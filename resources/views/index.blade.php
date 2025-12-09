<!DOCTYPE html>
<html>
<head>
    <title>Daftar Mahasiswa</title>
    <!-- @vite(['resources/css/style.css']) -->
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
    </style>
</head>
<body class="bg-light">
    <script>
    function getToken() {
        try { return localStorage.getItem('access_token') || ''; } catch (e) { return ''; }
    }

    function withAuthHeaders(base) {
        const headers = Object.assign({}, base || {});
        const t = getToken();
        if (t) headers['Authorization'] = 'Bearer ' + t;
        return headers;
    }
    </script>
    <div class="container py-5">
        <h1 class="mb-4">Daftar Mahasiswa</h1>
        <button id="btnLogout" class="btn btn-secondary mb-3 float-end" style="margin-top:-16px;">Logout</button>
        <script>
        document.getElementById('btnLogout').addEventListener('click', function() {
            fetch('/api/logout', {
                method: 'POST',
                headers: withAuthHeaders({ 'Accept': 'application/json' })
            })
            .then(() => {
                try { localStorage.removeItem('access_token'); } catch {}
                window.location.href = '/login';
            })
            .catch(() => {
                alert('Logout gagal. Silakan refresh halaman.');
            });
        });
        </script>
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
            <tbody id="tbody"></tbody>
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

    async function loadMahasiswa() {
        const tbody = document.getElementById('tbody');
        tbody.innerHTML = '<tr><td colspan="7" class="text-center">Memuat...</td></tr>';
        try {
            const res = await fetch('/api/mahasiswa', { headers: withAuthHeaders({ 'Accept':'application/json' }) });
            const ct = res.headers.get('content-type') || '';
            const isJson = ct.includes('application/json');
            if (!res.ok) {
                const payload = isJson ? await res.json().catch(()=>({})) : await res.text().catch(()=> '');
                const msg = isJson ? (payload.message || 'Gagal memuat data') : (payload || 'Gagal memuat data');
                tbody.innerHTML = '<tr><td colspan="7" class="text-center">'+msg+'</td></tr>';
                return;
            }
            const list = isJson ? await res.json() : [];
            if (!Array.isArray(list) || list.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" class="text-center">Data mahasiswa tidak ditemukan.</td></tr>';
                return;
            }
            tbody.innerHTML = list.map(function(m){
                const nim = String(m.nim || '');
                const nama = String(m.nama || '');
                const semester = String(m.semester ?? '');
                const jk = String(m.jenis_kelamin || '');
                const nohp = String(m.no_hp || '');
                const jurusan = String(m.jurusan || '');
                return (
                    '<tr data-nim="'+encodeURIComponent(nim)+'">'
                    +'<td>'+escapeHtml(nim)+'</td>'
                    +'<td>'+escapeHtml(nama)+'</td>'
                    +'<td>'+escapeHtml(semester)+'</td>'
                    +'<td>'+escapeHtml(jk)+'</td>'
                    +'<td>'+escapeHtml(nohp)+'</td>'
                    +'<td>'+escapeHtml(jurusan)+'</td>'
                    +'<td class="action-btns">'
                        +'<a href="/mahasiswa/'+encodeURIComponent(nim)+'" class="btn btn-info btn-sm">Lihat</a> '
                        +'<a href="/mahasiswa/'+encodeURIComponent(nim)+'/edit" class="btn btn-warning btn-sm">Edit</a> '
                        +'<button type="button" class="btn btn-danger btn-sm btn-hapus" data-nim="'+escapeAttr(nim)+'">Hapus</button>'
                    +'</td>'
                    +'</tr>'
                );
            }).join('');

            bindDeleteButtons();
        } catch (e) {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center">Terjadi kesalahan jaringan.</td></tr>';
        }
    }

    function bindDeleteButtons() {
        document.querySelectorAll('.btn-hapus').forEach(function(btn){
            btn.addEventListener('click', async function(){
                const nim = this.getAttribute('data-nim');
                if (!nim) return;
                if (!confirm('Yakin ingin menghapus mahasiswa ini?')) return;
                try {
                    const res = await fetch('/api/mahasiswa/'+encodeURIComponent(nim), {
                        method: 'DELETE',
                        headers: withAuthHeaders({ 'Accept':'application/json' }),
                    });
                    const ct = res.headers.get('content-type') || '';
                    const isJson = ct.includes('application/json');
                    if (res.ok) {
                        const tr = btn.closest('tr');
                        if (tr) tr.remove();
                        showMessage('<div class="alert alert-success">Mahasiswa berhasil dihapus!</div>');
                        if (document.querySelectorAll('tbody tr').length === 0) {
                            document.getElementById('tbody').innerHTML = '<tr><td colspan="7" class="text-center">Data mahasiswa tidak ditemukan.</td></tr>';
                        }
                    } else {
                        const payload = isJson ? await res.json().catch(()=>({})) : await res.text().catch(()=> '');
                        const msg = isJson ? (payload.message || 'Gagal menghapus data.') : (payload || 'Gagal menghapus data.');
                        showMessage('<div class="alert alert-danger">'+msg+'</div>', false);
                    }
                } catch (e) {
                    showMessage('<div class="alert alert-danger">Terjadi kesalahan jaringan.</div>', false);
                }
            });
        });
    }

    function escapeHtml(s){
        return String(s).replace(/[&<>"]/g, function(c){ return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'})[c]; });
    }
    function escapeAttr(s){
        return String(s).replace(/"/g, '&quot;');
    }

    loadMahasiswa();
    </script>
</body>
</html>
