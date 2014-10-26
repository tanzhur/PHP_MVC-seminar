<?php
class notes extends ORG_Controller
{
	public function __construct()
	{
		parent::__construct();
	}	
	
	//index
	public function index()
	{
		$data=array();
		$qnote=new note();
		$qnote->order_by("publishtime", "desc");
		$qnote->select("id, title, content, publishtime");
		$data["notes"]=$qnote->get();
		//
		$data["title"]=$this->input->post("title");
		$data["content"]=$this->input->post("content");	
		//add forms to aside region	
		$this->WriteViewToRegion("aside","insertnote",$data);
		//
		$this->RenderPage("notes",$data);	
	}
	
	private function redirect_to_index()
	{
		redirect(site_url()."notes/");
	}
		
	public function insert()
	{
		$post_data=$this->input->post();
		//var_dump($post_data);
		$n_title=$post_data["title"];
		$n_content=$post_data["content"];
		if(strlen($n_title)==0 && strlen($n_content)==0)
		{
			$this->redirect_to_index();
			return;
		}
		$note=new note($n_title,$n_content);
		$note->publishtime=date("Y-m-d H:i:s");
		$noteIsValid=$this->Validate($note);
		if($noteIsValid)
		{
			$note->save();
			$this->SendMessage("Note saved.","success");
			$this->redirect_to_index();
			return;
		}	
		//		
		$this->index();
	}
	
	public function delete()
	{
		//
		$noteid=$this->input->get("id");
		$dnote = new note();
		$dnote->where('id',$noteid)->get();
		//use get_by_id
		if(!$dnote->exists())
		{
			$this->SendMessage("Wrong id supplied.","error");
			$this->redirect_to_index();
			return;
		}
		//
		$d_succ=$dnote->delete();
		if($d_succ)
		{
			$this->SendMessage("Note deleted.","success");
			$this->redirect_to_index();
			return;
		}
		else
		{
			$this->SendMessage("Note deletion failed.","error");
		}
		//
		$this->index();
	}
	
}
?>
