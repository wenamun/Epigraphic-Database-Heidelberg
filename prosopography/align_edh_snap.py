from rdflib import Graph, Literal, RDF, URIRef
from SPARQLWrapper import SPARQLWrapper, JSON
import re

NS_DCT = "http://purl.org/dc/terms/"
NS_OWL = "http://www.w3.org/2002/07/owl#"
snap_sparql_endpoint = SPARQLWrapper("https://snap.dighum.kcl.ac.uk/sparql/")
g = Graph()
g.bind("dct", NS_DCT)
g.bind("owl", NS_OWL)
g.parse("edh_people.ttl", format="n3")
results = g.query("""
    SELECT  ?o ?s
    WHERE {
        ?s dct:identifier ?o
        FILTER regex(?o, '^PIR')
    }""")

for row in results:
	edition = "1"
	if "2. Aufl." in row[0]:
		edition = "2"
	# transform PIR edition & ID information
	# from EDH database in the SNAP format (e.g.: pir2-i-0662)
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
	""" % (edition, pir_id)
	snap_sparql_endpoint.setQuery(q)
	snap_sparql_endpoint.setReturnFormat(JSON)
	results = snap_sparql_endpoint.query().convert()
	for result in results["results"]["bindings"]:
	    print (str(row[1]) +  " = " + str(result["s"]['value']))
	    # write owl:same triple into graph
	    g.add((URIRef(str(row[1])), (URIRef(NS_OWL + "sameAs")), URIRef(str(result["s"]['value']))))


# serialize graph
out = open("edh_snap_people.ttl", "w")
out.write(g.serialize(format='turtle').decode('UTF-8'))
out.close()

		