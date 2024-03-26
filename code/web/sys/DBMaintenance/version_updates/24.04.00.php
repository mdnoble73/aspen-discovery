<?php

function getUpdates24_04_00(): array {
	$curTime = time();
	return [
		/*'name' => [
			 'title' => '',
			 'description' => '',
			 'continueOnError' => false,
			 'sql' => [
				 ''
			 ]
		 ], //name*/

		//mark - ByWater

		//kirstien - ByWater

		//kodi - ByWater

		//lucas - Theke
			'store_files_into_database' => [
				'title' => 'Store files into database',
				'description' => 'New column for uploaded files as blobs',
				'continueOnError' => false,
				'sql' => [
					"ALTER TABLE file_uploads ADD COLUMN IF NOT EXISTS uploadedFileData LONGBLOB DEFAULT NULL",
				]
			],

			'store_image_into_database' => [
				'title' => 'Store images into database',
				'description' => 'New column for uploaded images as blobs',
				'continueOnError' => false,
				'sql' => [
					"ALTER TABLE image_uploads ADD COLUMN IF NOT EXISTS fullSizeImageData LONGBLOB DEFAULT NULL",
				]
			],

			'store_custom_fonts_into_database' => [
				'title' => 'Store custom fonts into database',
				'description' => 'New columns for uploaded custom fonts as blobs',
				'continueOnError' => false,
				'sql' => [
					"ALTER TABLE themes ADD COLUMN IF NOT EXISTS customHeadingFontData LONGBLOB DEFAULT NULL",
					"ALTER TABLE themes ADD COLUMN IF NOT EXISTS customBodyFontData LONGBLOB DEFAULT NULL",
				]
			],

			'migrate_uploaded_files' => [
				'title' => 'Migrate uploaded files to store into database',
				'description' => 'Migrate uploaded files to store into database',
				'continueOnError' => true,
				'sql' => [
					'migrateUploadedFiles'
				]
			]

		//alexander - PTFS Europe

		//jacob - PTFS Europe

		// James Staub


	];


}

function migrateUploadedFiles(&$update) {
	require_once ROOT_DIR . 'sys/File/FileUpload.php';
	$uploadedFile = new FileUpload();
	$uploadedFile->find();
	$numUpdates = 0;
	while ($uploadedFile->fetch()){
		if (isset($uploadedFile->fullPath) && !isset($uploadedFile->uploadedFileData)){
			$dataFromPath = file_get_contents($uploadedFile->fullPath);
			$uploadedFile->uploadedFileData = $dataFromPath;
			unset($uploadedFile->fullPath);
			$numUpdates+= $uploadedFile->insert();
		}
	}
	$update['status'] = "<strong>Migrated $numUpdates uploaded files</strong><br/>";
	$update['success'] = true;
}