<!DOCTYPE html>
<html>
<head>
    <title>Detail Mahasiswa</title>
    <!-- <link rel="stylesheet" href="{{ asset('style.css') }}"> -->
    <meta name="api-token" content="{{ session('access_token') }}">
</head>
<body class="bg-light">
    <script>
    (function () {
        const meta = document.querySelector('meta[name="api-token"]');
        const sessionToken = meta && meta.content ? meta.content : null;
        if (sessionToken) {
            window.apiToken = sessionToken;
            try {
                localStorage.setItem('access_token', sessionToken);
            } catch (err) {
                console.warn('Tidak bisa menyimpan token ke localStorage:', err);
            }
        } else {
            try {
                window.apiToken = localStorage.getItem('access_token') || '';
            } catch (err) {
                window.apiToken = '';
            }
        }
    })();

    function withAuthHeaders(base) {
        const headers = Object.assign({}, base || {});
        if (window.apiToken) {
            headers['Authorization'] = 'Bearer ' + window.apiToken;
        }
        return headers;
    }
    </script>
    <div class="container py-5">
        <h1 class="mb-4">Detail Mahasiswa</h1>
        <table class="table table-bordered w-50">
            <tr>
                <th>NIM</th>
                <td id="nim"></td>
            </tr>
            <tr>
                <th>Nama</th>
                <td id="nama"></td>
            </tr>
            <tr>
                <th>Semester</th>
                <td id="semester"></td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td id="jenis_kelamin"></td>
            </tr>
            <tr>
                <th>No HP</th>
                <td id="no_hp"></td>
            </tr>
            <tr>
                <th>Jurusan</th>
                <td id="jurusan"></td>
            </tr>
        </table>
        <a href="/" class="btn btn-secondary">Kembali</a>
        <a id="editBtn" href="#" class="btn btn-warning">Edit</a>
        <form id="deleteForm" action="#" method="POST" style="display:inline" onsubmit="return confirm('Yakin hapus?')" class="d-inline">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
        <div class="mt-4" id="responseMessage"></div>
    </div>
    <script>
        // Mendapatkan NIM dari URL path
        function getNIMFromURL() {
            const match = window.location.pathname.match(/mahasiswa\/([^\/]+)/);
            return match ? decodeURIComponent(match[1]) : null;
        }

        const nim = getNIMFromURL();
        if (nim) {
            fetch('/api/mahasiswa/' + encodeURIComponent(nim), {
                headers: withAuthHeaders({'Accept': 'application/json'})
            })
            .then(async response => {
                if (response.ok) {
                    const data = await response.json();
                    document.getElementById('nim').textContent = data.nim || '-';
                    document.getElementById('nama').textContent = data.nama || '-';
                    document.getElementById('semester').textContent = data.semester || '-';
                    document.getElementById('jenis_kelamin').textContent = data.jenis_kelamin || '-';
                    document.getElementById('no_hp').textContent = data.no_hp || '-';
                    document.getElementById('jurusan').textContent = data.jurusan || '-';

                    document.getElementById('editBtn').href = "/mahasiswa/" + encodeURIComponent(data.nim) + "/edit";
                    document.getElementById('deleteForm').action = "/mahasiswa/" + encodeURIComponent(data.nim);
                } else {
                    document.getElementById('responseMessage').innerHTML = '<div class="alert alert-danger">Mahasiswa tidak ditemukan.</div>';
                }
            })
            .catch(() => {
                document.getElementById('responseMessage').innerHTML = '<div class="alert alert-danger">Gagal mengambil data.</div>';
            });
        } else {
            document.getElementById('responseMessage').innerHTML = '<div class="alert alert-danger">NIM tidak valid.</div>';
        }

        // Ajax delete (opsional: reload/redirect setelah hapus)
        document.getElementById('deleteForm').addEventListener('submit', function(e) {
            e.preventDefault();
            fetch('/api/mahasiswa/' + encodeURIComponent(nim), {
                method: 'DELETE',
                headers: withAuthHeaders({
                    'Accept': 'application/json'
                })
            })
            .then(async response => {
                if (response.ok) {
                    document.getElementById('responseMessage').innerHTML = '<div class="alert alert-success">Mahasiswa berhasil dihapus!</div>';
                    setTimeout(() => window.location.href = '/', 1200);
                } else {
                    let data = await response.json();
                    let msg = data.message || 'Gagal menghapus.';
                    document.getElementById('responseMessage').innerHTML = '<div class="alert alert-danger">' + msg + '</div>';
                }
            })
            .catch(() => {
                document.getElementById('responseMessage').innerHTML = '<div class="alert alert-danger">Gagal menghapus (jaringan).</div>';
            });
        });
    </script>
</body>
</html>
