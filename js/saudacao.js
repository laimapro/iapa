// var agora = new Date();
// var horas = agora.getHours();

// var saudacao = "";

// if (horas >= 01 && horas < 12) {
//     saudacao = "Bom dia";
// } else if (horas >= 12 && horas < 18) {
//     saudacao = "Boa tarde";
// } else {
//     saudacao = "Boa noite";
// }

// var minutos = agora.getMinutes();
// // var segundos = agora.getSeconds();

// // Formate a hora para exibir sempre dois dígitos
// if (horas < 10) {
//     horas = "0" + horas;
// }
// if (minutos < 10) {
//     minutos = "0" + minutos;
// }
// // if (segundos < 10) {
// //     segundos = "0" + segundos;
// // }

// // Atualize o conteúdo da span com o horário e a saudação
// document.getElementById("saudacao").textContent = saudacao;
// document.getElementById("horario").textContent = horas + ":" + minutos;

function getGreeting() {
    let now = new Date();
    let hour = now.getHours();
  
    if (hour < 12) {
      return "Bom dia";
    } else if (hour < 18) {
      return "Boa tarde";
    } else {
      return "Boa noite";
    }
  }
  
  function getFullTime() {
    let now = new Date();
    let hour = now.getHours();
    let minute = now.getMinutes();
    // let second = now.getSeconds();
  
    return `${hour}:${minute}`;
    // return `${hour}:${minute}:${second}`;
  }
  
  document.getElementById("saudacao").innerHTML = `${getGreeting()}`;
  document.getElementById("horario").innerHTML = `${getFullTime()}`;
  