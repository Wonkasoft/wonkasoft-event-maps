(function( $ ) {
	'use strict';

	

})( jQuery );

function copyToClipboard( el ) {

	console.log( el );
	/* Get the text field */
	var copyText = el.previousSibling;
	console.log( copyText );

	var copyMessage = el.nextSibling;
	console.log( copyMessage );
	
	/* Select the text field */
	copyText.select();
	
	/* Copy the text inside the text field */
	document.execCommand("Copy");
	
	copyMessage.setAttribute("style","display: inline;margin-left:10px;");

	setTimeout(function() {
	copyMessage.setAttribute("style","display: none");
	}, 1000);	

}