<?php

class AdminProductController
{
    private $model;

    public function __construct()
    {
        $this->model = new ProductModel();
    }

    // GET /admin/products — render trang quản lý
    public function index()
    {
        $products   = $this->model->getAll();
        $categories = $this->model->getCategories();

        // Thống kê
        $total  = count($products);
        $active = count(array_filter($products, fn($p) => ($p['status'] ?? 'active') === 'active'));
        $out    = count(array_filter($products, fn($p) => ($p['status'] ?? '') === 'out'));
        $hidden = count(array_filter($products, fn($p) => ($p['status'] ?? '') === 'hidden'));

        $sizesList = ['36', '37', '38', '39', '40', '41', '42', '43', '44', '45', 'XS', 'S', 'M', 'L', 'XL', 'XXL', 'Free Size'];
        $colorsList = [
            ['name' => 'Trắng', 'hex' => '#ffffff'],
            ['name' => 'Đen', 'hex' => '#111827'],
            ['name' => 'Đỏ', 'hex' => '#ef4444'],
            ['name' => 'Xanh dương', 'hex' => '#3b82f6'],
            ['name' => 'Xanh navy', 'hex' => '#1e3a8a'],
            ['name' => 'Xanh lá', 'hex' => '#10b981'],
            ['name' => 'Vàng', 'hex' => '#f59e0b'],
            ['name' => 'Hồng', 'hex' => '#ec4899'],
            ['name' => 'Tím', 'hex' => '#8b5cf6'],
            ['name' => 'Xám', 'hex' => '#6b7280'],
            ['name' => 'Nâu', 'hex' => '#78350f'],
            ['name' => 'Cam', 'hex' => '#f97316'],
            ['name' => 'Kem / Be', 'hex' => '#fef3c7'],
        ];

        require_once PATH_ROOT . 'admin/views/products.php';
    }

    // POST /admin/products?ajax=store — thêm SP
    public function store()
    {
        header('Content-Type: application/json; charset=utf-8');

        $data = $this->sanitizeInput($_POST);

        if (empty($data['product_name'])) {
            echo json_encode(['success' => false, 'message' => 'Tên sản phẩm không được trống.']);
            exit;
        }

        // Upload ảnh đại diện nếu có
        if (!empty($_FILES['image']['name'])) {
            try {
                $data['image'] = upload_file('products', $_FILES['image']);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                exit;
            }
        }

        // Mặc định ban đầu nếu chưa có giá
        if (!isset($data['price'])) $data['price'] = 0;
        if (!isset($data['quantity'])) $data['quantity'] = 0;
        if (!isset($data['status'])) $data['status'] = 'active';

        $productId = $this->model->insertProduct($data);
        if (!$productId) {
            echo json_encode(['success' => false, 'message' => 'Thêm sản phẩm thất bại.']);
            exit;
        }

        // Upload album ảnh nếu có
        if (!empty($_FILES['album']['name'][0])) {
            try {
                $albumImages = upload_multiple_files('products', $_FILES['album']);
                if (!empty($albumImages)) {
                    $this->model->saveImages($productId, $albumImages);
                }
            } catch (Exception $e) {
                // non-fatal
            }
        }

        // Xử lý danh sách biến thể
        $variants = $this->extractVariants($_POST);
        if (!empty($variants)) {
            $this->model->saveVariants($productId, $variants);
        }

        echo json_encode([
            'success'    => true,
            'product_id' => $productId,
            'message'    => 'Thêm sản phẩm thành công!',
        ]);
        exit;
    }

    // GET /admin/products?ajax=edit&id=X — trả JSON để fill form/modal
    public function edit()
    {
        header('Content-Type: application/json; charset=utf-8');
        $id = intval($_GET['id'] ?? 0);
        $product = $this->model->getOne($id);

        if (!$product) {
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy sản phẩm.']);
            exit;
        }

        echo json_encode(['success' => true, 'product' => $product]);
        exit;
    }

    // POST /admin/products?ajax=update&id=X — cập nhật SP
    public function update()
    {
        header('Content-Type: application/json; charset=utf-8');
        $id = intval($_GET['id'] ?? 0);

        if ($id <= 0) {
            echo json_encode(['success' => false, 'message' => 'ID sản phẩm không hợp lệ.']);
            exit;
        }

        $data = $this->sanitizeInput($_POST);

        if (empty($data['product_name'])) {
            echo json_encode(['success' => false, 'message' => 'Tên sản phẩm không được trống.']);
            exit;
        }

        // Upload ảnh đại diện mới nếu có
        if (!empty($_FILES['image']['name'])) {
            try {
                $data['image'] = upload_file('products', $_FILES['image']);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                exit;
            }
        }

        $ok = $this->model->updateProduct($id, $data);

        // Upload thêm album ảnh nếu có
        if (!empty($_FILES['album']['name'][0])) {
            try {
                $albumImages = upload_multiple_files('products', $_FILES['album']);
                if (!empty($albumImages)) {
                    $this->model->saveImages($id, $albumImages);
                }
            } catch (Exception $e) {
                // non-fatal
            }
        }

        // Cập nhật biến thể
        $variants = $this->extractVariants($_POST);
        $this->model->saveVariants($id, $variants);

        echo json_encode([
            'success' => true,
            'message' => 'Cập nhật sản phẩm thành công!',
        ]);
        exit;
    }

