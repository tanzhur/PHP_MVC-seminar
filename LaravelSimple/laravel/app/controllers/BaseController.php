<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
	
	public $layout="common.layout";
	
	public function RenderView($content_view,$data)
	{
		//assign some values for the layout view
		$this->layout->title=(isset($data["title"]))?$data["title"]:"Home";
		//assign views
		$this->layout->header=View::make('common.header',$data);
		$this->layout->content=View::make($content_view,$data);
		$this->layout->footer=View::make('common.footer',$data);
	}
}
