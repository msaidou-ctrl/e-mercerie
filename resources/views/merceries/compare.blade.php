@extends('layouts.app')

@section('content')
<div class="compare-container">
    <div class="card-header mb-5">
        <h1>Comparaison des merceries</h1>
        <p>Trouvez la meilleure mercerie pour vos besoins</p>
    </div>

    @if(isset($selectedCity) || isset($selectedQuarter))
        <div class="filter-indicator">
            <div class="filter-tags">
                @if($selectedCity) 
                    <span class="filter-tag">
                        <i class="fas fa-city"></i> {{ $selectedCity->name }}
                    </span>
                @endif
                @if($selectedQuarter) 
                    <span class="filter-tag">
                        <i class="fas fa-map-marker-alt"></i> {{ $selectedQuarter->name }}
                    </span>
                @endif
                <a href="{{ route('supplies.selection') }}" class="clear-filters">
                    <i class="fas fa-times"></i> Effacer les filtres
                </a>
            </div>
        </div>
    @endif

    <!-- Merceries disponibles -->
    <section class="section">
        <div class="section-header">
            <div class="section-badge available-badge">
                <i class="fas fa-check-circle"></i>
                <span>Disponibles</span>
            </div>
            <h2 class="section-title">Merceries complètement disponibles</h2>
            <span class="section-count">{{ count($disponibles) }} résultat(s)</span>
        </div>
        
        <div class="cards-grid">
            @forelse($disponibles as $mercerie)
                <div class="mercerie-card available-card">
                    <div class="card-ribbon available-ribbon">
                        <i class="fas fa-check"></i> Disponible
                    </div>
                    
                    <div class="mercerie-header">
                        <div class="mercerie-info">
                            <h3 class="mercerie-name">{{ $mercerie['mercerie']['name'] }}</h3>
                            @if(isset($mercerie['mercerie']['city_name']) || isset($mercerie['mercerie']['quarter_name']))
                                <div class="mercerie-location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $mercerie['mercerie']['city_name'] ?? '' }}
                                    @if(!empty($mercerie['mercerie']['quarter_name'])) — {{ $mercerie['mercerie']['quarter_name'] }}@endif
                                </div>
                            @endif
                        </div>
                        <div class="price-tag">
                            <span class="price-amount">{{ number_format($mercerie['total_estime'], 0, ',', ' ') }} FCFA</span>
                            <span class="price-label">Total estimé</span>
                        </div>
                    </div>

                    <div class="supplies-summary">
                        <div class="summary-item">
                            <i class="fas fa-cube"></i>
                            <span>{{ count($mercerie['details']) }} article(s)</span>
                        </div>
                    </div>

                    <ul class="details-list">
                        @foreach($mercerie['details'] as $detail)
                            <li class="detail-item">
                                <div class="detail-main">
                                    <span class="supply-name">{{ $detail['supply'] }}</span>
                                    @if(!empty($detail['measure_requested']))
                                        <span class="quantity-info">
                                            <strong>{{ $detail['measure_requested'] }}m</strong>
                                            @if(!empty($detail['quantite'])) × {{ $detail['quantite'] }}@endif
                                        </span>
                                    @else
                                        <span class="quantity-info">
                                            <strong>{{ $detail['quantite'] ?? '-' }} unité(s)</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="detail-price">
                                    <span class="unit-price">{{ number_format($detail['prix_unitaire'], 0, ',', ' ') }} FCFA</span>
                                    <span class="subtotal">{{ number_format($detail['sous_total'], 0, ',', ' ') }} FCFA</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <div class="card-actions">
                        @auth
                            <form class="confirm-order-form" action="{{ route('orders.storeFromMerchant', $mercerie['mercerie']['id']) }}" method="POST">
                                @csrf
                                @foreach($mercerie['details'] as $index => $detail)
                                    <input type="hidden" name="items[{{ $index }}][merchant_supply_id]" value="{{ $detail['merchant_supply_id'] }}">
                                    @if(!empty($detail['measure_requested']))
                                        <input type="hidden" name="items[{{ $index }}][measure_requested]" value="{{ $detail['measure_requested'] }}">
                                    @else
                                        <input type="hidden" name="items[{{ $index }}][quantity]" value="{{ $detail['quantite'] }}">
                                    @endif
                                @endforeach
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-shopping-cart"></i>
                                    Commander maintenant
                                </button>
                            </form>
                        @else
                            <button type="button" class="btn btn-secondary require-login" data-return="{{ request()->fullUrl() }}">
                                <i class="fas fa-sign-in-alt"></i>
                                Se connecter pour commander
                            </button>
                        @endauth
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-store-slash"></i>
                    <h3>Aucune mercerie disponible</h3>
                    <p>Aucune mercerie ne répond à vos critères pour le moment.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Merceries partiellement disponibles -->
    <section class="section">
        <div class="section-header">
            <div class="section-badge partial-badge">
                <i class="fas fa-exclamation-circle"></i>
                <span>Partiellement</span>
            </div>
            <h2 class="section-title">Merceries partiellement disponibles</h2>
            <span class="section-count">{{ count($partiels) }} résultat(s)</span>
        </div>
        
        <div class="cards-grid">
            @forelse($partiels as $mercerie)
                <div class="mercerie-card partial-card">
                    <div class="card-ribbon partial-ribbon">
                        <i class="fas fa-exclamation"></i> Partiel
                    </div>
                    
                    <div class="mercerie-header">
                        <div class="mercerie-info">
                            <h3 class="mercerie-name">{{ $mercerie['mercerie']['name'] }}</h3>
                            @if(isset($mercerie['mercerie']['city_name']) || isset($mercerie['mercerie']['quarter_name']))
                                <div class="mercerie-location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $mercerie['mercerie']['city_name'] ?? '' }}
                                    @if(!empty($mercerie['mercerie']['quarter_name'])) — {{ $mercerie['mercerie']['quarter_name'] }}@endif
                                </div>
                            @endif
                        </div>
                        <div class="price-tag">
                            <span class="price-amount">{{ number_format($mercerie['total_estime'] ?? 0, 0, ',', ' ') }} FCFA</span>
                            <span class="price-label">Total partiel</span>
                        </div>
                    </div>

                    <div class="supplies-summary">
                        <div class="summary-item">
                            <i class="fas fa-cube"></i>
                            <span>{{ count($mercerie['details']) }} article(s) disponible(s)</span>
                        </div>
                    </div>

                    <ul class="details-list">
                        @foreach($mercerie['details'] as $detail)
                            <li class="detail-item">
                                <div class="detail-main">
                                    <span class="supply-name">{{ $detail['supply'] }}</span>
                                    @if(!empty($detail['measure_requested']))
                                        <span class="quantity-info">
                                            <strong>{{ $detail['measure_requested'] }}m</strong>
                                            @if(!empty($detail['quantite'])) × {{ $detail['quantite'] }}@endif
                                        </span>
                                    @else
                                        <span class="quantity-info">
                                            <strong>{{ $detail['quantite'] ?? '-' }} unité(s)</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="detail-price">
                                    <span class="unit-price">{{ number_format($detail['prix_unitaire'], 0, ',', ' ') }} FCFA</span>
                                    <span class="subtotal">{{ number_format($detail['sous_total'], 0, ',', ' ') }} FCFA</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    @if(!empty($mercerie['raisons']))
                        <div class="missing-items">
                            <div class="missing-header">
                                <i class="fas fa-times-circle"></i>
                                <span>Articles manquants</span>
                            </div>
                            <ul class="missing-list">
                                @foreach($mercerie['raisons'] as $r)
                                    <li>{{ $r }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card-actions">
                        @auth
                            <form class="confirm-order-form" action="{{ route('orders.storeFromMerchant', $mercerie['mercerie']['id']) }}" method="POST">
                                @csrf
                                @foreach($mercerie['details'] as $index => $detail)
                                    <input type="hidden" name="items[{{ $index }}][merchant_supply_id]" value="{{ $detail['merchant_supply_id'] }}">
                                    @if(!empty($detail['measure_requested']))
                                        <input type="hidden" name="items[{{ $index }}][measure_requested]" value="{{ $detail['measure_requested'] }}">
                                    @else
                                        <input type="hidden" name="items[{{ $index }}][quantity]" value="{{ $detail['quantite'] }}">
                                    @endif
                                @endforeach
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-cart-plus"></i>
                                    Commander les articles disponibles
                                </button>
                            </form>
                        @else
                            <button type="button" class="btn btn-secondary require-login" data-return="{{ request()->fullUrl() }}">
                                <i class="fas fa-sign-in-alt"></i>
                                Se connecter pour commander
                            </button>
                        @endauth
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-clipboard-check"></i>
                    <h3>Aucune mercerie partiellement disponible</h3>
                    <p>Toutes les merceries sont soit complètement disponibles, soit non disponibles.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Merceries non disponibles -->
    <section class="section">
        <div class="section-header">
            <div class="section-badge unavailable-badge">
                <i class="fas fa-times-circle"></i>
                <span>Non disponible</span>
            </div>
            <h2 class="section-title">Merceries non disponibles</h2>
            <span class="section-count">{{ count($non_disponibles) }} résultat(s)</span>
        </div>
        
        <div class="cards-grid">
            @forelse($non_disponibles as $mercerie)
                <div class="mercerie-card unavailable-card">
                    <div class="card-ribbon unavailable-ribbon">
                        <i class="fas fa-times"></i> Non disponible
                    </div>
                    
                    <div class="mercerie-header">
                        <div class="mercerie-info">
                            <h3 class="mercerie-name">{{ $mercerie['mercerie']['name'] }}</h3>
                            @if(isset($mercerie['mercerie']['city_name']) || isset($mercerie['mercerie']['quarter_name']))
                                <div class="mercerie-location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $mercerie['mercerie']['city_name'] ?? '' }}
                                    @if(!empty($mercerie['mercerie']['quarter_name'])) — {{ $mercerie['mercerie']['quarter_name'] }}@endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="unavailable-content">
                        <div class="unavailable-icon">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <div class="unavailable-details">
                            <h4>Articles non disponibles</h4>
                            <ul class="unavailable-list">
                                @foreach($mercerie['raisons'] as $raison)
                                    <li>
                                        <i class="fas fa-minus"></i>
                                        {{ $raison }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-check-double"></i>
                    <h3>Toutes les merceries sont disponibles</h3>
                    <p>Excellent ! Toutes les merceries peuvent satisfaire votre demande.</p>
                </div>
            @endforelse
        </div>
    </section>
</div>

<style>
:root {
    --primary-color: #4F0341;
    --primary-light: #7a1761;
    --secondary-color: #9333ea;
    --accent-color: #f3e8ff;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --error-color: #ef4444;
    --background-color: #ffffff;
    --surface-color: #f8fafc;
    --text-primary: #1f2937;
    --text-secondary: #6b7280;
    --text-muted: #9ca3af;
    --border-color: #e5e7eb;
    --border-light: #f3f4f6;
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    --radius-sm: 8px;
    --radius-md: 12px;
    --radius-lg: 16px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* --- STRUCTURE DE BASE --- */
.compare-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 1.5rem;
}

.page-header {
    text-align: center;
    margin-bottom: 2.5rem;
}

.page-title {
    font-size: 2.25rem;
    font-weight: 800;
    color: var(--primary-color);
    margin-bottom: 0.5rem;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.page-subtitle {
    font-size: 1.1rem;
    color: var(--text-secondary);
    font-weight: 500;
}

/* --- FILTRES APPLIQUÉS --- */
.filter-indicator {
    background: var(--surface-color);
    border-radius: var(--radius-md);
    padding: 1.25rem;
    margin-bottom: 2rem;
    border: 1px solid var(--border-light);
}

.filter-tags {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.filter-tag {
    background: var(--primary-color);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.clear-filters {
    color: var(--text-secondary);
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: var(--transition);
}

.clear-filters:hover {
    color: var(--error-color);
}

/* --- SECTIONS --- */
.section {
    margin-bottom: 3rem;
}

.section-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}

.section-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.available-badge {
    background: #ecfdf5;
    color: var(--success-color);
    border: 1px solid #d1fae5;
}

.partial-badge {
    background: #fffbeb;
    color: var(--warning-color);
    border: 1px solid #fef3c7;
}

.unavailable-badge {
    background: #fef2f2;
    color: var(--error-color);
    border: 1px solid #fecaca;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
}

.section-count {
    color: var(--text-muted);
    font-size: 0.875rem;
    font-weight: 500;
    margin-left: auto;
}

/* --- GRILLE DES CARTES --- */
.cards-grid {
    display: grid;
    gap: 1.5rem;
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
}

/* --- CARTES MERCERIES --- */
.mercerie-card {
    background: var(--background-color);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    padding: 1.5rem;
    transition: var(--transition);
    border: 1px solid var(--border-color);
    position: relative;
    overflow: hidden;
}

.available-card {
    border-top: 4px solid var(--success-color);
}

.available-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
    border-color: var(--success-color);
}

.partial-card {
    border-top: 4px solid var(--warning-color);
}

.partial-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
    border-color: var(--warning-color);
}

.unavailable-card {
    border-top: 4px solid var(--error-color);
    background: var(--surface-color);
}

/* --- RUBANS --- */
.card-ribbon {
    position: absolute;
    top: 1rem;
    right: -2rem;
    padding: 0.5rem 3rem;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transform: rotate(45deg);
}

.available-ribbon {
    background: var(--success-color);
    color: white;
}

.partial-ribbon {
    background: var(--warning-color);
    color: white;
}

.unavailable-ribbon {
    background: var(--error-color);
    color: white;
}

/* --- EN-TÊTE DES CARTES --- */
.mercerie-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.25rem;
    gap: 1rem;
}

.mercerie-info {
    flex: 1;
}

.mercerie-name {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    line-height: 1.3;
}

.mercerie-location {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-secondary);
    font-size: 0.875rem;
}

