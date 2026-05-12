@extends('layouts.app')
@section('title', 'Dashboard Siswa')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Halo ' . auth()->user()->name . '! 👋')

@section('content')
<!-- Kartu Info Siswa -->
<div class="card mb-4" style="background:linear-gradient(135deg, var(--pink-500) 0%, var(--pink-700) 100%);border:none;">
    <div style="display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
        <div style="width:64px;height:64px;border-radius:50%;background:rgba(255,255,255,0.25);display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:800;color:white;flex-shrink:0;">
            {{ strtoupper(substr($user->name,0,1)) }}
        </div>
        <div style="flex:1;">
            <div style="font-size:20px;font-weight:800;color:white;">{{ $user->name }}</div>
            <div style="font-size:13px;color:rgba(255,255,255,0.8);margin-top:2px;">
                NIS: {{ $user->nis ?? '-' }} &bull;
                Kelas: {{ $kelas?->nama_kelas ?? 'Belum ada kelas' }} &bull;
                {{ $ta?->tahun }}
            </div>
        </div>
        @if($isKelas12)
        <div style="background:rgba(255,255,255,0.2);border-radius:12px;padding:10px 16px;text-align:center;">
            <div style="font-size:22px;">🎓</div>
            <div style="font-size:11px;color:white;font-weight:700;margin-top:2px;">Kelas XII</div>
            <div style="font-size:10px;color:rgba(255,255,255,0.7);">Fitur Kuliah Aktif</div>
        </div>
        @endif
    </div>
</div>

