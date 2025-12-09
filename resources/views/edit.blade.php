<!DOCTYPE html>
<html>
<head>
    <title>Edit Mahasiswa</title>
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
        <h1 class="mb-4">Edit Mahasiswa</h1>
        <form id="editMahasiswaForm">
            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" id="nim" name="nim" class="form-control" maxlength="15" readonly>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" id="nama" name="nama" class="form-control" maxlength="100" required>
            </div>
            <div class="mb-3">
                <label for="semester" class="form-label">Semester</label>
                <input type="number" id="semester" name="semester" class="form-control" min="1" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <select id="jenis_kelamin" name="jenis_kelamin" class="form-control" required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="no_hp" class="form-label">No HP</label>
                <input type="text" id="no_hp" name="no_hp" class="form-control" maxlength="20" required>
            </div>
            <div class="mb-3">
                <label for="jurusan" class="form-label">Jurusan</label>
                <input type="text" id="jurusan" name="jurusan" class="form-control" maxlength="50" required>
            </div>
            <button type="submit" class="btn btn-warning">Update</button>
            <a href="/" class="btn btn-secondary">Batal</a>
        </form>
        <div class="mt-4" id="responseMessage"></div>
    </div>
    <script>
    // Mendapatkan NIM dari URL path
    function getNIMFromURL() {
        const pathSegments = window.location.pathname.split('/');
        // Format: /mahasiswa/{nim}/edit
        const nimIndex = pathSegments.indexOf('mahasiswa');
        if (nimIndex !== -1 && pathSegments[nimIndex + 1]) {
            return decodeURIComponent(pathSegments[nimIndex + 1]);
        }
        return null;
    }

    const nim = getNIMFromURL();
    
    // Fetch data mahasiswa untuk prefill form
    if (nim) {
        fetch('/api/mahasiswa/' + encodeURIComponent(nim), {
            headers: withAuthHeaders({'Accept': 'application/json'})
        })
        .then(async response => {
            if (response.ok) {
                const data = await response.json();
                document.getElementById('nim').value = data.nim || '';
                document.getElementById('nama').value = data.nama || '';
                document.getElementById('semester').value = data.semester || '';
                document.getElementById('jenis_kelamin').value = data.jenis_kelamin || '';
                document.getElementById('no_hp').value = data.no_hp || '';
                document.getElementById('jurusan').value = data.jurusan || '';
            } else {
                document.getElementById('responseMessage').innerHTML = 
                    '<div class="alert alert-danger">Gagal mengambil data mahasiswa.</div>';
            }
        })
        .catch(() => {
            document.getElementById('responseMessage').innerHTML = 
                '<div class="alert alert-danger">Terjadi kesalahan jaringan.</div>';
        });
    } else {
        document.getElementById('responseMessage').innerHTML = 
            '<div class="alert alert-danger">NIM tidak valid.</div>';
    }

    // Handle form submit
    document.getElementById('editMahasiswaForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = e.target;
        const payload = {
            nama: document.getElementById('nama').value,
            semester: Number(document.getElementById('semester').value),
            jenis_kelamin: document.getElementById('jenis_kelamin').value,
            no_hp: document.getElementById('no_hp').value,
            jurusan: document.getElementById('jurusan').value,
        };

        fetch('/api/mahasiswa/' + encodeURIComponent(nim), {
            method: 'PUT',
            headers: withAuthHeaders({
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }),
            body: JSON.stringify(payload)
        })
        .then(async response => {
            let data = await response.json();
            if (response.ok) {
                document.getElementById('responseMessage').innerHTML =
                    `<div class="alert alert-success">Mahasiswa berhasil diupdate!</div>`;
                setTimeout(() => {
                    window.location.href = '/';
                }, 1200);
            } else {
                let msg = '<div class="alert alert-danger"><ul>';
                if (data.errors) {
                    for (const key in data.errors) {
                        msg += `<li>${data.errors[key][0]}</li>`;
                    }
                } else if (data.message) {
                    msg += `<li>${data.message}</li>`;
                } else {
                    msg += '<li>Terjadi kesalahan.</li>';
                }
                msg += '</ul></div>';
                document.getElementById('responseMessage').innerHTML = msg;
            }
        })
        .catch(() => {
            document.getElementById('responseMessage').innerHTML =
                '<div class="alert alert-danger">Terjadi kesalahan jaringan.</div>';
        });
    });
    </script>
</body>
</html>
