<?
# admin.php - VICIDIAL administration page
# 
# 
# Copyright (C) 2006  Matt Florell <vicidial@gmail.com>    LICENSE: GPLv2
#

require("dbconnect.php");

$PHP_AUTH_USER=$_SERVER['PHP_AUTH_USER'];
$PHP_AUTH_PW=$_SERVER['PHP_AUTH_PW'];
$PHP_SELF=$_SERVER['PHP_SELF'];
if (isset($_GET["ADD"]))				{$ADD=$_GET["ADD"];}
	elseif (isset($_POST["ADD"]))		{$ADD=$_POST["ADD"];}
if (isset($_GET["groups"]))				{$groups=$_GET["groups"];}
	elseif (isset($_POST["groups"]))		{$groups=$_POST["groups"];}
if (isset($_GET["remote_agent_id"]))				{$remote_agent_id=$_GET["remote_agent_id"];}
	elseif (isset($_POST["remote_agent_id"]))		{$remote_agent_id=$_POST["remote_agent_id"];}
if (isset($_GET["user"]))				{$user=$_GET["user"];}
	elseif (isset($_POST["user"]))		{$user=$_POST["user"];}
if (isset($_GET["pass"]))				{$pass=$_GET["pass"];}
	elseif (isset($_POST["pass"]))		{$pass=$_POST["pass"];}
if (isset($_GET["full_name"]))				{$full_name=$_GET["full_name"];}
	elseif (isset($_POST["full_name"]))		{$full_name=$_POST["full_name"];}
if (isset($_GET["user_level"]))				{$user_level=$_GET["user_level"];}
	elseif (isset($_POST["user_level"]))		{$user_level=$_POST["user_level"];}
if (isset($_GET["user_group"]))				{$user_group=$_GET["user_group"];}
	elseif (isset($_POST["user_group"]))		{$user_group=$_POST["user_group"];}
if (isset($_GET["campaign_id"]))				{$campaign_id=$_GET["campaign_id"];}
	elseif (isset($_POST["campaign_id"]))		{$campaign_id=$_POST["campaign_id"];}
if (isset($_GET["campaign_name"]))				{$campaign_name=$_GET["campaign_name"];}
	elseif (isset($_POST["campaign_name"]))		{$campaign_name=$_POST["campaign_name"];}
if (isset($_GET["active"]))				{$active=$_GET["active"];}
	elseif (isset($_POST["active"]))		{$active=$_POST["active"];}
if (isset($_GET["park_ext"]))				{$park_ext=$_GET["park_ext"];}
	elseif (isset($_POST["park_ext"]))		{$park_ext=$_POST["park_ext"];}
if (isset($_GET["park_file_name"]))				{$park_file_name=$_GET["park_file_name"];}
	elseif (isset($_POST["park_file_name"]))		{$park_file_name=$_POST["park_file_name"];}
if (isset($_GET["web_form_address"]))				{$web_form_address=$_GET["web_form_address"];}
	elseif (isset($_POST["web_form_address"]))		{$web_form_address=$_POST["web_form_address"];}
if (isset($_GET["allow_closers"]))				{$allow_closers=$_GET["allow_closers"];}
	elseif (isset($_POST["allow_closers"]))		{$allow_closers=$_POST["allow_closers"];}
if (isset($_GET["hopper_level"]))				{$hopper_level=$_GET["hopper_level"];}
	elseif (isset($_POST["hopper_level"]))		{$hopper_level=$_POST["hopper_level"];}
if (isset($_GET["auto_dial_level"]))				{$auto_dial_level=$_GET["auto_dial_level"];}
	elseif (isset($_POST["auto_dial_level"]))		{$auto_dial_level=$_POST["auto_dial_level"];}
if (isset($_GET["next_agent_call"]))				{$next_agent_call=$_GET["next_agent_call"];}
	elseif (isset($_POST["next_agent_call"]))		{$next_agent_call=$_POST["next_agent_call"];}
if (isset($_GET["local_call_time"]))				{$local_call_time=$_GET["local_call_time"];}
	elseif (isset($_POST["local_call_time"]))		{$local_call_time=$_POST["local_call_time"];}
if (isset($_GET["voicemail_ext"]))				{$voicemail_ext=$_GET["voicemail_ext"];}
	elseif (isset($_POST["voicemail_ext"]))		{$voicemail_ext=$_POST["voicemail_ext"];}
if (isset($_GET["submit"]))				{$submit=$_GET["submit"];}
	elseif (isset($_POST["submit"]))		{$submit=$_POST["submit"];}
if (isset($_GET["list_id"]))				{$list_id=$_GET["list_id"];}
	elseif (isset($_POST["list_id"]))		{$list_id=$_POST["list_id"];}
if (isset($_GET["list_name"]))				{$list_name=$_GET["list_name"];}
	elseif (isset($_POST["list_name"]))		{$list_name=$_POST["list_name"];}
if (isset($_GET["group_id"]))				{$group_id=$_GET["group_id"];}
	elseif (isset($_POST["group_id"]))		{$group_id=$_POST["group_id"];}
if (isset($_GET["group_name"]))				{$group_name=$_GET["group_name"];}
	elseif (isset($_POST["group_name"]))		{$group_name=$_POST["group_name"];}
if (isset($_GET["group_color"]))				{$group_color=$_GET["group_color"];}
	elseif (isset($_POST["group_color"]))		{$group_color=$_POST["group_color"];}
if (isset($_GET["fronter_display"]))				{$fronter_display=$_GET["fronter_display"];}
	elseif (isset($_POST["fronter_display"]))		{$fronter_display=$_POST["fronter_display"];}
if (isset($_GET["user_start"]))				{$user_start=$_GET["user_start"];}
	elseif (isset($_POST["user_start"]))		{$user_start=$_POST["user_start"];}
if (isset($_GET["number_of_lines"]))				{$number_of_lines=$_GET["number_of_lines"];}
	elseif (isset($_POST["number_of_lines"]))		{$number_of_lines=$_POST["number_of_lines"];}
if (isset($_GET["server_ip"]))				{$server_ip=$_GET["server_ip"];}
	elseif (isset($_POST["server_ip"]))		{$server_ip=$_POST["server_ip"];}
if (isset($_GET["conf_exten"]))				{$conf_exten=$_GET["conf_exten"];}
	elseif (isset($_POST["conf_exten"]))		{$conf_exten=$_POST["conf_exten"];}
if (isset($_GET["status"]))				{$status=$_GET["status"];}
	elseif (isset($_POST["status"]))		{$status=$_POST["status"];}
if (isset($_GET["group_name"]))				{$group_name=$_GET["group_name"];}
	elseif (isset($_POST["group_name"]))		{$group_name=$_POST["group_name"];}
if (isset($_GET["dial_status_a"]))				{$dial_status_a=$_GET["dial_status_a"];}
	elseif (isset($_POST["dial_status_a"]))		{$dial_status_a=$_POST["dial_status_a"];}
if (isset($_GET["dial_status_b"]))				{$dial_status_b=$_GET["dial_status_b"];}
	elseif (isset($_POST["dial_status_b"]))		{$dial_status_b=$_POST["dial_status_b"];}
if (isset($_GET["dial_status_c"]))				{$dial_status_c=$_GET["dial_status_c"];}
	elseif (isset($_POST["dial_status_c"]))		{$dial_status_c=$_POST["dial_status_c"];}
if (isset($_GET["dial_status_d"]))				{$dial_status_d=$_GET["dial_status_d"];}
	elseif (isset($_POST["dial_status_d"]))		{$dial_status_d=$_POST["dial_status_d"];}
if (isset($_GET["dial_status_e"]))				{$dial_status_e=$_GET["dial_status_e"];}
	elseif (isset($_POST["dial_status_e"]))		{$dial_status_e=$_POST["dial_status_e"];}
if (isset($_GET["lead_order"]))				{$lead_order=$_GET["lead_order"];}
	elseif (isset($_POST["lead_order"]))		{$lead_order=$_POST["lead_order"];}
if (isset($_GET["dial_timeout"]))				{$dial_timeout=$_GET["dial_timeout"];}
	elseif (isset($_POST["dial_timeout"]))		{$dial_timeout=$_POST["dial_timeout"];}
if (isset($_GET["dial_prefix"]))				{$dial_prefix=$_GET["dial_prefix"];}
	elseif (isset($_POST["dial_prefix"]))		{$dial_prefix=$_POST["dial_prefix"];}
if (isset($_GET["campaign_cid"]))				{$campaign_cid=$_GET["campaign_cid"];}
	elseif (isset($_POST["campaign_cid"]))		{$campaign_cid=$_POST["campaign_cid"];}
if (isset($_GET["campaign_vdad_exten"]))				{$campaign_vdad_exten=$_GET["campaign_vdad_exten"];}
	elseif (isset($_POST["campaign_vdad_exten"]))		{$campaign_vdad_exten=$_POST["campaign_vdad_exten"];}
if (isset($_GET["campaign_rec_exten"]))				{$campaign_rec_exten=$_GET["campaign_rec_exten"];}
	elseif (isset($_POST["campaign_rec_exten"]))		{$campaign_rec_exten=$_POST["campaign_rec_exten"];}
if (isset($_GET["campaign_recording"]))				{$campaign_recording=$_GET["campaign_recording"];}
	elseif (isset($_POST["campaign_recording"]))		{$campaign_recording=$_POST["campaign_recording"];}
if (isset($_GET["campaign_rec_filename"]))				{$campaign_rec_filename=$_GET["campaign_rec_filename"];}
	elseif (isset($_POST["campaign_rec_filename"]))		{$campaign_rec_filename=$_POST["campaign_rec_filename"];}
if (isset($_GET["hotkey"]))				{$hotkey=$_GET["hotkey"];}
	elseif (isset($_POST["hotkey"]))		{$hotkey=$_POST["hotkey"];}
if (isset($_GET["reset_list"]))				{$reset_list=$_GET["reset_list"];}
	elseif (isset($_POST["reset_list"]))		{$reset_list=$_POST["reset_list"];}
if (isset($_GET["old_campaign_id"]))				{$old_campaign_id=$_GET["old_campaign_id"];}
	elseif (isset($_POST["old_campaign_id"]))		{$old_campaign_id=$_POST["old_campaign_id"];}
if (isset($_GET["OLDuser_group"]))				{$OLDuser_group=$_GET["OLDuser_group"];}
	elseif (isset($_POST["OLDuser_group"]))		{$OLDuser_group=$_POST["OLDuser_group"];}
if (isset($_GET["status_name"]))				{$status_name=$_GET["status_name"];}
	elseif (isset($_POST["status_name"]))		{$status_name=$_POST["status_name"];}
if (isset($_GET["selectable"]))				{$selectable=$_GET["selectable"];}
	elseif (isset($_POST["selectable"]))		{$selectable=$_POST["selectable"];}
if (isset($_GET["HKstatus"]))				{$HKstatus=$_GET["HKstatus"];}
	elseif (isset($_POST["HKstatus"]))		{$HKstatus=$_POST["HKstatus"];}
if (isset($_GET["force_logout"]))				{$force_logout=$_GET["force_logout"];}
	elseif (isset($_POST["force_logout"]))		{$force_logout=$_POST["force_logout"];}
if (isset($_GET["phone_login"]))				{$phone_login=$_GET["phone_login"];}
	elseif (isset($_POST["phone_login"]))		{$phone_login=$_POST["phone_login"];}
if (isset($_GET["phone_pass"]))				{$phone_pass=$_GET["phone_pass"];}
	elseif (isset($_POST["phone_pass"]))		{$phone_pass=$_POST["phone_pass"];}
if (isset($_GET["delete_users"]))				{$delete_users=$_GET["delete_users"];}
	elseif (isset($_POST["delete_users"]))		{$delete_users=$_POST["delete_users"];}
if (isset($_GET["delete_user_groups"]))				{$delete_user_groups=$_GET["delete_user_groups"];}
	elseif (isset($_POST["delete_user_groups"]))		{$delete_user_groups=$_POST["delete_user_groups"];}
if (isset($_GET["delete_lists"]))				{$delete_lists=$_GET["delete_lists"];}
	elseif (isset($_POST["delete_lists"]))		{$delete_lists=$_POST["delete_lists"];}
if (isset($_GET["delete_campaigns"]))				{$delete_campaigns=$_GET["delete_campaigns"];}
	elseif (isset($_POST["delete_campaigns"]))		{$delete_campaigns=$_POST["delete_campaigns"];}
if (isset($_GET["delete_ingroups"]))				{$delete_ingroups=$_GET["delete_ingroups"];}
	elseif (isset($_POST["delete_ingroups"]))		{$delete_ingroups=$_POST["delete_ingroups"];}
if (isset($_GET["delete_remote_agents"]))				{$delete_remote_agents=$_GET["delete_remote_agents"];}
	elseif (isset($_POST["delete_remote_agents"]))		{$delete_remote_agents=$_POST["delete_remote_agents"];}
if (isset($_GET["load_leads"]))				{$load_leads=$_GET["load_leads"];}
	elseif (isset($_POST["load_leads"]))		{$load_leads=$_POST["load_leads"];}
if (isset($_GET["campaign_detail"]))				{$campaign_detail=$_GET["campaign_detail"];}
	elseif (isset($_POST["campaign_detail"]))		{$campaign_detail=$_POST["campaign_detail"];}
if (isset($_GET["ast_admin_access"]))				{$ast_admin_access=$_GET["ast_admin_access"];}
	elseif (isset($_POST["ast_admin_access"]))		{$ast_admin_access=$_POST["ast_admin_access"];}
if (isset($_GET["ast_delete_phones"]))				{$ast_delete_phones=$_GET["ast_delete_phones"];}
	elseif (isset($_POST["ast_delete_phones"]))		{$ast_delete_phones=$_POST["ast_delete_phones"];}
if (isset($_GET["CoNfIrM"]))				{$CoNfIrM=$_GET["CoNfIrM"];}
	elseif (isset($_POST["CoNfIrM"]))		{$CoNfIrM=$_POST["CoNfIrM"];}
if (isset($_GET["delete_scripts"]))				{$delete_scripts=$_GET["delete_scripts"];}
	elseif (isset($_POST["delete_scripts"]))		{$delete_scripts=$_POST["delete_scripts"];}
if (isset($_GET["script_id"]))				{$script_id=$_GET["script_id"];}
	elseif (isset($_POST["script_id"]))		{$script_id=$_POST["script_id"];}
if (isset($_GET["script_name"]))				{$script_name=$_GET["script_name"];}
	elseif (isset($_POST["script_name"]))		{$script_name=$_POST["script_name"];}
if (isset($_GET["script_comments"]))				{$script_comments=$_GET["script_comments"];}
	elseif (isset($_POST["script_comments"]))		{$script_comments=$_POST["script_comments"];}
if (isset($_GET["script_text"]))				{$script_text=$_GET["script_text"];}
	elseif (isset($_POST["script_text"]))		{$script_text=$_POST["script_text"];}
if (isset($_GET["reset_hopper"]))				{$reset_hopper=$_GET["reset_hopper"];}
	elseif (isset($_POST["reset_hopper"]))		{$reset_hopper=$_POST["reset_hopper"];}
if (isset($_GET["get_call_launch"]))				{$get_call_launch=$_GET["get_call_launch"];}
	elseif (isset($_POST["get_call_launch"]))		{$get_call_launch=$_POST["get_call_launch"];}
if (isset($_GET["am_message_exten"]))				{$am_message_exten=$_GET["am_message_exten"];}
	elseif (isset($_POST["am_message_exten"]))		{$am_message_exten=$_POST["am_message_exten"];}
if (isset($_GET["amd_send_to_vmx"]))				{$amd_send_to_vmx=$_GET["amd_send_to_vmx"];}
	elseif (isset($_POST["amd_send_to_vmx"]))		{$amd_send_to_vmx=$_POST["amd_send_to_vmx"];}
if (isset($_GET["xferconf_a_dtmf"]))				{$xferconf_a_dtmf=$_GET["xferconf_a_dtmf"];}
	elseif (isset($_POST["xferconf_a_dtmf"]))		{$xferconf_a_dtmf=$_POST["xferconf_a_dtmf"];}
if (isset($_GET["xferconf_a_number"]))				{$xferconf_a_number=$_GET["xferconf_a_number"];}
	elseif (isset($_POST["xferconf_a_number"]))		{$xferconf_a_number=$_POST["xferconf_a_number"];}
if (isset($_GET["xferconf_b_dtmf"]))				{$xferconf_b_dtmf=$_GET["xferconf_b_dtmf"];}
	elseif (isset($_POST["xferconf_b_dtmf"]))		{$xferconf_b_dtmf=$_POST["xferconf_b_dtmf"];}
if (isset($_GET["xferconf_b_number"]))				{$xferconf_b_number=$_GET["xferconf_b_number"];}
	elseif (isset($_POST["xferconf_b_number"]))		{$xferconf_b_number=$_POST["xferconf_b_number"];}
if (isset($_GET["modify_leads"]))				{$modify_leads=$_GET["modify_leads"];}
	elseif (isset($_POST["modify_leads"]))		{$modify_leads=$_POST["modify_leads"];}
if (isset($_GET["hotkeys_active"]))				{$hotkeys_active=$_GET["hotkeys_active"];}
	elseif (isset($_POST["hotkeys_active"]))		{$hotkeys_active=$_POST["hotkeys_active"];}
if (isset($_GET["change_agent_campaign"]))				{$change_agent_campaign=$_GET["change_agent_campaign"];}
	elseif (isset($_POST["change_agent_campaign"]))		{$change_agent_campaign=$_POST["change_agent_campaign"];}
if (isset($_GET["agent_choose_ingroups"]))				{$agent_choose_ingroups=$_GET["agent_choose_ingroups"];}
	elseif (isset($_POST["agent_choose_ingroups"]))		{$agent_choose_ingroups=$_POST["agent_choose_ingroups"];}
if (isset($_GET["alt_number_dialing"]))				{$alt_number_dialing=$_GET["alt_number_dialing"];}
	elseif (isset($_POST["alt_number_dialing"]))		{$alt_number_dialing=$_POST["alt_number_dialing"];}
if (isset($_GET["scheduled_callbacks"]))				{$scheduled_callbacks=$_GET["scheduled_callbacks"];}
	elseif (isset($_POST["scheduled_callbacks"]))		{$scheduled_callbacks=$_POST["scheduled_callbacks"];}
if (isset($_GET["lead_filter_id"]))				{$lead_filter_id=$_GET["lead_filter_id"];}
	elseif (isset($_POST["lead_filter_id"]))		{$lead_filter_id=$_POST["lead_filter_id"];}
if (isset($_GET["lead_filter_name"]))				{$lead_filter_name=$_GET["lead_filter_name"];}
	elseif (isset($_POST["lead_filter_name"]))		{$lead_filter_name=$_POST["lead_filter_name"];}
if (isset($_GET["lead_filter_comments"]))				{$lead_filter_comments=$_GET["lead_filter_comments"];}
	elseif (isset($_POST["lead_filter_comments"]))		{$lead_filter_comments=$_POST["lead_filter_comments"];}
if (isset($_GET["lead_filter_sql"]))				{$lead_filter_sql=$_GET["lead_filter_sql"];}
	elseif (isset($_POST["lead_filter_sql"]))		{$lead_filter_sql=$_POST["lead_filter_sql"];}
if (isset($_GET["agentonly_callbacks"]))				{$agentonly_callbacks=$_GET["agentonly_callbacks"];}
	elseif (isset($_POST["agentonly_callbacks"]))		{$agentonly_callbacks=$_POST["agentonly_callbacks"];}
if (isset($_GET["agentcall_manual"]))				{$agentcall_manual=$_GET["agentcall_manual"];}
	elseif (isset($_POST["agentcall_manual"]))		{$agentcall_manual=$_POST["agentcall_manual"];}
if (isset($_GET["vicidial_recording"]))				{$vicidial_recording=$_GET["vicidial_recording"];}
	elseif (isset($_POST["vicidial_recording"]))		{$vicidial_recording=$_POST["vicidial_recording"];}
if (isset($_GET["vicidial_transfers"]))				{$vicidial_transfers=$_GET["vicidial_transfers"];}
	elseif (isset($_POST["vicidial_transfers"]))		{$vicidial_transfers=$_POST["vicidial_transfers"];}
if (isset($_GET["delete_filters"]))				{$delete_filters=$_GET["delete_filters"];}
	elseif (isset($_POST["delete_filters"]))		{$delete_filters=$_POST["delete_filters"];}

	if (isset($script_id)) {$script_id= strtoupper($script_id);}
	if (isset($lead_filter_id)) {$lead_filter_id = strtoupper($lead_filter_id);}

# AST GUI database administration
# admin.php
# 
# CHANGES
# 50315-1110 - Added Custom Campaign Statuses
# 50317-1438 - Added Fronter Display var to inbound groups
# 50322-1355 - Added custom callerID per campaign
# 50517-1356 - Added user_groups sections and user_group to vicidial_users
# 50517-1440 - Added ability to logout (must click OK with empty user/pass)
# 50602-1622 - Added lead loader pages to load new files into vicidial_list
# 50620-1351 - Added custom vdad transfer AGI extension per campaign
# 50810-1414 - modified in groups to kick out spaces and dashes
# 50908-2136 - Added Custom Campaign HotKeys
# 50914-0950 - Fixed user search by user_group
# 50926-1358 - Modified to allow for language translation
# 50926-1615 - Added WeBRooTWritablE write controls
# 51020-1008 - Added editable web address and park ext - NEW dial campaigns
# 51020-1056 - Added fields and help for campaign recording control
# 51123-1335 - Altered code to function in php globals=off
# 51208-1038 - Added user_level changes, function controls and default user phones
# 51208-1556 - Added deletion of users/lists/campaigns/in groups/remote agents
# 51213-1706 - Added add/delete/modify vicidial scripts
# 51214-1737 - Added preview of vicidial script in popup window
# 51219-1225 - Added campaign and ingroups script selector and get_call_launch field
# 51222-1055 - Added am_message_exten to campaigns to allow for AM Message button
# 51222-1125 - Fixed new vicidial_campaigns default values not being assigned bug
# 51222-1156 - Added LOG OUT ALL AGENTS ON THIS CAMPAIGN button to campaign screen
# 60204-0659 - Fixed hopper reset bug
# 60207-1413 - Added AMD send to voicemail extension and xfer-conf dtmf presets
# 60213-1100 - Added several vicidial_users permissions fields
# 60215-1319 - Added On-hold CallBacks display and links
# 60227-1226 - Fixed vicidial_inbound_groups insert bug
# 60413-1308 - Fixed list display to have 1 row/status: count and time zone tables
#            - Added status name in selected dial statuses in campaign screen
# 60417-1416 - Added vicidial_lead_filters sections
#            - Changed the header links to color-coded sectional with sublinks below
#            - Added filter name and script name to campaign and in-group modify sections
#            - Added callback and alt dial options to campaigns section
#            - Added callback, alt dial and other options to users section
# 60419-1628 - Alter Callbacks display to include status and LIVE listings, reordered
# 60421-1441 - check GET/POST vars lines with isset to not trigger PHP NOTICES
#

# make sure you have added a user to the vicidial_users MySQL table with at least user_level 8 to access this page the first time

$version = '1.1.10-9';
$build = '60421-1441';

$STARTtime = date("U");

if ($force_logout)
{
  if( (strlen($PHP_AUTH_USER)>0) or (strlen($PHP_AUTH_PW)>0) )
	{
    Header("WWW-Authenticate: Basic realm=\"VICI-PROJECTS\"");
    Header("HTTP/1.0 401 Unauthorized");
	}
    echo "You have now logged out. Thank you\n";
    exit;
}

	$stmt="SELECT count(*) from vicidial_users where user='$PHP_AUTH_USER' and pass='$PHP_AUTH_PW' and user_level > 7;";
	if ($DB) {echo "|$stmt|\n";}
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$auth=$row[0];

if ($WeBRooTWritablE > 0)
	{$fp = fopen ("./project_auth_entries.txt", "a");}

$date = date("r");
$ip = getenv("REMOTE_ADDR");
$browser = getenv("HTTP_USER_AGENT");

  if( (strlen($PHP_AUTH_USER)<2) or (strlen($PHP_AUTH_PW)<2) or ($auth<1))
	{
    Header("WWW-Authenticate: Basic realm=\"VICI-PROJECTS\"");
    Header("HTTP/1.0 401 Unauthorized");
    echo "Invalid Username/Password: |$PHP_AUTH_USER|$PHP_AUTH_PW|\n";
    exit;
	}
  else
	{

	if($auth>0)
		{
		$office_no=strtoupper($PHP_AUTH_USER);
		$password=strtoupper($PHP_AUTH_PW);
			$stmt="SELECT * from vicidial_users where user='$PHP_AUTH_USER' and pass='$PHP_AUTH_PW'";
			$rslt=mysql_query($stmt, $link);
			$row=mysql_fetch_row($rslt);
			$LOGfullname				=$row[3];
			$LOGuser_level				=$row[4];
			$LOGdelete_users			=$row[8];
			$LOGdelete_user_groups		=$row[9];
			$LOGdelete_lists			=$row[10];
			$LOGdelete_campaigns		=$row[11];
			$LOGdelete_ingroups			=$row[12];
			$LOGdelete_remote_agents	=$row[13];
			$LOGload_leads				=$row[14];
			$LOGcampaign_detail			=$row[15];
			$LOGdelete_scripts			=$row[18];
			$LOGdelete_filters			=$row[29];

		if ($WeBRooTWritablE > 0)
			{
			fwrite ($fp, "VICIDIAL|GOOD|$date|$PHP_AUTH_USER|$PHP_AUTH_PW|$ip|$browser|$LOGfullname|\n");
			fclose($fp);
			}
		}
	else
		{
		if ($WeBRooTWritablE > 0)
			{
			fwrite ($fp, "VICIDIAL|FAIL|$date|$PHP_AUTH_USER|$PHP_AUTH_PW|$ip|$browser|\n");
			fclose($fp);
			}
		}
	}

header ("Content-type: text/html; charset=utf-8");
echo "<html>\n";
echo "<head>\n";
echo "<!-- VERSION: $version   BUILD: $build   ADD: $ADD   PHP_SELF: $PHP_SELF-->\n";
echo "<title>VICIDIAL ADMIN: ";

if (!isset($ADD))   {$ADD=0;}

