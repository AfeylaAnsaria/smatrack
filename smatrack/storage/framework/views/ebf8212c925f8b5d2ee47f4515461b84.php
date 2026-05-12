<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SMAtrack</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family:'Plus Jakarta Sans',sans-serif;
            min-height:100vh;
            background:#f0f4ff;
            display:flex; align-items:flex-start; justify-content:center;
            padding:20px; position:relative; overflow-x:hidden; overflow-y:auto;
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
            width:100%; max-width:560px;
            display:flex; flex-direction:column; align-items:center;
            position:relative; z-index:2;
            margin:16px 0 28px;
        }

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
        .top-section p { font-size:13px; color:#6b7a99; line-height:1.7; max-width:380px; margin:0 auto; }

        .register-box {
            width:100%;
            background:linear-gradient(145deg,#1565c0,#1976d2,#1e88e5);
            border-radius:24px;
            padding:32px 28px 28px;
            box-shadow:0 20px 60px rgba(21,101,192,0.35);
        }
        .register-box h2 { font-size:20px; font-weight:800; color:white; margin-bottom:4px; }
        .register-box .subtitle { font-size:13px; color:rgba(255,255,255,0.7); margin-bottom:24px; }

        .grid {
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:12px;
        }
        .form-group { margin-bottom:16px; }
        .form-group.full { grid-column:1 / -1; }
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

        .btn-register {
            width:100%; padding:14px; border-radius:12px; border:none;
            background:white; color:#1565c0;
            font-family:inherit; font-size:15px; font-weight:800; cursor:pointer;
            transition:all .2s; box-shadow:0 4px 16px rgba(0,0,0,0.15);
            display:flex; align-items:center; justify-content:center; gap:8px; margin-top:8px;
        }
        .btn-register:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(0,0,0,0.2); }

        .auth-switch {
            margin-top:14px;
            text-align:center;
            font-size:13px;
            color:rgba(255,255,255,0.85);
        }
        .auth-switch a {
            color:white;
            font-weight:700;
            text-decoration:underline;
            text-underline-offset:3px;
        }

        @media (max-width: 640px) {
            .wrapper { max-width:460px; }
            .grid { grid-template-columns:1fr; }
            body { padding:14px; }
            .register-box { padding:24px 18px 20px; }
        }
    </style>
</head>
<body>
<div class="wrapper">
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
        <h1>Buat Akun SMAtrack</h1>
        <p>Daftarkan akun siswa untuk mulai melihat jadwal, absensi, nilai, dan rapot digital.</p>
    </div>

    <div class="register-box">
        <h2>Form Registrasi</h2>
        <div class="subtitle">Akun baru akan dibuat sebagai siswa</div>

        <?php if($errors->any()): ?>
        <div class="error-msg">
            <i class="fas fa-exclamation-circle"></i> <?php echo e($errors->first()); ?>

        </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('register.post')); ?>">
            <?php echo csrf_field(); ?>

            <div class="grid">
                <div class="form-group full">
                    <label class="form-label">Nama Lengkap</label>
                    <div class="input-wrap">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" name="name" class="form-input" placeholder="Masukkan nama lengkap" value="<?php echo e(old('name')); ?>" required autofocus>
                    </div>
                </div>

                <div class="form-group full">
                    <label class="form-label">Email</label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" class="form-input" placeholder="email@siswa.com" value="<?php echo e(old('email')); ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">NIS (Opsional)</label>
                    <div class="input-wrap">
                        <i class="fas fa-id-card input-icon"></i>
                        <input type="text" name="nis" class="form-input" placeholder="Nomor Induk Siswa" value="<?php echo e(old('nis')); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">No. HP (Opsional)</label>
                    <div class="input-wrap">
                        <i class="fas fa-phone input-icon"></i>
                        <input type="text" name="no_hp" class="form-input" placeholder="08xxxxxxxxxx" value="<?php echo e(old('no_hp')); ?>">
                    </div>
                </div>

                <div class="form-group full">
                    <label class="form-label">Alamat (Opsional)</label>
                    <div class="input-wrap">
                        <i class="fas fa-location-dot input-icon"></i>
                        <input type="text" name="alamat" class="form-input" placeholder="Alamat domisili" value="<?php echo e(old('alamat')); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" class="form-input" placeholder="Minimal 6 karakter" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Konfirmasi Password</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password_confirmation" class="form-input" placeholder="Ulangi password" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-register">
                <i class="fas fa-user-plus"></i> Daftar Sekarang
            </button>

            <div class="auth-switch">
                Sudah punya akun? <a href="<?php echo e(route('login')); ?>">Masuk di sini</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\smatrack\resources\views/auth/register.blade.php ENDPATH**/ ?>