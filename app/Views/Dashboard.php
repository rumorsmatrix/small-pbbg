<?php

namespace App\Views;

class Dashboard extends View {

	public function __invoke()
	{
		$this->page_title = "Hello, world";
		$this->page_subtitle = "a subtitle";

		$content = $this->includeTemplate('bootstrap-header');
		$content .= $this->includeTemplate('officer-test');
		$content .= $this->includeTemplate('bootstrap-footer');
		return $content;
	}

}