if ($ADD==1)		{$hh='users';		echo "Add New User";}
if ($ADD==11)		{$hh='campaigns';	echo "Add New Campaign";}
if ($ADD==111)		{$hh='lists';		echo "Add New List";}
if ($ADD==1111)		{$hh='ingroups';	echo "Add New In-Group";}
if ($ADD==11111)	{$hh='remoteagent';	echo "Add New Remote Agents";}
if ($ADD==111111)	{$hh='usergroups';	echo "Add New Users Group";}
if ($ADD==1111111)	{$hh='scripts';		echo "Add New Script";}
if ($ADD==11111111)	{$hh='filters';		echo "Add New Filter";}
if ($ADD==2)		{$hh='users';		echo "New User Addition";}
if ($ADD==21)		{$hh='campaigns';	echo "New Campaign Addition";}
if ($ADD==22)		{$hh='campaigns';	echo "New Campaign Status Addition";}
if ($ADD==23)		{$hh='campaigns';	echo "New Campaign HotKey Addition";}
if ($ADD==211)		{$hh='lists';		echo "New List Addition";}
if ($ADD==2111)		{$hh='ingroups';	echo "New In-Group Addition";}
if ($ADD==21111)	{$hh='remoteagent';	echo "New Remote Agents Addition";}
if ($ADD==211111)	{$hh='usergroups';	echo "New Users Group Addition";}
if ($ADD==2111111)	{$hh='scripts';		echo "New Script Addition";}
if ($ADD==21111111)	{$hh='filters';		echo "New Filter Addition";}
if ($ADD==3)		{$hh='users';		echo "Modify User";}
if ($ADD==31)		{$hh='campaigns';	echo "Modify Campaign";}
if ($ADD==34)		{$hh='campaigns';	echo "Modify Campaign - Basic View";}
if ($ADD==311)		{$hh='lists';		echo "Modify List";}
if ($ADD==3111)		{$hh='ingroups';	echo "Modify In-Group";}
if ($ADD==31111)	{$hh='remoteagent';	echo "Modify Remote Agents";}
if ($ADD==311111)	{$hh='usergroups';	echo "Modify Users Groups";}
if ($ADD==3111111)	{$hh='scripts';		echo "Modify Script";}
if ($ADD==31111111)	{$hh='filters';		echo "Modify Filter";}
if ($ADD=="4A")		{$hh='users';		echo "Modify User - Admin";}
if ($ADD==4)		{$hh='users';		echo "Modify User";}
if ($ADD==41)		{$hh='campaigns';	echo "Modify Campaign";}
if ($ADD==42)		{$hh='campaigns';	echo "Modify Campaign Status";}
if ($ADD==43)		{$hh='campaigns';	echo "Modify Campaign HotKey";}
if ($ADD==44)		{$hh='campaigns';	echo "Modify Campaign - Basic View";}
if ($ADD==411)		{$hh='lists';		echo "Modify List";}
if ($ADD==4111)		{$hh='ingroups';	echo "Modify In-Group";}
if ($ADD==41111)	{$hh='remoteagent';	echo "Modify Remote Agents";}
if ($ADD==411111)	{$hh='usergroups';	echo "Modify Users Groups";}
if ($ADD==4111111)	{$hh='scripts';		echo "Modify Script";}
if ($ADD==41111111)	{$hh='filters';		echo "Modify Filter";}
if ($ADD==5)		{$hh='users';		echo "Delete User";}
if ($ADD==51)		{$hh='campaigns';	echo "Delete Campaign";}
if ($ADD==52)		{$hh='campaigns';	echo "Logout Agents";}
if ($ADD==511)		{$hh='lists';		echo "Delete List";}
if ($ADD==5111)		{$hh='ingroups';	echo "Delete In-Group";}
if ($ADD==51111)	{$hh='remoteagent';	echo "Delete Remote Agents";}
if ($ADD==511111)	{$hh='usergroups';	echo "Delete Users Group";}
if ($ADD==5111111)	{$hh='scripts';		echo "Delete Script";}
if ($ADD==51111111)	{$hh='filters';		echo "Delete Filter";}
if ($ADD==6)		{$hh='users';		echo "Delete User";}
if ($ADD==61)		{$hh='campaigns';	echo "Delete Campaign";}
if ($ADD==62)		{$hh='campaigns';	echo "Logout Agents";}
if ($ADD==611)		{$hh='lists';		echo "Delete List";}
if ($ADD==6111)		{$hh='ingroups';	echo "Delete In-Group";}
if ($ADD==61111)	{$hh='remoteagent';	echo "Delete Remote Agents";}
if ($ADD==611111)	{$hh='usergroups';	echo "Delete Users Group";}
if ($ADD==6111111)	{$hh='scripts';		echo "Delete Script";}
if ($ADD==61111111)	{$hh='filters';		echo "Delete Filter";}
if ($ADD==7111111)	{$hh='scripts';		echo "Preview Script";}
if ($ADD==0)		{$hh='users';		echo "Users List";}
if ($ADD==8)		{$hh='users';		echo "CallBacks Within Agent";}
if ($ADD==81)		{$hh='campaigns';	echo "CallBacks Within Campaign";}
if ($ADD==811)		{$hh='campaigns';	echo "CallBacks Within List";}
if ($ADD==10)		{$hh='campaigns';	echo "Campaigns";}
if ($ADD==100)		{$hh='lists';		echo "Lists";}
if ($ADD==1000)		{$hh='ingroups';	echo "In-Groups";}
if ($ADD==10000)	{$hh='remoteagent';	echo "Remote Agents";}
if ($ADD==100000)	{$hh='usergroups';	echo "User Groups";}
if ($ADD==1000000)	{$hh='scripts';		echo "Scripts";}
if ($ADD==10000000)	{$hh='filters';		echo "Filters";}
if ($ADD==55)		{$hh='users';		echo "Search Form";}
if ($ADD==66)		{$hh='users';		echo "Search Results";}
if ($ADD==99999)	{$hh='users';		echo "HELP";}

if ( ($ADD>9) && ($ADD < 99998) )
	{
	##### get scripts listing for dynamic pulldown
	$stmt="SELECT script_id,script_name from vicidial_scripts order by script_id";
	$rsltx=mysql_query($stmt, $link);
	$scripts_to_print = mysql_num_rows($rsltx);
	$scripts_list="<option value=\"\">NONE</option>\n";

	$o=0;
	while ($scripts_to_print > $o)
		{
		$rowx=mysql_fetch_row($rsltx);
		$scripts_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
		$scriptname_list["$rowx[0]"] = "$rowx[1]";
		$o++;
		}

	##### get filters listing for dynamic pulldown
	$stmt="SELECT lead_filter_id,lead_filter_name,lead_filter_sql from vicidial_lead_filters order by lead_filter_id";
	$rsltx=mysql_query($stmt, $link);
	$filters_to_print = mysql_num_rows($rsltx);
	$filters_list="<option value=\"\">NONE</option>\n";

	$o=0;
	while ($filters_to_print > $o)
		{
		$rowx=mysql_fetch_row($rsltx);
		$filters_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
		$filtername_list["$rowx[0]"] = "$rowx[1]";
		$filtersql_list["$rowx[0]"] = "$rowx[2]";
		$o++;
		}
	}

if ( ( (strlen($ADD)>4) && ($ADD < 99998) ) or ($ADD==3) or ($ADD=="4A") )
	{
	##### get server listing for dynamic pulldown
	$stmt="SELECT server_ip,server_description from servers order by server_ip";
	$rsltx=mysql_query($stmt, $link);
	$servers_to_print = mysql_num_rows($rsltx);
	$servers_list='';

	$o=0;
	while ($servers_to_print > $o)
		{
		$rowx=mysql_fetch_row($rsltx);
		$servers_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
		$o++;
		}

	##### get campaigns listing for dynamic pulldown
	$stmt="SELECT campaign_id,campaign_name from vicidial_campaigns order by campaign_id";
	$rsltx=mysql_query($stmt, $link);
	$campaigns_to_print = mysql_num_rows($rsltx);
	$campaigns_list='';

	$o=0;
	while ($campaigns_to_print > $o)
		{
		$rowx=mysql_fetch_row($rsltx);
		$campaigns_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
		$o++;
		}

	##### get inbound groups listing for checkboxes
	if ( (($ADD==31111) or ($ADD==31111)) and (count($groups)<1) )
	{
	$stmt="SELECT closer_campaigns from vicidial_remote_agents where remote_agent_id='$remote_agent_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$closer_campaigns =	$row[0];
	$closer_campaigns = preg_replace("/ -$/","",$closer_campaigns);
	$groups = explode(" ", $closer_campaigns);
	}

	if ($ADD==3)
	{
	$stmt="SELECT closer_campaigns from vicidial_users where user='$user';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$closer_campaigns =	$row[0];
	$closer_campaigns = preg_replace("/ -$/","",$closer_campaigns);
	$groups = explode(" ", $closer_campaigns);
	}

	$stmt="SELECT group_id,group_name from vicidial_inbound_groups order by group_id";
	$rsltx=mysql_query($stmt, $link);
	$groups_to_print = mysql_num_rows($rsltx);
	$groups_list='';
	$groups_value='';

	$o=0;
	while ($groups_to_print > $o)
		{
		$rowx=mysql_fetch_row($rsltx);
		$group_id_value = $rowx[0];
		$group_name_value = $rowx[1];
		$groups_list .= "<input type=\"checkbox\" name=\"groups[]\" value=\"$group_id_value\"";
		$p=0;
		while ($p<100)
			{
			if ($group_id_value == $groups[$p]) 
				{
				$groups_list .= " CHECKED";
				$groups_value .= " $group_id_value";
				}
			$p++;
			}
		$groups_list .= "> $group_id_value - $group_name_value<BR>\n";
		$o++;
		}
	if (strlen($groups_value)>2) {$groups_value .= " -";}
	}





$NWB = " &nbsp; <a href=\"javascript:openNewWindow('$PHP_SELF?ADD=99999";
$NWE = "')\"><IMG SRC=\"help.gif\" WIDTH=20 HEIGHT=20 BORDER=0 ALT=\"HELP\" ALIGN=TOP></A>";
######################
# ADD=99999 display the HELP SCREENS
######################

if ($ADD==99999)
{
echo "</title>\n";
echo "</head>\n";
echo "<BODY BGCOLOR=white marginheight=0 marginwidth=0 leftmargin=0 topmargin=0>\n";
echo "<CENTER>\n";
echo "<TABLE WIDTH=98% BGCOLOR=#E6E6E6 cellpadding=2 cellspacing=0><TR><TD ALIGN=LEFT><FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=4><B>VICIDIAL ADMIN: HELP<BR></B></FONT><FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2><BR><BR>\n";

?>
<B><FONT SIZE=3>VICIDIAL_USERS TABLE</FONT></B><BR><BR>
<A NAME="vicidial_users-user">
<BR>
<B>User ID -</B> This field is where you put the VICIDIAL users ID number, can be up to 8 digits in length, Must be at least 2 characters in length.

<BR>
<A NAME="vicidial_users-pass">
<BR>
<B>Password -</B> This field is where you put the VICIDIAL users password. Must be at least 2 characters in length.

<BR>
<A NAME="vicidial_users-full_name">
<BR>
<B>Full Name -</B> This field is where you put the VICIDIAL users full name. Must be at least 2 characters in length.

<BR>
<A NAME="vicidial_users-user_level">
<BR>
<B>User Level -</B> This menu is where you select the VICIDIAL users user level. Must be a level of 1 to log into VICIDIAL, Must be level greater than 2 to log in as a closer, Must be user level 8 or greater to get into admin web section.

<BR>
<A NAME="vicidial_users-user_group">
<BR>
<B>User Group -</B> This menu is where you select the VICIDIAL users group that this user will belong to. This does not have any restrictions at this time, this is just to subdivide users and allow for future features based upon it.

<BR>
<A NAME="vicidial_users-phone_login">
<BR>
<B>Phone Login -</B> Here is where you can set a default phone login value for when the user logs into vicidial.php. This value will populate the phone_login automatically when the user logs in with their user-pass-campaign in the vicidial.php login screen.

<BR>
<A NAME="vicidial_users-phone_pass">
<BR>
<B>Phone Pass -</B> Here is where you can set a default phone pass value for when the user logs into vicidial.php. This value will populate the phone_pass automatically when the user logs in with their user-pass-campaign in the vicidial.php login screen.

<BR>
<A NAME="vicidial_users-delete_users">
<BR>
<B>Delete Users -</B> This option if set to 1 allows the user to delete other users of equal or lesser user level from the system.

<BR>
<A NAME="vicidial_users-delete_user_groups">
<BR>
<B>Delete User Groups -</B> This option if set to 1 allows the user to delete user groups from the system.

<BR>
<A NAME="vicidial_users-delete_lists">
<BR>
<B>Delete Lists -</B> This option if set to 1 allows the user to delete vicidial lists from the system.

<BR>
<A NAME="vicidial_users-delete_campaigns">
<BR>
<B>Delete Campaigns -</B> This option if set to 1 allows the user to delete vicidial campaigns from the system.

<BR>
<A NAME="vicidial_users-delete_ingroups">
<BR>
<B>Delete In-Groups -</B> This option if set to 1 allows the user to delete vicidial In-Groups from the system.

<BR>
<A NAME="vicidial_users-delete_remote_agents">
<BR>
<B>Delete Remote Agents -</B> This option if set to 1 allows the user to delete vicidial remote agents from the system.

<BR>
<A NAME="vicidial_users-load_leads">
<BR>
<B>Load Leads -</B> This option if set to 1 allows the user to load vicidial leads into the vicidial_list table by way of the web based lead loader.

<BR>
<A NAME="vicidial_users-campaign_detail">
<BR>
<B>Campaign Detail -</B> This option if set to 1 allows the user to view and modify the campaign detail screen elements.

<BR>
<A NAME="vicidial_users-ast_admin_access">
<BR>
<B>AGC Admin Access -</B> This option if set to 1 allows the user to login to the astGUIclient admin pages.

<BR>
<A NAME="vicidial_users-ast_delete_phones">
<BR>
<B>AGC Delete Phones -</B> This option if set to 1 allows the user to delete phone entries in the astGUIclient admin pages.

<BR>
<A NAME="vicidial_users-delete_scripts">
<BR>
<B>Delete Scripts -</B> This option if set to 1 allows the user to delete Campaign scripts in the script modification screen.

<BR>
<A NAME="vicidial_users-modify_leads">
<BR>
<B>Modify Leads -</B> This option if set to 1 allows the user to modify leads in the admin section lead search results page.

<BR>
<A NAME="vicidial_users-hotkeys_active">
<BR>
<B>HotKeys Active -</B> This option if set to 1 allows the user to use the HotKeys quick-dispositioning function in vicidial.php.

<BR>
<A NAME="vicidial_users-change_agent_campaign">
<BR>
<B>Change Agent Campaign -</B> This option if set to 1 allows the user to alter the campaign that an agent is logged into while they are logged into it.

<BR>
<A NAME="vicidial_users-agent_choose_ingroups">
<BR>
<B>Agent Choose Ingroups -</B> This option if set to 1 allows the user to choose the ingroups that they will receive calls from when they login to a CLOSER or INBOUND campaign. Otherwise the Manager will need to set this in their user detail screen of the admin page.

<BR>
<A NAME="vicidial_users-closer_campaigns">
<BR>
<B>Inbound Groups -</B> Here is where you select the inbound groups you want to receive calls from if you have selected the CLOSER campaign.

<BR>
<A NAME="vicidial_users-scheduled_callbacks">
<BR>
<B>Scheduled Callbacks -</B> This option allows an agent to disposition a call as CALLBK and choose the data and time at which the lead will be re-activated.

<BR>
<A NAME="vicidial_users-agentonly_callbacks">
<BR>
<B>Agent-Only Callbacks -</B> This option allows an agent to set a callback so that they are the only Agent that can call the customer back. This also allows the agent to see their callback listings and call them back any time they want to.

<BR>
<A NAME="vicidial_users-agentcall_manual">
<BR>
<B>Agent Call Manual -</B> This option allows an agent to manually enter a new lead into the system and call them. This also allows the calling of any phone number from their vicidial screen and puts that call into their session. Use this option with caution.

<BR>
<A NAME="vicidial_users-vicidial_recording">
<BR>
<B>Vicidial Recording -</B> This option can prevent an agent from doing any recordings after they log in to vicidial. This option must be on for vicidial to follow the campaign recording session.

<BR>
<A NAME="vicidial_users-vicidial_transfers">
<BR>
<B>Vicidial Transfers -</B> This option can prevent an agent from opening the transfer - conference session of vicidial. If this is disabled, the agent cannot third party call or blind transfer any calls.

<BR>
<A NAME="vicidial_users-delete_filters">
<BR>
<B>Delete Filters -</B> This option allows the user to be able to delete vicidial lead filters from the system.




<BR><BR><BR><BR>

<B><FONT SIZE=3>VICIDIAL_CAMPAIGNS TABLE</FONT></B><BR><BR>
<A NAME="vicidial_campaigns-campaign_id">
<BR>
<B>Campaign ID -</B> This is the short name of the campaign, it is not editable after initial submission, cannot contain spaces and must be between 2 and 8 characters in length.

<BR>
<A NAME="vicidial_campaigns-campaign_name">
<BR>
<B>Campaign Name -</B> This is the description of the campaign, it must be between 6 and 40 characters in length.

<BR>
<A NAME="vicidial_campaigns-active">
<BR>
<B>Active -</B> This is where you set the campaign to Active or Inactive. If Inactive, noone can log into it.

<BR>
<A NAME="vicidial_campaigns-park_ext">
<BR>
<B>Park Extension -</B> This is where you can customize the on-hold music for VICIDIAL. Make sure the extension is in place in the extensions.conf and that it points to the filename below.

<BR>
<A NAME="vicidial_campaigns-park_file_name">
<BR>
<B>Park File Name -</B> This is where you can customize the on-hold music for VICIDIAL. Make sure the filename is 10 characters in length or less and that the file is in place in the /var/lib/asterisk/sounds directory.

<BR>
<A NAME="vicidial_campaigns-web_form_address">
<BR>
<B>Web Form -</B> This is where you can set the custom web page that will be opened when the user clicks on the WEB FORM button.

<BR>
<A NAME="vicidial_campaigns-allow_closers">
<BR>
<B>Allow Closers -</B> This is where you can set whether the users of this campaign will have the option to send the call to a closer.

<BR>
<A NAME="vicidial_campaigns-dial_status">
<BR>
<B>Dial Status -</B> This is where you set the statuses that you are wanting to dial on within the lists that are active for the campaign below

<BR>
<A NAME="vicidial_campaigns-lead_order">
<BR>
<B>List Order -</B> This menu is where you select how the leads that match the statuses selected above will be put in the lead hopper:
 <BR> &nbsp; - DOWN: select the first leads loaded into the vicidial_list table
 <BR> &nbsp; - UP: select the last leads loaded into the vicidial_list table
 <BR> &nbsp; - UP PHONE: select the highest phone number and works its way down
 <BR> &nbsp; - DOWN PHONE: select the lowest phone number and works its way up
 <BR> &nbsp; - UP LAST NAME: starts with last names starting with Z and works its way down
 <BR> &nbsp; - DOWN LAST NAME: starts with last names starting with A and works its way up
 <BR> &nbsp; - UP COUNT: starts with most called leads and works its way down
 <BR> &nbsp; - DOWN COUNT: starts with least called leads and works its way up
 <BR> &nbsp; - DOWN COUNT 2nd NEW: starts with least called leads and works its way up inserting a NEW lead in every other lead - Must NOT have NEW selected in the dial statuses
 <BR> &nbsp; - DOWN COUNT 3nd NEW: starts with least called leads and works its way up inserting a NEW lead in every third lead - Must NOT have NEW selected in the dial statuses
 <BR> &nbsp; - DOWN COUNT 4th NEW: starts with least called leads and works its way up inserting a NEW lead in every forth lead - Must NOT have NEW selected in the dial statuses

<BR>
<A NAME="vicidial_campaigns-hopper_level">
<BR>
<B>Hopper Level -</B> This is how many leads the VDhopper script tries to keep in the vicidial_hopper table for this campaign. If running VDhopper script every minute, make this slightly greater than the number of leads you go through in a minute.

<BR>
<A NAME="vicidial_campaigns-lead_filter_id">
<BR>
<B>Lead Filter -</B> This is a method of filtering your leads using a fragment of a SQL query. Use this feature with caution, it is easy to stop dialing accidentally with the slightest alteration to the SQL statement. Default is NONE.

<BR>
<A NAME="vicidial_campaigns-force_reset_hopper">
<BR>
<B>Force Reset of Hopper -</B> This allows you to wipe out the hopper contents upon form submission. It should be filled again when the VDhopper script runs.

<BR>
<A NAME="vicidial_campaigns-auto_dial_level">
<BR>
<B>Auto Dial Level -</B> This is where you set how many lines VICIDIAL should use per active agent. zero 0 means auto dialing is off and the agents will click to dial each number. Otherwise VICIDIAL will keep dialing lines equal to active agents multiplied by the dial level to arrive at how many lines this campaign on each server should allow.

<BR>
<A NAME="vicidial_campaigns-next_agent_call">
<BR>
<B>Next Agent Call -</B> This determines which agent receives the next call that is available:
 <BR> &nbsp; - random: orders by the random update value in the vicidial_live_agents table
 <BR> &nbsp; - oldest_call_start: orders by the last time an agent was sent a call. Results in agents receiving about the same number of calls overall.
 <BR> &nbsp; - oldest_call_finish: orders by the last time an agent finished a call. AKA agent waiting longest receives first call.
 <BR> &nbsp; - overall_user_level: orders by the user_level of the agent as defined in the vicidial_users table a higher user_level will receive more calls.

<BR>
<A NAME="vicidial_campaigns-local_call_time">
<BR>
<B>Local Call Time -</B> This is where you set during which hours you would like to dial, as determined by the local time in the are in which you are calling. This is controlled by area code and is adjusted for Daylight Savings time if applicable. General Guidelines in the USA for Business to Business is 9am to 5pm and Business to Consumer calls is 9am to 9pm.

<BR>
<A NAME="vicidial_campaigns-voicemail_ext">
<BR>
<B>Voicemail -</B> If defined, calls that would normally DROP would instead be directed to this voicemail box to hear and leave a message.

<BR>
<A NAME="vicidial_campaigns-dial_timeout">
<BR>
<B>Dial Timeout -</B> If defined, calls that would normally hangup after the timeout defined in extensions.conf would instead timeout at this amount of seconds if it is less than the extensions.conf timeout. This allows for quickly changing dial timeouts from server to server and limiting the effects to a single campaign. If you are having a lot of Answering Machine or Voicemail calls you may want to try changing this value to between 21-26 and see if results improve.

<BR>
<A NAME="vicidial_campaigns-dial_prefix">
<BR>
<B>Dial Prefix -</B> This field allows for more easily changing a path of dialing to go out through a different method without doing a reload in Asterisk. Default is 9 based upon a 91NXXNXXXXXX in the dialplan - extensions.conf.

<BR>
<A NAME="vicidial_campaigns-campaign_cid">
<BR>
<B>Campaign CallerID -</B> This field allows for the sending of a custom callerid number on the outbound calls. This is the number that would show up on the callerid of the person you are calling. The default is UNKNOWN. This option is only available if you are using PRIs - ISDN T1s or E1s - that have the custom callerid feature turned on. This feature may also work with IAX2 trunks depending on what your provider allows. The custom callerID only applies to calls placed for the VICIDIAL campaign directly, any 3rd party calls or transfers will not send the custom callerID. NOTE: Sometimes putting UNKNOWN or PRIVATE in the field will yield the sending of your default callerID number by your carrier with the calls. You may want to test this and put 0000000000 in the callerid field instead if you do not want to send you CallerID.

<BR>
<A NAME="vicidial_campaigns-campaign_vdad_exten">
<BR>
<B>Campaign VDAD extension -</B> This field allows for a custom VDAD transfer extension. This allows you to use different VDADtransfer...agi scripts depending upon your campaign. The default transfer AGI - exten 8365 agi-VDADtransfer.agi - just immediately sends the calls on to agents as soon as they are picked up. An additional sample political survey AGI is also now included - 8366 agi-VDADtransferSURVEY.agi - that plays a message to the called person and allows them to make a choice by pressing buttons - effectively pre-screening the lead - . Please note that except for surveys, political calls and charities this form of calling is illegal in the United States.

<BR>
<A NAME="vicidial_campaigns-campaign_rec_exten">
<BR>
<B>Campaign Rec extension -</B> This field allows for a custom recording extension to be used with VICIDIAL. This allows you to use different extensions depending upon how long you want to allow a maximum recording and what type of codec you want to record in. The default exten is 8309 which if you follow the SCRATCH_INSTALL examples will record in the WAV format for upto one hour. Another option included in the examples is 8310 which will record in GSM format for upto one hour.

<BR>
<A NAME="vicidial_campaigns-campaign_recording">
<BR>
<B>Campaign Recording -</B> This menu allows you to choose what level of recording is allowed on this campaign. NEVER will disable recording on the client. ONDEMAND is the default and allows the agent to start and stop recording as needed. ALLCALLS will start recording on the client whenever a call is sent to an agent.

<BR>
<A NAME="vicidial_campaigns-campaign_rec_filename">
<BR>
<B>Campaign Rec Filename -</B> This field allows you to customize the name of the recording when Campaign recording is ONDEMAND or ALLCALLS. The allowed variables are CAMPAIGN CUSTPHONE FULLDATE TINYDATE EPOCH AGENT. The default is FULLDATE_AGENT and would look like this 20051020-103108_6666. Another example is CAMPAIGN_TINYDATE_CUSTPHONE which would look like this TESTCAMP_51020103108_3125551212. 50 char max.

<BR>
<A NAME="vicidial_campaigns-campaign_script">
<BR>
<B>Campaign Script -</B> This menu allows you to choose the script that will appear on the agents screen for this campaign. Select NONE to show no script for this campaign.

<BR>
<A NAME="vicidial_campaigns-get_call_launch">
<BR>
<B>Get Call Launch -</B> This menu allows you to choose whether you want to auto-launch the web-form page in a separate window, auto-switch to the SCRIPT tab or do nothing when a call is sent to the agent for this campaign. 

<BR>
<A NAME="vicidial_campaigns-am_message_exten">
<BR>
<B>Answering Machine Message -</B> This field is for entering in an extension to blind transfer calls to when the agent gets an answering machine and clicks on the Answering Machine Message button in the transfer conference frame. You must set this exten up in the dialplan - extensions.conf - and make sure it plays an audio file then hangs up. 

<BR>
<A NAME="vicidial_campaigns-amd_send_to_vmx">
<BR>
<B>AMD send to vm exten -</B> This menu allows you to define whether a message is left on an answering machine when it is detected. the call will be immediately forwarded to the Answering-Machine-Message extension if AMD is active and it is determined that the call is an answering machine.

<BR>
<A NAME="vicidial_campaigns-xferconf_a_dtmf">
<BR>
<B>Xfer-Conf DTMF -</B> These four fields allow for you to have two sets of Transfer Conference and DTMF presets. When the call or campaign is loaded, the vicidial.php script will show two buttons on the transfer-conference frame and auto-populate the number-to-dial and the send-dtmf fields when pressed.

<BR>
<A NAME="vicidial_campaigns-alt_number_dialing">
<BR>
<B>Agent Alt Num Dialing -</B> This option allows an agent to manually dial the alternate phone number or address3 field after the main number has been called.

<BR>
<A NAME="vicidial_campaigns-scheduled_callbacks">
<BR>
<B>Scheduled Callbacks -</B> This option allows an agent to disposition a call as CALLBK and choose the data and time at which the lead will be re-activated.




<BR><BR><BR><BR>

<B><FONT SIZE=3>VICIDIAL_LISTS TABLE</FONT></B><BR><BR>
<A NAME="vicidial_lists-list_id">
<BR>
<B>List ID -</B> This is the numerical name of the list, it is not editable after initial submission, must contain only numbers and must be between 2 and 8 characters in length.

<BR>
<A NAME="vicidial_lists-list_name">
<BR>
<B>List Name -</B> This is the description of the list, it must be between 2 and 20 characters in length.

<BR>
<A NAME="vicidial_lists-campaign_id">
<BR>
<B>Campaign -</B> This is the campaign that this list belongs to. A list can only be dialed on a single campaign at one time.

<BR>
<A NAME="vicidial_lists-active">
<BR>
<B>Active -</B> This defines whether the list is to be dialed on or not.

<BR>
<A NAME="vicidial_lists-reset_list">
<BR>
<B>Reset Lead-Called-Status for this list -</B> This resets all leads in this list to N for "not called since last reset" and means that any lead can now be called if it is the right status as defined in the campaign screen.


<BR><BR><BR><BR>

<B><FONT SIZE=3>VICIDIAL_INBOUND_GROUPS TABLE</FONT></B><BR><BR>
<A NAME="vicidial_inbound_groups-group_id">
<BR>
<B>Group ID -</B> This is the short name of the inbound group, it is not editable after initial submission, must not contain any spaces and must be between 2 and 20 characters in length.

<BR>
<A NAME="vicidial_inbound_groups-group_name">
<BR>
<B>Group Name -</B> This is the description of the group, it must be between 2 and 30 characters in length. Cannot include dashes, plusses or spaces .

<BR>
<A NAME="vicidial_inbound_groups-group_color">
<BR>
<B>Group Color -</B> This is the color that displays in the VICIDIAL client app when a call comes in on this group. It must be between 2 and 7 characters long. If this is a hex color definition you must remember to put a # at the beginning of the string or VICIDIAL will not work properly.

<BR>
<A NAME="vicidial_inbound_groups-active">
<BR>
<B>Active -</B> This determines whether this group show up in the selection box when a VICIDIAL agent logs in.

<BR>
<A NAME="vicidial_inbound_groups-web_form_address">
<BR>
<B>Web Form -</B> This is the custom address that clicking on the WEB FORM button in VICIDIAL will take you to for calls that come in on this group.

<BR>
<A NAME="vicidial_inbound_groups-voicemail_ext">
<BR>
<B>Voicemail -</B> If defined, this is the Voicemail box that calls will go to instead of being dropped if no agents are available after the hold time is up.

<BR>
<A NAME="vicidial_inbound_groups-next_agent_call">
<BR>
<B>Next Agent Call -</B> This determines which agent receives the next call that is available:
 <BR> &nbsp; - random: orders by the random update value in the vicidial_live_agents table
 <BR> &nbsp; - oldest_call_start: orders by the last time an agent was sent a call. Results in agents receiving about the same number of calls overall.
 <BR> &nbsp; - oldest_call_finish: orders by the last time an agent finished a call. AKA agent waiting longest receives first call.
 <BR> &nbsp; - overall_user_level: orders by the user_level of the agent as defined in the vicidial_users table a higher user_level will receive more calls.

<BR>
<A NAME="vicidial_inbound_groups-fronter_display">
<BR>
<B>Fronter Display -</B> This field determines whether the inbound VICIDIAL agent would have the fronter name - if there is one - displayed in the Status field when the call comes to the agent.

<BR>
<A NAME="vicidial_inbound_groups-ingroup_script">
<BR>
<B>Campaign Script -</B> This menu allows you to choose the script that will appear on the agents screen for this campaign. Select NONE to show no script for this campaign.

<BR>
<A NAME="vicidial_inbound_groups-get_call_launch">
<BR>
<B>Get Call Launch -</B> This menu allows you to choose whether you want to auto-launch the web-form page in a separate window, auto-switch to the SCRIPT tab or do nothing when a call is sent to the agent for this campaign. 

<BR>
<A NAME="vicidial_inbound_groups-xferconf_a_dtmf">
<BR>
<B>Xfer-Conf DTMF -</B> These four fields allow for you to have two sets of Transfer Conference and DTMF presets. When the call or campaign is loaded, the vicidial.php script will show two buttons on the transfer-conference frame and auto-populate the number-to-dial and the send-dtmf fields when pressed.




<BR><BR><BR><BR>

<B><FONT SIZE=3>VICIDIAL_REMOTE_AGENTS TABLE</FONT></B><BR><BR>
<A NAME="vicidial_remote_agents-user_start">
<BR>
<B>User ID Start -</B> This is the starting User ID that is used when the remote agent entries are inserted into the system. If the Number of Lines is set higher than 1, this number is incremented by one until each line has an entry. Make sure you create a new VICIDIAL user account with a user level of 4 or great if you want them to be able to use the vdremote.php page for remote web access of this account.

<BR>
<A NAME="vicidial_remote_agents-number_of_lines">
<BR>
<B>Number of Lines -</B> This defines how many remote agent entries the system creates, and determines how many lines it thinks it can safely send to the number below.

<BR>
<A NAME="vicidial_remote_agents-server_ip">
<BR>
<B>Server IP -</B> A remote agent entry is only good for one specific server, here is where you select which server you want.

<BR>
<A NAME="vicidial_remote_agents-conf_exten">
<BR>
<B>External Extension -</B> This is the number that you want the calls forwarded to. Make sure that it is a full dialplan number and that if you need a 9 at the beginning you put it in here. Test by dialing this number from a phone on the system.

<BR>
<A NAME="vicidial_remote_agents-status">
<BR>
<B>Status -</B> Here is where you turn the remote agent on and off. As soon as the agent is Active the system assumes that it can send calls to it. It may take up to 30 seconds once you change the status to Inactive to stop receiving calls.

<BR>
<A NAME="vicidial_remote_agents-campaign_id">
<BR>
<B>Campaign -</B> Here is where you select the campaign that these remote agents will be logged into. Inbound needs to use the CLOSER campaign and select the inbound campaigns below that you want to receive calls from.

<BR>
<A NAME="vicidial_remote_agents-closer_campaigns">
<BR>
<B>Inbound Groups -</B> Here is where you select the inbound groups you want to receive calls from if you have selected the CLOSER campaign.


<BR><BR><BR><BR>

<B><FONT SIZE=3>VICIDIAL_CAMPAIGN_LISTS</FONT></B><BR><BR>
<A NAME="vicidial_campaign_lists">
<BR>
<B>The lists within this campaign are listed here, whether they are active is denoted by the Y or N and you can go to the list screen by clicking on the list ID in the first column.</B>


<BR><BR><BR><BR>

<B><FONT SIZE=3>VICIDIAL_CAMPAIGN_STATUSES TABLE</FONT></B><BR><BR>
<A NAME="vicidial_campaign_statuses">
<BR>
<B>Through the use of custom campaign statuses, you can have statuses that only exist for a specific campaign. The Status must be 1-8 characters in length, the description must be 2-30 characters in length and Selectable defines whether it shows up in VICIDIAL as a disposition.</B>



<BR><BR><BR><BR>

<B><FONT SIZE=3>VICIDIAL_CAMPAIGN_HOTKEYS TABLE</FONT></B><BR><BR>
<A NAME="vicidial_campaign_hotkeys">
<BR>
<B>Through the use of custom campaign hotkeys, agents that use the vicidial web-client can hangup and disposition calls just by pressing a single key on their keyboard.</B>





<BR><BR><BR><BR>

<B><FONT SIZE=3>VICIDIAL_USER_GROUPS TABLE</FONT></B><BR><BR>
<A NAME="vicidial_user_groups-user_group">
<BR>
<B>User Group -</B> This is the short name of a Vicidial User group, try not to use any spaces or punctuation for this field. max 20 characters, minimum of 2 characters.

<BR>
<A NAME="vicidial_user_groups-group_name">
<BR>
<B>Group Name -</B> This is the description of the vicidial user group max of 40 characters.





<BR><BR><BR><BR>

<B><FONT SIZE=3>VICIDIAL_SCRIPTS TABLE</FONT></B><BR><BR>
<A NAME="vicidial_scripts-script_id">
<BR>
<B>Script ID -</B> This is the short name of a Vicidial Script. This needs to be a unique identifier. Try not to use any spaces or punctuation for this field. max 10 characters, minimum of 2 characters.

<BR>
<A NAME="vicidial_scripts-script_name">
<B>Script Name -</B> This is the title of a Vicidial Script. This is a short summary of the script. max 50 characters, minimum of 2 characters. There should be no spaces or punctuation of any kind in theis field.

<BR>
<A NAME="vicidial_scripts-script_comments">
<B>Script Comments -</B> This is where you can place comments for a Vicidial Script such as -changed to free upgrade on Sept 23-.  max 255 characters, minimum of 2 characters.

<BR>
<A NAME="vicidial_scripts-script_text">
<B>Script Text -</B> This is where you place the content of a Vicidial Script. Minimum of 2 characters. You can have customer information be auto-populated in this script using "--A--field--B--" where field is one of the following fieldnames: vendor_lead_code, source_id, list_id, gmt_offset_now, called_since_last_reset, phone_code, phone_number, title, first_name, middle_initial, last_name, address1, address2, address3, city, state, province, postal_code, country_code, gender, date_of_birth, alt_phone, email, security_phrase, comments. For example, this sentence would print the persons name in it----<BR><BR>  Hello, can I speak with --A--first_name--B-- --A--last_name--B-- please? Well hello --A--title--B-- --A--last_name--B-- how are you today?<BR><BR> This would read----<BR><BR>Hello, can I speak with John Doe please? Well hello Mr. Doe how are you today?

<BR>
<A NAME="vicidial_scripts-active">
<BR>
<B>Active -</B> This determines whether this script can be selected to be used by a campaign.





<BR><BR><BR><BR>

<B><FONT SIZE=3>VICIDIAL_LEAD_FILTERS TABLE</FONT></B><BR><BR>
<A NAME="vicidial_lead_filters-lead_filter_id">
<BR>
<B>Filter ID -</B> This is the short name of a Vicidial Lead Filter. This needs to be a unique identifier. Do not use any spaces or punctuation for this field. max 10 characters, minimum of 2 characters.

<BR>
<A NAME="vicidial_lead_filters-lead_filter_name">
<B>Filter Name -</B> This is a more descriptive name of the Filter. This is a short summary of the filter. max 30 characters, minimum of 2 characters.

<BR>
<A NAME="vicidial_lead_filters-lead_filter_comments">
<B>Filter Comments -</B> This is where you can place comments for a Vicidial Filter such as -calls all California leads-.  max 255 characters, minimum of 2 characters.

<BR>
<A NAME="vicidial_lead_filters-lead_filter_sql">
<B>Filter SQL -</B> This is where you place the SQL query fragment that you want to filter by. do not begin or end with an AND, that will be added by the hopper cron script automatically. an example SQL query that would work here is- called_count > 4 and called_count < 8 -.





<BR><BR><BR><BR>

<B><FONT SIZE=3>VICIDIAL LIST LOADER FUNCTIONALITY</FONT></B><BR><BR>
<A NAME="vicidial_list_loader">
<BR>
The VICIDIAL basic web-based lead loader is designed simply to take a lead file - up to 8MB in size - that is either tab or pipe delimited and load it into the vicidial_list table. There is also a new beta version super lead loader that allows for field choosing and TXT- Plain Text, CSV- Comma Separated Values and XLS- Excel file formats. The lead loader does not do data validation or check for duplicates in itself or other lists, so that is something you need to do before you load the leads. Also, make sure that you have created the list that these leads are to be under so that you can use them. There is also the matter of time-zone-coding these leads. You may want to increase the frequency that the ADMIN_adjust_GMTnow_on_leads.pl is being run in the cron on your Asterisk server so that any loaded leads can be coded faster. Here is a list of the fields in their proper order for the lead files:
	<OL>
	<LI>Vendor Lead Code - shows up in the Vendor ID field of the GUI
	<LI>Source Code - internal use only for admins and DBAs
	<LI>List ID - the list number that these leads will show up under
	<LI>Phone Code - the prefix for the phone number - 1 for US, 01144 for UK, 01161 for AUS, etc
	<LI>Phone Number - must be at least 8 digits long
	<LI>Title - title of the customer - Mr. Ms. Mrs, etc...
	<LI>First Name
	<LI>Middle Initial
	<LI>Last Name
	<LI>Address Line 1
	<LI>Address Line 2
	<LI>Address Line 3
	<LI>City
	<LI>State - limited to 2 characters
	<LI>Province
	<LI>Postal Code
	<LI>Country
	<LI>Gender
	<LI>Date of Birth
	<LI>Alternate Phone Number
	<LI>Email Address
	<LI>Security Phrase
	<LI>Comments
	</OL>

<BR>NOTES: The Excel Lead loader functionality is enabled by a series of perl scripts and needs to have a properly configured /home/cron/AST_SERVER_conf.pl file in place on the web server. Also, a couple perl modules must be loaded for it to work as well - OLE-Storage_Lite and Spreadsheet-ParseExcel. You can check for runtime errors in these by looking at your apache error_log file.

<BR><BR><BR><BR><BR><BR><BR><BR>
<BR><BR><BR><BR><BR><BR><BR><BR>
THE END
</TD></TR></TABLE></BODY></HTML>
<?
exit;

#### END HELP SCREENS
}





