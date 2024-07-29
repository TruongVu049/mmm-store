const productOption = (function () {
  const modal = document.querySelector("#modal-option");
  const modalEdit = document.querySelector("#modal-edit_option");
  const btnOpen = document.querySelector("#btn_open");
  const btnClose = document.querySelector("#btn_close");

  const ipPrice = document.querySelector("input[name='gia']");
  const ipName = document.querySelector("input[name='ten']");
  const ipProImage = document.querySelector("input[name='image1']");
  const ipDesc = document.querySelector("textarea[name='mota']");
  const btnCraeteOptionValue = document.querySelector("#btn_createOpionValue");
  const btnCreateOption = document.querySelector("#btn-createOption");
  const ipSize = document.querySelector("input[name='ip_size']");
  const ipColor = document.querySelector("input[name='ip_color']");
  const ipQuantity = document.querySelector("input[name='ip_quantity']");
  const ipImage = document.querySelector("#image");
  const errOptionValue = document.querySelector("#err_craeteOptionValue");

  //edit option
  const btnEditModal = document.querySelector("#btn-edit_option");
  const btnCloseEditModal = document.querySelector("#btn-close_edit_option");
  const ipEditQuantity = document.querySelector(
    "input[name='ip_edit_quantity']"
  );
  const ipEditSize = document.querySelector("input[name='ip_edit_size']");

  const errEditOption = document.querySelector("#err_editOption");

  const tableOptionValue = document
    .querySelector("#table_optionValue")
    .getElementsByTagName("tbody")[0];
  const tableOption = document
    .querySelector("#table_option")
    .getElementsByTagName("tbody")[0];
  let option_id = 0;
  let option_value_id = 0;
  let option = [
    // {
    //   id: null,
    //   color: null,
    //   image: null,
    //   option_value: []
    // }
    // {
    //   id: 0,
    //   color: "xanh",
    //   image: "dfsfsdfsd",
    //   option_value: [
    //     {
    //       id: 0,
    //       size: "s",
    //       quantity: 12,
    //     },
    //   ],
    // },
  ];
  const inputData = document.querySelector("input[name='data']");
  if (inputData.value) {
    JSON.parse(inputData.value).forEach((item) => {
      option.push({
        id: item.id,
        color: item.mausac,
        image: item.hinhanh,
        option_value: item.option_value.map((i) => {
          return {
            id: i.id,
            size: i.kichco,
            quantity: i.soluong,
          };
        }),
      });
    });
  }
  let optionValue = [
    // {
    //   id: null,
    //   quantity: null,
    //   size: null,
    // },
  ];
  return {
    addOption(optionValue) {
      option.push(optionValue);
    },
    editOption(option_id, option_value_id, size, quantity) {
      option = option.map((item) => {
        if (parseInt(item.id) !== option_id) return item;
        else {
          _option_value = item.option_value.map((v) => {
            if (parseInt(v.id) !== option_value_id) return v;
            else {
              return {
                id: v.id,
                size: size,
                quantity: quantity,
              };
            }
          });
          return {
            ...item,
            option_value: _option_value,
          };
        }
      });
    },
    removeOption(option_id, option_value_id) {
      let _option = option.find((item) => parseInt(item.id) === option_id);
      if (_option.option_value.length === 1) {
        option = option.filter((item) => parseInt(item.id) !== _option.id);
      } else {
        option = option.map((item) => {
          if (item.id !== _option.id) {
            return item;
          } else {
            _option_value = _option.option_value.filter(
              (v) => parseInt(v.id) !== option_value_id
            );
            return {
              ..._option,
              option_value: _option_value,
            };
          }
        });
      }
    },
    renderOption() {
      tableOption.innerHTML = "";
      if (option.length === 0) {
        tableOption.innerHTML = `<tr>
            <td colspan="7" class="text-center py-4 bg-gray-200 text-gray-800">......</td>
        </tr>`;
      } else {
        option.forEach((item) => {
          // onerror="this.src='<../../public/images/ctgr_b.png'"
          let row_image = `
              <tr class="" style="border: 1px solid rgb(100 116 139);">
                  <td class=" px-6 py-4 text-gray-900" rowspan="${
                    item.option_value.length + 1
                  }"><img style="margin: 0 auto;" src="${
            item.image
          }"  class="w-16" /></td>
                  <td style="border: 1px solid rgb(100 116 139);" class="capitalize  px-6 py-4 text-gray-900" rowspan="${
                    item.option_value.length + 1
                  }">${item.color}</td>
              </tr>
          `;
          item.option_value.forEach((v) => {
            row_image += `
                   <tr style="border: 1px solid rgb(100 116 139);" class="">
                      <td class="capitalize  px-6 py-4 text-gray-900">${v.size}</td>
                      <td class="capitalize  px-6 py-4 text-gray-900">${v.quantity}</td>
                      <td class="capitalize  px-6 py-4 text-gray-900">
                          <button type="button"  class="inline-block cursor-pointer edit_option font-medium text-gray-600  hover:underline">
                              <svg data-option_id="${item.id}" data-option_value_id="${v.id}" class="btn_edit_option_value w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                  <path d="M12.687 14.408a3.01 3.01 0 0 1-1.533.821l-3.566.713a3 3 0 0 1-3.53-3.53l.713-3.566a3.01 3.01 0 0 1 .821-1.533L10.905 2H2.167A2.169 2.169 0 0 0 0 4.167v11.666A2.169 2.169 0 0 0 2.167 18h11.666A2.169 2.169 0 0 0 16 15.833V11.1l-3.313 3.308Zm5.53-9.065.546-.546a2.518 2.518 0 0 0 0-3.56 2.576 2.576 0 0 0-3.559 0l-.547.547 3.56 3.56Z" />
                                  <path d="M13.243 3.2 7.359 9.081a.5.5 0 0 0-.136.256L6.51 12.9a.5.5 0 0 0 .59.59l3.566-.713a.5.5 0 0 0 .255-.136L16.8 6.757 13.243 3.2Z" />
                              </svg>
                          </button>
                          <button type="button"  class=" inline-block cursor-pointer remove_option font-medium text-red-600  hover:underline">
                               <svg data-option_id="${item.id}" data-option_value_id="${v.id}" class="btn_remove_option_value w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h16M7 8v8m4-8v8M7 1h4a1 1 0 0 1 1 1v3H6V2a1 1 0 0 1 1-1ZM3 5h12v13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V5Z" />
                              </svg>
                          </button>
                      </td>
                  </tr>
              `;
          });
          tableOption.innerHTML += row_image;
        });
      }
    },
    createOptionValue(size, quantity) {
      optionValue.push({
        id: option_value_id--,
        quantity: quantity,
        size: size,
      });
    },
    removeOptionValue(id) {
      optionValue = optionValue.filter((item) => item.id != id);
    },
    renderOptionValue() {
      tableOptionValue.innerHTML = "";
      if (optionValue.length === 0) {
        tableOptionValue.innerHTML = `<tr>
        <td colspan="3" class="text-center py-4 bg-gray-200 text-gray-800">......</td>
    </tr>`;
      } else {
        tableOptionValue.innerHTML = optionValue.map((item) => {
          return `<tr class="border-b">
          <td class="px-6 py-4 text-gray-900">
              ${item.size}
          </td>
          <td class="px-6 py-4 text-gray-900">
            ${item.quantity}
          </td>
          <td class="px-6 py-4 text-gray-900">
              <button  class=" font-medium text-red-600  hover:underline" type="button" id="btn-remove_option_value">
                  <svg data-optionValueId ="${item.id}" class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h16M7 8v8m4-8v8M7 1h4a1 1 0 0 1 1 1v3H6V2a1 1 0 0 1 1-1ZM3 5h12v13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V5Z"></path>
                  </svg>
              </button>
          </td>
          </tr>`;
        });
      }
    },
    addError(elm, mes) {
      elm.classList.remove("hidden");
      elm.innerHTML = mes;
    },
    removeError(elm) {
      elm.classList.add("hidden");
      elm.innerHTML = "";
    },
    init() {
      const that = this;
      //Open modal
      btnOpen.addEventListener("click", () => {
        optionValue = [];
        this.renderOptionValue();
        this.removeError(errOptionValue);
        modal.classList.remove("hidden");
      });
      //Close modal
      btnClose.addEventListener("click", () => {
        modal.classList.add("hidden");
      });
      //create option value
      btnCraeteOptionValue.addEventListener("click", () => {
        if (ipSize.value === "" || ipQuantity.value === "") {
          this.addError(
            document.querySelector("#err_craeteOptionValue"),
            "Vui lòng điền vào màu sắc và size!"
          );
        } else {
          this.createOptionValue(ipSize.value, parseInt(ipQuantity.value));
          ipSize.value = "";
          ipQuantity.value = "";
          this.renderOptionValue();
        }
      });
      // remove option value
      tableOptionValue.addEventListener("click", (e) => {
        if (e.target.tagName == "path" || e.target.tagName == "svg") {
          if (e.target.tagName == "path") {
            this.removeOptionValue(
              parseInt(e.target.parentNode.dataset.optionvalueid)
            );
          } else {
            this.removeOptionValue(parseInt(e.target.dataset.optionvalueid));
          }
          this.renderOptionValue();
        }
      });
      // create option
      btnCreateOption.addEventListener("click", () => {
        if (
          ipColor.value == "" ||
          ipImage.value == "" ||
          optionValue.length == 0
        ) {
          let mes = "Vui lòng điền vào ";
          if (ipColor.value == "") mes += "màu sắc, ";
          if (ipImage.value == "") mes += "tải lên hình ảnh, ";
          if (optionValue.length == 0) mes += "size, số lượng ";
          this.addError(errOptionValue, mes);
        } else {
          this.addOption({
            id: option_id--,
            color: ipColor.value,
            image: ipImage.value,
            option_value: optionValue,
          });
          optionValue = [];
          this.renderOption();
          ipColor.value = "";
          ipImage.value = "";
          document.querySelector("#img_upload").classList.add("hidden");
          document.querySelector("#svg_upload").classList.remove("hidden");
          this.renderOptionValue();
          if (
            !document.querySelector(".errTuyChon").classList.contains("hidden")
          ) {
            document.querySelector(".errTuyChon").classList.add("hidden");
          }
          modal.classList.add("hidden");
        }
      });
      // =============
      tableOption.addEventListener("click", (e) => {
        if (e.target.tagName == "svg" || e.target.tagName == "path") {
          let isBtnEdit = true;
          let _option_id = 0;
          let _option_value_id = 0;
          if (e.target.tagName == "path") {
            if (
              e.target.parentNode.classList.contains("btn_edit_option_value")
            ) {
              // btn edit option
              isBtnEdit = true;
            } else {
              // btn remove option
              isBtnEdit = false;
            }
            _option_id = parseInt(e.target.parentNode.dataset.option_id);
            _option_value_id = parseInt(
              e.target.parentNode.dataset.option_value_id
            );
          } else {
            if (e.target.classList.contains("btn_edit_option_value")) {
              // btn edit option
              isBtnEdit = true;
            } else {
              // btn remove option
              isBtnEdit = false;
            }
            _option_id = parseInt(e.target.dataset.option_id);
            _option_value_id = parseInt(e.target.dataset.option_value_id);
          }

          if (isBtnEdit) {
            // edit option
            _option_value = option
              .find((item) => parseInt(item.id) === _option_id)
              .option_value.find(
                (item) => parseInt(item.id) === _option_value_id
              );
            ipEditQuantity.value = _option_value.quantity;
            ipEditSize.value = _option_value.size;
            btnEditModal.dataset.edit_option_id = _option_id;
            btnEditModal.dataset.edit_option_value_id = _option_value_id;
            modalEdit.classList.remove("hidden");
          } else {
            // remove option
            this.removeOption(_option_id, _option_value_id);
            this.renderOption();
          }
        }
      });
      // save modal edit option
      btnEditModal.addEventListener("click", () => {
        if (ipEditQuantity.value == "" || ipEditSize.value == "") {
          let mes = "Vui lòng điền vào ";
          if (ipEditSize.value == "") mes += "size, ";
          if (ipEditQuantity.value == "") mes += "số lượng ";
          this.addError(errEditOption, mes);
        } else {
          this.editOption(
            parseInt(btnEditModal.dataset.edit_option_id),
            parseInt(btnEditModal.dataset.edit_option_value_id),
            ipEditSize.value,
            parseInt(ipEditQuantity.value)
          );
          modalEdit.classList.add("hidden");
          this.renderOption();
        }
      });
      // close modal edit option
      btnCloseEditModal.addEventListener("click", () => {
        modalEdit.classList.add("hidden");
        ipEditQuantity.value = "";
        ipEditSize.value = "";
        btnEditModal.dataset.edit_option_id = "";
        btnEditModal.dataset.edit_option_value_id = "";
      });
      // remove error
      ipSize.addEventListener("input", () => {
        if (!errOptionValue.classList.contains("hidden")) {
          this.removeError(errOptionValue);
        }
      });
      ipQuantity.addEventListener("input", () => {
        if (!errOptionValue.classList.contains("hidden")) {
          this.removeError(errOptionValue);
        }
      });
      ipColor.addEventListener("input", () => {
        if (!errOptionValue.classList.contains("hidden")) {
          this.removeError(errOptionValue);
        }
      });
      ipEditQuantity.addEventListener("input", () => {
        if (!errEditOption.classList.contains("hidden")) {
          this.removeError(errEditOption);
        }
      });
      ipEditSize.addEventListener("input", () => {
        if (!errEditOption.classList.contains("hidden")) {
          this.removeError(errEditOption);
        }
      });
      ipName.addEventListener("input", function () {
        if (!this.nextElementSibling.classList.contains("hidden")) {
          that.removeError(this.nextElementSibling);
        }
      });
      ipDesc.addEventListener("input", function () {
        if (!this.nextElementSibling.classList.contains("hidden")) {
          that.removeError(this.nextElementSibling);
        }
      });
      ipPrice.addEventListener("input", function () {
        if (!this.nextElementSibling.classList.contains("hidden")) {
          that.removeError(this.nextElementSibling);
        }
      });
      document.getElementById('file1').addEventListener("input", function () {
        if (!document.querySelector(".errHinhAnh").classList.contains("hidden")) {
          that.removeError(document.querySelector(".errHinhAnh"));
        }
      });
      // submit form

      document
        .querySelector("#myForm")
        .addEventListener("submit", function (e) {
          e.preventDefault();
          let isValid = true;


          if (ipProImage.value == "") {
            isValid = false;
            that.addError(
              document.querySelector(".errHinhAnh"),
              "Vui lòng thêm hình ảnh cho sản phẩm"
            );
          }

          if (!isFinite(ipPrice.value)) {
            isValid = false;
            that.addError(
              ipPrice.nextElementSibling,
              "Giá sản phẩm không hợp lệ!"
            );
          } else {
            if (parseFloat(ipPrice.value) <= 0) {
              isValid = false;
              that.addError(
                ipPrice.nextElementSibling,
                "Giá sản phẩm phải lớn hơn 0!"
              );
            }
          }

          if (option.length == 0) {
            isValid = false;
            that.addError(
              document.querySelector(".errTuyChon"),
              "Vui lòng thêm tùy chọn cho sản phẩm!"
            );
          }

          if (isValid) {
            inputData.value = JSON.stringify(option);
            this.submit();
          }
        });
    },
  };
})();
productOption.init();
