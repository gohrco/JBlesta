<?php
/**
 * -------------------------------------------
 * @packageName@
 * -------------------------------------------
 * @package         @packageName@
 * @version         @fileVers@
 *
 * @author          @packageAuth@
 * @link            @packageLink@
 * @copyright       @packageCopy@
 * @license         @packageLice@
 */


/* ========================================================================= *\
 * GENERAL TRANSLATION STRINGS
\* ========================================================================= */

// -------------------------------------------------------------------------
// Alert Titles
// v1.0.0
$lang['alert.success']				=	'Success!';
$lang['alert.error']				=	'An Error Occurred!';
$lang['alert.info']					=	'Reminder:';
$lang['alert.block']				=	'Warning!';
$lang['alert.dunamis.compatible']	=	'The version of Dunamis you are using is not compatible with this version of J!Blesta.  Please upgrade Dunamis before proceeding.';


// -------------------------------------------------------------------------
// Alert Messages
// v1.0.0
$lang['alert.license.invalid']		=	'Your license is invalid!  Please check your license key before continuing.';
$lang['alert.license.saved']		=	'License successfully saved.';
$lang['alert.settings.saved']		=	'Settings have been saved!';
//$lang['alert.settings.autoautkeynotwritable']	=	'J!Blesta was unable to write the autoauthkey to your configuration file!  You will need to manually update your WHMCS configuration file to include the value for the AutoAuth key.  For more information, please visit our forum.';


// -------------------------------------------------------------------------
// Error Messages
// v1.0.0
$lang['error.apicnxn.nourl']		=	'You must set the URL to Joomla!';
$lang['error.apicnxn.notoken']		=	'You must set the API Token to connect to Joomla!';

// -------------------------------------------------------------------------
// Form Buttons
// v1.0.0
$lang['form.submit']				= 'Submit';
$lang['form.close']					= 'Close';
$lang['form.cancel']				= 'Cancel';
$lang['form.edit']					= 'Edit';
$lang['form.delete']				= 'Delete';
$lang['form.toggleyn.enabled']		= 'Enabled';
$lang['form.toggleyn.disabled']		= 'Disabled';
$lang['form.toggleyn.on']			= 'On';
$lang['form.toggleyn.off']			= 'Off';
$lang['form.button.addnew']			= 'Add New';


/* ========================================================================= *\
 * BACKEND TRANSLATION STRINGS - GENERAL
\* ========================================================================= */

// -------------------------------------------------------------------------
// Configuration Strings
// v1.0.0
$lang['addon.title']		= 'J!Blesta';
$lang['addon.author']		= '<div style="text-align: center; width: 100%; ">Go Higher<br/>Information Services, LLC</div>';
$lang['addon.description']	= '<div>...the premiere Joomla integration solution for Blesta!</div>';


/* ========================================================================= *\
 * BACKEND TRANSLATION STRINGS - ADDON AREA
\* ========================================================================= */

// -------------------------------------------------------------------------
// Default Area
// v1.0.0
$lang['admin.default.body']		=	'<p>Welcome to J!Blesta!</p>'
								.	'<h2>Installation</h2>'
								.	'<p>If this is the first time you have installed J!Blesta, be sure you have completely followed the instructions found at<br /><strong><a href="https://support.gohigheris.com/docs/display/JBL/New+Installations" target="_blank">https://support.gohigheris.com/docs/display/JBL/New+Installations</a></strong>.</p>'
								.	'<p>The next steps to folow at this point are <ul>'
								.	'<li><i class="icon-hang icon-ok"></i> <a href="https://support.gohigheris.com/docs/display/JBL/Create+An+API+User+in+Blesta" target="_blank">Create An API User in Blesta</a></li>'
								.	'<li><i class="icon-hang icon-ok"></i> <a href="https://support.gohigheris.com/docs/display/JBL/Add+or+Change+Your+License" target="_blank">Add or Change Your License</a></li>'
								.	'<li><i class="icon-hang icon-ok"></i> <a href="https://support.gohigheris.com/docs/display/J25/API+Connection+Manager+in+Joomla" target="_blank">API Connection Manager in Joomla</a></li>'
								.	'</ul>'
								.	'<h2>How To Guides</h2>'
								.	'<p>Some additional help in configuring J!Blesta to work with Blesta and Joomla is available in our documentation: <ul>'
								.	'<li><i class="icon-hang icon-ok"></i> <a href="https://support.gohigheris.com/docs/display/JBL/Add+or+Change+Your+License" target="_blank">Add or Change Your License</a></li>'
								.	'<li><i class="icon-hang icon-ok"></i> <a href="https://support.gohigheris.com/docs/display/JBL/Create+An+API+User+in+Blesta" target="_blank">Create An API User in Blesta</a></li>'
								.	'</ul>'
								.	'';


