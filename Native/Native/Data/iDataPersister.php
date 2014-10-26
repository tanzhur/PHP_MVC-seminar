<?php
namespace Data
{
	interface iDataPersister
	{
		public function loadEntities();

		public function saveEntities();
	}
}
?>