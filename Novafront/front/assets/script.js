/* ==========================================================
   CARROSSEL DE IMAGENS — troca automática
   ========================================================== */

let slides = document.querySelectorAll(".slide");
let index = 0;

// Troca de imagens a cada 3 segundos
setInterval(() => {
    slides[index].classList.remove("ativo");
    index = (index + 1) % slides.length;
    slides[index].classList.add("ativo");
}, 3000);

/* ==========================================================
   FUNÇÃO DE CONTRATAÇÃO — envia para página de cadastro
   ========================================================== */

function contratar(plano) {
    // Redireciona obrigando a pessoa a se cadastrar
    window.location.href = `cadastro.html?plano=${plano}`;
}
    function toggleMenu() {
        document.getElementById("menuMobile").classList.toggle("ativo");
    }

