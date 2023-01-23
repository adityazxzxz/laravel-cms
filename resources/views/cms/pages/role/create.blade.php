@extends('cms.layouts.main')
@section('content')
<div class="container-fluid p-0">
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Create Role</h1>
    </div>
    @if(session()->has('error'))
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="card" style="background-color:#f8d7da ;">

                <div class="card-body">
                    {{ session('error') }}
                </div>

            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('roles.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Role Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="ex: creator">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            @foreach($permissions as $permission)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission-{{ $permission->id }}">
                                <label for="permission-{{ $permission->id }}" class="form-check-label">{{ $permission->name }}</label>
                            </div>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
@endsection