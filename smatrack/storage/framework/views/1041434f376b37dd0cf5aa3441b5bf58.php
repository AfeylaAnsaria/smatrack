<?php $__env->startSection('title','Lihat Absensi'); ?>
<?php $__env->startSection('page-title','Lihat Absensi'); ?>
<?php $__env->startSection('page-subtitle','Data absensi siswa — hanya bisa dilihat'); ?>
<?php $__env->startSection('content'); ?>
<div class="card mb-4" style="background:#fff5f5;border-color:#fed7d7;">
    <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:#c53030;">
        <i class="fas fa-eye"></i> <strong>Mode Lihat Saja</strong> — Guru tidak bisa mengubah data absensi. Untuk koreksi, hubungi admin.
    </div>
</div>
<div class="card mb-4">
    <form method="GET" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
        <div class="form-group" style="margin:0;flex:1;min-width:140px;">
            <label class="form-label">Kelas</label>
            <select name="kelas_id" class="form-control">
                <?php $__currentLoopData = $kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($k->id); ?>" <?php echo e($k->id==$kelasId?'selected':''); ?>><?php echo e($k->nama_kelas); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="form-group" style="margin:0;flex:1;min-width:140px;">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="<?php echo e($tanggal); ?>">
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filter</button>
    </form>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">📋 Data Absensi</div>
        <span class="badge badge-pink"><?php echo e(\Carbon\Carbon::parse($tanggal)->translatedFormat('d M Y')); ?></span>
    </div>
    <div class="table-wrapper">
        <table>
            <thead><tr><th>#</th><th>Nama Siswa</th><th>Mata Pelajaran</th><th>Status</th></tr></thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $absensi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td style="font-size:12px;color:var(--text-muted);"><?php echo e($i+1); ?></td>
                    <td style="font-weight:600;"><?php echo e($a->siswa->name); ?></td>
                    <td><?php echo e($a->mataPelajaran->nama); ?></td>
                    <td><span class="badge badge-<?php echo e($a->status=='hadir'?'green':($a->status=='sakit'?'blue':($a->status=='izin'?'yellow':'red'))); ?>">
                        <?php echo e(['hadir'=>'✅ Hadir','sakit'=>'🤒 Sakit','izin'=>'📄 Izin','alpa'=>'❌ Alpa'][$a->status]); ?>

                    </span></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="4"><div class="empty-state"><i class="fas fa-clipboard"></i><p>Belum ada data absensi untuk tanggal ini</p></div></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\USER\smatrack\resources\views/guru/absensi.blade.php ENDPATH**/ ?>