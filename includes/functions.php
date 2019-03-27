<?php
    /**
        function buildQuery()
        builds and returns a query to be used in the database 
        $aQstart = start of query
        $aQry = $_POST $keys and $values
        $aQend = ending of the query

        Author  K.Abraham 
        Date    26/03/2019 
    **/
    function buildQuery($aQstart, $aQry, $aQend)
    {
        $result = $aQstart; // add the start of the query
        array_pop($aQry); // remove the last element from the array, not used in the database
        foreach ($aQry as $key => $value) // loop through the send data
        {  
            $result = $result . "'$value',"; // add posted values to the query
        }
        
        $result = rtrim($result, ","); // trim the last comma of the query
        return $result . $aQend; // add the end of the query
    }

    /** 
        function checkValue()
        $value = value to check
        if a value is null returns $val

        Author K.Abraham
        Date 11/03/2019
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
        Date 11/03/2019
    **/
    function prepState($aStatement,$aString,$aParam)
    {
        return $aStatemet->bindParam($aParam,$aString); 
        
    }

    /**
        function getDirectoryLIst()
        reads and returns the list of a directory
        
        Author K.Abraham
        Date 11/03/2019
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
        Date 11/03/2019
    **/
    function createTable($tableInit, $loc, $fList)
    {
        echo $tableInit;
        $row = 0;
        $currentFile = 0;
        $size = sizeof($fList);
        $_SESSION['loc'] = $loc;
        $_SESSION['file'] = $fList;
        while($row<=($size/4))
        {
            $column = 0;
            echo "<tr>";
            while($column<= 3)
            {
                if ($currentFile < $size)
                {

                    echo '<td>';
                    echo "<img src=\"image.php?val=" . $currentFile . "\" style=\"max-width: 150px; max-height: 150px; object-fit: contain\"/>";
                    echo '</td>';
    
                }
                else 
                {
                    echo '<td> </td>';
                }
                $currentFile++;
                $column++;
            }
            echo "</tr>";
            $row++;
        }
        echo "</table>";
    }


function LoadJpeg($imgname)
{
    /* Attempt to open */
    $im = @imagecreatefromjpeg($imgname);

    /* See if it failed */
    if(!$im)
    {
        /* Create a black image */
        $im  = imagecreatetruecolor(150, 30);
        $bgc = imagecolorallocate($im, 255, 255, 255);
        $tc  = imagecolorallocate($im, 0, 0, 0);

        imagefilledrectangle($im, 0, 0, 150, 30, $bgc);

        /* Output an error message */
        imagestring($im, 1, 5, 5, 'Error loading ' . $imgname, $tc);
    }

    return $im;
}
 

?>