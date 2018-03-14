<?php
$data['telephone'] = '';
$data['email'] = '';
$data['street-address'] = '';
$data['locality'] = '';
$data['postal-code'] = '';

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