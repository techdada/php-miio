<?php
	$l = [
		'usage_0' 			=> 'Verwalten Sie WLAN-Geräte aus dem Xiaomi-Ökosystem über das miIO-Protokoll. Version 0.2.6' . PHP_EOL,
		'usage_1' 			=> 'Akzeptierte Parameter:' . PHP_EOL,
		'usage_2' 			=> '	--discover all	Suchen Sie im lokalen Netzwerk nach Geräten und zeigen Sie Informationen dazu an' . PHP_EOL,
		'usage_3' 			=> '	--discover IP	Überprüfen der Verfügbarkeit eines bestimmten Geräts und Anzeigen von Informationen dazu' . PHP_EOL,
		'usage_4' 			=> '	--info		Geräteinformationen abrufen (analog --discover IP)' . PHP_EOL,
		'usage_5' 			=> '	--sendcmd	Kommando senden (In linux mit einfachen Anführungszeichen, in Windows ohne)' . PHP_EOL,
		'usage_6' 			=> '	--decode	Paket dekodieren' . PHP_EOL,
		'usage_7' 			=> '	--ip 		IP-Adresse des Geräts' . PHP_EOL,
		'usage_8' 			=> '	--bindip	IP-Adresse der Serverschnittstelle (optional, wenn nur eine Schnittstelle vorhanden ist)' . PHP_EOL,
		'usage_9' 			=> '	--token 	Geräte-Token' . PHP_EOL,
		'usage_10' 			=> '	--debug		Aktiviert die Debugging-Ausgabe' . PHP_EOL,
		'usage_11' 			=> '	--help		Hilfe' . PHP_EOL,
		'usage_12' 			=> 'Beispiele:' . PHP_EOL,
		'discover_0' 		=> 'Alle durchsuchen',
		'search'	 		=> 'Suche',
		'require_ip' 		=> 'Sie müssen die IP-Adresse des Geräts über den Parameter --ip angeben',
		'autogen_ip' 		=> 'Automatische Generierung eindeutiger IDs für Befehle aus der Datei id.json verwenden',
		'dev_info' 			=> 'Geräteinformationen',
		'dev_noreact' 		=> 'Gerät reagiert nicht',
		'require_cmd' 		=> 'Sie müssen einen Befehl angeben',
		'device' 			=> 'Gerät',
		'has_answered' 		=> 'hat geantwortet',
		'hasnt answered' 	=> 'hat nicht geantwortet',
		'require_token' 	=> 'Sie müssen das Geräte-Token über den Parameter --token angeben',
		'decoded' 			=> 'Entschlüsselte Daten',
		'searched' 			=> 'Suche abgeschlossen.',
		'devices' 			=> 'Geräte',
		'no_devices' 		=> 'Suche abgeschlossen. Keine Geräte gefunden.',
		'searched_ok' 		=> 'Das Gerät wurde gefunden und reagiert.',
		'searched_fail' 	=> 'Suche abgeschlossen. Keine Geräte gefunden.',
		'dev_addr'			=> 'Verbindung mit IP ',
		'dev_broadcast'		=> 'Geräte-Broadcast-Modus',
		'debug' 			=> 'Debug-Status',
		'err_sock_new'		=> 'Fehler beim Erstellen des Sockets',
		'ok_sock'			=> 'Socket erfolgreich erstellt',
		'err_rcvtim_new'	=> 'Fehler beim Einstellen des Socket-Parameters SO_RCVTIMEO',
		'ok_sock_rcvtim'	=> 'Socket-Parameter SO_RCVTIMEO erfolgreich gesetzt',
		'err_broadc_new'	=> 'Fehler beim Einstellen des Socket-Parameters SO_BROADCAST',
		'ok_broadc_new'		=> 'Socket-Parameter SO_BROADCAST erfolgreich gesetzt',
		'dev_chk_avail'		=> 'Geräteverfügbarkeit prüfen',
		'err_sock_read'		=> 'Fehler beim Lesen des Socket',
		'err_send_data'		=> 'Fehler beim Senden der Daten an den Socket.',
		'byte' 				=> 'Byte',
		'atport'			=> 'auf Port',
		'recv_response' 	=> 'IP Antwort erhalten von',
		'second'			=> 'Sekunde(n)',
		'discover_local'	=> 'Suchen Sie im lokalen Netzwerk nach verfügbaren Geräten',
		'err_sock_bind' 	=> 'Fehler beim Binden des Sockets an die Adresse',
		'ok_sock_bind'		=> 'Socket erfolgreich an Adresse gebunden: ',
		'cmdtosend' 		=> 'Kommando gesendet.',
		'dev_withip'		=> 'Gerät mit IP',
		'nohello'			=> 'hat nicht auf hello-Anfrage geantwortet!',
		'ok_json'			=> 'JSON Daten sind gültig.',
		'err_json'			=> 'JSON-Daten sind ungültig. Der Fehler ist:',
		'send_timeout'		=> 'Sende Paket an',
		'timeout'			=> 'mit Timeout',
		'recvd_token'		=> 'Das vom Gerät empfangene Token wird verwendet.',
		'tokmanu'			=> 'Verwendetes Token manuell angegeben',
		
		]; 