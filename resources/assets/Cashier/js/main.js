

document.addEventListener("DOMContentLoaded", function () {
  // Banner Swiper
  const bannerSwiperElement = document.querySelector(".bannerSwiper");
  if (bannerSwiperElement) {
    const bannerSwiper = new Swiper(".bannerSwiper", {
      loop: true,
      slidesPerView: 1,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      autoplay: {
        delay: 3000,
        disableOnInteraction: false,
      },
    });
  }

  // Check if we're on a mobile device
  const isMobile = window.innerWidth < 640;

  // Statistics Swiper
  const statisticsSwiperElement = document.querySelector(".statisticsSwiper");
  if (statisticsSwiperElement) {
    const statisticsSwiper = new Swiper(".statisticsSwiper", {
      slidesPerView: 1,
      spaceBetween: 10,
      autoplay: {
        delay: 2000,
        disableOnInteraction: false,
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      breakpoints: {
        480: {
          slidesPerView: 1,
          spaceBetween: 15,
        },
        640: {
          slidesPerView: 3,
          spaceBetween: 20,
        },
        720: {
          slidesPerView: 4,
          spaceBetween: 20,
        },
      },
    });
  }

  // Project Sections Swiper
  const projectSectionsElement = document.querySelector(".ProjectSections");
  if (projectSectionsElement) {
    const Cardswiper = new Swiper(".ProjectSections", {
      loop: !isMobile,
      slidesPerView: 1,
      spaceBetween: 1,
      allowTouchMove: !isMobile,
      autoplay: isMobile
        ? false
        : {
            delay: 2000,
            disableOnInteraction: false,
          },
      breakpoints: {
        320: {
          slidesPerView: 1,
        },
        640: {
          slidesPerView: 2,
          spaceBetween: 10,
        },
        1008: {
          slidesPerView: 4,
          spaceBetween: 10,
        },
        1400: {
          slidesPerView: 5,
          spaceBetween: 10,
        },
      },
      navigation: {
        nextEl: ".ProjectSection-button-next",
        prevEl: ".ProjectSection-button-prev",
      },
      pagination: {
        el: ".swiper-pagination",
      },
    });
  }

  // Ramdan Project Swiper
  const ramdanProjectElement = document.querySelector(".RamdanProjectSwiper");
  if (ramdanProjectElement) {
    const ramdanSwiper = new Swiper(".RamdanProjectSwiper", {
      navigation: {
        nextEl: ".RamdanProject-button-next",
        prevEl: ".RamdanProject-button-prev",
      },
      breakpoints: {
        320: {
          slidesPerView: 1,
          spaceBetween: 10,
        },
        1404: {
          slidesPerView: 3,
          spaceBetween: 10,
        },
      },
      autoplay: isMobile
        ? false
        : {
            delay: 5000,
            disableOnInteraction: false,
          },
      slidesPerView: 3,
      spaceBetween: 30,
    });
  }
  // Ramdan Project Swiper
  const projectSwiperElement = document.querySelector(".projectSwiper");
  if (projectSwiperElement) {
    const ramdanSwiper = new Swiper(".projectSwiper", {
      navigation: {
        nextEl: ".projectSwiper-button-next",
        prevEl: ".projectSwiper-button-prev",
      },
      breakpoints: {
        320: {
          slidesPerView: 1,
          spaceBetween: 10,
        },
        1404: {
          slidesPerView: 3,
          spaceBetween: 10,
        },
      },
      autoplay: isMobile
        ? false
        : {
            delay: 5000,
            disableOnInteraction: false,
          },
      slidesPerView: 3,
      spaceBetween: 30,
    });
  }

  // Get the modal element
  const modal = document.getElementById("exampleModal");

  // MY WORK

  document.addEventListener("DOMContentLoaded", function () {
    // document.querySelector('.custom-hamburger').addEventListener('click', function() {
    //   this.classList.toggle('active');
    //   console.log('ssssssssss');

    // });

    // document.querySelector('.custom-hamburger').addEventListener('click', function() {
    //   this.classList.toggle('active');
    //   console.log('ssssssssss');

    // });

    // Select all elements with the class 'Card'
    const cards = document.querySelectorAll(".home .Card");

    // Add a click event listener to each card
    cards.forEach((card, idx) => {
      card.addEventListener("click", function () {
        // Store the clicked card index in localStorage
        localStorage.setItem("selectedCardIndex", idx);

        // Redirect to category.html
        window.location.href = "category.html";
      });
    });
  });

  document.querySelectorAll(".swiper-slide").forEach(function (slide) {
    var amountBtns = slide.querySelectorAll(".amount-btn");
    amountBtns.forEach(function (btn) {
      btn.addEventListener("click", function () {
        amountBtns.forEach(function (b) {
          b.classList.remove("active-amount");
        });
        btn.classList.add("active-amount");
        // Optionally, set the input value if present
        var input = slide.querySelector(".custom-card-input");
        if (input) input.value = btn.textContent.replace(/[^\d]/g, "");
      });
    });
  });
});

//NAV-BAR
document.addEventListener("DOMContentLoaded", function () {
  const navLinks = document.querySelectorAll(".navbar-nav .nav-item");
  const navIcon = document.querySelector(".nav-icon");
  const collapse = document.querySelector(".navbar-collapse");
  const customHamburger = document.querySelector(".custom-hamburger");
  navIcon.addEventListener("click", function () {
    customHamburger.classList.toggle("active");
    collapse.classList.toggle("active");
  });
  navLinks.forEach((link) => {
    link.addEventListener("click", function () {
      link.classList.toggle("show");
      console.log('link');
      console.log(link);
      
      
    });
  });
});
// Fast Pay Animation Implementation
document.addEventListener("DOMContentLoaded", function () {
  // Fast Pay functionality

  const fastPay = document.querySelector(".fast-pay");
  const fastPayContainer = document.querySelector(".fast-pay .container");
  const donationForm = document.querySelector(".fast-pay .donation-form");
  const donationOptions = document.querySelectorAll(
    ".fast-pay .donation-option"
  );
  const projectGroups = document.querySelectorAll(".fast-pay .project-group");
  const projectSelects = document.querySelectorAll(".fast-pay .project-select");
  const donationAmounts = document.getElementById("donation-amounts");
  const amountGroups = document.querySelectorAll(".fast-pay .amount-group");

  if (fastPayContainer) {
    // Toggle expanded state when clicking the container
    fastPayContainer.addEventListener("click", function (e) {
      if (!fastPay.classList.contains("expanded")) {
        fastPay.classList.add("expanded");
      } else {
        fastPay.classList.remove("expanded");
      }
    });

    // Handle donation option selection
    donationOptions.forEach((option) => {
      option.addEventListener("click", function (e) {
        e.stopPropagation();
        // Remove active class from all options
        donationOptions.forEach((opt) => opt.classList.remove("active"));
        // Add active class to clicked option
        this.classList.add("active");

        // Show corresponding project group
        const selectedOption = this.dataset.option;
        projectGroups.forEach((group) => {
          if (group.dataset.for === selectedOption) {
            group.style.display = "block";
          } else {
            group.style.display = "none";
          }
        });

        // Hide donation amounts when changing donation type
        if (donationAmounts) {
          donationAmounts.style.display = "none";
        }

        // Reset project selects
        projectSelects.forEach((select) => {
          select.selectedIndex = 0;
        });
      });
    });

    // Handle project selection
    projectSelects.forEach((select) => {
      select.addEventListener("change", function () {
        // Show donation amounts section
        if (donationAmounts) {
          donationAmounts.style.display = "block";
        }

        // Get the donation type from the data attribute
        const donationType = this.dataset.type;

        // Show the corresponding amount group
        amountGroups.forEach((group) => {
          if (group.dataset.for === donationType) {
            group.style.display = "block";
          } else {
            group.style.display = "none";
          }
        });
      });
    });

    // Handle amount button selection
    const amountButtons = document.querySelectorAll(".fast-pay .amount-btn");
    amountButtons.forEach((button) => {
      button.addEventListener("click", function (e) {
        e.stopPropagation();

        // Find the parent amount group
        const parentGroup = this.closest(".amount-group");

        // Remove active class from all buttons in this group
        const groupButtons = parentGroup.querySelectorAll(".amount-btn");
        groupButtons.forEach((btn) => btn.classList.remove("active"));

        // Add active class to clicked button
        this.classList.add("active");

        // You can also update a hidden input or variable with the selected amount
        const amountValue = this.textContent.replace(/[^\d]/g, "");
        console.log("Selected amount:", amountValue);
      });
    });

    // Show initial project group based on active donation option
    const initialActiveOption = document.querySelector(
      ".fast-pay .donation-option.active"
    );
    if (initialActiveOption) {
      const selectedOption = initialActiveOption.dataset.option;
      const correspondingGroup = document.querySelector(
        `.fast-pay .project-group[data-for="${selectedOption}"]`
      );
      if (correspondingGroup) {
        correspondingGroup.style.display = "block";
      }
    }

    // Prevent form clicks from closing the container
    if (donationForm) {
      donationForm.addEventListener("click", function (e) {
        e.stopPropagation();
      });
    }

    // Close fast pay when clicking outside
    document.addEventListener("click", function (e) {
      if (
        fastPay.classList.contains("expanded") &&
        !fastPayContainer.contains(e.target) &&
        e.target !== fastPayContainer
      ) {
        fastPay.classList.remove("expanded");
      }
    });

    // Handle escape key to close
    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape" && fastPay.classList.contains("expanded")) {
        fastPay.classList.remove("expanded");
      }
    });
  }
});

document.addEventListener("DOMContentLoaded", function () {
  // ... existing code ...

  // Make navigation links active based on current page
  function setActiveNavLink() {
    // Get current page URL
    const currentPage = window.location.pathname.split("/").pop();

    // Get all nav links
    const navLinks = document.querySelectorAll(".navbar-nav .nav-link");

    // Remove active class from all links
    navLinks.forEach((link) => {
      link.classList.remove("active");
    });

    // Add active class to current page link
    navLinks.forEach((link) => {
      console.log("currentPage", currentPage);
      console.log("////////");
      const linkHref = link.getAttribute("href");
      console.log("link", link);

      if (
        linkHref === currentPage ||
        (currentPage === "" && linkHref === "index.html") ||
        (currentPage === "/" && linkHref === "index.html")
      ) {
        link.classList.add("active");
      }
    });
  }

  // Call the function when page loads
  setActiveNavLink();
});

