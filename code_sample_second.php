<!DOCTYPE html>
<html>
  <head>
    <title>Totara Code Sample - Recursive</title>
  </head>
  <body>
    <?php

      function createString($string){
        $string = trim($string);
        if (strlen($string) > 0) {
          return $string."\n";
        } else {
          return $string;
        }
      }

      function wrap($string, $length, $newStringArg) {
        $newString = $newStringArg;
        $subString = substr($string, 0, $length);
        $nextCharAfterSub = substr($string, $length, 1);
        if($newString >= strlen($string)){
          if($newString[strlen($newString) - 1] === PHP_EOL) {
            $newString = substr($newString, 0, strlen($newString) - 1);
          }
          return $newString;
        } else {
          //If next char in from set is space or last char in set is space
          //just concat $substring to $newString
          if($subString[strlen($subString)] === " " || $nextCharAfterSub === " "){
            $subString = createString($subString);
            $newString = $newString.$subString;
            echo $subString."<br>";
          //If first char in next set is not a space, find closest space to left and break there
          } else {
              for ($count = 1; $count <= $length; $count++) {
                if ($count === $length) {
                  //if ($subString[0] === " " && $nextCharAfterSub !== " "){
                    //$subString = $subString.$nextCharAfterSub;
                  //}
                  $subString = createString($subString);
                  $newString = $newString.$subString;
                  echo $subString."<br>";
                } elseif ($subString[$length - $count] === " ") {
                  $subString = createString(substr($subString, 0, $length - $count));
                  $newString = $newString.$subString;
                  echo $subString."<br>";
                  break;
                }
              }
          }
          if (strlen($subString) < $length) {
            $updateString = substr($string, strlen($subString));
          } else {
            $updateString = substr($string, $length);
          }
          return wrap($updateString, $length, $newString);
        }
      }

      $test = wrap("This is a string that I am testing.", 3, "");
      error_log($test);
      if ($test === "Thi\ns\nis\na\nstr\ning\ntha\nt I\nam\ntes\ntin\ng.") {
        error_log("True");
      } else {
        error_log("False");
      }

      /*$test = wrap("This is a string that I am testing.", 7, "");
      error_log($test);
      if ($test === "This is\na\nstring\nthat I\nam\ntestin\ng.") {
        error_log("True");
      } else {
        error_log("False");
      }*/

      /*$test = wrap("This is a string that I am testing.", 15, "");
      error_log($test);
      if ($test === "This is a\nstring that I am\ntesting.") {
        error_log("True");
      } else {
        error_log("False");
      }*/
    ?>
    </body>
</html>