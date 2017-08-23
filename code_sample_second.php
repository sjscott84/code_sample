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

      function newString($string, $length, $newString) {
        $newString = $newString;
        $subString = substr($string, 0, $length);
        $nextCharsAfterSub = substr($string, $length, $length);
        if($newString >= strlen($string)){
          return $newString;
        } else {
          //If no spaces in current set, or next set, or if next char in next set is space
          //just concat $substring to $newString with \n
          if(!preg_match_all('/\s/', $subString) || $nextCharsAfterSub[0] === " "){
            $newString = $newString.$subString."\n";
            echo $newString."<br>";
          //If first char in next set is a space, find closest space to left and break there
          } elseif ($nextCharsAfterSub[0] !== " ") {
              for ($count = 1; $count <= $length; $count++) {
                if ($subString[$length - $count] === " ") {
                  $subString = substr($subString, 0, $length - $count);
                  $newString = $newString.$subString."\n";
                  error_log($newString);
                  echo $newString."<br>";
                  break;
                }
              }
          }
          $updateString = substr($string, strlen($subString));
          newString($updateString, $length, $newString);
        }
      }

      function wrap ($string, $length){
        if (strlen($string) <= $length) {
          return $string;
        } else {
          $string = newString($string, $length, "");
        }
      }

      $test = wrap("This is a string that I am testing.", 7);
      error_log($test);
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