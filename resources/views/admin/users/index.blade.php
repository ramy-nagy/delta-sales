<x-app-layout>
    @section('title', trans('Users'))
    @section('h1', trans('Users'))
    <div class="page-body">
        <div class="container-xl">
            @livewire('admin.users', ['model' => $model, 'view' => 'users'])
        </div>
    </div>

</x-app-layout>