<?php

namespace EmiAdvisors\Base;

use \Exception;
use \PDO;
use EmiAdvisors\FormReference as ChildFormReference;
use EmiAdvisors\FormReferenceQuery as ChildFormReferenceQuery;
use EmiAdvisors\Map\FormReferenceTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'form_reference' table.
 *
 *
 *
 * @method     ChildFormReferenceQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildFormReferenceQuery orderByFormId($order = Criteria::ASC) Order by the form_id column
 * @method     ChildFormReferenceQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildFormReferenceQuery orderBySection($order = Criteria::ASC) Order by the section column
 * @method     ChildFormReferenceQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildFormReferenceQuery orderByMimeType($order = Criteria::ASC) Order by the mime_type column
 * @method     ChildFormReferenceQuery orderByReference($order = Criteria::ASC) Order by the reference column
 * @method     ChildFormReferenceQuery orderByValid($order = Criteria::ASC) Order by the valid column
 *
 * @method     ChildFormReferenceQuery groupById() Group by the id column
 * @method     ChildFormReferenceQuery groupByFormId() Group by the form_id column
 * @method     ChildFormReferenceQuery groupByUserId() Group by the user_id column
 * @method     ChildFormReferenceQuery groupBySection() Group by the section column
 * @method     ChildFormReferenceQuery groupByName() Group by the name column
 * @method     ChildFormReferenceQuery groupByMimeType() Group by the mime_type column
 * @method     ChildFormReferenceQuery groupByReference() Group by the reference column
 * @method     ChildFormReferenceQuery groupByValid() Group by the valid column
 *
 * @method     ChildFormReferenceQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildFormReferenceQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildFormReferenceQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildFormReferenceQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildFormReferenceQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildFormReferenceQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildFormReference findOne(ConnectionInterface $con = null) Return the first ChildFormReference matching the query
 * @method     ChildFormReference findOneOrCreate(ConnectionInterface $con = null) Return the first ChildFormReference matching the query, or a new ChildFormReference object populated from the query conditions when no match is found
 *
 * @method     ChildFormReference findOneById(string $id) Return the first ChildFormReference filtered by the id column
 * @method     ChildFormReference findOneByFormId(string $form_id) Return the first ChildFormReference filtered by the form_id column
 * @method     ChildFormReference findOneByUserId(string $user_id) Return the first ChildFormReference filtered by the user_id column
 * @method     ChildFormReference findOneBySection(string $section) Return the first ChildFormReference filtered by the section column
 * @method     ChildFormReference findOneByName(string $name) Return the first ChildFormReference filtered by the name column
 * @method     ChildFormReference findOneByMimeType(string $mime_type) Return the first ChildFormReference filtered by the mime_type column
 * @method     ChildFormReference findOneByReference(string $reference) Return the first ChildFormReference filtered by the reference column
 * @method     ChildFormReference findOneByValid(boolean $valid) Return the first ChildFormReference filtered by the valid column *

 * @method     ChildFormReference requirePk($key, ConnectionInterface $con = null) Return the ChildFormReference by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFormReference requireOne(ConnectionInterface $con = null) Return the first ChildFormReference matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildFormReference requireOneById(string $id) Return the first ChildFormReference filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFormReference requireOneByFormId(string $form_id) Return the first ChildFormReference filtered by the form_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFormReference requireOneByUserId(string $user_id) Return the first ChildFormReference filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFormReference requireOneBySection(string $section) Return the first ChildFormReference filtered by the section column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFormReference requireOneByName(string $name) Return the first ChildFormReference filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFormReference requireOneByMimeType(string $mime_type) Return the first ChildFormReference filtered by the mime_type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFormReference requireOneByReference(string $reference) Return the first ChildFormReference filtered by the reference column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFormReference requireOneByValid(boolean $valid) Return the first ChildFormReference filtered by the valid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildFormReference[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildFormReference objects based on current ModelCriteria
 * @method     ChildFormReference[]|ObjectCollection findById(string $id) Return ChildFormReference objects filtered by the id column
 * @method     ChildFormReference[]|ObjectCollection findByFormId(string $form_id) Return ChildFormReference objects filtered by the form_id column
 * @method     ChildFormReference[]|ObjectCollection findByUserId(string $user_id) Return ChildFormReference objects filtered by the user_id column
 * @method     ChildFormReference[]|ObjectCollection findBySection(string $section) Return ChildFormReference objects filtered by the section column
 * @method     ChildFormReference[]|ObjectCollection findByName(string $name) Return ChildFormReference objects filtered by the name column
 * @method     ChildFormReference[]|ObjectCollection findByMimeType(string $mime_type) Return ChildFormReference objects filtered by the mime_type column
 * @method     ChildFormReference[]|ObjectCollection findByReference(string $reference) Return ChildFormReference objects filtered by the reference column
 * @method     ChildFormReference[]|ObjectCollection findByValid(boolean $valid) Return ChildFormReference objects filtered by the valid column
 * @method     ChildFormReference[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class FormReferenceQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \EmiAdvisors\Base\FormReferenceQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'emi_advisors', $modelName = '\\EmiAdvisors\\FormReference', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildFormReferenceQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildFormReferenceQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildFormReferenceQuery) {
            return $criteria;
        }
        $query = new ChildFormReferenceQuery();
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
     * @return ChildFormReference|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(FormReferenceTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = FormReferenceTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildFormReference A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, form_id, user_id, section, name, mime_type, reference, valid FROM form_reference WHERE id = :p0';
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
            /** @var ChildFormReference $obj */
            $obj = new ChildFormReference();
            $obj->hydrate($row);
            FormReferenceTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildFormReference|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildFormReferenceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FormReferenceTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildFormReferenceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FormReferenceTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildFormReferenceQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(FormReferenceTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(FormReferenceTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FormReferenceTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the form_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFormId(1234); // WHERE form_id = 1234
     * $query->filterByFormId(array(12, 34)); // WHERE form_id IN (12, 34)
     * $query->filterByFormId(array('min' => 12)); // WHERE form_id > 12
     * </code>
     *
     * @param     mixed $formId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFormReferenceQuery The current query, for fluid interface
     */
    public function filterByFormId($formId = null, $comparison = null)
    {
        if (is_array($formId)) {
            $useMinMax = false;
            if (isset($formId['min'])) {
                $this->addUsingAlias(FormReferenceTableMap::COL_FORM_ID, $formId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($formId['max'])) {
                $this->addUsingAlias(FormReferenceTableMap::COL_FORM_ID, $formId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FormReferenceTableMap::COL_FORM_ID, $formId, $comparison);
    }

    /**
     * Filter the query on the user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId(1234); // WHERE user_id = 1234
     * $query->filterByUserId(array(12, 34)); // WHERE user_id IN (12, 34)
     * $query->filterByUserId(array('min' => 12)); // WHERE user_id > 12
     * </code>
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFormReferenceQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(FormReferenceTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(FormReferenceTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FormReferenceTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the section column
     *
     * Example usage:
     * <code>
     * $query->filterBySection('fooValue');   // WHERE section = 'fooValue'
     * $query->filterBySection('%fooValue%', Criteria::LIKE); // WHERE section LIKE '%fooValue%'
     * </code>
     *
     * @param     string $section The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFormReferenceQuery The current query, for fluid interface
     */
    public function filterBySection($section = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($section)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FormReferenceTableMap::COL_SECTION, $section, $comparison);
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
     * @return $this|ChildFormReferenceQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FormReferenceTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the mime_type column
     *
     * Example usage:
     * <code>
     * $query->filterByMimeType('fooValue');   // WHERE mime_type = 'fooValue'
     * $query->filterByMimeType('%fooValue%', Criteria::LIKE); // WHERE mime_type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $mimeType The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFormReferenceQuery The current query, for fluid interface
     */
    public function filterByMimeType($mimeType = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($mimeType)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FormReferenceTableMap::COL_MIME_TYPE, $mimeType, $comparison);
    }

    /**
     * Filter the query on the reference column
     *
     * Example usage:
     * <code>
     * $query->filterByReference('fooValue');   // WHERE reference = 'fooValue'
     * $query->filterByReference('%fooValue%', Criteria::LIKE); // WHERE reference LIKE '%fooValue%'
     * </code>
     *
     * @param     string $reference The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFormReferenceQuery The current query, for fluid interface
     */
    public function filterByReference($reference = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($reference)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FormReferenceTableMap::COL_REFERENCE, $reference, $comparison);
    }

    /**
     * Filter the query on the valid column
     *
     * Example usage:
     * <code>
     * $query->filterByValid(true); // WHERE valid = true
     * $query->filterByValid('yes'); // WHERE valid = true
     * </code>
     *
     * @param     boolean|string $valid The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFormReferenceQuery The current query, for fluid interface
     */
    public function filterByValid($valid = null, $comparison = null)
    {
        if (is_string($valid)) {
            $valid = in_array(strtolower($valid), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(FormReferenceTableMap::COL_VALID, $valid, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildFormReference $formReference Object to remove from the list of results
     *
     * @return $this|ChildFormReferenceQuery The current query, for fluid interface
     */
    public function prune($formReference = null)
    {
        if ($formReference) {
            $this->addUsingAlias(FormReferenceTableMap::COL_ID, $formReference->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the form_reference table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FormReferenceTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            FormReferenceTableMap::clearInstancePool();
            FormReferenceTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(FormReferenceTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(FormReferenceTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            FormReferenceTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            FormReferenceTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // FormReferenceQuery
