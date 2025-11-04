<!DOCTYPE html>
<html>
<head>
    <title>Daftar Mahasiswa</title>
    <!-- @vite(['resources/css/style.css'])
    <style>
    /* Kustomisasi tambahan agar responsive dan harmonis dengan style.css */
    @media (max-width: 600px) {
        .container {padding: 0.5rem 0.1rem;}
        .table td, .table th {font-size: 0.93em;padding: 0.36em 0.2em;}
        .mb-3, .mb-4 {margin-bottom: 0.6em !important;}
        .btn {padding: 0.3em 0.7em;}
    }
    .mb-3 { margin-bottom: 1.2em; }
    .mb-4 { margin-bottom: 2em; }
    .text-center { text-align: center;}
    </style> -->
</head>
<body class="bg-light">
    <div class="container py-5">
        <h1 class="mb-4">Daftar Mahasiswa</h1>
        <div id="responseMessage"></div>
        <a href="/mahasiswa/create" class="btn btn-success mb-3">Tambah Mahasiswa</a>
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-primary">
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Semester</th>
                    <th>Jenis Kelamin</th>
                    <th>No HP</th>
                    <th>Jurusan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($mahasiswas) && count($mahasiswas)): ?>
                    <?php foreach ($mahasiswas as $mhs): ?>
                    <tr data-nim="<?= htmlspecialchars($mhs->nim) ?>">
                        <td><?= htmlspecialchars($mhs->nim) ?></td>
                        <td><?= htmlspecialchars($mhs->nama) ?></td>
                        <td><?= htmlspecialchars($mhs->semester) ?></td>
                        <td><?= htmlspecialchars($mhs->jenis_kelamin) ?></td>
                        <td><?= htmlspecialchars($mhs->no_hp) ?></td>
                        <td><?= htmlspecialchars($mhs->jurusan) ?></td>
                        <td class="action-btns">
                            <a href="/mahasiswa/<?= urlencode($mhs->nim) ?>" class="btn btn-info btn-sm">Lihat</a>
                            <a href="/mahasiswa/<?= urlencode($mhs->nim) ?>/edit" class="btn btn-warning btn-sm">Edit</a>
                            <button 
                                type="button"
                                class="btn btn-danger btn-sm btn-hapus"
                                data-nim="<?= htmlspecialchars($mhs->nim) ?>"
                            >
                                Hapus
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Data mahasiswa tidak ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <img class="promo-gif" src="/images/wowo.gif" alt="Wowo" style="max-width:2000px; display:block; margin:18px auto 0 auto;">
    </div>
    <script>
    // Efek shake dan hilang pada pesan
    function showMessage(html, isSuccess = true) {
        let el = document.getElementById('responseMessage');
        el.innerHTML = html;
        setTimeout(() => { el.innerHTML = ''; }, 3000);
    }

    document.querySelectorAll('.btn-hapus').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const nim = this.getAttribute('data-nim');
            if (!nim) return;
            if (!confirm('Yakin ingin menghapus mahasiswa ini?')) return;

            fetch('/api/mahasiswa/' + encodeURIComponent(nim), {
                method: 'DELETE',
                headers: { 'Accept': 'application/json' }
            })
            .then(async response => {
                let messageEl = document.getElementById('responseMessage');
                if (response.ok) {
                    // Hapus baris sebelum tampilkan pesan!
                    const tr = btn.closest('tr');
                    if (tr) tr.remove();
                    showMessage('<div class="alert alert-success">Mahasiswa berhasil dihapus!</div>');
                    // Periksa jika tabel kosong setelah penghapusan
                    setTimeout(() => {
                        if (document.querySelectorAll('tbody tr').length === 0) {
                            document.querySelector('tbody').innerHTML = 
                                '<tr><td colspan="7" class="text-center">Data mahasiswa tidak ditemukan.</td></tr>';
                        }
                    }, 200);
                } else {
                    let data = await response.json().catch(()=>({}));
                    let msg = data && data.message ? data.message : 'Gagal menghapus data.';
                    showMessage('<div class="alert alert-danger">' + msg + '</div>', false);
                }
            })
            .catch(() => {
                showMessage('<div class="alert alert-danger">Terjadi kesalahan jaringan.</div>', false);
            });
        });
    });
    </script>
</body>
</html>
