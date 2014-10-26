<?php
	class note extends DataMapper
	{
		//table property
		var $table="notes";	
		
		//validation rules
		var $validation=array(
			"title"=>
			array(
				"label"=>"title",
				"rules"=>array("required","trim","min_length"=>5,"max_length"=>120)
			)
		);
		
		
		/**
		* Constructor function for a new note
		*
		* @access  public 
		* @param   note's title(not required)
		* @param   notes's content(not required)
		*/			
		public function __construct($title="",$content="")
		{
			parent::__construct();
			$this->title=$title;
			$this->content=$content;
		}
		
		public function IsValid()
		{
			$this->validate();			
			if ($this->valid)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
	}
?>