// -------------------------------------------------------------------------
// Addon Titles
// v1.0.0
$lang['admin.title']						=	'J!Blesta <small>%s</small>';
$lang['admin.subtitle.default.default']		=	'Dashboard';
$lang['admin.subtitle.license.default']		=	'Licensing';
$lang['admin.subtitle.license.save']		=	'Licensing :: Save License';
$lang['admin.subtitle.settings.default']	=	'Settings';
$lang['admin.subtitle.settings.save']		=	'Settings :: Save Settings';
$lang['admin.subtitle.updates.default']		=	'Update Manager';
$lang['admin.subtitle.syscheck.default']	=	'System Check';


// -------------------------------------------------------------------------
// Navigation Strings
// v1.0.0
$lang['admin.navbar.home']		=	'Dashboard';
$lang['admin.navbar.syscheck']	=	'System Check';
$lang['admin.navbar.settings']	=	'Settings';
$lang['admin.navbar.license']	=	'License';
$lang['admin.navbar.updates']	=	'Updates';


// -------------------------------------------------------------------------
// Widget Strings - API Cnxn
// v1.0.0
$lang['admin.widget.apicnxn.header']		=	'API Connection Status';
$lang['admin.widget.apicnxn.body.error']	=	'<p>An error was encountered attempting to connect to Joomla!  The error returned was:</p><p>%s</p>';
$lang['admin.widget.apicnxn.body.success']	=	'The API interface tested successfully!';

// Widget Strings - Updates
$lang['admin.widget.updates.header']		= 'Software Updates';
$lang['admin.widget.updates.body.none']		=	'<p>You are running the latest version of J!WHMCS Integrator!</p>';
$lang['admin.widget.updates.body.error']	=	'<p>An error occurred checking for the latest updates:</p><pre>%s</pre>';
$lang['admin.widget.updates.body.exist']	=	'<p><strong>J!WHMCS Integrator version %s</strong> is available for download.  Please visit our web site at https://www.gohigheris.com to download the latest product.</p>';

// Widget Strings - License
$lang['admin.widget.license.header']		= 'License Status';
$lang['admin.widget.license.body.success']	=	'<p>Your license is valid and current!</p>';
$lang['admin.widget.license.body.alert']	=	'<p>Your Support and Upgrade Pack expired on %s!  Please renew your Support and Upgrade Pack to ensure you have the latest updates available to you.</p>';
$lang['admin.widget.license.body.danger']	=	'<p>There is a problem with your license!</p><p>Please double check that your license key as entered is valid.  You will be unable to save or modify settings until the license is updated.</p>';

// Widget Strings - File Check
$lang['admin.widget.filecheck.header']		= 'Template File Status';
$lang['admin.widget.filecheck.body.success']	=	'<p>Files are current!</p>';
$lang['admin.widget.filecheck.body.alert']		=	'<p>One or more of your template files is out of date - please correct this by going to the System Check screen</p>';

// Widget Strings - Like Us
$lang['admin.widget.likeus.header']			=	'';
$lang['admin.widget.likeus.body']				=	'<p>If you find J!WHMCS Integrator useful please tell others about it by visiting the <a href="http://www.whmcs.com/appstore/145/JWHMCS-Integrator.html" target="_blank">WHMCS App Store</a> and <a href="http://www.whmcs.com/members/communityaddons.php?action=viewmod&id=145&vote=true&token=f67e6d896ec5c21bd0248570ac3671ebe6480106" target="_blank">liking</a> the product!</p>';

