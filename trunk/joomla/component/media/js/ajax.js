/**
 * Called by the apicnxn/default for verification check

 */
function apicnxnCheck()
{
	// Grab the values from the form
	var apiusername	= jQuery( '#blestaapiusername' ).val();
	var apikey		= jQuery( '#blestaapikey' ).val();
	var blestaurl	= jQuery( '#blestaapiurl' ).val();
	
	var apistatusimg	= jQuery( '#apistatusimg' );
	apistatusimg.removeClass( 'ajaxSuccess ajaxError ajaxAlert' ).addClass( 'ajaxLoading' );
	
	var apistatusmsg	= jQuery( '#apistatusmsg' );
	apistatusmsg.html( jQuery( '#apistatusmsgdefault' ).val() );
	
	var apistatushelp	= jQuery( '#apistatushelp' );
	apistatushelp.html( '' ).removeClass( 'alert-block alert-success');
	
	jQuery.ajax({
		type: 'POST',
		url: "index.php?option=com_jblesta&controller=ajax&task=apicnxncheck",
		data: 'blestaapiusername=' + apiusername + '&blestaapikey=' + apikey + '&blestaapiurl=' + blestaurl,
	}).success( function ( msg ) {
		var obj = jQuery.parseJSON( msg );
		
		apistatusmsg.html( obj.message );
		
		if ( obj.result == 'success' ) {
			apistatusimg.removeClass( 'ajaxLoading' ).addClass( 'ajaxSuccess' );
			apistatushelp.html( obj.helpful ).addClass( 'alert-success' );
			jQuery( '#apiconnection' ).val( '1' );
		}
		else {
			apistatusimg.removeClass( 'ajaxLoading' ).addClass('ajaxAlert');
			apistatushelp.html( obj.helpful ).addClass( 'alert-block' );
		}
	});
	return;
}


/**
 * Checks for an update from the site
 * @version		@fileVers@
 * @since		2.4.0
 */
function checkForUpdates()
{
	var apistatuslnk = jQuery( '#jblesta_icon_updates_link' );
	var apistatusimg = jQuery( '#jblesta_icon_updates_img' );
	var apistatusmsg = jQuery( '#jblesta_icon_updates_title' );
	
	jQuery.ajax({
		type: 'POST',
		url: 'index.php?option=com_jblesta',
		data: 'controller=ajax&task=checkforupdates'
	}).success( function ( msg ) {
		var obj = jQuery.parseJSON( msg );
		
		processUpdate( obj );
	});
	
	return;
}


/**
 * Processes response from update check
 * @version		@fileVers@
 * @since		2.4.0
 */
function processUpdate( response ) {
	
	var apistatuslnk = jQuery( '#jblesta_icon_updates_link' );
	var apistatusimg = jQuery( '#jblesta_icon_updates_img' );
	var apistatusmsg = jQuery( '#jblesta_icon_updates_title' );
	
	apistatusmsg.html( response.message );
	
	apistatusimg.attr( 'src', '');
	apistatusimg.attr( 'alt', '' );
	apistatusimg.addClass( 'ajaxicon' );
	
	if ( response.updates == '1' ) {
		apistatusimg.addClass( 'found' );
	}
	else if ( response.updates == '0' ) {
		apistatusimg.addClass( 'current' );
	}
	else if ( response.updates == '-1' ) {
		apistatusimg.addClass( 'unsupported' );
	} else {
		apistatusimg.addClass( 'stall' );
	}
	
	return;
}


/**
 * Initializes an update of the product (step 1)
 * @version		@fileVers@
 * @since		2.5.0
 */
