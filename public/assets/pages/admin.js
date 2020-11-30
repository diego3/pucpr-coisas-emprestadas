window.onload = function() {
    const menuUsuarios = document.getElementById("menu-usuarios");
    const menuEmprestimos = document.getElementById("menu-emprestimos");
    const menuItens = document.getElementById("menu-itens");
    const tituloListagem = document.getElementById("titulo-listagem");
    const containerCards = document.getElementById("container-cards");
    const containerUsers = document.getElementById("container-users");
    const tableUsersTbody = document.querySelectorAll("#table-users tbody")[0];
    const btnNovo = document.getElementById("btnNovo");
    const modalUser = document.getElementById("modalUser");
    const btnSalvar = document.getElementById("btnSalvar");
    const btnSalvarItem = document.getElementById("btnSalvarItem");
    const modalItem = document.getElementById("modalItem");
    let componenteAtual = "LISTAGEM_USUARIOS";

    menuUsuarios.addEventListener("click", renderListagemUsuarios)
    menuItens.addEventListener("click", renderListagemItens)
    btnNovo.addEventListener("click", abrirFormulario);
    btnSalvar.addEventListener("click", criarUsuario);
    btnSalvarItem.addEventListener("click", criarItem);

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

    function createUserRow(name, email, active, role) {
        let tr = document.createElement("tr");
        tr.classList.add("user");
        let tdName = document.createElement("td");
        let tdEmail = document.createElement("td");
        let tdActive = document.createElement("td");
        let tdRole = document.createElement("td");

        tdName.textContent = name;
        tdEmail.textContent = email;
        tdActive.textContent = active;
        tdRole.textContent = role;

        tr.append(tdName, tdEmail, tdActive, tdRole);
        return tr;
    }

    function renderListagemUsuarios() {
        tituloListagem.textContent = "Lista de usuários";
        containerCards.style.display = "none";
        containerUsers.style.display = "block";
        let nodes = document.querySelectorAll(".user");
        nodes.forEach(node => {
            node.remove();
        });
        componenteAtual = "LISTAGEM_USUARIOS";

        get("/rest/users").then(users => {
            for(let i=0; i< users.length; i++) {
                let user = users[i];
                let userRow = createUserRow(user.name, user.email, user.active === "1" ? "SIM" : "NÃO" , user.role);
                tableUsersTbody.append(userRow)
            }
        });   
    }

    function renderListagemItens() {
        tituloListagem.textContent = "Lista de itens de empréstimos";
        containerCards.style.display = "flex";
        containerUsers.style.display = "none";
        let nodes = document.querySelectorAll(".card");
        nodes.forEach(node => {
            node.remove();
        });
        componenteAtual = "LISTAGEM_ITENS";

        get("/rest/itens").then(items => {
            console.log("items", items);
            for(let i=0; i< items.length; i++) {
                let item = items[i];
                let cardItem = createCard(item.thumb, item.name, "Emprestar", "/emprestar")
                containerCards.append(cardItem)
            }
        });
    }

    function criarUsuario() {
        let payload = {
            name: document.getElementById("userName").value,
            email: document.getElementById("userEmail").value,
            password: document.getElementById("userPassword").value,
            role: document.getElementById("userRole").value
        };
      
        let response = post("/rest/new-user", JSON.stringify(payload));
        let success = document.querySelectorAll(".form-modal .success")[0];
        success.style.display = "inline";
        setTimeout(function(evt) {
            modalUser.style.opacity = 0;        
            success.style.display = "none";
            renderListagemUsuarios();
        }, 2000);
    }

    function criarItem() {
        let payload = {
            name: document.getElementById("itemName").value,
            thumb: document.getElementById("itemThumb").value,
        };
      
        let response = post("/rest/new-item", JSON.stringify(payload));
        let success = document.querySelectorAll(".form-modal .success")[0];
        success.style.display = "inline";
        setTimeout(function(evt) {
            modalItem.style.opacity = 0;        
            success.style.display = "none";
            renderListagemItens();
        }, 2000);
    }

    function abrirFormulario() {
        if (componenteAtual === "LISTAGEM_USUARIOS") {
            modalUser.style.opacity = 1;
        } else if (componenteAtual === "LISTAGEM_ITENS"){
            modalItem.style.opacity = 1;
        }
    }

    // INICIALIZAÇÂO
    renderListagemItens();
    //renderListagemUsuarios();
}