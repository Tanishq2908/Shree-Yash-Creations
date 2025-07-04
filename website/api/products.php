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
        // Get all products or single product
        if (isset($_GET['id'])) {
            $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->execute([$_GET['id']]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($product);
        } else {
            $stmt = $pdo->query("SELECT * FROM products WHERE status = 'active' ORDER BY created_at DESC");
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($products);
        }
        break;
        
    case 'POST':
        // Add new product
        $data = json_decode(file_get_contents('php://input'), true);
        
        $name = $data['name'] ?? '';
        $description = $data['description'] ?? '';
        $price = $data['price'] ?? 0;
        $category = $data['category'] ?? '';
        $image = $data['image'] ?? '';
        $stock = $data['stock'] ?? 0;
        
        $stmt = $pdo->prepare("INSERT INTO products (name, description, price, category, image, stock) VALUES (?, ?, ?, ?, ?, ?)");
        $result = $stmt->execute([$name, $description, $price, $category, $image, $stock]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Product added successfully', 'id' => $pdo->lastInsertId()]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add product']);
        }
        break;
        
    case 'PUT':
        // Update product
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'Product ID required']);
            break;
        }
        
        $name = $data['name'] ?? '';
        $description = $data['description'] ?? '';
        $price = $data['price'] ?? 0;
        $category = $data['category'] ?? '';
        $image = $data['image'] ?? '';
        $stock = $data['stock'] ?? 0;
        $status = $data['status'] ?? 'active';
        
        $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, category = ?, image = ?, stock = ?, status = ? WHERE id = ?");
        $result = $stmt->execute([$name, $description, $price, $category, $image, $stock, $status, $id]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Product updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update product']);
        }
        break;
        
    case 'DELETE':
        // Delete product (soft delete by setting status to inactive)
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'Product ID required']);
            break;
        }
        
        $stmt = $pdo->prepare("UPDATE products SET status = 'inactive' WHERE id = ?");
        $result = $stmt->execute([$id]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Product deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete product']);
        }
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Method not allowed']);
        break;
}
?> 