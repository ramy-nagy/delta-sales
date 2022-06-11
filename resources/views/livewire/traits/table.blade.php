<div class="card">
    <div wire:loading.delay.long class="spinner-border text-primary h2 " role="status"></div>
    <div class="card-status-bottom bg-primary"></div>
    <div class="card-header d-flex">
        <h3 class="card-title col text-uppercase">{{ __(ucfirst($view)) }} ( {{ $Model->total() ?? 0 }} )</h3>
        <div class="form-group  ">
            <div class="col-md-12">
                <select wire:model="entries" class="form-select col">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table card-table table-vcenter datatable  table-vcenter card-table table-striped">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll" wire:click="selectAll()"
                            class="form-check-input m-0 align-middle" aria-label="Select model">
                    </th>
                    @foreach ($this->Fillable as $fillable)
                        @if ($fillable != 'password')
                            <th>{{ __(ucfirst($fillable)) }}</th>
                        @endif
                    @endforeach
                    <th>{{ __('Created') }}</th>
                    <th colspan="2" class="text-center">{{ __('Actions') }}</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($Model as $key => $model)
                    <tr class="py-2">
                        <td>
                            <input type="checkbox" value="{{ $model->id }}" wire:model.defer="Ids"
                                class="form-check-input m-0 align-middle checkboxAll" aria-label="Select model">
                        </td>
                        @foreach ($this->Fillable as $fillable)
                            @if ($fillable != 'password')
                                @if ($fillable == 'status')
                                    @php
                                        $status_bg = $model->status == '1' ? 'green' : 'red';
                                        $status_name = $model->status == '1' ? 'active' : 'deactive';
                                    @endphp
                                    <td><span class="status status-{{ $status_bg ?? '' }}">
                                            <span class="status-dot"></span>
                                            {{ $status_name ?? '' }}</span>
                                        <button class="switch-icon switch-icon-slide-left"
                                            wire:click.prevent='switch("{{ $model->id }}")'
                                            data-bs-toggle="switch-icon">
                                            @if ($model->status == 0)
                                                <span class="switch-icon-a text-green">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-check" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M5 12l5 5l10 -10"></path>
                                                    </svg>
                                                </span>
                                                <span class="switch-icon-b text-red">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-x" width="24" height="24"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                                    </svg>
                                                </span>
                                            @else
                                                <span class="switch-icon-a text-red">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-x" width="24" height="24"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                                    </svg>
                                                </span>
                                                <span class="switch-icon-b text-green">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-check" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M5 12l5 5l10 -10"></path>
                                                    </svg>
                                                </span>
                                            @endif
                                        </button>
                                    </td>
                                @else
                                    <td>{{ $model[$fillable] ?? '' }}</td>
                                @endif
                            @endif
                        @endforeach
                        <td class="text-muted">
                            {{  date("Y-M-d", strtotime($model->created_at)) ?? '' }}
                        </td>
                        <td>
                            <button wire:click.prevent='edit("{{ $model->id }}")' class="btn btn-icon"
                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                data-bs-original-title="{{ __('Edit') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path
                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                    <path fill-rule="evenodd"
                                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                </svg>
                            </button>
                        </td>
                        <td>
                            @if ($model->deleted_at != null)
                                <button wire:click.prevent='restore("{{ $model->id }}")'
                                    class="btn btn-outline-green btn-icon" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" data-bs-original-title="{{ __('Restore') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z" />
                                        <path
                                            d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z" />
                                    </svg>
                                </button>
                            @else
                                <button onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                    wire:click.prevent='destroy("{{ $model->id }}")'
                                    class="btn btn-outline-danger btn-icon" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" data-bs-original-title="{{ __('Delete') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-trash" viewBox="0 0 16 16">
                                        <path
                                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                        <path fill-rule="evenodd"
                                            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                    </svg>
                                </button>
                            @endif

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center text-red" colspan="">{{ __('No Data Found') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <button onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click.prevent="deleteIDS()"
            class="btn btn-outline-danger my-2">{{ __('Delete') }} {{ __('All') }}</button>
        <button onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click.prevent="restoreIDS()"
            class="btn btn-outline-green my-2">{{ __('Restore') }} {{ __('All') }}</button>
    </div>
    <div class="card-footer d-flex align-items-center">
        <p class="m-0 text-muted">{{ __('Showing') }} <span>{{ $Model->firstItem() }}</span> {{ __('to') }}
            <span>{{ $Model->count() }}</span> {{ __('of') }}
            <span>{{ $Model->total() }}</span>
            {{ __('entries') }}
        </p>
        <ul class="pagination m-0 ms-auto">
            {{ $Model->links() }}
        </ul>
    </div>
    @push('scripts')
        <script>
            $("#selectAll").click(function() {
                $(".checkboxAll").prop('checked', $(this).prop('checked'));
            });
        </script>
    @endpush
</div>
