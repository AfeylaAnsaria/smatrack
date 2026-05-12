<?php $__env->startSection('title', 'Input Nilai'); ?>
<?php $__env->startSection('page-title', 'Input Nilai'); ?>
<?php $__env->startSection('page-subtitle', 'Masukkan nilai siswa per mata pelajaran'); ?>

<?php $__env->startSection('content'); ?>


<div class="card mb-4">
    <form method="GET" action="<?php echo e(route('admin.nilai.index')); ?>" id="filterForm">
        <div style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
            <div class="form-group" style="margin:0;flex:2;min-width:160px;">
                <label class="form-label">Kelas</label>
                <select name="kelas_id" class="form-control" onchange="document.getElementById('filterForm').submit()">
                    <?php $__currentLoopData = $kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($k->id); ?>" <?php echo e($k->id == $kelasId ? 'selected' : ''); ?>><?php echo e($k->nama_kelas); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-group" style="margin:0;flex:2;min-width:160px;">
                <label class="form-label">Mata Pelajaran</label>
                <select name="mata_pelajaran_id" class="form-control" onchange="document.getElementById('filterForm').submit()">
                    <?php $__currentLoopData = $mapels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($m->id); ?>" <?php echo e($m->id == $mapelId ? 'selected' : ''); ?>><?php echo e($m->nama); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-group" style="margin:0;min-width:130px;">
                <label class="form-label">Semester</label>
                <select name="semester" class="form-control" onchange="document.getElementById('filterForm').submit()">
                    <option value="1" <?php echo e($semester=='1' ? 'selected' : ''); ?>>Semester 1</option>
                    <option value="2" <?php echo e($semester=='2' ? 'selected' : ''); ?>>Semester 2</option>
                </select>
            </div>
        </div>
    </form>
</div>

