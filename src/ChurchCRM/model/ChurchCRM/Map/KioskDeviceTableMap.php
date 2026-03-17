<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Map;

use ChurchCRM\model\ChurchCRM\KioskDevice;
use ChurchCRM\model\ChurchCRM\KioskDeviceQuery;
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
 * This class defines the structure of the 'kioskdevice_kdev' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class KioskDeviceTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'ChurchCRM.model.ChurchCRM.Map.KioskDeviceTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'kioskdevice_kdev';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'KioskDevice';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\ChurchCRM\\model\\ChurchCRM\\KioskDevice';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'ChurchCRM.model.ChurchCRM.KioskDevice';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the kdev_ID field
     */
    public const COL_KDEV_ID = 'kioskdevice_kdev.kdev_ID';

    /**
     * the column name for the kdev_GUIDHash field
     */
    public const COL_KDEV_GUIDHASH = 'kioskdevice_kdev.kdev_GUIDHash';

    /**
     * the column name for the kdev_Name field
     */
    public const COL_KDEV_NAME = 'kioskdevice_kdev.kdev_Name';

    /**
     * the column name for the kdev_deviceType field
     */
    public const COL_KDEV_DEVICETYPE = 'kioskdevice_kdev.kdev_deviceType';

    /**
     * the column name for the kdev_lastHeartbeat field
     */
    public const COL_KDEV_LASTHEARTBEAT = 'kioskdevice_kdev.kdev_lastHeartbeat';

    /**
     * the column name for the kdev_Accepted field
     */
    public const COL_KDEV_ACCEPTED = 'kioskdevice_kdev.kdev_Accepted';

    /**
     * the column name for the kdev_PendingCommands field
     */
    public const COL_KDEV_PENDINGCOMMANDS = 'kioskdevice_kdev.kdev_PendingCommands';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * @var class-string<\ChurchCRM\model\ChurchCRM\Base\Collection\KioskDeviceCollection>
     */
    public const DEFAULT_OBJECT_COLLECTION = '\ChurchCRM\model\ChurchCRM\Base\Collection\KioskDeviceCollection';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['Id', 'GUIDHash', 'Name', 'DeviceType', 'LastHeartbeat', 'Accepted', 'PendingCommands', ],
        self::TYPE_CAMELNAME     => ['id', 'gUIDHash', 'name', 'deviceType', 'lastHeartbeat', 'accepted', 'pendingCommands', ],
        self::TYPE_COLNAME       => [KioskDeviceTableMap::COL_KDEV_ID, KioskDeviceTableMap::COL_KDEV_GUIDHASH, KioskDeviceTableMap::COL_KDEV_NAME, KioskDeviceTableMap::COL_KDEV_DEVICETYPE, KioskDeviceTableMap::COL_KDEV_LASTHEARTBEAT, KioskDeviceTableMap::COL_KDEV_ACCEPTED, KioskDeviceTableMap::COL_KDEV_PENDINGCOMMANDS, ],
        self::TYPE_FIELDNAME     => ['kdev_ID', 'kdev_GUIDHash', 'kdev_Name', 'kdev_deviceType', 'kdev_lastHeartbeat', 'kdev_Accepted', 'kdev_PendingCommands', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, ]
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
        self::TYPE_PHPNAME       => ['Id' => 0, 'GUIDHash' => 1, 'Name' => 2, 'DeviceType' => 3, 'LastHeartbeat' => 4, 'Accepted' => 5, 'PendingCommands' => 6, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'gUIDHash' => 1, 'name' => 2, 'deviceType' => 3, 'lastHeartbeat' => 4, 'accepted' => 5, 'pendingCommands' => 6, ],
        self::TYPE_COLNAME       => [KioskDeviceTableMap::COL_KDEV_ID => 0, KioskDeviceTableMap::COL_KDEV_GUIDHASH => 1, KioskDeviceTableMap::COL_KDEV_NAME => 2, KioskDeviceTableMap::COL_KDEV_DEVICETYPE => 3, KioskDeviceTableMap::COL_KDEV_LASTHEARTBEAT => 4, KioskDeviceTableMap::COL_KDEV_ACCEPTED => 5, KioskDeviceTableMap::COL_KDEV_PENDINGCOMMANDS => 6, ],
        self::TYPE_FIELDNAME     => ['kdev_ID' => 0, 'kdev_GUIDHash' => 1, 'kdev_Name' => 2, 'kdev_deviceType' => 3, 'kdev_lastHeartbeat' => 4, 'kdev_Accepted' => 5, 'kdev_PendingCommands' => 6, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string, string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'KDEV_ID',
        'KioskDevice.Id' => 'KDEV_ID',
        'id' => 'KDEV_ID',
        'kioskDevice.id' => 'KDEV_ID',
        'KioskDeviceTableMap::COL_KDEV_ID' => 'KDEV_ID',
        'COL_KDEV_ID' => 'KDEV_ID',
        'kdev_ID' => 'KDEV_ID',
        'kioskdevice_kdev.kdev_ID' => 'KDEV_ID',
        'GUIDHash' => 'KDEV_GUIDHASH',
        'KioskDevice.GUIDHash' => 'KDEV_GUIDHASH',
        'gUIDHash' => 'KDEV_GUIDHASH',
        'kioskDevice.gUIDHash' => 'KDEV_GUIDHASH',
        'KioskDeviceTableMap::COL_KDEV_GUIDHASH' => 'KDEV_GUIDHASH',
        'COL_KDEV_GUIDHASH' => 'KDEV_GUIDHASH',
        'kdev_GUIDHash' => 'KDEV_GUIDHASH',
        'kioskdevice_kdev.kdev_GUIDHash' => 'KDEV_GUIDHASH',
        'Name' => 'KDEV_NAME',
        'KioskDevice.Name' => 'KDEV_NAME',
        'name' => 'KDEV_NAME',
        'kioskDevice.name' => 'KDEV_NAME',
        'KioskDeviceTableMap::COL_KDEV_NAME' => 'KDEV_NAME',
        'COL_KDEV_NAME' => 'KDEV_NAME',
        'kdev_Name' => 'KDEV_NAME',
        'kioskdevice_kdev.kdev_Name' => 'KDEV_NAME',
        'DeviceType' => 'KDEV_DEVICETYPE',
        'KioskDevice.DeviceType' => 'KDEV_DEVICETYPE',
        'deviceType' => 'KDEV_DEVICETYPE',
        'kioskDevice.deviceType' => 'KDEV_DEVICETYPE',
        'KioskDeviceTableMap::COL_KDEV_DEVICETYPE' => 'KDEV_DEVICETYPE',
        'COL_KDEV_DEVICETYPE' => 'KDEV_DEVICETYPE',
        'kdev_deviceType' => 'KDEV_DEVICETYPE',
        'kioskdevice_kdev.kdev_deviceType' => 'KDEV_DEVICETYPE',
        'LastHeartbeat' => 'KDEV_LASTHEARTBEAT',
        'KioskDevice.LastHeartbeat' => 'KDEV_LASTHEARTBEAT',
        'lastHeartbeat' => 'KDEV_LASTHEARTBEAT',
        'kioskDevice.lastHeartbeat' => 'KDEV_LASTHEARTBEAT',
        'KioskDeviceTableMap::COL_KDEV_LASTHEARTBEAT' => 'KDEV_LASTHEARTBEAT',
        'COL_KDEV_LASTHEARTBEAT' => 'KDEV_LASTHEARTBEAT',
        'kdev_lastHeartbeat' => 'KDEV_LASTHEARTBEAT',
        'kioskdevice_kdev.kdev_lastHeartbeat' => 'KDEV_LASTHEARTBEAT',
        'Accepted' => 'KDEV_ACCEPTED',
        'KioskDevice.Accepted' => 'KDEV_ACCEPTED',
        'accepted' => 'KDEV_ACCEPTED',
        'kioskDevice.accepted' => 'KDEV_ACCEPTED',
        'KioskDeviceTableMap::COL_KDEV_ACCEPTED' => 'KDEV_ACCEPTED',
        'COL_KDEV_ACCEPTED' => 'KDEV_ACCEPTED',
        'kdev_Accepted' => 'KDEV_ACCEPTED',
        'kioskdevice_kdev.kdev_Accepted' => 'KDEV_ACCEPTED',
        'PendingCommands' => 'KDEV_PENDINGCOMMANDS',
        'KioskDevice.PendingCommands' => 'KDEV_PENDINGCOMMANDS',
        'pendingCommands' => 'KDEV_PENDINGCOMMANDS',
        'kioskDevice.pendingCommands' => 'KDEV_PENDINGCOMMANDS',
        'KioskDeviceTableMap::COL_KDEV_PENDINGCOMMANDS' => 'KDEV_PENDINGCOMMANDS',
        'COL_KDEV_PENDINGCOMMANDS' => 'KDEV_PENDINGCOMMANDS',
        'kdev_PendingCommands' => 'KDEV_PENDINGCOMMANDS',
        'kioskdevice_kdev.kdev_PendingCommands' => 'KDEV_PENDINGCOMMANDS',
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
        $this->setName('kioskdevice_kdev');
        $this->setPhpName('KioskDevice');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ChurchCRM\\model\\ChurchCRM\\KioskDevice');
        $this->setPackage('ChurchCRM.model.ChurchCRM');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('kdev_ID', 'Id', 'INTEGER', true, 9, null);
        $this->addColumn('kdev_GUIDHash', 'GUIDHash', 'VARCHAR', false, 36, null);
        $this->addColumn('kdev_Name', 'Name', 'VARCHAR', false, 50, null);
        $this->addColumn('kdev_deviceType', 'DeviceType', 'LONGVARCHAR', false, null, null);
        $this->addColumn('kdev_lastHeartbeat', 'LastHeartbeat', 'LONGVARCHAR', false, null, null);
        $this->addColumn('kdev_Accepted', 'Accepted', 'BOOLEAN', false, 1, null);
        $this->addColumn('kdev_PendingCommands', 'PendingCommands', 'LONGVARCHAR', false, null, null);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation(
            'KioskAssignment',
            '\\ChurchCRM\\model\\ChurchCRM\\KioskAssignment',
            RelationMap::ONE_TO_MANY,
            [[':kasm_kdevId', ':kdev_ID']],
            null,
            null,
            'KioskAssignments',
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
        return $withPrefix ? KioskDeviceTableMap::CLASS_DEFAULT : KioskDeviceTableMap::OM_CLASS;
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
     * @return array (KioskDevice object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = KioskDeviceTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (($obj = KioskDeviceTableMap::getInstanceFromPool($key)) !== null) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + KioskDeviceTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = KioskDeviceTableMap::OM_CLASS;
            /** @var KioskDevice $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            KioskDeviceTableMap::addInstanceToPool($obj, $key);
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
            $key = KioskDeviceTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (($obj = KioskDeviceTableMap::getInstanceFromPool($key)) !== null) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new KioskDevice();
                $obj->hydrate($row);
                $results[] = $obj;
                KioskDeviceTableMap::addInstanceToPool($obj, $key);
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
        $tableAlias = $alias ?: 'kioskdevice_kdev';
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['KDEV_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['KDEV_GUIDHASH']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['KDEV_NAME']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['KDEV_DEVICETYPE']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['KDEV_LASTHEARTBEAT']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['KDEV_ACCEPTED']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['KDEV_PENDINGCOMMANDS']));
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
            $criteria->removeSelectColumn(KioskDeviceTableMap::COL_KDEV_ID);
            $criteria->removeSelectColumn(KioskDeviceTableMap::COL_KDEV_GUIDHASH);
            $criteria->removeSelectColumn(KioskDeviceTableMap::COL_KDEV_NAME);
            $criteria->removeSelectColumn(KioskDeviceTableMap::COL_KDEV_DEVICETYPE);
            $criteria->removeSelectColumn(KioskDeviceTableMap::COL_KDEV_LASTHEARTBEAT);
            $criteria->removeSelectColumn(KioskDeviceTableMap::COL_KDEV_ACCEPTED);
            $criteria->removeSelectColumn(KioskDeviceTableMap::COL_KDEV_PENDINGCOMMANDS);
        } else {
            $criteria->removeSelectColumn($alias . '.kdev_ID');
            $criteria->removeSelectColumn($alias . '.kdev_GUIDHash');
            $criteria->removeSelectColumn($alias . '.kdev_Name');
            $criteria->removeSelectColumn($alias . '.kdev_deviceType');
            $criteria->removeSelectColumn($alias . '.kdev_lastHeartbeat');
            $criteria->removeSelectColumn($alias . '.kdev_Accepted');
            $criteria->removeSelectColumn($alias . '.kdev_PendingCommands');
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
        return Propel::getServiceContainer()->getDatabaseMap(KioskDeviceTableMap::DATABASE_NAME)->getTable(KioskDeviceTableMap::TABLE_NAME);
    }

    /**
     * @deprecated Delete via model or KioskDeviceQuery.
     *
     * Performs a DELETE on the database, given a KioskDevice or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or KioskDevice object or primary key or array of primary keys
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
        trigger_deprecation('Propel', '2.0', 'TableMap::doDelete() should not be used anymore, delete via model or KioskDeviceQuery');

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(KioskDeviceTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            $criteria = $values;
        } elseif ($values instanceof KioskDevice) { // it's a model object
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(KioskDeviceTableMap::DATABASE_NAME);
            $criteria->addAnd(KioskDeviceTableMap::COL_KDEV_ID, (array)$values, Criteria::IN);
        }

        $query = KioskDeviceQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            KioskDeviceTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array)$values as $singleval) {
                KioskDeviceTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the kioskdevice_kdev table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return KioskDeviceQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a KioskDevice or Criteria object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|\ChurchCRM\model\ChurchCRM\KioskDevice $criteria
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
            $con = Propel::getServiceContainer()->getWriteConnection(KioskDeviceTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria;
            $criteria->turnFiltersToUpdateValues();
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from KioskDevice object
        }

        if ($criteria->hasUpdateValue(KioskDeviceTableMap::COL_KDEV_ID)) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (KioskDeviceTableMap::COL_KDEV_ID)');
        }

        // Set the correct dbName
        $query = KioskDeviceQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }
}
