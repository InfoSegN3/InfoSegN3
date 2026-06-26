document.addEventListener("DOMContentLoaded", () => {

    const modal = document.getElementById("resultModal");
    const mensagem = document.getElementById("mensagem");
    const titulo = document.getElementById("modalTitulo");

    const boxSenha = document.getElementById("boxSenha");
    const senhaGerada = document.getElementById("senhaGerada");

    const fecharButton = document.getElementById("closeModal");
    const copiarButton = document.querySelector(".copyButton");

    const params = new URLSearchParams(window.location.search);

    const status = params.get("status");
    const senha = params.get("senha");

    if (status === "sucesso" && senha) {

        titulo.textContent = "Usuário cadastrado";

        mensagem.textContent =
            "O usuário foi cadastrado com sucesso.";

        boxSenha.style.display = "flex";

        senhaGerada.textContent = decodeURIComponent(senha);

        modal.classList.add("active");
    }

    if (status === "erro") {

        titulo.textContent = "Erro";

        mensagem.textContent =
            "Erro ao cadastrar usuário.";

        boxSenha.style.display = "none";

        modal.classList.add("active");
    }

    fecharButton.addEventListener("click", () => {
        modal.classList.remove("active");
    });

    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.classList.remove("active");
        }
    });

    copiarButton.addEventListener("click", copiarSenha);

});

function copiarSenha() {

    const senha = document.getElementById("senhaGerada").textContent;

    navigator.clipboard.writeText(senha);

    const botao = document.querySelector(".copyButton");

    botao.textContent = "✓ Copiado!";

    setTimeout(() => {
        botao.textContent = "Copiar senha";
    }, 1500);

}