document.addEventListener("DOMContentLoaded", () => {

    const abrir = document.getElementById("abrirTrocaSenha");
    const modal = document.getElementById("trocaSenhaModal");
    const cancelar = document.getElementById("cancelarTrocaSenha");

    abrir.addEventListener("click", (e) => {

        e.preventDefault();

        modal.classList.add("active");

    });

    cancelar.addEventListener("click", () => {

        modal.classList.remove("active");

    });

    modal.addEventListener("click", (e) => {

        if (e.target === modal) {

            modal.classList.remove("active");

        }

    });

});