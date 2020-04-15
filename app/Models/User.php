<?php

namespace App\Models;
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

    public function setServer(\App\Server $server) {
        $this->server = $server;
    }

	private function sessions()
	{
		return $this->hasMany('App\Models\Session');
    }

	public function getSessions()
	{
		return $this->sessions()->get();
	}

	private function officers()
	{
		return $this->hasMany('App\Models\Officer');
    }

	public function getOfficers()
	{
		return $this->officers()->get();
	}

}
