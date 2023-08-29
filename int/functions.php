<?php
	function showAlert($type, $message) {
		echo "<div class='position-fixed z-3 bottom-0 start-50 translate-middle-x mt-3 row alert text-bg-$type shake-animation' role='alert'>$message</div>";
	}
