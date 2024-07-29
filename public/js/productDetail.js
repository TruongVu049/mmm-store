const productDetail = (function () {
  const form = document.querySelector("#form");
  const btnAddToCart = document.querySelector("#addCart");
  const containerSize = document.querySelector("#container__size");
  const containerQuantity = document.querySelector("#container__quantity");
  const btnColor = document.querySelectorAll("input[name='color']");
  const ipQuantity = form.elements["quantity"];
  const spId = form.elements["id"];
  const btnDecrease = document.querySelector("#btnDecrease");
  const btnIncrease = document.querySelector("#btnIncrease");
  const productAvail = document.querySelector("#productAvail");
  const loading = document.querySelector("#loading");
  const errColor = document.querySelector(".errColor");
  const errSize = document.querySelector(".errSize");
  const modal = document.querySelector("#modal_nofi");
  const modalSize = document.getElementById("modal-size");
  let timeoutID = undefined;
  let limitQuantity = null;
  let colorValue = null;
  let sizeValue = null;
  let sizeId = null;

  //product ratings
  const pagination = document.querySelector(
    ".product-ratings .product-ratings-pagination"
  );
  const ratingView = document.querySelector(
    ".product-ratings .product-ratings-comments-view"
  );
  const ratingLoading = document.querySelector(
    ".product-ratings .product-ratings-loading"
  );
  let totalPage;
  let currentPage = 1;

  return {
    async fetchDataGet(url) {
      const res = await fetch(url);
      const data = await res.json();
      return data;
    },
    async fetchDataPost(userId, sizeId, quantity) {
      const res = await fetch("api/themGioHang.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json; charset=utf-8",
        },
        body: JSON.stringify({
          userId: userId,
          sizeId: sizeId,
          quantity: quantity,
        }),
      });
      const data = await res.json();
      return data;
    },
    renderModalUI(isSuccess) {
      modal.classList.remove("hidden");
      if (isSuccess) {
        modal.querySelector(
          ".modal__icon"
        ).innerHTML = `<svg class="mx-auto mb-4 text-green-500 bg-white  w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>`;
        modal.querySelector(".modal__mes").innerHTML =
          "Đã thêm sản phẩm vào giỏ hàng.";
      } else {
        modal.querySelector(
          ".modal__icon"
        ).innerHTML = `<svg class="mx-auto mb-4 text-red-500 bg-white  w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>`;
        modal.querySelector(".modal__mes").innerHTML =
          "Đã xảy ra lỗi. Vui lòng thực hiện lại!";
      }
    },
    addElement(data) {
      containerSize.innerHTML = data.map((item) => {
        return `<label class="cursor-pointer">
                    <input data-quantity="${item.soluong}" type="radio" ${
          parseInt(item.soluong) <= 0 ? "disabled" : ""
        }  name="size" class="peer sr-only" value="${item.id}">
                    <p class="${
                      parseInt(item.soluong) <= 0
                        ? "opacity-[50%] border-red-500 cursor-not-allowed"
                        : "border-black"
                    } capitalize peer-checked:bg-gray-900 peer-checked:text-white rounded-lg border  px-6 py-2 font-bold">${
          item.kichco
        }</p>
                </label>`;
      });
      containerQuantity.classList.remove("hidden");
    },
    addErr(elm, mes) {
      elm.innerHTML = mes;
      elm.classList.remove("hidden");
    },
    removeErr(elm) {
      if (!elm.classList.contains("hidden")) {
        elm.classList.add("hidden");
      }
    },
    checkIsValid() {
      let isValid = true;
      if (!colorValue) {
        isValid = false;
        this.addErr(errColor, "Vui lòng chọn màu sắc!");
      } else {
        if (!sizeValue) {
          isValid = false;
          this.addErr(errSize, "Vui lòng chọn kích cỡ!");
        }
      }
      return isValid;
    },
    async fetchQuantity(userId) {
      const res = await fetch(`api/layslgiohang.php?userid=${userId}`);
      const data = await res.json();
      return data;
    },
    showRatingLoading() {
      ratingLoading.classList.remove("hidden");
      ratingView.classList.add("hidden");
    },
    hideRatingLoading() {
      ratingLoading.classList.add("hidden");
      ratingView.classList.remove("hidden");
    },
    renderRatingView(data) {
      ratingView.innerHTML = "";
      data.forEach((item) => {
        const elmContent = document.createElement("article");
        elmContent.classList.add(
          "p-6",
          "pb-3",
          "text-base",
          "bg-white",
          "border-t",
          "border-gray-200"
        );
        elmContent.innerHTML = `
            <footer class=" mb-2">
            <div class="flex items-start">
                <div class="mr-3 ">
                    <img class="mr-2 w-6 h-6 rounded-full" src="./public/images/i-user.png" alt="user">
                </div>
                <div class="flex flex-col">
                    <div class="">
                        <p class="text-sm text-gray-900  font-semibold">
                            ${item.ten}
                        </p>
                        
                    </div>
                    <div class="flex items-center my-1">
                        ${new Array(5)
                          .fill(1)
                          .map((e, index) => {
                            if (parseInt(item.sosao) >= index + 1) {
                              return `
                              <svg class="h-4 w-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                              <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"></path>
                              </svg>
                              `;
                            }
                            return `
                            <svg class="h-4 w-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                              <path stroke="currentColor" stroke-width="2" d="M11.083 5.104c.35-.8 1.485-.8 1.834 0l1.752 4.022a1 1 0 0 0 .84.597l4.463.342c.9.069 1.255 1.2.556 1.771l-3.33 2.723a1 1 0 0 0-.337 1.016l1.03 4.119c.214.858-.71 1.552-1.474 1.106l-3.913-2.281a1 1 0 0 0-1.008 0L7.583 20.8c-.764.446-1.688-.248-1.474-1.106l1.03-4.119A1 1 0 0 0 6.8 14.56l-3.33-2.723c-.698-.571-.342-1.702.557-1.771l4.462-.342a1 1 0 0 0 .84-.597l1.753-4.022Z"></path>
                          </svg>
                            `;
                          })
                          .join(" ")}
                    </div>
                    <div>
                        <p class=" text-sm text-gray-600 ">
                        <time pubdate datetime="2022-06-23" title="${
                          item.ngaytao
                        }">${item.ngaytao} </time>| Phân loại hàng:
                        <span>${item.mausac},${item.kichco}</span>
                    </p>
                    </div>
                </div>
            </div>
        </footer>
        <p class="text-gray-500 dark:text-gray-400">${
          item.binhluan ?? "......................."
        }</p>
        <div class="flex items-center mt-4 space-x-4">
        </div>
        `;
        ratingView.appendChild(elmContent);
      });
    },
    renderPagination() {
      pagination.innerHTML = "";
      new Array(totalPage).fill(1).forEach((item, index) => {
        const elmContent = document.createElement("label");
        elmContent.classList.add("cursor-pointer");
        elmContent.innerHTML = `
        <input ${
          index === 0 ? `checked` : ``
        } type="radio" name="page" class="peer sr-only" value="${index + 1}">
        <p class="peer-checked:text-white peer-checked:bg-green-500 peer-checked-hover:text-white peer-checked-hover:bg-green-500 hover:text-white hover:bg-green-500 text-gray-900 bg-white flex items-center justify-center px-4 h-10 leading-tight border border-gray-300">${
          index + 1
        }</p>
        `;
        pagination.appendChild(elmContent);
      });
    },
    async getComments(page) {
      const res = await fetch(
        `api/laydsbinhluan.php?spId=${spId.value}&p=${page}`
      );
      return await res.json();
    },
    init() {
      window.addEventListener("load", async () => {
        form.reset();
        this.showRatingLoading();
        this.getComments(currentPage)
          .then((data) => {
            if (parseInt(data["tongtrang"]) === 0) {
              ratingView.innerHTML = `<div class="flex flex-col items-center my-10">
              <img src="./public/images/none-cm.png" alt="">
              <h6 class="md:text-base text-sm text-gray-500">Chưa có đánh giá</h6>
          </div>`;
            } else {
              totalPage = parseInt(data["tongtrang"]);
              this.renderRatingView(data["dsbl"]);
              this.renderPagination();
            }
          })
          .catch((err) => {
            console.log(err);
            ratingView.innerHTML = `<div class="flex flex-col items-center my-10">
              <img src="./public/images/none-cm.png" alt="">
              <h6 class="md:text-base text-sm text-gray-500">Chưa có đánh giá</h6>
          </div>`;
          })
          .finally(() => {
            this.hideRatingLoading();
          });
      });
      window.addEventListener("load", () => {
        btnColor.forEach((btnRadio) => {
          btnRadio.addEventListener("change", async () => {
            loading.classList.remove("hidden");
            document.getElementById("img_active").src= document.querySelector(`[data-lsphaid-${btnRadio.value}]`).src;
            const data = await this.fetchDataGet(
              `api/laykichcosanpham.php?sanphamid=${spId.value}&loaisanphamid=${btnRadio.value}`
            );
            this.removeErr(errColor);
            colorValue = parseInt(btnRadio.value);
            sizeValue = null;
            sizeId = null;
            this.addElement(data["data"]);
            loading.classList.add("hidden");
          });
        });
      });

      containerSize.addEventListener("click", (e) => {
        if (e.target.name === "size") {
          sizeId = e.target.value;
          ipQuantity.value = 1;
          limitQuantity = parseInt(e.target.dataset.quantity);
          this.removeErr(errSize);
          sizeValue = parseInt(e.target.dataset.quantity);
          productAvail.innerHTML = `${limitQuantity} sản phẩm có sẵn`;
        }
      });
      btnIncrease.addEventListener("click", () => {
        if (parseInt(ipQuantity.value) < limitQuantity) {
          ipQuantity.value = parseInt(ipQuantity.value) + 1;
        }
      });
      btnDecrease.addEventListener("click", () => {
        if (parseInt(ipQuantity.value) > 1) {
          ipQuantity.value = parseInt(ipQuantity.value) - 1;
        }
      });
      form.addEventListener("submit", (e) => {
        e.preventDefault();
        if (this.checkIsValid()) {
          HTMLFormElement.prototype.submit.call(form);
        }
      });

      btnAddToCart?.addEventListener("click", async (e) => {
        e.preventDefault();
        try {
          if (this.checkIsValid()) {
            const data = await this.fetchDataPost(
              document.querySelector("#checkLogin").value,
              sizeId,
              ipQuantity.value
            );
            if (JSON.parse(data["data"])) {
              this.renderModalUI(true);
              let data = await this.fetchQuantity(
                document.querySelector("#checkLogin")?.value ?? 0
              );
              if (typeof timeoutID === "number") {
                console.log("remove timeout");
                clearTimeout(timeoutID);
              }
              new Promise((resolve, reject) => {
                timeoutID = setTimeout(() => {
                  document.querySelector(
                    "[data-button-change"
                  ).dataset.buttonChange = "true";
                  document.querySelector(".cart-drawer__view").innerHTML =
                    parseInt(data["sl"]) > 99 ? "99+" : data["sl"];
                  modal.classList.add("hidden");
                }, 500);
              });
            } else {
              throw false;
            }
          }
        } catch (err) {
          this.renderModalUI(false);
          if (typeof timeoutID === "number") {
            console.log("remove timeout");
            clearTimeout(timeoutID);
          }
          new Promise((resolve, reject) => {
            timeoutID = setTimeout(() => {
              console.log("settimeout");
              modal.classList.add("hidden");
            }, 500);
          });
        }
      });

      document.querySelectorAll(".btnLogin")?.forEach((elm) => {
        elm.addEventListener("click", (e) => {
          window.history.pushState(
            { prevUrl: window.location.href },
            null,
            "dangnhap.php"
          );
          location.href = "dangnhap.php";
        });
      });

      pagination.addEventListener("click", (e) => {
        if (e.target.tagName == "INPUT" && e.target.name === "page") {
          if (parseInt(e.target.value) !== currentPage) {
            currentPage = parseInt(e.target.value);
            this.showRatingLoading();
            this.getComments(currentPage)
              .then((data) => {
                this.renderRatingView(data["dsbl"]);
              })
              .catch((err) => {
                console.log(err);
              })
              .finally(() => {
                this.hideRatingLoading();
              });
          }
        }
      });

      document
        .querySelector(".btn-open-modal-size")
        .addEventListener("click", () => {
          modalSize.classList.remove("hidden");
        });
      modalSize
        .querySelector(".btn-close-modal-size")
        .addEventListener("click", () => {
          modalSize.classList.add("hidden");
        });
    },
  };
})();

productDetail.init();
