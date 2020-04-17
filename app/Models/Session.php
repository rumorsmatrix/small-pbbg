<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{

	public function getUser()
	{
		return $this->belongsTo('App\Models\User', 'user_id')->get()->first();
	}

}
