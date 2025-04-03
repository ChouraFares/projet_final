@extends('layouts.app')

@section('title', 'Transit Dashboard')

@include('components.navbar')

<div class="dashboard">
    <div class="main-content">
        <div class="header animate__animated animate__fadeInDown">
            <div class="logo-container">
                <img src="{{ asset('images/bk-food.png') }}" alt="BK FOOD Logo" class="logo">
                <h2>Bonjour, {{ Auth::user()->name }} !</h2>
            </div>

     
        </div>

        <div class="options animate__animated animate__fadeInUp animate__delay-1s">
            <a href="{{ route('RessourcesHumaines_transit_achat_agent') }}" class="option">
                <i class="fas fa-users"></i>
                <h3>Gestion Des Ressources Humaines</h3>
            </a>
            <a href="{{ route('transit-achat.suivi-factures') }}" class="option">
                <i class="fas fa-file-invoice-dollar"></i>
                <h3>Achats en importation</h3>
            </a>
        </div>
    </div>

    <!-- Modal Container -->
    <div class="notification-modal" id="notificationModal">
        <div class="notification-modal-content animate__animated animate__zoomIn">
            <span class="close-modal" id="closeModal">&times;</span>
            <h3>Notifications</h3>
       
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.getElementById('notificationBtn').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('notificationModal').style.display = 'block';
    });

    document.getElementById('closeModal').addEventListener('click', function() {
        document.getElementById('notificationModal').style.display = 'none';
    });

    document.querySelectorAll('.mark-read-btn').forEach(button => {
        button.addEventListener('click', function() {
            const notificationId = this.getAttribute('data-notification-id');
            fetch(`/notifications/${notificationId}/mark-as-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelector(`.notification-item[data-notification-id="${notificationId}"]`).remove();
                    let countElement = document.querySelector('.notification-count');
                    let count = parseInt(countElement.textContent);
                    count--;
                    countElement.textContent = count;
                    if (count === 0) {
                        document.querySelector('.notification-modal-content').innerHTML = `
                            <span class="close-modal" id="closeModal">&times;</span>
                            <h3>Notifications</h3>
                            <div class="no-notifications">
                                <i class="fas fa-bell-slash"></i>
                                <p>Aucune notification non lue</p>
                            </div>
                        `;
                        document.getElementById('closeModal').addEventListener('click', function() {
                            document.getElementById('notificationModal').style.display = 'none';
                        });
                    }
                }
            });
        });
    });
</script>
@endsection
