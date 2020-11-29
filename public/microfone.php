<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="public/estilos.css">

    <title>Login</title>
</head>
<style>
    .container {
        max-width: 400px;
        border: solid 1px red;
        display: flex;
        margin: 0 auto;
    }
</style>
<body>
    <div class="container">
        <h1>Testando o microfone</h1>
    </div>

    <div class="container">
        <button id="record">Gravar</button>
    </div>
</body>
<script>
    window.onload = function() {
        console.log("pagina carregada")
        let gravarBtn = document.getElementById("record");

        let audio = navigator.mediaDevices.getUserMedia({ audio: true });
        console.log(audio)

        gravarBtn.addEventListener("click", function(evt) {
            console.log("abrindo o microfone para gravar")
        });
    }
</script>
</html>
