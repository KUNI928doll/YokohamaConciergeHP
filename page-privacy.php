<?php
/**
 * Template Name: Privacy Policy
 */
get_header(); 
?>

<?php get_template_part('template-parts/inner-nav'); ?>

<main class="privacy-page">
    <div class="privacy-page__inner">
        <h1 class="privacy-page__title">プライバシーポリシー（個人情報保護方針）</h1>

        <p class="privacy-page__intro">YOKOHAMA Concierge（運営：ハマナビサービス/エコプリントコンサルティングサービス内、以下「当社」）は、当社サービスを安心してご利用いただくため、個人情報の保護を重要な責務と認識し、以下のとおりプライバシーポリシー（個人情報保護方針）を定めます。</p>

        <section class="privacy-page__section">
            <h2 class="privacy-page__heading">第1条（適用範囲）</h2>
            <p class="privacy-page__text">本プライバシーポリシーは、当社が提供する「YOKOHAMA Concierge（宿泊・飲食・体験・観光ガイド・予約代行・荷物預かりサービス）」において取得するすべての個人情報の取り扱いに適用されます。</p>
        </section>

        <section class="privacy-page__section">
            <h2 class="privacy-page__heading">第2条（取得する個人情報）</h2>
            <p class="privacy-page__text">当社は、サービス提供にあたり以下の情報を取得します。</p>
            
            <h3 class="privacy-page__subheading">利用者から直接提供される情報</h3>
            <ul class="privacy-page__list">
                <li>氏名（漢字・英字）</li>
                <li>メールアドレス</li>
                <li>電話番号</li>
                <li>国籍</li>
                <li>宿泊先情報（ホテル名、住所 等）</li>
                <li>緊急連絡先</li>
                <li>人数・予約内容</li>
                <li>その他、問い合わせフォーム・予約フォームに記載された全内容</li>
            </ul>

            <h3 class="privacy-page__subheading">決済に関する情報</h3>
            <ul class="privacy-page__list">
                <li>Stripe を通じたカード決済情報</li>
            </ul>
            <p class="privacy-page__text">※当社はクレジットカード番号を保持しません（Stripe が安全に管理）</p>

            <h3 class="privacy-page__subheading">自動取得情報（Cookie など）</h3>
            <ul class="privacy-page__list">
                <li>アクセスログ</li>
                <li>タイムスタンプ</li>
                <li>利用ブラウザ・端末情報</li>
                <li>Cookie（識別ID）</li>
            </ul>
            <p class="privacy-page__text">※個人を特定しない範囲で取得します。</p>
        </section>

        <section class="privacy-page__section">
            <h2 class="privacy-page__heading">第3条（個人情報の利用目的）</h2>
            <p class="privacy-page__text">取得した個人情報は、以下の目的のみに使用します。</p>
            <ul class="privacy-page__list">
                <li>予約代行業務（宿泊・飲食・体験アクティビティ 等）の実施</li>
                <li>観光ガイドサービス（動画ガイド／通訳ガイド付）の実施</li>
                <li>荷物預かりサービスの提供</li>
                <li>利用者への確認・連絡・サポート対応</li>
                <li>トラブル発生時の本人確認および連絡</li>
                <li>Stripe を利用した決済処理</li>
                <li>通訳ガイド・体験事業者等、外部委託先への必要範囲での情報提供</li>
                <li>法令・行政機関からの要請への対応</li>
                <li>サービス改善のための統計データ（個人が特定されない形で利用）</li>
            </ul>
        </section>

        <section class="privacy-page__section">
            <h2 class="privacy-page__heading">第4条（個人情報の管理）</h2>
            <p class="privacy-page__text">当社は、個人情報を適切に管理し、漏えい・紛失・改ざん等を防止するため、次の安全対策を講じます。</p>
            <ul class="privacy-page__list">
                <li>Google スプレッドシートによる暗号化通信（HTTPS）でのデータ管理</li>
                <li>Make（Integromat）を利用した安全な自動連携</li>
                <li>管理端末のパスワード管理およびアクセス制限</li>
                <li>不要となった情報の速やかな削除</li>
                <li>外部ガイド・委託先に対する秘密保持の徹底</li>
            </ul>
            <p class="privacy-page__text">当社はクレジットカード情報を保持しません（Stripe が管理・暗号化）。</p>
        </section>

        <section class="privacy-page__section">
            <h2 class="privacy-page__heading">第5条（第三者提供について）</h2>
            <p class="privacy-page__text">当社は、以下の場合を除き、個人情報を第三者へ提供しません。</p>
            <ul class="privacy-page__list">
                <li>利用者の同意がある場合</li>
                <li>サービス提供に必要な場合
                    <ul class="privacy-page__list--nested">
                        <li>通訳ガイド</li>
                        <li>飲食店・ホテル・体験事業者</li>
                        <li>荷物預かりに関する協力業者</li>
                    </ul>
                </li>
                <li>法令に基づく場合</li>
                <li>人の生命・身体・財産の保護が必要な場合で、本人同意が困難なとき</li>
            </ul>
            <p class="privacy-page__text">※外部委託先には、適切な取り扱いを行うよう契約等により管理します。</p>
        </section>

        <section class="privacy-page__section">
            <h2 class="privacy-page__heading">第6条（Cookieおよびアクセス解析について）</h2>
            <p class="privacy-page__text">当社サイトでは、以下の目的で Cookie を使用する場合があります。</p>
            <ul class="privacy-page__list">
                <li>利便性向上（入力補助、言語設定 等）</li>
                <li>アクセス解析（Google Analytics 等）</li>
            </ul>
            <p class="privacy-page__text">Cookie は利用者のブラウザ設定で拒否することが可能です。</p>
            <p class="privacy-page__text">Cookie には個人を特定する情報は含みません。</p>
        </section>

        <section class="privacy-page__section">
            <h2 class="privacy-page__heading">第7条（個人情報の開示・訂正・削除等）</h2>
            <p class="privacy-page__text">利用者は、当社が保有する自身の個人情報について、以下の請求を行うことができます。</p>
            <ul class="privacy-page__list">
                <li>開示</li>
                <li>訂正・追加・削除</li>
                <li>利用停止</li>
                <li>第三者提供の停止</li>
            </ul>
            <p class="privacy-page__text">請求があった場合、本人確認のうえ速やかに対応いたします。</p>
        </section>

        <section class="privacy-page__section">
            <h2 class="privacy-page__heading">第8条（プライバシーポリシーの変更）</h2>
            <p class="privacy-page__text">当社は、法令・サービス内容の変更等に応じて、本プライバシーポリシーを随時改定することがあります。</p>
            <p class="privacy-page__text">変更後は、当サイトに掲載した時点で効力を生じます。</p>
        </section>

        <section class="privacy-page__section">
            <h2 class="privacy-page__heading">第9条（お問い合わせ窓口）</h2>
            <p class="privacy-page__text">プライバシーポリシーに関するお問い合わせは、以下の窓口までお願いいたします。</p>
            <div class="privacy-page__contact">
                <p class="privacy-page__text"><strong>YOKOHAMA Concierge（ハマナビサービス）</strong></p>
                <p class="privacy-page__text">📩 <a href="mailto:info@hamanavi-s.jp">info@hamanavi-s.jp</a></p>
                <p class="privacy-page__text">📞 045-681-2737 ／ 070-1526-3845</p>
                <p class="privacy-page__text">運営：エコプリントコンサルティングサービス内<br>ハマナビサービス（080-7428-0814）</p>
            </div>
        </section>
    </div>
</main>

<?php get_footer(); ?>
