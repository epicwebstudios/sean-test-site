<?


    // returns Array on result passed
    // @param->result
    function toArray( $result ){

        $array = Array();
        while( $row = mysql_fetch_assoc($result) ){
            array_push($array, $row);
        }

        $count = sizeof($array);
        if( $count == 1 ){
            return $array[0];
        }

        return $array;

    }


    //returns the last url keyword as id
    // $param->url
    function getUrlId( $url ){
        $uri = explode('/',$url);
        $urlSize = sizeof($uri);
        return $id = $uri[ $urlSize - 1];
    }

