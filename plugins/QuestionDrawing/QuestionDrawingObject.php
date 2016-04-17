<?php

use ls\pluginmanager\QuestionBase;

class QuestionDrawingObject extends QuestionBase {

	protected static $signature = array('QuestionDrawing');

	public function render($name, $language, $return = false) {error_log('render called 1');

	}
}