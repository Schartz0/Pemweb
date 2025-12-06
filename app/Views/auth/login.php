<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem Akademik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: url("<?= base_url('bg.png'); ?>") no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-box {
            width: 430px;
            background: #ffffffd9;
            border-radius: 12px;
            padding: 35px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            text-align: center;
            backdrop-filter: blur(5px);
        }
        .login-logo img {
            width: 85px;
            margin-bottom: 15px;
        }
        .btn-login {
            background-color: #FFC107;
            border: none;
            color: #000;
            font-weight: bold;
        }
        .btn-login:hover {
            background-color: #e0a800;
        }
    </style>
</head>
<body>

<div class="login-box">
    <div class="login-logo">
        <img src="<?= base_url('favicon.png'); ?>" alt="Logo"/>
        <h4><b>Single Sign On</b></h4>
    </div>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
    <?php endif; ?>

    <form action="<?= base_url('loginProcess'); ?>" method="post">
        <div class="mb-3 text-start">
            <label class="form-label">User Name</label>
            <input type="text" name="nama_user" class="form-control" placeholder="Masukkan User Name" required>
        </div>

        <div class="mb-3 text-start">
            <label class="form-label">Kata Sandi</label>
            <input type="password" name="password" class="form-control" placeholder="Masukkan Kata Sandi" required>
        </div>

        <button type="submit" class="btn btn-login w-100 mt-3">Masuk</button>

        <div class="mt-3">
            <a href="#" class="small">Lupa Password?</a>
        </div>
    </form>
</div>

</body>
</html>
