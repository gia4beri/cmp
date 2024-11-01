<?php

namespace App\Http\Controllers;

use App\Http\Requests\StaffRequest;
use App\Models\UserModel;
use App\Models\RoleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class StaffController extends Controller
{
    private function getUserData()
    {
        if (Auth::check()) {
            return Auth::user();
        } else {
            return redirect('/');
        }
    }

    public function index()
    {
        return view('staff', [
                'title' => 'პერსონალი',
                'user' => $this->getUserData(),
                'users' => UserModel::select('users.id as user_id', 'roles.description as role_description', 'users.*')
                    ->join('roles', 'users.role', '=', 'roles.slug')
                    ->where('username', '!=', 'admin')
                    ->where('role', '!=', 'user')
                    ->simplePaginate(30),
                'roles' => RoleModel::all()
            ]);
    }

    public function updateView(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|numeric|exists:users,id'
        ]);

        return view('staff', [
            'title' => 'პერსონალი',
            'user' => $this->getUserData(),
            'users' => UserModel::select('users.id as user_id', 'roles.description as role_description', 'users.*')
                ->join('roles', 'users.role', '=', 'roles.slug')
                ->where('username', '!=', 'admin')
                ->where('role', '!=', 'user')
                ->where('users.id', $validated['user_id'])
                ->simplePaginate(30),
            'roles' => RoleModel::all(),
            'update' => true
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'username' => 'required|string',
            'password' => 'nullable|string',
            'email' => 'email|nullable',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|numeric',
            'proficiency' => 'string|nullable',
            'consultation_price' => 'numeric|nullable',
            'role' => 'required|in:admin,reception,doctor'
        ]);

        $user = new UserModel();
        $user->updateStaff($validated);

        return redirect('/dashboard/staff');
    }

    public  function search(Request $request)
    {
        $search = $request->validate([
            'staff_search' => 'required|string'
        ]);

        return view('staff', [
            'title' => 'პერსონალი',
            'user' => $this->getUserData(),
            'users' => UserModel::join('roles', 'users.role', '=', 'roles.slug')
                ->where('username', '!=', 'admin')
                ->where('role', '!=', 'user')
                ->where(function ($query) use ($search){
                    $query->orWhere('first_name', 'like', '%'.$search['staff_search'].'%')
                        ->orWhere('last_name', 'like', '%'.$search['staff_search'].'%')
                        ->orWhere('phone', 'like', '%'.$search['staff_search'].'%')
                        ->orWhere('email', 'like', '%'.$search['staff_search'].'%')
                        ->orWhere('proficiency', 'like', '%'.$search['staff_search'].'%')
                        ->orWhere('description', 'like', '%'.$search['staff_search'].'%');
                })->simplePaginate(30),
            'roles' => RoleModel::all()
        ]);
    }

    public function create(StaffRequest $request)
    {
        $validated = $request->validated();
        $user = new UserModel();
        $user->createStaff($validated);

        return redirect('/dashboard/staff');
    }

    public function delete(Request $request)
    {
        $delete = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ]);
        $user = new UserModel();
        $user->remove($delete['user_id']);

        return redirect('/dashboard/staff');
    }
}
