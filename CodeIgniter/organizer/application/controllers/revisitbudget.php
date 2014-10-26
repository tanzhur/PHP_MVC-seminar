<?php
class revisitbudget extends ORG_Controller
{
	public function __construct()
	{
		parent::__construct();		
	}	
	
	//index
	public function index()
	{
		//
		$bid=$this->input->get("id");	
		$qbudget=new budget();
		$qbudget->select("id, title, saldo");
		$data=array();
		$data["cBudget"]=$qbudget->get_where(array('id'=> $bid));
		if(!$qbudget->exists())
		{
			$this->SendMessage("Wrong id supplied.","error");
			redirect(site_url()."budgets/");
			return;
		}		
		//add forms to aside region	
		$this->WriteViewToRegion("aside","changebudgettitle",$data);
		//
		$this->RenderPage("revisitbudget",$data);	
	}
	
	private function redirect_to_index($bid)
	{
		redirect(site_url()."revisitbudget/?id=".$bid);
	}
	
	public function update()
	{
		$bid=$this->input->get("id");
		//echo $bid;
		$newtitle=$this->input->post("title");
		if(strlen($newtitle)==0)
		{
			$this->redirect_to_index($bid);
			return;
		}
		//var_dump($newtitle);
		$newBudget=new budget();
		$newBudget->get_where(array('id'=> $bid));
		$newBudget->title=$newtitle;		
		if(!$newBudget->exists())
		{
			$this->SendMessage("Wrong id supplied.","error");
			$this->redirect_to_index($bid);
			return;
		}
		//
		$isValid=$this->Validate($newBudget);
		if($isValid)
		{
			$newBudget->save();
			$this->SendMessage("Budget title changed.","success");
			$this->redirect_to_index($bid);
			return;
		}
		//
		$this->index();
	}
	
	public function spend()
	{		
		$bid=$this->input->get("id");
		//
		$label=$this->input->post("label");
		$amount=$this->input->post("amount");
		$type=$this->input->post("type");
		//
		if(strlen($label)==0 && strlen($amount)==0)
		{
			$this->redirect_to_index($bid);
			return;
		}
		//
		$adding=($type=="add")?true:false;
		$spending=new spending($label,$amount,$adding);
		$isSpendingValid=$this->Validate($spending);
		if($isSpendingValid)
		{
			$budget=new budget();			
			$budget->get_where(array("id"=>$bid));
			if(!$budget->exists())
			{
				$this->SendMessage("Wrong id supplied.","error");
				$this->redirect_to_index($bid);
				return;
			}
			$budget->saldo+=($adding)?$amount:-$amount;		
			$spending->publishtime=date("Y-m-d H:i:s");			
			$spending->save($budget);
			$budget->save();
			$this->SendMessage("Budget saldo changed.","success");
			$this->redirect_to_index($bid);
			return;
		}
		//
		$this->index();
	}
	
	public function revertspending()
	{
		$sid=$this->input->get("sid");		
		$spending=new spending();
		$spending->get_where(array("id"=>$sid));
		if(!$spending->exists())
		{
			$this->SendMessage("Wrong id supplied.","error");
			$this->redirect_to_index($this->input->get("id"));
			return;
		}
		$budget=$spending->budget;
		$budget->saldo+=($spending->adding)?-$spending->amount:$spending->amount;
		$budget->save();
		$spending->delete();
		$this->SendMessage("Spending reverted.","success");
		$this->redirect_to_index($this->input->get("id"));
		return;
		//$this->index();
	}
	
}
?>
