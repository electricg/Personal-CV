<?php
$data['telephone'] = '07411480415';
$data['email'] = 'giulia.alfonsi@gmail.com';
$data['street-address'] = 'Flat 2, 19 Goldsmid Road';
$data['locality'] = 'Hove';
$data['postal-code'] = 'BN3 1QA';

$open = 'cv-controller.php';
$pattern_private = '|({#)([\w\-]+)(#})|';

// Print doc format
if ($_GET['f'] == 'rtf') {
	$open = 'doc-controller.php';
	$pattern_private = '|(\\\{#)([\w\-]+)(#\\\})|';
}
// Avoid echo from public controller
ob_start();

include $open;

// End of avoid echo from public controller
ob_end_clean();

$cv = preg_replace_callback($pattern_private, 'replacement', $cv);
echo $cv;
?>