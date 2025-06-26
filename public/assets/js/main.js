// $(function() {

//   $('a.confirmDeletion').on('click', function () {
//     if(!confirm('Confirm Delete!'))
//       return false
//   })

//   if($(".errors-wrap .alert").length > 0){
//     let dealy = 4000;
//     $(".errors-wrap .alert").each(function() {
//       $(this).delay(dealy).slideUp(200, function() {
//         $(this).alert('close');
//       });
//       dealy += 500;
//     });
//   }
// })

// Sticky Menu
var header = document.getElementById("main-header");
if (header) {
  window.onscroll = function () {
    stickyFun();
  };
  var bodyWrapper = document.querySelector(".main-body-wrapper");
  var navPlaceholder = document.createElement("div");
  navPlaceholder.classList.add("nav-placeholder");
  bodyWrapper.prepend(navPlaceholder);
  var sticky = header.offsetTop;
  function stickyFun() {
    if (window.pageYOffset >= sticky + 400) {
      header.classList.add("sticky");
      bodyWrapper.classList.add("header-sticky");
      bodyWrapper.style.paddingTop = header.offsetHeight + "px";
    } else {
      header.classList.remove("sticky");
      bodyWrapper.classList.remove("header-sticky");
      bodyWrapper.style.paddingTop = "0px";
    }
  }
}

// for cart side bar start from here
// Check if we need to dispatch the event after the page reload
window.addEventListener("load", () => {
  if (localStorage.getItem("openCartDrawerAfterReload") === "true") {
    // Trigger the 'openCartDrawer' event after a delay
    setTimeout(() => {
      document.dispatchEvent(new Event("openCartDrawer"));
      // Clear the flag after dispatching the event
      localStorage.removeItem("openCartDrawerAfterReload");
    }, 200);
  }
});
//cart side bar toggler function
function toggleCartDrawer(open) {
  const drawer = document.getElementById("drawer");
  const overlay = document.getElementById("overlay");

  if (open) {
    drawer.classList.remove("-right-full");
    drawer.classList.add("right-0");
    overlay.classList.remove("hidden");
    overlay.classList.add("block");
  } else {
    drawer.classList.remove("right-0");
    drawer.classList.add("-right-full");
    overlay.classList.remove("block");
    overlay.classList.add("hidden");
  }
}

// Listen for 'openCartDrawer' events to open the drawer
document.addEventListener("openCartDrawer", () => toggleCartDrawer(true));

// Listen for 'closeCartDrawer' events to close the drawer
document.addEventListener("closeCartDrawer", () => toggleCartDrawer(false));

// Close drawer when clicking outside (on overlay)
const overLayDiv = document.getElementById("overlay");
if (overLayDiv) {
  overLayDiv.addEventListener("click", () => {
    toggleCartDrawer(false);
  });
}

// Close button inside the drawer
const closeBtn = document.getElementById("closeBtn");
if (closeBtn) {
  document.getElementById("closeBtn").addEventListener("click", () => {
    toggleCartDrawer(false);
  });
}

// Function to handle form submission
function handleFormSubmit(event) {
  // Prevent form from submitting immediately
  event.preventDefault();

  // Capture current scroll position
  const scrollPosition = window.scrollY;

  // Set flags in localStorage
  localStorage.setItem("openCartDrawerAfterReload", "true");
  localStorage.setItem("scrollPosition", scrollPosition);

  // Submit the form
  event.target.submit();
}

// Scroll to saved position on page load
window.addEventListener("load", () => {
  const savedScrollPosition = localStorage.getItem("scrollPosition");

  if (savedScrollPosition) {
    // Smooth scroll to the saved position with an offset of 150px
    window.scrollTo({
      top: parseInt(savedScrollPosition, 10) - 150
    });

    // Remove the item from localStorage to prevent repeated scrolling
    localStorage.removeItem("scrollPosition");
  }
});
// for cart side bar end here
// pop up checkout start from here
document.addEventListener("DOMContentLoaded", () => {
  // Check if cached modal HTML exists and render it
  const cachedModalHTML = sessionStorage.getItem("checkoutModalHTML");
  if (cachedModalHTML) {
    // Remove the cached HTML after rendering to prevent reuse
    sessionStorage.removeItem("checkoutModalHTML");

    // Render the modal
    const modalContainer = document.getElementById("checkout-modal-wrapper");
    if (modalContainer) {
      modalContainer.innerHTML = cachedModalHTML;
    }

    // Enable modal close functionality
    setupPopupCheckoutModalClose();
  }
});

