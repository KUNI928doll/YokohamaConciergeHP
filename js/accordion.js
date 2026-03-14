document.addEventListener("DOMContentLoaded", () => {
  const faqSection = document.querySelector(".faq");

  // <details>要素のアコーディオン制御
  document.querySelectorAll(".faq__details").forEach(details => {
    const summary = details.querySelector(".faq__question");

    // 初期状態のaria-expanded属性を設定
    if (summary) {
      summary.setAttribute("aria-expanded", details.open ? "true" : "false");
    }

    details.addEventListener("toggle", function () {
      // aria-expanded属性を更新
      if (summary) {
        summary.setAttribute("aria-expanded", this.open ? "true" : "false");
      }

      // 他の<details>を閉じる（アコーディオン動作）
      if (this.open) {
        document.querySelectorAll(".faq__details").forEach(otherDetails => {
          if (otherDetails !== this && otherDetails.open) {
            otherDetails.open = false;
            const otherSummary = otherDetails.querySelector(".faq__question");
            if (otherSummary) {
              otherSummary.setAttribute("aria-expanded", "false");
            }
          }
        });
      }

      // どれかが開いているかチェックして .faq に is-open をつける
      const anyOpen = Array.from(document.querySelectorAll(".faq__details")).some(d => d.open);
      if (anyOpen) {
        faqSection.classList.add("is-open");
      } else {
        faqSection.classList.remove("is-open");
      }

      // アイテムにis-activeクラスを追加/削除
      const faqItem = this.closest(".faq__item");
      if (this.open) {
        faqItem.classList.add("is-active");
      } else {
        faqItem.classList.remove("is-active");
      }
    });
  });
});
