<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Role::query())
                ->addColumn('action', function ($role) {
                    $action = '<a href="roles/' . $role->id . '/edit" class="badge bg-success"><span data-feather="edit-2"></span></a>';
                    $action .= '<form action="/roles/' . $role->id . '" class="d-inline" method="post">
        ' . method_field("delete") . '
        ' . csrf_field() . '
        <button class="badge bg-danger border-0"><span data-feather="trash-2"></span></button>
    </form>';
                    if ($role->name != 'super') {
                        return $action;
                    }
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make();
        }
        return view('cms.pages.role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('cms.pages.role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'permissions' => 'required|array|min:1',
        ]);

        try {
            $role = Role::create(['name' => $validatedData['name']]);
            $role->givePermissionTo($validatedData['permissions']);
        } catch (RoleAlreadyExists $e) {
            return redirect()->back()->with('error', "Role " . $validatedData['name'] . " Already Exists");
        }

        return redirect('/roles')->with('success', 'Data has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findById($id);
        $permissions = Permission::all();
        return view('cms.pages.role.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if ($role->name == 'super') {
            return redirect('/roles')->with('error', "Role $role->name cannot be delete");
        }
        Role::where('id', $role->id)
            ->destroy($role);
        return redirect('/roles')->with('success', "Role $role->name has been deleted!");
    }
}
