<?php

namespace App\Views;

class Login extends View {

	public function __invoke()
	{
		$content = $this->includeTemplate('bootstrap-header')
			. $this->includeTemplate('login')
			. $this->includeTemplate('bootstrap-footer');

		return $content;
	}

}
