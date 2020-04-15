<?php

namespace App\Views;

class BlackMarket extends View {

	public function __invoke()
	{

		$content = $this->includeTemplate('bootstrap-header');
		$content .= $this->includeTemplate('black-market');
		$content .= $this->includeTemplate('bootstrap-footer');
		return $content;
	}

}
