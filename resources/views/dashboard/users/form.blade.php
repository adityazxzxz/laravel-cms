@extends('layouts.base')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Roles</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Roles Page</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="card ">
        @if(Session::has('error'))
        <div class="alert alert-danger">
            {{Session::get('error')}}
            @php
            Session::forget('error');
            @endphp
        </div>
        @endif
        <div class="card-body">
            <form method="post" action="{{$form['action']}}" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-6">
                        @if(!empty($form['edit']))
                        <input type="hidden" name="id" value="{{$user->id}}">
                        @endif
                        <div class="form-group">
                            <label for="inputrole">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputrole" placeholder="Name" name="name" value="{{$user->name ?? old('name')}}">
                            @error('name')
                            <small id="passwordHelp" class="text-danger">
                                {{ $message }}
                            </small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="inputrole">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="inputrole" placeholder="Name" name="email" value="{{$user->email ?? old('email')}}">
                            @error('email')
                            <small id="passwordHelp" class="text-danger">
                                {{ $message }}
                            </small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="inputrole">Password</label>
                            <input type="password" class="form-control @error('email') is-invalid @enderror" id="inputrole" placeholder="Name" name="password" value="">
                            @error('password')
                            <small id="passwordHelp" class="text-danger">
                                {{ $message }}
                            </small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="inputrole">Image</label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" id="inputimage" placeholder="Image" name="image" value="">
                            @error('image')
                            <small id="passwordHelp" class="text-danger">
                                {{ $message }}
                            </small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="inputrole">Role</label>
                            <select class="form-control" name="role" id="">
                                @foreach($roles as $role)
                                <option value="{{$role->name}}">{{$role->name}}</option>
                                @endforeach

                            </select>
                            @error('')
                            <small id="passwordHelp" class="text-danger">
                                {{ $message }}
                            </small>
                            @enderror
                        </div>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>

    </div>


</section>
<!-- /.content -->
@endsection