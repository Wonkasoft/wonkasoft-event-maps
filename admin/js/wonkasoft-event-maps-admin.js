(function( $ ) {
	'use strict';

	

})( jQuery );

function copyToClipboard() {
	/* Get the text field */
	var copyText = document.getElementById("wem-shortcode-input");

	var copyMessage = document.getElementById("copyMessage");
	
	/* Select the text field */
	copyText.select();
	
	/* Copy the text inside the text field */
	document.execCommand("Copy");
	
	copyMessage.setAttribute("style","display: inline;margin-left:10px;");

	setTimeout(function() {
	copyMessage.setAttribute("style","display: none");
	}, 1000);	

}