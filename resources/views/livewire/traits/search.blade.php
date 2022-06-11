{{-- Search --}}
<div class="card card-stacked my-2">
    <div class="card-status-bottom bg-primary"></div>
    <div class="card-body">
        <h3 class="card-title"><i class="bi bi-search"></i> {{ __('Search') }} ...</h3>
        <div class="row d-flex">
            <div class="col-md-2">
                <div class="mb-3">
                    <div class="form-label">{{ __('Search Column') }}</div>
                    <select class="form-select" wire:model="SearchInColumn">
                        @foreach ($this->Fillable as $fillable)
                            <option value="{{ $fillable }}">{{ __(ucfirst($fillable)) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label">{{ __(ucfirst($SearchInColumn)) }}</label>
                    <div class="input-icon mb-3">
                        <input type="text" wire:model.lazy="search" value="" class="form-control"
                            placeholder="Search…">
                        <span class="input-icon-addon">
                            <i class="bi bi-search"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label">{{ __('Date_From') }}</label>
                    <div class="input-icon">
                        <span class="input-icon-addon">
                            <i class="bi bi-calendar-date-fill"></i>
                        </span>
                        <input class="form-control" placeholder="Select a date"
                            wire:change="calendar_From($event.target.value)" name="calendar_from" id="calendar_from"
                            value="">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label">{{ __('Date_To') }}</label>
                    <div class="input-icon">
                        <span class="input-icon-addon">
                            <i class="bi bi-calendar-date-fill"></i>
                        </span>
                        <input class="form-control" placeholder="Select a date" wire:model.prevent="calendar_To"
                            name="calendar_to" id="calendar_to" value="">
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="mb-3">
                    <div class="form-label">{{ __('Created From') }}</div>
                    <select class="form-select" wire:model="DateFrom">
                        <option></option>
                        <option value="1">{{ __('Yesterday') }}</option>
                        <option value="7">{{ __('7 Days') }}</option>
                        <option value="30">{{ __('30 Days') }}</option>
                        <option value="60">{{ __('60 Days') }}</option>
                        <option value="90">{{ __('90 Days') }}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-1">
                <div class="mb-3">
                    <div class="form-label mb-3">{{ __('Today') }}</div>
                    <div class="mt-1">
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" wire:click="Today()"
                                @checked($Today)>
                            <span class="form-check-label">{{ __('Today') }}</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <div class="form-label mb-3">{{ __('Trashed') }}</div>
                    <div class="mt-1">
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="Trashed" wire:click="Only_Trashed()"
                                @checked($Only_Trashed)>
                            <span class="form-check-label">{{ __('Only Trashed') }}</span>
                        </label>
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="Trashed" wire:click="With_Trashed()"
                                @checked($With_Trashed)>
                            <span class="form-check-label">{{ __('With Trashed') }}</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="mb-3">
                    <div class="form-label">{{ __('Status') }}</div>
                    <select class="form-select">
                        <option></option>
                        {{-- @if (function_exists(STATUS()))
                            @foreach (STATUS() as $key => $value)
                                <option value="{{ $key }}">{{ $value[0] }}</option>
                            @endforeach
                        @endif --}}
                    </select>
                </div>
            </div>
            <div class="col-md-1 mt-4 d-flex">
                <div class="col"></div>
                <div class="">
                    <button wire:click.prevent="DateFromTo()"
                        class="btn btn-outline-primary ms-auto">{{ __('Search') }}</button>
                </div>
            </div>

        </div>
    </div>
</div>
