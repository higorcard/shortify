const absolutePath = window.location.origin;
const hostname = window.location.hostname;

function showAlert(type = 'primary', message) {
	if(!$('body').find('.alert').length) {
		$('body').prepend("<div class='position-fixed z-3 bottom-0 start-50 translate-middle-x mt-3 row alert text-bg-" + type + " shake-animation' role='alert'>" + message + "</div>");

		hideAlert();
	}
}

function hideAlert() {
	$(".alert").delay(3000).fadeTo(800, 0, function() {
		$(this).alert('close');
	});
}

function getLinks() {
	$.ajax({
		url: absolutePath + '/int/get-links.php',
		method: 'POST',
		dataType: 'json',
	}).done(function(links) {
		if(links == 'empty') {
			$('#links-container').html("<div class='d-flex justify-content-center text-center w-100 mt-5'><p class='text-secondary fs-5 m-0'>There are no links to display :(</p></div>");
		} else if(links.length > 0) {
			$('#links-container').html("<ul class='text-start mb-0' style='max-height: 300px; overflow: auto; list-style: none; margin-top: 2rem !important; padding-left: 0;'></ul>");

			links.forEach(function(e) {
				if(e['redirects'] > 1) {
					var redirectsTotal = e['redirects'] + ' redirects';
				} else {
					var redirectsTotal = e['redirects'] + ' redirect';
				}

				var owner = (e['owner'] != null && e['owner'] != '') ? e['owner'] + '/' : '';

				$('#links-container > ul').append("<li class='link-item d-flex flex-column text-secondary fs-5 border-bottom py-3 me-2' data-link-id='" + e['id'] + "'><div class='d-flex justify-content-between'><span class='d-flex'><i class='bi bi-link-45deg d-flex align-items-center me-2' style='height: 30px;'></i><a class='text-dark-emphasis mb-1' style='overflow-wrap: anywhere;' href='" + absolutePath + "/" + owner + e['short_code'] + "' target='_blank'>" +  hostname + "/" + owner + "<b>" + e['short_code'] + "</b></a></span><div class='dropdown' style='position: initial;'><button class='btn p-2 dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'><i class='bi bi-three-dots-vertical' style='font-size: 1.1rem;'></i></button><ul class='dropdown-menu' style='min-width: 7rem;'><li><a class='dropdown-item copy-link-btn'>copy</a></li><li><a class='dropdown-item track-link-btn'>track</a></li><li><a class='dropdown-item edit-link-btn' data-bs-toggle='modal' data-bs-target='#edit-modal'>edit</a></li><li><a class='dropdown-item delete-link-btn' data-bs-toggle='modal' data-bs-target='#delete-modal'>delete</a></li></ul></div></div><p class='mb-0' style='margin-left: 26px;'>" + redirectsTotal + "</p></li>");
			});

			$('#links-container .dropdown-menu').css('margin-left', '-130px');

			$('.copy-link-btn').each(function(e) {
				$(this).click(function() {
					var textToCopy = $(this).parents('.link-item').find('a').attr('href');
			
					var tempInput = $("<input>");
					$("body").append(tempInput);
					tempInput.val(textToCopy).select();
			
					document.execCommand("copy");
			
					tempInput.remove();
	
					showAlert('Copied link!');
				});
			});

			$('.track-link-btn').each(function(e) {
				$(this).click(function() {
					var shortCode = $(this).parents('.link-item').find('a b').text();

					$('#track-form input').val(shortCode);
					$('#track-form').submit();
					$('#card').toggleClass('flipped');
				});
			});

			$('.edit-link-btn').each(function(e) {
				$(this).click(function() {
					var linkId = $(this).parents('.link-item').attr('data-link-id');
					var shortCode = decodeURIComponent($(this).parents('.link-item').find('a b').text()).replaceAll('+', ' ');

					$('#edit-modal').find('input[name=link_id]').val(linkId);
					$('#edit-modal').find('input[name=short_code]').val(shortCode);
				});
			});

			$('.delete-link-btn').each(function(e) {
				$(this).click(function() {
					var linkId = $(this).parents('.link-item').attr('data-link-id');
					
					$('#delete-modal').find('input[name=link_id]').val(linkId);
				});
			});
		}
	});
}

