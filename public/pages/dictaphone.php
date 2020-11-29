<!DOCTYPE html>
<html lang="en-us">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Web dictaphone</title>
    <link href="/public/pages/dictaphone.css" rel="stylesheet" type="text/css">
  </head>
  <body>

    <div class="wrapper">

      <header>
        <h1>Web dictaphone</h1>
      </header>

      <section class="main-controls">
        <canvas class="visualizer" height="60px"></canvas>
        <div id="buttons">
          <button class="record">Record</button>
          <button class="stop">Stop</button>
        </div>
      </section>

      <section>
        <button id="enviarBtn">POST DIAGNOSTICO</button>
      </section>

      <section class="questions" id="perguntas">
        
        
      </section>

      <section class="sound-clips"></section>

    </div>

    <label for="toggle">❔</label>
    <input type="checkbox" id="toggle">
    <aside>
      <h2>Information</h2>

      <p>Web dictaphone is built using <a href="https://developer.mozilla.org/en-US/docs/Web/API/Navigator.getUserMedia">getUserMedia</a> and the <a href="https://developer.mozilla.org/en-US/docs/Web/API/MediaRecorder_API">MediaRecorder API</a>, which provides an easier way to capture Media streams.</p>

      <p>Icon courtesy of <a href="http://findicons.com/search/microphone">Find Icons</a>. Thanks to <a href="http://soledadpenades.com/">Sole</a> for the Oscilloscope code!</p>
    </aside>
    <script src="public/pages/dictaphone.js"></script>

  </body>
</html>
