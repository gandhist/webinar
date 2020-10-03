<button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa fa-chevron-up"></i></button>

<div id="WAButton"></div>
<!--
<section class="tentang pt-5 pb-5">
    <div class="container">
      <div class="row">
        <div class="col-md-3 mb-3">
          <h3 class="text-white">TENTANG KAMI</h3>
          <a href=""><img id="logoFoot" src="{{url('p3sm_a.png')}}" alt="" /></a>
          <h5 class="text-white">Mitra terpercaya bagi dunia usaha dan para profesional ...</h5>
          <a target="_blank" href="www.p3sm.or.id" class="text-white">Selengkapnya</a>
        </div>
        <div class="col-md-3 mb-3">
          <ul style="list-style: none; padding-left: 0">
            <li class=" mb-2"><a href="" class="text-white">LAYANAN KAMI</a></li>
            <li><a href="" class="text-white fz14">KONSTRUKSI</a></li>
            <li><a href="" class="text-white fz14">KETENAGALISTRIKAN</a></li>
            <li><a href="" class="text-white fz14">KETENAGAKERJAAN</a></li>
            <li><a href="" class="text-white fz14">BNSP</a></li>
            <li><a href="" class="text-white fz14">BSN/KAN</a></li>
            <li><a href="" class="text-white fz14">REGULASI</a></li>
            <li><a href="" class="text-white fz14">LAINNYA</a></li>
            <li><a href="" class="text-white fz14">TENTANG KAMI</a></li>
          </ul>
        </div>
        <div class="col-md-3 mb-3">
          <h3 class="text-white">ALAMAT KANTOR</h3>
          <h6 class="text-white" style="font-size: 15px; line-height: 28px">Jl. Pluit Raya Kav. 12 Blok A5 Rt.01 Rw 004 - Penjaringan Jakarta Utara 14440</h6>
        </div>
        <div class="col-md-3 mb-3">
          {{-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7934.0620224361655!2d106.79129582219835!3d-6.126529232256014!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6a1df20df00b7f%3A0x86fdf3a8e5816da5!2sHJKI!5e0!3m2!1sid!2sid!4v1594200386783!5m2!1sid!2sid" width="100%"  frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe> --}}
        </div>
      </div>
    </div>
</section>
-->
<!-- Footer Section Start -->
<footer>
    <!-- Footer Area Start -->
    <section class="footer">
    <!-- Copyright Start  -->
    <div class="copyright">
        <div class="container">
            <div class="row" align="center">
                <div class="col-md-12">
                    <div class="site-info">
                        <strong>&copy; {{ \Carbon\Carbon::now()->isoFormat('YYYY') }} - All Rights Reserved</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->
    </section>
    <!-- Footer area End -->

</footer>
 <!-- Footer Section End -->

<!--Jquery-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<!--Floating WhatsApp css-->
<link rel="stylesheet" href='{{asset("wa/floating-wpp.min.css")}}'>
<!--Floating WhatsApp javascript-->
<script type="text/javascript" src='{{asset("wa/floating-wpp.min.js")}}'></script>


<!-- jQuery CDN - Slim version (=without AJAX) -->
{{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> --}}
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

<script>
    //Get the button
    var mybutton = document.getElementById("myBtn");

    $('#WAButton').floatingWhatsApp({
        phone: '628111096173', //WhatsApp Business phone number
        headerTitle: 'Join Chat', //Popup Title
        popupMessage: 'Halo , Ada yang bisa kami bantu?', //Popup Message
        showPopup: true, //Enables popup display
        buttonImage: `<img src="{{asset('wa/whatsapp.svg')}}" />`,
        position: "right", //Position: left | right
        size: "50px"
    });

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
        if (document.body.scrollTop > 40 || document.documentElement.scrollTop > 40) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }

    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }

    // function initFreshChat() {
    //   window.fcWidget.init({
    //     token: "4a307164-690f-44ea-b930-f31ee9d818e3",
    //     host: "https://wchat.freshchat.com"
    //   });
    // }
    // function initialize(i,t){var e;i.getElementById(t)?initFreshChat():((e=i.createElement("script")).id=t,e.async=!0,e.src="https://wchat.freshchat.com/js/widget.js",e.onload=initFreshChat,i.head.appendChild(e))}function initiateCall(){initialize(document,"freshchat-js-sdk")}window.addEventListener?window.addEventListener("load",initiateCall,!1):window.attachEvent("load",initiateCall,!1);
  </script>
@stack('script')
</body>
</html>
