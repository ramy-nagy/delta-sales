<x-app-layout>
    @section('title', trans('Roles'))
    @section('h1', trans('Roles'))
    <div class="page-body">
        <div class="container-xl">
            @livewire('admin.roles', ['model' => $model, 'view' => 'roles'])
        </div>
    </div>

</x-app-layout>