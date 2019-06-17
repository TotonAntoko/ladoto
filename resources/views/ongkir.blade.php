@extends('layouts.main')
@section('content')

    <div class="container product_section_container" style="padding: 30px;">
        <div class="row">
            <div class="col-md-6">
                <div class="panel-heading">
                    <h3 class="panel-title">Cek Ongkos Kirim</h3>
                </div>
                <div class="form-group">
                    <label for="">Kota / Kabupaten Asal</label>
                    <select name="kotaAsal" class="form-control" id="kotaAsal"
                        aria-placeholder="Pilih Kategori">
                        <option value="">--- Pilih Kota ---</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Provinsi Asal</label>
                    <select name="provinsiTujuan" class="form-control" id="provinsiTujuan"
                        aria-placeholder="Pilih Kategori">
                        <option value="">--- Pilih Provinsi ---</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Kota / Kabupaten Tujuan</label>
                    <select name="kotaTujuan" class="form-control" id="kotaTujuan"
                        aria-placeholder="Pilih Kategori">
                        <option value="">--- Pilih Kota ---</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Kurir</label>
                    <select name="kurir" class="form-control" id="kurir"
                        aria-placeholder="Pilih Kategori" required>
                        <option value="">--- Pilih Kurir ---</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Berat (Gram)</label>
                    <input class="form-control" id="berat" type="text" name="berat" value="500" />
                </div>
                <button class="btn red_button text-white" id="cek" type="submit" name="button">Cek Ongkir</button>
                {{-- {!! Form::bsText("country","Berat (Gram)") !!} --}}
                {{-- {!! Form::bsSubmit("Update") !!} --}}
                
            </div>

            
            <div class="col-md-6">
                <div class="panel-heading">
                    <h3 class="panel-title">Hasil</h3>
                    <div title="" style="padding:10px">
                        <h3 id="title-ongkir"></h3>
                        <table id="tabel-ongkir" class="table table-striped">
                            <tr>
                                <th>#</th>
                                <th>Jenis Layanan</th>
                                <th>ETD</th>
                                <th>Tarif</th>
                            </tr>
                        </table>
                        <button class="btn red_button text-white" id="btn-table-rows" type="submit" name="button">Get</button>
                    </div>
                    <div class="col-md-12 col-sm-12 text-right">
                        <div class="wc-proceed-to-checkout">
                            <p>SUBTOTAL <span id="subTotal">Rp. </span></p>
                            <p>ONGKIR <span id="biayaKirim">Rp. </span></p>
                            <p>TOTAL <span id="total">Rp.  </span></p>

                            <a href="{{route('payment')}}" class="red_button" title="CHECKOUT">CHECKOUT</a>
                        </div>
                    </div><!-- Proceed To Checkout /- -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script>

        $(document).ready(function(){
            $.ajax({
                url : 'ongkir/loadKota',
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    $.each(data,function(index,obj)
                    {
                            $("#kotaAsal").append("<option value='"+obj.city_id+"'>"+obj.type+" "+obj.city_name+"</option>");
                    });
                }
            });
            $.ajax({
                url : 'ongkir/loadProvinsi',
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    $.each(data,function(index,obj)
                    {
                            $("#provinsiTujuan").append("<option value='"+obj.province_id+"'>"+obj.province+"</option>");
                    });
                }
            });
            $('#provinsiTujuan').change(function(){

                //Mengambil value dari option select provinsi kemudian parameternya dikirim menggunakan ajax
                var prov = $('#provinsiTujuan').val();
                // var prov = 1;

                $("#kotaTujuan").empty();
                $.ajax({
                    url : 'ongkir/loadCityByIdProv/' + prov,
                    type : 'GET',
                    dataType: "JSON",
                    success: function (data) {

                        $.each(data,function(index,obj)
                        {
                            $("#kotaTujuan").append("<option value='"+obj.city_id+"'>"+obj.type+" "+obj.city_name+"</option>");
                        });
                    }
                });
            });

            var kurir = {"jne":"JNE","tiki":"TIKI","pos":"POS INDONESIA"} ;
            $.each(kurir,function(key,value)
            {
                    $("#kurir").append("<option value='"+key+"'>"+value+"</option>");
            });

            $("#cek").click(function(){
                //Mengambil value dari option select provinsi asal, kabupaten, kurir, berat kemudian parameternya dikirim menggunakan ajax
                var asal = $('#kotaAsal').val();
                var kab = $('#kotaTujuan').val();
                var kurir = $('#kurir').val();
                var berat = $('#berat').val();

                $.ajax({
                    url : '/ongkir/cekOngkir/'+ asal + '/' + kab + '/' + kurir +'/' + berat,
                    type : 'GET',
                    dataType: "JSON",
                    success: function (ongkir) {
                        // console.log(ongkir);

                        $("#tabel-ongkir").empty();
                        $.each(ongkir,function(index,obj)
                        {
                            $("#title-ongkir").html(obj.name);
                            $.each(obj.costs,function(index,obj2)
                            {
                                $.each(obj2.cost,function(index,obj3)
                                {
                                    $('#tabel-ongkir').append(
                                        '<tr>' +
                                            '<td><input id="row-selector" name="price" type="radio"/></td>' +
                                            '<td>'+
                                                '<div style="font:bold 16px Arial">'+ obj2.service +'</div>'+
                                                '<div style="font:normal 11px Arial">'+ obj2.description +'</div>'+
                                            '</td>' +
                                            '<td align="center">'+ obj3.etd + " Hari" +'</td>' +
                                            '<td class="row-price" align="right">'+ obj3.value +'</td>' +
                                        '</tr>');
                                }); 
                            });
                        });
                    }
                });
            });

            $('#btn-table-rows').click(function (event) {
                var values = [];
                
                $('table #row-selector:checked').each(function () {
                    var rowValue = $(this).closest('tr').find('td.row-price').text();
                    values.push(rowValue)
                });

                $.ajax({
                    url : 'ongkir/addOngkirToDb/' + values,
                    type : 'GET',
                    dataType: "JSON",
                    success: function (data) {
                        
                        $.each(data,function(index,obj)
                        {
                            $('#biayaKirim').empty();
                            $('#subTotal').empty();
                            $('#total').empty();
                            $('#biayaKirim').append('Rp. ' + (obj.ongkir/1000).toFixed(3));
                            $('#subTotal').append('Rp. ' + (obj.subTotal/1000).toFixed(3));
                            $('#total').append('Rp. ' + (obj.total/1000).toFixed(3));
                        });
                    }
                });

                // $('#biayaKirim').empty();
                // $('#biayaKirim').append(values);
                
                // var json = JSON.stringify(values);
                
                // alert(json);
            });
        });
    </script>
    
@endsection