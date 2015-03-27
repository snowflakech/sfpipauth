<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}
// Add the services
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService(
	$_EXTKEY,
	'auth',
	'Snowflake\\Sfpipauth\\Service\\FindUserGroupService',
	array (
		'title' => 'Find IP-FE-User',
		'description' => 'Find FE-Users/groups via IP',
		'subtype' => 'authUserFE,getUserFE,getGroupsFE',
		'available' => TRUE,
		'priority' => 60,
		'quality' => 50,
		'os' => '',
		'exec' => '',
		'className' => 'Snowflake\\Sfpipauth\\Service\\FindUserGroupService'
	)
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService(
	$_EXTKEY,
	'auth',
	'Snowflake\\Sfpipauth\\Service\\IpAuthenticationService',
	array (
		'title' => 'IP-Auth FE-User',
		'description' => 'Authenticates FE-Users/groups via IP',
		'subtype' => 'authUserFE,authGroupsFE',
		'available' => TRUE,
		'priority' => 40,
		'quality' => 50,
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
