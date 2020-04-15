<?php

namespace App\Views;

class Test extends View {

	public function __invoke()
	{
		return $this->includeTemplate('test');
	}

}