function performUpdate()
{
	var apistatusimg = jQuery( '#jblesta_icon_updates_img' );
	var apistatusmsg = jQuery( '#jblesta_icon_updates_title' );
	var apistatuserr = jQuery( '#jblesta_icon_updates_error' );
	
	apistatusimg.attr( 'src', jQuery( '#rootimgurl' ).val() + 'ajax-img-48.gif' );
	apistatusmsg.html( jQuery( '#inittitle' ).val() );
	
	// Make the Ajax Call
	var resp	= jQuery.ajax({
					type: "POST",
					url: 'index.php?option=com_jblesta',
					dataType: 'json',
					data: 'controller=ajax&task=updateinit'
				});
	
	// Success
	resp.done( function( msg ) {
		
		apistatuserr.append( '<div>' + msg.message + '</div>' );
		apistatuserr.addClass( 'alert' );
		
		downloadUpdate();
	});
	
	// Failure
	resp.fail( function( jqXHR, msg ) {
		apistatusimg.attr( 'src', jQuery( '#rootimgurl' ).val() + 'error-48.png' );
		apistatuserr.addClass( 'alert' );
		apistatuserr.html( msg.error );
	});
}


/**
 * Downloads updates available for the product (step 2)
 * @version		@fileVers@
 * @since		2.5.0
 */
function downloadUpdate()
{
	var apistatusimg = jQuery( '#jblesta_icon_updates_img' );
	var apistatusmsg = jQuery( '#jblesta_icon_updates_title' );
	var apistatuserr = jQuery( '#jblesta_icon_updates_error' );
	
	// Make the Ajax Call
	var resp	= jQuery.ajax({
					type: "POST",
					url: 'index.php?option=com_jblesta',
					dataType: 'json',
					data: 'controller=ajax&task=updatedownload'
				});
	
	// Success
	resp.done( function( msg ) {
		
		apistatuserr.append( '<hr/><div>' + msg.message + '</div>' );
		
		if ( msg.state == 1 ) {
			installUpdate();
		}
		else {
			apistatusimg.attr( 'src', jQuery( '#rootimgurl' ).val() + 'error-48.png' );
			apistatuserr.html( msg.error );
		}
	});
	
	// Failure
	resp.fail( function( jqXHR, msg ) {
		apistatusimg.attr( 'src', jQuery( '#rootimgurl' ).val() + 'error-48.png' );
		apistatuserr.addClass( 'alert' );
		apistatuserr.html( msg.error );
	});
}


/**
 * Downloads updates available for the product (step 2)
 * @version		@fileVers@
 * @since		2.5.0
 */
function installUpdate()
{
	var apistatusimg = jQuery( '#jblesta_icon_updates_img' );
	var apistatusmsg = jQuery( '#jblesta_icon_updates_title' );
	var apistatuserr = jQuery( '#jblesta_icon_updates_error' );
	
	// Make the Ajax Call
	var resp	= jQuery.ajax({
					type: "POST",
					url: 'index.php?option=com_jblesta',
					dataType: 'json',
					data: 'controller=ajax&task=updatecomplete'
				});
	
	// Success
	resp.done( function( msg ) {
		
		apistatuserr.append( '<hr/><div>' + msg.message + '</div>' );
		
		if ( msg.state == 1 ) {
			apistatusimg.attr( 'src', jQuery( '#rootimgurl' ).val() + 'accept-48.png' );
			apistatusmsg.html( jQuery( '#donetitle' ).val() );
		}
		else {
			apistatusimg.attr( 'src', jQuery( '#rootimgurl' ).val() + 'error-48.png' );
			apistatuserr.html( msg.error );
		}
	});
	
	// Failure
	resp.fail( function( jqXHR, msg ) {
		apistatusimg.attr( 'src', jQuery( '#rootimgurl' ).val() + 'error-48.png' );
		apistatuserr.addClass( 'alert' );
		apistatuserr.html( msg.error );
	});
}

/*
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++
 * Not sure if these are used 
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++
 */

function jblesta_submitbutton(task) {
	var form = document.forms['registerForm'];
		
	if (task == 'validate') {
		validateUsername(document.getElementById('username').value);
	}
	else if (task == 'submit') {
		
		form.submitit.disabled = true;
		
		var valid = document.getElementById('validusername').value;

		if (valid == '1') {
			form.submit();
		}
		else {
			form.submitit.disabled = true;
		}
	}
}

