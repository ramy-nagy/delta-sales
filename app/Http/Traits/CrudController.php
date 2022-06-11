<?php

namespace App\Http\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use DB, Auth, Cache, Carbon\Carbon;
trait CrudController 
{

    public function index() 
    {
        $model = $this->model;
        return view($this->view_path .'.index', compact('model'));
    }

    public function create()  
    {
        $model = $this->model;
        return $this->view('create',compact('model'));
    }

    public function store(Request $request, array $array)
    {
        DB::beginTransaction();
        try {
            $inputs = $request->only($array);

            $create = $this->model::create($inputs);

            DB::commit();
            return redirect()->back()->with(['type'=>'success','message'=>"Created Successfully"]);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['type'=>'error','message'=>"Something Wrong"]);
        }
    }

    public function show($id) 
    {
        $model = $this->model::findOrFail($id);
        return view($this->view_path .'.show', compact('model'));

    }

    public function edit($id)
    {
        $model = $this->model::findOrFail($id);
        return $this->view('edit', compact('model'));
    }

    public function update(Request $request, $id, array $array) 
    {            
        DB::beginTransaction();
        try {
            $inputs = $request->only($array);
            $update = $this->model::whereId($id)->update($inputs);

            DB::commit();
            return redirect()->back()->with(['type'=>'success','message'=>"Created Successfully"]);

        } catch (\PDOException $e) {
            DB::rollback();
            return redirect()->back()->with(['type'=>'error','message'=>"Something Wrong".$e->errorInfo[2]]);
        }
    }

    public function destroy($id) 
    {
        $this->model::destroy($id);
    }

    public function onlineUsers() {
        // Get the array of users
        $users = Cache::get('online-users');
        if(!$users) return null;
        
        // Add the array to a collection so you can pluck the IDs
        $onlineUsers = collect($users);
        // Get all users by ID from the DB (1 very quick query)
        $dbUsers = User::find($onlineUsers->pluck('id')->toArray());
        
        // Prepare the return array
        $displayUsers = [];

        // Iterate over the retrieved DB users
        foreach ($dbUsers as $user){
            // Get the same user as this iteration from the cache
            // so that we can check the last activity.
            // firstWhere() is a Laravel collection method.
            $onlineUser = $onlineUsers->firstWhere('id', $user['id']) ;
            // Append the data to the return array
            $displayUsers[] = [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'photo' => $user->photo,
                // This Bool operation below, checks if the last activity
                // is older than 3 minutes and returns true or false,
                // so that if it's true you can change the status color to orange.
                'away' => $onlineUser['last_activity_at'] < now()->subMinutes(3),
            ];
        }
        return collect($displayUsers);
    }
}
