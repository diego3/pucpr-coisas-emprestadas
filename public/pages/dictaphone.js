//https://developer.mozilla.org/pt-BR/docs/Web/API/Blob
//https://developer.mozilla.org/en-US/docs/Web/API/MediaRecorder
//https://developer.mozilla.org/en-US/docs/Web/API/MediaDevices/getUserMedia
//https://medium.com/@bryanjenningz/how-to-record-and-play-audio-in-javascript-faa1b2b3e49b

// set up basic variables for app

const record = document.querySelector('.record');
const stop = document.querySelector('.stop');
const soundClips = document.querySelector('.sound-clips');
const canvas = document.querySelector('.visualizer');
const mainSection = document.querySelector('.main-controls');

const AUDIO_MIME_TYPE = 'audio/webm';
const OGG_OPUS_CODEC = 'audio/ogg; codecs=opus';

// disable stop button while not recording

stop.disabled = true;

// visualiser setup - create web audio api context and canvas

let audioCtx;
const canvasCtx = canvas.getContext("2d");


const blobToBase64 = (blob) => {
  return new Promise((resolve) => {
    const reader = new FileReader();
    reader.readAsDataURL(blob)
    reader.onloadend = function () {
      resolve(reader.result);
    };
  });
};

//main block for doing the audio recording

if (navigator.mediaDevices.getUserMedia) {
  console.log('getUserMedia supported.');

  const constraints = { audio: true };
  let chunks = [];

  let onSuccess = function(stream) {
    const mediaRecorder = new MediaRecorder(stream, {
      audioBitsPerSecond : 128000,
      mimeType : AUDIO_MIME_TYPE
   });

    visualize(stream);

    record.onclick = function() {
      mediaRecorder.start();
      console.log(mediaRecorder.state);
      console.log("recorder started");
      record.style.background = "red";

      stop.disabled = false;
      record.disabled = true;
    }

    stop.onclick = function() {
      mediaRecorder.stop();
      console.log(mediaRecorder.state);
      console.log("recorder stopped");
      record.style.background = "";
      record.style.color = "";
      // mediaRecorder.requestData();

      stop.disabled = true;
      record.disabled = false;
    }

    let clipIndex = 1;
    mediaRecorder.onstop = function(e) {
      console.log("data available after MediaRecorder.stop() called.");

      //const clipName = prompt('Enter a name for your sound clip?','My unnamed clip');

      const clipContainer = document.createElement('article');
      const clipLabel = document.createElement('p');
      const audio = document.createElement('audio');
      const deleteButton = document.createElement('button');

      clipContainer.classList.add('clip');
      audio.setAttribute('controls', '');
      deleteButton.textContent = 'Delete';
      deleteButton.className = 'delete';

      //if (clipName === null) {
        clipLabel.textContent = 'clip '+clipIndex;
        clipIndex = clipIndex + 1;
     // } else {
      //  clipLabel.textContent = clipName;
     // }

      clipContainer.appendChild(audio);
      clipContainer.appendChild(clipLabel);
      clipContainer.appendChild(deleteButton);
      soundClips.appendChild(clipContainer);

      audio.controls = true;
      const blob = new Blob(chunks, { 'type' :  "audio/webm"});

      speechToText("I'm not sad", blob, clipLabel);

      chunks = [];
      const audioURL = window.URL.createObjectURL(blob);
      audio.src = audioURL;
      console.log("recorder stopped");

      deleteButton.onclick = function(e) {
        let evtTgt = e.target;
        evtTgt.parentNode.parentNode.removeChild(evtTgt.parentNode);
      }

      clipLabel.onclick = function() {
        const existingName = clipLabel.textContent;
        const newClipName = prompt('Enter a new name for your sound clip?');
        if(newClipName === null) {
          clipLabel.textContent = existingName;
        } else {
          clipLabel.textContent = newClipName;
        }
      }
    }

    mediaRecorder.ondataavailable = function(e) {
      chunks.push(e.data);
    }
  }

  let onError = function(err) {
    console.log('The following error occured: ' + err);
  }

  navigator.mediaDevices.getUserMedia(constraints).then(onSuccess, onError);

} else {
   console.log('getUserMedia not supported on your browser!');
}

