<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Base\Collection\PropertyCollection;
use ChurchCRM\model\ChurchCRM\Map\PropertyTypeTableMap;
use ChurchCRM\model\ChurchCRM\PropertyQuery as ChildPropertyQuery;
use ChurchCRM\model\ChurchCRM\PropertyTypeQuery as ChildPropertyTypeQuery;
use Exception;
use PDO;
use Propel\Runtime\ActiveQuery\ColumnResolver\ColumnExpression\LocalColumnExpression;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Propel;
use ReflectionClass;
use ReflectionProperty;
use RuntimeException;

/**
 * Base class that represents a row from the 'propertytype_prt' table.
 *
 * This contains all the defined property types
 *
 * @package propel.generator.ChurchCRM.model.ChurchCRM.Base
 */
abstract class PropertyType implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\ChurchCRM\\model\\ChurchCRM\\Map\\PropertyTypeTableMap';

    /**
     * attribute to determine if this object has previously been saved.
     */
    protected bool $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     */
    protected bool $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     *
     * @var array<string, bool>
     */
    protected array $modifiedColumns = [];

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     *
     * @var array<string, mixed>
     */
    protected array $virtualColumns = [];

    /**
     * The value for the prt_id field.
     */
    protected int|null $prt_id = null;

    /**
     * The value for the prt_class field.
     *
     * Note: this column has a database default value of: ''
     */
    protected string|null $prt_class = null;

    /**
     * The value for the prt_name field.
     *
     * Note: this column has a database default value of: ''
     */
    protected string|null $prt_name = null;

    /**
     * The value for the prt_description field.
     */
    protected string|null $prt_description = null;

    /**
     * Objects associated via Property relation (1:n).
     */
    protected PropertyCollection|null $collProperties = null;

    /**
     * If $collProperties contains all objects in Property relation.
     */
    protected bool $collPropertiesPartial = false;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     */
    protected bool $alreadyInSave = false;

    /**
     * Items of Properties relation marked for deletion.
     *
     * @var \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Property>|null
     */
    protected ObjectCollection|null $propertiesScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     *
     * @see __construct()
     *
     * @return void
     */
    public function applyDefaultValues(): void
    {
        $this->prt_class = '';
        $this->prt_name = '';
    }

    /**
     * Initializes internal state of ChurchCRM\model\ChurchCRM\Base\PropertyType object.
     *
     * @see static::applyDefaultValues()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return bool True if the object has been modified.
     */
    public function isModified(): bool
    {
        return (bool)$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param string $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     *
     * @return bool True if $col has been modified.
     */
    public function isColumnModified(string $col): bool
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     *
     * @return array<string> A unique list of the modified column names for this object.
     */
    public function getModifiedColumns(): array
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved. This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return bool True, if the object has never been persisted.
     */
    public function isNew(): bool
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.
     *
     * Called by Propel-generated children and objects.
     *
     * @param bool $b the state of the object.
     *
     * @return void
     */
    public function setNew(bool $b): void
    {
        $this->new = $b;
    }

    /**
     * Whether this object has been deleted.
     *
     * @return bool The deleted state of this object.
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     *
     * @param bool $b The deleted state of this object.
     *
     * @return void
     */
    public function setDeleted(bool $b): void
    {
        $this->deleted = $b;
    }

    /**
     * Sets the modified state for the object to be false.
     *
     * @param string|null $col If supplied, only the specified column is reset.
     *
     * @return void
     */
    public function resetModified(?string $col = null): void
    {
        if ($col !== null) {
            unset($this->modifiedColumns[$col]);
        } else {
            $this->modifiedColumns = [];
        }
    }

    /**
     * Compares this with another <code>PropertyType</code> instance. If
     * <code>obj</code> is an instance of <code>PropertyType</code>, delegates to
     * <code>equals(PropertyType)</code>. Otherwise, returns <code>false</code>.
     *
     * @param mixed $obj The object to compare to.
     *
     * @return bool Whether equal to the object specified.
     */
    public function equals($obj): bool
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }
        if ($this->getPrimaryKey() === null || $obj->getPrimaryKey() === null) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array<mixed>
     */
    public function getVirtualColumns(): array
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param string $name The virtual column name
     *
     * @return bool
     */
    public function hasVirtualColumn(string $name): bool
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param string $name The virtual column name
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return mixed
     */
    public function getVirtualColumn(string $name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of nonexistent virtual column `%s`.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name The virtual column name
     * @param mixed $value The value to give to the virtual column
     *
     * @return $this
     */
    public function setVirtualColumn(string $name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param string $msg
     * @param int $priority One of the Propel::LOG_* logging levels
     *
     * @return void
     */
    protected function log(string $msg, int $priority = Propel::LOG_INFO): void
    {
        Propel::log(static::class . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param \Propel\Runtime\Parser\AbstractParser|string $parser An AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param bool $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @param string $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME, TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM. Defaults to TableMap::TYPE_PHPNAME.
     *
     * @return string The exported data
     */
    public function exportTo($parser, bool $includeLazyLoadColumns = true, string $keyType = TableMap::TYPE_PHPNAME): string
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray($keyType, $includeLazyLoadColumns, [], true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     *
     * @return array<string>
     */
    public function __sleep(): array
    {
        $this->clearAllReferences();

        $cls = new ReflectionClass($this);
        $staticProperties = $cls->getProperties(ReflectionProperty::IS_STATIC);
        $properties = $cls->getProperties();
        $serializableProperties = array_diff($properties, $staticProperties);

        $propertyNames = [];
        foreach ($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [prt_id] column value.
     *
     * @return int|null
     */
    public function getPrtId()
    {
        return $this->prt_id;
    }

    /**
     * Get the [prt_class] column value.
     *
     * @return string|null
     */
    public function getPrtClass()
    {
        return $this->prt_class;
    }

    /**
     * Get the [prt_name] column value.
     *
     * @return string|null
     */
    public function getPrtName()
    {
        return $this->prt_name;
    }

    /**
     * Get the [prt_description] column value.
     *
     * @return string|null
     */
    public function getPrtDescription()
    {
        return $this->prt_description;
    }

    /**
     * Set the value of [prt_id] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setPrtId($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->prt_id !== $v) {
            $this->prt_id = $v;
            $this->modifiedColumns[PropertyTypeTableMap::COL_PRT_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [prt_class] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setPrtClass($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->prt_class !== $v) {
            $this->prt_class = $v;
            $this->modifiedColumns[PropertyTypeTableMap::COL_PRT_CLASS] = true;
        }

        return $this;
    }

    /**
     * Set the value of [prt_name] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setPrtName($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->prt_name !== $v) {
            $this->prt_name = $v;
            $this->modifiedColumns[PropertyTypeTableMap::COL_PRT_NAME] = true;
        }

        return $this;
    }

    /**
     * Set the value of [prt_description] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setPrtDescription($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->prt_description !== $v) {
            $this->prt_description = $v;
            $this->modifiedColumns[PropertyTypeTableMap::COL_PRT_DESCRIPTION] = true;
        }

        return $this;
    }

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return bool Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues(): bool
    {
        if ($this->prt_class !== '') {
            return false;
        }

        if ($this->prt_name !== '') {
            return false;
        }

        return true;
    }

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows. This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by DataFetcher->fetch().
     * @param int $startcol 0-based offset column which indicates which resultset column to start with.
     * @param bool $rehydrate Whether this object is being re-hydrated from the database.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws \Propel\Runtime\Exception\PropelException - Any caught Exception will be rewrapped as a PropelException.
     *
     * @return int next starting column
     */
    public function hydrate(array $row, int $startcol = 0, bool $rehydrate = false, string $indexType = TableMap::TYPE_NUM): int
    {
        try {
            $useNumericIndex = $indexType === TableMap::TYPE_NUM;

            $rowIndex = $useNumericIndex ? $startcol + 0 : PropertyTypeTableMap::translateFieldName('PrtId', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->prt_id = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 1 : PropertyTypeTableMap::translateFieldName('PrtClass', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->prt_class = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 2 : PropertyTypeTableMap::translateFieldName('PrtName', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->prt_name = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 3 : PropertyTypeTableMap::translateFieldName('PrtDescription', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->prt_description = $columnValue !== null ? (string)$columnValue : null;

            $this->resetModified();
            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 4;
        } catch (Exception $e) {
            throw new PropelException('Error populating \ChurchCRM\model\ChurchCRM\PropertyType object', 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database. It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @return void
     */
    public function ensureConsistency(): void
    {
    }

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param bool $deep (optional) Whether to also de-associated any related objects.
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con (optional) The ConnectionInterface connection to use.
     *
     * @throws \Propel\Runtime\Exception\PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     *
     * @return void
     */
    public function reload(bool $deep = false, ?ConnectionInterface $con = null): void
    {
        if ($this->isDeleted()) {
            throw new PropelException('Cannot reload a deleted object.');
        }

        if ($this->isNew()) {
            throw new PropelException('Cannot reload an unsaved object.');
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PropertyTypeTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPropertyTypeQuery::create(null, $this->buildPkeyCriteria())->fetch($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row || $row === true) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) { // also de-associate any related objects?
            $this->collProperties = null;
        }
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @see PropertyType::setDeleted()
     * @see PropertyType::isDeleted()
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return void
     */
    public function delete(?ConnectionInterface $con = null): void
    {
        if ($this->isDeleted()) {
            throw new PropelException('This object has already been deleted.');
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PropertyTypeTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPropertyTypeQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method. This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return int The number of rows affected by this insert/update and any referring fk objects' save() operations.
     */
    public function save(?ConnectionInterface $con = null): int
    {
        if ($this->isDeleted()) {
            throw new PropelException('You cannot save an object that has been deleted.');
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PropertyTypeTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                PropertyTypeTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @see static::save()
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface $con
     *
     * @return int The number of rows affected by this insert/update and any referring fk objects' save() operations.
     */
    protected function doSave(ConnectionInterface $con): int
    {
        if ($this->alreadyInSave) {
            return 0;
        }

        $affectedRows = 0; // initialize var to track total num of affected rows
        $this->alreadyInSave = true;

        if ($this->isNew() || $this->isModified()) {
            // persist changes
            if ($this->isNew()) {
                $this->doInsert($con);
                $affectedRows += 1;
            } else {
                $affectedRows += $this->doUpdate($con);
            }
            $this->resetModified();
        }

        if ($this->propertiesScheduledForDeletion !== null) {
            if (!$this->propertiesScheduledForDeletion->isEmpty()) {
                ChildPropertyQuery::create()
                    ->filterByPrimaryKeys($this->propertiesScheduledForDeletion->getPrimaryKeys(false))
                    ->delete($con);
                $this->propertiesScheduledForDeletion = null;
            }
        }

        if ($this->collProperties !== null) {
            foreach ($this->collProperties as $referrerFK) {
                if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                    $affectedRows += $referrerFK->save($con);
                }
            }
        }

        $this->alreadyInSave = false;

        return $affectedRows;
    }

    /**
     * Insert the row in the database.
     *
     * @see static::doSave()
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface $con
     *
     * @throws \RuntimeException
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return void
     */
    protected function doInsert(ConnectionInterface $con): void
    {
        $modifiedColumns = [];
        $index = 0;
        $this->modifiedColumns[PropertyTypeTableMap::COL_PRT_ID] = true;
        if ($this->prt_id !== null) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PropertyTypeTableMap::COL_PRT_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PropertyTypeTableMap::COL_PRT_ID)) {
            $modifiedColumns[':p' . $index++] = 'prt_ID';
        }
        if ($this->isColumnModified(PropertyTypeTableMap::COL_PRT_CLASS)) {
            $modifiedColumns[':p' . $index++] = 'prt_Class';
        }
        if ($this->isColumnModified(PropertyTypeTableMap::COL_PRT_NAME)) {
            $modifiedColumns[':p' . $index++] = 'prt_Name';
        }
        if ($this->isColumnModified(PropertyTypeTableMap::COL_PRT_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++] = 'prt_Description';
        }

        $sql = sprintf(
            'INSERT INTO propertytype_prt (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns)),
        );

        try {
            $stmt = $con->prepare($sql);
            if (!$stmt) {
                throw new RuntimeException("Failed to build PreparedStatement for SQL '$sql'");
            }
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'prt_ID':
                        $stmt->bindValue($identifier, $this->prt_id, PDO::PARAM_INT);

                        break;
                    case 'prt_Class':
                        $stmt->bindValue($identifier, $this->prt_class, PDO::PARAM_STR);

                        break;
                    case 'prt_Name':
                        $stmt->bindValue($identifier, $this->prt_name, PDO::PARAM_STR);

                        break;
                    case 'prt_Description':
                        $stmt->bindValue($identifier, $this->prt_description, PDO::PARAM_STR);

                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);

            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setPrtId((int)$pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @see static::doSave()
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface $con
     *
     * @return int Number of updated rows
     */
    protected function doUpdate(ConnectionInterface $con): int
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     *
     * @return mixed Value of field.
     */
    public function getByName(string $name, string $type = TableMap::TYPE_PHPNAME)
    {
        /** @var int $pos */
        $pos = PropertyTypeTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->getByPosition($pos);
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos Position in XML schema
     *
     * @return mixed Value of field at $pos
     */
    public function getByPosition(int $pos)
    {
        return match ($pos) {
            0 => $this->getPrtId(),
            1 => $this->getPrtClass(),
            2 => $this->getPrtName(),
            3 => $this->getPrtDescription(),
            default => null
        };
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param string $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param bool $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param array<string, array<string|bool>> $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param bool $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array<mixed> An associative array containing the field names (as keys) and field values
     */
    public function toArray(
        string $keyType = TableMap::TYPE_PHPNAME,
        bool $includeLazyLoadColumns = true,
        array $alreadyDumpedObjects = [],
        bool $includeForeignObjects = false
    ): array {
        if (isset($alreadyDumpedObjects['PropertyType'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['PropertyType'][$this->hashCode()] = true;
        $keys = PropertyTypeTableMap::getFieldNames($keyType);
        $result = [
            $keys[0] => $this->getPrtId(),
            $keys[1] => $this->getPrtClass(),
            $keys[2] => $this->getPrtName(),
            $keys[3] => $this->getPrtDescription(),
        ];
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if ($this->collProperties !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'properties',
                     TableMap::TYPE_FIELDNAME => 'property_pros',
                     default => 'Properties',
                };
                $result[$key] = $this->collProperties->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     *
     * @return $this
     */
    public function setByName(string $name, $value, string $type = TableMap::TYPE_PHPNAME)
    {
        /** @var int $pos */
        $pos = PropertyTypeTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        $this->setByPosition($pos, $value);

        return $this;
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     *
     * @return $this
     */
    public function setByPosition(int $pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setPrtId($value);

                break;
            case 1:
                $this->setPrtClass($value);

                break;
            case 2:
                $this->setPrtName($value);

                break;
            case 3:
                $this->setPrtDescription($value);

                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST). This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param array<mixed> $arr An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this
     */
    public function fromArray(array $arr, string $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = PropertyTypeTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setPrtId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setPrtClass($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setPrtName($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setPrtDescription($arr[$keys[3]]);
        }

        return $this;
    }

    /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this
     */
    public function importFrom($parser, string $data, string $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return \Propel\Runtime\ActiveQuery\Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria(): Criteria
    {
        $tableMap = PropertyTypeTableMap::getTableMap();
        $criteria = new Criteria(PropertyTypeTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PropertyTypeTableMap::COL_PRT_ID)) {
            $criteria->setUpdateValue($tableMap->getColumn('prt_ID'), $this->prt_id);
        }
        if ($this->isColumnModified(PropertyTypeTableMap::COL_PRT_CLASS)) {
            $criteria->setUpdateValue($tableMap->getColumn('prt_Class'), $this->prt_class);
        }
        if ($this->isColumnModified(PropertyTypeTableMap::COL_PRT_NAME)) {
            $criteria->setUpdateValue($tableMap->getColumn('prt_Name'), $this->prt_name);
        }
        if ($this->isColumnModified(PropertyTypeTableMap::COL_PRT_DESCRIPTION)) {
            $criteria->setUpdateValue($tableMap->getColumn('prt_Description'), $this->prt_description);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether they have been modified.
     *
     * @return \Propel\Runtime\ActiveQuery\Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria(): Criteria
    {
        $tableMap = PropertyTypeTableMap::getTableMap();
        $query = ChildPropertyTypeQuery::create();
        $prt_IDColumn = new LocalColumnExpression($query, $tableMap->getName(), $tableMap->getColumn('prt_ID'));
        $query->addAnd($prt_IDColumn, $this->prt_id);

        return $query;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @throws \RuntimeException
     *
     * @return string|int Hashcode
     */
    public function hashCode()
    {
        $pkIsValid = $this->getPrtId() !== null;

        if ($pkIsValid) {
            $json = json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE);
            if ($json === false) {
                throw new RuntimeException('Failed to encode PK as JSON.');
            }

            return crc32($json);
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     *
     * @return int|null
     */
    public function getPrimaryKey()
    {
        return $this->getPrtId();
    }

    /**
     * Generic method to set the primary key (prt_id column).
     *
     * @param int|null $key Primary key.
     *
     * @return void
     */
    public function setPrimaryKey(?int $key = null): void
    {
        $this->setPrtId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     *
     * @return bool
     */
    public function isPrimaryKeyNull(): bool
    {
        return $this->getPrtId() === null;
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of \ChurchCRM\model\ChurchCRM\PropertyType (or compatible) type.
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param bool $makeNew Whether to reset autoincrement PKs and make the object new.
     *
     * @return void
     */
    public function copyInto(object $copyObj, bool $deepCopy = false, bool $makeNew = true): void
    {
        $copyObj->setPrtClass($this->getPrtClass());
        $copyObj->setPrtName($this->getPrtName());
        $copyObj->setPrtDescription($this->getPrtDescription());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getProperties() as $relObj) {
                $copyObj->addProperty($relObj->copy($deepCopy));
            }
        }

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setPrtId(null); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     *
     * @return static Clone of current object.
     */
    public function copy(bool $deepCopy = false)
    {
        $clazz = static::class;
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     *
     * @return void
     */
    public function initRelation($relationName): void
    {
        match ($relationName) {
            'Property' => $this->initProperties(),
            default => null
        };
    }

    /**
     * Initializes the collProperties collection.
     *
     * By default this just sets the collProperties collection to an empty array (like clearcollProperties());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProperties(bool $overrideExisting = true): void
    {
        if ($this->collProperties !== null && !$overrideExisting) {
            return;
        }

        $this->collProperties = new PropertyCollection();
        $this->collProperties->setModel('\ChurchCRM\model\ChurchCRM\Property');
    }

    /**
     * Reset is the collProperties collection loaded partially.
     *
     * @param bool $isPartial
     *
     * @return void
     */
    public function resetPartialProperties(bool $isPartial = true): void
    {
        $this->collPropertiesPartial = $isPartial;
    }

    /**
     * Clears out the collProperties collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return static
     */
    public function clearProperties(): static
    {
        $this->collProperties = null;

        return $this;
    }

    /**
     * Gets propertytype_prt objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this PropertyType is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\PropertyCollection
     */
    public function getProperties(?Criteria $criteria = null, ?ConnectionInterface $con = null): PropertyCollection
    {
        $partial = $this->collPropertiesPartial && !$this->isNew();
        if ($this->collProperties && !$criteria && !$partial) {
            return $this->collProperties;
        }

        if ($this->isNew()) {
            // return empty collection
            if ($this->collProperties === null) {
                $this->initProperties();

                return $this->collProperties;
            }

            $collProperties = new PropertyCollection();
            $collProperties->setModel('\ChurchCRM\model\ChurchCRM\Base\Property');

            return $collProperties;
        }

        $collProperties = ChildPropertyQuery::create(null, $criteria)
            ->filterByPropertyType($this)
            ->findObjects($con);

        if ($criteria) {
            if ($this->collPropertiesPartial !== false && count($collProperties)) {
                $this->initProperties(false);

                foreach ($collProperties as $obj) {
                    if (!$this->collProperties->contains($obj)) {
                        $this->collProperties->append($obj);
                    }
                }

                $this->collPropertiesPartial = true;
            }

            return $collProperties;
        }

        if ($this->collPropertiesPartial && $this->collProperties) {
            foreach ($this->collProperties as $obj) {
                if ($obj->isNew()) {
                    $collProperties[] = $obj;
                }
            }
        }

        $this->collProperties = $collProperties;
        $this->collPropertiesPartial = false;

        return $this->collProperties;
    }

    /**
     * Sets a collection of propertytype_prt objects related by a one-to-many relationship
     * to the current object.
     *
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\Property> $properties
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return static
     */
    public function setProperties(Collection $properties, ?ConnectionInterface $con = null): static
    {
        $propertiesToDelete = $this->getProperties(null, $con)->diff($properties);

        $this->propertiesScheduledForDeletion = $propertiesToDelete;

        foreach ($propertiesToDelete as $propertyRemoved) {
            $propertyRemoved->setPropertyType(null);
        }

        $this->collProperties = null;
        foreach ($properties as $property) {
            $this->addProperty($property);
        }

        $this->collPropertiesPartial = false;
        $this->collProperties = $properties instanceof PropertyCollection
            ? $properties : new PropertyCollection($properties->getData());

        return $this;
    }

    /**
     * Returns the number of related propertytype_prt objects.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param bool $distinct
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return int Count of related propertytype_prt objects.
     */
    public function countProperties(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collPropertiesPartial && !$this->isNew();
        if ($this->collProperties === null || $criteria !== null || $partial) {
            if ($this->isNew() && $this->collProperties === null) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getProperties());
            }

            $query = ChildPropertyQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPropertyType($this)
                ->count($con);
        }

        return count($this->collProperties);
    }

    /**
     * Method called to associate a Property object to this object
     * through the Property foreign key attribute.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Property $property
     *
     * @return $this
     */
    public function addProperty(Property $property)
    {
        if ($this->collProperties === null) {
            $this->initProperties();
            $this->collPropertiesPartial = true;
        }

        if (!$this->collProperties->contains($property)) {
            $this->doAddProperty($property);

            if ($this->propertiesScheduledForDeletion && $this->propertiesScheduledForDeletion->contains($property)) {
                $this->propertiesScheduledForDeletion->remove($this->propertiesScheduledForDeletion->search($property));
            }
        }

        return $this;
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\Property $property The Property object to add.
     *
     * @return void
     */
    protected function doAddProperty(Property $property): void
    {
        $this->collProperties->append($property);
        $property->setPropertyType($this);
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\Property $property The Property object to remove.
     *
     * @return static
     */
    public function removeProperty(Property $property): static
    {
        if ($this->getProperties()->contains($property)) {
            $pos = $this->collProperties->search($property);
            $this->collProperties->remove($pos);
            if ($this->propertiesScheduledForDeletion === null) {
                $this->propertiesScheduledForDeletion = clone $this->collProperties;
                $this->propertiesScheduledForDeletion->clear();
            }
            $this->propertiesScheduledForDeletion->append(clone $property);
            $property->setPropertyType(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     *
     * @return $this
     */
    public function clear()
    {
        $this->prt_id = null;
        $this->prt_class = null;
        $this->prt_name = null;
        $this->prt_description = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);

        return $this;
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param bool $deep Whether to also clear the references on all referrer objects.
     *
     * @return static
     */
    public function clearAllReferences(bool $deep = false): static
    {
        if ($deep) {
            if ($this->collProperties) {
                foreach ($this->collProperties as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        }

        $this->collProperties = null;

        return $this;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->exportTo(PropertyTypeTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return bool
     */
    public function preSave(?ConnectionInterface $con = null): bool
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return void
     */
    public function postSave(?ConnectionInterface $con = null): void
    {
    }

    /**
     * Code to be run before inserting to database
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return bool
     */
    public function preInsert(?ConnectionInterface $con = null): bool
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return void
     */
    public function postInsert(?ConnectionInterface $con = null): void
    {
    }

    /**
     * Code to be run before updating the object in database
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return bool
     */
    public function preUpdate(?ConnectionInterface $con = null): bool
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return void
     */
    public function postUpdate(?ConnectionInterface $con = null): void
    {
    }

    /**
     * Code to be run before deleting the object in database
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return bool
     */
    public function preDelete(?ConnectionInterface $con = null): bool
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return void
     */
    public function postDelete(?ConnectionInterface $con = null): void
    {
    }

    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed $params
     *
     * @throws \Propel\Runtime\Exception\BadMethodCallException
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (strpos($name, 'get') === 0) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (strpos($name, 'from') === 0) {
            $format = substr($name, 4);
            $inputData = $params[0];
            $keyType = $params[1] ?? TableMap::TYPE_PHPNAME;

            return $this->importFrom($format, $inputData, $keyType);
        }

        if (strpos($name, 'to') === 0) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = $params[0] ?? true;
            $keyType = $params[1] ?? TableMap::TYPE_PHPNAME;

            return $this->exportTo($format, $includeLazyLoadColumns, $keyType);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }
}
