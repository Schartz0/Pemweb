<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body { font-family: system-ui, sans-serif; display: grid; place-items: center; min-height: 100vh; margin: 0; background: #f5f5f5; }
        .card { background: #fff; padding: 24px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); width: 100%; max-width: 360px; }
        h1 { margin: 0 0 16px; font-size: 20px; }
        label { display: block; margin: 12px 0 6px; font-size: 14px; }
        input { width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; }
        button { width: 100%; padding: 10px 12px; border: 0; border-radius: 8px; margin-top: 16px; background: #2563eb; color: #fff; font-weight: 600; cursor: pointer; }
        .error { color: #b91c1c; font-size: 13px; margin-top: 8px; }
        .success { color: #16a34a; font-size: 13px; margin-top: 8px; }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="card">
    <h1>Login</h1>
    <form id="login-form">
        <label for="email">Email</label>
        <input id="email" name="email" type="email" required>
        <label for="password">Password</label>
        <input id="password" name="password" type="password" required>
        <button type="submit">Masuk</button>
        <div id="error" class="error" style="display:none"></div>
        <div id="success" class="success" style="display:none"></div>
        <pre id="apiResponse" style="display:none; background:#f8fafc; border:1px solid #e5e7eb; padding:10px; border-radius:8px; max-height:180px; overflow:auto"></pre>
    </form>
</div>
<script>

document.getElementById('login-form').addEventListener('submit', async function (e) {
    e.preventDefault();
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const errBox = document.getElementById('error');
    const okBox = document.getElementById('success');
    const apiBox = document.getElementById('apiResponse');
    errBox.style.display = 'none';
    errBox.textContent = '';
    okBox.style.display = 'none';
    okBox.textContent = '';
    apiBox.style.display = 'none';
    apiBox.textContent = '';

    try {
        const res = await fetch('{{ url('/api/login') }}', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'same-origin',
            body: JSON.stringify({ email, password })
        });
        const ct = res.headers.get('content-type') || '';
        const rawText = await res.clone().text().catch(()=> '');
        apiBox.textContent = rawText;
        apiBox.style.display = 'block';
        const isJson = ct.includes('application/json');
        if (!res.ok) {
            const payload = isJson ? await res.json().catch(() => ({})) : await res.text().catch(() => '');
            const msg = isJson ? (payload.message || 'Login gagal') : (payload || 'Login gagal');
            throw new Error(msg);
        }
        const data = isJson ? await res.json() : {};
        const token = data.access_token;
        if (!token) throw new Error('Token tidak ditemukan');

        window.apiToken = token;
        try { localStorage.setItem('access_token', token); } catch {}

        if (data && data.message) {
            okBox.textContent = data.message;
            okBox.style.display = 'block';
        }
        setTimeout(function(){ window.location.href = '{{ url('/') }}'; }, 500);
    } catch (err) {
        errBox.textContent = err.message;
        errBox.style.display = 'block';
    }
});
</script>
</body>
</html>

