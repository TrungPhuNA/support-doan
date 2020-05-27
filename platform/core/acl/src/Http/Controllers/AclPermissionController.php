<?php

namespace Core\Acl\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class AclPermissionController extends Controller
{
	public function index()
	{
		$permissions = Permission::orderBy('group_permission','asc')->get();

		$viewData = [
			'permissions' => $permissions
		];

		return view('acl::permission.index',$viewData);
	}

	public function create()
	{
		$group = $this->getGroupPermission();
		return view('acl::permission.create', compact('group'));
	}

	public function store(Request $request)
	{
		$permission                   = new Permission();
		$permission->name             = $request->name;
		$permission->description      = $request->description;
		$permission->group_permission = $request->group_permission;
		$permission->guard_name       = $request->guard_name;
		$permission->save();

		return redirect()->back();
	}

	public function edit($id)
	{
		$group      = $this->getGroupPermission();
		$permission = Permission::findOrFail($id);
		return view('acl::permission.update', compact('group', 'permission'));
	}

	public function update(Request $request, $id)
	{
		$permission                   = Permission::findOrFail($id);
		$permission->name             = $request->name;
		$permission->description      = $request->description;
		$permission->group_permission = $request->group_permission;
		$permission->guard_name       = $request->guard_name;
		$permission->save();
		return redirect()->back();
	}

	public function delete($id)
	{
		Permission::findOrFail($id)->delete();
		return redirect()->back();
	}

	private function getGroupPermission()
	{
		$group_permission = config('acl.group_permission') ?? [];
		return $group_permission;
	}
}