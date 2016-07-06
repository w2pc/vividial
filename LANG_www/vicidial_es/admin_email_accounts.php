<?php
# admin_email_accounts.php
# 
# Copyright (C) 2013  Joe Johnson, Matt Florell <vicidial@gmail.com>    LICENSE: AGPLv2
#
# This page manages the inbound email accounts in ViciDial
#
# changes:
# 121214-2245 - First Build
# 130102-1131 - Small admin log change
# 130221-1754 - Added level 8 disable add feature
# 130610-1041 - Changed all ereg to preg
# 130621-2001 - Added filtering of input to prevent SQL injection attacks and new user auth
# 130902-0754 - Changed to mysqli PHP functions
#

$admin_version = '2.8-6';
$build = '1300902-0754';

$sh="emails"; 

require("dbconnect_mysqli.php");
require("functions.php");

$PHP_AUTH_USER=$_SERVER['PHP_AUTH_USER'];
$PHP_AUTH_PW=$_SERVER['PHP_AUTH_PW'];
$PHP_SELF=$_SERVER['PHP_SELF'];
if (isset($_GET["DB"]))							{$DB=$_GET["DB"];}
	elseif (isset($_POST["DB"]))				{$DB=$_POST["DB"];}
if (isset($_GET["action"]))						{$action=$_GET["action"];}
	elseif (isset($_POST["action"]))			{$action=$_POST["action"];}
if (isset($_GET["REMITIR"]))						{$REMITIR=$_GET["REMITIR"];}
	elseif (isset($_POST["REMITIR"]))			{$REMITIR=$_POST["REMITIR"];}
if (isset($_GET["eact"]))						{$eact=$_GET["eact"];}
	elseif (isset($_POST["eact"]))				{$eact=$_POST["eact"];}
if (isset($_GET["email_account_id"]))					{$email_account_id=$_GET["email_account_id"];}
	elseif (isset($_POST["email_account_id"]))			{$email_account_id=$_POST["email_account_id"];}
if (isset($_GET["email_account_name"]))					{$email_account_name=$_GET["email_account_name"];}
	elseif (isset($_POST["email_account_name"]))		{$email_account_name=$_POST["email_account_name"];}
if (isset($_GET["email_account_description"]))			{$email_account_description=$_GET["email_account_description"];}
	elseif (isset($_POST["email_account_description"]))	{$email_account_description=$_POST["email_account_description"];}
if (isset($_GET["user_group"]))						{$user_group=$_GET["user_group"];}
	elseif (isset($_POST["user_group"]))			{$user_group=$_POST["user_group"];}
if (isset($_GET["protocol"]))						{$protocol=$_GET["protocol"];}
	elseif (isset($_POST["protocol"]))				{$protocol=$_POST["protocol"];}
if (isset($_GET["email_account_server"]))					{$email_account_server=$_GET["email_account_server"];}
	elseif (isset($_POST["email_account_server"]))			{$email_account_server=$_POST["email_account_server"];}
if (isset($_GET["email_account_user"]))						{$email_account_user=$_GET["email_account_user"];}
	elseif (isset($_POST["email_account_user"]))			{$email_account_user=$_POST["email_account_user"];}
if (isset($_GET["email_account_pass"]))						{$email_account_pass=$_GET["email_account_pass"];}
	elseif (isset($_POST["email_account_pass"]))			{$email_account_pass=$_POST["email_account_pass"];}
if (isset($_GET["active"]))						{$active=$_GET["active"];}
	elseif (isset($_POST["active"]))			{$active=$_POST["active"];}
if (isset($_GET["email_frequency_check_mins"]))				{$email_frequency_check_mins=$_GET["email_frequency_check_mins"];}
	elseif (isset($_POST["email_frequency_check_mins"]))	{$email_frequency_check_mins=$_POST["email_frequency_check_mins"];}
if (isset($_GET["list_id"]))					{$list_id=$_GET["list_id"];}
	elseif (isset($_POST["list_id"]))			{$list_id=$_POST["list_id"];}
if (isset($_GET["default_list_id"]))			{$default_list_id=$_GET["default_list_id"];}
	elseif (isset($_POST["default_list_id"]))	{$default_list_id=$_POST["default_list_id"];}
if (isset($_GET["group_id"]))					{$group_id=$_GET["group_id"];}
	elseif (isset($_POST["group_id"]))			{$group_id=$_POST["group_id"];}
if (isset($_GET["campaign_id"]))				{$campaign_id=$_GET["campaign_id"];}
	elseif (isset($_POST["campaign_id"]))		{$campaign_id=$_POST["campaign_id"];}
if (isset($_GET["new_account_id"]))				{$new_account_id=$_GET["new_account_id"];}
	elseif (isset($_POST["new_account_id"]))	{$new_account_id=$_POST["new_account_id"];}
if (isset($_GET["source_email_account"]))					{$source_email_account=$_GET["source_email_account"];}
	elseif (isset($_POST["source_email_account"]))			{$source_email_account=$_POST["source_email_account"];}
if (isset($_GET["confirm_deletion"]))						{$confirm_deletion=$_GET["confirm_deletion"];}
	elseif (isset($_POST["confirm_deletion"]))				{$confirm_deletion=$_POST["confirm_deletion"];}
if (isset($_GET["email_replyto_address"]))					{$email_replyto_address=$_GET["email_replyto_address"];}
	elseif (isset($_POST["email_replyto_address"]))			{$email_replyto_address=$_POST["email_replyto_address"];}
if (isset($_GET["email_replyto_address"]))					{$email_replyto_address=$_GET["email_replyto_address"];}
	elseif (isset($_POST["email_replyto_address"]))			{$email_replyto_address=$_POST["email_replyto_address"];}
if (isset($_GET["email_account_type"]))						{$email_account_type=$_GET["email_account_type"];}
	elseif (isset($_POST["email_account_type"]))			{$email_account_type=$_POST["email_account_type"];}
if (isset($_GET["call_handle_method"]))						{$call_handle_method=$_GET["call_handle_method"];}
	elseif (isset($_POST["call_handle_method"]))			{$call_handle_method=$_POST["call_handle_method"];}
if (isset($_GET["agent_search_method"]))					{$agent_search_method=$_GET["agent_search_method"];}
	elseif (isset($_POST["agent_search_method"]))			{$agent_search_method=$_POST["agent_search_method"];}

