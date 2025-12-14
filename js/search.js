document.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    const query = (params.get('q') || '').trim();
    const summary = document.querySelector('[data-search-summary]');
    const list = document.querySelector('[data-search-list]');
    const empty = document.querySelector('[data-search-empty]');
    const input = document.querySelector('.search-area__input');

    if (input) {
        input.value = query;
    }

    const pages = [
        {
            title: '予約代行サービス',
            description: 'ホテルや飲食店、観光チケットなどの手配を代行し、旅の準備をスムーズにします。',
            url: 'index.html#service-reserve',
            keywords: ['予約', '代行', '手配', 'サービス'],
        },
        {
            title: 'トランクお預かりサービス',
            description: '横浜観光のあいだ、お客様の大切なお荷物を安全にお預かりするサービスです。',
            url: 'service-storage.html',
            keywords: ['トランク', '荷物預かり', '保管', 'storage'],
        },
        {
            title: '横浜観光ガイドサービス',
            description: '外国人ゲストにも安心の、通訳付き観光ガイドやカスタムツアーをご提供します。',
            url: 'service-tour-guide.html',
            keywords: ['ガイド', '観光', 'ツアー', '通訳'],
        },
        {
            title: '横浜の見どころ',
            description: '横浜の歴史や主要スポットをエリアごとにご紹介します。',
            url: 'yokohama.html',
            keywords: ['横浜', '観光スポット', '歴史'],
        },
        {
            title: 'よくある質問',
            description: 'サービス利用に関する疑問や料金、対応エリアなどのQ&Aをご確認いただけます。',
            url: 'faq.html',
            keywords: ['FAQ', '質問', '料金', '対応エリア'],
        },
        {
            title: 'お問い合わせ',
            description: '電話・メール・フォームから各種お問い合わせを受け付けています。',
            url: 'contact.html',
            keywords: ['お問い合わせ', '相談', '連絡'],
        },
    ];

    const normalize = (text) => text.toLowerCase();

    if (!query) {
        summary.textContent = '検索ワードを入力して検索してください。';
        empty.hidden = false;
        list.innerHTML = '';
        return;
    }

    const normalizedQuery = normalize(query);
    const results = pages.filter((page) => {
        const haystack = normalize(`${page.title} ${page.description} ${page.keywords.join(' ')}`);
        return haystack.includes(normalizedQuery);
    });

    summary.textContent = `「${query}」の検索結果: ${results.length}件`;

    if (!results.length) {
        empty.hidden = false;
        empty.innerHTML = `ご指定のキーワード「${query}」に一致するページが見つかりませんでした。<br>
                <a href="contact.html">お問い合わせフォーム</a>からご質問をお送りください。`;
        list.innerHTML = '';
        return;
    }

    empty.hidden = true;
    list.innerHTML = results
        .map(
            (item) => `
                <li class="search-results__item">
                    <a href="${item.url}">${item.title}</a>
                    <p>${item.description}</p>
                </li>
            `,
        )
        .join('');
});


