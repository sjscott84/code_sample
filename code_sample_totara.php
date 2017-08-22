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

      function wrap ($string, $length) {
        $newString = "";
        $growLength = $length - 1;
        $startSplit = 0;
        while (strlen($newString) < strlen($string)){
          if (strlen($string) <= $length) {
            return $string;
          } elseif ($string[$growLength + 1] === " ") {
              debug_to_console("Next char space");
              $newString = $newString.substr($string, $startSplit, $length)."\n";
              echo $newString.",<br>";
              $startSplit = $startSplit + $length + 1;
              $growLength = $growLength + $length + 1;
          } elseif ($string[$growLength] === " ") {
              debug_to_console("This char space");
              $newString = $newString.substr($string, $startSplit, $length - 1)."\n";
              echo $newString.",<br>";
              $startSplit = $startSplit + $length - 1;
              $growLength = $growLength + $length - 1;
          } else {
              for ($count = 1; $count <= $length; $count++) {
                if ($count === $length) {
                  $newString = $newString.substr($string, $startSplit, $length)."\n";
                } elseif ($string[$growLength - $count] === " ") {
                  $newString = $newString.substr($string, $startSplit, $length - $count)."\n";
                  break;
                }
              }
              echo $newString.",<br>";
              $startSplit = $startSplit + $length;
              $growLength = $growLength + $length;
          }
        }
        return $newString;
      }
      
      wrap("This is a string that I am testing.", 4);
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