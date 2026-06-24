document.addEventListener("DOMContentLoaded", () => {

    const editButtons = document.querySelectorAll(".editButton");

    editButtons.forEach(button => {

        button.addEventListener("click", (event) => {
            event.preventDefault();

            const row = button.closest("tr");

            if (row.nextElementSibling?.classList.contains("editRow")) {
                return;
            }

            const nome = row.children[0].textContent.trim();
            const email = row.children[1].textContent.trim();
            const perfil = row.children[2].textContent.trim();

            const ativo = row.children[3].textContent
                .trim()
                .toLowerCase() === "ativo";

            const editRow = document.createElement("tr");

            editRow.classList.add("editRow");

            editRow.innerHTML = `
                <td colspan="5">
                    <div class="editForm">

                        <input
                            type="text"
                            class="editInput"
                            value="${nome}"
                        >

                        <input
                            type="email"
                            class="editInput"
                            value="${email}"
                        >

                        <select class="editSelect">
                            <option ${perfil === "Aluno" ? "selected" : ""}>
                                Aluno
                            </option>

                            <option ${perfil === "Professor" ? "selected" : ""}>
                                Professor
                            </option>

                            <option ${perfil === "Administrador" ? "selected" : ""}>
                                Administrador
                            </option>
                        </select>

                        <div class="statusContainer">
                            <input
                                type="checkbox"
                                class="statusToggle"
                                ${ativo ? "checked" : ""}
                            >

                            <span>Ativo</span>
                        </div>

                        <div class="editActions">
                            <button
                                class="cancelButton"
                                type="button"
                            >
                                Cancelar
                            </button>

                            <button
                                class="saveButton"
                                type="button"
                            >
                                Salvar
                            </button>
                        </div>
                    </div>
                </td>
            `;

            row.insertAdjacentElement(
                "afterend",
                editRow
            );

            editRow
                .querySelector(".cancelButton")
                .addEventListener("click", () => {
                    editRow.remove();
                });

            editRow
                .querySelector(".saveButton")
                .addEventListener("click", () => {
                    const novoNome = editRow.querySelectorAll(".editInput")[0].value;
                    const novoEmail = editRow.querySelectorAll(".editInput")[1].value;
                    const novoPerfil = editRow.querySelector(".editSelect").value;
                    const ativo = editRow.querySelector(".statusToggle").checked;

                    row.children[0].textContent = novoNome;

                    row.children[1].textContent = novoEmail;

                    row.children[2].innerHTML = `<span class="badge perfil">${novoPerfil}</span>`;

                    row.children[3].innerHTML = 
                        ativo
                            ? `<span class="badge ativo">Ativo</span>`
                            : `<span class="badge inativo">Inativo</span>`;

                    editRow.remove();
                });
        });
    });

    const deleteButtons =
    document.querySelectorAll(".deleteButton");

    deleteButtons.forEach(button => {
        button.addEventListener("click", (event) => {
            event.preventDefault();

            const row = button.closest("tr");
            const nome = row.children[0].textContent.trim();
            const confirmar = confirm(`Deseja realmente excluir o usuário "${nome}"?`);

            if (!confirmar) {
                return;
            }

            if (row.nextElementSibling?.classList.contains("editRow")) {
                row.nextElementSibling.remove();
            }

            row.remove();
        });
    });
});