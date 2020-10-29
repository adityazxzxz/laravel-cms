@extends('layouts.base')

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Users</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Users Page</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card ">
    @if(Session::has('success'))
    <div class="alert alert-success">
      {{Session::get('success')}}
      @php
      Session::forget('success');
      @endphp
    </div>
    @endif
    <div class="card-body">
      <div class="row mb-4">
        <div class="col-md-6">
          <a class="btn btn-primary" href="{{url('users/create')}}">Add User</a>
        </div>
        <div class="col-md-6">
          <div style="text-align:right">
            <label style="text-align:left">Search
              <div style="display:inline-block">
                <form action="{{route('users')}}" method="get">
                  <input type="search" name="search" id="" class="form-control form-control-sm">
                </form>
              </div>
            </label>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <table class="table table-bordered table-hover">
            <thead>
              <tr class="d-flex">
                <th class="col-1">#</th>
                <th class="col-4">Name</th>
                <th class="col-4">Email</th>
                <th class="col-2">Role</th>
                <th class="col-1">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $user)
              <tr class="d-flex">
                <th class="col-1">{{$loop->iteration}}</th>
                <td class="col-4">{{$user->name}}</td>
                <td class="col-4">{{$user->email}}</td>
                <td class="col-2">{{$user->roles[0]->name ?? ''}}</td>
                <td class="col-1">
                  <div style="font-size:20px">
                    <a href="{{route('users')}}" onClick="delete_user('{{$user->id}}')"><i class="icon ion-trash-b pr-3"></i></a>
                    <i class="icon ion-eye pr-3"></i>
                  </div>
                </td>
              </tr>
              @endforeach

            </tbody>
          </table>
        </div>
      </div>
      <form id="user_delete_form" action="{{route('user_delete')}}" method="post">
        @csrf
        <input type="hidden" name="user" id="user_id">
      </form>
      <script>
        function delete_user(id) {
          event.preventDefault();
          var c = confirm('Are you sure?');
          if (c) {
            document.getElementById('user_id').value = id;
            document.getElementById('user_delete_form').submit();
          }
        }
      </script>
    </div>
    <div class="row">
      <div class="ml-auto mr-5">
        {{$users->links()}}
      </div>
    </div>

  </div>


</section>
<!-- /.content -->
@endsection