<div class="col-md-12 my-2">
    <div class="card">
        <div class="card-header d-flex">
            <h3 class="card-title col">{{__('Update')}}</h3>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="update()" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                @foreach ($this->Fillable as $fillable)
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label required">{{__(ucfirst($fillable))}}</label>
                            <input type="text" class="form-control" wire:model.defer="{{$fillable}}">
                            @error($fillable) <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-1 d-flex justify-content-between">
                    <button type="submit" class="btn btn-outline-success">{{__('Update')}}</button>
                    <button wire:click.prevent="cancel()" class="btn btn-outline-danger">{{__('Cancel')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>