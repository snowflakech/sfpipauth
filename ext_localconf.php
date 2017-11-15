<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService(
	$_EXTKEY,
	'auth',
	'tx_sfpipauth_ip_authentication_service',
	array (
		'title' => 'IP-Auth FE-User',
		'description' => 'Authenticates FE-Users/groups via IP',
		'subtype' => 'authUserFE,getUserFE',
		'available' => TRUE,
		'priority' => 75,
		'quality' => 75,
		'os' => '',
		'exec' => '',
		'className' => 'Snowflake\\Sfpipauth\\Service\\IpAuthenticationService'
	)
);


// Extension Configuration
$extensionConfiguration = unserialize($_EXTCONF);
$GLOBALS['TYPO3_CONF_VARS']['SVCONF']['auth']['setup']['FE_fetchUserIfNoSession'] =
	isset($extensionConfiguration['fetchUserIfNoSession'])
		? $extensionConfiguration['fetchUserIfNoSession']
		: 1;

// User TS Config
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig('options.saveDocNew.tx_sfpipauth_ipconfiguration=1');
