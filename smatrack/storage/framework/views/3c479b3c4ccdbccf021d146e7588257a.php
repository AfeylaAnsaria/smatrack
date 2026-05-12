<?php $__env->startSection('title', 'Input Nilai'); ?>
<?php $__env->startSection('page-title', 'Input Nilai'); ?>
<?php $__env->startSection('page-subtitle', 'Masukkan nilai siswa per mata pelajaran'); ?>

<?php $__env->startSection('content'); ?>
<!-- Filter -->
<div class="card mb-4">
    <form method="GET" action="<?php echo e(route('admin.nilai.index')); ?>" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
        <div class="form-group" style="margin:0;flex:1;min-width:150px;">
            <label class="form-label">Kelas</label>
            <select name="kelas_id" class="form-control">
                <?php $__currentLoopData = $kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($k->id); ?>" <?php echo e($k->id == $kelasId ? 'selected' : ''); ?>><?php echo e($k->nama_kelas); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="form-group" style="margin:0;flex:1;min-width:150px;">
            <label class="form-label">Mata Pelajaran</label>
            <select name="mata_pelajaran_id" class="form-control">
                <?php $__currentLoopData = $mapels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($m->id); ?>" <?php echo e($m->id == $mapelId ? 'selected' : ''); ?>><?php echo e($m->nama); ?></option>
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
    <div class="card-header">
        <div>
            <div class="card-title">⭐ Input Nilai Siswa</div>
            <div class="card-subtitle">Formula: NH×40% + NUTs×30% + NUAs×30%</div>
        </div>
        <div style="background:var(--pink-50);border:1px solid var(--pink-200);border-radius:8px;padding:8px 14px;font-size:12px;color:var(--pink-600);">
            <i class="fas fa-info-circle"></i> Guru setor nilai ke admin
        </div>
    </div>

    <?php if($siswaKelas->count() > 0): ?>
    <form method="POST" action="<?php echo e(route('admin.nilai.store')); ?>">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="kelas_id" value="<?php echo e($kelasId); ?>">
        <input type="hidden" name="mata_pelajaran_id" value="<?php echo e($mapelId); ?>">
        <input type="hidden" name="semester" value="<?php echo e($semester); ?>">

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Siswa</th>
                        <th>Nilai Harian (NH)</th>
                        <th>Nilai UTS</th>
                        <th>Nilai UAS</th>
                        <th>Nilai Akhir</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $siswaKelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $sk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $nilai = $sk->siswa->nilais->first(); ?>
                    <tr>
                        <td style="font-size:12px;color:var(--text-muted);"><?php echo e($i+1); ?></td>
                        <td>
                            <div style="font-weight:600;font-size:14px;"><?php echo e($sk->siswa->name); ?></div>
                            <div style="font-size:11px;color:var(--text-muted);"><?php echo e($sk->siswa->nis ?? ''); ?></div>
                        </td>
                        <td>
                            <input type="number" name="nilais[<?php echo e($sk->siswa->id); ?>][nilai_harian]"
                                class="form-control" style="width:90px;padding:8px 10px;" min="0" max="100" step="0.01"
                                value="<?php echo e($nilai?->nilai_harian ?? ''); ?>" placeholder="0-100">
                        </td>
                        <td>
                            <input type="number" name="nilais[<?php echo e($sk->siswa->id); ?>][nilai_uts]"
                                class="form-control" style="width:90px;padding:8px 10px;" min="0" max="100" step="0.01"
                                value="<?php echo e($nilai?->nilai_uts ?? ''); ?>" placeholder="0-100">
                        </td>
                        <td>
                            <input type="number" name="nilais[<?php echo e($sk->siswa->id); ?>][nilai_uas]"
                                class="form-control" style="width:90px;padding:8px 10px;" min="0" max="100" step="0.01"
                                value="<?php echo e($nilai?->nilai_uas ?? ''); ?>" placeholder="0-100">
                        </td>
                        <td>
                            <?php if($nilai?->nilai_akhir): ?>
                            <div style="display:flex;align-items:center;gap:6px;">
                                <strong style="font-size:16px;color:<?php echo e($nilai->nilai_akhir >= 75 ? '#38a169' : '#e53e3e'); ?>">
                                    <?php echo e(number_format($nilai->nilai_akhir,1)); ?>

                                </strong>
                                <span class="badge badge-<?php echo e($nilai->predikat=='A'?'green':($nilai->predikat=='B'?'blue':($nilai->predikat=='C'?'yellow':'red'))); ?>">
                                    <?php echo e($nilai->predikat); ?>

                                </span>
                            </div>
                            <?php else: ?>
                            <span style="color:var(--text-muted);font-size:13px;">—</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <input type="text" name="nilais[<?php echo e($sk->siswa->id); ?>][catatan]"
                                class="form-control" style="width:120px;padding:8px 10px;"
                                value="<?php echo e($nilai?->catatan ?? ''); ?>" placeholder="Opsional">
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <div style="margin-top:20px;display:flex;justify-content:flex-end;gap:10px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Semua Nilai
            </button>
        </div>
    </form>
    <?php else: ?>
    <div class="empty-state"><i class="fas fa-users"></i><p>Tidak ada siswa atau pilih kelas terlebih dahulu</p></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\USER\smatrack\resources\views/admin/nilai/index.blade.php ENDPATH**/ ?>