@extends('layouts.app')
@section('title','Lihat Absensi')
@section('page-title','Lihat Absensi')
@section('page-subtitle','Data absensi siswa — hanya bisa dilihat')
@section('content')
<div class="card mb-4" style="background:#fff5f5;border-color:#fed7d7;">
    <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:#c53030;">
        <i class="fas fa-eye"></i> <strong>Mode Lihat Saja</strong> — Guru tidak bisa mengubah data absensi. Untuk koreksi, hubungi admin.
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
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ $tanggal }}">
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filter</button>
    </form>
</div>
<div class="card">
    <div class="card-header">
        <div class="card-title">📋 Data Absensi</div>
        <span class="badge badge-pink">{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d M Y') }}</span>
    </div>
    <div class="table-wrapper">
        <table>
            <thead><tr><th>#</th><th>Nama Siswa</th><th>Mata Pelajaran</th><th>Status</th></tr></thead>
            <tbody>
                @forelse($absensi as $i => $a)
                <tr>
                    <td style="font-size:12px;color:var(--text-muted);">{{ $i+1 }}</td>
                    <td style="font-weight:600;">{{ $a->siswa->name }}</td>
                    <td>{{ $a->mataPelajaran->nama }}</td>
                    <td><span class="badge badge-{{ $a->status=='hadir'?'green':($a->status=='sakit'?'blue':($a->status=='izin'?'yellow':'red')) }}">
                        {{ ['hadir'=>'✅ Hadir','sakit'=>'🤒 Sakit','izin'=>'📄 Izin','alpa'=>'❌ Alpa'][$a->status] }}
                    </span></td>
                </tr>
                @empty
                <tr><td colspan="4"><div class="empty-state"><i class="fas fa-clipboard"></i><p>Belum ada data absensi untuk tanggal ini</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