window.onload = function() {
  //montaQuestoes();
}

let diagnostic = {
  "studentId":"35693262-1dbe-4a1c-afa6-f704300f8448",
  "answers":[],
  "level":"BASIC"
}

let Resposta = {
  questionId: "",
  answerFreeText: "",
  answerId: "",
  answerAudio: ""
}

function respondePergunta() {
  this.classList.add("selecionada")
  let questionType = this.parentNode.getAttribute("data-type")
  let answer = {
    "answerId": this.id,
    "questionId": this.name
  };

  if (questionType == "AUDIO_LISTENING" || questionType == "MULTIPLE_CHOICE") {
    diagnostic.answers.push(answer)
  }
}

document.getElementById("enviarBtn").addEventListener("click", async function(evt){
  let texts = document.querySelectorAll("textarea");
  for(let i = 0; i < texts.length; i++) {
    let node = texts[i];
    if (node.value) {
      console.log(node.getAttribute("data-questionId"), node.value)
      diagnostic.answers.push({
        "questionId": node.getAttribute("data-questionId"),
        "answerFreeText": node.value
      })
    }
  }
  
  for(let i = 0; i < gravacoes.length; i++) {
    let gravacao = gravacoes[i];
    console.log(gravacao.questionId, gravacao.blob)
    const blob64 = await blobToBase64(gravacao.blob);
    diagnostic.answers.push({
      "questionId": gravacao.questionId,
      "answerAudio": blob64
    })
  }

  console.log(diagnostic.answers);

  postDiagnostico()
})

async function postDiagnostico() {
  const rawResponse = await fetch('http://localhost:8280/english-diagnostic', {
    method: 'POST',
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(diagnostic)
  });
  return rawResponse;
}

let recorders = {};
let gravacoes = [];

function gravarAudioQuestion(evt) {
  const questionId = this.getAttribute("data-questionId");
  let recorderObj = recorders[questionId];
  let recorder = recorderObj.recorder;
  recorder.start();
  console.log("recorder", recorder);
  console.log(recorder.state);
  console.log("recorder "+questionId+" started");
  this.style.background = "red";

  this.parentNode.lastChild.disabled = false;
  this.disabled = true;
}

function pararAudioRecord(evt) {
  const questionId = this.getAttribute("data-questionId")
  let recorderObj = recorders[questionId];
  let recorder = recorderObj.recorder;
  
  let $this = this;
  recorderObj.onStop = function(blob) {
    gravacoes.push({questionId: questionId, blob:blob});

    let playAudio = document.createElement("audio");
    let audioSource = document.createElement("source");
    const audioURL = window.URL.createObjectURL(blob);
    console.log("audioURL", audioURL)
    audioSource.setAttribute("src", audioURL);
    audioSource.setAttribute("type", "audio/webm");
    audioSource.setAttribute("data-questionId", questionId)
    audioSource.classList.add("audio-response");
    playAudio.setAttribute("controls", "");
    playAudio.appendChild(audioSource)
    let audioLi = document.createElement("li")
    audioLi.classList.add("resposta-li")  
    audioLi.appendChild(playAudio)
    $this.parentNode.append(audioLi);
  }

  recorder.stop();
  console.log(recorder.state);
  console.log("recorder "+questionId+" stop")
  this.style.background = "red";

  this.parentNode.lastChild.disabled = false;
  this.disabled = true;

  
}