    // POST /admin/products?ajax=delete&id=X — xóa SP
    public function destroy()
    {
        header('Content-Type: application/json; charset=utf-8');
        $id = intval($_GET['id'] ?? 0);

        $ok = $this->model->deleteProduct($id);
        echo json_encode([
            'success' => $ok,
            'message' => $ok ? 'Đã xóa sản phẩm.' : 'Xóa thất bại.',
        ]);
        exit;
    }

    // Trích xuất biến thể từ POST data
    private function extractVariants(array $post): array
    {
        $variants = [];

        // 1. Kiểm tra nếu gửi qua JSON string
        if (!empty($post['variants_json'])) {
            $decoded = json_decode($post['variants_json'], true);
            if (is_array($decoded)) {
                foreach ($decoded as $item) {
                    $size  = trim($item['size'] ?? '');
                    $orig  = (float)($item['original_price'] ?? 0);
                    $sale  = (float)($item['sale_price'] ?? 0);
                    $qty   = (int)($item['quantity'] ?? 0);
                    $rawColor = $item['color'] ?? ($item['colors'] ?? '');

                    $colorList = [];
                    if (is_array($rawColor)) {
                        $colorList = $rawColor;
                    } elseif (is_string($rawColor) && trim($rawColor) !== '') {
                        $colorList = explode(',', $rawColor);
                    }

                    $colorList = array_values(array_filter(array_map('trim', $colorList)));

                    if (!empty($colorList)) {
                        foreach ($colorList as $c) {
                            $variants[] = [
                                'size'           => $size,
                                'color'          => $c,
                                'original_price' => $orig > 0 ? $orig : $sale,
                                'sale_price'     => $sale > 0 ? $sale : $orig,
                                'quantity'       => $qty,
                            ];
                        }
                    } elseif ($size !== '' || $sale > 0 || $qty > 0) {
                        $variants[] = [
                            'size'           => $size,
                            'color'          => '',
                            'original_price' => $orig > 0 ? $orig : $sale,
                            'sale_price'     => $sale > 0 ? $sale : $orig,
                            'quantity'       => $qty,
                        ];
                    }
                }
                return $variants;
            }
        }

        // 2. Kiểm tra nếu gửi qua các mảng input (variant_size[], variant_color[], ...)
        if (isset($post['variant_size']) && is_array($post['variant_size'])) {
            $count = count($post['variant_size']);
            for ($i = 0; $i < $count; $i++) {
                $size  = trim($post['variant_size'][$i] ?? '');
                $rawColor = $post['variant_color'][$i] ?? ($post['variant_colors'][$i] ?? '');
                $orig  = (float)($post['variant_original_price'][$i] ?? 0);
                $sale  = (float)($post['variant_sale_price'][$i] ?? 0);
                $qty   = (int)($post['variant_quantity'][$i] ?? 0);

                $colorList = [];
                if (is_array($rawColor)) {
                    $colorList = $rawColor;
                } elseif (is_string($rawColor) && trim($rawColor) !== '') {
                    $colorList = explode(',', $rawColor);
                }

                $colorList = array_values(array_filter(array_map('trim', $colorList)));

                if (!empty($colorList)) {
                    foreach ($colorList as $c) {
                        $variants[] = [
                            'size'           => $size,
                            'color'          => $c,
                            'original_price' => $orig > 0 ? $orig : $sale,
                            'sale_price'     => $sale > 0 ? $sale : $orig,
                            'quantity'       => $qty,
                        ];
                    }
                } elseif ($size !== '' || $sale > 0 || $qty > 0) {
                    $variants[] = [
                        'size'           => $size,
                        'color'          => '',
                        'original_price' => $orig > 0 ? $orig : $sale,
                        'sale_price'     => $sale > 0 ? $sale : $orig,
                        'quantity'       => $qty,
                    ];
                }
            }
        }

        return $variants;
    }

    // Làm sạch input từ POST
    private function sanitizeInput(array $post): array
    {
        $allowed = [
            'product_name', 'sku', 'category_id', 'brand',
            'gender', 'price', 'original_price', 'quantity',
            'sizes', 'colors', 'description', 'status',
        ];

        $data = [];
        foreach ($allowed as $key) {
            if (isset($post[$key]) && $post[$key] !== '') {
                if ($key === 'description') {
                    // Mô tả từ rich text editor cho phép HTML an toàn
                    $data[$key] = trim($post[$key]);
                } else {
                    $data[$key] = htmlspecialchars(trim($post[$key]), ENT_QUOTES, 'UTF-8');
                }
            }
        }

        // Chuyển kiểu dữ liệu số
        if (isset($data['price']))          $data['price']          = (float) $data['price'];
        if (isset($data['original_price'])) $data['original_price'] = (float) $data['original_price'];
        if (isset($data['quantity']))       $data['quantity']       = (int)   $data['quantity'];
        if (isset($data['category_id']))    $data['category_id']    = (int)   $data['category_id'];

        return $data;
    }
}

