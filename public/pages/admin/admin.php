<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <script src="public/global.js"></script>
    <link rel="stylesheet" href="public/assets/pages/admin.css">

    <title>Admin :: </title>
</head>
<body>
    <section class="top-bar">
        <h1 class="title">Admin</h1>
    </section>
    <section class="container">
        <section class="left-panel column">
            <ul>
                <li id="menu-usuarios">Usuários</li>
                <li id="menu-itens">Itens</li>
                <li id="menu-emprestimos">Empréstimos</li>
            </ul>
        </section>
        
        <section class="main-panel column">
            <div class="main-painel-header">
                <h2 id="titulo-listagem" class="titulo-listagem"></h2>
                <button id="btnNovo" class="main-painel-btn-novo">Novo</button>
            </div>
            <div id="container-cards" class="container-cards">

            </div>
            <div id="container-users" class="container-users">
                <table id="table-users" class="table">
                    <thead>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Ativo</th>
                        <th>Papel</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Diego</td>
                            <td>diego@gamil.com</td>
                            <td>Sim</td>
                            <td>Admin</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <div class="form-modal" id="modalUser">
            <form action="#">
                <h4 class="title">Novo usuário</h4>
                <input type="text" id="userName"  placeholder="O nome do usuário" required> 
                <input type="email" id="userEmail"  placeholder="O e-mail do usuário" required>
                <input type="text" id="userPassword"  placeholder="A senha do usuário" required>
                <input type="text" id="userRole"  placeholder="O papel do usuário" required>

                <button type="button" class="button" id="btnSalvar">Salvar</button>
                
                <div class="error">Não foi possível salvar</div>
                <div class="success">Criado com sucesso</div>
            </form>
        </div>

        <div class="form-modal" id="modalItem">
            <form action="#">
                <h4 class="title">Novo item</h4>
                <input type="text" id="itemName"  placeholder="O nome do item" required> 
                <input type="text" id="itemThumb"  placeholder="A imagem de capa do item" required>

                <button type="button" class="button" id="btnSalvarItem">Salvar</button>
                
                <div class="error">Não foi possível salvar</div>
                <div class="success">Criado com sucesso</div>
            </form>
        </div>
        <!-- 
        <div class="card">
            <img class="card-img-top" src="" alt="Imagem de capa">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="">Emprestar</a>
            </div>
        </div> 
    
        
        -->

    </section>

    <script src="public/assets/pages/admin.js"></script>
</body>
</html>
