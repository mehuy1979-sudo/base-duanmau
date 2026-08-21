<?php

class CartController
{
    private static array $coupons = [
        'SALE10'  => ['type' => 'percent', 'value' => 10,    'label' => 'Giảm 10%'],
        'SALE20'  => ['type' => 'percent', 'value' => 20,    'label' => 'Giảm 20%'],
        'GIAM50K' => ['type' => 'fixed',   'value' => 50000, 'label' => 'Giảm 50.000đ'],
    ];

    private function initCart(): array
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $cart = $_SESSION['cart'] ?? [];

        foreach ($cart as $index => $item) {
            $cart[$index]['total'] = (float) ($item['price'] ?? 0) * (int) ($item['quantity'] ?? 1);
        }

        $_SESSION['cart'] = $cart;

        return $cart;
    }

    private function calculateTotals(array $cart): array
    {
        $subtotal = array_sum(array_column($cart, 'total'));
        $shipping = 0;

        $discount = 0;
        $couponCode = $_SESSION['coupon'] ?? null;

        if ($couponCode && isset(self::$coupons[$couponCode])) {
            $coupon = self::$coupons[$couponCode];

            if ($coupon['type'] === 'percent') {
                $discount = $subtotal * $coupon['value'] / 100;
            } elseif ($coupon['type'] === 'fixed') {
                $discount = min($coupon['value'], $subtotal);
            }
        } else {
            $couponCode = null;
        }

        $total = max(0, $subtotal - $discount + $shipping);

        return [
            'subtotal'    => $subtotal,
            'shipping'    => $shipping,
            'discount'    => $discount,
            'coupon_code' => $couponCode,
            'total'       => $total,
        ];
    }

    public function index()
    {
        $cart = $this->initCart();
        $totals = $this->calculateTotals($cart);

        $subtotal    = $totals['subtotal'];
        $shipping    = $totals['shipping'];
        $discount    = $totals['discount'];
        $coupon_code = $totals['coupon_code'];
        $total       = $totals['total'];

        require_once PATH_VIEW . 'cart.php';
    }

    public function checkout()
    {
        $cart = $this->initCart();
        $totals = $this->calculateTotals($cart);

        $subtotal    = $totals['subtotal'];
        $shipping    = $totals['shipping'];
        $discount    = $totals['discount'];
        $coupon_code = $totals['coupon_code'];
        $total       = $totals['total'];

        require_once PATH_VIEW . 'checkout.php';
    }

    public function addToCart()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $product_id = $_POST['product_id'] ?? null;
        $quantity = max(1, (int) ($_POST['quantity'] ?? 1));
        $size = trim($_POST['size'] ?? '');
        $color = trim($_POST['color'] ?? '');

        if (!$product_id) {
            header('Location: ?action=/cart');
            exit;
        }

        $productModel = new ProductModel();
        $product = $productModel->getOne($product_id);

        if (!$product) {
            $_SESSION['cart_error'] = 'Sản phẩm không tồn tại';
            header('Location: ?action=/cart');
            exit;
        }

        // Nếu sản phẩm có biến thể (size/color), tìm biến thể khớp để lấy đúng giá
        $price = (float) ($product['price'] ?? 0);
        $variants = $product['variants'] ?? [];

        if (!empty($variants)) {
            foreach ($variants as $v) {
                $matchSize  = $size === '' || ($v['size'] ?? '') === $size;
                $matchColor = $color === '' || ($v['color'] ?? '') === $color;

                if ($matchSize && $matchColor) {
                    $price = (float) ($v['sale_price'] ?? $v['original_price'] ?? $price);
                    break;
                }
            }
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Nếu sản phẩm (cùng size/color) đã có trong giỏ thì cộng dồn số lượng
        $found = false;
        foreach ($_SESSION['cart'] as $index => $item) {
            if (
                ($item['id'] ?? null) == $product_id &&
                ($item['size'] ?? '') === $size &&
                ($item['color'] ?? '') === $color
            ) {
                $_SESSION['cart'][$index]['quantity'] += $quantity;
                $_SESSION['cart'][$index]['total'] = $_SESSION['cart'][$index]['price'] * $_SESSION['cart'][$index]['quantity'];
                $found = true;
                break;
            }
        }

        if (!$found) {
            $_SESSION['cart'][] = [
                'id' => $product_id,
                'name' => $product['product_name'] ?? 'Sản phẩm',
                'price' => $price,
                'quantity' => $quantity,
                'image' => $product['image'] ?? '',
                'size' => $size,
                'color' => $color,
                'total' => $price * $quantity,
            ];
        }

        $_SESSION['cart_success'] = 'Đã thêm sản phẩm vào giỏ hàng';

        header('Location: ?action=/cart');
        exit;
    }

    public function removeFromCart()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $product_id = $_GET['id'] ?? null;

        if ($product_id && isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) use ($product_id) {
                return ($item['id'] ?? null) != $product_id;
            });

            header('Location: ?action=/cart');
            exit;
        }
    }

    public function applyCoupon()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $code = strtoupper(trim($_POST['coupon_code'] ?? ''));

        if (empty($code)) {
            $_SESSION['cart_error'] = 'Vui lòng nhập mã giảm giá';
        } elseif (!isset(self::$coupons[$code])) {
            $_SESSION['cart_error'] = 'Mã giảm giá không hợp lệ hoặc đã hết hạn';
        } else {
            $_SESSION['coupon'] = $code;
            $_SESSION['cart_success'] = 'Áp dụng mã thành công: ' . self::$coupons[$code]['label'];
        }

        header('Location: ?action=/cart');
        exit;
    }

    public function removeCoupon()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        unset($_SESSION['coupon']);
        header('Location: ?action=/cart');
        exit;
    }

    public function placeOrder()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?action=/checkout');
            exit;
        }

        $customer_name = trim($_POST['customer_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $city = trim($_POST['city'] ?? '');
        $district = trim($_POST['district'] ?? '');
        $note = trim($_POST['note'] ?? '');
        $payment_method = $_POST['payment_method'] ?? 'cod';

        if (
            empty($customer_name) ||
            empty($email) ||
            empty($phone) ||
            empty($address) ||
            empty($city) ||
            empty($district)
        ) {
            $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin";
            header('Location: ?action=/checkout');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Email không hợp lệ";
            header('Location: ?action=/checkout');
            exit;
        }

        if (!preg_match('/^[0-9]{9,11}$/', $phone)) {
            $_SESSION['error'] = "Số điện thoại không hợp lệ";
            header('Location: ?action=/checkout');
            exit;
        }

        $cart = $_SESSION['cart'] ?? [];

        if (empty($cart)) {
            $_SESSION['error'] = "Giỏ hàng của bạn đang trống";
            header('Location: ?action=/checkout');
            exit;
        }

        $totals = $this->calculateTotals($cart);
        $userId = $_SESSION['user_id'] ?? null;

        $pdo = Database::getConnection();

        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("
                INSERT INTO orders
                    (user_id, customer_name, email, phone, address, city, district,
                     note, payment_method, total_amount, discount, coupon_code, status, order_date)
                VALUES
                    (:user_id, :customer_name, :email, :phone, :address, :city, :district,
                     :note, :payment_method, :total_amount, :discount, :coupon_code, :status, NOW())
            ");

            $stmt->execute([
                ':user_id'        => $userId,
                ':customer_name'  => $customer_name,
                ':email'          => $email,
                ':phone'          => $phone,
                ':address'        => $address,
                ':city'           => $city,
                ':district'       => $district,
                ':note'           => $note,
                ':payment_method' => $payment_method,
                ':total_amount'   => $totals['total'],
                ':discount'       => $totals['discount'],
                ':coupon_code'    => $totals['coupon_code'],
                ':status'         => 'Đang xử lý',
            ]);

            $orderId = (int) $pdo->lastInsertId();

            $stmtDetail = $pdo->prepare("
                INSERT INTO order_details (order_id, product_id, quantity, price)
                VALUES (:order_id, :product_id, :quantity, :price)
            ");

            foreach ($cart as $item) {
                $stmtDetail->execute([
                    ':order_id'   => $orderId,
                    ':product_id' => $item['id'],
                    ':quantity'   => $item['quantity'],
                    ':price'      => $item['price'],
                ]);
            }

            $pdo->commit();
        } catch (Exception $e) {
            $pdo->rollBack();
            $_SESSION['error'] = "Đặt hàng thất bại, vui lòng thử lại";
            header('Location: ?action=/checkout');
            exit;
        }

        $_SESSION['last_order_id'] = $orderId;

        unset($_SESSION['cart']);
        unset($_SESSION['coupon']);

        header('Location: ?action=/order-success');
        exit;
    }

    public function orderSuccess()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $orderId = $_SESSION['last_order_id'] ?? null;

        if (!$orderId) {
            header('Location: ?action=/');
            exit;
        }

        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = :id");
        $stmt->execute([':id' => $orderId]);
        $order = $stmt->fetch();

        if (!$order) {
            header('Location: ?action=/');
            exit;
        }

        $stmtItems = $pdo->prepare("
            SELECT od.quantity, od.price, p.product_name AS name
            FROM order_details od
            JOIN products p ON p.id = od.product_id
            WHERE od.order_id = :order_id
        ");
        $stmtItems->execute([':order_id' => $orderId]);
        $items = $stmtItems->fetchAll();

        foreach ($items as &$it) {
            $it['total'] = $it['price'] * $it['quantity'];
        }
        unset($it);

        $order['created_at'] = $order['order_date'];
        $order['total']      = $order['total_amount'];
        $order['subtotal']   = $order['total_amount'] + $order['discount'];
        $order['cart']       = $items;

        require_once PATH_VIEW . 'order-success.php';
    }

    // Lịch sử mua hàng của khách hàng đang đăng nhập
    public function orderHistory()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['user'])) {
            $_SESSION['login_error'] = 'Vui lòng đăng nhập để xem lịch sử mua hàng';
            header('Location: ?action=/login');
            exit;
        }

        $userId = $_SESSION['user']['id'];

        $orderModel = new OrderModel();
        $orders = $orderModel->getOrdersByUserId($userId);

        require_once PATH_VIEW . 'order-history.php';
    }

    // Chi tiết 1 đơn hàng trong lịch sử mua hàng (chỉ xem được đơn của chính mình)
    public function orderDetail()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['user'])) {
            $_SESSION['login_error'] = 'Vui lòng đăng nhập để xem chi tiết đơn hàng';
            header('Location: ?action=/login');
            exit;
        }

        $orderId = (int) ($_GET['id'] ?? 0);
        $userId  = $_SESSION['user']['id'];

        $orderModel = new OrderModel();
        $order = $orderModel->getOrderById($orderId);

        // Không cho xem đơn hàng của người khác
        if (!$order || (int) $order['user_id'] !== (int) $userId) {
            header('Location: ?action=/order-history');
            exit;
        }

        $items = $orderModel->getOrderDetails($orderId);

        foreach ($items as &$it) {
            $it['total'] = (float) $it['price'] * (int) $it['quantity'];
        }
        unset($it);

        require_once PATH_VIEW . 'order-detail.php';
    }

    public function updateCart()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['cart'])) {
            $quantities = $_POST['quantities'] ?? [];

            foreach ($_SESSION['cart'] as &$item) {
                if (isset($quantities[$item['id']])) {
                    $item['quantity'] = max(1, (int) $quantities[$item['id']]);
                    $item['total'] = (float) ($item['price'] ?? 0) * (int) $item['quantity'];
                }
            }
            unset($item);

            header('Location: ?action=/cart');
            exit;
        }
    }
}