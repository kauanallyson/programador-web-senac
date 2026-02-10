const form = document.getElementById("form-imc");
const resultadoP = document.getElementById("resultado");

form.addEventListener("submit", function (e) {
  e.preventDefault();
  calcularIMC();
});

form.addEventListener("input", calcularIMC);

function calcularIMC() {
  const peso = Number(form.peso.value);
  const altura = Number(form.altura.value);

  if (!peso || !altura || peso <= 0 || altura <= 0) {
    resultadoP.innerHTML = "";
    return;
  }

  const imc = peso / (altura * altura);
  const classificacao = getClassificacaoIMC(imc);
  const pesoIdeal = getPesoIdeal(altura);

  let mensagem = `
    <strong>IMC: ${imc.toFixed(2)}</strong><br>
    ${classificacao}<br><br>
    Peso ideal aproximado: <strong>${pesoIdeal.toFixed(1)} kg</strong>
  `;

  resultadoP.innerHTML = mensagem;
}

function getClassificacaoIMC(imc) {
  if (imc >= 40) return "Obesidade Grau III (Extrema)";
  if (imc >= 35) return "Obesidade Grau II (Severa)";
  if (imc >= 30) return "Obesidade Grau I";
  if (imc >= 25) return "Sobrepeso";
  if (imc >= 18.5) return "Peso normal";
  if (imc >= 17) return "Baixo peso";
  if (imc >= 16) return "Baixo peso grave";
  return "Baixo peso muito grave";
}

function getPesoIdeal(altura) {
  const IMC_IDEAL = 22.5;
  return altura * altura * IMC_IDEAL;
}
