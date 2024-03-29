<?php
/** @noinspection PhpUnused */
function getUpdates22_06_10(): array {
	return [
		/*'name' => [
			'title' => '',
			'description' => '',
			'sql' => [
				''
			]
		], //sample*/
		'increase_course_reserves_source_length' => [
			'title' => 'Increase Course Reserves Source Length',
			'description' => 'Allow sourceId to be longer for course reserves entries',
			'sql' => [
				'ALTER TABLE course_reserve_entry CHANGE sourceId sourceId VARCHAR(40) COLLATE utf8mb4_general_ci DEFAULT NULL',
			],
		],
		//increase_course_reserves_source_length
		'ebscohost_search_settings' => [
			'title' => 'EBSCOhost search settings',
			'description' => 'Add configuration of database searching for EBSCOhost',
			'continueOnError' => true,
			'sql' => [
				'CREATE TABLE ebscohost_database (
					id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
					searchSettingId INT NOT NULL,
					shortName VARCHAR(50) NOT NULL,
					displayName VARCHAR(50) NOT NULL,
					allowSearching TINYINT DEFAULT 1,
					searchByDefault TINYINT DEFAULT 1, 
					showInExploreMore TINYINT DEFAULT 0,
					showInCombinedResults TINYINT DEFAULT 0
				) ENGINE INNODB',
				'CREATE TABLE ebscohost_search_options (
					id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
					name VARCHAR(50) NOT NULL,
					settingId INT(11) NOT NULL
				) ENGINE INNODB',
				'ALTER TABLE library ADD COLUMN ebscohostSearchSettingId INT(11) DEFAULT -1',
				'ALTER TABLE location ADD COLUMN ebscohostSearchSettingId INT(11) DEFAULT -2',
			],
		],
		//ebscohost_search_settings
		'ebscohost_facets' => [
			'title' => 'EBSCOhost facets',
			'description' => 'Store EBSCOhost facet names',
			'continueOnError' => true,
			'sql' => [
				'CREATE TABLE ebscohost_facet (
					id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
					shortName VARCHAR(50) NOT NULL UNIQUE,
					displayName VARCHAR(100) NOT NULL
				) ENGINE INNODB',
			],
		],
		//ebscohost_facets
		'ebscohost_ip_addresses' => [
			'title' => 'EBSCOhost IP Address configuration',
			'description' => 'Allow configuration of which IP Addresses should automatically authenticate with EBSCOhost',
			'continueOnError' => true,
			'sql' => [
				'ALTER TABLE ip_lookup ADD COLUMN authenticatedForEBSCOhost TINYINT DEFAULT 0',
			],
		],
		//ebscohost_ip_addresses
		'track_ebscohost_user_usage' => [
			'title' => 'EBSCOhost Usage by user',
			'description' => 'Add a table to track how often a particular user uses EBSCOhost.',
			'sql' => [
				"CREATE TABLE user_ebscohost_usage (
				    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
				    userId INT(11) NOT NULL,
				    instance VARCHAR(100),
				    month INT(2) NOT NULL,
				    year INT(4) NOT NULL,
				    usageCount INT(11)
				) ENGINE = InnoDB",
				"ALTER TABLE user_ebscohost_usage ADD INDEX (year, month, instance, userId)",
			],
		],
		//track_ebscohost_user_usage
		'ebscohost_record_usage' => [
			'title' => 'EBSCOhost Usage',
			'description' => 'Add a table to track how EBSCOhost is used.',
			'continueOnError' => true,
			'sql' => [
				"CREATE TABLE ebscohost_usage (
				    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
				    instance VARCHAR(100),
				    ebscohostId VARCHAR(50) NOT NULL,
				    month INT(2) NOT NULL,
				    year INT(4) NOT NULL,
				    timesViewedInSearch INT(11) NOT NULL,
				    timesUsed INT(11) NOT NULL
				) ENGINE = InnoDB",
				"ALTER TABLE ebscohost_usage ADD INDEX (ebscohostId, year, instance, month)",
			],
		],
		//ebscohost_record_usage
		'aspen_usage_ebscohost' => [
			'title' => 'Aspen Usage for EBSCOhost Searches',
			'description' => 'Add a column to track usage of EBSCOhost searches within Aspen',
			'continueOnError' => false,
			'sql' => [
				'ALTER TABLE aspen_usage ADD COLUMN ebscohostSearches INT(11) DEFAULT 0',
			],
		],
		//aspen_usage_ebscohost
		'add_image_to_ebscohost_database' => [
			'title' => 'Add image to EBSCOhost Databases',
			'description' => 'Add image to EBSCOhost Databases',
			'sql' => [
				'ALTER TABLE ebscohost_database ADD COLUMN logo VARCHAR(512) NOT NULL',
			],
		],
		//add_image_to_ebscohost_database
		'add_sort_info_to_ebscohost_database' => [
			'title' => 'Add sort info to EBSCOhost Databases',
			'description' => 'Add column to store if a database has date and relevancy sorting to EBSCOhost Databases',
			'continueOnError' => true,
			'sql' => [
				'ALTER TABLE ebscohost_database ADD COLUMN hasDateAndRelevancySorting TINYINT(1) DEFAULT 1',
				'UPDATE ebscohost_database set hasDateAndRelevancySorting = searchByDefault',
			],
		],
		//add_sort_info_to_ebscohost_database
		'ebscohost_remove_authType' => [
			'title' => 'Remove EBSCOhost auth type',
			'description' => 'Remove unused columns',
			'continueOnError' => true,
			'sql' => [
				'ALTER TABLE ebscohost_settings DROP COLUMN authType',
				'ALTER TABLE ebscohost_settings DROP COLUMN ipProfileId',
			],
		],
		//ebscohost_remove_authType
		'ebscohost_database_logo_default' => [
			'title' => 'Set a default for database logo',
			'description' => 'Set a default for database logo',
			'sql' => [
				"ALTER TABLE ebscohost_database CHANGE COLUMN logo logo VARCHAR(512) DEFAULT ''",
			],
		],
		//ebscohost_database_logo_default
	];
}
