@extends('layouts.app')

@section('title', 'Toutes les Notifications')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">Toutes Les Notifications</h1>
    <div class="table-responsive shadow-sm">
        <table id="notificationsTable" class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th><i class="fas fa-bell"></i> Type</th>
                    <th><i class="fas fa-file-invoice"></i> Facture</th>
                    <th><i class="fas fa-truck"></i> Fournisseur</th>
                    <th><i class="fas fa-calendar-alt"></i> Date Demande</th>
                    <th><i class="fas fa-user"></i> Agent</th>
                    <!-- <th><i class="fas fa-cog"></i> Action</th> -->
                </tr>
            </thead>
            <tbody>
                @forelse($unreadNotifications as $notification)
                    <tr>
                        <td>{{ class_basename($notification->type) }}</td>
                        <td>{{ $notification->data['facture_number'] ?? 'N/A' }}</td>
                        <td>{{ $notification->data['fournisseur'] ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($notification->data['date_demande'] ?? now())->format('d/m/Y H:i') }}</td>
                        <td>
                            <span class="agent-name" style="color: {{ $notification->data['transit_agent'] ? sprintf('#%06X', crc32($notification->data['transit_agent']) & 0xFFFFFF) : '#000000' }};">
                                <i class="fas fa-circle" style="font-size: 10px; margin-right: 5px;"></i>
                                {{ $notification->data['transit_agent'] ?? 'N/A' }}
                            </span>
                        </td>
                        <!--
                        <td>
                            <button class="btn btn-danger btn-sm delete-btn" data-notification-id="{{ $notification->id }}" title="Supprimer">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </td>
                        -->
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center"><i class="fas fa-info-circle"></i> Aucune notification non lue</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <br><br>
    <a href="{{ route('responsable_finance.dashboard') }}" class="btn btn-secondary mt-3 shadow-sm">
        <i class="fas fa-arrow-left"></i> Retour au tableau de bord
    </a>
</div>

<style>
    .container {
        width: 100%;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    h1 {
        font-size: 28px;
        margin-bottom: 20px;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
    }

    .table-responsive {
        overflow-x: auto;
        border-radius: 8px;
    }

    .table {
        width: 100%;
        margin-bottom: 0;
        border-radius: 8px;
        overflow: hidden;
    }

    .thead-dark th {
        background-color: #343a40;
        font-weight: 600;
        text-align: center;
        padding: 12px;
        color: #fff;
    }

    .thead-dark th i {
        margin-right: 8px;
    }

    tbody tr {
        transition: all 0.3s ease;
    }

    tbody tr:hover {
        background-color: #4d4e4e;
        transform: scale(1.01);
    }

    td {
        vertical-align: middle;
        padding: 12px;
        font-size: 14px;
        color: #ffffff;
    }

    .agent-name {
        font-weight: 500;
        display: flex;
        align-items: center;
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 12px;
        border-radius: 4px;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        transition: all 0.2s ease;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
        box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
        transition: all 0.2s ease;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
        box-shadow: 0 2px 8px rgba(108, 117, 125, 0.3);
    }

    .text-center {
        text-align: center;
    }
</style>
@endsection

@section('scripts')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Inclure Font Awesome pour les icônes -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<script>
    $(document).ready(function() {
        let table = $('#notificationsTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/French.json"
            },
            "order": [[3, 'desc']],
            "pageLength": 15,
            "paging": false,
            "scrollX": true,
            "autoWidth": false
        });

        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            const notificationId = $(this).data('notification-id');
            console.log('Tentative de suppression pour ID:', notificationId);

            if (confirm('Voulez-vous vraiment supprimer cette notification ?')) {
                $.ajax({
                    url: '#'.replace(':id', notificationId),
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            console.log('Notification supprimée');
                            let row = $(this).closest('tr');
                            table.row(row).remove().draw(false);
                            if (table.rows().count() === 0) {
                                table.row.add($('<tr><td colspan="6" class="text-center"><i class="fas fa-info-circle"></i> Aucune notification non lue</td></tr>')[0]).draw(false);
                            }
                        } else {
                            console.error('Échec de la suppression:', response.message);
                        }
                    }.bind(this),
                    error: function(xhr, status, error) {
                        console.error('Erreur AJAX:', status, error);
                        console.log('Réponse serveur:', xhr.responseText);
                    }
                });
            }
        });
    });
</script>
@endsection