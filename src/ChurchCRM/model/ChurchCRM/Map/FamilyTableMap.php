<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Map;

use ChurchCRM\model\ChurchCRM\Family;
use ChurchCRM\model\ChurchCRM\FamilyQuery;
use Propel\Runtime\ActiveQuery\ColumnResolver\ColumnExpression\LocalColumnExpression;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;
use Propel\Runtime\Propel;


/**
 * This class defines the structure of the 'family_fam' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class FamilyTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'ChurchCRM.model.ChurchCRM.Map.FamilyTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'family_fam';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'Family';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\ChurchCRM\\model\\ChurchCRM\\Family';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'ChurchCRM.model.ChurchCRM.Family';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 22;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 22;

    /**
     * the column name for the fam_ID field
     */
    public const COL_FAM_ID = 'family_fam.fam_ID';

    /**
     * the column name for the fam_Name field
     */
    public const COL_FAM_NAME = 'family_fam.fam_Name';

    /**
     * the column name for the fam_Address1 field
     */
    public const COL_FAM_ADDRESS1 = 'family_fam.fam_Address1';

    /**
     * the column name for the fam_Address2 field
     */
    public const COL_FAM_ADDRESS2 = 'family_fam.fam_Address2';

    /**
     * the column name for the fam_City field
     */
    public const COL_FAM_CITY = 'family_fam.fam_City';

    /**
     * the column name for the fam_State field
     */
    public const COL_FAM_STATE = 'family_fam.fam_State';

    /**
     * the column name for the fam_Zip field
     */
    public const COL_FAM_ZIP = 'family_fam.fam_Zip';

    /**
     * the column name for the fam_Country field
     */
    public const COL_FAM_COUNTRY = 'family_fam.fam_Country';

    /**
     * the column name for the fam_HomePhone field
     */
    public const COL_FAM_HOMEPHONE = 'family_fam.fam_HomePhone';

    /**
     * the column name for the fam_Email field
     */
    public const COL_FAM_EMAIL = 'family_fam.fam_Email';

    /**
     * the column name for the fam_WeddingDate field
     */
    public const COL_FAM_WEDDINGDATE = 'family_fam.fam_WeddingDate';

    /**
     * the column name for the fam_DateEntered field
     */
    public const COL_FAM_DATEENTERED = 'family_fam.fam_DateEntered';

    /**
     * the column name for the fam_DateLastEdited field
     */
    public const COL_FAM_DATELASTEDITED = 'family_fam.fam_DateLastEdited';

    /**
     * the column name for the fam_EnteredBy field
     */
    public const COL_FAM_ENTEREDBY = 'family_fam.fam_EnteredBy';

    /**
     * the column name for the fam_EditedBy field
     */
    public const COL_FAM_EDITEDBY = 'family_fam.fam_EditedBy';

    /**
     * the column name for the fam_scanCheck field
     */
    public const COL_FAM_SCANCHECK = 'family_fam.fam_scanCheck';

    /**
     * the column name for the fam_scanCredit field
     */
    public const COL_FAM_SCANCREDIT = 'family_fam.fam_scanCredit';

    /**
     * the column name for the fam_SendNewsLetter field
     */
    public const COL_FAM_SENDNEWSLETTER = 'family_fam.fam_SendNewsLetter';

    /**
     * the column name for the fam_DateDeactivated field
     */
    public const COL_FAM_DATEDEACTIVATED = 'family_fam.fam_DateDeactivated';

    /**
     * the column name for the fam_Latitude field
     */
    public const COL_FAM_LATITUDE = 'family_fam.fam_Latitude';

    /**
     * the column name for the fam_Longitude field
     */
    public const COL_FAM_LONGITUDE = 'family_fam.fam_Longitude';

    /**
     * the column name for the fam_Envelope field
     */
    public const COL_FAM_ENVELOPE = 'family_fam.fam_Envelope';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * @var class-string<\ChurchCRM\model\ChurchCRM\Base\Collection\FamilyCollection>
     */
    public const DEFAULT_OBJECT_COLLECTION = '\ChurchCRM\model\ChurchCRM\Base\Collection\FamilyCollection';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['Id', 'Name', 'Address1', 'Address2', 'City', 'State', 'Zip', 'Country', 'HomePhone', 'Email', 'Weddingdate', 'DateEntered', 'DateLastEdited', 'EnteredBy', 'EditedBy', 'ScanCheck', 'ScanCredit', 'SendNewsletter', 'DateDeactivated', 'Latitude', 'Longitude', 'Envelope', ],
        self::TYPE_CAMELNAME     => ['id', 'name', 'address1', 'address2', 'city', 'state', 'zip', 'country', 'homePhone', 'email', 'weddingdate', 'dateEntered', 'dateLastEdited', 'enteredBy', 'editedBy', 'scanCheck', 'scanCredit', 'sendNewsletter', 'dateDeactivated', 'latitude', 'longitude', 'envelope', ],
        self::TYPE_COLNAME       => [FamilyTableMap::COL_FAM_ID, FamilyTableMap::COL_FAM_NAME, FamilyTableMap::COL_FAM_ADDRESS1, FamilyTableMap::COL_FAM_ADDRESS2, FamilyTableMap::COL_FAM_CITY, FamilyTableMap::COL_FAM_STATE, FamilyTableMap::COL_FAM_ZIP, FamilyTableMap::COL_FAM_COUNTRY, FamilyTableMap::COL_FAM_HOMEPHONE, FamilyTableMap::COL_FAM_EMAIL, FamilyTableMap::COL_FAM_WEDDINGDATE, FamilyTableMap::COL_FAM_DATEENTERED, FamilyTableMap::COL_FAM_DATELASTEDITED, FamilyTableMap::COL_FAM_ENTEREDBY, FamilyTableMap::COL_FAM_EDITEDBY, FamilyTableMap::COL_FAM_SCANCHECK, FamilyTableMap::COL_FAM_SCANCREDIT, FamilyTableMap::COL_FAM_SENDNEWSLETTER, FamilyTableMap::COL_FAM_DATEDEACTIVATED, FamilyTableMap::COL_FAM_LATITUDE, FamilyTableMap::COL_FAM_LONGITUDE, FamilyTableMap::COL_FAM_ENVELOPE, ],
        self::TYPE_FIELDNAME     => ['fam_ID', 'fam_Name', 'fam_Address1', 'fam_Address2', 'fam_City', 'fam_State', 'fam_Zip', 'fam_Country', 'fam_HomePhone', 'fam_Email', 'fam_WeddingDate', 'fam_DateEntered', 'fam_DateLastEdited', 'fam_EnteredBy', 'fam_EditedBy', 'fam_scanCheck', 'fam_scanCredit', 'fam_SendNewsLetter', 'fam_DateDeactivated', 'fam_Latitude', 'fam_Longitude', 'fam_Envelope', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, ]
    ];

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     *
     * @var array<string, mixed>
     */
    protected static $fieldKeys = [
        self::TYPE_PHPNAME       => ['Id' => 0, 'Name' => 1, 'Address1' => 2, 'Address2' => 3, 'City' => 4, 'State' => 5, 'Zip' => 6, 'Country' => 7, 'HomePhone' => 8, 'Email' => 9, 'Weddingdate' => 10, 'DateEntered' => 11, 'DateLastEdited' => 12, 'EnteredBy' => 13, 'EditedBy' => 14, 'ScanCheck' => 15, 'ScanCredit' => 16, 'SendNewsletter' => 17, 'DateDeactivated' => 18, 'Latitude' => 19, 'Longitude' => 20, 'Envelope' => 21, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'name' => 1, 'address1' => 2, 'address2' => 3, 'city' => 4, 'state' => 5, 'zip' => 6, 'country' => 7, 'homePhone' => 8, 'email' => 9, 'weddingdate' => 10, 'dateEntered' => 11, 'dateLastEdited' => 12, 'enteredBy' => 13, 'editedBy' => 14, 'scanCheck' => 15, 'scanCredit' => 16, 'sendNewsletter' => 17, 'dateDeactivated' => 18, 'latitude' => 19, 'longitude' => 20, 'envelope' => 21, ],
        self::TYPE_COLNAME       => [FamilyTableMap::COL_FAM_ID => 0, FamilyTableMap::COL_FAM_NAME => 1, FamilyTableMap::COL_FAM_ADDRESS1 => 2, FamilyTableMap::COL_FAM_ADDRESS2 => 3, FamilyTableMap::COL_FAM_CITY => 4, FamilyTableMap::COL_FAM_STATE => 5, FamilyTableMap::COL_FAM_ZIP => 6, FamilyTableMap::COL_FAM_COUNTRY => 7, FamilyTableMap::COL_FAM_HOMEPHONE => 8, FamilyTableMap::COL_FAM_EMAIL => 9, FamilyTableMap::COL_FAM_WEDDINGDATE => 10, FamilyTableMap::COL_FAM_DATEENTERED => 11, FamilyTableMap::COL_FAM_DATELASTEDITED => 12, FamilyTableMap::COL_FAM_ENTEREDBY => 13, FamilyTableMap::COL_FAM_EDITEDBY => 14, FamilyTableMap::COL_FAM_SCANCHECK => 15, FamilyTableMap::COL_FAM_SCANCREDIT => 16, FamilyTableMap::COL_FAM_SENDNEWSLETTER => 17, FamilyTableMap::COL_FAM_DATEDEACTIVATED => 18, FamilyTableMap::COL_FAM_LATITUDE => 19, FamilyTableMap::COL_FAM_LONGITUDE => 20, FamilyTableMap::COL_FAM_ENVELOPE => 21, ],
        self::TYPE_FIELDNAME     => ['fam_ID' => 0, 'fam_Name' => 1, 'fam_Address1' => 2, 'fam_Address2' => 3, 'fam_City' => 4, 'fam_State' => 5, 'fam_Zip' => 6, 'fam_Country' => 7, 'fam_HomePhone' => 8, 'fam_Email' => 9, 'fam_WeddingDate' => 10, 'fam_DateEntered' => 11, 'fam_DateLastEdited' => 12, 'fam_EnteredBy' => 13, 'fam_EditedBy' => 14, 'fam_scanCheck' => 15, 'fam_scanCredit' => 16, 'fam_SendNewsLetter' => 17, 'fam_DateDeactivated' => 18, 'fam_Latitude' => 19, 'fam_Longitude' => 20, 'fam_Envelope' => 21, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string, string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'FAM_ID',
        'Family.Id' => 'FAM_ID',
        'id' => 'FAM_ID',
        'family.id' => 'FAM_ID',
        'FamilyTableMap::COL_FAM_ID' => 'FAM_ID',
        'COL_FAM_ID' => 'FAM_ID',
        'fam_ID' => 'FAM_ID',
        'family_fam.fam_ID' => 'FAM_ID',
        'Name' => 'FAM_NAME',
        'Family.Name' => 'FAM_NAME',
        'name' => 'FAM_NAME',
        'family.name' => 'FAM_NAME',
        'FamilyTableMap::COL_FAM_NAME' => 'FAM_NAME',
        'COL_FAM_NAME' => 'FAM_NAME',
        'fam_Name' => 'FAM_NAME',
        'family_fam.fam_Name' => 'FAM_NAME',
        'Address1' => 'FAM_ADDRESS1',
        'Family.Address1' => 'FAM_ADDRESS1',
        'address1' => 'FAM_ADDRESS1',
        'family.address1' => 'FAM_ADDRESS1',
        'FamilyTableMap::COL_FAM_ADDRESS1' => 'FAM_ADDRESS1',
        'COL_FAM_ADDRESS1' => 'FAM_ADDRESS1',
        'fam_Address1' => 'FAM_ADDRESS1',
        'family_fam.fam_Address1' => 'FAM_ADDRESS1',
        'Address2' => 'FAM_ADDRESS2',
        'Family.Address2' => 'FAM_ADDRESS2',
        'address2' => 'FAM_ADDRESS2',
        'family.address2' => 'FAM_ADDRESS2',
        'FamilyTableMap::COL_FAM_ADDRESS2' => 'FAM_ADDRESS2',
        'COL_FAM_ADDRESS2' => 'FAM_ADDRESS2',
        'fam_Address2' => 'FAM_ADDRESS2',
        'family_fam.fam_Address2' => 'FAM_ADDRESS2',
        'City' => 'FAM_CITY',
        'Family.City' => 'FAM_CITY',
        'city' => 'FAM_CITY',
        'family.city' => 'FAM_CITY',
        'FamilyTableMap::COL_FAM_CITY' => 'FAM_CITY',
        'COL_FAM_CITY' => 'FAM_CITY',
        'fam_City' => 'FAM_CITY',
        'family_fam.fam_City' => 'FAM_CITY',
        'State' => 'FAM_STATE',
        'Family.State' => 'FAM_STATE',
        'state' => 'FAM_STATE',
        'family.state' => 'FAM_STATE',
        'FamilyTableMap::COL_FAM_STATE' => 'FAM_STATE',
        'COL_FAM_STATE' => 'FAM_STATE',
        'fam_State' => 'FAM_STATE',
        'family_fam.fam_State' => 'FAM_STATE',
        'Zip' => 'FAM_ZIP',
        'Family.Zip' => 'FAM_ZIP',
        'zip' => 'FAM_ZIP',
        'family.zip' => 'FAM_ZIP',
        'FamilyTableMap::COL_FAM_ZIP' => 'FAM_ZIP',
        'COL_FAM_ZIP' => 'FAM_ZIP',
        'fam_Zip' => 'FAM_ZIP',
        'family_fam.fam_Zip' => 'FAM_ZIP',
        'Country' => 'FAM_COUNTRY',
        'Family.Country' => 'FAM_COUNTRY',
        'country' => 'FAM_COUNTRY',
        'family.country' => 'FAM_COUNTRY',
        'FamilyTableMap::COL_FAM_COUNTRY' => 'FAM_COUNTRY',
        'COL_FAM_COUNTRY' => 'FAM_COUNTRY',
        'fam_Country' => 'FAM_COUNTRY',
        'family_fam.fam_Country' => 'FAM_COUNTRY',
        'HomePhone' => 'FAM_HOMEPHONE',
        'Family.HomePhone' => 'FAM_HOMEPHONE',
        'homePhone' => 'FAM_HOMEPHONE',
        'family.homePhone' => 'FAM_HOMEPHONE',
        'FamilyTableMap::COL_FAM_HOMEPHONE' => 'FAM_HOMEPHONE',
        'COL_FAM_HOMEPHONE' => 'FAM_HOMEPHONE',
        'fam_HomePhone' => 'FAM_HOMEPHONE',
        'family_fam.fam_HomePhone' => 'FAM_HOMEPHONE',
        'Email' => 'FAM_EMAIL',
        'Family.Email' => 'FAM_EMAIL',
        'email' => 'FAM_EMAIL',
        'family.email' => 'FAM_EMAIL',
        'FamilyTableMap::COL_FAM_EMAIL' => 'FAM_EMAIL',
        'COL_FAM_EMAIL' => 'FAM_EMAIL',
        'fam_Email' => 'FAM_EMAIL',
        'family_fam.fam_Email' => 'FAM_EMAIL',
        'Weddingdate' => 'FAM_WEDDINGDATE',
        'Family.Weddingdate' => 'FAM_WEDDINGDATE',
        'weddingdate' => 'FAM_WEDDINGDATE',
        'family.weddingdate' => 'FAM_WEDDINGDATE',
        'FamilyTableMap::COL_FAM_WEDDINGDATE' => 'FAM_WEDDINGDATE',
        'COL_FAM_WEDDINGDATE' => 'FAM_WEDDINGDATE',
        'fam_WeddingDate' => 'FAM_WEDDINGDATE',
        'family_fam.fam_WeddingDate' => 'FAM_WEDDINGDATE',
        'DateEntered' => 'FAM_DATEENTERED',
        'Family.DateEntered' => 'FAM_DATEENTERED',
        'dateEntered' => 'FAM_DATEENTERED',
        'family.dateEntered' => 'FAM_DATEENTERED',
        'FamilyTableMap::COL_FAM_DATEENTERED' => 'FAM_DATEENTERED',
        'COL_FAM_DATEENTERED' => 'FAM_DATEENTERED',
        'fam_DateEntered' => 'FAM_DATEENTERED',
        'family_fam.fam_DateEntered' => 'FAM_DATEENTERED',
        'DateLastEdited' => 'FAM_DATELASTEDITED',
        'Family.DateLastEdited' => 'FAM_DATELASTEDITED',
        'dateLastEdited' => 'FAM_DATELASTEDITED',
        'family.dateLastEdited' => 'FAM_DATELASTEDITED',
        'FamilyTableMap::COL_FAM_DATELASTEDITED' => 'FAM_DATELASTEDITED',
        'COL_FAM_DATELASTEDITED' => 'FAM_DATELASTEDITED',
        'fam_DateLastEdited' => 'FAM_DATELASTEDITED',
        'family_fam.fam_DateLastEdited' => 'FAM_DATELASTEDITED',
        'EnteredBy' => 'FAM_ENTEREDBY',
        'Family.EnteredBy' => 'FAM_ENTEREDBY',
        'enteredBy' => 'FAM_ENTEREDBY',
        'family.enteredBy' => 'FAM_ENTEREDBY',
        'FamilyTableMap::COL_FAM_ENTEREDBY' => 'FAM_ENTEREDBY',
        'COL_FAM_ENTEREDBY' => 'FAM_ENTEREDBY',
        'fam_EnteredBy' => 'FAM_ENTEREDBY',
        'family_fam.fam_EnteredBy' => 'FAM_ENTEREDBY',
        'EditedBy' => 'FAM_EDITEDBY',
        'Family.EditedBy' => 'FAM_EDITEDBY',
        'editedBy' => 'FAM_EDITEDBY',
        'family.editedBy' => 'FAM_EDITEDBY',
        'FamilyTableMap::COL_FAM_EDITEDBY' => 'FAM_EDITEDBY',
        'COL_FAM_EDITEDBY' => 'FAM_EDITEDBY',
        'fam_EditedBy' => 'FAM_EDITEDBY',
        'family_fam.fam_EditedBy' => 'FAM_EDITEDBY',
        'ScanCheck' => 'FAM_SCANCHECK',
        'Family.ScanCheck' => 'FAM_SCANCHECK',
        'scanCheck' => 'FAM_SCANCHECK',
        'family.scanCheck' => 'FAM_SCANCHECK',
        'FamilyTableMap::COL_FAM_SCANCHECK' => 'FAM_SCANCHECK',
        'COL_FAM_SCANCHECK' => 'FAM_SCANCHECK',
        'fam_scanCheck' => 'FAM_SCANCHECK',
        'family_fam.fam_scanCheck' => 'FAM_SCANCHECK',
        'ScanCredit' => 'FAM_SCANCREDIT',
        'Family.ScanCredit' => 'FAM_SCANCREDIT',
        'scanCredit' => 'FAM_SCANCREDIT',
        'family.scanCredit' => 'FAM_SCANCREDIT',
        'FamilyTableMap::COL_FAM_SCANCREDIT' => 'FAM_SCANCREDIT',
        'COL_FAM_SCANCREDIT' => 'FAM_SCANCREDIT',
        'fam_scanCredit' => 'FAM_SCANCREDIT',
        'family_fam.fam_scanCredit' => 'FAM_SCANCREDIT',
        'SendNewsletter' => 'FAM_SENDNEWSLETTER',
        'Family.SendNewsletter' => 'FAM_SENDNEWSLETTER',
        'sendNewsletter' => 'FAM_SENDNEWSLETTER',
        'family.sendNewsletter' => 'FAM_SENDNEWSLETTER',
        'FamilyTableMap::COL_FAM_SENDNEWSLETTER' => 'FAM_SENDNEWSLETTER',
        'COL_FAM_SENDNEWSLETTER' => 'FAM_SENDNEWSLETTER',
        'fam_SendNewsLetter' => 'FAM_SENDNEWSLETTER',
        'family_fam.fam_SendNewsLetter' => 'FAM_SENDNEWSLETTER',
        'DateDeactivated' => 'FAM_DATEDEACTIVATED',
        'Family.DateDeactivated' => 'FAM_DATEDEACTIVATED',
        'dateDeactivated' => 'FAM_DATEDEACTIVATED',
        'family.dateDeactivated' => 'FAM_DATEDEACTIVATED',
        'FamilyTableMap::COL_FAM_DATEDEACTIVATED' => 'FAM_DATEDEACTIVATED',
        'COL_FAM_DATEDEACTIVATED' => 'FAM_DATEDEACTIVATED',
        'fam_DateDeactivated' => 'FAM_DATEDEACTIVATED',
        'family_fam.fam_DateDeactivated' => 'FAM_DATEDEACTIVATED',
        'Latitude' => 'FAM_LATITUDE',
        'Family.Latitude' => 'FAM_LATITUDE',
        'latitude' => 'FAM_LATITUDE',
        'family.latitude' => 'FAM_LATITUDE',
        'FamilyTableMap::COL_FAM_LATITUDE' => 'FAM_LATITUDE',
        'COL_FAM_LATITUDE' => 'FAM_LATITUDE',
        'fam_Latitude' => 'FAM_LATITUDE',
        'family_fam.fam_Latitude' => 'FAM_LATITUDE',
        'Longitude' => 'FAM_LONGITUDE',
        'Family.Longitude' => 'FAM_LONGITUDE',
        'longitude' => 'FAM_LONGITUDE',
        'family.longitude' => 'FAM_LONGITUDE',
        'FamilyTableMap::COL_FAM_LONGITUDE' => 'FAM_LONGITUDE',
        'COL_FAM_LONGITUDE' => 'FAM_LONGITUDE',
        'fam_Longitude' => 'FAM_LONGITUDE',
        'family_fam.fam_Longitude' => 'FAM_LONGITUDE',
        'Envelope' => 'FAM_ENVELOPE',
        'Family.Envelope' => 'FAM_ENVELOPE',
        'envelope' => 'FAM_ENVELOPE',
        'family.envelope' => 'FAM_ENVELOPE',
        'FamilyTableMap::COL_FAM_ENVELOPE' => 'FAM_ENVELOPE',
        'COL_FAM_ENVELOPE' => 'FAM_ENVELOPE',
        'fam_Envelope' => 'FAM_ENVELOPE',
        'family_fam.fam_Envelope' => 'FAM_ENVELOPE',
    ];

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return void
     */
    public function initialize(): void
    {
        // attributes
        $this->setName('family_fam');
        $this->setPhpName('Family');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ChurchCRM\\model\\ChurchCRM\\Family');
        $this->setPackage('ChurchCRM.model.ChurchCRM');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('fam_ID', 'Id', 'SMALLINT', true, 9, null);
        $this->addColumn('fam_Name', 'Name', 'VARCHAR', false, 50, null);
        $this->addColumn('fam_Address1', 'Address1', 'VARCHAR', false, 255, null);
        $this->addColumn('fam_Address2', 'Address2', 'VARCHAR', false, 255, null);
        $this->addColumn('fam_City', 'City', 'VARCHAR', false, 50, null);
        $this->addColumn('fam_State', 'State', 'VARCHAR', false, 50, null);
        $this->addColumn('fam_Zip', 'Zip', 'VARCHAR', false, 50, null);
        $this->addColumn('fam_Country', 'Country', 'VARCHAR', false, 50, null);
        $this->addColumn('fam_HomePhone', 'HomePhone', 'VARCHAR', false, 30, null);
        $this->addColumn('fam_Email', 'Email', 'VARCHAR', false, 100, null);
        $this->addColumn('fam_WeddingDate', 'Weddingdate', 'DATE', false, null, null);
        $this->addColumn('fam_DateEntered', 'DateEntered', 'TIMESTAMP', true, null, null);
        $this->addColumn('fam_DateLastEdited', 'DateLastEdited', 'TIMESTAMP', false, null, null);
        $this->addColumn('fam_EnteredBy', 'EnteredBy', 'SMALLINT', true, 5, 0);
        $this->addColumn('fam_EditedBy', 'EditedBy', 'SMALLINT', false, 5, 0);
        $this->addColumn('fam_scanCheck', 'ScanCheck', 'LONGVARCHAR', false, null, null);
        $this->addColumn('fam_scanCredit', 'ScanCredit', 'LONGVARCHAR', false, null, null);
        $this->addColumn('fam_SendNewsLetter', 'SendNewsletter', 'CHAR', true, null, 'FALSE');
        $this->addColumn('fam_DateDeactivated', 'DateDeactivated', 'DATE', false, null, null);
        $this->addColumn('fam_Latitude', 'Latitude', 'DOUBLE', false, null, null);
        $this->addColumn('fam_Longitude', 'Longitude', 'DOUBLE', false, null, null);
        $this->addColumn('fam_Envelope', 'Envelope', 'SMALLINT', true, 9, 0);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation(
            'Person',
            '\\ChurchCRM\\model\\ChurchCRM\\Person',
            RelationMap::ONE_TO_MANY,
            [[':per_fam_ID', ':fam_ID']],
            null,
            null,
            'People',
            false
        );
        $this->addRelation(
            'FamilyCustom',
            '\\ChurchCRM\\model\\ChurchCRM\\FamilyCustom',
            RelationMap::ONE_TO_ONE,
            [[':fam_ID', ':fam_ID']],
            null,
            null,
            null,
            false
        );
        $this->addRelation(
            'Note',
            '\\ChurchCRM\\model\\ChurchCRM\\Note',
            RelationMap::ONE_TO_MANY,
            [[':nte_fam_ID', ':fam_ID']],
            null,
            null,
            'Notes',
            false
        );
        $this->addRelation(
            'Pledge',
            '\\ChurchCRM\\model\\ChurchCRM\\Pledge',
            RelationMap::ONE_TO_MANY,
            [[':plg_FamID', ':fam_ID']],
            null,
            null,
            'Pledges',
            false
        );
    }

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array<string, array> Associative array (name => parameters) of behaviors
     */
    public function getBehaviors(): array
    {
        return [
            'validate' => ['rule1' => ['column' => 'fam_name', 'validator' => 'NotNull'], 'rule2' => ['column' => 'fam_name', 'validator' => 'NotBlank'], 'rule3' => ['column' => 'fam_name', 'validator' => 'Length', 'options' => ['min' => 2, 'max' => 50]]],
        ];
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array $row Resultset row.
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string|null The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): ?string
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string)$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.
     * For tables with a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array $row Resultset row.
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM)
    {
        $idIx = $indexType === TableMap::TYPE_NUM
            ? 0 + $offset
            : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType);

        return (int)$row[$idIx];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param bool $withPrefix Whether to return the path with the class name
     *
     * @return string path.to.ClassName
     */
    public static function getOMClass(bool $withPrefix = true): string
    {
        return $withPrefix ? FamilyTableMap::CLASS_DEFAULT : FamilyTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array $row Row returned by DataFetcher->fetch().
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
     *                           One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return array (Family object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = FamilyTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (($obj = FamilyTableMap::getInstanceFromPool($key)) !== null) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + FamilyTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = FamilyTableMap::OM_CLASS;
            /** @var Family $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            FamilyTableMap::addInstanceToPool($obj, $key);
        }

        return [$obj, $col];
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param \Propel\Runtime\DataFetcher\DataFetcherInterface $dataFetcher
     *
     * @return array<object>
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher): array
    {
        $results = [];

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = FamilyTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (($obj = FamilyTableMap::getInstanceFromPool($key)) !== null) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new Family();
                $obj->hydrate($row);
                $results[] = $obj;
                FamilyTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }

    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria $criteria Object containing the columns to add.
     * @param string|null $alias Optional table alias
     *
     * @return void
     */
    public static function addSelectColumns(Criteria $criteria, ?string $alias = null): void
    {
        $tableMap = static::getTableMap();
        $tableAlias = $alias ?: 'family_fam';
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['FAM_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['FAM_NAME']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['FAM_ADDRESS1']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['FAM_ADDRESS2']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['FAM_CITY']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['FAM_STATE']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['FAM_ZIP']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['FAM_COUNTRY']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['FAM_HOMEPHONE']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['FAM_EMAIL']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['FAM_WEDDINGDATE']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['FAM_DATEENTERED']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['FAM_DATELASTEDITED']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['FAM_ENTEREDBY']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['FAM_EDITEDBY']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['FAM_SCANCHECK']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['FAM_SCANCREDIT']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['FAM_SENDNEWSLETTER']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['FAM_DATEDEACTIVATED']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['FAM_LATITUDE']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['FAM_LONGITUDE']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['FAM_ENVELOPE']));
    }

    /**
     * Remove all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be removed as they are only loaded on demand.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria $criteria Object containing the columns to remove.
     * @param string|null $alias Optional table alias
     *
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     *
     * @return void
     */
    public static function removeSelectColumns(Criteria $criteria, ?string $alias = null): void
    {
        if ($alias === null) {
            $criteria->removeSelectColumn(FamilyTableMap::COL_FAM_ID);
            $criteria->removeSelectColumn(FamilyTableMap::COL_FAM_NAME);
            $criteria->removeSelectColumn(FamilyTableMap::COL_FAM_ADDRESS1);
            $criteria->removeSelectColumn(FamilyTableMap::COL_FAM_ADDRESS2);
            $criteria->removeSelectColumn(FamilyTableMap::COL_FAM_CITY);
            $criteria->removeSelectColumn(FamilyTableMap::COL_FAM_STATE);
            $criteria->removeSelectColumn(FamilyTableMap::COL_FAM_ZIP);
            $criteria->removeSelectColumn(FamilyTableMap::COL_FAM_COUNTRY);
            $criteria->removeSelectColumn(FamilyTableMap::COL_FAM_HOMEPHONE);
            $criteria->removeSelectColumn(FamilyTableMap::COL_FAM_EMAIL);
            $criteria->removeSelectColumn(FamilyTableMap::COL_FAM_WEDDINGDATE);
            $criteria->removeSelectColumn(FamilyTableMap::COL_FAM_DATEENTERED);
            $criteria->removeSelectColumn(FamilyTableMap::COL_FAM_DATELASTEDITED);
            $criteria->removeSelectColumn(FamilyTableMap::COL_FAM_ENTEREDBY);
            $criteria->removeSelectColumn(FamilyTableMap::COL_FAM_EDITEDBY);
            $criteria->removeSelectColumn(FamilyTableMap::COL_FAM_SCANCHECK);
            $criteria->removeSelectColumn(FamilyTableMap::COL_FAM_SCANCREDIT);
            $criteria->removeSelectColumn(FamilyTableMap::COL_FAM_SENDNEWSLETTER);
            $criteria->removeSelectColumn(FamilyTableMap::COL_FAM_DATEDEACTIVATED);
            $criteria->removeSelectColumn(FamilyTableMap::COL_FAM_LATITUDE);
            $criteria->removeSelectColumn(FamilyTableMap::COL_FAM_LONGITUDE);
            $criteria->removeSelectColumn(FamilyTableMap::COL_FAM_ENVELOPE);
        } else {
            $criteria->removeSelectColumn($alias . '.fam_ID');
            $criteria->removeSelectColumn($alias . '.fam_Name');
            $criteria->removeSelectColumn($alias . '.fam_Address1');
            $criteria->removeSelectColumn($alias . '.fam_Address2');
            $criteria->removeSelectColumn($alias . '.fam_City');
            $criteria->removeSelectColumn($alias . '.fam_State');
            $criteria->removeSelectColumn($alias . '.fam_Zip');
            $criteria->removeSelectColumn($alias . '.fam_Country');
            $criteria->removeSelectColumn($alias . '.fam_HomePhone');
            $criteria->removeSelectColumn($alias . '.fam_Email');
            $criteria->removeSelectColumn($alias . '.fam_WeddingDate');
            $criteria->removeSelectColumn($alias . '.fam_DateEntered');
            $criteria->removeSelectColumn($alias . '.fam_DateLastEdited');
            $criteria->removeSelectColumn($alias . '.fam_EnteredBy');
            $criteria->removeSelectColumn($alias . '.fam_EditedBy');
            $criteria->removeSelectColumn($alias . '.fam_scanCheck');
            $criteria->removeSelectColumn($alias . '.fam_scanCredit');
            $criteria->removeSelectColumn($alias . '.fam_SendNewsLetter');
            $criteria->removeSelectColumn($alias . '.fam_DateDeactivated');
            $criteria->removeSelectColumn($alias . '.fam_Latitude');
            $criteria->removeSelectColumn($alias . '.fam_Longitude');
            $criteria->removeSelectColumn($alias . '.fam_Envelope');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     *
     * @return static
     */
    public static function getTableMap(): TableMap
    {
        return Propel::getServiceContainer()->getDatabaseMap(FamilyTableMap::DATABASE_NAME)->getTable(FamilyTableMap::TABLE_NAME);
    }

    /**
     * @deprecated Delete via model or FamilyQuery.
     *
     * Performs a DELETE on the database, given a Family or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or Family object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     *
     * @return int The number of affected rows (if supported by underlying database driver). This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     */
    public static function doDelete($values, ?ConnectionInterface $con = null): int
    {
        trigger_deprecation('Propel', '2.0', 'TableMap::doDelete() should not be used anymore, delete via model or FamilyQuery');

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(FamilyTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            $criteria = $values;
        } elseif ($values instanceof Family) { // it's a model object
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(FamilyTableMap::DATABASE_NAME);
            $criteria->addAnd(FamilyTableMap::COL_FAM_ID, (array)$values, Criteria::IN);
        }

        $query = FamilyQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            FamilyTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array)$values as $singleval) {
                FamilyTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the family_fam table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return FamilyQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Family or Criteria object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|\ChurchCRM\model\ChurchCRM\Family $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     *
     * @return mixed The new primary key.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(FamilyTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria;
            $criteria->turnFiltersToUpdateValues();
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Family object
        }

        if ($criteria->hasUpdateValue(FamilyTableMap::COL_FAM_ID)) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (FamilyTableMap::COL_FAM_ID)');
        }

        // Set the correct dbName
        $query = FamilyQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }
}
