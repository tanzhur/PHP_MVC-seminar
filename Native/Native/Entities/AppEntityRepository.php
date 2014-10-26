<?php
namespace Entities
{
	//exception fix
	use \Exception as Exception;

	class AppEntityRepository implements iAppEntityRepository
	{
		//private $connection;

		//these messages can be moved to a language file...
		const ENTITY_NOT_FOUND="The entity you are trying to access is not found!";
		const ENTITY_EXISTS="The entity you are trying to add, already exists!";
		const ENTITY_COLLECTION_NOT_FOUND="Entity collection not found!";

		public function __construct()
		{
			//$this->connection=$connection;
			$this->entities=array();
		}

		private $entities;		

		//singleton...
		public static function create()
		{
	        static $instance = null;
	        if (null === $instance) {
	            $instance = new static();
	        }
	        
	        return $instance;			
		}

		public function getEntities()
		{
			return $this->entities;
		}

		public function addEntity($entity,$set_state_to_inserted=true)
		{
			$entity_type=$entity->getEntityType();
			
			//create an entity collection, if it dosent exist
			if(!isset($this->entities[$entity_type]))
			{
				$this->entities[$entity_type]=array();
			}

			if($this->entityExists($entity))
			{
				throw new Exception(self::ENTITY_EXISTS);
			}
			if($set_state_to_inserted==true)
			{
				$entity->setState(AppEntityState::Inserted);
			}
			//add the new entity to the entities collection
			$this->entities[$entity_type][$entity->getId()]=$entity;
		}

		public function updateEntity($entity)
		{			
			$this->checkEntityBeforeUpdateOrDelete($entity);
			//update entity
			$entity->setState(AppEntityState::Updated);
			$this->entities[$entity->getEntityType()][$entity->getId()]=$entity;			
		}

		public function deleteEntity($entity)
		{
			$this->checkEntityBeforeUpdateOrDelete($entity);
			//delete entity
			$entity->setState(AppEntityState::Deleted);
			$this->entities[$entity->getEntityType()][$entity->getId()]=$entity;
		}

		public function loadEntities($load_method)
		{
			call_user_func($load_method);
		}

		public function saveEntities($save_method)
		{
			call_user_func($save_method);
		}

		private function checkEntityBeforeUpdateOrDelete($entity)
		{
			if(!$this->entityCollectionExists($entity))
			{
				throw new Exception(self::ENTITY_COLLECTION_NOT_FOUND);
			}
			//
			if(!$this->entityExists($entity))
			{
				throw new Exception(self::ENTITY_NOT_FOUND);
			}
		}

		private function entityCollectionExists($entity)
		{
			$entity_type=$entity->getEntityType();

			//maybe check, if it is array too...
			if(!isset($this->entities[$entity_type]))
			{
				return false;
			}

			return true;
		}

		private function entityExists($entity)
		{
			$entity_type=$entity->getEntityType();
			$entity_id=$entity->getId();

			if(!isset($this->entities[$entity_type][$entity_id]))
			{
				return false;
			}

			return true;
		}		
	}	
}
?>