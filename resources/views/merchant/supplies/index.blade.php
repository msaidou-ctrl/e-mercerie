@extends('layouts.app')

@section('content')
<!-- === TITRE PRINCIPAL === -->
<div class="card-header">
  <h1>Mes Fournitures</h1>
  <p>Gérez votre inventaire de fournitures</p>
</div>

<div class="container-fluid px-3 px-md-5">
  <div class="tables-wrapper">
    <div class="card-style mb-30 shadow-sm rounded-4">

      <!-- En-tête de la carte -->
      <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <h4 class="fw-bold text-dark m-0">Liste de mes fournitures</h4>

        <div class="d-flex flex-wrap gap-2 align-items-center justify-content-center">
          <input id="merchant-search" name="search" value="{{ old('search', $search ?? '') }}"
            type="search" placeholder="🔍 Rechercher une fourniture..."
            class="form-control form-control-sm rounded-pill shadow-sm border-0 w-auto flex-grow-1"
            style="min-width: 230px;" autocomplete="off" />
          <a href="{{ route('merchant.supplies.create') }}" class="soft-btn primary-btn">
            <i class="fa-solid fa-plus"></i> Ajouter
          </a>
        </div>
      </div>

      <!-- Tableau responsive -->
      <div class="table-wrapper table-responsive">
        <table class="table align-middle text-center">
          <thead>
            <tr>
              <th><h6>Fourniture</h6></th>
              <th><h6>Prix (FCFA)</h6></th>
              <th><h6>Quantité</h6></th>
              <th><h6>Actions</h6></th>
            </tr>
          </thead>
          <tbody id="merchant-supplies-rows">
            @include('merchant.supplies._rows')
          </tbody>
        </table>
      </div>

      <!-- Section pagination -->
      <div id="merchant-supplies-pagination">
        @include('merchant.supplies._pagination')
      </div>

    </div>
  </div>
</div>

<!-- === STYLE PERSONNALISÉ === -->
<style>
:root {
  --primary-color: #4F0341;
  --primary-light: #7a1761;
  --secondary-color: #9333ea;
  --white: #fff;
  --gray-light: #f8f9fa;
  --gray-medium: #e9ecef;
  --gray-dark: #6b7280;
  --text-secondary: #64748b;
  --text-muted: #94a3b8;
  --surface-color: #f8fafc;
  --border-color: #e2e8f0;
  --border-light: #f1f5f9;
  --radius: 16px;
  --radius-lg: 20px;
  --shadow: 0 8px 30px rgba(0,0,0,0.08);
  --shadow-md: 0 8px 25px rgba(0,0,0,0.1);
  --transition: all 0.3s ease;
}

/* CARTE */
.card-style {
  background: var(--white);
  border-radius: var(--radius);
  box-shadow: var(--shadow);
  padding: 2rem;
}

/* TABLEAU */
.table-wrapper {
  overflow-x: auto;
}
.table thead {
  background: rgba(79, 3, 65, 0.08);
}
.table th h6 {
  color: var(--primary-color);
  font-weight: 600;
  margin: 0;
}
.table tbody tr {
  transition: var(--transition);
}
.table tbody tr:hover {
  background-color: #faf5ff;
}

/* BOUTONS */
.soft-btn {
  border: none;
  border-radius: 50px;
  font-weight: 600;
  padding: 0.7rem 1.8rem;
  cursor: pointer;
  transition: var(--transition);
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  text-decoration: none;
  text-align: center;
  white-space: nowrap;
}

.primary-btn {
  background: var(--primary-color);
  color: white;
  box-shadow: 0 4px 12px rgba(79, 3, 65, 0.2);
}
.primary-btn:hover {
  background: var(--secondary-color);
  transform: translateY(-3px);
  box-shadow: 0 10px 25px rgba(147,51,234,0.3);
}

