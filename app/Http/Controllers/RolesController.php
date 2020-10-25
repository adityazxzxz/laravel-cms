<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    //
    public function index() {
        $roles = Role::simplePaginate(10);
        return view('dashboard.roles.roles',['roles' => $roles]);
    }

    public function create(){
        return view('dashboard.roles.form');
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
            return back()->withInput()->with('error','Role sudah ada');
        }
        
    }
}
