let combustiveis = [];

class Combustivel {
  constructor(nome, km, litros, preco) {
    this.nome = nome.trim();
    this.km = parseFloat(km);
    this.litros = parseFloat(litros);
    this.precoPorLitro = parseFloat(preco);
    this.consumo = this.km / this.litros;
    this.custoPorKm = this.precoPorLitro / this.consumo;
  }
}

function mostrarErro(mensagem) {
  $("#mensagemErro").remove();

  const erroHtml = `
    <div id="mensagemErro" class="alert alert-danger alert-dismissible fade show position-fixed" 
         style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
      <i class="fas fa-exclamation-triangle me-2"></i>${mensagem}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  `;

  $("body").append(erroHtml);
  setTimeout(() => $("#mensagemErro").fadeOut(), 5000);
}

function mostrarConfirmacao(callback) {
  $("#modalConfirmacao").remove();

  const modalHtml = `
    <div class="modal fade" id="modalConfirmacao" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
          <div class="modal-header bg-danger text-white">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <h5 class="modal-title">Confirmar Ação</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-center py-4">
            <i class="fas fa-trash-can fa-3x text-danger mb-3 opacity-75"></i>
            <p class="mb-0 fs-5">Deseja apagar <strong>todos os dados inseridos</strong>?</p>
            <p class="text-muted small mt-2">Esta ação não pode ser desfeita.</p>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
              <i class="fas fa-times me-1"></i>Cancelar
            </button>
            <button type="button" class="btn btn-danger" id="confirmarDelete">
              <i class="fas fa-trash-alt me-1"></i>Limpar Tudo
            </button>
          </div>
        </div>
      </div>
    </div>
  `;

  $("body").append(modalHtml);

  const modal = new bootstrap.Modal(
    document.getElementById("modalConfirmacao"),
  );
  modal.show();

  $(document)
    .off("click", "#confirmarDelete")
    .on("click", "#confirmarDelete", function () {
      modal.hide();
      callback();
    });
}

function resetarLista() {
  mostrarConfirmacao(function () {
    combustiveis = [];
    listarCombustiveis();
    mostrarErro("Histórico limpo com sucesso!");
  });
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
                <span class="text-muted small">
                  <i class="fas fa-gas-pump me-1"></i>
                  Eficiência: ${comb.consumo.toFixed(2)} km/L
                </span>
              </div>
              ${
                isMelhor
                  ? '<span class="badge-winner"><i class="fas fa-trophy me-1"></i> Mais Econômico</span>'
                  : ""
              }
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

    const nome = $("#nome").val().trim();
    const km = parseFloat($("#kmPercorridos").val());
    const litros = parseFloat($("#litros").val());
    const preco = parseFloat($("#preco").val());

    if (!nome) {
      mostrarErro("Nome do combustível é obrigatório.");
      $("#nome").focus();
      return;
    }

    if (isNaN(km) || km <= 0) {
      mostrarErro("Distância deve ser maior que zero.");
      $("#kmPercorridos").focus();
      return;
    }

    if (isNaN(litros) || litros <= 0) {
      mostrarErro("Litros devem ser maiores que zero.");
      $("#litros").focus();
      return;
    }

    if (isNaN(preco) || preco <= 0) {
      mostrarErro("Preço deve ser maior que zero.");
      $("#preco").focus();
      return;
    }

    const novo = new Combustivel(nome, km, litros, preco);
    combustiveis.push(novo);
    listarCombustiveis();

    $("#formCombustiveis")[0].reset();
    $("#nome").focus();
  });

  $("#btnLimpar").on("click", resetarLista);
  listarCombustiveis();
});