$(window).ready(function() {
	getLinks();
	
	hideAlert();
	
	$(".flip-button").click(function() {
		$("#card").toggleClass("flipped");
	});
	
	$('#shorten-form').submit(function(e) {
		e.preventDefault();

		var inputUrl = $(this).find('input');
		var url = inputUrl.val();

		$('#shorten-code').css('display', 'block');

		$.ajax({
			url: absolutePath + '/int/shorten.php',
			method: 'POST',
			dataType: 'json',
			data: JSON.stringify({
				url: url,
			}),
		}).done(function(short_code) {
			if($('#links-container ul').length > 0 || $('#links-container div').length > 0) {
				$('#shorten-code').css('border-bottom', '1px solid #dee2e6');
				$('#shorten-code').css('padding-bottom', '2rem');
			}

			$('#shorten-code').html("<div class='d-flex align-items-center justify-content-between w-100 mt-5'><a id='finalLink' class='fs-4' href='" + absolutePath + "/" + short_code + "' target='_blank'>" +  hostname + "/<b>" + short_code + "</b></a><button id='copyLink' class='btn'><i class='bi bi-files text-primary fs-4'></i></button></div>");

			inputUrl.val('');

			getLinks();

			showAlert('success', 'Shortened link created!');

			$("#copyLink").click(function() {
				var textToCopy = $("#finalLink").attr('href');
		
				var tempInput = $("<input>");
				$("body").append(tempInput);
				tempInput.val(textToCopy).select();
		
				document.execCommand("copy");
		
				tempInput.remove();

				$('#shorten-code').css('display', 'none');
				
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
			url: absolutePath + '/int/track.php',
			method: 'POST',
			dataType: 'json',
			data: JSON.stringify({
				link_code: linkCode,
			}),
		}).done(function(link) {
			showAlert('Tracked link!');
		
			if(link['redirects_total'] > 1) {
				var redirectsTotal = link['redirects_total'] + ' redirects';
			} else {
				var redirectsTotal = link['redirects_total'] + ' redirect';
			}

			var owner = (link['owner'] != null && link['owner'] != '') ? link['owner'] + '/' : '';
			
			$('#track-link').html("<div class='d-flex align-items-start flex-column text-start w-100 mt-5' style='overflow-wrap: anywhere;'><span class='badge rounded-pill text-bg-primary mb-3' style='font-size: 1rem;'>" + redirectsTotal + " <span class='mx-2'>·</span> " + link['created_at'] + "</span><a class='fs-4 mb-1' href='" + absolutePath + "/" + owner + link['short_code'] + "' target='_blank'>" +  hostname + "/" + owner + "<b>" + link['short_code'] + "</b></a><p class='text-secondary text-start'>" + link['original_url'] + "</p></div>");

			if(link['redirects_total'] > 0) {
				$('#track-link').append("<ul class='text-start mb-0' style='max-height: 300px; overflow: auto; list-style: none; padding-left: 0;'></ul>");

				link['redirects'].forEach(function(e) {
					$('#track-link ul').append("<li class='d-flex align-items-center justify-content-between text-secondary fs-5 border-bottom py-3 me-2'><div><i class='bi bi-box-arrow-up-right me-2'></i>" + e[1] + "</div>" + e[0] + "</li>");
				});
			}
		}).fail(function() {
			$('#track-link').html("<div class='d-flex justify-content-center text-center w-100 mt-5'><p class='text-danger fs-5 m-0'>Short link not found :(</p></div>");
		});
	});

	$('#edit-modal').submit(function(e) {
		e.preventDefault();

		var linkId = $(this).find('input[name=link_id]').val();
		var shortCode = $(this).find('input[name=short_code]').val().replaceAll('/', '-');
		$(this).find('.btn-close').click();

		$.ajax({
			url: absolutePath + '/int/edit-link.php',
			method: 'POST',
			dataType: 'json',
			data: JSON.stringify({
				link_id: linkId,
				short_code: shortCode,
			}),
		}).done(function(response) {
			if(response) {
				getLinks();
	
				showAlert('success', 'Link edited!');
			} else {
				showAlert('danger', 'Fail to edit!');
			}
		});
	});

	$('#delete-modal').submit(function(e) {
		e.preventDefault();

		var linkId = $(this).find('input[name=link_id]').val();
		$(this).find('.btn-close').click();

		$.ajax({
			url: absolutePath + '/int/delete-link.php',
			method: 'POST',
			dataType: 'json',
			data: JSON.stringify({
				link_id: linkId,
			}),
		}).done(function(response) {
			if(response) {
				getLinks();
	
				showAlert('success', 'Link deleted!');
			} else {
				showAlert('danger', 'Fail to delete!');
			}
		});
	});
});