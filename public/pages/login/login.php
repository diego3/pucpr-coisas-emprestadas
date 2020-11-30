<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="public/global.css">
    <link rel="stylesheet" href="public/assets/pages/login/login.css">

    <title>Login</title>
</head>
<body>
    <section class="container">
        <h4 class="title">Login</h4>
        <form action="/login/submit" method="POST">
            <input type="email" name="email" class="email" placeholder="Digite seu e-mail">
            <input type="password" name="password" class="password" placeholder="Digite sua senha">
            <button type="submit" class="button">Entrar</button>
            <?php if ($this->error): ?>
            <div class="error" id="login-error">E-mail ou senha incorretos</div>
            <?php endif; ?>
        </form>
        
    </section>
</body>
</html>