function buyNow(productSlug, from) {
  const scrollPosition = window.scrollY;
  localStorage.setItem("scrollPosition", scrollPosition);
  const url = from === "buyNowButton" ? `/cart/ordernowcart/${productSlug}` : `/checkout/checkoutModal/api`;
  console.log("From url: ", url);
  fetch(url, { method: "GET" })
    .then((response) => response.json())
    .then((data) => {
      if (data.html) {
        if (from === "buyNowButton" || from === "productDetails") {
          // Cache the modal HTML in sessionStorage
          sessionStorage.setItem("checkoutModalHTML", data.html);
          // Reload the page to apply changes
          setTimeout(() => {
            window.location.reload();
          }, 100); // Adjust the timeout as needed
        } else {
          // Render directly into the wrapper without reloading
          const modalWrapper = document.getElementById("checkout-modal-wrapper");
          if (modalWrapper) {
            modalWrapper.innerHTML = data.html;
          }
          setupPopupCheckoutModalClose(); // Enable modal close functionality
        }
      } else {
        alert("Error: Unable to load the checkout modal.");
      }
    })
    .catch((err) => console.error("AJAX Error:", err));
}

function closePopupCheckoutModal() {
  const modalContainer = document.getElementById("checkout-modal-wrapper");
  if (modalContainer) {
    modalContainer.innerHTML = ""; // Clear the content
    document.body.style.overflow = "auto"; // Restore scrolling
  }
}

function setupPopupCheckoutModalClose() {
  const modal = document.getElementById("checkout-modal");
  if (modal) {
    // Close modal when clicking the overlay
    modal.addEventListener("click", (event) => {
      if (event.target === modal || event.target.classList.contains("backdrop-blur-md")) {
        closePopupCheckoutModal();
      }
    });

    // Close modal when clicking the close button
    const closeButton = modal.querySelector("button[onclick='closePopupCheckoutModal()']");
    if (closeButton) {
      closeButton.addEventListener("click", closePopupCheckoutModal);
    }
  }
}

// pop up checkout end here

//Offcanvas Toggler
const offcanvasToggler = document.querySelector("#offcanvas-toggler");
const offcanvasClose = document.querySelector(".offcanvas-close");
const offcanvasWrap = document.querySelector("#offcanvas-wrap");
const mainBody = document.querySelector("body");

offcanvasToggler.addEventListener("click", () => {
  mainBody.classList.toggle("offcanvas-active");
  offcanvasWrap.classList.toggle("active");
});

offcanvasClose.addEventListener("click", () => {
  mainBody.classList.toggle("offcanvas-active");
  offcanvasWrap.classList.toggle("active");
});

const offcanvasOveraly = document.querySelector(".offcanvas-overaly");
offcanvasOveraly.addEventListener("click", () => {
  mainBody.classList.remove("offcanvas-active");
  offcanvasWrap.classList.remove("active");
});

//Cart Toggler
const cartMenu = document.querySelector("#cart-menu");
const cartDropdown = document.querySelector("#cart-dropdown");
if (cartMenu) {
  cartMenu.addEventListener("click", () => {
    cartDropdown.classList.toggle("active");
  });
}

//Search Toggler
// const searchToggler = document.querySelector("#search-toggler")
// const searchBox = document.querySelector("#search-box")

// searchToggler.addEventListener('click', () => {
//   searchBox.classList.toggle('active');
// })

//Dismiss Alert
// let delay = 4000;
// const alert = document.querySelectorAll('.alert:not(.no-fade)');
// const noFadeAlert = document.querySelector('body').classList.contains('no-fade-alert');
// Array.prototype.forEach.call(alert, function(el, i){
//     el.addEventListener('click', function(e){
//         if(e.target.ariaLabel == "Close"){
//             if(el.parentNode.classList.contains('order-msg-wrap')){
//               el.parentNode.classList.remove('order-msg-wrap');
//             }
//             el.parentNode.removeChild(el);
//         }
//     })
//     if(!noFadeAlert){
//       //alert auto close
//       setTimeout(() => {
//           el.parentNode.removeChild(el);
//       }, delay);
//       delay += 500;
//     }
// });

