@extends('layouts.app')

@section('title', 'Voir les Rapports de Mission')

@section('content')
<div class="container mt-4">
    <h2 class="text-center text-primary"> Rapports Des Missions Locales</h2>

    @if($missions->isEmpty())
        <div class="alert alert-warning text-center">
            Aucun rapport n'a été soumis pour le moment.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover table-bordered" id="RepportView">
                <thead class="table-dark">
                    <tr>
                        <th>ID de la Mission</th>
                        <th>Nom de l'Utilisateur</th>
                        <th>Détails du Rapport</th>
                        <th>Date du Rapport</th>
                        <th>Attachement</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($missions as $mission)
                    <tr>
                        <td>{{ $mission->mission_id }}</td>
                        <td>{{ $mission->user->name }}</td>
                        <td>{{ $mission->report_details }}</td>
                        <td>{{ $mission->report_date }}</td>
                        <td>
                            @if($mission->receipt_path && Storage::disk('public')->exists($mission->receipt_path))
                                <a href="{{ asset('storage/'.$mission->receipt_path) }}" 
                                   target="_blank" 
                                   class="btn btn-warning btn-sm text-dark fw-bold">
                                    📑 Voir le reçu
                                </a>
                            @else
                                <span class="text-danger fw-bold">Aucun reçu</span>
                            @endif
                        </td>
                        <td class="text-center">
                          
                            <!-- Supprimer -->
                            <form action="{{ route('missions.report.local.destroy', $mission->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Voulez-vous vraiment supprimer ce rapport ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    ❌ Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <script>
            $(document).ready(function () {
                $('#RepportView').DataTable({
                    "paging": true,
                    "searching": true,
                    "ordering": true,
                    "language": {
                        "lengthMenu": "Afficher _MENU_ enregistrements par page",
                        "zeroRecords": "Aucun rapport trouvé",
                        "info": "Affichage de _PAGE_ sur _PAGES_",
                        "infoEmpty": "Aucun enregistrement disponible",
                        "infoFiltered": "(filtré à partir de _MAX_ enregistrements)",
                        "search": "Rechercher :",
                        "paginate": {
                            "next": "Suivant",
                            "previous": "Précédent"
                        }
                    }
                });
            });
        </script>
    @endif
</div>
@endsection
