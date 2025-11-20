@extends('layouts.app')

@section('title', 'Mon profil - Couturier')

@section('content')
<style>
:root {
    --primary-color: #4F0341;
    --primary-light: #7a1761;
    --secondary-color: #9333ea;
    --accent-color: #f3e8ff;
    --text-primary: #1f2937;
    --text-secondary: #6b7280;
    --text-muted: #9ca3af;
    --border-color: #e5e7eb;
    --border-light: #f3f4f6;
    --bg-white: #ffffff;
    --bg-light: #f8fafc;
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    --radius-sm: 8px;
    --radius-md: 12px;
    --radius-lg: 16px;
    --radius-xl: 20px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.profile-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 1rem;
}

.profile-card {
    background: var(--bg-white);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-color);
    overflow: hidden;
    transition: var(--transition);
}

.profile-card:hover {
    box-shadow: var(--shadow-lg);
}

.card-body {
    padding: 2.5rem;
}

.avatar-section {
    text-align: center;
    margin-bottom: 2.5rem;
    position: relative;
}

.avatar-container {
    position: relative;
    display: inline-block;
    margin-bottom: 1rem;
}

.avatar-preview {
    width: 140px;
    height: 140px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid var(--bg-white);
    box-shadow: var(--shadow-lg);
    transition: var(--transition);
}

.avatar-preview:hover {
    transform: scale(1.05);
}

.avatar-upload-btn {
    position: absolute;
    bottom: 8px;
    right: 8px;
    width: 44px;
    height: 44px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border: 3px solid var(--bg-white);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    cursor: pointer;
    transition: var(--transition);
    box-shadow: var(--shadow-md);
}

.avatar-upload-btn:hover {
    transform: scale(1.1);
    box-shadow: var(--shadow-lg);
}

.avatar-upload-btn i {
    font-size: 1.1rem;
}

