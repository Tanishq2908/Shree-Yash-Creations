<?php
require_once '../config.php';

// Set headers for Excel download
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="Shree_Yash_Creations_Orders_' . date('Y-m-d') . '.xls"');
header('Cache-Control: max-age=0');

// Start output buffering
ob_start();
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta charset="UTF-8">
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .header { background-color: #FF6B35; color: white; font-size: 18px; font-weight: bold; text-align: center; }
        .summary { background-color: #f9f9f9; font-weight: bold; }
    </style>
</head>
<body>
    <table>
        <tr>
            <td colspan="12" class="header">Shree Yash Creations - Complete Order Details</td>
        </tr>
        <tr>
            <td colspan="12" style="text-align: center; padding: 10px; font-weight: bold;">
                Export Date: <?php echo date('d-m-Y H:i:s'); ?> | Total Orders: 
                <?php 
                try {
                    $pdo = getDBConnection();
                    $countStmt = $pdo->query("SELECT COUNT(*) as total FROM orders");
                    $totalOrders = $countStmt->fetch()['total'];
                    echo $totalOrders;
                } catch (Exception $e) {
                    echo "Error";
                }
                ?>
            </td>
        </tr>
        <tr>
            <th>Order #</th>
            <th>Customer Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Products</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Total Amount</th>
            <th>Payment Method</th>
            <th>Payment Status</th>
            <th>Order Status</th>
            <th>Order Date</th>
        </tr>
        <?php
        try {
            $pdo = getDBConnection();
            
            // Get all orders with customer and product details
            $sql = "SELECT 
                        o.id,
                        o.order_number,
                        o.total_amount,
                        o.shipping_amount,
                        o.tax_amount,
                        o.payment_method,
                        o.payment_status,
                        o.order_status,
                        o.shipping_address,
                        o.notes,
                        o.created_at,
                        c.first_name,
                        c.last_name,
                        c.email,
                        c.phone,
                        c.address as customer_address,
                        c.city,
                        c.state,
                        c.pincode,
                        GROUP_CONCAT(oi.product_name SEPARATOR ', ') as products,
                        GROUP_CONCAT(oi.quantity SEPARATOR ', ') as quantities,
                        GROUP_CONCAT(oi.price SEPARATOR ', ') as prices
                    FROM orders o
                    LEFT JOIN customers c ON o.customer_id = c.id
                    LEFT JOIN order_items oi ON o.id = oi.order_id
                    GROUP BY o.id
                    ORDER BY o.created_at DESC";
            
            $stmt = $pdo->query($sql);
            $totalRevenue = 0;
            $totalOrders = 0;
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $totalRevenue += $row['total_amount'];
                $totalOrders++;
                
                // Format address
                $address = $row['customer_address'];
                if ($row['city']) $address .= ', ' . $row['city'];
                if ($row['state']) $address .= ', ' . $row['state'];
                if ($row['pincode']) $address .= ' - ' . $row['pincode'];
                
                // Format products, quantities, and prices
                $products = explode(', ', $row['products']);
                $quantities = explode(', ', $row['quantities']);
                $prices = explode(', ', $row['prices']);
                
                $productDetails = '';
                for ($i = 0; $i < count($products); $i++) {
                    if ($products[$i]) {
                        $productDetails .= $products[$i] . ' (Qty: ' . $quantities[$i] . ' @ ₹' . $prices[$i] . ')<br>';
                    }
                }
                
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['order_number']) . "</td>";
                echo "<td>" . htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                echo "<td>" . htmlspecialchars($address) . "</td>";
                echo "<td>" . $productDetails . "</td>";
                echo "<td>" . array_sum($quantities) . "</td>";
                echo "<td>₹" . number_format($row['total_amount'] / array_sum($quantities), 2) . "</td>";
                echo "<td>₹" . number_format($row['total_amount'], 2) . "</td>";
                echo "<td>" . htmlspecialchars($row['payment_method'] ?: 'Not specified') . "</td>";
                echo "<td>" . htmlspecialchars(ucfirst($row['payment_status'])) . "</td>";
                echo "<td>" . htmlspecialchars(ucfirst($row['order_status'])) . "</td>";
                echo "<td>" . date('d-m-Y H:i', strtotime($row['created_at'])) . "</td>";
                echo "</tr>";
            }
            
            // Add summary row
            echo "<tr class='summary'>";
            echo "<td colspan='8'><strong>SUMMARY</strong></td>";
            echo "<td><strong>₹" . number_format($totalRevenue, 2) . "</strong></td>";
            echo "<td colspan='3'><strong>Total Orders: " . $totalOrders . "</strong></td>";
            echo "</tr>";
            
        } catch (Exception $e) {
            echo "<tr><td colspan='12' style='color: red;'>Error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
        }
        ?>
    </table>
    
    <br><br>
    
    <!-- Product Summary Table -->
    <table>
        <tr>
            <td colspan="4" class="header">Product Sales Summary</td>
        </tr>
        <tr>
            <th>Product Name</th>
            <th>Total Quantity Sold</th>
            <th>Total Revenue</th>
            <th>Average Price</th>
        </tr>
        <?php
        try {
            $productSql = "SELECT 
                            oi.product_name,
                            SUM(oi.quantity) as total_quantity,
                            SUM(oi.quantity * oi.price) as total_revenue,
                            AVG(oi.price) as avg_price
                          FROM order_items oi
                          GROUP BY oi.product_name
                          ORDER BY total_revenue DESC";
            
            $productStmt = $pdo->query($productSql);
            
            while ($product = $productStmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($product['product_name']) . "</td>";
                echo "<td>" . $product['total_quantity'] . "</td>";
                echo "<td>₹" . number_format($product['total_revenue'], 2) . "</td>";
                echo "<td>₹" . number_format($product['avg_price'], 2) . "</td>";
                echo "</tr>";
            }
            
        } catch (Exception $e) {
            echo "<tr><td colspan='4' style='color: red;'>Error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
        }
        ?>
    </table>
    
    <br><br>
    
    <!-- Payment Status Summary -->
    <table>
        <tr>
            <td colspan="3" class="header">Payment Status Summary</td>
        </tr>
        <tr>
            <th>Payment Status</th>
            <th>Number of Orders</th>
            <th>Total Amount</th>
        </tr>
        <?php
        try {
            $statusSql = "SELECT 
                            payment_status,
                            COUNT(*) as order_count,
                            SUM(total_amount) as total_amount
                          FROM orders
                          GROUP BY payment_status";
            
            $statusStmt = $pdo->query($statusSql);
            
            while ($status = $statusStmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars(ucfirst($status['payment_status'])) . "</td>";
                echo "<td>" . $status['order_count'] . "</td>";
                echo "<td>₹" . number_format($status['total_amount'], 2) . "</td>";
                echo "</tr>";
            }
            
        } catch (Exception $e) {
            echo "<tr><td colspan='3' style='color: red;'>Error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
        }
        ?>
    </table>
</body>
</html>
<?php
$content = ob_get_clean();
echo $content;
?> 