######################
# ADD=7111111 view sample script with test variables
######################

if ($ADD==7111111)
{
	##### TEST VARIABLES #####
	$vendor_lead_code = 'VENDORLEADCODE';
	$list_id = 'LISTID';
	$gmt_offset_now = 'GMTOFFSET';
	$phone_code = '1';
	$phone_number = '7275551212';
	$title = 'Mr.';
	$first_name = 'JOHN';
	$middle_initial = 'Q';
	$last_name = 'PUBLIC';
	$address1 = '1234 Main St.';
	$address2 = 'Apt. 3';
	$address3 = 'ADDRESS3';
	$city = 'CHICAGO';
	$state = 'IL';
	$province = 'PROVINCE';
	$postal_code = '33760';
	$country_code = 'USA';
	$gender = 'M';
	$date_of_birth = '1970-01-01';
	$alt_phone = '3125551212';
	$email = 'test@test.com';
	$security_phrase = 'SECUTIRY';
	$comments = 'COMMENTS FIELD';
	$RGfullname = 'JOE AGENT';
	$RGuser = '6666';

echo "</title>\n";
echo "</head>\n";
echo "<BODY BGCOLOR=white marginheight=0 marginwidth=0 leftmargin=0 topmargin=0>\n";
echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

$stmt="SELECT * from vicidial_scripts where script_id='$script_id';";
$rslt=mysql_query($stmt, $link);
$row=mysql_fetch_row($rslt);
$script_name =		$row[1];
$script_text =		$row[3];

$script_text = eregi_replace('--A--vendor_lead_code--B--',"$vendor_lead_code",$script_text);
$script_text = eregi_replace('--A--list_id--B--',"$list_id",$script_text);
$script_text = eregi_replace('--A--gmt_offset_now--B--',"$gmt_offset_now",$script_text);
$script_text = eregi_replace('--A--phone_code--B--',"$phone_code",$script_text);
$script_text = eregi_replace('--A--phone_number--B--',"$phone_number",$script_text);
$script_text = eregi_replace('--A--title--B--',"$title",$script_text);
$script_text = eregi_replace('--A--first_name--B--',"$first_name",$script_text);
$script_text = eregi_replace('--A--middle_initial--B--',"$middle_initial",$script_text);
$script_text = eregi_replace('--A--last_name--B--',"$last_name",$script_text);
$script_text = eregi_replace('--A--address1--B--',"$address1",$script_text);
$script_text = eregi_replace('--A--address2--B--',"$address2",$script_text);
$script_text = eregi_replace('--A--address3--B--',"$address3",$script_text);
$script_text = eregi_replace('--A--city--B--',"$city",$script_text);
$script_text = eregi_replace('--A--state--B--',"$state",$script_text);
$script_text = eregi_replace('--A--province--B--',"$province",$script_text);
$script_text = eregi_replace('--A--postal_code--B--',"$postal_code",$script_text);
$script_text = eregi_replace('--A--country_code--B--',"$country_code",$script_text);
$script_text = eregi_replace('--A--gender--B--',"$gender",$script_text);
$script_text = eregi_replace('--A--date_of_birth--B--',"$date_of_birth",$script_text);
$script_text = eregi_replace('--A--alt_phone--B--',"$alt_phone",$script_text);
$script_text = eregi_replace('--A--email--B--',"$email",$script_text);
$script_text = eregi_replace('--A--security_phrase--B--',"$security_phrase",$script_text);
$script_text = eregi_replace('--A--comments--B--',"$comments",$script_text);
$script_text = eregi_replace('--A--fullname--B--',"$RGfullname",$script_text);
$script_text = eregi_replace('--A--user--B--',"$RGuser",$script_text);
$script_text = eregi_replace("\n","<BR>",$script_text);


echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

echo "Preview Script: $script_id<BR>\n";
echo "<TABLE WIDTH=400><TR><TD>\n";
echo "<center><B>$script_name</B><BR></center>\n";
echo "$script_text\n";
echo "</TD></TR></TABLE></center>\n";

echo "</BODY></HTML>\n";

exit;
}




######################### HTML HEADER BEGIN #######################################
if ($hh=='users') {$users_hh='bgcolor ="#FFFF99"'; $users_fc='BLACK';}	# yellow
	else {$users_hh=''; $users_fc='WHITE';}
if ($hh=='campaigns') {$campaigns_hh='bgcolor ="#FFCC99"'; $campaigns_fc='BLACK';}	# orange
	else {$campaigns_hh=''; $campaigns_fc='WHITE';}
if ($hh=='lists') {$lists_hh='bgcolor ="#FFCCCC"'; $lists_fc='BLACK';}	# red
	else {$lists_hh=''; $lists_fc='WHITE';}
if ($hh=='ingroups') {$ingroups_hh='bgcolor ="#CC99FF"'; $ingroups_fc='BLACK';} # purple
	else {$ingroups_hh=''; $ingroups_fc='WHITE';}
if ($hh=='remoteagent') {$remoteagent_hh='bgcolor ="#CCFFCC"'; $remoteagent_fc='BLACK';}	# green
	else {$remoteagent_hh=''; $remoteagent_fc='WHITE';}
if ($hh=='usergroups') {$usergroups_hh='bgcolor ="#CCFFFF"'; $usergroups_fc='BLACK';}	# cyan
	else {$usergroups_hh=''; $usergroups_fc='WHITE';}
if ($hh=='scripts') {$scripts_hh='bgcolor ="#99FFCC"'; $scripts_fc='BLACK';}	# teal
	else {$scripts_hh=''; $scripts_fc='WHITE';}
if ($hh=='filters') {$filters_hh='bgcolor ="#CCCCCC"'; $filters_fc='BLACK';} # grey
	else {$filters_hh=''; $filters_fc='WHITE';}

?>
</title>
<script language="Javascript">
function openNewWindow(url) {
  window.open (url,"",'width=500,height=300,scrollbars=yes,menubar=yes,address=yes');
}
</script>
</head>
<BODY BGCOLOR=white marginheight=0 marginwidth=0 leftmargin=0 topmargin=0>
<?
echo "<!-- INTERNATIONALIZATION-LINKS-PLACEHOLDER-VICIDIAL -->\n";
?>
<CENTER>
<TABLE WIDTH=620 BGCOLOR=#D9E6FE cellpadding=2 cellspacing=0><TR BGCOLOR=#015B91><TD ALIGN=LEFT COLSPAN=6><FONT FACE="ARIAL,HELVETICA" COLOR=WHITE SIZE=2><B> &nbsp; VICIDIAL ADMIN - <a href="<? echo $PHP_SELF ?>?force_logout=1"><FONT FACE="ARIAL,HELVETICA" COLOR=WHITE SIZE=1>Logout</a></TD><TD ALIGN=RIGHT COLSPAN=3><FONT FACE="ARIAL,HELVETICA" COLOR=WHITE SIZE=2><B><? echo date("l F j, Y G:i:s A") ?> &nbsp; </TD></TR>

<TR BGCOLOR=#000000>
<TD ALIGN=CENTER <?=$users_hh?>><a href="<? echo $PHP_SELF ?>?ADD=0"><FONT FACE="ARIAL,HELVETICA" COLOR=<?=$users_fc?> SIZE=1><B> USERS </a></TD>
<TD ALIGN=CENTER <?=$campaigns_hh?>><a href="<? echo $PHP_SELF ?>?ADD=10"><FONT FACE="ARIAL,HELVETICA" COLOR=<?=$campaigns_fc?> SIZE=1><B> CAMPAIGNS </a></TD>
<TD ALIGN=CENTER <?=$lists_hh?>><a href="<? echo $PHP_SELF ?>?ADD=100"><FONT FACE="ARIAL,HELVETICA" COLOR=<?=$lists_fc?> SIZE=1><B> LISTS </a></TD>
<TD ALIGN=CENTER <?=$scripts_hh?>><a href="<? echo $PHP_SELF ?>?ADD=1000000"><FONT FACE="ARIAL,HELVETICA" COLOR=<?=$scripts_fc?> SIZE=1><B> SCRIPTS </a></TD>
<TD ALIGN=CENTER <?=$filters_hh?>><a href="<? echo $PHP_SELF ?>?ADD=10000000"><FONT FACE="ARIAL,HELVETICA" COLOR=<?=$filters_fc?> SIZE=1><B> FILTERS </a></TD>
<TD ALIGN=CENTER <?=$ingroups_hh?>><a href="<? echo $PHP_SELF ?>?ADD=1000"><FONT FACE="ARIAL,HELVETICA" COLOR=<?=$ingroups_fc?> SIZE=1><B> IN-GROUPS </a></TD>
<TD ALIGN=CENTER <?=$usergroups_hh?>><a href="<? echo $PHP_SELF ?>?ADD=100000"><FONT FACE="ARIAL,HELVETICA" COLOR=<?=$usergroups_fc?> SIZE=1><B> USER GROUPS </a></TD>
<TD ALIGN=CENTER <?=$remoteagent_hh?>><a href="<? echo $PHP_SELF ?>?ADD=10000"><FONT FACE="ARIAL,HELVETICA" COLOR=<?=$remoteagent_fc?> SIZE=1><B> REMOTE AGENTS </a></TD>
<TD ALIGN=CENTER <?=$reports_hh?>><a href="server_stats.php"><FONT FACE="ARIAL,HELVETICA" COLOR=WHITE SIZE=1><B> REPORTS </a></TD>
</TR>


<? if (strlen($users_hh) > 1) { 
	?>
<TR BGCOLOR=#FFFF99><TD ALIGN=CENTER COLSPAN=9><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=1><B> &nbsp; <a href="<? echo $PHP_SELF ?>"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=1>LIST USERS</a> &nbsp; &nbsp; | &nbsp; &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=1"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=1>ADD A NEW USER</a> &nbsp; &nbsp; | &nbsp; &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=55"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=1>SEARCH FOR A USER</a></TD></TR>
<? } 
if (strlen($campaigns_hh) > 1) { 
	?>
<TR BGCOLOR=#FFCC99><TD ALIGN=CENTER COLSPAN=9><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=1><B> &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=11"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=1>ADD CAMPAIGN</a> &nbsp; &nbsp; | &nbsp; &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=10"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=1>LIST CAMPAIGNS</a></TD></TR>
<? } 
if (strlen($lists_hh) > 1) { 
	?>
<TR BGCOLOR=#FFCCCC><TD ALIGN=CENTER COLSPAN=9><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=1><B> &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=100"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=1>SHOW LISTS</a> &nbsp; &nbsp; | &nbsp; &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=111"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=1>ADD NEW LIST</a> &nbsp; &nbsp; | &nbsp; &nbsp; <a href="admin_search_lead.php"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=1>SEARCH FOR A LEAD</a> | &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; | &nbsp; &nbsp; <a href="./listloaderMAIN.php"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=1>LOAD NEW LEADS</a></TD></TR>
<? } 
if (strlen($scripts_hh) > 1) { 
	?>
<TR BGCOLOR=#99FFCC><TD ALIGN=CENTER COLSPAN=9><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=1><B> &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=1111111"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=1>ADD SCRIPT</a> &nbsp; &nbsp; | &nbsp; &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=1000000"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=1>VIEW SCRIPTS</a></TD></TR>
<? } 
if (strlen($filters_hh) > 1) { 
	?>
<TR BGCOLOR=#CCCCCC><TD ALIGN=CENTER COLSPAN=9><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=1><B> &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=11111111"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=1>ADD FILTER</a> &nbsp; &nbsp; | &nbsp; &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=10000000"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=1>VIEW FILTERS</a></TD></TR>
<? } 
if (strlen($ingroups_hh) > 1) { 
	?>
<TR BGCOLOR=#CC99FF><TD ALIGN=CENTER COLSPAN=9><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=1><B> &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=1000"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=1>SHOW IN-GROUPS</a> &nbsp; &nbsp; | &nbsp; &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=1111"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=1>ADD NEW IN-GROUP</a></TD></TR>
<? } 
if (strlen($usergroups_hh) > 1) { 
	?>
<TR BGCOLOR=#CCFFFF><TD ALIGN=CENTER COLSPAN=9><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=1><B> &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=111111"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=1>ADD USER GROUP</a> &nbsp; &nbsp; | &nbsp; &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=100000"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=1>LIST USER GROUPS</a> &nbsp; &nbsp; | &nbsp; &nbsp; <a href="group_hourly_stats.php"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=1>GROUP HOURLY</a></TD></TR>
<? } 
if (strlen($remoteagent_hh) > 1) { 
	?>
<TR BGCOLOR=#CCFFCC><TD ALIGN=CENTER COLSPAN=9><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=1><B> &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=10000"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=1>SHOW REMOTE AGENTS</a> &nbsp; &nbsp; | &nbsp; &nbsp; <a href="<? echo $PHP_SELF ?>?ADD=11111"><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=1>ADD NEW REMOTE AGENTS</a></TD></TR>
<? } 
if (strlen($reports_hh) > 1) { 
	?>
<TR BGCOLOR=#FFCC99><TD ALIGN=CENTER COLSPAN=9><FONT FACE="ARIAL,HELVETICA" COLOR=BLACK SIZE=1><B> &nbsp; </TD></TR>
<? } ?>


<TR><TD ALIGN=LEFT COLSPAN=9 HEIGHT=2 BGCOLOR=BLACK></TD></TR>
<TR><TD ALIGN=LEFT COLSPAN=9>
<? 
######################### HTML HEADER BEGIN #######################################





######################################################################################################
######################################################################################################
#######   1 series, ADD NEW forms for inserting new records into the database
######################################################################################################
######################################################################################################


######################
# ADD=1 display the ADD NEW USER FORM SCREEN
######################

if ($ADD==1)
{
echo "<TABLE><TR><TD>\n";
echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

echo "<br>ADD A NEW USER<form action=$PHP_SELF method=POST>\n";
echo "<input type=hidden name=ADD value=2>\n";
echo "<center><TABLE width=600 cellspacing=3>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>User Number: </td><td align=left><input type=text name=user size=20 maxlength=10>$NWB#vicidial_users-user$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Password: </td><td align=left><input type=text name=pass size=20 maxlength=10>$NWB#vicidial_users-pass$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Full Name: </td><td align=left><input type=text name=full_name size=20 maxlength=100>$NWB#vicidial_users-full_name$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>User Level: </td><td align=left><select size=1 name=user_level>";
$h=1;
while ($h<=$LOGuser_level)
	{
	echo "<option>$h</option>";
	$h++;
	}
echo "</select>$NWB#vicidial_users-user_level$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>User Group: </td><td align=left><select size=1 name=user_group>\n";

	$stmt="SELECT user_group,group_name from vicidial_user_groups order by user_group";
	$rsltx=mysql_query($stmt, $link);
	$Ugroups_to_print = mysql_num_rows($rsltx);
	$Ugroups_list='';

	$o=0;
	while ($Ugroups_to_print > $o) {
		$rowx=mysql_fetch_row($rsltx);
		$Ugroups_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
		$o++;
	}
echo "$Ugroups_list";
echo "<option SELECTED>$user_group</option>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Phone Login: </td><td align=left><input type=text name=phone_login size=20 maxlength=20>$NWB#vicidial_users-phone_login$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Phone Pass: </td><td align=left><input type=text name=phone_pass size=20 maxlength=20>$NWB#vicidial_users-phone_pass$NWE</td></tr>\n";
echo "</select>$NWB#vicidial_users-user_group$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=SUBMIT value=SUBMIT></td></tr>\n";
echo "</TABLE></center>\n";

}


######################
# ADD=11 display the ADD NEW CAMPAIGN FORM SCREEN
######################

if ($ADD==11)
{
echo "<TABLE><TR><TD>\n";
echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

echo "<br>ADD A NEW CAMPAIGN<form action=$PHP_SELF method=POST>\n";
echo "<input type=hidden name=ADD value=21>\n";
echo "<center><TABLE width=600 cellspacing=3>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Campaign ID: </td><td align=left><input type=text name=campaign_id size=8 maxlength=8>$NWB#vicidial_campaigns-campaign_id$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Campaign Name: </td><td align=left><input type=text name=campaign_name size=30 maxlength=30>$NWB#vicidial_campaigns-campaign_name$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Active: </td><td align=left><select size=1 name=active><option>Y</option><option>N</option></select>$NWB#vicidial_campaigns-active$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Park Extension: </td><td align=left><input type=text name=park_ext size=10 maxlength=10>$NWB#vicidial_campaigns-park_ext$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Park Filename: </td><td align=left><input type=text name=park_file_name size=10 maxlength=10>$NWB#vicidial_campaigns-park_file_name$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Web Form: </td><td align=left><input type=text name=web_form_address size=50 maxlength=255>$NWB#vicidial_campaigns-web_form_address$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Allow Closers: </td><td align=left><select size=1 name=allow_closers><option>Y</option><option>N</option></select>$NWB#vicidial_campaigns-allow_closers$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Hopper Level: </td><td align=left><select size=1 name=hopper_level><option>1</option><option>5</option><option>10</option><option>50</option><option>100</option><option>200</option><option>500</option><option>1000</option></select>$NWB#vicidial_campaigns-hopper_level$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Auto Dial Level: </td><td align=left><select size=1 name=auto_dial_level><option selected>0</option><option>1</option><option>1.1</option><option>1.2</option><option>1.3</option><option>1.4</option><option>1.5</option><option>1.6</option><option>1.7</option><option>1.8</option><option>1.9</option><option>2.0</option><option>2.2</option><option>2.5</option><option>2.7</option><option>3.0</option><option>3.5</option><option>4.0</option></select>(0 = off)$NWB#vicidial_campaigns-auto_dial_level$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Next Agent Call: </td><td align=left><select size=1 name=next_agent_call><option >random</option><option>oldest_call_start</option><option>oldest_call_finish</option><option>overall_user_level</option></select>$NWB#vicidial_campaigns-next_agent_call$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Local Call Time: </td><td align=left><select size=1 name=local_call_time><option >24hours</option><option >9am-9pm</option><option>9am-5pm</option><option>12pm-5pm</option><option>12pm-9pm</option><option>5pm-9pm</option></select>$NWB#vicidial_campaigns-local_call_time$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Voicemail: </td><td align=left><input type=text name=voicemail_ext size=10 maxlength=10 value=\"$voicemail_ext\">$NWB#vicidial_campaigns-voicemail_ext$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Script: </td><td align=left><select size=1 name=script_id>\n";
echo "$scripts_list";
echo "</select>$NWB#vicidial_campaigns-campaign_script$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Get Call Launch: </td><td align=left><select size=1 name=get_call_launch><option selected>NONE</option><option>SCRIPT</option><option>WEBFORM</option></select>$NWB#vicidial_campaigns-get_call_launch$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=SUBMIT value=SUBMIT></td></tr>\n";
echo "</TABLE></center>\n";

}