function montaQuestoes() {
  getQuestions("BASIC", data => {  
    let perguntas = data.payload;
    let container = document.getElementById("perguntas");

    let numeroPergunta = 1;
    for(let i=0; i < perguntas.length; i++) {
        let Pergunta = perguntas[i];
        let div = document.createElement("div");
        let perguntaUl = document.createElement("ul");
        perguntaUl.textContent = "["+numeroPergunta+"] "+Pergunta.text;
        perguntaUl.classList.add("pergunta-ul");
        perguntaUl.setAttribute("data-type", Pergunta.questionType);

        if (Pergunta.questionType == "WRITING") {
          perguntaUl.textContent = "["+numeroPergunta+"] Write this in english: "+Pergunta.text;
          let textArea = document.createElement("textarea")
          textArea.name = 'writing-'+Pergunta.id;
          textArea.maxLength = 5000;
          textArea.cols = 80;
          textArea.rows = 8;
          textArea.className = 'writing-text-area resposta-text';
          textArea.setAttribute("data-questionId", Pergunta.id)
          let textAreaLi = document.createElement("li")
          textAreaLi.classList.add("resposta-li");
          textAreaLi.appendChild(textArea);
          perguntaUl.append(textAreaLi);
        } 
        else if(Pergunta.questionType == "AUDIO_LISTENING") {
            let playAudio = document.createElement("audio");
            let audioSource = document.createElement("source");
            audioSource.setAttribute("src", Pergunta.mediaUrl);
            audioSource.setAttribute("type", "audio/wav");
            playAudio.setAttribute("controls", "");
            playAudio.appendChild(audioSource)
            playAudio.setAttribute("data-questionId", Pergunta.id)
            let audioLi = document.createElement("li")
            audioLi.classList.add("resposta-li")  
            audioLi.appendChild(playAudio)
            perguntaUl.append(audioLi);

            for(let j=0; j < Pergunta.answers.length; j++) {
              let Answer = Pergunta.answers[j];
              let li = document.createElement("li");
              li.classList.add("resposta-li")  
              li.textContent = Answer.text;
              li.id = Answer.id;
              li.name = Pergunta.id;
              li.addEventListener("click", respondePergunta)
              perguntaUl.append(li);
            }
        }
        else if (Pergunta.questionType == "AUDIO_RECORDING") {
            if (Pergunta.answers != null && Pergunta.answers.length > 0) {
              perguntaUl.textContent += " "+Pergunta.answers[0].text;
            }
            
            let recordAudioQuestion = document.createElement("button");
            recordAudioQuestion.setAttribute("data-questionId", Pergunta.id);
            recordAudioQuestion.textContent = "Gravar";
            recordAudioQuestion.addEventListener("click", gravarAudioQuestion)
            let stopAudioRecord = document.createElement("button");
            stopAudioRecord.setAttribute("data-questionId", Pergunta.id);
            stopAudioRecord.textContent = "Parar";
            stopAudioRecord.addEventListener("click", pararAudioRecord)
            
            let recordButtonsContainer = document.createElement("div");
            recordButtonsContainer.classList.add("record-buttons-container")
            recordButtonsContainer.appendChild(recordAudioQuestion)
            recordButtonsContainer.appendChild(stopAudioRecord)
            
            let recordButtonsLi = document.createElement("li")
            recordButtonsLi.classList.add("reposta-li")
            recordButtonsLi.appendChild(recordButtonsContainer)
            perguntaUl.append(recordButtonsLi)

            navigator.mediaDevices.getUserMedia({audio: true}).then(function(stream) {
                let r = new MediaRecorder(stream, {
                  audioBitsPerSecond : 128000,
                  mimeType : 'audio/webm'
               });

               let recorderObj = {
                 "recorder": r,
                 "chunks": [],
                 "blob": null,
                 "listenStream": function(e) {
                   recorderObj.chunks.push(e.data);
                 },
                 stopStream: function(e) {
                    console.log("stop streaming")
                    console.log("chunks", recorderObj.chunks)
                    recorderObj.blob = new Blob(recorderObj.chunks, { 'type' :  'audio/webm'});
                    recorderObj.chunks = [];
                    recorderObj.onStop(recorderObj.blob);
                 },
                 onStop: function(blob) {}
               }
               
               r.ondataavailable = recorderObj.listenStream;
               r.onstop = recorderObj.stopStream

               recorders[Pergunta.id] = recorderObj;
            }, function(evt){
              console.log("erro media recording", evt);
            });
        }
        else {

          for(let j=0; j < Pergunta.answers.length; j++) {
            let Answer = Pergunta.answers[j];
            let li = document.createElement("li");
            li.classList.add("resposta-li")  
            li.textContent = Answer.text;
            li.id = Answer.id;
            li.name = Pergunta.id;
            li.addEventListener("click", respondePergunta)

            perguntaUl.append(li);
          }
        }

        div.append(perguntaUl)
        div.classList.add("pergunta-positioning")

        container.append(div);
        numeroPergunta++;
    }

  });
}


