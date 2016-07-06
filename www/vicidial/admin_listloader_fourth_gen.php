<?php
# admin_listloader_fourth_gen.php - version 2.10
#  (based upon - new_listloader_superL.php script)
# 
# Copyright (C) 2015  Matt Florell,Joe Johnson <vicidial@gmail.com>    LICENSE: AGPLv2
#
# ViciDial web-based lead loader from formatted file
# 
# CHANGES
# 50602-1640 - First version created by Joe Johnson
# 51128-1108 - Removed PHP global vars requirement
# 60113-1603 - Fixed a few bugs in Excel import
# 60421-1624 - check GET/POST vars lines with isset to not trigger PHP NOTICES
# 60616-1240 - added listID override
# 60616-1604 - added gmt lookup for each lead
# 60619-1651 - Added variable filtering to eliminate SQL injection attack threat
# 60822-1121 - fixed for nonwritable directories
# 60906-1100 - added filter of non-digits in alt_phone field
# 61110-1222 - added new USA-Canada DST scheme and Brazil DST scheme
# 61128-1149 - added postal code GMT lookup and duplicate check options
# 70417-1059 - Fixed default phone_code bug
# 70510-1518 - Added campaign and system duplicate check and phonecode override
# 80428-0417 - UTF8 changes
# 80514-1030 - removed filesize limit and raised number of errors to be displayed
# 80713-0023 - added last_local_call_time field default of 2008-01-01
# 81011-2009 - a few bug fixes
# 90309-1831 - Added admin_log logging
# 90310-2128 - Added admin header
# 90508-0644 - Changed to PHP long tags
# 90522-0506 - Security fix
# 90721-1339 - Added rank and owner as vicidial_list fields
# 91112-0616 - Added title/alt-phone duplicate checking
# 100118-0543 - Added new Australian and New Zealand DST schemes (FSO-FSA and LSS-FSA)
# 100621-1026 - Added admin_web_directory variable
# 100630-1609 - Added a check for invalid ListIds and filtered out ' " ; ` \ from the field <mikec>
# 100705-1507 - Added custom fields to field chooser, only when liast_id_override is used and only with TXT and CSV file formats
# 100706-1250 - Forked script to create new script that will only load TXT(tab-
#				delimited files) and use a perl script to convert others to TXT
# 100707-1040 - Converted List Id Override and Phone Code Override to drop downs <mikec>
# 100707-1156 - Made it so you cannot submit with no lead file selected. Also fixed Start Over Link <mikec>
# 100712-1416 - Added entry_list_id field to vicidial_list to preserve link to custom fields if any
# 100728-0900 - Filtered uploaded filenames for unsupported characters
# 110424-0926 - Added option for time zone code in the owner field
# 110705-1947 - Added USACAN check for prefix and areacode
# 120221-0140 - Added User Group restrictions
# 120223-2318 - Removed logging of good login passwords if webroot writable is enabled
# 120402-2128 - Added template options
# 120525-1038 - Added uploaded filename filtering
# 120529-1348 - Filename filter fix
# 130420-2056 - Added NANPA prefix validation and timezone options
# 130610-0920 - Finalized changing of all ereg instances to preg
# 130621-1817 - Added filtering of input to prevent SQL injection attacks and new user auth
# 130719-1914 - Added SQL to filter by template statuses, if template has specific statuses to dedupe against
# 130802-0619 - Added status deduping option without template
# 130824-2322 - Changed to mysqli PHP functions
# 140214-1022 - Fixed status dedupe bug
# 140328-0007 - Converted division calculations to use MathZDC function
# 141001-2200 - Finalized adding QXZ translation to all admin files
# 141118-1955 - Added more debug output
# 141229-1814 - Added code for on-the-fly language translations display
# 150209-2113 - Added master_list_override option to override template setting
#

$version = '2.10-57';
$build = '150209-2113';

require("dbconnect_mysqli.php");
require("functions.php");

$US='_';

$PHP_AUTH_USER=$_SERVER['PHP_AUTH_USER'];
$PHP_AUTH_PW=$_SERVER['PHP_AUTH_PW'];
$PHP_SELF=$_SERVER['PHP_SELF'];
$leadfile=$_FILES["leadfile"];
	$LF_orig = $_FILES['leadfile']['name'];
	$LF_path = $_FILES['leadfile']['tmp_name'];
if (isset($_GET["submit_file"]))			{$submit_file=$_GET["submit_file"];}
	elseif (isset($_POST["submit_file"]))	{$submit_file=$_POST["submit_file"];}
if (isset($_GET["submit"]))				{$submit=$_GET["submit"];}
	elseif (isset($_POST["submit"]))	{$submit=$_POST["submit"];}
if (isset($_GET["SUBMIT"]))				{$SUBMIT=$_GET["SUBMIT"];}
	elseif (isset($_POST["SUBMIT"]))	{$SUBMIT=$_POST["SUBMIT"];}
if (isset($_GET["leadfile_name"]))			{$leadfile_name=$_GET["leadfile_name"];}
	elseif (isset($_POST["leadfile_name"]))	{$leadfile_name=$_POST["leadfile_name"];}
if (isset($_FILES["leadfile"]))				{$leadfile_name=$_FILES["leadfile"]['name'];}
if (isset($_GET["file_layout"]))				{$file_layout=$_GET["file_layout"];}
	elseif (isset($_POST["file_layout"]))		{$file_layout=$_POST["file_layout"];}
if (isset($_GET["OK_to_process"]))				{$OK_to_process=$_GET["OK_to_process"];}
	elseif (isset($_POST["OK_to_process"]))		{$OK_to_process=$_POST["OK_to_process"];}
if (isset($_GET["vendor_lead_code_field"]))				{$vendor_lead_code_field=$_GET["vendor_lead_code_field"];}
	elseif (isset($_POST["vendor_lead_code_field"]))	{$vendor_lead_code_field=$_POST["vendor_lead_code_field"];}
if (isset($_GET["source_id_field"]))			{$source_id_field=$_GET["source_id_field"];}
	elseif (isset($_POST["source_id_field"]))	{$source_id_field=$_POST["source_id_field"];}
if (isset($_GET["list_id_field"]))				{$list_id_field=$_GET["list_id_field"];}
	elseif (isset($_POST["list_id_field"]))		{$list_id_field=$_POST["list_id_field"];}
if (isset($_GET["phone_code_field"]))			{$phone_code_field=$_GET["phone_code_field"];}
	elseif (isset($_POST["phone_code_field"]))	{$phone_code_field=$_POST["phone_code_field"];}
if (isset($_GET["phone_number_field"]))				{$phone_number_field=$_GET["phone_number_field"];}
	elseif (isset($_POST["phone_number_field"]))	{$phone_number_field=$_POST["phone_number_field"];}
if (isset($_GET["title_field"]))				{$title_field=$_GET["title_field"];}
	elseif (isset($_POST["title_field"]))		{$title_field=$_POST["title_field"];}
if (isset($_GET["first_name_field"]))			{$first_name_field=$_GET["first_name_field"];}
	elseif (isset($_POST["first_name_field"]))	{$first_name_field=$_POST["first_name_field"];}
if (isset($_GET["middle_initial_field"]))			{$middle_initial_field=$_GET["middle_initial_field"];}
	elseif (isset($_POST["middle_initial_field"]))	{$middle_initial_field=$_POST["middle_initial_field"];}
if (isset($_GET["last_name_field"]))			{$last_name_field=$_GET["last_name_field"];}
	elseif (isset($_POST["last_name_field"]))	{$last_name_field=$_POST["last_name_field"];}
if (isset($_GET["address1_field"]))				{$address1_field=$_GET["address1_field"];}
	elseif (isset($_POST["address1_field"]))	{$address1_field=$_POST["address1_field"];}
if (isset($_GET["address2_field"]))				{$address2_field=$_GET["address2_field"];}
	elseif (isset($_POST["address2_field"]))	{$address2_field=$_POST["address2_field"];}
if (isset($_GET["address3_field"]))				{$address3_field=$_GET["address3_field"];}
	elseif (isset($_POST["address3_field"]))	{$address3_field=$_POST["address3_field"];}
if (isset($_GET["city_field"]))					{$city_field=$_GET["city_field"];}
	elseif (isset($_POST["city_field"]))		{$city_field=$_POST["city_field"];}
if (isset($_GET["state_field"]))				{$state_field=$_GET["state_field"];}
	elseif (isset($_POST["state_field"]))		{$state_field=$_POST["state_field"];}
if (isset($_GET["province_field"]))				{$province_field=$_GET["province_field"];}
	elseif (isset($_POST["province_field"]))		{$province_field=$_POST["province_field"];}
if (isset($_GET["postal_code_field"]))				{$postal_code_field=$_GET["postal_code_field"];}
	elseif (isset($_POST["postal_code_field"]))		{$postal_code_field=$_POST["postal_code_field"];}
if (isset($_GET["country_code_field"]))				{$country_code_field=$_GET["country_code_field"];}
	elseif (isset($_POST["country_code_field"]))	{$country_code_field=$_POST["country_code_field"];}
if (isset($_GET["gender_field"]))			{$gender_field=$_GET["gender_field"];}
	elseif (isset($_POST["gender_field"]))		{$gender_field=$_POST["gender_field"];}
if (isset($_GET["date_of_birth_field"]))			{$date_of_birth_field=$_GET["date_of_birth_field"];}
	elseif (isset($_POST["date_of_birth_field"]))	{$date_of_birth_field=$_POST["date_of_birth_field"];}
if (isset($_GET["alt_phone_field"]))			{$alt_phone_field=$_GET["alt_phone_field"];}
	elseif (isset($_POST["alt_phone_field"]))	{$alt_phone_field=$_POST["alt_phone_field"];}
if (isset($_GET["email_field"]))				{$email_field=$_GET["email_field"];}
	elseif (isset($_POST["email_field"]))		{$email_field=$_POST["email_field"];}
if (isset($_GET["security_phrase_field"]))			{$security_phrase_field=$_GET["security_phrase_field"];}
	elseif (isset($_POST["security_phrase_field"]))	{$security_phrase_field=$_POST["security_phrase_field"];}
if (isset($_GET["comments_field"]))				{$comments_field=$_GET["comments_field"];}
	elseif (isset($_POST["comments_field"]))	{$comments_field=$_POST["comments_field"];}
if (isset($_GET["rank_field"]))					{$rank_field=$_GET["rank_field"];}
	elseif (isset($_POST["rank_field"]))		{$rank_field=$_POST["rank_field"];}
if (isset($_GET["owner_field"]))				{$owner_field=$_GET["owner_field"];}
	elseif (isset($_POST["owner_field"]))		{$owner_field=$_POST["owner_field"];}
if (isset($_GET["list_id_override"]))			{$list_id_override=$_GET["list_id_override"];}
	elseif (isset($_POST["list_id_override"]))	{$list_id_override=$_POST["list_id_override"];}
	$list_id_override = (preg_replace("/\D/","",$list_id_override));
if (isset($_GET["master_list_override"]))			{$master_list_override=$_GET["master_list_override"];}
	elseif (isset($_POST["master_list_override"]))	{$master_list_override=$_POST["master_list_override"];}
if (isset($_GET["lead_file"]))					{$lead_file=$_GET["lead_file"];}
	elseif (isset($_POST["lead_file"]))			{$lead_file=$_POST["lead_file"];}
if (isset($_GET["dupcheck"]))				{$dupcheck=$_GET["dupcheck"];}
	elseif (isset($_POST["dupcheck"]))		{$dupcheck=$_POST["dupcheck"];}
if (isset($_GET["dedupe_statuses"]))				{$dedupe_statuses=$_GET["dedupe_statuses"];}
	elseif (isset($_POST["dedupe_statuses"]))		{$dedupe_statuses=$_POST["dedupe_statuses"];}
if (isset($_GET["dedupe_statuses_override"]))				{$dedupe_statuses_override=$_GET["dedupe_statuses_override"];}
	elseif (isset($_POST["dedupe_statuses_override"]))		{$dedupe_statuses_override=$_POST["dedupe_statuses_override"];}
if (isset($_GET["postalgmt"]))				{$postalgmt=$_GET["postalgmt"];}
	elseif (isset($_POST["postalgmt"]))		{$postalgmt=$_POST["postalgmt"];}
if (isset($_GET["phone_code_override"]))			{$phone_code_override=$_GET["phone_code_override"];}
	elseif (isset($_POST["phone_code_override"]))	{$phone_code_override=$_POST["phone_code_override"];}
	$phone_code_override = (preg_replace("/\D/","",$phone_code_override));
if (isset($_GET["DB"]))					{$DB=$_GET["DB"];}
	elseif (isset($_POST["DB"]))		{$DB=$_POST["DB"];}
if (isset($_GET["template_id"]))					{$template_id=$_GET["template_id"];}
	elseif (isset($_POST["template_id"]))		{$template_id=$_POST["template_id"];}
if (isset($_GET["usacan_check"]))			{$usacan_check=$_GET["usacan_check"];}
	elseif (isset($_POST["usacan_check"]))	{$usacan_check=$_POST["usacan_check"];}

if (strlen($dedupe_statuses_override)>0) {
	$dedupe_statuses=explode(",", $dedupe_statuses_override);
}
# if the didnt select an over ride wipe out in_file
if ( $list_id_override == "in_file" ) { $list_id_override = ""; }
if ( $phone_code_override == "in_file" ) { $phone_code_override = ""; }

# $country_field=$_GET["country_field"];					if (!$country_field) {$country_field=$_POST["country_field"];}

### REGEX to prevent weird characters from ending up in the fields
$field_regx = "['\"`\\;]";

$vicidial_list_fields = '|lead_id|vendor_lead_code|source_id|list_id|gmt_offset_now|called_since_last_reset|phone_code|phone_number|title|first_name|middle_initial|last_name|address1|address2|address3|city|state|province|postal_code|country_code|gender|date_of_birth|alt_phone|email|security_phrase|comments|called_count|last_local_call_time|rank|owner|entry_list_id|';

#############################################
##### START SYSTEM_SETTINGS LOOKUP #####
$stmt = "SELECT use_non_latin,admin_web_directory,custom_fields_enabled,webroot_writable,enable_languages,language_method FROM system_settings;";
$rslt=mysql_to_mysqli($stmt, $link);
if ($DB) {echo "$stmt\n";}
$qm_conf_ct = mysqli_num_rows($rslt);
if ($qm_conf_ct > 0)
	{
	$row=mysqli_fetch_row($rslt);
	$non_latin =				$row[0];
	$admin_web_directory =		$row[1];
	$custom_fields_enabled =	$row[2];
	$webroot_writable =			$row[3];
	$SSenable_languages =		$row[4];
	$SSlanguage_method =		$row[5];
	}
##### END SETTINGS LOOKUP #####
###########################################

if ($non_latin < 1)
	{
	$PHP_AUTH_USER = preg_replace('/[^0-9a-zA-Z]/', '', $PHP_AUTH_USER);
	$PHP_AUTH_PW = preg_replace('/[^0-9a-zA-Z]/', '', $PHP_AUTH_PW);
	}
else
	{
	$PHP_AUTH_PW = preg_replace("/'|\"|\\\\|;/","",$PHP_AUTH_PW);
	$PHP_AUTH_USER = preg_replace("/'|\"|\\\\|;/","",$PHP_AUTH_USER);
	}
$list_id_override = preg_replace('/[^0-9]/','',$list_id_override);

$STARTtime = date("U");
$TODAY = date("Y-m-d");
$NOW_TIME = date("Y-m-d H:i:s");
$FILE_datetime = $STARTtime;
$date = date("r");
$ip = getenv("REMOTE_ADDR");
$browser = getenv("HTTP_USER_AGENT");

$stmt="SELECT selected_language from vicidial_users where user='$PHP_AUTH_USER';";
if ($DB) {echo "|$stmt|\n";}
$rslt=mysql_to_mysqli($stmt, $link);
$sl_ct = mysqli_num_rows($rslt);
if ($sl_ct > 0)
	{
	$row=mysqli_fetch_row($rslt);
	$VUselected_language =		$row[0];
	}

$auth=0;
$auth_message = user_authorization($PHP_AUTH_USER,$PHP_AUTH_PW,'',1);
if ($auth_message == 'GOOD')
	{$auth=1;}

if ($auth < 1)
	{
	$VDdisplayMESSAGE = _QXZ("Login incorrect, please try again");
	if ($auth_message == 'LOCK')
		{
		$VDdisplayMESSAGE = _QXZ("Too many login attempts, try again in 15 minutes");
		Header ("Content-type: text/html; charset=utf-8");
		echo "$VDdisplayMESSAGE: |$PHP_AUTH_USER|$auth_message|\n";
		exit;
		}
	Header("WWW-Authenticate: Basic realm=\"CONTACT-CENTER-ADMIN\"");
	Header("HTTP/1.0 401 Unauthorized");
	echo "$VDdisplayMESSAGE: |$PHP_AUTH_USER|$PHP_AUTH_PW|$auth_message|\n";
	exit;
	}

$stmt="SELECT load_leads,user_group from vicidial_users where user='$PHP_AUTH_USER';";
$rslt=mysql_to_mysqli($stmt, $link);
$row=mysqli_fetch_row($rslt);
$LOGload_leads =	$row[0];
$LOGuser_group =	$row[1];

if ($LOGload_leads < 1)
	{
	Header ("Content-type: text/html; charset=utf-8");
	echo _QXZ("You do not have permissions to load leads")."\n";
	exit;
	}

if (preg_match("/;|:|\/|\^|\[|\]|\"|\'|\*/",$LF_orig))
	{
	echo _QXZ("ERROR: Invalid File Name").":: $LF_orig\n";
	exit;
	}

$stmt="SELECT allowed_campaigns,allowed_reports,admin_viewable_groups,admin_viewable_call_times from vicidial_user_groups where user_group='$LOGuser_group';";
if ($DB) {echo "|$stmt|\n";}
$rslt=mysql_to_mysqli($stmt, $link);
$row=mysqli_fetch_row($rslt);
$LOGallowed_campaigns =			$row[0];
$LOGallowed_reports =			$row[1];
$LOGadmin_viewable_groups =		$row[2];
$LOGadmin_viewable_call_times =	$row[3];

