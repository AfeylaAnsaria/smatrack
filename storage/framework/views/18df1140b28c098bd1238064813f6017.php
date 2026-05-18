<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SMAtrack</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family:'Plus Jakarta Sans',sans-serif;
            min-height:100vh;
            background:#f0f4ff;
            display:flex; align-items:center; justify-content:center;
            padding:20px; position:relative; overflow:hidden;
        }
        body::before {
            content:''; position:absolute; top:-100px; right:-100px;
            width:400px; height:400px; border-radius:50%;
            background:rgba(25,118,210,0.06);
        }
        body::after {
            content:''; position:absolute; bottom:-150px; left:-80px;
            width:500px; height:500px; border-radius:50%;
            background:rgba(25,118,210,0.04);
        }
        .wrapper {
            width:100%; max-width:440px;
            display:flex; flex-direction:column; align-items:center;
            position:relative; z-index:2;
        }

        /* Top: logo + teks */
        .top-section { text-align:center; margin-bottom:24px; }
        .logo-wrap {
            width:88px; height:88px; border-radius:22px;
            background:white; display:flex; align-items:center; justify-content:center;
            margin:0 auto 16px;
            box-shadow:0 8px 32px rgba(25,118,210,0.18);
            overflow:hidden; border:3px solid #e3eaf5;
        }
        .logo-wrap img { width:100%; height:100%; object-fit:cover; border-radius:20px; }
        .logo-wrap .logo-fallback { font-size:38px; }
        .top-section h1 { font-size:26px; font-weight:800; color:#1a2744; margin-bottom:8px; }
        .top-section p { font-size:13px; color:#6b7a99; line-height:1.7; max-width:340px; margin:0 auto; }

        /* Login box — BIRU */
        .login-box {
            width:100%;
            background:linear-gradient(145deg,#1565c0,#1976d2,#1e88e5);
            border-radius:24px;
            padding:32px 28px 28px;
            box-shadow:0 20px 60px rgba(21,101,192,0.35);
        }
        .login-box h2 { font-size:20px; font-weight:800; color:white; margin-bottom:4px; }
        .login-box .subtitle { font-size:13px; color:rgba(255,255,255,0.7); margin-bottom:24px; }

        .form-group { margin-bottom:16px; }
        .form-label { display:block; font-size:13px; font-weight:600; color:rgba(255,255,255,0.9); margin-bottom:7px; }
        .input-wrap { position:relative; }
        .input-icon {
            position:absolute; left:14px; top:50%;
            transform:translateY(-50%); color:#1976d2; font-size:14px;
        }
        .form-input {
            width:100%; padding:12px 14px 12px 40px; border-radius:12px;
            border:2px solid transparent; background:white;
            font-family:inherit; font-size:14px; color:#1a2744;
            transition:all .2s; outline:none;
        }
        .form-input:focus {
            border-color:#90caf9;
            box-shadow:0 0 0 4px rgba(144,202,249,0.25);
        }
        .form-input::placeholder { color:#b0bccc; }

        .error-msg {
            background:rgba(255,255,255,0.15);
            border:1px solid rgba(255,255,255,0.3);
            color:white;
            padding:10px 14px; border-radius:10px; font-size:13px;
            margin-bottom:16px; display:flex; align-items:center; gap:8px;
        }

        .btn-login {
            width:100%; padding:14px; border-radius:12px; border:none;
            background:white; color:#1565c0;
            font-family:inherit; font-size:15px; font-weight:800; cursor:pointer;
            transition:all .2s; box-shadow:0 4px 16px rgba(0,0,0,0.15);
            display:flex; align-items:center; justify-content:center; gap:8px; margin-top:8px;
        }
        .btn-login:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(0,0,0,0.2); }

        /* Demo box */
        .demo-box {
            width:100%; background:white; border-radius:20px;
            padding:20px 24px; margin-top:16px;
            box-shadow:0 4px 20px rgba(25,118,210,0.1);
            border:1px solid #e3eaf5;
        }
        .demo-label { font-size:12px; color:#6b7a99; text-align:center; margin-bottom:14px; font-weight:500; }
        .demo-cards { display:grid; grid-template-columns:1fr 1fr 1fr; gap:10px; }
        .demo-card {
            background:#f0f4ff; border:1.5px solid #dce8fa;
            border-radius:14px; padding:14px 10px; text-align:center;
            cursor:pointer; transition:all .2s;
        }
        .demo-card:hover { background:#e3eeff; border-color:#90caf9; transform:translateY(-2px); box-shadow:0 4px 12px rgba(25,118,210,0.15); }
        .demo-card .icon { font-size:26px; margin-bottom:6px; }
        .demo-card .label { font-size:12px; font-weight:700; color:#1565c0; }
        .demo-card .email { font-size:10px; color:#6b7a99; margin-top:2px; word-break:break-all; }
    </style>
</head>
<body>
<div class="wrapper">

    <!-- Logo + Judul + Deskripsi -->
    <div class="top-section">
        <div class="logo-wrap">
            <?php if(file_exists(public_path('logo.jpg'))): ?>
                <img src="<?php echo e(asset('logo.jpg')); ?>" alt="Logo">
            <?php elseif(file_exists(public_path('logo.png'))): ?>
                <img src="<?php echo e(asset('logo.png')); ?>" alt="Logo">
            <?php else: ?>
                <span class="logo-fallback">🎀</span>
            <?php endif; ?>
        </div>
        <h1>Selamat Datang di SMAtrack</h1>
        <p>Platform akademik modern untuk siswa, guru, dan admin SMA. Kelola absensi, nilai, jadwal & lebih banyak lagi!</p>
    </div>

    <!-- Box Login BIRU -->
    <div class="login-box">
        <h2>Masuk ke Akun</h2>
        <div class="subtitle">Gunakan email atau username siswa dan password yang diberikan admin</div>

        <?php if($errors->any()): ?>
        <div class="error-msg">
            <i class="fas fa-exclamation-circle"></i> <?php echo e($errors->first()); ?>

        </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('login.post')); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label class="form-label">Email / Username</label>
                <div class="input-wrap">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="text" name="login" class="form-input"
                        placeholder="contoh: tanti.12 atau tanti.12@siswa.com"
                        value="<?php echo e(old('login')); ?>" required autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-wrap">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="password" id="pwd"
                        class="form-input" placeholder="Masukkan password" required>
                </div>
            </div>
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Masuk Sekarang
            </button>
        </form>
    </div>

    <!-- 3 Demo Cards -->
    <div class="demo-box">
        <div class="demo-label">✨ Klik untuk isi otomatis (demo)</div>
        <div class="demo-cards">
            <div class="demo-card" onclick="fillLogin('admin@smatrack.com')">
                <div class="icon">👑</div>
                <div class="label">Admin</div>
                <div class="email">admin@smatrack.com</div>
            </div>
            <div class="demo-card" onclick="fillLogin('budi@guru.smatrack.com')">
                <div class="icon">👨‍🏫</div>
                <div class="label">Guru</div>
                <div class="email">budi@guru.smatrack.com</div>
            </div>
            <div class="demo-card" onclick="fillLogin('dimas.12@siswa.com')">
                <div class="icon">🎓</div>
                <div class="label">Siswa XII</div>
                <div class="email">dimas.12@siswa.com</div>
            </div>
        </div>
    </div>

</div>
<script>
function fillLogin(loginValue) {
    document.querySelector('input[name="login"]').value = loginValue;
    document.getElementById('pwd').value = 'password';
}
</script>
</body>
</html><?php /**PATH C:\xampp\htdocs\smatrack\resources\views/auth/login.blade.php ENDPATH**/ ?>