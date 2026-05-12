@extends('layouts.app')
@section('title', 'Absensi Saya')
@section('page-title', 'Absensi Saya')
@section('page-subtitle', 'Rekap kehadiran selama tahun ajaran ini')

@section('content')
<!-- Rekap -->
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px;">
    @php $total = array_sum($rekap); @endphp
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
        <div>
            <div class="stat-value">{{ $rekap['hadir'] }}</div>
            <div class="stat-label">Hadir {{ $total > 0 ? '('.round($rekap['hadir']/$total*100).'%)' : '' }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-procedures"></i></div>
        <div><div class="stat-value">{{ $rekap['sakit'] }}</div><div class="stat-label">Sakit</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-door-open"></i></div>
        <div><div class="stat-value">{{ $rekap['izin'] }}</div><div class="stat-label">Izin</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon rose"><i class="fas fa-times-circle"></i></div>
        <div><div class="stat-value">{{ $rekap['alpa'] }}</div><div class="stat-label">Alpa</div></div>
    </div>
</div>

<!-- Tabel -->
<div class="card">
    <div class="card-header">
        <div class="card-title">📋 Riwayat Absensi</div>
        <span class="badge badge-pink">Kelas {{ $sk?->kelas?->nama_kelas ?? '-' }}</span>
    </div>
    <div class="table-wrapper">
        <table>
            <thead><tr><th>Tanggal</th><th>Mata Pelajaran</th><th>Status</th><th>Keterangan</th></tr></thead>
            <tbody>
                @forelse($absensi as $a)
                <tr>
                    <td style="font-size:13px;">{{ $a->tanggal->translatedFormat('l, d M Y') }}</td>
                    <td style="font-weight:600;">{{ $a->mataPelajaran->nama }}</td>
                    <td>
                        <span class="badge badge-{{ $a->status=='hadir'?'green':($a->status=='sakit'?'blue':($a->status=='izin'?'yellow':'red')) }}">
                            {{ ['hadir'=>'✅ Hadir','sakit'=>'🤒 Sakit','izin'=>'📄 Izin','alpa'=>'❌ Alpa'][$a->status] }}
                        </span>
                    </td>
                    <td style="font-size:13px;color:var(--text-muted);">{{ $a->keterangan ?? '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="4"><div class="empty-state"><i class="fas fa-clipboard"></i><p>Belum ada data absensi</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:16px;">{{ $absensi->links() }}</div>
</div>
@endsection
