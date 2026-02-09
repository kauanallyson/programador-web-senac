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
  const existente = document.getElementById("mensagemErro");
  if (existente) existente.remove();

  const div = document.createElement("div");
  div.id = "mensagemErro";
  div.className =
    "alert alert-danger alert-dismissible fade show position-fixed";
  div.style.cssText = "top:20px; right:20px; z-index:9999; min-width:300px;";
  div.innerHTML = `
    <i class="fas fa-exclamation-triangle me-2"></i>${mensagem}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  `;

  document.body.appendChild(div);

  setTimeout(() => {
    div.classList.remove("show");
    div.remove();
  }, 5000);
}

function mostrarConfirmacao(callback) {
  const existente = document.getElementById("modalConfirmacao");
  if (existente) existente.remove();

  const modalHtml = document.createElement("div");
  modalHtml.innerHTML = `
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
              Cancelar
            </button>
            <button type="button" class="btn btn-danger" id="confirmarDelete">
              Limpar Tudo
            </button>
          </div>
        </div>
      </div>
    </div>
  `;

  document.body.appendChild(modalHtml);

  const modalEl = document.getElementById("modalConfirmacao");
  const modal = new bootstrap.Modal(modalEl);
  modal.show();

  document.getElementById("confirmarDelete").addEventListener("click", () => {
    modal.hide();
    callback();
  });
}

function resetarLista() {
  mostrarConfirmacao(() => {
    combustiveis = [];
    listarCombustiveis();
    mostrarErro("Histórico limpo com sucesso!");
  });
}

function listarCombustiveis() {
  const container = document.getElementById("result");

  if (!combustiveis.length) {
    container.innerHTML = `
      <div class="col-12 text-center empty-state">
        <i class="fas fa-chart-line fa-4x mb-3 text-muted"></i>
        <p class="h5">Aguardando dados para comparação...</p>
      </div>
    `;
    return;
  }

  const melhor = combustiveis.reduce((a, b) =>
    b.custoPorKm < a.custoPorKm ? b : a,
  );

  container.innerHTML = combustiveis
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
                  ? `<span class="badge-winner">
                      <i class="fas fa-trophy me-1"></i> Mais Econômico
                    </span>`
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
                <div class="fw-bold">R$ ${comb.precoPorLitro.toFixed(2)} /L</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    `;
    })
    .join("");
}

document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("formCombustiveis");

  form.addEventListener("submit", (e) => {
    e.preventDefault();

    const data = new FormData(form);

    const nome = data.get("nome").trim();
    const km = parseFloat(data.get("kmPercorridos"));
    const litros = parseFloat(data.get("litros"));
    const preco = parseFloat(data.get("preco"));

    if (!nome) return mostrarErro("Nome do combustível é obrigatório.");
    if (!km || km <= 0)
      return mostrarErro("Distância deve ser maior que zero.");
    if (!litros || litros <= 0)
      return mostrarErro("Litros devem ser maiores que zero.");
    if (!preco || preco <= 0)
      return mostrarErro("Preço deve ser maior que zero.");

    combustiveis.push(new Combustivel(nome, km, litros, preco));
    listarCombustiveis();

    form.reset();
    document.getElementById("nome").focus();
  });

  document.getElementById("btnLimpar").addEventListener("click", resetarLista);

  listarCombustiveis();
});
