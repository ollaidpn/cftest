<div id="index">
    <!-- row -->
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>Modifier une formation</h4>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index-2.html">Admin</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0);">Formations</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0);">Modifier la formation</a></li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    <ul class="nav nav-pills mb-4">
                        <li class=" nav-item">
                            <a href="#details" class="nav-link tabs {{ $selectedTab === "details" ? 'active' : '' }}" data-toggle="tab" wire:click="selectTab('details')" aria-expanded="false"  style="font-weight:bold">Détails de la formation</a>
                        </li>
                        <li class="nav-item">
                            <a href="#about" class="nav-link tabs {{ $selectedTab === "about" ? 'active' : '' }}" data-toggle="tab" wire:click="selectTab('about')" aria-expanded="false"  style=" font-weight:bold">A Propos</a>
                        </li>
                        <li class="nav-item">
                            <a href="#modules" class="nav-link tabs {{ $selectedTab === "modules" ? 'active' : '' }}" data-toggle="tab" wire:click="selectTab('modules')" aria-expanded="false"  style=" font-weight:bold">Modules</a>
                        </li>
                        <li class="nav-item">
                            <a href="#quizz" class="nav-link tabs {{ $selectedTab === "quizz" ? 'active' : '' }}" data-toggle="tab" wire:click="selectTab('quizz')" aria-expanded="false"  style=" font-weight:bold">Quizz</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="details" class="tab-pane {{ $selectedTab === "details" ? 'active' : '' }}">
                            {{-- Details --}}
                                @livewire('update-formation.update-details', ['formation' => $formation])
                        </div>
                        <div id="about" class="tab-pane {{ $selectedTab === "about" ? 'active' : '' }}">
                            {{-- About --}}
                                @livewire('update-formation.update-about', ['formation' => $formation])
                        </div>
                        <div id="modules" class="tab-pane {{ $selectedTab === "modules" ? 'active' : '' }}">
                            {{-- Modules --}}
                                @livewire('update-formation.update-modules', ['formation' => $formation])
                        </div>
                        <div id="quizz" class="tab-pane {{ $selectedTab === "quizz" ? 'active' : '' }}">
                            {{-- Quizz --}}
                            @if ($selectedTab === "quizz")
                                @livewire('update-formation.update-quizz', ['formation' => $formation])
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@push('scripts')
    <script>
        $(function () {
            @this.on('success', function () {
                toastr.success('L\'enregistrement s\'effectué avec succès ! ', 'Enregistrement Validé');
            });
            @this.on('error', function () {
                toastr.error('Veuillez remplir correctement le formulaire !', 'Enregistrement Interrompu');
                alert('test');
            });
        });
    </script>
@endpush
