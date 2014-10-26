<?php
class spending extends DataMapper
{
		//table property
		var $table="spendings";
		
		//autopopulate
		var $auto_populate_has_one = TRUE;
		
		//relations
		
		var $has_one = array("budget");
		
		//validation rules
		var $validation=array(
			"label"=>
			array(
				"label"=>"label",
				"rules"=>array("trim","max_length"=>120)
			),
			"amount"=>
			array(
				"label"=>"amount",
				"rules"=>array("required",'numeric')
			)
		);
		
		
		/**
		* Constructor function for a new spending
		*
		* @access  public 
		* @param   spending's label(not required)
		* @param   spending's amount(not required)
		* @param   spending's type(not required)
		*/			
		public function __construct($label="",$amount="0.00",$adding=false)
		{
			parent::__construct();
			$this->label=$label;
			$this->amount=$amount;
			$this->adding=$adding;
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