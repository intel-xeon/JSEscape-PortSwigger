<?php

function jsEscape($str) {
    $output = '';
    $str = str_split($str);
    for($i=0;$i<count($str);$i++) {
        $chrNum = ord($str[$i]);
        $chr = $str[$i];
        if($chrNum === 226) {
            if(isset($str[$i+1]) && ord($str[$i+1]) === 128) {
                if(isset($str[$i+2]) && ord($str[$i+2]) === 168) {
                    $output .= '\u2028';
                    $i += 2;
                    continue;
                }
                if(isset($str[$i+2]) && ord($str[$i+2]) === 169) {
                    $output .= '\u2029';
                    $i += 2;
                    continue;
                }
            }
        }
        switch($chr) {
            case "'":
            case '"':
            case "\n";
            case "\r";
            case "&";
            case "\\";
            case "<":
            case ">":
                $output .= sprintf("\\u%04x", $chrNum);
            break;
            default:
                $output .= $str[$i];
            break;
    }
    }
    return $output;
}
?>

<html>
<head>
<title>Page Title</title>
</head>
<body>

<h1>Example JS Escape Function</h1>

  <?php
  if(isset($_GET['input'])){
  $input=$_GET['input'];
  echo htmlentities("<script>EscapeOn = '". jsEscape($input)."';</script>", ENT_QUOTES, 'UTF-8');
  echo "<br>";
  echo "<br>";
  echo "<br>";
  echo htmlentities("<script>EscapeOff = '". $input."';</script>", ENT_QUOTES, 'UTF-8');
  echo "<br>";
  echo "<br>";
  echo "<script>EscapeOff = '". $input."';</script>";
  echo "<script>EscapeOn = '". jsEscape($input)."';</script>";
  }
  ?>
  



<?php 
$host=$_SERVER['SERVER_NAME'];
$port=$_SERVER['SERVER_PORT'];
$self=$_SERVER['PHP_SELF'];
echo "<br>";
echo "<br>";
echo "<br>";
echo "Try to call this page with http://$host:$port$self?input='; alert('XSS') // ";
 
 ?>

</body>
</html> 
