<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Epigraphic Database Heidelberg">
    <title>Epigraphic Database Heidelberg: Lexicon</title>
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">

    <!--[if lte IE 8]>
        <link rel="stylesheet" href="css/layouts/side-menu-old-ie.css">
    <![endif]-->
    <!--[if gt IE 8]><!-->
        <link rel="stylesheet" href="css/layouts/side-menu.css">
    <!--<![endif]-->
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css"/>
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
                <li class="pure-menu-item"><a href="#" class="pure-menu-link">Glossar</a></li>
            </ul>
        </div>
    </div>

    <div id="main">
        <div class="header">
            <h1>Epigraphic Database Heidelberg</h1>
            <h2>Glossar</h2>
        </div>

        <div class="content">
            <h2 class="content-subhead">Alphabetic Entries</h2>
            <div id="tabs">
                <ul>
                    <li><a href="dictionaryLetter.php?letter=a">a</a></li>
                    <li><a href="dictionaryLetter.php?letter=b">b</a></li>
                    <li><a href="dictionaryLetter.php?letter=c">c</a></li>
                    <li><a href="dictionaryLetter.php?letter=d">d</a></li>
                    <li><a href="dictionaryLetter.php?letter=e">e</a></li>
                    <li><a href="dictionaryLetter.php?letter=f">f</a></li>
                    <li><a href="dictionaryLetter.php?letter=g">g</a></li>
                    <li><a href="dictionaryLetter.php?letter=h">h</a></li>
                    <li><a href="dictionaryLetter.php?letter=i">i</a></li>
                    <li><a href="dictionaryLetter.php?letter=j">j</a></li>
                    <li><a href="dictionaryLetter.php?letter=k">k</a></li>
                    <li><a href="dictionaryLetter.php?letter=l">l</a></li>
                    <li><a href="dictionaryLetter.php?letter=m">m</a></li>
                    <li><a href="dictionaryLetter.php?letter=n">n</a></li>
                    <li><a href="dictionaryLetter.php?letter=o">o</a></li>
                    <li><a href="dictionaryLetter.php?letter=p">p</a></li>
                    <li><a href="dictionaryLetter.php?letter=q">q</a></li>
                    <li><a href="dictionaryLetter.php?letter=r">r</a></li>
                    <li><a href="dictionaryLetter.php?letter=s">s</a></li>
                    <li><a href="dictionaryLetter.php?letter=t">t</a></li>
                    <li><a href="dictionaryLetter.php?letter=u">u</a></li>
                    <li><a href="dictionaryLetter.php?letter=v">v</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script src="js/ui.js"></script>
<script>
  $(function() {
    $( "#tabs" ).tabs({
      beforeLoad: function( event, ui ) {
        ui.jqXHR.fail(function() {
          ui.panel.html(
            "Couldn't load this tab. We'll try to fix this as soon as possible. " +
            "If this wouldn't be a demo." );
        });
      }
    });
  });
</script>
</body>
</html>
