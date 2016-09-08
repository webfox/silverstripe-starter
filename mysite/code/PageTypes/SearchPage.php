<?php

class SearchPage extends Page
{

    function requireDefaultRecords()
    {
        if (!SiteTree::get_by_link('Search')) {
            $homepage = class_exists('SearchPage') ? new SearchPage() : new Page();
            $homepage->Title = _t('SiteTree.DEFAULTSEARCHTITLE', 'Search');
            $homepage->Content = _t('SiteTree.DEFAULTSEARCHCONTENT', '');
            $homepage->URLSegment = 'Search';
            $homepage->Status = 'Published';
            $homepage->Sort = 1;
            $homepage->write();
            $homepage->publish('Stage', 'Live');
            $homepage->flushCache();
            DB::alteration_message('Search page created', 'created');
        }
    }

    private static $defaults = [
        'ShowInMenus' => false,
        'ShowInSearch' => false
    ];

    public function canView($member = null)
    {
        return parent::canView($member);
    }

    public function canEdit($member = null)
    {
        return false;
    }

    public function canDelete($member = null)
    {
        return false;
    }

    public function canCreate($member = null)
    {
        return false;
    }
}

class SearchPage_Controller extends Page_Controller
{

}
