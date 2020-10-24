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
    <div class="card-body">
      <div class="row mb-4">
        <div class="col-md-6">
        <button class="btn btn-primary">Add Role</button>
        </div>
        <div class="col-md-6">
          <div style="text-align:right">
          <label style="text-align:left">Search
          <div style="display:inline-block"><input type="search" name="" id="" class="form-control form-control-sm"></div>
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
                <th class="col-9">Name</th>
                <th class="col-2">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($roles as $role)
              <tr class="d-flex">
                <th class="col-1">{{$loop->iteration}}</th>
                <td class="col-9">{{$role->name}}</td>
                <td class="col-2">
                  <div style="font-size:20px">
                  <i class="ion-edit pr-3"></i>
                  <i class="icon ion-ios-trash pr-3"></i>
                  <i class="icon ion-eye pr-3"></i>
                </div>
                </td>
              </tr>
              @endforeach

            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="ml-auto mr-5">
        {{$roles->links()}}
      </div>
    </div>

  </div>


</section>
<!-- /.content -->
@endsection