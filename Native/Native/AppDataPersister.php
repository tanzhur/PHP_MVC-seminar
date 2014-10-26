<?php

use Entities\Note as Note;
use Entities\AppEntityState as EntityState;
use Data\MySQLDataPersister as MySQLDataPersister;

class AppDataPersister extends MySQLDataPersister
{		
	public $data;

	public function loadEntities()
	{
		$this->openConnection();
		//
		mysql_select_db("notes_db");
		$get_notes=mysql_query("SELECT * FROM notes",$this->connection);
		//read notes
		while ($note_res_obj=mysql_fetch_object($get_notes)) 
		{
			$id=$note_res_obj->id;
			$title=$note_res_obj->title;
			$body=$note_res_obj->body;
			$postdate=$note_res_obj->postdate;
			$new_note=new Note($id,$title,$body,$postdate);
			$this->data->addEntity($new_note,false);
		}
		//
		$this->closeConnection();
	}

	private function insertNote($note)
	{
		//escape data
		$esc_title=addslashes($note->title);
		$esc_body=addslashes($note->body);
		$esc_postdate=addslashes($note->postdate);
		$query_string=sprintf("INSERT INTO notes(title,body,postdate)VALUES('%s','%s','%s');",$esc_title,$esc_body,$esc_postdate);
		//execute query
		mysql_query($query_string,$this->connection);
	}

	public function deleteNote($note)
	{
		$query_string=sprintf("DELETE FROM notes WHERE id=%s",$note->getId());
		//execute query
		mysql_query($query_string,$this->connection);	
	}

	public function updateNote($note)
	{
		$esc_title=addslashes($note->title);
		$esc_body=addslashes($note->body);
		$esc_postdate=addslashes($note->postdate);
		//
		$query_string=sprintf("UPDATE notes SET title='%s', body='%s', postdate='%s' WHERE id=%s",$esc_title,$esc_body,$esc_postdate,$note->getId());
		//execute query
		mysql_query($query_string,$this->connection);	
	}

	public function saveEntities()
	{
		$this->openConnection();
		mysql_select_db("notes_db");
		//var_dump($this->data);
		//
		$entities_collection=$this->data->getEntities();
		foreach ($entities_collection as $coll_type => $collection) 
		{
			foreach($collection as $id=>$item)
			{
				//var_dump($item);
				if($coll_type==Note::$ENTITY_TYPE)
				{
					switch($item->getState())
					{
						case EntityState::Inserted:
							//echo "to insert...";
							$this->insertNote($item);
						break;
						case EntityState::Updated:
							$this->updateNote($item);
						break;
						case EntityState::Deleted:
							$this->deleteNote($item);
						break;
					}
				}
			}
		}
		//
		$this->closeConnection();
	}
}	

?>