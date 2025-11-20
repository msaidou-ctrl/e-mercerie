@extends('layouts.app')

@section('title', 'Mon profil - Mercerie')

@section('content')
<style>
    /* ===== VARIABLES GLOBALES ===== */
    :root {
        --primary-color: #4F0341;
        --primary-light: #7a1761;
        --secondary-color: #9333ea;
        --accent-color: #FF6B95;
        --white: #fff;
        --gray-50: #f8fafc;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-300: #cbd5e1;
        --gray-400: #94a3b8;
        --gray-500: #64748b;
        --gray-600: #475569;
        --gray-700: #334155;
        --gray-800: #1e293b;
        --gray-900: #0f172a;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --radius-sm: 8px;
        --radius-md: 12px;
        --radius-lg: 16px;
        --radius-xl: 20px;
        --shadow-sm: 0 2px 8px rgba(0,0,0,0.04);
        --shadow-md: 0 8px 25px rgba(0,0,0,0.08);
        --shadow-lg: 0 15px 40px rgba(0,0,0,0.12);
        --shadow-xl: 0 20px 50px rgba(0,0,0,0.15);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --transition-fast: all 0.2s ease;
    }

    /* ===== STRUCTURE PRINCIPALE ===== */
    .container {
        max-width: 1200px;
    }

    /* ===== CARTE PRINCIPALE ===== */
    .profile-card {
        background: var(--white);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
        overflow: hidden;
        transition: var(--transition);
    }

    .profile-card:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-2px);
    }

    .card-header {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: var(--white);
        padding: 2.5rem 2rem;
        text-align: center;
        border-bottom: none;
        position: relative;
        overflow: hidden;
    }

    .card-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        animation: float 20s infinite linear;
    }

    @keyframes float {
        0% { transform: translateY(0) rotate(0deg); }
        100% { transform: translateY(-100px) rotate(360deg); }
    }

    .card-header h4 {
        font-size: clamp(1.5rem, 3vw, 1.75rem);
        font-weight: 800;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 2;
        text-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    .card-header p {
        font-size: 1rem;
        opacity: 0.9;
        margin: 0;
        position: relative;
        z-index: 2;
        font-weight: 400;
    }

    .card-body {
        padding: 2.5rem;
    }

    /* ===== AVATAR ===== */
    .avatar-section {
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .avatar-container {
        position: relative;
        display: inline-block;
    }

    .avatar-img {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--white);
        box-shadow: var(--shadow-lg);
        transition: var(--transition);
    }

    .avatar-container:hover .avatar-img {
        transform: scale(1.05);
        box-shadow: var(--shadow-xl);
    }

    .avatar-upload-label {
        position: absolute;
        bottom: 8px;
        right: 8px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: var(--white);
        border-radius: 50%;
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition);
        border: 3px solid var(--white);
        box-shadow: var(--shadow-md);
    }

    .avatar-upload-label:hover {
        transform: scale(1.1);
        box-shadow: var(--shadow-lg);
    }

    .avatar-upload-label i {
        font-size: 1.1rem;
    }

    /* ===== FORMULAIRES ===== */
    .form-label {
        font-weight: 600;
        color: var(--gray-800);
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .form-control, .form-select {
        padding: 0.875rem 1rem;
        border: 2px solid var(--gray-300);
        border-radius: var(--radius-lg);
        font-size: 1rem;
        transition: var(--transition);
        background: var(--white);
        color: var(--gray-800);
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(79, 3, 65, 0.1);
        outline: none;
        background: var(--white);
    }

    .form-control::placeholder {
        color: var(--gray-400);
    }

    .form-text {
        font-size: 0.875rem;
        color: var(--gray-500);
        margin-top: 0.25rem;
    }

    /* ===== BOUTONS ===== */
    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: var(--white);
        border: none;
        border-radius: var(--radius-lg);
        padding: 1rem 2.5rem;
        font-weight: 600;
        font-size: 1rem;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 15px rgba(79, 3, 65, 0.3);
        position: relative;
        overflow: hidden;
    }

    .btn-primary-custom::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .btn-primary-custom:hover::before {
        left: 100%;
    }

    .btn-primary-custom:hover {
        background: linear-gradient(135deg, var(--primary-light), var(--secondary-color));
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(147, 51, 234, 0.4);
        color: var(--white);
    }

    /* ===== ALERTES ===== */
    .alert {
        border-radius: var(--radius-lg);
        border: none;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
    }

    .alert-success {
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        color: #166534;
        border-left: 4px solid var(--success-color);
    }

    .alert-dismissible .btn-close {
        padding: 0.75rem;
    }

    /* ===== CHARGEMENT QUARTIERS ===== */
    .loading-spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 2px solid var(--gray-300);
        border-top: 2px solid var(--primary-color);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-right: 0.5rem;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* ===== RESPONSIVITÉ AVANCÉE ===== */
    @media (max-width: 1200px) {
        .container {
            max-width: 95%;
        }
    }

    @media (max-width: 992px) {
        .card-header {
            padding: 2rem 1.5rem;
        }

        .card-body {
            padding: 2rem;
        }

        .avatar-img {
            width: 120px;
            height: 120px;
        }

        .avatar-upload-label {
            width: 40px;
            height: 40px;
            bottom: 6px;
            right: 6px;
        }
    }

    @media (max-width: 768px) {
        .container {
            padding: 1rem;
        }

        .card-header {
            padding: 1.5rem 1rem;
            border-radius: var(--radius-lg) var(--radius-lg) 0 0;
        }

        .card-body {
            padding: 1.5rem;
        }

        .profile-card:hover {
            transform: none;
        }

        .avatar-img {
            width: 100px;
            height: 100px;
        }

        .avatar-upload-label {
            width: 36px;
            height: 36px;
            bottom: 4px;
            right: 4px;
        }

        .avatar-upload-label i {
            font-size: 1rem;
        }

        .form-control, .form-select {
            padding: 0.75rem 0.875rem;
            font-size: 16px; /* Prevent zoom on iOS */
        }

        .btn-primary-custom {
            width: 100%;
            justify-content: center;
            padding: 0.875rem 2rem;
        }

        .text-end {
            text-align: center !important;
        }
    }

    @media (max-width: 576px) {
        .card-header {
            padding: 1.25rem 0.75rem;
        }

        .card-body {
            padding: 1.25rem;
        }

        .avatar-img {
            width: 80px;
            height: 80px;
        }

        .avatar-upload-label {
            width: 32px;
            height: 32px;
            bottom: 2px;
            right: 2px;
        }

        .avatar-upload-label i {
            font-size: 0.9rem;
        }

        .form-control, .form-select {
            padding: 0.75rem;
            border-radius: var(--radius-md);
        }

        .btn-primary-custom {
            padding: 0.75rem 1.5rem;
            font-size: 0.9rem;
        }

        .row {
            margin: 0 -0.5rem;
        }

        .row > * {
            padding: 0 0.5rem;
        }
    }

    @media (max-width: 400px) {
        .container {
            padding: 0.5rem;
        }

        .card-header h4 {
            font-size: 1.25rem;
        }

        .card-header p {
            font-size: 0.9rem;
        }

        .avatar-section {
            margin-bottom: 2rem;
        }
    }

    /* ===== ANIMATIONS ===== */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .profile-card {
        animation: fadeInUp 0.6s ease-out;
    }

    /* ===== ACCESSIBILITÉ ===== */
    @media (prefers-reduced-motion: reduce) {
        .profile-card,
        .btn-primary-custom,
        .avatar-img,
        .avatar-upload-label,
        .form-control,
        .form-select {
            transition: none;
            animation: none;
        }

        .profile-card:hover {
            transform: none;
        }

        .card-header::before {
            animation: none;
        }

        .btn-primary-custom::before {
            display: none;
        }
    }

    .form-control:focus-visible,
    .form-select:focus-visible,
    .btn-primary-custom:focus-visible {
        outline: 2px solid var(--primary-color);
        outline-offset: 2px;
    }

    /* ===== ÉTATS DE VALIDATION ===== */
    .is-invalid {
        border-color: var(--danger-color) !important;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
    }

    .invalid-feedback {
        display: block;
        color: var(--danger-color);
        font-size: 0.875rem;
        margin-top: 0.25rem;
        font-weight: 500;
    }

    /* ===== AMÉLIORATIONS VISUELLES ===== */
    .form-section {
        margin-bottom: 2rem;
    }

    .form-section:last-of-type {
        margin-bottom: 0;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--gray-800);
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--gray-200);
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-xxl-8 col-xl-10 col-lg-12">
            <div class="profile-card">
                <!-- En-tête de la carte -->
                <div class="card-header">
                    <h1>Mon profil mercerie</h1>
                    <p>Mettez à jour vos informations personnelles</p>
                </div>

                <!-- Corps de la carte -->
                <div class="card-body">
                    <!-- Message de succès -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-check-circle me-2"></i>
                                <div>{{ session('success') }}</div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                        </div>
                    @endif

                    <form action="{{ route('merceries.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Section Avatar -->
                        <div class="form-section avatar-section">
                            <div class="avatar-container">
                                @php
                                    $avatarTimestamp = null;
                                    if (!empty($mercerie->avatar) && file_exists(storage_path('app/public/' . $mercerie->avatar))) {
                                        $avatarTimestamp = filemtime(storage_path('app/public/' . $mercerie->avatar));
                                    }
                                @endphp
                                <img id="avatarPreview" 
                                     src="{{ $mercerie->avatar ? asset('storage/' . $mercerie->avatar) . ($avatarTimestamp ? '?v=' . $avatarTimestamp : '') : asset('images/defaults/mercerie-avatar.png') }}"
                                     alt="Avatar de la mercerie"
                                     class="avatar-img">
                                
                                <label for="avatar" class="avatar-upload-label" title="Changer l'avatar">
                                    <i class="fa-solid fa-camera"></i>
                                    <input type="file" name="avatar" id="avatar" class="d-none" accept="image/*">
                                </label>
                            </div>
                            @error('avatar')
                                <p class="text-danger small mt-2 text-center">
                                    <i class="fa-solid fa-exclamation-triangle me-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Section Localisation -->
                        <div class="form-section">
                            <!-- <h5 class="section-title">
                                <i class="fa-solid fa-store me-2 text-primary"></i>
                                Informations de la mercerie
                            </h5> -->
                            <div class="mb-3">
                                <label for="business_name" class="form-label">Appellation exacte de la mercerie *</label>
                                <input id="business_name" name="business_name" type="text" required
                                       value="{{ old('business_name', $mercerie->business_name) }}"
                                       class="form-control @error('business_name') is-invalid @enderror">
                                @error('business_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- <h5 class="section-title">
                                <i class="fa-solid fa-location-dot me-2 text-primary"></i>
                                Localisation
                            </h5> -->
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="city_id" class="form-label">
                                        <i class="fa-solid fa-city me-1 text-muted"></i>
                                        Ville*
                                    </label>
                                    <select id="city_id" name="city_id" class="form-select @error('city_id') is-invalid @enderror" required>
                                        <option value="">Sélectionnez une ville...</option>
                                        @foreach(\App\Models\City::orderBy('name')->get() as $city)
                                            <option value="{{ $city->id }}" {{ (old('city_id', $mercerie->city_id ?? '') == $city->id) ? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('city_id')
                                        <div class="invalid-feedback">
                                            <i class="fa-solid fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="quarter_id" class="form-label">
                                        <i class="fa-solid fa-map-marker-alt me-1 text-muted"></i>
                                        Quartier*
                                    </label>
                                    <select id="quarter_id" name="quarter_id" class="form-select @error('quarter_id') is-invalid @enderror" required>
                                        <option value="">Sélectionnez d'abord une ville</option>
                                    </select>
                                    @error('quarter_id')
                                        <div class="invalid-feedback">
                                            <i class="fa-solid fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section Contact -->
                        <div class="form-section">
                            <!-- <h5 class="section-title">
                                <i class="fa-solid fa-address-book me-2 text-primary"></i>
                                Informations de contact
                            </h5> -->
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="phone" class="form-label">
                                        <i class="fa-solid fa-phone me-1 text-muted"></i>
                                        Numéro de téléphone*
                                    </label>
                                    <input type="text" id="phone" name="phone" 
                                           class="form-control @error('phone') is-invalid @enderror"
                                           value="{{ old('phone', $mercerie->phone ?? '') }}" 
                                           placeholder="Ex: +229 90 00 00 00" required>
                                    @error('phone')
                                        <div class="invalid-feedback">
                                            <i class="fa-solid fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="address" class="form-label">
                                        <i class="fa-solid fa-location-arrow me-1 text-muted"></i>
                                        Adresse complète
                                    </label>
                                    <textarea id="address" name="address"
                                              class="form-control @error('address') is-invalid @enderror"
                                              rows="3" 
                                              placeholder="Entrez votre adresse complète (rue, numéro, repères, etc.)" 
                                              >{{ old('address', $mercerie->address ?? '') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">
                                            <i class="fa-solid fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Bouton de soumission -->
                        <div class="text-end mt-4">
                            <button type="submit" class="btn-primary-custom">
                                <i class="fa-solid fa-floppy-disk me-2"></i>
                                Mettre à jour le profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts JavaScript -->
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Gestion de l'avatar
    const avatarInput = document.getElementById('avatar');
    const avatarPreview = document.getElementById('avatarPreview');

    if (avatarInput && avatarPreview) {
        avatarInput.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;
            
            // Validation basique du type de fichier
            if (!file.type.startsWith('image/')) {
                alert('Veuillez sélectionner une image valide.');
                return;
            }

            const reader = new FileReader();
            reader.onload = function (ev) {
                avatarPreview.src = ev.target.result;
            };
            reader.readAsDataURL(file);
        });
    }

    // Gestion des villes et quartiers
    const citySelect = document.getElementById('city_id');
    const quarterSelect = document.getElementById('quarter_id');
    const selectedQuarterId = '{{ old('quarter_id', $mercerie->quarter_id ?? '') }}';

    if (!citySelect || !quarterSelect) {
        console.warn('city_id or quarter_id select not found');
        return;
    }

    function loadQuarters(cityId, preselectId = null) {
        quarterSelect.disabled = true;
        quarterSelect.innerHTML = '<option><span class="loading-spinner"></span> Chargement des quartiers...</option>';

        if (!cityId) {
            quarterSelect.disabled = false;
            quarterSelect.innerHTML = '<option value="">Sélectionnez d\'abord une ville</option>';
            return;
        }

        try {
            // Use preloaded CITY_QUARTERS injected into the page
            const all = window.CITY_QUARTERS || {};
            const data = Array.isArray(all[cityId]) ? all[cityId] : [];

            if (!Array.isArray(data) || data.length === 0) {
                quarterSelect.innerHTML = '<option value="">Aucun quartier disponible</option>';
                quarterSelect.disabled = false;
                return;
            }

            quarterSelect.innerHTML = '<option value="">Sélectionnez un quartier...</option>';
            data.forEach(quarter => {
                const option = document.createElement('option');
                option.value = quarter.id;
                option.textContent = quarter.name;
                if (preselectId && String(preselectId) === String(quarter.id)) {
                    option.selected = true;
                }
                quarterSelect.appendChild(option);
            });

            quarterSelect.disabled = false;
        } catch (error) {
            console.error('Erreur lors du chargement des quartiers:', error);
            quarterSelect.innerHTML = '<option value="">Erreur de chargement</option>';
            quarterSelect.disabled = false;
        }
    }

    // Événement de changement de ville
    citySelect.addEventListener('change', function () {
        const selectedCityId = this.value;
        quarterSelect.innerHTML = '';
        loadQuarters(selectedCityId);
    });

    // Chargement initial si une ville est déjà sélectionnée
    if (citySelect.value) {
        // Use preloaded data only when available; otherwise keep server-rendered options
        try {
            if (window && window.CITY_QUARTERS && window.CITY_QUARTERS[citySelect.value]) {
                loadQuarters(citySelect.value, selectedQuarterId);
            } else {
                // Ensure the select is enabled so existing server-rendered options remain usable
                quarterSelect.disabled = false;
            }
        } catch (e) {
            quarterSelect.disabled = false;
        }
    }

    // Amélioration de l'UX sur mobile
    function handleMobileUX() {
        if (window.innerWidth <= 768) {
            document.querySelectorAll('.form-control, .form-select').forEach(element => {
                element.style.fontSize = '16px'; // Prevent zoom on iOS
            });
        }
    }

    handleMobileUX();
    window.addEventListener('resize', handleMobileUX);
});
</script>
@endpush

@endsection