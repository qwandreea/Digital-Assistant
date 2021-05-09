<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Digital assistant</title>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <script src="{{ asset('js/app.js') }}" defer></script>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('sass/app.scss') }}" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        
        <link rel="shortcut icon" href="{{asset('/image/favicon.png')}}" type="image/x-icon">
  <link rel="stylesheet" href="{{asset('/css/bootstrap.css')}}">
  <link rel="stylesheet" href="{{asset('/fonts/icon-font/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('/fonts/typography-font/typo.css')}}">
  <link rel="stylesheet" href="{{asset('/fonts/fontawesome-5/css/all.css')}}">
  <link href="https://fonts.googleapis.com/css2?family=Karla:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Gothic+A1:wght@400;500;700;900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
  <!-- Plugin'stylesheets  -->
  <link rel="stylesheet" href="{{asset('/plugins/aos/aos.min.css')}}">
  <link rel="stylesheet" href="{{asset('/plugins/slick/slick.min.css')}}">
  <!-- Vendor stylesheets  -->
  <link rel="stylesheet" href="{{asset('/css/main.css')}}">
  <!-- Custom stylesheet -->


    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            @if (Route::has('login'))
           <nav class="navbar navbar-light"  style="background-color:  #e3f2fd;">
                <div class="container-fluid">
                    <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block;">
                         <a class="navbar-brand" href="#">
                            <img src="{{ asset('/images/doctor.png') }}" alt="Logo" width="" height="60" class="d-inline-block align-text-top">
                        </a>
                        @auth
                            <a href="{{ url('/home') }}" class="text-sm text-gray-700 underline">Subscriptions</a>
                            <a>&nbsp; &nbsp;</a>
                            <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                        @endif
                    @endauth
                    </div>
                </div>
            </nav>
            @endif
        </div>

