<?php

abstract class DB_LibraryLinkedObject extends DataObject {
	/**
	 * @return int[]
	 */
	public abstract function getLibraries(): ?array;

	public function okToExport(array $selectedFilters): bool {
		$okToExport = parent::okToExport($selectedFilters);
		$selectedLibraries = $selectedFilters['libraries'];
		foreach ($selectedLibraries as $libraryId) {
			if (array_key_exists($libraryId, $this->getLibraries())) {
				$okToExport = true;
				break;
			}
		}
		return $okToExport;
	}

	public function getLinksForJSON(): array {
		$links = [];
		$allLibraries = Library::getLibraryListAsObjects(false);
		$libraries = $this->getLibraries();
		$links['libraries'] = [];
		foreach ($libraries as $libraryId) {
			if (array_key_exists($libraryId, $allLibraries)) {
				$library = $allLibraries[$libraryId];
				$links['libraries'][$libraryId] = empty($library->subdomain) ? $library->ilsCode : $library->subdomain;
			}
		}
		return $links;
	}

	public function loadRelatedLinksFromJSON($jsonLinks, $mappings, $overrideExisting = 'keepExisting'): bool {
		$result = parent::loadRelatedLinksFromJSON($jsonLinks, $mappings);
		if (array_key_exists('libraries', $jsonLinks)) {
			$allLibraries = Library::getLibraryListAsObjects(false);
			$libraries = [];
			foreach ($jsonLinks['libraries'] as $subdomain) {
				if (array_key_exists($subdomain, $mappings['libraries'])) {
					$subdomain = $mappings['libraries'][$subdomain];
				}
				foreach ($allLibraries as $tmpLibrary) {
					if ($tmpLibrary->subdomain == $subdomain || $tmpLibrary->ilsCode == $subdomain) {
						$libraries[$tmpLibrary->libraryId] = $tmpLibrary->libraryId;
						break;
					}
				}
			}
			$this->_libraries = $libraries;
			$result = true;
		}
		return $result;
	}

	public function toArray($includeRuntimeProperties = true, $encryptFields = false): array {
		//Unset libraries since they will be added as links
		$return = parent::toArray($includeRuntimeProperties, $encryptFields);
		unset($return['libraries']);
		return $return;
	}
}
