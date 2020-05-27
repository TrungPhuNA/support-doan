<?php
namespace Core\Acl\Http\Controllers;

use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class AclRoleController
{
	public function index()
	{
		$roles = Role::all();
		$viewData = [
			'roles' => $roles
		];

		return view('acl::role.index', $viewData);
	}

	public function create()
	{
		$permissions = Permission::orderBy('group_permission','asc')->get();

		$group_permission = config('acl.group_permission') ?? [];
		$viewData = [
			'permissions' => $permissions,
			'group'       => $group_permission
		];

		return view('acl::role.create', $viewData);
	}

	public function store(Request $request)
	{
		$role              = new Role();
		$role->name        = $request->name;
		$role->guard_name  = $request->guard_name;
		$role->name_slug  = Str::slug($request->name);
		$role->description = $request->description;
		$role->save();

		if ($permissions = $request->permissions)
		{
			foreach ($permissions as $permission)
				$role->givePermissionTo($permission);
		}

		return redirect()->back();
	}

	public function edit($id)
	{
		$permissions = Permission::orderBy('group_permission','asc')->get();
		$role = Role::findOrFail($id);
		$permissions_active = $role->permissions()->pluck('id')->toArray();

		$viewData = [
			'permissions' => $permissions,
			'role'        => $role,
			'permissions_active' => $permissions_active ?? []
		];

		return view('acl::role.update', $viewData);
	}

	public function update(Request $request, $id)
	{
		$role              = Role::findOrFail($id);
		$role->name        = $request->name;
		$role->name_slug  = Str::slug($request->name);
		$role->guard_name  = $request->guard_name;
		$role->description = $request->description;
		$role->save();

		$allPermissions = Permission::all();//Get all permissions
		foreach ($allPermissions as $p) {
			$role->revokePermissionTo($p); //Remove all permissions associated with role
		}


		if ($permissions = $request->permissions)
		{
			foreach ($permissions as $permission)
				$role->givePermissionTo($permission);
		}

		return redirect()->back();

	}

	public function delete($id)
	{
		Role::findOrFail($id)->delete();
		return redirect()->back();
	}
}