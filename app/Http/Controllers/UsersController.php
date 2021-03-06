<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    public function __construct(){
        $this->middleware(['permission:read user'])->only(['index']);
        $this->middleware(['permission:create user'])->only(['create','store']);
        $this->middleware(['permission:update user'])->only(['update','edit']);
        $this->middleware(['permission:delete user'])->only(['delete']);

        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $tmp = auth()->user();

        // dd($tmp->getAllPermissions()->pluck('name'));exit;
        if($request->query('search')){
            $users = User::where('name','LIKE',$request->query('search').'%')->orWhere('email','LIKE',$request->query('search').'%')->simplePaginate(10);
        }else{
            $users = User::simplePaginate(10);
        }
        return view('dashboard.users.users',['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = [
            'action' => route('user_save')
        ];

        $role = Role::all();


        return view('dashboard.users.form',['form' => $form,'roles' => $role]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $imageName = null;
        // if($request->hasFile('image')){
        //     if($request->file('image')->isValid()){
        //         $validated = $request->validate([
        //             'name' => 'string|max:40',
        //             'image' => 'mimes:jpeg,png|max:1014'
        //         ]);
        //         $extension = $request->image->extension();
        //         $request->image->storeAs('/public',$validated['name'].".".$extension);
        //         $url = Storage::url($validated['name'].".".$extension);
        //     }
        // }

        // $path = Storage::putFile('public/avatars',$request->file('image'));
        // echo asset('');exit;

        if($request->hasFile('image')){
            $imageName = Str::random(25).'.'.$request->image->extension();  
     
            $request->image->move(public_path('images/avatars'), $imageName);
        }

        $admin = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'avatar' => $imageName ?? null
        ]);

        $admin->assignRole($request->input('role'));
        return redirect()->route('users');
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
        //
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
    public function destroy($id)
    {
        //
    }

    public function delete(Request $request){
        $user = User::find($request->user);
        $user->delete();
        if($user){
            return redirect()->route('users')->with('success','User has been deleted!');
        }else{
            return redirect()->route('users')->with('error','Delete failed!');
        }
    }
}
