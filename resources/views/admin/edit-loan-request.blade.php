@extends('layouts.app')

@section('title', 'Modifier une Demande de Prêt/Avance')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Modifier la Demande de Prêt/Avance</h1>

    <form action="{{ route('admin.updateLoanRequest', $loanRequest->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="amount">Montant (TND) :</label>
            <input type="number" id="amount" name="amount" class="form-control" value="{{ $loanRequest->amount }}" required>
        </div>

        <div class="form-group">
            <label for="purpose">Objet :</label>
            <input type="text" id="purpose" name="purpose" class="form-control" value="{{ $loanRequest->purpose }}">
        </div>

        <div class="form-group">
            <label for="repayment_month">Mois de Remboursement :</label>
            <select id="repayment_month" name="repayment_month" class="form-control" required>
                <option value="JAN" {{ $loanRequest->repayment_month == 'JAN' ? 'selected' : '' }}>Janvier</option>
                <option value="FEB" {{ $loanRequest->repayment_month == 'FEB' ? 'selected' : '' }}>Février</option>
                <option value="MAR" {{ $loanRequest->repayment_month == 'MAR' ? 'selected' : '' }}>Mars</option>
                <option value="APR" {{ $loanRequest->repayment_month == 'APR' ? 'selected' : '' }}>Avril</option>
                <option value="MAY" {{ $loanRequest->repayment_month == 'MAY' ? 'selected' : '' }}>Mai</option>
                <option value="JUN" {{ $loanRequest->repayment_month == 'JUN' ? 'selected' : '' }}>Juin</option>
            </select>
        </div>

        <div class="form-group">
            <label for="type">Type :</label>
            <select id="type" name="type" class="form-control" required>
                <option value="Prêt" {{ $loanRequest->type == 'Prêt' ? 'selected' : '' }}>Prêt</option>
                <option value="Avance" {{ $loanRequest->type == 'Avance' ? 'selected' : '' }}>Avance</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection