<?php
// Avoid echo from public controller
ob_start();

include 'cv-controller.php';

// End of avoid echo from public controller
ob_end_clean();

$data['telephone'] = '07411480415';
$data['email'] = 'giulia.alfonsi@gmail.com';
$data['street-address'] = '29A Vallance Gardens';
$data['locality'] = 'Hove';
$data['postal-code'] = 'BN3 2DB';

$pattern_private = '|({#)([\w\-]+)(#})|';

$cv = preg_replace_callback($pattern_private, 'replacement', $cv);
echo $cv;
?>