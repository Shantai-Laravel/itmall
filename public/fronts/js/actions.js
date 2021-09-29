$.ajaxSetup({
    headers: {
        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
    }
});

$(document).on('click', '#addMoreBlogs', function(e){
  const count = $('.itemBlog').length;
  const categoryId = $(this).data('id');
  $.ajax({
      type: "POST",
      url: '/en/blogs/addMoreBlogs',
      data: {count: count, categoryId: categoryId},
      success: function(data) {
          const res = JSON.parse(data);
          $('.blogs').html(res.blogs);
      }
  });

  e.preventDefault();
});

$(document).on('click', '.filterBlogs', function(e){
  const categoryId = $(this).data('id');
  $('#addMoreBlogs').data('id', categoryId);
  $.ajax({
      type: "POST",
      url: '/en/blogs/filterBlogs',
      data: {categoryId: categoryId},
      success: function(data) {
          const res = JSON.parse(data);
          $('.blogs').html(res.blogs);
      }
  });

  e.preventDefault();
});

$(document).on('click', '.addToWishList', function(e){
    const id = $(this).data('id');
    $('.addToWishList[data-id='+id+']').prop('disabled', true);
    $.ajax({
        type: "POST",
        url: '/en/addToWishList',
        data: { id: id },
        success: function(data) {
            const res = JSON.parse(data);
            $('.wishListBlock').html(res.wishListBlock);
            $('.wishListBox').html(res.wishListBox);
            $('.wishListCount').html(res.wishListCount);
            $('.addToWishList[data-id='+id+']').toggleClass('buttonMenuWishElements');
            $(".menuOpenWish").show(500);
            setTimeout(() => {
              $(".menuOpenWish").hide(500);
                $('.addToWishList[data-id='+id+']').prop('disabled', false);
            }, 3000);
        },
        error: function (data) {
          console.log('Error:', data);
        }
    });

    e.preventDefault();
});

$(document).on('click', '.deleteFromWishList', function(e){
    const id = $(this).data('id');
    const product_id = $(this).data('product_id');
    $.ajax({
        type: "POST",
        url: '/en/removeItemWishList',
        data: { id: id },
        success: function(data) {
            const res = JSON.parse(data);
            $('.wishListBlock').html(res.wishListBlock);
            $('.wishListBox').html(res.wishListBox);
            $('.wishListCount').html(res.wishListCount);
            $('.addToWishList[data-id='+product_id+']').removeClass('buttonMenuWishElements');
        },
        error: function (data) {
          console.log('Error:', data);
        }
    });

    e.preventDefault();
});

$(document).on('click', '.moveFromWishListToCart', function(e){
    e.preventDefault();
    let product_id = $(this).data('id');
    $.ajax({
        type: "POST",
        url: '/en/moveFromWishListToCart',
        data: { id: product_id },
        success: function(data) {
            let res = JSON.parse(data);
            $('.cartBox').html(res.cartBox);
            $('.cartCount').html(res.cartCount);
            $('.wishListBlock').html(res.wishListBlock);
            $('.wishListBox').html(res.wishListBox);
            $('.wishListCount').html(res.wishListCount);
        },
        error: function (data) {
          $('#modalError .message').html(JSON.parse(data.responseText).message);
          $('#modalError').modal('show');
        }
    });
});

$(document).on('click', '.modalToCart', function(e){
    const id = $(this).attr('data-id');
    $('.modalToCart[data-id='+id+']').prop('disabled', true);
    $.ajax({
        type: "POST",
        url: '/en/addToCart',
        data: {
            id : id
        },
        success: function(data) {
            const res = JSON.parse(data);
            $('.cartBlock').html(res.cartBlock);
            $('.cartBox').html(res.cartBox);
            $('.cartCount').html(res.cartCount);
            $('.modalToCart[data-id='+id+']').removeClass('buttonMenuCartElements').addClass('buttonMenuCartElements');
            $(".menuOpenCart").toggle(500);
            setTimeout(() => {
              $(".menuOpenCart").toggle(500);
              $('.modalToCart[data-id='+id+']').prop('disabled', false);
            }, 3000);
        },
        error: function (data) {
          console.log(JSON.parse(data.responseText));
          $('#modalError .message').html(JSON.parse(data.responseText).message);
          $('#modalError').modal('show');
        }
    });

    e.preventDefault();
});

