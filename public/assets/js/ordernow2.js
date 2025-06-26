const sslPaymentUrl = "https://securepay.sslcommerz.com/embed.min.js?";
// const sslPaymentUrl = "https://sandbox.sslcommerz.com/embed.min.js?";

//Run this code whenn sslecommerz will failed
document.addEventListener("DOMContentLoaded", () => {
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const paymentStatus = urlParams.get("payment");
  if (paymentStatus === "failed") {
    Swal.fire({
      icon: "error",
      title: "Payment failed",
      text: "Your payment process has failed.",
      confirmButtonText: "Try Again"
    }).then(() => {
      const newUrl = window.location.origin + window.location.pathname;
      window.history.replaceState({}, document.title, newUrl);
    });
  }
});

// Alpine Store - Start
document.addEventListener("alpine:init", () => {
  let checkoutData = {};
  let localStorageUserAddressExtract = {};
  try {
    // Retrieve and parse checkoutData from localStorage
    checkoutData = JSON.parse(localStorage.getItem("checkoutData")) || {};

    // Safely parse the address field if it exists
    if (checkoutData.address) {
      localStorageUserAddressExtract = JSON.parse(checkoutData.address);
    }
  } catch (error) {
    console.error("Error parsing data from localStorage:", error);
  }
  ("");
  // Extract individual fields with fallback values
  const localStorageCheckoutUserName = checkoutData.name || ""; // Default to 'Guest' if undefined
  const localStorageCheckoutUserPhone = checkoutData.username || "";
  const localStorageCheckoutUserEmail = checkoutData.email || "";
  const localStorageCheckoutUserAddress = localStorageUserAddressExtract.inset_address || "";
  const localStorageCheckoutUserNote = checkoutData.usernote || "";

  Alpine.store("orderStore", {
    // Store

    data: {
      name: localStorageCheckoutUserName || "",
      username: localStorageCheckoutUserPhone || "",
      email: localStorageCheckoutUserEmail || "",
      address: "",
      usernote: localStorageCheckoutUserNote || "",
      deliveryarea: "",
      shipping: 0,
      totalDeliveryCharge: 0,
      discount: 0,
      subTotal: 0,
      actualAmount: 0,
      flatDiscounts: [],
      total: 0,
      landingPageProductTotalPrice: 0,
      promoDiscount: 0, // Add promo discount here
      onlyCart: cart || [],
      couponCode: "",
      appliedCoupon: null,
      isApplying: false, // To prevent multiple submissions
      paymentMethods: paymentMethods,
      paymentMethod: "",
      onlyAddress: onlyAddress,
      delivery_area_options: delivery_area_options,
      paymentmethod: "",
      paymentAccountNumber: "",
      paymentTransitionID: "",
      paymentSlip: "",
      hasCourier: true,
      advancedInitial: true,
      advancedFull: false,
      bkashAdvanceOnlinePayment: 0,
      sslAdvanceOnlinePayment: 0,
      advancedMethod: "",
      advancedPaymentType: "",
      courier: "pathao",
      imageShortPath: "",
      slipPreviews: {},
      isModalOpen: false,
      loader: false,
      globalSettings: {},
      siteSetttings: {},
      pathaoAddress: {
        cities: [],
        zones: [],
        areas: [],
        deliveryTitles: [],
        city: {
          city_id: "",
          city_name: ""
        },
        zone: {
          zone_id: "",
          zone_name: ""
        },
        area: {
          area_id: "",
          area_name: ""
        },
        deliveryTitle: {
          deliveryTitle_id: "",
          deliveryTitle_name: ""
        }
      },
      inset_address: localStorageCheckoutUserAddress || "",
      freeShipping: false,
      delivery_charge_list: [],
      deliveryChargeArr: [],
      globalSettings: [],
      customField1: "",
      customField2: "",
      customField3: "",
      customField4: "",
      customField5: "",
      productQuantity: 1,
      productSku_id: cart[0]?.sku_id || "",
      productSlug: cart[0]?.slug,
      productHasVariation: false
    },
    // Fetch global settings
    async fetchData() {
      try {
        const response = await fetch(`${window.location.origin}/orders-v2/global-settings`);
        const result = await response.json();
        if (result) {
          this.globalSettings = result[0];
        }
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    },
    async fetchSettings() {
      try {
        const response = await fetch(`${window.location.origin}/orders-v2/config-settings`);
        const result = await response.json();
        if (result) {
          this.data.siteSetttings = result;
        }
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    },
    async handleSlipFileChange(e, paymentMethod) {
      const storeData = Alpine.store("orderStore").data;
      const selectedFile = e.target.files[0];

      if (selectedFile) {
        storeData.loader = true;
        if (!storeData.slipPreviews) storeData.slipPreviews = {};

        const formData = new FormData();
        formData.append("file", selectedFile);

        const uri = `${window.location.origin}/api/s3/file/upload?parentFolderName=images&subParentFolderName=checkout`;
        try {
          const response = await axios.post(uri, formData);
          if (response?.data?.data?.shortPath) {
            storeData.imageShortPath = response.data.data.shortPath;
            storeData.slipPreviews[paymentMethod] =
              `${storeData.siteSetttings?.imageUploadFolder?.serverPath}/${storeData.siteSetttings?.imageUploadFolder?.checkout}/${response.data.data.shortPath}`;
          }
        } catch (error) {
          console.log("Upload error:", error);
        } finally {
          storeData.loader = false;
        }
      } else {
        console.log("Please select a file to upload.");
      }
    },

    async handleSlipFileRemove(paymentMethod) {
      const storeData = Alpine.store("orderStore").data;
      storeData.loader = true;

      const filePath = storeData.slipPreviews[paymentMethod]?.split("/").slice(-1).join("/");

      const uri = `${window.location.origin}/api/s3/file/remove?filePath=${storeData.siteSetttings?.db_name}/${storeData.siteSetttings?.imageUploadFolder?.checkout}/${filePath}`;
      try {
        const response = await axios.delete(uri);
        storeData.loader = false;
        delete storeData.slipPreviews[paymentMethod];
        storeData.imageShortPath = "";
      } catch (error) {
        console.error("Remove error:", error);
      }
    },

    openModal(paymentMethod) {
      const storeData = Alpine.store("orderStore").data;
      if (storeData.slipPreviews[paymentMethod]) {
        storeData.isModalOpen = true;
      }
    },

    closeModal() {
      const storeData = Alpine.store("orderStore").data;
      storeData.isModalOpen = false;
    },

    // API Call for Promo Code
    async handlePromoCodeApply() {
      const couponCode = this.data.couponCode.trim();

      // Check if the coupon is already applied
      if (couponCode === this.data.appliedCoupon) {
        Swal.fire({
          icon: "info",
          title: "Coupon Code Already Applied",
          text: `The Coupon code "${couponCode}" has already been applied.`,
          confirmButtonText: "OK"
        });
        return;
      }

      // If not already applied, call the API
      this.data.isApplying = true;
      await this.applyPromoCode(couponCode);
      this.data.isApplying = false;
    },
    async updateFromFooterAlpineStoreForLandingPage(data) {
      if (islandingPage) {
        this.data.total = data.total + this.data.totalDeliveryCharge;
        this.data.landingPageProductTotalPrice = data.total;
        this.data.productQuantity = data.qty;
        this.data.productSku_id = data.sku_id;
        this.data.productSlug = data.product.slug;
        const advancedPay = await this.onlineAdvancedPayment(this.data.advancedMethod, this.data.advancedPaymentType);
        this.calculateDeliveryCharge();
      } else {
        return;
      }
    },
    async quantityCounter(product, action) {
      let variationMatrixId;
      let productTitle;
      let url;
      let qty = product.qty;
      if (product.variation) {
        variationMatrixId = product.variation._id;
        url = `${httpPath}/api/inventory/has-stock/${product.slug}?qty=${qty + 1}&sku_id=${product.sku_id}`;
      } else {
        productTitle = encodeURIComponent(product.title);
        url = `${httpPath}/api/inventory/has-stock/${product.slug}?qty=${qty + 1}`;
      }
      if (action == "increament") {
        /* Check the stock from the server */
        this.data.promoDiscount = 0;
        this.data.appliedCoupon = null;
        await fetch(url, {
          method: "GET",
          headers: {
            "Content-Type": "application/json"
          }
        })
          .then((res) => {
            //Will updated after backend dependency
            // Swal.fire({
            //   icon: "error",
            //   title: "Max limit",
            //   text: "Won't be Incremented",
            //   confirmButtonText: "Ok"
            // });
            if (!res.ok) {
              throw new Error("Response was not ok");
            }
            return res.json();
          })
          .then((res) => {
            if (res) {
              product.qty++;
              if (product.variation) {
                axios.get(`/cart/update?&variationMatrixId=${variationMatrixId}&action=${action}`);
              } else {
                axios.get(`/cart/update?title=${productTitle}&action=${action}`);
              }
            } else {
              return;
            }
          });
      } else if (action == "decreament") {
        this.data.promoDiscount = 0;
        this.data.appliedCoupon = null;
        if (product.qty == 1) {
          return;
        } else {
          product.qty--;
          if (product.variation) {
            axios.get(`/cart/update?&variationMatrixId=${variationMatrixId}&action=${action}`);
          } else {
            axios.get(`/cart/update?title=${productTitle}&action=${action}`);
          }
        }
      } else if (action == "remove") {
        this.data.promoDiscount = 0;
        this.data.appliedCoupon = null;

        if (!variationMatrixId) {
          this.data.onlyCart = this.data.onlyCart.filter((onlycartproduct) => onlycartproduct.title != product.title);
          axios.get(`/cart/update?title=${productTitle}&action=${action}`);
        } else {
          this.data.onlyCart = this.data.onlyCart.filter(
            (onlycartproduct) => onlycartproduct.variation?._id != variationMatrixId
          );
          axios.get(`/cart/update?variationMatrixId=${variationMatrixId}&action=${action}`);
        }

        if (this.data.onlyCart.length == 0 && window.location.pathname === "/checkout") {
          setTimeout(() => {
            window.location = "/";
          }, 500);
        }
        if ("<%- siteSettings.popUpCheckout %>") {
          if (this.data.onlyCart.length == 0) {
            closePopupCheckoutModal();
          }
        }
      }
    },

    async onlineAdvancedPayment(method, paymentType) {
      this.data.advancedMethod = method;
      this.data.advancedPaymentType = paymentType;

      // Update payment type flags
      this.data.advancedInitial = paymentType === "initial";
      this.data.advancedFull = paymentType === "full";

      const settingsKey = `${method}AdvanceOnlinePaymentActive`;
      const productWiseKey = `${method}ProductWiseAdvanced`;
      const amountTypeKey = `${method}AdvancedAmountType`;
      const amountKey = `${method}AdvancedAmount`;

      const isActive = this.data.globalSettings[settingsKey];
      const isProductWise = this.data.globalSettings[productWiseKey];
      const amountType = this.data.globalSettings[amountTypeKey];
      const amountValue = this.data.globalSettings[amountKey];
      // Helper function to calculate advanced payment
      const calculateAdvancedPayment = (type, amount, islandingPage) => {
        if (type === "flat") {
          if (islandingPage) {
            return this.data.advancedInitial
              ? Math.ceil(isProductWise ? amount * this.data.productQuantity : amount)
              : 0;
          } else {
            return this.data.advancedInitial
              ? Math.ceil(
                  isProductWise ? this.data.onlyCart.reduce((acc, product) => acc + product.qty * amount, 0) : amount
                )
              : 0;
          }
        } else if (type === "percentage") {
          if (islandingPage) {
            return this.data.advancedInitial
              ? Math.ceil(((this.data.total - this.data.totalDeliveryCharge) * amount) / 100)
              : 0;
          } else {
            const percentageValue = this.data.onlyCart.reduce((acc, product) => {
              const effectivePrice = product.discountprice || product.price;
              const totalPrice = effectivePrice * product.qty;
              return acc + (totalPrice * amount) / 100;
            }, 0);
            return Math.ceil(this.data.advancedInitial ? percentageValue : 0);
          }
        } else {
          console.warn(`Unknown advanced type: ${type}`);
          return 0;
        }
      };

      //Check if online payment method is active or not
      if (isActive) {
        if (this.data.advancedMethod == "ssl") {
          this.data.sslAdvanceOnlinePayment = calculateAdvancedPayment(amountType, amountValue, islandingPage);
        } else if (this.data.advancedMethod == "bkash") {
          this.data.bkashAdvanceOnlinePayment = calculateAdvancedPayment(amountType, amountValue, islandingPage);
        }
      } else {
        console.warn(`Advanced payment is not active for method: ${method}`);
        this.data.sslAdvanceOnlinePayment = 0;
        this.data.bkashAdvanceOnlinePayment = 0;
      }
    },

    async applyPromoCode(couponCode) {
      try {
        const body = {
          coupon: couponCode,
          phone: this.data.phone || "",
          products: this.data.onlyCart.map((product) => {
            return {
              productId: product._id,
              isVariant: product.hasVariations,
              quantity: product.qty,
              price: product.discountprice ? product.discountprice : product.price,
              variationId: product.hasVariations ? product.variation?._id || "" : "",
              variationName: product.hasVariations ? product.variation?.title || "" : ""
            };
          })
        };

        const response = await fetch(`${window.location.origin}/api/coupon/verify`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify(body)
        });

        const result = await response.json();

        if (result.success) {
          this.data.promoDiscount = result.data.discount;
          this.data.total -= result.data.discount; // Subtract discount from total
          this.data.appliedCoupon = couponCode; // Set the applied coupon
          Swal.fire({
            icon: "success",
            title: "Coupon Code Applied",
            text: result.message,
            confirmButtonText: "OK"
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Failed to Apply Coupon Code",
            text: result.message || "Failed to apply Coupon code.",
            confirmButtonText: "Try Again"
          });
        }
      } catch (error) {
        console.error("Error applying Coupon code:", error);
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "An error occurred. Please try again.",
          confirmButtonText: "OK"
        });
      }
    },

    getImages(product) {
      let image = "";
      console.log("product", product);

      if (product?.gallery_folder) {
        if (product?.hasVariations || product?.variation) {
          // image = `${window.location.origin}/images/products/${product?.gallery_folder}/${product?.variation?.image}`;

          image = `${this.data.siteSetttings.imageUploadFolder.serverPath}/${this.data.siteSetttings.imageUploadFolder.products}/${product?.gallery_folder}/${product?.variation?.image || product?.image}`;
        } else {
          image = `${this.data.siteSetttings.imageUploadFolder.serverPath}/${this.data.siteSetttings.imageUploadFolder.products}/${product?.gallery_folder}/${product?.image
            ?.split("/")
            .pop()}`;
        }
      } else {
        if (product?.hasVariations || product?.variation) {
          image = `${this.data.siteSetttings.imageUploadFolder.serverPath}/${this.data.siteSetttings.imageUploadFolder.products}/${product?.variation?.image}`;
        } else {
          image = `${this.data.siteSetttings.imageUploadFolder.serverPath}/${this.data.siteSetttings.imageUploadFolder.products}/${product?.image}`;
        }
      }
      return image;
    },

    // Validation data
    validate: {
      nameError: "",
      usernameError: "",
      emailError: "",
      addressError: "",
      insetAddressError: "",
      citySelectionError: "",
      zoneSelectionError: "",
      areaSelectionError: "",
      deliveryTitleSelectionError: ""
    },
    initializeLandingPageCart() {
      let attempt = 0;
      const maxAttempts = 10;

      const cartInterval = setInterval(() => {
        if (islandingPage && cart) {
          try {
            this.data.onlyCart = JSON.parse(cart).data || [];
            this.data.productSlug = JSON.parse(cart).data[0]?.slug || "";
            this.data.productHasVariation = JSON.parse(cart).data[0]?.hasVariations || "";
            clearInterval(cartInterval);
          } catch (error) {
            console.error("Error parsing cart data:", error);
          }
        }
        attempt++;
        if (attempt >= maxAttempts) {
          clearInterval(cartInterval);
        }
      }, 500);
    },

    // initialChanges
    async initData() {
      // // Billing details prefill data reset
      const data = this.data;
      data.delivery_charge_list = [...JSON.parse(this.data.delivery_area_options?.charge_list)] || [];

      data.pathaoAddress.deliveryTitles = [...JSON.parse(this.data.delivery_area_options?.charge_list)];

      if (data.onlyCart.length == 0 && currentPath === "/checkout") {
        window.location.replace("/");
      }

      data?.onlyCart.forEach((product) => {
        product.sale = product.discountprice < product.price ? true : false;
      });

      this.calculateDeliveryCharge();

      this.calcualteTotal();

      const cities = await this.getCities();
      const getSettings = await this.fetchSettings();
      const advancedPay = await this.onlineAdvancedPayment(this.data.advancedMethod, this.data.advancedPaymentType);

      await this.fetchData().then((globalSettings) => {
        if (globalSettings?.billingdataprefilldata !== "on") {
          localStorage.setItem("checkoutData", JSON.stringify({}));

          // Reload only if not already reloaded
          if (localStorage.getItem("hasReloaded") !== "true") {
            localStorage.setItem("hasReloaded", "true");
            location.reload();
          }
        }
      });
    },
    // Fetch global settings
    async fetchData() {
      try {
        const response = await axios.get(`${window.location.origin}/orders-v2/global-settings`);
        if (response.data && response.data.length > 0) {
          this.data.globalSettings = response.data[0];
          return this.data.globalSettings; // Return the fetched data
        }
        return null; // In case no valid data is received
      } catch (error) {
        console.error("Error fetching data:", error);
        return null; // Handle error and return null
      }
    },

    // Pathao Address manager
    async getCities() {
      this.data.promoDiscount = 0;
      this.data.appliedCoupon = null;
      const data = this.data;
      await axios
        .get(`https://storex.dev/MEUBxsxAAKEjR3s/api/pathao/get-cities`)
        .then(function (response) {
          if (response && response.status == 200) {
            data.pathaoAddress.cities = response.data.map((d) => ({
              ...d,
              city_name: d?.city_name?.trim()
            }));
            data.pathaoAddress.zones = [];
            // return response.data
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },

    async getZones(id) {
      this.data.promoDiscount = 0;
      this.data.appliedCoupon = null;
      const data = this.data;
      await axios
        .get(`https://storex.dev/MEUBxsxAAKEjR3s/api/pathao/get-zones/${id}`)
        .then(function (response) {
          if (response.data && response.status == 200 && data.pathaoAddress.zones.length == 0) {
            data.pathaoAddress.zones = response.data;
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    removeZone() {
      this.data.pathaoAddress.zone.zone_id = "";
      this.data.pathaoAddress.zone.zone_name = "";
    },

    async getAreas(id) {
      this.data.promoDiscount = 0;
      this.data.appliedCoupon = null;
      const data = this.data;
      await axios
        .get(`${window.location.origin}/api/courier/get-areas?zone_id=${id}`)
        .then(function (response) {
          if (response && response.status == 200) {
            data.pathaoAddress.areas = response.data;
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },

    async getPathaoAddress(incoming_data) {
      const pathaoAddress = this.data.pathaoAddress;
      if (this.data.onlyAddress === "on") {
        if (incoming_data.deliveryTitle_id) {
          const selecteddeliveryTitle = pathaoAddress.deliveryTitles.find(
            (deliveryTitle) => Number(deliveryTitle.id) === Number(incoming_data.deliveryTitle_id)
          );

          pathaoAddress.deliveryTitle.deliveryTitle_id = selecteddeliveryTitle.id;
          pathaoAddress.deliveryTitle.deliveryTitle_name = selecteddeliveryTitle.chargeTitle;
        }
      } else {
        // emptying zone and area if city is changed by customer
        if (pathaoAddress.city.city_id != incoming_data.city_id) {
          incoming_data.zone_id = "";
          incoming_data.area_id = "";
          pathaoAddress.zone.zone_id = "";
          pathaoAddress.zone.zone_name = "";
        }

        //
        const selectedCity = pathaoAddress.cities.find((city) => city.city_id == incoming_data.city_id);
        pathaoAddress.city.city_id = parseInt(selectedCity.city_id);
        pathaoAddress.city.city_name = selectedCity.city_name;

        if (incoming_data.zone_id) {
          const selectedZone = pathaoAddress.zones.find((zone) => zone.zone_id == incoming_data.zone_id);
          pathaoAddress.zone.zone_id = selectedZone.zone_id;
          pathaoAddress.zone.zone_name = selectedZone.zone_name;
        }
        if (pathaoAddress.city.city_id) {
          await this.getZones(parseInt(pathaoAddress.city.city_id));
        }
      }
    },

    // Form Datas
    handleChange(incoming_form_data) {
      const data = this.data;
      const validation_checker_obj = this.validate;

      data.deliveryarea = incoming_form_data.deliveryarea;
      data.customField1 = incoming_form_data.customField1;
      data.customField2 = incoming_form_data.customField2;
      data.customField3 = incoming_form_data.customField3;
      data.customField4 = incoming_form_data.customField4;
      data.customField5 = incoming_form_data.customField5;

      data.deliveryarea = incoming_form_data.deliveryarea;

      // courier address manager
      if (this.data.hasCourier && this.data.courier == "pathao") {
        this.getPathaoAddress(incoming_form_data);
      }

      // user Notes
      data.usernote = incoming_form_data.usernote || localStorageCheckoutUserNote;
      data.name = incoming_form_data.name || localStorageCheckoutUserName;
      data.username = incoming_form_data.username || localStorageCheckoutUserPhone;
      data.email = incoming_form_data.email || localStorageCheckoutUserEmail;
      data.address = incoming_form_data.address;
      data.inset_address = incoming_form_data.inset_address || localStorageCheckoutUserAddress;
    },

    calculateWeight(product, weightType) {
      switch (weightType) {
        case "gm":
          return Number(product.weightVal) / 1000;
          break;
        case "kg":
          return Number(product.weightVal) * 1;
          break;
        case "lbs":
          return Number(product.weightVal) * 0.45359237;
          break;
        case "Ml":
          return Number(product.weightVal) / 1000;
          break;
        case "litre":
          return Number(product.weightVal) * 1;
          break;

        default:
          break;
      }
    },

    deliveryCharge(product, action = "initial") {
      let data = this.data;
      switch (action) {
        case "initial":
          switch (product.deliveryType) {
            case "flat-rate":
              product.deliveryCharge = Number(delivery_area_options?.flat_rate);

              // find if the product exists
              const existingProduct = this.data.deliveryChargeArr.find((item) => item.product === product._id);
              // If the product id is not already in the array, push the new object
              if (!existingProduct) {
                this.data.deliveryChargeArr.push({
                  product: product._id,
                  amount: Number(delivery_area_options?.flat_rate)
                });
              }

              break;
            case "free-shipping":
              data.freeShipping = true;

              product.deliveryCharge = Number(0);

              // find if the product exists
              const existingProduct2 = this.data.deliveryChargeArr.find((item) => item.product === product._id);
              // If the product id is not already in the array, push the new object
              if (!existingProduct2) {
                this.data.deliveryChargeArr.push({
                  product: product._id,
                  amount: Number(0)
                });
              }

              break;

            case "rate-by-weight":
              const calcWeight = this.calculateWeight(product, product.weightType) * product.qty;
              let productWeight = calcWeight <= 2 ? calcWeight : Math.ceil(calcWeight);

              let deliveryChargeObj = {};

              if (this.data.onlyAddress === "on") {
                deliveryChargeObj = data.delivery_charge_list?.find(
                  (obj) => obj.chargeTitle === data.pathaoAddress.deliveryTitle.deliveryTitle_name
                );
              } else {
                const selectedObject = data.delivery_charge_list?.find(
                  (obj) =>
                    obj.selectedDistricts && obj.selectedDistricts.includes(data.pathaoAddress.city.city_name.trim())
                );
                if (selectedObject) {
                  deliveryChargeObj = selectedObject;
                } else {
                  deliveryChargeObj = {};
                }
              }

              let chargeAmount = 0;

              if (Number(productWeight) >= 0 && Number(productWeight) <= 0.5) {
                product.deliveryCharge = Number(deliveryChargeObj?.range_1);

                chargeAmount = Number(deliveryChargeObj?.range_1);
              } else if (Number(productWeight) >= 0.6 && Number(productWeight) <= 1) {
                product.deliveryCharge = Number(deliveryChargeObj?.range_2);

                chargeAmount = Number(deliveryChargeObj?.range_2);
              } else if (Number(productWeight) >= 1.1 && Number(productWeight) <= 2) {
                product.deliveryCharge = Number(deliveryChargeObj?.range_3);

                chargeAmount = Number(deliveryChargeObj?.range_3);
              } else {
                const extraWeight = Number(productWeight) - 2;
                const extraCharge = extraWeight * deliveryChargeObj?.extraCharge;

                product.deliveryCharge = Number(deliveryChargeObj?.range_3) + extraCharge;

                chargeAmount = Number(deliveryChargeObj?.range_3) + extraCharge;
              }

              if (isNaN(chargeAmount)) {
                chargeAmount = 0;
              }
              // find if the product exists
              const existingProductIndex = this.data.deliveryChargeArr.findIndex((item) => {
                if (product?.hasVariations) {
                  return item.product === product?.variation?._id;
                } else {
                  return item.product === product._id;
                }
              });

              // If the product id is not already in the array, push the new object
              if (existingProductIndex === -1) {
                this.data.deliveryChargeArr.push({
                  product: product?.hasVariations ? product?.variation?._id : product._id,
                  amount: chargeAmount
                });
              } else {
                // If the product exists, update the amount
                this.data.deliveryChargeArr[existingProductIndex].amount = chargeAmount;
              }

              break;
            default:
              break;
          }
          break;

        default:
          break;
      }
    },

    deliveryChargeV2(weight) {
      if (islandingPage) {
        weight *= this.data.productQuantity;
      }
      let data = this.data;
      let deliveryChargeObj = {};

      if (this.data.onlyAddress === "on") {
        deliveryChargeObj = data.delivery_charge_list?.find(
          (obj) => obj.chargeTitle === data.pathaoAddress.deliveryTitle.deliveryTitle_name
        );
      } else {
        const selectedObject = data.delivery_charge_list?.find(
          (obj) => obj.selectedDistricts && obj.selectedDistricts.includes(data.pathaoAddress.city.city_name.trim())
        );
        if (selectedObject) {
          deliveryChargeObj = selectedObject;
        } else {
          deliveryChargeObj = {};
        }
      }

      let chargeAmount = 0;

      if (Number(weight) === 0) {
        chargeAmount = 0;
      } else if (Number(weight) > 0 && Number(weight) <= 0.5) {
        chargeAmount = Number(deliveryChargeObj?.range_1);
      } else if (Number(weight) >= 0.6 && Number(weight) <= 1) {
        chargeAmount = Number(deliveryChargeObj?.range_2);
      } else if (Number(weight) >= 1.1 && Number(weight) <= 2) {
        chargeAmount = Number(deliveryChargeObj?.range_3);
      } else {
        const extraWeight = Math.ceil(Number(weight) - 2);
        const extraCharge = extraWeight * deliveryChargeObj?.extraCharge;

        chargeAmount = Number(deliveryChargeObj?.range_3) + extraCharge;
      }

      if (isNaN(chargeAmount)) {
        chargeAmount = 0;
      }
      chargeAmount = parseInt(chargeAmount);

      return chargeAmount;
    },

    // Delivery Charge
    calculateDeliveryCharge() {
      let data = this.data;

      let weight = 0;

      const hasFlatRate = data?.onlyCart?.some((product) => product?.deliveryType === "flat-rate");

      const calculateTotalWeight = data?.onlyCart?.map((product) => {
        if (product?.deliveryType === "rate-by-weight") {
          const calcWeight = this.calculateWeight(product, product.weightType) * product.qty;
          let productWeight = calcWeight <= 2 ? calcWeight : Math.ceil(calcWeight);

          weight += productWeight;
        }
      });

      const rateByWeightCharge = this.deliveryChargeV2(weight);

      let totalAmount = (hasFlatRate ? Number(delivery_area_options?.flat_rate) : 0) + rateByWeightCharge;

      // for (let i = 0; i < this.data.deliveryChargeArr.length; i++) {
      //   totalAmount += this.data.deliveryChargeArr[i].amount;
      // }
      this.data.totalDeliveryCharge = totalAmount;
    },

    // calculateTotal
    calcualteTotal() {
      const data = this.data;

      let tempSubTotal = 0;

      // Subtotal
      data.onlyCart.forEach((product) => {
        if (!product.variation) {
          tempSubTotal += product.discountprice * product.qty;
        } else {
          tempSubTotal += product.variation.discountprice * product.qty;
        }
      });

      data.subTotal = tempSubTotal;
      // Total
      data.actualAmount = data.subTotal + Number(data.totalDeliveryCharge);
      data.total = data.actualAmount - Number(data.discount);
    },

    // Payment method
    async updatePaymentInfo(selectedPaymentMethod, caller) {
      const data = this.data;

      // clear the fields if this function is called by onClick event
      if (caller == "click") {
        data.paymentAccountNumber = "";
        data.paymentTransitionID = "";
      }

      // Setting the payment method
      data.paymentMethod = selectedPaymentMethod;
      // Toggle Functionality for the payment method's contents holder.
      data.paymentMethods.forEach((paymentMethod) => {
        let contentContainer = document.getElementById(paymentMethod.name);
        if (contentContainer) {
          if (contentContainer.id == selectedPaymentMethod) {
            contentContainer.classList.remove("hide");
          } else {
            contentContainer.classList.add("hide");
          }
        }
      });
      switch (selectedPaymentMethod) {
        case "SSLCOMMERZ":
          this.data.advancedMethod = "ssl";
          this.data.advancedPaymentType = "initial";
          break;
        case "BKASHONLINE":
          this.data.advancedMethod = "bkash";
          this.data.advancedPaymentType = "initial";
          break;
        default:
          break;
      }
      if (islandingPage && this.data.landingPageProductTotalPrice) {
        this.data.total = this.data.landingPageProductTotalPrice + this.data.totalDeliveryCharge;
      }
    },

    // incomplete order start
    incompleteOrderChecking(input) {
      // Limit the input to 11 digits
      if (input.value.length > input.maxLength) {
        input.value = input.value.slice(0, input.maxLength);
      }

      // Trigger request when exactly 11 digits are entered
      if (input.value.length === 11) {
        this.data.username = input.value;
        this.incompleteOrderHandler();
      }
    },
    async incompleteOrderHandler(payload) {
      data = this.data;

      let address;
      if (data.onlyAddress === "on") {
        address = {
          inset_address: data.inset_address
        };
      } else if (data.hasCourier && data.courier == "pathao") {
        address = {
          city: JSON.stringify(data.pathaoAddress.city),
          zone: JSON.stringify(data.pathaoAddress.zone),
          inset_address: data.inset_address
        };
      } else {
        address = {
          inset_address: data.inset_address
        };
      }

      // Collect all data from the form
      let orderData = {
        name: data.name,
        username: data.username,
        email: data.email,
        address: JSON.stringify(address),
        usernote: data.usernote,
        deliveryarea: data.deliveryarea,
        shippingCharge: data.totalDeliveryCharge,
        hasCourier: data.hasCourier,
        courier: data.courier,
        insetAddress: data.inset_address,
        paymentMethod: data.paymentMethod,
        paymentAccountNumber: data.paymentAccountNumber,
        paymentTransitionID: data.paymentTransitionID,
        total: data.total,
        landingPage: false,
        paymentSlip: data.imageShortPath,
        bkashAdvanceOnlinePayment: data.bkashAdvanceOnlinePayment,
        sslAdvanceOnlinePayment: data.sslAdvanceOnlinePayment,
        promoDiscount: data.promoDiscount,
        customField1: data.customField1 || "",
        customField2: data.customField2 || "",
        customField3: data.customField3 || "",
        customField4: data.customField4 || "",
        customField5: data.customField5 || "",
        cart: data.onlyCart.map((item) => JSON.parse(JSON.stringify(item)))
      };

      if (!orderData) {
        console.error("Payload is invalid or empty.");
        return;
      }

      try {
        const response = await axios.post(`${window.location.origin}/api/incomplete-order/create`, orderData);
        if (!response.ok) {
          throw new Error("Failed to send order. Status: " + response.status);
        }
        const data = await response.json();
        console.log("Order submitted successfully:", data);
      } catch (error) {
        console.error("Error sending order:", error);
      }
    },
    // incomplete order end

    // handling submit
    async handleSubmit() {
      data = this.data;
      const validation_checker_obj = this.validate;

      // Name Validation
      if (this.data.name !== "" && this.data.name?.length <= 3) {
        validation_checker_obj.nameError = "সর্বনিম্ন ৩টি অক্ষর বিশিষ্ট নাম লিখুন";
      } else if (this.data.name === "") {
        validation_checker_obj.nameError = "আপনার নাম লিখুন";
      } else {
        validation_checker_obj.nameError = "";
        data.name = this.data.name;
      }

      // Number Validation
      if (this.data.username === "") {
        validation_checker_obj.usernameError = "আপনার মোবাইল নাম্বার দিন";
      } else if (!/^\d+$/.test(this.data.username)) {
        validation_checker_obj.usernameError = "মোবাইল নম্বরটি ভ্যালিড নয় ";
      } else if (this.data.username !== "" && this.data.username?.length < 11) {
        validation_checker_obj.usernameError = "সর্বনিম্ন ১১ ডিজিটের সঠিক মোবাইল নাম্বার দিন";
      } else if (!/^01/.test(this.data.username)) {
        validation_checker_obj.usernameError = "সঠিক মোবাইল নাম্বার দিন যা ০১ দিয়ে শুরু";
      } else {
        validation_checker_obj.usernameError = "";
        data.username = this.data.username;
      }

      // Email Validations
      if ("<%- siteSettings.orderformfieldemail %>") {
        const validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        if (this.data.email !== "" && !this.data.email.match(validRegex)) {
          validation_checker_obj.emailError = "সঠিক ইমেইল দিন";
        } else {
          validation_checker_obj.emailError = "";
          data.email = this.data.email;
        }
      }

      // Address Validation
      if (this.data.inset_address === "") {
        validation_checker_obj.addressError = "আপনার ঠিকানা লিখুন";
      } else {
        validation_checker_obj.addressError = "";
        data.address = this.data.address;
      }

      // Area Validation
      if (this.data.inset_address !== "" && this.data.inset_address?.length <= 3) {
        validation_checker_obj.insetAddressError = "আপনার ঠিকানা লিখুন";
      } else {
        validation_checker_obj.insetAddressError = "";
        data.inset_address = this.data.inset_address;
      }

      //  Validation
      if (this.data.pathaoAddress.city.city_id === "") {
        validation_checker_obj.citySelectionError = "জেলা সিলেক্ট করুন";
      } else {
        validation_checker_obj.citySelectionError = "";
        data.address = this.data.address;
      }

      //  Validation
      if (this.data.pathaoAddress.zone.zone_id === "") {
        validation_checker_obj.zoneSelectionError = "থানা সিলেক্ট করুন";
      } else {
        validation_checker_obj.zoneSelectionError = "";
        data.address = this.data.address;
      }

      // Upazila Validation
      if (this.data.area_id === "") {
        validation_checker_obj.areaSelectionError = "থানা সিলেক্ট করুন";
      } else {
        validation_checker_obj.areaSelectionError = "";
        data.address = this.data.address;
      }

      // delivery title Validation
      if (this.data.deliveryTitle_id === "") {
        validation_checker_obj.deliveryTitleSelectionError = "delivery title সিলেক্ট করুন";
      } else {
        validation_checker_obj.deliveryTitleSelectionError = "";
        data.address = this.data.address;
      }

      // Zilla Validation
      if (!this.data.onlyAddress && this.data.pathaoAddress.city.city_id === "") {
        this.validate.citySelectionError = "জেলা সিলেক্ট করুন";
        return;
      } else {
        this.validate.citySelectionError = "";
      }

      //Zone  Validation
      if (!this.data.onlyAddress && this.data.pathaoAddress.zone.zone_id === "") {
        this.validate.zoneSelectionError = "থানা সিলেক্ট করুন";
        return;
      } else {
        this.validate.zoneSelectionError = "";
      }

      if (this.data.onlyAddress === "on" && this.data.pathaoAddress.deliveryTitle.deliveryTitle_id === "") {
        this.validate.deliveryTitleSelectionError = "delivery title সিলেক্ট করুন";
        return;
      }

      if (data.delivery_area_options?.length > 0 && data.deliveryarea == "") {
        return alert("Please select your delivery area first");
      }

      let address;
      if (data.onlyAddress === "on") {
        address = {
          inset_address: data.inset_address
        };
      } else if (data.hasCourier && data.courier == "pathao") {
        address = {
          city: JSON.stringify(data.pathaoAddress.city),
          zone: JSON.stringify(data.pathaoAddress.zone),
          inset_address: data.inset_address
        };
      } else {
        address = {
          inset_address: data.inset_address
        };
      }

      // Disabling Submit Button - start
      if (data.onlyAddress === "on") {
        if (
          validation_checker_obj.nameError !== "" ||
          validation_checker_obj.usernameError !== "" ||
          validation_checker_obj.emailError !== "" ||
          validation_checker_obj.insetAddressError !== "" ||
          validation_checker_obj.deliveryTitleSelectionError !== ""
        ) {
          document.getElementById("disable").disabled = true;
        } else {
          document.getElementById("disable").disabled = false;
        }
      } else {
        if (
          validation_checker_obj.nameError !== "" ||
          validation_checker_obj.usernameError !== "" ||
          validation_checker_obj.emailError !== "" ||
          validation_checker_obj.insetAddressError !== "" ||
          validation_checker_obj.citySelectionError !== "" ||
          validation_checker_obj.zoneSelectionError !== ""
        ) {
          document.getElementById("disable").disabled = true;
        } else {
          document.getElementById("disable").disabled = false;
        }
      }

      // Check if the payment method is not bkash or sll then advanced payment will be 0
      if (data.paymentMethod !== "BKASHONLINE" && data.paymentMethod !== "SSLCOMMERZ") {
        data.bkashAdvanceOnlinePayment = 0;
        data.sslAdvanceOnlinePayment = 0;
      }

      // Disabling Submit Button - End
      if (islandingPage && !!data.globalSettings.defaultVariationSelect && !data.productSku_id) {
        data.productSku_id = JSON.parse(cart).data[0]?.sku_id;
      }
      let orderData = {
        name: data.name,
        username: data.username,
        email: data.email,
        address: JSON.stringify(address),
        usernote: data.usernote,
        deliveryarea: data.deliveryarea,
        shippingCharge: data.totalDeliveryCharge,
        hasCourier: data.hasCourier,
        courier: data.courier,
        insetAddress: data.inset_address,
        paymentMethod: data.paymentMethod,
        paymentAccountNumber: data.paymentAccountNumber,
        paymentTransitionID: data.paymentTransitionID,
        total: data.total,
        paymentSlip: data.imageShortPath,
        bkashAdvanceOnlinePayment: data.bkashAdvanceOnlinePayment,
        sslAdvanceOnlinePayment: data.sslAdvanceOnlinePayment,
        promoDiscount: data.promoDiscount,
        customField1: data.customField1 || "",
        customField2: data.customField2 || "",
        customField3: data.customField3 || "",
        customField4: data.customField4 || "",
        customField5: data.customField5 || "",
        cart: data.onlyCart.map((item) => JSON.parse(JSON.stringify(item)))
      };

      if (islandingPage) {
        orderData = {
          ...orderData,
          landingPage: true,
          slug: data.productSlug,
          sku_id: data.productSku_id,
          qty: data.productQuantity
        };
      }
      // Create a new FormData object
      const formData = new FormData();

      // Append each key/value pair from orderData to the FormData object
      Object.entries(orderData).forEach(([key, value]) => {
        formData.append(key, value);
      });
      const hasValidationErrors = Object.values(validation_checker_obj).some((error) => error !== "");

      if (hasValidationErrors) {
        return;
      }
      if (this.data.globalSettings?.billingdataprefilldata == "on") {
        localStorage.setItem("checkoutData", JSON.stringify(orderData));
        // For empty billing details data form
        localStorage.setItem("hasReloaded", false);
      }

      // Check validation from backend api
      try {
        const checkLandingPage = async () => {
          const response = await axios.post(`${window.location.origin}/cart/landing-cart-update`, formData);
          if (!response.data) throw new Error("Please Try Again");
        };

        const preCheck = async () => {
          const response = await axios.post(`${window.location.origin}/cart/check-directorder`, formData);
          if (!response?.data?.success) throw new Error(response?.data?.message || "Order Confirmation Failed");
          this.data.preCheckoutCheck = true;
        };

        const handlePayment = async (url, data) => {
          loadingSpinner.style.display = "block";
          const response = await axios.post(url, data);
          if (response?.data?.success && response.data.url) {
            window.location.href = response.data.url;
          } else {
            throw new Error(response?.data?.message || "Failed to initialize payment.");
          }
        };

        const dynamicScriptLoader = (src) => {
          const script = document.createElement("script");
          script.src = src + Math.random().toString(36).substring(7);
          document.getElementsByTagName("script")[0].parentNode.insertBefore(script, null);
        };

        const handleOrder = async (url) => {
          loadingSpinner.style.display = "block";
          const response = await axios.post(url, formData);
          if (response?.data?.success && response?.data?.data?.orderID) {
            window.location.href = `${window.location.origin}/order/success`;
          } else {
            throw new Error("Direct Order failed");
          }
        };

        // Process starts here
        if (islandingPage) {
          if (this.data.productHasVariation) {
            if (this.data.productSku_id) {
              await checkLandingPage();
            } else {
              Swal.fire({
                icon: "error",
                title: "Please select all variation",
                text: "Product order failed.",
                confirmButtonText: "Try Again"
              });
              return false;
            }
          } else {
            await checkLandingPage();
          }
        }
        await preCheck();
        const paymentUrls = {
          SSLCOMMERZ: `${window.location.origin}/api/online-payment/ssl-commerz`,
          BKASHONLINE: `${window.location.origin}/api/online-payment/bkash`,
          "Cash On Delivery": `${window.location.origin}/cart/directorder`
        };

        const paymentUrl = paymentUrls[this.data.paymentMethod] || paymentUrls["Cash On Delivery"];
        if (this.data.paymentMethod === "SSLCOMMERZ" || this.data.paymentMethod === "BKASHONLINE") {
          await handlePayment(paymentUrl, orderData);
          dynamicScriptLoader(sslPaymentUrl);
        } else {
          await handleOrder(paymentUrl);
        }

        loadingSpinner.style.display = "none";
      } catch (error) {
        console.error(error.message || "Error occurred during the process.");
        loadingSpinner.style.display = "none";
        Swal.fire({
          icon: "error",
          title: error.message || "Error",
          confirmButtonText: "Try Again"
        });
      }
    },

    // Checking if the discount is available from the server
    async getFlatDiscountData() {},

    // updating flat discount on every change
    flatDiscountChecker() {
      if (this.data.flatDiscounts) {
        const data = this.data;

        data.flatDiscounts.forEach((discount) => {
          if (data.actualAmount >= discount.minimun_price_item && data.actualAmount <= discount.maximum_price_item) {
            data.discount = discount.discount_price_item;
          }
        });
      }
    },
    formatFloat(number) {
      if (Number.isInteger(number)) {
        return number;
      } else {
        return parseFloat(number).toFixed(2);
      }
    }
  });
  Alpine.store("orderStore").initializeLandingPageCart();
});

// Alpine Store - End