//order msg
const orderSuccessMsg = document.querySelector(".order-success-msg");
if (orderSuccessMsg) {
  orderSuccessMsg.parentNode.classList.add("order-msg-wrap");
}

// Category Menu
const catMenu = document.querySelector("#wh-catmenu");
if (catMenu) {
  const hasChild = document.querySelectorAll(".menu-item.has-child .toggle-icon");
  hasChild.forEach(function (item) {
    item.addEventListener("click", function () {
      this.nextElementSibling.classList.toggle("active");
      this.closest(".menu-item.has-child").classList.toggle("active");
    });
  });
}

//ajax search
// const search = document.getElementById("search");
// const matchList = document.getElementById("match-list");

// const searchStates = async searchText => {
//   const headerSearchBox = document.querySelector('header #search-box>div')
//   const httpPath = headerSearchBox.getAttribute('data-httpPath');
//   const productsRes = await fetch(`${httpPath}/products/api/all`);
//   const productStates = await productsRes.json();

//   let matches = productStates.filter(state => {
//     const regex = new RegExp(`${searchText}`, "gi");
//     return state.title.match(regex) || state.productid.match(regex);
//   });

//   if (searchText.length === 0) {
//     matches = [];
//     matchList.innerHTML = "";
//   }
//   outputHtml(matches);
// };

// const outputHtml = matches => {
//   if (matches.length > 0) {
//     const html = matches
//       .map(
//         match => `
//           <div class="flex align-items-center relative mb-3">
//             <a href="/products/${match.slug}" class="stretched-link"></a>
//               <div class="mr-5">
//                 <img src="/images/products/${match.gallery_folder}/${match.gallery[0]}" class="img-fluid">
//               </div>
//               <div>
//                 <h4 class="mb-1 mt-3 text-lg font-bold">${match.title}</h4>
//                 <p class="m-0"><strong>${match.discountprice ? `<ins class="mr-1">Tk ${match.discountprice}</ins>
//                 <del class="text-secondary-focus">Tk ${match.price}</del>` : match.price}</strong></p>
//             </div>
//           </div>`
//       ).join("");
//     matchList.innerHTML = html;
//   }
// };
// search.addEventListener('change' , async () => {
//   const headerSearchBox = document.querySelector('header #search-box>div')
//   const httpPath = headerSearchBox.getAttribute('data-httpPath');
//   const res = await fetch(`${httpPath}/fb-conversion`, {
//     method: "POST",
//     mode: "cors", // no-cors, *cors, same-origin
//     cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
//     credentials: "same-origin",
//     headers: {
//       "Content-Type" : "application/json"
//     },
//     body: JSON.stringify({
//       eventName: "search",
//       eventData: {
//         keyword: search.value
//       }
//     })
//   });
//   await res.json();
// });

// search.addEventListener("input", () => {
//   return searchStates(search.value)
// });

//add to cart ajax request
function addToCart(slug) {
  const formData = new FormData();
  formData.append("slug", slug);

  const xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const result = JSON.parse(this.responseText);

      //flash message
      const bodyWrapper = document.querySelector(".body-wrapper");
      let flashBox = document.createElement("div");
      flashBox.classList.add("errors-wrap");
      flashBox.innerHTML = `<div class="alert alert-success alert-hide-auto text-center my-5">Product added to cart.</div>`;
      bodyWrapper.append(flashBox);

      // update cart service
      // const cartList = `<div class="cartlist-dropdown">
      //   <ul>
      //     ${result.map(item => `<li>${item.title}</li>` ).join('')}
      //   </ul>
      // </div>`;
      // const cartMenuWrap = document.querySelector('.cartlist-wrap');
      // cartMenuWrap.innerHTML = cartList;

      //update cart counter
      const cartNotification = document.querySelector(".cart-notification");
      cartNotification.innerHTML = result.length;
    } else if (this.readyState == 4 && this.status != 200) {
      console.log("error occured!");
    }
  };
  xhr.open("POST", "/cart/add");
  xhr.send(formData);
}