$(document).on('click', '.deleteItemFromCart', function(e){
    const id = $(this).attr('data-id');
    const product_id = $(this).data('product_id');
    $.ajax({
        type: "POST",
        url: '/en/removeItemCart',
        data: {
            id: id,
        },
        success: function(data) {
            const res = JSON.parse(data);
            $('.cartBlock').html(res.cartBlock);
            $('.cartBox').html(res.cartBox);
            $('.cartCount').html(res.cartCount);
            $('.modalToCart[data-id='+product_id+']').removeClass('buttonMenuCartElements');
        }
    });

    e.preventDefault();
});

$(document).on('click', '.plus', function(e){
    const id = $(this).attr('data-id');

    $.ajax({
        type: "POST",
        url: '/en/cartQty/plus',
        data: {
            id: id
        },
        success: function(data) {
            const res = JSON.parse(data);
            $('.cartBlock').html(res.cartBlock);
            $('.cartBox').html(res.cartBox);
            $('.cartCount').html(res.cartCount);
        }
    });

    e.preventDefault();
});

$(document).on('click', '.minus', function(e){
    const id = $(this).attr('data-id');

    $.ajax({
        type: "POST",
        url: '/en/cartQty/minus',
        data: {
            id: id
        },
        success: function(data) {
            const res = JSON.parse(data);
            $('.cartBlock').html(res.cartBlock);
            $('.cartBox').html(res.cartBox);
            $('.cartCount').html(res.cartCount);
        }
    });

    e.preventDefault();
});

$('.search-field').on('keyup', function(){
    const val = $(this).val();

    if (val.length > 2) {
        $.ajax({
            type: "POST",
                url: '/en/search/autocomplete',
            data:{
                value: val,
            },
            success: function(data) {
                const res = JSON.parse(data);
                $('.searchResult').html(res);
            }
        });
    }else{
        $('.searchResult').html('');
    }
});

$(document).on('click', '.sortByHighPrice', function(event){
    const value = $('.searchInputs input[name="value"]').val();
    $.ajax({
        type: "POST",
        url: '/en/search/sort/highPrice',
        data: {value: value},
        success: function(data) {
            const res = JSON.parse(data);
            $('.searchBox').html(res.searchResults);
        }
    });
});

$(document).on('click', '.sortByLowPrice', function(event){
    const value = $('.searchInputs input[name="value"]').val();
    $.ajax({
        type: "POST",
        url: '/en/search/sort/lowPrice',
        data: {value: value},
        success: function(data) {
            const res = JSON.parse(data);
            $('.searchBox').html(res.searchResults);
        }
    });
});

$(document).on('click', '.promocodeAction', function(event){
    const promocode = $('.codPromo').val();

    $.ajax({
        type: "POST",
            url: '/en/cart/set/promocode',
        data: { promocode : promocode },
        success: function(data) {
            const res = JSON.parse(data);
            $('.cartBlock').html(res.cartBlock);
        }
    });
});

$(document).on('submit', '.feedBackPopup', function(e){
    e.preventDefault();

    const fullname = $(this).find('input[name="fullname"]').val();
    const phone = $(this).find('input[name="phone"]').val();
    const company = $(this).find('input[name="company"]').val();
    $.ajax({
        type: "POST",
        url: '/en/contacts/feedBackPopup',
        data: {
          fullname,
          phone,
          company
        },
        success: data => {
          $(this).find('.alert-success').html(data).css('display', 'block');
          $(this).find('.alert-danger').html('').css('display', 'none');
          $(this).find('input').attr('disabled', true);
          setTimeout(() => {
            $(this).find('input').attr('disabled', false);
            $(this).find('input').not(':input[type=submit]').val('');
            $(this).find('.alert-success').html('').css('display', 'none');
            $('#modalForm').modal('hide');
          }, 2000);
        },
        error: err => {
          $(this).find('.alert-success').html('').css('display', 'none');
          $(this).find('.alert-danger').html(err.responseJSON.errors.join('<br>')).css('display', 'block');
        }
    });
});
