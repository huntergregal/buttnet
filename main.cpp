#include <iostream>
#include <string>
#include <ctime>
#include <cstdlib>
#include "buttnet.h"


using namespace std;


int main()
{
	//irc settings
	/*string ircServer = "localhost";
	string ircServerPass = "";
	string channel = "JOIN #butt\r\n";
	string port = "6667";*/

    srand(time(NULL));
	int mutex = (rand() % 1000);
	string nick = "NICK butt_" + std::to_string(mutex) + "\r\n";
	string user = "USER butt_" + std::to_string(mutex) + " butthost buttserv :buttbot" + "\r\n";

	char *ircServerChars = &ircServer[0u];
	char *ircServerPassChars = &ircServerPass[0u];
	char *channelChars = &channel[0u];
	char *portChars = &port[0u];
	char *nickChars = &nick[0u];
	char *userChars = &user[0u];
	
	buttnet butt = buttnet(nickChars,userChars,ircServerChars,ircServerPassChars,channelChars,portChars);
	butt.start();

  return 0;

}
