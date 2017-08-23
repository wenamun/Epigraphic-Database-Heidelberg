<?php 

function cleanToken($t){
    # falls Token Gatterzaun enthält, Token splitten und erstes Element zurückliefern
    if (preg_match("/#/",$t)){
        $tArray = explode("#",$t);
        $t = $tArray[0];
    }
    $t = str_replace("<","&lt;",$t);
    $t = str_replace(">","&gt;",$t);
    return $t;
}



?>