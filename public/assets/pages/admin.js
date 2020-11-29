window.onload = function() {
    const menuUsuarios = document.getElementById("menu-usuarios");
    const menuEmprestimos = document.getElementById("menu-emprestimos");
    const menuItens = document.getElementById("menu-itens");
    const tituloListagem = document.getElementById("titulo-listagem");
    const containerCards = document.getElementById("container-cards");

    menuUsuarios.addEventListener("click", renderListagemUsuarios)
    menuItens.addEventListener("click", renderListagemItens)

    async function post(url, body) {
        let response = await fetch(url, {
            method: 'POST',
            headers: new Headers({
              'Content-Type': 'application/json'
            }),
            body: body
          });
        let json = await response.json();
        return json();
    }

    async function get(url, params) {
        let response = await fetch(url);
        let json = await response.json();
        return json;
    }

    function createCard(thumb, titulo, textoButton, redirectTo, texto) {
        let card = document.createElement("div")
        card.classList.add("card")
        let img = document.createElement("img")
        img.setAttribute("src", thumb)
        img.classList.add("card-img-top")
        card.appendChild(img)

        let cardBody = document.createElement("div")
        cardBody.classList.add("card-body")
        let cardTitle = document.createElement("h5")
        cardTitle.className = "card-title";
        cardTitle.textContent = titulo;
        cardBody.appendChild(cardTitle)
        if (texto) {
            let cardText = document.createElement("p")
            cardText.classList.add("card-text")
            cardText.textContent = texto;
            cardBody.appendChild(cardText)
        }
        let link = document.createElement("a")
        link.setAttribute("href", redirectTo)
        link.textContent = textoButton;
        link.classList.add("card-button");
        cardBody.appendChild(link)

        card.appendChild(cardBody)

        return card;
    }

    function renderListagemUsuarios() {
        tituloListagem.textContent = "Lista de usuários";
        get("/rest/users").then(users => {
            console.log("users", users);
        });   
    }

    function renderListagemItens() {
        tituloListagem.textContent = "Lista de itens de empréstimos";
        get("/rest/item").then(items => {
            console.log("items", items);
            for(let i=0; i< items.length; i++) {
                let item = items[i];
                let cardItem = createCard(item.thumb, item.name, "Emprestar", "/emprestar")
                containerCards.append(cardItem)
            }
        });
    }

    
    // INICIALIZAÇÂO

    renderListagemItens();

}