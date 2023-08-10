const absolutePath = window.location.origin;

function showAlert(message) {
	if(!$('body').find('.alert').length) {
		$('body').prepend("<div class='position-fixed z-3 bottom-0 start-50 translate-middle-x mt-3 row alert text-bg-primary shake-animation' role='alert'>" + message + "</div>");

		hideAlert();
	}
}

function hideAlert() {
	$(".alert").delay(3000).fadeTo(800, 0, function() {
		$(this).alert('close');
	});
}

$(window).ready(function() {
	hideAlert();
	
	$(".flip-button").click(function() {
		$("#card").toggleClass("flipped");
	});
	
	$('#shorten-form').submit(function(e) {
		e.preventDefault();

		var inputUrl = $(this).find('input');
		var url = inputUrl.val();

		$.ajax({
			url: absolutePath + '/int/shorten.php',
			method: 'POST',
			dataType: 'json',
			data: JSON.stringify({
				url: url,
			}),
		}).done(function(short_code) {
			$('#shorten-code').html("<div class='d-flex align-items-center justify-content-between w-100 mt-5'><a id='finalLink' class='fs-4' href='http://localhost/" + short_code + "' target='_blank'>shortify.com.br/<b>" + short_code + "</b></a><button id='copyLink' class='btn'><i class='bi bi-files text-primary fs-4'></i></button></div>");

			inputUrl.val('');

			showAlert('Shortened link created!');

			$("#copyLink").click(function() {
				var textToCopy = $("#finalLink").attr('href');
		
				var tempInput = $("<input>");
				$("body").append(tempInput);
				tempInput.val(textToCopy).select();
		
				document.execCommand("copy");
		
				tempInput.remove();

				showAlert('Copied link!');
			});
		}).fail(function() {
			$('#shorten-code').html("<div class='d-flex justify-content-center text-center w-100 mt-5'><p class='text-danger fs-5 m-0'>Fail to shorten :/</p></div>");
		});
	});
	
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
			showAlert('Tracked link!');

			if(link['redirectsTotal'] > 1) {
				var redirectsTotal = link['redirectsTotal'] + ' redirects';
			} else {
				var redirectsTotal = link['redirectsTotal'] + ' redirect';
			}
			
			$('#track-link').html("<div class='d-flex align-items-start flex-column w-100 mt-5'><span class='badge rounded-pill text-bg-primary mb-3' style='font-size: 1rem;'>" + redirectsTotal + " <span class='mx-2'>·</span> " + link['created_at'] + "</span><a class='fs-4 mb-1' href='" + link['short_code'] + "'>shortify.com.br/<b>" + link['short_code'] + "</b></a><p class='text-secondary'>" + link['original_url'] + "</p></div>");

			if(link['redirectsTotal'] > 0) {
				$('#track-link').append("<ul class='text-start mb-0' style='max-height: 300px; overflow: auto; list-style: none; padding-left: 0;'></ul>");

				link['redirects'].forEach(function(e) {
					$('#track-link ul').append("<li class='d-flex align-items-center text-secondary fs-5 border-bottom py-3 me-2'><i class='bi bi-box-arrow-up-right me-2'></i> " + e[1] + " <span class='mx-2 px-1'>·</span> " + e[0] + "</li>");
				});
			}
		}).fail(function() {
			$('#track-link').html("<div class='d-flex justify-content-center text-center w-100 mt-5'><p class='text-danger fs-5 m-0'>Short link not found :(</p></div>");
		});
	});
});