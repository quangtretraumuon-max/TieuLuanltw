$(document).ready(function () {
  $(document).on('click', '#checkoutJS', function () {
    Checkout($(this));
  });
});

var Checkout = function (x) {
  $.ajax({
    url: 'check.php',
    type: 'GET',
    contentType: 'application/json',
    success: function (res) {
        if (res.code === 200) {
            window.location.href = x.attr('href');
        }
        if (res.code === 403) {
            alert('You must be logged in to use this function !!!');
        }
    }
  });
}
