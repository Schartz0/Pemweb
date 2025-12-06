<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Jadwal Mengajar</h5>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Kelas</th>
                    <th>Mata Kuliah</th>
                    <th>SKS</th>
                    <th>Ruangan</th>
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
                        <td><?= esc($row['sks']); ?></td>
                        <td><?= esc($row['nama_ruangan']); ?></td>
                        <td><?= esc($row['hari']); ?></td>
                        <td><?= esc($row['jam']); ?></td>
                        <td>
                            <a href="<?= base_url('dosen/jadwal/' . $row['id'] . '/nilai'); ?>" class="btn btn-sm btn-primary">Isi Nilai</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection(); ?>

