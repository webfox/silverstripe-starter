<?php

class ContentBlock extends DataObject {

	protected static $singular_name = 'Content Block';
	protected static $plural_name   = 'Content Blocks';

	private static $db = [
		'Title'     => 'Varchar(255)',
		'Displayed' => 'Boolean',
		'SortOrder' => 'Int'
	];

	private static $summary_fields = [
		'Title'   => 'Title',
		'getType' => 'Type'
	];

	private static $has_one = [
		'Page' => 'Page'

	];

	private static $default_sort = 'SortOrder';

	private static $defaults = [
		'Displayed' => true
	];

	public function getCMSFields() {

		$this->beforeUpdateCMSFields(function (FieldList $fields) {
			$fields->addFieldsToTab('Root.Main', [
				TextField::create('Title'),
				DropdownField::create('Displayed', 'Displayed', [1 => 'Displayed', 0 => 'Hidden']),
			]);
		});

		$fields = parent::getCMSFields();

		$fields->removeByName('SortOrder');
		$fields->removeByName('PageID');

		return $fields;
	}



	function forTemplate() {
		return $this->renderWith(get_class($this));
	}


	public function getType() {
		return $this->i18n_singular_name();
	}

	public function canView($member = null) {
		return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
	}

	public function canEdit($member = null) {
		return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
	}

	public function canDelete($member = null) {
		return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
	}

	public function canCreate($member = null) {
		return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
	}

}