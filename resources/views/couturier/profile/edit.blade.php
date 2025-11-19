@extends('layouts.app')

@section('title', 'Mon profil - Couturier')

@section('content')
<style>
    .profile-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }

    .card-header {
        background: linear-gradient(135deg, #4F0341, #7a1761);
        color: white;
        padding: 2rem;
        text-align: center;
        border-bottom: none;
    }

    .avatar-preview {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #fff;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .form-control, .form-select {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 12px 16px;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #4F0341;
        box-shadow: 0 0 0 3px rgba(79, 3, 65, 0.1);
    }

    .btn-primary {
        background: linear-gradient(135deg, #4F0341, #7a1761);
        border: none;
        border-radius: 12px;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(79, 3, 65, 0.3);
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="profile-card">
                <div class="card-header">
                    <h4 class="fw-bold mb-2">Mon profil couturier</h4>
                    <p class="mb-0 opacity-90">Mettez à jour vos informations personnelles</p>
                </div>

                <div class="card-body p-4">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Avatar -->
                        <div class="text-center mb-4">
                            <div class="position-relative d-inline-block">
                                @php
                                    $avatarTimestamp = null;
                                    if (!empty($user->avatar) && file_exists(storage_path('app/public/' . $user->avatar))) {
                                        $avatarTimestamp = filemtime(storage_path('app/public/' . $user->avatar));
                                    }
                                @endphp
                                <img id="avatarPreview" 
                                     src="{{ $user->avatar ? asset('storage/' . $user->avatar) . ($avatarTimestamp ? '?v=' . $avatarTimestamp : '') : asset('images/defaults/user.png') }}" 
                                     alt="Avatar" 
                                     class="avatar-preview">
                                <label for="avatar" class="btn btn-primary btn-sm position-absolute bottom-0 end-0 rounded-circle" style="width: 40px; height: 40px;">
                                    <i class="fas fa-camera"></i>
                                    <input type="file" id="avatar" name="avatar" class="d-none" accept="image/*">
                                </label>
                            </div>
                            @error('avatar')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Informations de base -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-semibold">Nom complet *</label>
                                <input type="text" id="name" name="name" 
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $user->name) }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label fw-semibold">Téléphone</label>
                                <input type="text" id="phone" name="phone" 
                                       class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone', $user->phone) }}" 
                                       placeholder="+229 90 00 00 00">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Localisation -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="city_id" class="form-label fw-semibold">Ville</label>
                                <select id="city_id" name="city_id" 
                                        class="form-select @error('city_id') is-invalid @enderror">
                                    <option value="">Sélectionnez une ville...</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" 
                                            {{ (string)old('city_id', $user->city_id) === (string)$city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('city_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="quarter_id" class="form-label fw-semibold">Quartier</label>
                                <select id="quarter_id" name="quarter_id" 
                                        class="form-select @error('quarter_id') is-invalid @enderror"
                                        {{ !$user->city_id && !old('city_id') ? 'disabled' : '' }}>
                                    <option value="">Sélectionnez un quartier...</option>
                                    @foreach($quarters as $quarter)
                                        <option value="{{ $quarter->id }}" 
                                            {{ (string)old('quarter_id', $user->quarter_id) === (string)$quarter->id ? 'selected' : '' }}>
                                            {{ $quarter->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('quarter_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Adresse -->
                        <div class="mb-4">
                            <label for="address" class="form-label fw-semibold">Adresse</label>
                            <textarea id="address" name="address" 
                                      class="form-control @error('address') is-invalid @enderror"
                                      rows="3" 
                                      placeholder="Votre adresse complète...">{{ old('address', $user->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Bouton de soumission -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-2"></i>
                                Mettre à jour le profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Gestion de l'avatar
    const avatarInput = document.getElementById('avatar');
    const avatarPreview = document.getElementById('avatarPreview');

    if (avatarInput && avatarPreview) {
        avatarInput.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    avatarPreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Gestion villes/quartiers
    const citySelect = document.getElementById('city_id');
    const quarterSelect = document.getElementById('quarter_id');

    async function loadQuarters(cityId) {
        if (!cityId) {
            quarterSelect.innerHTML = '<option value="">Sélectionnez un quartier...</option>';
            quarterSelect.disabled = true;
            return;
        }

        quarterSelect.disabled = true;
        quarterSelect.innerHTML = '<option value="">Chargement...</option>';

        try {
            const response = await fetch(`/api/cities/${cityId}/quarters`);
            const quarters = await response.json();
            
            quarterSelect.innerHTML = '<option value="">Sélectionnez un quartier...</option>';
            quarters.forEach(quarter => {
                const option = document.createElement('option');
                option.value = quarter.id;
                option.textContent = quarter.name;
                quarterSelect.appendChild(option);
            });
            
            quarterSelect.disabled = false;
            
            // Pré-sélectionner si une valeur existe
            const selectedQuarter = '{{ old('quarter_id', $user->quarter_id) }}';
            if (selectedQuarter) {
                quarterSelect.value = selectedQuarter;
            }
        } catch (error) {
            console.error('Erreur:', error);
            quarterSelect.innerHTML = '<option value="">Erreur de chargement</option>';
            quarterSelect.disabled = true;
        }
    }

    if (citySelect) {
        citySelect.addEventListener('change', function() {
            loadQuarters(this.value);
        });

        // Chargement initial si une ville est sélectionnée
        if (citySelect.value) {
            loadQuarters(citySelect.value);
        }
    }
});
</script>
@endpush

@endsection