$camp_lists='';
$LOGallowed_campaignsSQL='';
$whereLOGallowed_campaignsSQL='';
if (!preg_match('/\-ALL/i', $LOGallowed_campaigns))
	{
	$rawLOGallowed_campaignsSQL = preg_replace("/ -/",'',$LOGallowed_campaigns);
	$rawLOGallowed_campaignsSQL = preg_replace("/ /","','",$rawLOGallowed_campaignsSQL);
	$LOGallowed_campaignsSQL = "and campaign_id IN('$rawLOGallowed_campaignsSQL')";
	$whereLOGallowed_campaignsSQL = "where campaign_id IN('$rawLOGallowed_campaignsSQL')";
	}
$regexLOGallowed_campaigns = " $LOGallowed_campaigns ";

$script_name = getenv("SCRIPT_NAME");
$server_name = getenv("SERVER_NAME");
$server_port = getenv("SERVER_PORT");
if (preg_match("/443/i",$server_port)) {$HTTPprotocol = 'https://';}
	else {$HTTPprotocol = 'http://';}
$admDIR = "$HTTPprotocol$server_name$script_name";
$admDIR = preg_replace('/admin_listloader_fourth_gen\.php/i', '',$admDIR);
$admDIR = "/vicidial/";
$admSCR = 'admin.php';
$NWB = " &nbsp; <a href=\"javascript:openNewWindow('help.php?ADD=99999";
$NWE = "')\"><IMG SRC=\"help.gif\" WIDTH=20 HEIGHT=20 BORDER=0 ALT=\"HELP\" ALIGN=TOP></A>";

$secX = date("U");
$hour = date("H");
$min = date("i");
$sec = date("s");
$mon = date("m");
$mday = date("d");
$year = date("Y");
$isdst = date("I");
$Shour = date("H");
$Smin = date("i");
$Ssec = date("s");
$Smon = date("m");
$Smday = date("d");
$Syear = date("Y");
$pulldate0 = "$year-$mon-$mday $hour:$min:$sec";
$inSD = $pulldate0;
$dsec = ( ( ($hour * 3600) + ($min * 60) ) + $sec );

### Grab Server GMT value from the database
$stmt="SELECT local_gmt FROM servers where server_ip = '$server_ip';";
$rslt=mysql_to_mysqli($stmt, $link);
$gmt_recs = mysqli_num_rows($rslt);
if ($gmt_recs > 0)
	{
	$row=mysqli_fetch_row($rslt);
	$DBSERVER_GMT		=		"$row[0]";
	if (strlen($DBSERVER_GMT)>0)	{$SERVER_GMT = $DBSERVER_GMT;}
	if ($isdst) {$SERVER_GMT++;} 
	}
else
	{
	$SERVER_GMT = date("O");
	$SERVER_GMT = preg_replace('/\+/i', '',$SERVER_GMT);
	$SERVER_GMT = ($SERVER_GMT + 0);
	$SERVER_GMT = MathZDC($SERVER_GMT, 100);
	}

$LOCAL_GMT_OFF = $SERVER_GMT;
$LOCAL_GMT_OFF_STD = $SERVER_GMT;

$dedupe_status_select='';
$stmt="SELECT status, status_name from vicidial_statuses order by status;";
$rslt=mysql_to_mysqli($stmt, $link);
$stat_num_rows = mysqli_num_rows($rslt);
$snr_count=0;
while ($stat_num_rows > $snr_count) 
	{
	$row=mysqli_fetch_row($rslt);
	$dedupe_status_select .= "\t\t\t<option value='$row[0]'>$row[0] - $row[1]</option>\n";
	$snr_count++;
	}

#if ($DB) {print "SEED TIME  $secX      :   $year-$mon-$mday $hour:$min:$sec  LOCAL GMT OFFSET NOW: $LOCAL_GMT_OFF\n";}


echo "<html>\n";
echo "<head>\n";
echo "<!-- VERSION: $version     BUILD: $build -->\n";
echo "<!-- SEED TIME  $secX:   $year-$mon-$mday $hour:$min:$sec  LOCAL GMT OFFSET NOW: $LOCAL_GMT_OFF  DST: $isdst -->\n";

function macfontfix($fontsize) 
	{
	$browser = getenv("HTTP_USER_AGENT");
	$pctype = explode("(", $browser);
	if (preg_match('/Mac/',$pctype[1])) 
		{
		/* Browser is a Mac.  If not Netscape 6, raise fonts */
		$blownbrowser = explode('/', $browser);
		$ver = explode(' ', $blownbrowser[1]);
		$ver = $ver[0];
		if ($ver >= 5.0) return $fontsize; else return ($fontsize+2);
		} 
	else return $fontsize;	/* Browser is not a Mac - don't touch fonts */
	}

echo "<style type=\"text/css\">\n
<!--\n
.title {  font-family: Arial, Helvetica, sans-serif; font-size: ".macfontfix(18)."pt}\n
.standard {  font-family: Arial, Helvetica, sans-serif; font-size: ".macfontfix(10)."pt}\n
.small_standard {  font-family: Arial, Helvetica, sans-serif; font-size: ".macfontfix(8)."pt}\n
.tiny_standard {  font-family: Arial, Helvetica, sans-serif; font-size: ".macfontfix(6)."pt}\n
.standard_bold {  font-family: Arial, Helvetica, sans-serif; font-size: ".macfontfix(10)."pt; font-weight: bold}\n
.standard_header {  font-family: Arial, Helvetica, sans-serif; font-size: ".macfontfix(14)."pt; font-weight: bold}\n
.standard_bold_highlight {  font-family: Arial, Helvetica, sans-serif; font-size: ".macfontfix(10)."pt; font-weight: bold; color: white; BACKGROUND-COLOR: black}\n
.standard_bold_blue_highlight {  font-family: Arial, Helvetica, sans-serif; font-size: 10pt; font-weight: bold; BACKGROUND-COLOR: blue}\n
A.employee_standard {  font-family: garamond, sans-serif; font-size: ".macfontfix(10)."pt; font-style: normal; font-variant: normal; font-weight: bold; text-decoration: none}\n
.employee_standard {  font-family: garamond, sans-serif; font-size: ".macfontfix(10)."pt; font-weight: bold}\n
.employee_title {  font-family: Garamond, sans-serif; font-size: ".macfontfix(14)."pt; font-weight: bold}\n
\\\\-->\n
</style>\n";

?>


<script language="JavaScript1.2">
function openNewWindow(url) 
	{
	window.open (url,"",'width=700,height=300,scrollbars=yes,menubar=yes,address=yes');
	}
function ShowProgress(good, bad, total, dup, inv, post) 
	{
	parent.lead_count.document.open();
	parent.lead_count.document.write('<html><body><table border=0 width=200 cellpadding=10 cellspacing=0 align=center valign=top><tr bgcolor="#000000"><th colspan=2><font face="arial, helvetica" size=3 color=white><?php echo _QXZ("Current file status"); ?>:</font></th></tr><tr bgcolor="#009900"><td align=right><font face="arial, helvetica" size=2 color=white><B><?php echo _QXZ("Good"); ?>:</B></font></td><td align=left><font face="arial, helvetica" size=2 color=white><B>'+good+'</B></font></td></tr><tr bgcolor="#990000"><td align=right><font face="arial, helvetica" size=2 color=white><B><?php echo _QXZ("Bad"); ?>:</B></font></td><td align=left><font face="arial, helvetica" size=2 color=white><B>'+bad+'</B></font></td></tr><tr bgcolor="#000099"><td align=right><font face="arial, helvetica" size=2 color=white><B><?php echo _QXZ("Total"); ?>:</B></font></td><td align=left><font face="arial, helvetica" size=2 color=white><B>'+total+'</B></font></td></tr><tr bgcolor="#009900"><td align=right><font face="arial, helvetica" size=2 color=white><B> &nbsp; </B></font></td><td align=left><font face="arial, helvetica" size=2 color=white><B> &nbsp; </B></font></td></tr><tr bgcolor="#009900"><td align=right><font face="arial, helvetica" size=2 color=white><B><?php echo _QXZ("Duplicate"); ?>:</B></font></td><td align=left><font face="arial, helvetica" size=2 color=white><B>'+dup+'</B></font></td></tr></tr><tr bgcolor="#009900"><td align=right><font face="arial, helvetica" size=2 color=white><B><?php echo _QXZ("Invalid"); ?>:</B></font></td><td align=left><font face="arial, helvetica" size=2 color=white><B>'+inv+'</B></font></td></tr><tr bgcolor="#009900"><td align=right><font face="arial, helvetica" size=2 color=white><B><?php echo _QXZ("Postal Match"); ?>:</B></font></td><td align=left><font face="arial, helvetica" size=2 color=white><B>'+post+'</B></font></td></tr></table><body></html>');
	parent.lead_count.document.close();
	}
function ParseFileName() 
	{
	if (!document.forms[0].OK_to_process) 
		{	
		var endstr=document.forms[0].leadfile.value.lastIndexOf('\\');
		if (endstr>-1) 
			{
			endstr++;
			var filename=document.forms[0].leadfile.value.substring(endstr);
			document.forms[0].leadfile_name.value=filename;
			}
		}
	}
function TemplateSpecs() {
	var template_field = document.getElementById("template_id");
	var template_id_value = template_field.options[template_field.selectedIndex].value;
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
		}
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	if (xmlhttp && template_id_value!="") { 
		var vs_query = "&template_id="+template_id_value;
		xmlhttp.open('POST', 'leadloader_template_display.php'); 
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=UTF-8');
		xmlhttp.send(vs_query); 
		xmlhttp.onreadystatechange = function() { 
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				var TemplateInfo = null;
				TemplateInfo = xmlhttp.responseText;
				if (TemplateInfo.length>0)
				{
				alert(TemplateInfo);
				}
			}
		}
		delete xmlhttp;
	}
}
function PopulateStatuses(list_id) {
	
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
		}
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	if (xmlhttp) { 
		var vs_query = "&form_action=no_template&list_id="+list_id;
		xmlhttp.open('POST', 'leadloader_template_display.php'); 
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=UTF-8');
		xmlhttp.send(vs_query); 
		xmlhttp.onreadystatechange = function() { 
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				var StatSpanText = null;
				StatSpanText = xmlhttp.responseText;
				document.getElementById("statuses_display").innerHTML = StatSpanText;
			}
		}
		delete xmlhttp;
	}

}

</script>
<title><?php echo _QXZ("ADMINISTRATION: Lead Loader"); ?></title>
</head>
<BODY BGCOLOR=WHITE marginheight=0 marginwidth=0 leftmargin=0 topmargin=0>

<?php
$short_header=1;

require("admin_header.php");

echo "<TABLE CELLPADDING=4 CELLSPACING=0><TR><TD>";


if ( (preg_match("/NANPA/",$usacan_check)) or (preg_match("/NANPA/",$tz_method)) )
	{
	$stmt="SELECT count(*) from vicidial_nanpa_prefix_codes;";
	$rslt=mysql_to_mysqli($stmt, $link);
	$row=mysqli_fetch_row($rslt);
	$vicidial_nanpa_prefix_codes_count = $row[0];
	if ($vicidial_nanpa_prefix_codes_count < 10)
		{
		$usacan_check = preg_replace("/NANPA/",'',$usacan_check);
		$tz_method = preg_replace("/NANPA/",'',$tz_method);

		echo "NOTICE: NANPA options disabled, NANPA prefix data not loaded: $vicidial_nanpa_prefix_codes_count<BR>\n";
		}
	}

if ( (!$OK_to_process) or ( ($leadfile) and ($file_layout!="standard" && $file_layout!="template") ) )
	{
	?>
	<form action=<?php echo $PHP_SELF ?> method=post onSubmit="ParseFileName()" enctype="multipart/form-data">
	<input type=hidden name='leadfile_name' value="<?php echo $leadfile_name ?>">
	<input type=hidden name='DB' value="<?php echo $DB ?>">
	<?php 
	if ($file_layout!="custom") 
		{
		?>
		<table align=center width="780" border=0 cellpadding=5 cellspacing=0 bgcolor=#D9E6FE>
		  <tr>
			<td align=right width="35%"><B><font face="arial, helvetica" size=2><?php echo _QXZ("Load leads from this file"); ?>:</font></B></td>
			<td align=left width="65%"><input type=file name="leadfile" value="<?php echo $leadfile ?>"> <?php echo "$NWB#list_loader$NWE"; ?></td>
		  </tr>
		  <tr>
			<td align=right width="25%"><font face="arial, helvetica" size=2><?php echo _QXZ("List ID Override"); ?>: </font></td>
			<td align=left width="75%"><font face="arial, helvetica" size=1>
			<select name='list_id_override' onchange="PopulateStatuses(this.value)">
			<option value='in_file' selected='yes'><?php echo _QXZ("Load from Lead File"); ?></option>
			<?php
			$stmt="SELECT list_id, list_name from vicidial_lists $whereLOGallowed_campaignsSQL order by list_id;";
			$rslt=mysql_to_mysqli($stmt, $link);
			$num_rows = mysqli_num_rows($rslt);

			$count=0;
			while ( $num_rows > $count ) 
				{
				$row = mysqli_fetch_row($rslt);
				echo "<option value=\'$row[0]\'>$row[0] - $row[1]</option>\n";
				$count++;
				}
			?>
			</select><input type='checkbox' name='master_list_override' value='1'>(override template setting)
			</font></td>
		  </tr>
		  <tr>
			<td align=right width="25%"><font face="arial, helvetica" size=2><?php echo _QXZ("Phone Code Override"); ?>: </font></td>
			<td align=left width="75%"><font face="arial, helvetica" size=1>
			<select name='phone_code_override'>
                        <option value='in_file' selected='yes'><?php echo _QXZ("Load from Lead File"); ?></option>
			<?php
			$stmt="select distinct country_code, country from vicidial_phone_codes;";
			$rslt=mysql_to_mysqli($stmt, $link);
			$num_rows = mysqli_num_rows($rslt);
			
			$count=0;
	                while ( $num_rows > $count )
				{
				$row = mysqli_fetch_row($rslt);
				echo "<option value=\'$row[0]\'>$row[0] - $row[1]</option>\n";
				$count++;
				}
			?>
			</select>
			</font></td>
		  </tr>
		  <tr>
			<td align=right><B><font face="arial, helvetica" size=2><?php echo _QXZ("File layout to use"); ?>:</font></B></td>
			<td align=left><font face="arial, helvetica" size=2><input type=radio name="file_layout" value="standard" checked><?php echo _QXZ("Standard Format"); ?>&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name="file_layout" value="custom"><?php echo _QXZ("Custom layout"); ?>&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name="file_layout" value="template"><?php echo _QXZ("Custom Template"); ?> <?php echo "$NWB#list_loader-file_layout$NWE"; ?></td>
		  </tr>
		  <tr>
			<td align=right width="25%"><font face="arial, helvetica" size=2><?php echo _QXZ("Custom Layout to Use"); ?>: </font></td>
			<td align=left><select name="template_id" id="template_id">
<?php
				$template_stmt="select template_id, template_name from vicidial_custom_leadloader_templates order by template_id asc";
				$template_rslt=mysql_to_mysqli($template_stmt, $link);
				if (mysqli_num_rows($template_rslt)>0) {
					echo "<option value='' selected>--"._QXZ("Select custom template")."--</option>";
					while ($row=mysqli_fetch_array($template_rslt)) {
						echo "<option value='$row[template_id]'>$row[template_id] - $row[template_name]</option>";
					}
				} else {
					echo "<option value='' selected>--No custom templates defined--</option>";
				}
?>
			</select> <a href='AST_admin_template_maker.php'><font face="arial, helvetica" size=1><?php echo _QXZ("template builder"); ?></font></a><?php echo "$NWB#list_loader-template_id$NWE"; ?><BR><a href='#' onClick="TemplateSpecs()"><font face="arial, helvetica" size=1><?php echo _QXZ("View template info"); ?></font></a></td>
		  <tr>
			<td align=right width="25%"><font face="arial, helvetica" size=2><?php echo _QXZ("Lead Duplicate Check"); ?>: </font></td>
			<td align=left width="75%"><font face="arial, helvetica" size=1><select size=1 name=dupcheck>
			<option selected value="NONE"><?php echo _QXZ("NO DUPLICATE CHECK"); ?></option>
			<option value="DUPLIST"><?php echo _QXZ("CHECK FOR DUPLICATES BY PHONE IN LIST ID"); ?></option>
			<option value="DUPCAMP"><?php echo _QXZ("CHECK FOR DUPLICATES BY PHONE IN ALL CAMPAIGN LISTS"); ?></option>
			<option value="DUPSYS"><?php echo _QXZ("CHECK FOR DUPLICATES BY PHONE IN ENTIRE SYSTEM"); ?></option>
			<option value="DUPTITLEALTPHONELIST"><?php echo _QXZ("CHECK FOR DUPLICATES BY TITLE/ALT-PHONE IN LIST ID"); ?></option>
			<option value="DUPTITLEALTPHONESYS"><?php echo _QXZ("CHECK FOR DUPLICATES BY TITLE/ALT-PHONE IN ENTIRE SYSTEM"); ?></option>
			</select> <?php echo "$NWB#list_loader-duplicate_check$NWE"; ?></td>
		  </tr>
	<tr bgcolor="#D9E6FE">
		<td width='25%' align="right"><font class="standard"><?php echo _QXZ("Status Duplicate Check"); ?>:</font></td>
		<td width='75%'>
		<span id='statuses_display'>
			<select id='dedupe_statuses' name='dedupe_statuses[]' size=5 multiple>
			<option value='--ALL--' selected>--<?php echo _QXZ("ALL DISPOSITIONS"); ?>--</option>
			<?php echo $dedupe_status_select ?>
			</select></font>		
		</span>
		</td>
	</tr>
		  <tr>
			<td align=right width="25%"><font face="arial, helvetica" size=2><?php echo _QXZ("USA-Canada Check"); ?>: </font></td>
			<td align=left width="75%"><font face="arial, helvetica" size=1><select size=1 name=usacan_check>
			<option selected value="NONE"><?php echo _QXZ("NO USACAN VALID CHECK"); ?></option>
			<option value="PREFIX"><?php echo _QXZ("CHECK FOR VALID PREFIX"); ?></option>
			<option value="AREACODE"><?php echo _QXZ("CHECK FOR VALID AREACODE"); ?></option>
			<option value="PREFIX_AREACODE"><?php echo _QXZ("CHECK FOR VALID PREFIX and AREACODE"); ?></option>
			<option value="NANPA"><?php echo _QXZ("CHECK FOR VALID NANPA PREFIX and AREACODE"); ?></option>
			</select></td>
		  </tr>
		  <tr>
			<td align=right width="25%"><font face="arial, helvetica" size=2><?php echo _QXZ("Lead Time Zone Lookup"); ?>: </font></td>
			<td align=left width="75%"><font face="arial, helvetica" size=1><select size=1 name=postalgmt>
			<option selected value="AREA"><?php echo _QXZ("COUNTRY CODE AND AREA CODE ONLY"); ?></option>
			<option value="POSTAL"><?php echo _QXZ("POSTAL CODE FIRST"); ?></option>
			<option value="TZCODE"><?php echo _QXZ("OWNER TIME ZONE CODE FIRST"); ?></option>
			<option value="NANPA"><?php echo _QXZ("NANPA AREACODE PREFIX FIRST"); ?></option>
			</select></td>
		  </tr>
		<tr>
			<td align=center colspan=2><input type=submit value="<?php echo _QXZ("SUBMIT"); ?>" name='submit_file'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=button onClick="javascript:document.location='admin_listloader_fourth_gen.php'" value="<?php echo _QXZ("START OVER"); ?>" name='reload_page'></td>
		  </tr>
		  <tr><td align=left><font size=1> &nbsp; &nbsp; &nbsp; &nbsp; <a href="admin.php?ADD=100" target="_parent"><?php echo _QXZ("BACK TO ADMIN"); ?></a> &nbsp; &nbsp; &nbsp; &nbsp; <a href="./admin_listloader_third_gen.php"><?php echo _QXZ("Old Lead Loader"); ?></a> &nbsp; &nbsp; </font></td><td align=right><font size=1><?php echo _QXZ("LIST LOADER 4th Gen"); ?>- &nbsp; &nbsp; <?php echo _QXZ("VERSION"); ?>: <?php echo $version ?> &nbsp; &nbsp; <?php echo _QXZ("BUILD"); ?>: <?php echo $build ?> &nbsp; &nbsp; </td></tr>
		</table>
		<?php 

		}
	}
