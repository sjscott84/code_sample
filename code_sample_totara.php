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
        if (strlen($tidyString) > 0) {
          return $tidyString."\n";
        } else {
          return $tidyString;
        }
      }

      //Create the new string and update variables needed to keep track of location
      function createString($string, $newString, $split, $length, $growLength, $addLength){
        $nextChar = substr($string, $length, 1);
        $nextString = tidyString(substr($string, $split, $length));
        $newString = $newString.$nextString;
        echo $newString."<br>";
        $split = $split + $addLength;
        $newLength = $growLength + $addLength;
        return array($newString, $split, $newLength);
      }

      function wrap ($string, $length) {
        $newString = "";
        $growLength = $length - 1;
        $startSplit = 0;
        $complete = False;
        while ( !$complete ){
          //If string less then length simply return string
          if (strlen($string) <= $length) {
            return $string;
          //This check ensures there are no PHP Notice:  Uninitialized string offset warnings
          //by simply adding the last characters in $string to $newString
          } elseif ($growLength > strlen($string)) {
            list($newString, $startSplit, $growLength) = createString($string, $newString,
              $startSplit, $length, $growLength, $length);
          //If character next to one that is to be split is space, split there
          } elseif ($string[$growLength + 1] === " ") {
            list($newString, $startSplit, $growLength) = createString($string, $newString,
              $startSplit, $length, $growLength, $length + 1);
          //If character to be split is a space, split there
          } elseif ($string[$growLength] === " ") {
            list($newString, $startSplit, $growLength) = createString($string, $newString,
              $startSplit, $length, $growLength, $length - 1);
          //Find the nearest space to the left and split there
          } else {
            for ($count = 1; $count <= $length; $count++) {
              if ($string[$growLength - $count] === " " && $count !== $length) {
                $tempLength = $length - $count;
                list($newString, $startSplit, $growLength) = createString($string, $newString,
                  $startSplit, $tempLength, $growLength, $tempLength);
                break;
              } elseif ($count === $length ) {
                list($newString, $startSplit, $growLength) = createString($string, $newString,
                  $startSplit, $length, $growLength, $length);
              }
            }
          }
          //Exit while loop once $growLength is greater the $string - also check if last character in
          //$newString is "\n" and remove if it is.
          if ($growLength - $length >= strlen($string)) {
            $complete = True;
            if($newString[strlen($newString) - 1] === PHP_EOL) {
              $newString = substr($newString, 0, strlen($newString) - 1);
            }
          }
        }
        return $newString;
      }

      //Tests to ensure string is being created correctly

      $test = wrap("This is a string that I am testing.", 7);
      error_log($test);
      if($test === "This is\na\nstring\nthat I\nam\ntesting\n."){
        error_log("True");
      } else {
        error_log("False");
      }

      /*$test = wrap("This is a string that I am testing.", 3);
      error_log($test);
      if($test === "Thi\ns\nis\na\nstr\ning\ntha\nt I\nam\ntes\ntin\ng."){
        error_log("True");
      } else {
        error_log("False");
      }*/

      /*$test = wrap("This is a string that I am testing.", 15);
      error_log($test);
      if($test === "This is a\nstring that I\nam testing."){
        error_log("True");
      } else {
        error_log("False");
      }*/
      
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