<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="/public/global.css">
    <script src="/public/global.js"></script>

    <link rel="stylesheet" href="/public/assets/pages/loan/loan.css">

    <title>Empréstimo</title>
</head>
<body>
    <section class="container">
        <h4 class="title">Emprestar este item</h4>
        <form action="/loan/submit" method="POST">
            <input type="text" name="id_item" class="" id="id_item" placeholder="" value="<?php echo $this->id?>">
            <input type="text" name="contact" class="" placeholder="seus dados de contato: telefone, endereço">

            <button type="submit" class="button">Emprestar</button>
            <button type="button" class="button" id="btnVoltar">Voltar</button>
            
            <div class="error" style="display:none;" id="login-error">Erro ao tentar emprestar o item</div>
        </form>
        
    </section>

    <script src="/public/assets/pages/loan/loan.js"></script>
</body>
</html>
