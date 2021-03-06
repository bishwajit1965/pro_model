 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
 <!-- CK Editor -->
<script src="../admin/bower_components/ckeditor/ckeditor.js"></script>
<!-- CK Editor -->
 <!-- Scroll top -->
 <script src="js/scrolltop.js"></script>

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
<!-- CK Editor -->
<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1')
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5()
  })
</script>
<!-- /CK Editor -->

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

 <!-- Tooltip -->
 <script>
     $(document).ready(function() {
         $('[data-toggle="tooltip"]').tooltip();
     });
 </script>
 <!-- /Tooltip -->
 <!-- Fade out bootstrap alert messages -->
<script type="text/javascript">
  $(document).ready(function () {
  window.setTimeout(function() {
      $(".alert").fadeTo(1000, 0).slideUp(1000, function(){
          $(this).remove();
      });
  }, 3000);
  });
</script>
<!-- /Fade out bootstrap alert messages -->

<?php ob_flush(); ?>