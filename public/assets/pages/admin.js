window.onload = function() {
    const menuUsuarios = document.getElementById("menu-usuarios");
    const menuEmprestimos = document.getElementById("menu-emprestimos");
    const menuItens = document.getElementById("menu-itens");
    const tituloListagem = document.getElementById("titulo-listagem");
    const containerCards = document.getElementById("container-cards");
    const containerUsers = document.getElementById("container-users");
    const tableUsersTbody = document.querySelectorAll("#table-users tbody")[0];
    const btnNovo = document.getElementById("btnNovo");

    menuUsuarios.addEventListener("click", renderListagemUsuarios)
    menuItens.addEventListener("click", renderListagemItens)
    btnNovo.addEventListener("click", abreFormulario);

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

        get("/rest/users").then(users => {
            console.log("users", users);
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

        get("/rest/itens").then(items => {
            console.log("items", items);
            for(let i=0; i< items.length; i++) {
                let item = items[i];
                let cardItem = createCard(item.thumb, item.name, "Emprestar", "/emprestar")
                containerCards.append(cardItem)
            }
        });
    }

    function abreFormulario() {
        
    }

    // INICIALIZAÇÂO
//    renderListagemItens();
    renderListagemUsuarios();
}