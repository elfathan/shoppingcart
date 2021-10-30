<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/your-logo.png">
  <link rel="icon" type="image/png" href="../assets/img/your-logo.png">
  <title>Shopping Cart</title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <link href="../assets/css/font-awesome.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="../assets/css/argon-design-system.css?v=1.2.2" rel="stylesheet" />
</head>

<body class="login-page">
  <section class="section section-shaped section-lg">
    <div class="shape shape-style-1">
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
    </div>
    <div class="container pt-lg-7">
      <div class="row justify-content-center">
        <div class="col-lg-5">
          <div class="card bg-secondary shadow border-0">
            <div class="card-body px-lg-5 py-lg-5">
              <div class="text-center text-muted mb-4">
                <small>Masuk</small>
              </div>
              <form id="login">
              @csrf
                <div class="form-group mb-3">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                    </div>
                    <input class="form-control pl-2" placeholder="Email" name="email" type="email">
                  </div>
                </div>
                <div class="form-group focused">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control pl-2" placeholder="Password" name="password" type="password">
                  </div>
                </div>
                <div class="custom-control custom-control-alternative custom-checkbox">
                  <input class="custom-control-input" id=" customCheckLogin" type="checkbox">
                  <label class="custom-control-label" for=" customCheckLogin"><span>Remember me</span></label>
                </div>
                <div class="text-center">
                  <button type="submit" id="loginProcess" class="btn btn-primary my-4">Masuk</button>
                </div>
              </form>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-6">
              <a href="#" class="text-primary"><small>Lupa Kata Sandi?</small></a>
            </div>
            <div class="col-6 text-right">
              <a href="{{route('register')}}" class="text-primary"><small>Belum punya akun? Daftar</small></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/jquery.min.js" type="text/javascript"></script>
  <script src="../assets/js/core/popper.min.js" type="text/javascript"></script>
  <script src="../assets/js/core/bootstrap.min.js" type="text/javascript"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
  <script src="../assets/js/plugins/bootstrap-switch.js"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="../assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
  <script src="../assets/js/plugins/moment.min.js"></script>
  <script src="../assets/js/plugins/datetimepicker.js" type="text/javascript"></script>
  <script src="../assets/js/plugins/bootstrap-datepicker.min.js"></script>
  <!-- Control Center for Argon UI Kit: parallax effects, scripts for the example pages etc -->
  <!--  Google Maps Plugin    -->
  <!-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> -->
  <script src="../assets/js/argon-design-system.min.js?v=1.2.2" type="text/javascript"></script>
  
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="{{ asset('assets') }}/js/swal.js"></script>
  <script src="{{ asset('assets') }}/js/validate.js"></script>
  <script>
      $(document).ready(function () {
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });

          $('#login').validate({
              rules: {
                  email: {
                      required: true,
                      email: true
                  },
                  password: {
                      required: true,
                      minlength: 8,
                      maxlength: 16
                  },
              },
              submitHandler: function(form) { 
                  document.getElementById("loginProcess").disabled = true;
                  $('#loginProcess').html('Tunggu...');

                  $.ajax({
                      method: 'POST',
                      type: 'POST',
                      url: '{{ route('login.do') }}',
                      data: new FormData(form),
                      mimeType: "multipart/form-data",
                      dataType: "json",
                      processData: false,
                      contentType: false,
                      cache : false,
                      success: function(res) {
                          console.log(res)
                          if (res.message == 'success') {
                              swal("Success", "Berhasil masuk", "success");
                              setTimeout(function(){ window.location.replace("/"); }, 500);
                          } else if (res.message == 'inactive') {
                              document.getElementById("loginProcess").disabled = false;
                              $('#loginProcess').html('Masuk');
                              swal("Error!", "Your account is no longer active!", "error");
                          } else {
                              document.getElementById("loginProcess").disabled = false;
                              $('#loginProcess').html('Masuk');
                              swal("Error!", "Email atau password Salah!", "error");
                          }
                      },
                      timeout: 15000,
                      error: function() {
                          document.getElementById("loginProcess").disabled = false;
                          $('#loginProcess').html('Masuk');

                          swal("Error!", "Request time out!");
                          // setTimeout(function(){ location.reload(); }, 1500);
                      }
                  });
              }
          });
      }); 
  </script>
</body>

</html>