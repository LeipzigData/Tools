To get this version running 

1) install the ARC2 data store as described in
https://github.com/semsol/arc2/wiki and link it as arc2 to this directory

2) copy db_credentials.php to db.inc and fill in the required database
credentials. For security reasons *.inc files should not be served to the
public by your web server. 

3) Download a RDF-file with LD Events Data from the web as EventsDump.ttl
(Save it as Turtle file, e.g., from the Events Database at
http://leipzig-data.de/Data).

4) Call 'php Store.php' from the comand line to store that data in your local
database. 

5) Call 'php getdata.php' to create data.json.

6) Start index.html in your browser.  
