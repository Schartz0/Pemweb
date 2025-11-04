<!DOCTYPE html>
<html>
<head>
    <title>Daftar Mahasiswa</title>
    <!-- <link rel="stylesheet" href="{{ asset('style.css') }}"> -->
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
                <?php
                if (isset($mahasiswas) && count($mahasiswas)):
                    foreach ($mahasiswas as $mhs):
                ?>
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
                <?php
                    endforeach;
                else:
                ?>
                <tr>
                    <td colspan="7" class="text-center">Data mahasiswa tidak ditemukan.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script>
        document.querySelectorAll('.btn-hapus').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                const nim = this.getAttribute('data-nim');
                if (!nim) return;
                if (!confirm('Yakin hapus?')) return;

                fetch('/mahasiswa/' + encodeURIComponent(nim), {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: new URLSearchParams({ _method: 'DELETE' })
                })
                .then(async response => {
                    let messageEl = document.getElementById('responseMessage');
                    if (response.ok) {
                        // Hapus baris tr lebih dulu sebelum tampilkan pesan!
                        const tr = btn.closest('tr');
                        if (tr) tr.remove();
                        messageEl.innerHTML = '<div class="alert alert-success">Mahasiswa berhasil dihapus!</div>';
                    } else {
                        let data = await response.json();
                        let msg = data && data.message ? data.message : 'Gagal menghapus data.';
                        messageEl.innerHTML = '<div class="alert alert-danger">' + msg + '</div>';
                    }
                })
                .catch(() => {
                    document.getElementById('responseMessage').innerHTML =
                        '<div class="alert alert-danger">Terjadi kesalahan jaringan.</div>';
                });
            });
        });
    </script>
</body>
</html>
