@extends('admin.layouts.master')

@section('title', 'Inventory')

@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Data Inventory
            {{-- <small>advanced tables</small> --}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Data Inventory</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Data Inventory</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#addModal">Add</button>
                        <br>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Jenis Barang</th>
                                    <th>Harga Barang</th>
                                    <th>Stok</th>
                                    <th>Brand</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($inventory as $inven)
                                <tr>
                                    <td>{{$inven->nama_barang}}</td>
                                    <td>{{$inven->jenis_barang}}</td>
                                    <td>{{$inven->harga_barang}}</td>
                                    <td>{{$inven->stok}}</td>
                                    <td>{{$inven->brand}}</td>
                                    <td>
                                        <a href="" class="btn btn-success btn-sm">Active</a>
                                        <a href="" class="btn btn-warning btn-sm">Suspend</a>
                                        <button class="edit-modal btn btn-warning btn-sm" 
                                            data-toggle="modal"
                                            data-target="#editModal"
                                            data-id="{{ $inven->id }}"
                                            data-nama="{{ $inven->nama_barang }}"
                                            data-jenis="{{ $inven->jenis_barang }}"
                                            data-harga="{{ $inven->harga_barang }}"
                                            data-stok="{{ $inven->stok }}"
                                            data-brand="{{ $inven->brand }}"
                                            >
                                            Edit
                                        </button>
                                        <button class="delete-modal btn btn-danger btn-sm"
                                            data-toggle="modal" 
                                            data-target="#deleteModal"
                                            data-delete-id="{{ $inven->id }}">Delete</button>
                                    </td>
                                </tr>
                              @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Rendering engine</th>
                                    <th>Browser</th>
                                    <th>Platform(s)</th>
                                    <th>Engine version</th>
                                    <th>CSS grade</th>
                                </tr>
                            </tfoot>
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
                <h5 class="modal-title" id="exampleModalLabel">Add Inventory</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form  action="/admin/inventory/create" method="post">
                  {{csrf_field()}}
                    <div class="form-group">
                        <label for="nama">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" id="nama" aria-describedby="emailHelp"
                            placeholder="Nama Barang" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="jenis">Jenis Barang</label>
                        <input type="text" name="jenis_barang" class="form-control" id="jenis" placeholder="Jenis Barang">
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga Barang</label>
                        <input type="text" name="harga_barang" class="form-control" id="harga" placeholder="Harga Barang">
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="text" name="stok" class="form-control" id="stok" placeholder="Stok">
                    </div>
                    <div class="form-group">
                        <label for="brand">Brand</label>
                        <input type="text" name="brand" class="form-control" id="brand" placeholder="Brand">
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
                <h5 class="modal-title" id="exampleModalLabel">Edit Inventory</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="text" id="id-edit" hidden>
                    <div class="form-group">
                        <label for="nama-edit">Nama Barang</label>
                        <input type="text" class="form-control" id="nama-edit" aria-describedby="emailHelp"
                            placeholder="Nama Barang" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="jenis-edit">Jenis Barang</label>
                        <input type="text" class="form-control" id="jenis-edit" placeholder="Jenis Barang">
                    </div>
                    <div class="form-group">
                        <label for="harga-edit">Harga Barang</label>
                        <input type="text" class="form-control" id="harga-edit" placeholder="Harga Barang">
                    </div>
                    <div class="form-group">
                        <label for="stok-edit">Stok</label>
                        <input type="text" class="form-control" id="stok-edit" placeholder="Stok">
                    </div>
                    <div class="form-group">
                        <label for="brand-edit">brand</label>
                        <input type="text" class="form-control" id="brand-edit" placeholder="Brand">
                    </div>
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
            $('#nama-edit').val($(this).data('nama'));
            $('#jenis-edit').val($(this).data('jenis'));
            $('#harga-edit').val($(this).data('harga'));
            $('#stok-edit').val($(this).data('stok'));
            $('#brand-edit').val($(this).data('brand'));
            // $('#editModal').modal('show');
        });
        $('.delete-modal').click(function() {
            $('#del-id').html($(this).data('delete-id'));
            // $('#modal-delete').modal('show');
        });
        $('.update').click(function() {
            $.ajax({
                url: '/admin/inventory/update',
                type: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': $('#token').attr('content')
                },
                data: {
                    'id': $('#id-edit').val(),
                    'nama_barang': $('#nama-edit').val(),
                    'jenis_barang': $('#harga-edit').val(),
                    'harga_barang': $('#harga-edit').val(),
                    'stok': $('#stok-edit').val(),
                    'brand': $('#brand-edit').val()
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
                url: '/admin/inventory/delete',
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