function getQuestions(level, callback) {
  fetch("http://localhost:8280/english-diagnostic/questions?level="+level)
    .then(result => result.json())
    .then(data => {
      callback(data);
    })
}

async function speechToText(question, blob, htmlEl) {
  const b64 = await blobToBase64(blob);
  
  let json = {
    "text": question,
    "voice": b64,
    "audioFormat": AUDIO_MIME_TYPE,
    "provider": "GOOGLE"
  }
  
  const rawResponse = await fetch('http://localhost:8180/ai/language-processing/base64', {
    method: 'POST',
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(json)
  });

  
  // let formData = new FormData();
  // formData.append("text", question);
  // formData.append("audio", blob);
  // const rawResponse = await fetch('http://localhost:8180/ai/language-processing/speech-to-text', {
  //   method: 'POST',
  //   body: formData,
  //   enctype: 'multipart/form-data'
  // });
  
  const content = await rawResponse.json();
  
  htmlEl.textContent = question;

  console.log("resposta", content);
  let speechMatch = "speech-wrong";
  if (question == content.payload.transcript) {
    speechMatch = "speech-right";
  }
  const span = document.createElement("span");
  span.textContent = "  "+content.payload.transcript;
  span.classList.add(speechMatch);
  htmlEl.appendChild(span);
}


// let diagnosticPost = new FormData();
// diagnosticPost.append("studentId", "");

// let respostas = [];
// for(let i =0; i<= 32; i++) {
//   let resp = {
//     "questionId": "poqweiqw9e8qw09r8098203",
//     "answerFreeText": "",
//     "answerId": "",//resposta selecionada
//     "answerAudio": "" 
//   };
// }

// for(let i =0; respostas.length <= 32; i++) {
//   let resp = respostas[i];
//   diagnosticPost.append(resp.questionId);// UUID 
//   diagnosticPost.append("answerFreeText");
//   diagnosticPost.append("answerId"); 
//   diagnosticPost.append("answerAudio"); // MultipartFile
// }

// diagnosticPost.append("answers", answers);//List<DiagnosticQuestionAnsweredDto> 
// diagnosticPost.append("level", "BASIC");



function visualize(stream) {
  if(!audioCtx) {
    audioCtx = new AudioContext();
  }

  const source = audioCtx.createMediaStreamSource(stream);

  const analyser = audioCtx.createAnalyser();
  analyser.fftSize = 2048;
  const bufferLength = analyser.frequencyBinCount;
  const dataArray = new Uint8Array(bufferLength);

  source.connect(analyser);
  //analyser.connect(audioCtx.destination);

  draw()

  function draw() {
    const WIDTH = canvas.width
    const HEIGHT = canvas.height;

    requestAnimationFrame(draw);

    analyser.getByteTimeDomainData(dataArray);

    canvasCtx.fillStyle = 'rgb(200, 200, 200)';
    canvasCtx.fillRect(0, 0, WIDTH, HEIGHT);

    canvasCtx.lineWidth = 2;
    canvasCtx.strokeStyle = 'rgb(0, 0, 0)';

    canvasCtx.beginPath();

    let sliceWidth = WIDTH * 1.0 / bufferLength;
    let x = 0;


    for(let i = 0; i < bufferLength; i++) {

      let v = dataArray[i] / 128.0;
      let y = v * HEIGHT/2;

      if(i === 0) {
        canvasCtx.moveTo(x, y);
      } else {
        canvasCtx.lineTo(x, y);
      }

      x += sliceWidth;
    }

    canvasCtx.lineTo(canvas.width, canvas.height/2);
    canvasCtx.stroke();

  }
}

window.onresize = function() {
  canvas.width = mainSection.offsetWidth;
}

window.onresize();
