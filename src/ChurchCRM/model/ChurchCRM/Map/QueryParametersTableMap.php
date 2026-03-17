<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Map;

use ChurchCRM\model\ChurchCRM\QueryParameters;
use ChurchCRM\model\ChurchCRM\QueryParametersQuery;
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
 * This class defines the structure of the 'queryparameters_qrp' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class QueryParametersTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'ChurchCRM.model.ChurchCRM.Map.QueryParametersTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'queryparameters_qrp';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'QueryParameters';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\ChurchCRM\\model\\ChurchCRM\\QueryParameters';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'ChurchCRM.model.ChurchCRM.QueryParameters';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 15;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 15;

    /**
     * the column name for the qrp_ID field
     */
    public const COL_QRP_ID = 'queryparameters_qrp.qrp_ID';

    /**
     * the column name for the qrp_qry_ID field
     */
    public const COL_QRP_QRY_ID = 'queryparameters_qrp.qrp_qry_ID';

    /**
     * the column name for the qrp_Type field
     */
    public const COL_QRP_TYPE = 'queryparameters_qrp.qrp_Type';

    /**
     * the column name for the qrp_OptionSQL field
     */
    public const COL_QRP_OPTIONSQL = 'queryparameters_qrp.qrp_OptionSQL';

    /**
     * the column name for the qrp_Name field
     */
    public const COL_QRP_NAME = 'queryparameters_qrp.qrp_Name';

    /**
     * the column name for the qrp_Description field
     */
    public const COL_QRP_DESCRIPTION = 'queryparameters_qrp.qrp_Description';

    /**
     * the column name for the qrp_Alias field
     */
    public const COL_QRP_ALIAS = 'queryparameters_qrp.qrp_Alias';

    /**
     * the column name for the qrp_Default field
     */
    public const COL_QRP_DEFAULT = 'queryparameters_qrp.qrp_Default';

    /**
     * the column name for the qrp_Required field
     */
    public const COL_QRP_REQUIRED = 'queryparameters_qrp.qrp_Required';

    /**
     * the column name for the qrp_InputBoxSize field
     */
    public const COL_QRP_INPUTBOXSIZE = 'queryparameters_qrp.qrp_InputBoxSize';

    /**
     * the column name for the qrp_Validation field
     */
    public const COL_QRP_VALIDATION = 'queryparameters_qrp.qrp_Validation';

    /**
     * the column name for the qrp_NumericMax field
     */
    public const COL_QRP_NUMERICMAX = 'queryparameters_qrp.qrp_NumericMax';

    /**
     * the column name for the qrp_NumericMin field
     */
    public const COL_QRP_NUMERICMIN = 'queryparameters_qrp.qrp_NumericMin';

    /**
     * the column name for the qrp_AlphaMinLength field
     */
    public const COL_QRP_ALPHAMINLENGTH = 'queryparameters_qrp.qrp_AlphaMinLength';

    /**
     * the column name for the qrp_AlphaMaxLength field
     */
    public const COL_QRP_ALPHAMAXLENGTH = 'queryparameters_qrp.qrp_AlphaMaxLength';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * @var class-string<\ChurchCRM\model\ChurchCRM\Base\Collection\QueryParametersCollection>
     */
    public const DEFAULT_OBJECT_COLLECTION = '\ChurchCRM\model\ChurchCRM\Base\Collection\QueryParametersCollection';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['Id', 'QryId', 'Type', 'OptionSQL', 'Name', 'Description', 'Alias', 'Default', 'Required', 'InputBoxSize', 'Validation', 'NumericMax', 'NumericMin', 'AlphaMinLength', 'AlphaMaxLength', ],
        self::TYPE_CAMELNAME     => ['id', 'qryId', 'type', 'optionSQL', 'name', 'description', 'alias', 'default', 'required', 'inputBoxSize', 'validation', 'numericMax', 'numericMin', 'alphaMinLength', 'alphaMaxLength', ],
        self::TYPE_COLNAME       => [QueryParametersTableMap::COL_QRP_ID, QueryParametersTableMap::COL_QRP_QRY_ID, QueryParametersTableMap::COL_QRP_TYPE, QueryParametersTableMap::COL_QRP_OPTIONSQL, QueryParametersTableMap::COL_QRP_NAME, QueryParametersTableMap::COL_QRP_DESCRIPTION, QueryParametersTableMap::COL_QRP_ALIAS, QueryParametersTableMap::COL_QRP_DEFAULT, QueryParametersTableMap::COL_QRP_REQUIRED, QueryParametersTableMap::COL_QRP_INPUTBOXSIZE, QueryParametersTableMap::COL_QRP_VALIDATION, QueryParametersTableMap::COL_QRP_NUMERICMAX, QueryParametersTableMap::COL_QRP_NUMERICMIN, QueryParametersTableMap::COL_QRP_ALPHAMINLENGTH, QueryParametersTableMap::COL_QRP_ALPHAMAXLENGTH, ],
        self::TYPE_FIELDNAME     => ['qrp_ID', 'qrp_qry_ID', 'qrp_Type', 'qrp_OptionSQL', 'qrp_Name', 'qrp_Description', 'qrp_Alias', 'qrp_Default', 'qrp_Required', 'qrp_InputBoxSize', 'qrp_Validation', 'qrp_NumericMax', 'qrp_NumericMin', 'qrp_AlphaMinLength', 'qrp_AlphaMaxLength', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, ]
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
        self::TYPE_PHPNAME       => ['Id' => 0, 'QryId' => 1, 'Type' => 2, 'OptionSQL' => 3, 'Name' => 4, 'Description' => 5, 'Alias' => 6, 'Default' => 7, 'Required' => 8, 'InputBoxSize' => 9, 'Validation' => 10, 'NumericMax' => 11, 'NumericMin' => 12, 'AlphaMinLength' => 13, 'AlphaMaxLength' => 14, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'qryId' => 1, 'type' => 2, 'optionSQL' => 3, 'name' => 4, 'description' => 5, 'alias' => 6, 'default' => 7, 'required' => 8, 'inputBoxSize' => 9, 'validation' => 10, 'numericMax' => 11, 'numericMin' => 12, 'alphaMinLength' => 13, 'alphaMaxLength' => 14, ],
        self::TYPE_COLNAME       => [QueryParametersTableMap::COL_QRP_ID => 0, QueryParametersTableMap::COL_QRP_QRY_ID => 1, QueryParametersTableMap::COL_QRP_TYPE => 2, QueryParametersTableMap::COL_QRP_OPTIONSQL => 3, QueryParametersTableMap::COL_QRP_NAME => 4, QueryParametersTableMap::COL_QRP_DESCRIPTION => 5, QueryParametersTableMap::COL_QRP_ALIAS => 6, QueryParametersTableMap::COL_QRP_DEFAULT => 7, QueryParametersTableMap::COL_QRP_REQUIRED => 8, QueryParametersTableMap::COL_QRP_INPUTBOXSIZE => 9, QueryParametersTableMap::COL_QRP_VALIDATION => 10, QueryParametersTableMap::COL_QRP_NUMERICMAX => 11, QueryParametersTableMap::COL_QRP_NUMERICMIN => 12, QueryParametersTableMap::COL_QRP_ALPHAMINLENGTH => 13, QueryParametersTableMap::COL_QRP_ALPHAMAXLENGTH => 14, ],
        self::TYPE_FIELDNAME     => ['qrp_ID' => 0, 'qrp_qry_ID' => 1, 'qrp_Type' => 2, 'qrp_OptionSQL' => 3, 'qrp_Name' => 4, 'qrp_Description' => 5, 'qrp_Alias' => 6, 'qrp_Default' => 7, 'qrp_Required' => 8, 'qrp_InputBoxSize' => 9, 'qrp_Validation' => 10, 'qrp_NumericMax' => 11, 'qrp_NumericMin' => 12, 'qrp_AlphaMinLength' => 13, 'qrp_AlphaMaxLength' => 14, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string, string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'QRP_ID',
        'QueryParameters.Id' => 'QRP_ID',
        'id' => 'QRP_ID',
        'queryParameters.id' => 'QRP_ID',
        'QueryParametersTableMap::COL_QRP_ID' => 'QRP_ID',
        'COL_QRP_ID' => 'QRP_ID',
        'qrp_ID' => 'QRP_ID',
        'queryparameters_qrp.qrp_ID' => 'QRP_ID',
        'QryId' => 'QRP_QRY_ID',
        'QueryParameters.QryId' => 'QRP_QRY_ID',
        'qryId' => 'QRP_QRY_ID',
        'queryParameters.qryId' => 'QRP_QRY_ID',
        'QueryParametersTableMap::COL_QRP_QRY_ID' => 'QRP_QRY_ID',
        'COL_QRP_QRY_ID' => 'QRP_QRY_ID',
        'qrp_qry_ID' => 'QRP_QRY_ID',
        'queryparameters_qrp.qrp_qry_ID' => 'QRP_QRY_ID',
        'Type' => 'QRP_TYPE',
        'QueryParameters.Type' => 'QRP_TYPE',
        'type' => 'QRP_TYPE',
        'queryParameters.type' => 'QRP_TYPE',
        'QueryParametersTableMap::COL_QRP_TYPE' => 'QRP_TYPE',
        'COL_QRP_TYPE' => 'QRP_TYPE',
        'qrp_Type' => 'QRP_TYPE',
        'queryparameters_qrp.qrp_Type' => 'QRP_TYPE',
        'OptionSQL' => 'QRP_OPTIONSQL',
        'QueryParameters.OptionSQL' => 'QRP_OPTIONSQL',
        'optionSQL' => 'QRP_OPTIONSQL',
        'queryParameters.optionSQL' => 'QRP_OPTIONSQL',
        'QueryParametersTableMap::COL_QRP_OPTIONSQL' => 'QRP_OPTIONSQL',
        'COL_QRP_OPTIONSQL' => 'QRP_OPTIONSQL',
        'qrp_OptionSQL' => 'QRP_OPTIONSQL',
        'queryparameters_qrp.qrp_OptionSQL' => 'QRP_OPTIONSQL',
        'Name' => 'QRP_NAME',
        'QueryParameters.Name' => 'QRP_NAME',
        'name' => 'QRP_NAME',
        'queryParameters.name' => 'QRP_NAME',
        'QueryParametersTableMap::COL_QRP_NAME' => 'QRP_NAME',
        'COL_QRP_NAME' => 'QRP_NAME',
        'qrp_Name' => 'QRP_NAME',
        'queryparameters_qrp.qrp_Name' => 'QRP_NAME',
        'Description' => 'QRP_DESCRIPTION',
        'QueryParameters.Description' => 'QRP_DESCRIPTION',
        'description' => 'QRP_DESCRIPTION',
        'queryParameters.description' => 'QRP_DESCRIPTION',
        'QueryParametersTableMap::COL_QRP_DESCRIPTION' => 'QRP_DESCRIPTION',
        'COL_QRP_DESCRIPTION' => 'QRP_DESCRIPTION',
        'qrp_Description' => 'QRP_DESCRIPTION',
        'queryparameters_qrp.qrp_Description' => 'QRP_DESCRIPTION',
        'Alias' => 'QRP_ALIAS',
        'QueryParameters.Alias' => 'QRP_ALIAS',
        'alias' => 'QRP_ALIAS',
        'queryParameters.alias' => 'QRP_ALIAS',
        'QueryParametersTableMap::COL_QRP_ALIAS' => 'QRP_ALIAS',
        'COL_QRP_ALIAS' => 'QRP_ALIAS',
        'qrp_Alias' => 'QRP_ALIAS',
        'queryparameters_qrp.qrp_Alias' => 'QRP_ALIAS',
        'Default' => 'QRP_DEFAULT',
        'QueryParameters.Default' => 'QRP_DEFAULT',
        'default' => 'QRP_DEFAULT',
        'queryParameters.default' => 'QRP_DEFAULT',
        'QueryParametersTableMap::COL_QRP_DEFAULT' => 'QRP_DEFAULT',
        'COL_QRP_DEFAULT' => 'QRP_DEFAULT',
        'qrp_Default' => 'QRP_DEFAULT',
        'queryparameters_qrp.qrp_Default' => 'QRP_DEFAULT',
        'Required' => 'QRP_REQUIRED',
        'QueryParameters.Required' => 'QRP_REQUIRED',
        'required' => 'QRP_REQUIRED',
        'queryParameters.required' => 'QRP_REQUIRED',
        'QueryParametersTableMap::COL_QRP_REQUIRED' => 'QRP_REQUIRED',
        'COL_QRP_REQUIRED' => 'QRP_REQUIRED',
        'qrp_Required' => 'QRP_REQUIRED',
        'queryparameters_qrp.qrp_Required' => 'QRP_REQUIRED',
        'InputBoxSize' => 'QRP_INPUTBOXSIZE',
        'QueryParameters.InputBoxSize' => 'QRP_INPUTBOXSIZE',
        'inputBoxSize' => 'QRP_INPUTBOXSIZE',
        'queryParameters.inputBoxSize' => 'QRP_INPUTBOXSIZE',
        'QueryParametersTableMap::COL_QRP_INPUTBOXSIZE' => 'QRP_INPUTBOXSIZE',
        'COL_QRP_INPUTBOXSIZE' => 'QRP_INPUTBOXSIZE',
        'qrp_InputBoxSize' => 'QRP_INPUTBOXSIZE',
        'queryparameters_qrp.qrp_InputBoxSize' => 'QRP_INPUTBOXSIZE',
        'Validation' => 'QRP_VALIDATION',
        'QueryParameters.Validation' => 'QRP_VALIDATION',
        'validation' => 'QRP_VALIDATION',
        'queryParameters.validation' => 'QRP_VALIDATION',
        'QueryParametersTableMap::COL_QRP_VALIDATION' => 'QRP_VALIDATION',
        'COL_QRP_VALIDATION' => 'QRP_VALIDATION',
        'qrp_Validation' => 'QRP_VALIDATION',
        'queryparameters_qrp.qrp_Validation' => 'QRP_VALIDATION',
        'NumericMax' => 'QRP_NUMERICMAX',
        'QueryParameters.NumericMax' => 'QRP_NUMERICMAX',
        'numericMax' => 'QRP_NUMERICMAX',
        'queryParameters.numericMax' => 'QRP_NUMERICMAX',
        'QueryParametersTableMap::COL_QRP_NUMERICMAX' => 'QRP_NUMERICMAX',
        'COL_QRP_NUMERICMAX' => 'QRP_NUMERICMAX',
        'qrp_NumericMax' => 'QRP_NUMERICMAX',
        'queryparameters_qrp.qrp_NumericMax' => 'QRP_NUMERICMAX',
        'NumericMin' => 'QRP_NUMERICMIN',
        'QueryParameters.NumericMin' => 'QRP_NUMERICMIN',
        'numericMin' => 'QRP_NUMERICMIN',
        'queryParameters.numericMin' => 'QRP_NUMERICMIN',
        'QueryParametersTableMap::COL_QRP_NUMERICMIN' => 'QRP_NUMERICMIN',
        'COL_QRP_NUMERICMIN' => 'QRP_NUMERICMIN',
        'qrp_NumericMin' => 'QRP_NUMERICMIN',
        'queryparameters_qrp.qrp_NumericMin' => 'QRP_NUMERICMIN',
        'AlphaMinLength' => 'QRP_ALPHAMINLENGTH',
        'QueryParameters.AlphaMinLength' => 'QRP_ALPHAMINLENGTH',
        'alphaMinLength' => 'QRP_ALPHAMINLENGTH',
        'queryParameters.alphaMinLength' => 'QRP_ALPHAMINLENGTH',
        'QueryParametersTableMap::COL_QRP_ALPHAMINLENGTH' => 'QRP_ALPHAMINLENGTH',
        'COL_QRP_ALPHAMINLENGTH' => 'QRP_ALPHAMINLENGTH',
        'qrp_AlphaMinLength' => 'QRP_ALPHAMINLENGTH',
        'queryparameters_qrp.qrp_AlphaMinLength' => 'QRP_ALPHAMINLENGTH',
        'AlphaMaxLength' => 'QRP_ALPHAMAXLENGTH',
        'QueryParameters.AlphaMaxLength' => 'QRP_ALPHAMAXLENGTH',
        'alphaMaxLength' => 'QRP_ALPHAMAXLENGTH',
        'queryParameters.alphaMaxLength' => 'QRP_ALPHAMAXLENGTH',
        'QueryParametersTableMap::COL_QRP_ALPHAMAXLENGTH' => 'QRP_ALPHAMAXLENGTH',
        'COL_QRP_ALPHAMAXLENGTH' => 'QRP_ALPHAMAXLENGTH',
        'qrp_AlphaMaxLength' => 'QRP_ALPHAMAXLENGTH',
        'queryparameters_qrp.qrp_AlphaMaxLength' => 'QRP_ALPHAMAXLENGTH',
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
        $this->setName('queryparameters_qrp');
        $this->setPhpName('QueryParameters');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ChurchCRM\\model\\ChurchCRM\\QueryParameters');
        $this->setPackage('ChurchCRM.model.ChurchCRM');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('qrp_ID', 'Id', 'SMALLINT', true, 8, null);
        $this->addColumn('qrp_qry_ID', 'QryId', 'SMALLINT', true, 8, 0);
        $this->addColumn('qrp_Type', 'Type', 'TINYINT', true, 3, 0);
        $this->addColumn('qrp_OptionSQL', 'OptionSQL', 'LONGVARCHAR', false, null, null);
        $this->addColumn('qrp_Name', 'Name', 'VARCHAR', false, 25, null);
        $this->addColumn('qrp_Description', 'Description', 'LONGVARCHAR', false, null, null);
        $this->addColumn('qrp_Alias', 'Alias', 'VARCHAR', false, 25, null);
        $this->addColumn('qrp_Default', 'Default', 'VARCHAR', false, 25, null);
        $this->addColumn('qrp_Required', 'Required', 'TINYINT', true, 3, 0);
        $this->addColumn('qrp_InputBoxSize', 'InputBoxSize', 'TINYINT', true, 3, 0);
        $this->addColumn('qrp_Validation', 'Validation', 'VARCHAR', true, 5, '');
        $this->addColumn('qrp_NumericMax', 'NumericMax', 'INTEGER', false, null, null);
        $this->addColumn('qrp_NumericMin', 'NumericMin', 'INTEGER', false, null, null);
        $this->addColumn('qrp_AlphaMinLength', 'AlphaMinLength', 'INTEGER', false, null, null);
        $this->addColumn('qrp_AlphaMaxLength', 'AlphaMaxLength', 'INTEGER', false, null, null);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
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
        return $withPrefix ? QueryParametersTableMap::CLASS_DEFAULT : QueryParametersTableMap::OM_CLASS;
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
     * @return array (QueryParameters object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = QueryParametersTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (($obj = QueryParametersTableMap::getInstanceFromPool($key)) !== null) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + QueryParametersTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = QueryParametersTableMap::OM_CLASS;
            /** @var QueryParameters $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            QueryParametersTableMap::addInstanceToPool($obj, $key);
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
            $key = QueryParametersTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (($obj = QueryParametersTableMap::getInstanceFromPool($key)) !== null) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new QueryParameters();
                $obj->hydrate($row);
                $results[] = $obj;
                QueryParametersTableMap::addInstanceToPool($obj, $key);
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
        $tableAlias = $alias ?: 'queryparameters_qrp';
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['QRP_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['QRP_QRY_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['QRP_TYPE']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['QRP_OPTIONSQL']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['QRP_NAME']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['QRP_DESCRIPTION']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['QRP_ALIAS']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['QRP_DEFAULT']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['QRP_REQUIRED']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['QRP_INPUTBOXSIZE']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['QRP_VALIDATION']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['QRP_NUMERICMAX']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['QRP_NUMERICMIN']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['QRP_ALPHAMINLENGTH']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['QRP_ALPHAMAXLENGTH']));
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
            $criteria->removeSelectColumn(QueryParametersTableMap::COL_QRP_ID);
            $criteria->removeSelectColumn(QueryParametersTableMap::COL_QRP_QRY_ID);
            $criteria->removeSelectColumn(QueryParametersTableMap::COL_QRP_TYPE);
            $criteria->removeSelectColumn(QueryParametersTableMap::COL_QRP_OPTIONSQL);
            $criteria->removeSelectColumn(QueryParametersTableMap::COL_QRP_NAME);
            $criteria->removeSelectColumn(QueryParametersTableMap::COL_QRP_DESCRIPTION);
            $criteria->removeSelectColumn(QueryParametersTableMap::COL_QRP_ALIAS);
            $criteria->removeSelectColumn(QueryParametersTableMap::COL_QRP_DEFAULT);
            $criteria->removeSelectColumn(QueryParametersTableMap::COL_QRP_REQUIRED);
            $criteria->removeSelectColumn(QueryParametersTableMap::COL_QRP_INPUTBOXSIZE);
            $criteria->removeSelectColumn(QueryParametersTableMap::COL_QRP_VALIDATION);
            $criteria->removeSelectColumn(QueryParametersTableMap::COL_QRP_NUMERICMAX);
            $criteria->removeSelectColumn(QueryParametersTableMap::COL_QRP_NUMERICMIN);
            $criteria->removeSelectColumn(QueryParametersTableMap::COL_QRP_ALPHAMINLENGTH);
            $criteria->removeSelectColumn(QueryParametersTableMap::COL_QRP_ALPHAMAXLENGTH);
        } else {
            $criteria->removeSelectColumn($alias . '.qrp_ID');
            $criteria->removeSelectColumn($alias . '.qrp_qry_ID');
            $criteria->removeSelectColumn($alias . '.qrp_Type');
            $criteria->removeSelectColumn($alias . '.qrp_OptionSQL');
            $criteria->removeSelectColumn($alias . '.qrp_Name');
            $criteria->removeSelectColumn($alias . '.qrp_Description');
            $criteria->removeSelectColumn($alias . '.qrp_Alias');
            $criteria->removeSelectColumn($alias . '.qrp_Default');
            $criteria->removeSelectColumn($alias . '.qrp_Required');
            $criteria->removeSelectColumn($alias . '.qrp_InputBoxSize');
            $criteria->removeSelectColumn($alias . '.qrp_Validation');
            $criteria->removeSelectColumn($alias . '.qrp_NumericMax');
            $criteria->removeSelectColumn($alias . '.qrp_NumericMin');
            $criteria->removeSelectColumn($alias . '.qrp_AlphaMinLength');
            $criteria->removeSelectColumn($alias . '.qrp_AlphaMaxLength');
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
        return Propel::getServiceContainer()->getDatabaseMap(QueryParametersTableMap::DATABASE_NAME)->getTable(QueryParametersTableMap::TABLE_NAME);
    }

    /**
     * @deprecated Delete via model or QueryParametersQuery.
     *
     * Performs a DELETE on the database, given a QueryParameters or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or QueryParameters object or primary key or array of primary keys
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
        trigger_deprecation('Propel', '2.0', 'TableMap::doDelete() should not be used anymore, delete via model or QueryParametersQuery');

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(QueryParametersTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            $criteria = $values;
        } elseif ($values instanceof QueryParameters) { // it's a model object
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(QueryParametersTableMap::DATABASE_NAME);
            $criteria->addAnd(QueryParametersTableMap::COL_QRP_ID, (array)$values, Criteria::IN);
        }

        $query = QueryParametersQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            QueryParametersTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array)$values as $singleval) {
                QueryParametersTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the queryparameters_qrp table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return QueryParametersQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a QueryParameters or Criteria object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|\ChurchCRM\model\ChurchCRM\QueryParameters $criteria
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
            $con = Propel::getServiceContainer()->getWriteConnection(QueryParametersTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria;
            $criteria->turnFiltersToUpdateValues();
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from QueryParameters object
        }

        if ($criteria->hasUpdateValue(QueryParametersTableMap::COL_QRP_ID)) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (QueryParametersTableMap::COL_QRP_ID)');
        }

        // Set the correct dbName
        $query = QueryParametersQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }
}
