@extends('layouts.app')
@section('title', 'Data Kuliah Kelas 12')
@section('page-title', 'Tracker Kuliah Kelas 12')
@section('page-subtitle', 'Pantau data perguruan tinggi siswa kelas 12')

@section('content')
<!-- Stats -->
<div class="stats-grid" style="grid-template-columns:repeat(4,1fr);">
    <div class="stat-card">
        <div class="stat-icon pink"><i class="fas fa-users"></i></div>
        <div><div class="stat-value">{{ $stats['total'] }}</div><div class="stat-label">Total Pendaftar</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
        <div><div class="stat-value">{{ $stats['diterima'] }}</div><div class="stat-label">Diterima</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-hourglass-half"></i></div>
        <div><div class="stat-value">{{ $stats['proses'] }}</div><div class="stat-label">Sedang Proses</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon rose"><i class="fas fa-times-circle"></i></div>
        <div><div class="stat-value">{{ $stats['tidak_diterima'] }}</div><div class="stat-label">Tidak Diterima</div></div>
    </div>
</div>

<div class="grid-2">
    <!-- Tambah/Update Data Kuliah -->
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">🎓 Input Data Kuliah</div>
                <div class="card-subtitle">Tambah atau update data pendaftaran kuliah siswa</div>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.kuliah.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Siswa Kelas 12 *</label>
                <select name="siswa_id" class="form-control" required>
                    <option value="">-- Pilih Siswa --</option>
                    @foreach($siswaKelas12 as $s)
                    <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->nis ?? '-' }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Jalur Masuk *</label>
                <select name="jalur" class="form-control" required>
                    <option value="">-- Pilih Jalur --</option>
                    <option value="SNBP">SNBP (Seleksi Nasional Berdasarkan Prestasi)</option>
                    <option value="SNBT">SNBT (Seleksi Nasional Berdasarkan Tes)</option>
                    <option value="Mandiri">Mandiri</option>
                    <option value="Beasiswa">Beasiswa</option>
                </select>
            </div>
            <div style="background:var(--pink-50);border-radius:12px;padding:16px;margin-bottom:16px;border:1px solid var(--pink-200);">
                <div style="font-size:13px;font-weight:700;color:var(--pink-700);margin-bottom:10px;">🏛️ Pilihan Pertama</div>
                <div class="form-group" style="margin-bottom:8px;">
                    <label class="form-label">Universitas *</label>
                    <input type="text" name="universitas_tujuan_1" class="form-control" placeholder="Contoh: Universitas Indonesia" required>
                </div>
                <div class="form-group" style="margin:0;">
                    <label class="form-label">Program Studi *</label>
                    <input type="text" name="prodi_tujuan_1" class="form-control" placeholder="Contoh: Teknik Informatika" required>
                </div>
            </div>
            <div style="background:#f5f0ff;border-radius:12px;padding:16px;margin-bottom:16px;border:1px solid #d6bcfa;">
                <div style="font-size:13px;font-weight:700;color:#6b46c1;margin-bottom:10px;">🏛️ Pilihan Kedua (opsional)</div>
                <div class="form-group" style="margin-bottom:8px;">
                    <label class="form-label">Universitas</label>
                    <input type="text" name="universitas_tujuan_2" class="form-control" placeholder="Universitas pilihan ke-2">
                </div>
                <div class="form-group" style="margin:0;">
                    <label class="form-label">Program Studi</label>
                    <input type="text" name="prodi_tujuan_2" class="form-control" placeholder="Prodi pilihan ke-2">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="belum_daftar">Belum Mendaftar</option>
                    <option value="sedang_proses">Sedang Proses</option>
                    <option value="diterima">✅ Diterima</option>
                    <option value="tidak_diterima">❌ Tidak Diterima</option>
                </select>
            </div>
            <div id="detailDiterima" style="display:none;background:#f0fff4;border-radius:12px;padding:16px;margin-bottom:16px;border:1px solid #c6f6d5;">
                <div style="font-size:13px;font-weight:700;color:#276749;margin-bottom:10px;">✅ Detail Kelulusan</div>
                <div class="grid-2">
                    <div class="form-group" style="margin-bottom:8px;">
                        <label class="form-label">Universitas Diterima</label>
                        <input type="text" name="universitas_diterima" class="form-control" placeholder="Universitas">
                    </div>
                    <div class="form-group" style="margin-bottom:8px;">
                        <label class="form-label">Prodi Diterima</label>
                        <input type="text" name="prodi_diterima" class="form-control" placeholder="Program Studi">
                    </div>
                </div>
                <div class="form-group" style="margin:0;">
                    <label class="form-label">Tanggal Pengumuman</label>
                    <input type="date" name="tanggal_pengumuman" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Catatan</label>
                <textarea name="catatan" class="form-control" rows="2" placeholder="Catatan tambahan..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
                <i class="fas fa-save"></i> Simpan Data Kuliah
            </button>
        </form>
    </div>

    <!-- Tabel Data -->
    <div class="card" style="overflow:hidden;">
        <div class="card-header">
            <div>
                <div class="card-title">📊 Daftar Data Kuliah</div>
                <div class="card-subtitle">{{ $data->total() }} data terdaftar</div>
            </div>
        </div>

        <!-- Filter -->
        <form method="GET" style="display:flex;gap:8px;margin-bottom:16px;">
            <select name="status" class="form-control" style="flex:1;">
                <option value="">Semua Status</option>
                <option value="diterima" {{ request('status')=='diterima'?'selected':'' }}>Diterima</option>
                <option value="sedang_proses" {{ request('status')=='sedang_proses'?'selected':'' }}>Proses</option>
                <option value="tidak_diterima" {{ request('status')=='tidak_diterima'?'selected':'' }}>Tidak Diterima</option>
            </select>
            <select name="jalur" class="form-control" style="flex:1;">
                <option value="">Semua Jalur</option>
                <option value="SNBP" {{ request('jalur')=='SNBP'?'selected':'' }}>SNBP</option>
                <option value="SNBT" {{ request('jalur')=='SNBT'?'selected':'' }}>SNBT</option>
                <option value="Mandiri" {{ request('jalur')=='Mandiri'?'selected':'' }}>Mandiri</option>
                <option value="Beasiswa" {{ request('jalur')=='Beasiswa'?'selected':'' }}>Beasiswa</option>
            </select>
            <button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-filter"></i></button>
        </form>

        <div style="max-height:520px;overflow-y:auto;">
            @forelse($data as $d)
            <div style="padding:14px;border-radius:12px;border:1px solid var(--border);margin-bottom:10px;background:white;">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:8px;">
                    <div>
                        <div style="font-weight:700;font-size:14px;">{{ $d->siswa->name }}</div>
                        <div style="font-size:12px;color:var(--text-muted);">{{ $d->siswa->nis ?? '' }}</div>
                    </div>
                    @php
                        $badge = match($d->status) {
                            'diterima' => 'green', 'sedang_proses' => 'yellow',
                            'tidak_diterima' => 'red', default => 'gray'
                        };
                        $statusLabel = match($d->status) {
                            'diterima' => '✅ Diterima', 'sedang_proses' => '⏳ Proses',
                            'tidak_diterima' => '❌ Tidak Diterima', default => '📝 Belum Daftar'
                        };
                    @endphp
                    <span class="badge badge-{{ $badge }}">{{ $statusLabel }}</span>
                </div>
                <div style="font-size:12px;color:var(--text-muted);margin-bottom:4px;">
                    <span class="badge badge-blue" style="margin-right:4px;">{{ $d->jalur }}</span>
                    🏛️ {{ $d->universitas_tujuan_1 }} — {{ $d->prodi_tujuan_1 }}
                </div>
                @if($d->status == 'diterima' && $d->universitas_diterima)
                <div style="font-size:12px;color:#276749;background:#f0fff4;padding:4px 10px;border-radius:6px;margin-top:4px;">
                    ✅ Diterima di {{ $d->universitas_diterima }} — {{ $d->prodi_diterima }}
                </div>
                @endif
                <div style="margin-top:8px;">
                    <button class="btn btn-secondary btn-sm" onclick="openUpdateModal({{ $d->id }}, '{{ $d->status }}')">
                        <i class="fas fa-edit"></i> Update Status
                    </button>
                </div>
            </div>
            @empty
            <div class="empty-state"><i class="fas fa-university"></i><p>Belum ada data kuliah</p></div>
            @endforelse
        </div>
        <div style="margin-top:12px;">{{ $data->links() }}</div>
    </div>
