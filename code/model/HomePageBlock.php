<?php
/**
 * Created by IntelliJ IDEA.
 * User: Werner M. Krauß <werner.krauss@netwerkstatt.at>
 * Date: 28.10.2015
 * Time: 12:02
 */

/**
 * StartGeneratedWithDataObjectAnnotator
 * @property string Title
 * @property string Content
 * @property string LinkText
 * @property string ExternalLinkURL
 * @property boolean IsActive
 * @property int SortOrder
 * @property int HomePageID
 * @property int LinkToPageID
 * @method HomePage HomePage
 * @method Page LinkToPage
 * EndGeneratedWithDataObjectAnnotator
 */
class HomePageBlock extends DataObject
{

    private static $db = [
        'Title' => 'Varchar(64)',
        'Content' => 'HTMLText',
        'LinkText' => 'Varchar(64)',
        'ExternalLinkURL' => 'Varchar(255)',
        'IsActive' => 'Boolean',
        'SortOrder' => 'Int'
    ];

    private static $has_one = [
        'HomePage' => 'HomePage',
        'LinkToPage' => 'Page'
    ];

    private static $singular_name = 'Home page block';

    private static $plural_name = 'Home page blocks';

    private static $summary_fields = [
        'Title', 'IsActive'
    ];

    private static $default_sort = 'SortOrder';

    /**
     * for configuring fluent
     * @var array
     */
    private static $translate = [
        'Title',
        'Content',
        'LinkText',
        'ExternalLinkURL'
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $linkTo = $fields->dataFieldByName('LinkToPageID')->setEmptyString('-- bitte auswählen --');

        $fields->removeByName(['SortOrder', 'HomePageID', 'LinkToPageID']);

        $fields->insertAfter('LinkText', $linkTo);

        $this->extend('updateCMSFields', $fields);

        return $fields;
    }

    public function getLink()
    {
        $link = $this->LinkToPageID && $this->LinkToPage()
            ? $this->LinkToPage()->Link()
            : $this->ExternalLinkURL;

        $this->extend('updateLink', $link);

        return $link;
    }
}
