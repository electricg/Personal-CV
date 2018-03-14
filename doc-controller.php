<?php
$template = 'cv-template';
$json = 'data.json';
$ext = '.rtf';

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

// decode characters and encode the special ones for rtf
function d($arr) {
  foreach ($arr as $key => $value) {
    if (gettype($value) == 'array') {
      $arr[$key] = d($value);
    }
    elseif (gettype($value) == 'string') {
      $value = iconv('UTF-8', 'CP1256', $value);
      $len = strlen($value);
      $new_value = '';
      for($i = 0; $i <= $len; $i++ ) {
        $o = ord($value[$i]);
        $v = $value[$i];
        // escape characters over code 127
        if ($o > 127) {
          $v = "\'".dechex($o);
        }
        // escape { } \
        if ($o == 123 || $o == 125 || $o == 92) {
          $v = '\\'.$v;
        }
        $new_value .= $v;
      }
      // inserts rtf line breaks before all newlines
      $new_value = str_replace("\n", "\\\n", $new_value);
      $arr[$key] = $new_value;
    }
  }
  return $arr;
}
$json = d($json);

// about section - last item - to avoid printing new line
$c = count($json['about']['items']);
$json['about']['items'][$c - 1]['last'] = true;

$cv = $tpl->render($json);

$file_name = strtolower($json['person']['name'].$json['person']['surname']).'-cv'.$ext;

header('Content-Type: application/rtf');
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"".$file_name."\"");

echo $cv;
?>