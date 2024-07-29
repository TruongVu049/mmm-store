const carousel = document.querySelector("#default-carousel");
const carouselItems = Array.from(
  document.querySelectorAll("[data-carousel-item]")
);
const carouselPrev = document.querySelector("[data-carousel-prev]");
const carouselNext = document.querySelector("[data-carousel-next]");
const max = 4;
let prev = 0;
let cur = 0;
let next = 0;

const handleCarouselNext = () => {
  cur === max ? (cur = 0) : cur++;
  next = cur === max ? 0 : cur + 1;
  carouselItems[prev].className =
    "duration-700 ease-in-out absolute inset-0 transition-transform transform -translate-x-full z-10";
  carouselItems[cur].className =
    "duration-700 ease-in-out absolute inset-0 transition-transform transform translate-x-0 z-20";
  carouselItems[next].className =
    "duration-700 ease-in-out absolute inset-0 transition-transform transform z-10 translate-x-full";
  for (let i = 0; i <= max; i++) {
    if (i !== next && i !== prev && i !== cur)
      carouselItems[i].className =
        "duration-700 ease-in-out absolute inset-0 transition-transform transform -translate-x-full z-10 hidden";
  }

  prev = cur;
};
carouselNext.addEventListener("click", () => handleCarouselNext());

carouselPrev.addEventListener("click", () => {
  cur === 0 ? (cur = max) : cur--;
  prev = cur === 0 ? max : cur - 1;
  next = cur === max ? 0 : cur + 1;
  carouselItems[prev].className =
    "duration-700 ease-in-out absolute inset-0 transition-transform transform -translate-x-full z-10";
  carouselItems[cur].className =
    "duration-700 ease-in-out absolute inset-0 transition-transform transform translate-x-0 z-20";
  carouselItems[next].className =
    "duration-700 ease-in-out absolute inset-0 transition-transform transform translate-x-full z-10";
  for (let i = 0; i <= max; i++) {
    if (i !== next && i !== prev && i !== cur)
      carouselItems[i].className =
        "duration-700 ease-in-out absolute inset-0 transition-transform transform -translate-x-full z-10 hidden";
  }
});

const clear = setInterval(() => {
  handleCarouselNext();
}, 4000);
