(function( $ ) {
	'use strict';
	
	function copyToClipboard( el ) {

		/* Get the text field */
		var copyText = el.previousElementSibling;

		var copyMessage = el.nextElementSibling;
		
		/* Select the text field */
		copyText.select();
		
		/* Copy the text inside the text field */
		document.execCommand("Copy");
		
		copyMessage.setAttribute("style","display: inline;margin-left:10px;");

		setTimeout(function() {
		copyMessage.setAttribute("style","display: none");
		}, 1000);	

	}

	window.onload = function() 
	{
		if ( document.querySelector( '.copy-btn' ) ) 
		{
			var copy_btns = document.querySelectorAll( '.copy-btn' );

			copy_btns.forEach( function( btn, i ) 
				{
					btn.addEventListener( 'click', function ( e ) 
						{
							var target = e.target;
							if ( target.nodeName === 'I' ) 
							{
								target = target.parentElement;
							}
							copyToClipboard( target );
						});
				});
		}

		if ( document.querySelector( '.toggle-password' ) ) 
		{
			var toggle_btn = document.querySelector( '.toggle-password' ).parentElement;
			toggle_btn.addEventListener( 'click', function ( e ) 
				{
					var target = e.target;
					if ( target.nodeName === 'DIV') 
					{
						target = target.firstElementChild;
					}

					if ( target.classList.contains( 'fa-eye' ) ) 
					{
						document.querySelector( 'input[name="wem_google_api"]').type = 'text';
						target.classList.remove( 'fa-eye' );
						target.classList.add( 'fa-eye-slash' );
					}
					else
					{
						if ( target.classList.contains( 'fa-eye-slash' ) ) 
						{
							document.querySelector( 'input[name="wem_google_api"]').type = 'password';
							target.classList.remove( 'fa-eye-slash' );
							target.classList.add( 'fa-eye' );
						}
					}
				});
		}
	};

})( jQuery );
