@extends('layouts.app')
@section('title', 'Kelola Kelas')
@section('page-title', 'Kelola Kelas')
@section('page-subtitle', 'Manajemen kelas tahun ajaran aktif')

@section('content')
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
    <div>
        <h1 style="font-size:24px;font-weight:800;">Kelola Kelas</h1>
        <p class="text-muted">Tahun Ajaran: {{ $ta?->tahun }}</p>
    </div>
    <button class="btn btn-primary" onclick="openModal('modalTambahKelas')">
        <i class="fas fa-plus"></i> Tambah Kelas
    </button>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px;margin-bottom:24px;">
    @forelse($kelas as $k)
    <div class="card" style="padding:20px;border-left:4px solid {{ $k->tingkat=='12' ? 'var(--pink-500)' : ($k->tingkat=='11' ? '#805ad5' : '#3182ce') }};">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:12px;">
            <div>
                <div style="font-size:18px;font-weight:800;color:var(--text);">{{ $k->nama_kelas }}</div>
                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;">
                    Kelas {{ $k->tingkat }} &bull; {{ $k->jurusan ?? 'Umum' }}
                </div>
            </div>
            <span class="badge badge-{{ $k->tingkat=='12' ? 'pink' : ($k->tingkat=='11' ? 'purple' : 'blue') }}">
                Kelas {{ $k->tingkat }}
            </span>
        </div>
        <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
            <i class="fas fa-users" style="color:var(--text-muted);font-size:13px;"></i>
            <span style="font-size:13px;"><strong>{{ $k->siswaKelas->count() }}</strong> siswa</span>
        </div>
        <div style="display:flex;align-items:center;gap:8px;">
            <i class="fas fa-chalkboard-teacher" style="color:var(--text-muted);font-size:13px;"></i>
            <span style="font-size:13px;">Wali: <strong>{{ $k->waliKelas?->name ?? 'Belum ditentukan' }}</strong></span>
        </div>
        @if($k->tingkat == '12')
        <div style="margin-top:12px;padding:8px 12px;background:var(--pink-50);border-radius:8px;border:1px solid var(--pink-200);">
            <span style="font-size:11px;color:var(--pink-600);font-weight:600;">🎓 Fitur Tracker Kuliah Aktif</span>
        </div>
        @endif
    </div>
    @empty
    <div class="card"><div class="empty-state"><i class="fas fa-school"></i><p>Belum ada kelas</p></div></div>
    @endforelse
</div>

<!-- Modal Tambah Kelas -->
<div class="modal-overlay" id="modalTambahKelas">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">➕ Tambah Kelas Baru</div>
            <button class="modal-close" onclick="closeModal('modalTambahKelas')"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" action="{{ route('admin.kelas.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Kelas *</label>
                <input type="text" name="nama_kelas" class="form-control" placeholder="Contoh: XII IPA 1" required>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Tingkat *</label>
                    <select name="tingkat" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="10">Kelas 10</option>
                        <option value="11">Kelas 11</option>
                        <option value="12">Kelas 12</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Jurusan</label>
                    <select name="jurusan" class="form-control">
                        <option value="">-- Pilih --</option>
                        <option value="IPA">IPA</option>
                        <option value="IPS">IPS</option>
                        <option value="Bahasa">Bahasa</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Wali Kelas</label>
                <select name="wali_kelas_id" class="form-control">
                    <option value="">-- Belum ditentukan --</option>
                    @foreach($gurus as $g)
                    <option value="{{ $g->id }}">{{ $g->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
                <i class="fas fa-save"></i> Simpan Kelas
            </button>
        </form>
    </div>
</div>
@endsection
