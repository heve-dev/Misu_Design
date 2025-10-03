const nav = document.getElementById("navbar");
nav.innerHTML = ` <img src="img/KiPedreiro.svg" alt="kipedreiro" class="logo">

        <input type="checkbox" id="menu-toggle" class="menu-toggle">
        <label for="menu-toggle" class="menu-icon">
        <div class="linha-menu-top"></div>
        <div class="linha-menu-center"></div>
        <div class="linha-menu-bottom"></div>
        </label>
        
        <nav class="navbar-desktop">
            <a href="index.html" id="ancora-home">Home</a>
            <a href="sobre.html">Sobre</a>
            <a href="portfolio.html">Portfólio</a>
            <a href="servicos.html">Serviços</a>
            <a href="atuacao.html">Atuação</a>
            <a href="contato.html">Contato</a>
        <ul>
            <a href="https://www.instagram.com/"><img src="img/instagram-svgrepo-com.svg" alt="linkinsta" class="redes cor"></a>
            <a href="https://web.whatsapp.com/"><img src="img/whatsapp-svgrepo-com.svg" alt="linkwhatsapp" class="redes cor"></a>
        </ul>
    </nav>`;