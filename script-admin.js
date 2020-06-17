jQuery( function( $ ) {
	$( '#save-data' ).click( function() {			
		$.ajax( {
		    url: wpApiSettings.root + 'wp/v2/simple_product',
		    method: 'POST',
		    beforeSend: function ( xhr ) {
		        xhr.setRequestHeader( 'X-WP-Nonce', wpApiSettings.nonce );
		    },
		    data:{
		        'title' : $( '#post-title' ).val(),
		        'content' : $( '#post-content' ).val(),
		    }
		} ).done( function ( response ) {
		    console.log( response );

		    // success notif
		    alert( 'A new post have been added' );

		    // empty form
		    $( '#post-title' ).val( '' );
		    $( '#post-content' ).val( '' );
		} );
	} );
} )