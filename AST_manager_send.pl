#!/usr/bin/perl
#
# AST_manager_send.pl version 0.2
#
# Part of the Asterisk Central Queue System (ACQS)
#
# DESCRIPTION:
# spawns child processes (AST_send_action_child.pl) to execute action commands 
# on the Asterisk manager interface from records in the vicidial_manager table
# of the asterisk database in MySQL that are marked as a status of NEW
#
# SUMMARY:
# This program was designed as the send-only part of the ACQS. It's job is to
# pick NEW actions from the vicidial_manager table and send them to be executed
# by separate child process. This allows for a higher degree of flexibility and
# scalability over just using a single process. Also, this means that a single
# action execution lock cannot bring the entire system down.
# 
# Win32 - ActiveState Perl 5.8.0
# UNIX - Gnome or KDE with Tk/Tcl and perl Tk/Tcl modules loaded
# Both - Net::MySQL, Net::Telnet and Time::HiRes perl modules loaded
#
# For the client program to work in ACQS mode, this program must be running
# 
# For this program to work you need to have the "asterisk" MySQL database 
# created and create the tables listed in the CONF_MySQL.txt file, also make sure
# that the machine running this program has read/write/update/delete access 
# to that database
# 
# In your Asterisk server setup you also need to have several things activated
# and defined. See the CONF_Asterisk.txt file for details
#
# Distributed with no waranty under the GNU Public License
#

# constants
$DB=1;  # Debug flag, set to 0 for no debug messages, On an active system this will generate thousands of lines of output per minute
$US='__';
$MT[0]='';