function ajaxCheckAPI(step)
{
	var whmcsurl		= $('whmcsurl').value;
	var jblestaadminus	= $('jblestaadminus').value;
	var jblestaadminpw	= $('jblestaadminpw').value;
	var accesskey		= $('accesskey').value;
	whmcsurl			= encodeURIComponent(whmcsurl);
	jblestaadminus		= encodeURIComponent(jblestaadminus);
	jblestaadminpw		= encodeURIComponent(jblestaadminpw);
	accesskey			= encodeURIComponent(accesskey);
	
	var ajaxLog			= $('ajaxLog');
	var ajaxStat		= $('ajaxStatus');
	var ajaxMsgs		= $('ajaxMessage');
	var origStep		= $('step');
	var reqApi			= $('reqApi');
	var textWelcome		= $('textWelcome');
	var textApivalid	= $('textApivalid');
	var reqWhmcsPath	= $('reqWhmcsPath');
	var url = $('thisUrl').getProperty('value')+"?option=com_jblesta&controller=ajax&task=interview&jblestaadminus="+jblestaadminus+"&jblestaadminpw="+jblestaadminpw+"&whmcsurl="+whmcsurl+"&accesskey="+accesskey+"&step="+step;
	
	ajaxStat.removeClass('ajaxWaiting').addClass('ajaxLoading');
	ajaxMsgs.removeClass('ajaxMessageWaiting').addClass('ajaxMessageLoading');
	ajaxMsgs.empty();
	mySetHTML( ajaxMsgs, 'Checking API Username and Password...');
	
	var xhr = createXHR();
	xhr.open("GET",url,true);
	xhr.send(null);
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4) {
			if (xhr.status == 200) {
				var resp = parseXml(xhr.responseText);
				var nextStep = resp.getElementsByTagName("nextstep")[0].childNodes[0].nodeValue;
				var valid	 = resp.getElementsByTagName("valid")[0].childNodes[0].nodeValue;
				var message  = resp.getElementsByTagName("message");
				var txt = ajaxLog.innerHTML;
				
				if (valid == true) {
					var i=0;
					for (i=0; i<message.length; i++) {
						txt = "<span>"+message[i].childNodes[0].nodeValue + "</span>" + txt;
					}
					
					mySetHTML( ajaxLog, txt );
					
					$('step').setProperty('value', nextStep);
					reqApi.setStyle('visibility', 'collapse').setStyle( 'display', 'none' );
					ajaxStat.removeClass('ajaxWaiting').addClass('ajaxLoading');
					ajaxMsgs.removeClass('ajaxMessageWaiting').addClass('ajaxMessageLoading');
					ajaxMsgs.empty();
					mySetHTML( ajaxMsgs, 'Installing' );
					textWelcome.removeClass('visDisplay').addClass('visHidden');
					textApivalid.removeClass('visHidden').addClass('visDisplay');
					
					/* Display path request */
					ajaxStat.removeClass('ajaxLoading').addClass('ajaxWaiting');
					ajaxMsgs.removeClass('ajaxMessageLoading').addClass('ajaxMessageWaiting');
					reqWhmcsPath.setStyle('visibility', 'visible').setStyle( 'display', 'inherit' );;
					textApivalid.removeClass('visDisplay').addClass('visHidden');
					ajaxMsgs.empty();
					mySetHTML( ajaxMsgs, 'Enter Path to WHMCS' );
				}
				else {
					ajaxStat.removeClass('ajaxLoading').addClass('ajaxWaiting');
					ajaxMsgs.removeClass('ajaxMessageLoading').addClass('ajaxMessageWaiting');
					reqApi.setStyle('visibility', 'visible').setStyle( 'display', 'inherit' );
					textWelcome.removeClass('visDisplay').addClass('visHidden');
					ajaxMsgs.empty();
					mySetHTML( ajaxMsgs, message[0].childNodes[0].nodeValue );
				}
			}
			else {
				alert('Error code ' + xhr.status);
			}
		}
	}
}


