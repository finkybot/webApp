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

    /** 
        function createTable()
        creates a table an populates its with values
    **/
    function createTable($tableInit, $location, $images)
    {
        echo $tableInit;
        $row = 0;
        $currentFile = 0;
        $iSum = sizeof($images);

        //$_SESSION['loc'] = $location;
        $_SESSION['file'] = $iSum;
        while($row<=$iSum)
        {
            echo "<tr>";
            if ($currentFile <= $iSum)
            {
                echo '<td>';
                //$images[$currentFile]->loadImage($location);
                echo "<img src=\"imageLoader.php?val=" . $currentFile . "\" style=\"max-width: 80vw; max-height: 80vh; object-fit: contain\"/>";
                echo '</td>';
            }
            else 
            {
                echo '<td> </td>';
            }
           
            $currentFile++;
            echo "</tr>";
            $row++;
        }
        echo "</table>";
    }
