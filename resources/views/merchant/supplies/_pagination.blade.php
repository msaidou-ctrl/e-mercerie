<div class="pagination-container">
  <div class="pagination-info">
    Affichage {{ $merchantSupplies->firstItem() ?? 0 }} - {{ $merchantSupplies->lastItem() ?? 0 }} sur {{ $merchantSupplies->total() }} fournitures</small>
  </div>
    {!! $merchantSupplies->links('pagination::bootstrap-5') !!}
</div>

<style>
  @if($merchantSupplies->hasPages())
<div class="pagination-container">
    <div class="pagination-info">
        Affichage {{ $merchantSupplies->firstItem() ?? 0 }} - {{ $merchantSupplies->lastItem() ?? 0 }} sur {{ $merchantSupplies->total() }} fournitures
    </div>
    {!! $merchantSupplies->links('pagination::bootstrap-5') !!}
</div>
@endif
</style>