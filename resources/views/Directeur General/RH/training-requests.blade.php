@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Gestion des Demandes de Formation</h2>
    @if($trainingRequests->isEmpty())
        <p>Aucune demande de formation disponible.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>Département</th>
                    <th>Formation</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trainingRequests as $request)
                    <tr>
                        <td>{{ $request->user->name }}</td>
                        <td>{{ $request->department }}</td>
                        <td>{{ $request->selected_training }}</td>
                        <td>{{ $request->status }}</td>
                        <td>
                            <form action="{{ route('admin.training-request.update-status', $request->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status" required>
                                    <option value="en attente" {{ $request->status == 'en attente' ? 'selected' : '' }}>En attente</option>
                                    <option value="approuvée" {{ $request->status == 'approuvée' ? 'selected' : '' }}>Approuvée</option>
                                    <option value="refusée" {{ $request->status == 'refusée' ? 'selected' : '' }}>Refusée</option>
                                </select>
                                <button type="submit">Mettre à jour</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
