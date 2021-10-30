@extends('layouts.app')

@section('content')

  <div class="section features-6">
    <div class="container">
      <div class="col-md-8 mx-auto text-center">
        <!-- <span class="badge badge-primary badge-pill mb-3">Insight</span> -->
        <h4 class="display-3">Checkout</h4>
      </div>
      <br>
      <br>
        
        <form id="checkout">
              @csrf
      <div class="row">
        <div class="col-lg-8">
            
            <div class="info info-horizontal info-hover-primary mb-4 pb-4" style="border-bottom: 1px solid #cccccc">
              <div class="row align-items-center" style="padding: 0 20px 20px">
                <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" value="{{ $member->name }}">
              </div>
              <div class="row align-items-center" style="padding: 0 20px 20px">
                <input type="text" name="email" class="form-control" placeholder="Email" value="{{ $member->email }}">
              </div>
              <div class="row align-items-center" style="padding: 0 20px 20px">
                <input type="text" name="phone" class="form-control" placeholder="Nomor Hanphone" value="{{ $member->phone }}">
              </div>
              <div class="row align-items-center" style="padding: 0 20px 20px">
                <textarea name="address" class="form-control" id="address" placeholder="Alamat"></textarea>
                <div id="map_canvas">
                </div>
                <a class="btn bt-sm btn-info" id="getAddress" style="width: 100%; cursor: pointer; margin-top: 20px">
                      <span class="nav-link-inner--text text-white">Dapatkan Alamat</span>
                  </a>
              </div>
            </div>
            
            
            
        </div>

        <div class="col-lg-4 col-12">
            <div>
                <b>Subtotal</b>
                <b style="font-size: 14px; float: right" class="display-3">Rp {{number_format($subtotal)}}</b>
            </div>
            
            <div>
                <b>Ongkor Kirim</b>
                <b style="font-size: 14px; float: right" class="display-3">Rp {{number_format(15000)}}</b>
            </div>
            
            <div>
                <b>Total</b>
                <b style="font-size: 14px; float: right" class="display-3">Rp {{number_format($subtotal + 15000)}}</b>
            </div>
            
          <br>
          <br>
          <button type="submit" class="btn bt-sm btn-primary" id="checkout" style="width: 100%; cursor: pointer">
              <span class="nav-link-inner--text text-white" id="checkoutProcess">Checkout</span>
          </button>
          <br>
          <br>
          <a class="btn bt-sm btn-warning" href="{{url('')}}" style="width: 100%; cursor: pointer; margin-bottom: 20px">
              <span class="nav-link-inner--text text-white" id="checkoutProcess">Belanja Lagi</span>
          </a>
        </div>
      </div>
        </form>
    </div>
  </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });

          $('#checkout').validate({
              rules: {
                  name: {
                      required: true,
                  },
                  phone: {
                      required: true,
                  },
                  email: {
                      required: true,
                      email: true
                  },
                  address: {
                      required: true,
                      minlength: 8,
                  },
              },
              submitHandler: function(form) { 
                  document.getElementById("checkoutProcess").disabled = true;
                  $('#checkoutProcess').html('Tunggu...');

                  $.ajax({
                      method: 'POST',
                      type: 'POST',
                      url: '{{ route('checkout.do') }}',
                      data: new FormData(form),
                      mimeType: "multipart/form-data",
                      dataType: "json",
                      processData: false,
                      contentType: false,
                      cache : false,
                      success: function(res) {
                          console.log(res)
                          if (res.message == 'success') {
                              swal("Success", "Pesanan berhasil disimpan", "success");
                              setTimeout(function(){ window.location.replace("history"); }, 1000);
                          } else {
                              document.getElementById("checkoutProcess").disabled = false;
                              $('#checkoutProcess').html('Checkout');
                              swal("Error!", "Pesanan Gagal!", "error");
                          }
                      },
                      timeout: 15000,
                      error: function(e) {
                          document.getElementById("checkoutProcess").disabled = false;
                          $('#checkoutProcess').html('Checkout');

                          swal("Error!", e);
                          // setTimeout(function(){ location.reload(); }, 1500);
                      }
                  });
              }
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
            
        });
        
        $('body').on('click', '#getAddress', function (event) {
            event.preventDefault();
            
            if(geo_position_js.init()){
    			geo_position_js.getCurrentPosition(success_callback,error_callback,{enableHighAccuracy:true});
    		} else {
    			alert("Functionality not available");
    		}
    
    		function success_callback(p) {
    			geo_position_js.showMap(p.coords.latitude,p.coords.longitude);
                // latitude=p.coords.latitude;
                // longitude=p.coords.longitude;

                // pesan='posisi:'+latitude+','+longitude;
                // pesan = pesan + '<br/>';
                // // pesan = pesan + "<img src='https://maps.googleapis.com/maps/api/staticmap?size=400×400&amp;zoom=13&amp;markers=color:red%7Clabel:C%7C"+latitude +","+longitude+"'/>";
                // pesan = pesan + '<img src="https://maps.googleapis.com/maps/api/staticmap?center=40.714728,-73.998672&zoom=12&size=600x400"/>'
                // div_isi = document.getElementById("div_isi");
                // //alert(pesan);
                // div_isi.innerHTML = pesan;
    		}
    		
    		function error_callback(p){
    			alert('error='+p.message);
    		}
        });
        
        	
    </script>
@endpush