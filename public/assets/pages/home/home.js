

window.onload = function() {
    let emprestarList = document.querySelectorAll(".emprestar");

    const tituloListagem = document.getElementById("titulo-listagem");
    const containerCards = document.getElementById("container-cards");
    const userId = document.getElementById("userId").value;
    const modalLoan = document.getElementById("modalLoan");
    const modalDevolucao = document.getElementById("modalDevolucao");
    const btnEmprestar = document.getElementById("btnEmprestar");
    const btnConfirmarDevolucao = document.getElementById("btnConfirmarDevolucao");
    const btnSalvar = document.getElementById("btnSalvar");
    const btnCancelar = document.getElementById("btnCancelar");
    const btnCancelarDevolucao = document.getElementById("btnCancelarDevolucao");
    const modalTitle = document.getElementById("modalTitle");
    const modalDevolucaoTitle = document.getElementById("modalDevolucaoTitle");
    let idItemSelecionado = 0;

    btnEmprestar.addEventListener("click", criarEmprestimoDoItem);
    btnConfirmarDevolucao.addEventListener("click", criarDevolucaoDoItem);
    btnCancelar.addEventListener("click", function () {modalLoan.style.opacity = 0;})
    btnCancelarDevolucao.addEventListener("click", function () {modalDevolucao.style.opacity = 0;})

    function abreModalEmprestimo(evt) {
        evt.preventDefault();
        evt.stopPropagation();
        modalLoan.style.opacity = 1;
        modalTitle.textContent = evt.target.getAttribute("title");
        idItemSelecionado = evt.target.getAttribute("itemId");
    }

    function abreModalDevolucao(evt) {
        evt.preventDefault();
        evt.stopPropagation();
        modalDevolucao.style.opacity = 1;
        modalDevolucaoTitle.textContent = evt.target.getAttribute("title");
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

    function criarDevolucaoDoItem() {
        let payload = {
            id_item: idItemSelecionado
        };
        post("/rest/devolution", JSON.stringify(payload));
        let success = document.querySelectorAll(".form-modal .success")[0];
        success.style.display = "inline";
        setTimeout(function(evt) {
            modalDevolucao.style.opacity = 0;        
            success.style.display = "none";
            renderListagemItens();
        }, 2000);
    }

    function createCard(thumb, titulo, textoButton, itemId, entregaAtrasada, emprestado, temDataDevolucao) {
        let card = document.createElement("div")
        
        modalTitle.textContent = "Emprestar: ";

        console.log(titulo, emprestado);

        if (emprestado) {
            let destaque = document.createElement("div");
            let textoAtraso = document.createElement("span");
            let classeDestaque = "emprestado";
            let textoDestaque = "Emprestado";
            if (entregaAtrasada) {
                classeDestaque = "entrega-atrasada";
                textoDestaque = "Entrega atrasada";
            }
            destaque.classList.add(classeDestaque);
            textoAtraso.textContent = textoDestaque;
            destaque.append(textoAtraso);
            card.append(destaque);
            textoButton = "Devolver";
            card.addEventListener("click", abreModalDevolucao);
        } else {
            card.addEventListener("click", abreModalEmprestimo);
        }

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

        get("/rest/home/itens").then(items => {
            for(let i=0; i< items.length; i++) {
                let item = items[i];
                let cardItem = createCard(item.thumb, item.name, "Emprestar", item.id, item.entregaAtrasada > 0, item.emprestado > 0, item.devolution)
                containerCards.append(cardItem)
            }
        });
    }

    renderListagemItens();
}

