<?php $__env->startSection('title', 'Dashboard Siswa'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>
<?php $__env->startSection('page-subtitle', 'Halo ' . auth()->user()->name . '! 👋'); ?>

<?php $__env->startSection('content'); ?>
<!-- Kartu Info Siswa -->
<div class="card mb-4" style="background:linear-gradient(135deg, var(--pink-500) 0%, var(--pink-700) 100%);border:none;">
    <div style="display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
        <div style="width:64px;height:64px;border-radius:50%;background:rgba(255,255,255,0.25);display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:800;color:white;flex-shrink:0;">
            <?php echo e(strtoupper(substr($user->name,0,1))); ?>

        </div>
        <div style="flex:1;">
            <div style="font-size:20px;font-weight:800;color:white;"><?php echo e($user->name); ?></div>
            <div style="font-size:13px;color:rgba(255,255,255,0.8);margin-top:2px;">
                NIS: <?php echo e($user->nis ?? '-'); ?> &bull;
                Kelas: <?php echo e($kelas?->nama_kelas ?? 'Belum ada kelas'); ?> &bull;
                <?php echo e($ta?->tahun); ?>

            </div>
        </div>
        <?php if($isKelas12): ?>
        <div style="background:rgba(255,255,255,0.2);border-radius:12px;padding:10px 16px;text-align:center;">
            <div style="font-size:22px;">🎓</div>
            <div style="font-size:11px;color:white;font-weight:700;margin-top:2px;">Kelas XII</div>
            <div style="font-size:10px;color:rgba(255,255,255,0.7);">Fitur Kuliah Aktif</div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Rekap Absensi -->
<div class="card mb-4">
    <div class="card-header">
        <div class="card-title">📋 Rekap Absensi Saya</div>
        <a href="<?php echo e(route('siswa.absensi')); ?>" class="btn btn-secondary btn-sm">Lihat Detail</a>
    </div>
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;">
        <?php $total = array_sum($statsAbsensi); ?>
        <div style="text-align:center;padding:16px;background:#f0fff4;border-radius:12px;border:1px solid #c6f6d5;">
            <div style="font-size:28px;font-weight:800;color:#276749;"><?php echo e($statsAbsensi['hadir']); ?></div>
            <div style="font-size:12px;color:#38a169;font-weight:600;">Hadir</div>
            <?php if($total > 0): ?>
            <div style="font-size:11px;color:#38a169;margin-top:2px;"><?php echo e(round($statsAbsensi['hadir']/$total*100)); ?>%</div>
            <?php endif; ?>
        </div>
        <div style="text-align:center;padding:16px;background:#ebf8ff;border-radius:12px;border:1px solid #bee3f8;">
            <div style="font-size:28px;font-weight:800;color:#2b6cb0;"><?php echo e($statsAbsensi['sakit']); ?></div>
            <div style="font-size:12px;color:#3182ce;font-weight:600;">Sakit</div>
        </div>
        <div style="text-align:center;padding:16px;background:#fffff0;border-radius:12px;border:1px solid #fefcbf;">
            <div style="font-size:28px;font-weight:800;color:#975a16;"><?php echo e($statsAbsensi['izin']); ?></div>
            <div style="font-size:12px;color:#d69e2e;font-weight:600;">Izin</div>
        </div>
        <div style="text-align:center;padding:16px;background:#fff5f5;border-radius:12px;border:1px solid #fed7d7;">
            <div style="font-size:28px;font-weight:800;color:#c53030;"><?php echo e($statsAbsensi['alpa']); ?></div>
            <div style="font-size:12px;color:#e53e3e;font-weight:600;">Alpa</div>
        </div>
    </div>
</div>

<div class="grid-2">
    <!-- Pengumuman -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">📢 Pengumuman</div>
        </div>
        <?php $__empty_1 = true; $__currentLoopData = $pengumumans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div style="padding:12px 0;border-bottom:1px solid var(--border);">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                <div style="width:8px;height:8px;border-radius:50%;background:var(--pink-400);flex-shrink:0;"></div>
                <span style="font-size:14px;font-weight:600;"><?php echo e($p->judul); ?></span>
                <?php if($p->untuk == 'kelas12'): ?>
                <span class="badge badge-pink" style="font-size:10px;">Kelas 12</span>
                <?php endif; ?>
            </div>
            <div style="font-size:12px;color:var(--text-muted);margin-left:16px;"><?php echo e($p->created_at->diffForHumans()); ?></div>
            <div style="font-size:13px;color:var(--text);margin-left:16px;margin-top:4px;line-height:1.5;">
                <?php echo e(Str::limit($p->isi, 100)); ?>

            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="empty-state"><i class="fas fa-bullhorn"></i><p>Belum ada pengumuman</p></div>
        <?php endif; ?>
    </div>

    <!-- Menu Cepat + Kelas 12 -->
    <div style="display:flex;flex-direction:column;gap:16px;">
        <div class="card">
            <div class="card-title mb-4">⚡ Menu Cepat</div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                <a href="<?php echo e(route('siswa.jadwal')); ?>" class="btn btn-secondary" style="justify-content:center;padding:14px;flex-direction:column;gap:4px;text-align:center;">
                    <i class="fas fa-calendar-alt" style="font-size:20px;color:var(--pink-500);"></i>
                    <span style="font-size:12px;">Jadwal</span>
                </a>
                <a href="<?php echo e(route('siswa.nilai')); ?>" class="btn btn-secondary" style="justify-content:center;padding:14px;flex-direction:column;gap:4px;text-align:center;">
                    <i class="fas fa-star" style="font-size:20px;color:var(--pink-500);"></i>
                    <span style="font-size:12px;">Nilai</span>
                </a>
                <a href="<?php echo e(route('siswa.rapot')); ?>" class="btn btn-secondary" style="justify-content:center;padding:14px;flex-direction:column;gap:4px;text-align:center;">
                    <i class="fas fa-file-alt" style="font-size:20px;color:var(--pink-500);"></i>
                    <span style="font-size:12px;">Rapot</span>
                </a>
                <a href="<?php echo e(route('siswa.absensi')); ?>" class="btn btn-secondary" style="justify-content:center;padding:14px;flex-direction:column;gap:4px;text-align:center;">
                    <i class="fas fa-clipboard-check" style="font-size:20px;color:var(--pink-500);"></i>
                    <span style="font-size:12px;">Absensi</span>
                </a>
            </div>
        </div>

        <?php if($isKelas12): ?>
        <!-- Kelas 12 Special Card -->
        <div class="card" style="background:linear-gradient(135deg,var(--pink-50),#fff5f0);border:2px solid var(--pink-200);">
            <div style="display:flex;gap:14px;align-items:flex-start;">
                <div style="font-size:36px;flex-shrink:0;">🎓</div>
                <div style="flex:1;">
                    <div style="font-size:16px;font-weight:800;color:var(--pink-700);margin-bottom:4px;">Tracker Kuliah Kelas 12</div>
                    <?php if($dataKuliah): ?>
                        <div style="font-size:13px;color:var(--text-muted);margin-bottom:10px;">
                            Tujuan: <strong><?php echo e($dataKuliah->universitas_tujuan_1); ?></strong> — <?php echo e($dataKuliah->prodi_tujuan_1); ?>

                        </div>
                        <?php
                        $statusKuliah = match($dataKuliah->status) {
                            'diterima' => ['✅ Diterima!', 'green'],
                            'sedang_proses' => ['⏳ Sedang Diproses', 'yellow'],
                            'tidak_diterima' => ['❌ Tidak Diterima', 'red'],
                            default => ['📝 Belum Mendaftar', 'gray']
                        };
                        ?>
                        <span class="badge badge-<?php echo e($statusKuliah[1]); ?>" style="font-size:12px;padding:5px 12px;">
                            <?php echo e($statusKuliah[0]); ?>

                        </span>
                        <?php if($dataKuliah->status == 'diterima'): ?>
                        <div style="margin-top:8px;font-size:13px;color:#276749;font-weight:600;">
                            🎉 <?php echo e($dataKuliah->universitas_diterima); ?> — <?php echo e($dataKuliah->prodi_diterima); ?>

                        </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div style="font-size:13px;color:var(--text-muted);margin-bottom:10px;">Data kuliah belum diisi. Hubungi admin.</div>
                    <?php endif; ?>
                    <a href="<?php echo e(route('siswa.kuliah')); ?>" class="btn btn-primary btn-sm" style="margin-top:10px;">
                        <i class="fas fa-university"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\USER\smatrack\resources\views/siswa/dashboard.blade.php ENDPATH**/ ?>