<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Epigraphic Database Heidelberg">
    <title>Epigraphic Database Heidelberg: Inscription</title>
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
    <!--[if lte IE 8]>
        <link rel="stylesheet" href="css/layouts/side-menu-old-ie.css">
    <![endif]-->
    <!--[if gt IE 8]><!-->
        <link rel="stylesheet" href="css/layouts/side-menu.css">
    <!--<![endif]-->
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"/>
    <style>
        span:hover {
            text-decoration:underline;
            cursor: pointer;
        }
        div#lemma {
            margin-left: 1em;
            font-weight: normal;
        }
        div#lemmaHeader {
            font-weight: bold;
        }
        .word {
            color: #1f8dd6; 
        }
        a {
	    text-decoration: none;
	    color: #1f8dd6;
        }
    </style>
</head>
<body>

<div id="layout">
    <a href="#menu" id="menuLink" class="menu-link">
        <span></span>
    </a>

    <div id="menu">
        <div class="pure-menu">
            <a class="pure-menu-heading" href="#">EDH</a>
            <ul class="pure-menu-list">
                <li class="pure-menu-item" class="menu-item-divided pure-menu-selected">
                    <a href="/nlp" class="pure-menu-link">Search</a>
                </li>
                <li class="pure-menu-item"><a href="lexicon.php" class="pure-menu-link">Glossar</a></li>
            </ul>
        </div>
    </div>

    <div id="main">
        <div class="header">
            <h1>Epigraphic Database Heidelberg</h1>
            <h2>Inscription: <a href="/edh/inschrift/<?php echo $_GET['hd_nr'];  ?>"><?php echo $_GET['hd_nr'];  ?></a></h2>
            <h3>
<?php

require('./library/Solarium/Autoloader.php');
require('./config.php');
require('./nlpUtilities.php');
Solarium_Autoloader::register();
$hd_nr = $_GET['hd_nr'];
# zurück Navigation
$hd_nr_zahl = substr($hd_nr,2);
$hd_nr_zahl_prev = $hd_nr_zahl - 1;
if ($hd_nr_zahl_prev <= 1){
	$hd_nr_zahl_prev = 1;
}
$prev_hd_nr = "HD" . sprintf('%06d',$hd_nr_zahl_prev);
$hd_nr_zahl_next = $hd_nr_zahl + 1;
$next_hd_nr = "HD" . sprintf('%06d',$hd_nr_zahl_next);


$q = "hd_nr:[* TO $prev_hd_nr]";
$client = new Solarium_Client($config);
$query = $client->createSelect();
$query->addSort('hd_nr', $query::SORT_DESC);
$query->setRows(1);
$query->setQuery($q);
$resultset = $client->select($query);
foreach ($resultset as $document) {
     $prev_link = "<a href='/nlp/inscription.php?hd_nr=" . $document->hd_nr . "'><<</a>";
}

$q = "hd_nr:[$next_hd_nr TO *]";
$client = new Solarium_Client($config);
$query = $client->createSelect();
$query->addSort('hd_nr', $query::SORT_ASC);
$query->setRows(1);
$query->setQuery($q);
$resultset = $client->select($query);
foreach ($resultset as $document) {
     $next_link = "<a href='/nlp/inscription.php?hd_nr=" . $document->hd_nr . "'>>></a>";
}
print $prev_link . " Navigation " . $next_link;
?>
            </h3>
        </div>

        <div class="content">
            <div>
            <p> 
                <?php 



$q = "hd_nr:" . $_GET['hd_nr'];
if (isset($_GET['token_id'])){
    $token_id = $_GET['token_id'];
} else {
    $token_id = "";
}
$client = new Solarium_Client($config);
$query = $client->createSelect();
$query->setRows(99999);
$query->setQuery($q);
$resultset = $client->select($query);
$atext = "";
$pos = array();
foreach ($resultset as $document) {
     $atext = $document->atext;
     $pos[$document->token_id] = $document->lemma . "#" . $document->pos;
}

// tokenize atext
$tokens = explode(" ",$atext);


$cnt = 0;
foreach ($tokens as $token){
    if (array_key_exists($cnt,$pos)){
        $wordInfo = explode("#",$pos[$cnt]);
        if ($token_id != "" AND $token_id == $cnt){
            print "<span class=\"word\" id =\"w_$cnt\" lemma=\"" . $wordInfo[0] . "\" pos=\"" . $wordInfo[1] . "\" ><span style='background-color:yellow; font-weight:bold'>" . cleanToken($token) . "</span></span> \n";
        } else {
            print "<span class=\"word\" id =\"w_$cnt\" lemma=\"" . $wordInfo[0] . "\" pos=\"" . $wordInfo[1] . "\" >" . cleanToken($token) . "</span> \n";
        }
    } else {
        print cleanToken($token) . " \n";
    }
    $cnt++;
}
                ?>
            </p>
        </div>
        
    </div>
    <div id="DialogLemma"></div>
</div>

<script src="js/ui.js"></script>
<script>
$(document).ready(function() {
    $("#DialogLemma").dialog({
        autoOpen: false,
        modal: true,
        width:350,
        resizable: true,
        title: "Lemma Information"
    });
    $(".word").click(function(){
        var hd = "<?php echo $_GET['hd_nr'];  ?>";
        var tid = document.getElementById(this.id).getAttribute("id");
        var l = document.getElementById(this.id).getAttribute("lemma");
        var pos = document.getElementById(this.id).getAttribute("pos");
        
        $.ajax({
                    url:"/cgi-bin/solrGetLemmaTranslation.pl",
                    type:"get",
                    data:{hd_nr: hd, token_id: tid},
                    success: function(response){
                        $("#DialogLemma").html(l + " (" + pos + ")<br /><br />" + response).dialog();
                        $("#DialogLemma").dialog("open");
                    }
                });
    });

});
</script>
</body>
</html>
