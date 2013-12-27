/**
 * Function to check for updates via ajax (backend)
 */
function checkForUpdates()
{
	var btn	=	jQuery( '#btn-updates' );
	var img	=	jQuery( '#img-updates' );
	var url	=	jQuery( '#jblestaurl' ).val();
	
	var title		=	jQuery( '#upd-title' );
	var subtitle	=	jQuery( '#upd-subtitle' );
	
	img.removeClass('update-error').addClass('update-check');
	title.html( jQuery( '#btntitle' ).val() );
	subtitle.html( jQuery( '#btnsubtitle' ).val() );
	
	// Make the Ajax Call
	var resp	= jQuery.ajax({
					type: "POST",
					url: url + '/ajax/checkforupdates',
					dataType: 'json',
					data: {}
				});
	
	// Success
	resp.done( function( msg ) {
		img.removeClass( 'update-check' );
		
		title.html( msg.title );
		subtitle.html( msg.subtitle );
		
		switch ( msg.state ) {
		// Updates exist
		case 1:
			img.addClass( 'update-found' );
			btn.attr( 'onclick', 'performUpdate();' );
			break;
		
		// No updates
		case 0:
			img.addClass( 'update-current' );
			break;
			
		// Error
		case -1:
			img.addClass( 'update-error' );
			btn.attr( 'onclick', 'checkForUpdates();' );
			break;
		}
	});
	
	// Failure
	resp.fail( function( jqXHR, msg ) {
		img.addClass( 'update-error' );
		title.html( 'Error Encountered' );
		subtitle.html( msg );
	});
}


function performUpdate()
{
	var btn	=	jqdun( '#btn-updates' );
	var img	=	jqdun( '#img-updates' );
	var url	=	jqdun( '#jblestaurl' ).val();
	
	var title		=	jqdun( '#upd-title' );
	var subtitle	=	jqdun( '#upd-subtitle' );
	
	// Make the Ajax Call
	var resp	= jqdun.ajax({
					type: "POST",
					url: url + '/ajax/updateinit',
					dataType: 'json',
					data: {}
				});
	
	// Success
	resp.done( function( msg ) {
		
		img.removeClass('update-found' ).addClass('update-init');
		title.html( msg.title );
		subtitle.html( msg.subtitle );
		
		downloadUpdate();
	});
	
	// Failure
	resp.fail( function( jqXHR, msg ) {
		title.html( 'Error Encountered' );
		subtitle.html( msg );
		img.removeClass('update-found' ).addClass('update-error');
	});
}


function downloadUpdate()
{
	var btn	=	jqdun( '#btn-updates' );
	var img	=	jqdun( '#img-updates' );
	var url	=	jqdun( '#jblestaurl' ).val();
	
	var title		=	jqdun( '#upd-title' );
	var subtitle	=	jqdun( '#upd-subtitle' );
	
	// Make the Ajax Call
	var resp	= jqdun.ajax({
					type: "POST",
					url: url + '/ajax/updatedownload',
					dataType: 'json',
					data: {}
				});
	
	// Success
	resp.done( function( msg ) {
		
		title.html( msg.title );
		subtitle.html( msg.subtitle );
		
		if ( msg.state == 1 ) {
			installUpdate();
		}
		else {
			img.removeClass('update-init' ).addClass('update-error');
		}
	});
	
	// Failure
	resp.fail( function( jqXHR, msg ) {
		title.html( 'Error Encountered' );
		subtitle.html( msg );
		img.removeClass('update-init' ).addClass('update-error');
	});
}


function installUpdate()
{
	var btn	=	jqdun( '#btn-updates' );
	var img	=	jqdun( '#img-updates' );
	var url	=	jqdun( '#jblestaurl' ).val();
	
	var title		=	jqdun( '#upd-title' );
	var subtitle	=	jqdun( '#upd-subtitle' );
	
	// Make the Ajax Call
	var resp	= jqdun.ajax({
					type: "POST",
					url: url + '/ajax/updateinstall',
					dataType: 'json',
					data: {}
				});
	
	// Success
	resp.done( function( msg ) {
		
		img.removeClass('update-init' ).addClass( 'update-current' );
		title.html( msg.title );
		subtitle.html( msg.subtitle );
		location.reload();
	});
	
	// Failure
	resp.fail( function( jqXHR, msg ) {
		title.html( 'Error Encountered' );
		subtitle.html( msg );
		img.removeClass('update-init' ).addClass('update-error');
	});
	
	
}