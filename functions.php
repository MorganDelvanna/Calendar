<?php

    $servername = "";
    $username = "";
    $password = "";
    $database = "";

    $mysqli = mysqli_connect($servername, $username, $password, $database);
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }

    function queryMySQL($query)
    {
        global $mysqli;
        $result = $mysqli->query($query);
        if (!$result) die ($mysqli->error);
        return $result;
    }

    function destroySession()
    {
        $_SESSION=array();

        if (session_id() != "" || isset($_COOKIE[session_name()]))
            setcookie(session_name(), '', time()-259200, '/');

        session_destroy();
    }

    function sanitizeString($var)
    {
        global $mysqli;
        $var = strip_tags($var);
        $var = htmlentities($var);
        $var = stripslashes($var);
        return $mysqli->real_escape_string($var);
    }

    function getEvent($id)
    {
        $row = new ArrayObject();

        $result = queryMysql("CALL getEventById($id)");
        if ($result->num_rows)
        {
            $row = $result->fetch_array(MYSQLI_ASSOC);
        }

        return $row;
    }

    function saveEvent($id, $start, $end, $title, $description)
    {

        if ($id == -1)
        {
            $result = queryMySQL("INSERT INTO calendar (eventStart, eventEnd, Title, Description, AllDay) VALUES ('$start', '$end', '$title', '$description', 0)");  
        }
        else
        {
            $result = queryMySQL("UPDATE calendar SET eventStart='$start', eventEnd='$end', Title='$title', Description='$description' WHERE ID= $id");
        }
        
        return $result;
    }
?>