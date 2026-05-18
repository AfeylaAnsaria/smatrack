
<?php $__env->startSection('title', 'Pengumuman'); ?>
<?php $__env->startSection('page-title', 'Pengumuman'); ?>
<?php $__env->startSection('page-subtitle', 'Informasi dan pengumuman untuk siswa'); ?>

<?php $__env->startSection('content'); ?>

<div class="card" style="margin-bottom:20px;">
    <div class="card-header">
        <div>
            <div class="card-title">📢 Pengumuman Sekolah</div>
            <div class="card-subtitle">Berita penting untuk semua siswa</div>
        </div>
    </div>

    <?php $__empty_1 = true; $__currentLoopData = $pengumumans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pengumuman): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div style="padding:16px;border-bottom:1px solid var(--border);">
        <div style="display:flex;align-items:flex-start;gap:12px;margin-bottom:8px;">
            <div style="width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,var(--pink-300),var(--pink-500));color:white;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;">
                📌
            </div>
            <div style="flex:1;">
                <div style="font-size:15px;font-weight:700;color:var(--text);margin-bottom:4px;"><?php echo e($pengumuman->judul); ?></div>
                <div style="font-size:12px;color:var(--text-muted);margin-bottom:8px;">
                    <?php echo e($pengumuman->created_at->translatedFormat('d F Y \p\u\k\u\l H:i')); ?>

                    <?php
                        $badge = match($pengumuman->untuk) {
                            'semua' => 'Semua',
                            'siswa' => 'Untuk Siswa',
                            'guru' => 'Untuk Guru',
                            'kelas12' => 'Khusus Kelas 12',
                            default => $pengumuman->untuk
                        };
                        $badgeColor = match($pengumuman->untuk) {
                            'semua' => 'blue',
                            'siswa' => 'green',
                            'guru' => 'purple',
                            'kelas12' => 'pink',
                            default => 'gray'
                        };
                    ?>
                    · <span class="badge badge-<?php echo e($badgeColor); ?>" style="font-size:10px;"><?php echo e($badge); ?></span>
                </div>
                <div style="font-size:13px;color:var(--text);line-height:1.6;">
                    <?php echo nl2br(e($pengumuman->isi)); ?>

                </div>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="empty-state" style="padding:60px 20px;">
        <i class="fas fa-inbox" style="font-size:48px;color:var(--text-muted);margin-bottom:12px;"></i>
        <p style="color:var(--text-muted);">Belum ada pengumuman</p>
    </div>
    <?php endif; ?>
</div>

<div style="display:flex;justify-content:center;margin-top:20px;">
    <?php echo e($pengumumans->links()); ?>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\smatrack\resources\views/siswa/pengumuman.blade.php ENDPATH**/ ?>