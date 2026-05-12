<?php $__env->startSection('title', 'Data Kuliah Kelas 12'); ?>
<?php $__env->startSection('page-title', 'Tracker Kuliah Kelas 12'); ?>
<?php $__env->startSection('page-subtitle', 'Pantau data perguruan tinggi siswa kelas 12'); ?>

<?php $__env->startSection('content'); ?>
<!-- Stats -->
<div class="stats-grid" style="grid-template-columns:repeat(4,1fr);">
    <div class="stat-card">
        <div class="stat-icon pink"><i class="fas fa-users"></i></div>
        <div><div class="stat-value"><?php echo e($stats['total']); ?></div><div class="stat-label">Total Pendaftar</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
        <div><div class="stat-value"><?php echo e($stats['diterima']); ?></div><div class="stat-label">Diterima</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-hourglass-half"></i></div>
        <div><div class="stat-value"><?php echo e($stats['proses']); ?></div><div class="stat-label">Sedang Proses</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon rose"><i class="fas fa-times-circle"></i></div>
        <div><div class="stat-value"><?php echo e($stats['tidak_diterima']); ?></div><div class="stat-label">Tidak Diterima</div></div>
    </div>
</div>

<div class="grid-2">
    <!-- FORM INPUT -->
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">🎓 Input Data Kuliah</div>
                <div class="card-subtitle">Tambah atau update data pendaftaran kuliah siswa</div>
            </div>
        </div>

        <form method="POST" action="<?php echo e(route('admin.kuliah.store')); ?>">
            <?php echo csrf_field(); ?>

            <div class="form-group">
                <label class="form-label">Siswa Kelas 12 *</label>
                <select name="siswa_id" class="form-control" required>
                    <option value="">-- Pilih Siswa --</option>
                    <?php $__currentLoopData = $siswaKelas12; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($s->id); ?>"><?php echo e($s->name); ?> (<?php echo e($s->nis ?? '-'); ?>)</option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Jalur Masuk *</label>
                <select name="jalur" class="form-control" required>
                    <option value="">-- Pilih Jalur --</option>
                    <option value="SNBP">SNBP</option>
                    <option value="SNBT">SNBT</option>
                    <option value="Mandiri">Mandiri</option>
                    <option value="Beasiswa">Beasiswa</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Universitas *</label>
                <input type="text" name="universitas_tujuan_1" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label">Prodi *</label>
                <input type="text" name="prodi_tujuan_1" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;">
                Simpan
            </button>
        </form>
    </div>

    <!-- LIST DATA -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">📊 Data Kuliah</div>
        </div>

        <div style="max-height:520px;overflow-y:auto;">

            <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                
                <?php if(!$d->siswa): ?> 
                    <?php continue; ?> 
                <?php endif; ?>

                <div style="padding:14px;border:1px solid #eee;margin-bottom:10px;border-radius:10px;">

                    <div style="font-weight:bold;">
                        <?php echo e($d->siswa->name); ?>

                    </div>

                    <div style="font-size:12px;color:gray;">
                        <?php echo e($d->siswa->nis ?? '-'); ?>

                    </div>

                    <div style="margin-top:6px;">
                        <?php echo e($d->universitas_tujuan_1); ?> - <?php echo e($d->prodi_tujuan_1); ?>

                    </div>

                    <div style="margin-top:6px;">
                        Status: <b><?php echo e($d->status); ?></b>
                    </div>

                </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p>Tidak ada data</p>
            <?php endif; ?>

        </div>

        <div style="margin-top:10px;">
            <?php echo e($data->links()); ?>

        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\smatrack\resources\views/admin/kuliah/index.blade.php ENDPATH**/ ?>