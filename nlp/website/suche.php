
<?php
require('./library/Solarium/Autoloader.php');
require('./config.php'); // Verbindungsdaten zum Solr Server
Solarium_Autoloader::register();

$buchstabe = "a";
$myQuery = "lemma:a*"; 

$client = new Solarium_Client($config);
$query = $client->createSelect();

// optionale Start & Rows Parameter, wird fürs Paging benötigt
// muss gesetzt werden, wenn mehr als 10 Resultate zurückgeliefert werden sollen
$query->setStart(0)->setRows(10000);
$query->addSort("lemma",$query::SORT_ASC);
$query->setQuery($myQuery);

// Query ausführen & und Ergebniss in einem Resultset speichern,
$resultset = $client->select($query);

// über Resultset iterieren
foreach ($resultset as $document) {
    
    print $document->lemma . " " . $document->hd_nr . ", " . $document->token_id . " (" . $document->pos . ")<br>";
    
}
?>

