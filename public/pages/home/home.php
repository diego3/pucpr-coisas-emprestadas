<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <script src="public/global.js"></script>
    <link rel="stylesheet" href="/public/assets/pages/home/home.css">

    <title>Lojinha dos empréstimos</title>
</head>
<body>
    <section class="top-bar">
        <h1 class="title">Lojinha dos empréstimos</h1>
    </section>
    <section class="container">
        <input type="hidden" value="<?php echo $this->userId; ?>" id="userId">
        
        <section class="main-panel column">
            <div class="main-painel-header">
                <h2 id="titulo-listagem" class="titulo-listagem"></h2>
            </div>
            <div id="container-cards" class="container-cards">

            </div>
            
        </section>

        

        <div class="form-modal" id="modalLoan">
            <form action="#">
                <h4 class="title" id="modalTitle">Emprestar este item</h4>
                <label for="devolutionDate">Data de devolução</label>
                <input type="date" id="devolutionDate"  placeholder="Data que vou devolver" required>
                <label for="contact">Contato</label> 
                <input type="text" id="contact"  placeholder="Dados de contato (telefone, endereço) ..." required>

                <button type="button" class="button" id="btnEmprestar">Confirmar e emprestar</button>
                <button type="button" class="button cancelar" id="btnCancelar">Cancelar</button>

                <div class="error">Não foi possível gerar o empréstimo do item</div>
                <div class="success">Empréstimo realizado com sucesso</div>
            </form>
        </div>
        
    </section>

    <script src="/public/assets/pages/home/home.js"></script>
</body>
</html>
