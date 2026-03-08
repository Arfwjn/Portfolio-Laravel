@extends('layouts.admin')
@section('title', 'Edit Profil')

@section('content')
<div style="max-width:760px">
<form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div class="card" style="margin-bottom:1.25rem">
        <h3 style="margin-bottom:1.5rem">Informasi Dasar</h3>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
            <div class="form-group">
                <label>Nama Lengkap *</label>
                <input type="text" name="full_name" value="{{ old('full_name', $profile->full_name ?? '') }}" required>
            </div>
            <div class="form-group">
                <label>Jabatan / Title *</label>
                <input type="text" name="title" value="{{ old('title', $profile->title ?? '') }}" required>
            </div>
        </div>

        <div class="form-group">
            <label>Subtitle</label>
            <input type="text" name="subtitle" value="{{ old('subtitle', $profile->subtitle ?? '') }}">
        </div>

        <div class="form-group">
            <label>Bio *</label>
            <textarea name="bio" style="height:120px">{{ old('bio', $profile->bio ?? '') }}</textarea>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
            <div class="form-group">
                <label>Lokasi</label>
                <input type="text" name="location" value="{{ old('location', $profile->location ?? '') }}">
            </div>
            <div class="form-group">
                <label>Pengalaman (contoh: 3 tahun)</label>
                <input type="text" name="experience_years" value="{{ old('experience_years', $profile->experience_years ?? '') }}">
            </div>
        </div>

        <div class="form-group">
            <label>Pendidikan</label>
            <input type="text" name="education" value="{{ old('education', $profile->education ?? '') }}">
        </div>

        <div class="form-group">
            <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer">
                <input type="checkbox" name="is_open_to_work" value="1"
                    {{ old('is_open_to_work', $profile->is_open_to_work ?? false) ? 'checked' : '' }}>
                Tandai sebagai "Open to Work"
            </label>
        </div>
    </div>

    <div class="card" style="margin-bottom:1.25rem">
        <h3 style="margin-bottom:1.5rem">Kontak & Media Sosial</h3>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
            <div class="form-group">
                <label>Email Kontak</label>
                <input type="email" name="email" value="{{ old('email', $profile->email ?? '') }}">
            </div>
            <div class="form-group">
                <label>Nomor Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', $profile->phone ?? '') }}">
            </div>
            <div class="form-group">
                <label>GitHub URL</label>
                <input type="url" name="github_url" value="{{ old('github_url', $profile->github_url ?? '') }}">
            </div>
            <div class="form-group">
                <label>LinkedIn URL</label>
                <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $profile->linkedin_url ?? '') }}">
            </div>
            <div class="form-group">
                <label>Twitter URL</label>
                <input type="url" name="twitter_url" value="{{ old('twitter_url', $profile->twitter_url ?? '') }}">
            </div>
            <div class="form-group">
                <label>Resume / CV URL</label>
                <input type="url" name="resume_url" value="{{ old('resume_url', $profile->resume_url ?? '') }}">
            </div>
        </div>
    </div>

    <div class="card" style="margin-bottom:1.25rem">
        <h3 style="margin-bottom:1.5rem">Foto</h3>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
            <div class="form-group">
                <label>Foto Profil (Avatar)</label>
                <input type="file" name="avatar" accept="image/*">
                @if(isset($profile) && $profile->avatar_url)
                    <img src="{{ $profile->avatar_url }}" style="width:80px;height:80px;border-radius:50%;object-fit:cover;margin-top:.5rem">
                @endif
            </div>
            <div class="form-group">
                <label>Hero Image</label>
                <input type="file" name="hero_image" accept="image/*">
                @if(isset($profile) && $profile->hero_image_url)
                    <img src="{{ $profile->hero_image_url }}" style="width:120px;border-radius:6px;margin-top:.5rem">
                @endif
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> Simpan Profil
    </button>
</form>
</div>
@endsection