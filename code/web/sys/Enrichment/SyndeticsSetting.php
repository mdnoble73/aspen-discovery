<?php


class SyndeticsSetting extends DataObject
{
	public $__table = 'syndetics_settings';    // table name
	public $id;
	public $syndeticsKey;
	public $syndeticsUnbound;
	public $unboundAccountNumber;
	public $hasSummary;
	public $hasAvSummary;
	public $hasAvProfile;
	public $hasToc;
	public $hasExcerpt;
	public $hasFictionProfile;
	public $hasAuthorNotes;
	public $hasVideoClip;

	public function getNumericColumnNames()
	{
		return ['hasSummary', 'hasAvSummary', 'hasAvProfile', 'hasToc', 'hasExcerpt', 'hasFictionProfile', 'hasAuthorNotes', 'hasVideoClip'];
	}

	public static function getObjectStructure()
	{
		return array(
			'id' => array('property' => 'id', 'type' => 'label', 'label' => 'Id', 'description' => 'The unique id'),
			'syndeticsKey' => array('property' => 'syndeticsKey', 'type' => 'text', 'label' => 'Syndetics Key', 'description' => 'The Key for the subscription'),
			'syndeticsUnbound' => array('property' => 'syndeticsUnbound', 'type' => 'checkbox', 'label' => 'Syndetics Unbound', 'description' => 'Check this option if this is a Syndetics Unbound Subscription', 'default' => 0),
			'unboundAccountNumber' => array('property' => 'unboundAccountNumber', 'type' => 'integer', 'label' => 'Unbound Account Number', 'description' => 'Enter the account number for syndetics unbound', 'default' => 0),
			'hasSummary' => array('property' => 'hasSummary', 'type' => 'checkbox', 'label' => 'Has Summary', 'description' => 'Whether or not the summary is available in the subscription', 'default' => 1),
			'hasAvSummary' => array('property' => 'hasAvSummary', 'type' => 'checkbox', 'label' => 'Has Audio Visual Summary', 'description' => 'Whether or not the summary is available in the subscription'),
			'hasAvProfile' => array('property' => 'hasAvProfile', 'type' => 'checkbox', 'label' => 'Has Audio Visual Profile', 'description' => 'Whether or not the summary is available in the subscription'),
			'hasToc' => array('property' => 'hasToc', 'type' => 'checkbox', 'label' => 'Has Table of Contents', 'description' => 'Whether or not the table of contents is available in the subscription', 'default' => 1),
			'hasExcerpt' => array('property' => 'hasExcerpt', 'type' => 'checkbox', 'label' => 'Has Excerpt', 'description' => 'Whether or not the excerpt is available in the subscription', 'default' => 1),
			'hasFictionProfile' => array('property' => 'hasFictionProfile', 'type' => 'checkbox', 'label' => 'Has Fiction Profile', 'description' => 'Whether or not the excerpt is available in the subscription'),
			'hasAuthorNotes' => array('property' => 'hasAuthorNotes', 'type' => 'checkbox', 'label' => 'Has Author Notes', 'description' => 'Whether or not author notes are available in the subscription'),
			'hasVideoClip' => array('property' => 'hasVideoClip', 'type' => 'checkbox', 'label' => 'Has Video Clip', 'description' => 'Whether or not the excerpt is available in the subscription'),
		);
	}
}