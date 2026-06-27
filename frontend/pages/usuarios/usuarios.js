document.addEventListener("DOMContentLoaded", () => {

const editButtons = document.querySelectorAll(".editButton");

editButtons.forEach(button => {

    button.addEventListener("click", (event) => {

        event.preventDefault();

        const row = button.closest("tr");

        if (row.nextElementSibling?.classList.contains("editRow")) {
            return;
        }

        const id = button.dataset.id;
        const nome = button.dataset.nome;

        const editRow = document.createElement("tr");

        editRow.classList.add("editRow");

        editRow.innerHTML = `
            <td colspan="5">

                <form
                    action="../../../backend/alterarUserSenha.php"
                    method="POST"
                    class="editForm"
                >

                    <input
                        type="hidden"
                        name="id"
                        value="${id}"
                    >

                    <h3>Alterar senha de <strong>${nome}</strong></h3>

                    <input
                        type="password"
                        name="novaSenha"
                        class="editInput"
                        placeholder="Nova senha"
                        required
                    >

                    <input
                        type="password"
                        name="confirmarSenha"
                        class="editInput"
                        placeholder="Confirmar senha"
                        required
                    >

                    <div class="editActions">

                        <button
                            type="button"
                            class="cancelButton"
                        >
                            Cancelar
                        </button>

                        <button
                            type="submit"
                            class="saveButton"
                        >
                            Alterar senha
                        </button>

                    </div>

                </form>

            </td>
        `;

        row.insertAdjacentElement("afterend", editRow);

        editRow.querySelector(".cancelButton").addEventListener("click", () => {
            editRow.remove();
        });

    });

});

    const deleteButtons = document.querySelectorAll(".deleteButton");

    deleteButtons.forEach(button => {

        button.addEventListener("click", (event) => {

            const row = button.closest("tr");
            const nome = row.children[0].textContent.trim();

            if (!confirm(`Deseja realmente desativar o usuário "${nome}"?`)) {

                event.preventDefault();

            }

        });

    });
});