else
	{
	?>
	<table align=center width="700" border=0 cellpadding=5 cellspacing=0 bgcolor=#D9E6FE>
	<tr>
	<td align=right width="35%"><B><font face="arial, helvetica" size=2><?php echo _QXZ("Lead file"); ?>:</font></B></td>
	<td align=left width="75%"><font face="arial, helvetica" size=2><?php echo $leadfile_name ?></font></td>
	</tr>
	<tr>
	<td align=right width="35%"><B><font face="arial, helvetica" size=2><?php echo _QXZ("List ID Override"); ?>:</font></B></td>
	<td align=left width="75%"><font face="arial, helvetica" size=2><?php echo $list_id_override ?></font></td>
	</tr>
	<tr>
	<td align=right width="35%"><B><font face="arial, helvetica" size=2><?php echo _QXZ("Phone Code Override"); ?>:</font></B></td>
	<td align=left width="75%"><font face="arial, helvetica" size=2><?php echo $phone_code_override ?></font></td>
	</tr>
	<tr>
	<td align=right width="35%"><B><font face="arial, helvetica" size=2><?php echo _QXZ("USA-Canada Check"); ?>:</font></B></td>
	<td align=left width="75%"><font face="arial, helvetica" size=2><?php echo $usacan_check ?></font></td>
	</tr>
	<tr>
	<td align=right width="35%"><B><font face="arial, helvetica" size=2><?php echo _QXZ("Lead Duplicate Check"); ?>:</font></B></td>
	<td align=left width="75%"><font face="arial, helvetica" size=2><?php echo $dupcheck ?></font></td>
	</tr>
	<tr>
	<td align=right width="35%"><B><font face="arial, helvetica" size=2><?php echo _QXZ("Lead Time Zone Lookup"); ?>:</font></B></td>
	<td align=left width="75%"><font face="arial, helvetica" size=2><?php echo $postalgmt ?></font></td>
	</tr>

	<tr>
	<td align=center colspan=2><B><font face="arial, helvetica" size=2>
	<form action=<?php echo $PHP_SELF ?> method=get onSubmit="ParseFileName()" enctype="multipart/form-data">
	<input type=hidden name='leadfile_name' value="<?php echo $leadfile_name ?>">
	<input type=hidden name='DB' value="<?php echo $DB ?>">
	<a href="admin_listloader_fourth_gen.php"><?php echo _QXZ("Load Another Lead File"); ?></a> &nbsp; &nbsp; &nbsp; &nbsp;</font></B> <font size=1><?php echo _QXZ("VERSION"); ?>: <?php echo $version ?> &nbsp; &nbsp; <?php echo _QXZ("BUILD"); ?>: <?php echo $build ?>
	</font></td>
	</tr></table>
	<BR><BR><BR><BR>
	<?php
	}



