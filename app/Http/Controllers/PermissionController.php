<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->user()->can('read permission') && !$request->user()->hasRole('super')) {
            return redirect('/dashboard')->with('error', 'No Permission');
        }
        if ($request->ajax()) {
            return DataTables::of(Permission::query())
                ->addColumn('action', function ($permission) {
                    $action = '<a href="permissions/' . $permission->id . '/edit" class="badge bg-success"><span data-feather="edit-2"></span></a>';
                    $action .= '<form action="/permissions/' . $permission->id . '" class="d-inline" method="post">
        ' . method_field("delete") . '
        ' . csrf_field() . '
        <button class="badge bg-danger border-0"><span data-feather="trash-2"></span></button>
    </form>';
                    return $action;
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make();
        }
        return view('cms.pages.permission.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!$request->user()->can('create permission') && !$request->user()->hasRole('super')) {
            return redirect('/dashboard')->with('error', 'No Permission');
        }
        return view('cms.pages.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->user()->can('create permission') && !$request->user()->hasRole('super')) {
            return redirect('/dashboard')->with('error', 'No Permission');
        }
        $validatedData = $request->validate([
            'name' => 'required|unique'
        ]);
        Permission::create($validatedData);
        return redirect('/permissions')->with('success', 'Permission has been added');
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
    public function edit(Request $request, Permission $permission)
    {
        if (!$request->user()->can('edit permission') && !$request->user()->hasRole('super')) {
            return redirect('/dashboard')->with('error', 'No Permission');
        }
        return view('cms.pages.permission.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        if (!$request->user()->can('edit permission') && !$request->user()->hasRole('super')) {
            return redirect('/dashboard')->with('error', 'No Permission');
        }
        $validatedData = $request->validate([
            'name' => 'required|unique:permissions'
        ]);

        Permission::where('id', $permission->id)
            ->update($validatedData);
        return redirect('/permissions')->with('success', 'Data has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Permission $permission)
    {
        if (!$request->user()->can('delete permission') && !$request->user()->hasRole('super')) {
            return redirect('/dashboard')->with('error', 'No Permission');
        }
        Permission::destroy($permission->id);
        return redirect('/permissions')->with('success', "Permission $permission->name has been deleted!");
    }
}