### begin parsing run-time options ###
if (length($ARGV[0])>1)
{
	$i=0;
	while ($#ARGV >= $i)
	{
	$args = "$args $ARGV[$i]";
	$i++;
	}

	if ($args =~ /--help/i)
	{
	print "allowed run time options:\n  [-q] = quiet\n  [-t] = test\n\n";
	}
	else
	{
		if ($args =~ /-q/i)
		{
		$q=1;
		}
		if ($args =~ /-v/i)
		{
		$V=1;
		print "\n-----VERBOSE -----\n\n";
		}
		if ($args =~ /-t/i)
		{
		$T=1; $TEST=1;
		print "\n-----TESTING -----\n\n";
		}
		if ($args =~ /-sendonlyone/i)
		{
		$sendonlyone=1;
		print "\n-----SEND ONLY ONE COMMAND -----\n\n";
		}
	}
}
else
{
print "no command line options set\n";
}


### Make sure this file is in a libs path or put the absolute path to it
require("/home/cron/AST_SERVER_conf.pl");	# local configuration file


	&get_time_now;

	$event_string='PROGRAM STARTED||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||';
	&event_logger;

#use lib './lib', '../lib';
use Time::HiRes ('gettimeofday','usleep','sleep');  # necessary to have perl sleep command of less than one second
use Net::MySQL;
#use Net::Telnet ();
	  
	my $dbhA = Net::MySQL->new(hostname => "$DB_server", database => "$DB_database", user => "$DB_user", password => "$DB_pass") 
	or 	die "Couldn't connect to database: \n";

	$event_string='LOGGED INTO MYSQL SERVER ON 1 CONNECTION|';
	&event_logger;

$one_day_interval = 90;		# 1 day loops for 3 months
while($one_day_interval > 0)
{


	$endless_loop=86400;		# 2 days at .20 seconds per loop

	while($endless_loop > 0)
	{

	$affected_rows=0;
	$NEW_actions=0;

	$stmtA = "SELECT count(*) from vicidial_manager where server_ip = '$server_ip' and status = 'NEW'";
	$dbhA->query("$stmtA");
	if ($dbhA->has_selected_record)
	   {
		$iter=$dbhA->create_record_iterator;
		$rec_count=0;
		while ( $record = $iter->each)
			{
			if($DB){print STDERR $record->[0],"|", $record->[1],"\n";}
			$NEW_actions	 = "$record->[0]";
			}
	   }

	if (!$NEW_actions)
		{
		$affected_rows=0;
		}
	else
		{
		$stmtA = "UPDATE vicidial_manager set status='QUEUE' where server_ip = '$server_ip' and status = 'NEW' order by entry_date limit 1";
	   $dbhA->query("$stmtA");
		$affected_rows = $dbhA->get_affected_rows_length;
		#	print STDERR "rows updated to QUEUE: |$affected_rows|\n";
		}


	if ($affected_rows)
		{
		$stmtA = "SELECT * FROM vicidial_manager where server_ip = '$server_ip' and status = 'QUEUE' order by entry_date desc limit 1";
					$event_string="SQL_QUERY|$stmtA|";
				&event_logger;

		$dbhA->query("$stmtA");
		if ($dbhA->has_selected_record)
		   {
			$iter=$dbhA->create_record_iterator;
			$rec_count=0;
			while ( $record = $iter->each)
				{
				if($DB){print STDERR $record->[0],"|", $record->[1],"\n";}
				$man_id		 = "$record->[0]";
				$uniqueid	 = "$record->[1]";
				$channel	 = "$record->[6]";
				$action		 = "$record->[7]";
				$callid		 = "$record->[8]";
				$cmd_line_b	 = "$record->[9]";
				$cmd_line_c	 = "$record->[10]";
				$cmd_line_d	 = "$record->[11]";
				$cmd_line_e	 = "$record->[12]";
				$cmd_line_f	 = "$record->[13]";
				$cmd_line_g	 = "$record->[14]";
				$cmd_line_h	 = "$record->[15]";
				$cmd_line_i	 = "$record->[16]";
				$cmd_line_j	 = "$record->[17]";
				$cmd_line_k	 = "$record->[18]";

				$originate_command  = '';
				$originate_command .= "Action: $action\n";
				if (length($cmd_line_b)>3) {$originate_command .= "$cmd_line_b\n";}
				if (length($cmd_line_c)>3) {$originate_command .= "$cmd_line_c\n";}
				if (length($cmd_line_d)>3) {$originate_command .= "$cmd_line_d\n";}
				if (length($cmd_line_e)>3) {$originate_command .= "$cmd_line_e\n";}
				if (length($cmd_line_f)>3) {$originate_command .= "$cmd_line_f\n";}
				if (length($cmd_line_g)>3) {$originate_command .= "$cmd_line_g\n";}
				if (length($cmd_line_h)>3) {$originate_command .= "$cmd_line_h\n";}
				if (length($cmd_line_i)>3) {$originate_command .= "$cmd_line_i\n";}
				if (length($cmd_line_j)>3) {$originate_command .= "$cmd_line_j\n";}
				if (length($cmd_line_k)>3) {$originate_command .= "$cmd_line_k\n";}
				$originate_command .= "\n";

				$SENDNOW=1;
				if ($originate_command =~ /Action: Hangup|Action: Redirect/)
					{
					$SENDNOW=0;
					if($DB){print STDERR "\n|checking for dead call before executing|$callid|$uniqueid|\n";}
					$dbhA->query("SELECT count(*) FROM vicidial_manager where server_ip = '$server_ip' and callerid='$callid' and status = 'DEAD'");
					   if ($dbhA->has_selected_record)
					   {
					   $iter=$dbhA->create_record_iterator;
						 $rec_countH=0;
						   while ( $record = $iter->each)
						   {
						   $rec_countH = "$record->[0]";
						   } 
						if (!$rec_countH){$SENDNOW=1;}
						else 
							{
							if($DB){print STDERR "\n|not sending command line is dead|$callid|$uniqueid|\n";}
							}
					   }

					}

					$event_string="----BEGIN NEW COMMAND----\n$originate_command----END NEW COMMAND----\n";
				&event_logger;

				if ($SENDNOW)
					{
	#				$tn->buffer_empty;

					system("/home/cron/AST_send_action_child.pl --data1=$man_id >> /home/cron/action.$action_log_date \&");

					$stmtA = "UPDATE vicidial_manager set status='SENT' where man_id='$man_id'";
						if($DB){print STDERR "\n|$stmtA|\n";}
					$dbhA->query($stmtA)  or die  "Couldn't execute query:\n";

						$event_string="SQL_QUERY|$stmtA|";
					&event_logger;
					}
				else
					{
					$stmtA = "UPDATE vicidial_manager set status='DEAD' where man_id='$man_id'";
						if($DB){print STDERR "\n|$stmtA|\n";}
					$dbhA->query($stmtA)  or die  "Couldn't execute query:\n";
						$event_string="COMMAND NOT SEND SQL_QUERY|$stmtA|";
					&event_logger;
					}

				}
		   }

		}

	if ($affected_rows)
		{
		### sleep for 10 hundredths of a second
		usleep(1*100*1000);
		}
	else
		{
		### sleep for 20 hundredths of a second
		usleep(1*200*1000);
		}

	$endless_loop--;
		if($DB){print STDERR "loop counter: |$endless_loop|\r";}

		### putting a blank file called "sendmgr.kill" in a directory will automatically safely kill this program
		if ( (-e '/home/cron/sendmgr.kill') or ($sendonlyone) )
			{
			unlink('/home/cron/sendmgr.kill');
			$endless_loop=0;
			$one_day_interval=0;
			print "\nPROCESS KILLED MANUALLY... EXITING\n\n";
			}

		if ($endless_loop =~ /00$/)
			{
				&get_time_now;

			@psoutput = `/bin/ps -f --no-headers -A`;

			$running_listen = 0;

			$i=0;
			foreach (@psoutput)
			{
				chomp($psoutput[$i]);

			@psline = split(/\/usr\/bin\/perl /,$psoutput[$i]);

			if ($psline[1] =~ /AST_manager_li/) {$running_listen++;}

			$i++;
			}

			if (!$running_listen) {$sendonlyone++;}

			if($DB){print "checking to see if listener is dead |$sendonlyone|$running_listen|\n";}
			}


	}


		if($DB){print "DONE... Exiting... Goodbye... See you later... Not really, initiating next loop...$one_day_interval left\n";}

	$one_day_interval--;

}

		$event_string='CLOSING DB CONNECTION|';
		&event_logger;


	$dbhA->close;


	if($DB){print "DONE... Exiting... Goodbye... See you later... Really I mean it this time\n";}


exit;







sub get_time_now	#get the current date and time and epoch for logging call lengths and datetimes
{
($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime(time);
$year = ($year + 1900);
$mon++;
if ($mon < 10) {$mon = "0$mon";}
if ($mday < 10) {$mday = "0$mday";}
if ($hour < 10) {$Fhour = "0$hour";}
if ($min < 10) {$min = "0$min";}
if ($sec < 10) {$sec = "0$sec";}

$now_date_epoch = time();
$now_date = "$year-$mon-$mday $hour:$min:$sec";
$action_log_date = "$year-$mon-$mday";
}





sub event_logger {
	### open the log file for writing ###
	open(Lout, ">>$MSLOGfile")
			|| die "Can't open $MSLOGfile: $!\n";

	print Lout "$now_date|$event_string|\n";

	close(Lout);

$event_string='';
}
