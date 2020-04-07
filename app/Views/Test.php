<?php

namespace App\Views;

class Test extends View {

	public function __invoke()
	{
		$this->page_title = "Test view";
		$this->page_subtitle = "lorem ipsum";

		$content = $this->includeTemplate('bootstrap-header');
		$content .= $this->includeTemplate('test');
		$content .= $this->includeTemplate('bootstrap-footer');
		return $content;
	}

}
