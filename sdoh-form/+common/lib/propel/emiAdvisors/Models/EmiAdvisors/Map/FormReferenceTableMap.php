<?php

namespace EmiAdvisors\Map;

use EmiAdvisors\FormReference;
use EmiAdvisors\FormReferenceQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'form_reference' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class FormReferenceTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'EmiAdvisors.Map.FormReferenceTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'emi_advisors';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'form_reference';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\EmiAdvisors\\FormReference';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'EmiAdvisors.FormReference';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the id field
     */
    const COL_ID = 'form_reference.id';

    /**
     * the column name for the form_id field
     */
    const COL_FORM_ID = 'form_reference.form_id';

    /**
     * the column name for the user_id field
     */
    const COL_USER_ID = 'form_reference.user_id';

    /**
     * the column name for the section field
     */
    const COL_SECTION = 'form_reference.section';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'form_reference.name';

    /**
     * the column name for the mime_type field
     */
    const COL_MIME_TYPE = 'form_reference.mime_type';

    /**
     * the column name for the reference field
     */
    const COL_REFERENCE = 'form_reference.reference';

    /**
     * the column name for the valid field
     */
    const COL_VALID = 'form_reference.valid';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'FormId', 'UserId', 'Section', 'Name', 'MimeType', 'Reference', 'Valid', ),
        self::TYPE_CAMELNAME     => array('id', 'formId', 'userId', 'section', 'name', 'mimeType', 'reference', 'valid', ),
        self::TYPE_COLNAME       => array(FormReferenceTableMap::COL_ID, FormReferenceTableMap::COL_FORM_ID, FormReferenceTableMap::COL_USER_ID, FormReferenceTableMap::COL_SECTION, FormReferenceTableMap::COL_NAME, FormReferenceTableMap::COL_MIME_TYPE, FormReferenceTableMap::COL_REFERENCE, FormReferenceTableMap::COL_VALID, ),
        self::TYPE_FIELDNAME     => array('id', 'form_id', 'user_id', 'section', 'name', 'mime_type', 'reference', 'valid', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'FormId' => 1, 'UserId' => 2, 'Section' => 3, 'Name' => 4, 'MimeType' => 5, 'Reference' => 6, 'Valid' => 7, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'formId' => 1, 'userId' => 2, 'section' => 3, 'name' => 4, 'mimeType' => 5, 'reference' => 6, 'valid' => 7, ),
        self::TYPE_COLNAME       => array(FormReferenceTableMap::COL_ID => 0, FormReferenceTableMap::COL_FORM_ID => 1, FormReferenceTableMap::COL_USER_ID => 2, FormReferenceTableMap::COL_SECTION => 3, FormReferenceTableMap::COL_NAME => 4, FormReferenceTableMap::COL_MIME_TYPE => 5, FormReferenceTableMap::COL_REFERENCE => 6, FormReferenceTableMap::COL_VALID => 7, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'form_id' => 1, 'user_id' => 2, 'section' => 3, 'name' => 4, 'mime_type' => 5, 'reference' => 6, 'valid' => 7, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('form_reference');
        $this->setPhpName('FormReference');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\EmiAdvisors\\FormReference');
        $this->setPackage('EmiAdvisors');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'BIGINT', true, null, null);
        $this->addColumn('form_id', 'FormId', 'BIGINT', true, null, 0);
        $this->addColumn('user_id', 'UserId', 'BIGINT', true, null, 0);
        $this->addColumn('section', 'Section', 'VARCHAR', false, 32, null);
        $this->addColumn('name', 'Name', 'LONGVARCHAR', false, null, null);
        $this->addColumn('mime_type', 'MimeType', 'LONGVARCHAR', false, null, null);
        $this->addColumn('reference', 'Reference', 'LONGVARCHAR', false, null, null);
        $this->addColumn('valid', 'Valid', 'BOOLEAN', true, 1, true);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? FormReferenceTableMap::CLASS_DEFAULT : FormReferenceTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (FormReference object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = FormReferenceTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = FormReferenceTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + FormReferenceTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = FormReferenceTableMap::OM_CLASS;
            /** @var FormReference $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            FormReferenceTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = FormReferenceTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = FormReferenceTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var FormReference $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                FormReferenceTableMap::addInstanceToPool($obj, $key);
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
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(FormReferenceTableMap::COL_ID);
            $criteria->addSelectColumn(FormReferenceTableMap::COL_FORM_ID);
            $criteria->addSelectColumn(FormReferenceTableMap::COL_USER_ID);
            $criteria->addSelectColumn(FormReferenceTableMap::COL_SECTION);
            $criteria->addSelectColumn(FormReferenceTableMap::COL_NAME);
            $criteria->addSelectColumn(FormReferenceTableMap::COL_MIME_TYPE);
            $criteria->addSelectColumn(FormReferenceTableMap::COL_REFERENCE);
            $criteria->addSelectColumn(FormReferenceTableMap::COL_VALID);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.form_id');
            $criteria->addSelectColumn($alias . '.user_id');
            $criteria->addSelectColumn($alias . '.section');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.mime_type');
            $criteria->addSelectColumn($alias . '.reference');
            $criteria->addSelectColumn($alias . '.valid');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(FormReferenceTableMap::DATABASE_NAME)->getTable(FormReferenceTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(FormReferenceTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(FormReferenceTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new FormReferenceTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a FormReference or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or FormReference object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FormReferenceTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \EmiAdvisors\FormReference) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(FormReferenceTableMap::DATABASE_NAME);
            $criteria->add(FormReferenceTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = FormReferenceQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            FormReferenceTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                FormReferenceTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the form_reference table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return FormReferenceQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a FormReference or Criteria object.
     *
     * @param mixed               $criteria Criteria or FormReference object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FormReferenceTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from FormReference object
        }

        if ($criteria->containsKey(FormReferenceTableMap::COL_ID) && $criteria->keyContainsValue(FormReferenceTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.FormReferenceTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = FormReferenceQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // FormReferenceTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
FormReferenceTableMap::buildTableMap();
