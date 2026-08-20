<?php

class PageController
{
    private AccountModel $accountModel;

    public function __construct()
    {
        $this->accountModel = new AccountModel();
    }

    // Trang tổng quan (Dashboard)
    public function dashboard(): void
    {
        $pageTitle  = 'Dashboard';
        $activeMenu = 'dashboard';
        $stats      = $this->accountModel->getStats();

        require_once __DIR__ . '/../views/dashboard.php';
    }

    // Trang thống kê
    public function stats(): void
    {
        $pageTitle  = 'Thống kê';
        $activeMenu = 'stats';
        $stats      = $this->accountModel->getStats();

        require_once __DIR__ . '/../views/stats.php';
    }

    // Trang cài đặt
    public function settings(): void
    {
        $pageTitle  = 'Cài đặt';
        $activeMenu = 'settings';

        require_once __DIR__ . '/../views/settings.php';
    }
}
