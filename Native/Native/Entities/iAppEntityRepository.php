<?php
namespace Entities
{
	interface iAppEntityRepository
	{

		public function getEntities();

		public function addEntity($entity);

		public function deleteEntity($entity);

		public function updateEntity($entity);

		public function loadEntities($load_method);	

		public function saveEntities($save_method);
	}
}	
?>