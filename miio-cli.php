#!/usr/bin/php
<?php
/* 
*	Реализация взаимодействия с wifi-устройствами из экосистемы xiaomi по протоколу miIO.
*
*	Интерфейс командной строки.
*		
*	Принимаемые параметры:
*		--discover all	поиск устройств в локальной сети и вывод информации о них
*		--discover IP	проверка доступности конкретного устройства и вывод информации о нем
*		--info			получить информацию об устройстве (аналог --discover IP)
*		--sendcmd		отправить команду (в linux д.б. заключена в одинарные кавычки, в windows без них)
*		--decode		расшифровать пакет
*		--ip			IP-адрес устройства
*		--bindip		IP-адрес интерфейса сервера (не обязательно, если интерфейс один)
*		--token			токен устройства
*		--debug			включает вывод отладочной информации
*		--help			справка по командам
*	
*	Примеры:
*		php miio-cli.php --discover all
*		php miio-cli.php --discover all --bindip 192.168.1.10
*		php miio-cli.php --discover 192.168.1.45 --debug
*		php miio-cli.php --ip 192.168.1.45 --info
*		php miio-cli.php --ip 192.168.1.45 --sendcmd '{"method":"toggle",,"params":[],"id":1}'
*		php miio-cli.php --ip 192.168.1.47 --sendcmd '{"id":1,"method":"get_prop","params":["power"]}'
*		php miio-cli.php --token b31c928032e6a4afc898c5c8768a518f --decode 2131004000000000035afe...bea030
*
*	Copyright (C) 2017 Agaphonov Dmitri aka skysilver [mailto:skysilver.da@gmail.com]
*/

require('miio.class.php');
//add language file:
$l = [];

@include('i18n/de.php');

error_reporting(-1);
ini_set('display_errors', 1);
function l($k,$a) {
	global $l;
	return l[$k] ? $l[$k] : $a;
}
$bind_ip = null;

$opts = getopt('d::', array('ip:', 'token:', 'info', 'discover:', 'sendcmd:', 'decode:', 'debug', 'help', 'bindip:', 'decode:'));

if ( empty($opts) || isset($opts['help']) ) {
	echo PHP_EOL;
	echo @l('usage_0',	'Управление wifi-устройствами из экосистемы xiaomi по протоколу miIO. Версия 0.2.6' . PHP_EOL);
	echo PHP_EOL;
	echo @l('usage_1',	'Принимаемые параметры:' . PHP_EOL);
	echo @l('usage_2', 	'	--discover all	поиск устройств в локальной сети и вывод информации о них' . PHP_EOL);
	echo @l('usage_3', 	'	--discover IP	проверка доступности конкретного устройства и вывод информации о нем' . PHP_EOL);
	echo @l('usage_4', 	'	--info		получить информацию об устройстве (аналог --discover IP)' . PHP_EOL);
	echo @l('usage_5', 	'	--sendcmd	отправить команду (в linux д.б. заключена в одинарные кавычки, в windows без них)' . PHP_EOL);
	echo @l('usage_6', 	'	--decode	расшифровать пакет' . PHP_EOL);
	echo @l('usage_7', 	'	--ip 		IP-адрес устройства' . PHP_EOL);
	echo @l('usage_8', 	'	--bindip	IP-адрес интерфейса сервера (не обязательно, если интерфейс один)' . PHP_EOL);
	echo @l('usage_9', 	'	--token 	токен устройства' . PHP_EOL);
	echo @l('usage_10',	'	--debug		включает вывод отладочной информации' . PHP_EOL);
	echo @l('usage_11',	'	--help		справка по командам' . PHP_EOL);
	echo PHP_EOL;
	echo @l('usage_12', 'Примеры:' . PHP_EOL);
	echo 				'	php miio-cli.php --discover all' . PHP_EOL;
	echo 				'	php miio-cli.php --discover all --bindip 192.168.1.10' . PHP_EOL;
	echo 				'	php miio-cli.php --discover 192.168.1.45 --debug' . PHP_EOL;
	echo 			 	'	php miio-cli.php --ip 192.168.1.45 --info' . PHP_EOL;
	echo 			 	'	php miio-cli.php --ip 192.168.1.45 --sendcmd \'{"method":"toggle",,"params":[],"id":1}\'' . PHP_EOL;
	echo 			 	'	php miio-cli.php --ip 192.168.1.47 --sendcmd \'{"id":1,"method":"get_prop","params":["power"]}\'' . PHP_EOL;
	echo 			 	'	php miio-cli.php --token b31c928032e6a4afc898c5c8768a518f --decode 2131004000000000035afe...bea030' . PHP_EOL;
	
}
if ( isset($opts['debug']) ) $debug = true;
 else $debug = false;

if ($debug) var_dump($opts);
 
if ( isset($opts['bindip']) && !empty($opts['bindip']) ) $bind_ip = $opts['bindip'];
 