.form-section {
    margin-bottom: 2rem;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid var(--border-light);
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.section-title::before {
    content: '';
    width: 4px;
    height: 20px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: 2px;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-label.required::after {
    content: '*';
    color: #ef4444;
    margin-left: 2px;
}

.form-control, .form-select {
    border: 2px solid var(--border-color);
    border-radius: var(--radius-md);
    padding: 0.875rem 1rem;
    font-size: 1rem;
    transition: var(--transition);
    background: var(--bg-white);
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(79, 3, 65, 0.1);
    outline: none;
}

.form-control::placeholder {
    color: var(--text-muted);
}

textarea.form-control {
    resize: vertical;
    min-height: 100px;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border: none;
    border-radius: var(--radius-md);
    padding: 1rem 2.5rem;
    font-weight: 600;
    font-size: 1rem;
    transition: var(--transition);
    box-shadow: var(--shadow-md);
    position: relative;
    overflow: hidden;
}

.btn-primary::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: var(--transition);
}

.btn-primary:hover::before {
    left: 100%;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.btn-primary:active {
    transform: translateY(0);
}

.alert {
    border-radius: var(--radius-md);
    border: none;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
}

.alert-success {
    background: #f0fdf4;
    color: #166534;
    border-left: 4px solid #22c55e;
}

.alert-danger {
    background: #fef2f2;
    color: #dc2626;
    border-left: 4px solid #ef4444;
}

.alert i {
    font-size: 1.1rem;
}

.invalid-feedback {
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .profile-container {
        padding: 0.5rem;
    }
    
    .card-body {
        padding: 2rem 1.5rem;
    }
    
    .avatar-preview {
        width: 120px;
        height: 120px;
    }
    
    .avatar-upload-btn {
        width: 40px;
        height: 40px;
        bottom: 6px;
        right: 6px;
    }
    
    .section-title {
        font-size: 1.1rem;
    }
    
    .btn-primary {
        width: 100%;
        padding: 1rem 2rem;
    }
}

@media (max-width: 576px) {
    
    .avatar-preview {
        width: 100px;
        height: 100px;
    }
    
    .form-control, .form-select {
        padding: 0.75rem 0.875rem;
        font-size: 0.95rem;
    }
    
    .btn-primary {
        padding: 0.875rem 1.5rem;
        font-size: 0.95rem;
    }
}

@media (max-width: 400px) {
    .profile-container {
        padding: 0.25rem;
    }
    
    .card-body {
        padding: 1.25rem 0.75rem;
    }
    
    .avatar-preview {
        width: 80px;
        height: 80px;
    }
    
    .avatar-upload-btn {
        width: 36px;
        height: 36px;
        bottom: 4px;
        right: 4px;
    }
    
    .avatar-upload-btn i {
        font-size: 0.9rem;
    }
}

/* Animation pour le chargement des quartiers */
.loading {
    opacity: 0.6;
    pointer-events: none;
}

/* Amélioration de l'accessibilité */
@media (prefers-reduced-motion: reduce) {
    .profile-card,
    .avatar-preview,
    .avatar-upload-btn,
    .btn-primary,
    .form-control,
    .form-select {
        transition: none;
    }
}

/* Focus visible pour l'accessibilité */
.form-control:focus-visible,
.form-select:focus-visible,
.btn-primary:focus-visible {
    outline: 2px solid var(--primary-color);
    outline-offset: 2px;
}
</style>

<div class="profile-container">
    <div class="row justify-content-center">
        <div class="col-xxl-10">
            <div class="profile-card">
                <!-- En-tête avec dégradé -->
                <div class="card-header">
                        <h1>Mon profil couturier</h1>
                        <p>Mettez à jour vos informations personnelles</p>
                    </div>
                </div>

                <!-- Corps du formulaire -->
                <div class="card-body">
                    <!-- Messages d'alerte -->
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

                        <!-- Section Avatar -->
                        <div class="avatar-section">
                            <div class="avatar-container">
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
                                <label for="avatar" class="avatar-upload-btn">
                                    <i class="fas fa-camera"></i>
                                    <input type="file" id="avatar" name="avatar" class="d-none" accept="image/*">
                                </label>
                            </div>
                            <div class="avatar-info">
                                <p class="text-muted mb-0">Cliquez sur l'icône pour changer votre photo</p>
                            </div>
                            @error('avatar')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Section Informations personnelles -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="fas fa-user-circle"></i>
                                Informations personnelles
                            </h5>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label required">
                                            <i class="fas fa-user"></i>
                                            Nom complet
                                        </label>
                                        <input type="text" id="name" name="name" 
                                               class="form-control @error('name') is-invalid @enderror"
                                               value="{{ old('name', $user->name) }}" 
                                               placeholder="Votre nom complet"
                                               required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone" class="form-label">
                                            <i class="fas fa-phone"></i>
                                            Téléphone
                                        </label>
                                        <input type="text" id="phone" name="phone" 
                                               class="form-control @error('phone') is-invalid @enderror"
                                               value="{{ old('phone', $user->phone) }}" 
                                               placeholder="+229 90 00 00 00">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section Localisation -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="fas fa-map-marker-alt"></i>
                                Localisation
                            </h5>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city_id" class="form-label">
                                            <i class="fas fa-city"></i>
                                            Ville
                                        </label>
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
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="quarter_id" class="form-label">
                                            <i class="fas fa-location-dot"></i>
                                            Quartier
                                        </label>
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
                            </div>

                            <div class="form-group">
                                <label for="address" class="form-label">
                                    <i class="fas fa-home"></i>
                                    Adresse complète
                                </label>
                                <textarea id="address" name="address" 
                                          class="form-control @error('address') is-invalid @enderror"
                                          rows="3" 
                                          placeholder="Votre adresse complète...">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Bouton de soumission -->
                        <div class="text-center text-md-end">
                            <button type="submit" class="btn btn-primary">
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
                // Validation de la taille (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('La taille de l\'image ne doit pas dépasser 5MB');
                    return;
                }
                
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
        quarterSelect.classList.add('loading');
        quarterSelect.innerHTML = '<option value="">Chargement des quartiers...</option>';

        try {
            const response = await fetch(`/api/cities/${cityId}/quarters`);
            if (!response.ok) throw new Error('Erreur réseau');
            
            const quarters = await response.json();
            
            quarterSelect.innerHTML = '<option value="">Sélectionnez un quartier...</option>';
            quarters.forEach(quarter => {
                const option = document.createElement('option');
                option.value = quarter.id;
                option.textContent = quarter.name;
                quarterSelect.appendChild(option);
            });
            
            quarterSelect.disabled = false;
            quarterSelect.classList.remove('loading');
            
            // Pré-sélectionner si une valeur existe
            const selectedQuarter = '{{ old('quarter_id', $user->quarter_id) }}';
            if (selectedQuarter) {
                quarterSelect.value = selectedQuarter;
            }
        } catch (error) {
            console.error('Erreur:', error);
            quarterSelect.innerHTML = '<option value="">Erreur de chargement</option>';
            quarterSelect.disabled = true;
            quarterSelect.classList.remove('loading');
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

    // Animation au scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observer les éléments pour l'animation
    const animatedElements = document.querySelectorAll('.profile-card, .form-section');
    animatedElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
});
</script>
@endpush

@endsection