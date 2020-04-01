<?php

namespace App\Views;

class View {

	const template_path = __DIR__ . '/../../templates/';

	public function __construct($data = [])
	{
		foreach ($data as $property => $value) {
			$this->$property = $value;
		}
	}

	public function __invoke()
	{
		return 404;
	}

	public function includeTemplate($template)
	{
		$template_file = self::template_path . $template . '.php';
		if (file_exists($template_file)) {
			ob_start();
			include($template_file);
			$content = ob_get_contents();
			ob_end_clean();
			return $content;

		} else {
			throw new \Exception("Template file " . $template . " not found");
		}
	}

}
