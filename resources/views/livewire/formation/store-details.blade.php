@push('styles')
        <link href="{{ asset('assets/admin-formateurs/plugins/dropify/dist/css/dropify.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/admin-formateurs/plugins/selectize-js/dist/css/selectize.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/admin-formateurs/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
@endpush

<div>

    <div class="row">
        <div class="card-body pb-0">
            <form wire:submit.prevent='storeDetails'>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Nom de la formation</label>
                            <input wire:loading.attr="disabled" type="text" required wire:model.defer='formation.title' class="form-control">
                            @error('title')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label class="form-label">Description de la formation</label>
                            <textarea wire:loading.attr="disabled" id="summernote" required wire:model.defer='formation.description' name="description" class="form-control" rows="10"></textarea>
                        </div>
                        @error('description')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- {{ $formation['description'] }} --}}
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group" wire:ignore>
                            <label class="form-label">Catégorie</label>
                            <select wire:loading.attr="disabled" id="categories" required wire:model.defer="formation.categories" placeholder="Selectionnez les catégories"></select>
                        </div>
                        @error('categories')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label class="form-label">Durée</label>
                            <input wire:loading.attr="disabled" type="number" required wire:model.defer="formation.nb_hours" class="form-control">
                            @error('nb_hours')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label class="form-label">Formateur</label>
                            <select wire:loading.attr="disabled" name="formateur" required wire:model.defer="formation.teacher" class="custom-select" >
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->first_name}} {{$teacher->last_name }}</option>
                                @endforeach

                            </select>
                            @error('teacher')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label class="form-label">Organisation</label>
                            <select wire:loading.attr="disabled" name="organization" wire:change="loadTeams(event.target.value)" wire:model.lazy="formation.organization" class="custom-select" >
                                <option>Aucune</option>
                                @foreach ($organizations as $organization)
                                    <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                                @endforeach
                            </select>
                            @error('organization')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group" >
                            <label class="form-label">Équipes</label>
                            <select id="teams" wire:model.lazy='formation.teams' name="teams[]" multiple="multiple">
                                @foreach ($teams as $team)
                                    <option value="{{ $team->id ?? '' }}">{{ $team->name ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="form-group">
                            <label class="form-label">Prix</label>
                            <input type="number" wire:loading.attr="disabled" required class="form-control" wire:model.defer="formation.price" name="price" id="price">
                            @error('price')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">Type de formation</label>
                            <select wire:loading.attr="disabled" name="formateur" wire:model.defer="formation.type" class="custom-select" >
                                <option value="private">Privé</option>
                                <option value="public">Publique</option>
                            </select>
                            @error('type')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group fallback w-100" wire:ignore>
                            <label class="form-label d-block">Photo couverture de la formation</label>
                            <div
                                x-data="{ isUploading: false, progress: 0 }"
                                x-on:livewire-upload-start="isUploading = true"
                                x-on:livewire-upload-finish="isUploading = false"
                                x-on:livewire-upload-error="isUploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress"
                            >
                                <!-- File Input -->
                                <input type="file" id="image" accept="image/*" required wire:model.defer="formation.image" class="dropify">

                                <!-- Progress Bar -->
                                <div x-show="isUploading">
                                    <progress max="100" x-bind:value="progress"></progress>
                                </div>
                            </div>
                        </div>
                        @error('image')
                                <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group fallback w-100" wire:ignore>
                            <label class="form-label d-block">Vidéo de présentation de la formation</label>
                            <div
                                x-data="{ isUploading: false, progress: 0 }"
                                x-on:livewire-upload-start="isUploading = true"
                                x-on:livewire-upload-finish="isUploading = false"
                                x-on:livewire-upload-error="isUploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress"
                            >
                                <!-- File Input -->
                                <input type="file" id="video" accept=".mp4" required wire:model.defer="formation.video" class="dropify">

                                <!-- Progress Bar -->
                                <div x-show="isUploading">
                                    <progress max="100" x-bind:value="progress"></progress>
                                </div>
                            </div>
                        </div>
                        @error('video')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12 d-flex justify-content-center">
                        <div wire:loading wire:target='storeDetails' class="spinner-border" role="status">
                            <span class="sr-only">Chargement...</span>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 mt-4">
                        <button wire:loading.remove type="submit" class="btn btn-block btn-primary" style="color: white; font-weight:bold">Enregistrer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@push('scripts')
    <script src="{{ asset('assets/admin-formateurs/plugins/selectize-js/dist/js/standalone/selectize.js') }}"></script>
    <script src="{{ asset('assets/admin-formateurs/plugins/select2/dist/js/select2.full.min.js') }}"></script>

    <script>
        document.addEventListener('livewire:load', function () {
            $('#teams').select2({placeholder: "Selectionnez une ou plusieurs équipes"});

            var categories = '{!! $categories !!}';

            var $select = $('#categories').selectize({
                    options: JSON.parse(categories),
                    create: false,
                    maxItems: null,
                    maxOptions: 100,
                    valueField: 'id',
                    labelField: 'title',
                    searchField: 'title',
                    sortField: 'title',
                    onChange: function (value) {
                        @this.set('formation.categories', value);
                    }
            });

            @this.on('scrollTop', function () {
                window.scrollTo({ top: 0, behavior: "smooth" });
            });

            @this.on('reloadSelect2', function () {
                $('#teams').select2({placeholder: "Selectionnez une ou plusieurs équipes"});
                $('#teams').on('change.select2', function (e) {
                    @this.set('formation.teams', $(this).val());
                });

            });

            @this.on('selectTab', function (value) {
                const doc = document.getElementById("index");
                var component = window.livewire.find(doc.getAttribute("wire:id"));

                component.set('selectedTab', value);
                window.scrollTo({ top: 0, behavior: "smooth" });
            });
        });
    </script>

    <script src="{{ asset('assets/admin-formateurs/plugins/dropify/dist/js/dropify.min.js') }}"> </script>
    <script>
        $(function () {
            $('#image').dropify({
                messages: {
                    'default': 'Faites un glissé déposé ou cliquez',
                    'replace': 'Faites un glissé déposé ou cliquez pour remplacer',
                    'remove':  'Supprimer',
                    'error':   'Ficher trop lourd'
                }
            });

            $('#video').dropify({
                messages: {
                    'default': 'Faites un glissé déposé ou cliquez',
                    'replace': 'Faites un glissé déposé ou cliquez pour remplacer',
                    'remove':  'Supprimer',
                    'error':   'Ficher trop lourd'
                }
            });
        });
    </script>

@endpush
