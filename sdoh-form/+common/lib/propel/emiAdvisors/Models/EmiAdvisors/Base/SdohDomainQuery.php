<?php

namespace EmiAdvisors\Base;

use \Exception;
use \PDO;
use EmiAdvisors\SdohDomain as ChildSdohDomain;
use EmiAdvisors\SdohDomainQuery as ChildSdohDomainQuery;
use EmiAdvisors\Map\SdohDomainTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'sdoh_domain' table.
 *
 *
 *
 * @method     ChildSdohDomainQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSdohDomainQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildSdohDomainQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildSdohDomainQuery orderBySchedules($order = Criteria::ASC) Order by the schedules column
 * @method     ChildSdohDomainQuery orderByLogs($order = Criteria::ASC) Order by the logs column
 * @method     ChildSdohDomainQuery orderByUpdatedTs($order = Criteria::ASC) Order by the updated_ts column
 * @method     ChildSdohDomainQuery orderByOtherInfo($order = Criteria::ASC) Order by the other_info column
 *
 * @method     ChildSdohDomainQuery groupById() Group by the id column
 * @method     ChildSdohDomainQuery groupByName() Group by the name column
 * @method     ChildSdohDomainQuery groupByStatus() Group by the status column
 * @method     ChildSdohDomainQuery groupBySchedules() Group by the schedules column
 * @method     ChildSdohDomainQuery groupByLogs() Group by the logs column
 * @method     ChildSdohDomainQuery groupByUpdatedTs() Group by the updated_ts column
 * @method     ChildSdohDomainQuery groupByOtherInfo() Group by the other_info column
 *
 * @method     ChildSdohDomainQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSdohDomainQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSdohDomainQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSdohDomainQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildSdohDomainQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildSdohDomainQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildSdohDomain findOne(ConnectionInterface $con = null) Return the first ChildSdohDomain matching the query
 * @method     ChildSdohDomain findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSdohDomain matching the query, or a new ChildSdohDomain object populated from the query conditions when no match is found
 *
 * @method     ChildSdohDomain findOneById(int $id) Return the first ChildSdohDomain filtered by the id column
 * @method     ChildSdohDomain findOneByName(string $name) Return the first ChildSdohDomain filtered by the name column
 * @method     ChildSdohDomain findOneByStatus(string $status) Return the first ChildSdohDomain filtered by the status column
 * @method     ChildSdohDomain findOneBySchedules(string $schedules) Return the first ChildSdohDomain filtered by the schedules column
 * @method     ChildSdohDomain findOneByLogs(string $logs) Return the first ChildSdohDomain filtered by the logs column
 * @method     ChildSdohDomain findOneByUpdatedTs(string $updated_ts) Return the first ChildSdohDomain filtered by the updated_ts column
 * @method     ChildSdohDomain findOneByOtherInfo(string $other_info) Return the first ChildSdohDomain filtered by the other_info column *

 * @method     ChildSdohDomain requirePk($key, ConnectionInterface $con = null) Return the ChildSdohDomain by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSdohDomain requireOne(ConnectionInterface $con = null) Return the first ChildSdohDomain matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSdohDomain requireOneById(int $id) Return the first ChildSdohDomain filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSdohDomain requireOneByName(string $name) Return the first ChildSdohDomain filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSdohDomain requireOneByStatus(string $status) Return the first ChildSdohDomain filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSdohDomain requireOneBySchedules(string $schedules) Return the first ChildSdohDomain filtered by the schedules column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSdohDomain requireOneByLogs(string $logs) Return the first ChildSdohDomain filtered by the logs column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSdohDomain requireOneByUpdatedTs(string $updated_ts) Return the first ChildSdohDomain filtered by the updated_ts column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSdohDomain requireOneByOtherInfo(string $other_info) Return the first ChildSdohDomain filtered by the other_info column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSdohDomain[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSdohDomain objects based on current ModelCriteria
 * @method     ChildSdohDomain[]|ObjectCollection findById(int $id) Return ChildSdohDomain objects filtered by the id column
 * @method     ChildSdohDomain[]|ObjectCollection findByName(string $name) Return ChildSdohDomain objects filtered by the name column
 * @method     ChildSdohDomain[]|ObjectCollection findByStatus(string $status) Return ChildSdohDomain objects filtered by the status column
 * @method     ChildSdohDomain[]|ObjectCollection findBySchedules(string $schedules) Return ChildSdohDomain objects filtered by the schedules column
 * @method     ChildSdohDomain[]|ObjectCollection findByLogs(string $logs) Return ChildSdohDomain objects filtered by the logs column
 * @method     ChildSdohDomain[]|ObjectCollection findByUpdatedTs(string $updated_ts) Return ChildSdohDomain objects filtered by the updated_ts column
 * @method     ChildSdohDomain[]|ObjectCollection findByOtherInfo(string $other_info) Return ChildSdohDomain objects filtered by the other_info column
 * @method     ChildSdohDomain[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SdohDomainQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \EmiAdvisors\Base\SdohDomainQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'emi_advisors', $modelName = '\\EmiAdvisors\\SdohDomain', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSdohDomainQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSdohDomainQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSdohDomainQuery) {
            return $criteria;
        }
        $query = new ChildSdohDomainQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildSdohDomain|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SdohDomainTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = SdohDomainTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSdohDomain A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, status, schedules, logs, updated_ts, other_info FROM sdoh_domain WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildSdohDomain $obj */
            $obj = new ChildSdohDomain();
            $obj->hydrate($row);
            SdohDomainTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildSdohDomain|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildSdohDomainQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SdohDomainTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSdohDomainQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SdohDomainTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSdohDomainQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SdohDomainTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SdohDomainTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SdohDomainTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSdohDomainQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SdohDomainTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus('fooValue');   // WHERE status = 'fooValue'
     * $query->filterByStatus('%fooValue%', Criteria::LIKE); // WHERE status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $status The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSdohDomainQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($status)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SdohDomainTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the schedules column
     *
     * Example usage:
     * <code>
     * $query->filterBySchedules('fooValue');   // WHERE schedules = 'fooValue'
     * $query->filterBySchedules('%fooValue%', Criteria::LIKE); // WHERE schedules LIKE '%fooValue%'
     * </code>
     *
     * @param     string $schedules The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSdohDomainQuery The current query, for fluid interface
     */
    public function filterBySchedules($schedules = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($schedules)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SdohDomainTableMap::COL_SCHEDULES, $schedules, $comparison);
    }

    /**
     * Filter the query on the logs column
     *
     * Example usage:
     * <code>
     * $query->filterByLogs('fooValue');   // WHERE logs = 'fooValue'
     * $query->filterByLogs('%fooValue%', Criteria::LIKE); // WHERE logs LIKE '%fooValue%'
     * </code>
     *
     * @param     string $logs The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSdohDomainQuery The current query, for fluid interface
     */
    public function filterByLogs($logs = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($logs)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SdohDomainTableMap::COL_LOGS, $logs, $comparison);
    }

    /**
     * Filter the query on the updated_ts column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedTs('2011-03-14'); // WHERE updated_ts = '2011-03-14'
     * $query->filterByUpdatedTs('now'); // WHERE updated_ts = '2011-03-14'
     * $query->filterByUpdatedTs(array('max' => 'yesterday')); // WHERE updated_ts > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedTs The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSdohDomainQuery The current query, for fluid interface
     */
    public function filterByUpdatedTs($updatedTs = null, $comparison = null)
    {
        if (is_array($updatedTs)) {
            $useMinMax = false;
            if (isset($updatedTs['min'])) {
                $this->addUsingAlias(SdohDomainTableMap::COL_UPDATED_TS, $updatedTs['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedTs['max'])) {
                $this->addUsingAlias(SdohDomainTableMap::COL_UPDATED_TS, $updatedTs['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SdohDomainTableMap::COL_UPDATED_TS, $updatedTs, $comparison);
    }

    /**
     * Filter the query on the other_info column
     *
     * Example usage:
     * <code>
     * $query->filterByOtherInfo('fooValue');   // WHERE other_info = 'fooValue'
     * $query->filterByOtherInfo('%fooValue%', Criteria::LIKE); // WHERE other_info LIKE '%fooValue%'
     * </code>
     *
     * @param     string $otherInfo The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSdohDomainQuery The current query, for fluid interface
     */
    public function filterByOtherInfo($otherInfo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($otherInfo)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SdohDomainTableMap::COL_OTHER_INFO, $otherInfo, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSdohDomain $sdohDomain Object to remove from the list of results
     *
     * @return $this|ChildSdohDomainQuery The current query, for fluid interface
     */
    public function prune($sdohDomain = null)
    {
        if ($sdohDomain) {
            $this->addUsingAlias(SdohDomainTableMap::COL_ID, $sdohDomain->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the sdoh_domain table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SdohDomainTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SdohDomainTableMap::clearInstancePool();
            SdohDomainTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SdohDomainTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SdohDomainTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SdohDomainTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SdohDomainTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SdohDomainQuery
