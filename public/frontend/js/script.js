$(document).ready(function () {
  // NEW BOOK Carousel
  var owlNew = $(".owl-new-book").owlCarousel({
    loop: true,
    margin: 16,
    responsive: {
      0: { items: 1 },
      576: { items: 2 },
      768: { items: 2 },
      992: { items: 4 },
    },
    autoplay: true,
    autoplayTimeout: 3000,
    autoplayHoverPause: true,
  });

  $(".slider-arrow-new-book.prev").click(function () {
    owlNew.trigger("prev.owl.carousel");
  });

  $(".slider-arrow-new-book.next").click(function () {
    owlNew.trigger("next.owl.carousel");
  });

  // TOP BOOK Carousel
  var owlTopBook = $(".owl-top-book").owlCarousel({
    loop: true,
    margin: 16,
    responsive: {
      0: { items: 1 },
      576: { items: 2 },
      768: { items: 2 },
      992: { items: 4 },
    },
    autoplay: true,
    autoplayTimeout: 3000,
    autoplayHoverPause: true,
  });

  $(".slider-arrow-top-book.prev").click(function () {
    owlTopBook.trigger("prev.owl.carousel");
  });

  $(".slider-arrow-top-book.next").click(function () {
    owlTopBook.trigger("next.owl.carousel");
  });

  // TOP Journals Carousel
  var owlTopJournals = $(".owl-top-journals").owlCarousel({
    loop: true,
    margin: 16,
    responsive: {
      0: { items: 1 },
      576: { items: 2 },
      768: { items: 2 },
      992: { items: 4 },
    },
    autoplay: true,
    autoplayTimeout: 3000,
    autoplayHoverPause: true,
  });

  $(".slider-arrow-top-journals.prev").click(function () {
    owlTopJournals.trigger("prev.owl.carousel");
  });

  $(".slider-arrow-top-journals.next").click(function () {
    owlTopJournals.trigger("next.owl.carousel");
  });

  // Seminar Proceeding Carousel
  var owlSeminarProceeding = $(".owl-seminar-proceeding").owlCarousel({
    loop: true,
    margin: 16,
    responsive: {
      0: { items: 1 },
      576: { items: 2 },
      768: { items: 2 },
      992: { items: 4 },
    },
    autoplay: true,
    autoplayTimeout: 3000,
    autoplayHoverPause: true,
  });

  $(".slider-arrow-seminar-proceeding.prev").click(function () {
    owlSeminarProceeding.trigger("prev.owl.carousel");
  });

  $(".slider-arrow-seminar-proceeding.next").click(function () {
    owlSeminarProceeding.trigger("next.owl.carousel");
  });

  //present years
  document.getElementById("current-year").textContent =
    new Date().getFullYear();
});
