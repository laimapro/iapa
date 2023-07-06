var agora = new Date();
var horas = agora.getHours();

var saudacao = "";

if (horas >= 01 && horas < 12) {
    saudacao = "Bom dia";
} else if (horas >= 12 && horas < 18) {
    saudacao = "Boa tarde";
} else {
    saudacao = "Boa noite";
}

var minutos = agora.getMinutes();
var segundos = agora.getSeconds();

// Formate a hora para exibir sempre dois dígitos
if (horas < 10) {
    horas = "0" + horas;
}
if (minutos < 10) {
    minutos = "0" + minutos;
}
if (segundos < 10) {
    segundos = "0" + segundos;
}

// Atualize o conteúdo da span com o horário e a saudação
document.getElementById("saudacao").textContent = saudacao;
document.getElementById("horario").textContent = horas + ":" + minutos + ":" + segundos;
