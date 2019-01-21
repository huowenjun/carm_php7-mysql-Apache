<?php
namespace car\index\controller;

class Index extends Controller
{
	public function index()
	{
		return $this->fetch('index2');
	}
}
