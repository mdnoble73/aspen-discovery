<?php

require_once ROOT_DIR . '/Action.php';
require_once ROOT_DIR . '/services/Admin/ObjectEditor.php';
require_once ROOT_DIR . '/sys/ILL/VdxForm.php';

class ILL_VdxForms extends ObjectEditor
{
	function getObjectType() : string
	{
		return 'VdxForm';
	}

	function getToolName() : string
	{
		return 'VdxForms';
	}

	function getModule() : string
	{
		return 'ILL';
	}

	function getPageTitle() : string
	{
		return 'VDX Forms';
	}

	function getAllObjects($page, $recordsPerPage) : array
	{
		$object = new VdxForm();
		$object->limit(($page - 1) * $recordsPerPage, $recordsPerPage);
		$this->applyFilters($object);
		$object->orderBy($this->getSort());
		$object->find();
		$objectList = array();
		while ($object->fetch()) {
			$objectList[$object->id] = clone $object;
		}
		return $objectList;
	}
	function getDefaultSort() : string
	{
		return 'id asc';
	}

	function getObjectStructure() : array
	{
		return VdxForm::getObjectStructure();
	}

	function getPrimaryKeyColumn() : string
	{
		return 'id';
	}

	function getIdKeyColumn() : string
	{
		return 'id';
	}

	function getAdditionalObjectActions($existingObject) : array
	{
		return [];
	}

	function getInstructions() : string
	{
		return '';
	}

	function getBreadcrumbs() : array
	{
		$breadcrumbs = [];
		$breadcrumbs[] = new Breadcrumb('/Admin/Home', 'Administration Home');
		$breadcrumbs[] = new Breadcrumb('/Admin/Home#ill_integration', 'Interlibrary Loan');
		$breadcrumbs[] = new Breadcrumb('/ILL/VdxForms', 'VDX Forms');
		return $breadcrumbs;
	}

	function getActiveAdminSection() : string
	{
		return 'ill_integration';
	}

	function canView() : bool
	{
		return UserAccount::userHasPermission(['Administer All VDX Forms', 'Administer Library VDX Forms']);
	}
}