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