// -------------------------------------------------------------------------
// Licensing Strings
// v1.0.0
$lang['admin.form.config.label.license']		= 'License';
$lang['admin.form.config.label.info']			= 'Licensed To';
$lang['admin.form.config.label.status']			= 'Status';

$lang['admin.form.config.description.license']	= 'Enter the license you received upon purchasing J!Blesta from <a href="https://www.gohigheris.com/" target="_blank">Go Higher Information Services</a>.';
$lang['admin.form.config.description.status']	= 'This is the status of your Support and Upgrade pack.';

$lang['admin.form.config.info.registeredname']	= '<h4>%s</h4>';
$lang['admin.form.config.info.companyname']		= '<h6>%s</h6>';
$lang['admin.form.config.info.regdate']			= '<div><em>Registered on</em> <strong>%s</strong></div>';
$lang['admin.form.config.info.supnextdue']		= '<div class="alert alert-%s" style="margin-top: 12px; "><em>Support and Upgrade next due on</em> <strong>%s</strong></div>';
$lang['admin.form.config.info.invalidkey']		= '<div class="alert alert-error">The license you entered above is invalid.  Please double check the license and try again.</div>';
$lang['admin.form.config.info.invalidmsg']		= '<div class="alert alert-error">The license above came back with an error message: %s</div>';


// -------------------------------------------------------------------------
// Settings Strings
// v1.0.0
$lang['admin.settings.subnav.general']	=	'<i class="icon-off"> </i> <strong>General Settings</strong>';
$lang['admin.settings.subnav.user']		=	'<i class="icon-user"> </i> <strong>User Integration</strong>';
$lang['admin.settings.subnav.visual']	=	'<i class="icon-eye-open"> </i> <strong>Visual Integration</strong>';
$lang['admin.settings.subnav.login']	=	'<i class="icon-retweet"> </i> <strong>Log In Settings</strong>';
$lang['admin.settings.subnav.language']	=	'<i class="icon-globe"> </i> <strong>Language Map</strong>';
$lang['admin.settings.subnav.advanced']	=	'<i class="icon-wrench"> </i> <strong>Advanced Settings</strong>';

$lang['admin.form.settings.label.enable']			=	'Enabled';
$lang['admin.form.settings.label.debug']			=	'Debug';
$lang['admin.form.settings.label.joomlaurl']		=	'Joomla URL';
$lang['admin.form.settings.label.logintoken']		=	'Login Token';

$lang['admin.form.settings.description.enable']		=	'This is the global enable configuration setting.  Turning the product off here turns off both user and visual integration regardless of their settings.';
$lang['admin.form.settings.description.debug']		=	'Use this setting to enable or disable debugging for the module.';
$lang['admin.form.settings.description.joomlaurl']	=	'Enter the URL to the frontend of your Joomla web site.  Do not include language routes such as /en/ or /fr/.';
$lang['admin.form.settings.description.logintoken']	=	'<p>The Login Token is used by J!Blesta to communicate between Blesta and Joomla.  You will need to also enter the value you have here in your J!Blesta settings in Joomla! to ensure they match or your API interface will not function between Blesta and Joomla.</p>';

// User Integration
$lang['admin.form.settings.label.userenable']			=	'Enable User Integration';
$lang['admin.form.settings.label.useraddmethod']		=	'Add Missing Users To';
$lang['admin.form.settings.label.regmethod']			=	'Registration Method';
$lang['admin.form.settings.label.namestyle']			=	'Name Style';
$lang['admin.form.settings.label.usernamestyle']		=	'Username Style';
$lang['admin.form.settings.label.usernamefield']		=	'Use Custom Field';

