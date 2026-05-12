@extends('layouts.app')
@section('title', 'Rapot')
@section('page-title', 'Rapot Saya')
@section('page-subtitle', 'Rekap lengkap nilai semua semester')

@section('content')
<!-- Header Rapot -->
<div class="card mb-4" style="background:linear-gradient(135deg,var(--pink-600),var(--pink-800));border:none;text-align:center;padding:32px;">
    <div style="font-size:14px;color:rgba(255,255,255,0.7);font-weight:500;margin-bottom:4px;">RAPOT SISWA</div>
    <div style="font-family:'Playfair Display',serif;font-size:28px;color:white;font-weight:700;margin-bottom:16px;">SMAtrack</div>
    <div style="display:inline-flex;align-items:center;gap:20px;background:rgba(255,255,255,0.15);border-radius:12px;padding:16px 24px;flex-wrap:wrap;justify-content:center;">
        <div style="text-align:center;">
            <div style="font-size:11px;color:rgba(255,255,255,0.7);">NAMA SISWA</div>
            <div style="font-size:15px;font-weight:700;color:white;">{{ $user->name }}</div>
        </div>
        <div style="width:1px;height:30px;background:rgba(255,255,255,0.3);"></div>
        <div style="text-align:center;">
            <div style="font-size:11px;color:rgba(255,255,255,0.7);">NIS</div>
            <div style="font-size:15px;font-weight:700;color:white;">{{ $user->nis ?? '-' }}</div>
        </div>
        <div style="width:1px;height:30px;background:rgba(255,255,255,0.3);"></div>
        <div style="text-align:center;">
            <div style="font-size:11px;color:rgba(255,255,255,0.7);">KELAS</div>
            <div style="font-size:15px;font-weight:700;color:white;">{{ $sk?->kelas?->nama_kelas ?? '-' }}</div>
        </div>
        <div style="width:1px;height:30px;background:rgba(255,255,255,0.3);"></div>
        <div style="text-align:center;">
            <div style="font-size:11px;color:rgba(255,255,255,0.7);">TAHUN AJARAN</div>
            <div style="font-size:15px;font-weight:700;color:white;">{{ $ta?->tahun }}</div>
        </div>
    </div>
</div>

<div class="grid-2">
    <!-- Semester 1 -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">📘 Semester 1</div>
            @php $avg1 = $nilaiSem1->whereNotNull('nilai_akhir')->avg('nilai_akhir'); @endphp
            @if($avg1)
            <span style="font-size:18px;font-weight:800;color:var(--pink-600);">{{ number_format($avg1,1) }}</span>
            @endif
        </div>
        @if($nilaiSem1->count() > 0)
        <div class="table-wrapper">
            <table>
                <thead><tr><th>Mata Pelajaran</th><th>NH</th><th>UTS</th><th>UAS</th><th>Akhir</th><th>Pred.</th></tr></thead>
                <tbody>
                    @foreach($nilaiSem1 as $n)
                    <tr>
                        <td style="font-weight:600;font-size:13px;">{{ $n->mataPelajaran->nama }}</td>
                        <td style="font-size:13px;">{{ $n->nilai_harian ?? '-' }}</td>
                        <td style="font-size:13px;">{{ $n->nilai_uts ?? '-' }}</td>
                        <td style="font-size:13px;">{{ $n->nilai_uas ?? '-' }}</td>
                        <td style="font-weight:700;color:{{ ($n->nilai_akhir ?? 0) >= $n->mataPelajaran->kkm ? 'var(--pink-600)' : '#e53e3e' }}">
                            {{ $n->nilai_akhir ? number_format($n->nilai_akhir,1) : '-' }}
                        </td>
                        <td>
                            <span class="badge badge-{{ $n->predikat=='A'?'green':($n->predikat=='B'?'blue':($n->predikat=='C'?'yellow':'red')) }}" style="font-size:11px;">
                                {{ $n->predikat ?? '-' }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state" style="padding:24px;"><i class="fas fa-book"></i><p>Nilai semester 1 belum ada</p></div>
        @endif
    </div>

    <!-- Semester 2 -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">📗 Semester 2</div>
            @php $avg2 = $nilaiSem2->whereNotNull('nilai_akhir')->avg('nilai_akhir'); @endphp
            @if($avg2)
            <span style="font-size:18px;font-weight:800;color:var(--pink-600);">{{ number_format($avg2,1) }}</span>
            @endif
        </div>
        @if($nilaiSem2->count() > 0)
        <div class="table-wrapper">
            <table>
                <thead><tr><th>Mata Pelajaran</th><th>NH</th><th>UTS</th><th>UAS</th><th>Akhir</th><th>Pred.</th></tr></thead>
                <tbody>
                    @foreach($nilaiSem2 as $n)
                    <tr>
                        <td style="font-weight:600;font-size:13px;">{{ $n->mataPelajaran->nama }}</td>
                        <td style="font-size:13px;">{{ $n->nilai_harian ?? '-' }}</td>
                        <td style="font-size:13px;">{{ $n->nilai_uts ?? '-' }}</td>
                        <td style="font-size:13px;">{{ $n->nilai_uas ?? '-' }}</td>
                        <td style="font-weight:700;color:{{ ($n->nilai_akhir ?? 0) >= $n->mataPelajaran->kkm ? 'var(--pink-600)' : '#e53e3e' }}">
                            {{ $n->nilai_akhir ? number_format($n->nilai_akhir,1) : '-' }}
                        </td>
                        <td>
                            <span class="badge badge-{{ $n->predikat=='A'?'green':($n->predikat=='B'?'blue':($n->predikat=='C'?'yellow':'red')) }}" style="font-size:11px;">
                                {{ $n->predikat ?? '-' }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state" style="padding:24px;"><i class="fas fa-book-open"></i><p>Nilai semester 2 belum ada</p></div>
        @endif
    </div>
</div>

<!-- Absensi Rekap -->
<div class="card mt-4">
    <div class="card-header"><div class="card-title">📋 Rekap Kehadiran</div></div>
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;">
        @foreach(['hadir'=>['Hadir','green','#276749'],'sakit'=>['Sakit','blue','#2b6cb0'],'izin'=>['Izin','yellow','#975a16'],'alpa'=>['Alpa','red','#c53030']] as $k=>$v)
        <div style="text-align:center;padding:16px;background:var(--pink-50);border-radius:12px;border:1px solid var(--pink-200);">
            <div style="font-size:28px;font-weight:800;color:{{ $v[2] }};">{{ $absensiRekap[$k] }}</div>
            <div style="font-size:12px;color:{{ $v[2] }};font-weight:600;">{{ $v[0] }}</div>
        </div>
        @endforeach
    </div>
</div>

<!-- Catatan -->
<div class="card mt-4" style="background:var(--pink-50);border-color:var(--pink-200);">
    <div style="display:flex;gap:12px;align-items:center;">
        <div style="font-size:28px;">📝</div>
        <div style="font-size:13px;color:var(--pink-700);">
            Rapot ini merupakan rekap digital. Untuk dokumen resmi bertanda tangan, hubungi wali kelas atau bagian TU sekolah.
        </div>
    </div>
</div>
@endsection
