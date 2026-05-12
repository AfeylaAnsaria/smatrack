<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\{Absensi, Nilai, Jadwal, Pengumuman, TahunAjaran, DataKuliah};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    private function getKelasAktif()
    {
        $ta = TahunAjaran::aktif();
        $user = Auth::user();
        return $user->siswaKelas()->where('tahun_ajaran_id', $ta?->id)->with('kelas')->first();
    }

    public function dashboard()
    {
        $user = Auth::user();
        $ta = TahunAjaran::aktif();
        $sk = $this->getKelasAktif();
        $kelas = $sk?->kelas;

        $statsAbsensi = [
            'hadir' => Absensi::where('siswa_id',$user->id)->where('tahun_ajaran_id',$ta?->id)->where('status','hadir')->count(),
            'sakit' => Absensi::where('siswa_id',$user->id)->where('tahun_ajaran_id',$ta?->id)->where('status','sakit')->count(),
            'izin' => Absensi::where('siswa_id',$user->id)->where('tahun_ajaran_id',$ta?->id)->where('status','izin')->count(),
            'alpa' => Absensi::where('siswa_id',$user->id)->where('tahun_ajaran_id',$ta?->id)->where('status','alpa')->count(),
        ];

        $pengumumans = Pengumuman::where(function($q) use ($kelas) {
            $q->where('untuk','semua')
              ->orWhere('untuk','siswa');
            if ($kelas && $kelas->tingkat == '12') {
                $q->orWhere('untuk','kelas12');
            }
        })->latest()->take(5)->get();

        $isKelas12 = $kelas && $kelas->tingkat == '12';
        $dataKuliah = $isKelas12 ? DataKuliah::where('siswa_id',$user->id)->where('tahun_ajaran_id',$ta?->id)->first() : null;

        return view('siswa.dashboard', compact('user','kelas','statsAbsensi','pengumumans','isKelas12','dataKuliah','ta'));
    }

    public function absensi()
    {
        $user = Auth::user();
        $ta = TahunAjaran::aktif();
        $sk = $this->getKelasAktif();
        $absensi = Absensi::where('siswa_id',$user->id)
            ->where('tahun_ajaran_id',$ta?->id)
            ->with('mataPelajaran')
            ->orderBy('tanggal','desc')
            ->paginate(20);

        $rekap = [
            'hadir' => Absensi::where('siswa_id',$user->id)->where('tahun_ajaran_id',$ta?->id)->where('status','hadir')->count(),
            'sakit' => Absensi::where('siswa_id',$user->id)->where('tahun_ajaran_id',$ta?->id)->where('status','sakit')->count(),
            'izin' => Absensi::where('siswa_id',$user->id)->where('tahun_ajaran_id',$ta?->id)->where('status','izin')->count(),
            'alpa' => Absensi::where('siswa_id',$user->id)->where('tahun_ajaran_id',$ta?->id)->where('status','alpa')->count(),
        ];

        return view('siswa.absensi', compact('absensi','rekap','sk'));
    }

    public function nilai(Request $request)
    {
        $user = Auth::user();
        $ta = TahunAjaran::aktif();
        $sk = $this->getKelasAktif();
        $semester = $request->semester ?? '1';

        $nilais = Nilai::where('siswa_id',$user->id)
            ->where('tahun_ajaran_id',$ta?->id)
            ->where('semester',$semester)
            ->with('mataPelajaran')
            ->get();

        return view('siswa.nilai', compact('nilais','semester','sk'));
    }

    public function rapot()
    {
        $user = Auth::user();
        $ta = TahunAjaran::aktif();
        $sk = $this->getKelasAktif();

        $nilaiSem1 = Nilai::where('siswa_id',$user->id)
            ->where('tahun_ajaran_id',$ta?->id)
            ->where('semester','1')
            ->with('mataPelajaran')
            ->get();

        $nilaiSem2 = Nilai::where('siswa_id',$user->id)
            ->where('tahun_ajaran_id',$ta?->id)
            ->where('semester','2')
            ->with('mataPelajaran')
            ->get();

        $absensiRekap = [
            'hadir' => Absensi::where('siswa_id',$user->id)->where('tahun_ajaran_id',$ta?->id)->where('status','hadir')->count(),
            'sakit' => Absensi::where('siswa_id',$user->id)->where('tahun_ajaran_id',$ta?->id)->where('status','sakit')->count(),
            'izin' => Absensi::where('siswa_id',$user->id)->where('tahun_ajaran_id',$ta?->id)->where('status','izin')->count(),
            'alpa' => Absensi::where('siswa_id',$user->id)->where('tahun_ajaran_id',$ta?->id)->where('status','alpa')->count(),
        ];

        return view('siswa.rapot', compact('nilaiSem1','nilaiSem2','absensiRekap','sk','ta','user'));
    }

    public function jadwal()
    {
        $ta = TahunAjaran::aktif();
        $sk = $this->getKelasAktif();
        $jadwals = $sk ? Jadwal::where('kelas_id', $sk->kelas_id)
            ->where('tahun_ajaran_id', $ta?->id)
            ->with(['mataPelajaran','guru'])
            ->orderByRaw("FIELD(hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari') : collect();

        return view('siswa.jadwal', compact('jadwals','sk'));
    }

    public function kuliah()
    {
        $user = Auth::user();
        $ta = TahunAjaran::aktif();
        $sk = $this->getKelasAktif();

        if (!$sk || $sk->kelas->tingkat != '12') {
            abort(403, 'Fitur ini hanya untuk siswa kelas 12.');
        }

        $dataKuliah = DataKuliah::where('siswa_id',$user->id)
            ->where('tahun_ajaran_id',$ta?->id)
            ->first();

        return view('siswa.kuliah', compact('dataKuliah','sk','user'));
    }
}
