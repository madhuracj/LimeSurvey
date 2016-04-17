<?php

Yii::import("application.libraries.PluginManager.Question.*");

class QuestionDrawing extends QuestionPluginBase {

	static protected $description = 'Question: Draw on an image';
	static protected $name = 'Drawing question';

	/**
     *
     * @param PluginManager $pluginManager
     * @param int $responseId Pass a response id to load results.
     */
     public function __construct(PluginManager $manager, $id) {
        parent::__construct($manager, $id);
        $questionTypes[] = 'QuestionDrawingObject';
     }
}