######################
# ADD=111 display the ADD NEW LIST FORM SCREEN
######################

if ($ADD==111)
{
echo "<TABLE><TR><TD>\n";
echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

echo "<br>ADD A NEW LIST<form action=$PHP_SELF method=POST>\n";
echo "<input type=hidden name=ADD value=211>\n";
echo "<center><TABLE width=600 cellspacing=3>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>List ID: </td><td align=left><input type=text name=list_id size=8 maxlength=8> (digits only)$NWB#vicidial_lists-list_id$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>List Name: </td><td align=left><input type=text name=list_name size=20 maxlength=20>$NWB#vicidial_lists-list_name$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Campaign: </td><td align=left><select size=1 name=campaign_id>\n";

	$stmt="SELECT campaign_id,campaign_name from vicidial_campaigns order by campaign_id";
	$rsltx=mysql_query($stmt, $link);
	$campaigns_to_print = mysql_num_rows($rsltx);
	$campaigns_list='';

	$o=0;
	while ($campaigns_to_print > $o) {
		$rowx=mysql_fetch_row($rsltx);
		$campaigns_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
		$o++;
	}
echo "$campaigns_list";
echo "<option SELECTED>$campaign_id</option>\n";
echo "</select>$NWB#vicidial_lists-campaign_id$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Active: </td><td align=left><select size=1 name=active><option>Y</option><option SELECTED>N</option></select>$NWB#vicidial_lists-active$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=SUBMIT value=SUBMIT></td></tr>\n";
echo "</TABLE></center>\n";

}


######################
# ADD=1111 display the ADD NEW INBOUND GROUP SCREEN
######################

if ($ADD==1111)
{
echo "<TABLE><TR><TD>\n";
echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

echo "<br>ADD A NEW INBOUND GROUP<form action=$PHP_SELF method=POST>\n";
echo "<input type=hidden name=ADD value=2111>\n";
echo "<center><TABLE width=600 cellspacing=3>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Group ID: </td><td align=left><input type=text name=group_id size=20 maxlength=20> (no spaces)$NWB#vicidial_inbound_groups-group_id$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Group Name: </td><td align=left><input type=text name=group_name size=30 maxlength=30>$NWB#vicidial_inbound_groups-group_name$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Group Color: </td><td align=left><input type=text name=group_color size=7 maxlength=7>$NWB#vicidial_inbound_groups-group_color$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Active: </td><td align=left><select size=1 name=active><option SELECTED>Y</option><option>N</option></select>$NWB#vicidial_inbound_groups-active$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Web Form: </td><td align=left><input type=text name=web_form_address size=50 maxlength=255 value=\"$web_form_address\">$NWB#vicidial_inbound_groups-web_form_address$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Voicemail: </td><td align=left><input type=text name=voicemail_ext size=10 maxlength=10 value=\"$voicemail_ext\">$NWB#vicidial_inbound_groups-voicemail_ext$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Next Agent Call: </td><td align=left><select size=1 name=next_agent_call><option >random</option><option>oldest_call_start</option><option>oldest_call_finish</option><option>overall_user_level</option></select>$NWB#vicidial_inbound_groups-next_agent_call$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Fronter Display: </td><td align=left><select size=1 name=fronter_display><option SELECTED>Y</option><option>N</option></select>$NWB#vicidial_inbound_groups-fronter_display$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Script: </td><td align=left><select size=1 name=script_id>\n";
echo "$scripts_list";
echo "</select>$NWB#vicidial_inbound_groups-ingroup_script$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Get Call Launch: </td><td align=left><select size=1 name=get_call_launch><option selected>NONE</option><option>SCRIPT</option><option>WEBFORM</option></select>$NWB#vicidial_inbound_groups-get_call_launch$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=SUBMIT value=SUBMIT></td></tr>\n";
echo "</TABLE></center>\n";

}


######################
# ADD=11111 display the ADD NEW REMOTE AGENTS SCREEN
######################

if ($ADD==11111)
{
echo "<TABLE><TR><TD>\n";
echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

echo "<br>ADD NEW REMOTE AGENTS<form action=$PHP_SELF method=POST>\n";
echo "<input type=hidden name=ADD value=21111>\n";
echo "<center><TABLE width=600 cellspacing=3>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>User ID Start: </td><td align=left><input type=text name=user_start size=6 maxlength=6> (numbers only, incremented)$NWB#vicidial_remote_agents-user_start$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Number of Lines: </td><td align=left><input type=text name=number_of_lines size=3 maxlength=3> (numbers only)$NWB#vicidial_remote_agents-number_of_lines$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Server IP: </td><td align=left><select size=1 name=server_ip>\n";
echo "$servers_list";
echo "</select>$NWB#vicidial_remote_agents-server_ip$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>External Extension: </td><td align=left><input type=text name=conf_exten size=20 maxlength=20> (dialplan number dialed to reach agents)$NWB#vicidial_remote_agents-conf_exten$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Status: </td><td align=left><select size=1 name=status><option>ACTIVE</option><option SELECTED>INACTIVE</option></select>$NWB#vicidial_remote_agents-status$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Campaign: </td><td align=left><select size=1 name=campaign_id>\n";
echo "$campaigns_list";
echo "</select>$NWB#vicidial_remote_agents-campaign_id$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Inbound Groups: </td><td align=left>\n";
echo "$groups_list";
echo "$NWB#vicidial_remote_agents-closer_campaigns$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=SUBMIT value=SUBMIT></td></tr>\n";
echo "</TABLE></center>\n";
echo "NOTE: It can take up to 30 seconds for changes submitted on this screen to go live\n";

}


######################
# ADD=111111 display the ADD NEW USERS GROUP SCREEN
######################

if ($ADD==111111)
{
echo "<TABLE><TR><TD>\n";
echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

echo "<br>ADD NEW USERS GROUP<form action=$PHP_SELF method=POST>\n";
echo "<input type=hidden name=ADD value=211111>\n";
echo "<center><TABLE width=600 cellspacing=3>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Group: </td><td align=left><input type=text name=user_group size=15 maxlength=20> (no spaces or punctuation)$NWB#vicidial_user_groups-user_group$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Description: </td><td align=left><input type=text name=group_name size=40 maxlength=40> (description of group)$NWB#vicidial_user_groups-group_name$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=SUBMIT value=SUBMIT></td></tr>\n";
echo "</TABLE></center>\n";

}


######################
# ADD=1111111 display the ADD NEW SCRIPT SCREEN
######################

if ($ADD==1111111)
{
echo "<TABLE><TR><TD>\n";
echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

echo "<br>ADD NEW SCRIPT<form action=$PHP_SELF method=POST>\n";
echo "<input type=hidden name=ADD value=2111111>\n";
echo "<center><TABLE width=600 cellspacing=3>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Script ID: </td><td align=left><input type=text name=script_id size=12 maxlength=10> (no spaces or punctuation)$NWB#vicidial_scripts-script_id$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Script Name: </td><td align=left><input type=text name=script_name size=40 maxlength=50> (title of the script)$NWB#vicidial_scripts-script_name$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Script Comments: </td><td align=left><input type=text name=script_comments size=50 maxlength=255> $NWB#vicidial_scripts-script_comments$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Active: </td><td align=left><select size=1 name=active><option SELECTED>Y</option><option>N</option></select>$NWB#vicidial_scripts-active$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Script Text: </td><td align=left><TEXTAREA NAME=script_text ROWS=20 COLS=50 value=\"\"></TEXTAREA> $NWB#vicidial_scripts-script_text$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=SUBMIT value=SUBMIT></td></tr>\n";
echo "</TABLE></center>\n";

}


######################
# ADD=11111111 display the ADD NEW FILTER SCREEN
######################

if ($ADD==11111111)
{
echo "<TABLE><TR><TD>\n";
echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

echo "<br>ADD NEW FILTER<form action=$PHP_SELF method=POST>\n";
echo "<input type=hidden name=ADD value=21111111>\n";
echo "<center><TABLE width=600 cellspacing=3>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Filter ID: </td><td align=left><input type=text name=lead_filter_id size=12 maxlength=10> (no spaces or punctuation)$NWB#vicidial_lead_filters-lead_filter_id$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Filter Name: </td><td align=left><input type=text name=lead_filter_name size=30 maxlength=30> (short description of the filter)$NWB#vicidial_lead_filters-lead_filter_name$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Filter Comments: </td><td align=left><input type=text name=lead_filter_comments size=50 maxlength=255> $NWB#vicidial_lead_filters-lead_filter_comments$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Filter SQL: </td><td align=left><TEXTAREA NAME=lead_filter_sql ROWS=20 COLS=50 value=\"\"></TEXTAREA> $NWB#vicidial_lead_filters-lead_filter_sql$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=SUBMIT value=SUBMIT></td></tr>\n";
echo "</TABLE></center>\n";
}


######################################################################################################
######################################################################################################
#######   2 series, validates form data and inserts the new record into the database
######################################################################################################
######################################################################################################


######################
# ADD=2 adds the new user to the system
######################

if ($ADD==2)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_users where user='$user';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>USER NOT ADDED - there is already a user in the system with this user number\n";}
	else
		{
		 if ( (strlen($user) < 2) or (strlen($pass) < 2) or (strlen($full_name) < 2) or (strlen($user) > 8) )
			{
			 echo "<br>USER NOT ADDED - Please go back and look at the data you entered\n";
			 echo "<br>user id must be between 2 and 8 characters long\n";
			 echo "<br>full name and password must be at least 2 characters long\n";
			}
		 else
			{
			echo "<br><B>USER ADDED: $user</B>\n";

			$stmt="INSERT INTO vicidial_users (user,pass,full_name,user_level,user_group,phone_login,phone_pass) values('$user','$pass','$full_name','$user_level','$user_group','$phone_login','$phone_pass');";
			$rslt=mysql_query($stmt, $link);

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|ADD A USER          |$PHP_AUTH_USER|$ip|'$user','$pass','$full_name','$user_level','$user_group','$phone_login','$phone_pass'|\n");
				fclose($fp);
				}
			}
		}
$ADD=3;
}

######################
# ADD=21 adds the new campaign to the system
######################

if ($ADD==21)
{

	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_campaigns where campaign_id='$campaign_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>CAMPAIGN NOT ADDED - there is already a campaign in the system with this ID\n";}
	else
		{
		 if ( (strlen($campaign_id) < 2) or (strlen($campaign_id) > 8) or (strlen($campaign_name) < 6)  or (strlen($campaign_name) > 40) )
			{
			 echo "<br>CAMPAIGN NOT ADDED - Please go back and look at the data you entered\n";
			 echo "<br>campaign ID must be between 2 and 8 characters in length\n";
			 echo "<br>campaign name must be between 6 and 40 characters in length\n";
			}
		 else
			{
			echo "<br><B>CAMPAIGN ADDED: $campaign_id</B>\n";

			$stmt="INSERT INTO vicidial_campaigns (campaign_id,campaign_name,active,dial_status_a,lead_order,park_ext,park_file_name,web_form_address,allow_closers,hopper_level,auto_dial_level,next_agent_call,local_call_time,voicemail_ext,campaign_script,get_call_launch) values('$campaign_id','$campaign_name','$active','NEW','DOWN','$park_ext','$park_file_name','$web_form_address','$allow_closers','$hopper_level','$auto_dial_level','$next_agent_call','$local_call_time','$voicemail_ext','$script_id','$get_call_launch');";
			$rslt=mysql_query($stmt, $link);

			echo "<!-- $stmt -->";
			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|ADD A NEW CAMPAIGN  |$PHP_AUTH_USER|$ip|INSERT INTO vicidial_campaigns (campaign_id,campaign_name,active,dial_status_a,lead_order,park_ext,park_file_name,web_form_address,allow_closers,hopper_level,auto_dial_level,next_agent_call,local_call_time,voicemail_ext,campaign_script,get_call_launch) values('$campaign_id','$campaign_name','$active','NEW','DOWN','$park_ext','$park_file_name','$web_form_address','$allow_closers','$hopper_level','$auto_dial_level','$next_agent_call','$local_call_time','$voicemail_ext','$script_id','$get_call_launch')|\n");
				fclose($fp);
				}

			}
		}
$ADD=31;
}

######################
# ADD=22 adds the new campaign status to the system
######################

if ($ADD==22)
{

	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_campaign_statuses where campaign_id='$campaign_id' and status='$status';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>CAMPAIGN STATUS NOT ADDED - there is already a campaign-status in the system with this name\n";}
	else
		{
		$stmt="SELECT count(*) from vicidial_statuses where status='$status';";
		$rslt=mysql_query($stmt, $link);
		$row=mysql_fetch_row($rslt);
		if ($row[0] > 0)
			{echo "<br>CAMPAIGN STATUS NOT ADDED - there is already a global-status in the system with this name\n";}
		else
			{
			 if ( (strlen($campaign_id) < 2) or (strlen($status) < 1) or (strlen($status_name) < 2) )
				{
				 echo "<br>CAMPAIGN STATUS NOT ADDED - Please go back and look at the data you entered\n";
				 echo "<br>status must be between 1 and 8 characters in length\n";
				 echo "<br>status name must be between 2 and 30 characters in length\n";
				}
			 else
				{
				echo "<br><B>CAMPAIGN STATUS ADDED: $campaign_id - $status</B>\n";

				$stmt="INSERT INTO vicidial_campaign_statuses values('$status','$status_name','$selectable','$campaign_id');";
				$rslt=mysql_query($stmt, $link);

				### LOG CHANGES TO LOG FILE ###
				if ($WeBRooTWritablE > 0)
					{
					$fp = fopen ("./admin_changes_log.txt", "a");
					fwrite ($fp, "$date|ADD A NEW CAMPAIGN STATUS |$PHP_AUTH_USER|$ip|'$status','$status_name','$selectable','$campaign_id'|\n");
					fclose($fp);
					}
				}
			}
		}
$ADD=31;
}


######################
# ADD=23 adds the new campaign hotkey to the system
######################

if ($ADD==23)
{
	$HKstatus_data = explode('-----',$HKstatus);
	$status = $HKstatus_data[0];
	$status_name = $HKstatus_data[1];

	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_campaign_hotkeys where campaign_id='$campaign_id' and hotkey='$hotkey' and hotkey='$hotkey';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>CAMPAIGN HOTKEY NOT ADDED - there is already a campaign-hotkey in the system with this hotkey\n";}
	else
		{
		 if ( (strlen($campaign_id) < 2) or (strlen($status) < 1) or (strlen($hotkey) < 1) )
			{
			 echo "<br>CAMPAIGN HOTKEY NOT ADDED - Please go back and look at the data you entered\n";
			 echo "<br>hotkey must be a single character between 1 and 9 \n";
			 echo "<br>status must be between 1 and 8 characters in length\n";
			}
		 else
			{
			echo "<br><B>CAMPAIGN HOTKEY ADDED: $campaign_id - $status - $hotkey</B>\n";

			$stmt="INSERT INTO vicidial_campaign_hotkeys values('$status','$hotkey','$status_name','$selectable','$campaign_id');";
			$rslt=mysql_query($stmt, $link);

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|ADD A NEW CAMPAIGN HOTKEY |$PHP_AUTH_USER|$ip|'$status','$hotkey','$status_name','$selectable','$campaign_id'|\n");
				fclose($fp);
				}
			}
		}
$ADD=31;
}


######################
# ADD=211 adds the new list to the system
######################

if ($ADD==211)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_lists where list_id='$list_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>LIST NOT ADDED - there is already a list in the system with this ID\n";}
	else
		{
		 if ( (strlen($campaign_id) < 2) or (strlen($list_name) < 2)  or (strlen($list_id) < 2) or (strlen($list_id) > 8) )
			{
			 echo "<br>LIST NOT ADDED - Please go back and look at the data you entered\n";
			 echo "<br>List ID must be between 2 and 8 characters in length\n";
			 echo "<br>List name must be at least 2 characters in length\n";
			 }
		 else
			{
			echo "<br><B>LIST ADDED: $list_id</B>\n";

			$stmt="INSERT INTO vicidial_lists values('$list_id','$list_name','$campaign_id','$active');";
			$rslt=mysql_query($stmt, $link);

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|ADD A NEW LIST      |$PHP_AUTH_USER|$ip|'$list_id','$list_name','$campaign_id','$active'|\n");
				fclose($fp);
				}
			}
		}
$ADD=311;
}



######################
# ADD=2111 adds the new inbound group to the system
######################

if ($ADD==2111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_inbound_groups where group_id='$group_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>GROUP NOT ADDED - there is already a group in the system with this ID\n";}
	else
		{
		 if ( (strlen($group_id) < 2) or (strlen($group_name) < 2)  or (strlen($group_color) < 2) or (strlen($group_id) > 20) or (eregi(' ',$group_id)) or (eregi("\-",$group_id)) or (eregi("\+",$group_id)) )
			{
			 echo "<br>GROUP NOT ADDED - Please go back and look at the data you entered\n";
			 echo "<br>Group ID must be between 2 and 20 characters in length and contain no ' -+'.\n";
			 echo "<br>Group name and group color must be at least 2 characters in length\n";
			}
		 else
			{
			$stmt="INSERT INTO vicidial_inbound_groups (group_id,group_name,group_color,active,web_form_address,voicemail_ext,next_agent_call,fronter_display,ingroup_script,get_call_launch) values('$group_id','$group_name','$group_color','$active','$web_form_address','$voicemail_ext','$next_agent_call','$fronter_display','$script_id','$get_call_launch');";
			$rslt=mysql_query($stmt, $link);

			echo "<br><B>GROUP ADDED: $group_id</B>\n";

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|ADD A NEW GROUP     |$PHP_AUTH_USER|$ip|'$group_id','$group_name','$group_color','$active','$web_form_address','$voicemail_ext','$next_agent_call','$fronter_display','$script_id','$get_call_launch'|\n");
				fclose($fp);
				}
			}
		}
$ADD=1000;
}


######################
# ADD=21111 adds new remote agents to the system
######################

if ($ADD==21111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_remote_agents where server_ip='$server_ip' and user_start='$user_start';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>REMOTE AGENTS NOT ADDED - there is already a remote agents entry starting with this userID\n";}
	else
		{
		 if ( (strlen($server_ip) < 2) or (strlen($user_start) < 2)  or (strlen($campaign_id) < 2) or (strlen($conf_exten) < 2) )
			{
			 echo "<br>REMOTE AGENTS NOT ADDED - Please go back and look at the data you entered\n";
			 echo "<br>User ID start and external extension must be at least 2 characters in length\n";
			 }
		 else
			{
			$stmt="INSERT INTO vicidial_remote_agents values('','$user_start','$number_of_lines','$server_ip','$conf_exten','$status','$campaign_id','$groups_value');";
			$rslt=mysql_query($stmt, $link);

			echo "<br><B>REMOTE AGENTS ADDED: $user_start</B>\n";

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|ADD A NEW REMOTE AGENTS ENTRY     |$PHP_AUTH_USER|$ip|'$user_start','$number_of_lines','$server_ip','$conf_exten','$status','$campaign_id','$groups_value'|\n");
				fclose($fp);
				}
			}
		}
$ADD=10000;
}

######################
# ADD=211111 adds new user group to the system
######################

if ($ADD==211111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_user_groups where user_group='$user_group';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>USER GROUP NOT ADDED - there is already a user group entry with this name\n";}
	else
		{
		 if ( (strlen($user_group) < 2) or (strlen($group_name) < 2) )
			{
			 echo "<br>USER GROUP NOT ADDED - Please go back and look at the data you entered\n";
			 echo "<br>Group name and description must be at least 2 characters in length\n";
			 }
		 else
			{
			$stmt="INSERT INTO vicidial_user_groups values('$user_group','$group_name');";
			$rslt=mysql_query($stmt, $link);

			echo "<br><B>USER GROUP ADDED: $user_start</B>\n";

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|ADD A NEW USER GROUP ENTRY     |$PHP_AUTH_USER|$ip|'$user_group','$group_name'|\n");
				fclose($fp);
				}
			}
		}
$ADD=100000;
}

######################
# ADD=2111111 adds new script to the system
######################

if ($ADD==2111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_scripts where script_id='$script_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>SCRIPT NOT ADDED - there is already a script entry with this name\n";}
	else
		{
		 if ( (strlen($script_id) < 2) or (strlen($script_name) < 2) or (strlen($script_text) < 2) )
			{
			 echo "<br>SCRIPT NOT ADDED - Please go back and look at the data you entered\n";
			 echo "<br>Script name, description and text must be at least 2 characters in length\n";
			 }
		 else
			{
			$stmt="INSERT INTO vicidial_scripts values('$script_id','$script_name','$script_comments','$script_text','$active');";
			$rslt=mysql_query($stmt, $link);

			echo "<br><B>SCRIPT ADDED: $script_id</B>\n";

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|ADD A NEW SCRIPT ENTRY         |$PHP_AUTH_USER|$ip|'$script_id','$script_name','$script_comments','$script_text','$active'|\n");
				fclose($fp);
				}
			}
		}
$ADD=1000000;
}


######################
# ADD=21111111 adds new filter to the system
######################

if ($ADD==21111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";
	$stmt="SELECT count(*) from vicidial_lead_filters where lead_filter_id='$lead_filter_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	if ($row[0] > 0)
		{echo "<br>FILTER NOT ADDED - there is already a filter entry with this ID\n";}
	else
		{
		 if ( (strlen($lead_filter_id) < 2) or (strlen($lead_filter_name) < 2) or (strlen($lead_filter_sql) < 2) )
			{
			 echo "<br>FILTER NOT ADDED - Please go back and look at the data you entered\n";
			 echo "<br>Filter ID, name and SQL must be at least 2 characters in length\n";
			 }
		 else
			{
			$stmt="INSERT INTO vicidial_lead_filters SET lead_filter_id='$lead_filter_id',lead_filter_name='$lead_filter_name',lead_filter_comments='$lead_filter_comments',lead_filter_sql='$lead_filter_sql';";
			$rslt=mysql_query($stmt, $link);

			echo "<br><B>FILTER ADDED: $lead_filter_id</B>\n";

			### LOG CHANGES TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|ADD A NEW FILTER ENTRY         |$PHP_AUTH_USER|$ip|lead_filter_id='$lead_filter_id',lead_filter_name='$lead_filter_name',lead_filter_comments='$lead_filter_comments',lead_filter_sql='$lead_filter_sql'|\n");
				fclose($fp);
				}
			}
		}
$ADD=10000000;
}





######################################################################################################
######################################################################################################
#######   4 series, record modifications submitted and DB is modified, then on to 3 series forms below
######################################################################################################
######################################################################################################



######################
# ADD=4A submit user modifications to the system - ADMIN
######################

if ($ADD=="4A")
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($pass) < 2) or (strlen($full_name) < 2) or (strlen($user_level) < 1) )
		{
		 echo "<br>USER NOT MODIFIED - Please go back and look at the data you entered\n";
		 echo "<br>Password and Full Name each need ot be at least 2 characters in length\n";
		}
	 else
		{
		echo "<br><B>USER MODIFIED - ADMIN: $user</B>\n";

		$stmt="UPDATE vicidial_users set pass='$pass',full_name='$full_name',user_level='$user_level',user_group='$user_group',phone_login='$phone_login',phone_pass='$phone_pass',delete_users='$delete_users',delete_user_groups='$delete_user_groups',delete_lists='$delete_lists',delete_campaigns='$delete_campaigns',delete_ingroups='$delete_ingroups',delete_remote_agents='$delete_remote_agents',load_leads='$load_leads',campaign_detail='$campaign_detail',ast_admin_access='$ast_admin_access',ast_delete_phones='$ast_delete_phones',delete_scripts='$delete_scripts',modify_leads='$modify_leads',hotkeys_active='$hotkeys_active',change_agent_campaign='$change_agent_campaign',agent_choose_ingroups='$agent_choose_ingroups',closer_campaigns='$groups_value',scheduled_callbacks='$scheduled_callbacks',agentonly_callbacks='$agentonly_callbacks',agentcall_manual='$agentcall_manual',vicidial_recording='$vicidial_recording',vicidial_transfers='$vicidial_transfers',delete_filters='$delete_filters' where user='$user';";
		$rslt=mysql_query($stmt, $link);



		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|MODIFY USER INFO    |$PHP_AUTH_USER|$ip|pass='$pass',full_name='$full_name',user_level='$user_level',user_group='$user_group',phone_login='$phone_login',phone_pass='$phone_pass',delete_users='$delete_users',delete_user_groups='$delete_user_groups',delete_lists='$delete_lists',delete_campaigns='$delete_campaigns',delete_ingroups='$delete_ingroups',delete_remote_agents='$delete_remote_agents',load_leads='$load_leads',campaign_detail='$campaign_detail',ast_admin_access='$ast_admin_access',ast_delete_phones='$ast_delete_phones',delete_scripts='$delete_scripts',modify_leads='$modify_leads',hotkeys_active='$hotkeys_active',change_agent_campaign='$change_agent_campaign',agent_choose_ingroups='$agent_choose_ingroups', closer_campaigns='$groups_value',scheduled_callbacks='$scheduled_callbacks',agentonly_callbacks='$agentonly_callbacks',agentcall_manual='$agentcall_manual',vicidial_recording='$vicidial_recording',vicidial_transfers='$vicidial_transfers',delete_filters='$delete_filters' where user='$user'|\n");
			fclose($fp);
			}
		}

$ADD=3;		# go to user modification below
}

######################
# ADD=4 submit user modifications to the system
######################

if ($ADD==4)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($pass) < 2) or (strlen($full_name) < 2) or (strlen($user_level) < 1) )
		{
		 echo "<br>USER NOT MODIFIED - Please go back and look at the data you entered\n";
		 echo "<br>Password and Full Name each need ot be at least 2 characters in length\n";
		}
	 else
		{
		echo "<br><B>USER MODIFIED: $user</B>\n";

		$stmt="UPDATE vicidial_users set pass='$pass',full_name='$full_name',user_level='$user_level',user_group='$user_group',phone_login='$phone_login',phone_pass='$phone_pass' where user='$user';";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|MODIFY USER INFO    |$PHP_AUTH_USER|$ip|pass='$pass',full_name='$full_name',user_level='$user_level',user_group='$user_group',phone_login='$phone_login',phone_pass='$phone_pass' where user='$user'|\n");
			fclose($fp);
			}
		}

$ADD=3;		# go to user modification below
}

######################
# ADD=41 submit campaign modifications to the system
######################

