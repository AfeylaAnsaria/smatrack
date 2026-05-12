<?php $__env->startSection('title', 'Jadwal Pelajaran'); ?>
<?php $__env->startSection('page-title', 'Jadwal Pelajaran'); ?>
<?php $__env->startSection('page-subtitle', 'Jadwal mingguan kelas ' . ($sk?->kelas?->nama_kelas ?? '-')); ?>

<?php $__env->startSection('content'); ?>
<?php if($jadwals->count() > 0): ?>
<div style="display:flex;flex-direction:column;gap:16px;">
    <?php $__currentLoopData = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hari): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if(isset($jadwals[$hari])): ?>
    <div class="card" style="border-left:4px solid var(--pink-<?php echo e($hari=='Senin'?'400':($hari=='Selasa'?'500':($hari=='Rabu'?'600':($hari=='Kamis'?'400':($hari=='Jumat'?'500':'600'))))); ?>);">
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
            <div style="width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,var(--pink-400),var(--pink-600));color:white;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;">
                <?php echo e(strtoupper(substr($hari,0,3))); ?>

            </div>
            <div style="font-size:16px;font-weight:800;"><?php echo e($hari); ?></div>
            <span class="badge badge-pink"><?php echo e($jadwals[$hari]->count()); ?> pelajaran</span>
        </div>
        <div style="display:flex;flex-direction:column;gap:8px;">
            <?php $__currentLoopData = $jadwals[$hari]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div style="display:flex;align-items:center;gap:14px;padding:12px 14px;background:var(--pink-50);border-radius:10px;border:1px solid var(--pink-100);">
                <div style="text-align:center;min-width:70px;">
                    <div style="font-size:12px;font-weight:700;color:var(--pink-700);"><?php echo e(substr($j->jam_mulai,0,5)); ?></div>
                    <div style="font-size:10px;color:var(--text-muted);"><?php echo e(substr($j->jam_selesai,0,5)); ?></div>
                </div>
                <div style="width:2px;height:32px;background:var(--pink-300);border-radius:2px;"></div>
                <div style="flex:1;">
                    <div style="font-weight:700;font-size:14px;"><?php echo e($j->mataPelajaran->nama); ?></div>
                    <div style="font-size:12px;color:var(--text-muted);"><?php echo e($j->guru->name); ?></div>
                </div>
                <?php if($j->ruangan): ?>
                <span class="badge badge-gray"><i class="fas fa-door-closed"></i> <?php echo e($j->ruangan); ?></span>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php else: ?>
<div class="card"><div class="empty-state"><i class="fas fa-calendar-alt"></i><p>Jadwal belum tersedia. Hubungi admin.</p></div></div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\smatrack\resources\views/siswa/jadwal.blade.php ENDPATH**/ ?>