function ajaxCheckAPIU()
{
	var jblestaadminus = document.getElementById('jblestaadminus').value;
	var jblestaadminpw = document.getElementById('jblestaadminpw').value;
	var accesskey = document.getElementById('accesskey').value;
	var jblestaurl = document.getElementById('jblestaurl').value;
	jblestaurl		= encodeURIComponent( jblestaurl );
	jblestaadminus	= encodeURIComponent( jblestaadminus );
	jblestaadminpw	= encodeURIComponent( jblestaadminpw );
	jblestaadminxs	= encodeURIComponent( accesskey );
	
	var apistatusimg = document.getElementById('apistatusimg');
	var apistatusmsg = document.getElementById('apistatusmsg');
	var apistatusdef = document.getElementById('apistatusmsgdefault').value;
	
	apistatusimg.removeClass('ajaxSuccess').removeClass('ajaxError').addClass('ajaxLoading');
	apistatusmsg.innerHTML=apistatusdef;
	
	var xhr = createXHR();
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4) {
			if (xhr.status == 200) {
				try //Internet Explorer
				{
					xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
					xmlDoc.async="false";
					xmlDoc.loadXML(xhr.responseText);
				}
				catch(e)
				{
					try //Firefox, Mozilla, Opera, etc.
					{
						parser=new DOMParser();
						xmlDoc=parser.parseFromString(xhr.responseText,"text/xml");
					}
					catch(e) {alert(e.message)}
				}
				var result =xmlDoc.getElementsByTagName("param").item(0);
				
				var dsc = result.getElementsByTagName("result")[0].childNodes[0].nodeValue;
				var msg = result.getElementsByTagName("message")[0].childNodes[0].nodeValue;
				
				if (dsc == "success") {
					apistatusimg.removeClass('ajaxLoading').addClass('ajaxSuccess');
					document.getElementById('apiconnection').setAttribute("value", "1");
				}
				else {
					apistatusimg.removeClass('ajaxLoading').addClass('ajaxError');
				}
				apistatusmsg.innerHTML=msg;
			}
			else {
				alert('Error code ' + xhr.status);
			}
		}
	}
	xhr.open("GET","index.php?option=com_jblesta&controller=ajax&task=checkApiu&jblestaadminus="+jblestaadminus+"&jblestaadminpw="+jblestaadminpw+"&accesskey="+accesskey+"&jblestaurl="+jblestaurl,true);
	xhr.send(null);
}


function ajaxCheckLicense(step)

