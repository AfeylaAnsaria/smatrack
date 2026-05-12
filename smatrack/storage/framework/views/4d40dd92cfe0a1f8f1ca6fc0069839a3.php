<?php $__env->startSection('title', 'Input Absensi'); ?>
<?php $__env->startSection('page-title', 'Input Absensi'); ?>
<?php $__env->startSection('page-subtitle', 'Catat kehadiran siswa'); ?>

<?php $__env->startSection('content'); ?>
<!-- Filter -->
<div class="card mb-4">
    <form method="GET" action="<?php echo e(route('admin.absensi.index')); ?>" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
        <div class="form-group" style="margin:0;flex:1;min-width:150px;">
            <label class="form-label">Kelas</label>
            <select name="kelas_id" class="form-control">
                <?php $__currentLoopData = $kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($k->id); ?>" <?php echo e($k->id == $kelasId ? 'selected' : ''); ?>><?php echo e($k->nama_kelas); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="form-group" style="margin:0;flex:1;min-width:150px;">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="<?php echo e($tanggal); ?>">
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filter</button>
    </form>
</div>

<!-- Form Absensi -->
<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">📋 Form Absensi</div>
            <div class="card-subtitle">Tanggal: <?php echo e(\Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y')); ?></div>
        </div>
    </div>

    <?php if($siswaKelas->count() > 0): ?>
    <form method="POST" action="<?php echo e(route('admin.absensi.store')); ?>">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="kelas_id" value="<?php echo e($kelasId); ?>">
        <input type="hidden" name="tanggal" value="<?php echo e($tanggal); ?>">

        <div class="form-group">
            <label class="form-label">Mata Pelajaran *</label>
            <select name="mata_pelajaran_id" class="form-control" required>
                <option value="">-- Pilih Mata Pelajaran --</option>
                <?php $__currentLoopData = $mapels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($m->id); ?>"><?php echo e($m->nama); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <!-- Quick actions -->
        <div style="display:flex;gap:8px;margin-bottom:16px;">
            <button type="button" class="btn btn-secondary btn-sm" onclick="setAll('hadir')"><i class="fas fa-check" style="color:#38a169;"></i> Semua Hadir</button>
            <button type="button" class="btn btn-secondary btn-sm" onclick="setAll('alpa')"><i class="fas fa-times" style="color:#e53e3e;"></i> Tandai Semua Alpa</button>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th>Hadir</th>
                        <th>Sakit</th>
                        <th>Izin</th>
                        <th>Alpa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $siswaKelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $sk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $existingAbsen = $absensi->where('siswa_id', $sk->siswa->id)->first(); ?>
                    <tr>
                        <td style="font-size:12px;color:var(--text-muted);"><?php echo e($i+1); ?></td>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,var(--pink-300),var(--pink-500));color:white;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:12px;"><?php echo e(strtoupper(substr($sk->siswa->name,0,1))); ?></div>
                                <span style="font-weight:600;font-size:14px;"><?php echo e($sk->siswa->name); ?></span>
                            </div>
                        </td>
                        <td><span class="badge badge-pink"><?php echo e($sk->siswa->nis ?? '-'); ?></span></td>
                        <?php $__currentLoopData = ['hadir','sakit','izin','alpa']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <td>
                            <label style="cursor:pointer;display:flex;align-items:center;justify-content:center;">
                                <input type="radio" name="absensis[<?php echo e($sk->siswa->id); ?>]" value="<?php echo e($s); ?>"
                                    class="absen-radio radio-<?php echo e($s); ?>"
                                    <?php echo e(($existingAbsen && $existingAbsen->status == $s) || (!$existingAbsen && $s == 'hadir') ? 'checked' : ''); ?>

                                    style="width:18px;height:18px;accent-color:<?php echo e($s=='hadir'?'#38a169':($s=='sakit'?'#3182ce':($s=='izin'?'#d69e2e':'#e53e3e'))); ?>;">
                            </label>
                        </td>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <div style="margin-top:20px;display:flex;justify-content:flex-end;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Absensi
            </button>
        </div>
    </form>
    <?php else: ?>
    <div class="empty-state"><i class="fas fa-users"></i><p>Tidak ada siswa di kelas ini</p></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function setAll(status) {
    document.querySelectorAll(`input[value="${status}"]`).forEach(r => r.checked = true);
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\USER\smatrack\resources\views/admin/absensi/index.blade.php ENDPATH**/ ?>