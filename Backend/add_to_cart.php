<?php
session_start();
require_once 'connect.php';

header('Content-Type: application/json'); // กำหนดให้ส่งข้อมูลเป็น JSON

if (isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    $sessionId = session_id();

    try {
        $pdo->beginTransaction(); // เริ่ม transaction เพื่อความปลอดภัยของข้อมูล

        // ตรวจสอบว่าสินค้ามีอยู่จริงหรือไม่
        $stmt = $pdo->prepare("SELECT product_name, price FROM products WHERE product_id = ?");
        $stmt->execute([$productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            echo json_encode(['error' => 'ไม่พบสินค้านี้']);
            exit();
        }

        // ตรวจสอบว่าสินค้าอยู่ในตะกร้าแล้วหรือไม่
        $stmt = $pdo->prepare("SELECT cart_id, quantity FROM carts WHERE session_id = ? AND product_id = ?");
        $stmt->execute([$sessionId, $productId]);
        $cartItem = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cartItem) {
            // เพิ่มจำนวนสินค้า
            $stmt = $pdo->prepare("UPDATE carts SET quantity = quantity + 1 WHERE cart_id = ?");
            $stmt->execute([$cartItem['cart_id']]);
        } else {
            // เพิ่มสินค้าใหม่ลงในตะกร้า
            $stmt = $pdo->prepare("INSERT INTO carts (session_id, product_id) VALUES (?, ?)");
            $stmt->execute([$sessionId, $productId]);
        }

        $pdo->commit(); // ยืนยันการเปลี่ยนแปลง

        // ดึงข้อมูลตะกร้าสินค้าล่าสุดและคำนวณราคารวม
        $stmt = $pdo->prepare("SELECT c.product_id, c.quantity, p.product_name, p.price
                               FROM carts c
                               JOIN products p ON c.product_id = p.product_id
                               WHERE c.session_id = ?");
        $stmt->execute([$sessionId]);
        $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        echo json_encode(['cart_items' => $cartItems, 'total_price' => $totalPrice]);

    } catch (PDOException $e) {
        $pdo->rollBack(); // ยกเลิก transaction หากมีข้อผิดพลาด
        echo json_encode(['error' => 'เกิดข้อผิดพลาดในการเพิ่มสินค้าลงตะกร้า: ' . $e->getMessage()]);
    }

} else {
    echo json_encode(['error' => 'ไม่ได้ระบุรหัสสินค้า']);
}
?>