@extends('layouts.app')
@section('title', 'Pengumuman Guru')
@section('page-title', 'Pengumuman untuk Guru')
@section('page-subtitle', 'Informasi dan pengumuman khusus untuk guru')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">📢 Pengumuman</div>
        <div class="card-subtitle">Pengumuman yang ditujukan untuk guru dan umum</div>
    </div>

    <div style="max-height:540px;overflow-y:auto;padding:12px;">
        @forelse($pengumumans as $p)
        <div style="padding:14px;border-radius:10px;border:1px solid var(--border);margin-bottom:10px;background:white;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                <div style="font-weight:700">{{ $p->judul }}</div>
                <div style="font-size:12px;color:var(--text-muted);">{{ $p->created_at->translatedFormat('d F Y H:i') }}</div>
            </div>
            <div style="font-size:13px;color:var(--text);line-height:1.6;">{!! nl2br(e($p->isi)) !!}</div>
        </div>
        @empty
        <div class="empty-state" style="padding:40px;">Belum ada pengumuman untuk guru</div>
        @endforelse
    </div>
</div>

<div style="display:flex;justify-content:center;margin-top:12px;">{{ $pengumumans->links() }}</div>

@endsection