if ($ADD==41)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($campaign_name) < 6) or (strlen($active) < 1) )
		{
		 echo "<br>CAMPAIGN NOT MODIFIED - Please go back and look at the data you entered\n";
		 echo "<br>the campaign name needs to be at least 6 characters in length\n";
		}
	 else
		{
		echo "<br><B>CAMPAIGN MODIFIED: $campaign_id</B>\n";

		$stmt="UPDATE vicidial_campaigns set campaign_name='$campaign_name',active='$active',dial_status_a='$dial_status_a',dial_status_b='$dial_status_b',dial_status_c='$dial_status_c',dial_status_d='$dial_status_d',dial_status_e='$dial_status_e',lead_order='$lead_order',allow_closers='$allow_closers',hopper_level='$hopper_level', auto_dial_level='$auto_dial_level', next_agent_call='$next_agent_call', local_call_time='$local_call_time', voicemail_ext='$voicemail_ext', dial_timeout='$dial_timeout', dial_prefix='$dial_prefix', campaign_cid='$campaign_cid', campaign_vdad_exten='$campaign_vdad_exten', web_form_address='$web_form_address', park_ext='$park_ext', park_file_name='$park_file_name', campaign_rec_exten='$campaign_rec_exten', campaign_recording='$campaign_recording', campaign_rec_filename='$campaign_rec_filename', campaign_script='$script_id', get_call_launch='$get_call_launch', am_message_exten='$am_message_exten', amd_send_to_vmx='$amd_send_to_vmx', xferconf_a_dtmf='$xferconf_a_dtmf',xferconf_a_number='$xferconf_a_number', xferconf_b_dtmf='$xferconf_b_dtmf',xferconf_b_number='$xferconf_b_number',lead_filter_id='$lead_filter_id',alt_number_dialing='$alt_number_dialing',scheduled_callbacks='$scheduled_callbacks' where campaign_id='$campaign_id';";
		$rslt=mysql_query($stmt, $link);

		if ($reset_hopper == 'Y')
			{
			echo "<br>RESETTING CAMPAIGN LEAD HOPPER\n";
			echo "<br> - Wait 1 minute before dialing next number\n";
			$stmt="DELETE from vicidial_hopper where campaign_id='$campaign_id' and status='READY';";
			$rslt=mysql_query($stmt, $link);

			### LOG RESET TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|CAMPAIGN HOPPERRESET|$PHP_AUTH_USER|$ip|campaign_name='$campaign_name'|\n");
				fclose($fp);
				}
			}

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|MODIFY CAMPAIGN INFO|$PHP_AUTH_USER|$ip|campaign_name='$campaign_name',active='$active',dial_status_a='$dial_status_a',dial_status_b='$dial_status_b',dial_status_c='$dial_status_c',dial_status_d='$dial_status_d',dial_status_e='$dial_status_e',lead_order='$lead_order',allow_closers='$allow_closers',hopper_level='$hopper_level', auto_dial_level='$auto_dial_level', next_agent_call='$next_agent_call', local_call_time='$local_call_time', voicemail_ext='$voicemail_ext', dial_timeout='$dial_timeout', dial_prefix='$dial_prefix', campaign_cid='$campaign_cid', campaign_vdad_exten='$campaign_vdad_exten', web_form_address='$web_form_address', park_ext='$park_ext', park_file_name='$park_file_name', campaign_rec_exten='$campaign_rec_exten', campaign_recording='$campaign_recording', campaign_rec_filename='$campaign_rec_filename', campaign_script='$script_id', get_call_launch='$get_call_launch', am_message_exten='$am_message_exten', amd_send_to_vmx='$amd_send_to_vmx', xferconf_a_dtmf='$xferconf_a_dtmf',xferconf_a_number='$xferconf_a_number', xferconf_b_dtmf='$xferconf_b_dtmf',xferconf_b_number='$xferconf_b_number',lead_filter_id='$lead_filter_id',alt_number_dialing='$alt_number_dialing',scheduled_callbacks='$scheduled_callbacks' where campaign_id='$campaign_id'|$reset_hopper|\n");
			fclose($fp);
			}
		}

$ADD=31;	# go to campaign modification form below
}

######################
# ADD=42 delete campaign status in the system
######################

if ($ADD==42)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($campaign_id) < 2) or (strlen($status) < 1) )
		{
		 echo "<br>CAMPAIGN STATUS NOT MODIFIED - Please go back and look at the data you entered\n";
		 echo "<br>the campaign id needs to be at least 2 characters in length\n";
		 echo "<br>the campaign status needs to be at least 1 characters in length\n";
		}
	 else
		{
		echo "<br><B>CUSTOM CAMPAIGN STATUS DELETED: $campaign_id - $status</B>\n";

		$stmt="DELETE FROM vicidial_campaign_statuses where campaign_id='$campaign_id' and status='$status';";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|DELETE CAMPAIGN STATUS|$PHP_AUTH_USER|$ip|DELETE FROM vicidial_campaign_statuses where campaign_id='$campaign_id' and status='$status'|\n");
			fclose($fp);
			}
		}

$ADD=31;	# go to campaign modification form below
}

######################
# ADD=43 delete campaign hotkey in the system
######################

if ($ADD==43)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($campaign_id) < 2) or (strlen($status) < 1) or (strlen($hotkey) < 1) )
		{
		 echo "<br>CAMPAIGN HOTKEY NOT MODIFIED - Please go back and look at the data you entered\n";
		 echo "<br>the campaign id needs to be at least 2 characters in length\n";
		 echo "<br>the campaign status needs to be at least 1 characters in length\n";
		 echo "<br>the campaign hotkey needs to be at least 1 characters in length\n";
		}
	 else
		{
		echo "<br><B>CUSTOM CAMPAIGN HOTKEY DELETED: $campaign_id - $status - $hotkey</B>\n";

		$stmt="DELETE FROM vicidial_campaign_hotkeys where campaign_id='$campaign_id' and status='$status' and hotkey='$hotkey';";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|DELETE CAMPAIGN STATUS|$PHP_AUTH_USER|$ip|DELETE FROM vicidial_campaign_statuses where campaign_id='$campaign_id' and status='$status' and hotkey='$hotkey'|\n");
			fclose($fp);
			}
		}

$ADD=31;	# go to campaign modification form below
}

######################
# ADD=44 submit campaign modifications to the system - Basic View
######################

if ($ADD==44)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($campaign_name) < 6) or (strlen($active) < 1) )
		{
		 echo "<br>CAMPAIGN NOT MODIFIED - Please go back and look at the data you entered\n";
		 echo "<br>the campaign name needs to be at least 6 characters in length\n";
		}
	 else
		{
		echo "<br><B>CAMPAIGN MODIFIED: $campaign_id</B>\n";

		$stmt="UPDATE vicidial_campaigns set campaign_name='$campaign_name',active='$active',dial_status_a='$dial_status_a',dial_status_b='$dial_status_b',dial_status_c='$dial_status_c',dial_status_d='$dial_status_d',dial_status_e='$dial_status_e',lead_order='$lead_order',hopper_level='$hopper_level', auto_dial_level='$auto_dial_level',lead_filter_id='$lead_filter_id' where campaign_id='$campaign_id';";
		$rslt=mysql_query($stmt, $link);

		if ($reset_hopper == 'Y')
			{
			echo "<br>RESETTING CAMPAIGN LEAD HOPPER\n";
			echo "<br> - Wait 1 minute before dialing next number\n";
			$stmt="DELETE from vicidial_hopper where campaign_id='$campaign_id' and status='READY';";
			$rslt=mysql_query($stmt, $link);

			### LOG HOPPER RESET TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|CAMPAIGN HOPPERRESET|$PHP_AUTH_USER|$ip|campaign_name='$campaign_name'|\n");
				fclose($fp);
				}
			}

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|MODIFY CAMPAIGN INFO|$PHP_AUTH_USER|$ip|campaign_name='$campaign_name',active='$active',dial_status_a='$dial_status_a',dial_status_b='$dial_status_b',dial_status_c='$dial_status_c',dial_status_d='$dial_status_d',dial_status_e='$dial_status_e',lead_order='$lead_order',hopper_level='$hopper_level', auto_dial_level='$auto_dial_level',lead_filter_id='$lead_filter_id' where campaign_id='$campaign_id'|$reset_hopper|\n");
			fclose($fp);
			}
		}

$ADD=34;	# go to campaign modification form below
}

######################
# ADD=411 submit list modifications to the system
######################

if ($ADD==411)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($list_name) < 2) or (strlen($campaign_id) < 2) )
		{
		 echo "<br>LIST NOT MODIFIED - Please go back and look at the data you entered\n";
		 echo "<br>list name must be at least 2 characters in length\n";
		}
	 else
		{
		echo "<br><B>LIST MODIFIED: $list_id</B>\n";

		$stmt="UPDATE vicidial_lists set list_name='$list_name',campaign_id='$campaign_id',active='$active' where list_id='$list_id';";
		$rslt=mysql_query($stmt, $link);

		if ($reset_list == 'Y')
			{
			echo "<br>RESETTING LIST-CALLED-STATUS\n";
			$stmt="UPDATE vicidial_list set called_since_last_reset='N' where list_id='$list_id';";
			$rslt=mysql_query($stmt, $link);
			### LOG RESET TO LOG FILE ###
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./admin_changes_log.txt", "a");
				fwrite ($fp, "$date|RESET LIST CALLED   |$PHP_AUTH_USER|$ip|list_name='$list_name'|\n");
				fclose($fp);
				}
			}
		if ($campaign_id != "$old_campaign_id")
			{
			echo "<br>REMOVING LIST HOPPER LEADS FROM OLD CAMPAIGN HOPPER ($old_campaign_id)\n";
			$stmt="DELETE from vicidial_hopper where list_id='$list_id' and campaign_id='$old_campaign_id';";
			$rslt=mysql_query($stmt, $link);
			}

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|MODIFY LIST INFO    |$PHP_AUTH_USER|$ip|list_name='$list_name',campaign_id='$campaign_id',active='$active' where list_id='$list_id'|\n");
			fclose($fp);
			}
		}

$ADD=311;	# go to list modification form below
}


######################
# ADD=4111 modify in-group info in the system
######################

if ($ADD==4111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($group_name) < 2) or (strlen($group_color) < 2) )
		{
		 echo "<br>GROUP NOT MODIFIED - Please go back and look at the data you entered\n";
		 echo "<br>group name and group color must be at least 2 characters in length\n";
		}
	 else
		{
		echo "<br><B>GROUP MODIFIED: $group_id</B>\n";

		$stmt="UPDATE vicidial_inbound_groups set group_name='$group_name', group_color='$group_color', active='$active', web_form_address='$web_form_address', voicemail_ext='$voicemail_ext', next_agent_call='$next_agent_call', fronter_display='$fronter_display', ingroup_script='$script_id', get_call_launch='$get_call_launch', xferconf_a_dtmf='$xferconf_a_dtmf',xferconf_a_number='$xferconf_a_number', xferconf_b_dtmf='$xferconf_b_dtmf',xferconf_b_number='$xferconf_b_number' where group_id='$group_id';";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|MODIFY GROUP INFO   |$PHP_AUTH_USER|$ip|group_name='$group_name',group_color='$group_color',active='$active', web_form_address='$web_form_address', voicemail_ext='$voicemail_ext', next_agent_call='$next_agent_call', fronter_display='$fronter_display', ingroup_script='$script_id', get_call_launch='$get_call_launch', xferconf_a_dtmf='$xferconf_a_dtmf',xferconf_a_number='$xferconf_a_number', xferconf_b_dtmf='$xferconf_b_dtmf',xferconf_b_number='$xferconf_b_number'  where group_id='$group_id'|\n");
			fclose($fp);
			}
		}

$ADD=3111;	# go to in-group modification form below
}



######################
# ADD=41111 modify remote agents info in the system
######################

if ($ADD==41111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($server_ip) < 2) or (strlen($user_start) < 2)  or (strlen($campaign_id) < 2) or (strlen($conf_exten) < 2) )
		{
		 echo "<br>REMOTE AGENTS NOT MODIFIED - Please go back and look at the data you entered\n";
		 echo "<br>User ID Start and External Extension must be at least 2 characters in length\n";
		}
	 else
		{
		$stmt="UPDATE vicidial_remote_agents set user_start='$user_start', number_of_lines='$number_of_lines', server_ip='$server_ip', conf_exten='$conf_exten', status='$status', campaign_id='$campaign_id', closer_campaigns='$groups_value' where remote_agent_id='$remote_agent_id';";
		$rslt=mysql_query($stmt, $link);

		echo "<br><B>REMOTE AGENTS MODIFIED</B>\n";

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|MODIFY REMOTE AGENTS ENTRY     |$PHP_AUTH_USER|$ip|set user_start='$user_start', number_of_lines='$number_of_lines', server_ip='$server_ip', conf_exten='$conf_exten', status='$status', campaign_id='$campaign_id', closer_campaigns='$groups_value' where remote_agent_id='$remote_agent_id'|\n");
			fclose($fp);
			}
		}

$ADD=31111;	# go to remote agents modification form below
}



######################
# ADD=411111 modify user group info in the system
######################

if ($ADD==411111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($user_group) < 2) or (strlen($group_name) < 2) )
		{
		 echo "<br>USER GROUP NOT MODIFIED - Please go back and look at the data you entered\n";
		 echo "<br>Group name and description must be at least 2 characters in length\n";
		}
	 else
		{
		$stmt="UPDATE vicidial_user_groups set user_group='$user_group', group_name='$group_name' where user_group='$OLDuser_group';";
		$rslt=mysql_query($stmt, $link);

		echo "<br><B>USER GROUP MODIFIED</B>\n";

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|MODIFY USER GROUP ENTRY     |$PHP_AUTH_USER|$ip|UPDATE vicidial_user_groups set user_group='$user_group', group_name='$group_name' where user_group='$OLDuser_group'|\n");
			fclose($fp);
			}
		}

$ADD=311111;	# go to user group modification form below
}

######################
# ADD=4111111 modify script in the system
######################

if ($ADD==4111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($script_id) < 2) or (strlen($script_name) < 2) or (strlen($script_text) < 2) )
		{
		 echo "<br>SCRIPT NOT MODIFIED - Please go back and look at the data you entered\n";
		 echo "<br>Script name, description and text must be at least 2 characters in length\n";
		}
	 else
		{
		$stmt="UPDATE vicidial_scripts set script_name='$script_name', script_comments='$script_comments', script_text='$script_text', active='$active' where script_id='$script_id';";
		$rslt=mysql_query($stmt, $link);

		echo "<br><B>SCRIPT MODIFIED</B>\n";

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|MODIFY SCRIPT ENTRY         |$PHP_AUTH_USER|$ip|UPDATE vicidial_scripts set script_name='$script_name', script_comments='$script_comments', script_text='$script_text', active='$active' where script_id='$script_id'|\n");
			fclose($fp);
			}
		}

$ADD=3111111;	# go to script modification form below
}


######################
# ADD=41111111 modify filter in the system
######################

if ($ADD==41111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($lead_filter_id) < 2) or (strlen($lead_filter_name) < 2) or (strlen($lead_filter_sql) < 2) )
		{
		 echo "<br>FILTER NOT MODIFIED - Please go back and look at the data you entered\n";
		 echo "<br>Filter ID, name and SQL must be at least 2 characters in length\n";
		}
	 else
		{
		$stmt="UPDATE vicidial_lead_filters set lead_filter_name='$lead_filter_name', lead_filter_comments='$lead_filter_comments', lead_filter_sql='$lead_filter_sql' where lead_filter_id='$lead_filter_id';";
		$rslt=mysql_query($stmt, $link);

		echo "<br><B>FILTER MODIFIED</B>\n";

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|MODIFY FILTER ENTRY         |$PHP_AUTH_USER|$ip|lead_filter_name='$lead_filter_name', lead_filter_comments='$lead_filter_comments', lead_filter_sql='$lead_filter_sql' where lead_filter_id='$lead_filter_id'|\n");
			fclose($fp);
			}
		}

$ADD=31111111;	# go to filter modification form below
}




######################################################################################################
######################################################################################################
#######   5 series, delete records confirmation
######################################################################################################
######################################################################################################


######################
# ADD=5 confirmation before deletion of user
######################

if ($ADD==5)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($user) < 2) or ($LOGdelete_users < 1) )
		{
		 echo "<br>USER NOT DELETED - Please go back and look at the data you entered\n";
		 echo "<br>User be at least 2 characters in length\n";
		}
	 else
		{
		echo "<br><B>USER DELETION CONFIRMATION: $user</B>\n";
		echo "<br><br><a href=\"$PHP_SELF?ADD=6&user=$user&CoNfIrM=YES\">Click here to delete user $user</a><br><br><br>\n";
		}

$ADD='3';		# go to user modification below
}

######################
# ADD=51 confirmation before deletion of campaign
######################

if ($ADD==51)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($campaign_id) < 2) or ($LOGdelete_campaigns < 1) )
		{
		 echo "<br>CAMPAIGN NOT DELETED - Please go back and look at the data you entered\n";
		 echo "<br>Campaign_id be at least 2 characters in length\n";
		}
	 else
		{
		echo "<br><B>CAMPAIGN DELETION CONFIRMATION: $campaign_id</B>\n";
		echo "<br><br><a href=\"$PHP_SELF?ADD=61&campaign_id=$campaign_id&CoNfIrM=YES\">Click here to delete campaign $campaign_id</a><br><br><br>\n";
		}

$ADD='31';		# go to campaign modification below
}

######################
# ADD=52 confirmation before logging all agents out of campaign of campaign
######################

if ($ADD==52)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if (strlen($campaign_id) < 2)
		{
		 echo "<br>AGENTS NOT LOGGED OUT OF CAMPAIGN - Please go back and look at the data you entered\n";
		 echo "<br>Campaign_id be at least 2 characters in length\n";
		}
	 else
		{
		echo "<br><B>AGENT LOGOUT CONFIRMATION: $campaign_id</B>\n";
		echo "<br><br><a href=\"$PHP_SELF?ADD=62&campaign_id=$campaign_id&CoNfIrM=YES\">Click here to log all agents out of $campaign_id</a><br><br><br>\n";
		}

$ADD='31';		# go to campaign modification below
}

######################
# ADD=511 confirmation before deletion of list
######################

if ($ADD==511)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($list_id) < 2) or ($LOGdelete_lists < 1) )
		{
		 echo "<br>LIST NOT DELETED - Please go back and look at the data you entered\n";
		 echo "<br>List_id be at least 2 characters in length\n";
		}
	 else
		{
		echo "<br><B>LIST DELETION CONFIRMATION: $list_id</B>\n";
		echo "<br><br><a href=\"$PHP_SELF?ADD=611&list_id=$list_id&CoNfIrM=YES\">Click here to delete list and all of its leads $list_id</a><br><br><br>\n";
		}

$ADD='311';		# go to campaign modification below
}

######################
# ADD=5111 confirmation before deletion of in-group
######################

if ($ADD==5111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($group_id) < 2) or ($LOGdelete_ingroups < 1) )
		{
		 echo "<br>IN-GROUP NOT DELETED - Please go back and look at the data you entered\n";
		 echo "<br>Group_id be at least 2 characters in length\n";
		}
	 else
		{
		echo "<br><B>IN-GROUP DELETION CONFIRMATION: $group_id</B>\n";
		echo "<br><br><a href=\"$PHP_SELF?ADD=6111&group_id=$group_id&CoNfIrM=YES\">Click here to delete in-group $group_id</a><br><br><br>\n";
		}

$ADD='3111';		# go to in-group modification below
}

######################
# ADD=51111 confirmation before deletion of remote agent record
######################

if ($ADD==51111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($remote_agent_id) < 1) or ($LOGdelete_remote_agents < 1) )
		{
		 echo "<br>REMOTE AGENT NOT DELETED - Please go back and look at the data you entered\n";
		 echo "<br>Remote_agent_id be at least 2 characters in length\n";
		}
	 else
		{
		echo "<br><B>REMOTE AGENT DELETION CONFIRMATION: $remote_agent_id</B>\n";
		echo "<br><br><a href=\"$PHP_SELF?ADD=61111&remote_agent_id=$remote_agent_id&CoNfIrM=YES\">Click here to delete remote agent $remote_agent_id</a><br><br><br>\n";
		}

$ADD='31111';		# go to remote agent modification below
}

######################
# ADD=511111 confirmation before deletion of user group record
######################

if ($ADD==511111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($user_group) < 2) or ($LOGdelete_user_groups < 1) )
		{
		 echo "<br>USER GROUP NOT DELETED - Please go back and look at the data you entered\n";
		 echo "<br>User_group be at least 2 characters in length\n";
		}
	 else
		{
		echo "<br><B>USER GROUP DELETION CONFIRMATION: $user_group</B>\n";
		echo "<br><br><a href=\"$PHP_SELF?ADD=611111&user_group=$user_group&CoNfIrM=YES\">Click here to delete user group $user_group</a><br><br><br>\n";
		}

$ADD='311111';		# go to user group modification below
}

######################
# ADD=5111111 confirmation before deletion of script record
######################

if ($ADD==5111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($script_id) < 2) or ($LOGdelete_scripts < 1) )
		{
		 echo "<br>SCRIPT NOT DELETED - Please go back and look at the data you entered\n";
		 echo "<br>Script_id must be at least 2 characters in length\n";
		}
	 else
		{
		echo "<br><B>SCRIPT DELETION CONFIRMATION: $script_id</B>\n";
		echo "<br><br><a href=\"$PHP_SELF?ADD=6111111&script_id=$script_id&CoNfIrM=YES\">Click here to delete script $script_id</a><br><br><br>\n";
		}

$ADD='3111111';		# go to script modification below
}

######################
# ADD=51111111 confirmation before deletion of filter record
######################

if ($ADD==51111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($lead_filter_id) < 2) or ($LOGdelete_filters < 1) )
		{
		 echo "<br>FILTER NOT DELETED - Please go back and look at the data you entered\n";
		 echo "<br>Filter ID must be at least 2 characters in length\n";
		}
	 else
		{
		echo "<br><B>FILTER DELETION CONFIRMATION: $lead_filter_id</B>\n";
		echo "<br><br><a href=\"$PHP_SELF?ADD=61111111&lead_filter_id=$lead_filter_id&CoNfIrM=YES\">Click here to delete filter $lead_filter_id</a><br><br><br>\n";
		}

$ADD='31111111';		# go to filter modification below
}





######################################################################################################
######################################################################################################
#######   6 series, delete records
######################################################################################################
######################################################################################################


######################
# ADD=6 delete user record
######################

if ($ADD==6)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( ( strlen($user) < 2) or ($CoNfIrM != 'YES') or ($LOGdelete_users < 1) )
		{
		 echo "<br>USER NOT DELETED - Please go back and look at the data you entered\n";
		 echo "<br>User be at least 2 characters in length\n";
		}
	 else
		{
		$stmt="DELETE from vicidial_users where user='$user' limit 1;";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|!!!DELETING USER!!!!|$PHP_AUTH_USER|$ip|user='$user'|\n");
			fclose($fp);
			}
		echo "<br><B>USER DELETION COMPLETED: $user</B>\n";
		echo "<br><br>\n";
		}

$ADD='0';		# go to user list
}

######################
# ADD=61 delete campaign record
######################

if ($ADD==61)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( ( strlen($campaign_id) < 2) or ($CoNfIrM != 'YES') or ($LOGdelete_campaigns < 1) )
		{
		 echo "<br>CAMPAIGN NOT DELETED - Please go back and look at the data you entered\n";
		 echo "<br>Campaign_id be at least 2 characters in length\n";
		}
	 else
		{
		$stmt="DELETE from vicidial_campaigns where campaign_id='$campaign_id' limit 1;";
		$rslt=mysql_query($stmt, $link);

		echo "<br>REMOVING LIST HOPPER LEADS FROM OLD CAMPAIGN HOPPER ($campaign_id)\n";
		$stmt="DELETE from vicidial_hopper where campaign_id='$campaign_id';";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|!!DELETING CAMPAIGN!|$PHP_AUTH_USER|$ip|campaign_id='$campaign_id'|\n");
			fclose($fp);
			}
		echo "<br><B>CAMPAIGN DELETION COMPLETED: $campaign_id</B>\n";
		echo "<br><br>\n";
		}

$ADD='10';		# go to campaigns list
}

######################
# ADD=62 Logout all agents fro a campaign
######################

if ($ADD==62)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if (strlen($campaign_id) < 2)
		{
		 echo "<br>AGENTS NOT LOGGED OUT OF CAMPAIGN - Please go back and look at the data you entered\n";
		 echo "<br>Campaign_id be at least 2 characters in length\n";
		}
	 else
		{
		$stmt="DELETE from vicidial_live_agents where campaign_id='$campaign_id';";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|!!AGENT LOGOUT!!!!!!|$PHP_AUTH_USER|$ip|campaign_id='$campaign_id'|\n");
			fclose($fp);
			}
		echo "<br><B>AGENT LOGOUT COMPLETED: $campaign_id</B>\n";
		echo "<br><br>\n";
		}

$ADD='31';		# go to campaign modification below
}
######################
# ADD=611 delete list record and all leads within it
######################

if ($ADD==611)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( ( strlen($list_id) < 2) or ($CoNfIrM != 'YES') or ($LOGdelete_lists < 1) )
		{
		 echo "<br>LIST NOT DELETED - Please go back and look at the data you entered\n";
		 echo "<br>List_id be at least 2 characters in length\n";
		}
	 else
		{
		$stmt="DELETE from vicidial_lists where list_id='$list_id' limit 1;";
		$rslt=mysql_query($stmt, $link);

		echo "<br>REMOVING LIST HOPPER LEADS FROM OLD CAMPAIGN HOPPER ($list_id)\n";
		$stmt="DELETE from vicidial_hopper where list_id='$list_id';";
		$rslt=mysql_query($stmt, $link);

		echo "<br>REMOVING LIST LEADS FROM VICIDIAL_LIST TABLE\n";
		$stmt="DELETE from vicidial_list where list_id='$list_id';";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|!!!DELETING LIST!!!!|$PHP_AUTH_USER|$ip|list_id='$list_id'|\n");
			fclose($fp);
			}
		echo "<br><B>LIST DELETION COMPLETED: $list_id</B>\n";
		echo "<br><br>\n";
		}

$ADD='100';		# go to lists list
}

######################
# ADD=6111 delete in-group record
######################

if ($ADD==6111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($group_id) < 2) or ($CoNfIrM != 'YES') or ($LOGdelete_ingroups < 1) )
		{
		 echo "<br>IN-GROUP NOT DELETED - Please go back and look at the data you entered\n";
		 echo "<br>Group_id be at least 2 characters in length\n";
		}
	 else
		{
		$stmt="DELETE from vicidial_inbound_groups where group_id='$group_id' limit 1;";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|!DELETING IN-GROUP!!|$PHP_AUTH_USER|$ip|group_id='$group_id'|\n");
			fclose($fp);
			}
		echo "<br><B>IN-GROUP DELETION COMPLETED: $group_id</B>\n";
		echo "<br><br>\n";
		}

$ADD='1000';		# go to in-group list
}

######################
# ADD=61111 delete remote agent record
######################

if ($ADD==61111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($remote_agent_id) < 1) or ($CoNfIrM != 'YES') or ($LOGdelete_remote_agents < 1) )
		{
		 echo "<br>REMOTE AGENT NOT DELETED - Please go back and look at the data you entered\n";
		 echo "<br>Remote_agent_id be at least 2 characters in length\n";
		}
	 else
		{
		$stmt="DELETE from vicidial_remote_agents where remote_agent_id='$remote_agent_id' limit 1;";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|!DELETING RMTAGENT!!|$PHP_AUTH_USER|$ip|remote_agent_id='$remote_agent_id'|\n");
			fclose($fp);
			}
		echo "<br><B>REMOTE AGENT DELETION COMPLETED: $remote_agent_id</B>\n";
		echo "<br><br>\n";
		}

$ADD='10000';		# go to remote agents list
}

######################
# ADD=611111 delete user group record
######################

if ($ADD==611111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($user_group) < 2) or ($CoNfIrM != 'YES') or ($LOGdelete_user_groups < 1) )
		{
		 echo "<br>USER GROUP NOT DELETED - Please go back and look at the data you entered\n";
		 echo "<br>User_group be at least 2 characters in length\n";
		}
	 else
		{
		$stmt="DELETE from vicidial_user_groups where user_group='$user_group' limit 1;";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|!DELETING USRGROUP!!|$PHP_AUTH_USER|$ip|user_group='$user_group'|\n");
			fclose($fp);
			}
		echo "<br><B>USER GROUP DELETION COMPLETED: $user_group</B>\n";
		echo "<br><br>\n";
		}

$ADD='100000';		# go to user group list
}

######################
# ADD=6111111 delete script record
######################

if ($ADD==6111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($script_id) < 2) or ($CoNfIrM != 'YES') or ($LOGdelete_scripts < 1) )
		{
		 echo "<br>SCRIPT NOT DELETED - Please go back and look at the data you entered\n";
		 echo "<br>Script_id be at least 2 characters in length\n";
		}
	 else
		{
		$stmt="DELETE from vicidial_scripts where script_id='$script_id' limit 1;";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|!DELETING SCRIPT!!!!|$PHP_AUTH_USER|$ip|script_id='$script_id'|\n");
			fclose($fp);
			}
		echo "<br><B>SCRIPT DELETION COMPLETED: $script_id</B>\n";
		echo "<br><br>\n";
		}

