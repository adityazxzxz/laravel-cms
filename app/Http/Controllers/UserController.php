<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->user()->can('read user') && !$request->user()->hasRole('super')) {
            return redirect('/dashboard')->with('error', 'No Permission');
        }
        if ($request->ajax()) {
            return DataTables::of(User::query())
                ->addColumn('action', function ($user) {
                    $action = '<a href="users/' . $user->id . '/edit" class="badge bg-success"><span data-feather="edit-2"></span></a>';
                    $action .= '<form action="/users/' . $user->id . '" class="d-inline" method="post">
        ' . method_field("delete") . '
        ' . csrf_field() . '
        <button class="badge bg-danger border-0"><span data-feather="trash-2"></span></button>
    </form>';
                    if (!$user->hasRole('super')) {
                        return $action;
                    }
                })
                ->addColumn('role', function ($user) {
                    return $user->roles->pluck('name')[0] ?? '';
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make();
        }
        return view('cms.pages.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!$request->user()->can('create user') && !$request->user()->hasRole('super')) {
            return redirect('/dashboard')->with('error', 'No Permission');
        }
        $roles = Role::where('name', '!=', 'super')->get();
        return view('cms.pages.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->user()->can('create user') && !$request->user()->hasRole('super')) {
            return redirect('/dashboard')->with('error', 'No Permission');
        }
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'role' => 'required',
            'image' => 'image|file|max:1024',
        ]);

        if ($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('profile-image');
        }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $validatedData['image']
        ]);

        $user->assignRole($request->role);



        return redirect('/users')->with('success', 'User has been added!');
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
    public function edit(Request $request, User $user)
    {
        if (!$request->user()->can('edit user') && !$request->user()->hasRole('super')) {
            return redirect('/dashboard')->with('error', 'No Permission');
        }
        $userrole = $user->getRoleNames();
        $roles = Role::where('name', '!=', 'super')->get();
        return view('cms.pages.user.edit', compact('user', 'roles', 'userrole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if (!$request->user()->can('edit user') && !$request->user()->hasRole('super')) {
            return redirect('/dashboard')->with('error', 'No Permission');
        }
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'image' => 'image|file|max:1024',
        ];


        if ($request->password) {
            $rules['password'] = 'required|confirmed|min:6';
        }

        $validatedData = $request->validate($rules);
        if ($request->password) {
            $validatedData['password'] = Hash::make($request->password);
        }

        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['image'] = $request->file('image')->store('profile-image');
        }

        try {
            User::where('id', $user->id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'image' => $validatedData['image']
            ]);
            $user->assignRole($request->role);
        } catch (QueryException $e) {
            Log::error('Error update user ' . $e);
            return redirect()->back()->with('error', 'Failed!');
        }

        return redirect('/users')->with('success', $user->email . ' has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        if (!$request->user()->can('delete user') && !$request->user()->hasRole('super')) {
            return redirect('/dashboard')->with('error', 'No Permission');
        }
        User::where('id', $user->id)->delete();
        return redirect('/users')->with('success', $user->email . ' has been deleted');
    }
}
