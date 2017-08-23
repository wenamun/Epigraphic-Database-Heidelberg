
<?php
require('./library/Solarium/Autoloader.php');
require('./config.php'); // Verbindungsdaten zum Solr Server
Solarium_Autoloader::register();

$letter = $_GET["letter"];

$select = array(
    'query'         => 'lemma:b*',
    'rows'          => 10000,
    'sort'          => array('lemma' => 'asc'),
    'component' => array(
        'facetset' => array(
            'facet' => array(
                array('type' => 'field', 'key' => 'lemmaListe', 'field' => 'lemma', 'sort' => 'index', 'limit' => 50000)
            )
        )
    )
);

$client = new Solarium_Client($config);
$c2  = new Solarium_Client($config);
$query = $client->createSelect($select);
$resultset = $client->select($query);

// alle facets in Array speichern
$facet = $resultset->getFacetSet()->getFacet('lemmaListe');
$lemmas = array();
foreach($facet as $value => $count) {
    if (preg_match("/^[a-z]/",$value)) {
        array_push($lemmas, $value);
    }
}

foreach ($lemmas as $l) {
    if (startsWith($l,$letter)){
        echo '<b>' . $l . '</b><br>';
        printHdNumbers($l,$c2);
    }
}


#
# zu jedem Lemma die Belege ausgeben
#
function printHdNumbers($lemma,$c){
    $myQuery = "lemma:$lemma";
    $q = $c->createSelect();
    $q->setStart(0)->setRows(10000);
    $q->addSort("hd_nr",$q::SORT_ASC);
    $q->setQuery($myQuery);
    $rs = $c->select($q);
    foreach ($rs as $document) {
       print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"./inscription.php?hd_nr=" . $document->hd_nr . "&token_id=" . $document->token_id . "\" style=\"color: #1f8dd6;font-weight: bold;text-decoration:none\">" . $document->hd_nr . "</a>, " . $document->token_id . "<br>\n";
   }
}

function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}

?>

