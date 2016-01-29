#include <iostream>
#include <string>
#include <ctime>
#include <cstdlib>
#include "buttnet.h"


using namespace std;


int main()
{
	//irc settings
	string ircServer = "localhost";
	string ircServerPass = "";
	string channel = "JOIN #butt\r\n";
	string port = "6667";

	srand(time(NULL));
	int mutex = (rand() % 1000);
	string nick = "NICK butt_" + to_string(mutex) + "\r\n";
	string user = "USER butt_" + to_string(mutex) + "\r\n";
	
	buttnet butt = buttnet(nick,user,ircServer,ircServerPass,channel,port);
	butt.start();

  return 0;

}
