<?php $__env->startSection('title', 'Input Absensi'); ?>
<?php $__env->startSection('page-title', 'Input Absensi'); ?>
<?php $__env->startSection('page-subtitle', 'Catat kehadiran siswa'); ?>

<?php $__env->startSection('content'); ?>


<div class="card mb-4">
    <form method="GET" action="<?php echo e(route('admin.absensi.index')); ?>" id="filterForm">
        <div style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
            <div class="form-group" style="margin:0;flex:2;min-width:180px;">
                <label class="form-label">Kelas</label>
                <select name="kelas_id" class="form-control" onchange="document.getElementById('filterForm').submit()">
                    <?php $__currentLoopData = $kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($k->id); ?>" <?php echo e($k->id == $kelasId ? 'selected' : ''); ?>>
                        <?php echo e($k->nama_kelas); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-group" style="margin:0;flex:1;min-width:160px;">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="<?php echo e($tanggal); ?>"
                    onchange="document.getElementById('filterForm').submit()">
            </div>
            <div class="form-group" style="margin:0;min-width:160px;">
                <label class="form-label">Mata Pelajaran</label>
                <select name="mata_pelajaran_id" class="form-control" onchange="document.getElementById('filterForm').submit()">
                    <option value="">-- Pilih Mapel --</option>
                    <?php $__currentLoopData = $mapels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($m->id); ?>" <?php echo e($m->id == $mapelId ? 'selected' : ''); ?>>
                        <?php echo e($m->nama); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>

        
        <div style="display:flex;gap:8px;margin-top:12px;align-items:center;">
            <a href="<?php echo e(route('admin.absensi.index', ['kelas_id'=>$kelasId, 'tanggal'=>\Carbon\Carbon::parse($tanggal)->subDay()->toDateString(), 'mata_pelajaran_id'=>$mapelId])); ?>"
               class="btn btn-secondary btn-sm">
                <i class="fas fa-chevron-left"></i> Kemarin
            </a>
            <span style="font-size:13px;font-weight:600;color:var(--text);">
                <?php echo e(\Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y')); ?>

            </span>
            <a href="<?php echo e(route('admin.absensi.index', ['kelas_id'=>$kelasId, 'tanggal'=>\Carbon\Carbon::parse($tanggal)->addDay()->toDateString(), 'mata_pelajaran_id'=>$mapelId])); ?>"
               class="btn btn-secondary btn-sm">
                Besok <i class="fas fa-chevron-right"></i>
            </a>
            <a href="<?php echo e(route('admin.absensi.index', ['kelas_id'=>$kelasId, 'tanggal'=>today()->toDateString(), 'mata_pelajaran_id'=>$mapelId])); ?>"
               class="btn btn-primary btn-sm">
                <i class="fas fa-calendar-day"></i> Hari Ini
            </a>
        </div>
    </form>
</div>


<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">📋 Form Absensi</div>
            <div class="card-subtitle">
                <?php echo e(\Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y')); ?>

                <?php if($mapelId): ?>
                — <?php echo e($mapels->find($mapelId)?->nama); ?>

                <?php endif; ?>
            </div>
        </div>
        <?php if($siswaKelas->count() > 0 && $mapelId): ?>
        <div style="display:flex;gap:8px;">
            <button type="button" class="btn btn-secondary btn-sm" onclick="setAll('hadir')">
                <i class="fas fa-check" style="color:#16a34a;"></i> Semua Hadir
            </button>
            <button type="button" class="btn btn-secondary btn-sm" onclick="setAll('alpa')">
                <i class="fas fa-times" style="color:#dc2626;"></i> Semua Alpa
            </button>
        </div>
        <?php endif; ?>
    </div>

    <?php if(!$mapelId): ?>
    <div class="empty-state">
        <i class="fas fa-hand-pointer"></i>
        <p>Pilih mata pelajaran terlebih dahulu untuk mulai mengisi absensi</p>
    </div>
    <?php elseif($siswaKelas->count() == 0): ?>
    <div class="empty-state">
        <i class="fas fa-users"></i>
        <p>Tidak ada siswa di kelas ini</p>
    </div>
    <?php else: ?>
    <form method="POST" action="<?php echo e(route('admin.absensi.store')); ?>" id="absensiForm">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="kelas_id" value="<?php echo e($kelasId); ?>">
        <input type="hidden" name="mata_pelajaran_id" value="<?php echo e($mapelId); ?>">
        <input type="hidden" name="tanggal" value="<?php echo e($tanggal); ?>">

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th style="width:40px;">#</th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th style="text-align:center;width:80px;">
                            <span style="color:#16a34a;"><i class="fas fa-check-circle"></i> Hadir</span>
                        </th>
                        <th style="text-align:center;width:80px;">
                            <span style="color:#2563eb;"><i class="fas fa-procedures"></i> Sakit</span>
                        </th>
                        <th style="text-align:center;width:80px;">
                            <span style="color:#d97706;"><i class="fas fa-door-open"></i> Izin</span>
                        </th>
                        <th style="text-align:center;width:80px;">
                            <span style="color:#dc2626;"><i class="fas fa-times-circle"></i> Alpa</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $siswaKelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $sk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(!$sk->siswa): ?> <?php continue; ?> <?php endif; ?>
                    <?php
                        $existing = $absensi->where('siswa_id', $sk->siswa->id)
                                           ->where('mata_pelajaran_id', $mapelId)
                                           ->first();
                        $currentStatus = $existing?->status ?? 'hadir';
                    ?>
                    <tr id="row-<?php echo e($sk->siswa->id); ?>">
                        <td style="font-size:12px;color:var(--text-muted);"><?php echo e($i+1); ?></td>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,var(--blue-300),var(--blue-500));color:white;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;flex-shrink:0;">
                                    <?php echo e(strtoupper(substr($sk->siswa->name,0,1))); ?>

                                </div>
                                <div>
                                    <div style="font-weight:600;font-size:14px;"><?php echo e($sk->siswa->name); ?></div>
                                    <?php if($existing): ?>
                                    <div style="font-size:10px;color:var(--text-muted);">Data tersimpan</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge badge-blue"><?php echo e($sk->siswa->nis ?? '-'); ?></span></td>

                        <?php $__currentLoopData = ['hadir'=>'#16a34a','sakit'=>'#2563eb','izin'=>'#d97706','alpa'=>'#dc2626']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <td style="text-align:center;">
                            <label style="cursor:pointer;display:flex;align-items:center;justify-content:center;width:100%;height:40px;">
                                <input type="radio"
                                    name="absensis[<?php echo e($sk->siswa->id); ?>]"
                                    value="<?php echo e($status); ?>"
                                    <?php echo e($currentStatus == $status ? 'checked' : ''); ?>

                                    onchange="updateRow(<?php echo e($sk->siswa->id); ?>, '<?php echo e($status); ?>')"
                                    style="width:18px;height:18px;accent-color:<?php echo e($color); ?>;cursor:pointer;">
                            </label>
                        </td>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        
        <div style="display:flex;gap:10px;margin-top:16px;padding:12px 16px;background:var(--blue-50);border-radius:10px;align-items:center;flex-wrap:wrap;">
            <span style="font-size:13px;font-weight:600;color:var(--text-muted);">Rekap:</span>
            <span id="count-hadir" style="font-size:13px;font-weight:700;color:#16a34a;">H: 0</span>
            <span id="count-sakit" style="font-size:13px;font-weight:700;color:#2563eb;">S: 0</span>
            <span id="count-izin" style="font-size:13px;font-weight:700;color:#d97706;">I: 0</span>
            <span id="count-alpa" style="font-size:13px;font-weight:700;color:#dc2626;">A: 0</span>
        </div>

        <div style="margin-top:16px;display:flex;justify-content:flex-end;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Absensi
            </button>
        </div>
    </form>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function setAll(status) {
    document.querySelectorAll(`input[value="${status}"]`).forEach(r => {
        r.checked = true;
        updateRow(r.name.match(/\d+/)[0], status);
    });
    updateCount();
}

function updateRow(siswaId, status) {
    updateCount();
}

function updateCount() {
    const statuses = ['hadir','sakit','izin','alpa'];
    statuses.forEach(s => {
        const count = document.querySelectorAll(`input[value="${s}"]:checked`).length;
        const labels = {'hadir':'H','sakit':'S','izin':'I','alpa':'A'};
        const el = document.getElementById(`count-${s}`);
        if (el) el.textContent = `${labels[s]}: ${count}`;
    });
}

// Hitung saat halaman load
document.addEventListener('DOMContentLoaded', updateCount);
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\smatrack\resources\views/admin/absensi/index.blade.php ENDPATH**/ ?>