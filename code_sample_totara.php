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

      function wrap ($string, $length) {
        $newString = "";
        $growLength = $length - 1;
        $startSplit = 0;
        while ( strlen($string) + $length >= strlen($newString) ){
          if (strlen($string) <= $length) {
            return $string;
          } elseif ($string[$growLength + 1] === " ") {
            $nextString = tidyString(substr($string, $startSplit, $length));
            $newString = $newString.$nextString;
            error_log($newString);
            echo $newString."<br>";
            $startSplit = $startSplit + $length + 1;
            $growLength = $growLength + $length + 1;
          } elseif ($string[$growLength] === " ") {
            $nextString = tidyString(substr($string, $startSplit, $length));
            $newString = $newString.$nextString;
            echo $newString."<br>";
            error_log($newString);
            $startSplit = $startSplit + $length - 1;
            $growLength = $growLength + $length - 1;
          } else {
            for ($count = 1; $count <= $length; $count++) {
              if ($count === $length) {
                $nextString = tidyString(substr($string, $startSplit, $length));
                $newString = $newString.$nextString;
                $startSplit = $startSplit + $length;
                $growLength = $growLength + $length;
              } elseif ($string[$growLength - $count] === " ") {
                $nextString = tidyString(substr($string, $startSplit, $length - $count));
                $newString = $newString.$nextString;
                $startSplit = $startSplit + $length - $count;
                $growLength = $growLength + $length - $count;
                break;
              }
            }
            echo $newString."<br>";
            error_log($newString);
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