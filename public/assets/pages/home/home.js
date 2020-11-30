

window.onload = function() {
    let emprestarList = document.querySelectorAll(".emprestar");

    const tituloListagem = document.getElementById("titulo-listagem");
    const containerCards = document.getElementById("container-cards");
    const userId = document.getElementById("userId").value;
    const modalLoan = document.getElementById("modalLoan");
    const btnEmprestar = document.getElementById("btnEmprestar");
    const btnSalvar = document.getElementById("btnSalvar");
    const btnCancelar = document.getElementById("btnCancelar");
    const modalTitle = document.getElementById("modalTitle");
    let idItemSelecionado = 0;

    btnEmprestar.addEventListener("click", criarEmprestimoDoItem);
    btnCancelar.addEventListener("click", function () {modalLoan.style.opacity = 0;})

    function abreModalEmprestimo(evt) {
        evt.preventDefault();
        evt.stopPropagation();
        modalLoan.style.opacity = 1;
        modalTitle.textContent = evt.target.getAttribute("title");
        idItemSelecionado = evt.target.getAttribute("itemId");
    }

    function criarEmprestimoDoItem() {
        let payload = {
            id_user: userId,
            id_item: idItemSelecionado,
            contact: document.getElementById("contact").value
        };
        let devolution = document.getElementById("devolutionDate").value;
        if (devolution) {
            payload["devolution"] = devolution;
        }
      
        let response = post("/rest/new-loan", JSON.stringify(payload));
        let success = document.querySelectorAll(".form-modal .success")[0];
        success.style.display = "inline";
        setTimeout(function(evt) {
            modalLoan.style.opacity = 0;        
            success.style.display = "none";
            renderListagemItens();
        }, 2000);
    }

    function createCard(thumb, titulo, textoButton, itemId, texto) {
        let card = document.createElement("div")
        card.addEventListener("click", abreModalEmprestimo);
        modalTitle.textContent = "Emprestar: ";

        card.classList.add("card")
        card.setAttribute("title", titulo);
        card.setAttribute("itemId", itemId);

        let img = document.createElement("img")
        img.setAttribute("src", thumb)
        img.classList.add("card-img-top")
        img.setAttribute("title", titulo);
        img.setAttribute("itemId", itemId);
        card.appendChild(img)

        let cardBody = document.createElement("div")
        cardBody.setAttribute("title", titulo);
        cardBody.classList.add("card-body")
        let cardTitle = document.createElement("h5")
        cardTitle.className = "card-title";
        cardTitle.textContent = titulo;
        cardTitle.setAttribute("title", titulo);
        cardTitle.setAttribute("itemId", itemId);
        cardBody.appendChild(cardTitle)
        if (texto) {
            let cardText = document.createElement("p")
            cardText.classList.add("card-text")
            cardText.textContent = texto;
            cardBody.appendChild(cardText)
        }
        let link = document.createElement("a")


        link.setAttribute("href", "#")
        link.textContent = textoButton;
        link.classList.add("card-button");
        link.setAttribute("title", titulo);
        link.setAttribute("itemId", itemId);
        cardBody.appendChild(link)

        card.appendChild(cardBody)

        return card;
    }

    function renderListagemItens() {
        tituloListagem.textContent = "Que tal ler um bom livro hoje?";
        containerCards.style.display = "flex";
        let nodes = document.querySelectorAll(".card");
        nodes.forEach(node => {
            node.remove();
        });

        get("/rest/itens").then(items => {
            for(let i=0; i< items.length; i++) {
                let item = items[i];
                let cardItem = createCard(item.thumb, item.name, "Emprestar", item.id)
                containerCards.append(cardItem)
            }
        });
    }

    renderListagemItens();
}

