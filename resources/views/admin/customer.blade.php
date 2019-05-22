@extends('admin.layouts.master')

@section('title', 'Customer')

@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Data Customer
            {{-- <small>advanced tables</small> --}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Data Customer</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Data Customer</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#addModal">Add</button>
                        <br>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    {{-- <th>Surname</th> --}}
                                    <th>Email</th>
                                    {{-- <th>Remember Token</th> --}}
                                    <th>Created At</th>
                                    {{-- <th>Status</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($users as $user)
                                <tr>
                                    <td>{{$user->id}}</td>
                                    <td>{{$user->name}}</td>
                                    {{-- <td>{{$user->surname}}</td> --}}
                                    <td>{{$user->email}}</td>
                                    {{-- <td>{{$user->remember_token}}</td> --}}
                                    <td>{{$user->created_at}}</td>
                                    {{-- <td>{{$user->status}}</td> --}}
                                    <td>
                                        <a href="" class="btn btn-success btn-sm">Active</a>
                                        <a href="" class="btn btn-warning btn-sm">Suspend</a>
                                        <button class="edit-modal btn btn-warning btn-sm" 
                                            data-toggle="modal"
                                            data-target="#editModal"
                                            data-id="{{ $user->id }}"
                                            data-name="{{ $user->name }}"
                                            data-email="{{ $user->email }}"
                                            {{-- data-kota="{{ $user->created_at }}" --}}
                                            {{-- data-negara="{{ $user->negara }}" --}}
                                            {{-- data-no_telp="{{ $user->no_telp }}" --}}
                                            {{-- data-status="{{ $user->status }}" --}}
                                            >
                                            Edit
                                        </button>
                                        <button class="delete-modal btn btn-danger btn-sm"
                                            data-toggle="modal" 
                                            data-target="#deleteModal"
                                            data-delete-id="{{ $user->id }}">Delete</button>
                                    </td>
                                </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- ./wrapper -->

<!-- Modal Add-->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form  action="/admin/customer/create" method="post">
                  {{csrf_field()}}
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" class="form-control" id="nama" aria-describedby="emailHelp"
                            placeholder="Nama" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Alamat">
                    </div>
                    <div class="form-group">
                        <label for="kota">Kota</label>
                        <input type="text" name="kota" class="form-control" id="kota" placeholder="Kota">
                    </div>
                    <div class="form-group">
                        <label for="negara">Negara</label>
                        <input type="text" name="negara" class="form-control" id="negara" placeholder="Negara">
                    </div>
                    <div class="form-group">
                        <label for="no_telp">No Telepon</label>
                        <input type="text" name="no_telp" class="form-control" id="no_telp" placeholder="No Telepon">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <input type="text" name="status" class="form-control" id="status" placeholder="Status">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit-->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="text" id="id-edit" hidden>
                    <div class="form-group">
                        <label for="nama-edit">Nama</label>
                        <input type="text" class="form-control" id="name-edit" aria-describedby="emailHelp"
                            placeholder="Nama" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="alamat-edit">Email</label>
                        <input type="text" class="form-control" id="email-edit" placeholder="Alamat">
                    </div>
                    {{-- <div class="form-group">
                        <label for="kota-edit">Kota</label>
                        <input type="text" class="form-control" id="kota-edit" placeholder="Kota">
                    </div>
                    <div class="form-group">
                        <label for="negara-edit">Negara</label>
                        <input type="text" class="form-control" id="negara-edit" placeholder="Negara">
                    </div>
                    <div class="form-group">
                        <label for="noTelp-edit">No Telepon</label>
                        <input type="text" class="form-control" id="noTelp-edit" placeholder="No Telepon">
                    </div>
                    <div class="form-group">
                        <label for="status-edit">Status</label>
                        <input type="text" class="form-control" id="status-edit" placeholder="Status">
                    </div> --}}
                </form>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                <button type="button" class="update btn btn-primary" data-dismiss="modal">Update</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Delete --}}
<div id="deleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delete</h4>
            </div>
            <div class="modal-body">
                <p>Sure you want to delete this data with ID : <strong><span id="del-id"></span></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="delete btn btn-danger" data-dismiss="modal">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- jQuery 3 -->
<script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- DataTables -->
<script src="{{asset('bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<!-- SlimScroll -->
<script src="{{asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('dist/js/demo.js')}}"></script>
<!-- page script -->
<script>
    $(function () {
        $('#example1').DataTable()
        $('#example2').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': false,
            'ordering': true,
            'info': true,
            'autoWidth': false
        })
    })

</script>
{{-- CRUD AJAX --}}
<script>
    $(document).ready(function() {
        $('.edit-modal').click(function() {
            $('#id-edit').val($(this).data('id'));
            $('#name-edit').val($(this).data('name'));
            $('#email-edit').val($(this).data('email'));
            // $('#kota-edit').val($(this).data('kota'));
            // $('#negara-edit').val($(this).data('negara'));
            // $('#noTelp-edit').val($(this).data('no_telp'));
            // $('#status-edit').val($(this).data('status'));
            // $('#editModal').modal('show');
        });
        $('.delete-modal').click(function() {
            $('#del-id').html($(this).data('delete-id'));
            // $('#modal-delete').modal('show');
        });
        $('.update').click(function() {
            $.ajax({
                url: '/admin-users/update',
                type: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': $('#token').attr('content')
                },
                data: {
                    'id': $('#id-edit').val(),
                    'name': $('#name-edit').val(),
                    'email': $('#email-edit').val()
                    // 'kota': $('#kota-edit').val(),
                    // 'negara': $('#negara-edit').val(),
                    // 'no_telp': $('#noTelp-edit').val(),
                    // 'status': $('#status-edit').val()
                },
                success: function(result) {
                    // $('.state' + result.id)
                    // .replaceWith(  
                    //     `<tr class="state${result.id}"> \
                    //         <td></td> \
                    //         <td>${result.name}</td> \
                    //         <td> \
                    //             <button class="edit-modal btn btn-warning" \
                    //                     data-id="${result.id}"  \
                    //                     data-name="${result.name}"> \
                    //                     Edit</button> \
                    //             <button class="delete-modal btn btn-danger" \
                    //                     data-delete-id="${result.id}"> \
                    //                     Delete</button> \
                    //         </td> \
                    //     </tr>`
                    // );
                    location.reload();
                }
                ,
                error: function(xhr, error) {
                    alert(error + ' : Name must not be empty');
                }
            });
        });
        $('.delete').click(function() {
            $.ajax({
                url: '/admin-users/destroy',
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('#token').attr('content')
                },
                data: {
                    'id': $('#del-id').html()
                },
                success: function(result) {
                    $('.state' + result.id).remove();
                    location.reload();
                },
                error: function(xhr, error) {
                    alert(error);
                }
            });
        });
    });
</script>
@endsection