$lang['admin.form.settings.description.userenable']		=	'This setting will enable or disable user integration from the Blesta side of the product.';
$lang['admin.form.settings.description.useraddmethod']	=	'This setting controls the behavior of J!Blesta when dealing with users that don\'t have a matching account already in both systems when logging in and editing accounts.  When editing an account in Joomla and adding a matching account in Blesta, the user will still need to log in with their Joomla username for the first time in order to synchronize the passwords properly.';
$lang['admin.form.settings.description.regmethod']		=	'Select the method of registration you want to use on your site.  You may select to use the native Joomla! registration form or the Blesta registration form';
$lang['admin.form.settings.description.namestyle']		=	'When a user registration is done in Blesta, either by the admin or on the front end registration form or order form, this setting tells J!Blesta what style to use for creating a users\' name on their Joomla account.  Joomla only uses a name field, not a full first name and last name field, so the name field must be assembled from data from Blesta.  This setting indicates to J!Blesta which method to use for assembling this data.';
$lang['admin.form.settings.description.usernamestyle']	=	'When a user registration is done in Blesta, either by the admin or on the front end registration form or order form, this setting tells J!Blesta what style to use for creating a username in Joomla.  This only applies if you have your User Integration enabled, and is only done when a user is registered through your Blesta application and if the user being created is using their email to log in with on Blesta rather than creating their own username.';
$lang['admin.form.settings.description.usernamefield']	=	'You You can choose to use a custom client field as the username when a user is created on the WHMCS portion of the integration.  Type the exact name of the client field you are using below.  Be sure to set it as required in the custom client field settings or user creation may fail.';

$lang['userstyle.label']			=	'Username Creation';
$lang['userstyle.optn.create']		=	'Create';
$lang['userstyle.optn.field']		=	'Use Field';

$lang['useraddmethod.0.none']		=	'Neither System';
$lang['useraddmethod.1.jonly']		=	'Joomla! only but not Blesta';
$lang['useraddmethod.2.wonly']		=	'Blesta only but not Joomla!';
$lang['useraddmethod.4.both']		=	'Both Joomla! and Blesta';

$lang['usernamestyle.1.firstlast']	=	'firstname.lastname';
$lang['usernamestyle.2.lastfirst']	=	'lastname.firstname';
$lang['usernamestyle.3.random']		=	'random';
$lang['usernamestyle.4.flast']		=	'f.lastname';
$lang['usernamestyle.5.firstl']		=	'firstname.l';
$lang['usernamestyle.6.firstname']	=	'firstname only';
$lang['usernamestyle.7.lastname']	=	'lastname only';
$lang['usernamestyle.8.email']		=	'User Email Address';

$lang['namestyle.1.firstlast']		=	'First Last';
$lang['namestyle.2.firstlastco']	=	'First Last (Company)';
$lang['namestyle.3.lastfirst']		=	'Last, First';
$lang['namestyle.4.lastfirstco']	=	'Last, First (Company)';

$lang['regmethod.0.joomla']		=	'Native Joomla! Registration Form';
$lang['regmethod.1.blesta']		=	'Blesta Registration Form';


// Visual Integration
$lang['admin.form.settings.label.visualenable']				=	'Enable Visual Integration';
$lang['admin.form.settings.label.jqueryenable']				=	'Enable jQuery';
$lang['admin.form.settings.label.imageurl']					=	'Custom URL';
$lang['admin.form.settings.label.menuitem']					=	'Menu Item';
$lang['admin.form.settings.label.resetcss']					=	'Reset CSS';
$lang['admin.form.settings.label.showmyinfo']				=	'Show My Info';
$lang['admin.form.settings.label.showheader']				=	'Show Header';

$lang['admin.form.settings.description.visualenable']		=	'This setting will enable or disable the visual integration from the Blesta side of the product.';
$lang['admin.form.settings.description.jqueryenable']		=	'Turn this on to enable the inclusion of the jQuery library from Blesta.  By default Blesta needs jQuery and does include it, however your Joomla template may already include a jQuery library in it which can cause javascript problems.  Typically you would disable this if you are running Joomla! 3 or a YooTheme template which includes jQuery by default.';
$lang['admin.form.settings.description.imageurl']			=	'Enter a full URL to repoint all images, css and javascript to.  This is useful in the event you have an SSL certificate on Blesta, but not on Joomla, you can enter an URL that would be on the WHMCS location and copy the files into place.';
$lang['admin.form.settings.description.menuitem']			=	'Select a menu item from the drop down list to retrieve from Joomla.';
$lang['admin.form.settings.description.resetcss']			=	'Enable the reset.css to revert any template changes made by your Joomla template so the WHMCS css work as expected.';
$lang['admin.form.settings.description.showmyinfo']			=	'On some Joomla! templates the space provided for rendering the Blesta application is limited.  You can disable the display of the left panel which would include the "My Info" box to provide more room to display content within your template area.';
$lang['admin.form.settings.description.showheader']			=	'Disable this setting to hide the header of the Blesta page containing the large page title and Return to Portal / Log In links.  <strong>Note:</strong> This will also hide the links that appear directly beneath once logged in - be sure to provide some way for your clients to access their account details.';

