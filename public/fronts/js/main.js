$(document).ready(function(){
  var buttonBurger = $(".burger");
  var buttonSearch = $(".buttonMenuSearch");
  var buttonProfile = $(".buttonMenuProfile");
  var buttonWish = $(".buttonMenuWish");
  var buttonCart = $(".buttonMenuCart");
  var buttonLang = $(".buttonMenuLang");
  var buttonClose = $(".closeMenu");
  var openBurger = $(".menuOpenBurger");
  var openBurgerMobile = $(".menuOpenBurgerMobile");
  var openSearch = $(".menuOpenSearch");
  var openProfile = $(".menuOpenProfile");
  var openWish = $(".menuOpenWish");
  var openCart = $(".menuOpenCart");
  var openLang = $(".menuOpenLang");
  var openMenu = $(".menuOpen");
  var retNav = $(".retNav");
  $(buttonBurger).click(function(){
    openBurger.toggle(500);
    openBurgerMobile.toggle(500);
  });

  $(buttonSearch).click(function(){
    openSearch.toggle(500);
  });
  $(buttonLang).click(function(){
    openLang.toggle(500);
  });
  $(buttonProfile).click(function(){
    openProfile.toggle(500);
  });
  $(document).on('click', ".buttonMenuWish", function(){
    openWish.toggle(500);
  });
  $(document).on('click', ".buttonMenuCart", function(){
    openCart.toggle(500);
  });
  $(buttonClose).click(function(){
    $(this).parent().parent().parent().hide(500);
  });
  $(document).mouseup(function (e)
  {
      if (!buttonBurger.is(e.target)
          && !openBurger.is(e.target)
          && openBurger.has(e.target).length === 0)
        {
          openBurger.hide(500);
        }
    });
    $(document).mouseup(function (e)
    {
        if (!buttonLang.is(e.target)
            && !openLang.is(e.target)
            && openLang.has(e.target).length === 0)
          {
            openLang.hide(500);
          }
      });
    $(document).mouseup(function (e)
    {
        if (!buttonBurger.is(e.target)
            && !openBurgerMobile.is(e.target)
            && openBurgerMobile.has(e.target).length === 0)
          {
            openBurgerMobile.hide(500);
          }
      });
    $(document).mouseup(function (e)
    {
        if (!buttonSearch.is(e.target)
            && !openSearch.is(e.target)
            && openSearch.has(e.target).length === 0)
          {
            openSearch.hide(500);
          }
      });
      $(document).mouseup(function (e)
      {
          if (!buttonProfile.is(e.target)
              && !openProfile.is(e.target)
              && openProfile.has(e.target).length === 0)
            {
              openProfile.hide(500);
            }
        });
        $(document).mouseup(function (e)
        {
            if (!buttonCart.is(e.target)
                && !openCart.is(e.target)
                && openCart.has(e.target).length === 0)
              {
                openCart.hide(500);
              }
          });
          $(document).mouseup(function (e)
          {
              if (!buttonWish.is(e.target)
                  && !openWish.is(e.target)
                  && openWish.has(e.target).length === 0)
                {
                  openWish.hide(500);
                }
            });
 });
 $(document).ready(function(){
 $('.slideMain').slick({
   slidesToShow: 1,
   slidesToScroll: 1,
   autoplaySpeed: 2000,
   arrows: true,
   autoplay: true,
   arrows: false,
   dots: false,
   asNavFor: '.slideNav'
 });
 });
 $(document).ready(function(){
 $('.slideNav').slick({
   slidesToShow: 1,
   slidesToScroll: 1,
   arrows: true,
   dots: false,
   asNavFor: '.slideMain',
   focusOnSelect: true
 });
 });
 $(document).ready(function(){
   $('.strategySlide').slick({
     slidesToShow: 1,
     slidesToScroll: 1,
     arrows: false,
     dots: true,
     focusOnSelect: true,
     variableWidth: true,
     centerMode: true,
     responsive: [
      {
        breakpoint: 768,
        settings: {
          arrows: false,
          centerMode: true,
          slidesToShow: 1
        }
      }
    ]
   });
   $('.brandingPresentationSlide').slick({
     slidesToShow: 1,
     slidesToScroll: 1,
     arrows: false,
     dots: true,
     focusOnSelect: true,
     variableWidth: true,
     centerMode: true,
     responsive: [
      {
        breakpoint: 768,
        settings: {
          arrows: false,
          centerMode: true,
          slidesToShow: 1
        }
      }
    ]
   });
 $('.slideOneProduct').slick({
   slidesToShow: 3,
   slidesToScroll: 3,
   arrows: false,
   dots: true,
   focusOnSelect: true,
   responsive: [
    {
      breakpoint: 768,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 1
      }
    }
  ]
 });
 $('.slideServ').slick({
   slidesToShow: 2,
   slidesToScroll: 1,
   autoplay: true,
   autoplaySpeed: 5000,
   arrows: true,
   dots: true,
   focusOnSelect: false,
   variableWidth: true,
   centerMode: true,
   responsive: [
     {
       breakpoint: 1400,
       settings: {
         centerMode: true,
         centerPadding: '40px',
         slidesToShow: 2
       }
     },
    {
      breakpoint: 768,
      settings: {
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 1
      }
    }
  ]
 });
 $('.slideTrenBranding').slick({
   slidesToShow: 1,
   slidesToScroll: 1,
   arrows: true,
   dots: false,
   focusOnSelect: false,
   variableWidth: false
 });
 $('.crmSlide').slick({
   slidesToShow: 1,
   slidesToScroll: 1,
   arrows: true,
   dots: false,
   focusOnSelect: false,
   variableWidth: false
 });
 });

 $(document).ready(function() {
   var link = $('.presentation').find('a');
  var linkAbout = $('.aboutUs').children('.aboutEcommerce').find('a');
  $(link).attr({
    'data-toggle': "modal",
    'data-target': "#modalForm"
  })
  $(linkAbout).attr({
    'data-toggle': "modal",
    'data-target': "#modalForm"
  })
 })
 $(document).ready(function() {
  setTimeout(function(){
    $('.posFixed').children('h3').css('opacity', '1');
    $('.posFixed').children('h3').addClass('animated fadeInDown');
  }, 20);
  setTimeout(function(){
    $('.slideServ').css('opacity', '1');
    $('.slideServ').addClass('animated fadeInLeft');
  }, 1000);
      var ul = $('.itemServDescr').children('ul');
      var maxHeight = 0;
      for(var i = 0; i < ul.length; i++){
        heig = $(ul[i]).height();
        if(heig > maxHeight){
          maxHeight = heig;
        }
      }
      $(ul).css('height', maxHeight + 'px')
      $('.itemServ a').hover(function () {
        $(this).children('.nameHover').children('div').addClass('animated fadeInUp');
      });
      $('.itemServ a').mouseleave(function () {
        $(this).children('.nameHover').children('div').removeClass('fadeInUp');
      });
  var bic = $('#dat').pageY;
})
 $().ready(function(){

   $('.plus').on('click', function(){
       man = $(this).prev().prev().val();
       man++;
       $(this).prev().prev().val(man);
   });
   $('.minus').on('click', function(){
       men = $(this).prev().val();
       if(men > 1){
       men--;
       $(this).prev().val(men);
     }
   });
   });
   $(document).ready(function(){
     $(".option").click(function(){
       $(this).next(".optionOpen").animate({
         height: "toggle"
       });
       $(this).toggleClass('submenuBcgMinus');
     });
   });
   $(document).ready(function(){
     $(".chCat").click(function(){
       $(this).next(".chooseCatOpenMob").animate({
         height: "toggle"
       });
     });
     });
   $(document).mouseup(function (e)
   {
       var container = $(".chooseCatOpenMob");
       if (!$(".chCat").is(e.target)
           && !container.is(e.target)
           && container.has(e.target).length === 0)
       {
           container.hide(500);
       }
   });
   $(document).ready(function(){
     $(".chCat2").click(function(){
       $(this).next(".chooseCatOpenMob2").animate({
         height: "toggle"
       });
     });
   });
   $(document).mouseup(function (e)
   {
       var container = $(".chooseCatOpenMob2");
       if (!$(".chCat2").is(e.target)
           && !container.is(e.target)
           && container.has(e.target).length === 0)
       {
           container.hide(500);
       }
   });
   $(document).ready(function(){
     $(".btnBlog").click(function(){
       $(this).next(".blogOptions").animate({
         height: "toggle"
       });
       $(this).toggleClass('submenuBcgMinus');
     });
   });
   $(document).mouseup(function (e)
   {
       var container = $(".blogOptions");
       if (!$(".btnBlog").is(e.target)
           && !container.is(e.target)
           && container.has(e.target).length === 0)
       {
           container.hide(200);
           $(".btnBlog").removeClass('submenuBcgMinus');
       }
   });
   $(document).ready(function(){
     $(".strUp").click(function(){
       $(this).next(".headerItem").children('.productNone').animate({
         height: "toggle"
       });
       $(this).toggleClass('strDown');
     });
   });
   $(document).ready(function(){
     $(".btnView").click(function(){
       $(this).parent().next(".contentItem").animate({
         height: "toggle"
       });
       $(this).toggleClass('viewUp');
     });
   });
   // $(document).ready(function(){
   //   $(".pn").css('top', '100px');
   // });
   // $(document).ready(function(){
   //   $(".pn2").css('top', '50px');
   // });
   // $(document).ready(function(){
   //   $(".pn3").css('top', '10px');
   // });
