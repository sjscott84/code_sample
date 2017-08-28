<!DOCTYPE html>
<html>
  <head>
    <title>Totara Code Sample</title>
  </head>
  <body>
    <form action="code_sample_totara.php" method="post">
      Enter a string:<br>
      <input type="text" name="string" value=""><br>
      Enter a number:<br>
      <input type="text" name="number" value=""><br><br>
      <input type="submit">
    </form>
    <?php

      //If form is posted, run wrap function
      if (isset($_POST['string']) && isset($_POST['number'])) {
        wrap($_POST['string'], intval($_POST['number']));
      } else {
        $_POST['string'] = " ";
        $_POST['number'] = " ";
      }


      //Helper function to log messages to chrome console
      function debug_to_console($data) {
        $output = $data;
        if (is_array($output)) {
          $output = implode( ',', $output);
        }
        echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
      }


      //Take section - remove white space at front and back
      function tidyString($string) {
        $tidyString = trim($string, " ");
        if (strlen($tidyString) > 0 && substr($tidyString, -1) !== PHP_EOL) {
          return $tidyString."\n";
        } else {
          return $tidyString;
        }
      }


      //Create the new string and update variables needed to keep track of location
      function createString($string, $newString, $split, $length, $growLength, $addLength) {
        $subString = substr($string, $split, $addLength);
        $nextString = tidyString($subString);
        $newString = $newString.$nextString;
        if (strlen($subString) > 1){
          echo $nextString."<br>";
        } else {
          echo $nextString;
        }
        $split = $split + $addLength;
        $growLength = $growLength + $addLength;
        return array($newString, $split, $growLength);
      }
      
      function wrap ($string, $length) {
        $newString = "";
        $growLength = $length - 1;
        $startSplit = 0;
        $complete = False;
        while (!$complete) {
          //If string less then length simply return string
          if (strlen($string) <= $length) {
            echo $string;
            return $string;
          //This check ensures there are no PHP Notice:  Uninitialized string offset 
          //warnings by simply adding the last characters in $string to $newString
          } elseif ($growLength + 1 >= strlen($string)) {
            list($newString, $startSplit, $growLength) = createString($string, $newString,
              $startSplit, $length, $growLength, $length);
          //If character next to one that is to be split is space, split there
          } elseif ($string[$growLength + 1] === " " || $string[$growLength + 1] === PHP_EOL) {
            list($newString, $startSplit, $growLength) = createString($string, $newString,
              $startSplit, $length, $growLength, $length + 1);
          //If last character is new line, then split on last character
          } elseif ($string[$growLength] === PHP_EOL) {
            list($newString, $startSplit, $growLength) = createString($string, $newString,
              $startSplit, $length, $growLength, $length);
          //If last character is a space, split on last character
          } elseif ($string[$growLength] === " ") {
            list($newString, $startSplit, $growLength) = createString($string, $newString,
              $startSplit, $length, $growLength, $length - 1);
          //Find the nearest space to the left and split there
          } else {
            for ($count = 1; $count <= $length; $count++) {
              if ($string[$growLength - $count] === " " || $string[$growLength - $count] === PHP_EOL
                && $count !== $length) {
                $tempLength = $length - $count;
                list($newString, $startSplit, $growLength) = createString($string, $newString,
                  $startSplit, $tempLength, $growLength, $tempLength);
                break;
              } elseif ($count === $length - 1) {
                list($newString, $startSplit, $growLength) = createString($string, $newString,
                  $startSplit, $length, $growLength, $length);
              }
            }
          }
          //Exit while loop once $growLength is greater the $string - also check if last 
          //character in $newString is "\n" and remove if it is.
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
      //$test = wrap("test\ntest", 3);
      //$test2 = wrap("test\ntesting", 4);
      //$test3 = wrap("test\ntest what a\ntest", 5);
      //$test4 = wrap("This is a string that I am testing.", 7);
      //$test5 = wrap("This is a string that I am testing.", 3);
      //$test6 = wrap("This is a string that I am testing.", 15);
      //$test7 = wrap("This is a string that I am testing.", 40);
      //$test8 = wrap("Once upon a time there was a princess", 4);
      //error_log($test5);
      //if ($test === "tes\nt\ntes\nt") {
      //if ($test2 === "test\ntest\ning") {
      //if ($test3 === "test\ntest\nwhat\na\ntest") {
      //if ($test4 === "This is\na\nstring\nthat I\nam\ntesting\n.") {
      //if ($test5 === "Thi\ns\nis\na\nstr\ning\ntha\nt I\nam\ntes\ntin\ng.") {
      //if ($test6 === "This is a\nstring that I\nam testing.") {
      //if ($test7 === "This is a string that I am testing.") {
      //if ($test8 === "Once\nupon\na\ntime\nther\ne\nwas\na\nprin\ncess") {
        /*error_log("True");
      } else {
        error_log("False");
      }*/

    ?>
    </body>
</html>