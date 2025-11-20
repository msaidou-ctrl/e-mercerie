@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Merceries (ayant au moins une fourniture)</h1>
        <form class="d-flex" method="GET" action="{{ route('admin.merceries.index') }}">
            <input type="search" name="search" value="{{ $search ?? '' }}" placeholder="Rechercher..." class="form-control me-2">
            <button class="btn btn-outline-secondary">Rechercher</button>
        </form>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nom / Raison</th>
                <th>Ville</th>
                <th>Quartier</th>
                <th>Téléphone</th>
                <th>Fournitures</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($merceries as $m)
            <tr>
                <td>{{ $m->display_business_name }}</td>
                <td>{{ $m->city }}</td>
                <td>{{ $m->quarter?->name }}</td>
                <td>{{ $m->phone }}</td>
                <td>{{ $m->merchantSupplies()->count() }}</td>
                <td>
                    <a href="{{ route('merceries.show', $m->id) }}" class="btn btn-sm btn-primary">Voir</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $merceries->links() }}
</div>
@endsection
