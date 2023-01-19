@extends('cms.layouts.main')
@section('content')
<div class="container-fluid p-0">
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Users Dashboard</h1>
    </div>
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-primary" href="peserta/create">Add User</a>
                </div>
                <div class="card-body">
                    <table id="myTable" class="display" style="width: 100%;margin-top:15px">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th class="d-none d-md-table-cell">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        var table = $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            "autoWidth": false,
            ajax: "{!! route('users.index') !!}",
            order: [
                [1, 'asc']
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'action',
                    name: 'action',
                    className: "d-none d-md-table-cell",
                    orderable: false,
                    searchable: false
                }
            ],
            drawCallback: function(settings) {
                feather.replace()
            }
        });

        $('#myTable').on('click', 'button', function(e) {
            e.preventDefault();
            var form = $(this).parents('form')
            Swal.fire({
                title: 'Do you want to delete this item?',
                showCancelButton: true,
                confirmButtonText: 'Delete',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    // return true
                    form.submit()
                    // Swal.fire('Saved!', '', 'success')
                }
            })
        });

        $.fn.dataTable.ext.errMode = 'none';

        $('#myTable')
            .on('error.dt', function(e, settings, techNote, message) {
                console.error(message)
                // window.location.reload()
            })
            .DataTable();
    });
</script>
@endsection