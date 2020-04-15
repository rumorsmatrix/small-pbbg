<?php

namespace App\Controllers\Ajax;

class Content extends \App\Controllers\Controller {

	public function dashboard()
	{
		return $this->template('officer-cards');
	}

	public function black_market()
	{
		return $this->template('black-market');
	}


	public function test()
	{
		return (($this->user->id === 1)
			? $this->template('test')
			: 404
		);
	}

}
