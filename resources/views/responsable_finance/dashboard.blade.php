@extends('layouts.app')
@section('title', 'Responsable Finance')

@include('components.navbar')

<style>
    /* Styles pour la modal de notifications */
    /* Style pour les toasts */
.toast {
    position: fixed;
    bottom: 20px;
    right: 20px;
    padding: 10px 20px;
    border-radius: 5px;
    color: white;
    z-index: 1001;
    opacity: 0.9;
    transition: opacity 0.3s;
}

.toast.success {
    background-color: #48bb78;
}

.toast.error {
    background-color: #f56565;
}



    .notification-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        z-index: 1000;
        overflow-y: auto;
    }

    .notification-modal-content {
        background-color: #2A4B67;
        margin: 5% auto;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        width: 80%;
        max-width: 800px;
        color: white;
        position: relative;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .close-modal {
        position: absolute;
        top: 20px;
        right: 25px;
        font-size: 28px;
        font-weight: bold;
        color: #F4A261;
        cursor: pointer;
        transition: color 0.3s;
    }

    .close-modal:hover {
        color: #E76F51;
    }

    .notification-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid rgba(244, 162, 97, 0.3);
    }

    .notification-header h3 {
        color: #F4A261;
        font-size: 24px;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .notification-header h3 i {
        font-size: 26px;
    }

    .notification-count-badge {
        background-color: #E76F51;
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: bold;
    }

    .notification-tabs {
        display: flex;
        margin-bottom: 25px;
        border-bottom: 1px solid rgba(244, 162, 97, 0.3);
    }

    .notification-tab {
        padding: 12px 25px;
        cursor: pointer;
        border-bottom: 3px solid transparent;
        transition: all 0.3s;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.7);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .notification-tab.active {
        border-bottom: 3px solid #F4A261;
        color: #F4A261;
        font-weight: bold;
    }

    .notification-tab:hover:not(.active) {
        color: white;
        background-color: rgba(244, 162, 97, 0.1);
    }

    .notification-tab i {
        font-size: 18px;
    }

    .notification-content {
        display: none;
    }

    .notification-content.active {
        display: block;
    }

    .notification-item {
        display: flex;
        padding: 20px;
        margin-bottom: 15px;
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 8px;
        transition: all 0.3s;
        align-items: center;
        border-left: 4px solid #F4A261;
    }

    .notification-item:hover {
        background-color: rgba(0, 0, 0, 0.3);
        transform: translateX(5px);
    }

    .notification-icon {
        margin-right: 20px;
        font-size: 24px;
        color: #F4A261;
        min-width: 40px;
        text-align: center;
    }

    .notification-details {
        flex: 1;
    }

    .notification-details h4 {
        margin: 0 0 8px 0;
        color: #F4A261;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .notification-details h4 i {
        font-size: 16px;
    }

    .notification-details p {
        margin: 5px 0;
        font-size: 14px;
        color: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .notification-details p i {
        color: #887630;
        font-size: 14px;
        min-width: 18px;
    }

    .notification-actions {
        display: flex;
        gap: 10px;
        margin-left: 15px;
    }

    .mark-read-btn, .delete-btn {
        background: none;
        border: none;
        color: rgba(255, 255, 255, 0.6);
        cursor: pointer;
        font-size: 18px;
        transition: color 0.3s;
        padding: 8px;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .mark-read-btn:hover {
        color: #48bb78;
        background-color: rgba(72, 187, 120, 0.1);
    }

    .delete-btn:hover {
        color: #f56565;
        background-color: rgba(245, 101, 101, 0.1);
    }

    .no-notifications {
        text-align: center;
        padding: 40px 20px;
        color: rgba(255, 255, 255, 0.7);
    }

    .no-notifications i {
        font-size: 50px;
        margin-bottom: 20px;
        color: rgba(244, 162, 97, 0.5);
    }

    .no-notifications p {
        font-size: 16px;
        margin: 0;
    }

    /* Styles pour le tableau dans la modal */
    .notification-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .notification-table th, .notification-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid rgba(244, 162, 97, 0.2);
    }

    .notification-table th {
        background-color: rgba(0, 0, 0, 0.2);
        color: #F4A261;
        font-weight: 500;
    }

    .notification-table tr:hover {
        background-color: rgba(0, 0, 0, 0.1);
    }

    .notification-table td {
        color: rgba(255, 255, 255, 0.9);
        vertical-align: middle;
    }

    .notification-table td i {
        color: #887630;
        margin-right: 8px;
    }

    .agent-name {
        display: flex;
        align-items: center;
    }

    .agent-name i {
        font-size: 10px;
        margin-right: 8px;
        color: inherit;
    }

    /* Animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-notification {
        animation: fadeIn 0.5s ease-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .notification-modal-content {
            width: 95%;
            padding: 20px;
        }
        
        .notification-item {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .notification-actions {
            margin-left: 0;
            margin-top: 15px;
            align-self: flex-end;
        }
        
        .notification-tabs {
            flex-direction: column;
            border-bottom: none;
        }
        
        .notification-tab {
            border-bottom: none;
            border-left: 3px solid transparent;
            padding: 10px 15px;
        }
        
        .notification-tab.active {
            border-bottom: none;
            border-left: 3px solid #F4A261;
        }
    }
</style>

<div class="dashboard">
    <div class="main-content">
        <div class="header animate__animated animate__fadeInDown">
            <div class="logo-container">
                <h2>Bonjour, {{ Auth::user()->name }} !</h2>
            </div>

            <button class="notification-btn" id="notificationBtn">
                <i class="fas fa-bell"></i> Notifications
                @if($unreadNotifications->count() > 0)
                    <span class="notification-count">{{ $unreadNotifications->count() }}</span>
                @else
                    <span class="notification-count">0</span>
                @endif
            </button>
        </div>

        <div class="options animate__animated animate__fadeInUp animate__delay-1s">
            <a href="{{ route('responsable_finance.ressouces_humaines') }}" class="option">
                <i class="fas fa-users"></i>
                <h3>Gestion des Ressources Humaines</h3>
            </a>
            <a href="{{ route('responsable_finance.suivi-factures-achats') }}" class="option">
                <i class="fas fa-coins"></i>
                <h3>Achats en importation</h3>
            </a>
            @if(Auth::user()->role === 'responsable_finance')
                <a href="{{ route('admin_assurance.types') }}" class="option">
                    <i class="fas fa-file-medical"></i>
                    <h3>Gestion des Assurances</h3>
                </a>
            @endif
        </div>
    </div>

    <!-- Modal Notifications -->
    <div class="notification-modal" id="notificationModal">
        <div class="notification-modal-content animate-notification">
            <span class="close-modal" id="closeModal">×</span>
            
            <div class="notification-header">
                <h3><i class="fas fa-bell"></i> Notifications</h3>
                <div class="notification-count-badge">
                    {{ $unreadNotifications->count() }} non lue(s)
                </div>
            </div>
            
            <div class="notification-tabs">
                <div class="notification-tab active" data-tab="unread">
                    <i class="fas fa-envelope"></i> Non lues
                </div>
                <div class="notification-tab" data-tab="all">
                    <i class="fas fa-inbox"></i> Toutes
                </div>
                <div class="notification-tab" data-tab="archived">
                    <i class="fas fa-archive"></i> Archivées
                </div>
            </div>
            
            <div class="notification-content active" id="unread-notifications">
                @if($unreadNotifications->count() > 0)
                    @foreach ($unreadNotifications as $notification)
                        <div class="notification-item" data-notification-id="{{ $notification->id }}">
                            <div class="notification-icon">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </div>
                            <div class="notification-details">
                                <h4><i class="fas fa-exclamation-circle"></i> Nouvelle Demande</h4>
                                <p><i class="fas fa-file-alt"></i> <strong>Facture:</strong> {{ $notification->data['facture_number'] ?? 'N/A' }}</p>
                                <p><i class="fas fa-truck"></i> <strong>Fournisseur:</strong> {{ $notification->data['fournisseur'] ?? 'N/A' }}</p>
                                <p><i class="fas fa-calendar-day"></i> <strong>Date:</strong> {{ \Carbon\Carbon::parse($notification->data['date_demande'] ?? now())->format('d/m/Y H:i') }}</p>
                                <p><i class="fas fa-user-tie"></i> <strong>Agent:</strong> {{ $notification->data['transit_agent_name'] ?? 'N/A' }}</p>
                            </div>
                            <div class="notification-actions">
                                <button class="mark-read-btn" data-notification-id="{{ $notification->id }}" title="Marquer comme lu">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="delete-btn" data-notification-id="{{ $notification->id }}" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="no-notifications">
                        <i class="fas fa-bell-slash"></i>
                        <p>Aucune notification non lue</p>
                    </div>
                @endif
            </div>
            
            <div class="notification-content" id="all-notifications">
                @if($allNotifications->count() > 0)
                    <table class="notification-table">
                        <thead>
                            <tr>
                                <th><i class="fas fa-bell"></i> Type</th>
                                <th><i class="fas fa-file-invoice"></i> Facture</th>
                                <th><i class="fas fa-truck"></i> Fournisseur</th>
                                <th><i class="fas fa-calendar-alt"></i> Date</th>
                                <th><i class="fas fa-user-tie"></i> Agent</th>
                                <th><i class="fas fa-cog"></i> Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allNotifications as $notification)
                                <tr>
                                    <td><i class="fas fa-file-invoice-dollar"></i> {{ class_basename($notification->type) }}</td>
                                    <td>{{ $notification->data['facture_number'] ?? 'N/A' }}</td>
                                    <td>{{ $notification->data['fournisseur'] ?? 'N/A' }}</td>
                                    <td><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($notification->data['date_demande'] ?? now())->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span class="agent-name" style="color: {{ $notification->data['transit_agent'] ? sprintf('#%06X', crc32($notification->data['transit_agent']) & 0xFFFFFF) : '#ffffff' }};">
                                            <i class="fas fa-circle"></i>
                                            {{ $notification->data['transit_agent_name'] ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="delete-btn" data-notification-id="{{ $notification->id }}" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="no-notifications">
                        <i class="fas fa-inbox"></i>
                        <p>Aucune notification</p>
                    </div>
                @endif
            </div>
    
            <div class="notification-content" id="archived-notifications">
                <div class="no-notifications">
                    <i class="fas fa-archive"></i>
                    <p>Aucune notification archivée</p>
                </div>
            </div>
        </div>
    </div>
    
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('notificationModal');
        const openBtn = document.getElementById('notificationBtn');
        const closeBtn = document.getElementById('closeModal');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Fonction showToast définie en premier pour être accessible partout
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            toast.textContent = message;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }

        // Gestion du modal
        if (openBtn) {
            openBtn.addEventListener('click', () => {
                modal.style.display = 'block';
                document.body.style.overflow = 'hidden';
            });
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            });
        }

        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });

        // Gestion des onglets
        document.querySelectorAll('.notification-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.notification-tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.notification-content').forEach(c => c.classList.remove('active'));
                this.classList.add('active');
                document.getElementById(this.dataset.tab + '-notifications').classList.add('active');
            });
        });

        // Gestion des actions
        document.addEventListener('click', async function(e) {
            // Marquer comme lu
            if (e.target.closest('.mark-read-btn')) {
                e.preventDefault();
                const btn = e.target.closest('.mark-read-btn');
                const notificationId = btn.dataset.notificationId;
                const notificationItem = btn.closest('.notification-item') || btn.closest('tr');
                
                try {
                    const response = await fetch(`/notifications/${notificationId}/mark-as-read`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    });
                    
                    if (!response.ok) {
                        throw new Error(`Erreur HTTP : ${response.status}`);
                    }
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        notificationItem.remove();
                        updateNotificationCount(data.unread_count);
                        showToast('Notification marquée comme lue');
                    } else {
                        showToast('Erreur : Notification non trouvée', 'error');
                    }
                } catch (error) {
                    console.error('Erreur lors de markAsRead:', error);
                    showToast(`Une erreur est survenue : ${error.message}`, 'error');
                }
            }
            
            // Supprimer
            if (e.target.closest('.delete-btn')) {
                e.preventDefault();
                if (!confirm('Voulez-vous vraiment supprimer cette notification ?')) return;
                
                const btn = e.target.closest('.delete-btn');
                const notificationId = btn.dataset.notificationId;
                const notificationItem = btn.closest('.notification-item') || btn.closest('tr');
                
                try {
                    const response = await fetch(`/notifications/${notificationId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    });
                    
                    if (!response.ok) {
                        throw new Error(`Erreur HTTP : ${response.status}`);
                    }
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        notificationItem.remove();
                        updateNotificationCount(data.unread_count);
                        showToast('Notification supprimée');
                    } else {
                        showToast('Erreur : Notification non trouvée', 'error');
                    }
                } catch (error) {
                    console.error('Erreur lors de destroy:', error);
                    showToast(`Une erreur est survenue : ${error.message}`, 'error');
                }
            }
        });

        // Fonction pour mettre à jour le compteur
        function updateNotificationCount(count) {
            const countElements = document.querySelectorAll('.notification-count, .notification-count-badge');
            countElements.forEach(el => {
                el.textContent = el.classList.contains('notification-count') ? count : `${count} non lue(s)`;
            });

            if (count === 0) {
                const unreadContainer = document.getElementById('unread-notifications');
                if (unreadContainer) {
                    unreadContainer.innerHTML = `
                        <div class="no-notifications">
                            <i class="fas fa-bell-slash"></i>
                            <p>Aucune notification non lue</p>
                        </div>
                    `;
                }
            }
        }
    });
</script>
