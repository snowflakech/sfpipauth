<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$_EXTCONF = unserialize($_EXTCONF);
$GLOBALS['TYPO3_CONF_VARS']['SVCONF']['auth']['setup']['FE_fetchUserIfNoSession']= isset($_EXTCONF['fetchUserIfNoSession']) ? $_EXTCONF['fetchUserIfNoSession'] : 1;

t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_sfpipauth_ipconfiguration=1
');

t3lib_extMgm::addService($_EXTKEY, 'auth',  'tx_sfpipauth_sv1',
	array(
		'title' => 'Finds IP-FE-User',
		'description' => 'Finds FE-Users/groups via IP',

		'subtype' => 'authUserFE,getUserFE,getGroupsFE',

		'available' => TRUE,
		'priority' => 60,
		'quality' => 50,

		'os' => '',
		'exec' => '',

		'classFile' => t3lib_extMgm::extPath($_EXTKEY).'sv1/class.tx_sfpipauth_sv1.php',
		'className' => 'tx_sfpipauth_sv1',
	)
);

t3lib_extMgm::addService($_EXTKEY, 'auth',  'tx_sfpipauth_sv2',
	array(
		'title' => 'IP-Auth FE-User',
		'description' => 'Authenticates FE-Users/groups via IP',

		'subtype' => 'authUserFE,authGroupsFE',

		'available' => TRUE,
		'priority' => 40,
		'quality' => 50,

		'os' => '',
		'exec' => '',

		'classFile' => t3lib_extMgm::extPath($_EXTKEY).'sv2/class.tx_sfpipauth_sv2.php',
		'className' => 'tx_sfpipauth_sv2',
	)
);
?>
