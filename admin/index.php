<?php

session_start();

require_once __DIR__ . '/../configs/env.php';
require_once __DIR__ . '/../configs/helper.php';
require_once __DIR__ . '/../configs/database.php';

require_once __DIR__ . '/../models/BaseModel.php';
require_once __DIR__ . '/../models/AccountModel.php';

require_once __DIR__ . '/controllers/AccountController.php';

$action = $_GET['action'] ?? 'account/list';

match ($action) {
    'account/list'        => (new AccountController)->index(),
    'account/detail'      => (new AccountController)->detail(),
    'account/toggle-lock' => (new AccountController)->toggleLock(),
    'account/change-role' => (new AccountController)->changeRole(),

    default => (new AccountController)->index(),
};
