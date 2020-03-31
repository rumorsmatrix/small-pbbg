class Client {

	constructor()
	{
		console.log('Connecting to server...');
		this.socket = new SimpleWebsocket('wss://rumorsmatrix.com:8080');

		this.socket.on('connect', this.onConnect );

		this.socket.on('data', function(data) {
			data = data.toString();
			if (data.charAt(0) === "{") {
				data = JSON.parse(data);
				client.onJSONData(data);

			} else {
				client.onStringData(data);
			}
		});

		this.socket.on('close', function() {
			clearInterval(this.ticker);
			console.log("Connection closed.");
		});

		this.socket.on('error', function(err) {
			console.log(err.message.toString());
			if (err.message.includes('connection error to')) console.log("Error connecting to server.");
		});
	}


	onConnect()
	{
		this.ticker = setInterval( function() { client.tick();  } , 5000);
	}


	onJSONData(data)
	{
		console.log(data);
	}


	onStringData(data)
	{
		if (data === 'PING' || data === 'PONG') return;
		console.log(data);
	}


	send(message)
	{
		if (this.socket.connected === true) {
			this.socket.send(message);
		} else {
			return false;
		}
	}


	tick()
	{
		this.send('PING');
	}

}
