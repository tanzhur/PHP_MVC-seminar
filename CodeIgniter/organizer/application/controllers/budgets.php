<?php
class budgets extends ORG_Controller
{
	public function __construct()
	{
		parent::__construct();
	}	
	
	//index
	public function index()
	{
		$data=array();
		$qbudget=new budget();
		$qbudget->order_by("publishtime", "desc");
		$qbudget->select("id, title, saldo");
		$data["budgets"]=$qbudget->get();
		$data["title"]=$this->input->post("title");
		$data["saldo"]=$this->input->post("saldo");
		//add forms to aside region	
		$this->WriteViewToRegion("aside","insertbudget",$data);
		//
		$this->RenderPage("budgets",$data);	
	}
	
	private function redirect_to_home()
	{
		redirect(site_url()."budgets/");
	}

	public function insert()
	{
		$post_data=$this->input->post();
		//var_dump($post_data);
		$n_title=$post_data["title"];
		$n_saldo=$post_data["saldo"];
		//WTF
		if(strlen($n_title)==0 && strlen($n_saldo)==0)
		{
			$this->redirect_to_home();
			return;
		}
		//
		$budget=new budget($n_title,$n_saldo);				
		$budgetIsValid=$this->Validate($budget);
		if($budgetIsValid)
		{
			$budget->publishtime=date("Y-m-d H:i:s");
			$budget->save();
			$this->SendMessage("New budget created.","success");
			$this->redirect_to_home();
			return;
		}	
		//		
		$this->index();
	}
	
	public function delete()
	{
		//
		$bid=$this->input->get("id");
		$dbudget = new budget();
		$dbudget->where('id',$bid)->get();
		if(!$dbudget->exists())	
		{
			$this->SendMessage("Wrong id supplied.","error");
			$this->redirect_to_home();
			return;
		}		
		//delete spendings on budget
		foreach($dbudget->spending->all as $spending)
		{
			$spending->delete();
		}
		//
		$d_succ=$dbudget->delete();
		if($d_succ)
		{
			$this->SendMessage("Budget deleted.","success");
			$this->redirect_to_home();
			return;
		}
		else
		{
			$this->SendMessage("Budget deletion failed.","error");
		}
		//
		$this->index();
	}
	
}
?>
