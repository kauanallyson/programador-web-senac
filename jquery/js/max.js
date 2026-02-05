$(() => {
  const cores = [
    "red",
    "orange",
    "yellow",
    "green",
    "blue",
    "indigo",
    "violet",
  ];
  let indiceCor = 0;
  let intervalo = null;

  const tututuru = new Audio("../audio/tututuru.mp3");

  const $result = $("#result");

  $("#iniciar").on("click", () => {
    $result.text("ARCO-ÍRIS!");

    if (!intervalo) {
      intervalo = setInterval(() => {
        $result.css("color", cores[indiceCor]);
        indiceCor = (indiceCor + 1) % cores.length;
      }, 300);
    }
  });

  $("#parar").on("click", () => {
    clearInterval(intervalo);
    intervalo = null;
    $result.text("...").css("color", "black");
  });

  $("#max").on("mouseover", () => {
    $("#max").attr("src", "img/max-2.webp");
    $(".max-wrapper").attr("data-label", "Tutututu");
    tututuru.play();
  });

  $("#max").on("mouseout", () => {
    $("#max").attr("src", "img/max-1.webp");
    $(".max-wrapper").attr("data-label", "Max Verstappen");
    tututuru.pause();
    tututuru.currentTime = 0;
  });
});