<!-- Rekap Absensi -->
<div class="card mb-4">
    <div class="card-header">
        <div class="card-title">📋 Rekap Absensi Saya</div>
        <a href="{{ route('siswa.absensi') }}" class="btn btn-secondary btn-sm">Lihat Detail</a>
    </div>
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;">
        @php $total = array_sum($statsAbsensi); @endphp
        <div style="text-align:center;padding:16px;background:#f0fff4;border-radius:12px;border:1px solid #c6f6d5;">
            <div style="font-size:28px;font-weight:800;color:#276749;">{{ $statsAbsensi['hadir'] }}</div>
            <div style="font-size:12px;color:#38a169;font-weight:600;">Hadir</div>
            @if($total > 0)
            <div style="font-size:11px;color:#38a169;margin-top:2px;">{{ round($statsAbsensi['hadir']/$total*100) }}%</div>
            @endif
        </div>
        <div style="text-align:center;padding:16px;background:#ebf8ff;border-radius:12px;border:1px solid #bee3f8;">
            <div style="font-size:28px;font-weight:800;color:#2b6cb0;">{{ $statsAbsensi['sakit'] }}</div>
            <div style="font-size:12px;color:#3182ce;font-weight:600;">Sakit</div>
        </div>
        <div style="text-align:center;padding:16px;background:#fffff0;border-radius:12px;border:1px solid #fefcbf;">
            <div style="font-size:28px;font-weight:800;color:#975a16;">{{ $statsAbsensi['izin'] }}</div>
            <div style="font-size:12px;color:#d69e2e;font-weight:600;">Izin</div>
        </div>
        <div style="text-align:center;padding:16px;background:#fff5f5;border-radius:12px;border:1px solid #fed7d7;">
            <div style="font-size:28px;font-weight:800;color:#c53030;">{{ $statsAbsensi['alpa'] }}</div>
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
        @forelse($pengumumans as $p)
        <div style="padding:12px 0;border-bottom:1px solid var(--border);">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                <div style="width:8px;height:8px;border-radius:50%;background:var(--pink-400);flex-shrink:0;"></div>
                <span style="font-size:14px;font-weight:600;">{{ $p->judul }}</span>
                @if($p->untuk == 'kelas12')
                <span class="badge badge-pink" style="font-size:10px;">Kelas 12</span>
                @endif
            </div>
            <div style="font-size:12px;color:var(--text-muted);margin-left:16px;">{{ $p->created_at->diffForHumans() }}</div>
            <div style="font-size:13px;color:var(--text);margin-left:16px;margin-top:4px;line-height:1.5;">
                {{ Str::limit($p->isi, 100) }}
            </div>
        </div>
        @empty
        <div class="empty-state"><i class="fas fa-bullhorn"></i><p>Belum ada pengumuman</p></div>
        @endforelse
    </div>

    <!-- Menu Cepat + Kelas 12 -->
    <div style="display:flex;flex-direction:column;gap:16px;">
        <div class="card">
            <div class="card-title mb-4">⚡ Menu Cepat</div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                <a href="{{ route('siswa.jadwal') }}" class="btn btn-secondary" style="justify-content:center;padding:14px;flex-direction:column;gap:4px;text-align:center;">
                    <i class="fas fa-calendar-alt" style="font-size:20px;color:var(--pink-500);"></i>
                    <span style="font-size:12px;">Jadwal</span>
                </a>
                <a href="{{ route('siswa.nilai') }}" class="btn btn-secondary" style="justify-content:center;padding:14px;flex-direction:column;gap:4px;text-align:center;">
                    <i class="fas fa-star" style="font-size:20px;color:var(--pink-500);"></i>
                    <span style="font-size:12px;">Nilai</span>
                </a>
                <a href="{{ route('siswa.rapot') }}" class="btn btn-secondary" style="justify-content:center;padding:14px;flex-direction:column;gap:4px;text-align:center;">
                    <i class="fas fa-file-alt" style="font-size:20px;color:var(--pink-500);"></i>
                    <span style="font-size:12px;">Rapot</span>
                </a>
                <a href="{{ route('siswa.absensi') }}" class="btn btn-secondary" style="justify-content:center;padding:14px;flex-direction:column;gap:4px;text-align:center;">
                    <i class="fas fa-clipboard-check" style="font-size:20px;color:var(--pink-500);"></i>
                    <span style="font-size:12px;">Absensi</span>
                </a>
            </div>
        </div>

        @if($isKelas12)
        <!-- Kelas 12 Special Card -->
        <div class="card" style="background:linear-gradient(135deg,var(--pink-50),#fff5f0);border:2px solid var(--pink-200);">
            <div style="display:flex;gap:14px;align-items:flex-start;">
                <div style="font-size:36px;flex-shrink:0;">🎓</div>
                <div style="flex:1;">
                    <div style="font-size:16px;font-weight:800;color:var(--pink-700);margin-bottom:4px;">Tracker Kuliah Kelas 12</div>
                    @if($dataKuliah)
                        <div style="font-size:13px;color:var(--text-muted);margin-bottom:10px;">
                            Tujuan: <strong>{{ $dataKuliah->universitas_tujuan_1 }}</strong> — {{ $dataKuliah->prodi_tujuan_1 }}
                        </div>
                        @php
                        $statusKuliah = match($dataKuliah->status) {
                            'diterima' => ['✅ Diterima!', 'green'],
                            'sedang_proses' => ['⏳ Sedang Diproses', 'yellow'],
                            'tidak_diterima' => ['❌ Tidak Diterima', 'red'],
                            default => ['📝 Belum Mendaftar', 'gray']
                        };
                        @endphp
                        <span class="badge badge-{{ $statusKuliah[1] }}" style="font-size:12px;padding:5px 12px;">
                            {{ $statusKuliah[0] }}
                        </span>
                        @if($dataKuliah->status == 'diterima')
                        <div style="margin-top:8px;font-size:13px;color:#276749;font-weight:600;">
                            🎉 {{ $dataKuliah->universitas_diterima }} — {{ $dataKuliah->prodi_diterima }}
                        </div>
                        @endif
                    @else
                        <div style="font-size:13px;color:var(--text-muted);margin-bottom:10px;">Data kuliah belum diisi. Hubungi admin.</div>
                    @endif
                    <a href="{{ route('siswa.kuliah') }}" class="btn btn-primary btn-sm" style="margin-top:10px;">
                        <i class="fas fa-university"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
