@extends('layouts.app')

@section('title', 'Demandes de Stage')

@section('content')
<div class="container mt-5">
    <div class="table-responsive">
        <table id="internshipRequestsTable" class="table table-striped table-hover table-bordered custom-table">
            <thead class="thead-dark text-center">
                <tr>
                    <th><i class="fas fa-user"></i> Nom de l'employé</th>
                    <th><i class="fas fa-id-badge"></i> MLE</th>
                    <th><i class="fas fa-building"></i> Département</th>
                    <th><i class="fas fa-briefcase"></i> Type de Stage</th>
                    <th><i class="fas fa-clock"></i> Durée</th>
                    <th><i class="fas fa-calendar-alt"></i> Date de Début</th>
                    <th><i class="fas fa-tools"></i> Compétences requises</th>
                    <th><i class="fas fa-lightbulb"></i> Autres Compétences</th>
                    <th><i class="fas fa-file-pdf"></i> CV</th>
                    <th><i class="fas fa-info-circle"></i> Statut</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach($requests as $request)
                    <tr>
                        <td>{{ $request->user->name }}</td>
                        <td>{{ $request->user->MLE }}</td>
                        <td>{{ $request->department }}</td>
                        <td>{{ $request->internship_type }}</td>
                        <td>{{ $request->duration }}</td>
                        <td>{{ $request->start_date }}</td>
                        <td>
                            @if(is_array(json_decode($request->skills_needed, true)))
                                {{ implode(', ', json_decode($request->skills_needed)) }}
                            @else
                                {{ $request->skills_needed }}
                            @endif
                        </td>
                        <td>{{ $request->further_skills }}</td>
                        <td>
                            <a href="{{ Storage::url($request->cv_path) }}" target="_blank" target="_blank" class="btn btn-warning btn-sm text-dark fw-bold custom-btn">
                                <i class="fas fa-folder-open"></i> Voir CV
                            </a>
                        </td>
                        <td><span class="badge bg-secondary text-white">{{ ucfirst($request->status) }}</span></td>
                    
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Activation de DataTables --}}
<script>
    $(document).ready(function () {
        $('#internshipRequestsTable').DataTable({
            "paging": true,
            "pageLength": 10,
            "lengthChange": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "language": {
                "lengthMenu": "Afficher _MENU_ entrées",
                "zeroRecords": "Aucune demande trouvée",
                "info": "Affichage de _START_ à _END_ sur _TOTAL_ demandes",
                "infoEmpty": "Aucune donnée disponible",
                "infoFiltered": "(filtré à partir de _MAX_ entrées au total)",
                "search": "Rechercher :",
                "paginate": {
                    "first": "Premier",
                    "last": "Dernier",
                    "next": "Suivant",
                    "previous": "Précédent"
                }
            },
            "dom": 'Bfrtip',
            "buttons": [
                {
                    extend: 'excelHtml5',
                    text: 'Exporter Excel',
                    className: 'btn btn-outline-success',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: 'Exporter PDF',
                    className: 'btn btn-outline-danger',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                }
            ]
        });
    });
</script>

<style>
    
    .custom-btn {
        font-weight: bold;
        padding: 5px 10px;
        border-radius: 5px;
    }
    .btn-success {
        background-color: #28a745 !important;
        border-color: #28a745 !important;
    }
    .btn-danger {
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
    }
    .btn-warning {
        background-color: #ffc107 !important;
        border-color: #ffc107 !important;
    }
    .badge {
        font-size: 14px;
        padding: 5px 10px;
        border-radius: 12px;
    }
</style>

@endsection
