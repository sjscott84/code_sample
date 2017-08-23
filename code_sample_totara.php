<!DOCTYPE html>
<html>
  <head>
    <title>Totara Code Sample</title>
  </head>
  <body>
    <?php
      //Helper function to log messages to chrome console
      function debug_to_console( $data ) {
        $output = $data;
        if ( is_array( $output ) ) {
          $output = implode( ',', $output);
        }
        echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
      }

      //take section - remove white space at front and back
      function tidyString($string){
        $tidyString = trim($string);
        return $tidyString."\n";
      }

      function createString($string, $newString, $split, $length, $growLength, $addLength){
        $nextString = tidyString(substr($string, $split, $length));
        $newString = $newString.$nextString;
        error_log($newString);
        echo $newString."<br>";
        $split = $split + $addLength;
        $newLength = $growLength + $addLength;
        return array($newString, $split, $newLength);
      }

      function wrap ($string, $length) {
        $newString = "";
        $growLength = $length - 1;
        $startSplit = 0;
        while ( strlen($string) >= strlen($newString) ){
          //If string less then length simply return string
          if (strlen($string) <= $length) {
            return $string;
          //If character next to one that is to be split is space, split there
          } elseif ($string[$growLength + 1] === " " && $growLength + $length < strlen($string)) {
            list($newString, $startSplit, $growLength) = createString($string, $newString,
              $startSplit, $length, $growLength, $length + 1);
          //If character to be split is a space, split there
          } elseif ($string[$growLength] === " ") {
            list($newString, $startSplit, $growLength) = createString($string, $newString,
              $startSplit, $length, $growLength, $length - 1);
          //Find the nearest space and split there
          } else {
            for ($count = 1; $count <= $length; $count++) {
              if ($count === $length) {
                list($newString, $startSplit, $growLength) = createString($string, $newString,
                  $startSplit, $length, $growLength, $length);
              } elseif ($string[$growLength - $count] === " ") {
                $tempLength = $length - $count;
                list($newString, $startSplit, $growLength) = createString($string, $newString,
                  $startSplit, $tempLength, $growLength, $tempLength);
                break;
              }
            }
          }
        }
        return $newString;
      }
      wrap("This is a string that I am testing.", 3);
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