$ADD='1000000';		# go to user group list
}


######################
# ADD=61111111 delete script record
######################

if ($ADD==61111111)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	 if ( (strlen($lead_filter_id) < 2) or ($CoNfIrM != 'YES') or ($LOGdelete_filters < 1) )
		{
		 echo "<br>FILTER NOT DELETED - Please go back and look at the data you entered\n";
		 echo "<br>Filter ID must be at least 2 characters in length\n";
		}
	 else
		{
		$stmt="DELETE from vicidial_lead_filters where lead_filter_id='$lead_filter_id' limit 1;";
		$rslt=mysql_query($stmt, $link);

		### LOG CHANGES TO LOG FILE ###
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./admin_changes_log.txt", "a");
			fwrite ($fp, "$date|!DELETING FILTER!!!!|$PHP_AUTH_USER|$ip|lead_filter_id='$lead_filter_id'|\n");
			fclose($fp);
			}
		echo "<br><B>FILTER DELETION COMPLETED: $lead_filter_id</B>\n";
		echo "<br><br>\n";
		}

$ADD='10000000';		# go to user group list
}




######################################################################################################
######################################################################################################
#######   3 series, record modification forms
######################################################################################################
######################################################################################################




######################
# ADD=3 modify user info in the system
######################

if ($ADD==3)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_users where user='$user';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$user_level =			$row[4];
	$user_group =			$row[5];
	$phone_login =			$row[6];
	$phone_pass =			$row[7];
	$delete_users =			$row[8];
	$delete_user_groups =	$row[9];
	$delete_lists =			$row[10];
	$delete_campaigns =		$row[11];
	$delete_ingroups =		$row[12];
	$delete_remote_agents =	$row[13];
	$load_leads =			$row[14];
	$campaign_detail =		$row[15];
	$ast_admin_access =		$row[16];
	$ast_delete_phones =	$row[17];
	$delete_scripts =		$row[18];
	$modify_leads =			$row[19];
	$hotkeys_active =		$row[20];
	$change_agent_campaign =$row[21];
	$agent_choose_ingroups =$row[22];
	$scheduled_callbacks =	$row[24];
	$agentonly_callbacks =	$row[25];
	$agentcall_manual =		$row[26];
	$vicidial_recording =	$row[27];
	$vicidial_transfers =	$row[28];
	$delete_filters =		$row[29];

if ( ($user_level >= $LOGuser_level) and ($LOGuser_level < 9) )
	{
	echo "<br>You do not have permissions to modify this user: $row[1]\n";
	}
else
	{
	echo "<br>MODIFY A USERS RECORD: $row[1]<form action=$PHP_SELF method=POST>\n";
	if ($LOGuser_level > 8)
		{echo "<input type=hidden name=ADD value=4A>\n";}
	else
		{echo "<input type=hidden name=ADD value=4>\n";}
	echo "<input type=hidden name=user value=\"$row[1]\">\n";
	echo "<center><TABLE width=600 cellspacing=3>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>User Number: </td><td align=left><b>$row[1]</b>$NWB#vicidial_users-user$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Password: </td><td align=left><input type=text name=pass size=20 maxlength=10 value=\"$row[2]\">$NWB#vicidial_users-pass$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Full Name: </td><td align=left><input type=text name=full_name size=30 maxlength=30 value=\"$row[3]\">$NWB#vicidial_users-full_name$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>User Level: </td><td align=left><select size=1 name=user_level>";
	$h=1;
	while ($h<=$LOGuser_level)
		{
		echo "<option>$h</option>";
		$h++;
		}
	echo "<option SELECTED>$row[4]</option></select>$NWB#vicidial_users-user_level$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>User Group: </td><td align=left><select size=1 name=user_group>\n";

		$stmt="SELECT user_group,group_name from vicidial_user_groups order by user_group";
		$rsltx=mysql_query($stmt, $link);
		$Ugroups_to_print = mysql_num_rows($rsltx);
		$Ugroups_list='';

		$o=0;
		while ($Ugroups_to_print > $o) {
			$rowx=mysql_fetch_row($rsltx);
			$Ugroups_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
			$o++;
		}
	echo "$Ugroups_list";
	echo "<option SELECTED>$user_group</option>\n";
	echo "</select>$NWB#vicidial_users-user_group$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Phone Login: </td><td align=left><input type=text name=phone_login size=20 maxlength=20 value=\"$phone_login\">$NWB#vicidial_users-phone_login$NWE</td></tr>\n";
	echo "<tr bgcolor=#B6D3FC><td align=right>Phone Pass: </td><td align=left><input type=text name=phone_pass size=20 maxlength=20 value=\"$phone_pass\">$NWB#vicidial_users-phone_pass$NWE</td></tr>\n";

	if ($LOGuser_level > 8)
		{
		echo "<tr bgcolor=#B6D3FC><td align=right>Agent Choose Ingroups: </td><td align=left><select size=1 name=agent_choose_ingroups><option>0</option><option>1</option><option SELECTED>$agent_choose_ingroups</option></select>$NWB#vicidial_users-agent_choose_ingroups$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>HotKeys Active: </td><td align=left><select size=1 name=hotkeys_active><option>0</option><option>1</option><option SELECTED>$hotkeys_active</option></select>$NWB#vicidial_users-hotkeys_active$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Delete Users: </td><td align=left><select size=1 name=delete_users><option>0</option><option>1</option><option SELECTED>$delete_users</option></select>$NWB#vicidial_users-delete_users$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Delete User Groups: </td><td align=left><select size=1 name=delete_user_groups><option>0</option><option>1</option><option SELECTED>$delete_user_groups</option></select>$NWB#vicidial_users-delete_user_groups$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Delete Lists: </td><td align=left><select size=1 name=delete_lists><option>0</option><option>1</option><option SELECTED>$delete_lists</option></select>$NWB#vicidial_users-delete_lists$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Delete Campaigns: </td><td align=left><select size=1 name=delete_campaigns><option>0</option><option>1</option><option SELECTED>$delete_campaigns</option></select>$NWB#vicidial_users-delete_campaigns$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Delete In-Groups: </td><td align=left><select size=1 name=delete_ingroups><option>0</option><option>1</option><option SELECTED>$delete_ingroups</option></select>$NWB#vicidial_users-delete_ingroups$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Delete Remote Agents: </td><td align=left><select size=1 name=delete_remote_agents><option>0</option><option>1</option><option SELECTED>$delete_remote_agents</option></select>$NWB#vicidial_users-delete_remote_agents$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Delete Scripts: </td><td align=left><select size=1 name=delete_scripts><option>0</option><option>1</option><option SELECTED>$delete_scripts</option></select>$NWB#vicidial_users-delete_scripts$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Load Leads: </td><td align=left><select size=1 name=load_leads><option>0</option><option>1</option><option SELECTED>$load_leads</option></select>$NWB#vicidial_users-load_leads$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Campaign Detail: </td><td align=left><select size=1 name=campaign_detail><option>0</option><option>1</option><option SELECTED>$campaign_detail</option></select>$NWB#vicidial_users-campaign_detail$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>AGC Admin Access: </td><td align=left><select size=1 name=ast_admin_access><option>0</option><option>1</option><option SELECTED>$ast_admin_access</option></select>$NWB#vicidial_users-ast_admin_access$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>AGC Delete Phones: </td><td align=left><select size=1 name=ast_delete_phones><option>0</option><option>1</option><option SELECTED>$ast_delete_phones</option></select>$NWB#vicidial_users-ast_delete_phones$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Modify Leads: </td><td align=left><select size=1 name=modify_leads><option>0</option><option>1</option><option SELECTED>$modify_leads</option></select>$NWB#vicidial_users-modify_leads$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Change Agent Campaign: </td><td align=left><select size=1 name=change_agent_campaign><option>0</option><option>1</option><option SELECTED>$change_agent_campaign</option></select>$NWB#vicidial_users-change_agent_campaign$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Scheduled Callbacks: </td><td align=left><select size=1 name=scheduled_callbacks><option>0</option><option>1</option><option SELECTED>$scheduled_callbacks</option></select>$NWB#vicidial_users-scheduled_callbacks$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Agent-Only Callbacks: </td><td align=left><select size=1 name=agentonly_callbacks><option>0</option><option>1</option><option SELECTED>$agentonly_callbacks</option></select>$NWB#vicidial_users-agentonly_callbacks$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Agent Call Manual: </td><td align=left><select size=1 name=agentcall_manual><option>0</option><option>1</option><option SELECTED>$agentcall_manual</option></select>$NWB#vicidial_users-agentcall_manual$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Vicidial Recording: </td><td align=left><select size=1 name=vicidial_recording><option>0</option><option>1</option><option SELECTED>$vicidial_recording</option></select>$NWB#vicidial_users-vicidial_recording$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Vicidial Transfers: </td><td align=left><select size=1 name=vicidial_transfers><option>0</option><option>1</option><option SELECTED>$vicidial_transfers</option></select>$NWB#vicidial_users-vicidial_transfers$NWE</td></tr>\n";
		echo "<tr bgcolor=#B6D3FC><td align=right>Delete Filters: </td><td align=left><select size=1 name=delete_filters><option>0</option><option>1</option><option SELECTED>$delete_filters</option></select>$NWB#vicidial_users-delete_filters$NWE</td></tr>\n";

		echo "<tr bgcolor=#B6D3FC><td align=right>Inbound Groups: </td><td align=left>\n";
		echo "$groups_list";
		echo "$NWB#vicidial_users-closer_campaigns$NWE</td></tr>\n";
		}
	echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=SUBMIT value=SUBMIT></td></tr>\n";
	echo "</TABLE></center>\n";

	if ($LOGdelete_users > 0)
		{
		echo "<br><br><a href=\"$PHP_SELF?ADD=5&user=$row[1]\">DELETE THIS USER</a>\n";
		}
	echo "<br><br><a href=\"./AST_agent_time_sheet.php?agent=$row[1]\">Click here for user time sheet</a>\n";
	echo "<br><br><a href=\"./user_status.php?user=$row[1]\">Click here for user status</a>\n";
	echo "<br><br><a href=\"./user_stats.php?user=$row[1]\">Click here for user stats</a>\n";
	echo "<br><br><a href=\"$PHP_SELF?ADD=8&user=$row[1]\">Click here for user CallBack Holds</a>\n";
	}
}


######################
# ADD=31 modify campaign info in the system - Detail view
######################

if ( ($LOGcampaign_detail < 1) and ($ADD==31) ) {$ADD=34;}	# send to Basic if not allowed

if ($ADD==31)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_campaigns where campaign_id='$campaign_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$dial_status_a = $row[3];
	$dial_status_b = $row[4];
	$dial_status_c = $row[5];
	$dial_status_d = $row[6];
	$dial_status_e = $row[7];
	$lead_order = $row[8];
	$hopper_level = $row[13];
	$auto_dial_level = $row[14];
	$next_agent_call = $row[15];
	$local_call_time = $row[16];
	$voicemail_ext = $row[17];
	$dial_timeout = $row[18];
	$dial_prefix = $row[19];
	$campaign_cid = $row[20];
	$campaign_vdad_exten = $row[21];
	$campaign_rec_exten = $row[22];
	$campaign_recording = $row[23];
	$campaign_rec_filename = $row[24];
	$script_id = $row[25];
	$get_call_launch = $row[26];
	$am_message_exten = $row[27];
	$amd_send_to_vmx = $row[28];
	$xferconf_a_dtmf = $row[29];
	$xferconf_a_number = $row[30];
	$xferconf_b_dtmf = $row[31];
	$xferconf_b_number = $row[32];
	$alt_number_dialing = $row[33];
	$scheduled_callbacks = $row[34];
	$lead_filter_id = $row[35];
		if ($lead_filter_id=='') {$lead_filter_id='NONE';}

echo "<br>MODIFY A CAMPAIGNS RECORD: $row[0] - <a href=\"$PHP_SELF?ADD=34&campaign_id=$campaign_id\">Basic View</a> | Detail View<form action=$PHP_SELF method=POST>\n";
echo "<input type=hidden name=ADD value=41>\n";
echo "<input type=hidden name=campaign_id value=\"$campaign_id\">\n";
echo "<center><TABLE width=600 cellspacing=3>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Campaign ID: </td><td align=left><b>$row[0]</b>$NWB#vicidial_campaigns-campaign_id$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Campaign Name: </td><td align=left><input type=text name=campaign_name size=40 maxlength=40 value=\"$row[1]\">$NWB#vicidial_campaigns-campaign_name$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Active: </td><td align=left><select size=1 name=active><option>Y</option><option>N</option><option SELECTED>$row[2]</option></select>$NWB#vicidial_campaigns-active$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Park Extension: </td><td align=left><input type=text name=park_ext size=10 maxlength=10 value=\"$row[9]\"> - Filename: <input type=text name=park_file_name size=10 maxlength=10 value=\"$row[10]\">$NWB#vicidial_campaigns-park_ext$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Web Form: </td><td align=left><input type=text name=web_form_address size=50 maxlength=255 value=\"$row[11]\">$NWB#vicidial_campaigns-web_form_address$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Allow Closers: </td><td align=left><select size=1 name=allow_closers><option>Y</option><option>N</option><option SELECTED>$row[12]</option></select>$NWB#vicidial_campaigns-allow_closers$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Dial status 1: </td><td align=left><select size=1 name=dial_status_a>\n";

	$stmt="SELECT * from vicidial_statuses order by status";
	$rsltx=mysql_query($stmt, $link);
	$statuses_to_print = mysql_num_rows($rsltx);
	$statuses_list='';

	$o=0;
	while ($statuses_to_print > $o) {
		$rowx=mysql_fetch_row($rsltx);
		$statuses_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
		$statname_list["$rowx[0]"] = "$rowx[1]";
		if (eregi("Y",$rowx[2]))
			{$HKstatuses_list .= "<option value=\"$rowx[0]-----$rowx[1]\">$rowx[0] - $rowx[1]</option>\n";}
		$o++;
	}

	$stmt="SELECT * from vicidial_campaign_statuses where campaign_id='$campaign_id' and selectable='Y' order by status";
	$rsltx=mysql_query($stmt, $link);
	$Cstatuses_to_print = mysql_num_rows($rsltx);

	$o=0;
	while ($Cstatuses_to_print > $o) {
		$rowx=mysql_fetch_row($rsltx);
		$statuses_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
		$statname_list["$rowx[0]"] = "$rowx[1]";
		if (eregi("Y",$rowx[2]))
			{$HKstatuses_list .= "<option value=\"$rowx[0]-----$rowx[1]\">$rowx[0] - $rowx[1]</option>\n";}
		$o++;
	}
echo "$statuses_list";
echo "<option value=\"$dial_status_a\" SELECTED>$dial_status_a - $statname_list[$dial_status_a]</option>\n";
echo "</select>$NWB#vicidial_campaigns-dial_status$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Dial status 2: </td><td align=left><select size=1 name=dial_status_b>\n";
echo "$statuses_list";
echo "<option value=\"$dial_status_b\" SELECTED>$dial_status_b - $statname_list[$dial_status_b]</option>\n";
echo "</select>$NWB#vicidial_campaigns-dial_status$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Dial status 3: </td><td align=left><select size=1 name=dial_status_c>\n";
echo "$statuses_list";
echo "<option value=\"$dial_status_c\" SELECTED>$dial_status_c - $statname_list[$dial_status_c]</option>\n";
echo "</select>$NWB#vicidial_campaigns-dial_status$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Dial status 4: </td><td align=left><select size=1 name=dial_status_d>\n";
echo "$statuses_list";
echo "<option value=\"$dial_status_d\" SELECTED>$dial_status_d - $statname_list[$dial_status_d]</option>\n";
echo "</select>$NWB#vicidial_campaigns-dial_status$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Dial status 5: </td><td align=left><select size=1 name=dial_status_e>\n";
echo "$statuses_list";
echo "<option value=\"$dial_status_e\" SELECTED>$dial_status_e - $statname_list[$dial_status_e]</option>\n";
echo "</select>$NWB#vicidial_campaigns-dial_status$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right>List Order: </td><td align=left><select size=1 name=lead_order><option>DOWN</option><option>UP</option><option>UP PHONE</option><option>DOWN PHONE</option><option>UP LAST NAME</option><option>DOWN LAST NAME</option><option>UP COUNT</option><option>DOWN COUNT</option><option>DOWN COUNT 2nd NEW</option><option>DOWN COUNT 3rd NEW</option><option>DOWN COUNT 4th NEW</option><option SELECTED>$lead_order</option></select>$NWB#vicidial_campaigns-lead_order$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right><a href=\"$PHP_SELF?ADD=31111111&lead_filter_id=$lead_filter_id\">Lead Filter</a>: </td><td align=left><select size=1 name=lead_filter_id>\n";
echo "$filters_list";
echo "<option selected value=\"$lead_filter_id\">$lead_filter_id - $filtername_list[$lead_filter_id]</option>\n";
echo "</select>$NWB#vicidial_campaigns-lead_filter_id$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right>Hopper Level: </td><td align=left><select size=1 name=hopper_level><option>1</option><option>5</option><option>10</option><option>50</option><option>100</option><option>200</option><option>500</option><option>1000</option><option SELECTED>$hopper_level</option></select>$NWB#vicidial_campaigns-hopper_level$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right>Force Reset of Hopper: </td><td align=left><select size=1 name=reset_hopper><option>Y</option><option SELECTED>N</option></select>$NWB#vicidial_campaigns-force_reset_hopper$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right>Auto Dial Level: </td><td align=left><select size=1 name=auto_dial_level><option >0</option><option>1</option><option>1.1</option><option>1.2</option><option>1.3</option><option>1.4</option><option>1.5</option><option>1.6</option><option>1.7</option><option>1.8</option><option>1.9</option><option>2.0</option><option>2.2</option><option>2.5</option><option>2.7</option><option>3.0</option><option>3.5</option><option>4.0</option><option SELECTED>$auto_dial_level</option></select>(0 = off)$NWB#vicidial_campaigns-auto_dial_level$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right>Next Agent Call: </td><td align=left><select size=1 name=next_agent_call><option >random</option><option>oldest_call_start</option><option>oldest_call_finish</option><option>overall_user_level</option><option SELECTED>$next_agent_call</option></select>$NWB#vicidial_campaigns-next_agent_call$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right>Local Call Time: </td><td align=left><select size=1 name=local_call_time><option >24hours</option><option >9am-9pm</option><option>9am-5pm</option><option>12pm-5pm</option><option>12pm-9pm</option><option>5pm-9pm</option><option SELECTED>$local_call_time</option></select>$NWB#vicidial_campaigns-local_call_time$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right>Voicemail: </td><td align=left><input type=text name=voicemail_ext size=10 maxlength=10 value=\"$voicemail_ext\">$NWB#vicidial_campaigns-voicemail_ext$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right>Dial Timeout: </td><td align=left><input type=text name=dial_timeout size=3 maxlength=3 value=\"$dial_timeout\"> <i>in seconds</i>$NWB#vicidial_campaigns-dial_timeout$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right>Dial Prefix: </td><td align=left><input type=text name=dial_prefix size=20 maxlength=20 value=\"$dial_prefix\"> <font size=1>for 91NXXNXXXXXX value would be 9, for no dial prefix use X</font>$NWB#vicidial_campaigns-dial_prefix$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right>Campaign CallerID: </td><td align=left><input type=text name=campaign_cid size=20 maxlength=20 value=\"$campaign_cid\">$NWB#vicidial_campaigns-campaign_cid$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right>Campaign VDAD exten: </td><td align=left><input type=text name=campaign_vdad_exten size=10 maxlength=20 value=\"$campaign_vdad_exten\">$NWB#vicidial_campaigns-campaign_vdad_exten$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right>Campaign Rec exten: </td><td align=left><input type=text name=campaign_rec_exten size=10 maxlength=10 value=\"$campaign_rec_exten\">$NWB#vicidial_campaigns-campaign_rec_exten$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right>Campaign Recording: </td><td align=left><select size=1 name=campaign_recording><option>NEVER</option><option>ONDEMAND</option><option>ALLCALLS</option><option SELECTED>$campaign_recording</option></select>$NWB#vicidial_campaigns-campaign_recording$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right>Campaign Rec Filename: </td><td align=left><input type=text name=campaign_rec_filename size=50 maxlength=50 value=\"$campaign_rec_filename\">$NWB#vicidial_campaigns-campaign_rec_filename$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right><a href=\"$PHP_SELF?ADD=3111111&script_id=$script_id\">Script</a>: </td><td align=left><select size=1 name=script_id>\n";
echo "$scripts_list";
echo "<option selected value=\"$script_id\">$script_id - $scriptname_list[$script_id]</option>\n";
echo "</select>$NWB#vicidial_campaigns-campaign_script$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right>Get Call Launch: </td><td align=left><select size=1 name=get_call_launch><option selected>NONE</option><option>SCRIPT</option><option>WEBFORM</option><option selected>$get_call_launch</option></select>$NWB#vicidial_campaigns-get_call_launch$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right>Answering Machine Message: </td><td align=left><input type=text name=am_message_exten size=10 maxlength=20 value=\"$am_message_exten\">$NWB#vicidial_campaigns-am_message_exten$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right>AMD Send to VM exten: </td><td align=left><select size=1 name=amd_send_to_vmx><option>Y</option><option>N</option><option SELECTED>$amd_send_to_vmx</option></select>$NWB#vicidial_campaigns-amd_send_to_vmx$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right>Transfer-Conf DTMF 1: </td><td align=left><input type=text name=xferconf_a_dtmf size=20 maxlength=50 value=\"$xferconf_a_dtmf\">$NWB#vicidial_campaigns-xferconf_a_dtmf$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right>Transfer-Conf Number 1: </td><td align=left><input type=text name=xferconf_a_number size=20 maxlength=50 value=\"$xferconf_a_number\">$NWB#vicidial_campaigns-xferconf_a_dtmf$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right>Transfer-Conf DTMF 2: </td><td align=left><input type=text name=xferconf_b_dtmf size=20 maxlength=50 value=\"$xferconf_b_dtmf\">$NWB#vicidial_campaigns-xferconf_a_dtmf$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right>Transfer-Conf Number 2: </td><td align=left><input type=text name=xferconf_b_number size=20 maxlength=50 value=\"$xferconf_b_number\">$NWB#vicidial_campaigns-xferconf_a_dtmf$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right>Scheduled Callbacks: </td><td align=left><select size=1 name=scheduled_callbacks><option>Y</option><option>N</option><option SELECTED>$scheduled_callbacks</option></select>$NWB#vicidial_campaigns-scheduled_callbacks$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right>Agent Alt Num Dialing: </td><td align=left><select size=1 name=alt_number_dialing><option>Y</option><option>N</option><option SELECTED>$alt_number_dialing</option></select>$NWB#vicidial_campaigns-alt_number_dialing$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=SUBMIT value=SUBMIT></td></tr>\n";
echo "</TABLE></center></FORM>\n";

	##### calculate what gmt_offset_now values are within the allowed local_call_time setting
	if ($local_call_time == '24hours')
		{
		$p='13';
		$GMT_allowed = '';
		while ($p > -13)
			{
			$tz = sprintf("%.2f", $p);	$GMT_allowed = "$GMT_allowed'$tz',";
			$p = ($p - 0.25);
			}
		}
	if ($local_call_time == '9am-9pm')
		{
		$p='13';
		$GMT_allowed = '';
		while ($p > -13)
			{
			$pzone=3600 * $p;
			$phour=gmdate("G", time() + $pzone);
			if ( ($phour >= 9) && ($phour <= 20) ){$tz = sprintf("%.2f", $p);	$GMT_allowed = "$GMT_allowed'$tz',";}
			$p = ($p - 0.25);
			}
		}
	if ($local_call_time == '9am-5pm')
		{
		$p='13';
		$GMT_allowed = '';
		while ($p > -13)
			{
			$pzone=3600 * $p;
			$phour=gmdate("G", time() + $pzone);
			if ( ($phour >= 9) && ($phour <= 16) ){$tz = sprintf("%.2f", $p);	$GMT_allowed = "$GMT_allowed'$tz',";}
			$p = ($p - 0.25);
			}
		}
	if ($local_call_time == '12pm-5pm')
		{
		$p='13';
		$GMT_allowed = '';
		while ($p > -13)
			{
			$pzone=3600 * $p;
			$phour=gmdate("G", time() + $pzone);
			if ( ($phour >= 12) && ($phour <= 16) ){$tz = sprintf("%.2f", $p);	$GMT_allowed = "$GMT_allowed'$tz',";}
			$p = ($p - 0.25);
			}
		}
	if ($local_call_time == '12pm-9pm')
		{
		$p='13';
		$GMT_allowed = '';
		while ($p > -13)
			{
			$pzone=3600 * $p;
			$phour=gmdate("G", time() + $pzone);
			if ( ($phour >= 12) && ($phour <= 20) ){$tz = sprintf("%.2f", $p);	$GMT_allowed = "$GMT_allowed'$tz',";}
			$p = ($p - 0.25);
			}
		}
	if ($local_call_time == '5pm-9pm')
		{
		$p='13';
		$GMT_allowed = '';
		while ($p > -13)
			{
			$pzone=3600 * $p;
			$phour=gmdate("G", time() + $pzone);
			if ( ($phour >= 17) && ($phour <= 20) ){$tz = sprintf("%.2f", $p);	$GMT_allowed = "$GMT_allowed'$tz',";}
			$p = ($p - 0.25);
			}
		}

	$GMT_allowed = "$GMT_allowed'99'";


echo "<center>\n";
echo "<br><b>LISTS WITHIN THIS CAMPAIGN: &nbsp; $NWB#vicidial_campaign_lists$NWE</b><br>\n";
echo "<TABLE width=400 cellspacing=3>\n";
echo "<tr><td>LIST ID</td><td>LIST NAME</td><td>ACTIVE</td></tr>\n";

	$active_lists = 0;
	$inactive_lists = 0;
	$stmt="SELECT list_id,active,list_name from vicidial_lists where campaign_id='$campaign_id'";
	$rsltx=mysql_query($stmt, $link);
	$lists_to_print = mysql_num_rows($rsltx);
	$camp_lists='';

	$o=0;
	while ($lists_to_print > $o) {
		$rowx=mysql_fetch_row($rsltx);
		$o++;
	if (ereg("Y", $rowx[1])) {$active_lists++;   $camp_lists .= "'$rowx[0]',";}
	if (ereg("N", $rowx[1])) {$inactive_lists++;}

	if (eregi("1$|3$|5$|7$|9$", $o))
		{$bgcolor='bgcolor="#B9CBFD"';} 
	else
		{$bgcolor='bgcolor="#9BB9FB"';}

	echo "<tr $bgcolor><td><font size=1><a href=\"$PHP_SELF?ADD=311&list_id=$rowx[0]\">$rowx[0]</a></td><td><font size=1>$rowx[2]</td><td><font size=1>$rowx[1]</td></tr>\n";

	}

echo "</table></center><br>\n";
echo "<center><b>\n";

$filterSQL = $filtersql_list[$lead_filter_id];
$filterSQL = eregi_replace("^and|and$|^or|or$","",$filterSQL);
if (strlen($filterSQL)>4)
	{$fSQL = "and $filterSQL";}
else
	{$fSQL = '';}

	$camp_lists = eregi_replace(".$","",$camp_lists);
echo "This campaign has $active_lists active lists and $inactive_lists inactive lists<br><br>\n";
	$stmt="SELECT count(*) FROM vicidial_list where called_since_last_reset='N' and status IN('$dial_status_a','$dial_status_b','$dial_status_c','$dial_status_d','$dial_status_e') and list_id IN($camp_lists) and gmt_offset_now IN($GMT_allowed) $fSQL";
	if ($DB) {echo "$stmt\n";}
	$rsltx=mysql_query($stmt, $link);
	$rsltx_rows = mysql_num_rows($rsltx);
	if ($rsltx_rows)
		{
		$rowx=mysql_fetch_row($rsltx);
		$active_leads = "$rowx[0]";
		}
	else {$active_leads = '0';}

