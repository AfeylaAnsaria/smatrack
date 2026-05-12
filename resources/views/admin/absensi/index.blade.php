@extends('layouts.app')
@section('title', 'Input Absensi')
@section('page-title', 'Input Absensi')
@section('page-subtitle', 'Catat kehadiran siswa')

@section('content')

{{-- Filter Kelas & Tanggal --}}
<div class="card mb-4">
    <form method="GET" action="{{ route('admin.absensi.index') }}" id="filterForm">
        <div style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
            <div class="form-group" style="margin:0;flex:2;min-width:180px;">
                <label class="form-label">Kelas</label>
                <select name="kelas_id" class="form-control" onchange="document.getElementById('filterForm').submit()">
                    @foreach($kelas as $k)
                    <option value="{{ $k->id }}" {{ $k->id == $kelasId ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="margin:0;flex:1;min-width:160px;">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="{{ $tanggal }}"
                    onchange="document.getElementById('filterForm').submit()">
            </div>
            <div class="form-group" style="margin:0;min-width:160px;">
                <label class="form-label">Mata Pelajaran</label>
                <select name="mata_pelajaran_id" class="form-control" onchange="document.getElementById('filterForm').submit()">
                    <option value="">-- Pilih Mapel --</option>
                    @foreach($mapels as $m)
                    <option value="{{ $m->id }}" {{ $m->id == $mapelId ? 'selected' : '' }}>
                        {{ $m->nama }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Navigasi tanggal --}}
        <div style="display:flex;gap:8px;margin-top:12px;align-items:center;">
            <a href="{{ route('admin.absensi.index', ['kelas_id'=>$kelasId, 'tanggal'=>\Carbon\Carbon::parse($tanggal)->subDay()->toDateString(), 'mata_pelajaran_id'=>$mapelId]) }}"
               class="btn btn-secondary btn-sm">
                <i class="fas fa-chevron-left"></i> Kemarin
            </a>
            <span style="font-size:13px;font-weight:600;color:var(--text);">
                {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
            </span>
            <a href="{{ route('admin.absensi.index', ['kelas_id'=>$kelasId, 'tanggal'=>\Carbon\Carbon::parse($tanggal)->addDay()->toDateString(), 'mata_pelajaran_id'=>$mapelId]) }}"
               class="btn btn-secondary btn-sm">
                Besok <i class="fas fa-chevron-right"></i>
            </a>
            <a href="{{ route('admin.absensi.index', ['kelas_id'=>$kelasId, 'tanggal'=>today()->toDateString(), 'mata_pelajaran_id'=>$mapelId]) }}"
               class="btn btn-primary btn-sm">
                <i class="fas fa-calendar-day"></i> Hari Ini
            </a>
        </div>
    </form>
</div>

{{-- Form Absensi --}}
<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">📋 Form Absensi</div>
            <div class="card-subtitle">
                {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
                @if($mapelId)
                — {{ $mapels->find($mapelId)?->nama }}
                @endif
            </div>
        </div>
        @if($siswaKelas->count() > 0 && $mapelId)
        <div style="display:flex;gap:8px;">
            <button type="button" class="btn btn-secondary btn-sm" onclick="setAll('hadir')">
                <i class="fas fa-check" style="color:#16a34a;"></i> Semua Hadir
            </button>
            <button type="button" class="btn btn-secondary btn-sm" onclick="setAll('alpa')">
                <i class="fas fa-times" style="color:#dc2626;"></i> Semua Alpa
            </button>
        </div>
        @endif
    </div>

    @if(!$mapelId)
    <div class="empty-state">
        <i class="fas fa-hand-pointer"></i>
        <p>Pilih mata pelajaran terlebih dahulu untuk mulai mengisi absensi</p>
    </div>
    @elseif($siswaKelas->count() == 0)
    <div class="empty-state">
        <i class="fas fa-users"></i>
        <p>Tidak ada siswa di kelas ini</p>
    </div>
    @else
    <form method="POST" action="{{ route('admin.absensi.store') }}" id="absensiForm">
        @csrf
        <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
        <input type="hidden" name="mata_pelajaran_id" value="{{ $mapelId }}">
        <input type="hidden" name="tanggal" value="{{ $tanggal }}">

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th style="width:40px;">#</th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th style="text-align:center;width:80px;">
                            <span style="color:#16a34a;"><i class="fas fa-check-circle"></i> Hadir</span>
                        </th>
                        <th style="text-align:center;width:80px;">
                            <span style="color:#2563eb;"><i class="fas fa-procedures"></i> Sakit</span>
                        </th>
                        <th style="text-align:center;width:80px;">
                            <span style="color:#d97706;"><i class="fas fa-door-open"></i> Izin</span>
                        </th>
                        <th style="text-align:center;width:80px;">
                            <span style="color:#dc2626;"><i class="fas fa-times-circle"></i> Alpa</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswaKelas as $i => $sk)
                    @if(!$sk->siswa) @continue @endif
                    @php
                        $existing = $absensi->where('siswa_id', $sk->siswa->id)
                                           ->where('mata_pelajaran_id', $mapelId)
                                           ->first();
                        $currentStatus = $existing?->status ?? 'hadir';
                    @endphp
                    <tr id="row-{{ $sk->siswa->id }}">
                        <td style="font-size:12px;color:var(--text-muted);">{{ $i+1 }}</td>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,var(--blue-300),var(--blue-500));color:white;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;flex-shrink:0;">
                                    {{ strtoupper(substr($sk->siswa->name,0,1)) }}
                                </div>
                                <div>
                                    <div style="font-weight:600;font-size:14px;">{{ $sk->siswa->name }}</div>
                                    @if($existing)
                                    <div style="font-size:10px;color:var(--text-muted);">Data tersimpan</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td><span class="badge badge-blue">{{ $sk->siswa->nis ?? '-' }}</span></td>

                        @foreach(['hadir'=>'#16a34a','sakit'=>'#2563eb','izin'=>'#d97706','alpa'=>'#dc2626'] as $status => $color)
                        <td style="text-align:center;">
                            <label style="cursor:pointer;display:flex;align-items:center;justify-content:center;width:100%;height:40px;">
                                <input type="radio"
                                    name="absensis[{{ $sk->siswa->id }}]"
                                    value="{{ $status }}"
                                    {{ $currentStatus == $status ? 'checked' : '' }}
                                    onchange="updateRow({{ $sk->siswa->id }}, '{{ $status }}')"
                                    style="width:18px;height:18px;accent-color:{{ $color }};cursor:pointer;">
                            </label>
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Rekap cepat --}}
        <div style="display:flex;gap:10px;margin-top:16px;padding:12px 16px;background:var(--blue-50);border-radius:10px;align-items:center;flex-wrap:wrap;">
            <span style="font-size:13px;font-weight:600;color:var(--text-muted);">Rekap:</span>
            <span id="count-hadir" style="font-size:13px;font-weight:700;color:#16a34a;">H: 0</span>
            <span id="count-sakit" style="font-size:13px;font-weight:700;color:#2563eb;">S: 0</span>
            <span id="count-izin" style="font-size:13px;font-weight:700;color:#d97706;">I: 0</span>
            <span id="count-alpa" style="font-size:13px;font-weight:700;color:#dc2626;">A: 0</span>
        </div>

        <div style="margin-top:16px;display:flex;justify-content:flex-end;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Absensi
            </button>
        </div>
    </form>
    @endif
</div>
@endsection

@push('scripts')
<script>
function setAll(status) {
    document.querySelectorAll(`input[value="${status}"]`).forEach(r => {
        r.checked = true;
        updateRow(r.name.match(/\d+/)[0], status);
    });
    updateCount();
}

function updateRow(siswaId, status) {
    updateCount();
}

function updateCount() {
    const statuses = ['hadir','sakit','izin','alpa'];
    statuses.forEach(s => {
        const count = document.querySelectorAll(`input[value="${s}"]:checked`).length;
        const labels = {'hadir':'H','sakit':'S','izin':'I','alpa':'A'};
        const el = document.getElementById(`count-${s}`);
        if (el) el.textContent = `${labels[s]}: ${count}`;
    });
}

// Hitung saat halaman load
document.addEventListener('DOMContentLoaded', updateCount);
</script>
@endpush