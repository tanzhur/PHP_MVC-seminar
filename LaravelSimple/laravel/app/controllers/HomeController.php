<?php

class HomeController extends BaseController {

	public function showWelcome()
	{
		$data=array(
			'title'=>'Home page'
		);
		
		$this->RenderView('home.hello',$data);
	}

}
