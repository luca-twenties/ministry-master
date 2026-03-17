<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Map;

use ChurchCRM\model\ChurchCRM\Pledge;
use ChurchCRM\model\ChurchCRM\PledgeQuery;
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
 * This class defines the structure of the 'pledge_plg' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class PledgeTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'ChurchCRM.model.ChurchCRM.Map.PledgeTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'pledge_plg';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'Pledge';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\ChurchCRM\\model\\ChurchCRM\\Pledge';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'ChurchCRM.model.ChurchCRM.Pledge';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 21;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 21;

    /**
     * the column name for the plg_plgID field
     */
    public const COL_PLG_PLGID = 'pledge_plg.plg_plgID';

    /**
     * the column name for the plg_FamID field
     */
    public const COL_PLG_FAMID = 'pledge_plg.plg_FamID';

    /**
     * the column name for the plg_FYID field
     */
    public const COL_PLG_FYID = 'pledge_plg.plg_FYID';

    /**
     * the column name for the plg_date field
     */
    public const COL_PLG_DATE = 'pledge_plg.plg_date';

    /**
     * the column name for the plg_amount field
     */
    public const COL_PLG_AMOUNT = 'pledge_plg.plg_amount';

    /**
     * the column name for the plg_schedule field
     */
    public const COL_PLG_SCHEDULE = 'pledge_plg.plg_schedule';

    /**
     * the column name for the plg_method field
     */
    public const COL_PLG_METHOD = 'pledge_plg.plg_method';

    /**
     * the column name for the plg_comment field
     */
    public const COL_PLG_COMMENT = 'pledge_plg.plg_comment';

    /**
     * the column name for the plg_DateLastEdited field
     */
    public const COL_PLG_DATELASTEDITED = 'pledge_plg.plg_DateLastEdited';

    /**
     * the column name for the plg_EditedBy field
     */
    public const COL_PLG_EDITEDBY = 'pledge_plg.plg_EditedBy';

    /**
     * the column name for the plg_PledgeOrPayment field
     */
    public const COL_PLG_PLEDGEORPAYMENT = 'pledge_plg.plg_PledgeOrPayment';

    /**
     * the column name for the plg_fundID field
     */
    public const COL_PLG_FUNDID = 'pledge_plg.plg_fundID';

    /**
     * the column name for the plg_depID field
     */
    public const COL_PLG_DEPID = 'pledge_plg.plg_depID';

    /**
     * the column name for the plg_CheckNo field
     */
    public const COL_PLG_CHECKNO = 'pledge_plg.plg_CheckNo';

    /**
     * the column name for the plg_Problem field
     */
    public const COL_PLG_PROBLEM = 'pledge_plg.plg_Problem';

    /**
     * the column name for the plg_scanString field
     */
    public const COL_PLG_SCANSTRING = 'pledge_plg.plg_scanString';

    /**
     * the column name for the plg_aut_ID field
     */
    public const COL_PLG_AUT_ID = 'pledge_plg.plg_aut_ID';

    /**
     * the column name for the plg_aut_Cleared field
     */
    public const COL_PLG_AUT_CLEARED = 'pledge_plg.plg_aut_Cleared';

    /**
     * the column name for the plg_aut_ResultID field
     */
    public const COL_PLG_AUT_RESULTID = 'pledge_plg.plg_aut_ResultID';

    /**
     * the column name for the plg_NonDeductible field
     */
    public const COL_PLG_NONDEDUCTIBLE = 'pledge_plg.plg_NonDeductible';

    /**
     * the column name for the plg_GroupKey field
     */
    public const COL_PLG_GROUPKEY = 'pledge_plg.plg_GroupKey';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * @var class-string<\ChurchCRM\model\ChurchCRM\Base\Collection\PledgeCollection>
     */
    public const DEFAULT_OBJECT_COLLECTION = '\ChurchCRM\model\ChurchCRM\Base\Collection\PledgeCollection';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['Id', 'FamId', 'FyId', 'Date', 'Amount', 'Schedule', 'Method', 'Comment', 'DateLastEdited', 'EditedBy', 'PledgeOrPayment', 'FundId', 'DepId', 'CheckNo', 'Problem', 'ScanString', 'AutId', 'AutCleared', 'AutResultId', 'Nondeductible', 'GroupKey', ],
        self::TYPE_CAMELNAME     => ['id', 'famId', 'fyId', 'date', 'amount', 'schedule', 'method', 'comment', 'dateLastEdited', 'editedBy', 'pledgeOrPayment', 'fundId', 'depId', 'checkNo', 'problem', 'scanString', 'autId', 'autCleared', 'autResultId', 'nondeductible', 'groupKey', ],
        self::TYPE_COLNAME       => [PledgeTableMap::COL_PLG_PLGID, PledgeTableMap::COL_PLG_FAMID, PledgeTableMap::COL_PLG_FYID, PledgeTableMap::COL_PLG_DATE, PledgeTableMap::COL_PLG_AMOUNT, PledgeTableMap::COL_PLG_SCHEDULE, PledgeTableMap::COL_PLG_METHOD, PledgeTableMap::COL_PLG_COMMENT, PledgeTableMap::COL_PLG_DATELASTEDITED, PledgeTableMap::COL_PLG_EDITEDBY, PledgeTableMap::COL_PLG_PLEDGEORPAYMENT, PledgeTableMap::COL_PLG_FUNDID, PledgeTableMap::COL_PLG_DEPID, PledgeTableMap::COL_PLG_CHECKNO, PledgeTableMap::COL_PLG_PROBLEM, PledgeTableMap::COL_PLG_SCANSTRING, PledgeTableMap::COL_PLG_AUT_ID, PledgeTableMap::COL_PLG_AUT_CLEARED, PledgeTableMap::COL_PLG_AUT_RESULTID, PledgeTableMap::COL_PLG_NONDEDUCTIBLE, PledgeTableMap::COL_PLG_GROUPKEY, ],
        self::TYPE_FIELDNAME     => ['plg_plgID', 'plg_FamID', 'plg_FYID', 'plg_date', 'plg_amount', 'plg_schedule', 'plg_method', 'plg_comment', 'plg_DateLastEdited', 'plg_EditedBy', 'plg_PledgeOrPayment', 'plg_fundID', 'plg_depID', 'plg_CheckNo', 'plg_Problem', 'plg_scanString', 'plg_aut_ID', 'plg_aut_Cleared', 'plg_aut_ResultID', 'plg_NonDeductible', 'plg_GroupKey', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, ]
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
        self::TYPE_PHPNAME       => ['Id' => 0, 'FamId' => 1, 'FyId' => 2, 'Date' => 3, 'Amount' => 4, 'Schedule' => 5, 'Method' => 6, 'Comment' => 7, 'DateLastEdited' => 8, 'EditedBy' => 9, 'PledgeOrPayment' => 10, 'FundId' => 11, 'DepId' => 12, 'CheckNo' => 13, 'Problem' => 14, 'ScanString' => 15, 'AutId' => 16, 'AutCleared' => 17, 'AutResultId' => 18, 'Nondeductible' => 19, 'GroupKey' => 20, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'famId' => 1, 'fyId' => 2, 'date' => 3, 'amount' => 4, 'schedule' => 5, 'method' => 6, 'comment' => 7, 'dateLastEdited' => 8, 'editedBy' => 9, 'pledgeOrPayment' => 10, 'fundId' => 11, 'depId' => 12, 'checkNo' => 13, 'problem' => 14, 'scanString' => 15, 'autId' => 16, 'autCleared' => 17, 'autResultId' => 18, 'nondeductible' => 19, 'groupKey' => 20, ],
        self::TYPE_COLNAME       => [PledgeTableMap::COL_PLG_PLGID => 0, PledgeTableMap::COL_PLG_FAMID => 1, PledgeTableMap::COL_PLG_FYID => 2, PledgeTableMap::COL_PLG_DATE => 3, PledgeTableMap::COL_PLG_AMOUNT => 4, PledgeTableMap::COL_PLG_SCHEDULE => 5, PledgeTableMap::COL_PLG_METHOD => 6, PledgeTableMap::COL_PLG_COMMENT => 7, PledgeTableMap::COL_PLG_DATELASTEDITED => 8, PledgeTableMap::COL_PLG_EDITEDBY => 9, PledgeTableMap::COL_PLG_PLEDGEORPAYMENT => 10, PledgeTableMap::COL_PLG_FUNDID => 11, PledgeTableMap::COL_PLG_DEPID => 12, PledgeTableMap::COL_PLG_CHECKNO => 13, PledgeTableMap::COL_PLG_PROBLEM => 14, PledgeTableMap::COL_PLG_SCANSTRING => 15, PledgeTableMap::COL_PLG_AUT_ID => 16, PledgeTableMap::COL_PLG_AUT_CLEARED => 17, PledgeTableMap::COL_PLG_AUT_RESULTID => 18, PledgeTableMap::COL_PLG_NONDEDUCTIBLE => 19, PledgeTableMap::COL_PLG_GROUPKEY => 20, ],
        self::TYPE_FIELDNAME     => ['plg_plgID' => 0, 'plg_FamID' => 1, 'plg_FYID' => 2, 'plg_date' => 3, 'plg_amount' => 4, 'plg_schedule' => 5, 'plg_method' => 6, 'plg_comment' => 7, 'plg_DateLastEdited' => 8, 'plg_EditedBy' => 9, 'plg_PledgeOrPayment' => 10, 'plg_fundID' => 11, 'plg_depID' => 12, 'plg_CheckNo' => 13, 'plg_Problem' => 14, 'plg_scanString' => 15, 'plg_aut_ID' => 16, 'plg_aut_Cleared' => 17, 'plg_aut_ResultID' => 18, 'plg_NonDeductible' => 19, 'plg_GroupKey' => 20, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string, string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'PLG_PLGID',
        'Pledge.Id' => 'PLG_PLGID',
        'id' => 'PLG_PLGID',
        'pledge.id' => 'PLG_PLGID',
        'PledgeTableMap::COL_PLG_PLGID' => 'PLG_PLGID',
        'COL_PLG_PLGID' => 'PLG_PLGID',
        'plg_plgID' => 'PLG_PLGID',
        'pledge_plg.plg_plgID' => 'PLG_PLGID',
        'FamId' => 'PLG_FAMID',
        'Pledge.FamId' => 'PLG_FAMID',
        'famId' => 'PLG_FAMID',
        'pledge.famId' => 'PLG_FAMID',
        'PledgeTableMap::COL_PLG_FAMID' => 'PLG_FAMID',
        'COL_PLG_FAMID' => 'PLG_FAMID',
        'plg_FamID' => 'PLG_FAMID',
        'pledge_plg.plg_FamID' => 'PLG_FAMID',
        'FyId' => 'PLG_FYID',
        'Pledge.FyId' => 'PLG_FYID',
        'fyId' => 'PLG_FYID',
        'pledge.fyId' => 'PLG_FYID',
        'PledgeTableMap::COL_PLG_FYID' => 'PLG_FYID',
        'COL_PLG_FYID' => 'PLG_FYID',
        'plg_FYID' => 'PLG_FYID',
        'pledge_plg.plg_FYID' => 'PLG_FYID',
        'Date' => 'PLG_DATE',
        'Pledge.Date' => 'PLG_DATE',
        'date' => 'PLG_DATE',
        'pledge.date' => 'PLG_DATE',
        'PledgeTableMap::COL_PLG_DATE' => 'PLG_DATE',
        'COL_PLG_DATE' => 'PLG_DATE',
        'plg_date' => 'PLG_DATE',
        'pledge_plg.plg_date' => 'PLG_DATE',
        'Amount' => 'PLG_AMOUNT',
        'Pledge.Amount' => 'PLG_AMOUNT',
        'amount' => 'PLG_AMOUNT',
        'pledge.amount' => 'PLG_AMOUNT',
        'PledgeTableMap::COL_PLG_AMOUNT' => 'PLG_AMOUNT',
        'COL_PLG_AMOUNT' => 'PLG_AMOUNT',
        'plg_amount' => 'PLG_AMOUNT',
        'pledge_plg.plg_amount' => 'PLG_AMOUNT',
        'Schedule' => 'PLG_SCHEDULE',
        'Pledge.Schedule' => 'PLG_SCHEDULE',
        'schedule' => 'PLG_SCHEDULE',
        'pledge.schedule' => 'PLG_SCHEDULE',
        'PledgeTableMap::COL_PLG_SCHEDULE' => 'PLG_SCHEDULE',
        'COL_PLG_SCHEDULE' => 'PLG_SCHEDULE',
        'plg_schedule' => 'PLG_SCHEDULE',
        'pledge_plg.plg_schedule' => 'PLG_SCHEDULE',
        'Method' => 'PLG_METHOD',
        'Pledge.Method' => 'PLG_METHOD',
        'method' => 'PLG_METHOD',
        'pledge.method' => 'PLG_METHOD',
        'PledgeTableMap::COL_PLG_METHOD' => 'PLG_METHOD',
        'COL_PLG_METHOD' => 'PLG_METHOD',
        'plg_method' => 'PLG_METHOD',
        'pledge_plg.plg_method' => 'PLG_METHOD',
        'Comment' => 'PLG_COMMENT',
        'Pledge.Comment' => 'PLG_COMMENT',
        'comment' => 'PLG_COMMENT',
        'pledge.comment' => 'PLG_COMMENT',
        'PledgeTableMap::COL_PLG_COMMENT' => 'PLG_COMMENT',
        'COL_PLG_COMMENT' => 'PLG_COMMENT',
        'plg_comment' => 'PLG_COMMENT',
        'pledge_plg.plg_comment' => 'PLG_COMMENT',
        'DateLastEdited' => 'PLG_DATELASTEDITED',
        'Pledge.DateLastEdited' => 'PLG_DATELASTEDITED',
        'dateLastEdited' => 'PLG_DATELASTEDITED',
        'pledge.dateLastEdited' => 'PLG_DATELASTEDITED',
        'PledgeTableMap::COL_PLG_DATELASTEDITED' => 'PLG_DATELASTEDITED',
        'COL_PLG_DATELASTEDITED' => 'PLG_DATELASTEDITED',
        'plg_DateLastEdited' => 'PLG_DATELASTEDITED',
        'pledge_plg.plg_DateLastEdited' => 'PLG_DATELASTEDITED',
        'EditedBy' => 'PLG_EDITEDBY',
        'Pledge.EditedBy' => 'PLG_EDITEDBY',
        'editedBy' => 'PLG_EDITEDBY',
        'pledge.editedBy' => 'PLG_EDITEDBY',
        'PledgeTableMap::COL_PLG_EDITEDBY' => 'PLG_EDITEDBY',
        'COL_PLG_EDITEDBY' => 'PLG_EDITEDBY',
        'plg_EditedBy' => 'PLG_EDITEDBY',
        'pledge_plg.plg_EditedBy' => 'PLG_EDITEDBY',
        'PledgeOrPayment' => 'PLG_PLEDGEORPAYMENT',
        'Pledge.PledgeOrPayment' => 'PLG_PLEDGEORPAYMENT',
        'pledgeOrPayment' => 'PLG_PLEDGEORPAYMENT',
        'pledge.pledgeOrPayment' => 'PLG_PLEDGEORPAYMENT',
        'PledgeTableMap::COL_PLG_PLEDGEORPAYMENT' => 'PLG_PLEDGEORPAYMENT',
        'COL_PLG_PLEDGEORPAYMENT' => 'PLG_PLEDGEORPAYMENT',
        'plg_PledgeOrPayment' => 'PLG_PLEDGEORPAYMENT',
        'pledge_plg.plg_PledgeOrPayment' => 'PLG_PLEDGEORPAYMENT',
        'FundId' => 'PLG_FUNDID',
        'Pledge.FundId' => 'PLG_FUNDID',
        'fundId' => 'PLG_FUNDID',
        'pledge.fundId' => 'PLG_FUNDID',
        'PledgeTableMap::COL_PLG_FUNDID' => 'PLG_FUNDID',
        'COL_PLG_FUNDID' => 'PLG_FUNDID',
        'plg_fundID' => 'PLG_FUNDID',
        'pledge_plg.plg_fundID' => 'PLG_FUNDID',
        'DepId' => 'PLG_DEPID',
        'Pledge.DepId' => 'PLG_DEPID',
        'depId' => 'PLG_DEPID',
        'pledge.depId' => 'PLG_DEPID',
        'PledgeTableMap::COL_PLG_DEPID' => 'PLG_DEPID',
        'COL_PLG_DEPID' => 'PLG_DEPID',
        'plg_depID' => 'PLG_DEPID',
        'pledge_plg.plg_depID' => 'PLG_DEPID',
        'CheckNo' => 'PLG_CHECKNO',
        'Pledge.CheckNo' => 'PLG_CHECKNO',
        'checkNo' => 'PLG_CHECKNO',
        'pledge.checkNo' => 'PLG_CHECKNO',
        'PledgeTableMap::COL_PLG_CHECKNO' => 'PLG_CHECKNO',
        'COL_PLG_CHECKNO' => 'PLG_CHECKNO',
        'plg_CheckNo' => 'PLG_CHECKNO',
        'pledge_plg.plg_CheckNo' => 'PLG_CHECKNO',
        'Problem' => 'PLG_PROBLEM',
        'Pledge.Problem' => 'PLG_PROBLEM',
        'problem' => 'PLG_PROBLEM',
        'pledge.problem' => 'PLG_PROBLEM',
        'PledgeTableMap::COL_PLG_PROBLEM' => 'PLG_PROBLEM',
        'COL_PLG_PROBLEM' => 'PLG_PROBLEM',
        'plg_Problem' => 'PLG_PROBLEM',
        'pledge_plg.plg_Problem' => 'PLG_PROBLEM',
        'ScanString' => 'PLG_SCANSTRING',
        'Pledge.ScanString' => 'PLG_SCANSTRING',
        'scanString' => 'PLG_SCANSTRING',
        'pledge.scanString' => 'PLG_SCANSTRING',
        'PledgeTableMap::COL_PLG_SCANSTRING' => 'PLG_SCANSTRING',
        'COL_PLG_SCANSTRING' => 'PLG_SCANSTRING',
        'plg_scanString' => 'PLG_SCANSTRING',
        'pledge_plg.plg_scanString' => 'PLG_SCANSTRING',
        'AutId' => 'PLG_AUT_ID',
        'Pledge.AutId' => 'PLG_AUT_ID',
        'autId' => 'PLG_AUT_ID',
        'pledge.autId' => 'PLG_AUT_ID',
        'PledgeTableMap::COL_PLG_AUT_ID' => 'PLG_AUT_ID',
        'COL_PLG_AUT_ID' => 'PLG_AUT_ID',
        'plg_aut_ID' => 'PLG_AUT_ID',
        'pledge_plg.plg_aut_ID' => 'PLG_AUT_ID',
        'AutCleared' => 'PLG_AUT_CLEARED',
        'Pledge.AutCleared' => 'PLG_AUT_CLEARED',
        'autCleared' => 'PLG_AUT_CLEARED',
        'pledge.autCleared' => 'PLG_AUT_CLEARED',
        'PledgeTableMap::COL_PLG_AUT_CLEARED' => 'PLG_AUT_CLEARED',
        'COL_PLG_AUT_CLEARED' => 'PLG_AUT_CLEARED',
        'plg_aut_Cleared' => 'PLG_AUT_CLEARED',
        'pledge_plg.plg_aut_Cleared' => 'PLG_AUT_CLEARED',
        'AutResultId' => 'PLG_AUT_RESULTID',
        'Pledge.AutResultId' => 'PLG_AUT_RESULTID',
        'autResultId' => 'PLG_AUT_RESULTID',
        'pledge.autResultId' => 'PLG_AUT_RESULTID',
        'PledgeTableMap::COL_PLG_AUT_RESULTID' => 'PLG_AUT_RESULTID',
        'COL_PLG_AUT_RESULTID' => 'PLG_AUT_RESULTID',
        'plg_aut_ResultID' => 'PLG_AUT_RESULTID',
        'pledge_plg.plg_aut_ResultID' => 'PLG_AUT_RESULTID',
        'Nondeductible' => 'PLG_NONDEDUCTIBLE',
        'Pledge.Nondeductible' => 'PLG_NONDEDUCTIBLE',
        'nondeductible' => 'PLG_NONDEDUCTIBLE',
        'pledge.nondeductible' => 'PLG_NONDEDUCTIBLE',
        'PledgeTableMap::COL_PLG_NONDEDUCTIBLE' => 'PLG_NONDEDUCTIBLE',
        'COL_PLG_NONDEDUCTIBLE' => 'PLG_NONDEDUCTIBLE',
        'plg_NonDeductible' => 'PLG_NONDEDUCTIBLE',
        'pledge_plg.plg_NonDeductible' => 'PLG_NONDEDUCTIBLE',
        'GroupKey' => 'PLG_GROUPKEY',
        'Pledge.GroupKey' => 'PLG_GROUPKEY',
        'groupKey' => 'PLG_GROUPKEY',
        'pledge.groupKey' => 'PLG_GROUPKEY',
        'PledgeTableMap::COL_PLG_GROUPKEY' => 'PLG_GROUPKEY',
        'COL_PLG_GROUPKEY' => 'PLG_GROUPKEY',
        'plg_GroupKey' => 'PLG_GROUPKEY',
        'pledge_plg.plg_GroupKey' => 'PLG_GROUPKEY',
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
        $this->setName('pledge_plg');
        $this->setPhpName('Pledge');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ChurchCRM\\model\\ChurchCRM\\Pledge');
        $this->setPackage('ChurchCRM.model.ChurchCRM');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('plg_plgID', 'Id', 'SMALLINT', true, 9, null);
        $this->addForeignKey('plg_FamID', 'FamId', 'SMALLINT', 'family_fam', 'fam_ID', false, 9, null);
        $this->addColumn('plg_FYID', 'FyId', 'SMALLINT', false, 9, null);
        $this->addColumn('plg_date', 'Date', 'DATE', false, null, null);
        $this->addColumn('plg_amount', 'Amount', 'DECIMAL', false, 8, null);
        $this->addColumn('plg_schedule', 'Schedule', 'CHAR', false, null, null);
        $this->addColumn('plg_method', 'Method', 'CHAR', false, null, null);
        $this->addColumn('plg_comment', 'Comment', 'LONGVARCHAR', false, null, null);
        $this->addColumn('plg_DateLastEdited', 'DateLastEdited', 'DATE', true, null, '2016-01-01');
        $this->addForeignKey('plg_EditedBy', 'EditedBy', 'SMALLINT', 'person_per', 'per_ID', true, 9, 0);
        $this->addColumn('plg_PledgeOrPayment', 'PledgeOrPayment', 'CHAR', true, null, 'Pledge');
        $this->addForeignKey('plg_fundID', 'FundId', 'TINYINT', 'donationfund_fun', 'fun_ID', false, 3, null);
        $this->addForeignKey('plg_depID', 'DepId', 'SMALLINT', 'deposit_dep', 'dep_ID', false, 9, null);
        $this->addColumn('plg_CheckNo', 'CheckNo', 'BIGINT', false, 16, null);
        $this->addColumn('plg_Problem', 'Problem', 'BOOLEAN', false, 1, null);
        $this->addColumn('plg_scanString', 'ScanString', 'LONGVARCHAR', false, null, null);
        $this->addColumn('plg_aut_ID', 'AutId', 'SMALLINT', true, 9, 0);
        $this->addColumn('plg_aut_Cleared', 'AutCleared', 'BOOLEAN', true, 1, false);
        $this->addColumn('plg_aut_ResultID', 'AutResultId', 'SMALLINT', true, 9, 0);
        $this->addColumn('plg_NonDeductible', 'Nondeductible', 'DECIMAL', true, 8, null);
        $this->addColumn('plg_GroupKey', 'GroupKey', 'VARCHAR', true, 64, null);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation(
            'Deposit',
            '\\ChurchCRM\\model\\ChurchCRM\\Deposit',
            RelationMap::MANY_TO_ONE,
            [[':plg_depID', ':dep_ID']],
            null,
            null,
            null,
            false
        );
        $this->addRelation(
            'DonationFund',
            '\\ChurchCRM\\model\\ChurchCRM\\DonationFund',
            RelationMap::MANY_TO_ONE,
            [[':plg_fundID', ':fun_ID']],
            null,
            null,
            null,
            false
        );
        $this->addRelation(
            'Family',
            '\\ChurchCRM\\model\\ChurchCRM\\Family',
            RelationMap::MANY_TO_ONE,
            [[':plg_FamID', ':fam_ID']],
            null,
            null,
            null,
            false
        );
        $this->addRelation(
            'Person',
            '\\ChurchCRM\\model\\ChurchCRM\\Person',
            RelationMap::MANY_TO_ONE,
            [[':plg_EditedBy', ':per_ID']],
            null,
            null,
            null,
            false
        );
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
        return $withPrefix ? PledgeTableMap::CLASS_DEFAULT : PledgeTableMap::OM_CLASS;
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
     * @return array (Pledge object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = PledgeTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (($obj = PledgeTableMap::getInstanceFromPool($key)) !== null) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PledgeTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PledgeTableMap::OM_CLASS;
            /** @var Pledge $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PledgeTableMap::addInstanceToPool($obj, $key);
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
            $key = PledgeTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (($obj = PledgeTableMap::getInstanceFromPool($key)) !== null) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new Pledge();
                $obj->hydrate($row);
                $results[] = $obj;
                PledgeTableMap::addInstanceToPool($obj, $key);
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
        $tableAlias = $alias ?: 'pledge_plg';
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PLG_PLGID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PLG_FAMID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PLG_FYID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PLG_DATE']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PLG_AMOUNT']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PLG_SCHEDULE']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PLG_METHOD']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PLG_COMMENT']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PLG_DATELASTEDITED']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PLG_EDITEDBY']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PLG_PLEDGEORPAYMENT']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PLG_FUNDID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PLG_DEPID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PLG_CHECKNO']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PLG_PROBLEM']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PLG_SCANSTRING']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PLG_AUT_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PLG_AUT_CLEARED']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PLG_AUT_RESULTID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PLG_NONDEDUCTIBLE']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PLG_GROUPKEY']));
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
            $criteria->removeSelectColumn(PledgeTableMap::COL_PLG_PLGID);
            $criteria->removeSelectColumn(PledgeTableMap::COL_PLG_FAMID);
            $criteria->removeSelectColumn(PledgeTableMap::COL_PLG_FYID);
            $criteria->removeSelectColumn(PledgeTableMap::COL_PLG_DATE);
            $criteria->removeSelectColumn(PledgeTableMap::COL_PLG_AMOUNT);
            $criteria->removeSelectColumn(PledgeTableMap::COL_PLG_SCHEDULE);
            $criteria->removeSelectColumn(PledgeTableMap::COL_PLG_METHOD);
            $criteria->removeSelectColumn(PledgeTableMap::COL_PLG_COMMENT);
            $criteria->removeSelectColumn(PledgeTableMap::COL_PLG_DATELASTEDITED);
            $criteria->removeSelectColumn(PledgeTableMap::COL_PLG_EDITEDBY);
            $criteria->removeSelectColumn(PledgeTableMap::COL_PLG_PLEDGEORPAYMENT);
            $criteria->removeSelectColumn(PledgeTableMap::COL_PLG_FUNDID);
            $criteria->removeSelectColumn(PledgeTableMap::COL_PLG_DEPID);
            $criteria->removeSelectColumn(PledgeTableMap::COL_PLG_CHECKNO);
            $criteria->removeSelectColumn(PledgeTableMap::COL_PLG_PROBLEM);
            $criteria->removeSelectColumn(PledgeTableMap::COL_PLG_SCANSTRING);
            $criteria->removeSelectColumn(PledgeTableMap::COL_PLG_AUT_ID);
            $criteria->removeSelectColumn(PledgeTableMap::COL_PLG_AUT_CLEARED);
            $criteria->removeSelectColumn(PledgeTableMap::COL_PLG_AUT_RESULTID);
            $criteria->removeSelectColumn(PledgeTableMap::COL_PLG_NONDEDUCTIBLE);
            $criteria->removeSelectColumn(PledgeTableMap::COL_PLG_GROUPKEY);
        } else {
            $criteria->removeSelectColumn($alias . '.plg_plgID');
            $criteria->removeSelectColumn($alias . '.plg_FamID');
            $criteria->removeSelectColumn($alias . '.plg_FYID');
            $criteria->removeSelectColumn($alias . '.plg_date');
            $criteria->removeSelectColumn($alias . '.plg_amount');
            $criteria->removeSelectColumn($alias . '.plg_schedule');
            $criteria->removeSelectColumn($alias . '.plg_method');
            $criteria->removeSelectColumn($alias . '.plg_comment');
            $criteria->removeSelectColumn($alias . '.plg_DateLastEdited');
            $criteria->removeSelectColumn($alias . '.plg_EditedBy');
            $criteria->removeSelectColumn($alias . '.plg_PledgeOrPayment');
            $criteria->removeSelectColumn($alias . '.plg_fundID');
            $criteria->removeSelectColumn($alias . '.plg_depID');
            $criteria->removeSelectColumn($alias . '.plg_CheckNo');
            $criteria->removeSelectColumn($alias . '.plg_Problem');
            $criteria->removeSelectColumn($alias . '.plg_scanString');
            $criteria->removeSelectColumn($alias . '.plg_aut_ID');
            $criteria->removeSelectColumn($alias . '.plg_aut_Cleared');
            $criteria->removeSelectColumn($alias . '.plg_aut_ResultID');
            $criteria->removeSelectColumn($alias . '.plg_NonDeductible');
            $criteria->removeSelectColumn($alias . '.plg_GroupKey');
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
        return Propel::getServiceContainer()->getDatabaseMap(PledgeTableMap::DATABASE_NAME)->getTable(PledgeTableMap::TABLE_NAME);
    }

    /**
     * @deprecated Delete via model or PledgeQuery.
     *
     * Performs a DELETE on the database, given a Pledge or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or Pledge object or primary key or array of primary keys
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
        trigger_deprecation('Propel', '2.0', 'TableMap::doDelete() should not be used anymore, delete via model or PledgeQuery');

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PledgeTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            $criteria = $values;
        } elseif ($values instanceof Pledge) { // it's a model object
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PledgeTableMap::DATABASE_NAME);
            $criteria->addAnd(PledgeTableMap::COL_PLG_PLGID, (array)$values, Criteria::IN);
        }

        $query = PledgeQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PledgeTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array)$values as $singleval) {
                PledgeTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the pledge_plg table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return PledgeQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Pledge or Criteria object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|\ChurchCRM\model\ChurchCRM\Pledge $criteria
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
            $con = Propel::getServiceContainer()->getWriteConnection(PledgeTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria;
            $criteria->turnFiltersToUpdateValues();
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Pledge object
        }

        if ($criteria->hasUpdateValue(PledgeTableMap::COL_PLG_PLGID)) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (PledgeTableMap::COL_PLG_PLGID)');
        }

        // Set the correct dbName
        $query = PledgeQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }
}
