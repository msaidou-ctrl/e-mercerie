@extends('layouts.app')

@section('content')
<!-- === TITRE PRINCIPAL === -->
<div class="page-title text-center py-4 py-md-5" style="background: #4F0341; color: #fff;">
    <div class="container">
        <h1 class="fw-bold m-0 display-6">Liste des Merceries</h1>
        <p class="mt-2 mb-0 opacity-75">Découvrez nos merceries partenaires et leurs produits</p>
    </div>
</div>

<!-- === CONTENU PRINCIPAL === -->
<div class="container-fluid px-3 px-md-4 px-lg-5 my-4 my-md-5">
    
    <!-- === BARRE DE RECHERCHE MODERNISÉE === -->
    <div class="search-wrapper mb-5">
        <div class="search-container">
            <div class="search-bar">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="search-merceries" placeholder="Rechercher une mercerie par nom, ville ou quartier..." autocomplete="off" />
                <div id="merceries-loader" class="loader hidden"></div>
            </div>
        </div>
    </div>

    <!-- === COMPTEUR DE RÉSULTATS === -->
    <div class="results-count mb-4 text-center">
        <span class="badge bg-primary rounded-pill px-3 py-2">
            <i class="fa-solid fa-store me-2"></i>
            <span id="results-count">{{ $merceries->count() }}</span> mercerie(s) trouvée(s)
        </span>
    </div>

    <!-- === LISTE DES MERCERIES === -->
    <div class="row g-4" id="merceries-list">
        @forelse($merceries as $mercerie)
            <div class="col-xl-4 col-lg-6 col-md-6 fade-in">
                <div class="mercerie-card">
                    <!-- Image de la mercerie -->
                    <div class="card-image">
                        <img src="{{ $mercerie->avatar_url ?? asset('images/default-mercerie.jpg') }}" 
                             alt="{{ $mercerie->name }}"
                             onerror="this.src='{{ asset('images/default-mercerie.jpg') }}'">
                        <div class="card-overlay">
                            <span class="card-badge">
                                <i class="fa-solid fa-store me-1"></i>Mercerie
                            </span>
                            <div class="card-actions">
                                <button class="btn-action favorite" title="Ajouter aux favoris">
                                    <i class="fa-regular fa-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Contenu de la carte -->
                    <div class="card-content">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="fa-solid fa-store me-2 text-primary"></i>{{ $mercerie->name }}
                            </h5>
                            <div class="rating">
                                <i class="fa-solid fa-star text-warning"></i>
                                <span class="rating-text">4.5</span>
                            </div>
                        </div>

                        <div class="card-info">
                            <div class="info-item">
                                <i class="fa-solid fa-location-dot text-danger"></i>
                                <div class="info-content">
                                    <strong>Adresse</strong>
                                    <span>{{ $mercerie->city ?? 'Ville non spécifiée' }}{{ $mercerie->quarter ? ' — ' . ($mercerie->quarter->name ?? $mercerie->quarter) : '' }}</span>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <i class="fa-solid fa-phone text-success"></i>
                                <div class="info-content">
                                    <strong>Téléphone</strong>
                                    <span>{{ $mercerie->phone ?? 'Non renseigné' }}</span>
                                </div>
                            </div>

                            <div class="info-item">
                                <i class="fa-solid fa-clock text-info"></i>
                                <div class="info-content">
                                    <strong>Horaires</strong>
                                    <span>Lun-Sam: 8h-18h</span>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <a href="{{ route('merceries.show', $mercerie->id) }}" class="soft-btn primary-btn">
                                <i class="fa-solid fa-box-open me-2"></i> Voir les fournitures
                            </a>
                            <button class="soft-btn secondary-btn" title="Contacter">
                                <i class="fa-solid fa-message"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state text-center py-5">
                    <i class="fa-solid fa-store-slash fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Aucune mercerie trouvée</h4>
                    <p class="text-muted mb-4">Il n'y a actuellement aucune mercerie disponible.</p>
                    <a href="{{ route('landing') }}" class="soft-btn primary-btn">
                        <i class="fa-solid fa-arrow-left me-2"></i> Retour à l'accueil
                    </a>
                </div>
            </div>
        @endforelse
    </div>

   
