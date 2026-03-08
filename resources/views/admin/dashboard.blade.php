@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:1.25rem;margin-bottom:2rem">
    <div class="card" style="border-left:4px solid #7c3aed">
        <p style="color:#94a3b8;font-size:.8rem;text-transform:uppercase;margin-bottom:.5rem">Total Proyek</p>
        <p style="font-size:2.5rem;font-weight:700">{{ $stats['total_projects'] }}</p>
    </div>
    <div class="card" style="border-left:4px solid #22c55e">
        <p style="color:#94a3b8;font-size:.8rem;text-transform:uppercase;margin-bottom:.5rem">Dipublikasikan</p>
        <p style="font-size:2.5rem;font-weight:700">{{ $stats['published'] }}</p>
    </div>
    <div class="card" style="border-left:4px solid #f59e0b">
        <p style="color:#94a3b8;font-size:.8rem;text-transform:uppercase;margin-bottom:.5rem">Pesan Belum Dibaca</p>
        <p style="font-size:2.5rem;font-weight:700">{{ $stats['unread_messages'] }}</p>
    </div>
</div>

<div class="card">
    <h3 style="margin-bottom:1.25rem;font-size:1rem">Pesan Terbaru</h3>
    @forelse($recentMessages as $msg)
        <div style="padding:.75rem 0;border-bottom:1px solid #334155;display:flex;justify-content:space-between;align-items:center">
            <div>
                <span style="font-weight:600">{{ $msg->name }}</span>
                <span style="color:#94a3b8;font-size:.85rem;margin-left:.75rem">{{ $msg->email }}</span>
                @unless($msg->is_read)
                    <span class="badge badge-purple" style="margin-left:.5rem">Baru</span>
                @endunless
            </div>
            <span style="color:#64748b;font-size:.8rem">{{ $msg->created_at->diffForHumans() }}</span>
        </div>
    @empty
        <p style="color:#64748b">Belum ada pesan.</p>
    @endforelse
    <div style="margin-top:1rem">
        <a href="{{ route('admin.messages') }}" class="btn btn-secondary">Lihat Semua Pesan</a>
    </div>
</div>
@endsection