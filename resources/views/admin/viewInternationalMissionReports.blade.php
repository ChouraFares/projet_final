@extends('layouts.app')

@section('title', 'Voir les Rapports de Mission Internationale')

@section('content') <!-- Assurez-vous que cette section est bien démarrée -->




<div class="container mt-5">
    <h2 class="text-center mb-4">Rapports Des Missions Internationales</h2>

  

    @if($missions->isEmpty())
        <div class="alert alert-warning text-center">
            Aucun rapport n'a été soumis pour le moment.
        </div>
    @else

        <div class="table-responsive">
            <table id="RepportView" class="table table-striped table-hover table-bordered" style="color: white;">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th>ID de la Mission</th>
                        <th>Nom de l'Utilisateur</th>
                        <th>Détails du Rapport</th>
                        <th>Date du Rapport</th>
                        <th>Reçu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($missions as $mission)
                        <tr class="text-center align-middle">
                            <td>{{ $mission->mission_id }}</td>
                            <td>{{ $mission->user->name }}</td>
                            <td>{{ $mission->report_details }}</td>
                            <td>{{ $mission->report_date }}</td>
                            <td>
                                @if($mission->receipt_path)
                                <a href="{{ asset('storage/'.$mission->receipt_path) }}" target="_blank" style="color: #ffc107; font-weight: bold;">
                                    Voir le reçu
                                </a>
                            @else
                                <span style="color: #ffc107; font-weight: bold;">⚠ Aucun reçu téléchargé</span>
                            @endif
                            

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <script>
            let table = new DataTable('#RepportView', {
                paging: true,
                searching: true,
                ordering: true
            });
        </script>
    @endif
</div>

@endsection <!-- Fin de la section -->
