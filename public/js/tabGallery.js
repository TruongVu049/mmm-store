const imgShow = document.querySelector("#img_active");
let curActive = document.querySelector("#tab_gallery").firstElementChild;
let prevActive = null;

document.querySelector("#tab_gallery").addEventListener("click", (e) => {
  if (e.target.tagName === "IMG" && !(curActive == e.target.parentNode)) {
    prevActive = curActive;
    prevActive.classList.remove("border-green-500", "border-4");
    curActive = e.target.parentNode;
    curActive.classList.add("border-green-500", "border-4");
    imgShow.src = e.target.src;
  }
});
