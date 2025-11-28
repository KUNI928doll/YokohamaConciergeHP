gsap.registerPlugin(ScrollTrigger);

// 共通フェードアップ
gsap.utils.toArray(".js-fade-up").forEach((el) => {
  // .about-yokohama__photos、.about-yokohama__character、.about-yokohama__character-img、.about-yokohama__areas-wrapper は transform を上書きせず、opacity のみアニメーション
  if (el.classList.contains("about-yokohama__photos") ||
    el.classList.contains("about-yokohama__character") ||
    el.classList.contains("about-yokohama__character-img") ||
    el.classList.contains("about-yokohama__areas-wrapper")) {
    gsap.fromTo(
      el,
      { opacity: 0 },
      {
        opacity: 1,
        duration: 1,
        ease: "power2.out",
        scrollTrigger: {
          trigger: el,
          start: "top 85%",
        },
      }
    );
    return;
  }
  gsap.fromTo(
    el,
    { y: 40, opacity: 0 },
    {
      y: 0,
      opacity: 1,
      duration: 1,
      ease: "power2.out",
      scrollTrigger: {
        trigger: el,
        start: "top 85%",
      },
    }
  );
});

// 通常フェード
gsap.utils.toArray(".js-fade").forEach((el) => {
  gsap.to(el, {
    opacity: 1,
    duration: 1.2,
    ease: "power1.out",
    scrollTrigger: {
      trigger: el,
      start: "top 90%",
    },
  });
});

// スタンプ「ポンッ」アニメ
gsap.fromTo(
  ".about__stamp",
  { scale: 0.4, opacity: 0 },
  {
    scale: 1,
    opacity: 1,
    duration: 0.6,
    ease: "back.out(1.7)",
    scrollTrigger: {
      trigger: ".about__stamp",
      start: "top 80%",
    },
  }
);

// 波とカモメの軽い動き
gsap.to(".about__seagull", {
  x: 20,
  y: -10,
  duration: 4,
  repeat: -1,
  yoyo: true,
  ease: "sine.inOut",
});


// ==========================
//  アニメーション順制御：波 → カモメ → 3枚画像
// ==========================

// ScrollTriggerに合わせてタイムラインを作成
const aboutTl = gsap.timeline({
  scrollTrigger: {
    trigger: ".about__images", // セクションinで開始
    start: "top 80%",
  },
});

// ① 波の出現（背景がゆっくり動き出す）
aboutTl.fromTo(
  ".about__wave-bg",
  { opacity: 0 },
  {
    opacity: 0.8,
    duration: 1.5,
    ease: "power2.out",
    onStart: () => {
      // 横方向にゆったりスライド（常時ループ）
      gsap.to(".about__wave-bg", {
        backgroundPositionX: "30%",
        duration: 10,
        repeat: -1,
        yoyo: true,
        ease: "sine.inOut",
      });
    },
  }
);

// ② カモメがふわっと現れて飛び始める
aboutTl.fromTo(
  ".about__seagull",
  { opacity: 0, y: 30 },
  {
    opacity: 1,
    y: 0,
    duration: 1,
    ease: "power2.out",
    onComplete: () => {
      gsap.to(".about__seagull", {
        x: 20,
        y: -10,
        duration: 4,
        repeat: -1,
        yoyo: true,
        ease: "sine.inOut",
      });
    },
  },
  "+=0.3" // 波のあと少し遅れて
);

// ③ 3枚のイメージが順に出現
aboutTl.from(".about__image img", {
  y: 50,
  opacity: 0,
  stagger: 0.25,
  duration: 1.2,
  ease: "power2.out",
});

gsap.to(".seagull", {
  scrollTrigger: {
    trigger: "#features",
    start: "top bottom",
    end: "bottom top",
    scrub: true,
  },
  y: "-40vh", // 上昇
  x: "40vw",  // 横移動
  ease: "power1.inOut",
});

