<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, Kelas, Absensi, Nilai, DataKuliah, Pengumuman, TahunAjaran, MataPelajaran, SiswaKelas};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $ta = TahunAjaran::aktif();
        $stats = [
            'total_siswa' => User::where('role', 'siswa')->count(),
            'total_guru' => User::where('role', 'guru')->count(),
            'total_kelas' => Kelas::where('tahun_ajaran_id', $ta?->id)->count(),
            'siswa_kelas12' => SiswaKelas::whereHas('kelas', fn($q) => $q->where('tingkat','12'))->where('tahun_ajaran_id', $ta?->id)->count(),
            'diterima_kuliah' => DataKuliah::where('status','diterima')->where('tahun_ajaran_id', $ta?->id)->count(),
            'proses_kuliah' => DataKuliah::where('status','sedang_proses')->where('tahun_ajaran_id', $ta?->id)->count(),
        ];
        $pengumumans = Pengumuman::latest()->take(5)->get();
        return view('admin.dashboard', compact('stats', 'pengumumans', 'ta'));
    }

    // ===================== USERS =====================
    public function siswaIndex()
    {
        $siswa = User::where('role','siswa')->with('siswaKelas.kelas')->latest()->paginate(15);
        $kelas = Kelas::where('tahun_ajaran_id', TahunAjaran::aktif()?->id)->get();
        return view('admin.siswa.index', compact('siswa','kelas'));
    }

    public function siswaStore(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'nis' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'alamat' => 'nullable|string',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'siswa',
            'nis' => $data['nis'] ?? null,
            'no_hp' => $data['no_hp'] ?? null,
            'alamat' => $data['alamat'] ?? null,
        ]);

        SiswaKelas::create([
            'siswa_id' => $user->id,
            'kelas_id' => $data['kelas_id'],
            'tahun_ajaran_id' => TahunAjaran::aktif()->id,
        ]);

        return back()->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function siswaDestroy($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Siswa berhasil dihapus!');
    }

    public function guruIndex()
    {
        $guru = User::where('role','guru')->latest()->paginate(15);
        return view('admin.guru.index', compact('guru'));
    }

    public function guruStore(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'nip' => 'nullable|string',
            'no_hp' => 'nullable|string',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'guru',
            'nip' => $data['nip'] ?? null,
            'no_hp' => $data['no_hp'] ?? null,
        ]);

        return back()->with('success', 'Guru berhasil ditambahkan!');
    }

    // ===================== KELAS =====================
    public function kelasIndex()
    {
        $ta = TahunAjaran::aktif();
        $kelas = Kelas::where('tahun_ajaran_id', $ta?->id)->with(['waliKelas','siswaKelas'])->get();
        $gurus = User::where('role','guru')->get();
        return view('admin.kelas.index', compact('kelas','gurus','ta'));
    }

    public function kelasStore(Request $request)
    {
        $data = $request->validate([
            'nama_kelas' => 'required|string',
            'tingkat' => 'required|in:10,11,12',
            'jurusan' => 'nullable|string',
            'wali_kelas_id' => 'nullable|exists:users,id',
        ]);

        Kelas::create(array_merge($data, ['tahun_ajaran_id' => TahunAjaran::aktif()->id]));
        return back()->with('success', 'Kelas berhasil ditambahkan!');
    }

    // ===================== ABSENSI =====================
    public function absensiIndex(Request $request)
    {
        $ta = TahunAjaran::aktif();
        $kelas = Kelas::where('tahun_ajaran_id', $ta?->id)->get();
        $kelasId = $request->kelas_id ?? $kelas->first()?->id;
        $tanggal = $request->tanggal ?? today()->toDateString();

        $absensi = Absensi::where('tahun_ajaran_id', $ta?->id)
            ->where('kelas_id', $kelasId)
            ->where('tanggal', $tanggal)
            ->with(['siswa','mataPelajaran'])
            ->get();

        $siswaKelas = SiswaKelas::where('kelas_id', $kelasId)
            ->where('tahun_ajaran_id', $ta?->id)
            ->with('siswa')
            ->get();

        $mapels = MataPelajaran::all();
        return view('admin.absensi.index', compact('absensi','kelas','kelasId','tanggal','siswaKelas','mapels'));
    }

    public function absensiStore(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'tanggal' => 'required|date',
            'absensis' => 'required|array',
        ]);

        $ta = TahunAjaran::aktif();
        foreach ($request->absensis as $siswaId => $status) {
            Absensi::updateOrCreate(
                [
                    'siswa_id' => $siswaId,
                    'kelas_id' => $request->kelas_id,
                    'mata_pelajaran_id' => $request->mata_pelajaran_id,
                    'tanggal' => $request->tanggal,
                    'tahun_ajaran_id' => $ta->id,
                ],
                ['status' => $status]
            );
        }

        return back()->with('success', 'Absensi berhasil disimpan!');
    }

    // ===================== NILAI =====================
    public function nilaiIndex(Request $request)
    {
        $ta = TahunAjaran::aktif();
        $kelas = Kelas::where('tahun_ajaran_id', $ta?->id)->get();
        $mapels = MataPelajaran::all();
        $kelasId = $request->kelas_id ?? $kelas->first()?->id;
        $mapelId = $request->mata_pelajaran_id ?? $mapels->first()?->id;
        $semester = $request->semester ?? '1';

        $siswaKelas = SiswaKelas::where('kelas_id', $kelasId)
            ->where('tahun_ajaran_id', $ta?->id)
            ->with(['siswa', 'siswa.nilais' => function($q) use ($mapelId, $semester, $ta, $kelasId) {
                $q->where('mata_pelajaran_id', $mapelId)
                  ->where('semester', $semester)
                  ->where('tahun_ajaran_id', $ta?->id)
                  ->where('kelas_id', $kelasId);
            }])
            ->get();

        return view('admin.nilai.index', compact('kelas','mapels','kelasId','mapelId','semester','siswaKelas','ta'));
    }

    public function nilaiStore(Request $request)
    {
        $ta = TahunAjaran::aktif();
        foreach ($request->nilais as $siswaId => $nilaiData) {
            $nh = $nilaiData['nilai_harian'] ?? null;
            $nuts = $nilaiData['nilai_uts'] ?? null;
            $nuas = $nilaiData['nilai_uas'] ?? null;
            $akhir = null;
            if ($nh && $nuts && $nuas) {
                $akhir = ($nh * 0.4) + ($nuts * 0.3) + ($nuas * 0.3);
            }

            Nilai::updateOrCreate(
                [
                    'siswa_id' => $siswaId,
                    'mata_pelajaran_id' => $request->mata_pelajaran_id,
                    'kelas_id' => $request->kelas_id,
                    'semester' => $request->semester,
                    'tahun_ajaran_id' => $ta->id,
                ],
                [
                    'nilai_harian' => $nh,
                    'nilai_uts' => $nuts,
                    'nilai_uas' => $nuas,
                    'nilai_akhir' => $akhir,
                    'predikat' => $akhir ? Nilai::hitungPredikat($akhir) : null,
                    'catatan' => $nilaiData['catatan'] ?? null,
                ]
            );
        }

        return back()->with('success', 'Nilai berhasil disimpan!');
    }

    // ===================== KULIAH KELAS 12 =====================
    public function kuliahIndex(Request $request)
    {
        $ta = TahunAjaran::aktif();
        $data = DataKuliah::where('tahun_ajaran_id', $ta?->id)
            ->with('siswa')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->jalur, fn($q) => $q->where('jalur', $request->jalur))
            ->paginate(15);

        $stats = [
            'total' => DataKuliah::where('tahun_ajaran_id', $ta?->id)->count(),
            'diterima' => DataKuliah::where('tahun_ajaran_id', $ta?->id)->where('status','diterima')->count(),
            'proses' => DataKuliah::where('tahun_ajaran_id', $ta?->id)->where('status','sedang_proses')->count(),
            'tidak_diterima' => DataKuliah::where('tahun_ajaran_id', $ta?->id)->where('status','tidak_diterima')->count(),
        ];

        $siswaKelas12 = User::where('role','siswa')
            ->whereHas('siswaKelas.kelas', fn($q) => $q->where('tingkat','12')->where('tahun_ajaran_id', $ta?->id))
            ->get();

        return view('admin.kuliah.index', compact('data','stats','siswaKelas12'));
    }

    public function kuliahStore(Request $request)
    {
        $data = $request->validate([
            'siswa_id' => 'required|exists:users,id',
            'universitas_tujuan_1' => 'required|string',
            'prodi_tujuan_1' => 'required|string',
            'universitas_tujuan_2' => 'nullable|string',
            'prodi_tujuan_2' => 'nullable|string',
            'jalur' => 'required|in:SNBP,SNBT,Mandiri,Beasiswa',
            'status' => 'required|in:belum_daftar,sedang_proses,diterima,tidak_diterima',
            'universitas_diterima' => 'nullable|string',
            'prodi_diterima' => 'nullable|string',
            'tanggal_pengumuman' => 'nullable|date',
            'catatan' => 'nullable|string',
        ]);

        $ta = TahunAjaran::aktif();
        DataKuliah::updateOrCreate(
            ['siswa_id' => $data['siswa_id'], 'tahun_ajaran_id' => $ta->id],
            array_merge($data, ['tahun_ajaran_id' => $ta->id])
        );

        return back()->with('success', 'Data kuliah berhasil disimpan!');
    }

    public function kuliahUpdate(Request $request, $id)
    {
        $dk = DataKuliah::findOrFail($id);
        $dk->update($request->only(['status','universitas_diterima','prodi_diterima','tanggal_pengumuman','catatan']));
        return back()->with('success', 'Status kuliah diperbarui!');
    }

    // ===================== PENGUMUMAN =====================
    public function pengumumanIndex()
    {
        $data = Pengumuman::with('pembuat')->latest()->paginate(10);
        return view('admin.pengumuman.index', compact('data'));
    }

    public function pengumumanStore(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:200',
            'isi' => 'required|string',
            'untuk' => 'required|in:semua,siswa,guru,kelas12',
        ]);

        Pengumuman::create(array_merge($data, ['dibuat_oleh' => auth()->id()]));
        return back()->with('success', 'Pengumuman berhasil ditambahkan!');
    }

    public function pengumumanDestroy($id)
    {
        Pengumuman::findOrFail($id)->delete();
        return back()->with('success', 'Pengumuman dihapus!');
    }
}
