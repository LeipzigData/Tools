all:
	php le.php >le.ttl
	rapper -g le.ttl -o rdfxml-abbrev >LeipzigerEcken.rdf
	php nl.php >nl.ttl
	rapper -g nl.ttl -o rdfxml-abbrev >NachhaltigesSachsen.rdf
