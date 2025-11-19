@extends('layouts.app')

@section('content')
<style>
  /* === Styles Modernisés === */

.card-head {
    background: linear-gradient(135deg, #4F0341, #7a1761);
    color: #fff;
    padding: 2.5rem 2rem;
    text-align: center;
    border-bottom: none;
    border-radius: 10px !important;
    position: relative;
    overflow: hidden;
    margin-bottom: 2rem;
}

.card-head::before {
    content: '';
    position: absolute;
    border-radius: 50px;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    animation: float 20s infinite linear;
}

@keyframes float {
    0% { transform: translateY(0) rotate(0deg); }
    100% { transform: translateY(-100px) rotate(360deg); }
}

.card-head h1 {
  color: var(--white);
  font-weight: 600;
  margin: 0;
  letter-spacing: 0.5px;
}

.card-head p {
    font-size: 1rem;
    opacity: 0.9;
    margin: 0;
    position: relative;
    z-index: 2;
    font-weight: 400;
}

  .btn-custom {
      background-color: #6a0b52;
      color: #fff;
      border: none;
      transition: all 0.3s ease;
      border-radius: 8px;
      padding: 0.5rem 1rem;
      font-weight: 500;
  }

  .btn-custom:hover {
      background-color: #8b166a;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(106, 11, 82, 0.3);
  }

  .btn-outline-danger {
      border: 1px solid #dc3545;
      color: #dc3545;
      transition: all 0.3s ease;
      border-radius: 8px;
      padding: 0.5rem 1rem;
      font-weight: 500;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
  }

  .btn-outline-danger:hover {
      background-color: #dc3545;
      color: #fff;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
  }

  .card-style {
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      padding: 1.5rem;
      overflow: hidden;
  }

  .single-notification {
      border-bottom: 1px solid #eee;
      padding: 1.25rem 0;
      transition: all 0.2s ease-in-out;
      position: relative;
  }

  .single-notification:last-child {
      border-bottom: none;
  }

  .single-notification:hover {
      background: #fafafa;
      border-radius: 10px;
      padding-left: 1rem;
      padding-right: 1rem;
      margin: 0 -1rem;
  }

  .single-notification.readed {
      opacity: 0.7;
  }

  .single-notification.readed::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 3px;
      background: #6a0b52;
      border-radius: 0 4px 4px 0;
  }

  .notification h6 {
      margin-bottom: 0.5rem;
      font-weight: 600;
      color: #333;
      line-height: 1.4;
      font-size: clamp(0.95rem, 2vw, 1.05rem);
  }

  .notification .text-sm {
      font-size: 0.9rem;
      color: #666;
      line-height: 1.4;
      margin-bottom: 0.5rem;
  }

  .notification small {
      font-size: 0.85rem;
      color: #888;
  }

  .notification .badge.bg-primary {
      background-color: #6a0b52 !important;
      font-size: 0.7rem;
      padding: 0.25rem 0.5rem;
  }

  .action {
      display: flex;
      gap: 0.5rem;
      flex-shrink: 0;
  }

  .action button,
  .action a {
      border-radius: 8px;
      transition: all 0.2s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 2.25rem;
      height: 2.25rem;
  }

  .action a.read {
      background-color: #f8f5fa;
      color: #6a0b52;
      border: 1px solid #e5d1e9;
  }

  .action a.read:hover {
      background-color: #6a0b52;
      color: #fff;
      transform: translateY(-1px);
  }

  .action .btn-outline-primary {
      border-color: #6a0b52;
      color: #6a0b52;
  }

  .action .btn-outline-primary:hover {
      background-color: #6a0b52;
      color: #fff;
  }

  .action .btn-outline-danger {
      border-color: #dc3545;
      color: #dc3545;
      width: auto;
      padding: 0.375rem 0.75rem;
  }

  .action .btn-outline-danger:hover {
      background-color: #dc3545;
      color: #fff;
  }

  .pagination-container {
      margin-top: 2rem;
  }

  .alert-info {
      background-color: #f9f5fb;
      color: #4F0341;
      border: none;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      padding: 2rem;
      text-align: center;
  }

  .alert-info i {
      margin-bottom: 1rem;
      opacity: 0.7;
  }

  /* ===== Pagination Stylisée ===== */
  .pagination {
      display: flex;
      list-style: none;
      padding: 0;
      gap: 0.5rem;
      flex-wrap: wrap;
      justify-content: center;
  }

  .pagination li {
      border-radius: 8px;
      overflow: hidden;
  }

  .pagination li a,
  .pagination li span {
      display: block;
      padding: 0.6rem 1rem;
      color: #6a0b52;
      background-color: #f8f5fa;
      border: 1px solid #e5d1e9;
      transition: all 0.3s ease;
      text-decoration: none;
      font-weight: 500;
      min-width: 2.75rem;
      text-align: center;
  }

  .pagination li a:hover {
      background-color: #6a0b52;
      color: #fff;
      transform: translateY(-1px);
  }

  .pagination .active span {
      background-color: #6a0b52;
      color: #fff;
      border-color: #6a0b52;
  }

  .pagination .disabled span {
      opacity: 0.5;
      cursor: not-allowed;
      transform: none !important;
  }

  /* === Responsive Design === */
  @media (max-width: 768px) {
      .container-fluid {
          padding: 0 1rem;
      }
      
      .card-style {
          padding: 1.25rem;
          border-radius: 12px;
      }
      
      .single-notification {
          padding: 1rem 0;
      }
      
      .single-notification:hover {
          padding-left: 0.75rem;
          padding-right: 0.75rem;
          margin: 0 -0.75rem;
      }
      
      .notification {
          flex-direction: column;
          align-items: flex-start !important;
      }
      
      .content {
          width: 100%;
          margin-bottom: 1rem;
      }
      
      .action {
          width: 100%;
          justify-content: flex-end;
      }
      
      .action button, 
      .action a {
          width: 2.5rem;
          height: 2.5rem;
      }
      
      .pagination li a,
      .pagination li span {
          padding: 0.5rem 0.8rem;
          min-width: 2.5rem;
          font-size: 0.9rem;
      }
  }

  @media (max-width: 576px) {
      .page-title h1 {
          font-size: 1.5rem;
      }
      
      .card-style {
          padding: 1rem;
          border-radius: 10px;
      }
      
      .single-notification {
          padding: 0.875rem 0;
      }
      
      .notification h6 {
          font-size: 1rem;
      }
      
      .action {
          gap: 0.375rem;
      }
      
      .action button, 
      .action a {
          width: 2.25rem;
          height: 2.25rem;
          font-size: 0.8rem;
      }
      
      .pagination {
          gap: 0.25rem;
      }
      
      .pagination li a,
      .pagination li span {
          padding: 0.4rem 0.7rem;
          min-width: 2.25rem;
          font-size: 0.85rem;
      }
      
      .btn-outline-danger {
          padding: 0.4rem 0.8rem;
          font-size: 0.9rem;
      }
  }

  @media (max-width: 400px) {
      .container-fluid {
          padding: 0 0.75rem;
      }
      
      .card-style {
          padding: 0.75rem;
      }
      
      .single-notification:hover {
          padding-left: 0.5rem;
          padding-right: 0.5rem;
          margin: 0 -0.5rem;
      }
      
      .pagination li a,
      .pagination li span {
          padding: 0.35rem 0.6rem;
          min-width: 2rem;
          font-size: 0.8rem;
      }
  }

  /* === Animations améliorées === */
  @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
  }

  .single-notification {
      animation: fadeIn 0.3s ease-out;
  }

  .single-notification:nth-child(odd) {
      animation-delay: 0.05s;
  }

  .single-notification:nth-child(even) {
      animation-delay: 0.1s;
  }

  /* === États de focus améliorés === */
  .action button:focus,
  .action a:focus,
  .pagination li a:focus {
      outline: 2px solid #6a0b52;
      outline-offset: 2px;
  }

  /* === Amélioration de la lisibilité === */
  .notification a.text-decoration-none:hover h6 {
      color: #6a0b52;
      transition: color 0.2s ease;
  }
