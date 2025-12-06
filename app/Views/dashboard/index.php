<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>
<div class="mb-4">
    <div class="p-4 bg-white rounded-4 shadow-sm d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <p class="mb-1 text-uppercase text-muted small">Tahun Ajaran Aktif</p>
            <h4 class="mb-2">2025 / 2026 - Semester Ganjil</h4>
            <p class="mb-0 text-muted">Hai, <?= esc($namaLengkap); ?> <span class="text-primary">|</span> <?= esc($kodePeran ?? '-'); ?></p>
        </div>
        <div class="text-end mt-3 mt-md-0">
            <span class="badge bg-primary fs-6"><?= strtoupper(esc($role)); ?></span>
            <p class="text-muted mb-0 mt-2">Selamat menggunakan SIPAKW</p>
        </div>
    </div>
</div>

<?php if (empty($links)): ?>
    <div class="alert alert-info">Belum ada tautan fitur khusus untuk rolenya.</div>
<?php else: ?>
    <div class="row g-3">
        <?php foreach ($links as $link): ?>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <p class="text-muted small mb-1">Menu</p>
                            <h5><?= esc($link['label']); ?></h5>
                        </div>
                        <a href="<?= esc($link['url']); ?>" class="btn btn-primary btn-sm align-self-start mt-3">Buka</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?= $this->endSection(); ?>

