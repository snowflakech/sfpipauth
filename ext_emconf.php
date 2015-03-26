<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "sfpipauth".
 *
 * Auto generated 02-04-2013 16:02
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'IP Authentication Service',
	'description' => 'This is a very fast service to log in and/or block Users by their IP.',
	'category' => 'services',
	'shy' => 0,
	'version' => '1.0.0',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'stable',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 1,
	'lockType' => '',
	'author' => 'Christoph Buchli | snowflake productions gmbh',
	'author_email' => 'support@snowflake.ch',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'typo3' => '4.2.0-6.0.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:14:{s:9:"ChangeLog";s:4:"6e83";s:21:"ext_conf_template.txt";s:4:"2fca";s:12:"ext_icon.gif";s:4:"aab5";s:17:"ext_localconf.php";s:4:"1033";s:14:"ext_tables.php";s:4:"1a6a";s:14:"ext_tables.sql";s:4:"e725";s:16:"locallang_db.xlf";s:4:"0abe";s:16:"locallang_db.xml";s:4:"a203";s:10:"README.txt";s:4:"ee2d";s:7:"tca.php";s:4:"7fb1";s:33:"class/class.tx_sfpipauth_main.php";s:4:"59bb";s:14:"doc/manual.sxw";s:4:"1dc8";s:30:"sv1/class.tx_sfpipauth_sv1.php";s:4:"e536";s:30:"sv2/class.tx_sfpipauth_sv2.php";s:4:"b77c";}',
	'suggests' => array(
	),
);

?>