<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


/**
 * Class User
 */
class User extends Model {

	private $client = null;
	private $server = null;

    public function setClient($client) {
        $this->client = $client;
    }

    public function getClient() {
        return $this->client;
    }

    public function getSocket() {
        return $this->getClient()['socket'];
    }

	public function getSocketID()
	{
		return (int)$this->getSocket();
	}

    public function setServer(Server $server) {
        $this->server = $server;
    }

}
