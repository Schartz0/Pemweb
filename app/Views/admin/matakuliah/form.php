<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>
<?php
    $isEdit = ! empty($mataKuliah);
    $action = $isEdit
        ? base_url('admin/mata-kuliah/' . $mataKuliah['id_mata_kuliah'])
        : base_url('admin/mata-kuliah');
?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><?= esc($title); ?></h5>
                <a href="<?= base_url('admin/mata-kuliah'); ?>" class="btn btn-sm btn-secondary">Kembali</a>
            </div>
            <div class="card-body">
                <form method="post" action="<?= $action; ?>">
                    <div class="mb-3">
                        <label class="form-label">Kode Mata Kuliah</label>
                        <input type="text" name="kode_mata_kuliah" class="form-control" value="<?= old('kode_mata_kuliah', $mataKuliah['kode_mata_kuliah'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Mata Kuliah</label>
                        <input type="text" name="nama_mata_kuliah" class="form-control" value="<?= old('nama_mata_kuliah', $mataKuliah['nama_mata_kuliah'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">SKS</label>
                        <input type="number" min="1" name="sks" class="form-control" value="<?= old('sks', $mataKuliah['sks'] ?? ''); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><?= $isEdit ? 'Perbarui' : 'Simpan'; ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

