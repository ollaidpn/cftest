@push('styles')
    <link href="{{ asset('assets/admin-formateurs/plugins/dropify/dist/css/dropify.min.css') }}" rel="stylesheet">
@endpush
<div>
    <div class="row">
        <div class="col-md-8" style="padding-left: 1.9rem !important;">
            <form wire:submit.prevent='storeModules'>
                <div class="form-group">
                    <label class="form-label">Titre du module</label>
                    <input type="text" wire:model.defer="section.module_title" name="name_title" class="form-control">
                    @error('module_title')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Titre de la section</label>
                    <input type="text" wire:model.defer="section.title" name="name_section" class="form-control">
                    @error('title')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Description de la section</label>
                    <textarea id="section_description" wire:model.defer="section.description" name="section_description" class="form-control" rows="3"></textarea>
                </div>
                @error('description')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group fallback w-100" wire:ignore>
                            <label class="form-label d-block">Vidéo</label>
                            <div
                                x-data="{ isUploading: false, progress: 0 }"
                                x-on:livewire-upload-start="isUploading = true"
                                x-on:livewire-upload-finish="isUploading = false"
                                x-on:livewire-upload-error="isUploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress"
                            >
                                <!-- File Input -->
                            <input type="file" wire:model.defer="section.video" accept="*" id="section-video" name="section_video" class="dropify">

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
                    <div class="col-md-6">
                        <div class="form-group fallback w-100" wire:ignore>
                            <label class="form-label d-block">Référence</label>
                            <div
                                x-data="{ isUploading: false, progress: 0 }"
                                x-on:livewire-upload-start="isUploading = true"
                                x-on:livewire-upload-finish="isUploading = false"
                                x-on:livewire-upload-error="isUploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress"
                            >
                                <!-- File Input -->
                            <input type="file" wire:model.defer="section.reference" multiple accept=".pdf, .docx, .pptx" id="section-reference" name="section_reference" class="dropify">

                                <!-- Progress Bar -->
                                <div x-show="isUploading">
                                    <progress max="100" x-bind:value="progress"></progress>
                                </div>
                            </div>
                        </div>
                        @error('reference')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Autre</label>
                    <textarea name="section_other" wire:model.defer="section.other" id="section_other" cols="30" class="form-control" placeholder="Autres informations" rows="10"></textarea>
                    @error('other')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group float-right">
                    <div wire:loading wire:target='storeModules' class="spinner-border" role="status">
                        <span class="sr-only">Chargement...</span>
                    </div>
                    <button type="submit" wire:loading.remove class="btn btn-success text-white">
                        Enregistrer
                    </button>
                    <button type="button" wire:loading.remove wire:click="selectTab('quizz')" class="btn btn-primary text-white">Suivant</button>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <strong>
                Architecture
            </strong>
            <div id="accordion1" class="mt-2">
                @if ($modules)
                    @foreach ($modules as $key => $module)
                        <div class="card">
                            <div class="card-header pt-2" id="headingOne{{ $key }}" style="background-color:#6C2B69;">
                                <h5 class="mb-0">
                                    <button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapseOne{{ $key }}" aria-expanded="true" aria-controls="collapseOne{{ $key }}">
                                    {{ $module->title ?? 'Module' }}
                                    </button>
                                </h5>
                            </div>

                            <div id="collapseOne{{ $key }}" class="collapse {{ $count_modules - 1 === $key ? 'show' : '' }}" aria-labelledby="headingOne{{ $key }}" data-parent="#accordion1">
                                <div class="card-body">
                                    @if ($module->sections)
                                        <ul>
                                            @foreach ($module->sections as $section)
                                                <li>{{ $section->title }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        Aucune section
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div>
                        Aucun module
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(function () {

            @this.on('scrollTop', function () {
                window.scrollTo({ top: 0, behavior: "smooth" });
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
            $('#section-video').dropify({
                messages: {
                    'default': 'Faites un glissé déposé ou cliquez',
                    'replace': 'Faites un glissé déposé ou cliquez pour remplacer',
                    'remove':  'Supprimer',
                    'error':   'Ficher trop lourd'
                }
            });

            $('#section-reference').dropify({
                messages: {
                    'default': 'Faites un glissé déposé ou cliquez',
                    'replace': 'Faites un glissé déposé ou cliquez pour remplacer',
                    'remove':  'Supprimer',
                    'error':   'Ficher trop lourd'
                }
            });

            @this.on('reset', function () {
                var section_video = $('#section-video').dropify();
                var section_reference = $('#section-reference').dropify();

                section_video = section_video.data('dropify');
                section_reference = section_reference.data('dropify');

                section_video.destroy();
                section_reference.destroy();
                section_video.init();
                section_reference.init();
            });

        });
    </script>
@endpush
