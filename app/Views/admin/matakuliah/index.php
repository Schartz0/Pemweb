<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>
<?php
    $isEdit = ! empty($editData); // cek apakah ada data untuk diedit
    $action = $isEdit 
        ? base_url('admin/mata-kuliah/' . $editData['id_mata_kuliah']) 
        : base_url('admin/mata-kuliah');
?>
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><?= $isEdit ? 'Edit Mata Kuliah' : 'Tambah Mata Kuliah'; ?></h5>
                <?php if ($isEdit): ?>
                    <a href="<?= base_url('admin/mata-kuliah'); ?>" class="btn btn-sm btn-secondary">Batal</a>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <form method="post" action="<?= $action; ?>">
                    <div class="mb-3">
                        <label class="form-label">Kode</label>
                        <input type="text" name="kode_mata_kuliah" class="form-control" 
                               value="<?= old('kode_mata_kuliah', $editData['kode_mata_kuliah'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Mata Kuliah</label>
                        <input type="text" name="nama_mata_kuliah" class="form-control" 
                               value="<?= old('nama_mata_kuliah', $editData['nama_mata_kuliah'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">SKS</label>
                        <input type="number" name="sks" class="form-control" min="1" 
                               value="<?= old('sks', $editData['sks'] ?? ''); ?>" required>
                    </div>
                    <button class="btn btn-primary w-100" type="submit"><?= $isEdit ? 'Perbarui' : 'Simpan'; ?></button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode</th>
                            <th>Nama Mata Kuliah</th>
                            <th>SKS</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mataKuliah as $index => $mk): ?>
                            <tr>
                                <td><?= $index + 1; ?></td>
                                <td><?= esc($mk['kode_mata_kuliah']); ?></td>
                                <td><?= esc($mk['nama_mata_kuliah']); ?></td>
                                <td><?= esc($mk['sks']); ?></td>
                                <td class="text-end">
                                    <a href="<?= base_url('admin/mata-kuliah?edit=' . $mk['id_mata_kuliah']); ?>" 
                                       class="btn btn-sm btn-warning">Edit</a>
                                    <form action="<?= base_url('admin/mata-kuliah/' . $mk['id_mata_kuliah'] . '/delete'); ?>" 
                                          method="post" class="d-inline" 
                                          onsubmit="return confirm('Hapus mata kuliah ini?');">
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
