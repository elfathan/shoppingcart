@extends('layouts.app')

@section('content')

  <div class="section features-6">
    <div class="container">
      <div class="col-md-8 mx-auto text-center">
        <!-- <span class="badge badge-primary badge-pill mb-3">Insight</span> -->
        <h4 class="display-3">Riwayat Transaksi</h4>
      </div>
      <br>
      <br>
      <div class="row">
        <div class="col-12">
          @if(count($histories) > 0)
          @foreach($histories as $history)
            <div class="info info-horizontal info-hover-primary mb-4 pb-4" style="border-bottom: 1px solid #cccccc">
              <div class="row align-items-center">
                <div class="col-lg-9">
                  <div class="description">
                    <a href="{{ route('history-detail', ['id' => $history->id]) }}">
                        <h5 class="text-primary">{{$history->invoice_number}}</h5>
                    </a>
                    <a style="margin-bottom: 10px" class="mb-3" href="{{ route('history-detail', ['id' => $history->id]) }}">
                        <span class="badge badge-primary badge-pill">Lihat Detail</span>
                    </a>
                    <br>
                    <br>
                    <p>Total: Rp {{number_format($history->total)}}</p>
                  </div>
                </div>
                <div class="col-lg-3">
                    <br>
                    <!--<small>Status</small>-->
                    @if($history->status == 'waiting')
                    <span class="badge badge-primary badge-pill mb-3">Status {{$history->status}}</span>
                    <a style="cursor: pointer" id="deleteTransaction" data-id="{{$history->id}}">
                        <span class="badge badge-danger badge-pill mb-3" id="deleteProcess{{$history->id}}">Batalkan</span>
                    </a>
                    @else
                    <span class="badge badge-danger badge-pill mb-3">Status {{$history->status}}</span>
                    @endif
                </div>
              </div>
            </div>
          @endforeach
          @else
            <div class="info info-horizontal info-hover-primary mb-4 pb-4">
              <div class="row align-items-center">
                <div class="col-12">
                  <div class="description" style="text-align: center">
                    <p>Belum ada transaksi</p>
                  </div>
                  <br>
                  <br>
                  <a class="btn bt-sm btn-warning" href="{{url('')}}" style="width: 100%; cursor: pointer; margin-bottom: 20px">
                      <span class="nav-link-inner--text text-white">Yuk Belanja</span>
                  </a>
                </div>
              </div>
            </div>
          @endif
          
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

            $('body').on('click', '#deleteTransaction', function (event) {
                event.preventDefault();
                var id = $(this).data('id');
                
                document.getElementById("deleteProcess" + id).disabled = true;
                $('#deleteProcess' + id).html('Tunggu...');

                var datas = {
                    'id': $(this).data('id'),
                };

                $.post('delete.transaction', datas, function (data) {
                    document.getElementById("deleteProcess" + id).disabled = false;
                    $('#deleteProcess' + id).html('Batalkan');
                              
                    swal("Produk berhasil dibatalkan", {
                        icon: "success",
                    });
                    setTimeout(function(){ location.reload(); }, 500);
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