#############################################
##### START SYSTEM_SETTINGS LOOKUP #####
$stmt = "SELECT use_non_latin,enable_queuemetrics_logging,enable_vtiger_integration,qc_features_active,outbound_autodial_active,sounds_central_control_active,enable_second_webform,user_territories_active,custom_fields_enabled,admin_web_directory,webphone_url,first_login_trigger,hosted_settings,default_phone_registration_password,default_phone_login_password,default_server_password,test_campaign_calls,active_voicemail_server,voicemail_timezones,default_voicemail_timezone,default_local_gmt,campaign_cid_areacodes_enabled,pllb_grouping_limit,did_ra_extensions_enabled,expanded_list_stats,contacts_enabled,alt_log_server_ip,alt_log_dbname,alt_log_login,alt_log_pass,tables_use_alt_log_db,allow_emails,allow_emails,level_8_disable_add FROM system_settings;";
$rslt=mysql_to_mysqli($stmt, $link);
if ($DB) {echo "$stmt\n";}
$qm_conf_ct = mysqli_num_rows($rslt);
if ($qm_conf_ct > 0)
	{
	$row=mysqli_fetch_row($rslt);
	$non_latin =							$row[0];
	$SSenable_queuemetrics_logging =		$row[1];
	$SSenable_vtiger_integration =			$row[2];
	$SSqc_features_active =					$row[3];
	$SSoutbound_autodial_active =			$row[4];
	$SSsounds_central_control_active =		$row[5];
	$SSenable_second_webform =				$row[6];
	$SSuser_territories_active =			$row[7];
	$SScustom_fields_enabled =				$row[8];
	$SSadmin_web_directory =				$row[9];
	$SSwebphone_url =						$row[10];
	$SSfirst_login_trigger =				$row[11];
	$SShosted_settings =					$row[12];
	$SSdefault_phone_registration_password =$row[13];
	$SSdefault_phone_login_password =		$row[14];
	$SSdefault_server_password =			$row[15];
	$SStest_campaign_calls =				$row[16];
	$SSactive_voicemail_server =			$row[17];
	$SSvoicemail_timezones =				$row[18];
	$SSdefault_voicemail_timezone =			$row[19];
	$SSdefault_local_gmt =					$row[20];
	$SScampaign_cid_areacodes_enabled =		$row[21];
	$SSpllb_grouping_limit =				$row[22];
	$SSdid_ra_extensions_enabled =			$row[23];
	$SSexpanded_list_stats =				$row[24];
	$SScontacts_enabled =					$row[25];
	$SSalt_log_server_ip =					$row[26];
	$SSalt_log_dbname =						$row[27];
	$SSalt_log_login =						$row[28];
	$SSalt_log_pass =						$row[29];
	$SStables_use_alt_log_db =				$row[30];
	$SSallow_emails =						$row[31];
	$SSemail_enabled =						$row[32];
	$SSlevel_8_disable_add =				$row[33];
	}
##### END SETTINGS LOOKUP #####
###########################################

if ($non_latin < 1)
	{
	$PHP_AUTH_USER = preg_replace("/[^-_0-9a-zA-Z]/", "",$PHP_AUTH_USER);
	$PHP_AUTH_PW = preg_replace("/[^-_0-9a-zA-Z]/", "",$PHP_AUTH_PW);

	$email_account_id = preg_replace("/[^_0-9a-zA-Z]/","",$email_account_id);
	$email_account_name = preg_replace("/[^ \.\,-\_0-9a-zA-Z]/","",$email_account_name);
	$email_account_description = preg_replace("/[^ \.\,-\_0-9a-zA-Z]/","",$email_account_description);
	$user_group = preg_replace("/[^_0-9a-zA-Z]/","",$user_group);
	$protocol = preg_replace("/[^_0-9a-zA-Z]/","",$protocol);
	$email_account_server = preg_replace("/[^\.\-\_0-9a-zA-Z]/","",$email_account_server);
	$active = preg_replace("/[^_0-9a-zA-Z]/","",$active);
	$email_frequency_check_mins = preg_replace("/[^0-9]/","",$email_frequency_check_mins);
	}	# end of non_latin
else
	{
	$PHP_AUTH_USER = preg_replace("/'|\"|\\\\|;/","",$PHP_AUTH_USER);
	$PHP_AUTH_PW = preg_replace("/'|\"|\\\\|;/","",$PHP_AUTH_PW);
	}
$list_id = preg_replace("/[^0-9]/","",$list_id);

$STARTtime = date("U");
$TODAY = date("Y-m-d");
$NOW_TIME = date("Y-m-d H:i:s");
$date = date("r");
$ip = getenv("REMOTE_ADDR");
$browser = getenv("HTTP_USER_AGENT");
$user = $PHP_AUTH_USER;
$add_copy_disabled=0;

$auth=0;
$auth_message = user_authorization($PHP_AUTH_USER,$PHP_AUTH_PW,'',1);
if ($auth_message == 'GOOD')
	{$auth=1;}

if ($auth < 1)
	{
	$VDdisplayMESSAGE = "Login incorrect, please try again";
	if ($auth_message == 'LOCK')
		{
		$VDdisplayMESSAGE = "Too many login attempts, try again in 15 minutes";
		Header ("Content-type: text/html; charset=utf-8");
		echo "$VDdisplayMESSAGE: |$PHP_AUTH_USER|$auth_message|\n";
		exit;
		}
	Header("WWW-Authenticate: Basic realm=\"CONTACT-CENTER-ADMIN\"");
	Header("HTTP/1.0 401 Unauthorized");
	echo "$VDdisplayMESSAGE: |$PHP_AUTH_USER|$PHP_AUTH_PW|$auth_message|\n";
	exit;
	}

$stmt="SELECT full_name,user_level,user_group,modify_email_accounts from vicidial_users where user='$PHP_AUTH_USER';";
$rslt=mysql_to_mysqli($stmt, $link);
$row=mysqli_fetch_row($rslt);
$LOGfullname =				$row[0];
$LOGuser_level =			$row[1];
$LOGuser_group =			$row[2];
$LOGemails_modify =			$row[3];

if ($LOGemails_modify < 1)
	{
	Header ("Content-type: text/html; charset=utf-8");
	echo "You do not have permissions to modify email accounts\n";
	exit;
	}

if (($LOGuser_level < 9) and ($SSlevel_8_disable_add > 0))
	{$add_copy_disabled++;}

