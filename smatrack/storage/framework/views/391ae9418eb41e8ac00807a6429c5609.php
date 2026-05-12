<?php $__env->startSection('title', 'Absensi Saya'); ?>
<?php $__env->startSection('page-title', 'Absensi Saya'); ?>
<?php $__env->startSection('page-subtitle', 'Rekap kehadiran selama tahun ajaran ini'); ?>

<?php $__env->startSection('content'); ?>
<!-- Rekap -->
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px;">
    <?php $total = array_sum($rekap); ?>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
        <div>
            <div class="stat-value"><?php echo e($rekap['hadir']); ?></div>
            <div class="stat-label">Hadir <?php echo e($total > 0 ? '('.round($rekap['hadir']/$total*100).'%)' : ''); ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-procedures"></i></div>
        <div><div class="stat-value"><?php echo e($rekap['sakit']); ?></div><div class="stat-label">Sakit</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-door-open"></i></div>
        <div><div class="stat-value"><?php echo e($rekap['izin']); ?></div><div class="stat-label">Izin</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon rose"><i class="fas fa-times-circle"></i></div>
        <div><div class="stat-value"><?php echo e($rekap['alpa']); ?></div><div class="stat-label">Alpa</div></div>
    </div>
</div>

<!-- Tabel -->
<div class="card">
    <div class="card-header">
        <div class="card-title">📋 Riwayat Absensi</div>
        <span class="badge badge-pink">Kelas <?php echo e($sk?->kelas?->nama_kelas ?? '-'); ?></span>
    </div>
    <div class="table-wrapper">
        <table>
            <thead><tr><th>Tanggal</th><th>Mata Pelajaran</th><th>Status</th><th>Keterangan</th></tr></thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $absensi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td style="font-size:13px;"><?php echo e($a->tanggal->translatedFormat('l, d M Y')); ?></td>
                    <td style="font-weight:600;"><?php echo e($a->mataPelajaran->nama); ?></td>
                    <td>
                        <span class="badge badge-<?php echo e($a->status=='hadir'?'green':($a->status=='sakit'?'blue':($a->status=='izin'?'yellow':'red'))); ?>">
                            <?php echo e(['hadir'=>'✅ Hadir','sakit'=>'🤒 Sakit','izin'=>'📄 Izin','alpa'=>'❌ Alpa'][$a->status]); ?>

                        </span>
                    </td>
                    <td style="font-size:13px;color:var(--text-muted);"><?php echo e($a->keterangan ?? '-'); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="4"><div class="empty-state"><i class="fas fa-clipboard"></i><p>Belum ada data absensi</p></div></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div style="margin-top:16px;"><?php echo e($absensi->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\smatrack\resources\views/siswa/absensi.blade.php ENDPATH**/ ?>