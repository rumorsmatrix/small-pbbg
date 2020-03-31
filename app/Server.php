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
	private $action_queue = null;

	// objects "cached" on the server
	private $players = [];

	// constants
	const TICK_INTERVAL = 5000;

	public function __construct($address = 'ws://127.0.0.1:8080', $cert = null) {
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


	private function registerCallbacks() {

		$this->websockets->validateClient(
			function ($client) {
				return $this->validateClient($client);
			}
		);

		$this->websockets->onConnect(
			function ($client) {
				$this->onConnect($this->players[(int)$client['socket']]);
			}
		);

		$this->websockets->onDisconnect(
			function ($client) {
				$this->onDisconnect($this->players[(int)$client['socket']]);
			}
		);

		$this->websockets->onMessage(
			function ($sender, $message) {
				if (!empty($this->players[(int)$sender['socket']])) {
					$this->onMessage($this->players[(int)$sender['socket']], $message);
				}
			}
		);

		$this->websockets->onTick(
			function () {
				$this->onTick();
			}
		);

	}


	private function validateClient(array $client) {
		$this->log("Validating client...");
		if (
			(isset($client['headers']['origin']) && $client['headers']['origin'] === 'https://rumorsmatrix.com') &&
			(null !== ((int)$client['socket'])) &&
			(isset($client['cookies']['ws_session']))
		) {

			if (empty($this->players[(int)$client['socket']])) {

				// see if this player exists in the database
				$player = Player::where('session', $client['cookies']['ws_session'])->first();

				/** @var $player Player */
				$player->setServer($this);

				if ($player) {
					// this player exists, add it to the players in memory
					/** @var Player $player */
					$player->setClient($client);
					$this->players[(int)$client['socket']] = $player;

					$this->log("Accepted connection (added to memory): " . $player->name);
					return true;

				} else {
					// no session/player in the database.
					$this->log("Declined connection: no valid player/session combination.");
					return false;
				}

			} else {

				// this session is already in the players list, so we're happy
				$this->players[(int)$client['socket']]->setClient($client);
				$this->log("Accepted connection (already in memory): " . $this->players[(int)$client['socket']]->name );
				return true;
			}

		} else {
			$this->log("Declined connection.");
			return false;
		}
	}


	private function onConnect(Player $player) {
		$this->log("Connected: " . $player->name);

		// send the player's current location to them
		$location = $player->getCurrentLocation();
		$location->setPlayerPresent($player);
		$player->emote('materialises from the void.');
		$this->send($player, 'Welcome back!');

		$player->lookAtLocation();
	}


	private function onDisconnect(Player $player) {
		$this->log($player->name . " disconnected.");
		$player->emote('fades away into the void.');

		// we have to check, because they might have opened a new socket elsewhere (ie: closed old tab with new one already connected)
		if (isset($this->players[(int)$player->getClient()['socket']])) {
			unset($this->players[(int)$player->getClient()['socket']]);
		}
	}


	private function onMessage(Player $player, $message) {
		if ($message == "PING") {
			$this->onPing($player);
			return;
		}

		$this->log("Parsing [" . $player->name . "]: " . $message);
		$data = json_decode($message, true);
		Parser::handle($data, $player, $this);
	}


	private function onTick() {
		$mtime = microtime(true) * 10000;

		if ($this->last_tick_time < ($mtime - self::TICK_INTERVAL) ) {
			$this->log('--- server tick');

			$this->last_tick_time = $mtime;
		}
	}


	private function onPing(Entity $player) {
		$this->send($player, "PONG");
		$this->log("Ping/pong with " . $player->name . ' on socket ' . (int)$player->getSocket());
	}


	public function send(Entity $player, $message) {
		if (!$player instanceof Player) return;

		if (is_array($message)) $message = json_encode($message);
		$client_socket = $player->getSocket();
		$this->websockets->send($client_socket, $message);
	}


	public function broadcast($message) {
		$this->log("---- Broadcasting start");
		foreach ($this->players as $player) {
			$this->send($player, $message);
		}
		$this->log("---- Broadcasting finished");
	}


	public function broadcastToLocation($message, Location $location) {
		$players = $location->getPlayersPresent();
		foreach ($players as $player) {
			$this->send($player, $message);
		}
	}


	public function startListening() {
		echo "Listening...\n";
		$this->listening_time = time();
		$this->websockets->run();
	}


	public function getClients() {
		$this->websockets->getClients();
	}


	public function log($message) {
		if (empty($this->log_file)) {
			echo date('Y-m-d H:i:s') . "\t" . $message . "\n";
			return;
		}
	}


}
