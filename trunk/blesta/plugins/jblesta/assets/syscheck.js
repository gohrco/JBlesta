/**
 * Function to check for updates via ajax (backend)
 */
$(document).ready( function() {
	$( 'button.fixfile' ).click( function() {
		fixTemplate( $( this ).data( 'filename' ), $( this ).data( 'refid' ) );
	})
});


function fixTemplate( template, refid )
{
	var icon	=	jqdun( '#icon' + refid );
	var span	=	jqdun( '#badge' + refid );
	var help	=	jqdun( '#help' + refid );
	var btn		=	jqdun( '#btn' + refid );
	
	icon.removeClass( 'icon-remove' ).addClass( 'icon-cog' );
	
	// Make the Ajax Call
	var resp	= jqdun.ajax({
					type: "POST",
					url: ajaxurl + '/ajax/fixfile',
					dataType: 'json',
					data: { file: template }
				});
	
	// Success
	resp.done( function( msg ) {
		icon.removeClass( 'icon-cog' );
		
		switch ( msg.state ) {
		// File updated
		case 1:
			icon.addClass( 'icon-ok' );
			span.removeClass( 'badge-important' ).addClass( 'badge-inverse' ).html( msg.span );
			btn.remove();
			help.remove();
			break;
		
		// Some error
		case 0:
			icon.addClass( 'icon-remove' );
			help.html( msg.message );
			break;
		}
	});
	
	// Failure
	resp.fail( function( jqXHR, msg ) {
		alert( msg );
	});
}