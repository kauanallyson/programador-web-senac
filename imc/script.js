function calculaImc() {
  const form = document.querySelector("form");
  const formData = new FormData(form);

  const peso = Number(formData.get("peso"));
  const altura = Number(formData.get("altura"));

  if (!peso || !altura) {
    document.querySelector("#resultado").innerHTML = "";
    return;
  }

  const imc = peso / Math.pow(altura, 2);

  document.querySelector("#resultado").innerHTML =
    `IMC = ${imc.toFixed(2)} | ${indiceDeObesidade(imc)}
    <br>
    O seu peso ideal é ${pesoIdeal(altura).toFixed(2)}Kg`;
}

function indiceDeObesidade(imc) {
  if (imc >= 35) {
    return "Obesidade Extrema";
  } else if (imc >= 30) {
    return "Obesidade";
  } else if (imc >= 25) {
    return "Excesso de peso";
  } else if (imc >= 18.5) {
    return "Peso Normal";
  } else {
    return "Baixo Peso";
  }
}

function pesoIdeal(altura) {
  const IMC_IDEAL = 25;
  return Math.pow(altura, 2) * IMC_IDEAL;
}

document.querySelector("form").addEventListener("submit", (e) => {
  e.preventDefault();
  calculaImc();
});

document
  .querySelectorAll('input[type="number"]')
  .forEach((input) => input.addEventListener("input", calculaImc));
