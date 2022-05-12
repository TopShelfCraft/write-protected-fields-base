<?php
namespace TopShelfCraft\WriteProtectedFields\base;

use Craft;
use craft\base\Field;
use craft\events\DefineBehaviorsEvent;
use yii\base\Event;
use yii\base\Module;

class WriteProtectedFieldsBase extends Module
{

	/**
	 * @var Settings
	 */
	private $_settings;

	public function init()
	{

		Craft::setAlias('@TopShelfCraft/WriteProtectedFields/base', __DIR__);

		parent::init();

		Event::on(
			Field::class,
			Field::EVENT_DEFINE_BEHAVIORS,
			function(DefineBehaviorsEvent $event)
			{
				$event->behaviors['writeProtectedFields'] = FieldBehavior::class;
			}
		);

	}

	public function getSettings(): Settings
	{
		if (!$this->_settings)
		{
			$fileConfig = Craft::$app->config->getConfigFromFile($this->id);
			$this->_settings = Craft::configure(new Settings(), $fileConfig);
		}
		return $this->_settings;
	}

}
