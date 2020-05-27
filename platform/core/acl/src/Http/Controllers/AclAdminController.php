<?php

namespace Core\Acl\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\User;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AclAdminController extends Controller
{
	public function index()
	{
		$admins   = Admin::all();
		$viewData = [
			'admins' => $admins
		];

		return view('acl::admin.index', $viewData);
	}

	public function create()
	{
		$roles    = Role::all();
		$viewData = [
			'roles' => $roles
		];

		return view('acl::admin.create', $viewData);
	}

	public function store(Request $request)
	{
		$admin           = new Admin();
		$admin->name     = $request->name;
		$admin->email    = $request->email;
		$admin->password = bcrypt('123456789');
		$admin->phone    = $request->phone;
		$admin->save();

		if ($roles = $request->roles) {
			foreach ($roles as $role) {
				$admin->assignRole($role);
			}
		}

		return redirect()->back();
	}

	public function edit($id)
	{
		$admin     = Admin::findOrFail($id);
		$roles     = Role::all();
		$roles_old = $admin->roles()->pluck('id')->toArray();

		$viewData = [
			'admin'     => $admin,
			'roles'     => $roles,
			'roles_old' => $roles_old ?? []
		];

		return view('acl::admin.update', $viewData);
	}

	public function update(Request $request, $id)
	{
		$admin        = Admin::findOrFail($id);
		$admin->name  = $request->name;
		$admin->email = $request->email;
		$admin->phone = $request->phone;

		$hashids     = new Hashids('', 20, config('setting._token'));
		$slug        = $hashids->encode($admin->id);
		$admin->slug = $slug;
		$admin->save();

		$roles = $request->roles;

		if (isset($roles)) {
			$admin->roles()->sync($roles);  //If one or more role is selected associate user to roles
		} else {
			$admin->roles()->detach(); //If no role is selected remove exisiting role associated to a user
		}

		return redirect()->back();
	}

	public function delete($id)
	{
		Admin::findOrFail($id)->delete();
		return redirect()->back();
	}

	public function changeStatus($id)
	{
		$admin = Admin::find($id);
		$admin->status = $admin->status == 1 ? -1 : 1;
		$admin->save();

		return redirect()->back();
	}
}