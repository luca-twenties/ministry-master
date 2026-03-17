<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Map;

use ChurchCRM\model\ChurchCRM\User;
use ChurchCRM\model\ChurchCRM\UserQuery;
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
 * This class defines the structure of the 'user_usr' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class UserTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'ChurchCRM.model.ChurchCRM.Map.UserTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'user_usr';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'User';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\ChurchCRM\\model\\ChurchCRM\\User';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'ChurchCRM.model.ChurchCRM.User';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 34;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 34;

    /**
     * the column name for the usr_per_ID field
     */
    public const COL_USR_PER_ID = 'user_usr.usr_per_ID';

    /**
     * the column name for the usr_Password field
     */
    public const COL_USR_PASSWORD = 'user_usr.usr_Password';

    /**
     * the column name for the usr_NeedPasswordChange field
     */
    public const COL_USR_NEEDPASSWORDCHANGE = 'user_usr.usr_NeedPasswordChange';

    /**
     * the column name for the usr_LastLogin field
     */
    public const COL_USR_LASTLOGIN = 'user_usr.usr_LastLogin';

    /**
     * the column name for the usr_LoginCount field
     */
    public const COL_USR_LOGINCOUNT = 'user_usr.usr_LoginCount';

    /**
     * the column name for the usr_FailedLogins field
     */
    public const COL_USR_FAILEDLOGINS = 'user_usr.usr_FailedLogins';

    /**
     * the column name for the usr_AddRecords field
     */
    public const COL_USR_ADDRECORDS = 'user_usr.usr_AddRecords';

    /**
     * the column name for the usr_EditRecords field
     */
    public const COL_USR_EDITRECORDS = 'user_usr.usr_EditRecords';

    /**
     * the column name for the usr_DeleteRecords field
     */
    public const COL_USR_DELETERECORDS = 'user_usr.usr_DeleteRecords';

    /**
     * the column name for the usr_MenuOptions field
     */
    public const COL_USR_MENUOPTIONS = 'user_usr.usr_MenuOptions';

    /**
     * the column name for the usr_ManageGroups field
     */
    public const COL_USR_MANAGEGROUPS = 'user_usr.usr_ManageGroups';

    /**
     * the column name for the usr_Finance field
     */
    public const COL_USR_FINANCE = 'user_usr.usr_Finance';

    /**
     * the column name for the usr_Notes field
     */
    public const COL_USR_NOTES = 'user_usr.usr_Notes';

    /**
     * the column name for the usr_Admin field
     */
    public const COL_USR_ADMIN = 'user_usr.usr_Admin';

    /**
     * the column name for the usr_defaultFY field
     */
    public const COL_USR_DEFAULTFY = 'user_usr.usr_defaultFY';

    /**
     * the column name for the usr_currentDeposit field
     */
    public const COL_USR_CURRENTDEPOSIT = 'user_usr.usr_currentDeposit';

    /**
     * the column name for the usr_UserName field
     */
    public const COL_USR_USERNAME = 'user_usr.usr_UserName';

    /**
     * the column name for the usr_Style field
     */
    public const COL_USR_STYLE = 'user_usr.usr_Style';

    /**
     * the column name for the usr_ApiKey field
     */
    public const COL_USR_APIKEY = 'user_usr.usr_ApiKey';

    /**
     * the column name for the usr_TwoFactorAuthSecret field
     */
    public const COL_USR_TWOFACTORAUTHSECRET = 'user_usr.usr_TwoFactorAuthSecret';

    /**
     * the column name for the usr_TwoFactorAuthLastKeyTimestamp field
     */
    public const COL_USR_TWOFACTORAUTHLASTKEYTIMESTAMP = 'user_usr.usr_TwoFactorAuthLastKeyTimestamp';

    /**
     * the column name for the usr_TwoFactorAuthRecoveryCodes field
     */
    public const COL_USR_TWOFACTORAUTHRECOVERYCODES = 'user_usr.usr_TwoFactorAuthRecoveryCodes';

    /**
     * the column name for the usr_EditSelf field
     */
    public const COL_USR_EDITSELF = 'user_usr.usr_EditSelf';

    /**
     * the column name for the usr_CalStart field
     */
    public const COL_USR_CALSTART = 'user_usr.usr_CalStart';

    /**
     * the column name for the usr_CalEnd field
     */
    public const COL_USR_CALEND = 'user_usr.usr_CalEnd';

    /**
     * the column name for the usr_CalNoSchool1 field
     */
    public const COL_USR_CALNOSCHOOL1 = 'user_usr.usr_CalNoSchool1';

    /**
     * the column name for the usr_CalNoSchool2 field
     */
    public const COL_USR_CALNOSCHOOL2 = 'user_usr.usr_CalNoSchool2';

    /**
     * the column name for the usr_CalNoSchool3 field
     */
    public const COL_USR_CALNOSCHOOL3 = 'user_usr.usr_CalNoSchool3';

    /**
     * the column name for the usr_CalNoSchool4 field
     */
    public const COL_USR_CALNOSCHOOL4 = 'user_usr.usr_CalNoSchool4';

    /**
     * the column name for the usr_CalNoSchool5 field
     */
    public const COL_USR_CALNOSCHOOL5 = 'user_usr.usr_CalNoSchool5';

    /**
     * the column name for the usr_CalNoSchool6 field
     */
    public const COL_USR_CALNOSCHOOL6 = 'user_usr.usr_CalNoSchool6';

    /**
     * the column name for the usr_CalNoSchool7 field
     */
    public const COL_USR_CALNOSCHOOL7 = 'user_usr.usr_CalNoSchool7';

    /**
     * the column name for the usr_CalNoSchool8 field
     */
    public const COL_USR_CALNOSCHOOL8 = 'user_usr.usr_CalNoSchool8';

    /**
     * the column name for the usr_SearchFamily field
     */
    public const COL_USR_SEARCHFAMILY = 'user_usr.usr_SearchFamily';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * @var class-string<\ChurchCRM\model\ChurchCRM\Base\Collection\UserCollection>
     */
    public const DEFAULT_OBJECT_COLLECTION = '\ChurchCRM\model\ChurchCRM\Base\Collection\UserCollection';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['PersonId', 'Password', 'NeedPasswordChange', 'LastLogin', 'LoginCount', 'FailedLogins', 'AddRecords', 'EditRecords', 'DeleteRecords', 'MenuOptions', 'ManageGroups', 'Finance', 'Notes', 'Admin', 'DefaultFY', 'CurrentDeposit', 'UserName', 'UserStyle', 'ApiKey', 'TwoFactorAuthSecret', 'TwoFactorAuthLastKeyTimestamp', 'TwoFactorAuthRecoveryCodes', 'EditSelf', 'CalStart', 'CalEnd', 'CalNoSchool1', 'CalNoSchool2', 'CalNoSchool3', 'CalNoSchool4', 'CalNoSchool5', 'CalNoSchool6', 'CalNoSchool7', 'CalNoSchool8', 'Searchfamily', ],
        self::TYPE_CAMELNAME     => ['personId', 'password', 'needPasswordChange', 'lastLogin', 'loginCount', 'failedLogins', 'addRecords', 'editRecords', 'deleteRecords', 'menuOptions', 'manageGroups', 'finance', 'notes', 'admin', 'defaultFY', 'currentDeposit', 'userName', 'userStyle', 'apiKey', 'twoFactorAuthSecret', 'twoFactorAuthLastKeyTimestamp', 'twoFactorAuthRecoveryCodes', 'editSelf', 'calStart', 'calEnd', 'calNoSchool1', 'calNoSchool2', 'calNoSchool3', 'calNoSchool4', 'calNoSchool5', 'calNoSchool6', 'calNoSchool7', 'calNoSchool8', 'searchfamily', ],
        self::TYPE_COLNAME       => [UserTableMap::COL_USR_PER_ID, UserTableMap::COL_USR_PASSWORD, UserTableMap::COL_USR_NEEDPASSWORDCHANGE, UserTableMap::COL_USR_LASTLOGIN, UserTableMap::COL_USR_LOGINCOUNT, UserTableMap::COL_USR_FAILEDLOGINS, UserTableMap::COL_USR_ADDRECORDS, UserTableMap::COL_USR_EDITRECORDS, UserTableMap::COL_USR_DELETERECORDS, UserTableMap::COL_USR_MENUOPTIONS, UserTableMap::COL_USR_MANAGEGROUPS, UserTableMap::COL_USR_FINANCE, UserTableMap::COL_USR_NOTES, UserTableMap::COL_USR_ADMIN, UserTableMap::COL_USR_DEFAULTFY, UserTableMap::COL_USR_CURRENTDEPOSIT, UserTableMap::COL_USR_USERNAME, UserTableMap::COL_USR_STYLE, UserTableMap::COL_USR_APIKEY, UserTableMap::COL_USR_TWOFACTORAUTHSECRET, UserTableMap::COL_USR_TWOFACTORAUTHLASTKEYTIMESTAMP, UserTableMap::COL_USR_TWOFACTORAUTHRECOVERYCODES, UserTableMap::COL_USR_EDITSELF, UserTableMap::COL_USR_CALSTART, UserTableMap::COL_USR_CALEND, UserTableMap::COL_USR_CALNOSCHOOL1, UserTableMap::COL_USR_CALNOSCHOOL2, UserTableMap::COL_USR_CALNOSCHOOL3, UserTableMap::COL_USR_CALNOSCHOOL4, UserTableMap::COL_USR_CALNOSCHOOL5, UserTableMap::COL_USR_CALNOSCHOOL6, UserTableMap::COL_USR_CALNOSCHOOL7, UserTableMap::COL_USR_CALNOSCHOOL8, UserTableMap::COL_USR_SEARCHFAMILY, ],
        self::TYPE_FIELDNAME     => ['usr_per_ID', 'usr_Password', 'usr_NeedPasswordChange', 'usr_LastLogin', 'usr_LoginCount', 'usr_FailedLogins', 'usr_AddRecords', 'usr_EditRecords', 'usr_DeleteRecords', 'usr_MenuOptions', 'usr_ManageGroups', 'usr_Finance', 'usr_Notes', 'usr_Admin', 'usr_defaultFY', 'usr_currentDeposit', 'usr_UserName', 'usr_Style', 'usr_ApiKey', 'usr_TwoFactorAuthSecret', 'usr_TwoFactorAuthLastKeyTimestamp', 'usr_TwoFactorAuthRecoveryCodes', 'usr_EditSelf', 'usr_CalStart', 'usr_CalEnd', 'usr_CalNoSchool1', 'usr_CalNoSchool2', 'usr_CalNoSchool3', 'usr_CalNoSchool4', 'usr_CalNoSchool5', 'usr_CalNoSchool6', 'usr_CalNoSchool7', 'usr_CalNoSchool8', 'usr_SearchFamily', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, ]
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
        self::TYPE_PHPNAME       => ['PersonId' => 0, 'Password' => 1, 'NeedPasswordChange' => 2, 'LastLogin' => 3, 'LoginCount' => 4, 'FailedLogins' => 5, 'AddRecords' => 6, 'EditRecords' => 7, 'DeleteRecords' => 8, 'MenuOptions' => 9, 'ManageGroups' => 10, 'Finance' => 11, 'Notes' => 12, 'Admin' => 13, 'DefaultFY' => 14, 'CurrentDeposit' => 15, 'UserName' => 16, 'UserStyle' => 17, 'ApiKey' => 18, 'TwoFactorAuthSecret' => 19, 'TwoFactorAuthLastKeyTimestamp' => 20, 'TwoFactorAuthRecoveryCodes' => 21, 'EditSelf' => 22, 'CalStart' => 23, 'CalEnd' => 24, 'CalNoSchool1' => 25, 'CalNoSchool2' => 26, 'CalNoSchool3' => 27, 'CalNoSchool4' => 28, 'CalNoSchool5' => 29, 'CalNoSchool6' => 30, 'CalNoSchool7' => 31, 'CalNoSchool8' => 32, 'Searchfamily' => 33, ],
        self::TYPE_CAMELNAME     => ['personId' => 0, 'password' => 1, 'needPasswordChange' => 2, 'lastLogin' => 3, 'loginCount' => 4, 'failedLogins' => 5, 'addRecords' => 6, 'editRecords' => 7, 'deleteRecords' => 8, 'menuOptions' => 9, 'manageGroups' => 10, 'finance' => 11, 'notes' => 12, 'admin' => 13, 'defaultFY' => 14, 'currentDeposit' => 15, 'userName' => 16, 'userStyle' => 17, 'apiKey' => 18, 'twoFactorAuthSecret' => 19, 'twoFactorAuthLastKeyTimestamp' => 20, 'twoFactorAuthRecoveryCodes' => 21, 'editSelf' => 22, 'calStart' => 23, 'calEnd' => 24, 'calNoSchool1' => 25, 'calNoSchool2' => 26, 'calNoSchool3' => 27, 'calNoSchool4' => 28, 'calNoSchool5' => 29, 'calNoSchool6' => 30, 'calNoSchool7' => 31, 'calNoSchool8' => 32, 'searchfamily' => 33, ],
        self::TYPE_COLNAME       => [UserTableMap::COL_USR_PER_ID => 0, UserTableMap::COL_USR_PASSWORD => 1, UserTableMap::COL_USR_NEEDPASSWORDCHANGE => 2, UserTableMap::COL_USR_LASTLOGIN => 3, UserTableMap::COL_USR_LOGINCOUNT => 4, UserTableMap::COL_USR_FAILEDLOGINS => 5, UserTableMap::COL_USR_ADDRECORDS => 6, UserTableMap::COL_USR_EDITRECORDS => 7, UserTableMap::COL_USR_DELETERECORDS => 8, UserTableMap::COL_USR_MENUOPTIONS => 9, UserTableMap::COL_USR_MANAGEGROUPS => 10, UserTableMap::COL_USR_FINANCE => 11, UserTableMap::COL_USR_NOTES => 12, UserTableMap::COL_USR_ADMIN => 13, UserTableMap::COL_USR_DEFAULTFY => 14, UserTableMap::COL_USR_CURRENTDEPOSIT => 15, UserTableMap::COL_USR_USERNAME => 16, UserTableMap::COL_USR_STYLE => 17, UserTableMap::COL_USR_APIKEY => 18, UserTableMap::COL_USR_TWOFACTORAUTHSECRET => 19, UserTableMap::COL_USR_TWOFACTORAUTHLASTKEYTIMESTAMP => 20, UserTableMap::COL_USR_TWOFACTORAUTHRECOVERYCODES => 21, UserTableMap::COL_USR_EDITSELF => 22, UserTableMap::COL_USR_CALSTART => 23, UserTableMap::COL_USR_CALEND => 24, UserTableMap::COL_USR_CALNOSCHOOL1 => 25, UserTableMap::COL_USR_CALNOSCHOOL2 => 26, UserTableMap::COL_USR_CALNOSCHOOL3 => 27, UserTableMap::COL_USR_CALNOSCHOOL4 => 28, UserTableMap::COL_USR_CALNOSCHOOL5 => 29, UserTableMap::COL_USR_CALNOSCHOOL6 => 30, UserTableMap::COL_USR_CALNOSCHOOL7 => 31, UserTableMap::COL_USR_CALNOSCHOOL8 => 32, UserTableMap::COL_USR_SEARCHFAMILY => 33, ],
        self::TYPE_FIELDNAME     => ['usr_per_ID' => 0, 'usr_Password' => 1, 'usr_NeedPasswordChange' => 2, 'usr_LastLogin' => 3, 'usr_LoginCount' => 4, 'usr_FailedLogins' => 5, 'usr_AddRecords' => 6, 'usr_EditRecords' => 7, 'usr_DeleteRecords' => 8, 'usr_MenuOptions' => 9, 'usr_ManageGroups' => 10, 'usr_Finance' => 11, 'usr_Notes' => 12, 'usr_Admin' => 13, 'usr_defaultFY' => 14, 'usr_currentDeposit' => 15, 'usr_UserName' => 16, 'usr_Style' => 17, 'usr_ApiKey' => 18, 'usr_TwoFactorAuthSecret' => 19, 'usr_TwoFactorAuthLastKeyTimestamp' => 20, 'usr_TwoFactorAuthRecoveryCodes' => 21, 'usr_EditSelf' => 22, 'usr_CalStart' => 23, 'usr_CalEnd' => 24, 'usr_CalNoSchool1' => 25, 'usr_CalNoSchool2' => 26, 'usr_CalNoSchool3' => 27, 'usr_CalNoSchool4' => 28, 'usr_CalNoSchool5' => 29, 'usr_CalNoSchool6' => 30, 'usr_CalNoSchool7' => 31, 'usr_CalNoSchool8' => 32, 'usr_SearchFamily' => 33, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string, string>
     */
    protected $normalizedColumnNameMap = [
        'PersonId' => 'USR_PER_ID',
        'User.PersonId' => 'USR_PER_ID',
        'personId' => 'USR_PER_ID',
        'user.personId' => 'USR_PER_ID',
        'UserTableMap::COL_USR_PER_ID' => 'USR_PER_ID',
        'COL_USR_PER_ID' => 'USR_PER_ID',
        'usr_per_ID' => 'USR_PER_ID',
        'user_usr.usr_per_ID' => 'USR_PER_ID',
        'Password' => 'USR_PASSWORD',
        'User.Password' => 'USR_PASSWORD',
        'password' => 'USR_PASSWORD',
        'user.password' => 'USR_PASSWORD',
        'UserTableMap::COL_USR_PASSWORD' => 'USR_PASSWORD',
        'COL_USR_PASSWORD' => 'USR_PASSWORD',
        'usr_Password' => 'USR_PASSWORD',
        'user_usr.usr_Password' => 'USR_PASSWORD',
        'NeedPasswordChange' => 'USR_NEEDPASSWORDCHANGE',
        'User.NeedPasswordChange' => 'USR_NEEDPASSWORDCHANGE',
        'needPasswordChange' => 'USR_NEEDPASSWORDCHANGE',
        'user.needPasswordChange' => 'USR_NEEDPASSWORDCHANGE',
        'UserTableMap::COL_USR_NEEDPASSWORDCHANGE' => 'USR_NEEDPASSWORDCHANGE',
        'COL_USR_NEEDPASSWORDCHANGE' => 'USR_NEEDPASSWORDCHANGE',
        'usr_NeedPasswordChange' => 'USR_NEEDPASSWORDCHANGE',
        'user_usr.usr_NeedPasswordChange' => 'USR_NEEDPASSWORDCHANGE',
        'LastLogin' => 'USR_LASTLOGIN',
        'User.LastLogin' => 'USR_LASTLOGIN',
        'lastLogin' => 'USR_LASTLOGIN',
        'user.lastLogin' => 'USR_LASTLOGIN',
        'UserTableMap::COL_USR_LASTLOGIN' => 'USR_LASTLOGIN',
        'COL_USR_LASTLOGIN' => 'USR_LASTLOGIN',
        'usr_LastLogin' => 'USR_LASTLOGIN',
        'user_usr.usr_LastLogin' => 'USR_LASTLOGIN',
        'LoginCount' => 'USR_LOGINCOUNT',
        'User.LoginCount' => 'USR_LOGINCOUNT',
        'loginCount' => 'USR_LOGINCOUNT',
        'user.loginCount' => 'USR_LOGINCOUNT',
        'UserTableMap::COL_USR_LOGINCOUNT' => 'USR_LOGINCOUNT',
        'COL_USR_LOGINCOUNT' => 'USR_LOGINCOUNT',
        'usr_LoginCount' => 'USR_LOGINCOUNT',
        'user_usr.usr_LoginCount' => 'USR_LOGINCOUNT',
        'FailedLogins' => 'USR_FAILEDLOGINS',
        'User.FailedLogins' => 'USR_FAILEDLOGINS',
        'failedLogins' => 'USR_FAILEDLOGINS',
        'user.failedLogins' => 'USR_FAILEDLOGINS',
        'UserTableMap::COL_USR_FAILEDLOGINS' => 'USR_FAILEDLOGINS',
        'COL_USR_FAILEDLOGINS' => 'USR_FAILEDLOGINS',
        'usr_FailedLogins' => 'USR_FAILEDLOGINS',
        'user_usr.usr_FailedLogins' => 'USR_FAILEDLOGINS',
        'AddRecords' => 'USR_ADDRECORDS',
        'User.AddRecords' => 'USR_ADDRECORDS',
        'addRecords' => 'USR_ADDRECORDS',
        'user.addRecords' => 'USR_ADDRECORDS',
        'UserTableMap::COL_USR_ADDRECORDS' => 'USR_ADDRECORDS',
        'COL_USR_ADDRECORDS' => 'USR_ADDRECORDS',
        'usr_AddRecords' => 'USR_ADDRECORDS',
        'user_usr.usr_AddRecords' => 'USR_ADDRECORDS',
        'EditRecords' => 'USR_EDITRECORDS',
        'User.EditRecords' => 'USR_EDITRECORDS',
        'editRecords' => 'USR_EDITRECORDS',
        'user.editRecords' => 'USR_EDITRECORDS',
        'UserTableMap::COL_USR_EDITRECORDS' => 'USR_EDITRECORDS',
        'COL_USR_EDITRECORDS' => 'USR_EDITRECORDS',
        'usr_EditRecords' => 'USR_EDITRECORDS',
        'user_usr.usr_EditRecords' => 'USR_EDITRECORDS',
        'DeleteRecords' => 'USR_DELETERECORDS',
        'User.DeleteRecords' => 'USR_DELETERECORDS',
        'deleteRecords' => 'USR_DELETERECORDS',
        'user.deleteRecords' => 'USR_DELETERECORDS',
        'UserTableMap::COL_USR_DELETERECORDS' => 'USR_DELETERECORDS',
        'COL_USR_DELETERECORDS' => 'USR_DELETERECORDS',
        'usr_DeleteRecords' => 'USR_DELETERECORDS',
        'user_usr.usr_DeleteRecords' => 'USR_DELETERECORDS',
        'MenuOptions' => 'USR_MENUOPTIONS',
        'User.MenuOptions' => 'USR_MENUOPTIONS',
        'menuOptions' => 'USR_MENUOPTIONS',
        'user.menuOptions' => 'USR_MENUOPTIONS',
        'UserTableMap::COL_USR_MENUOPTIONS' => 'USR_MENUOPTIONS',
        'COL_USR_MENUOPTIONS' => 'USR_MENUOPTIONS',
        'usr_MenuOptions' => 'USR_MENUOPTIONS',
        'user_usr.usr_MenuOptions' => 'USR_MENUOPTIONS',
        'ManageGroups' => 'USR_MANAGEGROUPS',
        'User.ManageGroups' => 'USR_MANAGEGROUPS',
        'manageGroups' => 'USR_MANAGEGROUPS',
        'user.manageGroups' => 'USR_MANAGEGROUPS',
        'UserTableMap::COL_USR_MANAGEGROUPS' => 'USR_MANAGEGROUPS',
        'COL_USR_MANAGEGROUPS' => 'USR_MANAGEGROUPS',
        'usr_ManageGroups' => 'USR_MANAGEGROUPS',
        'user_usr.usr_ManageGroups' => 'USR_MANAGEGROUPS',
        'Finance' => 'USR_FINANCE',
        'User.Finance' => 'USR_FINANCE',
        'finance' => 'USR_FINANCE',
        'user.finance' => 'USR_FINANCE',
        'UserTableMap::COL_USR_FINANCE' => 'USR_FINANCE',
        'COL_USR_FINANCE' => 'USR_FINANCE',
        'usr_Finance' => 'USR_FINANCE',
        'user_usr.usr_Finance' => 'USR_FINANCE',
        'Notes' => 'USR_NOTES',
        'User.Notes' => 'USR_NOTES',
        'notes' => 'USR_NOTES',
        'user.notes' => 'USR_NOTES',
        'UserTableMap::COL_USR_NOTES' => 'USR_NOTES',
        'COL_USR_NOTES' => 'USR_NOTES',
        'usr_Notes' => 'USR_NOTES',
        'user_usr.usr_Notes' => 'USR_NOTES',
        'Admin' => 'USR_ADMIN',
        'User.Admin' => 'USR_ADMIN',
        'admin' => 'USR_ADMIN',
        'user.admin' => 'USR_ADMIN',
        'UserTableMap::COL_USR_ADMIN' => 'USR_ADMIN',
        'COL_USR_ADMIN' => 'USR_ADMIN',
        'usr_Admin' => 'USR_ADMIN',
        'user_usr.usr_Admin' => 'USR_ADMIN',
        'DefaultFY' => 'USR_DEFAULTFY',
        'User.DefaultFY' => 'USR_DEFAULTFY',
        'defaultFY' => 'USR_DEFAULTFY',
        'user.defaultFY' => 'USR_DEFAULTFY',
        'UserTableMap::COL_USR_DEFAULTFY' => 'USR_DEFAULTFY',
        'COL_USR_DEFAULTFY' => 'USR_DEFAULTFY',
        'usr_defaultFY' => 'USR_DEFAULTFY',
        'user_usr.usr_defaultFY' => 'USR_DEFAULTFY',
        'CurrentDeposit' => 'USR_CURRENTDEPOSIT',
        'User.CurrentDeposit' => 'USR_CURRENTDEPOSIT',
        'currentDeposit' => 'USR_CURRENTDEPOSIT',
        'user.currentDeposit' => 'USR_CURRENTDEPOSIT',
        'UserTableMap::COL_USR_CURRENTDEPOSIT' => 'USR_CURRENTDEPOSIT',
        'COL_USR_CURRENTDEPOSIT' => 'USR_CURRENTDEPOSIT',
        'usr_currentDeposit' => 'USR_CURRENTDEPOSIT',
        'user_usr.usr_currentDeposit' => 'USR_CURRENTDEPOSIT',
        'UserName' => 'USR_USERNAME',
        'User.UserName' => 'USR_USERNAME',
        'userName' => 'USR_USERNAME',
        'user.userName' => 'USR_USERNAME',
        'UserTableMap::COL_USR_USERNAME' => 'USR_USERNAME',
        'COL_USR_USERNAME' => 'USR_USERNAME',
        'usr_UserName' => 'USR_USERNAME',
        'user_usr.usr_UserName' => 'USR_USERNAME',
        'UserStyle' => 'USR_STYLE',
        'User.UserStyle' => 'USR_STYLE',
        'userStyle' => 'USR_STYLE',
        'user.userStyle' => 'USR_STYLE',
        'UserTableMap::COL_USR_STYLE' => 'USR_STYLE',
        'COL_USR_STYLE' => 'USR_STYLE',
        'usr_Style' => 'USR_STYLE',
        'user_usr.usr_Style' => 'USR_STYLE',
        'ApiKey' => 'USR_APIKEY',
        'User.ApiKey' => 'USR_APIKEY',
        'apiKey' => 'USR_APIKEY',
        'user.apiKey' => 'USR_APIKEY',
        'UserTableMap::COL_USR_APIKEY' => 'USR_APIKEY',
        'COL_USR_APIKEY' => 'USR_APIKEY',
        'usr_ApiKey' => 'USR_APIKEY',
        'user_usr.usr_ApiKey' => 'USR_APIKEY',
        'TwoFactorAuthSecret' => 'USR_TWOFACTORAUTHSECRET',
        'User.TwoFactorAuthSecret' => 'USR_TWOFACTORAUTHSECRET',
        'twoFactorAuthSecret' => 'USR_TWOFACTORAUTHSECRET',
        'user.twoFactorAuthSecret' => 'USR_TWOFACTORAUTHSECRET',
        'UserTableMap::COL_USR_TWOFACTORAUTHSECRET' => 'USR_TWOFACTORAUTHSECRET',
        'COL_USR_TWOFACTORAUTHSECRET' => 'USR_TWOFACTORAUTHSECRET',
        'usr_TwoFactorAuthSecret' => 'USR_TWOFACTORAUTHSECRET',
        'user_usr.usr_TwoFactorAuthSecret' => 'USR_TWOFACTORAUTHSECRET',
        'TwoFactorAuthLastKeyTimestamp' => 'USR_TWOFACTORAUTHLASTKEYTIMESTAMP',
        'User.TwoFactorAuthLastKeyTimestamp' => 'USR_TWOFACTORAUTHLASTKEYTIMESTAMP',
        'twoFactorAuthLastKeyTimestamp' => 'USR_TWOFACTORAUTHLASTKEYTIMESTAMP',
        'user.twoFactorAuthLastKeyTimestamp' => 'USR_TWOFACTORAUTHLASTKEYTIMESTAMP',
        'UserTableMap::COL_USR_TWOFACTORAUTHLASTKEYTIMESTAMP' => 'USR_TWOFACTORAUTHLASTKEYTIMESTAMP',
        'COL_USR_TWOFACTORAUTHLASTKEYTIMESTAMP' => 'USR_TWOFACTORAUTHLASTKEYTIMESTAMP',
        'usr_TwoFactorAuthLastKeyTimestamp' => 'USR_TWOFACTORAUTHLASTKEYTIMESTAMP',
        'user_usr.usr_TwoFactorAuthLastKeyTimestamp' => 'USR_TWOFACTORAUTHLASTKEYTIMESTAMP',
        'TwoFactorAuthRecoveryCodes' => 'USR_TWOFACTORAUTHRECOVERYCODES',
        'User.TwoFactorAuthRecoveryCodes' => 'USR_TWOFACTORAUTHRECOVERYCODES',
        'twoFactorAuthRecoveryCodes' => 'USR_TWOFACTORAUTHRECOVERYCODES',
        'user.twoFactorAuthRecoveryCodes' => 'USR_TWOFACTORAUTHRECOVERYCODES',
        'UserTableMap::COL_USR_TWOFACTORAUTHRECOVERYCODES' => 'USR_TWOFACTORAUTHRECOVERYCODES',
        'COL_USR_TWOFACTORAUTHRECOVERYCODES' => 'USR_TWOFACTORAUTHRECOVERYCODES',
        'usr_TwoFactorAuthRecoveryCodes' => 'USR_TWOFACTORAUTHRECOVERYCODES',
        'user_usr.usr_TwoFactorAuthRecoveryCodes' => 'USR_TWOFACTORAUTHRECOVERYCODES',
        'EditSelf' => 'USR_EDITSELF',
        'User.EditSelf' => 'USR_EDITSELF',
        'editSelf' => 'USR_EDITSELF',
        'user.editSelf' => 'USR_EDITSELF',
        'UserTableMap::COL_USR_EDITSELF' => 'USR_EDITSELF',
        'COL_USR_EDITSELF' => 'USR_EDITSELF',
        'usr_EditSelf' => 'USR_EDITSELF',
        'user_usr.usr_EditSelf' => 'USR_EDITSELF',
        'CalStart' => 'USR_CALSTART',
        'User.CalStart' => 'USR_CALSTART',
        'calStart' => 'USR_CALSTART',
        'user.calStart' => 'USR_CALSTART',
        'UserTableMap::COL_USR_CALSTART' => 'USR_CALSTART',
        'COL_USR_CALSTART' => 'USR_CALSTART',
        'usr_CalStart' => 'USR_CALSTART',
        'user_usr.usr_CalStart' => 'USR_CALSTART',
        'CalEnd' => 'USR_CALEND',
        'User.CalEnd' => 'USR_CALEND',
        'calEnd' => 'USR_CALEND',
        'user.calEnd' => 'USR_CALEND',
        'UserTableMap::COL_USR_CALEND' => 'USR_CALEND',
        'COL_USR_CALEND' => 'USR_CALEND',
        'usr_CalEnd' => 'USR_CALEND',
        'user_usr.usr_CalEnd' => 'USR_CALEND',
        'CalNoSchool1' => 'USR_CALNOSCHOOL1',
        'User.CalNoSchool1' => 'USR_CALNOSCHOOL1',
        'calNoSchool1' => 'USR_CALNOSCHOOL1',
        'user.calNoSchool1' => 'USR_CALNOSCHOOL1',
        'UserTableMap::COL_USR_CALNOSCHOOL1' => 'USR_CALNOSCHOOL1',
        'COL_USR_CALNOSCHOOL1' => 'USR_CALNOSCHOOL1',
        'usr_CalNoSchool1' => 'USR_CALNOSCHOOL1',
        'user_usr.usr_CalNoSchool1' => 'USR_CALNOSCHOOL1',
        'CalNoSchool2' => 'USR_CALNOSCHOOL2',
        'User.CalNoSchool2' => 'USR_CALNOSCHOOL2',
        'calNoSchool2' => 'USR_CALNOSCHOOL2',
        'user.calNoSchool2' => 'USR_CALNOSCHOOL2',
        'UserTableMap::COL_USR_CALNOSCHOOL2' => 'USR_CALNOSCHOOL2',
        'COL_USR_CALNOSCHOOL2' => 'USR_CALNOSCHOOL2',
        'usr_CalNoSchool2' => 'USR_CALNOSCHOOL2',
        'user_usr.usr_CalNoSchool2' => 'USR_CALNOSCHOOL2',
        'CalNoSchool3' => 'USR_CALNOSCHOOL3',
        'User.CalNoSchool3' => 'USR_CALNOSCHOOL3',
        'calNoSchool3' => 'USR_CALNOSCHOOL3',
        'user.calNoSchool3' => 'USR_CALNOSCHOOL3',
        'UserTableMap::COL_USR_CALNOSCHOOL3' => 'USR_CALNOSCHOOL3',
        'COL_USR_CALNOSCHOOL3' => 'USR_CALNOSCHOOL3',
        'usr_CalNoSchool3' => 'USR_CALNOSCHOOL3',
        'user_usr.usr_CalNoSchool3' => 'USR_CALNOSCHOOL3',
        'CalNoSchool4' => 'USR_CALNOSCHOOL4',
        'User.CalNoSchool4' => 'USR_CALNOSCHOOL4',
        'calNoSchool4' => 'USR_CALNOSCHOOL4',
        'user.calNoSchool4' => 'USR_CALNOSCHOOL4',
        'UserTableMap::COL_USR_CALNOSCHOOL4' => 'USR_CALNOSCHOOL4',
        'COL_USR_CALNOSCHOOL4' => 'USR_CALNOSCHOOL4',
        'usr_CalNoSchool4' => 'USR_CALNOSCHOOL4',
        'user_usr.usr_CalNoSchool4' => 'USR_CALNOSCHOOL4',
        'CalNoSchool5' => 'USR_CALNOSCHOOL5',
        'User.CalNoSchool5' => 'USR_CALNOSCHOOL5',
        'calNoSchool5' => 'USR_CALNOSCHOOL5',
        'user.calNoSchool5' => 'USR_CALNOSCHOOL5',
        'UserTableMap::COL_USR_CALNOSCHOOL5' => 'USR_CALNOSCHOOL5',
        'COL_USR_CALNOSCHOOL5' => 'USR_CALNOSCHOOL5',
        'usr_CalNoSchool5' => 'USR_CALNOSCHOOL5',
        'user_usr.usr_CalNoSchool5' => 'USR_CALNOSCHOOL5',
        'CalNoSchool6' => 'USR_CALNOSCHOOL6',
        'User.CalNoSchool6' => 'USR_CALNOSCHOOL6',
        'calNoSchool6' => 'USR_CALNOSCHOOL6',
        'user.calNoSchool6' => 'USR_CALNOSCHOOL6',
        'UserTableMap::COL_USR_CALNOSCHOOL6' => 'USR_CALNOSCHOOL6',
        'COL_USR_CALNOSCHOOL6' => 'USR_CALNOSCHOOL6',
        'usr_CalNoSchool6' => 'USR_CALNOSCHOOL6',
        'user_usr.usr_CalNoSchool6' => 'USR_CALNOSCHOOL6',
        'CalNoSchool7' => 'USR_CALNOSCHOOL7',
        'User.CalNoSchool7' => 'USR_CALNOSCHOOL7',
        'calNoSchool7' => 'USR_CALNOSCHOOL7',
        'user.calNoSchool7' => 'USR_CALNOSCHOOL7',
        'UserTableMap::COL_USR_CALNOSCHOOL7' => 'USR_CALNOSCHOOL7',
        'COL_USR_CALNOSCHOOL7' => 'USR_CALNOSCHOOL7',
        'usr_CalNoSchool7' => 'USR_CALNOSCHOOL7',
        'user_usr.usr_CalNoSchool7' => 'USR_CALNOSCHOOL7',
        'CalNoSchool8' => 'USR_CALNOSCHOOL8',
        'User.CalNoSchool8' => 'USR_CALNOSCHOOL8',
        'calNoSchool8' => 'USR_CALNOSCHOOL8',
        'user.calNoSchool8' => 'USR_CALNOSCHOOL8',
        'UserTableMap::COL_USR_CALNOSCHOOL8' => 'USR_CALNOSCHOOL8',
        'COL_USR_CALNOSCHOOL8' => 'USR_CALNOSCHOOL8',
        'usr_CalNoSchool8' => 'USR_CALNOSCHOOL8',
        'user_usr.usr_CalNoSchool8' => 'USR_CALNOSCHOOL8',
        'Searchfamily' => 'USR_SEARCHFAMILY',
        'User.Searchfamily' => 'USR_SEARCHFAMILY',
        'searchfamily' => 'USR_SEARCHFAMILY',
        'user.searchfamily' => 'USR_SEARCHFAMILY',
        'UserTableMap::COL_USR_SEARCHFAMILY' => 'USR_SEARCHFAMILY',
        'COL_USR_SEARCHFAMILY' => 'USR_SEARCHFAMILY',
        'usr_SearchFamily' => 'USR_SEARCHFAMILY',
        'user_usr.usr_SearchFamily' => 'USR_SEARCHFAMILY',
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
        $this->setName('user_usr');
        $this->setPhpName('User');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ChurchCRM\\model\\ChurchCRM\\User');
        $this->setPackage('ChurchCRM.model.ChurchCRM');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('usr_per_ID', 'PersonId', 'SMALLINT', 'person_per', 'per_ID', true, 9, 0);
        $this->addColumn('usr_Password', 'Password', 'VARCHAR', true, 500, '');
        $this->addColumn('usr_NeedPasswordChange', 'NeedPasswordChange', 'BOOLEAN', true, 1, true);
        $this->addColumn('usr_LastLogin', 'LastLogin', 'TIMESTAMP', true, null, '2016-01-01 00:00:00');
        $this->addColumn('usr_LoginCount', 'LoginCount', 'SMALLINT', true, 5, 0);
        $this->addColumn('usr_FailedLogins', 'FailedLogins', 'TINYINT', true, 3, 0);
        $this->addColumn('usr_AddRecords', 'AddRecords', 'BOOLEAN', true, 1, false);
        $this->addColumn('usr_EditRecords', 'EditRecords', 'BOOLEAN', true, 1, false);
        $this->addColumn('usr_DeleteRecords', 'DeleteRecords', 'BOOLEAN', true, 1, false);
        $this->addColumn('usr_MenuOptions', 'MenuOptions', 'BOOLEAN', true, 1, false);
        $this->addColumn('usr_ManageGroups', 'ManageGroups', 'BOOLEAN', true, 1, false);
        $this->addColumn('usr_Finance', 'Finance', 'BOOLEAN', true, 1, false);
        $this->addColumn('usr_Notes', 'Notes', 'BOOLEAN', true, 1, false);
        $this->addColumn('usr_Admin', 'Admin', 'BOOLEAN', true, 1, false);
        $this->addColumn('usr_defaultFY', 'DefaultFY', 'SMALLINT', true, 9, 10);
        $this->addColumn('usr_currentDeposit', 'CurrentDeposit', 'SMALLINT', true, 9, 0);
        $this->addColumn('usr_UserName', 'UserName', 'VARCHAR', true, 32, null);
        $this->addColumn('usr_Style', 'UserStyle', 'VARCHAR', false, 50, null);
        $this->addColumn('usr_ApiKey', 'ApiKey', 'VARCHAR', false, 255, null);
        $this->addColumn('usr_TwoFactorAuthSecret', 'TwoFactorAuthSecret', 'VARCHAR', false, 255, null);
        $this->addColumn('usr_TwoFactorAuthLastKeyTimestamp', 'TwoFactorAuthLastKeyTimestamp', 'SMALLINT', false, 9, null);
        $this->addColumn('usr_TwoFactorAuthRecoveryCodes', 'TwoFactorAuthRecoveryCodes', 'LONGVARCHAR', false, null, null);
        $this->addColumn('usr_EditSelf', 'EditSelf', 'BOOLEAN', true, 1, false);
        $this->addColumn('usr_CalStart', 'CalStart', 'DATE', false, null, null);
        $this->addColumn('usr_CalEnd', 'CalEnd', 'DATE', false, null, null);
        $this->addColumn('usr_CalNoSchool1', 'CalNoSchool1', 'DATE', false, null, null);
        $this->addColumn('usr_CalNoSchool2', 'CalNoSchool2', 'DATE', false, null, null);
        $this->addColumn('usr_CalNoSchool3', 'CalNoSchool3', 'DATE', false, null, null);
        $this->addColumn('usr_CalNoSchool4', 'CalNoSchool4', 'DATE', false, null, null);
        $this->addColumn('usr_CalNoSchool5', 'CalNoSchool5', 'DATE', false, null, null);
        $this->addColumn('usr_CalNoSchool6', 'CalNoSchool6', 'DATE', false, null, null);
        $this->addColumn('usr_CalNoSchool7', 'CalNoSchool7', 'DATE', false, null, null);
        $this->addColumn('usr_CalNoSchool8', 'CalNoSchool8', 'DATE', false, null, null);
        $this->addColumn('usr_SearchFamily', 'Searchfamily', 'TINYINT', false, 3, null);
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
            RelationMap::MANY_TO_ONE,
            [[':usr_per_ID', ':per_ID']],
            null,
            null,
            null,
            false
        );
        $this->addRelation(
            'UserConfig',
            '\\ChurchCRM\\model\\ChurchCRM\\UserConfig',
            RelationMap::ONE_TO_MANY,
            [[':ucfg_per_id', ':usr_per_ID']],
            null,
            null,
            'UserConfigs',
            false
        );
        $this->addRelation(
            'UserSetting',
            '\\ChurchCRM\\model\\ChurchCRM\\UserSetting',
            RelationMap::ONE_TO_MANY,
            [[':user_id', ':usr_per_ID']],
            null,
            null,
            'UserSettings',
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PersonId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PersonId', TableMap::TYPE_PHPNAME, $indexType)] === null || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PersonId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PersonId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string)$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PersonId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PersonId', TableMap::TYPE_PHPNAME, $indexType)];
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
        $personIdIx = $indexType === TableMap::TYPE_NUM
            ? 0 + $offset
            : self::translateFieldName('PersonId', TableMap::TYPE_PHPNAME, $indexType);

        return (int)$row[$personIdIx];
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
        return $withPrefix ? UserTableMap::CLASS_DEFAULT : UserTableMap::OM_CLASS;
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
     * @return array (User object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = UserTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (($obj = UserTableMap::getInstanceFromPool($key)) !== null) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + UserTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = UserTableMap::OM_CLASS;
            /** @var User $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            UserTableMap::addInstanceToPool($obj, $key);
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
            $key = UserTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (($obj = UserTableMap::getInstanceFromPool($key)) !== null) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new User();
                $obj->hydrate($row);
                $results[] = $obj;
                UserTableMap::addInstanceToPool($obj, $key);
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
        $tableAlias = $alias ?: 'user_usr';
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_PER_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_PASSWORD']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_NEEDPASSWORDCHANGE']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_LASTLOGIN']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_LOGINCOUNT']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_FAILEDLOGINS']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_ADDRECORDS']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_EDITRECORDS']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_DELETERECORDS']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_MENUOPTIONS']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_MANAGEGROUPS']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_FINANCE']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_NOTES']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_ADMIN']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_DEFAULTFY']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_CURRENTDEPOSIT']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_USERNAME']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_STYLE']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_APIKEY']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_TWOFACTORAUTHSECRET']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_TWOFACTORAUTHLASTKEYTIMESTAMP']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_TWOFACTORAUTHRECOVERYCODES']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_EDITSELF']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_CALSTART']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_CALEND']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_CALNOSCHOOL1']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_CALNOSCHOOL2']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_CALNOSCHOOL3']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_CALNOSCHOOL4']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_CALNOSCHOOL5']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_CALNOSCHOOL6']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_CALNOSCHOOL7']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_CALNOSCHOOL8']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USR_SEARCHFAMILY']));
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
            $criteria->removeSelectColumn(UserTableMap::COL_USR_PER_ID);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_PASSWORD);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_NEEDPASSWORDCHANGE);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_LASTLOGIN);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_LOGINCOUNT);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_FAILEDLOGINS);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_ADDRECORDS);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_EDITRECORDS);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_DELETERECORDS);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_MENUOPTIONS);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_MANAGEGROUPS);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_FINANCE);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_NOTES);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_ADMIN);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_DEFAULTFY);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_CURRENTDEPOSIT);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_USERNAME);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_STYLE);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_APIKEY);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_TWOFACTORAUTHSECRET);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_TWOFACTORAUTHLASTKEYTIMESTAMP);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_TWOFACTORAUTHRECOVERYCODES);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_EDITSELF);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_CALSTART);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_CALEND);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_CALNOSCHOOL1);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_CALNOSCHOOL2);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_CALNOSCHOOL3);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_CALNOSCHOOL4);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_CALNOSCHOOL5);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_CALNOSCHOOL6);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_CALNOSCHOOL7);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_CALNOSCHOOL8);
            $criteria->removeSelectColumn(UserTableMap::COL_USR_SEARCHFAMILY);
        } else {
            $criteria->removeSelectColumn($alias . '.usr_per_ID');
            $criteria->removeSelectColumn($alias . '.usr_Password');
            $criteria->removeSelectColumn($alias . '.usr_NeedPasswordChange');
            $criteria->removeSelectColumn($alias . '.usr_LastLogin');
            $criteria->removeSelectColumn($alias . '.usr_LoginCount');
            $criteria->removeSelectColumn($alias . '.usr_FailedLogins');
            $criteria->removeSelectColumn($alias . '.usr_AddRecords');
            $criteria->removeSelectColumn($alias . '.usr_EditRecords');
            $criteria->removeSelectColumn($alias . '.usr_DeleteRecords');
            $criteria->removeSelectColumn($alias . '.usr_MenuOptions');
            $criteria->removeSelectColumn($alias . '.usr_ManageGroups');
            $criteria->removeSelectColumn($alias . '.usr_Finance');
            $criteria->removeSelectColumn($alias . '.usr_Notes');
            $criteria->removeSelectColumn($alias . '.usr_Admin');
            $criteria->removeSelectColumn($alias . '.usr_defaultFY');
            $criteria->removeSelectColumn($alias . '.usr_currentDeposit');
            $criteria->removeSelectColumn($alias . '.usr_UserName');
            $criteria->removeSelectColumn($alias . '.usr_Style');
            $criteria->removeSelectColumn($alias . '.usr_ApiKey');
            $criteria->removeSelectColumn($alias . '.usr_TwoFactorAuthSecret');
            $criteria->removeSelectColumn($alias . '.usr_TwoFactorAuthLastKeyTimestamp');
            $criteria->removeSelectColumn($alias . '.usr_TwoFactorAuthRecoveryCodes');
            $criteria->removeSelectColumn($alias . '.usr_EditSelf');
            $criteria->removeSelectColumn($alias . '.usr_CalStart');
            $criteria->removeSelectColumn($alias . '.usr_CalEnd');
            $criteria->removeSelectColumn($alias . '.usr_CalNoSchool1');
            $criteria->removeSelectColumn($alias . '.usr_CalNoSchool2');
            $criteria->removeSelectColumn($alias . '.usr_CalNoSchool3');
            $criteria->removeSelectColumn($alias . '.usr_CalNoSchool4');
            $criteria->removeSelectColumn($alias . '.usr_CalNoSchool5');
            $criteria->removeSelectColumn($alias . '.usr_CalNoSchool6');
            $criteria->removeSelectColumn($alias . '.usr_CalNoSchool7');
            $criteria->removeSelectColumn($alias . '.usr_CalNoSchool8');
            $criteria->removeSelectColumn($alias . '.usr_SearchFamily');
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
        return Propel::getServiceContainer()->getDatabaseMap(UserTableMap::DATABASE_NAME)->getTable(UserTableMap::TABLE_NAME);
    }

    /**
     * @deprecated Delete via model or UserQuery.
     *
     * Performs a DELETE on the database, given a User or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or User object or primary key or array of primary keys
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
        trigger_deprecation('Propel', '2.0', 'TableMap::doDelete() should not be used anymore, delete via model or UserQuery');

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            $criteria = $values;
        } elseif ($values instanceof User) { // it's a model object
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(UserTableMap::DATABASE_NAME);
            $criteria->addAnd(UserTableMap::COL_USR_PER_ID, (array)$values, Criteria::IN);
        }

        $query = UserQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            UserTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array)$values as $singleval) {
                UserTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the user_usr table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return UserQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a User or Criteria object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|\ChurchCRM\model\ChurchCRM\User $criteria
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
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria;
            $criteria->turnFiltersToUpdateValues();
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from User object
        }

        // Set the correct dbName
        $query = UserQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }
}
