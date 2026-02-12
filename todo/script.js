const $tarefaForm = $("#tarefa-form");
const $todosList = $("#todos-group");

function addTodo(todoText) {
  const newTodo = $(
    `<li class="list-group-item d-flex justify-content-between align-items-center">
      <div class="ms-2 me-auto">
        ${todoText}
      </div>
      <i class="fa-solid fa-trash text-danger" style="cursor: pointer;"></i>
    </li>`,
  );
  $todosList.append(newTodo);
}

$tarefaForm.submit((e) => {
  e.preventDefault();
  const $input = $("#tarefa-input");
  const texto = $input.val();

  if (texto.trim()) {
    addTodo(texto);
  }
  $tarefaForm.trigger("reset");
});

// Lógica para deletar (Delegação de evento)
$todosList.on("click", ".fa-trash", function () {
  $(this).closest("li").remove();
});
