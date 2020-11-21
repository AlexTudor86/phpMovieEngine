<?php


namespace Models;

class Engine {
	
	private $input_f;
	private $conn;
	
	public function __construct($a, $b) {
		$this->input_f = $a;
		$this->conn = $b;
	}
	
	public function get_results() {
		
		try {
			if (!$this->input_f) {
				// daca utilizatorul este la prima accesare ($_REQUEST empty), afisam top 10 filme dupa nota care au cel putin 10000 voturi
				$query = "SELECT titlu, gen, an, voturi, nota, descriere FROM filme WHERE voturi >= 10000 ORDER BY nota DESC, voturi DESC LIMIT 10";
				$results = $this->conn->query($query);
				$results->default_q = 1; // pentru prima accesare, ne folosim de aceasta prop pt a nu afisa nr rezultate in view
			} else if ($this->input_f['gen'] === false) { // acoperim cazul particular de eroare pt cand nu sunt genuri selectate / pt a nu mai modifica view-ul
				$query = "SELECT * from filme WHERE 1 = 2"; // va fi totdeauna false, obiectul va fi pasat catre view in continuare
				$results = $this->conn->query($query);
			} else {
				$query = "SELECT titlu, gen, an, voturi, nota, descriere FROM filme WHERE ";
				$query_params = array();
				
				// gen - nu stim cate elemente sunt bifate, iteram peste ele si scriem placeholder in arr de param
				// WHERE (gen like :gen0 OR gen like :gen1 OR ..) AND ...
				// in conditia de gen (intre paranteze) legam subconditiile cu OR sau AND, in fct de $this->input_f['gen_opt']
				$c = count($this->input_f['gen']); // <-- ar fi dat notice / db error daca nu mai faceam else if de dinainte
				if ($c > 1) { $query .= "("; }				
				for ($i = 0; $i < $c; $i++) {
					$query_params[":gen$i"] = '%'.$this->input_f['gen'][$i].'%';
					if ($i == 0) {
						$query .= "gen LIKE :gen$i ";
					} else {
						$query .= $this->input_f['gen_opt']." gen LIKE :gen$i "; // AND|OR gen like :gen$i
					}
				}
				if ($c > 1) { $query .= ") "; }
												
				// search field
				if ($this->input_f['search'] !== false) {
					$query_params[":titlu_descriere"] = '%'.$this->input_f['search'].'%';
					switch ($this->input_f['search_opt']) {
						case 'titlu': $query .= "AND titlu LIKE :titlu_descriere "; break;
						case 'descriere': $query .= "AND descriere LIKE :titlu_descriere "; break;
						case 'titlu_descriere': $query .= "AND (titlu LIKE :titlu_descriere OR descriere LIKE :titlu_descriere) "; break;
					}						
				}
				
				// an field - nu mai avem parametru placeholder (optiune hardcoded)
				switch ($this->input_f['an']) {
					case '< 2000': $query .= "AND an < 2000 "; break;
					case '> 2000': $query .= "AND an > 2000 "; break;
					case '2010 - 2020': $query .= "AND an BETWEEN 2010 AND 2020 "; break;
					case '2000 - 2010': $query .= "AND an BETWEEN 2000 AND 2010 "; break;
					case '1990 - 2000': $query .= "AND an BETWEEN 1990 AND 2000 "; break;
					case '1980 - 1990': $query .= "AND an BETWEEN 1980 AND 1990 "; break;
				}
				
				// nota field - am filtrat deja valoare sa fie integer intre 0 si 10; nu se poate SQLi aici
				if ($this->input_f['nota'] !== false) {
					$query .= "AND nota >= ".$this->input_f['nota']." ";
				}
				// voturi field - idem nota
				if ($this->input_f['voturi'] !== false) {
					$query .= "AND voturi >= ".$this->input_f['voturi']." ";
				}
				
				$query .= "ORDER BY ".$this->input_f['ord']." ";
				$asc_desc = $this->input_f['asc_desc'] === false ? 'DESC' : 'ASC';
				$query .= $asc_desc;				
				
				//var_dump($query);
				//var_dump($query_params);
				
				$results = $this->conn->prepare($query);
				$results->execute($query_params);
			}
			return $results;	
		} catch (\PDOException $e) {
			$date = date('Y-m-d H:i:s');
			$err_str = $date.' ===> '.$e->getMessage();
			file_put_contents('sql_errors.log', $err_str.PHP_EOL, FILE_APPEND);
			die('Database Error');	
		}
	
	}
	
}