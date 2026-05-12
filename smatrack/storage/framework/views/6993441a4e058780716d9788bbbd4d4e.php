<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'SMAtrack'); ?> — Sistem Akademik SMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --blue-50: #e3f0ff;
            --blue-100: #c5dbff;
            --blue-200: #90bbff;
            --blue-300: #5a99ff;
            --blue-400: #2979ff;
            --blue-500: #1565c0;
            --blue-600: #0d47a1;
            --blue-700: #0a3880;
            --bg: #f0f4ff;
            --card: #ffffff;
            --text: #0d1b3e;
            --text-muted: #5a6a8a;
            --border: #dce8fa;
            --sidebar-w: 260px;
            --radius: 16px;
            --shadow: 0 4px 24px rgba(21,101,192,0.10);
            --shadow-lg: 0 8px 40px rgba(21,101,192,0.18);
        }

        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Plus Jakarta Sans',sans-serif; background:var(--bg); color:var(--text); min-height:100vh; }

        /* ===== SIDEBAR ===== */
        .sidebar {
            position:fixed; top:0; left:0; width:var(--sidebar-w);
            height:100vh; background:linear-gradient(160deg,#1976d2 0%,#1565c0 60%,#0d47a1 100%);
            display:flex; flex-direction:column; z-index:100;
            box-shadow:4px 0 30px rgba(13,71,161,0.25);
        }
        .sidebar-logo { padding:24px 20px 18px; border-bottom:1px solid rgba(255,255,255,0.15); }
        .sidebar-logo-inner { display:flex; align-items:center; gap:12px; }
        .logo-img-wrap {
            width:44px; height:44px; border-radius:12px;
            background:white; overflow:hidden; flex-shrink:0;
            display:flex; align-items:center; justify-content:center;
            box-shadow:0 4px 12px rgba(0,0,0,0.15);
        }
        .logo-img-wrap img { width:100%; height:100%; object-fit:cover; border-radius:12px; }
        .logo-img-wrap .logo-emoji { font-size:22px; }
        .sidebar-logo h1 { font-size:20px; font-weight:800; color:white; letter-spacing:-0.5px; }
        .sidebar-logo p { font-size:11px; color:rgba(255,255,255,0.65); margin-top:1px; }

        .sidebar-user {
            margin:14px 14px 6px;
            background:rgba(255,255,255,0.13);
            border-radius:12px; padding:11px 13px;
            display:flex; align-items:center; gap:10px;
        }
        .sidebar-user .avatar {
            width:34px; height:34px; border-radius:50%;
            background:white; display:flex; align-items:center; justify-content:center;
            font-weight:700; font-size:13px; color:var(--blue-500); flex-shrink:0;
        }
        .sidebar-user .name { font-size:13px; font-weight:600; color:white; }
        .sidebar-user .role {
            font-size:10px; color:rgba(255,255,255,0.65);
            background:rgba(255,255,255,0.18); border-radius:20px;
            padding:1px 8px; display:inline-block; margin-top:2px;
            text-transform:uppercase; letter-spacing:.5px;
        }

        .sidebar-nav { flex:1; padding:8px 10px; overflow-y:auto; }
        .nav-label { font-size:10px; text-transform:uppercase; letter-spacing:1px; color:rgba(255,255,255,0.45); padding:12px 8px 4px; font-weight:600; }
        .nav-item {
            display:flex; align-items:center; gap:11px; padding:10px 13px;
            border-radius:10px; color:rgba(255,255,255,0.82); text-decoration:none;
            font-size:13.5px; font-weight:500; transition:all .2s; margin-bottom:2px;
        }
        .nav-item i { width:17px; text-align:center; font-size:14px; }
        .nav-item:hover { background:rgba(255,255,255,0.18); color:white; }
        .nav-item.active { background:white; color:var(--blue-500); box-shadow:0 4px 12px rgba(0,0,0,0.12); font-weight:700; }
        .nav-item.active i { color:var(--blue-400); }
        .nav-badge {
            margin-left:auto; background:white; color:var(--blue-600);
            font-size:10px; font-weight:700; padding:2px 7px; border-radius:20px;
        }
        .nav-item.active .nav-badge { background:var(--blue-100); }

        .sidebar-footer { padding:14px; border-top:1px solid rgba(255,255,255,0.12); }
        .logout-btn {
            display:flex; align-items:center; gap:10px; padding:10px 13px;
            background:rgba(255,255,255,0.13); border-radius:10px; color:white;
            text-decoration:none; font-size:13.5px; font-weight:500;
            cursor:pointer; border:none; width:100%; transition:background .2s;
        }
        .logout-btn:hover { background:rgba(255,255,255,0.22); }

        /* ===== MAIN ===== */
        .main { margin-left:var(--sidebar-w); min-height:100vh; }
        .topbar {
            background:white; padding:0 32px; height:64px;
            display:flex; align-items:center; justify-content:space-between;
            border-bottom:1px solid var(--border); position:sticky; top:0; z-index:50;
            box-shadow:0 2px 12px rgba(21,101,192,0.07);
            position:relative;
        }
        .topbar::before {
            content:''; position:absolute; top:0; left:0; right:0; height:3px;
            background:linear-gradient(90deg,var(--blue-400),var(--blue-600),var(--blue-400));
        }
        .topbar-title h2 { font-size:18px; font-weight:700; color:var(--text); }
        .topbar-title p { font-size:12px; color:var(--text-muted); }
        .topbar-right { display:flex; align-items:center; gap:12px; }
        .content { padding:28px 32px; }

        /* ===== CARDS ===== */
        .card { background:white; border-radius:var(--radius); padding:24px; box-shadow:var(--shadow); border:1px solid var(--border); }
        .card-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; padding-bottom:16px; border-bottom:1px solid var(--border); }
        .card-title { font-size:16px; font-weight:700; color:var(--text); }
        .card-subtitle { font-size:12px; color:var(--text-muted); margin-top:2px; }

        /* ===== STATS ===== */
        .stats-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:16px; margin-bottom:24px; }
        .stat-card {
            background:white; border-radius:var(--radius); padding:20px;
            box-shadow:var(--shadow); border:1px solid var(--border);
            display:flex; align-items:center; gap:16px;
            transition:transform .2s,box-shadow .2s;
        }
        .stat-card:hover { transform:translateY(-2px); box-shadow:var(--shadow-lg); }
        .stat-icon { width:52px; height:52px; border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:22px; flex-shrink:0; }
        .stat-icon.blue   { background:var(--blue-50); color:var(--blue-500); }
        .stat-icon.indigo { background:#eef2ff; color:#4338ca; }
        .stat-icon.sky    { background:#e0f2fe; color:#0284c7; }
        .stat-icon.green  { background:#f0fff4; color:#16a34a; }
        .stat-icon.orange { background:#fff7ed; color:#c2410c; }
        .stat-icon.rose   { background:#fff1f2; color:#e11d48; }
        .stat-icon.purple { background:#faf5ff; color:#7c3aed; }
        .stat-value { font-size:28px; font-weight:800; color:var(--text); line-height:1; }
        .stat-label { font-size:13px; color:var(--text-muted); margin-top:3px; }

        /* ===== FORMS ===== */
        .form-group { margin-bottom:16px; }
        .form-label { display:block; font-size:13px; font-weight:600; color:var(--text); margin-bottom:6px; }
        .form-control {
            width:100%; padding:10px 14px; border-radius:10px;
            border:1.5px solid var(--border); background:white;
            font-family:inherit; font-size:14px; color:var(--text);
            transition:all .2s; outline:none;
        }
        .form-control:focus { border-color:var(--blue-400); box-shadow:0 0 0 3px rgba(41,121,255,0.1); }
        .form-control::placeholder { color:#b0bccc; }

        /* ===== BUTTONS ===== */
        .btn {
            padding:10px 20px; border-radius:10px; font-family:inherit; font-size:14px;
            font-weight:600; cursor:pointer; transition:all .2s; border:none;
            display:inline-flex; align-items:center; gap:7px; text-decoration:none;
        }
        .btn-primary { background:linear-gradient(135deg,var(--blue-400),var(--blue-600)); color:white; box-shadow:0 4px 12px rgba(21,101,192,0.3); }
        .btn-primary:hover { box-shadow:0 6px 20px rgba(21,101,192,0.4); transform:translateY(-1px); }
        .btn-secondary { background:var(--blue-50); color:var(--blue-600); border:1px solid var(--blue-100); }
        .btn-secondary:hover { background:var(--blue-100); }
        .btn-danger { background:#fff0f0; color:#e53e3e; border:1px solid #fed7d7; }
        .btn-danger:hover { background:#fed7d7; }
        .btn-sm { padding:6px 14px; font-size:12px; border-radius:8px; }
        .btn-icon { width:36px; height:36px; padding:0; justify-content:center; border-radius:10px; }

        /* ===== TABLES ===== */
        .table-wrapper { overflow-x:auto; }
        table { width:100%; border-collapse:collapse; }
        th { font-size:11px; text-transform:uppercase; letter-spacing:.7px; color:var(--text-muted); font-weight:700; padding:10px 14px; background:var(--blue-50); text-align:left; }
        th:first-child { border-radius:10px 0 0 10px; }
        th:last-child { border-radius:0 10px 10px 0; }
        td { padding:13px 14px; font-size:14px; border-bottom:1px solid var(--border); }
        tr:last-child td { border-bottom:none; }
        tr:hover td { background:var(--blue-50); }

        /* ===== BADGES ===== */
        .badge { display:inline-flex; align-items:center; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; }
        .badge-blue   { background:var(--blue-50); color:var(--blue-600); }
        .badge-green  { background:#f0fff4; color:#276749; }
        .badge-red    { background:#fff5f5; color:#c53030; }
        .badge-yellow { background:#fffff0; color:#975a16; }
        .badge-purple { background:#faf5ff; color:#6b46c1; }
        .badge-gray   { background:#f7fafc; color:#4a5568; }
        .badge-pink   { background:#fff0f6; color:#c40d57; }
        .badge-rose   { background:#fff1f2; color:#e11d48; }

        /* ===== ALERTS ===== */
        .alert { padding:14px 18px; border-radius:12px; font-size:14px; margin-bottom:20px; display:flex; align-items:center; gap:10px; }
        .alert-success { background:#f0fff4; border:1px solid #c6f6d5; color:#276749; }
        .alert-danger  { background:#fff5f5; border:1px solid #fed7d7; color:#c53030; }

        /* ===== MODAL ===== */
        .modal-overlay { position:fixed; inset:0; background:rgba(13,27,62,0.5); z-index:200; display:none; align-items:center; justify-content:center; backdrop-filter:blur(4px); }
        .modal-overlay.show { display:flex; }
        .modal { background:white; border-radius:20px; padding:28px; width:100%; max-width:520px; box-shadow:0 20px 60px rgba(21,101,192,0.2); max-height:90vh; overflow-y:auto; }
        .modal-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; }
        .modal-title { font-size:18px; font-weight:700; }
        .modal-close { width:32px; height:32px; border-radius:8px; border:none; background:var(--blue-50); cursor:pointer; color:var(--blue-500); display:flex; align-items:center; justify-content:center; font-size:16px; }
        .modal-close:hover { background:var(--blue-100); }

        /* ===== MISC ===== */
        .page-header { margin-bottom:24px; }
        .grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
        .grid-3 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:20px; }
        .flex { display:flex; }
        .flex-center { align-items:center; }
        .gap-2 { gap:8px; } .gap-3 { gap:12px; }
        .mb-4 { margin-bottom:16px; } .mt-4 { margin-top:16px; }
        .text-muted { color:var(--text-muted); font-size:13px; }
        .text-center { text-align:center; }
        .empty-state { text-align:center; padding:48px 24px; color:var(--text-muted); }
        .empty-state i { font-size:48px; color:var(--blue-200); margin-bottom:12px; display:block; }

        ::-webkit-scrollbar { width:5px; height:5px; }
        ::-webkit-scrollbar-track { background:transparent; }
        ::-webkit-scrollbar-thumb { background:var(--blue-200); border-radius:10px; }
        ::-webkit-scrollbar-thumb:hover { background:var(--blue-400); }

        @media(max-width:768px){
            .sidebar { transform:translateX(-100%); }
            .main { margin-left:0; }
            .content { padding:20px 16px; }
            .stats-grid { grid-template-columns:1fr 1fr; }
            .grid-2,.grid-3 { grid-template-columns:1fr; }
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="sidebar-logo-inner">
                <div class="logo-img-wrap">
                    <?php if(file_exists(public_path('logo.jpg'))): ?>
                        <img src="<?php echo e(asset('logo.jpg')); ?>" alt="Logo">
                    <?php elseif(file_exists(public_path('logo.png'))): ?>
                        <img src="<?php echo e(asset('logo.png')); ?>" alt="Logo">
                    <?php else: ?>
                        <span class="logo-emoji">🏫</span>
                    <?php endif; ?>
                </div>
                <div>
                    <h1>SMAtrack</h1>
                    <p>Sistem Akademik SMA</p>
                </div>
            </div>
        </div>

        <div class="sidebar-user">
            <div class="avatar"><?php echo e(strtoupper(substr(auth()->user()->name,0,1))); ?></div>
            <div>
                <div class="name"><?php echo e(auth()->user()->name); ?></div>
                <span class="role"><?php echo e(auth()->user()->role); ?></span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <?php if(auth()->guard()->check()): ?>
                <?php if(auth()->user()->isAdmin()): ?>
                    <div class="nav-label">Menu Admin</div>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                    <a href="<?php echo e(route('admin.siswa.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.siswa.*') ? 'active' : ''); ?>">
                        <i class="fas fa-user-graduate"></i> Data Siswa
                    </a>
                    <a href="<?php echo e(route('admin.guru.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.guru.*') ? 'active' : ''); ?>">
                        <i class="fas fa-chalkboard-teacher"></i> Data Guru
                    </a>
                    <a href="<?php echo e(route('admin.kelas.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.kelas.*') ? 'active' : ''); ?>">
                        <i class="fas fa-school"></i> Kelas
                    </a>
                    <a href="<?php echo e(route('admin.absensi.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.absensi.*') ? 'active' : ''); ?>">
                        <i class="fas fa-clipboard-check"></i> Absensi
                    </a>
                    <a href="<?php echo e(route('admin.nilai.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.nilai.*') ? 'active' : ''); ?>">
                        <i class="fas fa-star"></i> Input Nilai
                    </a>
                    <div class="nav-label">Khusus Kelas 12</div>
                    <a href="<?php echo e(route('admin.kuliah.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.kuliah.*') ? 'active' : ''); ?>">
                        <i class="fas fa-university"></i> Data Kuliah
                        <span class="nav-badge">12</span>
                    </a>
                    <div class="nav-label">Lainnya</div>
                    <a href="<?php echo e(route('admin.pengumuman.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.pengumuman.*') ? 'active' : ''); ?>">
                        <i class="fas fa-bullhorn"></i> Pengumuman
                    </a>

                <?php elseif(auth()->user()->isGuru()): ?>
                    <div class="nav-label">Menu Guru</div>
                    <a href="<?php echo e(route('guru.dashboard')); ?>" class="nav-item <?php echo e(request()->routeIs('guru.dashboard') ? 'active' : ''); ?>">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                    <a href="<?php echo e(route('guru.jadwal')); ?>" class="nav-item <?php echo e(request()->routeIs('guru.jadwal') ? 'active' : ''); ?>">
                        <i class="fas fa-calendar-alt"></i> Jadwal Mengajar
                    </a>
                    <a href="<?php echo e(route('guru.absensi')); ?>" class="nav-item <?php echo e(request()->routeIs('guru.absensi') ? 'active' : ''); ?>">
                        <i class="fas fa-clipboard-check"></i> Lihat Absensi
                    </a>
                    <a href="<?php echo e(route('guru.nilai')); ?>" class="nav-item <?php echo e(request()->routeIs('guru.nilai') ? 'active' : ''); ?>">
                        <i class="fas fa-star"></i> Lihat Nilai
                    </a>

                <?php elseif(auth()->user()->isSiswa()): ?>
                    <div class="nav-label">Menu Siswa</div>
                    <a href="<?php echo e(route('siswa.dashboard')); ?>" class="nav-item <?php echo e(request()->routeIs('siswa.dashboard') ? 'active' : ''); ?>">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                    <a href="<?php echo e(route('siswa.jadwal')); ?>" class="nav-item <?php echo e(request()->routeIs('siswa.jadwal') ? 'active' : ''); ?>">
                        <i class="fas fa-calendar-alt"></i> Jadwal Pelajaran
                    </a>
                    <a href="<?php echo e(route('siswa.absensi')); ?>" class="nav-item <?php echo e(request()->routeIs('siswa.absensi') ? 'active' : ''); ?>">
                        <i class="fas fa-clipboard-check"></i> Absensi Saya
                    </a>
                    <a href="<?php echo e(route('siswa.nilai')); ?>" class="nav-item <?php echo e(request()->routeIs('siswa.nilai') ? 'active' : ''); ?>">
                        <i class="fas fa-star"></i> Nilai Saya
                    </a>
                    <a href="<?php echo e(route('siswa.rapot')); ?>" class="nav-item <?php echo e(request()->routeIs('siswa.rapot') ? 'active' : ''); ?>">
                        <i class="fas fa-file-alt"></i> Rapot
                    </a>
                    <?php $kelasAktif = auth()->user()->kelasAktif(); ?>
                    <?php if($kelasAktif && $kelasAktif->kelas->tingkat == '12'): ?>
                        <div class="nav-label">🎓 Khusus Kelas 12</div>
                        <a href="<?php echo e(route('siswa.kuliah')); ?>" class="nav-item <?php echo e(request()->routeIs('siswa.kuliah') ? 'active' : ''); ?>">
                            <i class="fas fa-university"></i> Data Kuliah
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        </nav>

        <div class="sidebar-footer">
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="main">
        <header class="topbar">
            <div class="topbar-title">
                <h2><?php echo $__env->yieldContent('page-title','Dashboard'); ?></h2>
                <p><?php echo $__env->yieldContent('page-subtitle', date('l, d F Y')); ?></p>
            </div>
            <div class="topbar-right">
                <div style="font-size:12px;color:var(--text-muted);text-align:right;">
                    <div style="font-weight:600;color:var(--text);"><?php echo e(auth()->user()->name); ?></div>
                    <div><?php echo e(ucfirst(auth()->user()->role)); ?></div>
                </div>
                <div style="width:38px;height:38px;background:linear-gradient(135deg,var(--blue-400),var(--blue-600));border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:15px;">
                    <?php echo e(strtoupper(substr(auth()->user()->name,0,1))); ?>

                </div>
            </div>
        </header>

        <div class="content">
            <?php if(session('success')): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

            </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

            </div>
            <?php endif; ?>
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </main>

    <script>
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(a => {
                a.style.transition='opacity .5s'; a.style.opacity='0';
                setTimeout(()=>a.remove(),500);
            });
        }, 4000);
        function openModal(id){ document.getElementById(id).classList.add('show'); }
        function closeModal(id){ document.getElementById(id).classList.remove('show'); }
        document.querySelectorAll('.modal-overlay').forEach(o=>{
            o.addEventListener('click',e=>{ if(e.target===o) o.classList.remove('show'); });
        });
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\smatrack\resources\views/layouts/app.blade.php ENDPATH**/ ?>