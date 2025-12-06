<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>
<?php
    $sudahDiambil = array_column($rencana, 'id_jadwal');
?>
<div class="row">
    <div class="col-lg-7">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Daftar Jadwal Tersedia</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Kelas</th>
                            <th>Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jadwal as $row): ?>
                            <?php $sudah = in_array($row['id'], $sudahDiambil); ?>
                            <tr>
                                <td><?= esc($row['nama_kelas']); ?></td>
                                <td><?= esc($row['nama_mata_kuliah']); ?></td>
                                <td><?= esc($row['sks']); ?></td>
                                <td><?= esc($row['hari']); ?></td>
                                <td><?= esc($row['jam']); ?></td>
                                <td>
                                    <?php if ($sudah): ?>
                                        <span class="badge bg-success">Sudah diambil</span>
                                    <?php else: ?>
                                        <form method="post" action="<?= base_url('mahasiswa/rencana-studi'); ?>">
                                            <input type="hidden" name="id_jadwal" value="<?= $row['id']; ?>">
                                            <button class="btn btn-sm btn-primary" type="submit">Ambil</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Rencana Studiku</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rencana as $item): ?>
                            <tr>
                                <td><?= esc($item['nama_mata_kuliah']); ?></td>
                                <td><?= esc($item['sks']); ?></td>
                                <td>
                                    <form method="post" action="<?= base_url('mahasiswa/rencana-studi/' . $item['id_rencana_studi'] . '/delete'); ?>" onsubmit="return confirm('Hapus dari rencana?');">
                                        <button class="btn btn-sm btn-outline-danger" type="submit">Batalkan</button>
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