$stmt="SELECT allowed_campaigns,allowed_reports,admin_viewable_groups,admin_viewable_call_times from vicidial_user_groups where user_group='$LOGuser_group';";
$rslt=mysql_to_mysqli($stmt, $link);
$row=mysqli_fetch_row($rslt);
$LOGallowed_campaigns =			$row[0];
$LOGallowed_reports =			$row[1];
$LOGadmin_viewable_groups =		$row[2];
$LOGadmin_viewable_call_times =	$row[3];
$admin_viewable_groupsALL=0;
$LOGadmin_viewable_groupsSQL='';
$whereLOGadmin_viewable_groupsSQL='';
$valLOGadmin_viewable_groupsSQL='';
$vmLOGadmin_viewable_groupsSQL='';
if ( (!preg_match("/\-\-ALL\-\-/i",$LOGadmin_viewable_groups)) and (strlen($LOGadmin_viewable_groups) > 3) )
	{
	$rawLOGadmin_viewable_groupsSQL = preg_replace("/ -/",'',$LOGadmin_viewable_groups);
	$rawLOGadmin_viewable_groupsSQL = preg_replace("/ /","','",$rawLOGadmin_viewable_groupsSQL);
	$LOGadmin_viewable_groupsSQL = "and user_group IN('---ALL---','$rawLOGadmin_viewable_groupsSQL')";
	$whereLOGadmin_viewable_groupsSQL = "where user_group IN('---ALL---','$rawLOGadmin_viewable_groupsSQL')";
	$valLOGadmin_viewable_groupsSQL = "and val.user_group IN('---ALL---','$rawLOGadmin_viewable_groupsSQL')";
	$vmLOGadmin_viewable_groupsSQL = "and vm.user_group IN('---ALL---','$rawLOGadmin_viewable_groupsSQL')";
	}
else 
	{$admin_viewable_groupsALL=1;}
$regexLOGadmin_viewable_groups = " $LOGadmin_viewable_groups ";

$UUgroups_list='';
if ($admin_viewable_groupsALL > 0)
	{$UUgroups_list .= "<option value=\"---ALL---\">Todos los Grupos de Usuarios Admin</option>\n";}
$stmt="SELECT user_group,group_name from vicidial_user_groups $whereLOGadmin_viewable_groupsSQL order by user_group;";
$rslt=mysql_to_mysqli($stmt, $link);
$UUgroups_to_print = mysqli_num_rows($rslt);
$o=0;
while ($UUgroups_to_print > $o) 
	{
	$rowx=mysqli_fetch_row($rslt);
	$UUgroups_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
	$o++;
	}

$stmt="SELECT group_id,group_name from vicidial_inbound_groups where group_handling='EMAIL' $LOGadmin_viewable_groupsSQL order by group_id;";
#	$stmt="SELECT group_id,group_name from vicidial_inbound_groups where group_id NOT IN('AGENTDIRECT') order by group_id";
$rslt=mysql_to_mysqli($stmt, $link);
$Dgroups_to_print = mysqli_num_rows($rslt);
$Dgroups_menu='';
$Dgroups_selected=0;
$o=0;
while ($Dgroups_to_print > $o) 
	{
	$rowx=mysqli_fetch_row($rslt);
	$Dgroups_menu .= "<option ";
	if ($drop_inbound_group == "$rowx[0]") 
		{
		$Dgroups_menu .= "SELECTED ";
		$Dgroups_selected++;
		}
	$Dgroups_menu .= "value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
	$o++;
	}
if ($Dgroups_selected < 1) 
	{$Dgroups_menu .= "<option SELECTED value=\"---NONE---\">---NONE---</option>\n";}
else 
	{$Dgroups_menu .= "<option value=\"---NONE---\">---NONE---</option>\n";}

?>
<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<title>ADMINISTRATION: Campos de Cuentas de Correo Electronico de Marcación
<?php 

##### BEGIN Set variables to make header show properly #####
$ADD =					'0';
$hh =					'admin';
$sh =					'emails';
$LOGast_admin_access =	'1';
$ADMIN =				'admin.php';
$page_width='770';
$section_width='750';
$header_font_size='3';
$subheader_font_size='2';
$subcamp_font_size='2';
$header_selected_bold='<b>';
$header_nonselected_bold='';
$admin_color =		'#FFFF99';
$admin_font =		'BLACK';
$admin_color =		'#E6E6E6';
$emails_color =		'#FFFF99';
$emails_font =		'BLACK';
$emails_color =		'#C6C6C6';
$subcamp_color =	'#C6C6C6';
##### END Set variables to make header show properly #####

require("admin_header.php");

if ($SSemail_enabled < 1)
	{
	echo "ERROR: mensajes de correo electrónico entrantes no están activos en este sistema\n";
	exit;
	}


$NWB = " &nbsp; <a href=\"javascript:openNewWindow('help.php?ADD=99999";
$NWE = "')\"><IMG SRC=\"help.gif\" WIDTH=20 HEIGHT=20 Border=0 ALT=\"AYUDA\" ALIGN=TOP></A>";


if ($DB > 0)
{
echo "$DB,$action,$ip,$user,$copy_option,$field_id,$list_id,$source_email_account,$field_label,$field_name,$field_description,$field_rank,$field_help,$field_type,$field_options,$field_size,$field_max,$field_default,$field_required,$field_cost,$multi_position,$name_position,$field_order";
}

if ($eact=="DELETE" && $confirm_deletion=="yes" && $email_account_id) 
	{
	$del_stmt="delete from vicidial_email_accounts where email_account_id='$email_account_id'";
	$del_rslt=mysql_to_mysqli($del_stmt, $link);
	$message="ACCOUNT $email_account_id DELETED<BR/>";
	$eact="";
	}



