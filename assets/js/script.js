const absolutePath = window.location.origin;

$(window).ready(function() {
	$('#track-form').submit(function(e) {
		e.preventDefault();

		var linkCode = $(this).find('input').val();
		
		$.ajax({
			url: absolutePath + '/int/search.php',
			method: 'POST',
			dataType: 'json',
			data: JSON.stringify({
				link_code: linkCode,
			}),
		}).done(function(link) {
			if(link['redirects'] > 1) {
				var redirectsTotal = link['redirects'] + ' redirects';
			} else {
				var redirectsTotal = link['redirects'] + ' redirect';
			}
			
			$('#track-link').html("<div class='d-flex align-items-start flex-column w-100 mt-5'><span class='badge rounded-pill text-bg-primary mb-3' style='font-size: 1rem;'>" + redirectsTotal + " · " + link['created_at'] + "</span><a class='fs-4 mb-1' href='" + link['short_code'] + "'>shortify.com.br/<b>" + link['short_code'] + "</b></a><div class='d-flex justify-content-between w-100'><p class='text-secondary'>" + link['original_url'] + "</p></div></div>");
		}).fail(function() {
			$('#track-link').html("<div class='d-flex justify-content-center text-center w-100 mt-5'><p class='text-secondary fs-5 m-0'>Short link not found :(</p></div>");
		});
	});
});