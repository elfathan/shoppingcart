@extends('layouts.app')

@section('content')

  <div class="section features-6">
    <div class="container">
      <div class="col-md-8 mx-auto text-center">
        <!-- <span class="badge badge-primary badge-pill mb-3">Insight</span> -->
        <h4 class="display-3">Detail Riwayat</h4>
      </div>
      <br>
      <br>
      <div class="row">
        
        <div class="col-lg-8">
          @foreach($carts as $cart)
            <div class="info info-horizontal info-hover-primary mb-4 pb-4" style="border-bottom: 1px solid #cccccc">
              <div class="row align-items-center">
                <div class="col-lg-2">
                  <a href="{{ route('detail', ['id' => $cart->product->id]) }}">
                    <img class="img rounded" src="../assets/img/{{$cart->product->image}}" width="100%"  data-config-id="02_image1">
                  </a>
                </div>
                <div class="col-lg-7">
                  <div class="description">
                    <a href="{{ route('detail', ['id' => $cart->product->id]) }}">
                        <h5>{{$cart->product->name}}</h5>
                    </a>
                    <p>Rp {{number_format($cart->product->price)}}</p>
                    <p>Qty: {{$cart->qty}}</p>
                  </div>
                </div>
                <div class="col-lg-3">
                    <br>
                    <small>Total</small>
                    <p>Rp {{number_format($cart->product->price * $cart->qty)}}</p>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <div class="col-lg-4 col-12">
            <div>
                <b>Subtotal</b>
                <b style="font-size: 14px; float: right" class="display-3">Rp {{number_format($subtotal)}}</b>
            </div>
            
            <div>
                <b>Ongkos Kirim</b>
                <b style="font-size: 14px; float: right" class="display-3">Rp {{number_format(15000)}}</b>
            </div>
            
            <div>
                <b>Total</b>
                <b style="font-size: 14px; float: right" class="display-3">Rp {{number_format($subtotal + 15000)}}</b>
            </div>
            
            
            <div style="margin-top: 20px">
                <b>Nama Penerima</b>
                <b style="font-size: 14px; float: right" class="display-3">{{$member->name}}</b>
            </div>
            
            <div>
                <b>No. Handphone</b>
                <b style="font-size: 14px; float: right" class="display-3">{{$member->phone}}</b>
            </div>
            
            <div>
                <b>Alamat Pengiriman</b>
                <b style="font-size: 14px; float: right" class="display-3">{{$address}}</b>
            </div>
        </div>
      </div>
      
    </div>
  </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                timeout: 10000
            });
            
            $('body').on('click', '#reduceQty', function (event) {
                event.preventDefault();
                var id = $(this).data('id');
                
                document.getElementById("reduceProcess" + id).disabled = true;
                $('#reduceProcess' + id).html('Tunggu...');

                var datas = {
                    'id': $(this).data('id'),
                };

                $.post('reduce.qty.cart', datas, function (data) {
                    document.getElementById("reduceProcess" + id).disabled = false;
                    $('#reduceProcess' + id).html('-');
                              
                    swal("Qty berhasil dikurangi", {
                        icon: "success",
                    });
                    setTimeout(function(){ window.location.replace("cart"); }, 500);
                })
            });
            
            $('body').on('click', '#addQty', function (event) {
                event.preventDefault();
                var id = $(this).data('id');
                
                document.getElementById("addProcess" + id).disabled = true;
                $('#addProcess' + id).html('Tunggu...');

                var datas = {
                    'id': $(this).data('id'),
                };

                $.post('add.qty.cart', datas, function (data) {
                    document.getElementById("addProcess" + id).disabled = false;
                    $('#addProcess' + id).html('+');
                              
                    swal("Qty berhasil ditambah", {
                        icon: "success",
                    });
                    setTimeout(function(){ window.location.replace("cart"); }, 500);
                })
            });

            $('body').on('click', '#deleteCart', function (event) {
                event.preventDefault();
                var id = $(this).data('id');
                
                document.getElementById("deleteProcess" + id).disabled = true;
                $('#deleteProcess' + id).html('Tunggu...');

                var datas = {
                    'id': $(this).data('id'),
                };

                $.post('delete.cart', datas, function (data) {
                    document.getElementById("deleteProcess" + id).disabled = false;
                    $('#deleteProcess' + id).html('Hapus');
                              
                    swal("Produk berhasil dihapus", {
                        icon: "success",
                    });
                    setTimeout(function(){ window.location.replace("cart"); }, 500);
                })
            });
            
            $('body').on('click', '#checkout', function (event) {
                event.preventDefault();
                
                document.getElementById("checkoutProcess").disabled = true;
                $('#checkoutProcess').html('Tunggu...');

                $.post('add.qty.cart', datas, function (data) {
                    document.getElementById("checkoutProcess").disabled = false;
                    $('#checkoutProcess').html('+');
                              
                    swal("Qty berhasil ditambah", {
                        icon: "success",
                    });
                    setTimeout(function(){ window.location.replace("cart"); }, 500);
                })
            });
        });
    </script>
@endpush