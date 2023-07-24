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
// var segundos = agora.getSeconds();

// Formate a hora para exibir sempre dois dígitos
if (horas < 10) {
    horas = "0" + horas;
}
if (minutos < 10) {
    minutos = "0" + minutos;
}
// if (segundos < 10) {
//     segundos = "0" + segundos;
// }

// Atualize o conteúdo da span com o horário e a saudação
// document.getElementById("saudacao").textContent = saudacao;
// document.getElementById("horario").textContent = horas + ":" + minutos;




// Anchor
document.addEventListener('DOMContentLoaded', function(event) {
    anchors.add('.anchor');
});


// TOC
anchors.options.visible = 'hover';
anchors.add('.anchor');
generateTableOfContents(anchors.elements);

// External code for generating a simple dynamic Table of Contents
function generateTableOfContents(els) {
	var anchoredElText,
  		anchoredElHref,
			ul = document.createElement('UL');

  document.getElementById('toc').appendChild(ul);

	for (var i = 0; i < els.length; i++) {
  	anchoredElText = els[i].textContent;
		anchoredElHref = els[i].querySelector('.anchorjs-link').getAttribute('href');
  	addNavItem(ul, anchoredElHref, anchoredElText);
  }
}

function addNavItem(ul, href, text) {
  var listItem = document.createElement('LI'),
		  anchorItem = document.createElement('A'),
  	  textNode = document.createTextNode(text);
  
  anchorItem.href = href;
  ul.appendChild(listItem);
  listItem.appendChild(anchorItem);
  anchorItem.appendChild(textNode);
}


