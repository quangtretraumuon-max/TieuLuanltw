   <!-- Footer Section Begin -->
   <footer class="footer">
     <div class="container">
       <div class="row">
         <div class="col-lg-3 col-md-6 col-sm-6">
           <div class="footer__about">
             <div class="footer__logo">
               <a href="#"><img src="img/footer-logo.png" alt=""></a>
             </div>
             <p>The customer is at the heart of our unique business model, which includes design.</p>
             <a href="#"><img src="img/payment.png" alt=""></a>
           </div>
         </div>
         <div class="col-lg-2 offset-lg-1 col-md-3 col-sm-6">
           <div class="footer__widget">
             <h6>Shopping</h6>
             <ul>
               <li><a href="#">Clothing Store</a></li>
               <li><a href="#">Trending Shoes</a></li>
               <li><a href="#">Accessories</a></li>
               <li><a href="#">Sale</a></li>
             </ul>
           </div>
         </div>
         <div class="col-lg-2 col-md-3 col-sm-6">
           <div class="footer__widget">
             <h6>Shopping</h6>
             <ul>
               <li><a href="#">Contact Us</a></li>
               <li><a href="#">Payment Methods</a></li>
               <li><a href="#">Delivary</a></li>
               <li><a href="#">Return & Exchanges</a></li>
             </ul>
           </div>
         </div>
         <div class="col-lg-3 offset-lg-1 col-md-6 col-sm-6">
           <div class="footer__widget">
             <h6>NewLetter</h6>
             <div class="footer__newslatter">
               <p>Be the first to know about new arrivals, look books, sales & promos!</p>
               <form action="#">
                 <input type="text" placeholder="Your email">
                 <button type="submit"><span class="icon_mail_alt"></span></button>
               </form>
             </div>
           </div>
         </div>
       </div>
       <div class="row">
         <div class="col-lg-12 text-center">
           <div class="footer__copyright__text">
             <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
             <p>Copyright ©
               <script>
                 document.write(new Date().getFullYear());
               </script>2020
               All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
             </p>
             <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
           </div>
         </div>
       </div>
     </div>
   </footer>
   <!-- Footer Section End -->

   <!-- Search Begin -->
   <div class="search-model">
     <div class="h-100 d-flex align-items-center justify-content-center">
       <div class="search-close-switch">+</div>
       <form class="search-model-form">
         <input name="keywork" class="keywork" id="search-input" placeholder="Tìm kiếm">
         <?php if (isset($_SESSION['error_s'])) : ?>
           {
           echo "<script>
             alert('<?php echo $_SESSION['error_s'];unset($_SESSION['error_s']); ?>');
             location.href = 'index.php'
           </script>";
           }
         <?php endif; ?>
       </form>
     </div>
   </div>
   <!-- Search End -->
   <!-- Js Plugins -->
   <script src="<?php echo base_url() ?>public/frontend/js/jquery-3.3.1.min.js"></script>
   <script src="<?php echo base_url() ?>public/frontend/js/bootstrap.min.js"></script>
   <script src="<?php echo base_url() ?>public/frontend/js/jquery.nice-select.min.js"></script>
   <script src="<?php echo base_url() ?>public/frontend/js/jquery.nicescroll.min.js"></script>
   <script src="<?php echo base_url() ?>public/frontend/js/jquery.magnific-popup.min.js"></script>
   <script src="<?php echo base_url() ?>public/frontend/js/jquery.countdown.min.js"></script>
   <script src="<?php echo base_url() ?>public/frontend/js/jquery.slicknav.js"></script>
   <script src="<?php echo base_url() ?>public/frontend/js/mixitup.min.js"></script>
   <script src="<?php echo base_url() ?>public/frontend/js/owl.carousel.min.js"></script>
   <script src="<?php echo base_url() ?>public/frontend/js/main.js"></script>
   <script src="http://www.myersdaily.org/joseph/javascript/md5.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   </body>

   </html>
   <script type="text/javascript">
     $(function() {
       $hidenitem = $(".hidenitem");
       $itemproduct = $(".item-product");
       $itemproduct.hover(function() {
         $(this).children(".hidenitem").show(100);
       }, function() {
         $hidenitem.hide(500);
       })
     })
     $(function() {
       $updatecart = $(".updatecart");
       $updatecart.click(function(e) {
         e.preventDefault();
         $qty = $(this).parents("tr").find("#qty").val();
         $key = $(this).attr("data-key");
         $.ajax({
           url: 'update.php',
           type: 'GET',
           data: {
             'qty': $qty,
             'key': $key
           },
           success: function(data) {
             alert('Thành công');
             location.href = 'giohang.php';
           }
         });
       })
     })
   </script>
   <script>
     function isNumberKey(evt) {
       var charCode = (evt.which) ? evt.which : evt.keyCode
       if (charCode > 31 && (charCode < 48 || charCode > 57))
         return false;
       return true;
     }
   </script>
