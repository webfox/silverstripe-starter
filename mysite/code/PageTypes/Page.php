<?php

/**
 * Base page type
 */
class Page extends SiteTree {

	#region Declarations

	/**
	 * Additional fields which are available to all pages
	 * @var array
	 */
	private static $db = [
		'PreviewText' => 'Text'
	];

	#endregion Declarations

	#region Relationships

	/**
	 * One to one relations
	 * @var array
	 */
	private static $has_one = [];

	/**
	 * One to many relations
	 * @var array
	 */

	private static $extensions = [
	];

	#endregion Relationships

	#region Private Methods

	#endregion Private Methods

	#region Public Methods

	public function getCMSFields() {

		$this->beforeUpdateCMSFields(function (FieldList $fields) {
			//
		});

		$fields = parent::getCMSFields();

		$fields->addFieldToTab('Root.Metadata', TextareaField::create('PreviewText'));


		Requirements::customCSS(
			<<<CSS
			.htmleditor label.left {
    			width: 100%;
			}
CSS
		);

		return $fields;
	}

	/**
	 * Validation which is applied to all pages
	 * @return RequiredFields
	 */
	public function getCMSValidator() {
		return new RequiredFields(
			[]
		);
	}

	/**
	 * Set to return true if this page should not show it's children in the nav
	 *
	 * @return bool
	 */
	public function HideChildrenFromNavigation() {
		return false;
	}

	/**
	 * Set to return false if this page should not be added to as the first child of it's dropdown list if it is a parent
	 *
	 * @return bool
	 */
	public function ShowInDropdownIfParent() {
		return true;
	}

	/**
	 * Returns the site default meta tags
	 * This overload also checks if the domain contains one of our non-indexable domains
	 * If it does it adds the noindex meta tag.
	 *
	 * @param bool $includeTitle
	 *
	 * @return string
	 */
	public function MetaTags($includeTitle = true) {
		$tags          = parent::MetaTags($includeTitle);
		$domains       = Config::inst()->get('Development', 'NoIndexDomains');
		$currentDomain = strtolower(Director::protocolAndHost());
		if (is_array($domains) && !empty($domains)) {
			foreach ($domains as $nonIndexableDomain) {
				if (strpos($currentDomain, strtolower($nonIndexableDomain)) !== false) {
					return $tags . '<meta name="robots" content="noindex">';
				}
			}
		}

		return $tags;
	}

	#endregion Public Methods

}

/**
 * Base page controller
 */
class Page_Controller extends ContentController {

	#region Declarations

	private static $allowed_actions = [];

	#endregion Declarations

	#region Public Methods

	public function init() {
		parent::init();
	}

	#endregion Public Methods

}