{
	var whmcspath = $('whmcspath').value;
	var license = $('licensekey').value;
	whmcspath = encodeURIComponent(whmcspath);
	license = encodeURIComponent(license);
	
	var ajaxLog  = $('ajaxLog');
	var ajaxStat = $('ajaxStatus');
	var ajaxMsgs = $('ajaxMessage');
	var origStep = $('step');
	var reqLicense = $('reqLicense');
	var textFileinstall = $('textFileinstall');
	var textLicensevalid = $('textLicensevalid');
	var url = $('thisUrl').getProperty('value')+"?option=com_jblesta&controller=ajax&task=interview&whmcspath="+whmcspath+"&license="+license+"&step="+step;
	
	ajaxStat.removeClass('ajaxWaiting').addClass('ajaxLoading');
	ajaxMsgs.removeClass('ajaxMessageWaiting').addClass('ajaxMessageLoading');
	ajaxMsgs.empty();
	mySetHTML( ajaxMsgs, 'Checking License...' );
	
	var xhr = createXHR();
	xhr.open("GET",url,true);
	xhr.send(null);
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4) {
			if (xhr.status == 200) {
				var resp = parseXml(xhr.responseText);
				var nextStep = resp.getElementsByTagName("nextstep")[0].childNodes[0].nodeValue;
				var valid	 = resp.getElementsByTagName("valid")[0].childNodes[0].nodeValue;
					
				if (valid == true) {
					var message  = resp.getElementsByTagName("message");
					var txt = ajaxLog.innerHTML;
					var i=0;
					
					for (i=0; i<message.length; i++) {
						txt = "<span>" + message[i].childNodes[0].nodeValue + "</span>" + txt;
					}
					
					mySetHTML( ajaxLog, txt );
					
					$('step').setProperty('value', nextStep);
					reqLicense.setStyle('visibility', 'collapse').setStyle( 'display', 'none' );
					ajaxStat.removeClass('ajaxWaiting').addClass('ajaxLoading');
					ajaxMsgs.removeClass('ajaxMessageWaiting').addClass('ajaxMessageLoading');
					ajaxMsgs.empty();
					mySetHTML( ajaxMsgs, 'Installing' );
					textFileinstall.removeClass('visDisplay').addClass('visHidden');
					textLicensevalid.removeClass('visHidden').addClass('visDisplay');
					runInstall(nextStep);
				} else {
					ajaxStat.removeClass('ajaxLoading').addClass('ajaxWaiting');
					ajaxMsgs.removeClass('ajaxMessageLoading').addClass('ajaxMessageWaiting');
					reqLicense.setStyle('visibility', 'visible').setStyle( 'display', 'inherit' );
					textFileinstall.removeClass('visDisplay').addClass('visHidden');
					var upgrade = resp.getElementsByTagName( "upgrade" )[0].childNodes[0].nodeValue;
					if ( upgrade == false ) {
						ajaxMsgs.empty();
						mySetHTML( ajaxMsgs, 'License Invalid' );
					} else {
						ajaxMsgs.empty();
						mySetHTML( ajaxMsgs, upgrade );
					}
				}
			} else {
				alert('Error code ' + xhr.status);
			}
		}
	}
}


function ajaxLicenseCheck()
{
	var license = document.getElementById('licensekey').value;
	license = encodeURIComponent(license);
	
	var whmcsstatusimg = document.getElementById('whmcsstatusimg');
	var whmcsstatusmsg = document.getElementById('whmcsstatusmsg');
	var whmcsstatusdef = document.getElementById('whmcsstatusmsgdefault').value;
	
	whmcsstatusimg.removeClass('ajaxSuccess').removeClass('ajaxError').addClass('ajaxLoading');
	whmcsstatusmsg.innerHTML=whmcsstatusdef;
	
	var url = "index.php?option=com_jblesta&controller=ajax&task=checkValidLicense&license="+license;
	
	var xhr = createXHR();
	xhr.open("GET",url,true);
	xhr.send(null);
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4) {
			if (xhr.status == 200) {
				var result = parseXml(xhr.responseText);
				
				var dsc = result.getElementsByTagName("result")[0].childNodes[0].nodeValue;
				var msg = result.getElementsByTagName("message")[0].childNodes[0].nodeValue;
				
				if (dsc == "success") {
					whmcsstatusimg.removeClass('ajaxLoading').addClass('ajaxSuccess');
					document.getElementById('license').setAttribute("value", "1");
				}
				else {
					whmcsstatusimg.removeClass('ajaxLoading').addClass('ajaxError');
					document.getElementById('license').setAttribute("value", "0");
				}
				whmcsstatusmsg.innerHTML=msg;
				
			} else {
				alert('Error code ' + xhr.status);
			}
		}
	}
}


function completeInstall() {
	var textLicensevalid	= $('textLicensevalid');
	var textComplete		= $('textComplete');
	textLicensevalid.removeClass('visDisplay').addClass('visHidden');
	textComplete.removeClass('visHidden').addClass('visDisplay');
	
	var ajaxLog  = $('ajaxLog').innerHTML;
	var installLog	= $('installLog');
	installLog.setProperty('value', ajaxLog);
	
	document.forms['adminForm'].submit();
}


