@extends('layouts.app')
@section('title', 'Jadwal Pelajaran')
@section('page-title', 'Jadwal Pelajaran')
@section('page-subtitle', 'Kelola jadwal pelajaran per kelas')

@section('content')

{{-- Filter Kelas --}}
<div class="card mb-4">
    <form method="GET" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;">
        <div class="form-group" style="margin:0;flex:1;min-width:180px;">
            <label class="form-label">Pilih Kelas</label>
            <select name="kelas_id" class="form-control" onchange="this.form.submit()">
                @foreach($kelas as $k)
                <option value="{{ $k->id }}" {{ $k->id == $kelasId ? 'selected' : '' }}>
                    {{ $k->nama_kelas }} — Kelas {{ $k->tingkat }}
                </option>
                @endforeach
            </select>
        </div>
        <button type="button" class="btn btn-primary" onclick="openModal('modalTambahJadwal')">
            <i class="fas fa-plus"></i> Tambah Jadwal
        </button>
    </form>
</div>

{{-- Tabel per hari --}}
@php $hariList = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu']; @endphp

@if(collect($jadwals)->flatten()->count() > 0)
<div style="display:flex;flex-direction:column;gap:16px;">
    @foreach($hariList as $hari)
    @if(isset($jadwals[$hari]) && $jadwals[$hari]->count() > 0)
    <div class="card" style="padding:0;overflow:hidden;">
        {{-- Header hari --}}
        <div style="background:linear-gradient(135deg,var(--blue-400),var(--blue-600));padding:12px 20px;display:flex;align-items:center;gap:10px;">
            <div style="width:34px;height:34px;border-radius:9px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:white;font-weight:800;font-size:12px;">
                {{ strtoupper(substr($hari,0,3)) }}
            </div>
            <div style="font-size:15px;font-weight:800;color:white;">{{ $hari }}</div>
            <span style="margin-left:auto;background:rgba(255,255,255,0.2);color:white;font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;">
                {{ $jadwals[$hari]->count() }} JP
            </span>
        </div>

        {{-- Tabel --}}
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Jam</th>
                        <th>Mata Pelajaran</th>
                        <th>Guru</th>
                        <th>Ruangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jadwals[$hari] as $j)
                    <tr>
                        <td>
                            <div style="font-weight:700;font-size:13px;color:var(--blue-600);">
                                {{ substr($j->jam_mulai,0,5) }} – {{ substr($j->jam_selesai,0,5) }}
                            </div>
                        </td>
                        <td>
                            <div style="font-weight:600;font-size:14px;">{{ $j->mataPelajaran->nama }}</div>
                            <div style="font-size:11px;color:var(--text-muted);">{{ $j->mataPelajaran->kode }}</div>
                        </td>
                        <td style="font-size:13px;">{{ $j->guru->name }}</td>
                        <td>
                            @if($j->ruangan)
                            <span class="badge badge-blue"><i class="fas fa-door-closed"></i> &nbsp;{{ $j->ruangan }}</span>
                            @else
                            <span style="color:var(--text-muted);font-size:12px;">—</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex;gap:6px;">
                                <button class="btn btn-secondary btn-sm btn-icon"
                                    onclick="openEditModal({{ $j->id }},'{{ $j->mata_pelajaran_id }}','{{ $j->guru_id }}','{{ $j->hari }}','{{ substr($j->jam_mulai,0,5) }}','{{ substr($j->jam_selesai,0,5) }}','{{ $j->ruangan }}')">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form method="POST" action="{{ route('admin.jadwal.destroy', $j->id) }}" onsubmit="return confirm('Hapus jadwal ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-icon">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
    @endforeach
</div>
@else
<div class="card">
    <div class="empty-state">
        <i class="fas fa-calendar-alt"></i>
        <p>Belum ada jadwal untuk kelas ini. Klik <strong>Tambah Jadwal</strong> untuk mulai!</p>
    </div>
</div>
@endif

{{-- ===== MODAL TAMBAH ===== --}}
<div class="modal-overlay" id="modalTambahJadwal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">➕ Tambah Jadwal Baru</div>
            <button class="modal-close" onclick="closeModal('modalTambahJadwal')"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" action="{{ route('admin.jadwal.store') }}">
            @csrf
            <input type="hidden" name="kelas_id" value="{{ $kelasId }}">

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Mata Pelajaran *</label>
                    <select name="mata_pelajaran_id" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        @foreach($mapels as $m)
                        <option value="{{ $m->id }}">{{ $m->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Guru *</label>
                    <select name="guru_id" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        @foreach($gurus as $g)
                        <option value="{{ $g->id }}">{{ $g->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Hari *</label>
                <select name="hari" class="form-control" required>
                    <option value="">-- Pilih Hari --</option>
                    @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $h)
                    <option value="{{ $h }}">{{ $h }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Jam Mulai *</label>
                    <input type="time" name="jam_mulai" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Jam Selesai *</label>
                    <input type="time" name="jam_selesai" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Ruangan</label>
                <input type="text" name="ruangan" class="form-control" placeholder="Contoh: Ruang 12A, Lab Komputer">
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
                <i class="fas fa-save"></i> Simpan Jadwal
            </button>
        </form>
    </div>
</div>

{{-- ===== MODAL EDIT ===== --}}
<div class="modal-overlay" id="modalEditJadwal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">✏️ Edit Jadwal</div>
            <button class="modal-close" onclick="closeModal('modalEditJadwal')"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" id="formEditJadwal">
            @csrf @method('PUT')

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Mata Pelajaran *</label>
                    <select name="mata_pelajaran_id" id="edit_mapel" class="form-control" required>
                        @foreach($mapels as $m)
                        <option value="{{ $m->id }}">{{ $m->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Guru *</label>
                    <select name="guru_id" id="edit_guru" class="form-control" required>
                        @foreach($gurus as $g)
                        <option value="{{ $g->id }}">{{ $g->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Hari *</label>
                <select name="hari" id="edit_hari" class="form-control" required>
                    @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $h)
                    <option value="{{ $h }}">{{ $h }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Jam Mulai *</label>
                    <input type="time" name="jam_mulai" id="edit_jam_mulai" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Jam Selesai *</label>
                    <input type="time" name="jam_selesai" id="edit_jam_selesai" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Ruangan</label>
                <input type="text" name="ruangan" id="edit_ruangan" class="form-control" placeholder="Opsional">
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
                <i class="fas fa-save"></i> Update Jadwal
            </button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openEditModal(id, mapelId, guruId, hari, jamMulai, jamSelesai, ruangan) {
    document.getElementById('formEditJadwal').action = '/admin/jadwal/' + id;
    document.getElementById('edit_mapel').value    = mapelId;
    document.getElementById('edit_guru').value     = guruId;
    document.getElementById('edit_hari').value     = hari;
    document.getElementById('edit_jam_mulai').value  = jamMulai;
    document.getElementById('edit_jam_selesai').value = jamSelesai;
    document.getElementById('edit_ruangan').value  = ruangan || '';
    openModal('modalEditJadwal');
}
</script>
@endpush