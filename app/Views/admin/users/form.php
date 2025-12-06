<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>
<?php
    $isEdit = isset($user);
    $action = $isEdit ? base_url('admin/users/' . $user['id_user']) : base_url('admin/users');
    $methodLabel = $isEdit ? 'Perbarui' : 'Simpan';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><?= esc($title); ?></h5>
                <a href="<?= base_url('admin/users'); ?>" class="btn btn-sm btn-secondary">Kembali</a>
            </div>
            <div class="card-body">
                <form method="post" action="<?= $action; ?>">
                    <div class="mb-3">
                        <label class="form-label">Nama User</label>
                        <input type="text" name="nama_user" class="form-control" value="<?= old('nama_user', $user['nama_user'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password <?= $isEdit ? '(kosongkan bila tidak diubah)' : ''; ?></label>
                        <input type="password" name="password" class="form-control" <?= $isEdit ? '' : 'required'; ?>>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <?php
                                $roles = ['admin' => 'Admin', 'mahasiswa' => 'Mahasiswa', 'dosen' => 'Dosen'];
                                $selectedRole = old('role', $user['role'] ?? 'admin');
                            ?>
                            <?php foreach ($roles as $key => $label): ?>
                                <option value="<?= $key; ?>" <?= $selectedRole === $key ? 'selected' : ''; ?>><?= $label; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kode Peran (NIM/NIDN)</label>
                        <input type="text" name="kode_peran" class="form-control" value="<?= old('kode_peran', $user['kode_peran'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_peran" class="form-control" value="<?= old('nama_peran', $nama_peran ?? ''); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><?= $methodLabel; ?></button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

