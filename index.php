<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Proiect PHP</title>
		<link rel="stylesheet" href="main.css">
		<script src="jquery-3.5.1.min.js"></script>
		<script src="main.js"></script>
	</head>
	
	<body>
		<div id ="header">
			<h1>Movie Engine</h1>
		</div>
		
		<div id="continut">
			<div id="filtru">
				<form autocomplete="off" method="post">					
					<div id="control">
						<div>
							<input type="text" name="search" placeholder="Cauta dupa cuvant cheie"> in
							<select name="search_opt">
								<option value="titlu">Titlu</option>
								<option value="descriere">Descriere</option>
								<option value="titlu_descriere">Titlu, Descriere</option>
							</select>
						</div>						
						<div>
							An:
							<select name="an">
								<option value="all">all</option>
								<option value="< 2000">< 2000</option>
								<option value="> 2000">> 2000</option>
								<option value="2010 - 2020">2010 - 2020</option>
								<option value="2000 - 2010">2000 - 2010</option>
								<option value="1990 - 2000">1990 - 2000</option>
								<option value="1980 - 1990">1980 - 1990</option>
							</select>
						</div>
						<div>
							<button type="button" id="gen_btn">Gen</button>					
						</div>
						<div>
							Nota: <input type="text" name="nota" placeholder="Nota minima 0.0 - 10">
						</div>
						<div>
							Voturi: <input type="text" name="voturi" placeholder="Nr minim de voturi">					
						</div>
						<div>Ordoneaza dupa: 
							<select name="ord">
								<option value="titlu">Titlu</option>
								<option value="an">An</option>
								<option value="voturi">Voturi</option>
								<option value="nota" selected="selected">Nota</option>
							</select>
							asc <input type="checkbox" name="asc_desc">
						</div>
					</div>
					<div id="cauta">
						<input type="submit" value="Cauta">
						<a id="back" href="<?php echo $_SERVER['PHP_SELF'];?>"><img src='art/back.png' alt='back'></a>
					</div>
					<div id="gen_popup">
						<div id="gen_control">
							<div>
								<button id="all">ALL</button><br>
								<button id='none'>NONE</button>
							</div>
							<div>
								<label><input type="radio" name="gen_opt" value="or" checked>OR</label>
								<label><input type="radio" name="gen_opt" value="and">AND</label>
							</div>
						</div>
						<div id="gen">
							<div><label><input type="checkbox" name="gen[]" value="action">Action</label></div>
							<div><label><input type="checkbox" name="gen[]" value="adventure">Adventure</label></div>
							<div><label><input type="checkbox" name="gen[]" value="animation">Animation</label></div>
							<div><label><input type="checkbox" name="gen[]" value="comedy">Comedy</label></div>
							<div><label><input type="checkbox" name="gen[]" value="crime">Crime</label></div>
							<div><label><input type="checkbox" name="gen[]" value="documentary">Documentary</label></div>
							<div><label><input type="checkbox" name="gen[]" value="drama">Drama</label></div>
							<div><label><input type="checkbox" name="gen[]" value="family">Family</label></div>
							<div><label><input type="checkbox" name="gen[]" value="fantasy">Fantasy</label></div>
							<div><label><input type="checkbox" name="gen[]" value="history">History</label></div>
							<div><label><input type="checkbox" name="gen[]" value="horror">Horror</label></div>
							<div><label><input type="checkbox" name="gen[]" value="mistery">Mistery</label></div>
							<div><label><input type="checkbox" name="gen[]" value="music">Music</label></div>
							<div><label><input type="checkbox" name="gen[]" value="romance">Romance</label></div>
							<div><label><input type="checkbox" name="gen[]" value="science fiction">SF</label></div>
							<div><label><input type="checkbox" name="gen[]" value="thriller">Thriller</label></div>
							<div><label><input type="checkbox" name="gen[]" value="tv movie">TV Movie</label></div>
							<div><label><input type="checkbox" name="gen[]" value="war">War</label></div>
							<div><label><input type="checkbox" name="gen[]" value="western">Western</label></div>
						</div>
					</div>
				</form>
			</div>
			<div id="results">
				<?php
					require_once('Helpers/Autoload.php');
					\Helpers\Autoload::run();
					$controller_obj = new \Controllers\Engine;
					$controller_obj->display();
				?>		
			</div>
		</div>
	</body>
</html>