/* ICONES */
.edit-icone {
  color: var(--primary-color);
  font-size: 1.1rem;
  transition: var(--transition);
}
.edit-icone:hover {
  color: var(--secondary-color);
  transform: scale(1.1);
}
.btn-delete i {
  color: #e11d48;
  transition: var(--transition);
}
.btn-delete i:hover {
  transform: scale(1.1);
  color: #b91c1c;
}

/* === PAGINATION STYLISÉE === */
.pagination-container {
    margin-top: 3rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1.5rem;
}

.pagination-info {
    color: var(--text-secondary);
    font-size: 0.9rem;
    font-weight: 500;
    background: var(--surface-color);
    padding: 0.5rem 1rem;
    border-radius: var(--radius-lg);
    border: 1px solid var(--border-light);
}

/* Conteneur principal de pagination */
.pagination {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
    gap: 0.5rem;
    align-items: center;
    flex-wrap: wrap;
    justify-content: center;
}

/* Éléments de pagination */
.pagination .page-item {
    margin: 0;
}

/* Liens de pagination */
.pagination .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 44px;
    height: 44px;
    padding: 0 1rem;
    border: 2px solid var(--border-color);
    border-radius: var(--radius-lg);
    background: var(--white);
    color: var(--text-secondary);
    text-decoration: none;
    font-weight: 600;
    font-size: 0.95rem;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}

/* Effet de survol */
.pagination .page-link:hover {
    background: var(--primary-color);
    color: var(--white);
    border-color: var(--primary-color);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

/* Page active */
.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    color: var(--white);
    border-color: var(--primary-color);
    box-shadow: 0 4px 15px rgba(79, 3, 65, 0.3);
    transform: translateY(-1px);
}

/* État désactivé */
.pagination .page-item.disabled .page-link {
    background: var(--surface-color);
    color: var(--text-muted);
    border-color: var(--border-light);
    cursor: not-allowed;
    opacity: 0.6;
    transform: none;
    box-shadow: none;
}

.pagination .page-item.disabled .page-link:hover {
    background: var(--surface-color);
    color: var(--text-muted);
    border-color: var(--border-light);
    transform: none;
    box-shadow: none;
}

/* Boutons précédent/suivant */
.pagination .page-item:first-child .page-link,
.pagination .page-item:last-child .page-link {
    font-weight: 700;
    padding: 0 1.25rem;
    background: var(--white);
    border: 2px solid var(--border-color);
    min-width: auto;
}

.pagination .page-item:first-child .page-link:hover,
.pagination .page-item:last-child .page-link:hover {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: var(--white);
}

/* Animation pour la page active */
@keyframes activePulse {
    0%, 100% { 
        transform: translateY(-1px) scale(1); 
        box-shadow: 0 4px 15px rgba(79, 3, 65, 0.3);
    }
    50% { 
        transform: translateY(-1px) scale(1.05); 
        box-shadow: 0 6px 20px rgba(79, 3, 65, 0.4);
    }
}

.pagination .page-item.active .page-link {
    animation: activePulse 2s ease-in-out infinite;
}

/* Style pour les petits écrans */
@media (max-width: 768px) {
    .pagination-container {
        margin-top: 2rem;
        gap: 1rem;
    }
    
    .pagination .page-link {
        min-width: 40px;
        height: 40px;
        padding: 0 0.875rem;
        font-size: 0.9rem;
    }
    
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        padding: 0 1rem;
        font-size: 0.85rem;
    }
    
    .pagination-info {
        font-size: 0.85rem;
        padding: 0.4rem 0.8rem;
    }
}

@media (max-width: 480px) {
    .pagination {
        gap: 0.25rem;
    }
    
    .pagination .page-link {
        min-width: 36px;
        height: 36px;
        padding: 0 0.5rem;
        font-size: 0.85rem;
    }
    
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        padding: 0 0.75rem;
        min-width: auto;
    }
}

/* RESPONSIVE DESIGN */
@media (max-width: 992px) {
  .d-flex.justify-content-between {
    flex-direction: column;
    align-items: stretch !important;
  }
  .d-flex.flex-wrap.gap-2 {
    justify-content: space-between;
  }
}

