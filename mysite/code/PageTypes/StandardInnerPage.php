<?php
class StandardInnerPage extends Page {

	protected static $hide_ancestor = 'Page';

	protected static $singular_name = 'Standard Inside Page';
	protected static $plural_name   = 'Standard Inside Page';

	private static $has_many = [
		'ContentBlocks' => 'ContentBlock',
	];

	public function getCMSFields(){

	    $this->beforeUpdateCMSFields(function(FieldList $fields) {
			/** @var GridFieldConfig_RecordEditor $ContentBlocksConfig */
			$ContentBlocksConfig = GridFieldConfig_RecordEditor::create();

			$ContentBlocksConfig->removeComponentsByType("GridFieldAddNewButton");
			$ContentBlocksConfig->addComponent($multiClass = new GridFieldAddNewMultiClass());
			$ContentBlocksConfig->addComponent(new GridFieldOrderableRows('SortOrder'));
			$grid    = GridField::create("ContentBlocks", "Content Blocks", $this->ContentBlocks(), $ContentBlocksConfig);
			$multiClass->setTitle('Add New Content Block');
			$classes = $multiClass->getClasses($grid);
			unset($classes['ContentBlock']);
			$multiClass->setClasses($classes);

			$fields->addFieldToTab('Root.ContentBlocks', $grid);
		});

		$fields = parent::getCMSFields();

		return $fields;
	}

	public function getDisplayedContentBlocks() {
		return $this->ContentBlocks()->filter('Displayed', true);
	}

	public function getHasContentBlocks() {
		return $this->getDisplayedContentBlocks()->Count() > 0;
	}
}

class StandardInnerPage_Controller extends Page_Controller {
}
