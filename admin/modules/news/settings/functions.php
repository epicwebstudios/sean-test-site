<?

function checked($array,$value){
    if( !empty($array) ){
        foreach ($array as $option){
            if($option == $value){
                echo "checked";
            }
        }
    }
}

	



