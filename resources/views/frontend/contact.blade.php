@extends('frontend.layouts.app')
@section('content')
<div class="innerHeading-wrap">
  <div class="container">
    <h1>Contact Us</h1>
  </div>
</div>
<div class="innerContent-wrap">
  <div class="container">
    <div class="cont_info ">
      <div class="row">
        <div class="col-lg-4 col-md-6 md-mb-30">
          <div class="address-item style">
            <div class="address-icon"> <i class="fas fa-phone-alt"></i> </div>
            <div class="address-text">
              <h3 class="contact-title">Call Us</h3>
              <ul class="unorderList">
                <li><a href="tel:{{getPhone()}}">{{getPhone()}}</a></li>
                <li><a href="tel:{{getMobile()}}">{{getMobile()}}</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 md-mb-30">
          <div class="address-item style">
            <div class="address-icon"> <i class="far fa-envelope"></i> </div>
            <div class="address-text">
              <h3 class="contact-title">Mail Us</h3>
              <ul class="unorderList">
                <li><a href="#">{{getSettingValueByName('email1')}}</a></li>
                <li><a href="#">{{getSettingValueByName('emai12')}}</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="address-item">
            <div class="address-icon"> <i class="fas fa-map-marker-alt"></i> </div>
            <div class="address-text">
              <h3 class="contact-title">Address</h3>
              <p> {{getaddress()}}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-7"> 
        
        <!-- Register Start -->
        <div class="login-wrap">
          <div class="contact-info login_box">
            <div class="contact-form loginWrp registerWrp">
              <form id="contactForm" novalidate="">
                <h3>Get In Touch</h3>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <input type="email" name="name" class="form-control" placeholder="First Name">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <input type="email" name="name" class="form-control" placeholder="Last Name">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <input type="email" name="email" class="form-control" placeholder="Email Address">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <input type="email" name="phone" class="form-control" placeholder="Phone">
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group">
                      <textarea class="form-control" placeholder="Message"></textarea>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group">
                      <button type="submit" class="default-btn btn send_btn"> Submit <span></span></button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- Register End --> 
      </div>
      <div class="col-lg-5">
        <div class="map">
         <?php print_r(getMap());?>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection 
@section('script')
<!--Google Map APi Key-->
<script src="http://maps.google.com/maps/api/js?key=AIzaSyBKS14AnP3HCIVlUpPKtGp7CbYuMtcXE2o"></script>
<script src="{{ asset('front/js/map-script.js') }}"></script>
@endsection 