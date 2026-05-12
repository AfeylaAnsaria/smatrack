@extends('layouts.app')
@section('title','Lihat Nilai')
@section('page-title','Lihat Nilai Siswa')
@section('page-subtitle','Data nilai siswa — hanya bisa dilihat')
@section('content')
<div class="card mb-4" style="background:#fff5f5;border-color:#fed7d7;">
    <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:#c53030;">
        <i class="fas fa-eye"></i> <strong>Mode Lihat Saja</strong> — Untuk input nilai, setor ke admin. Admin yang menginputkan.
    </div>
</div>
<div class="card mb-4">
    <form method="GET" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
        <div class="form-group" style="margin:0;flex:1;min-width:140px;">
            <label class="form-label">Kelas</label>
            <select name="kelas_id" class="form-control">
                @foreach($kelas as $k)
                <option value="{{ $k->id }}" {{ $k->id==$kelasId?'selected':'' }}>{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group" style="margin:0;flex:1;min-width:140px;">
            <label class="form-label">Mata Pelajaran</label>
            <select name="mata_pelajaran_id" class="form-control">
                @foreach($mapels as $m)
                <option value="{{ $m->id }}" {{ $m->id==$mapelId?'selected':'' }}>{{ $m->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group" style="margin:0;min-width:120px;">
            <label class="form-label">Semester</label>
            <select name="semester" class="form-control">
                <option value="1" {{ $semester=='1'?'selected':'' }}>Semester 1</option>
                <option value="2" {{ $semester=='2'?'selected':'' }}>Semester 2</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Tampilkan</button>
    </form>
</div>
<div class="card">
    <div class="table-wrapper">
        <table>
            <thead><tr><th>#</th><th>Nama Siswa</th><th>NH</th><th>UTS</th><th>UAS</th><th>Nilai Akhir</th><th>Predikat</th></tr></thead>
            <tbody>
                @forelse($nilais as $i => $n)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td style="font-weight:600;">{{ $n->siswa->name }}</td>
                    <td>{{ $n->nilai_harian ?? '-' }}</td>
                    <td>{{ $n->nilai_uts ?? '-' }}</td>
                    <td>{{ $n->nilai_uas ?? '-' }}</td>
                    <td style="font-weight:800;color:{{ ($n->nilai_akhir??0)>=75?'var(--pink-600)':'#e53e3e' }}">{{ $n->nilai_akhir ? number_format($n->nilai_akhir,1) : '-' }}</td>
                    <td><span class="badge badge-{{ $n->predikat=='A'?'green':($n->predikat=='B'?'blue':($n->predikat=='C'?'yellow':'red')) }}">{{ $n->predikat ?? '-' }}</span></td>
                </tr>
                @empty
                <tr><td colspan="7"><div class="empty-state"><i class="fas fa-star"></i><p>Belum ada nilai</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
