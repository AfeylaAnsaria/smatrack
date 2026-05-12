@extends('layouts.app')
@section('title', 'Input Absensi')
@section('page-title', 'Input Absensi')
@section('page-subtitle', 'Catat kehadiran siswa')

@section('content')
<!-- Filter -->
<div class="card mb-4">
    <form method="GET" action="{{ route('admin.absensi.index') }}" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
        <div class="form-group" style="margin:0;flex:1;min-width:150px;">
            <label class="form-label">Kelas</label>
            <select name="kelas_id" class="form-control">
                @foreach($kelas as $k)
                <option value="{{ $k->id }}" {{ $k->id == $kelasId ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group" style="margin:0;flex:1;min-width:150px;">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ $tanggal }}">
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filter</button>
    </form>
</div>

<!-- Form Absensi -->
<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">📋 Form Absensi</div>
            <div class="card-subtitle">Tanggal: {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}</div>
        </div>
    </div>

    @if($siswaKelas->count() > 0)
    <form method="POST" action="{{ route('admin.absensi.store') }}">
        @csrf
        <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
        <input type="hidden" name="tanggal" value="{{ $tanggal }}">

        <div class="form-group">
            <label class="form-label">Mata Pelajaran *</label>
            <select name="mata_pelajaran_id" class="form-control" required>
                <option value="">-- Pilih Mata Pelajaran --</option>
                @foreach($mapels as $m)
                <option value="{{ $m->id }}">{{ $m->nama }}</option>
                @endforeach
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
                    @foreach($siswaKelas as $i => $sk)
                    @php $existingAbsen = $absensi->where('siswa_id', $sk->siswa->id)->first(); @endphp
                    <tr>
                        <td style="font-size:12px;color:var(--text-muted);">{{ $i+1 }}</td>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,var(--pink-300),var(--pink-500));color:white;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:12px;">{{ strtoupper(substr($sk->siswa->name,0,1)) }}</div>
                                <span style="font-weight:600;font-size:14px;">{{ $sk->siswa->name }}</span>
                            </div>
                        </td>
                        <td><span class="badge badge-pink">{{ $sk->siswa->nis ?? '-' }}</span></td>
                        @foreach(['hadir','sakit','izin','alpa'] as $s)
                        <td>
                            <label style="cursor:pointer;display:flex;align-items:center;justify-content:center;">
                                <input type="radio" name="absensis[{{ $sk->siswa->id }}]" value="{{ $s }}"
                                    class="absen-radio radio-{{ $s }}"
                                    {{ ($existingAbsen && $existingAbsen->status == $s) || (!$existingAbsen && $s == 'hadir') ? 'checked' : '' }}
                                    style="width:18px;height:18px;accent-color:{{ $s=='hadir'?'#38a169':($s=='sakit'?'#3182ce':($s=='izin'?'#d69e2e':'#e53e3e')) }};">
                            </label>
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top:20px;display:flex;justify-content:flex-end;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Absensi
            </button>
        </div>
    </form>
    @else
    <div class="empty-state"><i class="fas fa-users"></i><p>Tidak ada siswa di kelas ini</p></div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function setAll(status) {
    document.querySelectorAll(`input[value="${status}"]`).forEach(r => r.checked = true);
}
</script>
@endpush