$lang['customimageurl.label']	=	"URL for Images / CSS / JS";
$lang['customimageurl.optn.joomla']	=	"Use Joomla URL";
$lang['customimageurl.optn.custom']	=	"Use Custom URL";


// Language Settings
$lang['admin.form.settings.label.languageenable']			=	'Enable Language Mapping';
$lang['admin.form.settings.label.languagedefault']			=	'Default Language';
$lang['admin.form.settings.label.languagearabic']			=	'Arabic';
$lang['admin.form.settings.label.languagecatalan']			=	'Catalan';
$lang['admin.form.settings.label.languagecroatian']			=	'Croatian';
$lang['admin.form.settings.label.languageczech']			=	'Czech';
$lang['admin.form.settings.label.languagedanish']			=	'Danish';
$lang['admin.form.settings.label.languagedutch']			=	'Dutch';
$lang['admin.form.settings.label.languageenglish']			=	'English';
$lang['admin.form.settings.label.languagefarsi']			=	'Farsi';
$lang['admin.form.settings.label.languagefrench']			=	'French';
$lang['admin.form.settings.label.languagegerman']			=	'German';
$lang['admin.form.settings.label.languagehungarian']		=	'Hungarian';
$lang['admin.form.settings.label.languageitalian']			=	'Italian';
$lang['admin.form.settings.label.languagenorwegian']		=	'Norwegian';
$lang['admin.form.settings.label.languageportuguese-br']	=	'Portuguese (Brazil)';
$lang['admin.form.settings.label.languageportuguese-pt']	=	'Portuguese (Portugal)';
$lang['admin.form.settings.label.languagerussian']			=	'Russian';
$lang['admin.form.settings.label.languagespanish']			=	'Spanish';
$lang['admin.form.settings.label.languageswedish']			=	'Swedish';
$lang['admin.form.settings.label.languageturkish']			=	'Turkish';
$lang['admin.form.settings.label.languageukranian']			=	'Ukranian';

$lang['admin.form.settings.description.languageenable']		=	'If you use multi-language capabilities within Joomla, you can enable this to map your languages from WHMCS to Joomla.';
$lang['admin.form.settings.description.languagedefault']	=	'Select the default language to use when coming from an unknown WHMCS language.';
$lang['admin.form.settings.description.languagearabic']			=
$lang['admin.form.settings.description.languagecatalan']		=
$lang['admin.form.settings.description.languagecroatian']		=
$lang['admin.form.settings.description.languageczech']			=
$lang['admin.form.settings.description.languagedanish']			=
$lang['admin.form.settings.description.languagedutch']			=
$lang['admin.form.settings.description.languageenglish']		=
$lang['admin.form.settings.description.languagefarsi']			=
$lang['admin.form.settings.description.languagefrench']			=
$lang['admin.form.settings.description.languagegerman']			=
$lang['admin.form.settings.description.languagehungarian']		=
$lang['admin.form.settings.description.languageitalian']		=
$lang['admin.form.settings.description.languagenorwegian']		=
$lang['admin.form.settings.description.languageportuguese-br']	=
$lang['admin.form.settings.description.languageportuguese-pt']	=
$lang['admin.form.settings.description.languagerussian']		=
$lang['admin.form.settings.description.languagespanish']		=
$lang['admin.form.settings.description.languageswedish']		=
$lang['admin.form.settings.description.languageturkish']		=
$lang['admin.form.settings.description.languageukranian']		=	'';

$lang['admin.settings.usedefaultlanguage']	=	'Use Default Item Above';

// Login Settings
$lang['admin.form.settings.label.loginenable']				=	'Enable Login Integration';
$lang['admin.form.settings.label.logouturlfield']			=	'Logout Landing URL';

