@extends('layouts.admin')
@section('title', isset($project) ? 'Edit Proyek' : 'Tambah Proyek')

@section('content')
<div style="max-width:720px">
    <form method="POST"
          action="{{ isset($project) ? route('admin.projects.update', $project) : route('admin.projects.store') }}"
          enctype="multipart/form-data">
        @csrf
        @if(isset($project)) @method('PUT') @endif

        <div class="card">
            <h3 style="margin-bottom:1.5rem">{{ isset($project) ? 'Edit' : 'Tambah' }} Proyek</h3>

            <div class="form-group">
                <label>Judul *</label>
                <input type="text" name="title" value="{{ old('title', $project->title ?? '') }}" required>
            </div>

            <div class="form-group">
                <label>Deskripsi *</label>
                <textarea name="description" style="height:100px">{{ old('description', $project->description ?? '') }}</textarea>
            </div>

            <div class="form-group">
                <label>Tech Stack (pisahkan dengan koma)</label>
                <input type="text" name="tech_stack_input" id="tech_stack_input"
                    value="{{ old('tech_stack_input', is_array($project->tech_stack ?? null) ? implode(', ', $project->tech_stack) : '') }}"
                    placeholder="Laravel, Vue.js, MySQL">
                <input type="hidden" name="tech_stack" id="tech_stack_hidden">
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                <div class="form-group">
                    <label>Demo URL</label>
                    <input type="url" name="demo_url" value="{{ old('demo_url', $project->demo_url ?? '') }}">
                </div>
                <div class="form-group">
                    <label>GitHub URL</label>
                    <input type="url" name="github_url" value="{{ old('github_url', $project->github_url ?? '') }}">
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                <div class="form-group">
                    <label>Kategori</label>
                    <input type="text" name="category" value="{{ old('category', $project->category ?? '') }}" placeholder="Web, Mobile, dll">
                </div>
                <div class="form-group">
                    <label>Tanggal Selesai</label>
                    <input type="date" name="built_at" value="{{ old('built_at', isset($project->built_at) ? $project->built_at->format('Y-m-d') : '') }}">
                </div>
            </div>

            <div class="form-group">
                <label>Thumbnail</label>
                <input type="file" name="thumbnail" accept="image/*">
                @if(isset($project) && $project->thumbnail_url)
                    <img src="{{ $project->thumbnail_url }}" style="width:120px;border-radius:6px;margin-top:.5rem">
                @endif
            </div>

            <div style="display:flex;gap:2rem;margin-bottom:1.25rem">
                <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer">
                    <input type="checkbox" name="is_published" value="1"
                        {{ old('is_published', $project->is_published ?? false) ? 'checked' : '' }}>
                    Publikasikan
                </label>
                <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer">
                    <input type="checkbox" name="is_featured" value="1"
                        {{ old('is_featured', $project->is_featured ?? false) ? 'checked' : '' }}>
                    Featured
                </label>
            </div>

            <div style="display:flex;gap:1rem;align-items:center">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.projects') }}" class="btn btn-secondary">Batal</a>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.querySelector('form').addEventListener('submit', function() {
        const raw = document.getElementById('tech_stack_input').value;
        const arr = raw.split(',').map(s => s.trim()).filter(Boolean);
        document.getElementById('tech_stack_hidden').value = JSON.stringify(arr);
    });
</script>
@endpush