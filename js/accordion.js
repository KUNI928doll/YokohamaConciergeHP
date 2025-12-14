document.addEventListener("DOMContentLoaded", () => {
  const faqSection = document.querySelector(".faq");

  document.querySelectorAll(".js-accordion-btn").forEach(btn => {
    btn.addEventListener("click", function () {
      const parent = btn.closest(".js-accordion");
      const answer = parent.querySelector(".js-accordion-body");

      const isAlreadyOpen = parent.classList.contains("is-active");

      // 🔻 すべて閉じる（他のアコーディオン）
      document.querySelectorAll(".js-accordion").forEach(item => {
        item.classList.remove("is-active");
        const itemAnswer = item.querySelector(".js-accordion-body");
        itemAnswer.style.maxHeight = null;
        itemAnswer.style.opacity = "0";
      });

      // 🔻 今クリックしたものが「閉じていた」場合のみ開く
      if (!isAlreadyOpen) {
        parent.classList.add("is-active");
        answer.style.maxHeight = answer.scrollHeight + "px";
        answer.style.opacity = "1";
      }

      // 🔻 どれかが開いているかチェックして .faq に is-open をつける
      const anyOpen = document.querySelectorAll(".js-accordion.is-active").length > 0;
      if (anyOpen) {
        faqSection.classList.add("is-open");
      } else {
        faqSection.classList.remove("is-open");
      }
    });
  });
});

