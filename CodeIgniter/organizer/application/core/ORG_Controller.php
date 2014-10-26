<?php
class ORG_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}		
	
	/*
    * MESSAGES STUFF    
    */	
	
	/**
    * Show a message on the page
    *
    * @access  protected
    * @param   string  message body	
	* @param   string  type of message, it can be error, warning, success, just message
    * @return  void
    */	
	protected function SendMessage($message,$type="message")
	{
		$this->messages->add($message,$type);		
	}
	
	/**
    * Show all validation errors on the page
    *
    * @access  protected
    * @param   string   error messages 	
    * @return  void
    */	
	protected function SendValidationMessages($messages)
	{
		$type="error";
		foreach($messages as $messageProvoc=>$message)
		{
			$this->messages->add($message,$type);		
		}
	}
	
	/**
    * Show a message on the page
    *
    * @access  protected
    * @param   string  message body	
	* @param   string  id for the message div container element	
	* @param   string  type of message, it can be error, warning, success, just message
    * @return  void
    */	
	protected function SendMessageToDiv($message,$divId,$type="message")
	{
		//work here
	}
	
	/*
    * RENDER PAGES STUFF    
    */	
	
	/**
    * Set the current template for the site
    *
    * @access  protected
    * @param   string  template name	
    * @return  void
    */	
	protected function SetCurrentTemplate($tempalte="default")
	{
		$this->template->set_template($template);
	}	
	
	/**
    * Write a view to a specific region
    *
    * @access  protected
    * @param   string  region name
	* @param   string  name of view to be pushed inside region
	* @param   array  data array used in region 
	* @param   boolean  set to true if you want to refresh 
    * @return  void
    */					
	protected function WriteViewToRegion($regionId,$view,$data=array(),$render=false)
	{		
		$this->template->write_view($regionId,$view,$data);
		//render if needed
		if($render)
		{
			echo $this->template->render();		
		}
	}	
	
	/**
    * Render a view inside the content region
    *
    * @access  protected
    * @param   string  name of view to be pushed inside content region
	* @param   array  data array used in all regions 
    * @return  void
    */	
	protected function RenderPage($view,$data=array())
	{							
		//fill regions
		$this->WriteViewToRegion("header","header",$data);
		$this->WriteViewToRegion("navigation","navigation",$data);
		//handling messages
		$messages_data=array();		
		$messages_data["allMessages"]=array();
		$messages_data["allMessages"] = $this->messages->get();
		$this->WriteViewToRegion("messages","messages",$messages_data);
		$this->WriteViewToRegion("content",$view,$data);
		$this->WriteViewToRegion("footer","footer",$data);
		//at the end render
		echo $this->template->render();		
	}
	
	protected function Validate($obj)
	{
		$IsValid=$obj->IsValid();
		if(!$IsValid)
		{						
			//var_dump($note->error);
			$this->SendValidationMessages($obj->error->all);			
		}
		return $IsValid;
	}
	
}
?>