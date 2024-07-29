const order = (function () {
  const userId = document.querySelector("#checkLogin")?.value ?? 0;
  const tabs = document.querySelector(".tabs");
  const content = document.querySelector(".tabs .content");
  const loader = document.querySelector(".tabs .loader");
  const modalCancelOrder = document.querySelector("#modal_nofi");
  const modalComment = document.getElementById("modal-comment");
  const formComment = document.getElementById("form-comment");
  let indexChecked = -1;
  const hashes = new Map([
    ["#choxa%cnha%%n", "tab1"],
    ["#dangva%%chuye%%n", "tab2"],
    ["#ho%antha%nh", "tab3"],
    ["#d%a%hu%y", "tab4"],
  ]);
  const data = new Map([
    [
      "tab1",
      {
        url: "donhang.php#choxa%cnha%%n",
        type: 1,
      },
    ],
    [
      "tab2",
      {
        url: "donhang.php#dangva%%chuye%%n",
        type: 2,
      },
    ],
    [
      "tab3",
      {
        url: "donhang.php#ho%antha%nh",
        type: 3,
      },
    ],
    [
      "tab4",
      {
        url: "donhang.php#d%a%hu%y",
        type: 4,
      },
    ],
  ]);

  let arrOrder = [];
  let idTimeOut = null;

  return {
    formatPrice(n) {
      let parts = n.toString().split(".");
      parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      return `₫ ${parts.join(",")}`;
    },
    formatData(data) {
      let arr = [];
      let arrRemoveDuplicates = data.filter(function (item, pos, self) {
        let index = self.map((e) => e.id).indexOf(item.id);
        return index === pos;
      });
      arrRemoveDuplicates.forEach((item) => {
        arr.push({
          id: item.id,
          sanpham_id: item.SanPham_id,
          diachi: item.diachi,
          ngaytao: item.ngaytao,
          ngaysua: item.ngaysua,
          tongtien: item.tongtien,
          trangthaidonhang_id: item.TrangThaiDonHang_id,
          trangthai: item.trangthai,
          chitietdonhang: [
            ...data
              .filter((e) => e.id === item.id)
              .map((e) => {
                return {
                  id: e.SanPham_id,
                  kichcosanpham_id: e.KichCoSanPham_id,
                  ten: e.ten,
                  soluong: e.soluong,
                  mausac: e.mausac,
                  kichco: e.kichco,
                  hinhanh: e.hinhanh,
                  gia: e.gia,
                  danhgia: e.danhgiasanpham_id,
                };
              }),
          ],
        });
      });
      return arr;
    },
    combineData(data) {
      let arr = [];
      data.forEach((item) => {
        item["chitietdonhang"].forEach((e, index) => {
          arr.push({
            ...item,
            sanpham_id: e.id,
            kichcosanpham_id: e.kichcosanpham_id,
            danhgia: e.danhgia,
            chitietdonhang: [e],
          });
        });
      });
    
      return arr;
    },
    async getOrders(type) {
      const res = await fetch(
        `api/laydonhangtheokhach.php?userid=${userId}&type=${type}`
      );
      return await res.json();
    },
    async cancelOrder(id) {
      const res = await fetch("api/huydonhang.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json; charset=utf-8",
        },
        body: JSON.stringify({
          dhId: id,
          loaiId: 4,
        }),
      });
      const data = await res.json();
      return data;
    },
    showOrders(data) {
      if (data.length === 0) {
        content.innerHTML = `
        <div class="h-80 flex items-center justify-center py-10 bg-white">
            <div class="flex flex-col items-center gap-4">
                <img class="aspect-square" src="./public/images/none.png" alt="image"><span class="text-gray-900">Chưa có đơn hàng</span>
            </div>
        </div>
        `;
      } else {
        data.forEach((item) => {
          const elmContent = document.createElement("div");
          elmContent.innerHTML = `
                    <div class="bg-white p-4  mb-4 ${
                      item.trangthaidonhang_id == 4 ? `opacity-70` : ""
                    }">
                        <div class="flex items-center justify-between ">
                            <h4 class="text-blue-500 md:text-lg sm:text-base text-sm">
                                Mã đơn hàng: ${item["id"]} | 
                                <span class="text-gray-800">${
                                  item["trangthaidonhang_id"] == 1
                                    ? item["ngaytao"]
                                    : item["ngaysua"]
                                }</span>
                            </h4>
                            <h4 class="whitespace-nowrap uppercase md:text-lg sm:text-base text-sm float-right p-2 text-rose-500">
                                ${item["trangthai"]}
                            </h4>
                        </div>
                        ${item["chitietdonhang"]
                          .map((e) => {
                            return `<div class="clear-both gap-1  flex justify-between py-2 items-center border-y border-gray-200 border-solid">
                            <div class="flex items-center gap-1">
                                <img class="h-20 w-20  " src="${
                                  e.hinhanh
                                }" alt="image" />
                                <div>
                                    <h4 class="sm:line-clamp-none line-clamp-1 sm:text-base text-sm">
                                    ${e.ten}
                                    </h4>
                                    <span class="text-gray-500 sm:text-base text-sm">
                                        Phân loại hàng: 
                                        ${e.mausac}, ${e.kichco}
                                    </span>
                                    <span class="block sm:text-base text-sm">
                                        Số lượng: ${e.soluong}
                                    </span>
                                </div>
                            </div>
                            <strong class="whitespace-nowrap">
                            ${this.formatPrice(e.gia)}
                            </strong>
                        </div>`;
                          })
                          .join(" ")}
                        <div class="flex justify-end flex-col items-end">
                            <div class="pt-4 pb-4">
                                Thành tiền: 
                                <strong class="sm:text-2xl text-lg text-rose-500">
                                ${this.formatPrice(item.tongtien)}
                                </strong>
                            </div>
                            ${
                              item.trangthaidonhang_id == 1
                                ? `<button data-orderid  = "${item.id}" class="btn-cancel hover:bg-rose-400 hover:text-white border-rose-500 border-2 border-solid text-rose-500 px-10 py-2  ">
                                  Hủy đơn
                                </button>
                              `
                                : item.trangthaidonhang_id == 3
                                ? `
                                <div class="flex items-center justify-end gap-2">
                                ${
                                  item.danhgia == null
                                    ? `
                                    <button data-comment="${item.id}_${item?.kichcosanpham_id}" class="btn-rate hover:bg-rose-400 border-rose-500 border-2 border-solid px-10 py-2 bg-rose-500 text-white">Đánh giá</button>
                                    `
                                    : `
                                    <button class="cursor-not-allowed focus:outline-none opacity-50 border-rose-500 border-2 border-solid px-10 py-2 bg-rose-500 text-white">Đã đánh giá</button>
                                  `
                                }
                                <button class="border-rose-500 border-2 border-solid text-rose-500 px-10 py-2 hover:bg-rose-500 hover:text-white">
                                    <a href="sanpham.php">
                                        Mua lại
                                    </a>
                                </button>
                                </div>
                                `
                                : item.trangthaidonhang_id == 2
                                ? `
                                <button  class=" cursor-not-allowed focus:outline-none opacity-50 border-rose-500 border-2 border-solid text-rose-500 px-10 py-2  ">
                                  Đang giao
                                </button>
                                `
                                : `
                                <button class="border-rose-500 border-2 border-solid text-rose-500 px-10 py-2 hover:bg-rose-500 hover:text-white">
                                      <a href="sanpham.php">
                                          Mua lại
                                      </a>
                                  </button>
                                `
                            }
                        </div>
                        <div class="clear-both"></div>
                    </div>
              `;
          content.appendChild(elmContent);
        });
      }
    },
    async update(tabId) {
      const currentTab = tabs.querySelector(".active");
      if (currentTab.id != tabId) {
        currentTab.classList.remove("text-rose-500", "border-rose-500");
        currentTab.classList.remove("active");
        currentTab.classList.add(
          "border-transparent",
          "hover:text-rose-500",
          "hover:border-rose-500"
        );
      }
      const selectedTab = document.getElementById(tabId);
      selectedTab.classList.add("text-rose-500", "border-rose-500");
      selectedTab.classList.add("active");
      selectedTab.classList.remove(
        "border-transparent",
        "hover:text-rose-500",
        "hover:border-rose-500"
      );
      const entry = data.get(tabId);
      history.pushState(null, "", entry.url);
      this.showLoader();
      content.innerHTML = "";

      this.getOrders(entry.type).then(res=>{
        arrOrder = this.formatData(res);
        if (entry.type === 3) {
          arrOrder = this.combineData(arrOrder);
        }
      }).catch(err=>console.log(err))
      .finally(()=>{
        if(idTimeOut) clearTimeout(idTimeOut);
        idTimeOut = setTimeout(() => {
          this.hideLoader();
          this.showOrders(arrOrder);
        }, 200);
      })
      // const res = await this.getOrders(entry.type);
      // arrOrder = this.formatData(res);
      // if (entry.type === 3) {
      //   arrOrder = this.combineData(arrOrder);
      //   this.showOrders(arrOrder);
      // } else {
      //   this.showOrders(arrOrder);
      // }
      // 
    },
    hideLoader() {
      loader.classList.add("hidden");
    },
    showLoader() {
      loader.classList.remove("hidden");
    },
    showModalComment(str) {
      let [orderId, pdId] = str.split("_");
      const data = arrOrder.find(
        (item) =>
          parseInt(item.id) === parseInt(orderId) &&
          parseInt(item.kichcosanpham_id) === parseInt(pdId)
      );
      
      formComment.reset();
      modalComment.querySelector(".modal-comment-name").innerHTML =
        data.chitietdonhang[0].ten;
      modalComment.querySelector(".modal-comment-img").src =
        data.chitietdonhang[0].hinhanh;
      modalComment.querySelector(".modal-comment-type").innerHTML =
        data.chitietdonhang
          .map((item) => {
            return item.mausac + ", " + item.kichco;
          })
          .join(", ");
      modalComment.querySelector("input[name='orderId']").value =
        data.id + "_" + data.kichcosanpham_id;
      modalComment.classList.remove("hidden");
    },
    hideModalComment() {
      modalComment.classList.add("hidden");
      indexChecked = -1;
    },
    init() {
      tabs.addEventListener("click", (event) => {
        if (!event.target.id) return;
        this.update(event.target.id);
      });

      // get tab id from the hash
      const tabId = hashes.get(window.location.hash) ?? "tab1";
      // update the tab
      if (tabId) this.update(tabId);

      content.addEventListener("click", (e) => {
        //
        if (e.target.tagName === "BUTTON") {
          if (e.target.dataset.orderid) {
            modalCancelOrder.classList.remove("hidden");
            document.querySelector('input[name="orderId"]').value =
              e.target.dataset.orderid;
          } else if (e.target.dataset.comment) {
            this.showModalComment(e.target.dataset.comment);
          }
        }

        //
      });
      document
        .getElementById("btn-close-modalC")
        .addEventListener("click", () => {
          modalCancelOrder.classList.add("hidden");
          document.querySelector('input[name="orderId"]').value = "";
        });
      document
        .querySelector("#formC")
        .addEventListener("submit", async (event) => {
          event.preventDefault();
          let orderId = document.querySelector('input[name="orderId"]').value;
          if (orderId != "") {
            document.getElementById("modal-spinner").classList.remove("hidden");
            const res = await this.cancelOrder(orderId)
              .then(() => {
                this.update(tabId);
              })
              .catch((err) => {
                console.log(err);
              })
              .finally(() => {
                modalCancelOrder.classList.add("hidden");
              });
            document.getElementById("modal-spinner").classList.add("hidden");
          }
        });
      document
        .querySelector(".close-modal-comment")
        .addEventListener("click", this.hideModalComment);
      formComment.querySelectorAll("input[name='star']").forEach((elm) => {
        elm.addEventListener("input", (e) => {
          if (e.target.checked) {
            if (parseInt(e.target.value) > indexChecked) {
              formComment
                .querySelectorAll("input[name='star']")
                .forEach((item, index) => {
                  if (parseInt(item.value) <= parseInt(e.target.value)) {
                    item.checked = true;
                  }
                });
            }
            indexChecked = parseInt(e.target.value);
          } else {
            if (parseInt(e.target.value) < indexChecked) {
              formComment
                .querySelectorAll("input[name='star']")
                .forEach((item, index) => {
                  if (parseInt(item.value) <= parseInt(e.target.value)) {
                    item.checked = true;
                  } else {
                    item.checked = false;
                  }
                });
              indexChecked = parseInt(e.target.value);
            } else {
              e.target.checked = false;
              indexChecked -= 1;
            }
          }
        });
      });
      formComment.addEventListener("submit", (e) => {
        e.preventDefault();
        document.getElementById("modal-spinner").classList.remove("hidden");
        const form = new FormData(formComment);
        const data = Object.fromEntries(form.entries());
        fetch("api/danhgiadonhang.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json; charset=utf-8",
          },
          body: JSON.stringify(data),
        })
          .then((res) => {
            let arrId = data.orderId.split("_");
            arrOrder = arrOrder.map((item) => {
              if (
                parseInt(arrId[0]) === parseInt(item.id) &&
                parseInt(arrId[1]) === parseInt(item.kichcosanpham_id)
              ) {
                return {
                  ...item,
                  danhgia: 1,
                };
              }
              return item;
            });
          })
          .catch((err) => {})
          .finally(() => {
            document.getElementById("modal-spinner").classList.add("hidden");
            this.hideModalComment();
            content.innerHTML = "";
            this.showOrders(arrOrder);
          });
      });
    },
  };
})();
order.init();
