<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0">Input Nilai - <?= esc($jadwal['nama_kelas']); ?></h5>
            <small class="text-muted"><?= esc($jadwal['hari']); ?>, <?= esc($jadwal['jam']); ?></small>
        </div>
        <a href="<?= base_url('dosen/jadwal'); ?>" class="btn btn-sm btn-secondary">Kembali</a>
    </div>
    <div class="card-body">
        <?php if (empty($peserta)): ?>
            <p>Tidak ada mahasiswa pada jadwal ini.</p>
        <?php else: ?>
            <form method="post" action="<?= base_url('dosen/jadwal/' . $jadwal['id'] . '/nilai'); ?>">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Nilai Angka</th>
                                <th>Nilai Huruf</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($peserta as $row): ?>
                                <tr>
                                    <td><?= esc($row['nim']); ?></td>
                                    <td><?= esc($row['nama']); ?></td>
                                    <td>
                                        <input type="number" name="nilai[<?= $row['id_rencana_studi']; ?>][nilai_angka]" class="form-control" value="<?= esc($row['nilai_angka'] ?? ''); ?>" step="0.01" min="0" max="100">
                                    </td>
                                    <td>
                                        <select name="nilai[<?= $row['id_rencana_studi']; ?>][nilai_huruf]" class="form-select">
                                            <option value="">-</option>
                                            <?php foreach ($nilai_mutu as $mutu): ?>
                                                <?php $selected = ($row['nilai_huruf'] ?? '') === $mutu['nilai_huruf']; ?>
                                                <option value="<?= esc($mutu['nilai_huruf']); ?>" <?= $selected ? 'selected' : ''; ?>>
                                                    <?= esc($mutu['nilai_huruf']); ?> (<?= esc($mutu['nilai_mutu']); ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <button class="btn btn-primary" type="submit">Simpan Nilai</button>
            </form>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection(); ?>

