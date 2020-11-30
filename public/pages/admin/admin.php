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
                <li id="menu-emprestimos">Empréstimos</li>
                <li id="menu-itens">Itens</li>
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
