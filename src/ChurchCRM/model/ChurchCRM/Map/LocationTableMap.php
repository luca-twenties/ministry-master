<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Map;

use ChurchCRM\model\ChurchCRM\Location;
use ChurchCRM\model\ChurchCRM\LocationQuery;
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
 * This class defines the structure of the 'locations' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class LocationTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'ChurchCRM.model.ChurchCRM.Map.LocationTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'locations';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'Location';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\ChurchCRM\\model\\ChurchCRM\\Location';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'ChurchCRM.model.ChurchCRM.Location';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 11;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 11;

    /**
     * the column name for the location_id field
     */
    public const COL_LOCATION_ID = 'locations.location_id';

    /**
     * the column name for the location_typeID field
     */
    public const COL_LOCATION_TYPEID = 'locations.location_typeID';

    /**
     * the column name for the location_name field
     */
    public const COL_LOCATION_NAME = 'locations.location_name';

    /**
     * the column name for the location_address field
     */
    public const COL_LOCATION_ADDRESS = 'locations.location_address';

    /**
     * the column name for the location_city field
     */
    public const COL_LOCATION_CITY = 'locations.location_city';

    /**
     * the column name for the location_state field
     */
    public const COL_LOCATION_STATE = 'locations.location_state';

    /**
     * the column name for the location_zip field
     */
    public const COL_LOCATION_ZIP = 'locations.location_zip';

    /**
     * the column name for the location_country field
     */
    public const COL_LOCATION_COUNTRY = 'locations.location_country';

    /**
     * the column name for the location_phone field
     */
    public const COL_LOCATION_PHONE = 'locations.location_phone';

    /**
     * the column name for the location_email field
     */
    public const COL_LOCATION_EMAIL = 'locations.location_email';

    /**
     * the column name for the location_timzezone field
     */
    public const COL_LOCATION_TIMZEZONE = 'locations.location_timzezone';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * @var class-string<\ChurchCRM\model\ChurchCRM\Base\Collection\LocationCollection>
     */
    public const DEFAULT_OBJECT_COLLECTION = '\ChurchCRM\model\ChurchCRM\Base\Collection\LocationCollection';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['LocationId', 'LocationType', 'LocationName', 'LocationAddress', 'LocationCity', 'LocationState', 'LocationZip', 'LocationCountry', 'LocationPhone', 'LocationEmail', 'LocationTimzezone', ],
        self::TYPE_CAMELNAME     => ['locationId', 'locationType', 'locationName', 'locationAddress', 'locationCity', 'locationState', 'locationZip', 'locationCountry', 'locationPhone', 'locationEmail', 'locationTimzezone', ],
        self::TYPE_COLNAME       => [LocationTableMap::COL_LOCATION_ID, LocationTableMap::COL_LOCATION_TYPEID, LocationTableMap::COL_LOCATION_NAME, LocationTableMap::COL_LOCATION_ADDRESS, LocationTableMap::COL_LOCATION_CITY, LocationTableMap::COL_LOCATION_STATE, LocationTableMap::COL_LOCATION_ZIP, LocationTableMap::COL_LOCATION_COUNTRY, LocationTableMap::COL_LOCATION_PHONE, LocationTableMap::COL_LOCATION_EMAIL, LocationTableMap::COL_LOCATION_TIMZEZONE, ],
        self::TYPE_FIELDNAME     => ['location_id', 'location_typeID', 'location_name', 'location_address', 'location_city', 'location_state', 'location_zip', 'location_country', 'location_phone', 'location_email', 'location_timzezone', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, ]
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
        self::TYPE_PHPNAME       => ['LocationId' => 0, 'LocationType' => 1, 'LocationName' => 2, 'LocationAddress' => 3, 'LocationCity' => 4, 'LocationState' => 5, 'LocationZip' => 6, 'LocationCountry' => 7, 'LocationPhone' => 8, 'LocationEmail' => 9, 'LocationTimzezone' => 10, ],
        self::TYPE_CAMELNAME     => ['locationId' => 0, 'locationType' => 1, 'locationName' => 2, 'locationAddress' => 3, 'locationCity' => 4, 'locationState' => 5, 'locationZip' => 6, 'locationCountry' => 7, 'locationPhone' => 8, 'locationEmail' => 9, 'locationTimzezone' => 10, ],
        self::TYPE_COLNAME       => [LocationTableMap::COL_LOCATION_ID => 0, LocationTableMap::COL_LOCATION_TYPEID => 1, LocationTableMap::COL_LOCATION_NAME => 2, LocationTableMap::COL_LOCATION_ADDRESS => 3, LocationTableMap::COL_LOCATION_CITY => 4, LocationTableMap::COL_LOCATION_STATE => 5, LocationTableMap::COL_LOCATION_ZIP => 6, LocationTableMap::COL_LOCATION_COUNTRY => 7, LocationTableMap::COL_LOCATION_PHONE => 8, LocationTableMap::COL_LOCATION_EMAIL => 9, LocationTableMap::COL_LOCATION_TIMZEZONE => 10, ],
        self::TYPE_FIELDNAME     => ['location_id' => 0, 'location_typeID' => 1, 'location_name' => 2, 'location_address' => 3, 'location_city' => 4, 'location_state' => 5, 'location_zip' => 6, 'location_country' => 7, 'location_phone' => 8, 'location_email' => 9, 'location_timzezone' => 10, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string, string>
     */
    protected $normalizedColumnNameMap = [
        'LocationId' => 'LOCATION_ID',
        'Location.LocationId' => 'LOCATION_ID',
        'locationId' => 'LOCATION_ID',
        'location.locationId' => 'LOCATION_ID',
        'LocationTableMap::COL_LOCATION_ID' => 'LOCATION_ID',
        'COL_LOCATION_ID' => 'LOCATION_ID',
        'location_id' => 'LOCATION_ID',
        'locations.location_id' => 'LOCATION_ID',
        'LocationType' => 'LOCATION_TYPEID',
        'Location.LocationType' => 'LOCATION_TYPEID',
        'locationType' => 'LOCATION_TYPEID',
        'location.locationType' => 'LOCATION_TYPEID',
        'LocationTableMap::COL_LOCATION_TYPEID' => 'LOCATION_TYPEID',
        'COL_LOCATION_TYPEID' => 'LOCATION_TYPEID',
        'location_typeID' => 'LOCATION_TYPEID',
        'locations.location_typeID' => 'LOCATION_TYPEID',
        'LocationName' => 'LOCATION_NAME',
        'Location.LocationName' => 'LOCATION_NAME',
        'locationName' => 'LOCATION_NAME',
        'location.locationName' => 'LOCATION_NAME',
        'LocationTableMap::COL_LOCATION_NAME' => 'LOCATION_NAME',
        'COL_LOCATION_NAME' => 'LOCATION_NAME',
        'location_name' => 'LOCATION_NAME',
        'locations.location_name' => 'LOCATION_NAME',
        'LocationAddress' => 'LOCATION_ADDRESS',
        'Location.LocationAddress' => 'LOCATION_ADDRESS',
        'locationAddress' => 'LOCATION_ADDRESS',
        'location.locationAddress' => 'LOCATION_ADDRESS',
        'LocationTableMap::COL_LOCATION_ADDRESS' => 'LOCATION_ADDRESS',
        'COL_LOCATION_ADDRESS' => 'LOCATION_ADDRESS',
        'location_address' => 'LOCATION_ADDRESS',
        'locations.location_address' => 'LOCATION_ADDRESS',
        'LocationCity' => 'LOCATION_CITY',
        'Location.LocationCity' => 'LOCATION_CITY',
        'locationCity' => 'LOCATION_CITY',
        'location.locationCity' => 'LOCATION_CITY',
        'LocationTableMap::COL_LOCATION_CITY' => 'LOCATION_CITY',
        'COL_LOCATION_CITY' => 'LOCATION_CITY',
        'location_city' => 'LOCATION_CITY',
        'locations.location_city' => 'LOCATION_CITY',
        'LocationState' => 'LOCATION_STATE',
        'Location.LocationState' => 'LOCATION_STATE',
        'locationState' => 'LOCATION_STATE',
        'location.locationState' => 'LOCATION_STATE',
        'LocationTableMap::COL_LOCATION_STATE' => 'LOCATION_STATE',
        'COL_LOCATION_STATE' => 'LOCATION_STATE',
        'location_state' => 'LOCATION_STATE',
        'locations.location_state' => 'LOCATION_STATE',
        'LocationZip' => 'LOCATION_ZIP',
        'Location.LocationZip' => 'LOCATION_ZIP',
        'locationZip' => 'LOCATION_ZIP',
        'location.locationZip' => 'LOCATION_ZIP',
        'LocationTableMap::COL_LOCATION_ZIP' => 'LOCATION_ZIP',
        'COL_LOCATION_ZIP' => 'LOCATION_ZIP',
        'location_zip' => 'LOCATION_ZIP',
        'locations.location_zip' => 'LOCATION_ZIP',
        'LocationCountry' => 'LOCATION_COUNTRY',
        'Location.LocationCountry' => 'LOCATION_COUNTRY',
        'locationCountry' => 'LOCATION_COUNTRY',
        'location.locationCountry' => 'LOCATION_COUNTRY',
        'LocationTableMap::COL_LOCATION_COUNTRY' => 'LOCATION_COUNTRY',
        'COL_LOCATION_COUNTRY' => 'LOCATION_COUNTRY',
        'location_country' => 'LOCATION_COUNTRY',
        'locations.location_country' => 'LOCATION_COUNTRY',
        'LocationPhone' => 'LOCATION_PHONE',
        'Location.LocationPhone' => 'LOCATION_PHONE',
        'locationPhone' => 'LOCATION_PHONE',
        'location.locationPhone' => 'LOCATION_PHONE',
        'LocationTableMap::COL_LOCATION_PHONE' => 'LOCATION_PHONE',
        'COL_LOCATION_PHONE' => 'LOCATION_PHONE',
        'location_phone' => 'LOCATION_PHONE',
        'locations.location_phone' => 'LOCATION_PHONE',
        'LocationEmail' => 'LOCATION_EMAIL',
        'Location.LocationEmail' => 'LOCATION_EMAIL',
        'locationEmail' => 'LOCATION_EMAIL',
        'location.locationEmail' => 'LOCATION_EMAIL',
        'LocationTableMap::COL_LOCATION_EMAIL' => 'LOCATION_EMAIL',
        'COL_LOCATION_EMAIL' => 'LOCATION_EMAIL',
        'location_email' => 'LOCATION_EMAIL',
        'locations.location_email' => 'LOCATION_EMAIL',
        'LocationTimzezone' => 'LOCATION_TIMZEZONE',
        'Location.LocationTimzezone' => 'LOCATION_TIMZEZONE',
        'locationTimzezone' => 'LOCATION_TIMZEZONE',
        'location.locationTimzezone' => 'LOCATION_TIMZEZONE',
        'LocationTableMap::COL_LOCATION_TIMZEZONE' => 'LOCATION_TIMZEZONE',
        'COL_LOCATION_TIMZEZONE' => 'LOCATION_TIMZEZONE',
        'location_timzezone' => 'LOCATION_TIMZEZONE',
        'locations.location_timzezone' => 'LOCATION_TIMZEZONE',
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
        $this->setName('locations');
        $this->setPhpName('Location');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ChurchCRM\\model\\ChurchCRM\\Location');
        $this->setPackage('ChurchCRM.model.ChurchCRM');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('location_id', 'LocationId', 'SMALLINT', true, 8, null);
        $this->addColumn('location_typeID', 'LocationType', 'SMALLINT', true, 8, null);
        $this->addColumn('location_name', 'LocationName', 'VARCHAR', true, 256, '');
        $this->addColumn('location_address', 'LocationAddress', 'VARCHAR', true, 45, '');
        $this->addColumn('location_city', 'LocationCity', 'VARCHAR', true, 45, '');
        $this->addColumn('location_state', 'LocationState', 'VARCHAR', true, 45, '');
        $this->addColumn('location_zip', 'LocationZip', 'VARCHAR', true, 45, '');
        $this->addColumn('location_country', 'LocationCountry', 'VARCHAR', true, 45, '');
        $this->addColumn('location_phone', 'LocationPhone', 'VARCHAR', true, 45, '');
        $this->addColumn('location_email', 'LocationEmail', 'VARCHAR', true, 45, '');
        $this->addColumn('location_timzezone', 'LocationTimzezone', 'VARCHAR', true, 45, '');
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation(
            'Event',
            '\\ChurchCRM\\model\\ChurchCRM\\Event',
            RelationMap::ONE_TO_MANY,
            [[':location_id', ':location_id']],
            null,
            null,
            'Events',
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('LocationId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('LocationId', TableMap::TYPE_PHPNAME, $indexType)] === null || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('LocationId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('LocationId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string)$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('LocationId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('LocationId', TableMap::TYPE_PHPNAME, $indexType)];
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
        $locationIdIx = $indexType === TableMap::TYPE_NUM
            ? 0 + $offset
            : self::translateFieldName('LocationId', TableMap::TYPE_PHPNAME, $indexType);

        return (int)$row[$locationIdIx];
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
        return $withPrefix ? LocationTableMap::CLASS_DEFAULT : LocationTableMap::OM_CLASS;
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
     * @return array (Location object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = LocationTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (($obj = LocationTableMap::getInstanceFromPool($key)) !== null) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + LocationTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = LocationTableMap::OM_CLASS;
            /** @var Location $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            LocationTableMap::addInstanceToPool($obj, $key);
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
            $key = LocationTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (($obj = LocationTableMap::getInstanceFromPool($key)) !== null) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new Location();
                $obj->hydrate($row);
                $results[] = $obj;
                LocationTableMap::addInstanceToPool($obj, $key);
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
        $tableAlias = $alias ?: 'locations';
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['LOCATION_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['LOCATION_TYPEID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['LOCATION_NAME']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['LOCATION_ADDRESS']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['LOCATION_CITY']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['LOCATION_STATE']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['LOCATION_ZIP']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['LOCATION_COUNTRY']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['LOCATION_PHONE']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['LOCATION_EMAIL']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['LOCATION_TIMZEZONE']));
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
            $criteria->removeSelectColumn(LocationTableMap::COL_LOCATION_ID);
            $criteria->removeSelectColumn(LocationTableMap::COL_LOCATION_TYPEID);
            $criteria->removeSelectColumn(LocationTableMap::COL_LOCATION_NAME);
            $criteria->removeSelectColumn(LocationTableMap::COL_LOCATION_ADDRESS);
            $criteria->removeSelectColumn(LocationTableMap::COL_LOCATION_CITY);
            $criteria->removeSelectColumn(LocationTableMap::COL_LOCATION_STATE);
            $criteria->removeSelectColumn(LocationTableMap::COL_LOCATION_ZIP);
            $criteria->removeSelectColumn(LocationTableMap::COL_LOCATION_COUNTRY);
            $criteria->removeSelectColumn(LocationTableMap::COL_LOCATION_PHONE);
            $criteria->removeSelectColumn(LocationTableMap::COL_LOCATION_EMAIL);
            $criteria->removeSelectColumn(LocationTableMap::COL_LOCATION_TIMZEZONE);
        } else {
            $criteria->removeSelectColumn($alias . '.location_id');
            $criteria->removeSelectColumn($alias . '.location_typeID');
            $criteria->removeSelectColumn($alias . '.location_name');
            $criteria->removeSelectColumn($alias . '.location_address');
            $criteria->removeSelectColumn($alias . '.location_city');
            $criteria->removeSelectColumn($alias . '.location_state');
            $criteria->removeSelectColumn($alias . '.location_zip');
            $criteria->removeSelectColumn($alias . '.location_country');
            $criteria->removeSelectColumn($alias . '.location_phone');
            $criteria->removeSelectColumn($alias . '.location_email');
            $criteria->removeSelectColumn($alias . '.location_timzezone');
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
        return Propel::getServiceContainer()->getDatabaseMap(LocationTableMap::DATABASE_NAME)->getTable(LocationTableMap::TABLE_NAME);
    }

    /**
     * @deprecated Delete via model or LocationQuery.
     *
     * Performs a DELETE on the database, given a Location or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or Location object or primary key or array of primary keys
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
        trigger_deprecation('Propel', '2.0', 'TableMap::doDelete() should not be used anymore, delete via model or LocationQuery');

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(LocationTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            $criteria = $values;
        } elseif ($values instanceof Location) { // it's a model object
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(LocationTableMap::DATABASE_NAME);
            $criteria->addAnd(LocationTableMap::COL_LOCATION_ID, (array)$values, Criteria::IN);
        }

        $query = LocationQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            LocationTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array)$values as $singleval) {
                LocationTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the locations table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return LocationQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Location or Criteria object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|\ChurchCRM\model\ChurchCRM\Location $criteria
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
            $con = Propel::getServiceContainer()->getWriteConnection(LocationTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria;
            $criteria->turnFiltersToUpdateValues();
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Location object
        }

        // Set the correct dbName
        $query = LocationQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }
}