var gambiy = true;
var tamb = function()
    {
        $('.t1').addClass('top1');
        $('.t2').addClass('top2');
        $('.t3').addClass('top3');
        $('.t4').addClass('top4');
        $('.t5').addClass('top5');
        $('.t6').addClass('top6');
        gambiy = false;
    }
var back = function(){
  $('.t1').removeClass('top1');
  $('.t2').removeClass('top2');
  $('.t3').removeClass('top3');
  $('.t4').removeClass('top4');
  $('.t5').removeClass('top5');
  $('.t6').removeClass('top6');
  gambiy = true;
}
   $(document).ready(function(){
     tamb();
    var timerId = setInterval(function(){
      if(gambiy){
        tamb();
      }
      else{
        back();
      }
    }, 9000);
});

$(document).ready(function(){
    if(screen.width < 768){
      $(".menuOpenBurger").remove();
    }
    if(screen.width > 768){
      $(".menuOpenBurgerMobile").remove();
    }
});
function man(){
  $(".navItemOpenMob").css('display', 'none');
  $(".navItemMob").removeClass('bcgMinus');
}
function openNav(event){
  var n = $(".navItem").children('div').children('div').children('div').children('div').children('a');
  if(event.target.classList.length < 2 && !n.is(event.target)){
    man();
    event.target.classList.add('bcgMinus');
    event.target.children[0].style.display = 'block';
  }
  else if(event.target.classList.length > 1){
    event.target.classList.remove('bcgMinus');
    event.target.children[0].style.display = 'none';
  }
}
$(document).mouseup(function (e)
{
    var container = $(".navItemOpen");
    if (!$(".navItem").is(e.target)
        && !container.is(e.target)
        && container.has(e.target).length === 0)
    {
        container.hide(200);
    }
});
