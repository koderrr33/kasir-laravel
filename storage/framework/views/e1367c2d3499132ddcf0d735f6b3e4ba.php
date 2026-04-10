<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Kasir'); ?> — TokoKu POS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --bg:        #0d0f14;
            --surface:   #161922;
            --card:      #1e2230;
            --border:    #2a2f3d;
            --accent:    #f5c542;
            --accent2:   #ff6b35;
            --green:     #22c55e;
            --red:       #ef4444;
            --text:      #e8eaf0;
            --muted:     #7c8398;
            --radius:    12px;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }
        /* Sidebar */
        .sidebar {
            position: fixed; top: 0; left: 0; bottom: 0; width: 240px;
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex; flex-direction: column;
            z-index: 100;
        }
        .sidebar-brand {
            padding: 24px 20px;
            border-bottom: 1px solid var(--border);
        }
        .sidebar-brand .logo {
            font-family: 'Space Mono', monospace;
            font-size: 20px; font-weight: 700;
            color: var(--accent);
            letter-spacing: -0.5px;
        }
        .sidebar-brand .tagline {
            font-size: 11px; color: var(--muted);
            margin-top: 3px; letter-spacing: 1px;
            text-transform: uppercase;
        }
        .nav-section {
            padding: 16px 12px 8px;
            font-size: 10px; color: var(--muted);
            letter-spacing: 1.5px; text-transform: uppercase;
            font-weight: 600;
        }
        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 11px 20px;
            color: var(--muted);
            text-decoration: none;
            border-radius: var(--radius);
            margin: 2px 8px;
            font-size: 14px; font-weight: 500;
            transition: all .2s;
        }
        .nav-item:hover { background: var(--card); color: var(--text); }
        .nav-item.active {
            background: rgba(245,197,66,.12);
            color: var(--accent);
        }
        .nav-item i { width: 16px; text-align: center; }
        .sidebar-footer {
            margin-top: auto;
            padding: 20px;
            border-top: 1px solid var(--border);
            font-size: 12px; color: var(--muted);
        }

        /* Main */
        .main { margin-left: 240px; min-height: 100vh; }
        .topbar {
            height: 64px;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 28px;
            position: sticky; top: 0; z-index: 50;
        }
        .topbar-title { font-size: 18px; font-weight: 700; }
        .topbar-info {
            display: flex; align-items: center; gap: 16px;
            font-size: 13px; color: var(--muted);
        }
        .badge-kasir {
            background: rgba(245,197,66,.15);
            color: var(--accent);
            padding: 4px 12px;
            border-radius: 99px;
            font-size: 12px; font-weight: 600;
        }
        .content { padding: 28px; }

        /* Cards */
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
        }
        .card-header {
            padding: 18px 22px;
            border-bottom: 1px solid var(--border);
            font-size: 15px; font-weight: 700;
            display: flex; align-items: center; justify-content: space-between;
        }

        /* Buttons */
        .btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 9px 18px; border-radius: 8px;
            font-family: inherit; font-size: 13px; font-weight: 600;
            cursor: pointer; border: none; transition: all .2s;
            text-decoration: none;
        }
        .btn-primary {
            background: var(--accent); color: #000;
        }
        .btn-primary:hover { background: #e8b820; transform: translateY(-1px); }
        .btn-success  { background: var(--green); color: #fff; }
        .btn-success:hover { background: #16a34a; }
        .btn-danger   { background: var(--red); color: #fff; }
        .btn-danger:hover { background: #dc2626; }
        .btn-ghost {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text);
        }
        .btn-ghost:hover { background: var(--surface); }
        .btn-sm { padding: 6px 12px; font-size: 12px; }
        .btn-lg { padding: 14px 28px; font-size: 15px; }

        /* Alerts */
        .alert {
            padding: 14px 18px; border-radius: var(--radius);
            margin-bottom: 20px; font-size: 14px;
        }
        .alert-success { background: rgba(34,197,94,.15); border: 1px solid rgba(34,197,94,.3); color: #22c55e; }
        .alert-danger  { background: rgba(239,68,68,.15); border: 1px solid rgba(239,68,68,.3); color: #ef4444; }

        /* Table */
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px 16px; text-align: left; font-size: 13px; }
        th { font-size: 11px; color: var(--muted); font-weight: 600; text-transform: uppercase; letter-spacing: .5px; }
        tbody tr { border-top: 1px solid var(--border); }
        tbody tr:hover { background: rgba(255,255,255,.02); }

        /* Form */
        .form-group { margin-bottom: 18px; }
        label { display: block; font-size: 12px; color: var(--muted); margin-bottom: 6px; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; }
        input, select, textarea {
            width: 100%; padding: 10px 14px;
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 8px; color: var(--text); font-family: inherit; font-size: 14px;
        }
        input:focus, select:focus, textarea:focus {
            outline: none; border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(245,197,66,.1);
        }

        /* Stat chips */
        .stat-grid {
            display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: var(--card); border: 1px solid var(--border);
            border-radius: var(--radius); padding: 20px;
        }
        .stat-label { font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: .5px; font-weight: 600; }
        .stat-value { font-size: 26px; font-weight: 800; margin-top: 6px; font-family: 'Space Mono', monospace; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg); }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }

        /* Toast */
        .toast-wrap {
            position: fixed;
            right: 18px;
            bottom: 18px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            z-index: 9999;
            pointer-events: none;
        }
        .toast {
            width: min(420px, calc(100vw - 36px));
            background: rgba(22, 25, 34, .92);
            border: 1px solid var(--border);
            backdrop-filter: blur(10px);
            border-radius: 14px;
            padding: 12px 14px;
            display: flex;
            gap: 10px;
            align-items: flex-start;
            box-shadow: 0 18px 60px rgba(0,0,0,.45);
            transform: translateY(6px);
            opacity: 0;
            transition: all .18s ease;
            pointer-events: auto;
        }
        .toast.show { transform: translateY(0); opacity: 1; }
        .toast .ic {
            width: 34px; height: 34px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex: 0 0 auto;
            margin-top: 1px;
        }
        .toast.success .ic { background: rgba(34,197,94,.12); color: var(--green); border: 1px solid rgba(34,197,94,.25); }
        .toast.error .ic   { background: rgba(239,68,68,.12); color: var(--red); border: 1px solid rgba(239,68,68,.25); }
        .toast.info .ic    { background: rgba(245,197,66,.12); color: var(--accent); border: 1px solid rgba(245,197,66,.25); }
        .toast .t-title { font-weight: 800; font-size: 13px; margin-bottom: 2px; }
        .toast .t-msg { font-size: 12px; color: var(--muted); line-height: 1.35; }
        .toast .x {
            margin-left: auto;
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text);
            width: 30px; height: 30px;
            border-radius: 10px;
            cursor: pointer;
            opacity: .85;
            transition: all .15s ease;
        }
        .toast .x:hover { opacity: 1; transform: translateY(-1px); border-color: rgba(245,197,66,.35); }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="logo">TokoKu POS</div>
        <div class="tagline">Point of Sale System</div>
    </div>

    <div class="nav-section">Menu Utama</div>
    <a href="<?php echo e(route('kasir.index')); ?>"    class="nav-item <?php echo e(request()->routeIs('kasir.index') ? 'active' : ''); ?>">
        <i class="fa fa-cash-register"></i> Kasir
    </a>
    <a href="<?php echo e(route('kasir.riwayat')); ?>"  class="nav-item <?php echo e(request()->routeIs('kasir.riwayat') ? 'active' : ''); ?>">
        <i class="fa fa-receipt"></i> Riwayat Transaksi
    </a>

    <div class="nav-section">Master Data</div>
    <a href="<?php echo e(route('products.index')); ?>" class="nav-item <?php echo e(request()->routeIs('products.*') ? 'active' : ''); ?>">
        <i class="fa fa-box"></i> Data Produk
    </a>
    <a href="<?php echo e(route('products.create')); ?>" class="nav-item">
        <i class="fa fa-plus"></i> Tambah Produk
    </a>

    <div class="sidebar-footer">
        <i class="fa fa-circle" style="color:var(--green);font-size:8px"></i>
        Kasir: <strong>Admin</strong><br>
        <?php echo e(now()->format('d M Y')); ?>

    </div>
</aside>

<!-- Main -->
<div class="main">
    <div class="topbar">
        <div class="topbar-title"><?php echo $__env->yieldContent('title', 'Dashboard'); ?></div>
        <div class="topbar-info">
            <span><i class="fa fa-clock"></i> <?php echo e(now()->format('H:i')); ?> WIB</span>
            <span class="badge-kasir"><i class="fa fa-user"></i> Admin</span>
        </div>
    </div>

    <div class="content">
        <?php if(session('success')): ?>
            <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger"><i class="fa fa-circle-xmark"></i> <?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </div>
</div>

<div class="toast-wrap" id="toastWrap" aria-live="polite" aria-relevant="additions"></div>

<?php echo $__env->yieldPushContent('scripts'); ?>
<script>
    window.toast = function toast(message, type = 'info', title = null, timeoutMs = 2600) {
        const wrap = document.getElementById('toastWrap');
        if (!wrap) return;

        const el = document.createElement('div');
        el.className = `toast ${type}`;
        const icon = type === 'success' ? 'fa-check' : (type === 'error' ? 'fa-triangle-exclamation' : 'fa-circle-info');
        el.innerHTML = `
            <div class="ic"><i class="fa ${icon}"></i></div>
            <div style="min-width:0">
                <div class="t-title">${title ?? (type === 'error' ? 'Gagal' : type === 'success' ? 'Berhasil' : 'Info')}</div>
                <div class="t-msg"></div>
            </div>
            <button class="x" type="button" aria-label="Tutup"><i class="fa fa-xmark"></i></button>
        `;
        el.querySelector('.t-msg').textContent = String(message ?? '');
        el.querySelector('.x').addEventListener('click', () => el.remove());
        wrap.appendChild(el);
        requestAnimationFrame(() => el.classList.add('show'));

        if (timeoutMs > 0) {
            window.setTimeout(() => {
                el.classList.remove('show');
                window.setTimeout(() => el.remove(), 220);
            }, timeoutMs);
        }
    }
</script>
</body>
</html>
<?php /**PATH /home/alnitak/Downloads/kasir-laravel/resources/views/layouts/app.blade.php ENDPATH**/ ?>