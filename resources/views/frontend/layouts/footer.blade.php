<div class="footer-wrap">
  <div class="container">
    <div class="row">
      <div class="col-lg-4">
        <div class="footer_logo"><img alt="" class="footer-default" src="{{asset('front/images/logo-footer.png')}}"></div>
        <p>Air Force School, Kanpur Cantt was established in 1954 with the primary objective to provide educational facilities to the children of Air Force Personnel and civilians. It started with lofty ideas of making students better and responsible citizens of the nation. The school is situated inside the Air Force Station thus ensuring the safety of the children .</p>
      </div>
      <?php print_r(getBlock('quick-links'));?>
      <?php print_r(getBlock('opening-hours'));?>
      <div class="col-lg-3 col-md-4">
        <div class="footer_info">
          <h3>Get in Touch</h3>
          <ul class="footer-adress">
            <li class="footer_address"> <i class="fas fa-map-signs"> </i> <span> {{getaddress()}}</span> </li>
            <li class="footer_email"> <i class="fas fa-envelope" aria-hidden="true"></i> <span><a href="mailto:info@example.com"> {{getEmail()}} </a></span> </li>
            <li class="footer_phone"> <i class="fas fa-phone-alt"></i> <span><a href="tel:{{getPhone()}}"> {{getPhone()}}  </a></span> </li>
          </ul>
          <div class="social-icons footer_icon">
            <ul>
              <li><a href="{{getSocialLink('facebook')}}"><i class="fab fa-facebook-f" aria-hidden="true"></i></a></li>
              <li><a href="{{getSocialLink('twitter')}}"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
              <li><a href="{{getSocialLink('instagram')}}"><i class="fab fa-instagram" aria-hidden="true"></i></a></li>
              <li><a href="{{getSocialLink('youtube')}}"><i class="fab fa-youtube" aria-hidden="true"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Footer End --> 

<!--Copyright Start-->
<div class="footer-bottom text-center">
  <div class="container">
    <div class="copyright-text"><?php print_r(getBlock('copy-right'));?></div>
  </div>
</div>
<!--Copyright End--> 