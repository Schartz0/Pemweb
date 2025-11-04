<!DOCTYPE html>
<html>
<head>
    <title>Tambah Mahasiswa</title>
    <!-- <link rel="stylesheet" href="{{ asset('style.css') }}"> -->
</head>
<body class="bg-light">
    <div class="container py-5">
        <h1 class="mb-4">Form Tambah Mahasiswa</h1>
        <form id="mahasiswaForm">
            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" id="nim" name="nim" class="form-control" maxlength="15" required>
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
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="/" class="btn btn-secondary">Batal</a>
        </form>
        <div class="mt-4" id="responseMessage"></div>
    </div>
    <script>
    document.getElementById('mahasiswaForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);

        fetch('/mahasiswa', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(async response => {
            let data = await response.json();
            if (response.ok) {
                document.getElementById('responseMessage').innerHTML =
                    `<div class="alert alert-success">Mahasiswa berhasil ditambahkan!</div>`;
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