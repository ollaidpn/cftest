<div>
    <div class="row">
        <div class="card-body pb-0">
            <div class="row">
                <div class="col-md-6">
                    <form wire:submit.prevent={{ $goalAction }}>
                        <div class="form-group">
                            <label class="form-label">Objectif de la formation</label>
                            <input type="text" required wire:model.defer='goal.title_goal' class="form-control">
                            <small>Saisissez un objectif à la fois</small>
                            @error('title_goal')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                            <div class="form-group float-right mt-3">
                                <button type="submit" class="btn btn-block btn-success" style="color: white; font-weight:bold">Enregistrer</button>
                            </div>
                        </div>
                        @if ($goals)
                            @foreach ($goals as $goal)
                            <div class="align-items-center d-flex mb-2">
                                <a href="javascript:;" wire:click="editGoal({{ $goal->id }})" class="mr-3">{{ $goal->title }}</a>
                                <a href="javascript:;" wire:click="deleteGoal({{ $goal->id }})"><i class="la font-weight-bold text-danger la-trash" style="font-size: 24px;"></i></a>
                            </div>
                            @endforeach
                        @endif
                    </form>
                    <form wire:submit.prevent={{ $requirementAction }}>
                        <div class="form-group">
                            <label class="form-label">Prérequis</label>
                            <input type="text" required wire:model.defer='requirement.title_requirement' class="form-control">
                            <small>Saisissez une chose à la fois</small>
                            @error('title')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                            <div class="form-group float-right mt-3">
                                <button type="submit" class="btn btn-block btn-success" style="color: white; font-weight:bold">Enregistrer</button>
                            </div>
                        </div>
                        @if ($requirements)
                            @foreach ($requirements as $requirement)
                            <div class="align-items-center d-flex mb-2">
                                <a href="javascript:;" wire:click="editRequirement({{ $requirement->id }})" class="mr-3">{{ $requirement->title }}</a>
                                <a href="javascript:;" wire:click="deleteRequirement({{ $requirement->id }})"><i class="la font-weight-bold text-danger la-trash" style="font-size: 24px;"></i></a>
                            </div>
                            @endforeach
                        @endif
                    </form >
                    {{-- <form wire:submit.prevent={{ $targetedSkillAction }}>
                        <div class="form-group mb-5">
                            <label class="form-label">Compétences visées</label>
                            <input type="text" required wire:model.defer='targetedSkill.title_targetedSkill' class="form-control">
                            <small>Saisissez une compétence à la fois</small>
                            @error('title')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                            <div class="form-group float-right mt-3">
                                <button type="submit" class="btn btn-block btn-success" style="color: white; font-weight:bold">Enregistrer</button>
                            </div>
                        </div>
                    </form> --}}
                    <form wire:submit.prevent="updatePracticalInformations">
                        <div class="form-group">
                            <label class="form-label">Infos pratiques</label>
                            <textarea rows="6" required wire:model.defer='practical_informations' class="form-control">
                            </textarea>
                            @error('title')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                            <div class="form-group float-right mt-3">
                                <button type="button" wire:click='updatePracticalInformations' class="btn btn-block btn-success" style="color: white; font-weight:bold">Enregistrer</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <h4>Résumé</h4>
                    <h5 class="mb-2">Objectifs de la formation</h5>
                    @if (count($goals) > 0)
                        @foreach ($goals as $goal)
                        <div class="align-items-center d-flex mb-2">
                            <a href="javascript:;" wire:click.prevent="editGoal({{ $goal->id }})"><span class="checked-icon ml-4">&#10003; </span><span class="mr-3">{{ $goal->title }}</span></a>
                            <a href="javascript:;" wire:click.prevent="deleteGoal({{ $goal->id }})"><i class="la font-weight-bold text-danger la-trash" style="font-size: 24px;"></i></a>
                        </div>
                        @endforeach
                    @else
                        <div>
                            Aucun contenu
                        </div>
                    @endif

                    {{-- <h5 class="mb-2 mt-2">Compétences visées</h5>
                    @if (count($targetedSkills) > 0)
                        @foreach ($targetedSkills as $targetedSkill)
                        <div class="align-items-center d-flex mb-2">
                            <a href="javascript:;" wire:click.prevent="editTargetedSkill({{ $targetedSkill->id }})"><span class="checked-icon ml-4">&#10003; </span><span class="mr-3">{{ $targetedSkill->title ?? 'Pas de titre' }}</span></a>
                            <a href="javascript:;" wire:click.prevent="deleteTargetedSkill({{ $targetedSkill->id }})"><i class="la font-weight-bold text-danger la-trash" style="font-size: 24px;"></i></a>
                        </div>
                        @endforeach
                    @else
                        <div>
                            Aucun contenu
                        </div>
                    @endif --}}

                    <h5 class="mb-2 mt-2">Prérequis</h5>
                    @if (count($requirements) > 0)
                        @foreach ($requirements as $requirement)
                        <div class="align-items-center d-flex mb-2">
                            <a href="javascript:;" wire:click.prevent="editRequirement({{ $requirement->id }})"><span class="checked-icon ml-4">&#10003; </span><span class="mr-3">{{ $requirement->title ?? 'Pas de titre' }}</span></a>
                            <a href="javascript:;" wire:click.prevent="deleteRequirement({{ $requirement->id }})"><i class="la font-weight-bold text-danger la-trash" style="font-size: 24px;"></i></a>
                        </div>
                        @endforeach
                    @else
                        <div>
                            Aucun contenu
                        </div>
                    @endif

                    <h5 class="mb-2 mt-2">Infos pratiques</h5>
                    <div>{{ $practical_informations ?? '' }}</div>

                </div>
            </div>
            <div>
                <button type="button" wire:click="selectTab('modules')" class="btn btn-block btn-primary text-white mt-4" >Suivant</button>
            </div>
        </div>
    </div>
</div>


@section('script')
    <script>
        $(function () {

            @this.on('scrollTop', function () {
                window.scrollTo({ top: 0, behavior: "smooth" });
            });
            @this.on('test', function (value) {
                console.log('test', value);
            });
            @this.on('selectTab', function (value) {
                const doc = document.getElementById("index");
                var component = window.livewire.find(doc.getAttribute("wire:id"));
                console.log('module', value);
                component.set('selectedTab', value);
                window.scrollTo({ top: 0, behavior: "smooth" });
            });
        });
    </script>
@endsection