@media (max-width: 768px) {
  .card-style {
    padding: 1.2rem;
  }
  .soft-btn {
    padding: 0.6rem 1.3rem;
    width: 100%;
    justify-content: center;
  }
  .page-title {
    padding: 1.8rem 1rem;
  }
  .table th h6 {
    font-size: 0.9rem;
  }
  .table td {
    font-size: 0.9rem;
  }
}
</style>

<!-- === SWEETALERT2 === -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  // Fonction pour attacher les événements de suppression
  function attachDeleteHandlers() {
    document.querySelectorAll('.btn-delete').forEach(button => {
      button.addEventListener('click', function (e) {
        e.preventDefault();
        const form = this.closest('form');
        Swal.fire({
          title: 'Supprimer cette fourniture ?',
          text: "Cette action est irréversible.",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#4F0341',
          cancelButtonColor: '#6c757d',
          confirmButtonText: 'Oui, supprimer',
          cancelButtonText: 'Annuler',
          customClass: { popup: 'rounded-4 shadow-lg' }
        }).then((result) => {
          if (result.isConfirmed) form.submit();
        });
      });
    });
  }

  // Attacher les handlers initiaux
  attachDeleteHandlers();

  // === RECHERCHE AJAX AMÉLIORÉE === 
  const searchInput = document.getElementById('merchant-search');
  const rowsContainer = document.getElementById('merchant-supplies-rows');
  const paginationContainer = document.getElementById('merchant-supplies-pagination');

  function debounce(fn, delay) {
    let timeout;
    return function (...args) {
      clearTimeout(timeout);
      timeout = setTimeout(() => fn.apply(this, args), delay);
    };
  }

  async function fetchResults(url) {
    try {
      // Afficher un indicateur de chargement
      rowsContainer.innerHTML = '<tr><td colspan="4" class="text-center py-4"><div class="spinner-border text-primary" role="status"></div><p class="mt-2 text-muted">Chargement...</p></td></tr>';
      
      const response = await fetch(url, { 
        headers: { 
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json'
        } 
      });
      
      if (!response.ok) throw new Error('Erreur réseau');
      
      const data = await response.json();
      
      // Mettre à jour les lignes du tableau
      if (data.rows) {
        rowsContainer.innerHTML = data.rows;
      }
      
      // Mettre à jour la pagination
      if (data.pagination) {
        paginationContainer.innerHTML = data.pagination;
      }
      
      // Réattacher les événements
      attachDeleteHandlers();
      attachPaginationHandlers();
      
    } catch (error) {
      console.error('Erreur lors de la recherche:', error);
      rowsContainer.innerHTML = '<tr><td colspan="4" class="text-center text-danger py-4">Erreur lors du chargement des données</td></tr>';
    }
  }

  // Gestionnaire pour la recherche
  const handleSearch = debounce(() => {
    const query = searchInput.value;
    const url = new URL(window.location.href);
    
    if (query) {
      url.searchParams.set('search', query);
    } else {
      url.searchParams.delete('search');
    }
    
    // Retirer le paramètre page pour revenir à la première page
    url.searchParams.delete('page');
    
    // Mettre à jour l'URL sans recharger la page
    window.history.replaceState({}, '', url);
    
    fetchResults(url.toString());
  }, 400);

  searchInput.addEventListener('input', handleSearch);

  // Gestionnaire pour la pagination
  function attachPaginationHandlers() {
    document.querySelectorAll('.pagination a').forEach(link => {
      link.addEventListener('click', function (e) {
        e.preventDefault();
        fetchResults(this.href);
        
        // Scroll vers le haut du tableau
        rowsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
      });
    });
  }

  // Attacher les handlers de pagination initiaux
  attachPaginationHandlers();

  // Gestion du chargement initial si des paramètres de recherche sont présents
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.has('search') || urlParams.has('page')) {
    // Les données sont déjà chargées par le serveur, pas besoin de refetch
  }
});
</script>
@endsection