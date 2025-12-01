$(function () {
  $(".js-slider").slick({
    autoplay: false,
    dots: false,
    arrows: true,
    slidesToShow: 2.5,
    slidesToShow: 2,
    slidesToScroll: 1, 
    prevArrow: '<button class="slide-arrow prev-arrow"></button>',
    nextArrow: '<button class="slide-arrow next-arrow"></button>',
    responsive:[
      {
        breakpoint: 1000, // 768px以下（タブレット）
        settings: {
          slidesToShow: 1.5, // 1.5枚見せ
          dots: true         // ドットを表示
        }
      }
    ]
  });
});

