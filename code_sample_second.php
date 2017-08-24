<!DOCTYPE html>
<html>
  <head>
    <title>Totara Code Sample</title>
  </head>
  <body>
    <?php

      function debug_to_console( $data ) {
        $output = $data;
        if ( is_array( $output ) ) {
          $output = implode( ',', $output);
        }
        echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
      }

      function createString($string){
        $string = trim($string);
        if (strlen($string) > 0) {
          return $string."\n";
        } else {
          return $string;
        }
      }

      function wrap($string, $length, $newString) {
        $newString = $newString;
        $subString = substr($string, 0, $length);
        //$nextCharAfterSub = substr($string, $length, 1);
        if($newString >= strlen($string)){
          error_log("In func: ".$newString);
          if($newString[strlen($newString) - 1] === PHP_EOL) {
            $newString = substr($newString, 0, strlen($newString) - 1);
          }
          return $newString;
        } else {
          //If next char in next set is space
          //just concat $substring to $newString with \n
          if($subString[strlen($subString)] === " "){
            $subString = createString($subString);
            $newString = $newString.$subString;
            echo $newString."<br>";
          //If first char in next set is not a space, find closest space to left and break there
          } else {
              for ($count = 1; $count <= $length; $count++) {
                if($count === $length) {
                  $subString = createString($subString);
                  $newString = $newString.$subString;
                  echo $newString."<br>";
                  break;
                } elseif ($subString[$length - $count] === " ") {
                  $subString = createString(substr($subString, 0, $length - $count));
                  $newString = $newString.$subString;
                  echo $newString."<br>";
                  break;
                }
              }
          }
          if (strlen($subString) < $length) {
            $updateString = substr($string, strlen($subString));
          } else {
            $updateString = substr($string, $length);
          }
          wrap($updateString, $length, $newString);
        }
      }

      /*function wrap ($string, $length){
        if (strlen($string) <= $length) {
          return $string;
        } else {
          $string = newString($string, $length, "");
          return $string;
        }
      }*/

      $test = wrap("This is a string that I am testing.", 7, "");
      error_log("Final: ".$test);
      if ($test === "This is\na\nstring\nthat I\nam\ntesting\n.") {
        error_log("True");
      } else {
        error_log("False");
      }
    ?>
    </body>
</html>

<!--
	The task is to write a function called 'wrap' that takes two arguments, $string and $length.
The function should return the string, but with new lines ("\n") added to ensure that no line is longer than $length characters. 
Always wrap at word boundaries if possible, only break a word if it is longer than $length characters. 
When breaking at word boundaries, replace all the whitespace between the two words with a single newline character. 
Any unbroken whitespace should be left unchanged.
Please implement the function directly in PHP, rather than using the built-in wordwrap() function. -->