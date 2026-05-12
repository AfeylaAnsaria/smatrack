<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Jadwal, Kelas, MataPelajaran, TahunAjaran, User};
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $ta = TahunAjaran::aktif();
        $kelas = Kelas::where('tahun_ajaran_id', $ta?->id)->get();
        $mapels = MataPelajaran::all();
        $gurus = User::where('role', 'guru')->get();

        $kelasId = $request->kelas_id ?? $kelas->first()?->id;

        $jadwals = Jadwal::where('kelas_id', $kelasId)
            ->where('tahun_ajaran_id', $ta?->id)
            ->with(['mataPelajaran', 'guru', 'kelas'])
            ->orderByRaw("FIELD(hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        return view('admin.jadwal.index', compact('kelas', 'mapels', 'gurus', 'jadwals', 'kelasId', 'ta'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id'          => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'guru_id'           => 'required|exists:users,id',
            'hari'              => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai'         => 'required',
            'jam_selesai'       => 'required',
            'ruangan'           => 'nullable|string|max:50',
        ]);

        Jadwal::create([
            'kelas_id'          => $request->kelas_id,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'guru_id'           => $request->guru_id,
            'hari'              => $request->hari,
            'jam_mulai'         => $request->jam_mulai,
            'jam_selesai'       => $request->jam_selesai,
            'ruangan'           => $request->ruangan,
            'tahun_ajaran_id'   => TahunAjaran::aktif()->id,
        ]);

        return back()->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        Jadwal::findOrFail($id)->delete();
        return back()->with('success', 'Jadwal berhasil dihapus!');
    }

    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $mapels = MataPelajaran::all();
        $gurus  = User::where('role', 'guru')->get();
        return response()->json([
            'jadwal' => $jadwal,
            'mapels' => $mapels,
            'gurus'  => $gurus,
        ]);
    }

    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'guru_id'           => 'required|exists:users,id',
            'hari'              => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai'         => 'required',
            'jam_selesai'       => 'required',
            'ruangan'           => 'nullable|string|max:50',
        ]);

        $jadwal->update($request->only(['mata_pelajaran_id','guru_id','hari','jam_mulai','jam_selesai','ruangan']));
        return back()->with('success', 'Jadwal berhasil diperbarui!');
    }
}