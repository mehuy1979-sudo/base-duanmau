<?php
// reload_database.php - Rebuild and seed entire shop_quanao database

$dbHost = 'localhost';
$dbPort = '3306';
$dbName = 'shop_quanao';
$dbUser = 'root';
$dbPass = '';

try {
    // 1. Connect without db to drop & recreate db clean
    $pdo = new PDO("mysql:host={$dbHost};port={$dbPort};charset=utf8mb4", $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    $pdo->exec("USE `{$dbName}`;");

    echo "==> Database '{$dbName}' is ready.\n";

    // 2. Drop existing tables in reverse order of dependencies
    $tables = ['order_details', 'orders', 'product_reviews', 'product_images', 'product_variants', 'products', 'categories', 'users'];
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
    foreach ($tables as $t) {
        $pdo->exec("DROP TABLE IF EXISTS `{$t}`;");
    }
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");

    echo "==> Old tables cleaned up.\n";

    // 3. Create Tables
    // Users table
    $pdo->exec("
    CREATE TABLE `users` (
      `id` INT AUTO_INCREMENT PRIMARY KEY,
      `fullname` VARCHAR(150) NOT NULL,
      `email` VARCHAR(150) NOT NULL UNIQUE,
      `password` VARCHAR(255) NOT NULL,
      `phone` VARCHAR(20) DEFAULT NULL,
      `role` ENUM('admin','customer') NOT NULL DEFAULT 'customer',
      `status` ENUM('active','locked') NOT NULL DEFAULT 'active',
      `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");

    // Categories table
    $pdo->exec("
    CREATE TABLE `categories` (
      `id` INT AUTO_INCREMENT PRIMARY KEY,
      `category_name` VARCHAR(150) NOT NULL,
      `status` TINYINT(1) NOT NULL DEFAULT 1,
      `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");

    // Products table
    $pdo->exec("
    CREATE TABLE `products` (
      `id` INT AUTO_INCREMENT PRIMARY KEY,
      `category_id` INT NULL,
      `product_name` VARCHAR(255) NOT NULL,
      `price` DECIMAL(12,2) NOT NULL DEFAULT 0,
      `sale_price` DECIMAL(12,2) NULL,
      `image` VARCHAR(255) NULL,
      `description` TEXT NULL,
      `status` TINYINT(1) NOT NULL DEFAULT 1,
      `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");

    // Product variants table
    $pdo->exec("
    CREATE TABLE `product_variants` (
      `id` INT AUTO_INCREMENT PRIMARY KEY,
      `product_id` INT NOT NULL,
      `color` VARCHAR(50) NULL,
      `size` VARCHAR(20) NULL,
      `quantity` INT NOT NULL DEFAULT 0,
      `price` DECIMAL(12,2) NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");

    // Product images table
    $pdo->exec("
    CREATE TABLE `product_images` (
      `id` INT AUTO_INCREMENT PRIMARY KEY,
      `product_id` INT NOT NULL,
      `image_url` VARCHAR(255) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");

    // Orders table
    $pdo->exec("
    CREATE TABLE `orders` (
      `id` INT AUTO_INCREMENT PRIMARY KEY,
      `order_code` VARCHAR(50) NOT NULL UNIQUE,
      `user_id` INT NULL,
      `fullname` VARCHAR(150) NOT NULL,
      `phone` VARCHAR(20) NOT NULL,
      `email` VARCHAR(150) NOT NULL,
      `shipping_address` TEXT NOT NULL,
      `note` TEXT NULL,
      `payment_method` VARCHAR(50) NOT NULL DEFAULT 'cod',
      `total_amount` DECIMAL(12,2) NOT NULL DEFAULT 0,
      `order_status` VARCHAR(50) NOT NULL DEFAULT 'pending',
      `payment_status` VARCHAR(50) NOT NULL DEFAULT 'unpaid',
      `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");

    // Order details table
    $pdo->exec("
    CREATE TABLE `order_details` (
      `id` INT AUTO_INCREMENT PRIMARY KEY,
      `order_id` INT NOT NULL,
      `product_id` INT NOT NULL,
      `product_name` VARCHAR(255) NOT NULL,
      `product_image` VARCHAR(255) NULL,
      `color` VARCHAR(50) NULL,
      `size` VARCHAR(20) NULL,
      `quantity` INT NOT NULL DEFAULT 1,
      `price` DECIMAL(12,2) NOT NULL DEFAULT 0,
      `total_price` DECIMAL(12,2) NOT NULL DEFAULT 0
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");

    // Product reviews table
    $pdo->exec("
    CREATE TABLE `product_reviews` (
      `id` INT AUTO_INCREMENT PRIMARY KEY,
      `product_id` INT NOT NULL,
      `user_id` INT NULL,
      `user_name` VARCHAR(100) NOT NULL,
      `user_email` VARCHAR(150) NULL,
      `user_avatar` VARCHAR(255) NULL,
      `rating` TINYINT NOT NULL DEFAULT 5,
      `comment` TEXT NOT NULL,
      `is_verified_purchase` TINYINT(1) NOT NULL DEFAULT 1,
      `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
      INDEX `idx_product_id` (`product_id`),
      INDEX `idx_user_id` (`user_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");

    echo "==> All schema tables created.\n";

    // 4. Seed Users
    $passwordHash = password_hash('123456', PASSWORD_DEFAULT);
    $userStmt = $pdo->prepare("INSERT INTO `users` (fullname, email, password, phone, role, status) VALUES (?, ?, ?, ?, ?, ?)");
    $users = [
        ['Quản Trị Viên', 'admin@bunnywear.vn', $passwordHash, '0901234567', 'admin', 'active'],
        ['Admin Shop', 'admin@gmail.com', $passwordHash, '0912345678', 'admin', 'active'],
        ['Nguyễn Văn An', 'customer@bunnywear.vn', $passwordHash, '0987654321', 'customer', 'active'],
        ['Trần Thị Bích', 'user@gmail.com', $passwordHash, '0978123456', 'customer', 'active'],
    ];
    foreach ($users as $u) {
        $userStmt->execute($u);
    }
    echo "==> Seeded " . count($users) . " users.\n";

    // 5. Seed Categories
    $catStmt = $pdo->prepare("INSERT INTO `categories` (id, category_name, status) VALUES (?, ?, 1)");
    $categories = [
        [1, 'Thời trang nữ'],
        [2, 'Thời trang nam'],
        [3, 'Túi xách & Phụ kiện'],
        [4, 'Giày dép & Sneaker'],
        [5, 'Đồng hồ & Trang sức'],
    ];
    foreach ($categories as $c) {
        $catStmt->execute($c);
    }
    echo "==> Seeded " . count($categories) . " categories.\n";

    // 6. Seed Products
    $products = [
        [1, 1, 'Áo Sơ Mi Nữ Dáng Rộng Tay Lỡ Vintage', 350000, 299000, 'product-01.jpg', 'Áo sơ mi dáng rộng phong cách vintage trẻ trung, chất liệu cotton đũi thoáng mát thích hợp mặc đi học, đi chơi, đi làm.'],
        [2, 1, 'Áo Thun Nữ Basic Cổ Tròn Cotton 100%', 180000, 150000, 'product-02.jpg', 'Áo thun nữ basic dáng ôm nhẹ, vải 100% cotton co giãn 4 chiều mềm mịn, thấm hút mồ hôi tốt.'],
        [3, 2, 'Áo Sơ Mi Nam Công Sở Kháng Khuẩn', 420000, 379000, 'product-03.jpg', 'Áo sơ mi nam phom dáng slimfit tôn dáng, chất liệu sợi tre bamboo cao cấp chống nhăn và kháng khuẩn hiệu quả.'],
        [4, 1, 'Áo Khoác Trench Coat Dáng Dài Thu Đông', 850000, 750000, 'product-04.jpg', 'Áo khoác dáng dài sang trọng phong cách Hàn Quốc, chất vải dạ cao cấp giữ ấm và tạo form chuẩn.'],
        [5, 1, 'Áo Len Dệt Kim Cổ Lọ Phối Nút Cổ Điển', 390000, 320000, 'product-05.jpg', 'Áo len nữ dệt kim mềm mịn co giãn tốt, giữ ấm mùa lạnh và dễ dàng phối cùng chân váy, quần jean.'],
        [6, 5, 'Đồng Hồ Nam Dây Da Đen Mặt Tối Giản', 1250000, 990000, 'product-06.jpg', 'Đồng hồ nam máy thạch anh Nhật Bản, mặt kính sapphire chống trầy xước và dây da tự nhiên cao cấp chống nước 3ATM.'],
        [7, 1, 'Quần Jean Nữ Cạp Cao Ống Rộng Hack Dáng', 450000, 390000, 'product-07.jpg', 'Quần bò ống suông cạp cao tôn dáng, chất denim bền màu mềm mại không bai dão.'],
        [8, 1, 'Áo Kiểu Nữ Tay Phồng Bo Chun Dễ Thương', 280000, 240000, 'product-08.jpg', 'Áo kiểu nữ voan tơ cao cấp tay bồng công chúa, phù hợp dạo phố, chụp ảnh hoặc đi tiệc nhẹ.'],
        [9, 4, 'Giày Sneaker Unisex Thể Thao Năng Động', 650000, 520000, 'product-09.jpg', 'Giày thể thao đế êm chống trơn trượt, thiết kế hiện đại unisex phù hợp cho cả nam và nữ.'],
        [10, 1, 'Đầm Voan Hoa Nhí Dáng Xòe Điệu Đà', 550000, 480000, 'product-10.jpg', 'Váy đầm hoa nhí 2 lớp mềm mại phong cách tiểu thư ngọt ngào dự tiệc dạo phố.'],
        [11, 2, 'Quần Kaki Nam Dáng Slimfit Trẻ Trung', 380000, 330000, 'product-11.jpg', 'Quần kaki co giãn thoải mái, màu sắc trung tính dễ mix cùng áo thun và áo sơ mi.'],
        [12, 5, 'Dây Lưng Da Bò Nam Mặt Khóa Tự Động', 290000, 220000, 'product-12.jpg', 'Thắt lưng da bò nguyên tấm sang trọng, khóa kim loại chống gỉ sáng bóng.'],
        [13, 1, 'Áo Khoác Nỉ Hoodie Nữ Form Rộng Streetwear', 420000, 360000, 'product-13.jpg', 'Áo hoodie nỉ bông ấm áp, form rộng unisex cá tính với hình in sắc nét bền bỉ.'],
        [14, 1, 'Chân Váy Chữ A Xếp Ly Dáng Ngắn', 260000, 210000, 'product-14.jpg', 'Chân váy xếp ly cạp cao có quần bảo hộ bên trong, năng động trẻ trung và dễ phối đồ.'],
        [15, 5, 'Đồng Hồ Nữ Dây Kim Loại Đính Đá Tinh Tế', 1450000, 1190000, 'product-15.jpg', 'Đồng hồ nữ mặt xà cừ viền đá sang trọng, máy pin chính hãng chống nước 5ATM.'],
        [16, 1, 'Áo Khoác Phao Nữ Trần Bông Siêu Nhẹ', 790000, 690000, 'product-16.jpg', 'Áo phao siêu nhẹ cản gió chống nước tốt, giữ ấm vượt trội trong thời tiết giá lạnh.']
    ];

    $prodStmt = $pdo->prepare("INSERT INTO `products` (id, category_id, product_name, price, sale_price, image, description, status) VALUES (?, ?, ?, ?, ?, ?, ?, 1)");
    foreach ($products as $p) {
        $prodStmt->execute($p);
    }
    echo "==> Seeded " . count($products) . " products.\n";

    // 7. Seed Variants & Images for each product
    $varStmt = $pdo->prepare("INSERT INTO `product_variants` (product_id, color, size, quantity, price) VALUES (?, ?, ?, ?, ?)");
    $imgStmt = $pdo->prepare("INSERT INTO `product_images` (product_id, image_url) VALUES (?, ?)");

    $sizes = ['S', 'M', 'L', 'XL'];
    $colors = ['Trắng', 'Đen', 'Xanh', 'Be'];

    foreach ($products as $p) {
        $pid = $p[0];
        $basePrice = $p[3];

        // 3-4 variants per product
        foreach (array_slice($sizes, 0, 3) as $s) {
            foreach (array_slice($colors, 0, 2) as $c) {
                $varStmt->execute([$pid, $c, $s, rand(20, 80), $basePrice]);
            }
        }

        // Product gallery images
        $imgStmt->execute([$pid, $p[5]]);
        $imgStmt->execute([$pid, 'product-detail-01.jpg']);
        $imgStmt->execute([$pid, 'product-detail-02.jpg']);
    }
    echo "==> Seeded product variants and gallery images.\n";

    // 8. Seed Sample Orders & Details
    $ordStmt = $pdo->prepare("INSERT INTO `orders` (id, order_code, user_id, fullname, phone, email, shipping_address, note, payment_method, total_amount, order_status, payment_status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $detStmt = $pdo->prepare("INSERT INTO `order_details` (order_id, product_id, product_name, product_image, color, size, quantity, price, total_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $sampleOrders = [
        [1, 'ORD-20260820-001', 3, 'Nguyễn Văn An', '0987654321', 'customer@bunnywear.vn', 'Số 123 Đường Cầu Giấy, Hà Nội', 'Giao giờ hành chính', 'cod', 649000, 'completed', 'paid', '2026-08-18 10:30:00'],
        [2, 'ORD-20260820-002', 3, 'Nguyễn Văn An', '0987654321', 'customer@bunnywear.vn', 'Số 123 Đường Cầu Giấy, Hà Nội', 'Gọi trước khi giao', 'bank', 750000, 'shipping', 'paid', '2026-08-19 14:15:00'],
        [3, 'ORD-20260820-003', 4, 'Trần Thị Bích', '0978123456', 'user@gmail.com', '456 Lê Duẩn, Quận 1, TP. Hồ Chí Minh', 'Để ở quầy lễ tân', 'cod', 520000, 'pending', 'unpaid', '2026-08-20 09:00:00'],
    ];

    foreach ($sampleOrders as $so) {
        $ordStmt->execute($so);
    }

    // Order items
    $detStmt->execute([1, 1, 'Áo Sơ Mi Nữ Dáng Rộng Tay Lỡ Vintage', 'product-01.jpg', 'Trắng', 'M', 1, 299000, 299000]);
    $detStmt->execute([1, 2, 'Áo Sơ Mi Nam Công Sở Kháng Khuẩn', 'product-03.jpg', 'Xanh', 'L', 1, 350000, 350000]);
    $detStmt->execute([2, 4, 'Áo Khoác Trench Coat Dáng Dài Thu Đông', 'product-04.jpg', 'Be', 'M', 1, 750000, 750000]);
    $detStmt->execute([3, 9, 'Giày Sneaker Unisex Thể Thao Năng Động', 'product-09.jpg', 'Trắng', '40', 1, 520000, 520000]);

    echo "==> Seeded sample orders & order items.\n";

    // 9. Seed Reviews
    $revStmt = $pdo->prepare("INSERT INTO `product_reviews` (product_id, user_id, user_name, user_email, rating, comment, is_verified_purchase, created_at) VALUES (?, ?, ?, ?, ?, ?, 1, ?)");
    $sampleReviews = [
        [1, 3, 'Nguyễn Văn An', 'customer@bunnywear.vn', 5, 'Áo form rất đẹp, vải mát không bị nhăn nhiều, shop đóng gói cẩn thận!', '2026-08-19 11:20:00'],
        [1, 4, 'Trần Thị Bích', 'user@gmail.com', 5, 'Giao hàng siêu nhanh, áo mặc tôn dáng lắm ạ, 10/10 điểm.', '2026-08-20 08:30:00'],
        [3, 3, 'Nguyễn Văn An', 'customer@bunnywear.vn', 5, 'Chất vải sợi tre mặc cực kỳ dễ chịu, màu xanh nhạt sang trọng.', '2026-08-19 16:45:00'],
    ];
    foreach ($sampleReviews as $r) {
        $revStmt->execute($r);
    }
    echo "==> Seeded product reviews.\n";

    // 10. Copy Images to assets/uploads/ so all products display properly
    $srcDir = __DIR__ . '/views/images/';
    $dstDir = __DIR__ . '/assets/uploads/';
    if (!is_dir($dstDir)) {
        mkdir($dstDir, 0777, true);
    }

    $imageFiles = glob($srcDir . '*.jpg');
    $copied = 0;
    foreach ($imageFiles as $img) {
        $filename = basename($img);
        $target = $dstDir . $filename;
        if (!file_exists($target)) {
            copy($img, $target);
            $copied++;
        }
    }
    echo "==> Synced {$copied} images to assets/uploads/\n";

    echo "\n>>> DATABASE RELOAD COMPLETED SUCCESSFULLY! <<<\n";

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
