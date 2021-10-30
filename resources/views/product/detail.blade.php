@extends('layouts.app')

@section('content')
  <section class="section team-2">
    <div class="container">

    <div class="row" style="margin-bottom: 40px">
        <div class="col-md-7 mx-auto text-left">
            <img class="img rounded" src="../assets/img/{{$detail->image}}" width="100%"  data-config-id="02_image1">
        </div>

        <div class="col-md-5 mx-auto text-left">
          <!-- <span class="badge badge-primary badge-pill mb-3">Insight</span> -->
          <h4 class="display-3">{{$detail->name}}</h4>
          <b style="font-size: 24px" class="display-3">Rp {{number_format($detail->price)}}</b>
          <p class="lead">{{$detail->description}}</p>
          <p class="lead">Stok: {{$detail->stock}}</p>

          <a class="btn bt-sm btn-primary" style="width: 100%; cursor: pointer" id="addToCartDetail" data-id="{{ $detail->id }}">
                <span class="nav-link-inner--text text-white" id="addToCartProcessDetail">Masukkan Keranjang</span>
            </a>
        </div>
      </div>
      

      <div class="row">
        <div class="col-md-8 mx-auto text-center">
          <!-- <span class="badge badge-primary badge-pill mb-3">Insight</span> -->
          <h4 class="display-3">Produk Lainnya</h4>
          <p class="lead">Lorem ipsum dolor sit amet.</p>
        </div>
      </div>

      <div class="row">
        @foreach($products as $product)
          <div class="col-lg-4 mb-4 col-md-6">
            <div class="card card-profile" data-image="profile-image">
              <!-- <div class="card-header"> -->
                <div class="card-image">
                  <a href="{{ route('detail', ['id' => $product->id]) }}">
                    <img class="img rounded" src="../assets/img/{{$product->image}}" width="100%"  data-config-id="02_image1">
                  </a>
                </div>
              <!-- </div> -->
              <div class="card-body pt-4">
                <p class="description" style="font-weight: bold; font-size: 18px">{{$product->name}}</p>
                <h6 class="info-title mb-0">Rp {{number_format($product->price)}}</h6>
                <br>
                <a class="btn bt-sm btn-primary" style="width: 100%; cursor: pointer" id="addToCart" data-id="{{$product->id}}">
                  <span class="nav-link-inner--text text-white" id="addToCartProcess{{$product->id}}">Masukkan Keranjang</span>
                </a>
              </div>
            </div>
          </div>
        @endforeach

      </div>

    </div>
</section>
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

            $('body').on('click', '#addToCartDetail', function (event) {
                event.preventDefault();
                document.getElementById("addToCartProcessDetail").disabled = true;
                $('#addToCartProcessDetail').html('Tunggu...');

                var datas = {
                    'id': $(this).data('id'),
                };

                $.post('{{URL::to('add.to.cart')}}', datas, function (data) {
                    document.getElementById("addToCartProcessDetail").disabled = false;
                    $('#addToCartProcessDetail').html('Masukkan Keranjang');
                
                    swal("Berhasil ditambahkan ke keranjang", {
                        icon: "success",
                    });
                    setTimeout(function(){ window.location.replace("{{ url('cart') }}"); }, 500);
                })
            });
            
            $('body').on('click', '#addToCart', function (event) {
                event.preventDefault();
                var id = $(this).data('id');
                
                document.getElementById("addToCartProcess" + id).disabled = true;
                $('#addToCartProcess' + id).html('Tunggu...');

                var datas = {
                    'id': $(this).data('id'),
                };

                $.post('{{URL::to('add.to.cart')}}', datas, function (data) {
                    console.log(data);
                    document.getElementById("addToCartProcess" + id).disabled = false;
                    $('#addToCartProcess' + id).html('Masukkan Keranjang');
                
                    swal("Berhasil ditambahkan ke keranjang", {
                        icon: "success",
                    });
                    setTimeout(function(){ window.location.replace("{{ url('cart') }}"); }, 500);
                })
            });
        });
    </script>
@endpush