if (($REMITIR=="REMITIR" || $REMITIR=="UPDATE") && $email_account_id) 
	{
	$error_msg="";
	if (!$list_id) {$error_msg.="- Default list ID is inválida o nula<BR/>";}
	if (!$email_account_id) {$error_msg.="- Email account ID is inválida o nula<BR/>";}
	if (!$email_account_name) {$error_msg.="- Email account name is inválida o nula<BR/>";}
	if (!$email_account_server) {$error_msg.="- Email account server is inválida o nula<BR/>";}
	if (!$email_account_user) {$error_msg.="- Email account user is inválida o nula<BR/>";}
	if (!$email_account_pass) {$error_msg.="- Email account password is inválida o nula<BR/>";}
	if (!filter_var($email_replyto_address, FILTER_VALIDATE_EMAIL)) {$error_msg.="- Email reply-to address is inválida o nula<BR/>";}

	if (!$error_msg) 
		{
		if ($REMITIR=="REMITIR") 
			{
			if ($add_copy_disabled > 0)
				{
				echo "<br>Usted no tiene permiso para agregar registros en este sistema -system_settings-\n";
				}
			else
				{
				$ins_stmt="INSERT INTO vicidial_email_accounts(email_account_id, email_account_name, email_account_description, user_group, email_replyto_address, protocol, email_account_server, email_account_user, email_account_pass, active, email_frequency_check_mins, group_id, default_list_id, email_account_type, call_handle_method, agent_search_method, list_id, campaign_id) VALUES('$email_account_id', '$email_account_name', '$email_account_description', '$user_group', '$email_replyto_address', '$protocol', '$email_account_server', '$email_account_user', '$email_account_pass', '$active', '$email_frequency_check_mins', '$group_id', '$default_list_id', '$email_account_type', '$call_handle_method', '$agent_search_method', '$list_id', '$campaign_id')";
				$ins_rslt=mysql_to_mysqli($ins_stmt, $link);
				if (mysqli_affected_rows($link)==0) 
					{
					$error_msg.="- There was an unknown error when attempting to create the new account<BR/>";
					if($DB>0) {$error_msg.="<B>$ins_stmt</B><BR>";}
					}
				else 
					{
					$message="CUENTA NUEVA $email_account_id CREADO EXITOSAMENTE";
					$eact="";

					### LOG INSERTION Admin Log Table ###
					$SQL_log = "$ins_stmt|";
					$SQL_log = preg_replace('/;/','',$SQL_log);
					$SQL_log = addslashes($SQL_log);
					$stmt="INSERT INTO vicidial_admin_log set event_date=now(), user='$PHP_AUTH_USER', ip_address='$ip', event_section='EMAIL', event_type='ADD', record_id='$user', event_code='NEW EMAIL ACCOUNT ADDED', event_sql=\"$SQL_log\", event_notes='';";
					if ($DB) {echo "|$stmt|\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
					}
				}
			}
		else
			{
			$upd_stmt="update vicidial_email_accounts set email_account_name='$email_account_name', email_account_description='$email_account_description', user_group='$user_group', protocol='$protocol', email_replyto_address='$email_replyto_address', email_account_server='$email_account_server', email_account_user='$email_account_user', email_account_pass='$email_account_pass', active='$active', email_frequency_check_mins='$email_frequency_check_mins', group_id='$group_id', default_list_id='$default_list_id', email_account_type='$email_account_type', call_handle_method='$call_handle_method', agent_search_method='$agent_search_method', campaign_id='$campaign_id', list_id='$list_id' WHERE email_account_id='$email_account_id'";
			$upd_rslt=mysql_to_mysqli($upd_stmt, $link);
			if (mysqli_affected_rows($link)==0) 
				{
				$error_msg.="- There was an unknown error when attempting to update account $email_account_id<BR/>";
				if($DB>0) {$error_msg.="<B>$upd_stmt</B><BR>";}
				}
			else 
				{
				$message="ACCOUNT $email_account_id MODIFICADO CON ÉXITO";
				# $eact="";

				### LOG INSERTION Admin Log Table ###
				$SQL_log = "$upd_stmt|";
				$SQL_log = preg_replace('/;/','',$SQL_log);
				$SQL_log = addslashes($SQL_log);
				$stmt="INSERT INTO vicidial_admin_log set event_date=now(), user='$PHP_AUTH_USER', ip_address='$ip', event_section='EMAIL', event_type='MODIFY', record_id='$email_account_id', event_code='EMAIL ACCOUNT MODIFIED', event_sql=\"$SQL_log\", event_notes='';";
				if ($DB) {echo "|$stmt|\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
				}
			}
		}
	}
else if ($REMITIR=="COPY") 
	{
	$stmt="select * from vicidial_email_accounts where email_account_id='$source_email_account'";
	$rslt=mysql_to_mysqli($stmt, $link);
	if (mysqli_num_rows($rslt)>0) 
		{
		if ($add_copy_disabled > 0)
			{
			echo "<br>Usted no tiene permiso para agregar registros en este sistema -system_settings-\n";
			}
		else
			{
			$row=mysqli_fetch_array($rslt);
			$ins_stmt="insert into vicidial_email_accounts(email_account_id, email_account_name, email_account_description, user_group, protocol, email_replyto_address, email_account_server, email_account_user, email_account_pass, active, email_frequency_check_mins, group_id, default_list_id, email_account_type, call_handle_method, agent_search_method, list_id, campaign_id) VALUES('$new_account_id', '$email_account_name', '$row[email_account_description]', '$row[user_group]', '$row[protocol]', '$row[email_replyto_address]', '$row[email_account_server]', '$row[email_account_user]', '$row[email_account_pass]', '$row[active]', '$row[email_frequency_check_mins]', '$row[group_id]','$row[default_list_id]', '$row[email_account_type]', '$row[call_handle_method]','$row[agent_search_method]', '$row[list_id]', '$row[campaign_id]')";
			$ins_rslt=mysql_to_mysqli($ins_stmt, $link);
			if (mysqli_affected_rows($link)==0) 
				{
				$error_msg.="- Se ha producido un error desconocido al intentar copiar la nueva cuenta<BR/>";
				if($DB>0) {$error_msg.="<B>$ins_stmt</B><BR>";}
				}
			else
				{
				$message="CUENTA NUEVA $new_account_id COPIADO EXITOSAMENTE DESDE $source_email_account<BR/>";
				$eact="";

				### LOG INSERTION Admin Log Table ###
				$SQL_log = "$ins_stmt|";
				$SQL_log = preg_replace('/;/','',$SQL_log);
				$SQL_log = addslashes($SQL_log);
				$stmt="INSERT INTO vicidial_admin_log set event_date=now(), user='$PHP_AUTH_USER', ip_address='$ip', event_section='EMAIL', event_type='ADD', record_id='$user', event_code='NEW EMAIL ACCOUNT ADDED', event_sql=\"$SQL_log\", event_notes='';";
				if ($DB) {echo "|$stmt|\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
				}
			}
		}
	else
		{
		$error_msg="- Error - correo electrónico de origen no existe<BR/>";
		if($DB>0) {$error_msg.="<B>$stmt</B><BR>";}
		}
	}


################################################################################
##### BEGIN copy fields to a list form
if ($eact == "COPY")
	{
	##### get lists listing for dynamic pulldown
	$stmt="SELECT email_account_id, email_account_name from vicidial_email_accounts order by email_account_id";
	$rsltx=mysql_to_mysqli($stmt, $link);
	$accounts_to_print = mysqli_num_rows($rsltx);
	$accounts_list='';
	$o=0;
	if ($accounts_to_print>0) 
		{
		while ($accounts_to_print > $o)
			{
			$rowx=mysqli_fetch_row($rsltx);
			$accounts_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
			$o++;
			}

		echo "<TABLE><TR><TD>\n";
		echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
		if ($error_msg) {echo "CUENTA NO COPIADA<BR/>Los datos enviados tienen los siguientes errores:<BR/>$error_msg";}
		echo "<br>Crear Nueva Cuenta a partir de Cuenta Existente<form action='$PHP_SELF' method='GET'>\n";
		echo "<input type=hidden name=DB value=\"$DB\">\n";
		echo "<input type=hidden name=action value=COPY_EMAIL_REMITIR>\n";
		echo "<center><TABLE width=$section_width cellspacing=3>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>ID Cuenta para Copiar desde: </td><td align=left><select size=1 name=source_email_account>\n";
		echo "$accounts_list";
		echo "</select></td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Nuevo ID de Cuenta: </td><td align=left><input type=text name=new_account_id value='$new_account_id' size=10 maxlength=20></td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Nuevo Nombre de Cuenta: </td><td align=left><input type=text name=email_account_name size=40 maxlength=100>$NWB#email_accounts-carrier_name$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=REMITIR value='COPY'></td></tr>\n";
		echo "</TABLE></center>\n";
		echo "</TD></TR></TABLE>\n";
		}
	else 
		{
		echo "<TABLE><TR><TD>\n";
		echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
		echo "<br><br>*** No hay cuentas existentes desde las cuales copiar ***\n";
		echo "</TD></TR></TABLE>\n";
		}
	}
### END copy fields to a list form
else if ($eact == "ADD")
	{
	if ( ($LOGemails_modify==1) )
		{
		$stmt="SELECT campaign_id,campaign_name from vicidial_campaigns $whereLOGallowed_campaignsSQL order by campaign_id;";
		$rslt=mysql_to_mysqli($stmt, $link);
		$campaigns_to_print = mysqli_num_rows($rslt);
		$campaigns_list='';
		$o=0;
		while ($campaigns_to_print > $o) 
			{
			$rowx=mysqli_fetch_row($rslt);
			$campaigns_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
			$o++;
			}

		##### get in-groups listings for dynamic pulldown
		$stmt="SELECT group_id,group_name from vicidial_inbound_groups $whereLOGadmin_viewable_groupsSQL order by group_id;";
		$rslt=mysql_to_mysqli($stmt, $link);
		$Xgroups_to_print = mysqli_num_rows($rslt);
		$Xgroups_menu='';
		$Xgroups_selected=0;
		$FXgroups_menu='';
		$FXgroups_selected=0;
		$o=0;
		while ($Xgroups_to_print > $o) 
			{
			$rowx=mysqli_fetch_row($rslt);
			$Xgroups_menu .= "<option ";
			$FXgroups_menu .= "<option ";
			if ($user_route_settings_ingroup == "$rowx[0]") 
				{
				$Xgroups_menu .= "SELECTED ";
				$Xgroups_selected++;
				}
			if ($filter_user_route_settings_ingroup == "$rowx[0]") 
				{
				$FXgroups_menu .= "SELECTED ";
				$FXgroups_selected++;
				}
			$Xgroups_menu .= "value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
			$FXgroups_menu .= "value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
			$o++;
			}
		if ($Xgroups_selected < 1) 
			{$Xgroups_menu .= "<option SELECTED value=\"---NONE---\">---NONE---</option>\n";}
		else 
			{$Xgroups_menu .= "<option value=\"---NONE---\">---NONE---</option>\n";}
		if ($FXgroups_selected < 1) 
			{$FXgroups_menu .= "<option SELECTED value=\"---NONE---\">---NONE---</option>\n";}
		else 
			{$FXgroups_menu .= "<option value=\"---NONE---\">---NONE---</option>\n";}


		##### get in-groups listings for dynamic pulldown
		$stmt="SELECT group_id,group_name from vicidial_inbound_groups where group_id NOT IN('AGENTDIRECT') $LOGadmin_viewable_groupsSQL order by group_id;";
		$rslt=mysql_to_mysqli($stmt, $link);
		$Dgroups_to_print = mysqli_num_rows($rslt);
		$Dgroups_menu='';
		$Dgroups_selected=0;
		$FDgroups_menu='';
		$FDgroups_selected=0;
		$o=0;
		while ($Dgroups_to_print > $o) 
			{
			$rowx=mysqli_fetch_row($rslt);
			$Dgroups_menu .= "<option ";
			$FDgroups_menu .= "<option ";
			if ($group_id == "$rowx[0]") 
				{
				$Dgroups_menu .= "SELECTED ";
				$Dgroups_selected++;
				}
			if ($filter_group_id == "$rowx[0]") 
				{
				$FDgroups_menu .= "SELECTED ";
				$FDgroups_selected++;
				}
			$Dgroups_menu .= "value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
			$FDgroups_menu .= "value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
			$o++;
			}
		if ($Dgroups_selected < 1) 
			{$Dgroups_menu .= "<option SELECTED value=\"---NONE---\">---NONE---</option>\n";}
		else 
			{$Dgroups_menu .= "<option value=\"---NONE---\">---NONE---</option>\n";}
		if ($FDgroups_selected < 1) 
			{$FDgroups_menu .= "<option SELECTED value=\"---NONE---\">---NONE---</option>\n";}
		else 
			{$FDgroups_menu .= "<option value=\"---NONE---\">---NONE---</option>\n";}

		
		echo "<TABLE>\n";
		echo "<TR><TD>\n";
		echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
		if ($error_msg) {echo "CUENTA NO AGREGADA<BR/>Los datos enviados tienen los siguientes errores:<BR/>$error_msg";}
		echo "<br>AÑADIR NUEVA CUENTA DE CORREO ELECTRÓNICO ENTRANTE<form action='$PHP_SELF' method='GET'>\n";
		echo "<center><TABLE width=$section_width cellspacing=3>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Cuenta Correo Electrónico ID: </td><td align=left><input type=text name=email_account_id size=15 maxlength=20 value='$email_account_id'>$NWB#email_accounts-email_account_id$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Cuenta Correo Electrónico Nombre: </td><td align=left><input type=text name=email_account_name size=40 maxlength=100 value='$email_account_name'>$NWB#email_accounts-email_account_name$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Activo: </td><td align=left><select size=1 name=active><option>Y</option><option SELECTED>N</option></select>$NWB#email_accounts-email_account_active$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Cuenta Correo Electronico Descripción: </td><td align=left><input type=text name=email_account_description size=70 maxlength=255 value='$email_account_description'>$NWB#email_accounts-email_account_description$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>cuenta Correo Electrónico Tipo: </td><td align=left><select size=1 name=email_account_type><option>INBOUND</option></select>$NWB#email_accounts-email_account_type$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Admin Grupo de Usuarios: </td><td align=left><select size=1 name=user_group>\n";
		echo "$UUgroups_list";
		echo "<option SELECTED value=\"---ALL---\">Todos los Grupos de Usuarios Admin</option>\n";
		echo "</select>$NWB#email_accounts-admin_user_group$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Cuenta Correo Electrónico Protocolo: </td><td align=left><select size=1 name=protocol><option SELECTED>IMAP</option><option>POP3</option></select>$NWB#email_accounts-protocol$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Correo Electrónico Dirección de Respuesta: </td><td align=left><input type=text name=email_replyto_address size=70 maxlength=255 value='$email_replyto_address'>$NWB#email_accounts-email_replyto_address$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Cuenta Correo Electrónico Servidor: </td><td align=left><input type=text name=email_account_server size=70 maxlength=255 value='$email_account_server'>$NWB#email_accounts-email_account_server$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Cuenta Correo Electrónico Usuario: </td><td align=left><input type=text name=email_account_user size=30 maxlength=255 value='$email_account_user'>$NWB#email_accounts-email_account_user$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Cuenta Correo Electrónico Contraseña: </td><td align=left><input type=text name=email_account_pass size=30 maxlength=100 value='$email_account_pass'>$NWB#email_accounts-email_account_pass$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Correo Electronico Frequency Check Rate (mins): </td><td align=left><select name='email_frequency_check_mins'>";
		$i=5;
		while ($i<=60) 
			{
			echo "<option value='$i'>$i</option>";
			$i+=5;
			}
		echo "</select>$NWB#email_accounts-email_frequency_check_mins$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right><a href=\"admin.php?ADD=1000\">Grupo-Entrada ID</a>: </td><td align=left><select size=1 name=group_id>";
		echo "$Dgroups_menu";
		echo "</select>$NWB#email_accounts-in_group$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right><a href=\"admin.php?ADD=1000\">Lista de ID Predeterminada</a>: </td><td align=left><input type=text name=default_list_id size=20 maxlength=255 value='$default_list_id'>$NWB#email_accounts-default_list_id$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Grupo-Entrada Método Manejo llamada : </td><td align=left><select size=1 name=call_handle_method><option>EMAIL</option><option>EMAILLOOKUP</option><option>EMAILLOOKUPRL</option><option>EMAILLOOKUPRC</option><option SELECTED>$call_handle_method</option></select>$NWB#email_accounts-call_handle_method$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Grupo-Entrada Método Búsqueda Agente : </td><td align=left><select size=1 name=agent_search_method><option value=\"LB\">LB - Load Balanced</option><option value=\"LO\">LO - Load Balanced Overflow</option><option value=\"SO\">SO - Server Only</option><option SELECTED>$agent_search_method</option></select>$NWB#email_accounts-agent_search_method$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Grupo-Entrada ID Lista : </td><td align=left><input type=text name=list_id size=14 maxlength=14 value=\"$list_id\">$NWB#email_accounts-ingroup_list_id$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Grupo-Entrada ID Campaña : </td><td align=left><select size=1 name=campaign_id>\n";
		echo "$campaigns_list";
		echo "<option SELECTED>$campaign_id</option>\n";
		echo "</select>$NWB#email_accounts-ingroup_campaign_id$NWE</td></tr>\n";
		
		echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=REMITIR VALUE=REMITIR><input type=hidden name='eact' value='ADD'></td></tr>\n";
		echo "</TABLE></center></form>\n";
		}
	else
		{
		echo "Usted no tiene autorización para ver esta página\n";
		exit;
		}
	}
else if (($eact=="DELETE" || $eact=="UPDATE") && $email_account_id)  
	{
	if ( ($LOGemails_modify==1) )
		{
		$stmt="SELECT * from vicidial_email_accounts where email_account_id='$email_account_id'";
		$rslt=mysql_to_mysqli($stmt, $link);
		$row=mysqli_fetch_array($rslt);

		$email_account_id=$row["email_account_id"];
		$email_account_name=$row["email_account_name"];
		$email_account_description=$row["email_account_description"];
		$user_group=$row["user_group"];
		$protocol=$row["protocol"];
		$email_replyto_address=$row["email_replyto_address"];
		$email_account_server=$row["email_account_server"];
		$email_account_user=$row["email_account_user"];
		$email_account_pass=$row["email_account_pass"];
		$active=$row["active"];
		$email_frequency_check_mins=$row["email_frequency_check_mins"];
		$group_id=$row["group_id"];
		$call_handle_method=$row["call_handle_method"];
		$agent_search_method=$row["agent_search_method"];
		$campaign_id=$row["campaign_id"];
		$list_id=$row["list_id"];
		$default_list_id=$row["default_list_id"];
		$email_account_type=$row["email_account_type"];

		if ($eact=="DELETE" && $email_account_id)  
			{
			echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
			echo "<br><B>CONFIRMAR BORRADO DE CUENTA DE CORREO ELECTRÓNICO ENTRANTE $email_account_id</B><BR>\n";
			echo "<a href='$PHP_SELF?eact=DELETE&email_account_id=$email_account_id&confirm_deletion=yes'>Clic para borrar la cuenta $email_account_id</a>\n";
			echo "</font>";
			}
		$stmt="SELECT campaign_id,campaign_name from vicidial_campaigns $whereLOGallowed_campaignsSQL order by campaign_id;";
		$rslt=mysql_to_mysqli($stmt, $link);
		$campaigns_to_print = mysqli_num_rows($rslt);
		$campaigns_list='';
		$o=0;
		while ($campaigns_to_print > $o) 
			{
			$rowx=mysqli_fetch_row($rslt);
			$campaigns_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
			$o++;
			}

		##### get in-groups listings for dynamic pulldown
		$stmt="SELECT group_id,group_name from vicidial_inbound_groups $whereLOGadmin_viewable_groupsSQL order by group_id;";
		$rslt=mysql_to_mysqli($stmt, $link);
		$Xgroups_to_print = mysqli_num_rows($rslt);
		$Xgroups_menu='';
		$Xgroups_selected=0;
		$FXgroups_menu='';
		$FXgroups_selected=0;
		$o=0;
		while ($Xgroups_to_print > $o) 
			{
			$rowx=mysqli_fetch_row($rslt);
			$Xgroups_menu .= "<option ";
			$FXgroups_menu .= "<option ";
			if ($user_route_settings_ingroup == "$rowx[0]") 
				{
				$Xgroups_menu .= "SELECTED ";
				$Xgroups_selected++;
				}
			if ($filter_user_route_settings_ingroup == "$rowx[0]") 
				{
				$FXgroups_menu .= "SELECTED ";
				$FXgroups_selected++;
				}
			$Xgroups_menu .= "value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
			$FXgroups_menu .= "value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
			$o++;
			}
		if ($Xgroups_selected < 1) 
			{$Xgroups_menu .= "<option SELECTED value=\"---NONE---\">---NONE---</option>\n";}
		else 
			{$Xgroups_menu .= "<option value=\"---NONE---\">---NONE---</option>\n";}
		if ($FXgroups_selected < 1) 
			{$FXgroups_menu .= "<option SELECTED value=\"---NONE---\">---NONE---</option>\n";}
		else 
			{$FXgroups_menu .= "<option value=\"---NONE---\">---NONE---</option>\n";}


		##### get in-groups listings for dynamic pulldown
		$stmt="SELECT group_id,group_name from vicidial_inbound_groups where group_id NOT IN('AGENTDIRECT') $LOGadmin_viewable_groupsSQL order by group_id;";
		$rslt=mysql_to_mysqli($stmt, $link);
		$Dgroups_to_print = mysqli_num_rows($rslt);
		$Dgroups_menu='';
		$Dgroups_selected=0;
		$FDgroups_menu='';
		$FDgroups_selected=0;
		$o=0;
		while ($Dgroups_to_print > $o) 
			{
			$rowx=mysqli_fetch_row($rslt);
			$Dgroups_menu .= "<option ";
			$FDgroups_menu .= "<option ";
			if ($group_id == "$rowx[0]") 
				{
				$Dgroups_menu .= "SELECTED ";
				$Dgroups_selected++;
				}
			if ($filter_group_id == "$rowx[0]") 
				{
				$FDgroups_menu .= "SELECTED ";
				$FDgroups_selected++;
				}
			$Dgroups_menu .= "value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
			$FDgroups_menu .= "value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
			$o++;
			}
		if ($Dgroups_selected < 1) 
			{$Dgroups_menu .= "<option SELECTED value=\"---NONE---\">---NONE---</option>\n";}
		else 
			{$Dgroups_menu .= "<option value=\"---NONE---\">---NONE---</option>\n";}
		if ($FDgroups_selected < 1) 
			{$FDgroups_menu .= "<option SELECTED value=\"---NONE---\">---NONE---</option>\n";}
		else 
			{$FDgroups_menu .= "<option value=\"---NONE---\">---NONE---</option>\n";}

		## Get unhandled count
		$stmt="select count(*) From vicidial_email_list where status='NEW' and email_account_id='$email_account_id'";
		$rslt=mysql_to_mysqli($stmt, $link);
		$row=mysqli_fetch_row($rslt);
		$unhandled_emails=$row[0];
		
		echo "<TABLE>\n";
		echo "<TR><TD>\n";
		echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
		if ($message) {echo "<B>$message</B><BR>";}
		if ($error_msg) {echo "CUENTA NO ACTUALIZADA<BR/>Los datos enviados tienen los siguientes errores:<BR/>$error_msg";}
		echo "<br>ACTUALIZAR CUENTA CORREO ELECTRÓNICO ENTRANTE<form action='$PHP_SELF' method='GET'>\n";
		echo "<center><TABLE width=$section_width cellspacing=3>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Cuenta Correo Electrónico ID: </td><td align=left><input type=hidden name=email_account_id value='$email_account_id'><B>$email_account_id$NWB#email_accounts-email_account_id$NWE</B></td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Cuenta Correo Electrónico Nombre: </td><td align=left><input type=text name=email_account_name size=40 maxlength=100 value='$email_account_name'>$NWB#email_accounts-email_account_name$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Activo: </td><td align=left><select size=1 name=active>";
		echo "<option value='$active' selected>$active</option>";
		echo "<option>Y</option><option>N</option></select>$NWB#email_accounts-email_account_active$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Cuenta Correo Electronico Descripción: </td><td align=left><input type=text name=email_account_description size=70 maxlength=255 value='$email_account_description'>$NWB#email_accounts-email_account_description$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>cuenta Correo Electrónico Tipo: </td><td align=left><select size=1 name=email_account_type><option value='$email_account_type' selected>$email_account_type</option><option>INBOUND</option></select>$NWB#email_accounts-email_account_type$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Admin Grupo de Usuarios: </td><td align=left><select size=1 name=user_group>\n";
		echo "<option value='$user_group' selected>$user_group</option>";
		echo "$UUgroups_list";
		echo "<option SELECTED value=\"---ALL---\">Todos los Grupos de Usuarios Admin</option>\n";
		echo "</select>$NWB#email_accounts-admin_user_group$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Cuenta Correo Electrónico Protocolo: </td><td align=left><select size=1 name=protocol><option>IMAP</option><option>POP3</option><option SELECTED>$protocol</option></select>$NWB#email_accounts-protocol$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Correo Electrónico Dirección de Respuesta: </td><td align=left><input type=text name=email_replyto_address size=70 maxlength=255 value='$email_replyto_address'>$NWB#email_accounts-email_replyto_address$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Cuenta Correo Electrónico Servidor: </td><td align=left><input type=text name=email_account_server size=70 maxlength=255 value='$email_account_server'>$NWB#email_accounts-email_account_server$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Cuenta Correo Electrónico Usuario: </td><td align=left><input type=text name=email_account_user size=30 maxlength=255 value='$email_account_user'>$NWB#email_accounts-email_account_user$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Cuenta Correo Electrónico Contraseña: </td><td align=left><input type=text name=email_account_pass size=30 maxlength=100 value='$email_account_pass'>$NWB#email_accounts-email_account_pass$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Correo Electronico Frequency Check Rate (mins): </td><td align=left><select name='email_frequency_check_mins'>";
		echo "<option value='$email_frequency_check_mins' selected>$email_frequency_check_mins</option>";
		$i=5;
		while ($i<=60) 
			{
			echo "<option value='$i'>$i</option>";
			$i+=5;
			}
		echo "</select>$NWB#email_accounts-email_frequency_check_mins$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right><a href=\"admin.php?ADD=3811&group_id=$group_id\">Grupo-Entrada ID</a>: </td><td align=left><select size=1 name=group_id>";
		echo "$Dgroups_menu";
		echo "<option value='$group_id' selected>$group_id</option></select>$NWB#email_accounts-in_group$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right><a href=\"admin.php?ADD=1000\">Lista de ID Predeterminada</a>: </td><td align=left><input type=text name=default_list_id size=20 maxlength=255 value='$default_list_id'>$NWB#email_accounts-default_list_id$NWE</td></tr>\n";

###############
		echo "<tr bgcolor=#B6D3FC><td align=right>Grupo-Entrada Método Manejo llamada : </td><td align=left><select size=1 name=call_handle_method><option>EMAIL</option><option>EMAILLOOKUP</option><option>EMAILLOOKUPRL</option><option>EMAILLOOKUPRC</option><option SELECTED>$call_handle_method</option></select>$NWB#email_accounts-call_handle_method$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Grupo-Entrada Método Búsqueda Agente : </td><td align=left><select size=1 name=agent_search_method><option value=\"LB\">LB - Load Balanced</option><option value=\"LO\">LO - Load Balanced Overflow</option><option value=\"SO\">SO - Server Only</option><option SELECTED>$agent_search_method</option></select>$NWB#email_accounts-agent_search_method$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Grupo-Entrada ID Lista : </td><td align=left><input type=text name=list_id size=14 maxlength=14 value=\"$list_id\">$NWB#email_accounts-ingroup_list_id$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Grupo-Entrada ID Campaña : </td><td align=left><select size=1 name=campaign_id>\n";
		echo "$campaigns_list";
		echo "<option SELECTED>$campaign_id</option>\n";
		echo "</select>$NWB#email_accounts-ingroup_campaign_id$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Emails no-Atendidos: </td><td align=left><B>$unhandled_emails</B></td></tr>\n";
################
		
		echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=REMITIR VALUE=UPDATE><input type=hidden name='eact' value='UPDATE'></td></tr>\n";
		echo "</TABLE><BR><BR>";
		if ($LOGuser_level >= 9)
			{
			echo "<br><br><a href=\"admin.php?ADD=720000000000000&category=EMAIL&stage=$email_account_id\">Haga clic aquí para ver los cambios de administrador para este registro</FONT>\n";
			}
		echo "<BR><BR><a href='$PHP_SELF?eact=DELETE&email_account_id=$email_account_id'>DELETE EMAIL ACCOUNT</a></center></form>\n";
		}
	else
		{
		echo "Usted no tiene autorización para ver esta página\n";
		exit;
		}
	}
else 
	{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	if ($message) {echo "<B>$message</B><BR>";}
	echo "<br>LISTADOS DE CUENTA DE CORREO ELECTRÓNICO ENTRANTE:\n";
	echo "<center><TABLE width=750 cellspacing=0 cellpadding=1>\n";
	echo "<TR BGCOLOR=BLACK>\n";
	echo "<TD><font size=1 color=white>ACCOUNT ID</TD>\n";
	echo "<TD><font size=1 color=white>ACCOUNT NAME</TD>\n";
	echo "<TD><font size=1 color=white>DESCRIPCIÓN</TD>\n";
	echo "<TD><font size=1 color=white>REPLY-TO ADDRESS</TD>\n";
	echo "<TD><font size=1 color=white>PROTOCOL</TD>\n";
	echo "<TD><font size=1 color=white>SERVER</TD>\n";
	echo "<TD><font size=1 color=white>FREQUENCY</TD>\n";
	echo "<TD><font size=1 color=white>ACTIVO</TD>\n";
	echo "<TD><font size=1 color=white>MENSAJES NO LEÍDOS</TD>\n";
	echo "<TD><font size=1 color=white>MODIFICAR</TD></tr>\n";

	$stmt="SELECT email_account_id, email_account_name, email_account_description, email_replyto_address, protocol, email_account_server, email_frequency_check_mins, active from vicidial_email_accounts $whereLOGadmin_viewable_groupsSQL order by email_account_id;";
	$rslt=mysql_to_mysqli($stmt, $link);
	$accounts_to_print = mysqli_num_rows($rslt);
	$o=0;
	while ($accounts_to_print > $o) 
		{
		$row=mysqli_fetch_array($rslt);

		## Get unhandled count
		$ct_stmt="select count(*) From vicidial_email_list where status='NEW' and email_account_id='$row[email_account_id]'";
		$ct_rslt=mysql_to_mysqli($ct_stmt, $link);
		$ct_row=mysqli_fetch_row($ct_rslt);
		$unhandled_emails=$ct_row[0];
		
		if (preg_match("/1$|3$|5$|7$|9$/i", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><font size=1><a href=\"$PHP_SELF?eact=UPDATE&email_account_id=$row[email_account_id]\">$row[email_account_id]</a></font></td>";
		echo "<td><font size=1> $row[email_account_name]</font></td>";
		echo "<td><font size=1> $row[email_account_description]</font></td>";
		echo "<td><font size=1> $row[email_replyto_address]</font></td>";
		echo "<td><font size=1> $row[protocol]</font></td>";
		echo "<td><font size=1> $row[email_account_server]</font></td>";
		echo "<td><font size=1> $row[email_frequency_check_mins] mins</font></td>";
		echo "<td><font size=1> $row[active]</font></td>";
		echo "<td><font size=1> $unhandled_emails</font></td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?eact=UPDATE&email_account_id=$row[email_account_id]\">MODIFICAR</a></font></td></tr>\n";
		$o++;
		}

	echo "</table></font>";
	}


$ENDtime = date("U");
$RUNtime = ($ENDtime - $STARTtime);
echo "\n\n\n<br><br><br>\n<font size=1> runtime: $RUNtime seconds &nbsp; &nbsp; &nbsp; &nbsp; Versión: $admin_version &nbsp; &nbsp; Build: $build</font>";

?>

</body>
</html>
