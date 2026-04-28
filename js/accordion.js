"use strict";

document.addEventListener("DOMContentLoaded", () => {
  const faqSection = document.querySelector(".faq");
  const faqButtons = document.querySelectorAll(".faq__question");

  faqButtons.forEach(faqBtn => {
    faqBtn.addEventListener("click", function() {
      const item   = this.closest(".faq__item");
      const answer = item.querySelector(".faq__answer");
      const isOpen = item.classList.contains("is-active");

      // 他のFAQを閉じる
      faqButtons.forEach(otherBtn => {
        if (otherBtn === this) return;
        const otherItem   = otherBtn.closest(".faq__item");
        const otherAnswer = otherItem.querySelector(".faq__answer");

        if (otherItem.classList.contains("is-active")) {
          otherAnswer.style.maxHeight = otherAnswer.scrollHeight + "px";
          requestAnimationFrame(() => {
            otherAnswer.style.maxHeight = "0px";
          });
          otherItem.classList.remove("is-active");
          otherBtn.setAttribute("aria-expanded", "false");
        }
      });

      if (isOpen) {
        // 閉じる
        answer.style.maxHeight = answer.scrollHeight + "px";
        requestAnimationFrame(() => {
          answer.style.maxHeight = "0px";
        });
        item.classList.remove("is-active");
        this.setAttribute("aria-expanded", "false");
        if (faqSection) faqSection.classList.remove("is-open");
      } else {
        // 開く
        item.classList.add("is-active");
        answer.style.maxHeight = answer.scrollHeight + "px";
        this.setAttribute("aria-expanded", "true");
        if (faqSection) faqSection.classList.add("is-open");
      }
    });
  });
});
