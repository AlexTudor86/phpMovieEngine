<?php

namespace Controllers;

class Engine {
	
	private $input;
	private $input_f;
	private $conn;
	
	public function __construct() {
		$this->input = !empty($_REQUEST) ? $_REQUEST : false; 
		$this->conn = \Helpers\Database::connect();
		$this->filter();
		file_put_contents('submitted.txt', json_encode($this->input_f)); // retinem datele introduse pt a le afisa in valorile campurilor din div-ul filtru folosind ajax
	}	
	
	private function filter() {
		if (!$this->input) {
			$this->input_f = false;
		} else {
			$this->input_f = array();
			$this->input_f['search'] = $_REQUEST['search'] !== '' ? trim($_REQUEST['search']) : false;
			$this->input_f['search_opt'] = $_REQUEST['search_opt'];
			$this->input_f['gen'] = isset($_REQUEST['gen']) ? $_REQUEST['gen'] : false;
			$this->input_f['gen_opt'] = $_REQUEST['gen_opt'];
			$this->input_f['an'] = $_REQUEST['an'];
			$voturi_filtrat = filter_var($_REQUEST['voturi'], FILTER_VALIDATE_INT);
			$this->input_f['voturi'] = $voturi_filtrat > 0 ? $voturi_filtrat : false;
			$nota_filtrat = filter_var($_REQUEST['nota'], FILTER_VALIDATE_FLOAT);
			$this->input_f['nota'] = $nota_filtrat > 0 && $nota_filtrat < 10 ? $nota_filtrat : false;
			$this->input_f['ord'] = $_REQUEST['ord'];
			$this->input_f['asc_desc'] = isset($_REQUEST['asc_desc']) ? true : false;
		}
		//var_dump($this->input_f);
	}
	
	
	public function display() {
		$model_obj = new \Models\Engine($this->input_f, $this->conn);
		$results_obj = $model_obj->get_results();
		
		$view_obj = new \Views\Engine($results_obj);
		$view_obj->generate_output();	
	}
}