$(document).ready(function() {
	$('div#gen_popup').hide()
	$('button#gen_btn').click(function() {
		$('div#gen_popup').toggle()
	})
	$('#all').click(function(ev) {
		ev.preventDefault()
		$('div#gen input[type="checkbox"]').prop({checked: true})
	})
	$('#all').click()
	$('#none').click(function(ev) {
		ev.preventDefault()
		$('div#gen input[type="checkbox"]').prop('checked', false)		
	})

	// Facem un request AJAX pt a prelua date introduse si a le precompleta
	// --> pt ca partea de filtru nu este afisata de View
	
	$.ajax({

		type: "GET",
		url: 'submitted.txt',	// contine un json cu datele introduse
	
		success: function(response) {
			response_obj = JSON.parse(response)
			//console.log(response);
			
			if (response !== 'false') { // prima oara cand intram pe pagina, $input_f este false, fisierul este populat cu stringul "false"
				if (response_obj.search !== false) {
					$('div#filtru input[name="search"]').val(response_obj.search)			
				}
				
				if (response_obj.gen !== false) {
					$('#none').click()	// pt a bifa doar casutele "bifate" la submit, mai intai deselectam, apoi iteram si comparam valorile salvate				
					response_obj.gen.forEach(function(e) {					
						$('div#gen input[type="checkbox"]').each(function(idx, val) {
							if ($(this).val() == e) {
								$(this).prop({checked: true});
								return false; // in loc de break in functia jQuery each
							}						
						})
					})
				} else {
					$('#none').click()
				}
				if (response_obj.voturi !== false) {
					$('div#control input[name="voturi"]').val(response_obj.voturi)
				}
				if (response_obj.nota !== false) {
					$('div#control input[name="nota"]').val(response_obj.nota)
				}
				$('div#control select[name="search_opt"]').val(response_obj.search_opt)
				$('div#gen_control input[name="gen_opt"]').each(function(idx, val) {
					if ($(this).val() == response_obj.gen_opt) {
						$(this).prop('checked', true);
						return false;
					}
				})
				$('div#control select[name="an"]').val(response_obj.an)
				$('div#control select[name="ord"]').val(response_obj.ord)
				if (response_obj.asc_desc !== false) {
					$('div#control input[name="asc_desc"]').prop('checked', true)
				}				
			}
		},
		
		error: function() {			
			alert('Eroare!');			
		}	
	})
	
})






