@extends('layouts.app')

@section('title', 'Admin Transit Achat')
@include('components.navbar')


<div class="dashboard">
    <div class="header">
        <div class="logo-container">
            <img src="{{ asset('images/bk-food.png') }}" alt="BK FOOD Logo" class="logo">
        </div>
        <h2>Bonjour, {{ Auth::user()->name }} !</h2>

        <!-- Bouton Notifications -->
        <a href="{{ route('super_admin_transit.index') }}" class="notification-btn" id="notificationBtn">
            <i class="fas fa-bell"></i> Notifications
            @if($unreadNotifications->count() > 0)
                <span class="notification-count">{{ $unreadNotifications->count() }}</span>
            @else
                <span class="notification-count">0</span>
            @endif
        </a>
    </div>

    <div class="options">
        <a href="{{ route('super-admin-transit.RessourcesHumaines') }}" class="option">
            <i class="fas fa-users"></i>
            <h3>Ressources Humaines</h3>
        </a>
        <a href="{{ route('super-admin-transit.suivi-factures-achats') }}" class="option">
            <i class="fas fa-coins"></i>
            <h3>Achat Importer</h3>
        </a>
    </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
document.addEventListener('DOMContentLoaded', function () {
    const notificationBtn = document.getElementById('notificationBtn');
    const notificationModal = document.getElementById('notificationModal');
    const closeModal = document.getElementById('closeModal');

    if (!notificationBtn || !notificationModal || !closeModal) {
        console.error('Éléments manquants:', {
            btn: !!notificationBtn,
            modal: !!notificationModal,
            close: !!closeModal
        });
        return;
    }

    // Ouvrir le modal
    notificationBtn.addEventListener('click', function(event) {
        event.preventDefault();
        notificationModal.classList.add('active');
    });

    // Fermer le modal avec le bouton de fermeture
    closeModal.addEventListener('click', function() {
        notificationModal.classList.remove('active');
    });

    // Fermer le modal en cliquant à l’extérieur
    notificationModal.addEventListener('click', function(event) {
        if (event.target === notificationModal) {
            notificationModal.classList.remove('active');
        }
    });

    // Gestion des boutons "Marquer comme lu"
    document.querySelectorAll('.mark-read-btn').forEach(button => {
        button.addEventListener('click', function() {
            const notificationId = this.getAttribute('data-notification-id');
            fetch(`/notifications/${notificationId}/mark-as-read`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const item = this.closest('.notification-item');
                    item.remove();
                    const count = document.querySelectorAll('.notification-item').length;
                    document.querySelector('.notification-count').textContent = count;
                } else {
                    console.error('Échec du marquage');
                }
            })
            .catch(error => console.error('Erreur:', error));
        });
    });
});
</script>
