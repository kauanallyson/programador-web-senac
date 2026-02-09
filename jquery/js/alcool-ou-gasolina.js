class Combustivel {
  constructor(nome, km, litros, preco) {
    this.nome = nome.trim();
    this.consumo = km / litros;
    this.precoPorLitro = preco;
    this.custoPorKm = preco / this.consumo;
  }
}

let combustiveis = [];

function resetarLista() {
  if (confirm("Deseja apagar todos os dados inseridos?")) {
    combustiveis = [];
    listarCombustiveis();
  }
}

function listarCombustiveis() {
  const container = $("#result");

  if (!combustiveis.length) {
    container.html(`
            <div class="col-12 text-center empty-state">
              <i class="fas fa-chart-line fa-4x mb-3 text-muted"></i>
              <p class="h5">Aguardando dados para comparação...</p>
            </div>
          `);
    return;
  }

  const melhor = combustiveis.reduce((prev, curr) =>
    curr.custoPorKm < prev.custoPorKm ? curr : prev,
  );

  const html = combustiveis
    .map((comb) => {
      const isMelhor = comb === melhor;
      return `
            <div class="col-12">
              <div class="card shadow-sm ${isMelhor ? "melhor-custo" : ""}">
                <div class="card-body p-4">
                  <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                      <h5 class="fw-bold mb-1">${comb.nome}</h5>
                      <span class="text-muted small"><i class="fas fa-gas-pump me-1"></i>Eficiência: ${comb.consumo.toFixed(2)} km/L</span>
                    </div>
                    ${isMelhor ? '<span class="badge-winner"><i class="fas fa-trophy me-1"></i> Mais Econômico</span>' : ""}
                  </div>
                  
                  <div class="row align-items-center">
                    <div class="col-sm-7">
                       <p class="mb-0 text-muted small">Custo por Km</p>
                       <div class="price-tag">R$ ${comb.custoPorKm.toFixed(3)}</div>
                    </div>
                    <div class="col-sm-5 text-sm-end mt-3 mt-sm-0">
                       <div class="text-secondary small">Preço pago:</div>
                       <div class="fw-bold text-dark">R$ ${comb.precoPorLitro.toFixed(2)} /L</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          `;
    })
    .join("");

  container.html(html);
}

$(() => {
  $("#formCombustiveis").on("submit", function (e) {
    e.preventDefault();

    const novo = new Combustivel(
      $("#nome").val(),
      Number($("#kmPercorridos").val()),
      Number($("#litros").val()),
      Number($("#preco").val()),
    );

    combustiveis.push(novo);
    listarCombustiveis();
    this.reset();
    $("#nome").focus();
  });

  listarCombustiveis();
});
