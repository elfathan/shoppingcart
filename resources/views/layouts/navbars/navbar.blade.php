<!-- Navbar -->
<nav id="navbar-main" class="navbar navbar-main navbar-expand-lg bg-white navbar-light position-sticky top-0 shadow py-2">
  <div class="container">
    <a class="navbar-brand mr-lg-5" href="{{url('')}}">
      <img src="../assets/img/your-logo.png">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse collapse" id="navbar_global">
      <div class="navbar-collapse-header">
        <div class="row">
          <div class="col-6 collapse-brand">
            <a href="{{url('')}}">
              <img src="../assets/img/your-logo.png">
            </a>
          </div>
          <div class="col-6 collapse-close">
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
              <span></span>
              <span></span>
            </button>
          </div>
        </div>
      </div>
      <ul class="navbar-nav navbar-nav-hover align-items-lg-center">
        <li class="nav-item dropdown">
          <a href="{{url('')}}" class="nav-link" role="button">
            <i class="ni ni-ui-04 d-lg-none"></i>
            <span class="nav-link-inner--text">Beranda</span>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a href="#" class="nav-link" href="#" role="button">
            <i class="ni ni-ui-04 d-lg-none"></i>
            <span class="nav-link-inner--text">Tentang Kami</span>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a href="#" class="nav-link" href="#" role="button">
            <i class="ni ni-ui-04 d-lg-none"></i>
            <span class="nav-link-inner--text">Hubungi Kami</span>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav align-items-lg-center ml-lg-auto">
        <li class="nav-item dropdown">
            
            @if($cartTotal > 0)
          <a class="nav-link nav-link-icon" data-toggle="dropdown" role="button" data-toggle="tooltip" title="Cart">
            <i class="fa fa-shopping-cart"></i>
            <span class="nav-link-inner--text d-lg-none">Cart</span>
            <div style="background: #f00; color: #fff; height: 20px; width: 20px; border-radius: 10px; position: absolute; top: 5px; left: 15px; font-size: 10px; text-align: center; vertical-align: middle; padding-top: 2px;">
                {{ $cartTotal }}
            </div>
          </a>
            @else
                <a class="nav-link nav-link-icon" href="{{route('cart')}}" role="button" data-toggle="tooltip" title="Cart">
                    <i class="fa fa-shopping-cart"></i>
                    <span class="nav-link-inner--text d-lg-none">Cart</span>
                  </a>
            @endif
          <div class="dropdown-menu dropdown-menu-xl">
            <div class="dropdown-menu-inner">
                @foreach($cartHeader as $cart)
                  <a href="{{ route('detail', ['id' => $cart->product->id]) }}" class="media d-flex align-items-center">
                    <div class="icon bg-gradient-primary rounded-circle text-white">
                      <img class="img rounded" src="../assets/img/{{$cart->product->image}}" width="100%"  data-config-id="02_image1">
                    </div>
                    <div class="media-body ml-3">
                      <h6 class="heading text-primary mb-md-1">{{$cart->product->name}}</h6>
                      <p class="description d-none d-md-inline-block mb-0">
                        Rp {{number_format($cart->product->price)}}
                      </p>
                    </div>
                  </a>
                @endforeach
                <a class="btn bt-sm btn-primary" href="{{route('cart')}}" style="width: 100%; cursor: pointer">
                  @csrf
                  <span class="nav-link-inner--text text-white">Lihat Keranjang</span>
                </a>
            </div>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-link-icon" href="#" data-toggle="tooltip" title="Notification">
            <i class="fa fa-bell"></i>
            <span class="nav-link-inner--text d-lg-none">Notification</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-link-icon" href="#" data-toggle="tooltip" title="Email">
            <i class="fa fa-envelope"></i>
            <span class="nav-link-inner--text d-lg-none">Email</span>
          </a>
        </li>

        @auth()     
          <li class="nav-item dropdown">
            <a href="#" class="nav-link" data-toggle="dropdown" href="#" role="button">
              <i class="ni ni-collection d-lg-none"></i>
              <span class="nav-link-inner--text text-primary">Hi, {{ $member->name }}</span>
            </a>
            <div class="dropdown-menu">
              <!--<a href="{{route('member')}}" class="dropdown-item">Member Area</a>-->
              <a href="{{route('history')}}" class="dropdown-item">Riwayat Transaksi</a>
              <a href="{{route('logout')}}" class="dropdown-item">Keluar</a>
            </div>
          </li>
        @endauth

        @guest()
          <li class="nav-item">
            <a class="btn bt-sm btn-primary" style="height: 30px; line-height: 10px" href="{{ route('login') }}">
              <span class="nav-link-inner--text">Masuk</span>
            </a>
          </li>      
        @endguest
        
        <!-- <li class="nav-item d-none d-lg-block">
          <a href="https://www.creative-tim.com/product/argon-design-system-pro?ref=ads-upgrade-pro" target="_blank" class="btn btn-primary btn-icon">
            <span class="btn-inner--icon">
              <i class="fa fa-shopping-cart"></i>
            </span>
            <span class="nav-link-inner--text">Upgrade to PRO</span>
          </a>
        </li> -->
      </ul>
    </div>
  </div>
</nav>
<!-- End Navbar -->