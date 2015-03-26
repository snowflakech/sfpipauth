<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_sfpipauth_ipconfiguration'] = array (
	'ctrl' => $TCA['tx_sfpipauth_ipconfiguration']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,name,ip,feusers,fegroups,loginmode'
	),
	'feInterface' => $TCA['tx_sfpipauth_ipconfiguration']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'name' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:sfpipauth/locallang_db.xml:tx_sfpipauth_ipconfiguration.name',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required',
			)
		),
		'ip' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:sfpipauth/locallang_db.xml:tx_sfpipauth_ipconfiguration.ip',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required',
			)
		),
		'feusers' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:sfpipauth/locallang_db.xml:tx_sfpipauth_ipconfiguration.feusers',		
			'config' => array (
				'type' => 'group',	
				'internal_type' => 'db',	
				'allowed' => 'fe_users',	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'fegroups' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:sfpipauth/locallang_db.xml:tx_sfpipauth_ipconfiguration.fegroups',		
			'config' => array (
				'type' => 'group',	
				'internal_type' => 'db',	
				'allowed' => 'fe_groups',	
				'size' => 5,	
				'minitems' => 0,
				'maxitems' => 9999,
			)
		),
		'loginmode' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:sfpipauth/locallang_db.xml:tx_sfpipauth_ipconfiguration.loginmode',
			'config' => array (
				'type' => 'select',
				'items' => array(
					array('LLL:EXT:sfpipauth/locallang_db.xml:tx_sfpipauth_ipconfiguration.loginmode.I.1', 1),
					array('LLL:EXT:sfpipauth/locallang_db.xml:tx_sfpipauth_ipconfiguration.loginmode.I.2', 2),
					array('LLL:EXT:sfpipauth/locallang_db.xml:tx_sfpipauth_ipconfiguration.loginmode.I.3', 3),
					array('LLL:EXT:sfpipauth/locallang_db.xml:tx_sfpipauth_ipconfiguration.loginmode.I.0', 0),
				),
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, name, ip, feusers, fegroups, loginmode')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
?>
