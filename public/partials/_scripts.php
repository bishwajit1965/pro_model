 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

 <!-- Nivo slider -->
 <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
 <script type="text/javascript" src="nivo-slider/jquery.nivo.slider.js"></script> -->
 <!-- Scroll top -->
 <script src="js/scrolltop.js"></script>
 <!-- Google Map -->
 <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAogGV7rIQusJkmarj7c_5EHEyHAmu3emU&callback=myMap" type="text/javascript"></script>

 <!-- Sticky navbar -->
 <script>
     window.onscroll = function() {
         myFunction()
     };

     var navbar = document.getElementById("navbar");
     var sticky = navbar.offsetTop;

     function myFunction() {
         if (window.pageYOffset >= sticky) {
             navbar.classList.add("sticky")
         } else {
             navbar.classList.remove("sticky");
         }
     }
 </script>
 <!-- /Sticky navbar -->

 <script type="text/javascript">
     $(window).load(function() {
         $('#slider').nivoSlider();
     });
 </script>
 <script type="text/javascript">
     var _gaq = _gaq || [];
     _gaq.push(['_setAccount', 'UA-36251023-1']);
     _gaq.push(['_setDomainName', 'jqueryscript.net']);
     _gaq.push(['_trackPageview']);

     (function() {
         var ga = document.createElement('script');
         ga.type = 'text/javascript';
         ga.async = true;
         ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') +
             '.google-analytics.com/ga.js';
         var s = document.getElementsByTagName('script')[0];
         s.parentNode.insertBefore(ga, s);
     })();
 </script>
 <!-- Code injected by live-server -->
 <script type="text/javascript">
     // <![CDATA[  <-- For SVG support
     if ('WebSocket' in window) {
         (function() {
             function refreshCSS() {
                 var sheets = [].slice.call(document.getElementsByTagName("link"));
                 var head = document.getElementsByTagName("head")[0];
                 for (var i = 0; i < sheets.length; ++i) {
                     var elem = sheets[i];
                     var parent = elem.parentElement || head;
                     parent.removeChild(elem);
                     var rel = elem.rel;
                     if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
                         var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
                         elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date()
                             .valueOf());
                     }
                     parent.appendChild(elem);
                 }
             }
             var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
             var address = protocol + window.location.host + window.location.pathname + '/ws';
             var socket = new WebSocket(address);
             socket.onmessage = function(msg) {
                 if (msg.data == 'reload') window.location.reload();
                 else if (msg.data == 'refreshcss') refreshCSS();
             };
             if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
                 console.log('Live reload enabled.');
                 sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
             }
         })();
     } else {
         console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
     }
     // ]]>
 </script>
 <!-- /Nivo slider -->

 <!-- Google Map for Location -->
 <script>
     function myMap() {
         var mapProp = {
             center: new google.maps.LatLng(23.1697102, 89.213707),
             zoom: 15,
         };
         var map = new google.maps.Map(document.getElementById("map"), mapProp);
     }
 </script>
 <!-- /Google Map for Location -->
 <!-- Tooltip -->
 <script>
     $(document).ready(function() {
         $('[data-toggle="tooltip"]').tooltip();
     });
 </script>
 <!-- /Tooltip -->

 <?php ob_flush(); ?>