const cartbtn = document.querySelectorAll(".cart-button");
if (cartbtn.length) {
  cartbtn.forEach(function (btn) {
    btn.addEventListener("click", function () {
      const slug = this.dataset.slug;
      addToCart(slug);
    });
  });
}

// image gallery js

function showVideo() {
  const videoContainer = document.getElementById("videoContainer");
  const iframe = videoContainer.querySelector("iframe");
  if (iframe) {
    iframe.style.width = "100%";
    iframe.style.height = "100%";
  } else {
    console.log("No iframe found in product.video");
  }
}

function showVideoInMainGallery() {
  document.getElementById("videoContainer").scrollIntoView({ behavior: "smooth" });
}
// image gallery js




document.addEventListener('DOMContentLoaded', function () {
  var splideEl = document.querySelector('#splide01');
  if (splideEl) {
    new Splide(splideEl, {
      type: 'loop',
      perPage: 5,
      interval: 3000,
      autoplay: true,
      gap: '1rem',
      breakpoints: {
        768: {
          perPage: 2.5,
        },
        480: {
          perPage: 2,
        }
      }
    }).mount();
  } else {
    console.warn('Splide element not found: #splide01');
  }
});

document.addEventListener('DOMContentLoaded', function () {
  var main = document.querySelector('#main-slider');
  var thumbs = document.querySelector('#thumbnail-slider');

  if (main && thumbs) {
    var thumbnailSlider = new Splide(thumbs, {
      fixedWidth: 100,
      fixedHeight: 64,
      isNavigation: true,
      gap: 10,
      focus: 'center',
      pagination: false,
      cover: true,
      breakpoints: {
        600: {
          fixedWidth: 66,
          fixedHeight: 44,
        },
      },
    }).mount();

    var mainSlider = new Splide(main, {
      type: 'fade',
      heightRatio: 0.9,
      pagination: false,
      arrows: false,
      cover: true,
    });

    mainSlider.sync(thumbnailSlider).mount();
  } else {
    console.warn("Slider elements not found.");
  }
});

if ($('#banner-slider').length > 0) {

  new Splide('#banner-slider', {
    type: 'loop',
    autoplay: true,
    interval: 3000,
    pauseOnHover: false,
    arrows: false,
    pagination: true,
  }).mount();
}

document.addEventListener('DOMContentLoaded', function () {
    new Splide('#splide02', {
        type: 'loop',
        perPage: 4,
        perMove: 1,
        autoplay: true,
        interval: 3000,
        pauseOnHover: true,
        pagination: true,
        arrows: true,
        breakpoints: {
            768: {
                perPage: 2,
            },
            480: {
                perPage: 1,
            },
        },
    }).mount();
});

// Update main image and zoom image if the selected variation has an image
function updateProductImages(variation) {
  const mainImageElement = document.querySelector('.flexImg .main-image');
  const zoomImageElement = document.querySelector('.flexImg .zoom-image');

  if (variation?.image) {
    this.data.variationImage = variation.image;

    const imageUrl = `${this.data?.siteSettings?.imageUploadFolder?.serverPath}/${this.data?.siteSettings?.imageUploadFolder?.products}/${this.data.product.gallery_folder}/${variation.image}`;
    if (mainImageElement && zoomImageElement) {
      mainImageElement.src = imageUrl;
      zoomImageElement.src = imageUrl;
      mainImageElement.style.display = 'block';
      zoomImageElement.style.display = 'block';
    }
  } else {
    const defaultImage = this.data.product.gallery[0];
    if (mainImageElement && zoomImageElement) {
      const defaultImageUrl = `${this.data?.siteSettings?.imageUploadFolder?.serverPath}/${this.data?.siteSettings?.imageUploadFolder?.products}/${this.data.product.gallery_folder}/${defaultImage}`;
      mainImageElement.src = defaultImageUrl;
      zoomImageElement.src = defaultImageUrl;
    }
  }
}