.price-tag {
    text-align: right;
    min-width: 100px;
}

.price-amount {
    display: block;
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--primary-color);
    line-height: 1.2;
}

.price-label {
    display: block;
    font-size: 0.75rem;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* --- RÉSUMÉ DES FOURNITURES --- */
.supplies-summary {
    background: var(--surface-color);
    border-radius: var(--radius-md);
    padding: 1rem;
    margin-bottom: 1.25rem;
}

.summary-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: var(--text-secondary);
    font-size: 0.875rem;
    font-weight: 500;
}

/* --- LISTE DES DÉTAILS --- */
.details-list {
    list-style: none;
    margin: 0 0 1.5rem 0;
    padding: 0;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.875rem 0;
    border-bottom: 1px solid var(--border-light);
    gap: 1rem;
}

.detail-item:last-child {
    border-bottom: none;
}

.detail-main {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.supply-name {
    font-weight: 600;
    color: var(--text-primary);
    font-size: 0.95rem;
}

.quantity-info {
    color: var(--text-secondary);
    font-size: 0.875rem;
}

.detail-price {
    text-align: right;
    min-width: 120px;
}

.unit-price {
    display: block;
    color: var(--text-muted);
    font-size: 0.75rem;
    margin-bottom: 0.25rem;
}

.subtotal {
    display: block;
    font-weight: 700;
    color: var(--primary-color);
    font-size: 0.95rem;
}

/* --- ARTICLES MANQUANTS --- */
.missing-items {
    background: #fef3f3;
    border: 1px solid #fecaca;
    border-radius: var(--radius-md);
    padding: 1rem;
    margin-bottom: 1.5rem;
}

.missing-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--error-color);
    font-weight: 600;
    font-size: 0.875rem;
    margin-bottom: 0.75rem;
}