##### BEGIN custom fields submission #####
if ($OK_to_process) 
	{
	print "<script language='JavaScript1.2'>document.forms[0].leadfile.disabled=true;document.forms[0].list_id_override.disabled=true;document.forms[0].phone_code_override.disabled=true; document.forms[0].submit_file.disabled=true; document.forms[0].reload_page.disabled=true;</script>";
	flush();
	$total=0; $good=0; $bad=0; $dup=0; $post=0; $phone_list='';

	$file=fopen("$lead_file", "r");
	if ($webroot_writable > 0)
		{
		$stmt_file=fopen("listloader_stmts.txt", "w");
		}
	$buffer=fgets($file, 4096);
	$tab_count=substr_count($buffer, "\t");
	$pipe_count=substr_count($buffer, "|");

	if ($tab_count>$pipe_count) {$delimiter="\t";  $delim_name="tab";} else {$delimiter="|";  $delim_name="pipe";}
	$field_check=explode($delimiter, $buffer);

	if (count($field_check)>=2) 
		{
		flush();
		$file=fopen("$lead_file", "r");
		print "<center><font face='arial, helvetica' size=3 color='#009900'><B>"._QXZ("Processing file")."...\n";

		if (count($dedupe_statuses)>0) {
			$statuses_clause=" and status in (";
			$status_dedupe_str="";
			for($ds=0; $ds<count($dedupe_statuses); $ds++) {
				$statuses_clause.="'$dedupe_statuses[$ds]',";
				$status_dedupe_str.="$dedupe_statuses[$ds], ";
				if (preg_match('/\-\-ALL\-\-/', $dedupe_statuses[$ds])) {
					$statuses_clause="";
					$status_dedupe_str="";
					break;
				}
			}
			$statuses_clause=preg_replace('/,$/', "", $statuses_clause);
			$status_dedupe_str=preg_replace('/,\s$/', "", $status_dedupe_str);
			if ($statuses_clause!="") {$statuses_clause.=")";}
		} 

		if (strlen($list_id_override)>0) 
			{
			print "<BR><BR>"._QXZ("LIST ID OVERRIDE FOR THIS FILE").": $list_id_override<BR><BR>";
			}

		if (strlen($phone_code_override)>0) 
			{
			print "<BR><BR>"._QXZ("PHONE CODE OVERRIDE FOR THIS FILE").": $phone_code_override<BR><BR>";
			}
		if (strlen($status_dedupe_str)>0) 
			{
			print "<BR>"._QXZ("OMITTING DUPLICATES AGAINST FOLLOWING STATUSES ONLY").": $status_dedupe_str<BR>\n";
			}

		if ($custom_fields_enabled > 0)
			{
			$tablecount_to_print=0;
			$fieldscount_to_print=0;
			$fields_to_print=0;

			$stmt="SHOW TABLES LIKE \"custom_$list_id_override\";";
			if ($DB>0) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
			$tablecount_to_print = mysqli_num_rows($rslt);

			if ($tablecount_to_print > 0) 
				{
				$stmt="SELECT count(*) from vicidial_lists_fields where list_id='$list_id_override';";
				if ($DB>0) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
				$fieldscount_to_print = mysqli_num_rows($rslt);

				if ($fieldscount_to_print > 0) 
					{
					$stmt="SELECT field_label,field_type from vicidial_lists_fields where list_id='$list_id_override' order by field_rank,field_order,field_label;";
					if ($DB>0) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
					$fields_to_print = mysqli_num_rows($rslt);
					$fields_list='';
					$o=0;
					while ($fields_to_print > $o) 
						{
						$rowx=mysqli_fetch_row($rslt);
						$A_field_label[$o] =	$rowx[0];
						$A_field_type[$o] =		$rowx[1];
						$A_field_value[$o] =	'';
						$o++;
						}
					}
				}
			}

		while (!feof($file)) 
			{
			$record++;
			$buffer=rtrim(fgets($file, 4096));
			$buffer=stripslashes($buffer);

			if (strlen($buffer)>0) 
				{
				$row=explode($delimiter, preg_replace('/[\'\"]/i', '', $buffer));

				$pulldate=date("Y-m-d H:i:s");
				$entry_date =			"$pulldate";
				$modify_date =			"";
				$status =				"NEW";
				$user ="";
				$vendor_lead_code =		$row[$vendor_lead_code_field];
				$source_code =			$row[$source_id_field];
				$source_id=$source_code;
				$list_id =				$row[$list_id_field];
				$gmt_offset =			'0';
				$called_since_last_reset='N';
				$phone_code =			preg_replace('/[^0-9]/i', '', $row[$phone_code_field]);
				$phone_number =			preg_replace('/[^0-9]/i', '', $row[$phone_number_field]);
				$title =				$row[$title_field];
				$first_name =			$row[$first_name_field];
				$middle_initial =		$row[$middle_initial_field];
				$last_name =			$row[$last_name_field];
				$address1 =				$row[$address1_field];
				$address2 =				$row[$address2_field];
				$address3 =				$row[$address3_field];
				$city =$row[$city_field];
				$state =				$row[$state_field];
				$province =				$row[$province_field];
				$postal_code =			$row[$postal_code_field];
				$country_code =			$row[$country_code_field];
				$gender =				$row[$gender_field];
				$date_of_birth =		$row[$date_of_birth_field];
				$alt_phone =			preg_replace('/[^0-9]/i', '', $row[$alt_phone_field]);
				$email =				$row[$email_field];
				$security_phrase =		$row[$security_phrase_field];
				$comments =				trim($row[$comments_field]);
				$rank =					$row[$rank_field];
				$owner =				$row[$owner_field];
				
				# replace ' " ` \ ; with nothing
				$vendor_lead_code =		preg_replace("/$field_regx/i", "", $vendor_lead_code);
				$source_code =			preg_replace("/$field_regx/i", "", $source_code);
				$source_id = 			preg_replace("/$field_regx/i", "", $source_id);
				$list_id =				preg_replace("/$field_regx/i", "", $list_id);
				$phone_code =			preg_replace("/$field_regx/i", "", $phone_code);
				$phone_number =			preg_replace("/$field_regx/i", "", $phone_number);
				$title =				preg_replace("/$field_regx/i", "", $title);
				$first_name =			preg_replace("/$field_regx/i", "", $first_name);
				$middle_initial =		preg_replace("/$field_regx/i", "", $middle_initial);
				$last_name =			preg_replace("/$field_regx/i", "", $last_name);
				$address1 =				preg_replace("/$field_regx/i", "", $address1);
				$address2 =				preg_replace("/$field_regx/i", "", $address2);
				$address3 =				preg_replace("/$field_regx/i", "", $address3);
				$city =					preg_replace("/$field_regx/i", "", $city);
				$state =				preg_replace("/$field_regx/i", "", $state);
				$province =				preg_replace("/$field_regx/i", "", $province);
				$postal_code =			preg_replace("/$field_regx/i", "", $postal_code);
				$country_code =			preg_replace("/$field_regx/i", "", $country_code);
				$gender =				preg_replace("/$field_regx/i", "", $gender);
				$date_of_birth =		preg_replace("/$field_regx/i", "", $date_of_birth);
				$alt_phone =			preg_replace("/$field_regx/i", "", $alt_phone);
				$email =				preg_replace("/$field_regx/i", "", $email);
				$security_phrase =		preg_replace("/$field_regx/i", "", $security_phrase);
				$comments =				preg_replace("/$field_regx/i", "", $comments);
				$rank =					preg_replace("/$field_regx/i", "", $rank);
				$owner =				preg_replace("/$field_regx/i", "", $owner);
				
				$USarea = 			substr($phone_number, 0, 3);
				$USprefix = 		substr($phone_number, 3, 3);

				if (strlen($list_id_override)>0) 
					{
				#	print "<BR><BR>LIST ID OVERRIDE FOR THIS FILE: $list_id_override<BR><BR>";
					$list_id = $list_id_override;
					}
				if (strlen($phone_code_override)>0) 
					{
					$phone_code = $phone_code_override;
					}

				##### BEGIN custom fields columns list ###
				$custom_SQL='';
				if ($custom_fields_enabled > 0)
					{
					if ($tablecount_to_print > 0) 
						{
						if ($fieldscount_to_print > 0)
							{
							$o=0;
							while ($fields_to_print > $o) 
								{
								$A_field_value[$o] =	'';
								$field_name_id = $A_field_label[$o] . "_field";

							#	if ($DB>0) {echo "$A_field_label[$o]|$A_field_type[$o]\n";}

								if ( ($A_field_type[$o]!='DISPLAY') and ($A_field_type[$o]!='SCRIPT') )
									{
									if (!preg_match("/\|$A_field_label[$o]\|/",$vicidial_list_fields))
										{
										if (isset($_GET["$field_name_id"]))				{$form_field_value=$_GET["$field_name_id"];}
											elseif (isset($_POST["$field_name_id"]))	{$form_field_value=$_POST["$field_name_id"];}

										if ($form_field_value >= 0)
											{
											$A_field_value[$o] =	$row[$form_field_value];
											# replace ' " ` \ ; with nothing
											$A_field_value[$o] =	preg_replace("/$field_regx/i", "", $A_field_value[$o]);

											$custom_SQL .= "$A_field_label[$o]='$A_field_value[$o]',";
											}
										}
									}
								$o++;
								}
							}
						}
					}
				##### END custom fields columns list ###

				$custom_SQL = preg_replace("/,$/","",$custom_SQL);


				##### Check for duplicate phone numbers in vicidial_list table for all lists in a campaign #####
				if (preg_match("/DUPCAMP/i",$dupcheck))
					{
					$dup_lead=0;
					$dup_lists='';
					$stmt="select campaign_id from vicidial_lists where list_id='$list_id';";
					$rslt=mysql_to_mysqli($stmt, $link);
					$ci_recs = mysqli_num_rows($rslt);
					if ($ci_recs > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$dup_camp =			$row[0];

						$stmt="select list_id from vicidial_lists where campaign_id='$dup_camp';";
						$rslt=mysql_to_mysqli($stmt, $link);
						$li_recs = mysqli_num_rows($rslt);
						if ($li_recs > 0)
							{
							$L=0;
							while ($li_recs > $L)
								{
								$row=mysqli_fetch_row($rslt);
								$dup_lists .=	"'$row[0]',";
								$L++;
								}
							$dup_lists = preg_replace('/,$/i', '',$dup_lists);

							$stmt="select list_id from vicidial_list where phone_number='$phone_number' and list_id IN($dup_lists) $statuses_clause limit 1;";
							$rslt=mysql_to_mysqli($stmt, $link);
							$pc_recs = mysqli_num_rows($rslt);
							if ($pc_recs > 0)
								{
								$dup_lead=1;
								$row=mysqli_fetch_row($rslt);
								$dup_lead_list =	$row[0];
								}
							if ($dup_lead < 1)
								{
								if (preg_match("/$phone_number$US$list_id/i", $phone_list))
									{$dup_lead++; $dup++;}
								}
							}
						}
					}

				##### Check for duplicate phone numbers in vicidial_list table entire database #####
				if (preg_match("/DUPSYS/i",$dupcheck))
					{
					$dup_lead=0;
					$stmt="select list_id from vicidial_list where phone_number='$phone_number' $statuses_clause;";
					$rslt=mysql_to_mysqli($stmt, $link);
					$pc_recs = mysqli_num_rows($rslt);
					if ($pc_recs > 0)
						{
						$dup_lead=1;
						$row=mysqli_fetch_row($rslt);
						$dup_lead_list =	$row[0];
						}
					if ($dup_lead < 1)
						{
						if (preg_match("/$phone_number$US$list_id/i", $phone_list))
							{$dup_lead++; $dup++;}
						}
					}

				##### Check for duplicate phone numbers in vicidial_list table for one list_id #####
				if (preg_match("/DUPLIST/i",$dupcheck))
					{
					$dup_lead=0;
					$stmt="select count(*) from vicidial_list where phone_number='$phone_number' and list_id='$list_id' $statuses_clause;";
					$rslt=mysql_to_mysqli($stmt, $link);
					$pc_recs = mysqli_num_rows($rslt);
					if ($pc_recs > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$dup_lead =			$row[0];
						$dup_lead_list =	$list_id;
						}
					if ($dup_lead < 1)
						{
						if (preg_match("/$phone_number$US$list_id/i", $phone_list))
							{$dup_lead++; $dup++;}
						}
					}

				##### Check for duplicate title and alt-phone in vicidial_list table for one list_id #####
				if (preg_match("/DUPTITLEALTPHONELIST/i",$dupcheck))
					{
					$dup_lead=0;
					$stmt="select count(*) from vicidial_list where title='$title' and alt_phone='$alt_phone' and list_id='$list_id' $statuses_clause;";
					$rslt=mysql_to_mysqli($stmt, $link);
					$pc_recs = mysqli_num_rows($rslt);
					if ($pc_recs > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$dup_lead =			$row[0];
						$dup_lead_list =	$list_id;
						}
					if ($dup_lead < 1)
						{
						if (preg_match("/$alt_phone$title$US$list_id/i",$phone_list))
							{$dup_lead++; $dup++;}
						}
					}

				##### Check for duplicate phone numbers in vicidial_list table entire database #####
				if (preg_match("/DUPTITLEALTPHONESYS/i",$dupcheck))
					{
					$dup_lead=0;
					$stmt="select list_id from vicidial_list where title='$title' and alt_phone='$alt_phone' $statuses_clause;";
					$rslt=mysql_to_mysqli($stmt, $link);
					$pc_recs = mysqli_num_rows($rslt);
					if ($pc_recs > 0)
						{
						$dup_lead=1;
						$row=mysqli_fetch_row($rslt);
						$dup_lead_list =	$row[0];
						}
					if ($dup_lead < 1)
						{
						if (preg_match("/$alt_phone$title$US$list_id/i",$phone_list))
							{$dup_lead++; $dup++;}
						}
					}

				$valid_number=1;
				$invalid_reason='';
				if ( (strlen($phone_number)<6) || (strlen($phone_number)>16) )
					{
					$valid_number=0;
					$invalid_reason = _QXZ("INVALID PHONE NUMBER LENGTH");
					}
				if ( (preg_match("/PREFIX/",$usacan_check)) and ($valid_number > 0) )
					{
					$USprefix = 	substr($phone_number, 3, 1);
					if ($DB>0) {echo "DEBUG: usacan prefix check - $USprefix|$phone_number\n";}
					if ($USprefix < 2)
						{
						$valid_number=0;
						$invalid_reason = _QXZ("INVALID PHONE NUMBER PREFIX");
						}
					}
				if ( (preg_match("/AREACODE/",$usacan_check)) and ($valid_number > 0) )
					{
					$phone_areacode = substr($phone_number, 0, 3);
					$stmt = "select count(*) from vicidial_phone_codes where areacode='$phone_areacode' and country_code='1';";
					if ($DB>0) {echo "DEBUG: usacan areacode query - $stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
					$row=mysqli_fetch_row($rslt);
					$valid_number=$row[0];
					if ($valid_number < 1)
						{
						$invalid_reason = _QXZ("INVALID PHONE NUMBER AREACODE");
						}
					}
				if ( (preg_match("/NANPA/",$usacan_check)) and ($valid_number > 0) )
					{
					$phone_areacode = substr($phone_number, 0, 3);
					$phone_prefix = substr($phone_number, 3, 3);
					$stmt = "SELECT count(*) from vicidial_nanpa_prefix_codes where areacode='$phone_areacode' and prefix='$phone_prefix';";
					if ($DB>0) {echo "DEBUG: usacan nanpa query - $stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
					$row=mysqli_fetch_row($rslt);
					$valid_number=$row[0];
					if ($valid_number < 1)
						{
						$invalid_reason = _QXZ("INVALID PHONE NUMBER NANPA AREACODE PREFIX");
						}
					}

				if ( ($valid_number>0) and ($dup_lead<1) and ($list_id >= 100 ))
					{
					if (strlen($phone_code)<1) {$phone_code = '1';}

					if (preg_match("/TITLEALTPHONE/i",$dupcheck))
						{$phone_list .= "$alt_phone$title$US$list_id|";}
					else
						{$phone_list .= "$phone_number$US$list_id|";}

					$gmt_offset = lookup_gmt($phone_code,$USarea,$state,$LOCAL_GMT_OFF_STD,$Shour,$Smin,$Ssec,$Smon,$Smday,$Syear,$postalgmt,$postal_code,$owner,$USprefix);

					if (strlen($custom_SQL)>3)
						{
						$stmtZ = "INSERT INTO vicidial_list (lead_id,entry_date,modify_date,status,user,vendor_lead_code,source_id,list_id,gmt_offset_now,called_since_last_reset,phone_code,phone_number,title,first_name,middle_initial,last_name,address1,address2,address3,city,state,province,postal_code,country_code,gender,date_of_birth,alt_phone,email,security_phrase,comments,called_count,last_local_call_time,rank,owner,entry_list_id) values('','$entry_date','$modify_date','$status','$user','$vendor_lead_code','$source_id','$list_id','$gmt_offset','$called_since_last_reset','$phone_code','$phone_number','$title','$first_name','$middle_initial','$last_name','$address1','$address2','$address3','$city','$state','$province','$postal_code','$country_code','$gender','$date_of_birth','$alt_phone','$email','$security_phrase','$comments',0,'2008-01-01 00:00:00','$rank','$owner','$list_id');";
						$rslt=mysql_to_mysqli($stmtZ, $link);
						$affected_rows = mysqli_affected_rows($link);
						$lead_id = mysqli_insert_id($link);
						if ($DB > 0) {echo "<!-- $affected_rows|$lead_id|$stmtZ -->";}
						if ($webroot_writable > 0) 
							{fwrite($stmt_file, $stmtZ."\r\n");}
						$multistmt='';

						$custom_SQL_query = "INSERT INTO custom_$list_id_override SET lead_id='$lead_id',$custom_SQL;";
						$rslt=mysql_to_mysqli($custom_SQL_query, $link);
						$affected_rows = mysqli_affected_rows($link);
						if ($DB > 0) {echo "<!-- $affected_rows|$custom_SQL_query -->";}
						}
					else
						{
						if ($multi_insert_counter > 8) 
							{
							### insert good record into vicidial_list table ###
							$stmtZ = "INSERT INTO vicidial_list (lead_id,entry_date,modify_date,status,user,vendor_lead_code,source_id,list_id,gmt_offset_now,called_since_last_reset,phone_code,phone_number,title,first_name,middle_initial,last_name,address1,address2,address3,city,state,province,postal_code,country_code,gender,date_of_birth,alt_phone,email,security_phrase,comments,called_count,last_local_call_time,rank,owner,entry_list_id) values$multistmt('','$entry_date','$modify_date','$status','$user','$vendor_lead_code','$source_id','$list_id','$gmt_offset','$called_since_last_reset','$phone_code','$phone_number','$title','$first_name','$middle_initial','$last_name','$address1','$address2','$address3','$city','$state','$province','$postal_code','$country_code','$gender','$date_of_birth','$alt_phone','$email','$security_phrase','$comments',0,'2008-01-01 00:00:00','$rank','$owner','0');";
							$rslt=mysql_to_mysqli($stmtZ, $link);
							if ($webroot_writable > 0) 
								{fwrite($stmt_file, $stmtZ."\r\n");}
							$multistmt='';
							$multi_insert_counter=0;
							}
						else
							{
							$multistmt .= "('','$entry_date','$modify_date','$status','$user','$vendor_lead_code','$source_id','$list_id','$gmt_offset','$called_since_last_reset','$phone_code','$phone_number','$title','$first_name','$middle_initial','$last_name','$address1','$address2','$address3','$city','$state','$province','$postal_code','$country_code','$gender','$date_of_birth','$alt_phone','$email','$security_phrase','$comments',0,'2008-01-01 00:00:00','$rank','$owner','0'),";
							$multi_insert_counter++;
							}
						}
					$good++;
					}
				else
					{
					if ($bad < 1000000)
						{
						if ( $list_id < 100 )
							{
							print "<BR></b><font size=1 color=red>"._QXZ("record")." $total "._QXZ("BAD- PHONE").": $phone_number "._QXZ("ROW").": |$row[0]| "._QXZ("INVALID LIST ID")."</font><b>\n";
							}
						else
							{
							if ($valid_number < 1)
								{
								print "<BR></b><font size=1 color=red>"._QXZ("record")." $total "._QXZ("BAD- PHONE").": $phone_number "._QXZ("ROW").": |$row[0]| "._QXZ("INV").": $phone_number</font><b>\n";
								}
							else
								{
								print "<BR></b><font size=1 color=red>"._QXZ("record")." $total "._QXZ("BAD- PHONE").": $phone_number "._QXZ("ROW").": |$row[0]| "._QXZ("DUP").": $dup_lead  $dup_lead_list</font><b>\n";
								}
							}
						}
					$bad++;
					}
				$total++;
				if ($total%100==0) 
					{
					print "<script language='JavaScript1.2'>ShowProgress($good, $bad, $total, $dup, $inv, $post)</script>";
					usleep(1000);
					flush();
					}
				}
			}
		if ($multi_insert_counter!=0) 
			{
			$stmtZ = "INSERT INTO vicidial_list (lead_id,entry_date,modify_date,status,user,vendor_lead_code,source_id,list_id,gmt_offset_now,called_since_last_reset,phone_code,phone_number,title,first_name,middle_initial,last_name,address1,address2,address3,city,state,province,postal_code,country_code,gender,date_of_birth,alt_phone,email,security_phrase,comments,called_count,last_local_call_time,rank,owner,entry_list_id) values".substr($multistmt, 0, -1).";";
			mysql_to_mysqli($stmtZ, $link);
			if ($webroot_writable > 0) 
				{fwrite($stmt_file, $stmtZ."\r\n");}
			}

		### LOG INSERTION Admin Log Table ###
		$stmt="INSERT INTO vicidial_admin_log set event_date='$NOW_TIME', user='$PHP_AUTH_USER', ip_address='$ip', event_section='LISTS', event_type='LOAD', record_id='$list_id_override', event_code='ADMIN LOAD LIST CUSTOM', event_sql='', event_notes='File Name: $leadfile_name, GOOD: $good, BAD: $bad, TOTAL: $total, DEBUG: dedupe_statuses:$dedupe_statuses[0]| dedupe_statuses_override:$dedupe_statuses_override| dupcheck:$dupcheck| lead_file:$lead_file| list_id_override:$list_id_override| phone_code_override:$phone_code_override| postalgmt:$postalgmt| template_id:$template_id| usacan_check:$usacan_check|';";
		if ($DB) {echo "|$stmt|\n";}
		$rslt=mysql_to_mysqli($stmt, $link);

		print "<BR><BR>"._QXZ("Done")."</B> "._QXZ("GOOD").": $good &nbsp; &nbsp; &nbsp; "._QXZ("BAD").": $bad &nbsp; &nbsp; &nbsp; "._QXZ("TOTAL").": $total</font></center>";
		} 
	else 
		{
		print "<center><font face='arial, helvetica' size=3 color='#990000'><B>"._QXZ("ERROR").": "._QXZ("The file does not have the required number of fields to process it").".</B></font></center>";
		}
	}
##### END custom fields submission #####

if (($leadfile) && ($LF_path))
	{
	$total=0; $good=0; $bad=0; $dup=0; $post=0; $phone_list='';

	### LOG INSERTION Admin Log Table ###
	$stmt="INSERT INTO vicidial_admin_log set event_date='$NOW_TIME', user='$PHP_AUTH_USER', ip_address='$ip', event_section='LISTS', event_type='LOAD', record_id='$list_id_override', event_code='ADMIN LOAD LIST', event_sql='', event_notes='File Name: $leadfile_name, DEBUG: dedupe_statuses:$dedupe_statuses[0]| dedupe_statuses_override:$dedupe_statuses_override| dupcheck:$dupcheck| lead_file:$lead_file| list_id_override:$list_id_override| phone_code_override:$phone_code_override| postalgmt:$postalgmt| template_id:$template_id| usacan_check:$usacan_check|';";
	if ($DB) {echo "|$stmt|\n";}
	$rslt=mysql_to_mysqli($stmt, $link);

	##### BEGIN process TEMPLATE file layout #####
	if ($file_layout=="template"  && $template_id) 
		{

		$template_stmt="select * from vicidial_custom_leadloader_templates where template_id='$template_id'";
		$template_rslt=mysql_to_mysqli($template_stmt, $link);
		if (mysqli_num_rows($template_rslt)==0) 
			{
			echo _QXZ("Error - template no longer exists"); die;
			} 
		else 
			{
			$template_row=mysqli_fetch_array($template_rslt);
			$template_id=$template_row["template_id"];
			$template_name=$template_row["template_name"];
			$template_description=$template_row["template_description"];
			# Added 2/9/2015 to allow dropdown to override template
			if (!$master_list_override) {
				$list_id_override=$template_row["list_id"];
			}
			$standard_variables=$template_row["standard_variables"];
			$custom_table=$template_row["custom_table"];
			$custom_variables=$template_row["custom_variables"];
			$template_statuses=$template_row["template_statuses"];
			if (strlen($template_statuses)>0) {
				$template_statuses=preg_replace('/\|/', "','", $template_statuses);
				$statuses_clause=" and status in ('$template_statuses') ";
			}
			$standard_fields_ary=explode("|", $standard_variables);
			for ($i=0; $i<count($standard_fields_ary); $i++) 
				{
				if (strlen($standard_fields_ary[$i])>0) 
					{
					$fieldno_ary=explode(",", $standard_fields_ary[$i]);
					$varname=$fieldno_ary[0]."_field";
					$$varname=$fieldno_ary[1];
					} 
				}
			$custom_fields_ary=explode("|", $custom_variables);
			if (count($custom_fields_ary)>0 && strlen($custom_table)>0) 
				{
				$custom_ins_stmt="INSERT INTO $custom_table(";
				for ($i=0; $i<count($custom_fields_ary); $i++)
					{
					if (strlen($custom_fields_ary[$i])>0) 
						{
						$fieldno_ary=explode(",", $custom_fields_ary[$i]);
						$custom_ins_stmt.="$fieldno_ary[0],";
						$varname=$fieldno_ary[0]."_field";
						$$varname=$fieldno_ary[1];
						} 
					}
				$custom_ins_stmt=substr($custom_ins_stmt, 0, -1).") VALUES (";
				}
			}

		print "<script language='JavaScript1.2'>document.forms[0].leadfile.disabled=true; document.forms[0].submit_file.disabled=true; document.forms[0].reload_page.disabled=true;</script>";
		flush();

		$delim_set=0;
		# csv xls xlsx ods sxc conversion
		if (preg_match("/\.csv$|\.xls$|\.xlsx$|\.ods$|\.sxc$/i", $leadfile_name)) 
			{
			$leadfile_name = preg_replace('/[^-\.\_0-9a-zA-Z]/','_',$leadfile_name);
			copy($LF_path, "/tmp/$leadfile_name");
			$new_filename = preg_replace("/\.csv$|\.xls$|\.xlsx$|\.ods$|\.sxc$/i", '.txt', $leadfile_name);
			$convert_command = "$WeBServeRRooT/$admin_web_directory/sheet2tab.pl /tmp/$leadfile_name /tmp/$new_filename";
			passthru("$convert_command");
			$lead_file = "/tmp/$new_filename";
			if ($DB > 0) {echo "|$convert_command|";}

			if (preg_match("/\.csv$/i", $leadfile_name)) {$delim_name="CSV: "._QXZ("Comma Separated Values");}
			if (preg_match("/\.xls$/i", $leadfile_name)) {$delim_name="XLS: MS Excel 2000-XP";}
			if (preg_match("/\.xlsx$/i", $leadfile_name)) {$delim_name="XLSX: MS Excel 2007+";}
			if (preg_match("/\.ods$/i", $leadfile_name)) {$delim_name="ODS: OpenOffice.org OpenDocument "._QXZ("Spreadsheet");}
			if (preg_match("/\.sxc$/i", $leadfile_name)) {$delim_name="SXC: OpenOffice.org "._QXZ("First Spreadsheet");}
			$delim_set=1;
			}
		else
			{
			copy($LF_path, "/tmp/vicidial_temp_file.txt");
			$lead_file = "/tmp/vicidial_temp_file.txt";
			}
		$file=fopen("$lead_file", "r");
		if ($webroot_writable > 0)
			{$stmt_file=fopen("$WeBServeRRooT/$admin_web_directory/listloader_stmts.txt", "w");}

		$buffer=fgets($file, 4096);
		$tab_count=substr_count($buffer, "\t");
		$pipe_count=substr_count($buffer, "|");

		if ($delim_set < 1)
			{
			if ($tab_count>$pipe_count)
				{$delim_name=_QXZ("tab-delimited");} 
			else 
				{$delim_name=_QXZ("pipe-delimited");}
			} 
		if ($tab_count>$pipe_count)
			{$delimiter="\t";}
		else 
			{$delimiter="|";}

		$field_check=explode($delimiter, $buffer);

		if (count($field_check)>=2) 
			{
			flush();
			$file=fopen("$lead_file", "r");
			$total=0; $good=0; $bad=0; $dup=0; $post=0; $phone_list='';
			print "<center><font face='arial, helvetica' size=3 color='#009900'><B>"._QXZ("Processing")." $delim_name "._QXZ("file using template")." $template_id... ($tab_count|$pipe_count)\n";
			if (strlen($list_id_override)>0) 
				{
				print "<BR>"._QXZ("LIST ID OVERRIDE FOR THIS FILE").": $list_id_override<BR>";
				}
			if (strlen($phone_code_override)>0) 
				{
				print "<BR>"._QXZ("PHONE CODE OVERRIDE FOR THIS FILE").": $phone_code_override<BR>\n";
				}
			if (strlen($template_statuses)>0) 
				{
				print "<BR>"._QXZ("OMITTING DUPLICATES AGAINST FOLLOWING STATUSES ONLY").": ".preg_replace('/\'/', '', $template_statuses)."<BR>\n";
				}
			while (!feof($file)) 
				{
				$record++;
				$buffer=rtrim(fgets($file, 4096));
				$buffer=stripslashes($buffer);

				if (strlen($buffer)>0) 
					{
					$row=explode($delimiter, preg_replace('/[\'\"]/i', '', $buffer));
					$custom_fields_row=$row;
					$pulldate=date("Y-m-d H:i:s");
					$entry_date =			"$pulldate";
					$modify_date =			"";
					$status =				"NEW";
					$user ="";
					$vendor_lead_code =		$row[$vendor_lead_code_field];
					$source_code =			$row[$source_id_field];
					$source_id=$source_code;
					$list_id =				$row[$list_id_field];
					# Added 2/9/2015 to allow dropdown to override template
					if ($master_list_override) {
						$list_id=$list_id_override;
					}
					$gmt_offset =			'0';
					$called_since_last_reset='N';
					$phone_code =			preg_replace('/[^0-9]/i', '', $row[$phone_code_field]);
					$phone_number =			preg_replace('/[^0-9]/i', '', $row[$phone_number_field]);
					$title =				$row[$title_field];
					$first_name =			$row[$first_name_field];
					$middle_initial =		$row[$middle_initial_field];
					$last_name =			$row[$last_name_field];
					$address1 =				$row[$address1_field];
					$address2 =				$row[$address2_field];
					$address3 =				$row[$address3_field];
					$city =$row[$city_field];
					$state =				$row[$state_field];
					$province =				$row[$province_field];
					$postal_code =			$row[$postal_code_field];
					$country_code =			$row[$country_code_field];
					$gender =				$row[$gender_field];
					$date_of_birth =		$row[$date_of_birth_field];
					$alt_phone =			preg_replace('/[^0-9]/i', '', $row[$alt_phone_field]);
					$email =				$row[$email_field];
					$security_phrase =		$row[$security_phrase_field];
					$comments =				trim($row[$comments_field]);
					$rank =					$row[$rank_field];
					$owner =				$row[$owner_field];
					
					# replace ' " ` \ ; with nothing
					$vendor_lead_code =		preg_replace("/$field_regx/i", "", $vendor_lead_code);
					$source_code =			preg_replace("/$field_regx/i", "", $source_code);
					$source_id = 			preg_replace("/$field_regx/i", "", $source_id);
					$list_id =				preg_replace("/$field_regx/i", "", $list_id);
					$phone_code =			preg_replace("/$field_regx/i", "", $phone_code);
					$phone_number =			preg_replace("/$field_regx/i", "", $phone_number);
					$title =				preg_replace("/$field_regx/i", "", $title);
					$first_name =			preg_replace("/$field_regx/i", "", $first_name);
					$middle_initial =		preg_replace("/$field_regx/i", "", $middle_initial);
					$last_name =			preg_replace("/$field_regx/i", "", $last_name);
					$address1 =				preg_replace("/$field_regx/i", "", $address1);
					$address2 =				preg_replace("/$field_regx/i", "", $address2);
					$address3 =				preg_replace("/$field_regx/i", "", $address3);
					$city =					preg_replace("/$field_regx/i", "", $city);
					$state =				preg_replace("/$field_regx/i", "", $state);
					$province =				preg_replace("/$field_regx/i", "", $province);
					$postal_code =			preg_replace("/$field_regx/i", "", $postal_code);
					$country_code =			preg_replace("/$field_regx/i", "", $country_code);
					$gender =				preg_replace("/$field_regx/i", "", $gender);
					$date_of_birth =		preg_replace("/$field_regx/i", "", $date_of_birth);
					$alt_phone =			preg_replace("/$field_regx/i", "", $alt_phone);
					$email =				preg_replace("/$field_regx/i", "", $email);
					$security_phrase =		preg_replace("/$field_regx/i", "", $security_phrase);
					$comments =				preg_replace("/$field_regx/i", "", $comments);
					$rank =					preg_replace("/$field_regx/i", "", $rank);
					$owner =				preg_replace("/$field_regx/i", "", $owner);
					
					$USarea = 			substr($phone_number, 0, 3);
					$USprefix = 		substr($phone_number, 3, 3);

					if (strlen($list_id_override)>0) 
						{
						$list_id = $list_id_override;
						}
					if (strlen($phone_code_override)>0) 
						{
						$phone_code = $phone_code_override;
						}

					##### Check for duplicate phone numbers in vicidial_list table for all lists in a campaign #####
					if (preg_match("/DUPCAMP/i",$dupcheck))
						{
							$dup_lead=0;
							$dup_lists='';
						$stmt="select campaign_id from vicidial_lists where list_id='$list_id';";
						$rslt=mysql_to_mysqli($stmt, $link);
						$ci_recs = mysqli_num_rows($rslt);
						if ($ci_recs > 0)
							{
							$row=mysqli_fetch_row($rslt);
							$dup_camp =			$row[0];

							$stmt="select list_id from vicidial_lists where campaign_id='$dup_camp';";
							$rslt=mysql_to_mysqli($stmt, $link);
							$li_recs = mysqli_num_rows($rslt);
							if ($li_recs > 0)
								{
								$L=0;
								while ($li_recs > $L)
									{
									$row=mysqli_fetch_row($rslt);
									$dup_lists .=	"'$row[0]',";
									$L++;
									}
								$dup_lists = preg_replace('/,$/i', '',$dup_lists);

								$stmt="select list_id from vicidial_list where phone_number='$phone_number' and list_id IN($dup_lists) $statuses_clause limit 1;";
								$rslt=mysql_to_mysqli($stmt, $link);
								$pc_recs = mysqli_num_rows($rslt);
								if ($pc_recs > 0)
									{
									$dup_lead=1;
									$row=mysqli_fetch_row($rslt);
									$dup_lead_list =	$row[0];
									}
								if ($dup_lead < 1)
									{
									if (preg_match("/$phone_number$US$list_id/i", $phone_list))
										{$dup_lead++; $dup++;}
									}
								}
							}
						}

					##### Check for duplicate phone numbers in vicidial_list table entire database #####
					if (preg_match("/DUPSYS/i",$dupcheck))
						{
						$dup_lead=0;
						$stmt="select list_id from vicidial_list where phone_number='$phone_number' $statuses_clause;";
						$rslt=mysql_to_mysqli($stmt, $link);
						$pc_recs = mysqli_num_rows($rslt);
						if ($pc_recs > 0)
							{
							$dup_lead=1;
							$row=mysqli_fetch_row($rslt);
							$dup_lead_list =	$row[0];
							}
						if ($dup_lead < 1)
							{
							if (preg_match("/$phone_number$US$list_id/i", $phone_list))
								{$dup_lead++; $dup++;}
							}
						}

					##### Check for duplicate phone numbers in vicidial_list table for one list_id #####
					if (preg_match("/DUPLIST/i",$dupcheck))
						{
						$dup_lead=0;
						$stmt="select count(*) from vicidial_list where phone_number='$phone_number' and list_id='$list_id' $statuses_clause;";
						$rslt=mysql_to_mysqli($stmt, $link);
						$pc_recs = mysqli_num_rows($rslt);
						if ($pc_recs > 0)
							{
							$row=mysqli_fetch_row($rslt);
							$dup_lead =			$row[0];
							}
						if ($dup_lead < 1)
							{
							if (preg_match("/$phone_number$US$list_id/i", $phone_list))
								{$dup_lead++; $dup++;}
							}
						}

					##### Check for duplicate title and alt-phone in vicidial_list table for one list_id #####
					if (preg_match("/DUPTITLEALTPHONELIST/i",$dupcheck))
						{
						$dup_lead=0;
						$stmt="select count(*) from vicidial_list where title='$title' and alt_phone='$alt_phone' and list_id='$list_id' $statuses_clause;";
						$rslt=mysql_to_mysqli($stmt, $link);
						$pc_recs = mysqli_num_rows($rslt);
						if ($pc_recs > 0)
							{
							$row=mysqli_fetch_row($rslt);
							$dup_lead =			$row[0];
							$dup_lead_list =	$list_id;
							}
						if ($dup_lead < 1)
							{
							if (preg_match("/$alt_phone$title$US$list_id/i",$phone_list))
								{$dup_lead++; $dup++;}
							}
						}

					##### Check for duplicate phone numbers in vicidial_list table entire database #####
					if (preg_match("/DUPTITLEALTPHONESYS/i",$dupcheck))
						{
						$dup_lead=0;
						$stmt="select list_id from vicidial_list where title='$title' and alt_phone='$alt_phone' $statuses_clause;";
						$rslt=mysql_to_mysqli($stmt, $link);
						$pc_recs = mysqli_num_rows($rslt);
						if ($pc_recs > 0)
							{
							$dup_lead=1;
							$row=mysqli_fetch_row($rslt);
							$dup_lead_list =	$row[0];
							}
						if ($dup_lead < 1)
							{
							if (preg_match("/$alt_phone$title$US$list_id/i",$phone_list))
								{$dup_lead++; $dup++;}
							}
						}

					$valid_number=1;
					$invalid_reason='';
					if ( (strlen($phone_number)<6) || (strlen($phone_number)>16) )
						{
						$valid_number=0;
						$invalid_reason = _QXZ("INVALID PHONE NUMBER LENGTH");
						}
					if ( (preg_match("/PREFIX/",$usacan_check)) and ($valid_number > 0) )
						{
						$USprefix = 	substr($phone_number, 3, 1);
						if ($DB>0) {echo _QXZ("DEBUG: usacan prefix check")." - $USprefix|$phone_number\n";}
						if ($USprefix < 2)
							{
							$valid_number=0;
							$invalid_reason = _QXZ("INVALID PHONE NUMBER PREFIX");
							}
						}
					if ( (preg_match("/AREACODE/",$usacan_check)) and ($valid_number > 0) )
						{
						$phone_areacode = substr($phone_number, 0, 3);
						$stmt = "select count(*) from vicidial_phone_codes where areacode='$phone_areacode' and country_code='1';";
						if ($DB>0) {echo "DEBUG: usacan areacode query - $stmt\n";}
						$rslt=mysql_to_mysqli($stmt, $link);
						$row=mysqli_fetch_row($rslt);
						$valid_number=$row[0];
						if ($valid_number < 1)
							{
							$invalid_reason = _QXZ("INVALID PHONE NUMBER AREACODE");
							}
						}
					if ( (preg_match("/NANPA/",$usacan_check)) and ($valid_number > 0) )
						{
						$phone_areacode = substr($phone_number, 0, 3);
						$phone_prefix = substr($phone_number, 3, 3);
						$stmt = "SELECT count(*) from vicidial_nanpa_prefix_codes where areacode='$phone_areacode' and prefix='$phone_prefix';";
						if ($DB>0) {echo "DEBUG: usacan nanpa query - $stmt\n";}
						$rslt=mysql_to_mysqli($stmt, $link);
						$row=mysqli_fetch_row($rslt);
						$valid_number=$row[0];
						if ($valid_number < 1)
							{
							$invalid_reason = _QXZ("INVALID PHONE NUMBER NANPA AREACODE PREFIX");
							}
						}

					if ( ($valid_number>0) and ($dup_lead<1) and ($list_id >= 100 ))
						{
						if (strlen($phone_code)<1) {$phone_code = '1';}

						if (preg_match("/TITLEALTPHONE/i",$dupcheck))
							{$phone_list .= "$alt_phone$title$US$list_id|";}
						else
							{$phone_list .= "$phone_number$US$list_id|";}

						$gmt_offset = lookup_gmt($phone_code,$USarea,$state,$LOCAL_GMT_OFF_STD,$Shour,$Smin,$Ssec,$Smon,$Smday,$Syear,$postalgmt,$postal_code,$owner,$USprefix);

/*						if ($multi_insert_counter > 8) 
#							{
							### insert good deal into pending_transactions table ###
							$stmtZ = "INSERT INTO vicidial_list (lead_id,entry_date,modify_date,status,user,vendor_lead_code,source_id,list_id,gmt_offset_now,called_since_last_reset,phone_code,phone_number,title,first_name,middle_initial,last_name,address1,address2,address3,city,state,province,postal_code,country_code,gender,date_of_birth,alt_phone,email,security_phrase,comments,called_count,last_local_call_time,rank,owner,entry_list_id) values$multistmt('','$entry_date','$modify_date','$status','$user','$vendor_lead_code','$source_id','$list_id','$gmt_offset','$called_since_last_reset','$phone_code','$phone_number','$title','$first_name','$middle_initial','$last_name','$address1','$address2','$address3','$city','$state','$province','$postal_code','$country_code','$gender','$date_of_birth','$alt_phone','$email','$security_phrase','$comments',0,'2008-01-01 00:00:00','$rank','$owner','0');";
							$rslt=mysql_to_mysqli($stmtZ, $link);
							if ($webroot_writable > 0) 
								{fwrite($stmt_file, $stmtZ."\r\n");}
							$multistmt=''; */
							$multi_insert_counter=0;
							$stmtZ = "INSERT INTO vicidial_list (lead_id,entry_date,modify_date,status,user,vendor_lead_code,source_id,list_id,gmt_offset_now,called_since_last_reset,phone_code,phone_number,title,first_name,middle_initial,last_name,address1,address2,address3,city,state,province,postal_code,country_code,gender,date_of_birth,alt_phone,email,security_phrase,comments,called_count,last_local_call_time,rank,owner,entry_list_id) values('','$entry_date','$modify_date','$status','$user','$vendor_lead_code','$source_id','$list_id','$gmt_offset','$called_since_last_reset','$phone_code','$phone_number','$title','$first_name','$middle_initial','$last_name','$address1','$address2','$address3','$city','$state','$province','$postal_code','$country_code','$gender','$date_of_birth','$alt_phone','$email','$security_phrase','$comments',0,'2008-01-01 00:00:00','$rank','$owner','$list_id');";
							$rslt=mysql_to_mysqli($stmtZ, $link);
							$affected_rows = mysqli_affected_rows($link);
							$lead_id = mysqli_insert_id($link);
							if ($DB > 0) {echo "<!-- $affected_rows|$lead_id|$stmtZ -->";}
							if ($webroot_writable > 0) 
								{fwrite($stmt_file, $stmtZ."\r\n");}
							$multistmt='';

							#$custom_SQL_query = "INSERT INTO custom_$list_id_override SET lead_id='$lead_id',$custom_SQL;";
							#$rslt=mysql_to_mysqli($custom_SQL_query, $link);
							#$affected_rows = mysqli_affected_rows($link);

							$custom_ins_stmt="INSERT INTO $custom_table(lead_id";
							$custom_SQL_values="";
							for ($q=0; $q<count($custom_fields_ary); $q++) 
								{
								if (strlen($custom_fields_ary[$q])>0) 
									{
									$fieldno_ary=explode(",", $custom_fields_ary[$q]);
									$varname=$fieldno_ary[0]."_field";
									$$varname=$fieldno_ary[1];
									$custom_ins_stmt.=",$fieldno_ary[0]";
									$custom_SQL_values.=",'".$custom_fields_row[$$varname]."'";
									} 
								}
							$custom_ins_stmt.=") VALUES('$lead_id'$custom_SQL_values)";
							$custom_rslt=mysql_to_mysqli($custom_ins_stmt, $link);
							$affected_rows = mysqli_affected_rows($link);
							echo "<!-- $custom_ins_stmt //-->\n";
							if ($webroot_writable > 0) 
								{fwrite($stmt_file, $custom_ins_stmt."\r\n");}
/*
							} 
						else 
							{
							$multistmt .= "('','$entry_date','$modify_date','$status','$user','$vendor_lead_code','$source_id','$list_id','$gmt_offset','$called_since_last_reset','$phone_code','$phone_number','$title','$first_name','$middle_initial','$last_name','$address1','$address2','$address3','$city','$state','$province','$postal_code','$country_code','$gender','$date_of_birth','$alt_phone','$email','$security_phrase','$comments',0,'2008-01-01 00:00:00','$rank','$owner','0'),";

							$custom_multistmt.="(";
							for ($q=0; $q<count($custom_fields_ary); $q++)
								{
								if (strlen($custom_fields_ary[$q])>0) 
									{
									$custom_fieldno_ary=explode(",", $custom_fields_ary[$q]);
									$varname=$custom_fieldno_ary[0];
									$$varname=$row[$custom_fieldno_ary[1]];
									$custom_multistmt.="'".$$varname."',";
									}
								}
							$custom_multistmt=substr($custom_multistmt, 0, -1)."),";
							$multi_insert_counter++;
							} */
						$good++;
						} 
					else
						{
						if ($bad < 1000000)
							{
							if ( $list_id < 100 )
								{
								print "<BR></b><font size=1 color=red>"._QXZ("record")." $total "._QXZ("BAD- PHONE").": $phone_number "._QXZ("ROW").":|$row[0]| "._QXZ("INVALID LIST ID")."</font><b>\n";
								}
							else
								{
								if ($valid_number < 1)
									{
									print "<BR></b><font size=1 color=red>"._QXZ("record")." $total "._QXZ("BAD- PHONE").": $phone_number "._QXZ("ROW").":|$row[0]| "._QXZ("INV").": $phone_number</font><b>\n";
									}
								else
									{
									print "<BR></b><font size=1 color=red>"._QXZ("record")." $total "._QXZ("BAD- PHONE").": $phone_number "._QXZ("ROW").":|$row[0]| "._QXZ("DUP").": $dup_lead  $dup_lead_list</font><b>\n";
									}
								}
							}
						$bad++;
						}
					$total++;
					if ($total%100==0) 
						{
						print "<script language='JavaScript1.2'>ShowProgress($good, $bad, $total, $dup, $inv, $post)</script>";
						usleep(1000);
						flush();
						}
					}
				}
			if ($multi_insert_counter!=0) 
				{
				$stmtZ = "INSERT INTO vicidial_list (lead_id,entry_date,modify_date,status,user,vendor_lead_code,source_id,list_id,gmt_offset_now,called_since_last_reset,phone_code,phone_number,title,first_name,middle_initial,last_name,address1,address2,address3,city,state,province,postal_code,country_code,gender,date_of_birth,alt_phone,email,security_phrase,comments,called_count,last_local_call_time,rank,owner,entry_list_id) values".substr($multistmt, 0, -1).";";
				mysql_to_mysqli($stmtZ, $link);
				if ($webroot_writable > 0) 
					{fwrite($stmt_file, $stmtZ."\r\n");}

				$custom_ins_stmt="INSERT INTO $custom_table(";
				for ($q=0; $q<count($custom_fields_ary); $q++) 
					{
					if (strlen($custom_fields_ary[$q])>0) 
						{
						$fieldno_ary=explode(",", $custom_fields_ary[$q]);
						$custom_ins_stmt.="$fieldno_ary[0],";
						$varname=$fieldno_ary[0]."_field";
						$$varname=$fieldno_ary[1];
						} 
					}
				$custom_ins_stmt=substr($custom_ins_stmt, 0, -1).") VALUES".substr($custom_multistmt, 0, -1);
				mysql_to_mysqli($custom_ins_stmt, $link);
				if ($webroot_writable > 0) 
					{fwrite($stmt_file, $custom_ins_stmt."\r\n");}
				}
			### LOG INSERTION Admin Log Table ###
			$stmt="INSERT INTO vicidial_admin_log set event_date='$NOW_TIME', user='$PHP_AUTH_USER', ip_address='$ip', event_section='LISTS', event_type='LOAD', record_id='$list_id_override', event_code='ADMIN LOAD LIST STANDARD', event_sql='', event_notes='File Name: $leadfile_name, GOOD: $good, BAD: $bad, TOTAL: $total, DEBUG: dedupe_statuses:$dedupe_statuses[0]| dedupe_statuses_override:$dedupe_statuses_override| dupcheck:$dupcheck| lead_file:$lead_file| list_id_override:$list_id_override| phone_code_override:$phone_code_override| postalgmt:$postalgmt| template_id:$template_id| usacan_check:$usacan_check|';";
			if ($DB) {echo "|$stmt|\n";}
			$rslt=mysql_to_mysqli($stmt, $link);

			print "<BR><BR>"._QXZ("Done")."</B> "._QXZ("GOOD").": $good &nbsp; &nbsp; &nbsp; "._QXZ("BAD").": $bad &nbsp; &nbsp; &nbsp; "._QXZ("TOTAL").": $total</font></center>";
			}
		else 
			{
			print "<center><font face='arial, helvetica' size=3 color='#990000'><B>"._QXZ("ERROR: The file does not have the required number of fields to process it").".</B></font></center>";
			}
					
		}

	##### BEGIN process standard file layout #####
	if ($file_layout=="standard") 
		{
		print "<script language='JavaScript1.2'>document.forms[0].leadfile.disabled=true; document.forms[0].submit_file.disabled=true; document.forms[0].reload_page.disabled=true;</script>";
		flush();


		$delim_set=0;
		# csv xls xlsx ods sxc conversion
		if (preg_match("/\.csv$|\.xls$|\.xlsx$|\.ods$|\.sxc$/i", $leadfile_name)) 
			{
			$leadfile_name = preg_replace('/[^-\.\_0-9a-zA-Z]/','_',$leadfile_name);
			copy($LF_path, "/tmp/$leadfile_name");
			$new_filename = preg_replace("/\.csv$|\.xls$|\.xlsx$|\.ods$|\.sxc$/i", '.txt', $leadfile_name);
			$convert_command = "$WeBServeRRooT/$admin_web_directory/sheet2tab.pl /tmp/$leadfile_name /tmp/$new_filename";
			passthru("$convert_command");
			$lead_file = "/tmp/$new_filename";
			if ($DB > 0) {echo "|$convert_command|";}

			if (preg_match("/\.csv$/i", $leadfile_name)) {$delim_name="CSV: "._QXZ("Comma Separated Values");}
			if (preg_match("/\.xls$/i", $leadfile_name)) {$delim_name="XLS: MS Excel 2000-XP";}
			if (preg_match("/\.xlsx$/i", $leadfile_name)) {$delim_name="XLSX: MS Excel 2007+";}
			if (preg_match("/\.ods$/i", $leadfile_name)) {$delim_name="ODS: OpenOffice.org OpenDocument "._QXZ("Spreadsheet");}
			if (preg_match("/\.sxc$/i", $leadfile_name)) {$delim_name="SXC: OpenOffice.org "._QXZ("First Spreadsheet");}
			$delim_set=1;
			}
		else
			{
			copy($LF_path, "/tmp/vicidial_temp_file.txt");
			$lead_file = "/tmp/vicidial_temp_file.txt";
			}
		$file=fopen("$lead_file", "r");
		if ($webroot_writable > 0)
			{$stmt_file=fopen("$WeBServeRRooT/$admin_web_directory/listloader_stmts.txt", "w");}

		$buffer=fgets($file, 4096);
		$tab_count=substr_count($buffer, "\t");
		$pipe_count=substr_count($buffer, "|");

		if ($delim_set < 1)
			{
			if ($tab_count>$pipe_count)
				{$delim_name=_QXZ("tab-delimited");} 
			else 
				{$delim_name=_QXZ("pipe-delimited");}
			} 
		if ($tab_count>$pipe_count)
			{$delimiter="\t";}
		else 
			{$delimiter="|";}

		$field_check=explode($delimiter, $buffer);

		if (count($field_check)>=2) 
			{
			flush();
			$file=fopen("$lead_file", "r");
			$total=0; $good=0; $bad=0; $dup=0; $post=0; $phone_list='';
			print "<center><font face='arial, helvetica' size=3 color='#009900'><B>"._QXZ("Processing")." $delim_name "._QXZ("file")."... ($tab_count|$pipe_count)\n";

			if (count($dedupe_statuses)>0) {
				$statuses_clause=" and status in (";
				$status_dedupe_str="";
				for($ds=0; $ds<count($dedupe_statuses); $ds++) {
					$statuses_clause.="'$dedupe_statuses[$ds]',";
					$status_dedupe_str.="$dedupe_statuses[$ds], ";
					if (preg_match('/\-\-ALL\-\-/', $dedupe_statuses[$ds])) {
						$statuses_clause="";
						$status_dedupe_str="";
						break;
					}
				}
				$statuses_clause=preg_replace('/,$/', "", $statuses_clause);
				$status_dedupe_str=preg_replace('/,\s$/', "", $status_dedupe_str);
				if ($statuses_clause!="") {$statuses_clause.=")";}
			} 

			if (strlen($list_id_override)>0) 
				{
				print "<BR><BR>"._QXZ("LIST ID OVERRIDE FOR THIS FILE").": $list_id_override<BR><BR>";
				}
			if (strlen($phone_code_override)>0) 
				{
				print "<BR><BR>"._QXZ("PHONE CODE OVERRIDE FOR THIS FILE").": $phone_code_override<BR><BR>\n";
				}
			if (strlen($status_dedupe_str)>0) 
				{
				print "<BR>"._QXZ("OMITTING DUPLICATES AGAINST FOLLOWING STATUSES ONLY").": $status_dedupe_str<BR>\n";
				}
			while (!feof($file)) 
				{
				$record++;
				$buffer=rtrim(fgets($file, 4096));
				$buffer=stripslashes($buffer);

				if (strlen($buffer)>0) 
					{
					$row=explode($delimiter, preg_replace('/[\'\"]/i', '', $buffer));

					$pulldate=date("Y-m-d H:i:s");
					$entry_date =			"$pulldate";
					$modify_date =			"";
					$status =				"NEW";
					$user ="";
					$vendor_lead_code =		$row[0];
					$source_code =			$row[1];
					$source_id=$source_code;
					$list_id =				$row[2];
					$gmt_offset =			'0';
					$called_since_last_reset='N';
					$phone_code =			preg_replace('/[^0-9]/i', '', $row[3]);
					$phone_number =			preg_replace('/[^0-9]/i', '', $row[4]);
					$title =				$row[5];
					$first_name =			$row[6];
					$middle_initial =		$row[7];
					$last_name =			$row[8];
					$address1 =				$row[9];
					$address2 =				$row[10];
					$address3 =				$row[11];
					$city =$row[12];
					$state =				$row[13];
					$province =				$row[14];
					$postal_code =			$row[15];
					$country_code =			$row[16];
					$gender =				$row[17];
					$date_of_birth =		$row[18];
					$alt_phone =			preg_replace('/[^0-9]/i', '', $row[19]);
					$email =				$row[20];
					$security_phrase =		$row[21];
					$comments =				trim($row[22]);
					$rank =					$row[23];
					$owner =				$row[24];
						
					# replace ' " ` \ ; with nothing
					$vendor_lead_code =		preg_replace("/$field_regx/i", "", $vendor_lead_code);
					$source_code =			preg_replace("/$field_regx/i", "", $source_code);
					$source_id = 			preg_replace("/$field_regx/i", "", $source_id);
					$list_id =				preg_replace("/$field_regx/i", "", $list_id);
					$phone_code =			preg_replace("/$field_regx/i", "", $phone_code);
					$phone_number =			preg_replace("/$field_regx/i", "", $phone_number);
					$title =				preg_replace("/$field_regx/i", "", $title);
					$first_name =			preg_replace("/$field_regx/i", "", $first_name);
					$middle_initial =		preg_replace("/$field_regx/i", "", $middle_initial);
					$last_name =			preg_replace("/$field_regx/i", "", $last_name);
					$address1 =				preg_replace("/$field_regx/i", "", $address1);
					$address2 =				preg_replace("/$field_regx/i", "", $address2);
					$address3 =				preg_replace("/$field_regx/i", "", $address3);
					$city =					preg_replace("/$field_regx/i", "", $city);
					$state =				preg_replace("/$field_regx/i", "", $state);
					$province =				preg_replace("/$field_regx/i", "", $province);
					$postal_code =			preg_replace("/$field_regx/i", "", $postal_code);
					$country_code =			preg_replace("/$field_regx/i", "", $country_code);
					$gender =				preg_replace("/$field_regx/i", "", $gender);
					$date_of_birth =		preg_replace("/$field_regx/i", "", $date_of_birth);
					$alt_phone =			preg_replace("/$field_regx/i", "", $alt_phone);
					$email =				preg_replace("/$field_regx/i", "", $email);
					$security_phrase =		preg_replace("/$field_regx/i", "", $security_phrase);
					$comments =				preg_replace("/$field_regx/i", "", $comments);
					$rank =					preg_replace("/$field_regx/i", "", $rank);
					$owner =				preg_replace("/$field_regx/i", "", $owner);
					
					$USarea = 			substr($phone_number, 0, 3);
					$USprefix = 		substr($phone_number, 3, 3);

					if (strlen($list_id_override)>0) 
						{
						$list_id = $list_id_override;
						}
					if (strlen($phone_code_override)>0) 
						{
						$phone_code = $phone_code_override;
						}

					##### Check for duplicate phone numbers in vicidial_list table for all lists in a campaign #####
					if (preg_match("/DUPCAMP/i",$dupcheck))
						{
							$dup_lead=0;
							$dup_lists='';
						$stmt="select campaign_id from vicidial_lists where list_id='$list_id';";
						$rslt=mysql_to_mysqli($stmt, $link);
						$ci_recs = mysqli_num_rows($rslt);
						if ($ci_recs > 0)
							{
							$row=mysqli_fetch_row($rslt);
							$dup_camp =			$row[0];

							$stmt="select list_id from vicidial_lists where campaign_id='$dup_camp';";
							$rslt=mysql_to_mysqli($stmt, $link);
							$li_recs = mysqli_num_rows($rslt);
							if ($li_recs > 0)
								{
								$L=0;
								while ($li_recs > $L)
									{
									$row=mysqli_fetch_row($rslt);
									$dup_lists .=	"'$row[0]',";
									$L++;
									}
								$dup_lists = preg_replace('/,$/i', '',$dup_lists);

								$stmt="select list_id from vicidial_list where phone_number='$phone_number' and list_id IN($dup_lists) $statuses_clause limit 1;";
								$rslt=mysql_to_mysqli($stmt, $link);
								$pc_recs = mysqli_num_rows($rslt);
								if ($pc_recs > 0)
									{
									$dup_lead=1;
									$row=mysqli_fetch_row($rslt);
									$dup_lead_list =	$row[0];
									}
								if ($dup_lead < 1)
									{
									if (preg_match("/$phone_number$US$list_id/i", $phone_list))
										{$dup_lead++; $dup++;}
									}
								}
							}
						}

					##### Check for duplicate phone numbers in vicidial_list table entire database #####
					if (preg_match("/DUPSYS/i",$dupcheck))
						{
						$dup_lead=0;
						$stmt="select list_id from vicidial_list where phone_number='$phone_number' $statuses_clause;";
						$rslt=mysql_to_mysqli($stmt, $link);
						$pc_recs = mysqli_num_rows($rslt);
						if ($pc_recs > 0)
							{
							$dup_lead=1;
							$row=mysqli_fetch_row($rslt);
							$dup_lead_list =	$row[0];
							}
						if ($dup_lead < 1)
							{
							if (preg_match("/$phone_number$US$list_id/i", $phone_list))
								{$dup_lead++; $dup++;}
							}
						}

					##### Check for duplicate phone numbers in vicidial_list table for one list_id #####
					if (preg_match("/DUPLIST/i",$dupcheck))
						{
						$dup_lead=0;
						$stmt="select count(*) from vicidial_list where phone_number='$phone_number' and list_id='$list_id' $statuses_clause;";
						$rslt=mysql_to_mysqli($stmt, $link);
						$pc_recs = mysqli_num_rows($rslt);
						if ($pc_recs > 0)
							{
							$row=mysqli_fetch_row($rslt);
							$dup_lead =			$row[0];
							}
						if ($dup_lead < 1)
							{
							if (preg_match("/$phone_number$US$list_id/i", $phone_list))
								{$dup_lead++; $dup++;}
							}
						}

					##### Check for duplicate title and alt-phone in vicidial_list table for one list_id #####
					if (preg_match("/DUPTITLEALTPHONELIST/i",$dupcheck))
						{
						$dup_lead=0;
						$stmt="select count(*) from vicidial_list where title='$title' and alt_phone='$alt_phone' and list_id='$list_id' $statuses_clause;";
						$rslt=mysql_to_mysqli($stmt, $link);
						$pc_recs = mysqli_num_rows($rslt);
						if ($pc_recs > 0)
							{
							$row=mysqli_fetch_row($rslt);
							$dup_lead =			$row[0];
							$dup_lead_list =	$list_id;
							}
						if ($dup_lead < 1)
							{
							if (preg_match("/$alt_phone$title$US$list_id/i",$phone_list))
								{$dup_lead++; $dup++;}
							}
						}

					##### Check for duplicate phone numbers in vicidial_list table entire database #####
					if (preg_match("/DUPTITLEALTPHONESYS/i",$dupcheck))
						{
						$dup_lead=0;
						$stmt="select list_id from vicidial_list where title='$title' and alt_phone='$alt_phone' $statuses_clause;";
						$rslt=mysql_to_mysqli($stmt, $link);
						$pc_recs = mysqli_num_rows($rslt);
						if ($pc_recs > 0)
							{
							$dup_lead=1;
							$row=mysqli_fetch_row($rslt);
							$dup_lead_list =	$row[0];
							}
						if ($dup_lead < 1)
							{
							if (preg_match("/$alt_phone$title$US$list_id/i",$phone_list))
								{$dup_lead++; $dup++;}
							}
						}

					$valid_number=1;
					$invalid_reason='';
					if ( (strlen($phone_number)<6) || (strlen($phone_number)>16) )
						{
						$valid_number=0;
						$invalid_reason = _QXZ("INVALID PHONE NUMBER LENGTH");
						}
					if ( (preg_match("/PREFIX/",$usacan_check)) and ($valid_number > 0) )
						{
						$USprefix = 	substr($phone_number, 3, 1);
						if ($DB>0) {echo "DEBUG: usacan prefix check - $USprefix|$phone_number\n";}
						if ($USprefix < 2)
							{
							$valid_number=0;
							$invalid_reason = _QXZ("INVALID PHONE NUMBER PREFIX");
							}
						}
					if ( (preg_match("/AREACODE/",$usacan_check)) and ($valid_number > 0) )
						{
						$phone_areacode = substr($phone_number, 0, 3);
						$stmt = "select count(*) from vicidial_phone_codes where areacode='$phone_areacode' and country_code='1';";
						if ($DB>0) {echo "DEBUG: usacan areacode query - $stmt\n";}
						$rslt=mysql_to_mysqli($stmt, $link);
						$row=mysqli_fetch_row($rslt);
						$valid_number=$row[0];
						if ($valid_number < 1)
							{
							$invalid_reason = _QXZ("INVALID PHONE NUMBER AREACODE");
							}
						}
					if ( (preg_match("/NANPA/",$usacan_check)) and ($valid_number > 0) )
						{
						$phone_areacode = substr($phone_number, 0, 3);
						$phone_prefix = substr($phone_number, 3, 3);
						$stmt = "SELECT count(*) from vicidial_nanpa_prefix_codes where areacode='$phone_areacode' and prefix='$phone_prefix';";
						if ($DB>0) {echo "DEBUG: usacan nanpa query - $stmt\n";}
						$rslt=mysql_to_mysqli($stmt, $link);
						$row=mysqli_fetch_row($rslt);
						$valid_number=$row[0];
						if ($valid_number < 1)
							{
							$invalid_reason = _QXZ("INVALID PHONE NUMBER NANPA AREACODE PREFIX");
							}
						}

					if ( ($valid_number>0) and ($dup_lead<1) and ($list_id >= 100 ))
						{
						if (strlen($phone_code)<1) {$phone_code = '1';}

						if (preg_match("/TITLEALTPHONE/i",$dupcheck))
							{$phone_list .= "$alt_phone$title$US$list_id|";}
						else
							{$phone_list .= "$phone_number$US$list_id|";}

						$gmt_offset = lookup_gmt($phone_code,$USarea,$state,$LOCAL_GMT_OFF_STD,$Shour,$Smin,$Ssec,$Smon,$Smday,$Syear,$postalgmt,$postal_code,$owner,$USprefix);

						if ($multi_insert_counter > 8) 
							{
							### insert good deal into pending_transactions table ###
							$stmtZ = "INSERT INTO vicidial_list (lead_id,entry_date,modify_date,status,user,vendor_lead_code,source_id,list_id,gmt_offset_now,called_since_last_reset,phone_code,phone_number,title,first_name,middle_initial,last_name,address1,address2,address3,city,state,province,postal_code,country_code,gender,date_of_birth,alt_phone,email,security_phrase,comments,called_count,last_local_call_time,rank,owner,entry_list_id) values$multistmt('','$entry_date','$modify_date','$status','$user','$vendor_lead_code','$source_id','$list_id','$gmt_offset','$called_since_last_reset','$phone_code','$phone_number','$title','$first_name','$middle_initial','$last_name','$address1','$address2','$address3','$city','$state','$province','$postal_code','$country_code','$gender','$date_of_birth','$alt_phone','$email','$security_phrase','$comments',0,'2008-01-01 00:00:00','$rank','$owner','0');";
							$rslt=mysql_to_mysqli($stmtZ, $link);
							if ($webroot_writable > 0) 
								{fwrite($stmt_file, $stmtZ."\r\n");}
							$multistmt='';
							$multi_insert_counter=0;
							} 
						else 
							{
							$multistmt .= "('','$entry_date','$modify_date','$status','$user','$vendor_lead_code','$source_id','$list_id','$gmt_offset','$called_since_last_reset','$phone_code','$phone_number','$title','$first_name','$middle_initial','$last_name','$address1','$address2','$address3','$city','$state','$province','$postal_code','$country_code','$gender','$date_of_birth','$alt_phone','$email','$security_phrase','$comments',0,'2008-01-01 00:00:00','$rank','$owner','0'),";
							$multi_insert_counter++;
							}
						$good++;
						} 
					else
						{
						if ($bad < 1000000)
							{
							if ( $list_id < 100 )
								{
								print "<BR></b><font size=1 color=red>record $total "._QXZ("BAD- PHONE").": $phone_number "._QXZ("ROW").": |$row[0]| "._QXZ("INVALID LIST ID")."</font><b>\n";
								}
							else
								{
								if ($valid_number < 1)
									{
									print "<BR></b><font size=1 color=red>record $total "._QXZ("BAD- PHONE").": $phone_number "._QXZ("ROW").": |$row[0]| "._QXZ("INV")."($invalid_reason): $phone_number</font><b>\n";
									}
								else
									{
									print "<BR></b><font size=1 color=red>record $total "._QXZ("BAD- PHONE").": $phone_number "._QXZ("ROW").": |$row[0]| "._QXZ("DUP").": $dup_lead  $dup_lead_list</font><b>\n";
									}
								}
							}
						$bad++;
						}
					$total++;
					if ($total%100==0) 
						{
						print "<script language='JavaScript1.2'>ShowProgress($good, $bad, $total, $dup, $inv, $post)</script>";
						usleep(1000);
						flush();
						}
					}
				}
			if ($multi_insert_counter!=0) 
				{
				$stmtZ = "INSERT INTO vicidial_list (lead_id,entry_date,modify_date,status,user,vendor_lead_code,source_id,list_id,gmt_offset_now,called_since_last_reset,phone_code,phone_number,title,first_name,middle_initial,last_name,address1,address2,address3,city,state,province,postal_code,country_code,gender,date_of_birth,alt_phone,email,security_phrase,comments,called_count,last_local_call_time,rank,owner,entry_list_id) values".substr($multistmt, 0, -1).";";
				mysql_to_mysqli($stmtZ, $link);
				if ($webroot_writable > 0) 
					{fwrite($stmt_file, $stmtZ."\r\n");}
				}
			### LOG INSERTION Admin Log Table ###
			$stmt="INSERT INTO vicidial_admin_log set event_date='$NOW_TIME', user='$PHP_AUTH_USER', ip_address='$ip', event_section='LISTS', event_type='LOAD', record_id='$list_id_override', event_code='ADMIN LOAD LIST STANDARD', event_sql='', event_notes='File Name: $leadfile_name, GOOD: $good, BAD: $bad, TOTAL: $total, DEBUG: dedupe_statuses:$dedupe_statuses[0]| dedupe_statuses_override:$dedupe_statuses_override| dupcheck:$dupcheck| lead_file:$lead_file| list_id_override:$list_id_override| phone_code_override:$phone_code_override| postalgmt:$postalgmt| template_id:$template_id| usacan_check:$usacan_check|';";
			if ($DB) {echo "|$stmt|\n";}
			$rslt=mysql_to_mysqli($stmt, $link);

			print "<BR><BR>"._QXZ("Done")."</B> "._QXZ("GOOD").": $good &nbsp; &nbsp; &nbsp; "._QXZ("BAD").": $bad &nbsp; &nbsp; &nbsp; "._QXZ("TOTAL").": $total</font></center>";
			}
		else 
			{
			print "<center><font face='arial, helvetica' size=3 color='#990000'><B>"._QXZ("ERROR: The file does not have the required number of fields to process it").".</B></font></center>";
			}
		}
	##### END process standard file layout #####

		
	##### BEGIN field chooser #####
	else if ($file_layout=="custom")
		{
		print "<script language='JavaScript1.2'>document.forms[0].leadfile.disabled=true; document.forms[0].submit_file.disabled=true; document.forms[0].reload_page.disabled=true;</script><HR>";
		flush();
		print "<table border=0 cellpadding=3 cellspacing=0 width=700 align=center>\r\n";
		print "  <tr bgcolor='#330099'>\r\n";
		print "    <th align=right><font class='standard' color='white'>"._QXZ("VICIDIAL Column")."</font></th>\r\n";
		print "    <th><font class='standard' color='white'>"._QXZ("File data")."</font></th>\r\n";
		print "  </tr>\r\n";

		$fields_stmt = "SELECT vendor_lead_code, source_id, list_id, phone_code, phone_number, title, first_name, middle_initial, last_name, address1, address2, address3, city, state, province, postal_code, country_code, gender, date_of_birth, alt_phone, email, security_phrase, comments, rank, owner from vicidial_list limit 1";

		##### BEGIN custom fields columns list ###
		if ($custom_fields_enabled > 0)
			{
			$stmt="SHOW TABLES LIKE \"custom_$list_id_override\";";
			if ($DB>0) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
			$tablecount_to_print = mysqli_num_rows($rslt);
			if ($tablecount_to_print > 0) 
				{
				$stmt="SELECT count(*) from vicidial_lists_fields where list_id='$list_id_override';";
				if ($DB>0) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
				$fieldscount_to_print = mysqli_num_rows($rslt);
				if ($fieldscount_to_print > 0) 
					{
					$rowx=mysqli_fetch_row($rslt);
					$custom_records_count =	$rowx[0];

					$custom_SQL='';
					$stmt="SELECT field_id,field_label,field_name,field_description,field_rank,field_help,field_type,field_options,field_size,field_max,field_default,field_cost,field_required,multi_position,name_position,field_order from vicidial_lists_fields where list_id='$list_id_override' order by field_rank,field_order,field_label;";
					if ($DB>0) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
					$fields_to_print = mysqli_num_rows($rslt);
					$fields_list='';
					$o=0;
					while ($fields_to_print > $o) 
						{
						$rowx=mysqli_fetch_row($rslt);
						$A_field_label[$o] =	$rowx[1];
						$A_field_type[$o] =		$rowx[6];

						if ($DB>0) {echo "$A_field_label[$o]|$A_field_type[$o]\n";}

						if ( ($A_field_type[$o]!='DISPLAY') and ($A_field_type[$o]!='SCRIPT') )
							{
							if (!preg_match("/\|$A_field_label[$o]\|/",$vicidial_list_fields))
								{
								$custom_SQL .= ",$A_field_label[$o]";
								}
							}
						$o++;
						}

					$fields_stmt = "SELECT vendor_lead_code, source_id, list_id, phone_code, phone_number, title, first_name, middle_initial, last_name, address1, address2, address3, city, state, province, postal_code, country_code, gender, date_of_birth, alt_phone, email, security_phrase, comments, rank, owner $custom_SQL from vicidial_list, custom_$list_id_override limit 1";

					}
				}
			}
		##### END custom fields columns list ###


		$rslt=mysql_to_mysqli("$fields_stmt", $link);

		# csv xls xlsx ods sxc conversion
		$delim_set=0;
		if (preg_match("/\.csv$|\.xls$|\.xlsx$|\.ods$|\.sxc$/i", $leadfile_name)) 
			{
			$leadfile_name = preg_replace('/[^-\.\_0-9a-zA-Z]/','_',$leadfile_name);
			copy($LF_path, "/tmp/$leadfile_name");
			$new_filename = preg_replace("/\.csv$|\.xls$|\.xlsx$|\.ods$|\.sxc$/i", '.txt', $leadfile_name);
			$convert_command = "$WeBServeRRooT/$admin_web_directory/sheet2tab.pl /tmp/$leadfile_name /tmp/$new_filename";
			passthru("$convert_command");
			$lead_file = "/tmp/$new_filename";
			if ($DB > 0) {echo "|$convert_command|";}

			if (preg_match("/\.csv$/i", $leadfile_name)) {$delim_name="CSV: "._QXZ("Comma Separated Values");}
			if (preg_match("/\.xls$/i", $leadfile_name)) {$delim_name="XLS: MS Excel 2000-XP";}
			if (preg_match("/\.xlsx$/i", $leadfile_name)) {$delim_name="XLSX: MS Excel 2007+";}
			if (preg_match("/\.ods$/i", $leadfile_name)) {$delim_name="ODS: OpenOffice.org OpenDocument "._QXZ("Spreadsheet");}
			if (preg_match("/\.sxc$/i", $leadfile_name)) {$delim_name="SXC: OpenOffice.org "._QXZ("First Spreadsheet");}
			$delim_set=1;
			}
		else
			{
			copy($LF_path, "/tmp/vicidial_temp_file.txt");
			$lead_file = "/tmp/vicidial_temp_file.txt";
			}
		$file=fopen("$lead_file", "r");
		if ($webroot_writable > 0)
			{$stmt_file=fopen("$WeBServeRRooT/$admin_web_directory/listloader_stmts.txt", "w");}

		$buffer=fgets($file, 4096);
		$tab_count=substr_count($buffer, "\t");
		$pipe_count=substr_count($buffer, "|");

		if ($delim_set < 1)
			{
			if ($tab_count>$pipe_count)
				{$delim_name=_QXZ("tab-delimited");} 
			else 
				{$delim_name=_QXZ("pipe-delimited");}
			} 
		if ($tab_count>$pipe_count)
			{$delimiter="\t";}
		else 
			{$delimiter="|";}

		$field_check=explode($delimiter, $buffer);

		if (count($dedupe_statuses)>0) {
			$status_dedupe_str="";
			for($ds=0; $ds<count($dedupe_statuses); $ds++) {
				$status_dedupe_str.="$dedupe_statuses[$ds],";
				if (preg_match('/\-\-ALL\-\-/', $dedupe_statuses[$ds])) {
					$status_dedupe_str="";
					break;
				}
			}
			$status_dedupe_str=preg_replace('/\,$/', "", $status_dedupe_str);
		} 
			
		flush();
		$file=fopen("$lead_file", "r");
		print "<center><font face='arial, helvetica' size=3 color='#009900'><B>"._QXZ("Processing")." $delim_name "._QXZ("file")."...\n";

		if (strlen($list_id_override)>0) 
			{
			print "<BR><BR>"._QXZ("LIST ID OVERRIDE FOR THIS FILE").": $list_id_override<BR><BR>";
			}
		if (strlen($phone_code_override)>0) 
			{
			print "<BR><BR>"._QXZ("PHONE CODE OVERRIDE FOR THIS FILE").": $phone_code_override<BR><BR>";
			}
		if (strlen($status_dedupe_str)>0) 
			{
			print "<BR>"._QXZ("OMITTING DUPLICATES AGAINST FOLLOWING STATUSES ONLY").": $status_dedupe_str<BR>\n";
			}
		$buffer=rtrim(fgets($file, 4096));
		$buffer=stripslashes($buffer);
		$row=explode($delimiter, preg_replace('/[\'\"]/i', '', $buffer));
		
		while ($fieldinfo=mysqli_fetch_field($rslt))
			{
			$rslt_field_name=$fieldinfo->name;
			if ( ($rslt_field_name=="list_id" and $list_id_override!="") or ($rslt_field_name=="phone_code" and $phone_code_override!="") )
				{
				print "<!-- skipping " . $rslt_field_name . " -->\n";
				}
			else 
				{
				print "  <tr bgcolor=#D9E6FE>\r\n";
				print "    <td align=right><font class=standard>".strtoupper(preg_replace('/_/i', ' ', $rslt_field_name)).": </font></td>\r\n";
				print "    <td align=center><select name='".$rslt_field_name."_field'>\r\n";
				print "     <option value='-1'>(none)</option>\r\n";

				for ($j=0; $j<count($row); $j++) 
					{
					preg_replace('/\"/i', '', $row[$j]);
					print "     <option value='$j'>\"$row[$j]\"</option>\r\n";
					}

				print "    </select></td>\r\n";
				print "  </tr>\r\n";
				}
			}
		print "  <tr bgcolor='#330099'>\r\n";
		print "  <input type=hidden name=dedupe_statuses_override value=\"$status_dedupe_str\">\r\n";
		print "  <input type=hidden name=dupcheck value=\"$dupcheck\">\r\n";
		print "  <input type=hidden name=usacan_check value=\"$usacan_check\">\r\n";
		print "  <input type=hidden name=postalgmt value=\"$postalgmt\">\r\n";
		print "  <input type=hidden name=lead_file value=\"$lead_file\">\r\n";
		print "  <input type=hidden name=list_id_override value=\"$list_id_override\">\r\n";
		print "  <input type=hidden name=phone_code_override value=\"$phone_code_override\">\r\n";
		print "    <th colspan=2><input type=submit name='OK_to_process' value='"._QXZ("OK TO PROCESS")."'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=button onClick=\"javascript:document.location='admin_listloader_fourth_gen.php'\" value=\""._QXZ("START OVER")."\" name='reload_page'></th>\r\n";
		print "  </tr>\r\n";
		print "</table>\r\n";

		print "<script language='JavaScript1.2'>document.forms[0].leadfile.disabled=false; document.forms[0].submit_file.disabled=false; document.forms[0].reload_page.disabled=false;</script>";
		}
	##### END field chooser #####

	}

?>
</form>
</body>
</html>





<?php

exit;



function lookup_gmt($phone_code,$USarea,$state,$LOCAL_GMT_OFF_STD,$Shour,$Smin,$Ssec,$Smon,$Smday,$Syear,$postalgmt,$postal_code,$owner,$USprefix)
	{
	global $link;

	$postalgmt_found=0;
	if ( (preg_match("/POSTAL/i",$postalgmt)) && (strlen($postal_code)>4) )
		{
		if (preg_match('/^1$/', $phone_code))
			{
			$stmt="select postal_code,state,GMT_offset,DST,DST_range,country,country_code from vicidial_postal_codes where country_code='$phone_code' and postal_code LIKE \"$postal_code%\";";
			$rslt=mysql_to_mysqli($stmt, $link);
			$pc_recs = mysqli_num_rows($rslt);
			if ($pc_recs > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$gmt_offset =	$row[2];	 $gmt_offset = preg_replace('/\+/i', '',$gmt_offset);
				$dst =			$row[3];
				$dst_range =	$row[4];
				$PC_processed++;
				$postalgmt_found++;
				$post++;
				}
			}
		}
	if ( ($postalgmt=="TZCODE") && (strlen($owner)>1) )
		{
		$dst_range='';
		$dst='N';
		$gmt_offset=0;

		$stmt="select GMT_offset from vicidial_phone_codes where tz_code='$owner' and country_code='$phone_code' limit 1;";
		$rslt=mysql_to_mysqli($stmt, $link);
		$pc_recs = mysqli_num_rows($rslt);
		if ($pc_recs > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$gmt_offset =	$row[0];	 $gmt_offset = preg_replace('/\+/i', '',$gmt_offset);
			$PC_processed++;
			$postalgmt_found++;
			$post++;
			}

		$stmt = "select distinct DST_range from vicidial_phone_codes where tz_code='$owner' and country_code='$phone_code' order by DST_range desc limit 1;";
		$rslt=mysql_to_mysqli($stmt, $link);
		$pc_recs = mysqli_num_rows($rslt);
		if ($pc_recs > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$dst_range =	$row[0];
			if (strlen($dst_range)>2) {$dst = 'Y';}
			}
		}
	if ( (preg_match("/NANPA/i",$tz_method)) && (strlen($USarea)>2) && (strlen($USprefix)>2) )
		{
		$stmt="select GMT_offset,DST from vicidial_nanpa_prefix_codes where areacode='$USarea' and prefix='$USprefix';";
		$rslt=mysql_to_mysqli($stmt, $link);
		$pc_recs = mysqli_num_rows($rslt);
		if ($pc_recs > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$gmt_offset =	$row[0];	 $gmt_offset = preg_replace('/\+/i', '',$gmt_offset);
			$dst =			$row[1];
			$dst_range =	'';
			if ($dst == 'Y')
				{$dst_range =	'SSM-FSN';}
			$PC_processed++;
			$postalgmt_found++;
			$post++;
			}
		}

	if ($postalgmt_found < 1)
		{
		$PC_processed=0;
		### UNITED STATES ###
		if ($phone_code =='1')
			{
			$stmt="select country_code,country,areacode,state,GMT_offset,DST,DST_range,geographic_description from vicidial_phone_codes where country_code='$phone_code' and areacode='$USarea';";
			$rslt=mysql_to_mysqli($stmt, $link);
			$pc_recs = mysqli_num_rows($rslt);
			if ($pc_recs > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$gmt_offset =	$row[4];	 $gmt_offset = preg_replace('/\+/i', '',$gmt_offset);
				$dst =			$row[5];
				$dst_range =	$row[6];
				$PC_processed++;
				}
			}
		### MEXICO ###
		if ($phone_code =='52')
			{
			$stmt="select country_code,country,areacode,state,GMT_offset,DST,DST_range,geographic_description from vicidial_phone_codes where country_code='$phone_code' and areacode='$USarea';";
			$rslt=mysql_to_mysqli($stmt, $link);
			$pc_recs = mysqli_num_rows($rslt);
			if ($pc_recs > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$gmt_offset =	$row[4];	 $gmt_offset = preg_replace('/\+/i', '',$gmt_offset);
				$dst =			$row[5];
				$dst_range =	$row[6];
				$PC_processed++;
				}
			}
		### AUSTRALIA ###
		if ($phone_code =='61')
			{
			$stmt="select country_code,country,areacode,state,GMT_offset,DST,DST_range,geographic_description from vicidial_phone_codes where country_code='$phone_code' and state='$state';";
			$rslt=mysql_to_mysqli($stmt, $link);
			$pc_recs = mysqli_num_rows($rslt);
			if ($pc_recs > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$gmt_offset =	$row[4];	 $gmt_offset = preg_replace('/\+/i', '',$gmt_offset);
				$dst =			$row[5];
				$dst_range =	$row[6];
				$PC_processed++;
				}
			}
		### ALL OTHER COUNTRY CODES ###
		if (!$PC_processed)
			{
			$PC_processed++;
			$stmt="select country_code,country,areacode,state,GMT_offset,DST,DST_range,geographic_description from vicidial_phone_codes where country_code='$phone_code';";
			$rslt=mysql_to_mysqli($stmt, $link);
			$pc_recs = mysqli_num_rows($rslt);
			if ($pc_recs > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$gmt_offset =	$row[4];	 $gmt_offset = preg_replace('/\+/i', '',$gmt_offset);
				$dst =			$row[5];
				$dst_range =	$row[6];
				$PC_processed++;
				}
			}
		}

	### Find out if DST to raise the gmt offset ###
	$AC_GMT_diff = ($gmt_offset - $LOCAL_GMT_OFF_STD);
	$AC_localtime = mktime(($Shour + $AC_GMT_diff), $Smin, $Ssec, $Smon, $Smday, $Syear);
		$hour = date("H",$AC_localtime);
		$min = date("i",$AC_localtime);
		$sec = date("s",$AC_localtime);
		$mon = date("m",$AC_localtime);
		$mday = date("d",$AC_localtime);
		$wday = date("w",$AC_localtime);
		$year = date("Y",$AC_localtime);
	$dsec = ( ( ($hour * 3600) + ($min * 60) ) + $sec );

	$AC_processed=0;
	if ( (!$AC_processed) and ($dst_range == 'SSM-FSN') )
		{
		if ($DBX) {print "     Second Sunday March to First Sunday November\n";}
		#**********************************************************************
		# SSM-FSN
		#     This is returns 1 if Daylight Savings Time is in effect and 0 if 
		#       Standard time is in effect.
		#     Based on Second Sunday March to First Sunday November at 2 am.
		#     INPUTS:
		#       mm              INTEGER       Month.
		#       dd              INTEGER       Day of the month.
		#       ns              INTEGER       Seconds into the day.
		#       dow             INTEGER       Day of week (0=Sunday, to 6=Saturday)
		#     OPTIONAL INPUT:
		#       timezone        INTEGER       hour difference UTC - local standard time
		#                                      (DEFAULT is blank)
		#                                     make calculations based on UTC time, 
		#                                     which means shift at 10:00 UTC in April
		#                                     and 9:00 UTC in October
		#     OUTPUT: 
		#                       INTEGER       1 = DST, 0 = not DST
		#
		# S  M  T  W  T  F  S
		# 1  2  3  4  5  6  7
		# 8  9 10 11 12 13 14
		#15 16 17 18 19 20 21
		#22 23 24 25 26 27 28
		#29 30 31
		# 
		# S  M  T  W  T  F  S
		#    1  2  3  4  5  6
		# 7  8  9 10 11 12 13
		#14 15 16 17 18 19 20
		#21 22 23 24 25 26 27
		#28 29 30 31
		# 
		#**********************************************************************

			$USACAN_DST=0;
			$mm = $mon;
			$dd = $mday;
			$ns = $dsec;
			$dow= $wday;

			if ($mm < 3 || $mm > 11) {
			$USACAN_DST=0;   
			} elseif ($mm >= 4 and $mm <= 10) {
			$USACAN_DST=1;   
			} elseif ($mm == 3) {
			if ($dd > 13) {
				$USACAN_DST=1;   
			} elseif ($dd >= ($dow+8)) {
				if ($timezone) {
				if ($dow == 0 and $ns < (7200+$timezone*3600)) {
					$USACAN_DST=0;   
				} else {
					$USACAN_DST=1;   
				}
				} else {
				if ($dow == 0 and $ns < 7200) {
					$USACAN_DST=0;   
				} else {
					$USACAN_DST=1;   
				}
				}
			} else {
				$USACAN_DST=0;   
			}
			} elseif ($mm == 11) {
			if ($dd > 7) {
				$USACAN_DST=0;   
			} elseif ($dd < ($dow+1)) {
				$USACAN_DST=1;   
			} elseif ($dow == 0) {
				if ($timezone) { # UTC calculations
				if ($ns < (7200+($timezone-1)*3600)) {
					$USACAN_DST=1;   
				} else {
					$USACAN_DST=0;   
				}
				} else { # local time calculations
				if ($ns < 7200) {
					$USACAN_DST=1;   
				} else {
					$USACAN_DST=0;   
				}
				}
			} else {
				$USACAN_DST=0;   
			}
			} # end of month checks
		if ($DBX) {print "     DST: $USACAN_DST\n";}
		if ($USACAN_DST) {$gmt_offset++;}
		$AC_processed++;
		}

	if ( (!$AC_processed) and ($dst_range == 'FSA-LSO') )
		{
		if ($DBX) {print "     First Sunday April to Last Sunday October\n";}
		#**********************************************************************
		# FSA-LSO
		#     This is returns 1 if Daylight Savings Time is in effect and 0 if 
		#       Standard time is in effect.
		#     Based on first Sunday in April and last Sunday in October at 2 am.
		#**********************************************************************
			
			$USA_DST=0;
			$mm = $mon;
			$dd = $mday;
			$ns = $dsec;
			$dow= $wday;

			if ($mm < 4 || $mm > 10) {
			$USA_DST=0;
			} elseif ($mm >= 5 and $mm <= 9) {
			$USA_DST=1;
			} elseif ($mm == 4) {
			if ($dd > 7) {
				$USA_DST=1;
			} elseif ($dd >= ($dow+1)) {
				if ($timezone) {
				if ($dow == 0 and $ns < (7200+$timezone*3600)) {
					$USA_DST=0;
				} else {
					$USA_DST=1;
				}
				} else {
				if ($dow == 0 and $ns < 7200) {
					$USA_DST=0;
				} else {
					$USA_DST=1;
				}
				}
			} else {
				$USA_DST=0;
			}
			} elseif ($mm == 10) {
			if ($dd < 25) {
				$USA_DST=1;
			} elseif ($dd < ($dow+25)) {
				$USA_DST=1;
			} elseif ($dow == 0) {
				if ($timezone) { # UTC calculations
				if ($ns < (7200+($timezone-1)*3600)) {
					$USA_DST=1;
				} else {
					$USA_DST=0;
				}
				} else { # local time calculations
				if ($ns < 7200) {
					$USA_DST=1;
				} else {
					$USA_DST=0;
				}
				}
			} else {
				$USA_DST=0;
			}
			} # end of month checks

		if ($DBX) {print "     DST: $USA_DST\n";}
		if ($USA_DST) {$gmt_offset++;}
		$AC_processed++;
		}

	if ( (!$AC_processed) and ($dst_range == 'LSM-LSO') )
		{
		if ($DBX) {print "     Last Sunday March to Last Sunday October\n";}
		#**********************************************************************
		#     This is s 1 if Daylight Savings Time is in effect and 0 if 
		#       Standard time is in effect.
		#     Based on last Sunday in March and last Sunday in October at 1 am.
		#**********************************************************************
			
			$GBR_DST=0;
			$mm = $mon;
			$dd = $mday;
			$ns = $dsec;
			$dow= $wday;

			if ($mm < 3 || $mm > 10) {
			$GBR_DST=0;
			} elseif ($mm >= 4 and $mm <= 9) {
			$GBR_DST=1;
			} elseif ($mm == 3) {
			if ($dd < 25) {
				$GBR_DST=0;
			} elseif ($dd < ($dow+25)) {
				$GBR_DST=0;
			} elseif ($dow == 0) {
				if ($timezone) { # UTC calculations
				if ($ns < (3600+($timezone-1)*3600)) {
					$GBR_DST=0;
				} else {
					$GBR_DST=1;
				}
				} else { # local time calculations
				if ($ns < 3600) {
					$GBR_DST=0;
				} else {
					$GBR_DST=1;
				}
				}
			} else {
				$GBR_DST=1;
			}
			} elseif ($mm == 10) {
			if ($dd < 25) {
				$GBR_DST=1;
			} elseif ($dd < ($dow+25)) {
				$GBR_DST=1;
			} elseif ($dow == 0) {
				if ($timezone) { # UTC calculations
				if ($ns < (3600+($timezone-1)*3600)) {
					$GBR_DST=1;
				} else {
					$GBR_DST=0;
				}
				} else { # local time calculations
				if ($ns < 3600) {
					$GBR_DST=1;
				} else {
					$GBR_DST=0;
				}
				}
			} else {
				$GBR_DST=0;
			}
			} # end of month checks
			if ($DBX) {print "     DST: $GBR_DST\n";}
		if ($GBR_DST) {$gmt_offset++;}
		$AC_processed++;
		}
	if ( (!$AC_processed) and ($dst_range == 'LSO-LSM') )
		{
		if ($DBX) {print "     Last Sunday October to Last Sunday March\n";}
		#**********************************************************************
		#     This is s 1 if Daylight Savings Time is in effect and 0 if 
		#       Standard time is in effect.
		#     Based on last Sunday in October and last Sunday in March at 1 am.
		#**********************************************************************
			
			$AUS_DST=0;
			$mm = $mon;
			$dd = $mday;
			$ns = $dsec;
			$dow= $wday;

			if ($mm < 3 || $mm > 10) {
			$AUS_DST=1;
			} elseif ($mm >= 4 and $mm <= 9) {
			$AUS_DST=0;
			} elseif ($mm == 3) {
			if ($dd < 25) {
				$AUS_DST=1;
			} elseif ($dd < ($dow+25)) {
				$AUS_DST=1;
			} elseif ($dow == 0) {
				if ($timezone) { # UTC calculations
				if ($ns < (3600+($timezone-1)*3600)) {
					$AUS_DST=1;
				} else {
					$AUS_DST=0;
				}
				} else { # local time calculations
				if ($ns < 3600) {
					$AUS_DST=1;
				} else {
					$AUS_DST=0;
				}
				}
			} else {
				$AUS_DST=0;
			}
			} elseif ($mm == 10) {
			if ($dd < 25) {
				$AUS_DST=0;
			} elseif ($dd < ($dow+25)) {
				$AUS_DST=0;
			} elseif ($dow == 0) {
				if ($timezone) { # UTC calculations
				if ($ns < (3600+($timezone-1)*3600)) {
					$AUS_DST=0;
				} else {
					$AUS_DST=1;
				}
				} else { # local time calculations
				if ($ns < 3600) {
					$AUS_DST=0;
				} else {
					$AUS_DST=1;
				}
				}
			} else {
				$AUS_DST=1;
			}
			} # end of month checks						
		if ($DBX) {print "     DST: $AUS_DST\n";}
		if ($AUS_DST) {$gmt_offset++;}
		$AC_processed++;
		}

	if ( (!$AC_processed) and ($dst_range == 'FSO-LSM') )
		{
		if ($DBX) {print "     First Sunday October to Last Sunday March\n";}
		#**********************************************************************
		#   TASMANIA ONLY
		#     This is s 1 if Daylight Savings Time is in effect and 0 if 
		#       Standard time is in effect.
		#     Based on first Sunday in October and last Sunday in March at 1 am.
		#**********************************************************************
			
			$AUST_DST=0;
			$mm = $mon;
			$dd = $mday;
			$ns = $dsec;
			$dow= $wday;

			if ($mm < 3 || $mm > 10) {
			$AUST_DST=1;
			} elseif ($mm >= 4 and $mm <= 9) {
			$AUST_DST=0;
			} elseif ($mm == 3) {
			if ($dd < 25) {
				$AUST_DST=1;
			} elseif ($dd < ($dow+25)) {
				$AUST_DST=1;
			} elseif ($dow == 0) {
				if ($timezone) { # UTC calculations
				if ($ns < (3600+($timezone-1)*3600)) {
					$AUST_DST=1;
				} else {
					$AUST_DST=0;
				}
				} else { # local time calculations
				if ($ns < 3600) {
					$AUST_DST=1;
				} else {
					$AUST_DST=0;
				}
				}
			} else {
				$AUST_DST=0;
			}
			} elseif ($mm == 10) {
			if ($dd > 7) {
				$AUST_DST=1;
			} elseif ($dd >= ($dow+1)) {
				if ($timezone) {
				if ($dow == 0 and $ns < (7200+$timezone*3600)) {
					$AUST_DST=0;
				} else {
					$AUST_DST=1;
				}
				} else {
				if ($dow == 0 and $ns < 3600) {
					$AUST_DST=0;
				} else {
					$AUST_DST=1;
				}
				}
			} else {
				$AUST_DST=0;
			}
			} # end of month checks						
		if ($DBX) {print "     DST: $AUST_DST\n";}
		if ($AUST_DST) {$gmt_offset++;}
		$AC_processed++;
		}

	if ( (!$AC_processed) and ($dst_range == 'FSO-FSA') )
		{
		if ($DBX) {print "     Sunday in October to First Sunday in April\n";}
		#**********************************************************************
		# FSO-FSA
		#   2008+ AUSTRALIA ONLY (country code 61)
		#     This is returns 1 if Daylight Savings Time is in effect and 0 if 
		#       Standard time is in effect.
		#     Based on first Sunday in October and first Sunday in April at 1 am.
		#**********************************************************************
		
		$AUSE_DST=0;
		$mm = $mon;
		$dd = $mday;
		$ns = $dsec;
		$dow= $wday;

		if ($mm < 4 or $mm > 10) {
		$AUSE_DST=1;   
		} elseif ($mm >= 5 and $mm <= 9) {
		$AUSE_DST=0;   
		} elseif ($mm == 4) {
		if ($dd > 7) {
			$AUSE_DST=0;   
		} elseif ($dd >= ($dow+1)) {
			if ($timezone) {
			if ($dow == 0 and $ns < (3600+$timezone*3600)) {
				$AUSE_DST=1;   
			} else {
				$AUSE_DST=0;   
			}
			} else {
			if ($dow == 0 and $ns < 7200) {
				$AUSE_DST=1;   
			} else {
				$AUSE_DST=0;   
			}
			}
		} else {
			$AUSE_DST=1;   
		}
		} elseif ($mm == 10) {
		if ($dd >= 8) {
			$AUSE_DST=1;   
		} elseif ($dd >= ($dow+1)) {
			if ($timezone) {
			if ($dow == 0 and $ns < (7200+$timezone*3600)) {
				$AUSE_DST=0;   
			} else {
				$AUSE_DST=1;   
			}
			} else {
			if ($dow == 0 and $ns < 3600) {
				$AUSE_DST=0;   
			} else {
				$AUSE_DST=1;   
			}
			}
		} else {
			$AUSE_DST=0;   
		}
		} # end of month checks
		if ($DBX) {print "     DST: $AUSE_DST\n";}
		if ($AUSE_DST) {$gmt_offset++;}
		$AC_processed++;
		}

	if ( (!$AC_processed) and ($dst_range == 'FSO-TSM') )
		{
		if ($DBX) {print "     First Sunday October to Third Sunday March\n";}
		#**********************************************************************
		#     This is s 1 if Daylight Savings Time is in effect and 0 if 
		#       Standard time is in effect.
		#     Based on first Sunday in October and third Sunday in March at 1 am.
		#**********************************************************************
			
			$NZL_DST=0;
			$mm = $mon;
			$dd = $mday;
			$ns = $dsec;
			$dow= $wday;

			if ($mm < 3 || $mm > 10) {
			$NZL_DST=1;
			} elseif ($mm >= 4 and $mm <= 9) {
			$NZL_DST=0;
			} elseif ($mm == 3) {
			if ($dd < 14) {
				$NZL_DST=1;
			} elseif ($dd < ($dow+14)) {
				$NZL_DST=1;
			} elseif ($dow == 0) {
				if ($timezone) { # UTC calculations
				if ($ns < (3600+($timezone-1)*3600)) {
					$NZL_DST=1;
				} else {
					$NZL_DST=0;
				}
				} else { # local time calculations
				if ($ns < 3600) {
					$NZL_DST=1;
				} else {
					$NZL_DST=0;
				}
				}
			} else {
				$NZL_DST=0;
			}
			} elseif ($mm == 10) {
			if ($dd > 7) {
				$NZL_DST=1;
			} elseif ($dd >= ($dow+1)) {
				if ($timezone) {
				if ($dow == 0 and $ns < (7200+$timezone*3600)) {
					$NZL_DST=0;
				} else {
					$NZL_DST=1;
				}
				} else {
				if ($dow == 0 and $ns < 3600) {
					$NZL_DST=0;
				} else {
					$NZL_DST=1;
				}
				}
			} else {
				$NZL_DST=0;
			}
			} # end of month checks						
		if ($DBX) {print "     DST: $NZL_DST\n";}
		if ($NZL_DST) {$gmt_offset++;}
		$AC_processed++;
		}

	if ( (!$AC_processed) and ($dst_range == 'LSS-FSA') )
		{
		if ($DBX) {print "     Last Sunday in September to First Sunday in April\n";}
		#**********************************************************************
		# LSS-FSA
		#   2007+ NEW ZEALAND (country code 64)
		#     This is returns 1 if Daylight Savings Time is in effect and 0 if 
		#       Standard time is in effect.
		#     Based on last Sunday in September and first Sunday in April at 1 am.
		#**********************************************************************
		
		$NZLN_DST=0;
		$mm = $mon;
		$dd = $mday;
		$ns = $dsec;
		$dow= $wday;

		if ($mm < 4 || $mm > 9) {
		$NZLN_DST=1;   
		} elseif ($mm >= 5 && $mm <= 9) {
		$NZLN_DST=0;   
		} elseif ($mm == 4) {
		if ($dd > 7) {
			$NZLN_DST=0;   
		} elseif ($dd >= ($dow+1)) {
			if ($timezone) {
			if ($dow == 0 && $ns < (3600+$timezone*3600)) {
				$NZLN_DST=1;   
			} else {
				$NZLN_DST=0;   
			}
			} else {
			if ($dow == 0 && $ns < 7200) {
				$NZLN_DST=1;   
			} else {
				$NZLN_DST=0;   
			}
			}
		} else {
			$NZLN_DST=1;   
		}
		} elseif ($mm == 9) {
		if ($dd < 25) {
			$NZLN_DST=0;   
		} elseif ($dd < ($dow+25)) {
			$NZLN_DST=0;   
		} elseif ($dow == 0) {
			if ($timezone) { # UTC calculations
			if ($ns < (3600+($timezone-1)*3600)) {
				$NZLN_DST=0;   
			} else {
				$NZLN_DST=1;   
			}
			} else { # local time calculations
			if ($ns < 3600) {
				$NZLN_DST=0;   
			} else {
				$NZLN_DST=1;   
			}
			}
		} else {
			$NZLN_DST=1;   
		}
		} # end of month checks
		if ($DBX) {print "     DST: $NZLN_DST\n";}
		if ($NZLN_DST) {$gmt_offset++;}
		$AC_processed++;
		}

	if ( (!$AC_processed) and ($dst_range == 'TSO-LSF') )
		{
		if ($DBX) {print "     Third Sunday October to Last Sunday February\n";}
		#**********************************************************************
		# TSO-LSF
		#     This is returns 1 if Daylight Savings Time is in effect and 0 if 
		#       Standard time is in effect. Brazil
		#     Based on Third Sunday October to Last Sunday February at 1 am.
		#**********************************************************************
			
			$BZL_DST=0;
			$mm = $mon;
			$dd = $mday;
			$ns = $dsec;
			$dow= $wday;

			if ($mm < 2 || $mm > 10) {
			$BZL_DST=1;   
			} elseif ($mm >= 3 and $mm <= 9) {
			$BZL_DST=0;   
			} elseif ($mm == 2) {
			if ($dd < 22) {
				$BZL_DST=1;   
			} elseif ($dd < ($dow+22)) {
				$BZL_DST=1;   
			} elseif ($dow == 0) {
				if ($timezone) { # UTC calculations
				if ($ns < (3600+($timezone-1)*3600)) {
					$BZL_DST=1;   
				} else {
					$BZL_DST=0;   
				}
				} else { # local time calculations
				if ($ns < 3600) {
					$BZL_DST=1;   
				} else {
					$BZL_DST=0;   
				}
				}
			} else {
				$BZL_DST=0;   
			}
			} elseif ($mm == 10) {
			if ($dd < 22) {
				$BZL_DST=0;   
			} elseif ($dd < ($dow+22)) {
				$BZL_DST=0;   
			} elseif ($dow == 0) {
				if ($timezone) { # UTC calculations
				if ($ns < (3600+($timezone-1)*3600)) {
					$BZL_DST=0;   
				} else {
					$BZL_DST=1;   
				}
				} else { # local time calculations
				if ($ns < 3600) {
					$BZL_DST=0;   
				} else {
					$BZL_DST=1;   
				}
				}
			} else {
				$BZL_DST=1;   
			}
			} # end of month checks
		if ($DBX) {print "     DST: $BZL_DST\n";}
		if ($BZL_DST) {$gmt_offset++;}
		$AC_processed++;
		}

	if (!$AC_processed)
		{
		if ($DBX) {print "     No DST Method Found\n";}
		if ($DBX) {print "     DST: 0\n";}
		$AC_processed++;
		}

	return $gmt_offset;
	}

?>
</TD></TR></TABLE>
