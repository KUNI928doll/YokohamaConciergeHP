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
        centerMode: true,
        centerPadding: '0px',
        adaptiveHeight: true,
        variableWidth: true,
        appendArrows: '.news__dots-wrapper',
        appendDots: '.news__dots-wrapper',
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
    };

    // 全てのカードを保存（初回のみ）
    let allCards = [];
    
    // 初回スライダー初期化
    if ($('.js-news-slider').length) {
        // 全カードを保存
        $('.news__card').each(function() {
            allCards.push({
                element: $(this).clone(true),
                category: $(this).attr('data-category')
            });
        });
        
        $('.js-news-slider').slick(slickOptions);
    }

    // フィルター機能
    $('input[name="news-filter"]').on('change', function () {
        const filterValue = $(this).val();
        const $slider = $('.js-news-slider');
        
        console.log('=== フィルター変更 ===');
        console.log('選択されたフィルター:', filterValue);
        
        // スライダーを破棄
        if ($slider.hasClass('slick-initialized')) {
            console.log('スライダーを破棄');
            $slider.slick('unslick');
        }

        // スライダー内のカードを全削除
        $slider.empty();
        console.log('全カードを削除');

        // フィルタリングして再追加
        let displayCount = 0;
        allCards.forEach(function(card, index) {
            console.log(`カード${index + 1}: カテゴリー="${card.category}"`);
            
            if (filterValue === 'all' || card.category === filterValue) {
                $slider.append(card.element.clone(true));
                displayCount++;
                console.log(`  → 追加`);
            } else {
                console.log(`  → スキップ`);
            }
        });

        console.log(`表示するカード数: ${displayCount}`);

        // スライダー再初期化
        setTimeout(function() {
            if (displayCount > 0) {
                $slider.slick(slickOptions);
                console.log('スライダー再初期化完了');
            } else {
                console.log('表示するカードがありません');
            }
        }, 50);
    });
});
