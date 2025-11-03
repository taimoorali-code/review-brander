document.addEventListener("DOMContentLoaded", function () {
  const toggleButton = document.getElementById("toggle-mega");
  const header = document.querySelector("header");

  toggleButton.addEventListener("click", function (event) {
    event.preventDefault(); // Prevent the default link behavior

    // Toggle the class on the header
    header.classList.toggle("active");
  });
});

const popoverTriggerList = document.querySelectorAll(
  '[data-bs-toggle="popover"]'
);
const popoverList = [...popoverTriggerList].map(
  (popoverTriggerEl) => new bootstrap.Popover(popoverTriggerEl)
);

// script.js

$(document).ready(function () {
  // Define the scroll threshold
  var scrollThreshold = 50; // Adjust this value as needed

  $(window).scroll(function () {
    // Check the current scroll position
    var scrollPosition = $(this).scrollTop();

    // Add or remove the class based on scroll position
    if (scrollPosition > scrollThreshold) {
      $("header").addClass("sticky");
    } else {
      $("header").removeClass("sticky");
      $("header").removeClass("header-dark");
    }
  });

  $("#toggleFiltersSidebar").on("click", function () {
    $("#category-sidebar").addClass("active");
    $("body").addClass("overflow-hidden");
    $(".page-overlay").addClass("active");
  });

  $("#close-category-filters").on("click", function () {
    $("#category-sidebar").removeClass("active");
    $("body").removeClass("overflow-hidden");
    $(".page-overlay").removeClass("active");
  });
});
///notification
$(document).ready(function () {
  $("#showDropdown").on("click", function () {
    console.log("true");

    $("#notificationDropdown").toggleClass("active");
    $("#navbarSupportedContent").addClass("show");
  });

  $("#notification-close").on("click", function () {
    $("#notificationDropdown").removeClass("active");
    $("#navbarSupportedContent").removeClass("show");
  });
});

$(".slider").slick({
  dots: false,
  autoplay: true,
  autoplaySpeed: 2000,
  infinite: true,
  speed: 500,
  slidesToShow: 3,
  slidesToScroll: 1,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: true,
        dots: true,
      },
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
      },
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
      },
    },
  ],
});
