const productOption = (function () {
  const modal = document.querySelector("#modal-option");
  const btnOpen = document.querySelector("#btn_open");
  const btnAdd = document.querySelector("#btn_add");
  const btnClose = document.querySelector("#btn_close");
  const btnShowMore = document.querySelector("#btn-show-more");
  const form = document.querySelector("#form_options");
  const elmProductsChecked = document.querySelector("#product-checked");
  const errListProduct = document.querySelector("#error_listProduct");
  const ipChecked = document.querySelector("input[name='them_thoigian_kt']");
  const error = document.querySelector("#error");
  const tableListProduct = document
    .querySelector("#tb_listProduct")
    .getElementsByTagName("tbody")[0];
  let productsChecked = [];

  let limit = 4;
  let p = 1;
  let totalPage = 0;
  let s = "";
  const inputData = document.querySelector("input[name='data']");
  if (inputData.value) {
    productsChecked = JSON.parse(inputData.value);
  }
  const ipPercent = document.querySelector("input[name='phantram']");
  const ipStartTime = document.querySelector("input[name='thoigian_bd']");
  const ipEndTime = document.querySelector("input[name='thoigian_kt']");

  return {
    async getListProduct(limit, p, s) {
      const res = await fetch("../api/laysanpham.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json; charset=utf-8",
        },
        body: JSON.stringify({
          limit: limit,
          p: p,
          s: "",
          pro: productsChecked.map((item) => item.id) ?? [],
        }),
      });
      const data = await res.json();
      return data;
    },
    addListProduct() {
      const formData = new FormData(form);
      let values = [...formData.entries()];
      values = values.map((item) => JSON.parse(item[1]));
      productsChecked.push(
        ...values.filter((item) => {
          return productsChecked.filter((e) => e.id == item.id).length == 0;
        })
      );
    },
    removeProductChecked(id) {
      productsChecked = productsChecked.filter((item) => item.id != id);
    },
    renderListProduct(data) {
      const tr = document.createElement("tr");
      let kt = false;
      data.forEach((item) => {
        item.ten =
          item["ten"].length > 70
            ? item["ten"].substring(0, 70) + "..."
            : item["ten"];
        const tr = document.createElement("tr");
        if (productsChecked.some((e) => e.id === parseInt(item.id))) {
          kt = true;
          tr.className =
            "bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600";
          tr.innerHTML = `<td class="w-4 p-4">
                              <div class="flex items-center gap-2">
                                  <input id="proId${
                                    item.id
                                  }" type="checkbox" checked name='product' value='${JSON.stringify(
            item
          )}' class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600  focus:ring-2 ">
                                  <label for="checkbox-table" class="sr-only">checkbox</label>
                                  <div class="w-16 h-16">
                                    <img src="${
                                      item.hinhanh
                                    }" class="w-16 h-16">
                                  </div>
                              </div>
                              
                          </td>
                          <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                          ${item.ten}
                          </th>
                          <td class="px-6 py-4">
                          ${item.gia}
                          </td>`;
        } else {
          tr.className =
            "bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600";
          tr.innerHTML = `<td class="w-4 p-4">
                              <div class="flex items-center gap-2">
                                  <input id="proId${
                                    item.id
                                  }" type="checkbox" name='product' value='${JSON.stringify(
            item
          )}' class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600  focus:ring-2 ">
                                  <label for="checkbox-table" class="sr-only">checkbox</label>
                                  <div class="w-16 h-16">
                                    <img src="${
                                      item.hinhanh
                                    }" class="w-16 h-16">
                                  </div>
                              </div>
                              
                          </td>
                          <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                          ${item.ten}
                          </th>
                          <td class="px-6 py-4">
                          ${item.gia}
                          </td>`;
        }
        tableListProduct.append(tr);
      });
      
    },
    renderProductsChecked(data) {
      elmProductsChecked.innerHTML = data
        .map((item) => {
          item.ten =
            item["ten"].length > 70
              ? item["ten"].substring(0, 70) + "..."
              : item["ten"];
          return `<div class="flex p-2 items-center border border-gray-200 sm:rounded-lg rounded-base">
        <div class="flex items-center w-20">
            <img class="h-16" src="${item.hinhanh}" alt="">
        </div>
        <input checked name="proId[]" value="${item.id}" class="sr-only"/>
        <div class="flex  justify-between ml-4 flex-grow">
            <span class="text-sm">${item.ten}</span>
            <button type="button" class="">
                <svg data-product-checked-id = "${item.id}" class="font-semibold hover:text-red-500 text-gray-500 text-xs w-6 h-6 text-gray-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6m0 12L6 6" />
                </svg>
            </button>
        </div>
    </div>`;
        })
        .join(" ");
    },
    addError(elm, mes) {
      elm.classList.remove("hidden");
      elm.innerHTML = mes;
    },
    removeError(elm) {
      elm.classList.add("hidden");
      elm.innerHTML = "";
    },
    checkShowMore() {
      if (p == totalPage) {
        btnShowMore.classList.add("hidden");
      }
    },
    init() {
      //Open modal
      btnOpen.addEventListener("click", async () => {
        btnShowMore.classList.remove("hidden");
        modal.classList.remove("hidden");
        if (totalPage == 0) {
          const data = await this.getListProduct(limit, p, s);
          totalPage = parseInt(data.totalPage);
          tableListProduct.innerHTML = "";
          this.renderListProduct(data.data);
        }
        this.checkShowMore();
      });
      // btn show more
      btnShowMore.addEventListener("click", async () => {
        p = p + 1;
        const data = await this.getListProduct(limit, p, s);
        this.renderListProduct(data.data);
        this.checkShowMore();
      });
      // add list product
      btnAdd.addEventListener("click", () => {
        //check null
        this.addListProduct();
        if (productsChecked.length === 0) {
          this.addError(
            errListProduct,
            "Vui lòng tích chọn vào sản phẩm để áp dụng khuyến mãi!"
          );
        } else {
          this.removeError(error);
          this.renderProductsChecked(productsChecked);
          modal.classList.add("hidden");
          this.removeError(errListProduct);
        }
      });
      //remove product checked
      elmProductsChecked.addEventListener("click", (e) => {
        let id = 0;
        if (e.target.tagName == "path") {
          id = e.target.parentNode.dataset.productCheckedId;
        } else if (e.target.tagName == "svg") {
          id = e.target.dataset.productCheckedId;
        }
        this.removeProductChecked(parseInt(id));
        if (document.querySelector(`#proId${id}`)) {
          document.querySelector(`#proId${id}`).checked = false;
        }
        this.renderProductsChecked(productsChecked);
      });
      //Close modal
      btnClose.addEventListener("click", () => {
        modal.classList.add("hidden");
      });
      //remove err
      ipStartTime.addEventListener("input", function () {
        console.log(this.value);
      });
      ipEndTime.addEventListener("input", () => {
        this.removeError(error);
      });
      ipPercent.addEventListener("input", () => {
        this.removeError(error);
      });
      // submit form
      document.querySelector("#myForm").addEventListener("submit", (e) => {
        e.preventDefault();
        let arrMes = [];
        if (productsChecked.length === 0) {
          arrMes.push("Vui lòng thêm vào sản phẩm áp dụng khuyến mãi");
        }
        if (!isFinite(ipPercent.value)) {
          arrMes.push("phần trăm khuyến mãi không hợp lệ");
        } else if (!(parseFloat(ipPercent.value) < 100)) {
          arrMes.push("phần trăm khuyến mãi phải dưới 100");
        }
        const curDate = new Date();
        if (document.querySelector("input[name='id']").value == "") {
          if (
            new Date(ipStartTime.value) <
            new Date(
              curDate.getFullYear() +
                "-" +
                (curDate.getMonth() + 1) +
                "-" +
                curDate.getDate()
            )
          ) {
            arrMes.push(
              "Thời gian bắt đầu không được nhỏ hơn thời gian hiện tại"
            );
          }
        }
        if (ipStartTime.value == "") {
          arrMes.push("Thời gian bắt đầu không được rỗng");
        }
        if (ipChecked.checked) {
          if (ipEndTime.value == "") {
            arrMes.push("Thời gian kết thúc không được rỗng");
          }
          if (ipEndTime.value != "") {
            if (
              new Date(ipEndTime.value) <
                new Date(
                  curDate.getFullYear() +
                    "-" +
                    (curDate.getMonth() + 1) +
                    "-" +
                    curDate.getDate()
                ) ||
              new Date(ipEndTime.value) <= new Date(ipStartTime.value)
            ) {
              arrMes.push(
                "Thời gian kết thúc không được nhỏ hơn thời gian hiện tại và thời gian bắt đầu"
              );
            }
          }
        }

        if (arrMes.length != 0) {
          let mes = arrMes.join(", ").toLowerCase();
          let firstChar = mes[0].toUpperCase();
          this.addError(error, firstChar + mes.substring(1));
        } else {
          document.querySelector("#myForm").submit();
        }
      });
    },
  };
})();
productOption.init();

/*

  - bien ignore = false
 -neu chua tim thay 
  + lay mang cu + mang moi (ignore = false)
 - neu da tim thay
  + lay mang moi(mang checked)

khoi tao mang tam chua 


*/
