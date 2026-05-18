
<?php $__env->startSection('title', 'Data Kuliah Kelas 12'); ?>
<?php $__env->startSection('page-title', 'Tracker Kuliah Kelas 12'); ?>
<?php $__env->startSection('page-subtitle', 'Pantau data perguruan tinggi siswa kelas 12'); ?>

<?php $__env->startSection('content'); ?>

<datalist id="ptn-options">
    <?php $__currentLoopData = ($ptns ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ptn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <option value="<?php echo e($ptn); ?>"></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</datalist>


<div class="stats-grid" style="grid-template-columns:repeat(4,1fr);">
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-users"></i></div>
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
    
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">🎓 Input Data Kuliah</div>
                <div class="card-subtitle">Tambah atau update data pendaftaran kuliah siswa kelas 12</div>
            </div>
        </div>
        <form method="POST" action="<?php echo e(route('admin.kuliah.store')); ?>">
            <?php echo csrf_field(); ?>

            <div class="form-group">
                <label class="form-label">Siswa Kelas 12 *</label>
                <select name="siswa_id" class="form-control" required>
                    <option value="">-- Pilih Siswa --</option>
                    <?php $__empty_1 = true; $__currentLoopData = $siswaKelas12; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <option value="<?php echo e($s->id); ?>"><?php echo e($s->name); ?> (<?php echo e($s->nis ?? 'NIS: -'); ?>)</option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <option disabled>Tidak ada siswa kelas 12</option>
                    <?php endif; ?>
                </select>
                <?php if($siswaKelas12->isEmpty()): ?>
                <div style="font-size:12px;color:#dc2626;margin-top:4px;">
                    <i class="fas fa-exclamation-triangle"></i>
                    Tidak ada siswa kelas 12. Pastikan siswa sudah terdaftar di kelas tingkat 12.
                </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label class="form-label">Jalur Masuk *</label>
                <select name="jalur" class="form-control" required>
                    <option value="">-- Pilih Jalur --</option>
                    <option value="SNBP">SNBP (Seleksi Nasional Berdasarkan Prestasi)</option>
                    <option value="SNBT">SNBT (Seleksi Nasional Berdasarkan Tes)</option>
                    <option value="Mandiri">Mandiri</option>
                    <option value="Beasiswa">Beasiswa</option>
                </select>
            </div>

            <div style="background:var(--blue-50);border-radius:12px;padding:16px;margin-bottom:16px;border:1px solid var(--blue-100);">
                <div style="font-size:13px;font-weight:700;color:var(--blue-700);margin-bottom:10px;">🏛️ Pilihan Pertama</div>
                <div class="form-group" style="margin-bottom:8px;">
                    <label class="form-label">Universitas *</label>
                    <input type="text" name="universitas_tujuan_1" class="form-control" placeholder="Contoh: Universitas Indonesia" list="ptn-options" required>
                    <div style="font-size:11px;color:var(--text-muted);margin-top:4px;">Ketik nama PTN atau klik panah dropdown untuk pilih.</div>
                </div>
                <div class="form-group" style="margin:0;">
                    <label class="form-label">Program Studi *</label>
                    <input type="text" name="prodi_tujuan_1" class="form-control" placeholder="Contoh: Teknik Informatika" required>
                </div>
            </div>

            <div style="background:#f5f0ff;border-radius:12px;padding:16px;margin-bottom:16px;border:1px solid #d6bcfa;">
                <div style="font-size:13px;font-weight:700;color:#6b46c1;margin-bottom:10px;">🏛️ Pilihan Kedua (opsional)</div>
                <div class="form-group" style="margin-bottom:8px;">
                    <label class="form-label">Universitas</label>
                    <input type="text" name="universitas_tujuan_2" class="form-control" placeholder="Universitas pilihan ke-2" list="ptn-options">
                </div>
                <div class="form-group" style="margin:0;">
                    <label class="form-label">Program Studi</label>
                    <input type="text" name="prodi_tujuan_2" class="form-control" placeholder="Prodi pilihan ke-2">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Status Pendaftaran</label>
                <select name="status" class="form-control" id="statusSelect" onchange="toggleDiterima()">
                    <option value="belum_daftar">📝 Belum Mendaftar</option>
                    <option value="sedang_proses">⏳ Sedang Proses</option>
                    <option value="diterima">✅ Diterima</option>
                    <option value="tidak_diterima">❌ Tidak Diterima</option>
                </select>
            </div>

            <div id="detailDiterima" style="display:none;background:#f0fff4;border-radius:12px;padding:16px;margin-bottom:16px;border:1px solid #c6f6d5;">
                <div style="font-size:13px;font-weight:700;color:#276749;margin-bottom:10px;">✅ Detail Kelulusan</div>
                <div class="grid-2">
                    <div class="form-group" style="margin-bottom:8px;">
                        <label class="form-label">Universitas Diterima</label>
                        <input type="text" name="universitas_diterima" class="form-control" placeholder="Universitas" list="ptn-options">
                    </div>
                    <div class="form-group" style="margin-bottom:8px;">
                        <label class="form-label">Prodi Diterima</label>
                        <input type="text" name="prodi_diterima" class="form-control" placeholder="Program Studi">
                    </div>
                </div>
                <div class="form-group" style="margin:0;">
                    <label class="form-label">Tanggal Pengumuman</label>
                    <input type="date" name="tanggal_pengumuman" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Catatan</label>
                <textarea name="catatan" class="form-control" rows="2" placeholder="Catatan tambahan..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
                <i class="fas fa-save"></i> Simpan Data Kuliah
            </button>
        </form>
    </div>

    
    <div class="card" style="overflow:hidden;">
        <div class="card-header">
            <div>
                <div class="card-title">📊 Daftar Data Kuliah</div>
                <div class="card-subtitle"><?php echo e($data->total()); ?> data terdaftar</div>
            </div>
        </div>

        
        <form method="GET" style="display:flex;gap:8px;margin-bottom:16px;">
            <select name="status" class="form-control" style="flex:1;" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="diterima" <?php echo e(request('status')=='diterima'?'selected':''); ?>>✅ Diterima</option>
                <option value="sedang_proses" <?php echo e(request('status')=='sedang_proses'?'selected':''); ?>>⏳ Proses</option>
                <option value="tidak_diterima" <?php echo e(request('status')=='tidak_diterima'?'selected':''); ?>>❌ Tidak Diterima</option>
                <option value="belum_daftar" <?php echo e(request('status')=='belum_daftar'?'selected':''); ?>>📝 Belum Daftar</option>
            </select>
            <select name="jalur" class="form-control" style="flex:1;" onchange="this.form.submit()">
                <option value="">Semua Jalur</option>
                <option value="SNBP" <?php echo e(request('jalur')=='SNBP'?'selected':''); ?>>SNBP</option>
                <option value="SNBT" <?php echo e(request('jalur')=='SNBT'?'selected':''); ?>>SNBT</option>
                <option value="Mandiri" <?php echo e(request('jalur')=='Mandiri'?'selected':''); ?>>Mandiri</option>
                <option value="Beasiswa" <?php echo e(request('jalur')=='Beasiswa'?'selected':''); ?>>Beasiswa</option>
            </select>
        </form>

        <div style="max-height:520px;overflow-y:auto;">
            <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php if(!$d->siswa): ?> <?php continue; ?> <?php endif; ?>
            <div style="padding:14px;border-radius:12px;border:1px solid var(--border);margin-bottom:10px;background:white;">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:8px;">
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,var(--blue-300),var(--blue-500));color:white;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;flex-shrink:0;">
                            <?php echo e(strtoupper(substr($d->siswa->name,0,1))); ?>

                        </div>
                        <div>
                            <div style="font-weight:700;font-size:14px;"><?php echo e($d->siswa->name); ?></div>
                            <div style="font-size:11px;color:var(--text-muted);">NIS: <?php echo e($d->siswa->nis ?? '-'); ?></div>
                        </div>
                    </div>
                    <?php
                        $badge = match($d->status) {
                            'diterima' => 'green', 'sedang_proses' => 'yellow',
                            'tidak_diterima' => 'red', default => 'gray'
                        };
                        $statusLabel = match($d->status) {
                            'diterima' => '✅ Diterima', 'sedang_proses' => '⏳ Proses',
                            'tidak_diterima' => '❌ Tidak Diterima', default => '📝 Belum Daftar'
                        };
                    ?>
                    <span class="badge badge-<?php echo e($badge); ?>"><?php echo e($statusLabel); ?></span>
                </div>

                <div style="font-size:12px;margin-bottom:6px;">
                    <span class="badge badge-blue" style="margin-right:4px;"><?php echo e($d->jalur); ?></span>
                    🏛️ <strong><?php echo e($d->universitas_tujuan_1); ?></strong> — <?php echo e($d->prodi_tujuan_1); ?>

                </div>
                <?php if($d->universitas_tujuan_2): ?>
                <div style="font-size:12px;color:var(--text-muted);margin-bottom:6px;">
                    2️⃣ <?php echo e($d->universitas_tujuan_2); ?> — <?php echo e($d->prodi_tujuan_2); ?>

                </div>
                <?php endif; ?>

                <?php if($d->status == 'diterima' && $d->universitas_diterima): ?>
                <div style="font-size:12px;color:#276749;background:#f0fff4;padding:6px 10px;border-radius:8px;margin-bottom:6px;">
                    🎉 Diterima di <strong><?php echo e($d->universitas_diterima); ?></strong> — <?php echo e($d->prodi_diterima); ?>

                    <?php if($d->tanggal_pengumuman): ?>
                    <span style="color:var(--text-muted);">(<?php echo e($d->tanggal_pengumuman->format('d/m/Y')); ?>)</span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <div style="display:flex;gap:6px;margin-top:8px;">
                    <button class="btn btn-secondary btn-sm" onclick="openUpdateModal(<?php echo e($d->id); ?>, '<?php echo e($d->status); ?>', '<?php echo e($d->universitas_diterima); ?>', '<?php echo e($d->prodi_diterima); ?>')">
                        <i class="fas fa-edit"></i> Update Status
                    </button>
                    <form method="POST" action="<?php echo e(route('admin.kuliah.destroy', $d->id)); ?>" onsubmit="return confirm('Hapus data ini?')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger btn-sm btn-icon"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty-state"><i class="fas fa-university"></i><p>Belum ada data kuliah</p></div>
            <?php endif; ?>
        </div>
        <div style="margin-top:12px;"><?php echo e($data->links()); ?></div>
    </div>
