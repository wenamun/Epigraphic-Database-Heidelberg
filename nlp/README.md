# Natural Language Processing
The Epigraphic Database Heidelberg websitge (EDH) holds some 75.000 ancient Latin inscriptions and provides extensive querying options; the drawback as of now is if you're searching for all inflected forms of a latin word you have to search for each form individually one after the other. The idea for the next version of the EDH website is to have a lemma search where you can query for a lemma and automatically all inflected forms of this word will be returned as hits. This can be done by lemmatizing all inscriptions.

The folder "data" holds the lemma informations that are stored in an Apache Solr index. The basic structure of these CSV file is as follows:
* HD-No (ID of inscription)
* token ID
* token string
* POS information
* base form

An EpiDoc export where these informations are added to the w-elements is in preparation. 

The folder "website" holds a very basic web application for querying and browsing the lemmatized forms.
