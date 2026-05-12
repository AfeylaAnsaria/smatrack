<?php $__env->startSection('title', 'Pengumuman'); ?>
<?php $__env->startSection('page-title', 'Pengumuman'); ?>
<?php $__env->startSection('page-subtitle', 'Buat dan kelola pengumuman sekolah'); ?>

<?php $__env->startSection('content'); ?>
<div class="grid-2">
    <!-- Form Tambah -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">📢 Buat Pengumuman</div>
        </div>
        <form method="POST" action="<?php echo e(route('admin.pengumuman.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label class="form-label">Judul Pengumuman *</label>
                <input type="text" name="judul" class="form-control" placeholder="Judul pengumuman" required>
            </div>
            <div class="form-group">
                <label class="form-label">Tujuan Pengumuman *</label>
                <select name="untuk" class="form-control" required>
                    <option value="semua">🌐 Semua (Siswa + Guru)</option>
                    <option value="siswa">🎒 Khusus Siswa</option>
                    <option value="guru">👨‍🏫 Khusus Guru</option>
                    <option value="kelas12">🎓 Khusus Kelas 12</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Isi Pengumuman *</label>
                <textarea name="isi" class="form-control" rows="6" placeholder="Tulis isi pengumuman di sini..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
                <i class="fas fa-paper-plane"></i> Kirim Pengumuman
            </button>
        </form>
    </div>

    <!-- Daftar Pengumuman -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">📋 Daftar Pengumuman</div>
            <span class="badge badge-pink"><?php echo e($data->total()); ?> total</span>
        </div>
        <div style="max-height:540px;overflow-y:auto;padding-right:4px;">
            <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div style="padding:14px;border-radius:12px;border:1px solid var(--border);margin-bottom:10px;background:white;">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:6px;">
                    <div style="font-weight:700;font-size:14px;flex:1;padding-right:8px;"><?php echo e($p->judul); ?></div>
                    <div style="display:flex;gap:6px;align-items:center;flex-shrink:0;">
                        <span class="badge badge-<?php echo e($p->untuk=='kelas12'?'pink':($p->untuk=='semua'?'green':($p->untuk=='guru'?'purple':'blue'))); ?>">
                            <?php echo e(['semua'=>'Semua','siswa'=>'Siswa','guru'=>'Guru','kelas12'=>'Kelas 12'][$p->untuk]); ?>

                        </span>
                        <form method="POST" action="<?php echo e(route('admin.pengumuman.destroy', $p->id)); ?>" onsubmit="return confirm('Hapus pengumuman ini?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm btn-icon"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
                <div style="font-size:12px;color:var(--text-muted);margin-bottom:6px;">
                    <i class="fas fa-clock"></i> <?php echo e($p->created_at->diffForHumans()); ?>

                    &bull; oleh <?php echo e($p->pembuat->name); ?>

                </div>
                <div style="font-size:13px;color:var(--text);line-height:1.5;max-height:60px;overflow:hidden;"><?php echo e($p->isi); ?></div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty-state"><i class="fas fa-bullhorn"></i><p>Belum ada pengumuman</p></div>
            <?php endif; ?>
        </div>
        <div style="margin-top:12px;"><?php echo e($data->links()); ?></div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\smatrack\resources\views/admin/pengumuman/index.blade.php ENDPATH**/ ?>