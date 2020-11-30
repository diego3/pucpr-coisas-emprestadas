<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="public/global.css">
    <script src="public/global.js"></script>
    
    <link rel="stylesheet" href="public/assets/pages/user/user.css">

    <title>Editar perfil</title>
</head>
<body>
    <section class="container">
        <h4 class="title">Editar perfil</h4>
        <form action="/user/submit" method="POST">
            <input type="text" name="id" class="" placeholder="" value="<?php echo $_GET["id"]?>">

            <input type="text" name="name" id="name" class="" placeholder="Seu nome" value="" required>
            <input type="email" name="email" id="email" placeholder="Seu email" value="" required>
            <input type="password" name="password" id="password" class="" placeholder="Trocar a senha" value="">

            <button type="submit" class="button">Salvar</button>

            <?php if ($this->error): ?>
            <div class="error">Erro ao tentar atualizar os dados</div>
            <?php endif; ?>
        </form>
        
    </section>

    <script src="/public/assets/pages/user/user.js"></script>
</body>
</html>
