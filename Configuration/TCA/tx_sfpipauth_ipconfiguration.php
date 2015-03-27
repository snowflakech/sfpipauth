<?php
$ll = 'LLL:EXT:sfpipauth/Resources/Private/Language/locallang_db.xlf:';

return array (

	'ctrl' => array (
		'title' => $ll . 'tx_sfpipauth_ipconfiguration',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',
		'delete' => 'deleted',
		'enablecolumns' => array (
			'disabled' => 'hidden',
		),
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('sfpipauth') . 'Resources/Public/Icons/tx_sfpipauth_ipconfiguration.gif',
		'hideTable' => false,
		'dividers2tabs' => 1,
		'searchFields' => 'name, ip'
	),
	'interface' => array (
		'showRecordFieldList' => 'hidden, name, ip,feusers, fegroups, loginmode'
	),
	'types' => array (
		'0' => array ('showitem' => 'name, ip, feusers, fegroups, loginmode, hidden')
	),
	'palettes' => array(
		'canNotCollapse' => '1'
	),
	'columns' => array (
		'hidden' => array(
			'l10n_mode' => 'exclude',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'name' => array (
			'exclude' => 0,
			'label' => $ll . 'tx_sfpipauth_ipconfiguration.name',
			'config' => array (
				'type' => 'input',
				'size' => '30',
				'eval' => 'required',
			)
		),
		'ip' => array (
			'exclude' => 0,
			'label' => $ll . 'tx_sfpipauth_ipconfiguration.ip',
			'config' => array (
				'type' => 'input',
				'size' => '30',
				'eval' => 'required',
			)
		),
		'feusers' => array (
			'exclude' => 0,
			'label' => $ll . 'tx_sfpipauth_ipconfiguration.feusers',
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
			'exclude' => 0,
			'label' => $ll . 'tx_sfpipauth_ipconfiguration.fegroups',
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
			'exclude' => 0,
			'label' => $ll . 'tx_sfpipauth_ipconfiguration.loginmode',
			'config' => array (
				'type' => 'select',
				'items' => array (
					array ($ll . 'tx_sfpipauth_ipconfiguration.loginmode.I.1', 1),
					array ($ll . 'tx_sfpipauth_ipconfiguration.loginmode.I.2', 2),
					array ($ll . 'tx_sfpipauth_ipconfiguration.loginmode.I.3', 3),
					array ($ll . 'tx_sfpipauth_ipconfiguration.loginmode.I.0', 0),
				),
			)
		),
	)

);