</div>

<!-- Update Status Modal -->
<div class="modal-overlay" id="modalUpdateStatus">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">✏️ Update Status Kuliah</div>
            <button class="modal-close" onclick="closeModal('modalUpdateStatus')"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" id="formUpdateStatus">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">Status Baru</label>
                <select name="status" id="updateStatus" class="form-control">
                    <option value="belum_daftar">Belum Mendaftar</option>
                    <option value="sedang_proses">Sedang Proses</option>
                    <option value="diterima">✅ Diterima</option>
                    <option value="tidak_diterima">❌ Tidak Diterima</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Universitas Diterima</label>
                <input type="text" name="universitas_diterima" class="form-control" placeholder="Jika diterima">
            </div>
            <div class="form-group">
                <label class="form-label">Program Studi Diterima</label>
                <input type="text" name="prodi_diterima" class="form-control" placeholder="Jika diterima">
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal Pengumuman</label>
                <input type="date" name="tanggal_pengumuman" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Catatan</label>
                <textarea name="catatan" class="form-control" rows="2"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
                <i class="fas fa-save"></i> Update Status
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelector('select[name="status"]')?.addEventListener('change', function() {
    document.getElementById('detailDiterima').style.display = this.value === 'diterima' ? 'block' : 'none';
});

function openUpdateModal(id, currentStatus) {
    document.getElementById('formUpdateStatus').action = `/admin/kuliah/${id}`;
    document.getElementById('updateStatus').value = currentStatus;
    openModal('modalUpdateStatus');
}
</script>
@endpush
