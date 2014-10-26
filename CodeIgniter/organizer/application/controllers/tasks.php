<?php
class tasks extends ORG_Controller
{
	public function __construct()
	{
		parent::__construct();		
	}
	
	public function index()
	{
		$data=array();
		//
		$qtask=new task();		
		$qtask->select_min('priority');
		$data["min_p"]=$qtask->get()->priority;
		$qtask->select_max('priority');
		$data["max_p"]=$qtask->get()->priority;
		//
		$qtask->order_by("status asc, priority asc");
		$data["tasks"]=$qtask->get();		
		//add forms to aside region
		$this->WriteViewToRegion("aside","inserttask",$data);
		//
		$this->RenderPage("tasks",$data);
	}
	
	private function redirect_to_index()
	{
		redirect(site_url()."tasks/");
	}
	
	//insert task
	public function insert()
	{		
		$title=$this->input->post("title");
		$content=$this->input->post("content");
		$priority=$this->input->post("priority");
		//
		if(strlen($title)==0 && strlen($content)==0 && strlen($priority)==0)
		{
			$this->redirect_to_index();
			return;
		}
		//
		$itask=new task($title,$content,$priority);
		//
		$taskIsValid=$this->Validate($itask);
		if($taskIsValid)
		{
			$itask->save();
			$this->SendMessage("Task saved.","success");
			$this->redirect_to_index();
			return;
		}
		//
		$this->index();
	}
	
	//change status
	public function status()
	{
		$id=$this->input->get("id");
		$status=$this->input->get("status");
		//
		$qtask=new task();
		$qtask->get_by_id($id);
		$exists=$qtask->exists();
		//
		if((!$exists) || ($status!="0" && $status!="1"))
		{
			$this->SendMessage("Wrong argument supplied","error");
			$this->redirect_to_index();
			return;
		}
		//
		$qtask->status=$status;
		$d_succ=$qtask->save();
		if($d_succ)
		{
			$this->SendMessage("Task status changed.","success");
		}
		else
		{
			$this->SendMessage("Task update failed.","error");
		}
		$this->redirect_to_index();
	}
	
	//delete task
	public function delete()
	{
		//
		$id=$this->input->get("id");
		//
		//var_dump($id);
		$dtask=new task();
		$dtask->get_by_id($id);
		//
		$exists=$dtask->exists();
		if(!$exists)
		{
			$this->SendMessage("Wrong id supplied","error");
			$this->redirect_to_index();
			return;
		}
		//
		$d_succ=$dtask->delete();
		//
		if($d_succ)
		{
			$this->SendMessage("Task deleted.","success");
		}
		else
		{
			$this->SendMessage("Task deletion failed.","error");
		}
		//
		$this->redirect_to_index();	
	}
}
?>