$lang['admin.form.settings.description.loginenable']		=	'This setting will enable or disable the capability to log the user into both Joomla and WHMCS when logging in from WHMCS.';
$lang['admin.form.settings.description.logouturlfield']		=	'Specify the URL you would like users to return to when logging out through WHMCS.';

// Advanced Settings
$lang['admin.form.settings.label.dlid']							=	'Download ID';
$lang['admin.form.settings.label.preservedb']					=	'Preserve Settings';
$lang['admin.form.settings.label.passalonguseragent']			=	'Pass User Agent';
$lang['admin.form.settings.label.parseheadlinebyline']			=	'Parse Head Line by Line';
$lang['admin.form.settings.label.forceapitoget']				=	'Force API to GET';

$lang['admin.form.settings.description.dlid']					=	'Enter your Download ID in this field.  Note that this is not the same as your license key, but can be acquired by logging into our site and clicking on the "Download ID" button.';
$lang['admin.form.settings.description.preservedb']				=	'Set this to Enabled to ensure if your product is ever deactivated through the Blesta Plugin Manager then the database settings will be preserved.  This is advised if you ever allow third party support staff to troubleshoot problems on your Blesta application.';
$lang['admin.form.settings.description.passalonguseragent']		=	'Some systems require the user agent to be passed along to identify the client properly.  Set this to enable in order to pass your clients reported user agent along to your Joomla installation for visual rendering purposes.  If the client isn\'t reporting a user agent for some reason, then `Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13` will be used as the default.';
$lang['admin.form.settings.description.parseheadlinebyline']	=	'Set this to parse the head of your Joomla document line by line (slightly slower but more accurate)';
$lang['admin.form.settings.description.forceapitoget']			=	'Some servers are configured in such a way that POST, PUT and DELETE requests cannot be processed properly.  This setting will force all API calls from WHMCS to Joomla to use the GET method.  This is not ideal, as any sensitive data used is exposed via the URL, however for most users this should not be a concern.';




// -------------------------------------------------------------------------
// Updates
// v1.0.0
$lang['updates.checking.title']		=	"Checking for Updates";
$lang['updates.checking.subtitle']	=	"Please wait...";

$lang['updates.none.title']		=	"Check Complete";
$lang['updates.none.subtitle']	=	"Your version %s is the latest release";

$lang['updates.exist.title']	=	"Updates Found!";
$lang['updates.exist.subtitle']	=	"Click to update";

$lang['updates.init.title']		=	"Downloading Update";
$lang['updates.init.subtitle']	=	"Downloading version %s...";

$lang['updates.download.title']		=	"Installing Update";
$lang['updates.download.subtitle']	=	"Installing version %s...";

$lang['updates.install.title']		=	"Product Installed";
$lang['updates.install.subtitle']	=	'Upgrading system...';

$lang['updates.complete.title']		=	"Upgrade Complete!";
$lang['updates.complete.subtitle']	=	"Version %s installed";


// -------------------------------------------------------------------------
// System Check
// v1.0.0
$lang['install.file.error.read']	=	'There was a problem reading the %s file';
$lang['install.file.error.version']	=	'Unable to determine the version of the %s file';
$lang['install.file.error.newer']	=	'%s is newer than %s';
$lang['install.file.error.chksum']	=	'The file checksums did not match - if you have customized the template file this is okay!';
$lang['install.file.jblesta']		=	'the J!Blesta template file';
$lang['install.file.template']		=	'the template file currently being used';

$lang['install.file.fix.fail.readsrc']		=	'Unable to read the source file `%s`';
$lang['install.file.fix.fail.copy']			=	'Unable to write the destination file `%s`';
$lang['install.file.fix.fail.delbackup']	=	'Unable to delete the backup file `%s`';
$lang['install.file.fix.fail.movebackup']	=	'Unable to backup the file `%s`';
$lang['install.file.fix.fail.pathcheck']	=	'Path check failed for `%s`';
$lang['install.file.fix.fail.missbackup']	=	'Backup file missing, unable to restore `%s`';
$lang['install.file.fix.fail.deloriginal']	=	'Unable to remove the modified file `%s` to restore the backup';
$lang['install.file.fix.fail.restore']		=	'Unable to restore the backup file to `%s`';
$lang['install.file.fix.fail.delfile']		=	'Unable to delete the file `%s`';

