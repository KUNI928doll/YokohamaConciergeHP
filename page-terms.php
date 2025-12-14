<?php
/**
 * Template Name: Terms of Service
 */
get_header(); 
?>

<?php get_template_part('template-parts/inner-nav'); ?>

<main class="privacy-page">
    <div class="privacy-page__inner">
        <h1 class="privacy-page__title">利用規約</h1>

        <p class="privacy-page__intro">本利用規約（以下「本規約」）は、YOKOHAMA Concierge（運営：ハマナビサービス／エコプリントコンサルティングサービス内、以下「当社」）が提供する各種サービスの利用条件を定めるものです。利用者（以下「利用者」）は、本規約に同意のうえ、本サービスをご利用ください。</p>

        <section class="privacy-page__section">
            <h2 class="privacy-page__heading">第1条（適用範囲）</h2>
            <ul class="privacy-page__list">
                <li>本規約は、当社が提供する「YOKOHAMA Concierge」に関連するすべてのサービスに適用されます。</li>
                <li>当社は、利用者への事前通知なく本規約を変更できるものとし、変更後の規約は当サイトに掲載された時点で効力を生じます。</li>
            </ul>
        </section>

        <section class="privacy-page__section">
            <h2 class="privacy-page__heading">第2条（サービス内容）</h2>
            <p class="privacy-page__text">当社が提供するサービスは以下のとおりとします。</p>
            <ul class="privacy-page__list">
                <li>宿泊施設、飲食店、観光アクティビティ等の情報提供および予約代行サービス</li>
                <li>観光ガイドサービス（2種類）
                    <ul class="privacy-page__list--nested">
                        <li>動画ガイドプラン（当社制作のナレーション付き映像を使用したセルフガイド方式）</li>
                        <li>通訳ガイド付きプラン（外部委託の通訳ガイドによる同行案内）</li>
                    </ul>
                </li>
                <li>荷物預かりサービス（1m × 1m以内のサイズに限る）
                    <ul class="privacy-page__list--nested">
                        <li>返却は「預かり時点の外観状態」に限り保証し、内部の物品については一切保証しません。</li>
                    </ul>
                </li>
                <li>上記に付随する案内・連絡・サポート業務。</li>
            </ul>
            <p class="privacy-page__text privacy-page__note">※観光中の交通費、飲食費、施設入場料などの実費は、すべて利用者負担となります。</p>
        </section>

        <section class="privacy-page__section">
            <h2 class="privacy-page__heading">第3条（契約の成立）</h2>
            <ul class="privacy-page__list">
                <li>当社の予約代行サービスは、利用者と各事業者（宿泊施設・飲食店・体験事業者・通訳ガイド等）との契約成立を補助するものであり、最終契約は利用者と事業者の間で直接成立するものとします。</li>
                <li>当社は、各事業者が提供するサービス内容、品質、料金、営業時間、キャンセル規定等について保証するものではありません。</li>
                <li>利用者は、各事業者の利用規約・キャンセル条件に従うものとします。</li>
            </ul>
        </section>

        <section class="privacy-page__section">
            <h2 class="privacy-page__heading">第4条（料金と支払い）</h2>
            
            <h3 class="privacy-page__subheading">1. 観光ガイドサービス料金</h3>
            <ul class="privacy-page__list">
                <li>動画ガイド（半日）：12,000円</li>
                <li>通訳ガイド付（半日）：20,000円</li>
                <li>動画ガイド（1日）：22,000円</li>
                <li>通訳ガイド付（1日）：30,000円</li>
            </ul>
            <p class="privacy-page__text privacy-page__note">ガイド案内は 1組3名まで とし、4名以上の案内は行いません。<br>※交通費・入場料等は別途利用者負担。</p>

            <h3 class="privacy-page__subheading">2. 予約代行サービス料金</h3>
            <ul class="privacy-page__list">
                <li>ホテル予約代行：2,200円</li>
                <li>飲食店予約代行：2,200円</li>
                <li>体験アクティビティ予約代行：2,200円</li>
            </ul>
            <p class="privacy-page__text privacy-page__note">※予約代行手数料は予約完了後、いかなる理由でも返金不可とします。<br>※飲食代・宿泊代・体験料は現地事業者へ直接支払いとなります。</p>

            <h3 class="privacy-page__subheading">3. トランク預かりサービス</h3>
            <ul class="privacy-page__list">
                <li>1個／1日：1,800円</li>
                <li>1m × 1m以内のサイズのみ預かり可能</li>
            </ul>
            <p class="privacy-page__text privacy-page__note">返却は預かり時点の外観状態を保証し、内部物品の破損・紛失等は保証対象外とします。</p>

            <h3 class="privacy-page__subheading">4. 支払い方法および為替レート</h3>
            <ul class="privacy-page__list">
                <li>支払いは Stripe（クレジットカード）を使用します。</li>
                <li>外貨表示（USD/EUR/CNY/KRW等）は参考値であり、最終金額はカード会社の換算レートに基づき変動します。</li>
                <li>サービス特性により、予約時点での事前決済が必要となる場合があります。</li>
            </ul>
        </section>

        <section class="privacy-page__section">
            <h2 class="privacy-page__heading">第5条（キャンセルポリシー）</h2>
            
            <h3 class="privacy-page__subheading">1. 観光ガイドサービス（動画／通訳）</h3>
            <ul class="privacy-page__list">
                <li>前日キャンセル：料金の50%</li>
                <li>当日キャンセル：料金の100%</li>
                <li>無断キャンセル：料金の100%</li>
            </ul>
            <p class="privacy-page__text privacy-page__note">当社は Stripe の仕様に基づき、キャンセル料率に応じた部分返金または返金なしの対応を、当社判断にて行います。</p>

            <h3 class="privacy-page__subheading">2. 予約代行サービス</h3>
            <p class="privacy-page__text">予約代行手数料（2,200円）は、予約完了後は返金不可とします。</p>

            <h3 class="privacy-page__subheading">3. 事業者都合によるキャンセル</h3>
            <p class="privacy-page__text">事業者側の事情（満席、急な休業、設備トラブル、天災等）により予約が取消しとなった場合、返金・補償・振替に関する取り扱いは利用者と事業者の間の契約に従って処理されます。</p>
            <p class="privacy-page__text privacy-page__note">当社は、これらに関する返金義務・補償責任を負いません。</p>
        </section>

        <section class="privacy-page__section">
            <h2 class="privacy-page__heading">第6条（免責事項）</h2>
            <p class="privacy-page__text">当社は、以下に起因して利用者に発生した損害について責任を負いません。</p>
            <ul class="privacy-page__list">
                <li>交通機関の遅延・運休</li>
                <li>事業者の都合による変更・休業・取消し</li>
                <li>外部委託ガイドの対応品質</li>
                <li>動画ガイド利用中の事故・紛失</li>
                <li>天災地変、不可抗力</li>
            </ul>
            <p class="privacy-page__text">荷物預かりサービスでは、以下について保証しません。</p>
            <ul class="privacy-page__list">
                <li>内部の物品（貴重品・電子機器・ガラス等）の破損／紛失</li>
                <li>トランク自体の経年劣化・自然損耗</li>
            </ul>
            <p class="privacy-page__text privacy-page__note">ただし、当社の重大な過失または法令違反に該当する場合はこの限りではありません。</p>
        </section>

        <section class="privacy-page__section">
            <h2 class="privacy-page__heading">第7条（個人情報の取り扱い）</h2>
            <p class="privacy-page__text">個人情報の取り扱いは、当社が別途定める「<a href="<?php echo esc_url(home_url('/privacy/')); ?>">プライバシーポリシー（個人情報保護方針）</a>」に従うものとします。</p>
        </section>

        <section class="privacy-page__section">
            <h2 class="privacy-page__heading">第8条（禁止事項）</h2>
            <p class="privacy-page__text">利用者は、以下の行為を行ってはなりません。</p>
            <ul class="privacy-page__list">
                <li>虚偽情報の提供</li>
                <li>無断キャンセル・迷惑行為</li>
                <li>法令・公序良俗に反する行為</li>
                <li>サービス運営を妨害する行為</li>
                <li>第三者になりすます行為</li>
                <li>予約枠の不正取得や転売行為</li>
            </ul>
        </section>

        <section class="privacy-page__section">
            <h2 class="privacy-page__heading">第9条（準拠法・管轄裁判所）</h2>
            <ul class="privacy-page__list">
                <li>本規約は日本法に準拠します。</li>
                <li>本サービスに関連して紛争が生じた場合、横浜地方裁判所を第一審の専属的合意管轄裁判所とします。</li>
            </ul>
        </section>

        <section class="privacy-page__section">
            <h2 class="privacy-page__heading">お問い合わせ先</h2>
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
