<?php
    /** 
        function checkValue()
        $value = value to check
        if a value is null returns $val
    **/
    function checkValue($aValue,$val)
    {
        if($aValue == null || $aValue == '')
        {
            return $val;
        }
        
        return $aValue;
        
    }

    /** 
        function prepState()
        prepares and returns a sql statement of execution
    **/
    function prepState($aStatement,$aString,$aParam)
    {
        return $aStatement->bindParam($aParam,$aString); 
        
    }

    /**
        function getDirectoryLIst()
        reads and returns the list of a directory
    **/
    function getDirectoryList ($directory) 
    {
        // create an array to hold directory list
        $results = array();

        // create a handler for the directory
        $handler = opendir($directory);

        // open directory and walk through the filenames
        while ($file = readdir($handler)) 
        {
            // if file isn't this directory or its parent, add it to the results
            if ($file != "." && $file != "..") 
            {
                $results[] = $file;
            }
        }
        // tidy up: close the handler
        closedir($handler);

        // done!
        return $results;
    }

    // function fix image rotation by reading and fixing EXIF files
/*     function correctImageOrientation($filename) {
        if (function_exists('exif_read_data')) {
          $exif = exif_read_data($filename);
          if($exif && isset($exif['Orientation'])) {
            $orientation = $exif['Orientation'];
            if($orientation != 1){
              $img = imagecreatefromjpeg($filename);
              $deg = 0;
              switch ($orientation) {
                case 3:
                  $deg = 180;
                  break;
                case 6:
                  $deg = 270;
                  break;
                case 8:
                  $deg = 90;
                  break;
              }
              if ($deg) {
                $img = imagerotate($img, $deg, 0);        
              }
              // then rewrite the rotated image back to the disk as $filename 
              imagejpeg($img, $filename, 95);
            } // if there is some rotation necessary
          } // if have the exif orientation info
        } // if function exists      
      } */


    /** 
    function createTable()
    creates a table an populates its with values
    **/
    function createTable($tableInit, $fList)
    {
        echo $tableInit;
        $row = 0;
        $currentVal = 0;
        $size = sizeof($fList);
        $_SESSION['file'] = $fList;
        while($row<=($size/4))
        {
            $column = 0;
            echo "<tr>";
            while($column<= 3)
            {
                if ($currentVal < $size)
                {

                    echo '<td>';
                    //echo "<img src=\"image.php?val=" . $currentVal . "\" style=\"max-width: 150px; max-height: 150px; object-fit: contain\"/>";
                    echo '<p>' . $currentVal . '</p>';
                    echo '</td>';
    
                }
                else 
                {
                    echo '<td> </td>';
                }
                $currentVal++;
                $column++;
            }
            echo "</tr>";
            $row++;
        }
        echo "</table>";
    }