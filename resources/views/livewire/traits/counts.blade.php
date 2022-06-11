<div class="row my-3">
    {{-- CountStatus --}}
    @if (Schema::hasColumn($view, 'status'))
        @foreach ($model->Sub7Days()->CountStatus()->first()->toArray()
    as $key => $value)
            <div class="col-md-6 col-xl-3 my-3">
                <div class="card card-sm">
                    <div class="card-status-bottom bg-primary"></div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-blue-lt avatar">
                                    <i class="bi bi-circle"></i>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium ">
                                    <span class="h2 text-blue">
                                        {{ $value ?? 0 }}
                                    </span>
                                </div>
                                <div class="text-muted">
                                    <span class="text-white"> {{ $key ?? '' }}</span> last 7 days
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <hr>
    {{-- CountStatus --}}
    {{-- @foreach ($CountRoles as $key => $value)
    <div class="col-md-6 col-xl-3 mb-3">
        <div class="card card-sm">
            <div class="card-status-bottom bg-primary"></div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-blue-lt avatar">
                        <i class="bi bi-circle"></i>
                    </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium ">
                            <span class="h2 text-blue">
                                {{$value ?? 0}}
                            </span>
                        </div>
                        <div class="text-muted">
                            <span class="text-white"> {{$key ?? ''}}</span> last 7 days
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach --}}
    @if (Schema::hasColumn($view, 'deleted_at'))
        <div class="col-md-6 col-xl-3 mb-3">
            <div class="card card-sm">
                <div class="card-status-bottom bg-red"></div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-red-lt avatar">
                                <i class="bi bi-circle"></i>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium ">
                                <span class="h2 text-red">
                                    {{ $model->select('id')->onlyTrashed()->count('id') ?? 0 }}
                                </span>
                            </div>
                            <div class="text-muted">
                                <span class="text-white">deleted</span> last 7 days
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
