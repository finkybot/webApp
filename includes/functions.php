<?php
    /**
        function buildQuery()
        builds and returns a query to be used in the database 
        $aQstart = start of query
        $aQry = $_POST $keys and $values
        $aQend = ending of the query

        Author  K.Abraham 
        Date    24/04/2019 
    **/
    //function buildQuery($aQstart, $aQry, $aQend)
    //{
    //    $result = $aQstart; // add the start of the query
    //    array_pop($aQry); // remove the last element from the array, not used in the database
    //    foreach ($aQry as $key => $value) // loop through the send data
    //    {  
    //        $result = $result . "'$value',"; // add posted values to the query
    //    }
        
    //    $result = rtrim($result, ","); // trim the last comma of the query
    //    return $result . $aQend; // add the end of the query
    //}

    /** 
        function checkValue()
        $value = value to check
        if a value is null returns $val

        Author K.Abraham
        Date 24/04/2019
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
       
        Author K.Abraham
        Date 24/04/2019
    **/
    function prepState($aStatement,$aString,$aParam)
    {
        return $aStatement->bindParam($aParam,$aString); 
        
    }

    /**
        function getDirectoryLIst()
        reads and returns the list of a directory
        
        Author K.Abraham
        Date 24/04/2019
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

        Author K.Abraham
        Date 24/04/2019
    **/
    function createTable($tableInit, $images)
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