</div>

<!-- === STYLES AMÉLIORÉS === -->
<style>
:root {
    --primary-color: #4F0341;
    --primary-light: #7a1761;
    --secondary-color: #9333ea;
    --white: #fff;
    --gray-light: #f8f9fa;
    --gray-medium: #e9ecef;
    --gray-dark: #6b7280;
    --success: #198754;
    --warning: #ffc107;
    --danger: #dc3545;
    --info: #0dcaf0;
    --radius: 16px;
    --radius-lg: 20px;
    --shadow: 0 8px 30px rgba(0,0,0,0.08);
    --shadow-hover: 0 15px 40px rgba(0,0,0,0.12);
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* === TYPOGRAPHIE === */
.page-title h1 {
    font-size: clamp(1.75rem, 4vw, 2.5rem);
    font-weight: 800;
    letter-spacing: -0.5px;
}

.page-title p {
    font-size: clamp(0.9rem, 2vw, 1.1rem);
}

/* === BARRE DE RECHERCHE AMÉLIORÉE === */
.search-wrapper {
    display: flex;
    justify-content: center;
    margin-bottom: 2rem;
}

.search-container {
    width: 100%;
    max-width: 600px;
}

.search-bar {
    background: var(--white);
    border-radius: 50px;
    box-shadow: var(--shadow);
    display: flex;
    align-items: center;
    padding: 1rem 1.5rem;
    transition: var(--transition);
    border: 2px solid transparent;
    position: relative;
}

.search-bar:focus-within {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(79, 3, 65, 0.1);
    transform: translateY(-2px);
}

.search-bar i {
    color: var(--primary-color);
    font-size: 1.1rem;
    margin-right: 1rem;
}

.search-bar input {
    flex: 1;
    border: none;
    outline: none;
    font-size: 1rem;
    color: #2d3748;
    background: transparent;
}

.search-bar input::placeholder {
    color: var(--gray-dark);
    font-weight: 400;
}

/* === LOADER === */
.loader {
    width: 20px;
    height: 20px;
    border: 2px solid var(--gray-medium);
    border-top: 2px solid var(--primary-color);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

.hidden {
    display: none !important;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* === COMPTEUR DE RÉSULTATS === */
.results-count {
    margin-bottom: 2rem;
}

.results-count .badge {
    font-size: 0.9rem;
    font-weight: 600;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light)) !important;
    border: none;
    box-shadow: 0 4px 12px rgba(79, 3, 65, 0.2);
}

/* === CARTES MERCERIES AMÉLIORÉES === */
.mercerie-card {
    background: var(--white);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow);
    overflow: hidden;
    transition: var(--transition);
    border: 1px solid rgba(0,0,0,0.05);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.mercerie-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-hover);
}

/* Image de la carte */
.card-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: var(--transition);
}

.mercerie-card:hover .card-image img {
    transform: scale(1.08);
}

.card-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, transparent 60%, rgba(0,0,0,0.3));
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 1rem;
}

.card-badge {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    color: var(--white);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}

.card-actions {
    display: flex;
    gap: 0.5rem;
}

.btn-action {
    background: rgba(255, 255, 255, 0.9);
    border: none;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition);
    backdrop-filter: blur(10px);
}

.btn-action:hover {
    background: var(--white);
    transform: scale(1.1);
}

.btn-action.favorite:hover {
    color: var(--danger);
}

/* Contenu de la carte */
.card-content {
    padding: 1.5rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.card-title {
    font-weight: 700;
    font-size: 1.2rem;
    color: var(--primary-color);
    margin: 0;
    line-height: 1.3;
}

.rating {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    background: var(--gray-light);
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
}

.rating-text {
    color: var(--gray-dark);
}

/* Informations de la carte */
.card-info {
    margin-bottom: 1.5rem;
    flex-grow: 1;
}

.info-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
}

.info-item:last-child {
    margin-bottom: 0;
}

.info-item i {
    margin-top: 0.125rem;
    font-size: 0.9rem;
    width: 16px;
    text-align: center;
}

.info-content {
    flex: 1;
}

.info-content strong {
    display: block;
    font-size: 0.8rem;
    color: var(--gray-dark);
    margin-bottom: 0.125rem;
}

