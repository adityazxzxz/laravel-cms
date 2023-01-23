@extends('cms.layouts.main')
@section('content')
<div class="container-fluid p-0">
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Update User</h1>
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
                    <form method="post" action="{{ route('users.store').'/'.$user->id }}" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Name</label>
                            <input type="text" value="{{ old('name',$user->name)}}" class="form-control @error('name') is-invalid @enderror" name="name">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email</label>
                            <input type="email" value="{{ old('email',$user->email)}}" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="example@email.com">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Re-type password confirmation</label>
                            <input name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" aria-describedby="password_confirmation">
                            @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Role</label>
                            <select name="role" class="form-select mb-3 @error('role') is-invalid @enderror">
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                <option @if($userrole[0]==$role->name) selected @endif value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('role')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Profil Picture</label>
                            <input type="hidden" name="oldImage" value="{{ $user->image }}">
                            @if($user->image)
                            <img src="{{ asset('storage/'.$user->image) }}" class="img-preview img-fluid mb-3 col-sm-5 d-block">
                            @endif
                            <img class="img-preview img-fluid mb-3 col-sm-5">
                            <input name="image" id="image" class="form-control @error('image') is-invalid @enderror" type="file" onchange="previewImage()">
                            @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
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
<script>
    function previewImage() {
        const image = document.querySelector('#image');
        const imgPreview = document.querySelector('.img-preview');

        imgPreview.style.display = 'block';

        const oFReader = new FileReader()
        oFReader.readAsDataURL(image.files[0]);
        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }
</script>
@endsection