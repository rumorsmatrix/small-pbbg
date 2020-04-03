<?php

namespace App;
use DateTime;
use Exception;
use Illuminate\Database\DatabaseManager;
use vakata\websocket\Server as WebsocketsServer;

class Server {

	private $websockets = null;
	private $construct_time = 0;
	private $listening_time = 0;
	private $last_tick_time = 0;

	// objects "cached" on the server
	private $users = [];

	// constants
	const TICK_INTERVAL = 5000;

	public function __construct($address = 'ws://127.0.0.1:8080', $cert = null)
	{
		$this->construct_time = time();
		$this->players = [];

		try {
			$this->websockets = new WebsocketsServer($address, $cert);
			$this->registerCallbacks();

		} catch (Exception $e) {
			print_r($e);
			die();
		}
	}


	private function registerCallbacks()
	{

		$this->websockets->validateClient(
			function ($client) {
				return $this->validateClient($client);
			}
		);

		$this->websockets->onConnect(
			function ($client) {
				$this->onConnect($this->users[(int)$client['socket']]);
			}
		);

		$this->websockets->onDisconnect(
			function ($client) {
				$this->onDisconnect($this->users[(int)$client['socket']]);
			}
		);

		$this->websockets->onMessage(
			function ($sender, $message) {
				if (!empty($this->users[(int)$sender['socket']])) {
					$this->onMessage($this->users[(int)$sender['socket']], $message);
				}
			}
		);

		$this->websockets->onTick(
			function () {
				$this->onTick();
			}
		);
	}


	private function validateClient(array $client)
	{
		$this->log("Validating client...");
		if (
			(isset($client['headers']['origin']) && $client['headers']['origin'] === 'https://rumorsmatrix.com')
			&& (null !== ((int)$client['socket']))
			&& (isset($client['cookies']['ws_session']))
		) {
			if (empty($this->users[(int)$client['socket']])) {

				// see if this user exists in the database
				$user = User::where('session', $client['cookies']['ws_session'])->first();

				/** @var $user User */
				$user->setServer($this);

				if ($user) {
					// this user exists, add it to the players in memory
					/** @var Player $player */
					$user->setClient($client);
					$this->users[(int)$client['socket']] = $user;

					$this->log("Accepted connection (added to memory): " . $user->name);
					return true;

				} else {
					// no session/player in the database.
					$this->log("Declined connection: no valid user/session combination.");
					return false;
				}

			} else {

				// this session is already in the users list, so we're happy
				$this->users[(int)$client['socket']]->setClient($client);
				$this->log("Accepted connection (already in memory): " . $this->users[(int)$client['socket']]->name);
				return true;
			}

		} else {
			$this->log("Declined connection.");
			return false;
		}
	}


	private function onConnect(User $user)
	{
		$this->log("Connected: " . $user->name);
		$this->send($user, 'Welcome back!');
	}


	private function onDisconnect(User $user)
	{
		$this->log($user->name . " disconnected.");

		// we have to check, because they might have opened a new socket elsewhere (ie: closed old tab with new one already connected)
		if (isset($this->users[(int)$user->getClient()['socket']])) {
			unset($this->users[(int)$user->getClient()['socket']]);
		}
	}


	private function onMessage(User $player, $message)
	{
		if ($message == "PING") {
			$this->onPing($user);
			return;
		}

		$this->log("Parsing [" . $user->name . "]: " . $message);
		$data = json_decode($message, true);

		// TODO: handle this data!
	}

	private function onTick()
	{
		$mtime = microtime(true) * 10000;

		if ($this->last_tick_time < ($mtime - self::TICK_INTERVAL) ) {
			$this->log('--- server tick');

			// TODO: do something, eh

			$this->last_tick_time = $mtime;
		}
	}


	private function onPing(User $user)
	{
		$this->send($user, "PONG");
		$this->log("Ping/pong with " . $user->name . ' on socket ' . (int)$user->getSocket());
	}


	public function send(User $user, $message)
	{
		if (is_array($message)) $message = json_encode($message);
		$client_socket = $user->getSocket();
		$this->websockets->send($client_socket, $message);
	}


	public function broadcast($message)
	{
		$this->log("---- Broadcasting start");
		foreach ($this->users as $user) {
			$this->send($user, $message);
		}
		$this->log("---- Broadcasting finished");
	}


	public function startListening()
	{
		echo "Listening...\n";
		$this->listening_time = time();
		$this->websockets->run();
	}


	public function getClients()
	{
		$this->websockets->getClients();
	}


	public function log($message)
	{
		if (empty($this->log_file)) {
			echo date('Y-m-d H:i:s') . "\t" . $message . "\n";
			return;
		}
	}

}