.info-content span {
    font-size: 0.9rem;
    color: #2d3748;
    line-height: 1.3;
}

/* Pied de carte */
.card-footer {
    display: flex;
    gap: 0.75rem;
    align-items: center;
}

.card-footer .primary-btn {
    flex: 1;
}

.card-footer .secondary-btn {
    width: 44px;
    height: 44px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* === BOUTONS === */
.soft-btn {
    border: none;
    border-radius: 12px;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    cursor: pointer;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    text-decoration: none;
    text-align: center;
    white-space: nowrap;
    font-size: 0.9rem;
    position: relative;
    overflow: hidden;
}

.soft-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.soft-btn:hover::before {
    left: 100%;
}

.primary-btn {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    color: var(--white);
    box-shadow: 0 4px 12px rgba(79, 3, 65, 0.25);
}

.primary-btn:hover {
    background: linear-gradient(135deg, var(--primary-light), var(--secondary-color));
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(147, 51, 234, 0.3);
    color: var(--white);
}

.secondary-btn {
    background: var(--gray-light);
    color: var(--gray-dark);
    border: 2px solid var(--gray-medium);
}

.secondary-btn:hover {
    background: var(--gray-medium);
    color: #2d3748;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

/* === ÉTAT VIDE === */
.empty-state {
    background: var(--white);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow);
    padding: 3rem 2rem;
}

.empty-state i {
    opacity: 0.5;
}

/* === PAGINATION === */
.pagination-container {
    display: flex;
    justify-content: center;
}

.pagination {
    gap: 0.5rem;
}

.pagination .page-link {
    border-radius: 12px;
    border: 2px solid var(--gray-medium);
    color: var(--primary-color);
    font-weight: 600;
    padding: 0.75rem 1rem;
    transition: var(--transition);
}

.pagination .page-link:hover {
    background: var(--primary-color);
    color: var(--white);
    border-color: var(--primary-color);
    transform: translateY(-2px);
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    border-color: var(--primary-color);
    color: var(--white);
}

/* === ANIMATIONS === */
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

.fade-in {
    animation: fadeInUp 0.6s ease forwards;
}

/* === RESPONSIVE === */
@media (max-width: 768px) {
    .container-fluid {
        padding: 0 1rem;
    }
    
    .search-bar {
        padding: 0.875rem 1.25rem;
    }
    
    .card-header {
        flex-direction: column;
        gap: 0.5rem;
        align-items: flex-start;
    }
    
    .rating {
        align-self: flex-start;
    }
    
    .card-footer {
        flex-direction: column;
    }
    
    .card-footer .secondary-btn {
        width: 100%;
        height: auto;
        padding: 0.75rem 1.5rem;
    }
}

@media (max-width: 576px) {
    .page-title {
        padding: 2rem 1rem !important;
    }
    
    .card-content {
        padding: 1.25rem;
    }
    
    .card-image {
        height: 160px;
    }
    
    .soft-btn {
        padding: 0.875rem 1.25rem;
        font-size: 0.9rem;
    }
}

/* === ACCESSIBILITÉ === */
@media (prefers-reduced-motion: reduce) {
    .mercerie-card,
    .soft-btn,
    .search-bar,
    .pagination .page-link {
        transition: none;
        animation: none;
    }
    
    .soft-btn::before {
        display: none;
    }
}

.soft-btn:focus-visible,
.search-bar:focus-within {
    outline: 2px solid var(--primary-color);
    outline-offset: 2px;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-merceries');
    const merceriesList = document.getElementById('merceries-list');
    const resultsCount = document.getElementById('results-count');
    const loader = document.getElementById('merceries-loader');
    let timer = null;

    searchInput.addEventListener('input', function () {
        clearTimeout(timer);
        timer = setTimeout(() => {
            const query = searchInput.value.trim();
            
            if (query.length === 0) {
                window.location.reload();
                return;
            }

            loader.classList.remove('hidden');

            fetch(`{{ route('api.merceries.search') }}?search=${encodeURIComponent(query)}`, { 
                credentials: 'same-origin', 
                headers: { 
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                } 
            })
            .then(r => {
                if (!r.ok) throw new Error(`HTTP ${r.status}`);
                return r.json();
            })
            .then(merceries => {
                renderMerceries(merceries);
                updateResultsCount(merceries.length);
            })
            .catch(error => {
                console.error('Search error:', error);
                merceriesList.innerHTML = `
                    <div class="col-12">
                        <div class="alert alert-danger text-center">
                            <i class="fa-solid fa-triangle-exclamation me-2"></i>
                            Erreur lors de la recherche. Veuillez réessayer.
                        </div>
                    </div>`;
                updateResultsCount(0);
            })
            .finally(() => {
                loader.classList.add('hidden');
            });
        }, 350);
    });

    function renderMerceries(merceries) {
        if (merceries.length === 0) {
            merceriesList.innerHTML = `
                <div class="col-12">
                    <div class="empty-state text-center py-5">
                        <i class="fa-solid fa-search fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Aucune mercerie trouvée</h4>
                        <p class="text-muted mb-4">Aucun résultat ne correspond à votre recherche.</p>
                        <button onclick="window.location.reload()" class="soft-btn secondary-btn">
                            <i class="fa-solid fa-rotate-left me-2"></i> Réinitialiser
                        </button>
                    </div>
                </div>`;
            return;
        }

        merceriesList.innerHTML = merceries.map(mercerie => `
            <div class="col-xl-4 col-lg-6 col-md-6 fade-in">
                <div class="mercerie-card">
                    <div class="card-image">
                        <img src="${mercerie.avatar_url || '{{ asset('images/default-mercerie.jpg') }}'}" 
                             alt="${mercerie.name}"
                             onerror="this.src='{{ asset('images/default-mercerie.jpg') }}'">
                        <div class="card-overlay">
                            <span class="card-badge">
                                <i class="fa-solid fa-store me-1"></i>Mercerie
                            </span>
                            <div class="card-actions">
                                <button class="btn-action favorite" title="Ajouter aux favoris">
                                    <i class="fa-regular fa-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="fa-solid fa-store me-2 text-primary"></i>${mercerie.name}
                            </h5>
                            <div class="rating">
                                <i class="fa-solid fa-star text-warning"></i>
                                <span class="rating-text">4.5</span>
                            </div>
                        </div>
                        <div class="card-info">
                            <div class="info-item">
                                <i class="fa-solid fa-location-dot text-danger"></i>
                                <div class="info-content">
                                    <strong>Adresse</strong>
                                    <span>${mercerie.city || 'Ville non spécifiée'}${mercerie.quarter ? ' — ' + mercerie.quarter : ''}</span>
                                </div>
                            </div>
                            <div class="info-item">
                                <i class="fa-solid fa-phone text-success"></i>
                                <div class="info-content">
                                    <strong>Téléphone</strong>
                                    <span>${mercerie.phone || 'Non renseigné'}</span>
                                </div>
                            </div>
                            <div class="info-item">
                                <i class="fa-solid fa-clock text-info"></i>
                                <div class="info-content">
                                    <strong>Horaires</strong>
                                    <span>Lun-Sam: 8h-18h</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="/couturier/merceries/${mercerie.id}" class="soft-btn primary-btn">
                                <i class="fa-solid fa-box-open me-2"></i> Voir les fournitures
                            </a>
                            <button class="soft-btn secondary-btn" title="Contacter">
                                <i class="fa-solid fa-message"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
    }

    function updateResultsCount(count) {
        if (resultsCount) {
            resultsCount.textContent = count;
        }
    }

    // Gestion des favoris
    document.addEventListener('click', function(e) {
        if (e.target.closest('.favorite')) {
            const btn = e.target.closest('.favorite');
            const icon = btn.querySelector('i');
            
            if (icon.classList.contains('fa-regular')) {
                icon.classList.replace('fa-regular', 'fa-solid');
                icon.style.color = 'var(--danger)';
                // Ici vous pouvez ajouter une requête AJAX pour sauvegarder le favori
            } else {
                icon.classList.replace('fa-solid', 'fa-regular');
                icon.style.color = '';
                // Ici vous pouvez ajouter une requête AJAX pour supprimer le favori
            }
        }
    });
});
</script>
@endpush
@endsection