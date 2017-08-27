<!DOCTYPE html>
<html>
  <head>
    <title>Totara Code Sample - Recursive</title>
  </head>
  <body>
    <?php

      function createString($string){
        $string = trim($string, " ");
        if (strlen($string) > 0 && substr($string, -1) !== PHP_EOL) {
          return $string."\n";
        } else {
          return $string;
        }
      }

      function recursiveWrap($string, $length, $newStringArg) {
        $newString = $newStringArg;
        if (strlen($string) >= $length) {
          $subString = substr($string, 0, $length);
          if (strlen($string) > strlen($subString)) {
            $nextChar = $string[$length];
          } else {
            $nextChar = NULL;
          }
        } else {
          $subString = $string;
          $nextChar = NULL;
        }
        if(strlen($string) < $length){
          $subString = createString($subString);
          $newString = $newString.$subString;
          echo $subString;
          if($newString[strlen($newString) - 1] === PHP_EOL) {
            $newString = substr($newString, 0, strlen($newString) - 1);
          }
          return $newString;
        } else {
          //If last element in substring is a space or new line, break at last element
          if($subString[strlen($subString) - 1] === " " || $subString[strlen($subString) - 1] === PHP_EOL
            || $nextChar === " " || $nextChar === PHP_EOL){
            $subString = createString($subString);
            $newString = $newString.$subString;
            echo $subString."<br>";
          //If last element in substring is not a space or new line, 
          //find closest space or new line to left and break there
          } else {
              for ($count = 1; $count <= $length; $count++) {
                if ($count === $length && $subString[0] !== PHP_EOL) {
                  $subString = createString($subString);
                  $newString = $newString.$subString;
                  echo $subString."<br>";
                } elseif ($count === $length && $subString[0] === PHP_EOL) {
                  $subString = substr($subString, 0, 1);
                  $newString = $newString;
                } elseif ($subString[$length - $count] === " " || $subString[$length - $count] === PHP_EOL) {
                  $subString = createString(substr($subString, 0, $length - $count));
                  $newString = $newString.$subString;
                  echo $subString."<br>";
                  break;
              }
            }
          }

          if(strlen($subString) > $length) {
            $updateString = substr($string, $length);
            $trimUpdate = trim($updateString, " ");
          } else {
            $updateString = substr($string, strlen($subString));
            $trimUpdate = trim($updateString, " ");
          }
          return recursiveWrap($trimUpdate, $length, $newString);
        }
      }

      function wrap($string, $length) {
        if (strlen($string) <= $length ) {
          echo $string;
          return $string;
        } else {
          $newString = recursiveWrap($string, $length, "");
          return $newString;
        }
      }

      //Tests to ensure string is being created correctly
      //$test = wrap("test\ntest", 3);
      //$test2 = wrap("test\ntesting", 4);
      $test3 = wrap("test\ntest what a\ntest", 5);
      //$test4 = wrap("This is a string that I am testing.", 7);
      //$test5 = wrap("This is a string that I am testing.", 3);
      //$test6 = wrap("This is a string that I am testing.", 15);
      //$test7 = wrap("This is a string that I am testing.", 40);
      error_log($test7);
      //if ($test === "tes\nt\ntes\nt") {
      //if ($test2 === "test\ntest\ning") {
      if ($test3 === "test\ntest\nwhat\na\ntest") {
      //if ($test4 === "This is\na\nstring\nthat I\nam\ntesting\n.") {
      //if ($test5 === "Thi\ns\nis\na\nstr\ning\ntha\nt I\nam\ntes\ntin\ng.") {
      //if ($test6 === "This is a\nstring that I\nam testing.") {
      //if ($test7 === "This is a string that I am testing.") {
        error_log("True");
      } else {
        error_log("False");
      }

    ?>
    </body>
</html>