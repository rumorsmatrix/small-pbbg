<?php

namespace App\Views;

class Test extends View {

	public function __invoke()
	{
		$content = $this->includeTemplate('bootstrap-header');
		$content .= '<p>Hello, world!</p>';
		$content .= $this->includeTemplate('bootstrap-footer');
		return $content;
	}

}
