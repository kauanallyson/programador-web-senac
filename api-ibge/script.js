$(() => {
  const URL = "https://servicodados.ibge.gov.br/api/v1/localidades/estados";

  async function carregarEstados() {
    try {
      const response = await fetch(URL);
      const estados = await response.json();

      estados.sort((a, b) => a.nome.localeCompare(b.nome));

      const select = $("#selectEstados");
      select.empty();
      select.append('<option value="">Selecione um estado</option>');

      estados.forEach((estado) => {
        select.append(
          `<option value="${estado.id}">${estado.nome} (${estado.sigla})</option>`,
        );
      });

      select.on("change", function () {
        const uf = $(this).val();

        if (uf) {
          carregarMunicipios(uf);
        } else {
          $("#selectMunicipios").html(
            '<option value="">Selecione um Município</option>',
          );
        }
      });
    } catch (error) {
      console.error("Erro ao buscar estados:", error);
      $("#selectEstados").html('<option value="">Erro ao carregar</option>');
    }
  }

  async function carregarMunicipios(UF) {
    try {
      const response = await fetch(`${URL}/${UF}/municipios`);
      const municipios = await response.json();

      municipios.sort((a, b) => a.nome.localeCompare(b.nome));

      const select = $("#selectMunicipios");
      select.empty();
      select.append('<option value="">Selecione um Município</option>');

      municipios.forEach((municipio) => {
        select.append(
          `<option value="${municipio.id}">${municipio.nome}</option>`,
        );
      });
    } catch (error) {
      console.error("Erro ao buscar municípios:", error);
      $("#selectMunicipios").html('<option value="">Erro ao carregar</option>');
    }
  }

  carregarEstados();
});
