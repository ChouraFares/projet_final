<!-- Favicon HD (pour les écrans retina) -->
<link rel="icon" type="image/png" sizes="512x512" href="{{ asset('images/bk-food-hd.png') }}">

<!-- Favicon standard -->
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/bk-food-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/bk-food-16x16.png') }}">

<!-- Pour Safari/iOS -->
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/bk-food-180x180.png') }}">


<div class="navigation-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="btn-group-vertical w-100" role="group" aria-label="Assurance Navigation">
                    <!-- Bouton Assurance MRD -->
                    <a href="{{ route('admin.mrd.index') }}" class="btn btn-primary btn-block mb-2">Assurance MRD</a>

                    <!-- Bouton Assurance Flotte -->
                    <a href="{{ route('admin.assurance.flotte.bouttons') }}" class="btn btn-primary btn-block mb-2">Assurance Flotte</a>

                    <!-- Bouton Assurance Transport Maritime -->
                    <a href="{{ route('admin.assurance.Maritime.bouttons') }}" class="btn btn-primary btn-block mb-2">Assurance Transport Maritime</a>

                    <!-- Bouton Assurance Bris Des Machines -->
                    <a href="{{ route('admin.assurance.BrisDeMachines.bouttons') }}" class="btn btn-primary btn-block mb-2">Assurance Bris Des Machines</a>

                    <!-- Bouton Assurance Responsable Civil -->
                    <a href="{{ route('admin.assurance.ResponsableCivil.bouttons') }}" class="btn btn-primary btn-block mb-2">Assurance Responsable Civil</a>

                    <!-- Bouton Assurance Maladie -->
                    <a href="{{ route('admin.assurance.AssuranceMaladie.bouttons') }}" class="btn btn-primary btn-block mb-2">Assurance Maladie</a>

                    <!-- Bouton Assurance Retraite -->
                    <a href="{{ route('admin.assurance.AssuranceRetraite.bouttons') }}" class="btn btn-primary btn-block mb-2">Assurance Retraite</a>
                </div>
            </div>
        </div>
    </div>
</div>