</div>


<div class="modal-overlay" id="modalUpdateStatus">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">✏️ Update Status Kuliah</div>
            <button class="modal-close" onclick="closeModal('modalUpdateStatus')"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" id="formUpdateStatus">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div class="form-group">
                <label class="form-label">Status Baru</label>
                <select name="status" id="updateStatus" class="form-control" onchange="toggleUpdateDiterima()">
                    <option value="belum_daftar">📝 Belum Mendaftar</option>
                    <option value="sedang_proses">⏳ Sedang Proses</option>
                    <option value="diterima">✅ Diterima</option>
                    <option value="tidak_diterima">❌ Tidak Diterima</option>
                </select>
            </div>
            <div id="updateDiterimaSection" style="display:none;">
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Universitas Diterima</label>
                        <input type="text" name="universitas_diterima" id="updateUniv" class="form-control" list="ptn-options">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Prodi Diterima</label>
                        <input type="text" name="prodi_diterima" id="updateProdi" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Pengumuman</label>
                    <input type="date" name="tanggal_pengumuman" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Catatan</label>
                <textarea name="catatan" class="form-control" rows="2"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
                <i class="fas fa-save"></i> Update Status
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function toggleDiterima() {
    const val = document.getElementById('statusSelect').value;
    document.getElementById('detailDiterima').style.display = val === 'diterima' ? 'block' : 'none';
}

function toggleUpdateDiterima() {
    const val = document.getElementById('updateStatus').value;
    document.getElementById('updateDiterimaSection').style.display = val === 'diterima' ? 'block' : 'none';
}

function openUpdateModal(id, status, univ, prodi) {
    document.getElementById('formUpdateStatus').action = `/admin/kuliah/${id}`;
    document.getElementById('updateStatus').value = status;
    document.getElementById('updateUniv').value = univ || '';
    document.getElementById('updateProdi').value = prodi || '';
    toggleUpdateDiterima();
    openModal('modalUpdateStatus');
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\smatrack\resources\views/admin/kuliah/index.blade.php ENDPATH**/ ?>