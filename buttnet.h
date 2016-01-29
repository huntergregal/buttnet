#ifndef BUTTNET_H_
#define BUTTNET_H_

class buttnet
{
public:
	buttnet(char * _nick, char * _usr, char * _ircServer, char * _ircServerPass, char * _channel, char * _port);
	virtual ~buttnett();

	bool setup;

	void start();
	bool charSearch(char *toSearch, char *searchFor);

private:
	int s; //the socket descriptor

	char *nick;
	char *usr;
	char *ircServer;
	char *ircServerPass;
	char *channel;
	char *port;	

	bool isConnected(char *buf);

	char * timeNow();

	bool sendData(char *msg);

	void sendPong(char *buf);

	void msgHandel(char *buf);
};

#endif /* BUTTNET_H_ */
