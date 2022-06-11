<div class="col-md-12 my-2">
    @include('livewire.traits.counts')

    @include('livewire.traits.search')
    @if ($updateMode)
        @include('livewire.traits.update')
    @else
        @include('livewire.traits.create')
    @endif
    @include('livewire.traits.table')
</div>
