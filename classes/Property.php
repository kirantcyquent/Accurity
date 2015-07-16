<?php

class Property{

	public $sq_footage , $bedrooms, $bathrooms, $year_built, $lot_size, $stories, $sq_f, $radius, $age, $l_size;
	public $story, $pool, $basement, $beds_from, $beds_to, $baths_from, $baths_to, $sale_range, $sale_type;


	public function __construct(){
		$this->sq_f = "+/- 20%";
		$this->radius  =  "0.5 Mile";
		$this->age  =  "+/- 5 years";
		$this->l_size  = "+/- 50%";
		$this->story  =  "3";
		$this->pool = "No";
		$this->basement =  "No";
		$this->beds_from =  "2";
		$this->beds_to =  "3";
		$this->baths_from = "2";
		$this->baths_to =  "3";
		$this->sale_range =  "0.3 Months";
		$this->sale_type ="Full Value";
	}

}
?>