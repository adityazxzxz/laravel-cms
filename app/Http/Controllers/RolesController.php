<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    //
    public function index() {
        $roles = Role::simplePaginate(2);
        return view('dashboard.roles.roles',['roles' => $roles]);
    }

    public function create(){
        return view('dashboard.roles.form');
    }

    public function save(){
        return "nice";
    }
}
