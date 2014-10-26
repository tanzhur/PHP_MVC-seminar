<?php
class task extends DataMapper
{
		//table property
		var $table="tasks";	
		
		//validation rules
		var $validation=array(
			"title"=>
			array(
				"label"=>"title",
				"rules"=>array("required","trim","min_length"=>5,"max_length"=>120)
			),
			"priority"=>
			array(
				"label"=>"priority",
				"rules"=>array("required",'numeric')
			)
		);
		
		public function __construct($title="",$content="",$priority=0)
		{
			parent::__construct();
			$this->title=$title;
			$this->content=$content;
			$this->priority=$priority;
		}
		
		public function PriorityToColor($min,$max)
		{
			if($this->status==1)
			{
				return "rgb(0,255,0)";
			}
			$dR=$max-($this->priority);
			$dL=($this->priority)-$min;
			$all=$max-$min;
			$R=230;
			$G=230;
			if($all!=0)
			{
				$B=(int)(($dL/$all)*255);
				$R=(int)(($dR/$all)*255);
			}
			return "rgb($R,0,$B)";
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