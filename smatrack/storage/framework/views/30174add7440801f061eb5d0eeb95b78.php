<?php $__env->startSection('title', 'Kelola Kelas'); ?>
<?php $__env->startSection('page-title', 'Kelola Kelas'); ?>
<?php $__env->startSection('page-subtitle', 'Manajemen kelas tahun ajaran aktif'); ?>

<?php $__env->startSection('content'); ?>
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
    <div>
        <h1 style="font-size:24px;font-weight:800;">Kelola Kelas</h1>
        <p class="text-muted">Tahun Ajaran: <?php echo e($ta?->tahun); ?></p>
    </div>
    <button class="btn btn-primary" onclick="openModal('modalTambahKelas')">
        <i class="fas fa-plus"></i> Tambah Kelas
    </button>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px;margin-bottom:24px;">
    <?php $__empty_1 = true; $__currentLoopData = $kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="card" style="padding:20px;border-left:4px solid <?php echo e($k->tingkat=='12' ? 'var(--pink-500)' : ($k->tingkat=='11' ? '#805ad5' : '#3182ce')); ?>;">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:12px;">
            <div>
                <div style="font-size:18px;font-weight:800;color:var(--text);"><?php echo e($k->nama_kelas); ?></div>
                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;">
                    Kelas <?php echo e($k->tingkat); ?> &bull; <?php echo e($k->jurusan ?? 'Umum'); ?>

                </div>
            </div>
            <span class="badge badge-<?php echo e($k->tingkat=='12' ? 'pink' : ($k->tingkat=='11' ? 'purple' : 'blue')); ?>">
                Kelas <?php echo e($k->tingkat); ?>

            </span>
        </div>
        <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
            <i class="fas fa-users" style="color:var(--text-muted);font-size:13px;"></i>
            <span style="font-size:13px;"><strong><?php echo e($k->siswaKelas->count()); ?></strong> siswa</span>
        </div>
        <div style="display:flex;align-items:center;gap:8px;">
            <i class="fas fa-chalkboard-teacher" style="color:var(--text-muted);font-size:13px;"></i>
            <span style="font-size:13px;">Wali: <strong><?php echo e($k->waliKelas?->name ?? 'Belum ditentukan'); ?></strong></span>
        </div>
        <?php if($k->tingkat == '12'): ?>
        <div style="margin-top:12px;padding:8px 12px;background:var(--pink-50);border-radius:8px;border:1px solid var(--pink-200);">
            <span style="font-size:11px;color:var(--pink-600);font-weight:600;">🎓 Fitur Tracker Kuliah Aktif</span>
        </div>
        <?php endif; ?>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="card"><div class="empty-state"><i class="fas fa-school"></i><p>Belum ada kelas</p></div></div>
    <?php endif; ?>
</div>

<!-- Modal Tambah Kelas -->
<div class="modal-overlay" id="modalTambahKelas">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">➕ Tambah Kelas Baru</div>
            <button class="modal-close" onclick="closeModal('modalTambahKelas')"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" action="<?php echo e(route('admin.kelas.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label class="form-label">Nama Kelas *</label>
                <input type="text" name="nama_kelas" class="form-control" placeholder="Contoh: XII IPA 1" required>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Tingkat *</label>
                    <select name="tingkat" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="10">Kelas 10</option>
                        <option value="11">Kelas 11</option>
                        <option value="12">Kelas 12</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Jurusan</label>
                    <select name="jurusan" class="form-control">
                        <option value="">-- Pilih --</option>
                        <option value="IPA">IPA</option>
                        <option value="IPS">IPS</option>
                        <option value="Bahasa">Bahasa</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Wali Kelas</label>
                <select name="wali_kelas_id" class="form-control">
                    <option value="">-- Belum ditentukan --</option>
                    <?php $__currentLoopData = $gurus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($g->id); ?>"><?php echo e($g->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
                <i class="fas fa-save"></i> Simpan Kelas
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\USER\smatrack\resources\views/admin/kelas/index.blade.php ENDPATH**/ ?>