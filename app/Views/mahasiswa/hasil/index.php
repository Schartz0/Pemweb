<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><?= esc($title); ?></h5>
        <div>
            <span class="badge bg-primary me-2">Total SKS: <?= $total_sks; ?></span>
            <span class="badge bg-success">IPK: <?= number_format($ipk, 2); ?></span>
        </div>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Mata Kuliah</th>
                    <th>SKS</th>
                    <th>Nilai Angka</th>
                    <th>Nilai Huruf</th>
                    <th>Nilai Mutu</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hasil as $row): ?>
                    <tr>
                        <td><?= esc($row['nama_mata_kuliah']); ?></td>
                        <td><?= esc($row['sks']); ?></td>
                        <td><?= esc($row['nilai_angka'] ?? '-'); ?></td>
                        <td><?= esc($row['nilai_huruf'] ?? '-'); ?></td>
                        <td><?= esc($row['nilai_mutu'] ?? '-'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection(); ?>