if ( isset($opts['discover']) && !empty($opts['discover']) ) {
	if ( $opts['discover'] == 'all' ) {
		echo @l('discover_0','Поиск всех') . PHP_EOL;
		cbDiscoverAll($bind_ip, $debug);
	} else {
		echo @l('search','Поиск') . ' ' . $opts['discover'] . PHP_EOL;
		cbDiscoverIP($opts['discover'], $bind_ip, $debug);
	}
}

if ( isset($opts['info']) && empty($opts['ip']) ) {
	echo @l('require_ip','Необходимо указать ip-адрес устройства через параметр --ip') . PHP_EOL;
	echo '	php miio-cli.php --ip 192.168.1.45 --info' . PHP_EOL;
} else if (isset($opts['info']) && !empty($opts['ip'])) {
	if (isset($opts['token']) && !empty($opts['token'])) $dev = new miIO($opts['ip'], $bind_ip, $opts['token'], $debug);
	 else $dev = new miIO($opts['ip'], $bind_ip, null, $debug);
	
	//echo PHP_EOL . 'Отправка предварительного широковещательного hello-пакета' . PHP_EOL;
	//$dev->fastDiscover();
	
	echo PHP_EOL . @l('autogen_id','Используем авто-формирование уникальных ID для команд из файла id.json') . PHP_EOL;
	$dev->useAutoMsgID = true;
	
	if ($dev->getInfo() == true) {
		echo @l('dev_info','Информация об устройстве') . ':' . PHP_EOL;
		echo $dev->data . PHP_EOL;
	} else {
		echo @l('dev_noreact','Устройство не отвечает') . '.' . PHP_EOL;
	}
}

if ( isset($opts['sendcmd']) && empty($opts['ip']) ) {
	echo @l('require_ip','Необходимо указать ip-адрес устройства через параметр --ip') . PHP_EOL;
	echo '	php miio-cli.php --ip 192.168.1.45 --info' . PHP_EOL;
} else if (isset($opts['sendcmd']) && empty($opts['sendcmd']) && !empty($opts['ip'])) {
	echo @l('require_cmd','Необходимо указать команду') . PHP_EOL;
	echo '	php miio-cli.php --ip 192.168.1.45 --sendcmd \'{\'method\': \'get_status\', \'id\': 1}\'' . PHP_EOL;
} else if (!empty($opts['sendcmd']) && !empty($opts['ip'])) {
	if (isset($opts['token']) && !empty($opts['token'])) $dev = new miIO($opts['ip'], $bind_ip, $opts['token'], $debug);
	 else $dev = new miIO($opts['ip'], $bind_ip, null, $debug);
	if ($dev->msgSendRcvRaw($opts['sendcmd']) == true) {
		echo @l('device',"Устройство").' '.$dev->ip.' '. @l('has_answered','доступно и ответило') . ':' . PHP_EOL;
		echo $dev->data . PHP_EOL;
	} else {
		echo @l('device',"Устройство").' '.$dev->ip. ' '. @l('hasnt_answered','не доступно или не отвечает.') . PHP_EOL;
	}
}

if ( isset($opts['decode']) && empty($opts['token']) ) {
	echo @l('require_token','Необходимо указать токен устройства через параметр --token'). PHP_EOL;
} else if (isset($opts['decode']) && !empty($opts['decode']) && isset($opts['token']) && !empty($opts['token'])) {
	$miPacket = new miPacket();	
	$miPacket->setToken($opts['token']);
	$miPacket->msgParse($opts['decode']);
	if ($debug) $miPacket->printPacket();
	$data_dec = $miPacket->decryptData($miPacket->data);	
	echo @l('decoded','Расшифрованные данные'). ": $data_dec" . PHP_EOL;
}

function cbDiscoverAll ($bind_ip, $debug) {
	
	$dev = new miIO(null, $bind_ip, null, $debug);
	
	//echo PHP_EOL . 'Отправка предварительного широковещательного hello-пакета' . PHP_EOL;
	//$dev->fastDiscover();
	
	if ($dev->discover() == true) {
		echo @l('searched','Поиск выполнен.') .  PHP_EOL;
		$devices = json_decode($dev->data);
		$count = count($devices->devices);
		echo @l('found','Найдено')." $count " . @l('devices','устройств') . '.'. PHP_EOL;
		foreach($devices->devices as $dev) {
			$devprop = json_decode($dev);
			echo 	' IP ' . 		$devprop->ip . 
					' DevType ' . 	$devprop->devicetype . 
					' Serial ' . 	$devprop->serial . 
					' Token ' . 	$devprop->token . PHP_EOL;
		}
	} else {
		echo @l('no_devices','Поиск выполнен. Устройств не найдено.') . PHP_EOL;
	}
}

function cbDiscoverIP ($ip, $bind_ip, $debug) {
	
	$dev = new miIO($ip, $bind_ip, null, $debug);

	if ($dev->discover($ip) == true) {
		echo @l('searched','Поиск выполнен.') . PHP_EOL;
		echo @l('searched_ok','Устройство найдено и отвечает.') . PHP_EOL;
	} else {
		echo @l('searched_fail','Поиск выполнен. Устройств не найдено.') . PHP_EOL;
	}
	
}
