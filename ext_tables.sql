#
# Table structure for table 'tx_gomapsap_adress'
#
CREATE TABLE tx_gomapsap_adress (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sorting int(10) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	title tinytext,
	adress tinytext,
	image text,
	imagesize tinyint(3) DEFAULT '0' NOT NULL,
	imageheight int(11) DEFAULT '0' NOT NULL,
	imagewidth int(11) DEFAULT '0' NOT NULL,
	shadow text,
	shadowsize tinyint(3) DEFAULT '0' NOT NULL,
	shadowheight int(11) DEFAULT '0' NOT NULL,
	shadowwidth int(11) DEFAULT '0' NOT NULL,
	text text,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);