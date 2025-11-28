$(document).ready(function () {
    if ($('.js-news-slider').length) {
        $('.js-news-slider').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 4000,
            pauseOnHover: true,
            pauseOnFocus: false,
            arrows: true,
            dots: true,
            centerMode: true,
            centerPadding: '0px',
            adaptiveHeight: true,
            variableWidth: true, // カードの幅を固定するために有効化
            appendArrows: '.news__dots-wrapper', // 矢印をドットの横に配置
            appendDots: '.news__dots-wrapper', // ドットも同じコンテナに配置
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        centerMode: false
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        centerMode: true,
                        centerPadding: '20px'
                    }
                }
            ]
        });
    }
});

