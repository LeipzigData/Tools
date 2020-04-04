all:
	rm -f *.ttl
	wget -O Akteure.ttl https://leipziger-ecken.de/Data/getdata.php?show=akteure
	wget -O Events.ttl https://leipziger-ecken.de/Data/getdata.php?show=events
	wget -O Adressen.ttl https://leipziger-ecken.de/Data/getdata.php?show=adressen
	wget -O Sparten.ttl https://leipziger-ecken.de/Data/getdata.php?show=sparten
	cat *.ttl >Data.ttl
	rapper -g Data.ttl -o json >Data.json
