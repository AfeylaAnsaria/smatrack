<?php $__env->startSection('title', 'Data Kuliah Saya'); ?>
<?php $__env->startSection('page-title', 'Tracker Kuliah'); ?>
<?php $__env->startSection('page-subtitle', 'Data pendaftaran perguruan tinggi kamu'); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero -->
<div class="card mb-4" style="background:linear-gradient(135deg,#ff5fa3 0%,#c40d57 100%);border:none;padding:32px;">
    <div style="display:flex;align-items:center;gap:20px;">
        <div style="font-size:56px;">🎓</div>
        <div>
            <div style="font-size:24px;font-weight:800;color:white;">Halo, <?php echo e(auth()->user()->name); ?>!</div>
            <div style="font-size:15px;color:rgba(255,255,255,0.8);margin-top:4px;">
                Kamu adalah siswa kelas 12 — ini adalah tracker perjalanan kuliah kamu!
            </div>
            <div style="font-size:13px;color:rgba(255,255,255,0.6);margin-top:2px;">
                Kelas: <?php echo e($sk?->kelas?->nama_kelas); ?>

            </div>
        </div>
    </div>
</div>

<?php if($dataKuliah): ?>
<!-- Status Card -->
<?php
$statusInfo = match($dataKuliah->status) {
    'diterima' => ['✅ Selamat! Kamu Diterima!', 'Alhamdulillah, perjuangan kamu terbayar!', '#f0fff4', '#c6f6d5', '#276749', '🎉'],
    'sedang_proses' => ['⏳ Sedang Diproses', 'Sabar ya! Hasil sedang dalam proses pengumuman.', '#fffff0', '#fefcbf', '#975a16', '🌟'],
    'tidak_diterima' => ['😢 Belum Rezeki di Sini', 'Jangan menyerah! Masih banyak jalur lain.', '#fff5f5', '#fed7d7', '#c53030', '💪'],
    default => ['📝 Belum Mendaftar', 'Segera konsultasi dengan BK untuk rencana kuliah.', 'var(--pink-50)', 'var(--pink-200)', 'var(--pink-700)', '📋']
};
?>