function resetValid() {
	var msg = $('servermsg');
	var val = $('validusername');
	var form = document.forms['registerForm'];
	
	val.setProperty('value', '0');
	msg.removeClass('invalid').removeClass('valid');
	mySetHTML( msg, '' );
	form.submitit.disabled = true;
}


function runInstall(step)

{
	var ver		= MooTools.version;
	
	var ajaxLog = $('ajaxLog');
	var ajaxStat = $('ajaxStatus');
	var ajaxMsgs = $('ajaxMessage');
	var whmcspath = $('whmcspath').value;
	whmcspath = encodeURIComponent(whmcspath);
	var url = $('thisUrl').getProperty('value')+"?option=com_jblesta&controller=ajax&task=interview&whmcspath="+whmcspath+"&step="+step;
	
	ajaxStat.removeClass('ajaxInitial');
	ajaxStat.addClass('ajaxLoading');
	ajaxMsgs.removeClass('ajaxMessageInitial');
	ajaxMsgs.addClass('ajaxMessageLoading');
	
	mySetHTML( ajaxMsgs, 'Installing' );
	
	var xhr = createXHR();
	xhr.open("GET",url,true);
	xhr.send(null);
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4) {
			if (xhr.status == 200) {
				var resp = parseXml(xhr.responseText);
				var nextStep = resp.getElementsByTagName("nextstep")[0].childNodes[0].nodeValue;
				var message  = resp.getElementsByTagName("message");
				var txt = ajaxLog.innerHTML;
				
				var i=0;
				
				for (i=0; i<message.length; i++) {
					txt = "<span>"+message[i].childNodes[0].nodeValue + "</span>" + txt;
				}
				
				mySetHTML( ajaxLog, txt );
				
				$('step').setProperty('value', nextStep);
				if (nextStep == '110' || nextStep == '210') {
					ajaxCheckAPI(nextStep);
				} else if (nextStep == '150' || nextStep == '155' || nextStep == '250' || nextStep == '255') {
					ajaxCheckLicense(nextStep);
				} else if (nextStep == '1000') {
					completeInstall();
				} else {
					runInstall(nextStep);
				}
			} else {
				alert('Error code ' + xhr.status);
			}
		}
	}
}



function URLEncode (clearString) {
	var output = '';
	var x = 0;
	clearString = clearString.toString();
	var regex = /(^[a-zA-Z0-9_.]*)/;
	while (x < clearString.length) {
		var match = regex.exec(clearString.substr(x));
		if (match != null && match.length > 1 && match[1] != '') {
			output += match[1];
			x += match[1].length;
		} else {
			if (clearString[x] == ' ')
				output += '+';
			else {
				var charCode = clearString.charCodeAt(x);
				var hexVal = charCode.toString(16);
				output += '%' + ( hexVal.length < 2 ? '0' : '' ) + hexVal.toUpperCase();
			}
			x++;
		}
	}
	return output;
}


function validateUsername(username)
{
	var msg = document.getElementById('servermsg');
	var val = document.getElementById('validusername');
	var jid = document.getElementById('joomlaid');
	var url = document.getElementById('thisurl' ).value + "?option=com_jblesta&controller=changeusername&task=validateUsername&username="+URLEncode(username)+"&joomlaid="+jid.value;
	var frm = document.forms['registerForm'];
	frm.validate.disabled = true;
	frm.submitit.disabled = true;
	msg.removeClass('invalid').removeClass('valid').addClass('checking');
	mySetHTML( msg, "Checking Username..." );
	
	var xhr = createXHR();
	xhr.open("GET",url,true);
	xhr.send(null);
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4) {
			if (xhr.status == 200) {
				var resp = parseXml(xhr.responseText);
				var result = resp.getElementsByTagName("result")[0].childNodes[0].nodeValue;
				var message  = resp.getElementsByTagName("message")[0].childNodes[0].nodeValue;
				
				mySetHTML( msg, message );
				val.setProperty('value', result);
				
				if (result == 1) {
					msg.removeClass('checking').addClass('valid');
					frm.submitit.disabled = false;
					frm.validate.disabled = false;
				} else {
					msg.removeClass('checking').addClass('invalid');
					frm.validate.disabled = false;
					frm.submitit.disabled = true;
				}
			} else {
				alert('Error code ' + xhr.status);
			}
		}
	}
}


