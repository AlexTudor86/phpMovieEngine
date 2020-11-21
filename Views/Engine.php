<?php

namespace Views;

class Engine {
	
	private $results_obj;
	
		
	public function __construct($a) {
		$this->results_obj = $a;
	}
	
	public function generate_output() {
		
		$output = '';
		$nr_results = $this->results_obj->rowCount();
		if ($nr_results > 0) {
			if (!isset($this->results_obj->default_q)) {
				$output .= '<p>'.$nr_results.' results</p>';
			}
			$output .= '<table><thead><tr><th>Titlu</th><th>Gen</th><th>An</th>';
			$output .= '<th>Voturi</th><th>Nota</th><th>Descriere</th></tr></thead><tbody>';
			while ($row = $this->results_obj->fetch()) {
				$output .= '<tr><td>'.$row['titlu'].'</td>';
				$output .= '<td>'.$row['gen'].'</td>';
				$output .= '<td>'.$row['an'].'</td>';
				$output .= '<td>'.$row['voturi'].'</td>';
				$output .= '<td>'.$row['nota'].'</td>';
				$output .= '<td>'.$row['descriere'].'</td>';
			}			
			$output .= '</tbody></table>';
		} else {
			$output .= '<p>No results</p>';
		}
		echo $output;		
	}	
}