</style>

<!-- === Titre principal === -->
<div class="card-head">
    <h1>Mes Notifications</h1>
    <p>Accédez à vos notifications.</p>
</div>

@if($notifications->isNotEmpty())
<form action="{{ route('notifications.clearAll') }}" method="POST" class="d-inline">
@csrf
@method('DELETE')
<button type="button" id="clear-all-btn" class="btn btn-outline-danger mb-4">
    <i class="fa-solid fa-trash"></i> Tout supprimer
</button>
</form>
@endif

<!-- === Liste des notifications === -->
<div class="card-style">
@forelse($notifications as $notification)
    <div class="single-notification {{ $notification->read_at ? 'readed' : '' }}">
    <div class="notification d-flex align-items-start justify-content-between flex-wrap">
        <div class="content flex-grow-1 me-3">
        <a href="{{ $notification->data['url'] ?? '#' }}" class="text-decoration-none text-dark read">
            <h6>{{ $notification->data['message'] ?? 'Notification' }}</h6>
            @if(isset($notification->data['subtitle']))
            <p class="text-sm">{{ $notification->data['subtitle'] }}</p>
            @endif
        </a>
        <small class="text-muted d-flex align-items-center flex-wrap">
            {{ $notification->created_at->format('d/m/Y H:i') }}
            @if(!$notification->read_at)
            <span class="badge bg-primary ms-2">Nouveau</span>
            @endif
        </small>
        </div>
        <div class="action mt-2 mt-md-0">
        @if(!$notification->read_at)
            <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-primary" title="Marquer comme lu">
                <i class="fa-solid fa-check"></i>
            </button>
            </form>
        @endif
        @if(isset($notification->data['url']))
            <a href="{{ $notification->data['url'] . '?notif=' . $notification->id }}" 
                class="btn btn-sm read" title="Voir">
            <i class="fa-solid fa-eye"></i>
            </a>
        @endif
        <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
            <i class="fa-solid fa-trash-can"></i>
            </button>
        </form>
        </div>
    </div>
    </div>
