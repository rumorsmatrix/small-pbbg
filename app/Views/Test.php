<?php

namespace App\Views;

class Test extends View {

	public function __invoke()
	{
		$content = $this->includeTemplate('bootstrap-header')
			. $this->includeTemplate('test')
			. $this->includeTemplate('bootstrap-footer');

		return $content;
	}

}
