class WSClient {

	constructor()
	{
		this.address = 'wss://rumorsmatrix.com:8080';
	}

	connect()
	{
		console.log('Connecting to server...');
		this.socket = new SimpleWebsocket(this.address);
		this.registerCallbacks();
	}

	registerCallbacks()
	{
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
		this.ticker = setInterval( function() { this.tick(); } , 5000);
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

	connected()
	{
		return ((this.socket !== undefined)
			? this.socket.connected
			: false
		);
	}


	send(message)
	{
		if (this.socket && this.socket.connected === true) {
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