@empty
    <div class="alert alert-info text-center py-4">
    <i class="fa-solid fa-bell-slash fa-3x mb-3 d-block"></i>
    <h4>Aucune notification</h4>
    <p class="mb-0">Vous n'avez aucune notification pour le moment.</p>
    </div>
@endforelse
</div>

<!-- Pagination -->
@if($notifications->isNotEmpty())
<div class="pagination-container d-flex justify-content-center">
{{ $notifications->links() }}
</div>
@endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // SweetAlert2 - Suppression globale
    const clearAllBtn = document.getElementById('clear-all-btn');
    if (clearAllBtn) {
        clearAllBtn.addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: 'Cette action supprimera toutes vos notifications.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4F0341',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler',
                customClass: { 
                    popup: 'rounded-4 shadow-lg',
                    confirmButton: 'btn-custom',
                    cancelButton: 'btn-outline-danger'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    clearAllBtn.closest('form').submit();
                }
            });
        });
    }

    // Marquer comme lu via clic
    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    document.querySelectorAll('.btn.read').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const href = this.getAttribute('href') || '#';
            const url = new URL(href, window.location.origin);
            const notifId = url.searchParams.get('notif');
            if (notifId) {
                e.preventDefault();
                fetch(`/notifications/${notifId}/read`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf
                    }
                }).then(() => window.location.href = href)
                .catch(() => window.location.href = href);
            }
        });
    });
});
</script>
@endpush