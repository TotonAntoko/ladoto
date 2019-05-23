@extends('admin.layouts.master')

@section('title', 'Product')

@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Data Products
            {{-- <small>advanced tables</small> --}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Data Products</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Data Products</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#addModal">Add</button>
                        <br>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Category</th>
                                    <th>Product Name</th>
                                    <th>Original Price</th>
                                    <th>Product Price</th>
                                    <th>Product Details</th>
                                    <th>Stok</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{!! $product->thumbs !!}</td>
                                    <td> {{ $product->categories->category_name }}  </td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ number_format($product->original_price) }} ₺</td>
                                    <td>{{ number_format($product->product_price) }} ₺</td>
                                    <td>{!! str_limit($product->product_detail, 30) !!}</td>
                                    <td>{{ $product->stok }}</td>
                                    <td>{{ $product->created_at }}</td>
                                    <td>
                                        <a href="" class="btn btn-success btn-sm">Active</a>
                                        <a href="" class="btn btn-warning btn-sm">Suspend</a>
                                        <button class="edit-modal btn btn-warning btn-sm" 
                                            data-toggle="modal"
                                            data-target="#editModal"
                                            data-id="{{ $product->id }}"
                                            data-category="{{ $product->category_id }}"
                                            data-product="{{ $product->product_name }}"
                                            data-oriprice="{{ $product->original_price }}"
                                            data-prodprice="{{ $product->product_price }}"
                                            data-stok="{{ $product->stok }}"
                                            data-detail="{{ $product->product_detail }}"
                                            {{-- data-createdAt="{{ $product->created_at }}" --}}
                                            >
                                            Edit
                                        </button>
                                        <button class="delete-modal btn btn-danger btn-sm"
                                            data-toggle="modal" 
                                            data-target="#deleteModal"
                                            data-delete-id="{{ $product->id }}">Delete</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form  action="{{route('admin-products.store')}}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="image">Product Image</label>
                        <input type="file" name="img[]" class="form-control-file" id="img">
                    </div>
                    <div class="form-group">
                        <label for="">Kategori</label>
                        @if(count($categoryMenu)>0)
                        <select name="category_id" class="form-control" id="category_id"
                            aria-placeholder="Pilih Kategori">
                            <option value="">--- Pilih Kategori ---</option>
                            @foreach ($categoryMenu as $list)
                            <option value="{{$list->id}}">{{$list->category_name}}</option>
                            @endforeach
                        </select>
                        @else
                        <p>Tidak ada pilihan Kategori</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="nama">Product Name</label>
                        <input type="text" name="product_name" class="form-control" id="product_name" aria-describedby="emailHelp"
                            placeholder="Nama" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Original Price</label>
                        <input type="text" name="original_price" class="form-control" id="original_price" placeholder="Alamat">
                    </div>
                    <div class="form-group">
                        <label for="kota">Product Price</label>
                        <input type="text" name="product_price" class="form-control" id="product_price" placeholder="Kota">
                    </div>
                    <div class="form-group">
                        <label for="kota">Stok</label>
                        <input type="text" name="stok" class="form-control" id="stok" placeholder="Stok">
                    </div>
                    <div class="form-group">
                        <label for="negara">Product Details</label>
                        <input type="text" name="product_detail" class="form-control" id="product_detail" placeholder="Negara">
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
                <form enctype="multipart/form-data">
                    <input type="text" id="id-edit">
                    <div class="form-group">
                        <label for="image">Product Image</label>
                        <input type="file" name="img[]" class="form-control-file" id="img-edit[]">
                    </div>
                    <div id="category_id-edit" class="form-group">
                        <label for="">Kategori</label>
                        @if(count($categoryMenu)>0)
                        <select name="category_id" class="form-control" id="category_id-select"
                            aria-placeholder="Pilih Kategori">
                            <option value="">--- Pilih Kategori ---</option>
                            @foreach ($categoryMenu as $list)
                            <option value="{{$list->id}}">{{$list->category_name}}</option>
                            @endforeach
                        </select>
                        @else
                        <p>Tidak ada pilihan Kategori</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="nama">Product Name</label>
                        <input type="text" name="product_name" class="form-control" id="product_name-edit" aria-describedby="emailHelp" placeholder="Nama" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Original Price</label>
                        <input type="text" name="original_price" class="form-control" id="original_price-edit" placeholder="Alamat">
                    </div>
                    <div class="form-group">
                        <label for="kota">Product Price</label>
                        <input type="text" name="product_price" class="form-control" id="product_price-edit" placeholder="Kota">
                    </div>
                    <div class="form-group">
                        <label for="stok-edit">Stok</label>
                        <input type="text" name="stok" class="form-control" id="stok-edit" placeholder="Stok">
                    </div>
                    <div class="form-group">
                        <label for="negara">Product Details</label>
                        <input type="text" name="product_detail" class="form-control" id="product_detail-edit" placeholder="Details">
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
            // $('#id-edit').val(23);
            $('#id-edit').val($(this).data('id'));
            // $('#category_id-edit select').val('7');
            $('#stok-edit').val($(this).data('stok'));
            $('#category_id-edit select').val($(this).data('category'));
            $('#product_name-edit').val($(this).data('product'));
            $('#original_price-edit').val($(this).data('oriprice'));
            $('#product_price-edit').val($(this).data('prodprice'));
            $('#product_detail-edit').val($(this).data('detail'));
            // $('#status-edit').val($(this).data('createdAt'));
            // $('#editModal').modal('show');
        });
        $('.delete-modal').click(function() {
            $('#del-id').html($(this).data('delete-id'));
            // $('#modal-delete').modal('show');
        });
        $('.update').click(function() {
            $.ajax({
                url: '/admin-products/update',
                type: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': $('#token').attr('content')
                },
                data: {
                    'id': $('#id-edit').val(),
                    'img': $('#img-edit').val(),
                    'stok': $('#stok-edit').val(),
                    'category_id': $('#category_id-select').val(),
                    'product_name': $('#product_name-edit').val(),
                    'product_price': $('#product_price-edit').val(),
                    'original_price': $('#original_price-edit').val(),
                    'product_detail': $('#product_detail-edit').val(),
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
                url: '/admin-product/destroy',
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