echo "This campaign has $active_leads leads to be dialed in those lists<br><br>\n";
	$stmt="SELECT count(*) FROM vicidial_hopper where campaign_id='$campaign_id' and status IN('READY')";
	if ($DB) {echo "$stmt\n";}
	$rsltx=mysql_query($stmt, $link);
	$rowx=mysql_fetch_row($rsltx);
	$hopper_leads = "$rowx[0]";

echo "This campaign has $hopper_leads leads in the dial hopper<br><br>\n";
echo "<a href=\"./AST_VICIDIAL_hopperlist.php?group=$campaign_id\">Click here to see what leads are in the hopper right now</a><br><br>\n";
echo "<a href=\"$PHP_SELF?ADD=81&campaign_id=$campaign_id\">Click here to see all CallBack Holds in this campaign</a><BR><BR>\n";
echo "</b></center>\n";




echo "<center>\n";
echo "<br><b>CUSTOM STATUSES WITHIN THIS CAMPAIGN: &nbsp; $NWB#vicidial_campaign_statuses$NWE</b><br>\n";
echo "<TABLE width=400 cellspacing=3>\n";
echo "<tr><td>STATUS</td><td>DESCRIPTION</td><td>SELECTABLE</td><td>DELETE</td></tr>\n";

	$stmt="SELECT * from vicidial_campaign_statuses where campaign_id='$campaign_id'";
	$rsltx=mysql_query($stmt, $link);
	$statuses_to_print = mysql_num_rows($rsltx);
	$o=0;
	while ($statuses_to_print > $o) {
		$rowx=mysql_fetch_row($rsltx);
		$o++;

	if (eregi("1$|3$|5$|7$|9$", $o))
		{$bgcolor='bgcolor="#B9CBFD"';} 
	else
		{$bgcolor='bgcolor="#9BB9FB"';}

	echo "<tr $bgcolor><td><font size=1>$rowx[0]</td><td><font size=1>$rowx[1]</td><td><font size=1>$rowx[2]</td><td><font size=1><a href=\"$PHP_SELF?ADD=42&campaign_id=$campaign_id&status=$rowx[0]&action=DELETE\">DELETE</a></td></tr>\n";

	}

echo "</table>\n";

echo "<br>ADD NEW CUSTOM CAMPAIGN STATUS<BR><form action=$PHP_SELF method=POST>\n";
echo "<input type=hidden name=ADD value=22>\n";
echo "<input type=hidden name=campaign_id value=\"$campaign_id\">\n";
echo "Status: <input type=text name=status size=10 maxlength=8> &nbsp; \n";
echo "Description: <input type=text name=status_name size=20 maxlength=30> &nbsp; \n";
echo "Selectable: <select size=1 name=selectable><option>Y</option><option>N</option></select> &nbsp; \n";
echo "<input type=submit name=submit value=ADD><BR>\n";

echo "</FORM><br>\n";



echo "<br><b>CUSTOM HOTKEYS WITHIN THIS CAMPAIGN: &nbsp; $NWB#vicidial_campaign_hotkeys$NWE</b><br>\n";
echo "<TABLE width=400 cellspacing=3>\n";
echo "<tr><td>HOTKEY</td><td>STATUS</td><td>DESCRIPTION</td><td>DELETE</td></tr>\n";

	$stmt="SELECT * from vicidial_campaign_hotkeys where campaign_id='$campaign_id' order by hotkey";
	$rsltx=mysql_query($stmt, $link);
	$statuses_to_print = mysql_num_rows($rsltx);
	$o=0;
	while ($statuses_to_print > $o) {
		$rowx=mysql_fetch_row($rsltx);
		$o++;

	if (eregi("1$|3$|5$|7$|9$", $o))
		{$bgcolor='bgcolor="#B9CBFD"';} 
	else
		{$bgcolor='bgcolor="#9BB9FB"';}

	echo "<tr $bgcolor><td><font size=1>$rowx[1]</td><td><font size=1>$rowx[0]</td><td><font size=1>$rowx[2]</td><td><font size=1><a href=\"$PHP_SELF?ADD=43&campaign_id=$campaign_id&status=$rowx[0]&hotkey=$rowx[1]&action=DELETE\">DELETE</a></td></tr>\n";

	}

echo "</table>\n";

echo "<br>ADD NEW CUSTOM CAMPAIGN HOTKEY<BR><form action=$PHP_SELF method=POST>\n";
echo "<input type=hidden name=ADD value=23>\n";
echo "<input type=hidden name=selectable value=Y>\n";
echo "<input type=hidden name=campaign_id value=\"$campaign_id\">\n";
echo "Hotkey: <select size=1 name=hotkey>\n";
echo "<option>1</option>\n";
echo "<option>2</option>\n";
echo "<option>3</option>\n";
echo "<option>4</option>\n";
echo "<option>5</option>\n";
echo "<option>6</option>\n";
echo "<option>7</option>\n";
echo "<option>8</option>\n";
echo "<option>9</option>\n";
echo "</select> &nbsp; \n";
echo "Status: <select size=1 name=HKstatus>\n";
echo "$HKstatuses_list\n";
echo "</select> &nbsp; \n";
echo "<input type=submit name=submit value=ADD><BR>\n";

echo "</center></FORM><br>\n";

echo "<a href=\"$PHP_SELF?ADD=52&campaign_id=$campaign_id\">LOG ALL AGENTS OUT OF THIS CAMPAIGN</a><BR><BR>\n";

if ($LOGdelete_campaigns > 0)
	{
	echo "<br><br><a href=\"$PHP_SELF?ADD=51&campaign_id=$campaign_id\">DELETE THIS CAMPAIGN</a>\n";
	}

}


######################
# ADD=34 modify campaign info in the system - Basic View
######################

if ($ADD==34)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_campaigns where campaign_id='$campaign_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$dial_status_a = $row[3];
	$dial_status_b = $row[4];
	$dial_status_c = $row[5];
	$dial_status_d = $row[6];
	$dial_status_e = $row[7];
	$lead_order = $row[8];
	$hopper_level = $row[13];
	$auto_dial_level = $row[14];
	$next_agent_call = $row[15];
	$local_call_time = $row[16];
	$voicemail_ext = $row[17];
	$dial_timeout = $row[18];
	$dial_prefix = $row[19];
	$campaign_cid = $row[20];
	$campaign_vdad_exten = $row[21];
	$script_id = $row[25];
	$get_call_launch = $row[26];
	$lead_filter_id = $row[35];
		if ($lead_filter_id=='') {$lead_filter_id='NONE';}

echo "<br>MODIFY A CAMPAIGN'S RECORD: $row[0] - Basic View | <a href=\"$PHP_SELF?ADD=31&campaign_id=$campaign_id\">Detail View</a><form action=$PHP_SELF method=POST>\n";
echo "<input type=hidden name=ADD value=44>\n";
echo "<input type=hidden name=campaign_id value=\"$campaign_id\">\n";
echo "<center><TABLE width=600 cellspacing=3>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Campaign ID: </td><td align=left><b>$row[0]</b>$NWB#vicidial_campaigns-campaign_id$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Campaign Name: </td><td align=left><input type=text name=campaign_name size=40 maxlength=40 value=\"$row[1]\">$NWB#vicidial_campaigns-campaign_name$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Active: </td><td align=left><select size=1 name=active><option>Y</option><option>N</option><option SELECTED>$row[2]</option></select>$NWB#vicidial_campaigns-active$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Park Extension: </td><td align=left>$row[9] - $row[10]$NWB#vicidial_campaigns-park_ext$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Web Form: </td><td align=left>$row[11]$NWB#vicidial_campaigns-web_form_address$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Allow Closers: </td><td align=left>$row[12] $NWB#vicidial_campaigns-allow_closers$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Dial status 1: </td><td align=left><select size=1 name=dial_status_a>\n";

	$stmt="SELECT * from vicidial_statuses order by status";
	$rsltx=mysql_query($stmt, $link);
	$statuses_to_print = mysql_num_rows($rsltx);
	$statuses_list='';

	$o=0;
	while ($statuses_to_print > $o) {
		$rowx=mysql_fetch_row($rsltx);
		$statuses_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
		$statname_list["$rowx[0]"] = "$rowx[1]";
		$o++;
	}

	$stmt="SELECT * from vicidial_campaign_statuses where campaign_id='$campaign_id' order by status";
	$rsltx=mysql_query($stmt, $link);
	$Cstatuses_to_print = mysql_num_rows($rsltx);

	$o=0;
	while ($Cstatuses_to_print > $o) {
		$rowx=mysql_fetch_row($rsltx);
		$statuses_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
		$statname_list["$rowx[0]"] = "$rowx[1]";
		$o++;
	}
echo "$statuses_list";
echo "<option value=\"$dial_status_a\" SELECTED>$dial_status_a - $statname_list[$dial_status_a]</option>\n";
echo "</select>$NWB#vicidial_campaigns-dial_status$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Dial status 2: </td><td align=left><select size=1 name=dial_status_b>\n";
echo "$statuses_list";
echo "<option value=\"$dial_status_b\" SELECTED>$dial_status_b - $statname_list[$dial_status_b]</option>\n";
echo "</select>$NWB#vicidial_campaigns-dial_status$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Dial status 3: </td><td align=left><select size=1 name=dial_status_c>\n";
echo "$statuses_list";
echo "<option value=\"$dial_status_c\" SELECTED>$dial_status_c - $statname_list[$dial_status_c]</option>\n";
echo "</select>$NWB#vicidial_campaigns-dial_status$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Dial status 4: </td><td align=left><select size=1 name=dial_status_d>\n";
echo "$statuses_list";
echo "<option value=\"$dial_status_d\" SELECTED>$dial_status_d - $statname_list[$dial_status_d]</option>\n";
echo "</select>$NWB#vicidial_campaigns-dial_status$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Dial status 5: </td><td align=left><select size=1 name=dial_status_e>\n";
echo "$statuses_list";
echo "<option value=\"$dial_status_e\" SELECTED>$dial_status_e - $statname_list[$dial_status_e]</option>\n";
echo "</select>$NWB#vicidial_campaigns-dial_status$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right>List Order: </td><td align=left><select size=1 name=lead_order><option>DOWN</option><option>UP</option><option>UP PHONE</option><option>DOWN PHONE</option><option>UP LAST NAME</option><option>DOWN LAST NAME</option><option>UP COUNT</option><option>DOWN COUNT</option><option>DOWN COUNT 2nd NEW</option><option>DOWN COUNT 3rd NEW</option><option>DOWN COUNT 4th NEW</option><option SELECTED>$lead_order</option></select>$NWB#vicidial_campaigns-lead_order$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right><a href=\"$PHP_SELF?ADD=31111111&lead_filter_id=$lead_filter_id\">Lead Filter</a>: </td><td align=left><select size=1 name=lead_filter_id>\n";
echo "$filters_list";
echo "<option selected value=\"$lead_filter_id\">$lead_filter_id - $filtername_list[$lead_filter_id]</option>\n";
echo "</select>$NWB#vicidial_campaigns-lead_filter_id$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right>Hopper Level: </td><td align=left><select size=1 name=hopper_level><option>1</option><option>5</option><option>10</option><option>50</option><option>100</option><option>200</option><option>500</option><option>1000</option><option SELECTED>$hopper_level</option></select>$NWB#vicidial_campaigns-hopper_level$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right>Force Reset of Hopper: </td><td align=left><select size=1 name=reset_hopper><option>Y</option><option SELECTED>N</option></select>$NWB#vicidial_campaigns-force_reset_hopper$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right>Auto Dial Level: </td><td align=left><select size=1 name=auto_dial_level><option >0</option><option>1</option><option>1.1</option><option>1.2</option><option>1.3</option><option>1.4</option><option>1.5</option><option>1.6</option><option>1.7</option><option>1.8</option><option>1.9</option><option>2.0</option><option>2.2</option><option>2.5</option><option>2.7</option><option>3.0</option><option>3.5</option><option>4.0</option><option SELECTED>$auto_dial_level</option></select>(0 = off)$NWB#vicidial_campaigns-auto_dial_level$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right><a href=\"$PHP_SELF?ADD=3111111&script_id=$script_id\">Script</a>: </td><td align=left>$script_id</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right>Get Call Launch: </td><td align=left>$get_call_launch</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=SUBMIT value=SUBMIT></td></tr>\n";
echo "</TABLE></center></FORM>\n";

	##### calculate what gmt_offset_now values are within the allowed local_call_time setting
	if ($local_call_time == '24hours')
		{
		$p='13';
		$GMT_allowed = '';
		while ($p > -13)
			{
			$tz = sprintf("%.2f", $p);	$GMT_allowed = "$GMT_allowed'$tz',";
			$p = ($p - 0.25);
			}
		}
	if ($local_call_time == '9am-9pm')
		{
		$p='13';
		$GMT_allowed = '';
		while ($p > -13)
			{
			$pzone=3600 * $p;
			$phour=gmdate("G", time() + $pzone);
			if ( ($phour >= 9) && ($phour <= 20) ){$tz = sprintf("%.2f", $p);	$GMT_allowed = "$GMT_allowed'$tz',";}
			$p = ($p - 0.25);
			}
		}
	if ($local_call_time == '9am-5pm')
		{
		$p='13';
		$GMT_allowed = '';
		while ($p > -13)
			{
			$pzone=3600 * $p;
			$phour=gmdate("G", time() + $pzone);
			if ( ($phour >= 9) && ($phour <= 16) ){$tz = sprintf("%.2f", $p);	$GMT_allowed = "$GMT_allowed'$tz',";}
			$p = ($p - 0.25);
			}
		}
	if ($local_call_time == '12pm-5pm')
		{
		$p='13';
		$GMT_allowed = '';
		while ($p > -13)
			{
			$pzone=3600 * $p;
			$phour=gmdate("G", time() + $pzone);
			if ( ($phour >= 12) && ($phour <= 16) ){$tz = sprintf("%.2f", $p);	$GMT_allowed = "$GMT_allowed'$tz',";}
			$p = ($p - 0.25);
			}
		}
	if ($local_call_time == '12pm-9pm')
		{
		$p='13';
		$GMT_allowed = '';
		while ($p > -13)
			{
			$pzone=3600 * $p;
			$phour=gmdate("G", time() + $pzone);
			if ( ($phour >= 12) && ($phour <= 20) ){$tz = sprintf("%.2f", $p);	$GMT_allowed = "$GMT_allowed'$tz',";}
			$p = ($p - 0.25);
			}
		}
	if ($local_call_time == '5pm-9pm')
		{
		$p='13';
		$GMT_allowed = '';
		while ($p > -13)
			{
			$pzone=3600 * $p;
			$phour=gmdate("G", time() + $pzone);
			if ( ($phour >= 17) && ($phour <= 20) ){$tz = sprintf("%.2f", $p);	$GMT_allowed = "$GMT_allowed'$tz',";}
			$p = ($p - 0.25);
			}
		}

	$GMT_allowed = "$GMT_allowed'99'";



echo "<center>\n";
echo "<br><b>LISTS WITHIN THIS CAMPAIGN: &nbsp; $NWB#vicidial_campaign_lists$NWE</b><br>\n";
echo "<TABLE width=400 cellspacing=3>\n";
echo "<tr><td>LIST ID</td><td>LIST NAME</td><td>ACTIVE</td></tr>\n";

	$active_lists = 0;
	$inactive_lists = 0;
	$stmt="SELECT list_id,active,list_name from vicidial_lists where campaign_id='$campaign_id'";
	$rsltx=mysql_query($stmt, $link);
	$lists_to_print = mysql_num_rows($rsltx);
	$camp_lists='';

	$o=0;
	while ($lists_to_print > $o) {
		$rowx=mysql_fetch_row($rsltx);
		$o++;
	if (ereg("Y", $rowx[1])) {$active_lists++;   $camp_lists .= "'$rowx[0]',";}
	if (ereg("N", $rowx[1])) {$inactive_lists++;}

	if (eregi("1$|3$|5$|7$|9$", $o))
		{$bgcolor='bgcolor="#B9CBFD"';} 
	else
		{$bgcolor='bgcolor="#9BB9FB"';}

	echo "<tr $bgcolor><td><font size=1><a href=\"$PHP_SELF?ADD=311&list_id=$rowx[0]\">$rowx[0]</a></td><td><font size=1>$rowx[2]</td><td><font size=1>$rowx[1]</td></tr>\n";

	}

echo "</table></center><br>\n";
echo "<center><b>\n";

$filterSQL = $filtersql_list[$lead_filter_id];
$filterSQL = eregi_replace("^and|and$|^or|or$","",$filterSQL);
if (strlen($filterSQL)>4)
	{$fSQL = "and $filterSQL";}
else
	{$fSQL = '';}

	$camp_lists = eregi_replace(".$","",$camp_lists);
echo "This campaign has $active_lists active lists and $inactive_lists inactive lists<br><br>\n";
	$stmt="SELECT count(*) FROM vicidial_list where called_since_last_reset='N' and status IN('$dial_status_a','$dial_status_b','$dial_status_c','$dial_status_d','$dial_status_e') and list_id IN($camp_lists) and gmt_offset_now IN($GMT_allowed) $fSQL";
	if ($DB) {echo "$stmt\n";}
	$rsltx=mysql_query($stmt, $link);
	$rsltx_rows = mysql_num_rows($rsltx);
	if ($rsltx_rows)
		{
		$rowx=mysql_fetch_row($rsltx);
		$active_leads = "$rowx[0]";
		}
	else {$active_leads = '0';}

echo "This campaign has $active_leads leads to be dialed in those lists<br><br>\n";
	$stmt="SELECT count(*) FROM vicidial_hopper where campaign_id='$campaign_id' and status IN('READY')";
	if ($DB) {echo "$stmt\n";}
	$rsltx=mysql_query($stmt, $link);
	$rowx=mysql_fetch_row($rsltx);
	$hopper_leads = "$rowx[0]";

echo "This campaign has $hopper_leads leads in the dial hopper<br><br>\n";
echo "<a href=\"./AST_VICIDIAL_hopperlist.php?group=$campaign_id\">Click here to see what leads are in the hopper right now</a><br><br>\n";
echo "<a href=\"$PHP_SELF?ADD=81&campaign_id=$campaign_id\">Click here to see all CallBack Holds in this campaign</a><BR><BR>\n";
echo "</b></center>\n";

echo "<br>\n";

echo "<a href=\"$PHP_SELF?ADD=52&campaign_id=$campaign_id\">LOG ALL AGENTS OUT OF THIS CAMPAIGN</a><BR><BR>\n";


if ($LOGdelete_campaigns > 0)
	{
	echo "<br><br><a href=\"$PHP_SELF?ADD=51&campaign_id=$campaign_id\">DELETE THIS CAMPAIGN</a>\n";
	}


}


######################
# ADD=311 modify list info in the system
######################

if ($ADD==311)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_lists where list_id='$list_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$campaign_id = $row[2];
	$active = $row[3];

	# grab names of global statuses and statuses in the selected campaign
	$stmt="SELECT * from vicidial_statuses order by status";
	$rsltx=mysql_query($stmt, $link);
	$statuses_to_print = mysql_num_rows($rsltx);

	$o=0;
	while ($statuses_to_print > $o) {
		$rowx=mysql_fetch_row($rsltx);
		$statuses_list["$rowx[0]"] = "$rowx[1]";
		$o++;
	}

	$stmt="SELECT * from vicidial_campaign_statuses where campaign_id='$campaign_id' order by status";
	$rsltx=mysql_query($stmt, $link);
	$Cstatuses_to_print = mysql_num_rows($rsltx);

	$o=0;
	while ($Cstatuses_to_print > $o) {
		$rowx=mysql_fetch_row($rsltx);
		$statuses_list["$rowx[0]"] = "$rowx[1]";
		$o++;
	}
	# end grab status names


echo "<br>MODIFY A LISTS RECORD: $row[0]<form action=$PHP_SELF method=POST>\n";
echo "<input type=hidden name=ADD value=411>\n";
echo "<input type=hidden name=list_id value=\"$row[0]\">\n";
echo "<input type=hidden name=old_campaign_id value=\"$row[2]\">\n";
echo "<center><TABLE width=600 cellspacing=3>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>List ID: </td><td align=left><b>$row[0]</b>$NWB#vicidial_lists-list_id$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>List Name: </td><td align=left><input type=text name=list_name size=20 maxlength=20 value=\"$row[1]\">$NWB#vicidial_lists-list_name$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right><a href=\"$PHP_SELF?ADD=34&campaign_id=$campaign_id\">Campaign</a>: </td><td align=left><select size=1 name=campaign_id>\n";

	$stmt="SELECT campaign_id,campaign_name from vicidial_campaigns order by campaign_id";
	$rsltx=mysql_query($stmt, $link);
	$campaigns_to_print = mysql_num_rows($rsltx);
	$campaigns_list='';

	$o=0;
	while ($campaigns_to_print > $o) {
		$rowx=mysql_fetch_row($rsltx);
		$campaigns_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
		$o++;
	}
echo "$campaigns_list";
echo "<option SELECTED>$campaign_id</option>\n";
echo "</select>$NWB#vicidial_lists-campaign_id$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Active: </td><td align=left><select size=1 name=active><option>Y</option><option>N</option><option SELECTED>$active</option></select>$NWB#vicidial_lists-active$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Reset Lead-Called-Status for this list: </td><td align=left><select size=1 name=reset_list><option>Y</option><option SELECTED>N</option></select>$NWB#vicidial_lists-reset_list$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=SUBMIT value=SUBMIT></td></tr>\n";
echo "</TABLE></center>\n";

echo "<center>\n";
echo "<br><b>STATUSES WITHIN THIS LIST:</b><br>\n";
echo "<TABLE width=500 cellspacing=3>\n";
echo "<tr><td>STATUS</td><td>STATUS NAME</td><td>CALLED</td><td>NOT CALLED</td></tr>\n";

	$leads_in_list = 0;
	$leads_in_list_N = 0;
	$leads_in_list_Y = 0;
	$stmt="SELECT status,called_since_last_reset,count(*) from vicidial_list where list_id='$list_id' group by status,called_since_last_reset order by status,called_since_last_reset";
	$rsltx=mysql_query($stmt, $link);
	$statuses_to_print = mysql_num_rows($rsltx);

	$o=0;
	$lead_list['count'] = 0;
	$lead_list['Y_count'] = 0;
	$lead_list['N_count'] = 0;
	while ($statuses_to_print > $o) 
	{
	    $rowx=mysql_fetch_row($rsltx);
	    
	    $lead_list['count'] = ($lead_list['count'] + $rowx[2]);
	    if ($rowx[1] == 'N') 
	    {
		$since_reset = 'N';
		$since_resetX = 'Y';
	    }
	    else 
	    {
		$since_reset = 'Y';
		$since_resetX = 'N';
	    } 
	    $lead_list[$since_reset][$rowx[0]] = $rowx[2];
	    $lead_list[$since_reset.'_count'] = ($lead_list[$since_reset.'_count'] + $rowx[2]);
	    #If opposite side is not set, it may not in the future so give it a value of zero
	    if (!isset($lead_list[$since_resetX][$rowx[0]])) 
	    {
		$lead_list[$since_resetX][$rowx[0]]=0;
	    }
	    $o++;
	}
 
	$o=0;
	while (list($dispo,) = each($lead_list[$since_reset]))
	{

	if (eregi("1$|3$|5$|7$|9$", $o))
		{$bgcolor='bgcolor="#B9CBFD"';} 
	else
		{$bgcolor='bgcolor="#9BB9FB"';}

	if ($dispo == 'CBHOLD')
		{
		$CLB="<a href=\"$PHP_SELF?ADD=811&list_id=$list_id\">";
		$CLE="</a>";
		}
	else
		{
		$CLB='';
		$CLE='';
		}

	echo "<tr $bgcolor><td><font size=1>$CLB$dispo$CLE</td><td><font size=1>$statuses_list[$dispo]</td><td><font size=1>".$lead_list['Y'][$dispo]."</td><td><font size=1>".$lead_list['N'][$dispo]." </td></tr>\n";
	$o++;
	}

echo "<tr><td colspan=2><font size=1>SUBTOTALS</td><td><font size=1>$lead_list[Y_count]</td><td><font size=1>$lead_list[N_count]</td></tr>\n";
echo "<tr bgcolor=\"#9BB9FB\"><td><font size=1>TOTAL</td><td colspan=3 align=center><font size=1>$lead_list[count]</td></tr>\n";

echo "</table></center><br>\n";
unset($lead_list);





echo "<center>\n";
echo "<br><b>TIME ZONES WITHIN THIS LIST:</b><br>\n";
echo "<TABLE width=500 cellspacing=3>\n";
echo "<tr><td>GMT OFFSET NOW (local time)</td><td>CALLED</td><td>NOT CALLED</td></tr>\n";

	$stmt="SELECT gmt_offset_now,called_since_last_reset,count(*) from vicidial_list where list_id='$list_id' group by gmt_offset_now,called_since_last_reset order by gmt_offset_now,called_since_last_reset";
	$rsltx=mysql_query($stmt, $link);
	$statuses_to_print = mysql_num_rows($rsltx);

	$o=0;
	$plus='+';
	$lead_list['count'] = 0;
	$lead_list['Y_count'] = 0;
	$lead_list['N_count'] = 0;
	while ($statuses_to_print > $o) 
	{
	    $rowx=mysql_fetch_row($rsltx);
	    
	    $lead_list['count'] = ($lead_list['count'] + $rowx[2]);
	    if ($rowx[1] == 'N') 
	    {
		$since_reset = 'N';
		$since_resetX = 'Y';
	    }
	    else 
	    {
		$since_reset = 'Y';
		$since_resetX = 'N';
	    } 
	    $lead_list[$since_reset][$rowx[0]] = $rowx[2];
	    $lead_list[$since_reset.'_count'] = ($lead_list[$since_reset.'_count'] + $rowx[2]);
	    #If opposite side is not set, it may not in the future so give it a value of zero
	    if (!isset($lead_list[$since_resetX][$rowx[0]])) 
	    {
		$lead_list[$since_resetX][$rowx[0]]=0;
	    }
	    $o++;
	}

	while (list($tzone,) = each($lead_list[$since_reset]))
	{
	$LOCALzone=3600 * $tzone;
	$LOCALdate=gmdate("D M Y H:i", time() + $LOCALzone);

	if ($tzone >= 0) {$tzone = "$plus$tzone";}
	if (eregi("1$|3$|5$|7$|9$", $o))
		{$bgcolor='bgcolor="#B9CBFD"';} 
	else
		{$bgcolor='bgcolor="#9BB9FB"';}

		echo "<tr $bgcolor><td><font size=1>".$tzone." &nbsp; &nbsp; ($LOCALdate)</td><td><font size=1>".$lead_list['Y'][$tzone]."</td><td><font size=1>".$lead_list['N'][$tzone]."</td></tr>\n";
	}

echo "<tr><td><font size=1>SUBTOTALS</td><td><font size=1>$lead_list[Y_count]</td><td><font size=1>$lead_list[N_count]</td></tr>\n";
echo "<tr bgcolor=\"#9BB9FB\"><td><font size=1>TOTAL</td><td colspan=2 align=center><font size=1>$lead_list[count]</td></tr>\n";

echo "</table></center><br>\n";
unset($lead_list);







	$leads_in_list = 0;
	$leads_in_list_N = 0;
	$leads_in_list_Y = 0;
	$stmt="SELECT status,called_count,count(*) from vicidial_list where list_id='$list_id' group by status,called_count order by status,called_count";
	$rsltx=mysql_query($stmt, $link);
	$status_called_to_print = mysql_num_rows($rsltx);

	$o=0;
	$sts=0;
	$first_row=1;
	$all_called_first=1000;
	$all_called_last=0;
	while ($status_called_to_print > $o) 
	{
	$rowx=mysql_fetch_row($rsltx);
	$leads_in_list = ($leads_in_list + $rowx[2]);
	$count_statuses[$o]			= "$rowx[0]";
	$count_called[$o]			= "$rowx[1]";
	$count_count[$o]			= "$rowx[2]";
	$all_called_count[$rowx[1]] = ($all_called_count[$rowx[1]] + $rowx[2]);

	if ( (strlen($status[$sts]) < 1) or ($status[$sts] != "$rowx[0]") )
		{
		if ($first_row) {$first_row=0;}
		else {$sts++;}
		$status[$sts] = "$rowx[0]";
		$status_called_first[$sts] = "$rowx[1]";
		if ($status_called_first[$sts] < $all_called_first) {$all_called_first = $status_called_first[$sts];}
		}
	$leads_in_sts[$sts] = ($leads_in_sts[$sts] + $rowx[2]);
	$status_called_last[$sts] = "$rowx[1]";
	if ($status_called_last[$sts] > $all_called_last) {$all_called_last = $status_called_last[$sts];}

	$o++;
	}




