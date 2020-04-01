<?php

namespace App\Views;

class Test extends View {

	public function __invoke()
	{
		$content = $this->includeTemplate('bootstrap-header');
		$content .= '<p>Hello, world!</p>';

		$content .= '<pre>';
		$content .= print_r($this->user, true);
		$content .= '</pre>';

		$content .= $this->includeTemplate('bootstrap-footer');
		return $content;
	}

}
