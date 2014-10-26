<?php
	class budget extends DataMapper
	{
		//table property
		var $table="budgets";	
		
		//autopopulate
		var $auto_populate_has_many = TRUE;
		
		//relations
		
		var $has_many = array("spending");
		
		//validation rules
		var $validation=array(
			"title"=>
			array(
				"label"=>"title",
				"rules"=>array("required","trim","unique","min_length"=>5,"max_length"=>120)
			),
			"saldo"=>
			array(
				"label"=>"saldo",
				"rules"=>array("required",'numeric')
			)
		);
		
		
		/**
		* Constructor function for a new budget
		*
		* @access  public 
		* @param   budgets's title(not required)
		* @param   budgets's saldo(not required)
		*/			
		public function __construct($title="",$saldo="0.00")
		{
			parent::__construct();
			$this->title=$title;
			$this->saldo=$saldo;
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