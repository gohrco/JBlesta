/*
 * Common method for creating an xhr object for ajax calls
 */
function createXHR() {
	var xhr = null;
		if (window.XMLHttpRequest) {
			xhr = new XMLHttpRequest();
		} else if (window.ActiveXObject) {
			try {
				xhr = new ActiveXObject('Microsoft.XMLHTTP');
			} catch (e) {}
		}
	return xhr;
}


/*
 * Common method for setting html across mootools versions
 */
function mySetHTML( object, value )
{
	var ver = MooTools.version;
	
	if ( ver <= '1.2.1' ) {
		object.setHTML( value );
	}
	else {
		object.set('html', value );
	}
	
	return object;
}


/*
 * Common method for ignoring the return keypress in a field
 */
function onKeypress(e) {
	if (e.keyCode == 13) {
		return false;
	}
}


/*
 * Common method for parsing an xml data source
 */
function parseXml(data) {

	try //Internet Explorer
	{
		xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
		xmlDoc.async="false";
		xmlDoc.loadXML(data);
	}
	catch(e)
	{
		try //Firefox, Mozilla, Opera, etc.
		{
			parser=new DOMParser();
			xmlDoc=parser.parseFromString(data,"text/xml");
		}
		catch(e) {alert(e.message)}
	}
	return xmlDoc.getElementsByTagName("param").item(0);
}