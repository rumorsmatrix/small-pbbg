<?php

namespace App\Views;

class Dashboard extends View {

	public function __invoke()
	{

		$content = $this->includeTemplate('bootstrap-header');
		$content .= $this->includeTemplate('officer-cards');
		$content .= $this->includeTemplate('bootstrap-footer');
		return $content;
	}

}
