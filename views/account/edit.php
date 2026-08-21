<!DOCTYPE html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Chỉnh sửa tài khoản</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100">

    <div class="max-w-2xl mx-auto px-4 py-10">

        <!-- Tiêu đề -->
        <div class="mb-6">

            <h1 class="text-3xl font-bold text-gray-800">
                Chỉnh sửa tài khoản
            </h1>

            <p class="text-gray-500 mt-1">
                Cập nhật thông tin cá nhân của bạn
            </p>

        </div>

        <!-- Lỗi -->
        <?php if (!empty($error)): ?>

            <div class="mb-5 p-4 rounded-lg bg-red-100 text-red-700">

                <?= htmlspecialchars($error) ?>

            </div>

        <?php endif; ?>


        <div class="bg-white rounded-xl shadow-sm p-6">

            <form
                method="POST"
                action="<?= BASE_URL ?>?action=/account/update"
            >

                <!-- Họ tên -->
                <div class="mb-5">

                    <label class="block mb-2 font-medium text-gray-700">
                        Họ và tên
                    </label>

                    <input
                        type="text"
                        name="fullname"
                        value="<?= htmlspecialchars($account['fullname'] ?? '') ?>"
                        required
                        class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >

                </div>


                <!-- Email -->
                <div class="mb-5">

                    <label class="block mb-2 font-medium text-gray-700">
                        Email
                    </label>

                    <input
                        type="email"
                        value="<?= htmlspecialchars($account['email'] ?? '') ?>"
                        disabled
                        class="w-full px-4 py-3 border rounded-lg bg-gray-100 text-gray-500"
                    >

                    <p class="text-sm text-gray-500 mt-1">
                        Email không thể thay đổi.
                    </p>

                </div>


                <!-- Số điện thoại -->
                <div class="mb-5">

                    <label class="block mb-2 font-medium text-gray-700">
                        Số điện thoại
                    </label>

                    <input
                        type="text"
                        name="phone"
                        value="<?= htmlspecialchars($account['phone'] ?? '') ?>"
                        class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >

                </div>


                <hr class="my-6">


                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    Đổi mật khẩu
                </h2>

                <p class="text-sm text-gray-500 mb-5">
                    Nếu không muốn đổi mật khẩu, hãy để trống hai ô bên dưới.
                </p>


                <!-- Mật khẩu mới -->
                <div class="mb-5">

                    <label class="block mb-2 font-medium text-gray-700">
                        Mật khẩu mới
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >

                </div>


                <!-- Xác nhận mật khẩu -->
                <div class="mb-6">

                    <label class="block mb-2 font-medium text-gray-700">
                        Xác nhận mật khẩu mới
                    </label>

                    <input
                        type="password"
                        name="confirm_password"
                        class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >

                </div>


                <!-- Buttons -->
                <div class="flex gap-3">

                    <button
                        type="submit"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                    >
                        Lưu thay đổi
                    </button>

                    <a
                        href="<?= BASE_URL ?>?action=/account"
                        class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300"
                    >
                        Hủy
                    </a>

                </div>

            </form>

        </div>

    </div>

</body>

</html>