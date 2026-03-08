@extends('layouts.admin')
@section('title', 'Pesan Masuk')

@section('content')
<div class="card">
    <table>
        <thead>
            <tr>
                <th>Pengirim</th>
                <th>Subjek</th>
                <th>Pesan</th>
                <th>Dikirim</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($messages as $msg)
            <tr class="{{ !$msg->is_read ? 'unread-row' : '' }}">
                <td>
                    <strong>{{ $msg->name }}</strong><br>
                    <small style="color:#64748b">{{ $msg->email }}</small>
                </td>
                <td>{{ $msg->subject ?? '-' }}</td>
                <td style="max-width:260px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                    {{ $msg->message }}
                </td>
                <td style="white-space:nowrap;color:#64748b;font-size:.85rem">
                    {{ $msg->created_at->format('d M Y') }}
                </td>
                <td>
                    @if($msg->is_read)
                        <span class="badge badge-gray">Dibaca</span>
                    @else
                        <span class="badge badge-purple">Baru</span>
                    @endif
                </td>
                <td style="display:flex;gap:.5rem;flex-wrap:wrap">
                    @unless($msg->is_read)
                        <form method="POST" action="{{ route('admin.messages.read', $msg) }}">
                            @csrf @method('PATCH')
                            <button class="btn btn-secondary" style="padding:.3rem .7rem;font-size:.8rem" title="Tandai dibaca">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                    @endunless
                    <form method="POST" action="{{ route('admin.messages.destroy', $msg) }}" onsubmit="return confirm('Hapus pesan ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger" style="padding:.3rem .7rem;font-size:.8rem">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" style="text-align:center;color:#64748b;padding:2rem">Belum ada pesan.</td></tr>
        @endforelse
        </tbody>
    </table>
    <div style="margin-top:1rem">{{ $messages->links() }}</div>
</div>
@endsection