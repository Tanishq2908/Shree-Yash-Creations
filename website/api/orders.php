<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config.php';

$method = $_SERVER['REQUEST_METHOD'];
$pdo = getDBConnection();

switch($method) {
    case 'GET':
        // Get all orders or single order
        if (isset($_GET['id'])) {
            $stmt = $pdo->prepare("
                SELECT o.*, c.first_name, c.last_name, c.email, c.phone 
                FROM orders o 
                LEFT JOIN customers c ON o.customer_id = c.id 
                WHERE o.id = ?
            ");
            $stmt->execute([$_GET['id']]);
            $order = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Get order items
            $stmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
            $stmt->execute([$_GET['id']]);
            $order['items'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode($order);
        } else {
            $stmt = $pdo->query("
                SELECT o.*, c.first_name, c.last_name, c.email, c.phone 
                FROM orders o 
                LEFT JOIN customers c ON o.customer_id = c.id 
                ORDER BY o.created_at DESC
            ");
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($orders);
        }
        break;
        
    case 'POST':
        // Create new order
        $data = json_decode(file_get_contents('php://input'), true);
        
        try {
            $pdo->beginTransaction();
            
            // Create or get customer
            $customerData = $data['customer'] ?? [];
            $customerId = null;
            
            if (!empty($customerData['email'])) {
                // Check if customer exists
                $stmt = $pdo->prepare("SELECT id FROM customers WHERE email = ?");
                $stmt->execute([$customerData['email']]);
                $existingCustomer = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($existingCustomer) {
                    $customerId = $existingCustomer['id'];
                    // Update customer info
                    $stmt = $pdo->prepare("UPDATE customers SET first_name = ?, last_name = ?, phone = ?, address = ?, city = ?, state = ?, pincode = ? WHERE id = ?");
                    $stmt->execute([
                        $customerData['first_name'],
                        $customerData['last_name'],
                        $customerData['phone'],
                        $customerData['address'],
                        $customerData['city'],
                        $customerData['state'],
                        $customerData['pincode'],
                        $customerId
                    ]);
                } else {
                    // Create new customer
                    $stmt = $pdo->prepare("INSERT INTO customers (first_name, last_name, email, phone, address, city, state, pincode) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute([
                        $customerData['first_name'],
                        $customerData['last_name'],
                        $customerData['email'],
                        $customerData['phone'],
                        $customerData['address'],
                        $customerData['city'],
                        $customerData['state'],
                        $customerData['pincode']
                    ]);
                    $customerId = $pdo->lastInsertId();
                }
            }
            
            // Generate order number
            $orderNumber = 'ORD' . date('Ymd') . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
            
            // Create order
            $orderData = $data['order'] ?? [];
            $stmt = $pdo->prepare("INSERT INTO orders (order_number, customer_id, total_amount, shipping_amount, tax_amount, payment_method, shipping_address, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $orderNumber,
                $customerId,
                $orderData['total_amount'] ?? 0,
                $orderData['shipping_amount'] ?? 0,
                $orderData['tax_amount'] ?? 0,
                $orderData['payment_method'] ?? 'cod',
                $orderData['shipping_address'] ?? '',
                $orderData['notes'] ?? ''
            ]);
            
            $orderId = $pdo->lastInsertId();
            
            // Add order items
            $items = $data['items'] ?? [];
            foreach ($items as $item) {
                $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, product_name, quantity, price) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([
                    $orderId,
                    $item['product_id'] ?? null,
                    $item['product_name'],
                    $item['quantity'],
                    $item['price']
                ]);
                
                // Update product stock
                if (!empty($item['product_id'])) {
                    $stmt = $pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
                    $stmt->execute([$item['quantity'], $item['product_id']]);
                }
            }
            
            $pdo->commit();
            
            echo json_encode([
                'success' => true, 
                'message' => 'Order created successfully', 
                'order_id' => $orderId,
                'order_number' => $orderNumber
            ]);
            
        } catch (Exception $e) {
            $pdo->rollback();
            echo json_encode(['success' => false, 'message' => 'Failed to create order: ' . $e->getMessage()]);
        }
        break;
        
    case 'PUT':
        // Update order status
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'Order ID required']);
            break;
        }
        
        $orderStatus = $data['order_status'] ?? null;
        $paymentStatus = $data['payment_status'] ?? null;
        $notes = $data['notes'] ?? null;
        
        $updates = [];
        $params = [];
        
        if ($orderStatus) {
            $updates[] = "order_status = ?";
            $params[] = $orderStatus;
        }
        
        if ($paymentStatus) {
            $updates[] = "payment_status = ?";
            $params[] = $paymentStatus;
        }
        
        if ($notes !== null) {
            $updates[] = "notes = ?";
            $params[] = $notes;
        }
        
        if (empty($updates)) {
            echo json_encode(['success' => false, 'message' => 'No updates provided']);
            break;
        }
        
        $params[] = $id;
        $sql = "UPDATE orders SET " . implode(', ', $updates) . " WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute($params);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Order updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update order']);
        }
        break;
        
    case 'DELETE':
        // Cancel order (soft delete)
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'Order ID required']);
            break;
        }
        
        $stmt = $pdo->prepare("UPDATE orders SET order_status = 'cancelled' WHERE id = ?");
        $result = $stmt->execute([$id]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Order cancelled successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to cancel order']);
        }
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Method not allowed']);
        break;
}
?> 