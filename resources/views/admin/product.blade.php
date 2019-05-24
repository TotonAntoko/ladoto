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
                            <button onclick="addForm()" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#addModal" style="margin-bottom: 13px;">Add</button>
                        <table id="product-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Category</th>
                                    <th>Product Name</th>
                                    {{-- <th>Original Price</th> --}}
                                    <th>Product Price</th>
                                    {{-- <th>Product Details</th> --}}
                                    <th>Stok</th>
                                    {{-- <th>Created At</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
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
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                <form method="POST" data-toggle="validator" enctype="multipart/form-data">
                    {{csrf_field()}} {{ method_field('POST') }}
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="img">Product Image</label>
                        <input type="file" name="img[]" class="form-control-file" id="img" multiple>
                    </div>
                    <div id="category_id-edit" class="form-group">
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

<!-- Modal Show-->
<div class="modal fade" id="modal-show" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="image-show">Image</label>
                    <div id="image-show" class="shadow-lg p-3 mb-5 bg-white rounded"></div>
                </div>
                <div class="form-group">
                    <label for="kategori-show">Kategori</label>
                    <div id="kategori-show" class="shadow-lg p-3 mb-5 bg-white rounded">Larger shadow</div>
                </div>
                <div class="form-group">
                    <label for="nama-show">Nama Product</label>
                    <div id="nama-show" class="shadow-lg p-3 mb-5 bg-white rounded">Larger shadow</div>
                </div>
                <div class="form-group">
                    <label for="hargaOri-show">Harga Original</label>
                    <div id="hargaOri-show" class="shadow-lg p-3 mb-5 bg-white rounded">Larger shadow</div>
                </div>
                <div class="form-group">
                    <label for="hargaProduct-show">Harga Product</label>
                    <div id="hargaProduct-show" class="shadow-lg p-3 mb-5 bg-white rounded">Larger shadow</div>
                </div>
                <div class="form-group">
                    <label for="detail-show">Detail Product</label>
                    <div id="detail-show" class="shadow-lg p-3 mb-5 bg-white rounded">Larger shadow</div>
                </div>
                <div class="form-group">
                    <label for="stok-show">Stok</label>
                    <div id="stok-show" class="shadow-lg p-3 mb-5 bg-white rounded">Larger shadow</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                {{-- <button type="submit" class="btn btn-primary">Save changes</button>
                </form> --}}
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
{{-- Validator --}}
<script src="{{asset('plugins/validator/validator.min.js') }}"></script>
<!-- SlimScroll -->
<script src="{{asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('dist/js/demo.js')}}"></script>


{{-- CRUD AJAX --}}
<script>
    var table = $('#product-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.product') }}",
        columns: [
        {data: 'id', name: 'id'},
        {data: 'show_photo', name: 'show_photo'},
        {data: 'category_name', name: 'category_name'},
        {data: 'product_name', name: 'product_name'},
        // {data: 'original_price', name: 'original_price'},
        {data: 'product_price', name: 'product_price'},
        // {data: 'product_detail', name: 'product_detail'},
        {data: 'stok', name: 'stok'},
        // {data: 'created_at', name: 'created_at'},
        {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
    function addForm() {
        save_method = "add";
        $('input[name=_method]').val('POST');
        $('#modal-form').modal('show');
        $('#modal-form form')[0].reset();
        $('.modal-title').text('Add Product');
    }

    function showForm(id) {
        $.ajax({
          url: "{{ url('admin-products') }}" + '/' + id ,
          type: "GET",
          dataType: "JSON",
          success: function(data) {
            $('#modal-show').modal('show');
            $('.modal-title').text('Detail Customer');
            
            // $(".modal-body").append("
            //     <span class='shadow-lg p-3 mb-5 bg-white rounded'>Larger shadow</span>".
            //     "<span class='shadow-lg p-3 mb-5 bg-white rounded'>Larger shadow</span>");
            

            $('#image-show').append(data.img);
            $('#kategori-show').text(data.kategori);
            $('#nama-show').text(data.product_name);
            $('#hargaOri-show').text(data.hargaOri);
            $('#hargaProduct-show').text(data.hargaProduct);
            $('#detail-show').text(data.product_detail);
            $('#stok-show').text(data.stok);
            
          },
          error : function() {
              alert("Nothing Data");
          }
        });
    }

    function editForm(id) {
        save_method = 'edit';
        $('input[name=_method]').val('PATCH');
        $('#modal-form form')[0].reset();
        $.ajax({
          url: "{{ url('admin-products') }}" + '/' + id + "/edit",
          type: "GET",
          dataType: "JSON",
          success: function(data) {
            $('#modal-form').modal('show');
            $('.modal-title').text('Edit Product');

            // $('#id-edit').val($(this).data('id'));
            // $('#stok-edit').val($(this).data('stok'));
            // $('#category_id-edit select').val($(this).data('category'));
            // $('#product_name-edit').val($(this).data('product'));
            // $('#original_price-edit').val($(this).data('oriprice'));
            // $('#product_price-edit').val($(this).data('prodprice'));
            // $('#product_detail-edit').val($(this).data('detail'));

            $('#id').val(data.id);
            $('#category_id-edit select').val(data.category_id);
            $('#product_name').val(data.product_name);
            $('#original_price').val(data.original_price);
            $('#product_price').val(data.product_price);
            $('#product_detail').val(data.product_detail);
            $('#stok').val(data.stok);
            
            
          },
          error : function() {
              alert("Nothing Data");
          }
        });
    }

    function deleteData(id){
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then(function () {
            $.ajax({
                url : "{{ url('admin-products') }}" + '/' + id,
                type : "POST",
                data : {'_method' : 'DELETE', '_token' : csrf_token},
                success : function(data) {
                    table.ajax.reload();
                    swal({
                        title: 'Success!',
                        text: data.message,
                        type: 'success',
                        timer: '1500'
                    })
                },
                error : function () {
                    swal({
                        title: 'Oops...',
                        text: data.message,
                        type: 'error',
                        timer: '1500'
                    })
                }
            });
        });
    }

    $(function(){
        $('#modal-form form').validator().on('submit', function (e) {
            if (!e.isDefaultPrevented()){
                var id = $('#id').val();
                if (save_method == 'add') url = "{{ url('admin-products') }}";
                else url = "{{ url('admin-products') . '/' }}" + id;

                $.ajax({
                    url : url,
                    type : "POST",
//                        data : $('#modal-form form').serialize(),
                    data: new FormData($("#modal-form form")[0]),
                    contentType: false,
                    processData: false,
                    success : function(data) {
                        $('#modal-form').modal('hide');
                        table.ajax.reload();
                        swal({
                            title: 'Success!',
                            text: data.message,
                            type: 'success',
                            timer: '1500'
                        })
                    },
                    error : function(data){
                        swal({
                            title: 'Oops...',
                            text: data.message,
                            type: 'error',
                            timer: '1500'
                        })
                    }
                });
                return false;
            }
        });
    });
</script>
@endsection
