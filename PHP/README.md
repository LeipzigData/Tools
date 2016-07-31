# PHP Tools 

All tools are provided "as is", not useful or even operating for any special
purpose but only as example code how things could be done.

Run `composer update` to install the required environment.

## Events

Legacy code concerned with the LD Events system.  Has to be fixed. 

## GeoData

* GeoData/geodata.php - Interface to extract geodata via
  (nominatim)[http://nominatim.openstreetmap.org].
* GeoData/checkDistance.php - check the distance between different geo
  coordinates

## Main dir

* getLDAdressen.php - Explore LD Adresses via LeipzigData Sparql endpoint.

* oklab-ics.php - transform ics file to RDF LD Event format. Uses
  class.iCalReader.php to parse ical.

* helper.php - some helpers to compose a turtle file.
