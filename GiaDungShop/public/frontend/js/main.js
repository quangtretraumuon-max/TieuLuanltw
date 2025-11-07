/*  ---------------------------------------------------
    Template Name: Male Fashion
    Description: Male Fashion - ecommerce teplate
    Author: Colorib
    Author URI: https://www.colorib.com/
    Version: 1.0
    Created: Colorib
---------------------------------------------------------  */

'use strict';

(function ($) {

  /*------------------
      Preloader
  --------------------*/
  $(window).on('load', function () {
    $(".loader").fadeOut();
    $("#preloder").delay(200).fadeOut("slow");

    /*------------------
        Gallery filter
    --------------------*/
    $('.filter__controls li').on('click', function () {
      $('.filter__controls li').removeClass('active');
      $(this).addClass('active');
    });
    if ($('.product__filter').length > 0) {
      var containerEl = document.querySelector('.product__filter');
      var mixer = mixitup(containerEl);
    }
  });

  /*------------------
      Background Set
  --------------------*/
  $('.set-bg').each(function () {
    var bg = $(this).data('setbg');
    $(this).css('background-image', 'url(' + bg + ')');
  });

  //Search Switch
  $('.search-switch').on('click', function () {
    $('.search-model').fadeIn(400);
  });

  $('.search-close-switch').on('click', function () {
    $('.search-model').fadeOut(400, function () {
      $('#search-input').val('');
    });
  });

  /*------------------
      Navigation
  --------------------*/
  $(".mobile-menu").slicknav({
    prependTo: '#mobile-menu-wrap',
    allowParentLinks: true
  });

  /*------------------
      Accordin Active
  --------------------*/
  $('.collapse').on('shown.bs.collapse', function () {
    $(this).prev().addClass('active');
  });

  $('.collapse').on('hidden.bs.collapse', function () {
    $(this).prev().removeClass('active');
  });

  //Canvas Menu
  $(".canvas__open").on('click', function () {
    $(".offcanvas-menu-wrapper").addClass("active");
    $(".offcanvas-menu-overlay").addClass("active");
  });

  $(".offcanvas-menu-overlay").on('click', function () {
    $(".offcanvas-menu-wrapper").removeClass("active");
    $(".offcanvas-menu-overlay").removeClass("active");
  });

  /*-----------------------
      Hero Slider
  ------------------------*/
  $(".hero__slider").owlCarousel({
    loop: true,
    margin: 0,
    items: 1,
    dots: false,
    nav: true,
    navText: ["<span class='arrow_left'><span/>", "<span class='arrow_right'><span/>"],
    animateOut: 'fadeOut',
    animateIn: 'fadeIn',
    smartSpeed: 1200,
    autoHeight: false,
    autoplay: false
  });

  /*--------------------------
      Select
  ----------------------------*/
  $("select").niceSelect();

  /*-------------------
      Radio Btn
  --------------------- */
  // $(".product__color__select label, .shop__sidebar__size label, .product__details__option__size label").on('click', function () {
  //     $(".product__color__select label, .shop__sidebar__size label, .product__details__option__size label").removeClass('active');
  //     $(this).addClass('active');
  // });
  $(document).on('click', '.color__select, .product__details__option__size label', function () {
    $(".product__color__select label, .shop__sidebar__size label, .product__details__option__size label").removeClass('active');
    $(this).addClass('active');
  });
  /*-------------------
      Scroll
  --------------------- */
  $(".nice-scroll").niceScroll({
    cursorcolor: "#0d0d0d",
    cursorwidth: "5px",
    background: "#e5e5e5",
    cursorborder: "",
    autohidemode: true,
    horizrailenabled: false
  });

  /*------------------
      CountDown
  --------------------*/
  // For demo preview start
  var today = new Date();
  var dd = String(today.getDate()).padStart(2, '0');
  var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
  var yyyy = today.getFullYear();

  if (mm == 12) {
    mm = '01';
    yyyy = yyyy + 1;
  } else {
    mm = parseInt(mm) + 1;
    mm = String(mm).padStart(2, '0');
  }
  var timerdate = mm + '/' + dd + '/' + yyyy;
  // For demo preview end


  // Uncomment below and use your date //

  /* var timerdate = "2020/12/30" */

  $("#countdown").countdown(timerdate, function (event) {
    $(this).html(event.strftime("<div class='cd-item'><span>%D</span> <p>Days</p> </div>" + "<div class='cd-item'><span>%H</span> <p>Hours</p> </div>" + "<div class='cd-item'><span>%M</span> <p>Minutes</p> </div>" + "<div class='cd-item'><span>%S</span> <p>Seconds</p> </div>"));
  });

  /*------------------
      Magnific
  --------------------*/
  $('.video-popup').magnificPopup({
    type: 'iframe'
  });

  /*-------------------
      Quantity change
  --------------------- */
  var proQty = $('.pro-qty');
  proQty.prepend('<span class="fa fa-angle-up dec qtybtn"></span>');
  proQty.append('<span class="fa fa-angle-down inc qtybtn"></span>');
  proQty.on('click', '.qtybtn', function () {
    var $button = $(this);
    var oldValue = $button.parent().find('input').val();
    if ($button.hasClass('inc')) {
      if (oldValue > 0) {
        var newVal = parseFloat(oldValue) - 1;
      } else {
        newVal = 0;
      }
    } else {
      var newVal = parseFloat(oldValue) + 1;
    }
    $button.parent().find('input').val(newVal);
  });

  const formatNumber = num => {
    var format = new Number(num).toLocaleString("id-ID");
    return format;
  }
  //change to class
  fetchCart();
  updatecart();
  fetchPayment();

  $(document).on('click', '.addToCart', function () {
    var size = $(".size:checked").val();
    var color = $(".color:checked").val();
    var qty = $('.cart-qty').val();
    var id = $('.id').val();
    var category = $('.category').val();
    var name = $('.name').val();
    var product_number = $('.product-number').val();
    var price = $('.price-cart').val();
    if (size == null) {
      var toastMixin = Swal.mixin({
        toast: true,
        icon: 'error',
        title: 'General Title',
        animation: false,
        position: 'bottom',
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      });
      toastMixin.fire({
        animation: true,
        title: 'Vui lòng chọn size áo !!!'
      });
      return;
    }
    if (color == null) {
      var toastMixin = Swal.mixin({
        toast: true,
        icon: 'error',
        title: 'General Title',
        animation: false,
        position: 'bottom',
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      });
      toastMixin.fire({
        animation: true,
        title: 'Vui lòng chọn màu áo !!!'
      });
      return;
    }
    if (product_number <= 0) {
      var toastMixin = Swal.mixin({
        toast: true,
        icon: 'error',
        title: 'General Title',
        animation: false,
        position: 'top-right',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      });
      toastMixin.fire({
        animation: true,
        title: 'Số lượng ' + name + 'trong kho còn ' + product_number
      });
      return;
    }
    var cart = localStorage.getItem("cart");
    var index = md5(id + color + size);
    var pcart = JSON.parse(cart) != null ? JSON.parse(cart) : [];
    var present_or_not = pcart.findIndex(item => item.session_id == index);
    if (cart == null || present_or_not == null || present_or_not == -1) {
      var product = {
        session_id: index,
        id: id,
        price: price,
        qty: qty,
        category: category,
        size: size,
        color: color,
        name: name
      };
      pcart.push(product);
      localStorage.setItem("cart", JSON.stringify(pcart));
    } else {
      var actual_stored_product = pcart[present_or_not];
      pcart.splice(present_or_not, 1);
      var actual_qty = actual_stored_product.qty == null || actual_stored_product.qty == "" ? 0 : actual_stored_product.qty;
      actual_stored_product.qty = parseInt(actual_qty) + parseInt(qty);
      pcart.push(actual_stored_product);
      localStorage.setItem("cart", JSON.stringify(pcart));
    }
    var toastMixin = Swal.mixin({
      toast: true,
      icon: 'success',
      title: 'General Title',
      animation: false,
      position: 'top-right',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
    });
    toastMixin.fire({
      animation: true,
      title: name + ' đã được thêm vào giỏ hàng !!!'
    });
    updatecart();
  });

  $(document).on('click', '#thanhtoan', function () {
    Payment($(this));
  });

  $(document).on('click', '#momo', function () {
    Momo();
  })

  $(document).on('click', '#register', function () {
    Register($(this));
  })

  function updatecart() {
    var cartstring = localStorage.getItem("cart");
    if (cartstring) {
      var cart = JSON.parse(cartstring);
      var cartlength = cart.length;
      if (cart == null || cart.length == 0) {
        $(".cart-total").html('0');
      } else {
        $(".cart-total").html(cartlength);
      }
      fetchCart();
    }
  }

  function fetchPayment() {
    var carts = localStorage.getItem('cart');
    if (carts) {
      $.ajax({
        url: 'get-cart.php',
        type: 'POST',
        data: {
          carts: carts
        },
        success: function (res) {
          var html = '';
          var carts = JSON.parse(res);
          var products = JSON.parse(carts.split(","));
          for (let i = 0; i < products.length; i++) {
            html += '<li class="d-flex"><p class="mb-0">' + products[i].name + '</p> <span class="ml-3">' + formatNumber(products[i].price * products[i].qty) + '</span></li>';
          }
          $('#checkout__total_products').html(html);
        }
      });
    }
  }

  function fetchCart() {
    var carts = localStorage.getItem('cart');
    if (carts) {
      $.ajax({
        url: 'get-cart.php',
        type: 'POST',
        data: {
          carts: carts
        },
        success: function (res) {
          var html = '';
          var carts = JSON.parse(res);
          var total = 0;
          var products = JSON.parse(carts.split(","));
          for (let i = 0; i < products.length; i++) {
            var subtotal = products[i].price * products[i].qty;
            total += subtotal;
            html += '<tr>\
                        <input type="hidden" class="session_id" value="' + products[i].session_id + '">\
                        <td class="product__cart__item">\
                          <div class="product__cart__item__pic">\
                            <img src="img/shopping-cart/cart-1.jpg" alt="">\
                          </div>\
                          <div class="product__cart__item__text">\
                            <h6>' + products[i].name + '</h6>\
                            <div class="d-flex align-items-center">\
                              <h5 class="price-ajax">' + formatNumber(products[i].price) + 'đ</h5>\
                              <span class="ml-3">(Size: ' + products[i].size + ', Color: ' + products[i].color + ')</span>\
                            </div>\
                          </div>\
                        </td>\
                        <td class="quantity__item">\
                          <div class="quantity">\
                             <div class="pro-qty-2">\
                                <input type="number" class="qty-ajax" value="' + products[i].qty + '" min="1" id="qty" oninput="this.value = Math.abs(this.value)">\
                             </div>\
                          </div>\
                        </td>\
                        <td class="cart__price"><input style="border: none;" type="text" readonly class="subtotal-ajax" value="' + formatNumber(products[i].price * products[i].qty) + '" oninput="this.value = Math.abs(this.value)"></td>\
                        <td class="cart__close"><i class="fa fa-close cursor delete-item" data-session_id="' + products[i].session_id + '"></i></td>\
                       </tr>';
          }
          $('#cart-local').html(html);
          $('.total-money').html(formatNumber(total) + ' đ');
        }
      });
    }
  }

  function Momo() {
    var carts = localStorage.getItem('cart');
    if (!carts) {
      var toastMixin = Swal.mixin({
        toast: true,
        icon: 'error',
        title: 'General Title',
        animation: false,
        position: 'top-right',
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      });
      toastMixin.fire({
        animation: true,
        title: 'Không có gì trong giỏ hàng !!!'
      }).then(function () {
        location.href = 'index.php';
      });
      return;
    }
    $.ajax({
      url: 'xu-li-cart.php',
      type: 'POST',
      data: {
        carts: carts,
      },
      success: function (res) {
        var res = JSON.parse(res);
        localStorage.removeItem('cart');
        if (res.code === 200) {
          window.open('http://localhost/FashionShop/thanh-toan-momo.php');
        }
      }
    });
  }

  function Payment(value) {
    var id = $('.checkout__id').val();
    var name = $('.checkout__name').val();
    var address = $('.checkout__address').val();
    var email = $('.checkout__email').val();
    var phone = $('.checkout__phone').val();
    var carts = localStorage.getItem('cart');
    $.ajax({
      url: 'thanhtoan.php',
      type: 'POST',
      data: {
        carts: carts,
        id: id,
        name: name,
        email: email,
        address: address,
        phone: phone
      },
      success: function (res) {
        var code = JSON.parse(res);
        if (code.code === 200) {
          localStorage.removeItem('cart');
          var toastMixin = Swal.mixin({
            toast: true,
            icon: 'success',
            title: 'General Title',
            animation: false,
            position: 'top-right',
            showConfirmButton: false,
            timer: 1000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
          });
          toastMixin.fire({
            animation: true,
            title: 'Xác nhận mua hàng thành công! Đơn hàng của bạn sẽ được giao đến bạn trong thời gian sớm nhất !!!'
          }).then(function () {
            location.href = 'index.php';
          });
        }
      }
    });
  }

  function Register(btn) {
    var attr = btn.closest('.col-lg-12.col-md-12.register');
    var name = attr.find('.register_name').val();
    var address = attr.find('.register_address').val();
    var phone = attr.find('.register_phone').val();
    var email = attr.find('.register_email').val();
    var password = attr.find('.register_password').val();
    $.ajax({
      url: 'register.php',
      type: 'POST',
      data: {
        name: name,
        email: email,
        address: address,
        phone: phone,
        password: password,
      },
      success: function (res) {
        var res = JSON.parse(res);
        if (res.code == 404) {
          var toastMixin = Swal.mixin({
            toast: true,
            icon: 'error',
            title: 'General Title',
            animation: false,
            position: 'top-right',
            showConfirmButton: false,
            timer: 1000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
          });
          toastMixin.fire({
            animation: true,
            title: res.message
          });
          return;
        }
        if (res.code == 200) {
          var toastMixin = Swal.mixin({
            toast: true,
            icon: 'success',
            title: 'General Title',
            animation: false,
            position: 'top-right',
            showConfirmButton: false,
            timer: 1000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
          });
          toastMixin.fire({
            animation: true,
            title: res.message
          }).then(function () {
            location.href = 'dang-nhap.php';
          });
        }
      }
    });
  }

  $(document).on('click', '.delete-item', function () {
    var session_id = $(this).data('session_id');
    var carts = localStorage.getItem('cart');
    var products = JSON.parse(carts);
    for (var i = 0; i < products.length; i++) {
      if (products[i]['session_id'] === session_id) {
        const cart = JSON.parse(localStorage.cart ?? "[]")
        localStorage.cart = JSON.stringify(products.slice(products[i], -1));
      }
    }
    fetchCart();
    updatecart();
  });

  $(document).on('click', '.add', function () {
    addQuantity($(this));
  });

  $(document).on('click', '.sub', function () {
    subQuantity($(this));
  });

  $(document).on('keyup', ".qty-ajax", function () {
    updateQuantity($(this));
  });

  function updateQuantity(qty) {
    var cartRow = $(qty).closest('tr');
    var session_id = $('.session_id', cartRow).val();
    var price = parseFloat($('.price-ajax', cartRow).text());
    var $quantity = $('.qty-ajax', cartRow);
    var current = parseInt($quantity.val());
    var subtotal = $('.subtotal-ajax', cartRow);
    $quantity.val(current)
    subtotal.val(formatNumber(price * current * 1000));
    var products = JSON.parse(localStorage.getItem('cart'));
    for (var i = 0; i < products.length; i++) {
      if (products[i]['session_id'] === session_id) {
        products[i]['qty'] = current;
      }
      localStorage.setItem('cart', JSON.stringify(products));
    }
    fetchCart();
  }

  $(document).on('click', '#login', function () {
    var email = $('.email').val();
    var password = $('.password').val();
    $.ajax({
      url: 'login.php',
      type: 'POST',
      data: {
        email: email,
        password: password,
      },
      success: function (res) {
        var res = JSON.parse(res);
        console.log(res);
        if (res.code == 200) {
          var toastMixin = Swal.mixin({
            toast: true,
            icon: 'success',
            title: 'General Title',
            animation: false,
            position: 'top-right',
            showConfirmButton: false,
            timer: 1000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
          });
          toastMixin.fire({
            animation: true,
            title: res.message
          }).then(function () {
            location.href = 'index.php';
          });
        }
        if (res.code == 404) {
          var toastMixin = Swal.mixin({
            toast: true,
            icon: 'error',
            title: 'General Title',
            animation: false,
            position: 'top-right',
            showConfirmButton: false,
            timer: 1000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
          });
          toastMixin.fire({
            animation: true,
            title: res.message
          });
          return;
        }
      }
    });
  });

  // function addQuantity(addButton) {
  //     var cartRow = $(addButton).closest('tr');
  //     var price = parseFloat($('.price-ajax', cartRow).text());
  //     var session_id = $('.session_id', cartRow).val();
  //     var $quantity = $('.qty-ajax', cartRow);
  //     var current = parseInt($quantity.val());
  //     var subtotal = $('.subtotal-ajax', cartRow);
  //     $quantity.val(current + 1)
  //     subtotal.val(formatNumber(price * (current + 1) * 1000));
  //     var products = JSON.parse(localStorage.getItem('cart'));
  //     for (var i = 0; i < products.length; i++) {
  //         if (products[i]['session_id'] == session_id) {
  //             products[i]['qty'] = current;
  //             console.log(products[i]['qty']);
  //         }
  //     }
  //     localStorage.setItem('cart', JSON.stringify(products));
  // }

  // function subQuantity(subButton) {
  //     var cartRow = $(subButton).closest('tr');
  //     var price = parseFloat($('.price-ajax', cartRow).text());
  //     var session_id = $('.session_id', cartRow).val();
  //     var $quantity = $('.qty-ajax', cartRow);
  //     var current = parseInt($quantity.val());
  //     var subtotal = $('.subtotal-ajax', cartRow);

  //     if (current > 0) {
  //         $quantity.val(current - 1)
  //         subtotal.val(formatNumber(price * (current - 1) * 1000));
  //     } else {
  //         subtotal.val(0);
  //     }
  //     var products = JSON.parse(localStorage.getItem('cart'));
  //     for (var i = 0; i < products.length; i++) {
  //         if (products[i]['session_id'] == session_id) {
  //             products[i]['qty'] = current;
  //         }
  //     }
  //     localStorage.setItem('cart', JSON.stringify(products));
  // }


  /*------------------
      Achieve Counter
  --------------------*/
  $('.cn_num').each(function () {
    $(this).prop('Counter', 0).animate({
      Counter: $(this).text()
    }, {
      duration: 4000,
      easing: 'swing',
      step: function (now) {
        $(this).text(Math.ceil(now));
      }
    });
  });

})(jQuery);
