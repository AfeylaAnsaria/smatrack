<?php $__env->startSection('title', 'Data Guru'); ?>
<?php $__env->startSection('page-title', 'Data Guru'); ?>
<?php $__env->startSection('page-subtitle', 'Kelola data seluruh guru'); ?>

<?php $__env->startSection('content'); ?>
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
    <div>
        <h1 style="font-size:24px;font-weight:800;">Data Guru</h1>
        <p class="text-muted">Total <?php echo e($guru->total()); ?> guru terdaftar</p>
    </div>
    <button class="btn btn-primary" onclick="openModal('modalTambahGuru')">
        <i class="fas fa-plus"></i> Tambah Guru
    </button>
</div>

<div class="card">
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Guru</th>
                    <th>NIP</th>
                    <th>Email</th>
                    <th>No. HP</th>
                    <th>Login</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $guru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td style="color:var(--text-muted);font-size:12px;"><?php echo e($guru->firstItem() + $i); ?></td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#a78bfa,#7c3aed);color:white;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;flex-shrink:0;">
                                <?php echo e(strtoupper(substr($g->name,0,1))); ?>

                            </div>
                            <div>
                                <div style="font-weight:600;font-size:14px;"><?php echo e($g->name); ?></div>
                                <div style="font-size:11px;color:var(--text-muted);"><?php echo e($g->email); ?></div>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge badge-purple"><?php echo e($g->nip ?? '-'); ?></span></td>
                    <td style="font-size:13px;"><?php echo e($g->email); ?></td>
                    <td style="font-size:13px;"><?php echo e($g->no_hp ?? '-'); ?></td>
                    <td><span class="badge badge-green"><i class="fas fa-check-circle"></i>&nbsp;Aktif</span></td>
                    <td>
                        <form method="POST" action="<?php echo e(route('admin.guru.destroy', $g->id)); ?>" onsubmit="return confirm('Hapus guru ini?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm btn-icon"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="7"><div class="empty-state"><i class="fas fa-chalkboard-teacher"></i><p>Belum ada guru</p></div></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div style="margin-top:16px;"><?php echo e($guru->links()); ?></div>
</div>

<div class="card mt-4" style="background:linear-gradient(135deg,#f5f0ff,white);border-color:#d6bcfa;">
    <div style="display:flex;gap:14px;align-items:center;">
        <div style="font-size:32px;">ℹ️</div>
        <div>
            <div style="font-weight:700;font-size:15px;color:#6b46c1;">Catatan Hak Akses Guru</div>
            <div style="font-size:13px;color:#6b46c1;opacity:.8;margin-top:4px;">
                Guru hanya dapat <strong>melihat</strong> data absensi, nilai, dan jadwal. Untuk input nilai, guru harus menyetor ke admin dan admin yang menginputkan. Guru tidak memiliki akses edit data apapun.
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Guru -->
<div class="modal-overlay" id="modalTambahGuru">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">➕ Tambah Guru Baru</div>
            <button class="modal-close" onclick="closeModal('modalTambahGuru')"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" action="<?php echo e(route('admin.guru.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label class="form-label">Nama Lengkap *</label>
                <input type="text" name="name" class="form-control" placeholder="Nama guru" required>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control" placeholder="nama@guru.smatrack.com" required>
                </div>
                <div class="form-group">
                    <label class="form-label">NIP</label>
                    <input type="text" name="nip" class="form-control" placeholder="Nomor Induk Pegawai">
                </div>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Password *</label>
                    <input type="password" name="password" class="form-control" placeholder="Min. 6 karakter" required>
                </div>
                <div class="form-group">
                    <label class="form-label">No. HP</label>
                    <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx">
                </div>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
                <i class="fas fa-save"></i> Simpan Guru
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\smatrack\resources\views/admin/guru/index.blade.php ENDPATH**/ ?>