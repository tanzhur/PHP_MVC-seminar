<?php
namespace Entities
{
	class Note implements iAppEntity
	{
		public static $ENTITY_TYPE="Notes";

		public function __construct($id,$title="",$body="",$post_date="")
		{
			//init properties and fields
			$this->id=$id;
			$this->title=$title;
			$this->body=$body;
			$this->postdate=$post_date;
			//default state is loaded
			$this->state=AppEntityState::Loaded;
		}

		private $id;
		private $state;

		public $title;

		public $body;

		public $postdate;

		public function getId()
		{
			return $this->id;
		}

		public function getState()
		{
			return $this->state;
		}

		public function setState($new_state)
		{
			$this->state=$new_state;
		}

		public function getEntityType()
		{
			return self::$ENTITY_TYPE;
		}

		public function isValid()
		{
			//do some validation and set valid state
			return true;
		}		
	}
}
?>