$lang['syscheck.general.supported.yes']	=	'Supported';
$lang['syscheck.general.supported.no']	=	'Not Supported';
$lang['syscheck.general.yesno.yes']		=	'Yes';
$lang['syscheck.general.yesno.no']		=	'No';
$lang['syscheck.general.attention']		=	'Attention: ';
$lang['syscheck.general.fixit']			=	'Correct';


$lang['syscheck.tblhdr.blesta']		=	'<h4>Blesta System Check</h4>';
$lang['syscheck.tbldata.blesta.version']		=	'%s Version';

$lang['syscheck.version.help']		=	' The version of J!Blesta you are running does not explicitly support the version of Blesta you are running.  If you have recently upgraded Blesta, you will need to check for an update from Go Higher for the J!Blesta to ensure any changes in the system API will work with J!Blesta.';


$lang['syscheck.tblhdr.env']			=	'<h4>Environment Check</h4>';
$lang['syscheck.tbldata.env.curl']			=	'%s Curl Support';
$lang['syscheck.tbldata.env.iconv']			=	'%s iconv Found';
$lang['syscheck.tbldata.env.mbdetect']		=	'%s Multibyte';
$lang['syscheck.tbldata.env.phpvers']		=	'%s PHP Version';

$lang['syscheck.curl.help']			=	' The Client URL Library (curl) could not be found in your environment.  You must compile your PHP with curl in order for J!Blesta to operate properly.';
$lang['syscheck.iconv.help']		=	' J!Blesta was unable to locate the iconv function which is used to transliterate a Joomla site to match your Blesta character encoding.  This may not be a big deal if you are using ISO-8895-1 or UTF-8 in Blesta, but for any other character encoding you will want to build php with this capability.';
$lang['syscheck.mbdetect.help']		=	' J!Blesta was unable to locate the multibyte string functionality needed to transliterate a Joomla site to match your Blesta character encoding.  This may not be a big deal if you are using ISO-8895-1 or UTF-8 in Blesta, but for any other character encoding you will want to build php with this capability.';
$lang['syscheck.phpvers.help']		=	' You must use PHP version 5.2 or higher!';


$lang['syscheck.tblhdr.api']		=	'<h4>API Check</h4>';
$lang['syscheck.tbldata.api.apiurl']	=	'%s API URL';
$lang['syscheck.tbldata.api.apifound']	=	'%s URL Found';
$lang['syscheck.tbldata.api.token']		=	'%s Token Set';
$lang['syscheck.tbldata.api.tokenauth']	=	'%s Token Valid';

$lang['syscheck.apiurl.help']		=	' You haven\'t set a URL yet in the settings for J!Blesta.  Please click on Settings above to do so now.';
$lang['syscheck.apifound.help']		=	' The API attempted to verify the URL you entered in your settings and received this message back: %s';
$lang['syscheck.token.help']		=	' You haven\'t set a Token yet in the settings for J!Blesta.  Please click on Settings above to do so now.';
$lang['syscheck.tokenauth.help']	=	' The API attempted to verify the token and authorize access to Joomla but received this message back from Joomla: %s';

$lang['syscheck.tblhdr.files']		=	'<h4>File Check</h4>';



/* ========================================================================= *\
 * FRONTEND TRANSLATION STRINGS
\* ========================================================================= */
//
// -------------------------------------------------------------------------
// Control Panel Screen
$lang['client.pagetitle']		=	'J!Blesta Debug Screen';

$lang['client.pagedesc.index']		=	'Check Screen';
$lang['client.breadcrumb.index']	=	'J!Blesta: Client Check Screen';

$lang['client.pagedesc.checkinstall']	=	'Check Install';
$lang['client.breadcrumb.checkinstall']	=	'J!Blesta: Check Install';

$lang['client.pagedesc.checkrender']	=	'Check Render';
$lang['client.breadcrumb.checkrender']	=	'J!Blesta: Check Render';
