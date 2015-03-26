<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_extMgm::allowTableOnStandardPages('tx_sfpipauth_ipconfiguration');

$TCA['tx_sfpipauth_ipconfiguration'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:sfpipauth/locallang_db.xml:tx_sfpipauth_ipconfiguration',		
		'label'     => 'name',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon.gif',
	),
);
?>
