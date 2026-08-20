<?php
/**
 * Admin – Quản Lý Sản Phẩm & Biến Thể
 * Route: ?action=/admin/products
 */
$BASE = BASE_URL;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Quản lý sản phẩm quần áo - adminHMD Seller Dashboard">
  <meta name="robots" content="noindex, nofollow">
  <title>Sản Phẩm | adminHMD</title>

  <link rel="stylesheet" href="<?= $BASE ?>admin/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= $BASE ?>admin/assets/vendors/bootstrap-icons/bootstrap-icons.css">
  <link rel="stylesheet" href="<?= $BASE ?>admin/assets/css/style.css">
  <style>
    /* ── Original theme CSS extras ── */
    .product-img-thumb {
      width: 48px;
      height: 48px;
      border-radius: 10px;
      object-fit: cover;
      border: 1px solid var(--admin-border);
      flex: 0 0 auto;
    }
    .product-img-placeholder {
      width: 48px;
      height: 48px;
      border-radius: 10px;
      flex: 0 0 auto;
      border: 1px solid var(--admin-border);
      background: var(--admin-surface-soft);
      display: inline-grid;
      place-items: center;
      color: var(--admin-muted);
      font-size: 1.2rem;
    }
    .size-tag {
      display: inline-flex;
      align-items: center;
      padding: .18rem .5rem;
      border: 1px solid var(--admin-border);
      border-radius: 6px;
      background: var(--admin-surface-soft);
      font-size: .76rem;
      font-weight: 700;
      color: var(--admin-text);
    }
    .filter-tabs {
      display: flex;
      gap: .4rem;
      flex-wrap: wrap;
    }
    .filter-tab {
      padding: .3rem .85rem;
      border: 1px solid var(--admin-border);
      border-radius: 20px;
      background: var(--admin-surface);
      color: var(--admin-muted);
      font-size: .82rem;
      font-weight: 700;
      cursor: pointer;
      transition: all .16s ease;
      white-space: nowrap;
    }
    .filter-tab:hover {
      border-color: var(--admin-primary);
      color: var(--admin-primary);
    }
    .filter-tab.active {
      border-color: var(--admin-primary);
      background: var(--admin-primary);
      color: #fff;
    }
    .stock-bar {
      height: 6px;
      border-radius: 999px;
      background: var(--admin-border);
      overflow: hidden;
      min-width: 64px;
    }
    .stock-bar-fill {
      height: 100%;
      border-radius: 999px;
    }
    .action-btn-group {
      display: flex;
      gap: .35rem;
      justify-content: flex-end;
    }
    .btn-icon-sm {
      width: 32px;
      height: 32px;
      padding: 0;
      display: inline-grid;
      place-items: center;
      border-radius: 8px;
      font-size: .85rem;
    }
    .upload-zone {
      border: 2px dashed var(--admin-border);
      border-radius: 10px;
      padding: 1.25rem 1rem;
      text-align: center;
      cursor: pointer;
      background: var(--admin-surface-soft);
      transition: border-color .16s ease, background .16s ease;
      display: block;
    }
    .upload-zone:hover {
      border-color: var(--admin-primary);
      background: #eaf2ff;
    }
    html[data-theme="dark"] .upload-zone:hover {
      background: #1e3a5f;
    }
    .upload-zone .upload-icon {
      font-size: 1.6rem;
      color: var(--admin-muted);
      display: block;
      margin-bottom: .35rem;
    }
    .delete-confirm-icon {
      width: 68px;
      height: 68px;
      border-radius: 50%;
      background: #ffecec;
      display: inline-grid;
      place-items: center;
      font-size: 1.8rem;
      color: var(--admin-danger);
      margin-bottom: 1rem;
    }
    html[data-theme="dark"] .delete-confirm-icon {
      background: rgba(220,38,38,.16);
    }
    .toast-stack {
      position: fixed;
      bottom: 1.25rem;
      right: 1.25rem;
      z-index: 9999;
      display: grid;
      gap: .5rem;
    }
    .panel-header-col {
      display: flex;
      flex-direction: column;
      align-items: stretch;
      gap: 1rem;
    }
    .panel-header-top {
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: .75rem;
    }
    .spinner-overlay {
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,.35);
      z-index: 9998;
      display: none;
      place-items: center;
    }
    .spinner-overlay.show {
      display: grid;
    }

    /* ── Form Card & Variant Styles (Using original theme) ── */
    .form-panel {
      background: var(--admin-surface);
      border: 1px solid var(--admin-border);
      border-radius: 12px;
      padding: 1.75rem;
      box-shadow: var(--admin-shadow-sm);
      margin-bottom: 1.5rem;
    }
    .form-panel-title {
      font-size: 1.35rem;
      font-weight: 800;
      color: var(--admin-text);
      text-transform: uppercase;
      margin-bottom: 1.5rem;
    }
    .rich-editor-wrapper {
      border: 1px solid var(--admin-border);
      border-radius: 8px;
      overflow: hidden;
      background: var(--admin-surface);
    }
    .rich-editor-toolbar {
      display: flex;
      align-items: center;
      gap: .25rem;
      padding: .4rem .6rem;
      background: var(--admin-surface-soft);
      border-bottom: 1px solid var(--admin-border);
      flex-wrap: wrap;
    }
    .rich-editor-toolbar button {
      background: transparent;
      border: 1px solid transparent;
      border-radius: 4px;
      padding: .2rem .4rem;
      color: var(--admin-text);
      font-size: .85rem;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }
    .rich-editor-toolbar button:hover {
      background: var(--admin-surface);
      border-color: var(--admin-border);
      color: var(--admin-primary);
    }
    .rich-editor-toolbar .toolbar-divider {
      width: 1px;
      height: 18px;
      background: var(--admin-border);
      margin: 0 .25rem;
    }
    .rich-editor-content {
      min-height: 125px;
      max-height: 250px;
      overflow-y: auto;
      padding: .75rem .9rem;
      font-size: .9rem;
      color: var(--admin-text);
      outline: none;
    }
    .rich-editor-content[placeholder]:empty:before {
      content: attr(placeholder);
      color: var(--admin-muted);
    }

    /* ── Variants Row (Original theme) ── */
    .variants-section-title {
      font-size: 1.05rem;
      font-weight: 700;
      color: var(--admin-text);
      margin-top: 1.5rem;
      margin-bottom: .85rem;
    }
    .variant-row {
      display: grid;
      grid-template-columns: 1.3fr 2.4fr 1.6fr 1.6fr 1.4fr 44px;
      gap: .75rem;
      align-items: flex-start;
      margin-bottom: .85rem;
      padding: .85rem;
      background: var(--admin-surface-soft);
      border: 1px solid var(--admin-border);
      border-radius: 10px;
      animation: fadeInRow .18s ease;
    }
    @media (max-width: 991px) {
      .variant-row {
        grid-template-columns: 1fr 1fr;
        background: var(--admin-surface-soft);
        padding: 1rem;
        border-radius: 8px;
        border: 1px solid var(--admin-border);
      }
    }
    .variant-col-label {
      font-size: .8rem;
      font-weight: 600;
      color: var(--admin-muted);
      margin-bottom: .25rem;
      display: block;
    }

    /* ── Multi-select Color Component ── */
    .color-multiselect-wrap {
      position: relative;
      user-select: none;
    }
    .color-multiselect-trigger {
      min-height: 38px;
      border: 1px solid var(--admin-border);
      border-radius: 6px;
      background: var(--admin-surface);
      padding: 4px 8px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: .35rem;
      transition: border-color .15s ease, box-shadow .15s ease;
    }
    .color-multiselect-trigger:hover, .color-multiselect-wrap.open .color-multiselect-trigger {
      border-color: var(--admin-primary);
    }
    .color-chips-box {
      display: flex;
      flex-wrap: wrap;
      gap: 4px;
      align-items: center;
      flex: 1 1 auto;
      min-width: 0;
    }
    .color-chip {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      padding: 2px 7px;
      border-radius: 12px;
      background: var(--admin-surface-soft);
      border: 1px solid var(--admin-border);
      font-size: .76rem;
      font-weight: 600;
      color: var(--admin-text);
      line-height: 1.3;
    }
    .color-chip-dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      display: inline-block;
      border: 1px solid rgba(0,0,0,.15);
      flex: 0 0 auto;
    }
    .color-chip-del {
      font-size: 13px;
      line-height: 1;
      cursor: pointer;
      color: var(--admin-muted);
      margin-left: 2px;
      border-radius: 50%;
      transition: color .12s;
    }
    .color-chip-del:hover {
      color: var(--admin-danger);
    }
    .color-placeholder {
      color: var(--admin-muted);
      font-size: .83rem;
    }
    .color-multiselect-dropdown {
      position: absolute;
      top: calc(100% + 4px);
      left: 0;
      width: 100%;
      min-width: 230px;
      background: var(--admin-surface);
      border: 1px solid var(--admin-border);
      border-radius: 8px;
      box-shadow: 0 10px 24px rgba(0,0,0,.18);
      z-index: 1050;
      padding: 8px;
      display: none;
    }
    .color-multiselect-wrap.open .color-multiselect-dropdown {
      display: block;
    }
    .color-options-list {
      max-height: 190px;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
      gap: 2px;
      padding-right: 2px;
    }
    .color-option-item {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 5px 8px;
      border-radius: 6px;
      cursor: pointer;
      font-size: .83rem;
      color: var(--admin-text);
      transition: background .12s ease;
      margin: 0;
    }
    .color-option-item:hover {
      background: var(--admin-surface-soft);
    }
    .color-option-dot {
      width: 14px;
      height: 14px;
      border-radius: 50%;
      display: inline-block;
      border: 1px solid rgba(0,0,0,.18);
      flex: 0 0 auto;
    }
    .btn-xs {
      padding: 0;
      font-size: .75rem;
      font-weight: 600;
    }
    .btn-delete-variant {
      width: 36px;
      height: 36px;
      border-radius: 8px;
      border: 1px solid transparent;
      background: transparent;
      color: var(--admin-danger);
      display: inline-grid;
      place-items: center;
      cursor: pointer;
      font-size: 1.1rem;
      transition: all .14s ease;
      align-self: flex-end;
    }
    .btn-delete-variant:hover {
      background: #fee2e2;
      border-color: #fca5a5;
    }
    .btn-add-variant-circle {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: var(--admin-surface-soft);
      border: 1px solid var(--admin-border);
      color: var(--admin-text);
      display: inline-grid;
      place-items: center;
      font-size: 1.15rem;
      cursor: pointer;
      margin: 1rem auto 1.25rem;
      transition: all .16s ease;
    }
    .btn-add-variant-circle:hover {
      background: var(--admin-primary);
      color: #fff;
      border-color: var(--admin-primary);
      transform: scale(1.06);
    }
    .preview-thumb-container {
      display: flex;
      flex-wrap: wrap;
      gap: .5rem;
      margin-top: .5rem;
    }
    .preview-thumb {
      width: 52px;
      height: 52px;
      border-radius: 6px;
      object-fit: cover;
      border: 1px solid var(--admin-border);
    }
    .preview-item {
      position: relative;
      display: inline-block;
    }
    .preview-remove-btn {
      position: absolute;
      top: -5px;
      right: -5px;
      width: 18px;
      height: 18px;
      border-radius: 50%;
      background: var(--admin-danger);
      color: #fff;
      border: none;
      font-size: 10px;
      display: grid;
      place-items: center;
      cursor: pointer;
    }
    @keyframes fadeInRow {
      from { opacity: 0; transform: translateY(-4px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
<div class="admin-shell">
  <div class="sidebar-backdrop" data-sidebar-close></div>

  <!-- SIDEBAR (Original Dark Theme) -->
  <aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
    <div class="sidebar-header">
      <a class="brand-mark" href="<?= $BASE ?>admin/index.php?action=dashboard" aria-label="adminHMD dashboard">
        <span class="brand-icon"><i class="bi bi-grid-1x2-fill" aria-hidden="true"></i></span>
        <span class="brand-copy">
          <span class="brand-title">adminHMD</span>
          <span class="brand-subtitle">Seller Dashboard</span>
        </span>
      </a>
    </div>

    <nav class="sidebar-nav">
      <a class="nav-link" href="<?= $BASE ?>admin/index.php?action=dashboard">
        <span class="nav-icon"><i class="bi bi-speedometer2"></i></span>
        <span class="nav-text">Dashboard</span>
      </a>
      <a class="nav-link active" href="javascript:void(0);" id="navProductLink">
        <span class="nav-icon"><i class="bi bi-bag-heart"></i></span>
        <span class="nav-text">Sản Phẩm</span>
      </a>
      <a class="nav-link" href="<?= $BASE ?>admin/index.php?action=account/list">
        <span class="nav-icon"><i class="bi bi-people"></i></span>
        <span class="nav-text">Users</span>
      </a>
      <a class="nav-link" href="<?= $BASE ?>admin/index.php?action=stats">
        <span class="nav-icon"><i class="bi bi-bar-chart-line"></i></span>
        <span class="nav-text">Charts</span>
      </a>
      <a class="nav-link" href="<?= $BASE ?>admin/index.php?action=settings">
        <span class="nav-icon"><i class="bi bi-gear"></i></span>
        <span class="nav-text">Settings</span>
      </a>
    </nav>

    <div class="sidebar-footer">
      <span class="status-dot"></span>
      <span class="sidebar-footer-text">System running smoothly</span>
    </div>
  </aside>

  <!-- MAIN -->
  <div class="admin-main">
    <!-- Navbar -->
    <nav class="navbar admin-navbar navbar-expand bg-white">
      <div class="container-fluid px-3 px-lg-4">
        <button class="sidebar-toggle" type="button" data-sidebar-toggle aria-controls="adminSidebar" aria-label="Toggle sidebar">
          <span></span><span></span><span></span>
        </button>
        <div class="navbar-actions ms-auto d-flex align-items-center gap-2">
          <a href="<?= $BASE ?>" target="_blank" class="btn btn-sm btn-outline-secondary d-none d-sm-inline-flex align-items-center gap-1">
            <i class="bi bi-shop"></i> Xem Cửa Hàng
          </a>
          <button class="icon-button theme-toggle" type="button" data-theme-toggle aria-label="Switch theme" title="Switch theme">
            <i class="bi bi-moon-stars" data-theme-icon></i>
          </button>
        </div>
      </div>
    </nav>

    <!-- Content -->
    <main class="dashboard-content">
      <div class="container-fluid px-3 px-lg-4 py-4">

        <!-- Page heading -->
        <div class="page-heading">
          <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-bag-heart"></i></span>
            <div>
              <p class="eyebrow mb-1">Seller</p>
              <h1 class="h3 mb-1">Quản Lý Sản Phẩm</h1>
              <p class="text-muted mb-0">Thêm, chỉnh sửa và quản lý toàn bộ danh mục & biến thể sản phẩm.</p>
            </div>
          </div>
          <div class="heading-actions">
            <button class="btn btn-primary btn-sm" type="button" id="btnToggleAddProduct">
              <i class="bi bi-plus-lg"></i> <span id="btnToggleAddProductText">Thêm Sản Phẩm</span>
            </button>
          </div>
        </div>

        <!-- Metric Cards -->
        <section class="row g-3 mt-1" aria-label="Product metrics" id="metricCardsSection">
          <div class="col-12 col-sm-6 col-xl-3">
            <article class="metric-card metric-primary">
              <div class="metric-top"><span class="metric-label">Tổng Sản Phẩm</span><span class="metric-icon"><i class="bi bi-bag-heart"></i></span></div>
              <div class="metric-value"><?= $total ?></div>
              <div class="metric-meta"><span>tất cả</span></div>
            </article>
          </div>
          <div class="col-12 col-sm-6 col-xl-3">
            <article class="metric-card metric-success">
              <div class="metric-top"><span class="metric-label">Đang Bán</span><span class="metric-icon"><i class="bi bi-check2-circle"></i></span></div>
              <div class="metric-value"><?= $active ?></div>
              <div class="metric-meta"><span>đang hoạt động</span></div>
            </article>
          </div>
          <div class="col-12 col-sm-6 col-xl-3">
            <article class="metric-card metric-danger">
              <div class="metric-top"><span class="metric-label">Hết Hàng</span><span class="metric-icon"><i class="bi bi-exclamation-triangle"></i></span></div>
              <div class="metric-value"><?= $out ?></div>
              <div class="metric-meta"><span>cần nhập thêm</span></div>
            </article>
          </div>
          <div class="col-12 col-sm-6 col-xl-3">
            <article class="metric-card metric-warning">
              <div class="metric-top"><span class="metric-label">Đã Ẩn</span><span class="metric-icon"><i class="bi bi-eye-slash"></i></span></div>
              <div class="metric-value"><?= $hidden ?></div>
              <div class="metric-meta"><span>không hiển thị</span></div>
            </article>
          </div>
        </section>

        <!-- ═══════════════════════════════════════════════════════════ -->
        <!-- FORM: THÊM MỚI / SỬA SẢN PHẨM & BIẾN THỂ -->
        <!-- ═══════════════════════════════════════════════════════════ -->
        <section id="viewProductForm" class="form-panel mt-3" style="display:none;">
          <h2 class="form-panel-title" id="formMainTitle">THÊM MỚI SẢN PHẨM</h2>

          <form id="productFormElement" enctype="multipart/form-data" novalidate>
            <input type="hidden" id="formProductId" name="id" value="">

            <div class="row g-4">
              <!-- Cột trái: Tên SP, Thương hiệu, Mô tả -->
              <div class="col-12 col-lg-7">
                <div class="mb-3">
                  <label class="form-label fw-semibold" for="inp_product_name">Tên sản phẩm <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="inp_product_name" name="product_name" placeholder="giày af1..">
                </div>

                <div class="mb-3">
                  <label class="form-label fw-semibold" for="inp_brand">Thương hiệu</label>
                  <input type="text" class="form-control" id="inp_brand" name="brand" placeholder="Thương hiệu*..">
                </div>

                <div class="mb-3">
                  <label class="form-label fw-semibold">Mô tả</label>
                  <div class="rich-editor-wrapper">
                    <!-- Toolbar matching screenshot -->
                    <div class="rich-editor-toolbar">
                      <button type="button" onclick="execEditor('undo')" title="Undo"><i class="bi bi-arrow-counterclockwise"></i></button>
                      <button type="button" onclick="execEditor('redo')" title="Redo"><i class="bi bi-arrow-clockwise"></i></button>
                      <div class="toolbar-divider"></div>
                      <select class="form-select form-select-sm border-0 py-0 text-muted" onchange="execEditor('formatBlock', this.value)" style="width:auto; background:transparent;">
                        <option value="p">Paragraph</option>
                        <option value="h3">Heading 1</option>
                        <option value="h4">Heading 2</option>
                        <option value="h5">Heading 3</option>
                      </select>
                      <div class="toolbar-divider"></div>
                      <button type="button" onclick="execEditor('bold')" title="Bold"><i class="bi bi-type-bold"></i></button>
                      <button type="button" onclick="execEditor('italic')" title="Italic"><i class="bi bi-type-italic"></i></button>
                      <button type="button" onclick="promptLink()" title="Link"><i class="bi bi-link-45deg"></i></button>
                      <button type="button" onclick="insertTable()" title="Table"><i class="bi bi-table"></i></button>
                      <button type="button" onclick="execEditor('formatBlock', 'blockquote')" title="Quote"><i class="bi bi-quote"></i></button>
                      <button type="button" onclick="promptMedia()" title="Media/Video"><i class="bi bi-play-btn"></i></button>
                      <div class="toolbar-divider"></div>
                      <button type="button" onclick="execEditor('insertUnorderedList')" title="Bullet list"><i class="bi bi-list-ul"></i></button>
                      <button type="button" onclick="execEditor('insertOrderedList')" title="Numbered list"><i class="bi bi-list-ol"></i></button>
                      <button type="button" onclick="execEditor('justifyLeft')" title="Align left"><i class="bi bi-text-left"></i></button>
                      <button type="button" onclick="execEditor('justifyCenter')" title="Align center"><i class="bi bi-text-center"></i></button>
                      <button type="button" onclick="execEditor('justifyRight')" title="Align right"><i class="bi bi-text-right"></i></button>
                    </div>
                    <!-- Editor Area -->
                    <div class="rich-editor-content" id="richEditorArea" contenteditable="true" placeholder="Nhập mô tả sản phẩm..."></div>
                    <textarea id="inp_description" name="description" style="display:none;"></textarea>
                  </div>
                </div>
              </div>

              <!-- Cột phải: Danh mục, Hình ảnh, Album ảnh -->
              <div class="col-12 col-lg-5">
                <div class="mb-3">
                  <label class="form-label fw-semibold" for="inp_category_id">Danh mục sản phẩm*</label>
                  <select class="form-select" id="inp_category_id" name="category_id">
                    <option value="">Category</option>
                    <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['category_name']) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <!-- Single Image Upload -->
                <div class="mb-3">
                  <label class="form-label fw-semibold">Hình ảnh</label>
                  <label class="upload-zone" for="inp_single_image">
                    <span class="upload-icon"><i class="bi bi-image"></i></span>
                    <span class="fw-semibold small">Chọn 1 ảnh</span>
                    <input type="file" id="inp_single_image" name="image" accept="image/*" style="display:none;" onchange="previewMainImage(this)">
                  </label>
                  <div id="mainImagePreviewContainer" class="preview-thumb-container"></div>
                </div>

                <!-- Multiple Album Images Upload -->
                <div class="mb-3">
                  <label class="form-label fw-semibold">Album ảnh</label>
                  <label class="upload-zone" for="inp_album_images">
                    <span class="upload-icon"><i class="bi bi-images"></i></span>
                    <span class="fw-semibold small">Chọn 1 hoặc nhiều ảnh</span>
                    <input type="file" id="inp_album_images" name="album[]" accept="image/*" multiple style="display:none;" onchange="previewAlbumImages(this)">
                  </label>
                  <div id="albumImagesPreviewContainer" class="preview-thumb-container"></div>
                </div>
              </div>
            </div>

            <!-- PHẦN BIẾN THỂ SẢN PHẨM -->
            <div class="variants-container-wrapper">
              <h3 class="variants-section-title">Sản phẩm biến thể</h3>

              <!-- Variant List Items -->
              <div id="variantRowsList"></div>

              <!-- Button Add (+) Circle Centered -->
              <div class="text-center">
                <button type="button" class="btn-add-variant-circle" id="btnAddVariantRow" title="Thêm dòng biến thể">
                  <i class="bi bi-plus-lg"></i>
                </button>
              </div>
            </div>

            <!-- Bottom Action Buttons -->
            <div class="d-flex align-items-center gap-2 mt-3 pt-2 border-top">
              <button type="button" class="btn btn-primary px-4 fw-bold" id="btnSubmitForm">
                <i class="bi bi-plus-lg me-1"></i> <span id="btnSubmitText">THÊM MỚI</span>
              </button>
              <button type="button" class="btn btn-danger px-4 fw-bold" id="btnBackToList">
                <i class="bi bi-arrow-left me-1"></i> QUAY LẠI
              </button>
            </div>
          </form>
        </section>

        <!-- ═══════════════════════════════════════════════════════════ -->
        <!-- TABLE PANEL: DANH SÁCH SẢN PHẨM (Original Table Layout) -->
        <!-- ═══════════════════════════════════════════════════════════ -->
        <section id="viewProductList" class="panel mt-3">
          <div class="panel-header panel-header-col">
            <div class="panel-header-top">
              <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-bag-heart"></i><span>Danh Sách Sản Phẩm</span></h2>
                <p class="text-muted mb-0">Quản lý tất cả sản phẩm và các biến thể trong kho.</p>
              </div>
              <div class="d-flex gap-2 flex-wrap">
                <input class="form-control form-control-sm" type="search" placeholder="Tìm sản phẩm..." id="productSearchInput" style="min-width:180px;" aria-label="Search">
                <select class="form-select form-select-sm" id="statusFilter" style="min-width:145px;">
                  <option value="">Tất cả trạng thái</option>
                  <option value="active">Đang bán</option>
                  <option value="out">Hết hàng</option>
                  <option value="hidden">Ẩn</option>
                </select>
              </div>
            </div>

            <!-- Category tabs -->
            <div class="filter-tabs" id="categoryTabs" role="tablist" aria-label="Lọc theo danh mục">
              <button class="filter-tab active" data-category="" role="tab" aria-selected="true">Tất cả</button>
              <?php foreach ($categories as $cat): ?>
              <button class="filter-tab" data-category="<?= $cat['id'] ?>" role="tab" aria-selected="false">
                <?= htmlspecialchars($cat['category_name']) ?>
              </button>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table align-middle mb-0" id="productsTable">
              <thead>
                <tr>
                  <th style="width:36px;"><input class="form-check-input" type="checkbox" id="selectAll" title="Chọn tất cả"></th>
                  <th>Sản Phẩm</th>
                  <th>Danh Mục</th>
                  <th>Size / Màu</th>
                  <th>Giá Bán</th>
                  <th>Tồn Kho</th>
                  <th>Trạng Thái</th>
                  <th class="text-end">Thao Tác</th>
                </tr>
              </thead>
              <tbody id="productsTableBody">
                <?php if (empty($products)): ?>
                <tr>
                  <td colspan="8" class="text-center text-muted py-5">Chưa có sản phẩm nào. <a href="javascript:void(0);" onclick="switchToCreateMode()">Thêm ngay!</a></td>
                </tr>
                <?php else: ?>
                <?php foreach ($products as $p):
                  $statusLabel = match($p['status'] ?? 'active') {
                    'active' => ['Đang bán', 'success'],
                    'out'    => ['Hết hàng', 'danger'],
                    'hidden' => ['Ẩn', 'secondary'],
                    default  => ['Đang bán', 'success'],
                  };
                  $stockPct = min(100, ($p['quantity'] > 0 ? min(100, $p['quantity'] / 2) : 0));
                  $stockColor = $p['quantity'] == 0 ? 'danger' : ($p['quantity'] < 10 ? 'warning' : 'success');
                  $sizes = htmlspecialchars($p['sizes'] ?? '');
                  $sizeTags = '';
                  if ($sizes) {
                    foreach (explode(',', $sizes) as $s) {
                      if (trim($s) !== '') {
                        $sizeTags .= '<span class="size-tag me-1">' . trim(htmlspecialchars($s)) . '</span>';
                      }
                    }
                  }
                  $imgSrc = !empty($p['image'])
                    ? $BASE . 'assets/uploads/' . $p['image']
                    : null;
                ?>
                <tr data-id="<?= $p['id'] ?>" data-category="<?= $p['category_id'] ?? '' ?>" data-status="<?= $p['status'] ?? 'active' ?>">
                  <td><input class="form-check-input row-check" type="checkbox"></td>
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      <?php if ($imgSrc): ?>
                        <img class="product-img-thumb" src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($p['product_name']) ?>" onerror="this.src='<?= $BASE ?>assets/uploads/products/default.jpg'">
                      <?php else: ?>
                        <span class="product-img-placeholder"><i class="bi bi-image"></i></span>
                      <?php endif; ?>
                      <div>
                        <p class="fw-semibold mb-0" style="white-space:nowrap;"><?= htmlspecialchars($p['product_name']) ?></p>
                        <p class="text-muted small mb-0">
                          <?php if (!empty($p['sku'])): ?>SKU: <?= htmlspecialchars($p['sku']) ?> &middot; <?php endif; ?>
                          <?= htmlspecialchars($p['brand'] ?? '') ?>
                        </p>
                      </div>
                    </div>
                  </td>
                  <td>
                    <?php if (!empty($p['category_name'])): ?>
                    <span class="badge text-bg-primary"><?= htmlspecialchars($p['category_name']) ?></span>
                    <?php else: ?><span class="text-muted small">—</span><?php endif; ?>
                  </td>
                  <td>
                    <div><?= $sizeTags ?: '<span class="text-muted small">Mặc định</span>' ?></div>
                    <?php if (!empty($p['colors'])): ?>
                    <small class="text-muted d-block mt-1"><?= htmlspecialchars($p['colors']) ?></small>
                    <?php endif; ?>
                  </td>
                  <td>
                    <span class="fw-bold"><?= number_format($p['price'] ?? 0, 0, ',', '.') ?>₫</span>
                    <?php if (!empty($p['original_price']) && $p['original_price'] > $p['price']): ?>
                    <small class="text-muted d-block text-decoration-line-through"><?= number_format($p['original_price'], 0, ',', '.') ?>₫</small>
                    <?php endif; ?>
                  </td>
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      <div class="stock-bar"><div class="stock-bar-fill bg-<?= $stockColor ?>" style="width:<?= $stockPct ?>%"></div></div>
                      <span class="small fw-semibold <?= $p['quantity'] == 0 ? 'text-danger' : '' ?>"><?= intval($p['quantity'] ?? 0) ?></span>
                    </div>
                  </td>
                  <td><span class="badge text-bg-<?= $statusLabel[1] ?>"><?= $statusLabel[0] ?></span></td>
                  <td>
                    <div class="action-btn-group">
                      <button class="btn btn-primary btn-sm btn-icon-sm btn-table-edit" type="button" title="Sửa" data-id="<?= $p['id'] ?>">
                        <i class="bi bi-pencil"></i>
                      </button>
                      <button class="btn btn-danger btn-sm btn-icon-sm btn-table-delete" type="button" title="Xóa" data-id="<?= $p['id'] ?>" data-name="<?= htmlspecialchars($p['product_name']) ?>">
                        <i class="bi bi-trash3"></i>
                      </button>
                    </div>
                  </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>

          <div class="d-flex align-items-center justify-content-between gap-3 mt-3 p-3">
            <p class="text-muted small mb-0" id="paginationInfo">Hiển thị <?= count($products) ?> sản phẩm</p>
          </div>
        </section>

      </div>
    </main>

    <footer class="admin-footer">
      <div class="container-fluid px-3 px-lg-4">
        <span>Copyright 2026 adminHMD &mdash; Seller Dashboard</span>
      </div>
    </footer>
  </div>
</div>

<!-- ═══ MODAL: XÁC NHẬN XÓA ═══ -->
<div class="modal fade" id="modalDeleteProduct" tabindex="-1" aria-labelledby="lblDeleteProduct" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
    <div class="modal-content text-center">
      <div class="modal-body py-4 px-4">
        <div class="delete-confirm-icon mx-auto"><i class="bi bi-trash3"></i></div>
        <h2 class="h5 mb-2" id="lblDeleteProduct">Xoá Sản Phẩm?</h2>
        <p class="text-muted mb-1">Bạn chắc chắn muốn xóa sản phẩm:</p>
        <p class="fw-bold mb-1" id="deleteProductName"></p>
        <p class="text-danger small mt-2 mb-0"><i class="bi bi-exclamation-triangle me-1"></i>Hành động này không thể hoàn tác.</p>
      </div>
      <div class="modal-footer justify-content-center gap-2 border-0 pt-0 pb-4">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="min-width:110px;">Huỷ</button>
        <button type="button" class="btn btn-danger" id="btnConfirmDelete" style="min-width:110px;" data-id="">
          <i class="bi bi-trash3 me-1"></i>Xoá
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Loading overlay -->
<div class="spinner-overlay" id="loadingOverlay">
  <div class="spinner-border text-light" role="status"><span class="visually-hidden">Đang xử lý...</span></div>
</div>

<!-- Toast stack -->
<div class="toast-stack" id="toastStack" aria-live="polite"></div>

<script src="<?= $BASE ?>admin/assets/js/bootstrap.bundle.min.js"></script>
<script src="<?= $BASE ?>admin/assets/js/main.js"></script>
<script>
const AVAILABLE_SIZES = <?= json_encode($sizesList) ?>;
const AVAILABLE_COLORS_DATA = <?= json_encode($colorsList) ?>;
const AVAILABLE_COLORS = <?= json_encode(array_column($colorsList, 'name')) ?>;

const rowColorsMap = {};

function getColorHex(colorName) {
  if (!colorName) return '#9ca3af';
  const found = AVAILABLE_COLORS_DATA.find(c => c.name.toLowerCase() === colorName.trim().toLowerCase());
  return found ? found.hex : '#6366f1';
}

function initColorMultiSelect(rowId, initialColors = []) {
  rowColorsMap[rowId] = new Set(initialColors.filter(c => typeof c === 'string' && c.trim() !== ''));
  renderColorComponent(rowId);
}

function renderColorComponent(rowId) {
  const wrap = document.getElementById(`cms_${rowId}`);
  if (!wrap) return;

  const chipsBox = wrap.querySelector('.color-chips-box');
  const hiddenInp = wrap.querySelector('.variant-colors-input');
  const selectedSet = rowColorsMap[rowId] || new Set();
  const selectedArr = Array.from(selectedSet);

  hiddenInp.value = selectedArr.join(', ');

  if (selectedArr.length === 0) {
    chipsBox.innerHTML = `<span class="color-placeholder">Chọn màu sắc...</span>`;
  } else {
    chipsBox.innerHTML = selectedArr.map(c => `
      <span class="color-chip">
        <span class="color-chip-dot" style="background:${getColorHex(c)}"></span>
        <span>${escapeHtml(c)}</span>
        <span class="color-chip-del" onclick="event.stopPropagation(); removeColor('${rowId}', '${escapeHtml(c)}')" title="Xóa">&times;</span>
      </span>
    `).join('');
  }

  wrap.querySelectorAll('.color-cb').forEach(cb => {
    cb.checked = selectedSet.has(cb.dataset.color);
  });
}

function toggleColorDropdown(rowId, e) {
  if (e) e.stopPropagation();
  const wrap = document.getElementById(`cms_${rowId}`);
  if (!wrap) return;
  const isOpen = wrap.classList.contains('open');
  document.querySelectorAll('.color-multiselect-wrap.open').forEach(el => el.classList.remove('open'));
  if (!isOpen) {
    wrap.classList.add('open');
  }
}

function toggleColorSelection(rowId, colorName) {
  if (!rowColorsMap[rowId]) rowColorsMap[rowId] = new Set();
  if (rowColorsMap[rowId].has(colorName)) {
    rowColorsMap[rowId].delete(colorName);
  } else {
    rowColorsMap[rowId].add(colorName);
  }
  renderColorComponent(rowId);
}

function removeColor(rowId, colorName) {
  if (rowColorsMap[rowId]) {
    rowColorsMap[rowId].delete(colorName);
    renderColorComponent(rowId);
  }
}

function selectAllColors(rowId) {
  if (!rowColorsMap[rowId]) rowColorsMap[rowId] = new Set();
  AVAILABLE_COLORS.forEach(c => rowColorsMap[rowId].add(c));
  renderColorComponent(rowId);
}

function clearColors(rowId) {
  if (rowColorsMap[rowId]) {
    rowColorsMap[rowId].clear();
    renderColorComponent(rowId);
  }
}

function addCustomColor(rowId) {
  const wrap = document.getElementById(`cms_${rowId}`);
  if (!wrap) return;
  const inp = wrap.querySelector('.custom-color-inp');
  const val = inp.value.trim();
  if (val) {
    if (!rowColorsMap[rowId]) rowColorsMap[rowId] = new Set();
    rowColorsMap[rowId].add(val);
    inp.value = '';
    renderColorComponent(rowId);
  }
}

function escapeHtml(str) {
  return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
}

document.addEventListener('click', function(e) {
  if (!e.target.closest('.color-multiselect-wrap')) {
    document.querySelectorAll('.color-multiselect-wrap.open').forEach(el => el.classList.remove('open'));
  }
});

(function () {
  "use strict";

  const BASE_URL = "<?= $BASE ?>";
  let isEditMode = false;
  let currentEditingId = null;

  /* ── Toast ──────────────────────────────── */
  window.showToast = function(msg, type) {
    type = type || "success";
    const m = { success:"text-bg-success", danger:"text-bg-danger", warning:"text-bg-warning", info:"text-bg-primary" };
    const ic = { success:"bi-check2-circle", danger:"bi-x-circle", warning:"bi-exclamation-triangle", info:"bi-info-circle" };
    const el = document.createElement("div");
    el.className = "toast show align-items-center border-0 " + (m[type] || m.success);
    el.setAttribute("role", "alert");
    el.innerHTML = `<div class="d-flex"><div class="toast-body d-flex align-items-center gap-2"><i class="bi ${ic[type] || ic.success}"></i>${msg}</div><button type="button" class="btn-close btn-close-white me-2 m-auto" aria-label="Close"></button></div>`;
    el.querySelector("button").addEventListener("click", () => el.remove());
    document.getElementById("toastStack").appendChild(el);
    setTimeout(() => { el.classList.remove("show"); setTimeout(() => el.remove(), 300); }, 3500);
  };

  function setLoading(on) {
    document.getElementById("loadingOverlay").classList.toggle("show", on);
  }

  /* ── Rich Text Editor helpers ── */
  window.execEditor = function(cmd, val = null) {
    document.getElementById("richEditorArea").focus();
    document.execCommand(cmd, false, val);
  };
  window.promptLink = function() {
    const url = prompt("Nhập đường dẫn URL:", "https://");
    if (url) window.execEditor("createLink", url);
  };
  window.promptMedia = function() {
    const url = prompt("Nhập URL hình ảnh hoặc video:", "https://");
    if (url) window.execEditor("insertImage", url);
  };
  window.insertTable = function() {
    const tableHtml = '<table class="table table-bordered my-2"><tbody><tr><td>Nội dung 1</td><td>Nội dung 2</td></tr><tr><td>Nội dung 3</td><td>Nội dung 4</td></tr></tbody></table><p></p>';
    window.execEditor("insertHTML", tableHtml);
  };

  /* ── Dynamic Variant Row Creation ── */
  window.addVariantRow = function(data = {}) {
    const container = document.getElementById("variantRowsList");
    const rowId = "vrow_" + Math.random().toString(36).substring(2, 9);
    const row = document.createElement("div");
    row.className = "variant-row";
    row.id = rowId;

    const sizeVal = data.size || "";
    let initialColors = [];
    if (Array.isArray(data.colors)) {
      initialColors = data.colors;
    } else if (typeof data.color === "string" && data.color.trim() !== "") {
      initialColors = data.color.split(",").map(c => c.trim()).filter(Boolean);
    } else if (Array.isArray(data.color)) {
      initialColors = data.color;
    }

    const origVal = data.original_price !== undefined ? data.original_price : "";
    const saleVal = data.sale_price !== undefined ? data.sale_price : "";
    const qtyVal = data.quantity !== undefined ? data.quantity : "";

    let sizeOptions = `<option value="">Chọn Size</option>`;
    AVAILABLE_SIZES.forEach(s => {
      sizeOptions += `<option value="${s}" ${s === sizeVal ? "selected" : ""}>${s}</option>`;
    });

    const colorOptionsHtml = AVAILABLE_COLORS_DATA.map(c => `
      <label class="color-option-item" onclick="toggleColorSelection('${rowId}', '${c.name}')">
        <input type="checkbox" class="form-check-input mt-0 color-cb" data-color="${c.name}" onclick="event.stopPropagation(); toggleColorSelection('${rowId}', '${c.name}')">
        <span class="color-option-dot" style="background:${c.hex}"></span>
        <span class="color-name flex-grow-1">${c.name}</span>
      </label>
    `).join('');

    row.innerHTML = `
      <div>
        <label class="variant-col-label">Kích cỡ</label>
        <select class="form-select form-select-sm" name="variant_size[]">
          ${sizeOptions}
        </select>
      </div>
      <div>
        <label class="variant-col-label">Màu sắc (chọn nhiều)</label>
        <div class="color-multiselect-wrap" id="cms_${rowId}">
          <input type="hidden" name="variant_color[]" class="variant-colors-input" value="">
          <div class="color-multiselect-trigger" onclick="toggleColorDropdown('${rowId}', event)">
            <div class="color-chips-box"></div>
            <i class="bi bi-chevron-down text-muted small" style="margin-left:auto;"></i>
          </div>
          <div class="color-multiselect-dropdown" onclick="event.stopPropagation()">
            <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom">
              <span class="small fw-bold text-muted">Bảng màu</span>
              <div class="d-flex gap-2">
                <button type="button" class="btn btn-link btn-xs p-0 text-decoration-none" onclick="selectAllColors('${rowId}')">Tất cả</button>
                <span class="text-muted" style="font-size:11px;">|</span>
                <button type="button" class="btn btn-link btn-xs p-0 text-decoration-none text-danger" onclick="clearColors('${rowId}')">Bỏ chọn</button>
              </div>
            </div>
            <div class="color-options-list">
              ${colorOptionsHtml}
            </div>
            <div class="d-flex gap-1 mt-2 pt-2 border-top">
              <input type="text" class="form-control form-control-sm custom-color-inp" placeholder="Màu khác..." onkeydown="if(event.key==='Enter'){event.preventDefault();addCustomColor('${rowId}');}">
              <button type="button" class="btn btn-sm btn-outline-primary px-2" onclick="addCustomColor('${rowId}')">Thêm</button>
            </div>
          </div>
        </div>
      </div>
      <div>
        <label class="variant-col-label">Giá gốc</label>
        <input type="number" min="0" step="1000" class="form-control form-control-sm" name="variant_original_price[]" placeholder="500.." value="${origVal}">
      </div>
      <div>
        <label class="variant-col-label">Giá khuyến mãi</label>
        <input type="number" min="0" step="1000" class="form-control form-control-sm" name="variant_sale_price[]" placeholder="500.." value="${saleVal}">
      </div>
      <div>
        <label class="variant-col-label">Số lượng</label>
        <input type="number" min="0" class="form-control form-control-sm" name="variant_quantity[]" placeholder="500.." value="${qtyVal}">
      </div>
      <div class="text-end">
        <button type="button" class="btn-delete-variant" title="Xóa dòng biến thể" onclick="removeVariantRow('${rowId}')">
          <i class="bi bi-trash3"></i>
        </button>
      </div>
    `;

    container.appendChild(row);
    initColorMultiSelect(rowId, initialColors);
  };

  window.removeVariantRow = function(rowId) {
    const row = document.getElementById(rowId);
    if (!row) return;
    const allRows = document.querySelectorAll(".variant-row");
    if (allRows.length <= 1) {
      showToast("Cần giữ lại ít nhất 1 biến thể.", "warning");
      return;
    }
    delete rowColorsMap[rowId];
    row.remove();
  };

  /* ── Image Upload Previews ── */
  window.previewMainImage = function(input) {
    const container = document.getElementById("mainImagePreviewContainer");
    container.innerHTML = "";
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        container.innerHTML = `
          <div class="preview-item">
            <img src="${e.target.result}" class="preview-thumb" alt="Preview">
            <button type="button" class="preview-remove-btn" onclick="clearMainImage()">&times;</button>
          </div>
        `;
      };
      reader.readAsDataURL(input.files[0]);
    }
  };

  window.clearMainImage = function() {
    document.getElementById("inp_single_image").value = "";
    document.getElementById("mainImagePreviewContainer").innerHTML = "";
  };

  window.previewAlbumImages = function(input) {
    const container = document.getElementById("albumImagesPreviewContainer");
    container.innerHTML = "";
    if (input.files) {
      Array.from(input.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
          const div = document.createElement("div");
          div.className = "preview-item";
          div.innerHTML = `<img src="${e.target.result}" class="preview-thumb" alt="Album Preview">`;
          container.appendChild(div);
        };
        reader.readAsDataURL(file);
      });
    }
  };

  /* ── Switch View Modes ── */
  window.switchToCreateMode = function() {
    isEditMode = false;
    currentEditingId = null;
    document.getElementById("formMainTitle").textContent = "THÊM MỚI SẢN PHẨM";
    document.getElementById("btnSubmitText").textContent = "THÊM MỚI";
    document.getElementById("btnToggleAddProductText").textContent = "Đóng Form";
    document.getElementById("productFormElement").reset();
    document.getElementById("richEditorArea").innerHTML = "";
    document.getElementById("mainImagePreviewContainer").innerHTML = "";
    document.getElementById("albumImagesPreviewContainer").innerHTML = "";
    document.getElementById("formProductId").value = "";

    const container = document.getElementById("variantRowsList");
    container.innerHTML = "";
    Object.keys(rowColorsMap).forEach(k => delete rowColorsMap[k]);

    addVariantRow({ size: 'M' });
    addVariantRow({ size: 'L' });

    document.getElementById("viewProductForm").style.display = "block";
    document.getElementById("viewProductForm").scrollIntoView({ behavior: 'smooth' });
  };

  window.switchToListMode = function() {
    document.getElementById("viewProductForm").style.display = "none";
    document.getElementById("btnToggleAddProductText").textContent = "Thêm Sản Phẩm";
  };

  window.switchToEditMode = function(productId) {
    setLoading(true);
    fetch(`${BASE_URL}?action=/admin/products&ajax=edit&id=${productId}`)
      .then(r => r.json())
      .then(res => {
        setLoading(false);
        if (!res.success || !res.product) {
          showToast(res.message || "Không thể tải thông tin sản phẩm", "danger");
          return;
        }
        const p = res.product;
        isEditMode = true;
        currentEditingId = p.id;
        document.getElementById("formMainTitle").textContent = "CHỈNH SỬA SẢN PHẨM";
        document.getElementById("btnSubmitText").textContent = "LƯU THAY ĐỔI";
        document.getElementById("btnToggleAddProductText").textContent = "Đóng Form";
        document.getElementById("formProductId").value = p.id;
        document.getElementById("inp_product_name").value = p.product_name || "";
        document.getElementById("inp_brand").value = p.brand || "";
        document.getElementById("inp_category_id").value = p.category_id || "";
        document.getElementById("richEditorArea").innerHTML = p.description || "";

        // Main Image
        const mainContainer = document.getElementById("mainImagePreviewContainer");
        mainContainer.innerHTML = "";
        if (p.image) {
          mainContainer.innerHTML = `
            <div class="preview-item">
              <img src="${BASE_URL}assets/uploads/${p.image}" class="preview-thumb" alt="Main Image">
            </div>
          `;
        }

        // Album Images
        const albumContainer = document.getElementById("albumImagesPreviewContainer");
        albumContainer.innerHTML = "";
        if (p.images && p.images.length > 0) {
          p.images.forEach(img => {
            const div = document.createElement("div");
            div.className = "preview-item";
            div.innerHTML = `<img src="${BASE_URL}assets/uploads/${img.image}" class="preview-thumb" alt="Album Image">`;
            albumContainer.appendChild(div);
          });
        }

        // Variants: Group variants by (size + prices + qty) so colors for that size are combined
        const variantContainer = document.getElementById("variantRowsList");
        variantContainer.innerHTML = "";
        Object.keys(rowColorsMap).forEach(k => delete rowColorsMap[k]);

        if (p.variants && p.variants.length > 0) {
          const grouped = {};
          p.variants.forEach(v => {
            const sizeKey = v.size || '__no_size__';
            const priceKey = `${v.original_price}_${v.sale_price}_${v.quantity}`;
            const key = `${sizeKey}###${priceKey}`;

            if (!grouped[key]) {
              grouped[key] = {
                size: v.size || '',
                colors: [],
                original_price: v.original_price,
                sale_price: v.sale_price,
                quantity: v.quantity
              };
            }
            if (v.color && !grouped[key].colors.includes(v.color)) {
              grouped[key].colors.push(v.color);
            }
          });

          Object.values(grouped).forEach(g => {
            addVariantRow(g);
          });
        } else {
          addVariantRow({ original_price: p.original_price, sale_price: p.price, quantity: p.quantity });
        }

        document.getElementById("viewProductForm").style.display = "block";
        document.getElementById("viewProductForm").scrollIntoView({ behavior: 'smooth' });
      })
      .catch(() => {
        setLoading(false);
        showToast("Lỗi kết nối tải thông tin!", "danger");
      });
  };

  /* ── Toggle button on top ── */
  document.getElementById("btnToggleAddProduct").addEventListener("click", function() {
    const isVisible = document.getElementById("viewProductForm").style.display !== "none";
    if (isVisible) {
      switchToListMode();
    } else {
      switchToCreateMode();
    }
  });

  document.getElementById("btnBackToList").addEventListener("click", switchToListMode);
  document.getElementById("btnAddVariantRow").addEventListener("click", () => addVariantRow());

  /* ── Submit Form ── */
  document.getElementById("btnSubmitForm").addEventListener("click", function() {
    const name = document.getElementById("inp_product_name").value.trim();
    if (!name) {
      showToast("Vui lòng nhập tên sản phẩm!", "warning");
      document.getElementById("inp_product_name").focus();
      return;
    }

    document.getElementById("inp_description").value = document.getElementById("richEditorArea").innerHTML;
    const form = document.getElementById("productFormElement");
    const formData = new FormData(form);

    const actionUrl = isEditMode && currentEditingId
      ? `${BASE_URL}?action=/admin/products&ajax=update&id=${currentEditingId}`
      : `${BASE_URL}?action=/admin/products&ajax=store`;

    setLoading(true);
    fetch(actionUrl, { method: "POST", body: formData })
    .then(r => r.json())
    .then(res => {
      setLoading(false);
      if (res.success) {
        showToast(res.message || "Thành công!", "success");
        setTimeout(() => location.reload(), 750);
      } else {
        showToast(res.message || "Có lỗi xảy ra!", "danger");
      }
    })
    .catch(() => {
      setLoading(false);
      showToast("Lỗi kết nối máy chủ!", "danger");
    });
  });

  /* ── Edit / Delete in table ── */
  document.querySelectorAll(".btn-table-edit").forEach(btn => {
    btn.addEventListener("click", () => switchToEditMode(btn.dataset.id));
  });

  let targetDeleteId = null;
  document.querySelectorAll(".btn-table-delete").forEach(btn => {
    btn.addEventListener("click", function() {
      targetDeleteId = this.dataset.id;
      document.getElementById("deleteProductName").textContent = this.dataset.name;
      new bootstrap.Modal(document.getElementById("modalDeleteProduct")).show();
    });
  });

  document.getElementById("btnConfirmDelete").addEventListener("click", function() {
    if (!targetDeleteId) return;
    setLoading(true);
    fetch(`${BASE_URL}?action=/admin/products&ajax=delete&id=${targetDeleteId}`, { method: "POST" })
      .then(r => r.json())
      .then(res => {
        setLoading(false);
        bootstrap.Modal.getInstance(document.getElementById("modalDeleteProduct")).hide();
        if (res.success) {
          showToast(res.message || "Đã xóa sản phẩm.", "success");
          setTimeout(() => location.reload(), 750);
        } else {
          showToast(res.message || "Xóa thất bại.", "danger");
        }
      })
      .catch(() => {
        setLoading(false);
        showToast("Lỗi kết nối!", "danger");
      });
  });

  /* ── Filters and Search ── */
  let activeCategory = "";
  const rows = Array.from(document.querySelectorAll("#productsTableBody tr[data-id]"));

  function applyFilters() {
    const statusVal = document.getElementById("statusFilter").value;
    const searchVal = document.getElementById("productSearchInput").value.trim().toLowerCase();
    let visible = 0;
    rows.forEach(function(row) {
      const catOk    = activeCategory === "" || row.dataset.category === activeCategory;
      const stOk     = statusVal === "" || row.dataset.status === statusVal;
      const srchOk   = searchVal === "" || row.textContent.toLowerCase().includes(searchVal);
      row.hidden   = !(catOk && stOk && srchOk);
      if (!row.hidden) visible++;
    });
    document.getElementById("paginationInfo").textContent = "Hiển thị " + visible + " sản phẩm";
  }

  document.querySelectorAll("#categoryTabs .filter-tab").forEach(function(tab) {
    tab.addEventListener("click", function() {
      document.querySelectorAll("#categoryTabs .filter-tab").forEach(t => { t.classList.remove("active"); t.setAttribute("aria-selected","false"); });
      tab.classList.add("active"); tab.setAttribute("aria-selected","true");
      activeCategory = tab.dataset.category || "";
      applyFilters();
    });
  });
  document.getElementById("statusFilter").addEventListener("change", applyFilters);
  document.getElementById("productSearchInput").addEventListener("input", applyFilters);
  document.getElementById("selectAll").addEventListener("change", function() {
    document.querySelectorAll(".row-check").forEach(cb => cb.checked = this.checked);
  });

  // Initial variant rows for add form
  addVariantRow({ size: 'M' });
  addVariantRow({ size: 'L' });

})();
</script>
</body>
</html>
