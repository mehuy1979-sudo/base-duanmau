<?php
$user = $account;
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Thông tin tài khoản</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <div class="max-w-4xl mx-auto px-4 py-10">

        <!-- Tiêu đề -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">
                Thông tin tài khoản
            </h1>

            <p class="text-gray-500 mt-1">
                Quản lý thông tin cá nhân của bạn
            </p>
        </div>

        <!-- Thông báo thành công -->
        <?php if (!empty($success)): ?>
            <div class="mb-5 p-4 rounded-lg bg-green-100 text-green-700">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <!-- Thông báo lỗi -->
        <?php if (!empty($error)): ?>
            <div class="mb-5 p-4 rounded-lg bg-red-100 text-red-700">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <!-- Thông tin tài khoản -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">

            <!-- Header -->
            <div class="bg-gray-900 text-white px-6 py-5">
                <h2 class="text-xl font-semibold">
                    Thông tin cá nhân
                </h2>
            </div>

            <div class="p-6">

                <!-- Họ tên -->
                <div class="border-b py-4">
                    <div class="text-sm text-gray-500">
                        Họ và tên
                    </div>

                    <div class="text-lg font-medium text-gray-800 mt-1">
                        <?= htmlspecialchars($user['fullname'] ?? '') ?>
                    </div>
                </div>

                <!-- Email -->
                <div class="border-b py-4">
                    <div class="text-sm text-gray-500">
                        Email
                    </div>

                    <div class="text-lg font-medium text-gray-800 mt-1">
                        <?= htmlspecialchars($user['email'] ?? '') ?>
                    </div>
                </div>

                <!-- Số điện thoại -->
                <div class="border-b py-4">
                    <div class="text-sm text-gray-500">
                        Số điện thoại
                    </div>

                    <div class="text-lg font-medium text-gray-800 mt-1">
                        <?= !empty($user['phone'])
                            ? htmlspecialchars($user['phone'])
                            : 'Chưa cập nhật'
                        ?>
                    </div>
                </div>

                <!-- Quyền -->
                <div class="border-b py-4">
                    <div class="text-sm text-gray-500">
                        Vai trò
                    </div>

                    <div class="mt-1">
                        <?php if (($user['role'] ?? '') === 'admin'): ?>

                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm">
                                Quản trị viên
                            </span>

                        <?php else: ?>

                            <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm">
                                Khách hàng
                            </span>

                        <?php endif; ?>
                    </div>
                </div>

                <!-- Trạng thái -->
                <div class="border-b py-4">
                    <div class="text-sm text-gray-500">
                        Trạng thái tài khoản
                    </div>

                    <div class="mt-1">

                        <?php if (($user['status'] ?? '') === 'active'): ?>

                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">
                                Đang hoạt động
                            </span>

                        <?php else: ?>

                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm">
                                Đã khóa
                            </span>

                        <?php endif; ?>

                    </div>
                </div>

                <!-- Ngày đăng ký -->
                <div class="py-4">
                    <div class="text-sm text-gray-500">
                        Ngày đăng ký
                    </div>

                    <div class="text-lg font-medium text-gray-800 mt-1">
                        <?= !empty($user['created_at'])
                            ? date('d/m/Y H:i', strtotime($user['created_at']))
                            : '---'
                        ?>
                    </div>
                </div>

                <!-- Nút -->
                <div class="mt-6 flex gap-3">

                    <a
                        href="<?= BASE_URL ?>?action=/account/edit"
                        class="px-5 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                    >
                        Chỉnh sửa thông tin
                    </a>

                    <a
                        href="<?= BASE_URL ?>?action=/"
                        class="px-5 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300"
                    >
                        Quay lại
                    </a>

                </div>

            </div>
        </div>

    </div>

</body>

</html>