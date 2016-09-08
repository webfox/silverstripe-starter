<?php

class BlogPostExtension extends SiteTreeExtension {

    private static $db = [
        'Author' => 'Varchar(255)',
    ];

    public function populateDefaults() {
        if ($member = Member::currentUser()) {
            $this->owner->Author = $member->getName();
        }
    }

    public function updateCmsFields(FieldList $fields) {

        $fields->addFieldToTab('Root.Main', TextField::create('Author'), 'PublishDate');
        $fields->addFieldToTab('Root.Main', UploadField::create('FeaturedImage')->setFolderName('Images/Blog'), 'Content');

        $fields->insertAfter($fields->dataFieldByName('Content'), 'CustomSummary');
        //$fields->insertBefore($customSummaryField, 'Content');

        Requirements::customCSS(
            <<<CSS
			.blog-admin-sidebar ~ .blog-admin-outer > .ss-tabset #SubTitle .middleColumn,
			.blog-admin-sidebar ~ .blog-admin-outer > .ss-tabset #SubTitle input,
			.blog-admin-sidebar ~ .blog-admin-outer > .ss-tabset #FeaturedImage .middleColumn {
    			width: 100%;
    			max-width: 100%;
    			margin-left: 0;
			}

			#Form_EditForm #Title button.update {
				margin-left: 0;
				margin-top: 3px;
			}
CSS
        );

        return $fields;
    }
}