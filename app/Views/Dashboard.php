<?php

namespace App\Views;

class Dashboard extends View {

	public function __invoke()
	{
		$this->page_title = "Duty Roster";
		$this->page_subtitle = "viewing all officers";

		$content = $this->includeTemplate('bootstrap-header');
		$content .= $this->includeTemplate('officer-test');
		$content .= $this->includeTemplate('bootstrap-footer');
		return $content;
	}

}
