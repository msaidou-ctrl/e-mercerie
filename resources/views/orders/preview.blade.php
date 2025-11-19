@extends('layouts.app')

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

    /* ===== TITRE PRINCIPAL ===== */
    .page-title {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: var(--white);
        padding: 3rem 1.5rem;
        text-align: center;
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-lg);
        margin-bottom: 3rem;
        position: relative;
        overflow: hidden;
    }

    .page-title::before {
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

    .page-title h1 {
        font-size: clamp(1.75rem, 4vw, 2.5rem);
        font-weight: 800;
        margin: 0;
        line-height: 1.2;
        position: relative;
        z-index: 2;
        text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        letter-spacing: -0.5px;
    }

    .mercerie-name {
        display: block;
        font-size: clamp(1rem, 2vw, 1.25rem);
        font-weight: 500;
        opacity: 0.9;
        margin-top: 0.5rem;
    }

    /* ===== CARTE PRINCIPALE ===== */
    .card-custom {
        background: var(--white);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-md);
        padding: 2.5rem;
        transition: var(--transition);
        border: 1px solid var(--gray-200);
        position: relative;
        overflow: hidden;
    }

    .card-custom::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--primary-light), var(--secondary-color));
        transform: scaleX(0);
        transition: var(--transition);
    }

    .card-custom:hover::before {
        transform: scaleX(1);
    }

    .card-custom:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-xl);
    }

    /* ===== TABLEAU ===== */
    .table-responsive {
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    .table {
        margin: 0;
        border-radius: var(--radius-lg);
        overflow: hidden;
        min-width: 600px;
    }

    .table thead {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: var(--white);
    }

    .table thead th {
        border: none;
        padding: 1.25rem 1rem;
        font-weight: 600;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: relative;
    }

    .table thead th::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 1rem;
        right: 1rem;
        height: 2px;
        background: rgba(255,255,255,0.3);
    }

    .table tbody tr {
        transition: var(--transition-fast);
        border-bottom: 1px solid var(--gray-200);
    }

    .table tbody tr:last-child {
        border-bottom: none;
    }

    .table tbody tr:hover {
        background: linear-gradient(90deg, rgba(79, 3, 65, 0.02), rgba(147, 51, 234, 0.02));
        transform: translateX(4px);
    }

    .table tbody td {
        padding: 1.25rem 1rem;
        border: none;
        font-weight: 500;
        color: var(--gray-700);
        vertical-align: middle;
    }

    .table tbody td:first-child {
        font-weight: 600;
        color: var(--gray-900);
    }

    /* ===== BADGES ET INDICATEURS ===== */
    .quantity-badge {
        background: var(--gray-100);
        color: var(--gray-700);
        padding: 0.375rem 0.75rem;
        border-radius: var(--radius-md);
        font-size: 0.875rem;
        font-weight: 600;
        border: 1px solid var(--gray-200);
    }

    .measure-badge {
        background: linear-gradient(135deg, var(--primary-light), var(--secondary-color));
        color: var(--white);
        padding: 0.375rem 0.75rem;
        border-radius: var(--radius-md);
        font-size: 0.875rem;
        font-weight: 600;
    }

    .swal2-actions{
        display: flex;
        gap: 10px;
    }

    /* ===== TOTAL ===== */
    .text-total {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 800;
        font-size: 1.5rem;
        padding: 1rem 0;
        border-top: 2px dashed var(--gray-300);
        margin-top: 2rem;
    }

    /* ===== BOUTONS ===== */
    .btn-custom {
        border: none;
        border-radius: var(--radius-lg);
        padding: 1rem 2rem;
        font-weight: 600;
        font-size: 1rem;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .btn-custom::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .btn-custom:hover::before {
        left: 100%;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: var(--white);
        box-shadow: 0 4px 15px rgba(79, 3, 65, 0.3);
    }

    .btn-primary-custom:hover {
        background: linear-gradient(135deg, var(--primary-light), var(--secondary-color));
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(147, 51, 234, 0.4);
        color: var(--white);
    }

    .btn-secondary-custom {
        background: var(--white);
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
        box-shadow: 0 2px 8px rgba(79, 3, 65, 0.1);
    }

    .btn-secondary-custom:hover {
        background: var(--primary-color);
        color: var(--white);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(79, 3, 65, 0.2);
    }

    /* ===== FORMULAIRE ===== */
    #confirmOrderForm {
        gap: 1rem;
    }

    /* ===== ÉTAT VIDE ===== */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--gray-500);
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    /* ===== RESPONSIVITÉ AVANCÉE ===== */
    @media (max-width: 1200px) {
        .container {
            max-width: 95%;
        }
    }

    @media (max-width: 992px) {
        .page-title {
            padding: 2.5rem 1.25rem;
            margin-bottom: 2.5rem;
        }

        .card-custom {
            padding: 2rem;
        }

        .table thead th,
        .table tbody td {
            padding: 1rem 0.75rem;
        }
    }

    @media (max-width: 768px) {
        .page-title {
            padding: 2rem 1rem;
            margin-bottom: 2rem;
            border-radius: var(--radius-lg);
        }

        .card-custom {
            padding: 1.5rem;
            border-radius: var(--radius-lg);
            margin: 0 -0.5rem;
        }

        .card-custom:hover {
            transform: translateY(-2px);
        }

        .table-responsive {
            border-radius: var(--radius-md);
        }

        .table {
            min-width: 500px;
        }

        .table thead th {
            padding: 0.875rem 0.5rem;
            font-size: 0.875rem;
        }

        .table tbody td {
            padding: 0.875rem 0.5rem;
            font-size: 0.9rem;
        }

        .text-total {
            font-size: 1.25rem;
            text-align: center;
            margin-top: 1.5rem;
        }

        #confirmOrderForm {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-custom {
            width: 100%;
            justify-content: center;
            padding: 0.875rem 1.5rem;
        }

        .quantity-badge,
        .measure-badge {
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
        }
    }

    @media (max-width: 576px) {
        .page-title {
            padding: 1.5rem 0.75rem;
        }

        .page-title h1 {
            font-size: 1.5rem;
        }

        .mercerie-name {
            font-size: 1rem;
        }

        .card-custom {
            padding: 1.25rem;
            margin: 0 -0.75rem;
            border-radius: var(--radius-md);
        }

        .table thead th {
            font-size: 0.8rem;
            padding: 0.75rem 0.375rem;
        }

        .table tbody td {
            font-size: 0.85rem;
            padding: 0.75rem 0.375rem;
        }

        .text-total {
            font-size: 1.1rem;
            padding: 0.75rem 0;
        }

        .btn-custom {
            padding: 0.75rem 1.25rem;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 480px) {
        .container {
            padding: 0 0.5rem;
        }

        .page-title {
            border-radius: var(--radius-md);
        }

        .table {
            min-width: 400px;
        }

        .table thead th {
            font-size: 0.75rem;
        }

        .table tbody td {
            font-size: 0.8rem;
        }

        /* Masquer certaines colonnes sur très petits écrans */
        @media (max-width: 360px) {
            .table thead th:nth-child(3),
            .table tbody td:nth-child(3) {
                display: none;
            }
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

    .card-custom {
        animation: fadeInUp 0.6s ease-out;
    }

    /* ===== ACCESSIBILITÉ ===== */
    @media (prefers-reduced-motion: reduce) {
        .card-custom,
        .btn-custom,
        .table tbody tr {
            transition: none;
            animation: none;
        }

        .card-custom:hover {
            transform: none;
        }

        .page-title::before {
            animation: none;
        }

        .btn-custom::before {
            display: none;
        }
    }

    .btn-custom:focus-visible,
    .table tbody tr:focus-visible {
        outline: 2px solid var(--primary-color);
        outline-offset: 2px;
    }

    /* ===== SWEETALERT2 PERSONNALISATION ===== */
    .swal2-popup {
        border-radius: var(--radius-xl) !important;
        box-shadow: var(--shadow-xl) !important;
    }
</style>

<div class="container my-5">
    <!-- Titre principal -->
    <div class="card-header">
        <h1>
            Prévisualisation de la commande
            <span class="mercerie-name">{{ $mercerie->name }}</span>
        </h1>
    </div>

    <!-- Carte principale -->
    <div class="card-custom">
        <!-- Tableau des fournitures -->
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr>
                        <th>Fourniture</th>
                        <th>Quantité</th>
                        <th>Mesure</th>
                        <th>Prix Unitaire</th>
                        <th>Sous-total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($details as $item)
                    @php
                        // Normalize display: prefer explicit measure_requested for the measure column.
                        // If measure_requested is empty but quantity contains letters (e.g. "2.5m"),
                        // treat that quantity value as the measure and hide it from the quantity column.
                        $qty = $item['quantity'] ?? null;
                        $measure = $item['measure_requested'] ?? null;

                        if (empty($measure) && is_string($qty) && preg_match('/[a-z]/i', $qty)) {
                            $measure = $qty;
                            $qty = null;
                        }
                    @endphp
                    <tr>
                        <td>
                            <strong>{{ $item['supply'] }}</strong>
                        </td>
                        <td>
                            @if($qty !== null)
                                <span class="quantity-badge">{{ $qty }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($measure)
                                <span class="measure-badge">{{ $measure }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <strong>{{ number_format($item['price'], 0, ',', ' ') }} FCFA</strong>
                        </td>
                        <td>
                            <strong class="text-primary">{{ number_format($item['subtotal'], 0, ',', ' ') }} FCFA</strong>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="empty-state">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <h4>Aucune fourniture sélectionnée</h4>
                            <p>Veuillez ajouter des fournitures à votre commande</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Total -->
        <h4 class="text-end mt-4 text-total">
            <i class="fa-solid fa-receipt me-2"></i>
            Total : {{ number_format($total, 0, ',', ' ') }} FCFA
        </h4>

        <!-- Formulaire de validation -->
        <form id="confirmOrderForm" 
              action="{{ route('merceries.order', $mercerie->id) }}" 
              method="POST" 
              class="mt-4 d-flex justify-content-end gap-3 flex-wrap">
            @csrf
            @foreach($details as $index => $item)
                <input type="hidden" name="items[{{ $index }}][merchant_supply_id]" value="{{ $item['merchant_supply_id'] ?? '' }}">
                <input type="hidden" name="items[{{ $index }}][quantity]" value="{{ $item['quantity'] }}">
                <input type="hidden" name="items[{{ $index }}][measure_requested]" value="{{ $item['measure_requested'] ?? '' }}">
            @endforeach

            <button type="button" id="confirmOrderBtn" class="btn-custom btn-primary-custom">
                <i class="fa-solid fa-check-circle me-2"></i>
                Valider la commande
            </button>
            <a href="{{ route('merceries.show', $mercerie->id) }}" class="btn-custom btn-secondary-custom">
                <i class="fa-solid fa-arrow-left me-2"></i>
                Modifier
            </a>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<!-- Import SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const confirmBtn = document.getElementById('confirmOrderBtn');
    const form = document.getElementById('confirmOrderForm');

    confirmBtn.addEventListener('click', function() {
        Swal.fire({
            title: 'Confirmer la commande ?',
            html: `
                <div class="text-start">
                    <p><strong>Vous êtes sur le point de valider votre commande :</strong></p>
                    <div class="mt-3 p-3 rounded-3" style="background: var(--gray-50); border: 1px solid var(--gray-200);">
                        <div class="mb-2">
                            <i class="fa-solid fa-store me-2 text-primary"></i>
                            <strong>Mercerie :</strong> {{ $mercerie->name }}
                        </div>
                        <div class="mb-2">
                            <i class="fa-solid fa-list me-2 text-primary"></i>
                            <strong>Articles :</strong> {{ count($details) }}
                        </div>
                        <div>
                            <i class="fa-solid fa-receipt me-2 text-primary"></i>
                            <strong>Total :</strong> {{ number_format($total, 0, ',', ' ') }} FCFA
                        </div>
                    </div>
                    <p class="mt-3 text-muted small">Cette action enverra votre commande à la mercerie pour validation.</p>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4F0341',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fa-solid fa-check me-2"></i>Confirmer la commande',
            cancelButtonText: '<i class="fa-solid fa-times me-2"></i>Annuler',
            background: '#fff',
            color: '#334155',
            customClass: {
                popup: 'rounded-4 shadow-lg',
                confirmButton: 'btn-custom btn-primary-custom',
                cancelButton: 'btn-custom btn-secondary-custom'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                // Ajouter un indicateur de chargement
                confirmBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Validation en cours...';
                confirmBtn.disabled = true;
                
                form.submit();
            }
        });
    });

    // Gestion du responsive avancé
    function handleResponsive() {
        const table = document.querySelector('.table');
        const container = document.querySelector('.container');
        
        if (table && container) {
            const tableWidth = table.offsetWidth;
            const containerWidth = container.offsetWidth;
            
            if (tableWidth > containerWidth) {
                table.parentElement.classList.add('overflow-x-auto');
            } else {
                table.parentElement.classList.remove('overflow-x-auto');
            }
        }
    }

    // Exécuter au chargement et au redimensionnement
    handleResponsive();
    window.addEventListener('resize', handleResponsive);
});
</script>
@endpush