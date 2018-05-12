(function( $ ) {
	'use strict';

	window.onload = function() {
		var quick_copy = document.getElementById('shortcode-copy'),
		code_box = document.getElementById('shortcode-snippet');
				console.log(code_box);
		

		if ( quick_copy ) {
			quick_copy.addEventListener( 'click', function() {
				console.log(code_box.value);
				code_box.select();
				console.log(code_box.select());
				document.execCommand('Copy');
			});
		}
	}

})( jQuery );