/*
 * This function is used on the front end registration form
 */
function validInfo(type, value)
{
	var msg = $('message');
	var img = $(type+"Result");
	var chk = $(type+"Checkmsg");
	var val = $(type+"Valid");
	var thisurl = $('thisurl');
	var url = thisurl.value + "&task=validInfo&type="+URLEncode(type)+"&value="+URLEncode(value);
	
	msg.removeClass('msginvalid').removeClass('msgvalid').addClass('msgnotice');
	mySetHTML( msg, chk.value );
	img.removeClass('imginvalid').removeClass('imgrequired').removeClass('imgnotice').removeClass('imgvalid').addClass('imgcheck');
	
	var xhr = createXHR();
	xhr.open("GET",url,true);
	xhr.send(null);
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4) {
			if (xhr.status == 200) {
				var resp = parseXml(xhr.responseText);
				var result = resp.getElementsByTagName("result")[0].childNodes[0].nodeValue;
				var message  = resp.getElementsByTagName("message")[0].childNodes[0].nodeValue;
				
				mySetHTML( msg, message );
				
				if (result == 1) {
					msg.removeClass('msgnotice').removeClass('msginvalid').addClass('msgvalid');
					img.removeClass('imgnotice').removeClass('imginvalid').removeClass('imgcheck').addClass('imgvalid');
					val.setProperty('value', "1");
				} else {
					msg.removeClass('msgnotice').addClass('msginvalid');
					img.removeClass('imgcheck').addClass('imginvalid');
					val.setProperty('value', "");
				}
			} else {
				alert('Error code ' + xhr.status);
			}
		}
	}
}


function verifyFtp(step) {

	var hostname	= $('FtpHostname');
	var port		= $('FtpPort');
	var username	= $('FtpUsername');
	var password	= $('FtpPassword');
	
	hostname		= encodeURIComponent(hostname.value);
	port			= encodeURIComponent(port.value);
	username		= encodeURIComponent(username.value);
	password		= encodeURIComponent(password.value);
	
	var variables	= "&hostname="+hostname+"&port="+port+"&username="+username+"&password="+password+"&step="+step;
	var url = "index.php?option=com_jblesta&controller=ajax&task=verifyFtp"+variables;
	
	var ajaxLog			= $('ajaxLog');
	var ajaxStat		= $('ajaxStatus');
	var ajaxMsgs		= $('ajaxMessage');
	var reqFtp			= $('reqFtp');
	var textWelcome		= $('textWelcome');
	var textApivalid	= $('textApivalid');
	
	ajaxStat.removeClass('ajaxWaiting').addClass('ajaxLoading');
	ajaxMsgs.removeClass('ajaxMessageWaiting').addClass('ajaxMessageLoading');
	ajaxMsgs.empty();
	mySetHTML( ajaxMsgs, 'Verifying Credentials - This may take a moment' );
	
	var xhr = createXHR();
	xhr.open("GET",url,true);
	xhr.send(null);
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4) {
			if (xhr.status == 200) {
				var resp = parseXml(xhr.responseText);
				var nextStep = resp.getElementsByTagName("nextstep")[0].childNodes[0].nodeValue;
				var valid	 = resp.getElementsByTagName("status")[0].childNodes[0].nodeValue;
				var message  = resp.getElementsByTagName("message");
				var txt = ajaxLog.innerHTML;
				
				if (valid == 1) {
					var i=0;
					for (i=0; i<message.length; i++) {
						txt = "<span>" + message[i].childNodes[0].nodeValue + "</span>" + txt;
					}
					
					mySetHTML( ajaxLog, txt );
					
					reqFtp.setStyle('visibility', 'collapse').setStyle( 'display', 'none' );
					ajaxStat.removeClass('ajaxWaiting').addClass('ajaxLoading');
					ajaxMsgs.removeClass('ajaxMessageWaiting').addClass('ajaxMessageLoading');
					ajaxMsgs.empty();
					mySetHTML( ajaxMsgs, 'Installing' );
					textWelcome.removeClass('visDisplay').addClass('visHidden');
					textApivalid.removeClass('visHidden').addClass('visDisplay');
					$('step').setProperty('value', nextStep );
					runInstall(nextStep);
				} else {
					ajaxStat.removeClass('ajaxLoading').addClass('ajaxWaiting');
					ajaxMsgs.removeClass('ajaxMessageLoading').addClass('ajaxMessageWaiting');
					ajaxMsgs.empty();
					mySetHTML( ajaxMsgs, message[0].childNodes[0].nodeValue );
				}
			} else {
				alert('Error code ' + xhr.status);
			}
		}
	}
}


