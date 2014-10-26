<?php
class dashboard extends ORG_Controller
{
	public function __construct()
	{
		parent::__construct();
	}	
	
	//index
	public function index()
	{									
		$this->RenderPage("dashboard");	
	}	
	
}
?>
