@extends('layouts.base')
<style>
.custom-control-label::before, 
.custom-control-label::after {
top: .8rem;
width: 1.25rem;
height: 1.25rem;
}
</style>

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
            <form method="post" action="{{$form['action']}}">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-6">
                        @if(!empty($form['edit']))
                            <input type="hidden" name="id" value="{{$role->id}}">
                        @endif
                        <label for="inputrole">Role Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputrole" placeholder="Role name" name="name" value="{{$role->name ?? old('name')}}">
                        @error('name')
                        <small id="passwordHelp" class="text-danger">
                        {{ $message }}
                        </small>
                        @enderror
                    </div>

                </div>
                <div class="row mt-5 mb-5">
                <div class="col-sm-6">
                    
                    <!-- checkbox -->
                    <h5>Permissions</h5>
                    @foreach($permissions as $permission)
                        
                        <div class="icheck-success">
                        <input type="checkbox" @if($permission_role) @if(in_array($permission->id,$permission_role)) checked @endif @endif id="permission-{{$permission->id}}" name="permissions[]" value="{{$permission->name}}">
                        <label for="permission-{{$permission->id}}">
                        {{Str::upper($permission->name)}}
                        
                        </label>
                      </div>
                    @endforeach
                  </div>
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>

    </div>


</section>
<!-- /.content -->
@endsection