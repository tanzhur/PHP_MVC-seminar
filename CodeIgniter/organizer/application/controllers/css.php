<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class Css extends ORG_Controller {

   public function __construct()
   {
    parent::__construct();
   }
   
   public function compile()//$file = FALSE)
   {
		$working_file=$this->input->get("filename");
		$data=array();
		$data["working_file"]="./css/style";
		$data["output"]="none";
		if(isset($working_file) && strlen($working_file)>0)
		{
			//$this->output->cache(999999);
			$config['css_path']  = $working_file.".less";//"./css/$file".".less";
			$config['compress']  = false;    
			$this->load->library('less_css',$config);    
			$this->less_css->parse();	
			$output=$this->less_css->css_string;
			file_put_contents($working_file.".css", $output);//"./css/$file".".css",$this->less_css->css_string);
			//data for view			
			$data["working_file"]=$working_file;
			$data["output"]=$output;
			//echo "Hello there!";	
		}
		//
		$this->RenderPage("lesscompiler",$data);	
   }
  }

  #End of file css.php
  #Location: ./application/controllers/css.php