<div class="card mb-4" style="background:<?php echo e($statusInfo[2]); ?>;border:2px solid <?php echo e($statusInfo[3]); ?>;">
    <div style="display:flex;align-items:center;gap:16px;">
        <div style="font-size:48px;"><?php echo e($statusInfo[5]); ?></div>
        <div>
            <div style="font-size:20px;font-weight:800;color:<?php echo e($statusInfo[4]); ?>;"><?php echo e($statusInfo[0]); ?></div>
            <div style="font-size:14px;color:<?php echo e($statusInfo[4]); ?>;opacity:.8;margin-top:4px;"><?php echo e($statusInfo[1]); ?></div>
            <?php if($dataKuliah->status == 'diterima' && $dataKuliah->universitas_diterima): ?>
            <div style="margin-top:10px;font-size:15px;font-weight:700;color:#276749;">
                🏛️ <?php echo e($dataKuliah->universitas_diterima); ?> — <?php echo e($dataKuliah->prodi_diterima); ?>

                <?php if($dataKuliah->tanggal_pengumuman): ?>
                <span style="font-size:12px;font-weight:400;"> (<?php echo e($dataKuliah->tanggal_pengumuman->translatedFormat('d F Y')); ?>)</span>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="grid-2">
    <!-- Pilihan Universitas -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">🏛️ Pilihan Universitas</div>
            <span class="badge badge-<?php echo e($dataKuliah->jalur=='SNBP'?'green':($dataKuliah->jalur=='SNBT'?'blue':($dataKuliah->jalur=='Beasiswa'?'pink':'purple'))); ?>">
                <?php echo e($dataKuliah->jalur); ?>

            </span>
        </div>

        <div style="padding:16px;background:var(--pink-50);border-radius:12px;border:1px solid var(--pink-200);margin-bottom:12px;">
            <div style="font-size:11px;text-transform:uppercase;letter-spacing:.5px;color:var(--pink-600);font-weight:700;margin-bottom:6px;">Pilihan Pertama</div>
            <div style="font-size:16px;font-weight:800;color:var(--text);"><?php echo e($dataKuliah->universitas_tujuan_1); ?></div>
            <div style="font-size:13px;color:var(--text-muted);margin-top:2px;"><?php echo e($dataKuliah->prodi_tujuan_1); ?></div>
        </div>

        <?php if($dataKuliah->universitas_tujuan_2): ?>
        <div style="padding:16px;background:#f5f0ff;border-radius:12px;border:1px solid #d6bcfa;">
            <div style="font-size:11px;text-transform:uppercase;letter-spacing:.5px;color:#6b46c1;font-weight:700;margin-bottom:6px;">Pilihan Kedua</div>
            <div style="font-size:16px;font-weight:800;color:var(--text);"><?php echo e($dataKuliah->universitas_tujuan_2); ?></div>
            <div style="font-size:13px;color:var(--text-muted);margin-top:2px;"><?php echo e($dataKuliah->prodi_tujuan_2); ?></div>
        </div>
        <?php endif; ?>

        <?php if($dataKuliah->catatan): ?>
        <div style="margin-top:12px;padding:12px;background:#fffff0;border-radius:10px;border:1px solid #fefcbf;">
            <div style="font-size:12px;font-weight:700;color:#975a16;margin-bottom:4px;">📝 Catatan dari Admin</div>
            <div style="font-size:13px;color:#744210;"><?php echo e($dataKuliah->catatan); ?></div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Timeline -->
    <div class="card">
        <div class="card-title mb-4">🗓️ Timeline Status</div>
        <div style="position:relative;padding-left:24px;">
            <div style="position:absolute;left:7px;top:0;bottom:0;width:2px;background:var(--pink-200);"></div>

            <div style="position:relative;margin-bottom:20px;">
                <div style="position:absolute;left:-24px;top:2px;width:14px;height:14px;border-radius:50%;background:<?php echo e($dataKuliah->status!='belum_daftar'?'var(--pink-500)':'var(--pink-200)'); ?>;border:2px solid white;box-shadow:0 0 0 2px <?php echo e($dataKuliah->status!='belum_daftar'?'var(--pink-400)':'var(--pink-200)'); ?>;"></div>
                <div style="font-weight:700;font-size:14px;">Pendaftaran</div>
                <div style="font-size:12px;color:var(--text-muted);">Data telah diinput ke sistem</div>
            </div>

            <div style="position:relative;margin-bottom:20px;">
                <div style="position:absolute;left:-24px;top:2px;width:14px;height:14px;border-radius:50%;background:<?php echo e(in_array($dataKuliah->status,['sedang_proses','diterima','tidak_diterima'])?'var(--pink-500)':'var(--pink-200)'); ?>;border:2px solid white;"></div>
                <div style="font-weight:700;font-size:14px;">Proses Seleksi</div>
                <div style="font-size:12px;color:var(--text-muted);">Menunggu pengumuman</div>
            </div>

            <div style="position:relative;">
                <div style="position:absolute;left:-24px;top:2px;width:14px;height:14px;border-radius:50%;background:<?php echo e(in_array($dataKuliah->status,['diterima','tidak_diterima'])?($dataKuliah->status=='diterima'?'#38a169':'#e53e3e'):'var(--pink-200)'); ?>;border:2px solid white;"></div>
                <div style="font-weight:700;font-size:14px;">Hasil Pengumuman</div>
                <div style="font-size:12px;color:var(--text-muted);">
                    <?php if($dataKuliah->status == 'diterima'): ?> ✅ Diterima di <?php echo e($dataKuliah->universitas_diterima); ?>

                    <?php elseif($dataKuliah->status == 'tidak_diterima'): ?> ❌ Tidak diterima — coba jalur lain!
                    <?php else: ?> Menunggu...
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div style="margin-top:24px;padding:14px;background:var(--pink-50);border-radius:12px;border:1px solid var(--pink-200);">
            <div style="font-size:12px;font-weight:700;color:var(--pink-700);margin-bottom:4px;">💬 Info Penting</div>
            <div style="font-size:12px;color:var(--pink-600);line-height:1.6;">
                Jika ada perubahan status atau ingin update data, hubungi admin sekolah. Kamu tidak bisa mengubah data sendiri.
            </div>
        </div>
    </div>
</div>

<?php else: ?>
<!-- Belum ada data -->
<div class="card" style="text-align:center;padding:48px 24px;">
    <div style="font-size:64px;margin-bottom:16px;">🏛️</div>
    <div style="font-size:20px;font-weight:800;color:var(--text);margin-bottom:8px;">Data Kuliah Belum Tersedia</div>
    <div style="font-size:14px;color:var(--text-muted);max-width:400px;margin:0 auto 20px;line-height:1.7;">
        Data pendaftaran kuliah kamu belum diinput oleh admin. Segera konsultasi dengan guru BK atau hubungi admin untuk menginput data rencana kuliah kamu.
    </div>
    <div style="display:inline-flex;gap:12px;flex-wrap:wrap;justify-content:center;">
        <div style="padding:12px 20px;background:var(--pink-50);border-radius:12px;border:1px solid var(--pink-200);">
            <div style="font-size:11px;color:var(--text-muted);">Hubungi</div>
            <div style="font-size:14px;font-weight:700;color:var(--pink-700);">Admin / Guru BK</div>
        </div>
        <div style="padding:12px 20px;background:var(--pink-50);border-radius:12px;border:1px solid var(--pink-200);">
            <div style="font-size:11px;color:var(--text-muted);">Email Admin</div>
            <div style="font-size:14px;font-weight:700;color:var(--pink-700);">admin@smatrack.com</div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\USER\smatrack\resources\views/siswa/kuliah.blade.php ENDPATH**/ ?>