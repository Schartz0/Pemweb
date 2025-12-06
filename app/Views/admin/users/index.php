<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0"><?= esc($title); ?></h4>
    <a href="<?= base_url('admin/users/create'); ?>" class="btn btn-primary">Tambah User</a>
</div>

<form method="get" action="<?= base_url('admin/users'); ?>" class="d-flex align-items-center gap-2 mb-3">
    <label for="role" class="form-label mb-0">Filter Role:</label>
    <select name="role" id="role" class="form-select w-auto" onchange="this.form.submit()">
        <option value="" <?= empty($selectedRole) ? 'selected' : '' ?>>Semua</option>
        <option value="admin" <?= isset($selectedRole) && $selectedRole === 'admin' ? 'selected' : '' ?>>Admin</option>
        <option value="dosen" <?= isset($selectedRole) && $selectedRole === 'dosen' ? 'selected' : '' ?>>Dosen</option>
        <option value="mahasiswa" <?= isset($selectedRole) && $selectedRole === 'mahasiswa' ? 'selected' : '' ?>>Mahasiswa</option>
    </select>
</form>

<div class="table-responsive">
    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Nama User</th>
                <th>Role</th>
                <th>Kode Peran</th>
                <th>Nama Peran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $index => $user): ?>
                <tr>
                    <td><?= $index + 1; ?></td>
                    <td><?= esc($user['nama_user']); ?></td>
                    <td><span class="badge bg-info text-uppercase"><?= esc($user['role']); ?></span></td>
                    <td><?= esc($user['kode_peran']); ?></td>
                    <td><?= esc($user['nama_peran'] ?? '-'); ?></td>
                    <td>
                        <a href="<?= base_url('admin/users/' . $user['id_user'] . '/edit'); ?>" class="btn btn-sm btn-warning">Edit</a>
                        <form action="<?= base_url('admin/users/' . $user['id_user'] . '/delete'); ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus user ini?');">
                            <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection(); ?>

