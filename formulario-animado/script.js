$(".toggle").on("click", (e) => {
  e.preventDefault();
  $(".card").toggleClass("flipped");
});
