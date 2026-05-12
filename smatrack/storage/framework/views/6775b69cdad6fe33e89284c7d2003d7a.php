<?php $__env->startSection('title', 'Dashboard Guru'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>
<?php $__env->startSection('page-subtitle', 'Selamat datang, ' . auth()->user()->name . '!'); ?>

<?php $__env->startSection('content'); ?>
<!-- Info Hak Akses -->
<div class="card mb-4" style="background:linear-gradient(135deg,#f5f0ff,white);border:2px solid #d6bcfa;">
    <div style="display:flex;align-items:center;gap:14px;">
        <div style="font-size:32px;">👨‍🏫</div>
        <div>
            <div style="font-weight:800;font-size:16px;color:#6b46c1;">Mode Guru — Hanya Bisa Melihat</div>
            <div style="font-size:13px;color:#805ad5;margin-top:2px;">
                Kamu bisa melihat absensi, nilai, dan jadwal. Untuk input nilai, setor ke admin dan admin yang akan menginputkan.
            </div>
        </div>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon purple"><i class="fas fa-chalkboard"></i></div>
        <div><div class="stat-value"><?php echo e($kelasDiajar->count()); ?></div><div class="stat-label">Kelas Diajar</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon pink"><i class="fas fa-calendar-day"></i></div>
        <div><div class="stat-value"><?php echo e($jadwalHariIni->count()); ?></div><div class="stat-label">Jadwal Hari Ini</div></div>
    </div>
</div>

<div class="grid-2">
    <!-- Jadwal Hari Ini -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">📅 Jadwal Hari Ini</div>
            <span class="badge badge-pink"><?php echo e(now()->locale('id')->isoFormat('dddd')); ?></span>
        </div>
        <?php $__empty_1 = true; $__currentLoopData = $jadwalHariIni; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div style="padding:12px 0;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:14px;">
            <div style="text-align:center;min-width:60px;">
                <div style="font-size:13px;font-weight:700;color:var(--pink-700);"><?php echo e(substr($j->jam_mulai,0,5)); ?></div>
                <div style="font-size:11px;color:var(--text-muted);"><?php echo e(substr($j->jam_selesai,0,5)); ?></div>
            </div>
            <div style="flex:1;">
                <div style="font-weight:700;font-size:14px;"><?php echo e($j->mataPelajaran->nama); ?></div>
                <div style="font-size:12px;color:var(--text-muted);"><?php echo e($j->kelas->nama_kelas); ?></div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="empty-state" style="padding:24px;"><i class="fas fa-couch"></i><p>Tidak ada jadwal hari ini 😊</p></div>
        <?php endif; ?>
    </div>

    <!-- Kelas yang Diajar -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">🏫 Kelas yang Diajar</div>
        </div>
        <?php $__empty_1 = true; $__currentLoopData = $kelasDiajar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div style="padding:10px 0;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
            <div>
                <div style="font-weight:700;font-size:14px;"><?php echo e($k->nama_kelas); ?></div>
                <div style="font-size:12px;color:var(--text-muted);">Kelas <?php echo e($k->tingkat); ?> &bull; <?php echo e($k->jurusan); ?></div>
            </div>
            <span class="badge badge-<?php echo e($k->tingkat=='12'?'pink':($k->tingkat=='11'?'purple':'blue')); ?>">
                Kelas <?php echo e($k->tingkat); ?>

            </span>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="empty-state" style="padding:24px;"><i class="fas fa-school"></i><p>Belum ada jadwal mengajar</p></div>
        <?php endif; ?>
    </div>
</div>

<!-- Pengumuman -->
<div class="card mt-4">
    <div class="card-header">
        <div class="card-title">📢 Pengumuman</div>
    </div>
    <?php $__empty_1 = true; $__currentLoopData = $pengumumans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div style="padding:12px 0;border-bottom:1px solid var(--border);">
        <div style="font-weight:600;font-size:14px;margin-bottom:4px;"><?php echo e($p->judul); ?></div>
        <div style="font-size:12px;color:var(--text-muted);"><?php echo e($p->created_at->diffForHumans()); ?></div>
        <div style="font-size:13px;margin-top:4px;"><?php echo e(Str::limit($p->isi, 120)); ?></div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="empty-state"><i class="fas fa-bullhorn"></i><p>Belum ada pengumuman</p></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\USER\smatrack\resources\views/guru/dashboard.blade.php ENDPATH**/ ?>