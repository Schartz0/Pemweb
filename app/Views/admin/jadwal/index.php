<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>
<?php
    $isEdit = ! empty($editData);
    $action = $isEdit ? base_url('admin/jadwal/' . $editData['id']) : base_url('admin/jadwal');
?>
<div class="row">
    <div class="col-lg-5">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><?= $isEdit ? 'Edit Jadwal' : 'Tambah Jadwal'; ?></h5>
                <?php if ($isEdit): ?>
                    <a href="<?= base_url('admin/jadwal'); ?>" class="btn btn-sm btn-secondary">Batal</a>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <form method="post" action="<?= $action; ?>">
                    <div class="mb-3">
                        <label class="form-label">Nama Kelas</label>
                        <input type="text" name="nama_kelas" class="form-control" value="<?= old('nama_kelas', $editData['nama_kelas'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mata Kuliah</label>
                        <select class="form-select" name="id_mata_kuliah" required>
                            <option value="">-- Pilih --</option>
                            <?php foreach ($mataKuliah as $mk): ?>
                                <option value="<?= $mk['id_mata_kuliah']; ?>" <?= (old('id_mata_kuliah', $editData['id_mata_kuliah'] ?? '') == $mk['id_mata_kuliah']) ? 'selected' : ''; ?>>
                                    <?= esc($mk['nama_mata_kuliah']); ?> (<?= $mk['sks']; ?> SKS)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ruangan</label>
                        <select class="form-select" name="id_ruangan" required>
                            <option value="">-- Pilih --</option>
                            <?php foreach ($ruangan as $rg): ?>
                                <option value="<?= $rg['id_ruangan']; ?>" <?= (old('id_ruangan', $editData['id_ruangan'] ?? '') == $rg['id_ruangan']) ? 'selected' : ''; ?>>
                                    <?= esc($rg['nama_ruangan']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dosen (NIDN)</label>
                        <select class="form-select" name="nidn" required>
                            <option value="">-- Pilih --</option>
                            <?php foreach ($dosen as $ds): ?>
                                <option value="<?= $ds['nidn']; ?>" <?= (old('nidn', $editData['nidn'] ?? '') == $ds['nidn']) ? 'selected' : ''; ?>>
                                    <?= esc($ds['nama']); ?> (<?= esc($ds['nidn']); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Hari</label>
                            <input type="text" name="hari" class="form-control" value="<?= old('hari', $editData['hari'] ?? ''); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jam</label>
                            <input type="text" name="jam" class="form-control" value="<?= old('jam', $editData['jam'] ?? ''); ?>" placeholder="07:30 - 09:10" required>
                        </div>
                    </div>
                    <button class="btn btn-primary w-100" type="submit"><?= $isEdit ? 'Perbarui' : 'Simpan'; ?></button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Daftar Jadwal</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Kelas</th>
                            <th>Mata Kuliah</th>
                            <th>Ruangan</th>
                            <th>Dosen</th>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jadwal as $row): ?>
                            <tr>
                                <td><?= esc($row['nama_kelas']); ?></td>
                                <td><?= esc($row['nama_mata_kuliah']); ?></td>
                                <td><?= esc($row['nama_ruangan']); ?></td>
                                <td><?= esc($row['nama_dosen']); ?></td>
                                <td><?= esc($row['hari']); ?></td>
                                <td><?= esc($row['jam']); ?></td>
                                <td>
                                    <a href="<?= base_url('admin/jadwal?edit=' . $row['id']); ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="<?= base_url('admin/jadwal/' . $row['id'] . '/delete'); ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus jadwal ini?');">
                                        <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
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

