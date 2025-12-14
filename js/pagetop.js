$(function () {
    const $pageTop = $('.pagetop');

    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 300) {
            $pageTop.addClass('is-show');
        } else {
            $pageTop.removeClass('is-show');
        }
    });

    $pageTop.on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({ scrollTop: 0 }, 600, 'swing');
    });
});

