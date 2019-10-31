<?php

class verifyError
{

	public function verifyError($error)
	{
			
	}

	public function __construct()
	{
		if($_GET['error']){
			$this->verifyError($_GET['error']);
		}
	}
}
