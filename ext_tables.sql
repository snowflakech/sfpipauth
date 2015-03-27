#
# Table structure for table 'tx_sfpipauth_ipconfiguration'
#
CREATE TABLE tx_sfpipauth_ipconfiguration (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,

	name tinytext NOT NULL,
	ip tinytext NOT NULL,
	feusers blob NOT NULL,
	fegroups blob NOT NULL,
	loginmode tinyint(4) DEFAULT '1' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);
