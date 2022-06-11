<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class DashboardController extends Controller
{
    public function index()
    {

        $online_users = collect(Cache::get('online-users'))->count();
        $counts = collect(DB::select( "SELECT 
        (SELECT COUNT('id') FROM users) as users"))->first();
        return view('dashboard', compact('online_users', 'counts'));
    }

    // users show
    public function users(User $model)
    {
        $model = $model;
        return view('admin.users.index', compact('model'));
    }
    // roles show
    public function roles(Role $model)
    {
        if (auth()->user()->cannot('viewAny', $model)) {
            abort(403);
        }
        $model = $model;
        return view('admin.roles.index', compact('model'));
    }
    // generate show
    public function generate()
    {
        abort_if(!auth()->user()->is_admin, 403);
        return view('admin.generate.index');
    }
    private function getCountInfluancers($request)
    {
        return $this->filter($request, (new User()))->count();
    }

    private function filter($request, $model)
    {

        return $model->where(function ($query) use ($request) {

            // Search Users by Created Dates
            if ($request->from)
                $query->whereDate('created_at', '>=', $request->from);

            if ($request->to)
                $query->whereDate('created_at', '<=', $request->to);

        });
    }
}
