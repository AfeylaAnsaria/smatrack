<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\{Nilai, Absensi, Jadwal, Kelas, MataPelajaran, TahunAjaran, SiswaKelas, Pengumuman};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $ta = TahunAjaran::aktif();

        $jadwalHariIni = Jadwal::where('guru_id', $user->id)
            ->where('hari', now()->locale('id')->isoFormat('dddd'))
            ->where('tahun_ajaran_id', $ta?->id)
            ->with(['kelas','mataPelajaran'])
            ->get();

        $kelasDiajar = Jadwal::where('guru_id', $user->id)
            ->where('tahun_ajaran_id', $ta?->id)
            ->with('kelas')
            ->get()
            ->pluck('kelas')
            ->unique('id');

        $pengumumans = Pengumuman::where(function($q){
            $q->where('untuk','semua')->orWhere('untuk','guru');
        })->latest()->take(5)->get();

        return view('guru.dashboard', compact('user','jadwalHariIni','kelasDiajar','pengumumans'));
    }

    public function absensi(Request $request)
    {
        $user = Auth::user();
        $ta = TahunAjaran::aktif();
        $kelas = Kelas::whereHas('jadwals', fn($q) => $q->where('guru_id', $user->id))->where('tahun_ajaran_id', $ta?->id)->get();
        $kelasId = $request->kelas_id ?? $kelas->first()?->id;
        $tanggal = $request->tanggal ?? today()->toDateString();
        $mapels = MataPelajaran::all();
        $mapelId = $request->mata_pelajaran_id;

        $absensi = Absensi::where('kelas_id', $kelasId)
            ->where('tanggal', $tanggal)
            ->where('tahun_ajaran_id', $ta?->id)
            ->with(['siswa','mataPelajaran'])
            ->get();

        $siswaKelas = SiswaKelas::where('kelas_id', $kelasId)
            ->where('tahun_ajaran_id', $ta?->id)
            ->with('siswa')
            ->get();

        return view('guru.absensi', compact('kelas','kelasId','tanggal','absensi','siswaKelas','mapels','mapelId'));
    }

    public function nilai(Request $request)
    {
        $user = Auth::user();
        $ta = TahunAjaran::aktif();
        $kelas = Kelas::whereHas('jadwals', fn($q) => $q->where('guru_id', $user->id))->where('tahun_ajaran_id', $ta?->id)->get();
        $mapels = MataPelajaran::all();
        $kelasId = $request->kelas_id ?? $kelas->first()?->id;
        $mapelId = $request->mata_pelajaran_id ?? $mapels->first()?->id;
        $semester = $request->semester ?? '1';

        $nilais = Nilai::where('kelas_id', $kelasId)
            ->where('mata_pelajaran_id', $mapelId)
            ->where('semester', $semester)
            ->where('tahun_ajaran_id', $ta?->id)
            ->with('siswa')
            ->get();

        return view('guru.nilai', compact('kelas','mapels','kelasId','mapelId','semester','nilais'));
    }

    public function jadwal()
    {
        $user = Auth::user();
        $ta = TahunAjaran::aktif();
        $jadwals = Jadwal::where('guru_id', $user->id)
            ->where('tahun_ajaran_id', $ta?->id)
            ->with(['kelas','mataPelajaran'])
            ->orderByRaw("FIELD(hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        return view('guru.jadwal', compact('jadwals'));
    }

    public function pengumuman()
    {
        $user = Auth::user();
        $ta = TahunAjaran::aktif();

        $pengumumans = Pengumuman::where(function($q){
            $q->where('untuk','semua')->orWhere('untuk','guru');
        })->latest()->paginate(15);

        return view('guru.pengumuman', compact('pengumumans'));
    }
}
