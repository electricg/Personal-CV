<?php
$template = 'cv-template';
$json = 'data.json';
$ext = '.html';

date_default_timezone_set('Europe/London');

require '../lib/php/mustache.php/src/Mustache/Autoloader.php';
Mustache_Autoloader::register();

// use html files as templates
$options =  array('extension' => $ext);

$mustache = new Mustache_Engine(array(
	'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__), $options)
));

// format date
$mustache->addHelper('month', function($value) { return date('F', strtotime($value)); });
$mustache->addHelper('year',  function($value) { return date('Y', strtotime($value)); });

$tpl = $mustache->loadTemplate($template);

$string = file_get_contents($json);

// format metadata available inside json data
$data['today'] = date("Y-m-d");
$pattern = '|({{@)([\w]+)(}})|';
function replacement($matches) {
    global $data;
    return $data[$matches[2]];
}
$string = preg_replace_callback($pattern, 'replacement', $string);

$json = json_decode($string, true);

// decode newline characters
function d($arr) {
	foreach ($arr as $key => $value) {
		if (gettype($value) == 'array') {
			$arr[$key] = d($value);
		}
		elseif (gettype($value) == 'string') {
			// inserts HTML line breaks before all newlines
			$arr[$key] = nl2br($value, false);
		}
	}
	return $arr;
}
$json = d($json);

$cv = $tpl->render($json);
echo $cv;
?>