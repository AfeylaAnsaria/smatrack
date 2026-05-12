@extends('layouts.app')
@section('title', 'Nilai Saya')
@section('page-title', 'Nilai Saya')
@section('page-subtitle', 'Rekap nilai per mata pelajaran')

@section('content')
<!-- Semester Tabs -->
<div style="display:flex;gap:8px;margin-bottom:20px;">
    <a href="{{ route('siswa.nilai', ['semester'=>'1']) }}"
       class="btn {{ $semester=='1' ? 'btn-primary' : 'btn-secondary' }}">
        <i class="fas fa-book"></i> Semester 1
    </a>
    <a href="{{ route('siswa.nilai', ['semester'=>'2']) }}"
       class="btn {{ $semester=='2' ? 'btn-primary' : 'btn-secondary' }}">
        <i class="fas fa-book-open"></i> Semester 2
    </a>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">⭐ Nilai Semester {{ $semester }}</div>
        <span class="badge badge-pink">Kelas {{ $sk?->kelas?->nama_kelas ?? '-' }}</span>
    </div>

    @if($nilais->count() > 0)
    @php
        $avg = $nilais->whereNotNull('nilai_akhir')->avg('nilai_akhir');
    @endphp
    <!-- Average -->
    <div style="background:linear-gradient(135deg,var(--pink-50),white);border-radius:12px;padding:16px;border:1px solid var(--pink-200);margin-bottom:20px;display:flex;align-items:center;gap:16px;">
        <div style="width:60px;height:60px;border-radius:50%;background:linear-gradient(135deg,var(--pink-400),var(--pink-600));color:white;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:800;flex-shrink:0;">
            {{ $avg ? number_format($avg,0) : '-' }}
        </div>
        <div>
            <div style="font-size:16px;font-weight:700;">Rata-rata Nilai Semester {{ $semester }}</div>
            <div style="font-size:13px;color:var(--text-muted);">{{ $nilais->count() }} mata pelajaran</div>
        </div>
    </div>

    <div style="display:grid;gap:10px;">
        @foreach($nilais as $n)
        <div style="padding:16px;border-radius:12px;border:1px solid var(--border);background:white;display:flex;align-items:center;gap:16px;">
            <div style="width:44px;height:44px;border-radius:12px;background:var(--pink-50);border:1px solid var(--pink-200);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:800;color:var(--pink-600);flex-shrink:0;">
                {{ $n->mataPelajaran->kode }}
            </div>
            <div style="flex:1;">
                <div style="font-weight:700;font-size:14px;">{{ $n->mataPelajaran->nama }}</div>
                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;">
                    NH: {{ $n->nilai_harian ?? '-' }} &bull;
                    UTS: {{ $n->nilai_uts ?? '-' }} &bull;
                    UAS: {{ $n->nilai_uas ?? '-' }}
                </div>
            </div>
            <div style="text-align:right;">
                @if($n->nilai_akhir)
                <div style="font-size:24px;font-weight:800;color:{{ $n->nilai_akhir >= $n->mataPelajaran->kkm ? 'var(--pink-600)' : '#e53e3e' }}">
                    {{ number_format($n->nilai_akhir,1) }}
                </div>
                <span class="badge badge-{{ $n->predikat=='A'?'green':($n->predikat=='B'?'blue':($n->predikat=='C'?'yellow':'red')) }}">
                    {{ $n->predikat }}
                </span>
                @if($n->nilai_akhir < $n->mataPelajaran->kkm)
                <div style="font-size:10px;color:#e53e3e;margin-top:2px;">Di bawah KKM ({{ $n->mataPelajaran->kkm }})</div>
                @endif
                @else
                <div style="color:var(--text-muted);font-size:13px;">—</div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="empty-state"><i class="fas fa-star"></i><p>Belum ada nilai untuk semester {{ $semester }}</p></div>
    @endif
</div>
@endsection
