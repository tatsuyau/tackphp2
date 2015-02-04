<?php
class Human{
	protected $name;
	public function __construct($name){
		$this->name	= $name;
	}
	// MEMO
	public function getName(){
		return $this->name;
	}
}

$eiko	= new Human("瑛子");
echo $eiko->getName();