<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">⭐ Input Nilai Siswa</div>
            <div class="card-subtitle">
                Formula: <strong>NH × 40%</strong> + <strong>UTS × 30%</strong> + <strong>UAS × 30%</strong>
            </div>
        </div>
        <div style="background:var(--blue-50);border:1px solid var(--blue-100);border-radius:8px;padding:8px 14px;font-size:12px;color:var(--blue-600);">
            <i class="fas fa-info-circle"></i> Guru setor nilai → Admin input
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
                        <th style="width:40px;">#</th>
                        <th>Nama Siswa</th>
                        <th style="width:110px;">
                            <div>Nilai Harian</div>
                            <div style="font-size:10px;color:var(--text-muted);font-weight:400;">(NH) bobot 40%</div>
                        </th>
                        <th style="width:110px;">
                            <div>Nilai UTS</div>
                            <div style="font-size:10px;color:var(--text-muted);font-weight:400;">bobot 30%</div>
                        </th>
                        <th style="width:110px;">
                            <div>Nilai UAS</div>
                            <div style="font-size:10px;color:var(--text-muted);font-weight:400;">bobot 30%</div>
                        </th>
                        <th style="width:100px;">Nilai Akhir</th>
                        <th style="width:130px;">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $siswaKelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $sk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(!$sk->siswa): ?> <?php continue; ?> <?php endif; ?>
                    <?php $nilai = $sk->siswa->nilais->first(); ?>
                    <tr>
                        <td style="font-size:12px;color:var(--text-muted);"><?php echo e($i+1); ?></td>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--blue-300),var(--blue-500));color:white;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;flex-shrink:0;">
                                    <?php echo e(strtoupper(substr($sk->siswa->name,0,1))); ?>

                                </div>
                                <div>
                                    <div style="font-weight:600;font-size:14px;"><?php echo e($sk->siswa->name); ?></div>
                                    <div style="font-size:11px;color:var(--text-muted);">NIS: <?php echo e($sk->siswa->nis ?? '-'); ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <input type="number"
                                name="nilais[<?php echo e($sk->siswa->id); ?>][nilai_harian]"
                                class="form-control nh-input" data-row="<?php echo e($sk->siswa->id); ?>"
                                style="width:90px;padding:8px 10px;"
                                min="0" max="100" step="0.01"
                                value="<?php echo e($nilai?->nilai_harian ?? ''); ?>"
                                placeholder="0-100"
                                oninput="hitungAkhir(<?php echo e($sk->siswa->id); ?>)">
                        </td>
                        <td>
                            <input type="number"
                                name="nilais[<?php echo e($sk->siswa->id); ?>][nilai_uts]"
                                class="form-control uts-input" data-row="<?php echo e($sk->siswa->id); ?>"
                                style="width:90px;padding:8px 10px;"
                                min="0" max="100" step="0.01"
                                value="<?php echo e($nilai?->nilai_uts ?? ''); ?>"
                                placeholder="0-100"
                                oninput="hitungAkhir(<?php echo e($sk->siswa->id); ?>)">
                        </td>
                        <td>
                            <input type="number"
                                name="nilais[<?php echo e($sk->siswa->id); ?>][nilai_uas]"
                                class="form-control uas-input" data-row="<?php echo e($sk->siswa->id); ?>"
                                style="width:90px;padding:8px 10px;"
                                min="0" max="100" step="0.01"
                                value="<?php echo e($nilai?->nilai_uas ?? ''); ?>"
                                placeholder="0-100"
                                oninput="hitungAkhir(<?php echo e($sk->siswa->id); ?>)">
                        </td>
                        <td>
                            <div id="akhir-<?php echo e($sk->siswa->id); ?>" style="font-size:22px;font-weight:800;color:<?php echo e(($nilai?->nilai_akhir ?? 0) >= 75 ? 'var(--blue-600)' : '#dc2626'); ?>">
                                <?php if($nilai?->nilai_akhir): ?>
                                    <?php echo e(number_format($nilai->nilai_akhir, 1)); ?>

                                <?php else: ?>
                                    <span style="font-size:14px;color:var(--text-muted);">—</span>
                                <?php endif; ?>
                            </div>
                            <?php if($nilai?->predikat): ?>
                            <span class="badge badge-<?php echo e($nilai->predikat=='A'?'green':($nilai->predikat=='B'?'blue':($nilai->predikat=='C'?'yellow':'red'))); ?>">
                                <?php echo e($nilai->predikat); ?>

                            </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <input type="text"
                                name="nilais[<?php echo e($sk->siswa->id); ?>][catatan]"
                                class="form-control"
                                style="width:120px;padding:8px 10px;"
                                value="<?php echo e($nilai?->catatan ?? ''); ?>"
                                placeholder="Opsional">
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        
        <?php $kkm = $mapels->find($mapelId)?->kkm ?? 75; ?>
        <div style="margin-top:14px;padding:10px 16px;background:var(--blue-50);border-radius:10px;border:1px solid var(--blue-100);display:flex;align-items:center;gap:10px;">
            <i class="fas fa-info-circle" style="color:var(--blue-500);"></i>
            <span style="font-size:13px;color:var(--blue-700);">
                KKM mata pelajaran ini: <strong><?php echo e($kkm); ?></strong> —
                Nilai di bawah KKM akan ditampilkan <span style="color:#dc2626;font-weight:700;">merah</span>
            </span>
        </div>

        <div style="margin-top:16px;display:flex;justify-content:flex-end;gap:10px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Semua Nilai
            </button>
        </div>
    </form>
    <?php else: ?>
    <div class="empty-state">
        <i class="fas fa-users"></i>
        <p>Tidak ada siswa di kelas ini atau pilih kelas terlebih dahulu</p>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function hitungAkhir(siswaId) {
    const nh  = parseFloat(document.querySelector(`.nh-input[data-row="${siswaId}"]`)?.value) || 0;
    const uts = parseFloat(document.querySelector(`.uts-input[data-row="${siswaId}"]`)?.value) || 0;
    const uas = parseFloat(document.querySelector(`.uas-input[data-row="${siswaId}"]`)?.value) || 0;

    const el = document.getElementById(`akhir-${siswaId}`);
    if (!el) return;

    if (nh > 0 || uts > 0 || uas > 0) {
        const akhir = (nh * 0.4) + (uts * 0.3) + (uas * 0.3);
        const kkm = <?php echo e($kkm ?? 75); ?>;
        el.style.color = akhir >= kkm ? 'var(--blue-600)' : '#dc2626';
        el.innerHTML = akhir.toFixed(1) + '<br><small style="font-size:11px;">' + getPredikat(akhir) + '</small>';
    } else {
        el.innerHTML = '<span style="font-size:14px;color:var(--text-muted);">—</span>';
    }
}

function getPredikat(nilai) {
    if (nilai >= 90) return '🏆 A';
    if (nilai >= 80) return '⭐ B';
    if (nilai >= 70) return '✅ C';
    if (nilai >= 60) return '⚠️ D';
    return '❌ E';
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\smatrack\resources\views/admin/nilai/index.blade.php ENDPATH**/ ?>