echo "<center>\n";
echo "<br><b>CALLED COUNTS WITHIN THIS LIST:</b><br>\n";
echo "<TABLE width=500 cellspacing=1>\n";
echo "<tr><td align=left><font size=1>STATUS</td><td align=center><font size=1>STATUS NAME</td>";
$first = $all_called_first;
while ($first <= $all_called_last)
	{
	if (eregi("1$|3$|5$|7$|9$", $first)) {$AB='bgcolor="#AFEEEE"';} 
	else{$AB='bgcolor="#E0FFFF"';}
	echo "<td align=center $AB><font size=1>$first</td>";
	$first++;
	}
echo "<td align=center><font size=1>SUBTOTAL</td></tr>\n";

	$sts=0;
	$statuses_called_to_print = count($status);
	while ($statuses_called_to_print > $sts) 
	{
	$Pstatus = $status[$sts];
	if (eregi("1$|3$|5$|7$|9$", $sts))
		{$bgcolor='bgcolor="#B9CBFD"';   $AB='bgcolor="#9BB9FB"';} 
	else
		{$bgcolor='bgcolor="#9BB9FB"';   $AB='bgcolor="#B9CBFD"';}
#	echo "$status[$sts]|$status_called_first[$sts]|$status_called_last[$sts]|$leads_in_sts[$sts]|\n";
#	echo "$status[$sts]|";
	echo "<tr $bgcolor><td><font size=1>$Pstatus</td><td><font size=1>$statuses_list[$Pstatus]</td>";

	$first = $all_called_first;
	while ($first <= $all_called_last)
		{
		if (eregi("1$|3$|5$|7$|9$", $sts))
			{
			if (eregi("1$|3$|5$|7$|9$", $first)) {$AB='bgcolor="#9BB9FB"';} 
			else{$AB='bgcolor="#B9CBFD"';}
			}
		else
			{
			if (eregi("0$|2$|4$|6$|8$", $first)) {$AB='bgcolor="#9BB9FB"';} 
			else{$AB='bgcolor="#B9CBFD"';}
			}

		$called_printed=0;
		$o=0;
		while ($status_called_to_print > $o) 
			{
			if ( ($count_statuses[$o] == "$Pstatus") and ($count_called[$o] == "$first") )
				{
				$called_printed++;
				echo "<td $AB><font size=1> $count_count[$o]</td>";
				}


			$o++;
			}
		if (!$called_printed) 
			{echo "<td $AB><font size=1> &nbsp;</td>";}
		$first++;
		}
	echo "<td><font size=1>$leads_in_sts[$sts]</td></tr>\n\n";

	$sts++;
	}

echo "<tr><td align=center colspan=2><b><font size=1>TOTAL</td>";
$first = $all_called_first;
while ($first <= $all_called_last)
	{
	if (eregi("1$|3$|5$|7$|9$", $first)) {$AB='bgcolor="#AFEEEE"';} 
	else{$AB='bgcolor="#E0FFFF"';}
	echo "<td align=center $AB><b><font size=1>$all_called_count[$first]</td>";
	$first++;
	}
echo "<td align=center><b><font size=1>$leads_in_list</td></tr>\n";

echo "</table></center><br>\n";





echo "<center><b>\n";

if ($LOGdelete_lists > 0)
	{
	echo "<br><br><a href=\"$PHP_SELF?ADD=511&list_id=$list_id\">DELETE THIS LIST</a>\n";
	}

}



######################
# ADD=3111 modify in-group info in the system
######################

if ($ADD==3111)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_inbound_groups where group_id='$group_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$group_name = $row[1];
	$group_color = $row[2];
	$active = $row[3];
	$web_form_address = $row[4];
	$voicemail_ext = $row[5];
	$next_agent_call = $row[6];
	$fronter_display = $row[7];
	$script_id = $row[8];
	$get_call_launch = $row[9];
	$xferconf_a_dtmf = $row[10];
	$xferconf_a_number = $row[11];
	$xferconf_b_dtmf = $row[12];
	$xferconf_b_number = $row[13];

echo "<br>MODIFY A GROUPS RECORD: $row[0]<form action=$PHP_SELF method=POST>\n";
echo "<input type=hidden name=ADD value=4111>\n";
echo "<input type=hidden name=group_id value=\"$row[0]\">\n";
echo "<center><TABLE width=600 cellspacing=3>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Group ID: </td><td align=left><b>$row[0]</b>$NWB#vicidial_inbound_groups-group_id$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Group Name: </td><td align=left><input type=text name=group_name size=30 maxlength=30 value=\"$row[1]\">$NWB#vicidial_inbound_groups-group_name$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Group Color: </td><td align=left bgcolor=\"$row[2]\"><input type=text name=group_color size=7 maxlength=7 value=\"$row[2]\">$NWB#vicidial_inbound_groups-group_color$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Active: </td><td align=left><select size=1 name=active><option>Y</option><option>N</option><option SELECTED>$active</option></select>$NWB#vicidial_inbound_groups-active$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Web Form: </td><td align=left><input type=text name=web_form_address size=50 maxlength=255 value=\"$web_form_address\">$NWB#vicidial_inbound_groups-web_form_address$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Voicemail: </td><td align=left><input type=text name=voicemail_ext size=10 maxlength=10 value=\"$voicemail_ext\">$NWB#vicidial_inbound_groups-voicemail_ext$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Next Agent Call: </td><td align=left><select size=1 name=next_agent_call><option >random</option><option>oldest_call_start</option><option>oldest_call_finish</option><option>overall_user_level</option><option SELECTED>$next_agent_call</option></select>$NWB#vicidial_inbound_groups-next_agent_call$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Fronter Display: </td><td align=left><select size=1 name=fronter_display><option>Y</option><option>N</option><option SELECTED>$fronter_display</option></select>$NWB#vicidial_inbound_groups-fronter_display$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right><a href=\"$PHP_SELF?ADD=3111111&script_id=$script_id\">Script</a>: </td><td align=left><select size=1 name=script_id>\n";
echo "$scripts_list";
echo "<option selected value=\"$script_id\">$script_id - $scriptname_list[$script_id]</option>\n";
echo "</select>$NWB#vicidial_inbound_groups-ingroup_script$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Get Call Launch: </td><td align=left><select size=1 name=get_call_launch><option selected>NONE</option><option>SCRIPT</option><option>WEBFORM</option><option selected>$get_call_launch</option></select>$NWB#vicidial_inbound_groups-get_call_launch$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right>Transfer-Conf DTMF 1: </td><td align=left><input type=text name=xferconf_a_dtmf size=20 maxlength=50 value=\"$xferconf_a_dtmf\">$NWB#vicidial_inbound_groups-xferconf_a_dtmf$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right>Transfer-Conf Number 1: </td><td align=left><input type=text name=xferconf_a_number size=20 maxlength=50 value=\"$xferconf_a_number\">$NWB#vicidial_inbound_groups-xferconf_a_dtmf$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right>Transfer-Conf DTMF 2: </td><td align=left><input type=text name=xferconf_b_dtmf size=20 maxlength=50 value=\"$xferconf_b_dtmf\">$NWB#vicidial_inbound_groups-xferconf_a_dtmf$NWE</td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=right>Transfer-Conf Number 2: </td><td align=left><input type=text name=xferconf_b_number size=20 maxlength=50 value=\"$xferconf_b_number\">$NWB#vicidial_inbound_groups-xferconf_a_dtmf$NWE</td></tr>\n";


echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=SUBMIT value=SUBMIT></td></tr>\n";
echo "</TABLE></center>\n";

echo "</table></center><br>\n";

echo "<center><b>\n";

if ($LOGdelete_ingroups > 0)
	{
	echo "<br><br><a href=\"$PHP_SELF?ADD=5111&group_id=$group_id\">DELETE THIS IN-GROUP</a>\n";
	}

}



######################
# ADD=31111 modify remote agents info in the system
######################

if ($ADD==31111)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_remote_agents where remote_agent_id='$remote_agent_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$remote_agent_id =	$row[0];
	$user_start =		$row[1];
	$number_of_lines =	$row[2];
	$server_ip =		$row[3];
	$conf_exten =		$row[4];
	$status =			$row[5];
	$campaign_id =		$row[6];

echo "<br>MODIFY A REMOTE AGENTS ENTRY: $row[0]<form action=$PHP_SELF method=POST>\n";
echo "<input type=hidden name=ADD value=41111>\n";
echo "<input type=hidden name=remote_agent_id value=\"$row[0]\">\n";
echo "<center><TABLE width=600 cellspacing=3>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>User ID Start: </td><td align=left><input type=text name=user_start size=6 maxlength=6 value=\"$user_start\"> (numbers only, incremented)$NWB#vicidial_remote_agents-user_start$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Number of Lines: </td><td align=left><input type=text name=number_of_lines size=3 maxlength=3 value=\"$number_of_lines\"> (numbers only)$NWB#vicidial_remote_agents-number_of_lines$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Server IP: </td><td align=left><select size=1 name=server_ip>\n";
echo "$servers_list";
echo "<option SELECTED>$row[3]</option>\n";
echo "</select>$NWB#vicidial_remote_agents-server_ip$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>External Extension: </td><td align=left><input type=text name=conf_exten size=20 maxlength=20 value=\"$conf_exten\"> (dialplan number dialed to reach agents)$NWB#vicidial_remote_agents-conf_exten$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Status: </td><td align=left><select size=1 name=status><option SELECTED>ACTIVE</option><option>INACTIVE</option><option SELECTED>$status</option></select>$NWB#vicidial_remote_agents-status$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Campaign: </td><td align=left><select size=1 name=campaign_id>\n";
echo "$campaigns_list";
echo "<option SELECTED>$campaign_id</option>\n";
echo "</select>$NWB#vicidial_remote_agents-campaign_id$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Inbound Groups: </td><td align=left>\n";
echo "$groups_list";
echo "$NWB#vicidial_remote_agents-closer_campaigns$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=SUBMIT value=SUBMIT></td></tr>\n";
echo "</TABLE></center>\n";
echo "NOTE: It can take up to 30 seconds for changes submitted on this screen to go live\n";


if ($LOGdelete_remote_agents > 0)
	{
	echo "<br><br><a href=\"$PHP_SELF?ADD=51111&remote_agent_id=$remote_agent_id\">DELETE THIS REMOTE AGENT</a>\n";
	}

}


######################
# ADD=311111 modify user group info in the system
######################

if ($ADD==311111)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_user_groups where user_group='$user_group';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$user_group =		$row[0];
	$group_name =		$row[1];
echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

echo "<br>MODIFY A USERS GROUP ENTRY<form action=$PHP_SELF method=POST>\n";
echo "<input type=hidden name=ADD value=411111>\n";
echo "<input type=hidden name=OLDuser_group value=\"$user_group\">\n";
echo "<center><TABLE width=600 cellspacing=3>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Group: </td><td align=left><input type=text name=user_group size=15 maxlength=20 value=\"$user_group\"> (no spaces or punctuation)$NWB#vicidial_user_groups-user_group$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Description: </td><td align=left><input type=text name=group_name size=40 maxlength=40 value=\"$group_name\"> (description of group)$NWB#vicidial_user_groups-group_name$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=SUBMIT value=SUBMIT></td></tr>\n";
echo "</TABLE></center>\n";

if ($LOGdelete_user_groups > 0)
	{
	echo "<br><br><a href=\"$PHP_SELF?ADD=511111&user_group=$user_group\">DELETE THIS USER GROUP</a>\n";
	}

}


######################
# ADD=3111111 modify script info in the system
######################

if ($ADD==3111111)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_scripts where script_id='$script_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$script_name =		$row[1];
	$script_comments =	$row[2];
	$script_text =		$row[3];
	$active =			$row[4];
echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

echo "<br>MODIFY A SCRIPT<form action=$PHP_SELF method=POST>\n";
echo "<input type=hidden name=ADD value=4111111>\n";
echo "<input type=hidden name=script_id value=\"$script_id\">\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Script ID: </td><td align=left><B>$script_id</B>$NWB#vicidial_scripts-script_name$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Script Name: </td><td align=left><input type=text name=script_name size=40 maxlength=50 value=\"$script_name\"> (title of the script)$NWB#vicidial_scripts-script_name$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Script Comments: </td><td align=left><input type=text name=script_comments size=50 maxlength=255 value=\"$script_comments\"> $NWB#vicidial_scripts-script_comments$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Active: </td><td align=left><select size=1 name=active><option SELECTED>Y</option><option>N</option><option selected>$active</option></select>$NWB#vicidial_scripts-active$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Script Text: <BR><BR><B><a href=\"javascript:openNewWindow('$PHP_SELF?ADD=7111111&script_id=$script_id')\">Preview Script</a></B> </td><td align=left><TEXTAREA NAME=script_text ROWS=20 COLS=50>$script_text</TEXTAREA> $NWB#vicidial_scripts-script_text$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=SUBMIT value=SUBMIT></td></tr>\n";
echo "</TABLE></center>\n";

if ($LOGdelete_scripts > 0)
	{
	echo "<br><br><a href=\"$PHP_SELF?ADD=5111111&script_id=$script_id\">DELETE THIS SCRIPT</a>\n";
	}

}


######################
# ADD=31111111 modify filter info in the system
######################

if ($ADD==31111111)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_lead_filters where lead_filter_id='$lead_filter_id';";
	$rslt=mysql_query($stmt, $link);
	$row=mysql_fetch_row($rslt);
	$lead_filter_name =		$row[1];
	$lead_filter_comments =	$row[2];
	$lead_filter_sql =		$row[3];
echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

echo "<br>MODIFY A FILTER<form action=$PHP_SELF method=POST>\n";
echo "<input type=hidden name=ADD value=41111111>\n";
echo "<input type=hidden name=lead_filter_id value=\"$lead_filter_id\">\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Filter ID: </td><td align=left><B>$lead_filter_id</B>$NWB#vicidial_lead_filters-lead_filter_id$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Filter Name: </td><td align=left><input type=text name=lead_filter_name size=40 maxlength=50 value=\"$lead_filter_name\"> (short description of the filter)$NWB#vicidial_lead_filters-lead_filter_name$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Filter Comments: </td><td align=left><input type=text name=lead_filter_comments size=50 maxlength=255 value=\"$lead_filter_comments\"> $NWB#vicidial_lead_filters-lead_filter_comments$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Filter SQL:</td><td align=left><TEXTAREA NAME=lead_filter_sql ROWS=20 COLS=50>$lead_filter_sql</TEXTAREA> $NWB#vicidial_lead_filters-lead_filter_sql$NWE</td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=SUBMIT value=SUBMIT></td></tr>\n";
echo "</TABLE></center>\n";

if ($LOGdelete_filters > 0)
	{
	echo "<br><br><a href=\"$PHP_SELF?ADD=51111111&lead_filter_id=$lead_filter_id\">DELETE THIS FILTER</a>\n";
	}

}







######################
# ADD=55 search form
######################

if ($ADD==55)
{
echo "<TABLE><TR><TD>\n";
echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

echo "<br>SEARCH FOR A USER<form action=$PHP_SELF method=POST>\n";
echo "<input type=hidden name=ADD value=66>\n";
echo "<center><TABLE width=600 cellspacing=3>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>User Number: </td><td align=left><input type=text name=user size=20 maxlength=20></td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>Full Name: </td><td align=left><input type=text name=full_name size=30 maxlength=30></td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>User Level: </td><td align=left><select size=1 name=user_level><option selected>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option></select></td></tr>\n";
echo "<tr bgcolor=#B6D3FC><td align=right>User Group: </td><td align=left><select size=1 name=user_group>\n";

	$stmt="SELECT * from vicidial_user_groups order by user_group";
	$rslt=mysql_query($stmt, $link);
	$groups_to_print = mysql_num_rows($rslt);
	$o=0;
	$groups_list='';
	while ($groups_to_print > $o) {
		$rowx=mysql_fetch_row($rslt);
		$groups_list .= "<option value=\"$rowx[0]\">$rowx[0] - $rowx[1]</option>\n";
		$o++;
	}
echo "$groups_list</select></td></tr>\n";

echo "<tr bgcolor=#B6D3FC><td align=center colspan=2><input type=submit name=search value=search></td></tr>\n";
echo "</TABLE></center>\n";

}

######################
# ADD=66 user search results
######################

if ($ADD==66)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$SQL = '';
	if ($user) {$SQL .= " user LIKE \"%$user%\" and";}
	if ($full_name) {$SQL .= " full_name LIKE \"%$full_name%\" and";}
	if ($user_level > 0) {$SQL .= " user_level LIKE \"%$user_level%\" and";}
	if ($user_group) {$SQL .= " user_group = '$user_group' and";}
	$SQL = eregi_replace(" and$", "", $SQL);
	if (strlen($SQL)>5) {$SQL = "where $SQL";}

	$stmt="SELECT * from vicidial_users $SQL order by full_name desc;";
#	echo "\n|$stmt|\n";
	$rslt=mysql_query($stmt, $link);
	$people_to_print = mysql_num_rows($rslt);

echo "<br>SEARCH RESULTS:\n";
echo "<center><TABLE width=600 cellspacing=0 cellpadding=1>\n";

	$o=0;
	while ($people_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><font size=1>$row[1]</td><td><font size=1>$row[3]</td><td><font size=1>$row[4]</td><td><font size=1>$row[5]</td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=3&user=$row[1]\">MODIFY</a> | <a href=\"./user_stats.php?user=$row[1]\">STATS</a> | <a href=\"./user_status.php?user=$row[1]\">STATUS</a> | <a href=\"./AST_agent_time_sheet.php?agent=$row[1]\">TIME</a></td></tr>\n";
		$o++;
	}

echo "</TABLE></center>\n";

}


######################################################################################################
######################################################################################################
#######   8 series, Callback lists
######################################################################################################
######################################################################################################

######################
# ADD=8 find all callbacks on hold by a User
######################
if ($ADD==8)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_callbacks where status IN('ACTIVE','LIVE') and user='$user' order by recipient,status desc,callback_time";
	$rslt=mysql_query($stmt, $link);
	$cb_to_print = mysql_num_rows($rslt);

echo "<br>USER CALLBACK HOLD LISTINGS: $user\n";
$ADD='82';
}

######################
# ADD=81 find all callbacks on hold within a Campaign
######################
if ($ADD==81)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_callbacks where status IN('ACTIVE','LIVE') and campaign_id='$campaign_id' order by recipient,status desc,callback_time";
	$rslt=mysql_query($stmt, $link);
	$cb_to_print = mysql_num_rows($rslt);

echo "<br>CAMPAIGN CALLBACK HOLD LISTINGS: $campaign_id\n";
$ADD='82';
}

######################
# ADD=811 find all callbacks on hold within a List
######################
if ($ADD==811)
{
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_callbacks where status IN('ACTIVE','LIVE') and list_id='$list_id' order by recipient,status desc,callback_time";
	$rslt=mysql_query($stmt, $link);
	$cb_to_print = mysql_num_rows($rslt);

echo "<br>LIST CALLBACK HOLD LISTINGS: $list_id\n";
$ADD='82';
}

######################
# ADD=82 display all callbacks on hold
######################
if ($ADD==82)
{
echo "<TABLE><TR><TD>\n";
echo "<center><TABLE width=600 cellspacing=0 cellpadding=1>\n";
echo "<tr bgcolor=black><td><font size=1 color=white>LEAD</td><td><font size=1 color=white>LIST</td><td><font size=1 color=white>CAMPAIGN</td><td><font size=1 color=white>ENTRY DATE</td><td><font size=1 color=white>CALLBACK DATE</td><td><font size=1 color=white>USER</td><td><font size=1 color=white>RECIPIENT</td><td><font size=1 color=white>STATUS</td></tr>\n";

	$o=0;
	while ($cb_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor>";
		echo "<td><font size=1><A HREF=\"admin_modify_lead.php?lead_id=$row[1]\" target=\"_blank\">$row[1]</A></td>";
		echo "<td><font size=1><A HREF=\"$PHP_SELF?ADD=311&list_id=$row[2]\">$row[2]</A></td>";
		echo "<td><font size=1><A HREF=\"$PHP_SELF?ADD=31&campaign_id=$row[3]\">$row[3]</A></td>";
		echo "<td><font size=1>$row[5]</td>";
		echo "<td><font size=1>$row[6]</td>";
		echo "<td><font size=1><A HREF=\"$PHP_SELF?ADD=3&user=$row[8]\">$row[8]</A></td>";
		echo "<td><font size=1>$row[9]</td>";
		echo "<td><font size=1>$row[4]</td>";
		echo "</tr>\n";
		$o++;
	}

echo "</TABLE></center>\n";
}



######################################################################################################
######################################################################################################
#######   0 series, displays and searches
######################################################################################################
######################################################################################################

######################
# ADD=0 display all active users
######################
if ($ADD==0)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_users order by full_name";
	$rslt=mysql_query($stmt, $link);
	$people_to_print = mysql_num_rows($rslt);

echo "<br>USER LISTINGS:\n";
echo "<center><TABLE width=600 cellspacing=0 cellpadding=1>\n";

	$o=0;
	while ($people_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><font size=1>$row[1]</td><td><font size=1>$row[3]</td><td><font size=1>$row[4]</td><td><font size=1>$row[5]</td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=3&user=$row[1]\">MODIFY</a> | <a href=\"./user_stats.php?user=$row[1]\">STATS</a> | <a href=\"./user_status.php?user=$row[1]\">STATUS</a> | <a href=\"./AST_agent_time_sheet.php?agent=$row[1]\">TIME</a></td></tr>\n";
		$o++;
	}

echo "</TABLE></center>\n";
}

######################
# ADD=10 display all campaigns
######################
if ($ADD==10)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_campaigns order by campaign_id";
	$rslt=mysql_query($stmt, $link);
	$people_to_print = mysql_num_rows($rslt);

echo "<br>CAMPAIGN LISTINGS:\n";
echo "<center><TABLE width=600 cellspacing=0 cellpadding=1>\n";

	$o=0;
	while ($people_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><font size=1><a href=\"$PHP_SELF?ADD=34&campaign_id=$row[0]\">$row[0]</a></td>";
		echo "<td><font size=1> $row[1] </td>";
		echo "<td><font size=1> $row[2]</td>";
		echo "<td><font size=1> $row[3]</td><td><font size=1>$row[4]</td><td><font size=1>$row[5]</td>";
		echo "<td><font size=1> $row[6]</td><td><font size=1>$row[7]</td><td><font size=1> &nbsp;</td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=31&campaign_id=$row[0]\">MODIFY</a></td></tr>\n";
		$o++;
	}

echo "</TABLE></center>\n";
}


######################
# ADD=100 display all lists
######################
if ($ADD==100)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_lists order by list_id";
	$rslt=mysql_query($stmt, $link);
	$people_to_print = mysql_num_rows($rslt);

echo "<br>LIST LISTINGS:\n";
echo "<center><TABLE width=600 cellspacing=0 cellpadding=1>\n";

	$o=0;
	while ($people_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><font size=1>$row[0]</td>";
		echo "<td><font size=1> $row[1]</td>";
		echo "<td><font size=1> $row[2]</td><td><font size=1>$row[4]</td><td><font size=1>$row[5]</td>";
		echo "<td><font size=1> $row[3]</td><td><font size=1>$row[7]</td><td><font size=1> &nbsp;</td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=311&list_id=$row[0]\">MODIFY</a></td></tr>\n";
		$o++;
	}

echo "</TABLE></center>\n";
}



######################
# ADD=1000 display all inbound groups
######################
if ($ADD==1000)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_inbound_groups order by group_id";
	$rslt=mysql_query($stmt, $link);
	$people_to_print = mysql_num_rows($rslt);

echo "<br>INBOUND GROUP LISTINGS:\n";
echo "<center><TABLE width=600 cellspacing=0 cellpadding=1>\n";

	$o=0;
	while ($people_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><font size=1>$row[0]</td>";
		echo "<td><font size=1> $row[1]</td>";
		echo "<td><font size=1> $row[3]</td>";
		echo "<td><font size=1> $row[5]</td>";
		echo "<td bgcolor=\"$row[2]\"><font size=1> &nbsp;</td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=3111&group_id=$row[0]\">MODIFY</a></td></tr>\n";
		$o++;
	}

echo "</TABLE></center>\n";
}


######################
# ADD=10000 display all remote agents
######################
if ($ADD==10000)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_remote_agents order by server_ip,campaign_id,user_start";
	$rslt=mysql_query($stmt, $link);
	$people_to_print = mysql_num_rows($rslt);

echo "<br>REMOTE AGENTS LISTINGS:\n";
echo "<center><TABLE width=600 cellspacing=0 cellpadding=1>\n";

	$o=0;
	while ($people_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><font size=1>$row[1]</td>";
		echo "<td><font size=1> $row[2]</td>";
		echo "<td><font size=1> $row[3]</td>";
		echo "<td><font size=1> $row[4]</td>";
		echo "<td><font size=1> $row[5]</td>";
		echo "<td><font size=1> $row[6]</td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=31111&remote_agent_id=$row[0]\">MODIFY</a></td></tr>\n";
		$o++;
	}

echo "</TABLE></center>\n";
}


######################
# ADD=100000 display all user groups
######################
if ($ADD==100000)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_user_groups order by user_group";
	$rslt=mysql_query($stmt, $link);
	$people_to_print = mysql_num_rows($rslt);

echo "<br>USER GROUPS LISTINGS:\n";
echo "<center><TABLE width=600 cellspacing=0 cellpadding=1>\n";

	$o=0;
	while ($people_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><font size=1>$row[0]</td>";
		echo "<td><font size=1> $row[1]</td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=311111&user_group=$row[0]\">MODIFY</a></td></tr>\n";
		$o++;
	}

echo "</TABLE></center>\n";
}


######################
# ADD=1000000 display all scripts
######################
if ($ADD==1000000)
{
echo "<TABLE><TR><TD>\n";
	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_scripts order by script_id";
	$rslt=mysql_query($stmt, $link);
	$people_to_print = mysql_num_rows($rslt);

echo "<br>SCRIPTS LISTINGS:\n";
echo "<center><TABLE width=600 cellspacing=0 cellpadding=1>\n";

	$o=0;
	while ($people_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><font size=1>$row[0]</td>";
		echo "<td><font size=1> $row[1]</td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=3111111&script_id=$row[0]\">MODIFY</a></td></tr>\n";
		$o++;
	}

echo "</TABLE></center>\n";
}


######################
# ADD=10000000 display all filters
######################
if ($ADD==10000000)
{
echo "<TABLE><TR><TD>\n";

	echo "<FONT FACE=\"ARIAL,HELVETICA\" COLOR=BLACK SIZE=2>";

	$stmt="SELECT * from vicidial_lead_filters order by lead_filter_id";
	$rslt=mysql_query($stmt, $link);
	$filters_to_print = mysql_num_rows($rslt);

echo "<br>LEAD FILTER LISTINGS:\n";
echo "<center><TABLE width=600 cellspacing=0 cellpadding=1>\n";

	$o=0;
	while ($filters_to_print > $o) {
		$row=mysql_fetch_row($rslt);
		if (eregi("1$|3$|5$|7$|9$", $o))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}
		echo "<tr $bgcolor><td><font size=1>$row[0]</td>";
		echo "<td><font size=1> $row[1]</td>";
		echo "<td><font size=1><a href=\"$PHP_SELF?ADD=31111111&lead_filter_id=$row[0]\">MODIFY</a></td></tr>\n";
		$o++;
	}

echo "</TABLE></center>\n";
}




echo "</TD></TR></TABLE></center>\n";

$ENDtime = date("U");

$RUNtime = ($ENDtime - $STARTtime);

echo "\n\n\n<br><br><br>\n\n";


echo "<font size=0>\n\n\n<br><br><br>\nscript runtime: $RUNtime seconds";
echo " &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; VERSION: $version";
echo " &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; BUILD: $build</font>\n";


?>


</TD></TR><TABLE>
</body>
</html>

<?
	
exit; 

?>