.swal2-actions{
    display: flex;
    gap: 10px;
}

.missing-list {
    list-style: none;
    margin: 0;
    padding: 0;
    color: var(--text-secondary);
    font-size: 0.875rem;
}

.missing-list li {
    padding: 0.25rem 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.missing-list li:before {
    content: "•";
    color: var(--error-color);
}

/* --- CONTENU NON DISPONIBLE --- */
.unavailable-content {
    text-align: center;
    padding: 1.5rem 0;
}

.unavailable-icon {
    font-size: 3rem;
    color: var(--text-muted);
    margin-bottom: 1rem;
}

.unavailable-details h4 {
    color: var(--text-secondary);
    margin-bottom: 1rem;
    font-weight: 600;
}

.unavailable-list {
    list-style: none;
    margin: 0;
    padding: 0;
    text-align: left;
    max-width: 300px;
    margin: 0 auto;
}

.unavailable-list li {
    padding: 0.5rem 0;
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    border-bottom: 1px solid var(--border-light);
}

.unavailable-list li:last-child {
    border-bottom: none;
}

/* --- ACTIONS DES CARTES --- */
.card-actions {
    margin-top: auto;
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    width: 100%;
    padding: 1rem 1.5rem;
    border-radius: var(--radius-md);
    font-weight: 600;
    font-size: 0.95rem;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}

.btn:before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.btn:hover:before {
    width: 300px;
    height: 300px;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    box-shadow: 0 4px 12px rgba(79, 3, 65, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(79, 3, 65, 0.4);
}

.btn-secondary {
    background: var(--surface-color);
    color: var(--text-secondary);
    border: 1px solid var(--border-color);
}

.btn-secondary:hover {
    background: var(--border-light);
    transform: translateY(-1px);
}

/* --- ÉTATS VIDES --- */
.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 3rem 2rem;
    color: var(--text-muted);
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 1.5rem;
    opacity: 0.5;
}

.empty-state h3 {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    color: var(--text-secondary);
}

.empty-state p {
    font-size: 1rem;
    max-width: 400px;
    margin: 0 auto;
    line-height: 1.6;
}

/* --- RESPONSIVE DESIGN --- */
@media (max-width: 1024px) {
    .cards-grid {
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    }
}

@media (max-width: 768px) {
    .compare-container {
        padding: 1rem;
    }
    
    .page-title {
        font-size: 1.75rem;
    }
    
    .cards-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
    }
    
    .section-count {
        margin-left: 0;
    }
    
    .mercerie-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
    }
    
    .price-tag {
        text-align: left;
    }
    
    .filter-tags {
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .compare-container {
        padding: 0.75rem;
    }
    
    .mercerie-card {
        padding: 1.25rem;
    }
    
    .page-title {
        font-size: 1.5rem;
    }
    
    .section-title {
        font-size: 1.25rem;
    }
    
    .detail-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .detail-price {
        text-align: left;
        width: 100%;
        display: flex;
        justify-content: space-between;
    }
    
    .btn {
        padding: 0.875rem 1.25rem;
        font-size: 0.9rem;
    }
    
    .empty-state {
        padding: 2rem 1rem;
    }
    
    .empty-state i {
        font-size: 3rem;
    }
}