function verifyPath(step)

{
	var whmcspath = $('whmcspath').value;
	whmcspath = encodeURIComponent(whmcspath);
	
	var ajaxLog  = $('ajaxLog');
	var ajaxStat = $('ajaxStatus');
	var ajaxMsgs = $('ajaxMessage');
	var origStep = $('step');
	var reqWhmcsPath = $('reqWhmcsPath');
	var textApivalid = $('textApivalid');
	var textFileinstall = $('textFileinstall');
	
	var url = $('thisUrl').getProperty('value')+"?option=com_jblesta&controller=ajax&task=verifyPath&whmcspath="+whmcspath+"&step="+step;
	
	ajaxStat.removeClass('ajaxWaiting').addClass('ajaxLoading');
	ajaxMsgs.removeClass('ajaxMessageWaiting').addClass('ajaxMessageLoading');
	ajaxMsgs.empty();
	mySetHTML( ajaxMsgs, 'Checking Path...' );
	
	var xhr = createXHR();
	xhr.open("GET",url,true);
	xhr.send(null);
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4) {
			if (xhr.status == 200) {
				var resp = parseXml(xhr.responseText);
				var nextStep = resp.getElementsByTagName("nextstep")[0].childNodes[0].nodeValue;
				var valid	 = resp.getElementsByTagName("valid")[0].childNodes[0].nodeValue;
				
				var message  = resp.getElementsByTagName("message");
				var txt = ajaxLog.innerHTML;
				var i=0;
				
				for (i=0; i<message.length; i++) {
					txt = "<span>" + message[i].childNodes[0].nodeValue + "</span>" + txt;
				}
				
				mySetHTML( ajaxLog, txt );
				
				if (valid == true) {
					$('step').setProperty('value', nextStep);
					reqWhmcsPath.setStyle('visibility', 'collapse').setStyle( 'display', 'none' );
					ajaxStat.removeClass('ajaxWaiting').addClass('ajaxLoading');
					ajaxMsgs.removeClass('ajaxMessageWaiting').addClass('ajaxMessageLoading');
					ajaxMsgs.empty();
					mySetHTML( ajaxMsgs, 'Installing' );
					textApivalid.removeClass('visDisplay').addClass('visHidden');
					textFileinstall.removeClass('visHidden').addClass('visDisplay');
					runInstall(nextStep);
				} else {
					ajaxStat.removeClass('ajaxLoading').addClass('ajaxWaiting');
					ajaxMsgs.removeClass('ajaxMessageLoading').addClass('ajaxMessageWaiting');
					reqWhmcsPath.setStyle('visibility', 'visible').setStyle( 'display', 'inherit' );
					textApivalid.removeClass('visDisplay').addClass('visHidden');
					ajaxMsgs.empty();
					mySetHTML( ajaxMsgs, 'Path Error' );
				}
			} else {
				alert('Error code ' + xhr.status);
			}
		}
	}
}

