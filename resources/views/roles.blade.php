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
        <div class="row p-4">
            nice
        </div>
        <div class="row p-4">
        <table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Guard</th>
    </tr>
  </thead>
  <tbody>
    @foreach($roles as $role)
      <tr>
        <th scope="row">{{$loop->iteration}}</th>
        <td>{{$role->name}}</td>
        <td>{{$role->guard_name}}</td>
      </tr>
    @endforeach
  </tbody>
</table>
        </div>
      </div>

    </section>
    <!-- /.content -->
@endsection