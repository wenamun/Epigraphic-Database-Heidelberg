from rdflib import Graph, Literal, RDF, URIRef
from SPARQLWrapper import SPARQLWrapper, JSON
import re

NS_DCT = "http://purl.org/dc/terms/"
snap_sparql = SPARQLWrapper("https://snap.dighum.kcl.ac.uk/sparql/")
g = Graph()
g.bind("dct", NS_DCT)
g.parse("edh_people.ttl", format="n3")
results = g.query("""
    SELECT  ?o ?s
    WHERE {
        ?s dct:identifier ?o
        FILTER regex(?o, '^PIR')
    }""")

for row in results:
	auflage = "1"
	if "2. Aufl." in row[0]:
		auflage = "2"
	pattern = re.compile(r'(.\s\d{1,4}).*$')
	match_object = pattern.search(row[0])
	pir_id = match_object.group()
	pir_id = pir_id.replace(" ","-").lower()
	pir_id = pir_id.replace(".","")
	pir = pir_id.split('-')
	pir_id = pir[0] + "-" + pir[1].zfill(4)
	q = """
		SELECT ?s
   		WHERE {
        	?s ?p <http://www.paregorios.org/resources/roman-elites/persons/pir%s-%s>
		} 
		LIMIT 10
	""" % (auflage, pir_id)
	snap_sparql.setQuery(q)
	snap_sparql.setReturnFormat(JSON)
	results = snap_sparql.query().convert()
	for result in results["results"]["bindings"]:
	    print (str(row[1]) +  "," + str(result["s"]['value']))
	
		