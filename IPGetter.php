<?php

$var=shell_exec("ipconfig /all");

$var = explode("DNS Servers",explode("Wireless LAN adapter WiFi:",$var)[1])[0];
$bla = explode("Wireless LAN adapter WiFi:",$var);
$lines = explode("\n",$var);

$hashmap = array();
foreach($lines as $line){
	$temp = explode(":",$line);
	if(count($temp) == 2){
		$temp[0] = ltrim($temp[0]," ");
		$temp[0] = rtrim($temp[0]," . ");
		$hashmap[$temp[0]] = $temp[1];
	}
}

$subnetMask = $hashmap['Subnet Mask'];
$ipv4Address = rtrim(rtrim($hashmap['IPv4 Address']),"(Preffered)");

echo "IP je: $ipv4Address, Maska je: $subnetMask.\n";

$deliMaske = explode(".",$subnetMask);
$deli = 0;
foreach($deliMaske as $deliMask){
	if($deliMask == "0"){
		$deli += 1;
	}
}
$ipAddresses = array();
if($deli == 1){
	for($i = 0;$i < 256;$i++){
		$deliIP = explode(".",$ipv4Address);
		$ipv4 = $deliIP[0].".".$deliIP[1].".".$deliIP[2].".".$i;
		$var=shell_exec("ping ".$ipv4." -w 100");
		//$najdi = "Reply from ".$ipv4;
		if(strpos($var, "TTL") !== false){
			//echo $najdi."\n";
			echo $ipv4."\n";
			array_push($ipAddresses,$ipv4);
		} else {
			echo "IP doesn't exist!!!\n";
		}
	}
} else if($deli == 2){
	for($i = 0;$i < 256;$i++){
		for($j = 0;$j < 256;$j++){
			$deliIP = explode(".",$ipv4Address);
			$ipv4 = $deliIP[0].".".$deliIP[1].".".$i.".".$j;
			echo $ipv4."\n";
		}
	}
} else if($deli == 3){
	for($i = 0;$i < 256;$i++){
		for($j = 0;$j < 256;$j++){
			for($k = 0;$k < 256;$k++){
				$deliIP = explode(".",$ipv4Address);
				$ipv4 = $deliIP[0].".".$i.".".$j.".".$k;
				echo $ipv4."\n";
			}
		}
	}
}
echo "Found IP addresses on this network are: \n";
foreach($ipAddresses as $ipaddr){
	echo $ipaddr."\n";
}







?>