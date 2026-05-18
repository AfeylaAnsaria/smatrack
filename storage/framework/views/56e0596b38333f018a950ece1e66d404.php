
<?php $__env->startSection('title', 'Data Siswa'); ?>
<?php $__env->startSection('page-title', 'Data Siswa'); ?>
<?php $__env->startSection('page-subtitle', 'Kelola data seluruh siswa'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header" style="display:flex;align-items:center;justify-content:space-between;">
    <div>
        <h1 class="page-header" style="font-size:24px;font-weight:800;">Data Siswa</h1>
        <p class="text-muted">Total <?php echo e($siswa->total()); ?> siswa terdaftar</p>
    </div>
    <button class="btn btn-primary" onclick="openModal('modalTambahSiswa')">

    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            <?php if($errors->any()): ?>
                openModal('modalTambahSiswa');
            <?php endif; ?>
        });
    </script>
    <?php $__env->stopPush(); ?>
        <i class="fas fa-plus"></i> Tambah Siswa
    </button>
</div>

<div class="card">
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Siswa</th>
                    <th>NIS</th>
                    <th>Email</th>
                    <th>Kelas</th>
                    <th>No. HP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $siswa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td style="color:var(--text-muted);font-size:12px;"><?php echo e($siswa->firstItem() + $i); ?></td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--pink-300),var(--pink-500));color:white;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;flex-shrink:0;">
                                <?php echo e(strtoupper(substr($s->name,0,1))); ?>

                            </div>
                            <div>
                                <div style="font-weight:600;font-size:14px;"><?php echo e($s->name); ?></div>
                                <div style="font-size:11px;color:var(--text-muted);"><?php echo e($s->email); ?></div>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge badge-pink"><?php echo e($s->nis ?? '-'); ?></span></td>
                    <td style="font-size:13px;"><?php echo e($s->email); ?></td>
                    <td>
                        <?php $sk = $s->siswaKelas->first(); ?>
                        <?php if($sk): ?>
                            <span class="badge badge-<?php echo e($sk->kelas->tingkat == '12' ? 'rose' : ($sk->kelas->tingkat == '11' ? 'purple' : 'blue')); ?>">
                                <?php echo e($sk->kelas->nama_kelas); ?>

                            </span>
                        <?php else: ?>
                            <span class="badge badge-gray">Belum ada kelas</span>
                        <?php endif; ?>
                    </td>
                    <td style="font-size:13px;"><?php echo e($s->no_hp ?? '-'); ?></td>
                    <td>
                        <form method="POST" action="<?php echo e(route('admin.siswa.destroy', $s->id)); ?>" onsubmit="return confirm('Hapus siswa ini?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm btn-icon"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="7"><div class="empty-state"><i class="fas fa-user-graduate"></i><p>Belum ada siswa</p></div></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div style="margin-top:16px;"><?php echo e($siswa->links()); ?></div>
</div>

<!-- Modal Tambah Siswa -->
<div class="modal-overlay" id="modalTambahSiswa">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">➕ Tambah Siswa Baru</div>
            <button class="modal-close" onclick="closeModal('modalTambahSiswa')"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" action="<?php echo e(route('admin.siswa.store')); ?>">
            <?php echo csrf_field(); ?>
            <?php if($errors->any()): ?>
            <div style="margin-bottom:12px;">
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <strong>Terdapat error pada input:</strong>
                    <ul style="margin-top:6px;margin-left:18px;">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($err); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
            <div class="form-group">
                <label class="form-label">Nama Lengkap *</label>
                <input type="text" name="name" class="form-control" placeholder="Nama siswa" required>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control" placeholder="contoh: tanti.12@siswa.com / widya12@siswa.com" required>
                    <div class="text-muted" style="margin-top:6px;">
                        Wajib beda per tingkat: kelas 12 pakai penanda 12, kelas 11 penanda 11, kelas 10 penanda 10 (boleh pakai titik atau tanpa titik).
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">NIS</label>
                    <input type="text" name="nis" class="form-control" placeholder="Nomor Induk Siswa">
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
            <div class="form-group">
                <label class="form-label">Kelas *</label>
                <select name="kelas_id" class="form-control" required>
                    <option value="">-- Pilih Kelas --</option>
                    <?php $__currentLoopData = $kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($k->id); ?>"><?php echo e($k->nama_kelas); ?> (Kelas <?php echo e($k->tingkat); ?>)</option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Tahun Ajaran *</label>
                <select name="tahun_ajaran_id" class="form-control" required>
                    <option value="">-- Pilih Tahun Ajaran --</option>
                    <?php $__currentLoopData = $tas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($ta->id); ?>" <?php echo e($ta->is_aktif ? 'selected' : ''); ?>>
                        <?php echo e($ta->tahun); ?> <?php echo e($ta->is_aktif ? '(Aktif)' : ''); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="2" placeholder="Alamat lengkap"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
                <i class="fas fa-save"></i> Simpan Siswa
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\smatrack\resources\views/admin/siswa/index.blade.php ENDPATH**/ ?>