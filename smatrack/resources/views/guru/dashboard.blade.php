@extends('layouts.app')
@section('title', 'Dashboard Guru')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, ' . auth()->user()->name . '!')

@section('content')
<!-- Info Hak Akses -->
<div class="card mb-4" style="background:linear-gradient(135deg,#f5f0ff,white);border:2px solid #d6bcfa;">
    <div style="display:flex;align-items:center;gap:14px;">
        <div style="font-size:32px;">👨‍🏫</div>
        <div>
            <div style="font-weight:800;font-size:16px;color:#6b46c1;">Mode Guru — Hanya Bisa Melihat</div>
            <div style="font-size:13px;color:#805ad5;margin-top:2px;">
                Kamu bisa melihat absensi, nilai, dan jadwal. Untuk input nilai, setor ke admin dan admin yang akan menginputkan.
            </div>
        </div>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon purple"><i class="fas fa-chalkboard"></i></div>
        <div><div class="stat-value">{{ $kelasDiajar->count() }}</div><div class="stat-label">Kelas Diajar</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon pink"><i class="fas fa-calendar-day"></i></div>
        <div><div class="stat-value">{{ $jadwalHariIni->count() }}</div><div class="stat-label">Jadwal Hari Ini</div></div>
    </div>
</div>

<div class="grid-2">
    <!-- Jadwal Hari Ini -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">📅 Jadwal Hari Ini</div>
            <span class="badge badge-pink">{{ now()->locale('id')->isoFormat('dddd') }}</span>
        </div>
        @forelse($jadwalHariIni as $j)
        <div style="padding:12px 0;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:14px;">
            <div style="text-align:center;min-width:60px;">
                <div style="font-size:13px;font-weight:700;color:var(--pink-700);">{{ substr($j->jam_mulai,0,5) }}</div>
                <div style="font-size:11px;color:var(--text-muted);">{{ substr($j->jam_selesai,0,5) }}</div>
            </div>
            <div style="flex:1;">
                <div style="font-weight:700;font-size:14px;">{{ $j->mataPelajaran->nama }}</div>
                <div style="font-size:12px;color:var(--text-muted);">{{ $j->kelas->nama_kelas }}</div>
            </div>
        </div>
        @empty
        <div class="empty-state" style="padding:24px;"><i class="fas fa-couch"></i><p>Tidak ada jadwal hari ini 😊</p></div>
        @endforelse
    </div>

    <!-- Kelas yang Diajar -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">🏫 Kelas yang Diajar</div>
        </div>
        @forelse($kelasDiajar as $k)
        <div style="padding:10px 0;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
            <div>
                <div style="font-weight:700;font-size:14px;">{{ $k->nama_kelas }}</div>
                <div style="font-size:12px;color:var(--text-muted);">Kelas {{ $k->tingkat }} &bull; {{ $k->jurusan }}</div>
            </div>
            <span class="badge badge-{{ $k->tingkat=='12'?'pink':($k->tingkat=='11'?'purple':'blue') }}">
                Kelas {{ $k->tingkat }}
            </span>
        </div>
        @empty
        <div class="empty-state" style="padding:24px;"><i class="fas fa-school"></i><p>Belum ada jadwal mengajar</p></div>
        @endforelse
    </div>
</div>

<!-- Pengumuman -->
<div class="card mt-4">
    <div class="card-header">
        <div class="card-title">📢 Pengumuman</div>
    </div>
    @forelse($pengumumans as $p)
    <div style="padding:12px 0;border-bottom:1px solid var(--border);">
        <div style="font-weight:600;font-size:14px;margin-bottom:4px;">{{ $p->judul }}</div>
        <div style="font-size:12px;color:var(--text-muted);">{{ $p->created_at->diffForHumans() }}</div>
        <div style="font-size:13px;margin-top:4px;">{{ Str::limit($p->isi, 120) }}</div>
    </div>
    @empty
    <div class="empty-state"><i class="fas fa-bullhorn"></i><p>Belum ada pengumuman</p></div>
    @endforelse
</div>
@endsection
