<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    //
    public function index(Request $request) {
        if(!empty($request->query('search'))){
            $roles = Role::where('name','LIKE',$request->query('search').'%')->simplePaginate(10);
        }else{
            $roles = Role::simplePaginate(10);
        }
        
        return view('dashboard.roles.roles',['roles' => $roles]);
    }

    public function create(){
        $form = [
            'action' => route('roles_save')
        ];
        return view('dashboard.roles.form',['form' => $form]);
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
        $form = [
            'action' => route('roles_update'),
            'edit' => true
        ];
        return view('dashboard.roles.form',['form' => $form,'role'=>$role]);
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
