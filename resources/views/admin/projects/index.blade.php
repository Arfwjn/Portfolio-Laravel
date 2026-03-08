@extends('layouts.admin')
@section('title', 'Proyek')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem">
    <h2 style="font-size:1.1rem;font-weight:600">Daftar Proyek</h2>
    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Proyek
    </a>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Featured</th>
                <th>Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($projects as $i => $project)
            <tr>
                <td>{{ $projects->firstItem() + $i }}</td>
                <td>
                    <strong>{{ $project->title }}</strong>
                    <br><small style="color:#64748b">{{ Str::limit($project->description, 60) }}</small>
                </td>
                <td>{{ $project->category ?? '-' }}</td>
                <td>
                    @if($project->is_published)
                        <span class="badge badge-green">Publik</span>
                    @else
                        <span class="badge badge-gray">Draft</span>
                    @endif
                </td>
                <td>
                    @if($project->is_featured)
                        <span class="badge badge-purple">⭐ Yes</span>
                    @else
                        <span style="color:#64748b">–</span>
                    @endif
                </td>
                <td>{{ $project->built_at?->format('M Y') ?? '-' }}</td>
                <td>
                    <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-secondary" style="padding:.35rem .8rem;font-size:.8rem">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" style="display:inline" onsubmit="return confirm('Hapus proyek ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger" style="padding:.35rem .8rem;font-size:.8rem">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" style="text-align:center;color:#64748b;padding:2rem">Belum ada proyek.</td></tr>
        @endforelse
        </tbody>
    </table>
    <div style="margin-top:1rem">{{ $projects->links() }}</div>
</div>
@endsection