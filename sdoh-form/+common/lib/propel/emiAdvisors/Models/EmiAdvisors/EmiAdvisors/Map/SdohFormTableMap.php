<?php

namespace EmiAdvisors\EmiAdvisors\Map;

use EmiAdvisors\EmiAdvisors\SdohForm;
use EmiAdvisors\EmiAdvisors\SdohFormQuery;
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
 * This class defines the structure of the 'sdoh_form' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SdohFormTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'EmiAdvisors.EmiAdvisors.Map.SdohFormTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'sdoh_form';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\EmiAdvisors\\EmiAdvisors\\SdohForm';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'EmiAdvisors.EmiAdvisors.SdohForm';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 11;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 11;

    /**
     * the column name for the id field
     */
    const COL_ID = 'sdoh_form.id';

    /**
     * the column name for the user_id field
     */
    const COL_USER_ID = 'sdoh_form.user_id';

    /**
     * the column name for the domain field
     */
    const COL_DOMAIN = 'sdoh_form.domain';

    /**
     * the column name for the screening_data field
     */
    const COL_SCREENING_DATA = 'sdoh_form.screening_data';

    /**
     * the column name for the diagnoses_data field
     */
    const COL_DIAGNOSES_DATA = 'sdoh_form.diagnoses_data';

    /**
     * the column name for the goals_data field
     */
    const COL_GOALS_DATA = 'sdoh_form.goals_data';

    /**
     * the column name for the intervention_data field
     */
    const COL_INTERVENTION_DATA = 'sdoh_form.intervention_data';

    /**
     * the column name for the status field
     */
    const COL_STATUS = 'sdoh_form.status';

    /**
     * the column name for the created_ts field
     */
    const COL_CREATED_TS = 'sdoh_form.created_ts';

    /**
     * the column name for the updated_ts field
     */
    const COL_UPDATED_TS = 'sdoh_form.updated_ts';

    /**
     * the column name for the valid field
     */
    const COL_VALID = 'sdoh_form.valid';

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
        self::TYPE_PHPNAME       => array('Id', 'UserId', 'Domain', 'ScreeningData', 'DiagnosesData', 'GoalsData', 'InterventionData', 'Status', 'CreatedTs', 'UpdatedTs', 'Valid', ),
        self::TYPE_CAMELNAME     => array('id', 'userId', 'domain', 'screeningData', 'diagnosesData', 'goalsData', 'interventionData', 'status', 'createdTs', 'updatedTs', 'valid', ),
        self::TYPE_COLNAME       => array(SdohFormTableMap::COL_ID, SdohFormTableMap::COL_USER_ID, SdohFormTableMap::COL_DOMAIN, SdohFormTableMap::COL_SCREENING_DATA, SdohFormTableMap::COL_DIAGNOSES_DATA, SdohFormTableMap::COL_GOALS_DATA, SdohFormTableMap::COL_INTERVENTION_DATA, SdohFormTableMap::COL_STATUS, SdohFormTableMap::COL_CREATED_TS, SdohFormTableMap::COL_UPDATED_TS, SdohFormTableMap::COL_VALID, ),
        self::TYPE_FIELDNAME     => array('id', 'user_id', 'domain', 'screening_data', 'diagnoses_data', 'goals_data', 'intervention_data', 'status', 'created_ts', 'updated_ts', 'valid', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'UserId' => 1, 'Domain' => 2, 'ScreeningData' => 3, 'DiagnosesData' => 4, 'GoalsData' => 5, 'InterventionData' => 6, 'Status' => 7, 'CreatedTs' => 8, 'UpdatedTs' => 9, 'Valid' => 10, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'userId' => 1, 'domain' => 2, 'screeningData' => 3, 'diagnosesData' => 4, 'goalsData' => 5, 'interventionData' => 6, 'status' => 7, 'createdTs' => 8, 'updatedTs' => 9, 'valid' => 10, ),
        self::TYPE_COLNAME       => array(SdohFormTableMap::COL_ID => 0, SdohFormTableMap::COL_USER_ID => 1, SdohFormTableMap::COL_DOMAIN => 2, SdohFormTableMap::COL_SCREENING_DATA => 3, SdohFormTableMap::COL_DIAGNOSES_DATA => 4, SdohFormTableMap::COL_GOALS_DATA => 5, SdohFormTableMap::COL_INTERVENTION_DATA => 6, SdohFormTableMap::COL_STATUS => 7, SdohFormTableMap::COL_CREATED_TS => 8, SdohFormTableMap::COL_UPDATED_TS => 9, SdohFormTableMap::COL_VALID => 10, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'user_id' => 1, 'domain' => 2, 'screening_data' => 3, 'diagnoses_data' => 4, 'goals_data' => 5, 'intervention_data' => 6, 'status' => 7, 'created_ts' => 8, 'updated_ts' => 9, 'valid' => 10, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
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
        $this->setName('sdoh_form');
        $this->setPhpName('SdohForm');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\EmiAdvisors\\EmiAdvisors\\SdohForm');
        $this->setPackage('EmiAdvisors.EmiAdvisors');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'BIGINT', true, null, null);
        $this->addColumn('user_id', 'UserId', 'BIGINT', true, null, 0);
        $this->addColumn('domain', 'Domain', 'VARCHAR', true, 32, null);
        $this->addColumn('screening_data', 'ScreeningData', 'LONGVARCHAR', false, null, null);
        $this->addColumn('diagnoses_data', 'DiagnosesData', 'LONGVARCHAR', false, null, null);
        $this->addColumn('goals_data', 'GoalsData', 'LONGVARCHAR', false, null, null);
        $this->addColumn('intervention_data', 'InterventionData', 'LONGVARCHAR', false, null, null);
        $this->addColumn('status', 'Status', 'VARCHAR', false, 16, null);
        $this->addColumn('created_ts', 'CreatedTs', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_ts', 'UpdatedTs', 'TIMESTAMP', false, null, 'CURRENT_TIMESTAMP');
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
        return $withPrefix ? SdohFormTableMap::CLASS_DEFAULT : SdohFormTableMap::OM_CLASS;
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
     * @return array           (SdohForm object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SdohFormTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SdohFormTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SdohFormTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SdohFormTableMap::OM_CLASS;
            /** @var SdohForm $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SdohFormTableMap::addInstanceToPool($obj, $key);
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
            $key = SdohFormTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SdohFormTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var SdohForm $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SdohFormTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(SdohFormTableMap::COL_ID);
            $criteria->addSelectColumn(SdohFormTableMap::COL_USER_ID);
            $criteria->addSelectColumn(SdohFormTableMap::COL_DOMAIN);
            $criteria->addSelectColumn(SdohFormTableMap::COL_SCREENING_DATA);
            $criteria->addSelectColumn(SdohFormTableMap::COL_DIAGNOSES_DATA);
            $criteria->addSelectColumn(SdohFormTableMap::COL_GOALS_DATA);
            $criteria->addSelectColumn(SdohFormTableMap::COL_INTERVENTION_DATA);
            $criteria->addSelectColumn(SdohFormTableMap::COL_STATUS);
            $criteria->addSelectColumn(SdohFormTableMap::COL_CREATED_TS);
            $criteria->addSelectColumn(SdohFormTableMap::COL_UPDATED_TS);
            $criteria->addSelectColumn(SdohFormTableMap::COL_VALID);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.user_id');
            $criteria->addSelectColumn($alias . '.domain');
            $criteria->addSelectColumn($alias . '.screening_data');
            $criteria->addSelectColumn($alias . '.diagnoses_data');
            $criteria->addSelectColumn($alias . '.goals_data');
            $criteria->addSelectColumn($alias . '.intervention_data');
            $criteria->addSelectColumn($alias . '.status');
            $criteria->addSelectColumn($alias . '.created_ts');
            $criteria->addSelectColumn($alias . '.updated_ts');
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
        return Propel::getServiceContainer()->getDatabaseMap(SdohFormTableMap::DATABASE_NAME)->getTable(SdohFormTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SdohFormTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SdohFormTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SdohFormTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a SdohForm or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or SdohForm object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SdohFormTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \EmiAdvisors\EmiAdvisors\SdohForm) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SdohFormTableMap::DATABASE_NAME);
            $criteria->add(SdohFormTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = SdohFormQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SdohFormTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SdohFormTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the sdoh_form table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SdohFormQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a SdohForm or Criteria object.
     *
     * @param mixed               $criteria Criteria or SdohForm object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SdohFormTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from SdohForm object
        }

        if ($criteria->containsKey(SdohFormTableMap::COL_ID) && $criteria->keyContainsValue(SdohFormTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SdohFormTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = SdohFormQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SdohFormTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SdohFormTableMap::buildTableMap();
