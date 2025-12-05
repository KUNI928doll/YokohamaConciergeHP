$(document).ready(function () {
    const slickOptions = {
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 4000,
        pauseOnHover: true,
        pauseOnFocus: false,
        arrows: true,
        dots: true,
        centerMode: false,
        adaptiveHeight: true,
        infinite: true,
        appendArrows: '.news__dots-wrapper',
        appendDots: '.news__dots-wrapper',
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    centerMode: false,
                    infinite: true
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    centerMode: false,
                    infinite: true
                }
            }
        ]
    };

    let allCards = [];

    if ($('.js-news-slider').length) {
        $('.news__card').each(function() {
            allCards.push({
                element: $(this).clone(true),
                category: $(this).attr('data-category')
            });
        });

        // 記事がある場合のみスライダーを初期化
        if (allCards.length > 0) {
            $('.js-news-slider').slick(slickOptions);
        } else {
            // 記事がない場合は非表示にしてメッセージを表示
            $('.js-news-slider').hide();
            $('.news__dots-wrapper').hide();
            $('.news__btn-wrapper').hide();
            $('.news__filter').after('<p class="news__empty-message">現在、お知らせ・イベントはありません。</p>');
        }
    }

    $('input[name="news-filter"]').on('change', function () {
        const filterValue = $(this).val();
        const $slider = $('.js-news-slider');

        if ($slider.hasClass('slick-initialized')) {
            $slider.slick('unslick');
        }

        $slider.empty();

        let displayCount = 0;

        allCards.forEach(function(card) {
            if (filterValue === 'all' || card.category === filterValue) {
                $slider.append(card.element.clone(true));
                displayCount++;
            }
        });

        if (displayCount > 0) {
            const adjustedOptions = {...slickOptions};
            
            // カード数が3枚以下の場合はinfiniteをfalseに
            if (displayCount <= 3) {
                adjustedOptions.infinite = false;
            }
            
            $slider.slick(adjustedOptions);
            
            // スライダーとボタンを表示
            $slider.show();
            $('.news__dots-wrapper').show();
            $('.news__btn-wrapper').show();
            $('.news__empty-message').remove();
        } else {
            // 投稿がない場合はスライダーとボタンを非表示
            $slider.hide();
            $('.news__dots-wrapper').hide();
            $('.news__btn-wrapper').hide();
            
            // 空のメッセージを表示（まだ存在しない場合のみ）
            if (!$('.news__empty-message').length) {
                $('.news__filter').after('<p class="news__empty-message">該当する投稿がありません。</p>');
            }
        }
    });
});
