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
            <form method="post" action="{{route('roles_save')}}">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputrole">Role Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputrole" placeholder="Role name" name="name" value="{{old('name')}}">
                        @error('name')
                        <small id="passwordHelp" class="text-danger">
                        {{ $message }}
                        </small>
                        @enderror
                    </div>

                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>

    </div>


</section>
<!-- /.content -->
@endsection