document.addEventListener("DOMContentLoaded", () => {
  const faqSection = document.querySelector(".faq");
  const faqButtons = document.querySelectorAll(".faq__question");

  faqButtons.forEach(button => {
    button.addEventListener("click", function () {
      const expanded = this.getAttribute("aria-expanded") === "true";
      const answerId = this.getAttribute("aria-controls");
      const answer = document.getElementById(answerId);
      const faqItem = this.closest(".faq__item");

      // 他のFAQを閉じる（アコーディオン動作）
      faqButtons.forEach(otherButton => {
        if (otherButton !== this) {
          const otherAnswerId = otherButton.getAttribute("aria-controls");
          const otherAnswer = document.getElementById(otherAnswerId);
          const otherFaqItem = otherButton.closest(".faq__item");

          otherButton.setAttribute("aria-expanded", "false");
          if (otherAnswer) {
            otherAnswer.hidden = true;
          }
          if (otherFaqItem) {
            otherFaqItem.classList.remove("is-active");
          }
        }
      });

      // 現在のFAQをトグル
      this.setAttribute("aria-expanded", String(!expanded));
      if (answer) {
        answer.hidden = expanded;
      }

      if (!expanded) {
        faqItem.classList.add("is-active");
        faqSection.classList.add("is-open");
      } else {
        faqItem.classList.remove("is-active");
        // すべて閉じているかチェック
        const anyOpen = Array.from(faqButtons).some(btn => btn.getAttribute("aria-expanded") === "true");
        if (!anyOpen) {
          faqSection.classList.remove("is-open");
        }
      }
    });
  });
});
