@extends('layouts.app')
@section('title', 'Input Nilai')
@section('page-title', 'Input Nilai')
@section('page-subtitle', 'Masukkan nilai siswa per mata pelajaran')

@section('content')
<!-- Filter -->
<div class="card mb-4">
    <form method="GET" action="{{ route('admin.nilai.index') }}" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
        <div class="form-group" style="margin:0;flex:1;min-width:150px;">
            <label class="form-label">Kelas</label>
            <select name="kelas_id" class="form-control">
                @foreach($kelas as $k)
                <option value="{{ $k->id }}" {{ $k->id == $kelasId ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group" style="margin:0;flex:1;min-width:150px;">
            <label class="form-label">Mata Pelajaran</label>
            <select name="mata_pelajaran_id" class="form-control">
                @foreach($mapels as $m)
                <option value="{{ $m->id }}" {{ $m->id == $mapelId ? 'selected' : '' }}>{{ $m->nama }}</option>
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
    <div class="card-header">
        <div>
            <div class="card-title">⭐ Input Nilai Siswa</div>
            <div class="card-subtitle">Formula: NH×40% + NUTs×30% + NUAs×30%</div>
        </div>
        <div style="background:var(--pink-50);border:1px solid var(--pink-200);border-radius:8px;padding:8px 14px;font-size:12px;color:var(--pink-600);">
            <i class="fas fa-info-circle"></i> Guru setor nilai ke admin
        </div>
    </div>

    @if($siswaKelas->count() > 0)
    <form method="POST" action="{{ route('admin.nilai.store') }}">
        @csrf
        <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
        <input type="hidden" name="mata_pelajaran_id" value="{{ $mapelId }}">
        <input type="hidden" name="semester" value="{{ $semester }}">

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Siswa</th>
                        <th>Nilai Harian (NH)</th>
                        <th>Nilai UTS</th>
                        <th>Nilai UAS</th>
                        <th>Nilai Akhir</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswaKelas as $i => $sk)
                    @php $nilai = $sk->siswa->nilais->first(); @endphp
                    <tr>
                        <td style="font-size:12px;color:var(--text-muted);">{{ $i+1 }}</td>
                        <td>
                            <div style="font-weight:600;font-size:14px;">{{ $sk->siswa->name }}</div>
                            <div style="font-size:11px;color:var(--text-muted);">{{ $sk->siswa->nis ?? '' }}</div>
                        </td>
                        <td>
                            <input type="number" name="nilais[{{ $sk->siswa->id }}][nilai_harian]"
                                class="form-control" style="width:90px;padding:8px 10px;" min="0" max="100" step="0.01"
                                value="{{ $nilai?->nilai_harian ?? '' }}" placeholder="0-100">
                        </td>
                        <td>
                            <input type="number" name="nilais[{{ $sk->siswa->id }}][nilai_uts]"
                                class="form-control" style="width:90px;padding:8px 10px;" min="0" max="100" step="0.01"
                                value="{{ $nilai?->nilai_uts ?? '' }}" placeholder="0-100">
                        </td>
                        <td>
                            <input type="number" name="nilais[{{ $sk->siswa->id }}][nilai_uas]"
                                class="form-control" style="width:90px;padding:8px 10px;" min="0" max="100" step="0.01"
                                value="{{ $nilai?->nilai_uas ?? '' }}" placeholder="0-100">
                        </td>
                        <td>
                            @if($nilai?->nilai_akhir)
                            <div style="display:flex;align-items:center;gap:6px;">
                                <strong style="font-size:16px;color:{{ $nilai->nilai_akhir >= 75 ? '#38a169' : '#e53e3e' }}">
                                    {{ number_format($nilai->nilai_akhir,1) }}
                                </strong>
                                <span class="badge badge-{{ $nilai->predikat=='A'?'green':($nilai->predikat=='B'?'blue':($nilai->predikat=='C'?'yellow':'red')) }}">
                                    {{ $nilai->predikat }}
                                </span>
                            </div>
                            @else
                            <span style="color:var(--text-muted);font-size:13px;">—</span>
                            @endif
                        </td>
                        <td>
                            <input type="text" name="nilais[{{ $sk->siswa->id }}][catatan]"
                                class="form-control" style="width:120px;padding:8px 10px;"
                                value="{{ $nilai?->catatan ?? '' }}" placeholder="Opsional">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top:20px;display:flex;justify-content:flex-end;gap:10px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Semua Nilai
            </button>
        </div>
    </form>
    @else
    <div class="empty-state"><i class="fas fa-users"></i><p>Tidak ada siswa atau pilih kelas terlebih dahulu</p></div>
    @endif
</div>
@endsection
