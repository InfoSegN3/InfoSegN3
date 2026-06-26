document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("resultadoModal");
    const mensagem = document.getElementById("mensagem");
    const boxSenha = document.getElementById("boxSenha");
    const senhaGerada = document.getElementById("senhaGerada");

    const fecharModal = document.querySelector(".closeModal");
    const fecharButton = document.querySelector(".closeButton");

    const params = new URLSearchParams(window.location.search);

    const status = params.get("status");
    const senha = params.get("senha");

    if (status === "sucesso" && senha) {
        mensagem.textContent = "Usuário cadastrado com sucesso!";
        boxSenha.style.display = "block";
        senhaGerada.textContent = senha;
        modal.classList.add("active");
    }

    if (status === "erro") {
        mensagem.textContent = "Erro ao cadastrar o usuário.";
        boxSenha.style.display = "none";
        modal.classList.add("active");
    }

    fecharModal.addEventListener("click", () => {
        modal.classList.remove("active");
    });

    fecharButton.addEventListener("click", () => {
        modal.classList.remove("active");
    });

    modal.addEventListener("click", (event) => {
        if (event.target === modal) {
            modal.classList.remove("active");
        }
    });
});

function copiarSenha() {
    const senha = document.getElementById("senhaGerada").textContent;

    navigator.clipboard.writeText(senha);

    const botao = document.querySelector(".copyButton");

    botao.textContent = "Copiado!";

    setTimeout(() => {
        botao.textContent = "Copiar senha";
    }, 1500);
}