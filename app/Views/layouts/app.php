<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Sistem Akademik'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #eef2fb;
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }
        .app-header {
            background: #0b5ed7;
            color: #fff;
            padding: 0.75rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 3px 8px rgba(0,0,0,0.12);
        }
        .app-title {
            font-size: 1.15rem;
            font-weight: 600;
            margin: 0;
        }
        .app-shell {
            display: flex;
            min-height: calc(100vh - 64px);
        }
        .app-sidebar {
            width: 240px;
            background: #fff;
            border-right: 1px solid #e4e7f2;
            padding: 1.25rem;
        }
        .sidebar-heading {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #9ca1b3;
            letter-spacing: .08em;
            margin-bottom: 0.75rem;
        }
        .sidebar-link {
            display: block;
            padding: 0.55rem 0.85rem;
            border-radius: 8px;
            color: #455280;
            font-weight: 500;
            text-decoration: none;
            margin-bottom: 0.25rem;
        }
        .sidebar-link.active,
        .sidebar-link:hover {
            background: #0b5ed7;
            color: #fff;
        }
        .app-content {
            flex: 1;
            padding: 1.5rem;
        }
    </style>
</head>
<?php
    helper('url');
    $role = session('role');
    $navItems = [
        ['label' => 'Halaman Utama', 'url' => base_url('dashboard')],
    ];

    if ($role === 'admin') {
        $navItems = array_merge($navItems, [
            ['label' => 'Kelola User', 'url' => base_url('admin/users')],
            ['label' => 'Mata Kuliah', 'url' => base_url('admin/mata-kuliah')],
            ['label' => 'Ruangan', 'url' => base_url('admin/ruangan')],
            ['label' => 'Jadwal Kuliah', 'url' => base_url('admin/jadwal')],
        ]);
    } elseif ($role === 'mahasiswa') {
        $navItems = array_merge($navItems, [
            ['label' => 'Rencana Studi', 'url' => base_url('mahasiswa/rencana-studi')],
            ['label' => 'Laporan Studi', 'url' => base_url('mahasiswa/hasil-studi')],
        ]);
    } elseif ($role === 'dosen') {
        $navItems = array_merge($navItems, [
            ['label' => 'Jadwal Mengajar', 'url' => base_url('dosen/jadwal')],
        ]);
    }

    $currentUrl = rtrim(current_url(), '/');
?>
<body>
    <header class="app-header">
        <div>
            <p class="mb-0 text-uppercase small text-white-50">Sistem Informasi Pengelolaan Akademik</p>
            <h1 class="app-title">SIPAKW</h1>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="text-end">
                <div class="fw-semibold"><?= esc(session('nama_user')); ?></div>
                <small class="text-white-50 text-uppercase"><?= esc($role ?? '-'); ?></small>
            </div>
            <a href="<?= base_url('logout'); ?>" class="btn btn-outline-light btn-sm">Keluar</a>
        </div>
    </header>

    <div class="app-shell">
        <aside class="app-sidebar">
            <p class="sidebar-heading">Menu</p>
            <?php foreach ($navItems as $item): ?>
                <?php $isActive = $currentUrl === rtrim($item['url'], '/'); ?>
                <a class="sidebar-link <?= $isActive ? 'active' : ''; ?>" href="<?= $item['url']; ?>">
                    <?= esc($item['label']); ?>
                </a>
            <?php endforeach; ?>
        </aside>

        <main class="app-content">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
            <?php endif; ?>

            <?php if ($errors = session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?= esc($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?= $this->renderSection('content'); ?>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

