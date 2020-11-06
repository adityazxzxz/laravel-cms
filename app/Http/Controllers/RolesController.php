<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    public function __construct(){
        $this->middleware(['permission:read role'])->only(['index']);
        $this->middleware(['permission:create role'])->only(['create','save']);
        $this->middleware(['permission:update role'])->only(['update','edit']);
        $this->middleware(['permission:delete role'])->only(['delete']);
    }
    public function index(Request $request) {
        if(!empty($request->query('search'))){
            $roles = Role::where('name','LIKE',$request->query('search').'%')->simplePaginate(10);
        }else{
            $roles = Role::simplePaginate(10);
        }
        
        return view('dashboard.roles.roles',['roles' => $roles]);
    }

    public function create(){
        $permissions = Permission::all();
        $form = [
            'action' => route('roles_save')
        ];
        return view('dashboard.roles.form',['form' => $form,'permissions' => $permissions]);
    }

    public function save(Request $request){
        $validateData = $request->validate([
            'name' => ['required']
        ]);
        $name = $request->input('name');
        $res = Role::firstOrCreate(
            ['name' => $name]
        );
        if($res->wasRecentlyCreated){
            return redirect()->route('roles')->with('success','Berhasil menyimpan role');
        }else{
            return back()->withErrors(['name' => 'Role already exists!'])->withInput();
        }
        
    }

    public function edit($id){
        $role = Role::find($id);
        $permissions = Permission::all();
        $permission_role = DB::table('role_has_permissions')->where('role_has_permissions.role_id',$id)->pluck('role_has_permissions.permission_id')->toArray();
        

        $form = [
            'action' => route('roles_update'),
            'edit' => true
        ];
        return view('dashboard.roles.form',['form' => $form,'role'=>$role,'permissions' => $permissions,'permission_role' => $permission_role]);
    }

    public function update(Request $request){
        $role = Role::find($request->input('id'));
        if($role->name === 'super-admin'){
            return redirect()->route('roles')->with('error','Cannot change super role!');
        }
        $role->name = $request->input('name');
        $role->save();
        $role->syncPermissions($request->input('permissions'));
        return redirect()->route('roles')->with('success','Role has been updated!');
    }

    
    public function delete(Request $request){
        $role = Role::find($request->role);
        $role->delete();
        if($role){
            return redirect()->route('roles')->with('success','Role has been deleted!');
        }else{
            return redirect()->route('roles')->with('error','Delete failed!');
        }
    }
}
