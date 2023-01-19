@extends('cms.layouts.main')
@section('content')
<div class="container-fluid p-0">
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Update Permission</h1>
    </div>
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('permissions.store').'/'.$permission->id  }}">
                        @method('put')
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Guard Name</label>
                            <input value="{{ $permission->name }}" type=" text" class="form-control" name="name" placeholder="ex: create user">
                            <div id="emailHelp" class="form-text">Guard name perlu disesuaikan dengan middleware yg tersedia.</div>
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