<?php
namespace Entities
{

	interface iAppEntity
	{
		public function isValid();

		public function getId();

		public function setState($new_state);

		public function getState();

		public function getEntityType();
	}		
}
?>