/* --- ANIMATIONS --- */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.mercerie-card {
    animation: fadeInUp 0.6s ease-out;
}

/* --- ACCESSIBILITÉ --- */
@media (prefers-reduced-motion: reduce) {
    * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}

.btn:focus-visible,
.mercerie-card:focus-visible {
    outline: 2px solid var(--primary-color);
    outline-offset: 2px;
}

/* --- SWEETALERT PERSONNALISATION --- */
.swal2-popup {
    border-radius: var(--radius-lg) !important;
}

.swal2-confirm {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
    border: none !important;
    border-radius: var(--radius-md) !important;
    padding: 0.75rem 1.5rem !important;
}

.swal2-cancel {
    background: var(--text-muted) !important;
    border: none !important;
    border-radius: var(--radius-md) !important;
    padding: 0.75rem 1.5rem !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Gestion de la connexion requise
    document.querySelectorAll('.require-login').forEach(function(btn) {
        btn.addEventListener('click', function () {
            try { 
                localStorage.setItem('post_login_return', this.dataset.return || window.location.href); 
            } catch (e) { /* ignore */ }
            window.location.href = "{{ route('login.form') }}";
        });
    });

    // Confirmation de commande avec SweetAlert
    document.querySelectorAll('.confirm-order-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Use the enclosing card as the source of truth (details list and price live outside the form)
            const card = form.closest('.mercerie-card');
            const details = card ? card.querySelectorAll('.details-list li') : form.querySelectorAll('.details-list li');
            const itemsCount = details ? details.length : 0;
            const priceSpan = card ? card.querySelector('.price-amount') : form.closest('.mercerie-card')?.querySelector('.price-amount');
            const totalText = priceSpan ? priceSpan.textContent.trim() : null;
            const mercerieNameEl = card ? card.querySelector('.mercerie-name') : null;
            const mercerieName = mercerieNameEl ? mercerieNameEl.textContent.trim() : '{{ $mercerie['mercerie']['name'] ?? '' }}';

            const html = `<div class="text-start" style="color: var(--text-primary);">
                <p style="margin-bottom: 1rem;"><strong>Vous êtes sur le point de valider une commande pour :</strong><br/><strong>${mercerieName}</strong></p>
                <div style="background: var(--surface-color); padding: 1rem; border-radius: var(--radius-md); margin-bottom: 1rem;">
                    <p style="margin: 0.5rem 0;"><strong>Articles :</strong> ${itemsCount}</p>
                    ${totalText ? `<p style="margin: 0.5rem 0;"><strong>Total estimé :</strong> ${totalText}</p>` : ''}
                </div>
                <p style="color: var(--text-secondary); font-size: 0.875rem;">Cette action enverra votre commande à la mercerie pour validation.</p>
            </div>`;

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Confirmer la commande',
                    html: html,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#4F0341',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="fas fa-check"></i> Confirmer',
                    cancelButtonText: '<i class="fas fa-times"></i> Annuler',
                    customClass: {
                        popup: 'rounded-4 shadow-lg',
                        confirmButton: 'btn primary-btn',
                        cancelButton: 'btn secondary-btn'
                    },
                    buttonsStyling: false
                }).then(result => {
                    if (result.isConfirmed) {
                        // Ajouter un indicateur de chargement
                        const submitBtn = form.querySelector('button[type="submit"]');
                        if (submitBtn) {
                            const originalHTML = submitBtn.innerHTML;
                            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Traitement...';
                            submitBtn.disabled = true;
                        }

                        setTimeout(() => {
                            form.submit();
                        }, 400);
                    }
                });
                return;
            }

            // Fallback natif
            if (confirm('Confirmer la commande ?')) {
                form.submit();
            }
        });
    });

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

    // Observer les cartes pour l'animation
    document.querySelectorAll('.mercerie-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
});
</script>
@endsection