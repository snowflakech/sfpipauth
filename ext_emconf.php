<?php

/***************************************************************
 * Extension Manager/Repository config file.
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
	'title' => 'snowflake: IP Authentication Service',
	'description' => 'This is a very fast service to log in and/or block Users by their IP.',
	'category' => 'services',
	'shy' => 0,
	'version' => '2.1.0',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'stable',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 0,
	'lockType' => '',
	'author' => 'Christoph Buchli',
	'author_email' => 'support@snowflake.ch',
	'author_company' => 'snowflake productions gmbh',
	'CGLcompliance' => NULL,
	'CGLcompliance_note' => NULL,
	'constraints' =>
		array (
			'depends' =>
				array (
					'php' => '5.4-0.0.0',
					'typo3' => '6.2.0-8.7.99'
				),
			'conflicts' =>
				array (),
			'suggests' =>
				array (),
		),
);