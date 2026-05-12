<?php $__env->startSection('title', 'Dashboard Admin'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>
<?php $__env->startSection('page-subtitle', 'Selamat datang, ' . auth()->user()->name . '!'); ?>

<?php $__env->startSection('content'); ?>
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon pink"><i class="fas fa-user-graduate"></i></div>
        <div><div class="stat-value"><?php echo e($stats['total_siswa']); ?></div><div class="stat-label">Total Siswa</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple"><i class="fas fa-chalkboard-teacher"></i></div>
        <div><div class="stat-value"><?php echo e($stats['total_guru']); ?></div><div class="stat-label">Total Guru</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-school"></i></div>
        <div><div class="stat-value"><?php echo e($stats['total_kelas']); ?></div><div class="stat-label">Total Kelas</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon rose"><i class="fas fa-graduation-cap"></i></div>
        <div><div class="stat-value"><?php echo e($stats['siswa_kelas12']); ?></div><div class="stat-label">Siswa Kelas 12</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-university"></i></div>
        <div><div class="stat-value"><?php echo e($stats['diterima_kuliah']); ?></div><div class="stat-label">Diterima Kuliah</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-hourglass-half"></i></div>
        <div><div class="stat-value"><?php echo e($stats['proses_kuliah']); ?></div><div class="stat-label">Sedang Proses</div></div>
    </div>
</div>

<div class="grid-2">
    <!-- Quick Actions -->
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">⚡ Aksi Cepat</div>
                <div class="card-subtitle">Pintasan menu admin</div>
            </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
            <a href="<?php echo e(route('admin.absensi.index')); ?>" class="btn btn-secondary" style="justify-content:center;padding:14px;">
                <i class="fas fa-clipboard-check"></i> Absensi
            </a>
            <a href="<?php echo e(route('admin.nilai.index')); ?>" class="btn btn-secondary" style="justify-content:center;padding:14px;">
                <i class="fas fa-star"></i> Input Nilai
            </a>
            <a href="<?php echo e(route('admin.kuliah.index')); ?>" class="btn btn-secondary" style="justify-content:center;padding:14px;">
                <i class="fas fa-university"></i> Data Kuliah
            </a>
            <a href="<?php echo e(route('admin.pengumuman.index')); ?>" class="btn btn-secondary" style="justify-content:center;padding:14px;">
                <i class="fas fa-bullhorn"></i> Pengumuman
            </a>
            <a href="<?php echo e(route('admin.siswa.index')); ?>" class="btn btn-secondary" style="justify-content:center;padding:14px;">
                <i class="fas fa-user-plus"></i> Tambah Siswa
            </a>
            <a href="<?php echo e(route('admin.kelas.index')); ?>" class="btn btn-secondary" style="justify-content:center;padding:14px;">
                <i class="fas fa-school"></i> Kelola Kelas
            </a>
        </div>
    </div>

    <!-- Pengumuman Terbaru -->
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">📢 Pengumuman Terbaru</div>
                <div class="card-subtitle">5 pengumuman terakhir</div>
            </div>
            <a href="<?php echo e(route('admin.pengumuman.index')); ?>" class="btn btn-secondary btn-sm">Lihat Semua</a>
        </div>
        <?php $__empty_1 = true; $__currentLoopData = $pengumumans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div style="padding:12px 0;border-bottom:1px solid var(--border);display:flex;align-items:flex-start;gap:10px;">
            <div style="width:8px;height:8px;border-radius:50%;background:var(--pink-400);margin-top:5px;flex-shrink:0;"></div>
            <div>
                <div style="font-size:14px;font-weight:600;color:var(--text);"><?php echo e($p->judul); ?></div>
                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;">
                    <?php echo e($p->created_at->diffForHumans()); ?> &bull;
                    <span class="badge badge-<?php echo e($p->untuk == 'kelas12' ? 'pink' : ($p->untuk == 'semua' ? 'green' : 'blue')); ?>">
                        <?php echo e(ucfirst($p->untuk)); ?>

                    </span>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="empty-state"><i class="fas fa-bullhorn"></i><p>Belum ada pengumuman</p></div>
        <?php endif; ?>
    </div>
</div>

<!-- Tahun Ajaran Info -->
<div class="card mt-4" style="background:linear-gradient(135deg,var(--pink-50),white);border-color:var(--pink-200);">
    <div style="display:flex;align-items:center;gap:16px;">
        <div style="width:52px;height:52px;background:linear-gradient(135deg,var(--pink-400),var(--pink-600));border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:24px;">📅</div>
        <div>
            <div style="font-size:18px;font-weight:800;color:var(--text);">Tahun Ajaran Aktif: <?php echo e($ta?->tahun ?? 'Belum diatur'); ?></div>
            <div style="font-size:13px;color:var(--text-muted);">Semua data mengacu pada tahun ajaran ini</div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\smatrack\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>