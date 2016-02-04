# buttnet
A simple IRC Botnet for linux-based targets

##Features
* !say `<message>`- Echos message back to channel
  * Command output is PM'd back to command issuer
* !cmd `<command>` - Runs command on all bots in channel, or bot PM'd. 
* !udp `<host>` `<port | 0 for random>` `<time>` - UDP flood target
