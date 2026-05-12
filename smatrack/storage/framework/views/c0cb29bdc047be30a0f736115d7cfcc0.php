<?php $__env->startSection('title','Lihat Nilai'); ?>
<?php $__env->startSection('page-title','Lihat Nilai Siswa'); ?>
<?php $__env->startSection('page-subtitle','Data nilai siswa — hanya bisa dilihat'); ?>
<?php $__env->startSection('content'); ?>
<div class="card mb-4" style="background:#fff5f5;border-color:#fed7d7;">
    <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:#c53030;">
        <i class="fas fa-eye"></i> <strong>Mode Lihat Saja</strong> — Untuk input nilai, setor ke admin. Admin yang menginputkan.
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
            <label class="form-label">Mata Pelajaran</label>
            <select name="mata_pelajaran_id" class="form-control">
                <?php $__currentLoopData = $mapels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($m->id); ?>" <?php echo e($m->id==$mapelId?'selected':''); ?>><?php echo e($m->nama); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="form-group" style="margin:0;min-width:120px;">
            <label class="form-label">Semester</label>
            <select name="semester" class="form-control">
                <option value="1" <?php echo e($semester=='1'?'selected':''); ?>>Semester 1</option>
                <option value="2" <?php echo e($semester=='2'?'selected':''); ?>>Semester 2</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Tampilkan</button>
    </form>
</div>
<div class="card">
    <div class="table-wrapper">
        <table>
            <thead><tr><th>#</th><th>Nama Siswa</th><th>NH</th><th>UTS</th><th>UAS</th><th>Nilai Akhir</th><th>Predikat</th></tr></thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $nilais; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($i+1); ?></td>
                    <td style="font-weight:600;"><?php echo e($n->siswa->name); ?></td>
                    <td><?php echo e($n->nilai_harian ?? '-'); ?></td>
                    <td><?php echo e($n->nilai_uts ?? '-'); ?></td>
                    <td><?php echo e($n->nilai_uas ?? '-'); ?></td>
                    <td style="font-weight:800;color:<?php echo e(($n->nilai_akhir??0)>=75?'var(--pink-600)':'#e53e3e'); ?>"><?php echo e($n->nilai_akhir ? number_format($n->nilai_akhir,1) : '-'); ?></td>
                    <td><span class="badge badge-<?php echo e($n->predikat=='A'?'green':($n->predikat=='B'?'blue':($n->predikat=='C'?'yellow':'red'))); ?>"><?php echo e($n->predikat ?? '-'); ?></span></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="7"><div class="empty-state"><i class="fas fa-star"></i><p>Belum ada nilai</p></div></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\USER\smatrack\resources\views/guru/nilai.blade.php ENDPATH**/ ?>