<div class="site-wrapper overflow-hidden position-relative"<div class="site-wrapper overflow-hidden position-relative">
    <div class="hero-area-l11 position-relative z-index-1 overflow-hidden">
      <div class="container position-relative">
        <div class="row position-relative justify-content-center">
          <div class="col-xl-8 col-lg-9 col-md-12 order-lg-1 order-1" data-aos="fade-up" data-aos-duration="500" data-aos-once="true">
            <div class="content">
              <h1>Digital assistant<br class="d-none d-md-block"> built for you.</h1>
              <div class="row banner-l-11-bottom-content">
                <div class="col-lg-8 col-md-8 col-sm-10">
                  <p class="position-relative banner-main-content-l-11">Check out a symptom that worries you
                    just a click away!
                    It's never been easier.
                    <span class="line-left-content"></span>
                  </p>
                </div>
                <div class="col-xl-3 col-lg-4">
                  <div class="compitable-text border-top d-inline-block">
                    <p>Compitable with:</p>
                    <div class="compatible-icon flex-y-center img-grayscale">
                      <a href="#" class="font-size-13 mr-7"><img src="./image/l2/windows.svg" alt=""></a>
                      <a href="#" class="font-size-13 mr-7"><img src="./image/l2/apple.svg" alt=""></a>
                      <a href="#" class="font-size-13"><img src="./image/l2/penguine.svg" alt=""></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-9 order-lg-1 order-0" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
            <img src="image/l2/laptop-screen.png" alt="" class="w-100 hero-l11-main-image">
          </div>
        </div>
      </div>
      <div class="hero-shape-l11-1 d-none d-md-block">
        <img src="./image/l2/hero-shape-1.svg" alt="">
      </div>
      <div class="hero-shape-l11-2 d-none d-md-block">
        <img src="./image/l2/hero-shape-2.png" alt="">
      </div>
    </div>
    <!-- Content Area -->
    <div class="content-area-l-11-3 position-relative">
      <div class="container">
        <div class="row align-items-center justify-content-center justify-content-lg-start">
          <div class="col-xl-6 col-lg-6 col-md-8 order-lg-1 order-0" data-aos="fade-up" data-aos-delay="500" data-aos-duration="1000">
            <div class="content-img">
              <img src="image/l2/content-img3.png" alt="" class="w-100">
            </div>
          </div>
          <div class="offset-xl-1 col-xl-5 col-lg-6 col-md-9 order-lg-1 order-1" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
            <div class="content section-heading-5">
              <h2>Purchase a great subscription for you.</h2>
              <p>Register in the app, purchase a package suitable for you, then eenjoy checking your symptoms directly from your room. </p>
              <ul class="list-unstyled pl-0">
                <li class="d-flex align-items-center">
                  <i class="fas fa-check"></i>Access to a variety of symptoms
                </li>
                <li class="d-flex align-items-center">
                  <i class="fas fa-check"></i>Intelligent diagnosis
                </li>
                <li class="d-flex align-items-center">
                  <i class="fas fa-check"></i>Access to your history
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Feature Area -->
    <div class="feature-l-11">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xl-9 px-lg-12 col-md-12">
            <div class="row justify-content-center">
              <div class="col-lg-10 text-center">
                <div class="section-heading-5">
                  <h2>
                    One Software, Every Solution
                  </h2>
                  <p>Here are the steps to be able to use the software application without problems.</p>
                </div>
              </div>
            </div>
            <div class="row feature-l-11-items justify-content-center">
              <div class="col-md-6" data-aos="fade-right" data-aos-duration="800" data-aos-once="true">
                <div class="d-flex ">
                  <div class="icon-box">
                    <i class="fas fa-user-plus"></i>
                  </div>
                  <div class="content-body">
                    <h5>Register</h5>
                    <p>Click the register button on the header of this page, fill in the fields and you're ready!</p>
                  </div>
                </div>
              </div>
              <div class="col-md-6" data-aos="fade-left" data-aos-duration="800" data-aos-once="true">
                <div class="d-flex ">
                  <div class="icon-box">
                    <i class="fab fa-cc-paypal"></i>
                  </div>
                  <div class="content-body">
                    <h5>Buy</h5>
                    <p>Choose a subscription that suits you. You can update your number of checks at any time by buying another subscription.</p>
                  </div>
                </div>
              </div>
              <div class="col-md-6" data-aos="fade-right" data-aos-duration="1000" data-aos-once="true">
                <div class="d-flex ">
                  <div class="icon-box">
                    <i class="fas fa-tachometer-alt"></i>
                  </div>
                  <div class="content-body">
                    <h5>Dashboard</h5>
                    <p>After recording the payment, you will be redirected to your dashboard. Here you have access to more information suitable for your account.</p>
                  </div>
                </div>
              </div>
           
              <div class="col-md-6" data-aos="fade-left" data-aos-duration="1200" data-aos-once="true">
                <div class="d-flex ">
                  <div class="icon-box">
                    <i class="fas fa-briefcase-medical"></i>
                  </div>
                  <div class="content-body">
                    <h5>Check your diagnosis!</h5>
                    <p>Check your symptoms and generate a smart diagnosis directly from your dashboard.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Testimonial Section -->
    <div class="testimonial-area-l-11">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xl-7 col-lg-9" data-aos="fade-down" data-aos-duration="800" data-aos-once="true">
            <div class="section-heading-5 text-center">
              <h2>
                100+ Customers Trust Us
              </h2>
              <p>I designed and tested prototypes. Together, we shaped the new standard.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>>
   

    <!-- Newsletter-area start -->
    <div class="newsletter-l-11" style="margin-top:-10%;">
      <div class="container">
        <div class="row justify-content-center news-l-11-main-bg position-relative">
          <div class="news-l-11-second-bg w-100 h-100"></div>
          <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-11" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
            <div class="content text-center">
              <h5>Try my software!</h5>
              <h2>Try my software!</h2>
              <span>Credit card required or PayPal account</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="copyright-area-l-11">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="text-center">
              <p>© Digital assistant 2021. </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <!-- Vendor Scripts -->  <script src={{asset('/js/vendor.min.js')}}"></script>
  <!-- Plugin's Scripts -->
  <script src="{{asset('/plugins/aos/aos.min.js')}}"></script>
  <script src="{{asset('/plugins/slick/slick.min.js')}}"></script>
  <script src="{{asset('/plugins/menu/menu.js')}}"></script>
  <!-- Activation Script -->
  <script src="{{asset('js/custom.js')}}"></script>

  </script>
    </body>
</html>
