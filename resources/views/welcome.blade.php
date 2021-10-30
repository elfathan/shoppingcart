@extends('layouts.app')

@section('content')
  <section class="section team-2">
    <div class="container">

      <div class="row">
        <div class="col-md-8 mx-auto text-center">
          <!-- <span class="badge badge-primary badge-pill mb-3">Insight</span> -->
          <h4 class="display-3">Produk Terbaru</h4>
          <p class="lead"></p>
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
                <div>
                    <h6 class="info-title mb-4" style="float: left">Rp {{number_format($product->price)}}</h6>
                    <h6 class="info-title mb-4" style="float: right">Stok {{number_format($product->stock)}}</h6>
                </div>
                <br>
                <a class="btn bt-sm btn-primary" style="width: 100%; cursor: pointer" id="addToCart" data-id="{{ $product->id }}">
                  @csrf
                  <span class="nav-link-inner--text text-white" id="addToCartProcess{{ $product->id }}">Masukkan Keranjang</span>
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

            $('body').on('click', '#addToCart', function (event) {
                event.preventDefault();
                var id = $(this).data('id');
                
                document.getElementById("addToCartProcess" + id).disabled = true;
                $('#addToCartProcess' + id).html('Tunggu...');

                var datas = {
                    'id': $(this).data('id'),
                };

                $.post('add.to.cart', datas, function (data) {
                    console.log(data);
                    document.getElementById("addToCartProcess" + id).disabled = false;
                    $('#addToCartProcess' + id).html('Masukkan Keranjang');
                
                    swal("Berhasil ditambahkan ke keranjang", {
                        icon: "success",
                    });
                    setTimeout(function(){ window.location.replace("cart"); }, 500);
                })
            });
        });
    </script>
@endpush