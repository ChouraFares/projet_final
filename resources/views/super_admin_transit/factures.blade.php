@extends('layouts.transit')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Validation des Factures</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Fournisseur</th>
                <th>Facture</th>
                <th>Validation Transit</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($factures as $facture)
            <tr>
                <td>{{ $facture->fournisseur }}</td>
                <td>{{ $facture->facture }}</td>
                <td>{{ $facture->validation_transit }}</td>
                <td>
                    <form action="{{ route('super-admin-transit.factures.approve', $facture->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Approuver</button>
                    </form>
                    <form action="{{ route('super-admin-transit.factures.reject', $facture->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">Refuser</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
