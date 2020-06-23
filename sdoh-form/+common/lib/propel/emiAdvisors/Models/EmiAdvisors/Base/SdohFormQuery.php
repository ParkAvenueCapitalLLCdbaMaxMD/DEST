<?php

namespace EmiAdvisors\Base;

use \Exception;
use \PDO;
use EmiAdvisors\SdohForm as ChildSdohForm;
use EmiAdvisors\SdohFormQuery as ChildSdohFormQuery;
use EmiAdvisors\Map\SdohFormTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'sdoh_form' table.
 *
 *
 *
 * @method     ChildSdohFormQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSdohFormQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildSdohFormQuery orderByDomain($order = Criteria::ASC) Order by the domain column
 * @method     ChildSdohFormQuery orderByIdentifier($order = Criteria::ASC) Order by the identifier column
 * @method     ChildSdohFormQuery orderByFormVersion($order = Criteria::ASC) Order by the form_version column
 * @method     ChildSdohFormQuery orderByScreeningData($order = Criteria::ASC) Order by the screening_data column
 * @method     ChildSdohFormQuery orderByDiagnosesData($order = Criteria::ASC) Order by the diagnoses_data column
 * @method     ChildSdohFormQuery orderByGoalsData($order = Criteria::ASC) Order by the goals_data column
 * @method     ChildSdohFormQuery orderByInterventionData($order = Criteria::ASC) Order by the intervention_data column
 * @method     ChildSdohFormQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildSdohFormQuery orderByLastAdminDownloadTs($order = Criteria::ASC) Order by the last_admin_download_ts column
 * @method     ChildSdohFormQuery orderByLog($order = Criteria::ASC) Order by the log column
 * @method     ChildSdohFormQuery orderByCreatedTs($order = Criteria::ASC) Order by the created_ts column
 * @method     ChildSdohFormQuery orderByUpdatedTs($order = Criteria::ASC) Order by the updated_ts column
 * @method     ChildSdohFormQuery orderByValid($order = Criteria::ASC) Order by the valid column
 *
 * @method     ChildSdohFormQuery groupById() Group by the id column
 * @method     ChildSdohFormQuery groupByUserId() Group by the user_id column
 * @method     ChildSdohFormQuery groupByDomain() Group by the domain column
 * @method     ChildSdohFormQuery groupByIdentifier() Group by the identifier column
 * @method     ChildSdohFormQuery groupByFormVersion() Group by the form_version column
 * @method     ChildSdohFormQuery groupByScreeningData() Group by the screening_data column
 * @method     ChildSdohFormQuery groupByDiagnosesData() Group by the diagnoses_data column
 * @method     ChildSdohFormQuery groupByGoalsData() Group by the goals_data column
 * @method     ChildSdohFormQuery groupByInterventionData() Group by the intervention_data column
 * @method     ChildSdohFormQuery groupByStatus() Group by the status column
 * @method     ChildSdohFormQuery groupByLastAdminDownloadTs() Group by the last_admin_download_ts column
 * @method     ChildSdohFormQuery groupByLog() Group by the log column
 * @method     ChildSdohFormQuery groupByCreatedTs() Group by the created_ts column
 * @method     ChildSdohFormQuery groupByUpdatedTs() Group by the updated_ts column
 * @method     ChildSdohFormQuery groupByValid() Group by the valid column
 *
 * @method     ChildSdohFormQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSdohFormQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSdohFormQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSdohFormQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildSdohFormQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildSdohFormQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildSdohForm findOne(ConnectionInterface $con = null) Return the first ChildSdohForm matching the query
 * @method     ChildSdohForm findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSdohForm matching the query, or a new ChildSdohForm object populated from the query conditions when no match is found
 *
 * @method     ChildSdohForm findOneById(string $id) Return the first ChildSdohForm filtered by the id column
 * @method     ChildSdohForm findOneByUserId(string $user_id) Return the first ChildSdohForm filtered by the user_id column
 * @method     ChildSdohForm findOneByDomain(string $domain) Return the first ChildSdohForm filtered by the domain column
 * @method     ChildSdohForm findOneByIdentifier(string $identifier) Return the first ChildSdohForm filtered by the identifier column
 * @method     ChildSdohForm findOneByFormVersion(int $form_version) Return the first ChildSdohForm filtered by the form_version column
 * @method     ChildSdohForm findOneByScreeningData(string $screening_data) Return the first ChildSdohForm filtered by the screening_data column
 * @method     ChildSdohForm findOneByDiagnosesData(string $diagnoses_data) Return the first ChildSdohForm filtered by the diagnoses_data column
 * @method     ChildSdohForm findOneByGoalsData(string $goals_data) Return the first ChildSdohForm filtered by the goals_data column
 * @method     ChildSdohForm findOneByInterventionData(string $intervention_data) Return the first ChildSdohForm filtered by the intervention_data column
 * @method     ChildSdohForm findOneByStatus(string $status) Return the first ChildSdohForm filtered by the status column
 * @method     ChildSdohForm findOneByLastAdminDownloadTs(string $last_admin_download_ts) Return the first ChildSdohForm filtered by the last_admin_download_ts column
 * @method     ChildSdohForm findOneByLog(string $log) Return the first ChildSdohForm filtered by the log column
 * @method     ChildSdohForm findOneByCreatedTs(string $created_ts) Return the first ChildSdohForm filtered by the created_ts column
 * @method     ChildSdohForm findOneByUpdatedTs(string $updated_ts) Return the first ChildSdohForm filtered by the updated_ts column
 * @method     ChildSdohForm findOneByValid(boolean $valid) Return the first ChildSdohForm filtered by the valid column *

 * @method     ChildSdohForm requirePk($key, ConnectionInterface $con = null) Return the ChildSdohForm by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSdohForm requireOne(ConnectionInterface $con = null) Return the first ChildSdohForm matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSdohForm requireOneById(string $id) Return the first ChildSdohForm filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSdohForm requireOneByUserId(string $user_id) Return the first ChildSdohForm filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSdohForm requireOneByDomain(string $domain) Return the first ChildSdohForm filtered by the domain column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSdohForm requireOneByIdentifier(string $identifier) Return the first ChildSdohForm filtered by the identifier column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSdohForm requireOneByFormVersion(int $form_version) Return the first ChildSdohForm filtered by the form_version column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSdohForm requireOneByScreeningData(string $screening_data) Return the first ChildSdohForm filtered by the screening_data column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSdohForm requireOneByDiagnosesData(string $diagnoses_data) Return the first ChildSdohForm filtered by the diagnoses_data column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSdohForm requireOneByGoalsData(string $goals_data) Return the first ChildSdohForm filtered by the goals_data column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSdohForm requireOneByInterventionData(string $intervention_data) Return the first ChildSdohForm filtered by the intervention_data column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSdohForm requireOneByStatus(string $status) Return the first ChildSdohForm filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSdohForm requireOneByLastAdminDownloadTs(string $last_admin_download_ts) Return the first ChildSdohForm filtered by the last_admin_download_ts column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSdohForm requireOneByLog(string $log) Return the first ChildSdohForm filtered by the log column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSdohForm requireOneByCreatedTs(string $created_ts) Return the first ChildSdohForm filtered by the created_ts column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSdohForm requireOneByUpdatedTs(string $updated_ts) Return the first ChildSdohForm filtered by the updated_ts column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSdohForm requireOneByValid(boolean $valid) Return the first ChildSdohForm filtered by the valid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSdohForm[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSdohForm objects based on current ModelCriteria
 * @method     ChildSdohForm[]|ObjectCollection findById(string $id) Return ChildSdohForm objects filtered by the id column
 * @method     ChildSdohForm[]|ObjectCollection findByUserId(string $user_id) Return ChildSdohForm objects filtered by the user_id column
 * @method     ChildSdohForm[]|ObjectCollection findByDomain(string $domain) Return ChildSdohForm objects filtered by the domain column
 * @method     ChildSdohForm[]|ObjectCollection findByIdentifier(string $identifier) Return ChildSdohForm objects filtered by the identifier column
 * @method     ChildSdohForm[]|ObjectCollection findByFormVersion(int $form_version) Return ChildSdohForm objects filtered by the form_version column
 * @method     ChildSdohForm[]|ObjectCollection findByScreeningData(string $screening_data) Return ChildSdohForm objects filtered by the screening_data column
 * @method     ChildSdohForm[]|ObjectCollection findByDiagnosesData(string $diagnoses_data) Return ChildSdohForm objects filtered by the diagnoses_data column
 * @method     ChildSdohForm[]|ObjectCollection findByGoalsData(string $goals_data) Return ChildSdohForm objects filtered by the goals_data column
 * @method     ChildSdohForm[]|ObjectCollection findByInterventionData(string $intervention_data) Return ChildSdohForm objects filtered by the intervention_data column
 * @method     ChildSdohForm[]|ObjectCollection findByStatus(string $status) Return ChildSdohForm objects filtered by the status column
 * @method     ChildSdohForm[]|ObjectCollection findByLastAdminDownloadTs(string $last_admin_download_ts) Return ChildSdohForm objects filtered by the last_admin_download_ts column
 * @method     ChildSdohForm[]|ObjectCollection findByLog(string $log) Return ChildSdohForm objects filtered by the log column
 * @method     ChildSdohForm[]|ObjectCollection findByCreatedTs(string $created_ts) Return ChildSdohForm objects filtered by the created_ts column
 * @method     ChildSdohForm[]|ObjectCollection findByUpdatedTs(string $updated_ts) Return ChildSdohForm objects filtered by the updated_ts column
 * @method     ChildSdohForm[]|ObjectCollection findByValid(boolean $valid) Return ChildSdohForm objects filtered by the valid column
 * @method     ChildSdohForm[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SdohFormQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \EmiAdvisors\Base\SdohFormQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'emi_advisors', $modelName = '\\EmiAdvisors\\SdohForm', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSdohFormQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSdohFormQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSdohFormQuery) {
            return $criteria;
        }
        $query = new ChildSdohFormQuery();
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
     * @return ChildSdohForm|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SdohFormTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = SdohFormTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildSdohForm A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, user_id, domain, identifier, form_version, screening_data, diagnoses_data, goals_data, intervention_data, status, last_admin_download_ts, log, created_ts, updated_ts, valid FROM sdoh_form WHERE id = :p0';
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
            /** @var ChildSdohForm $obj */
            $obj = new ChildSdohForm();
            $obj->hydrate($row);
            SdohFormTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildSdohForm|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSdohFormQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SdohFormTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSdohFormQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SdohFormTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSdohFormQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SdohFormTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SdohFormTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SdohFormTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildSdohFormQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(SdohFormTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(SdohFormTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SdohFormTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the domain column
     *
     * Example usage:
     * <code>
     * $query->filterByDomain('fooValue');   // WHERE domain = 'fooValue'
     * $query->filterByDomain('%fooValue%', Criteria::LIKE); // WHERE domain LIKE '%fooValue%'
     * </code>
     *
     * @param     string $domain The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSdohFormQuery The current query, for fluid interface
     */
    public function filterByDomain($domain = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($domain)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SdohFormTableMap::COL_DOMAIN, $domain, $comparison);
    }

    /**
     * Filter the query on the identifier column
     *
     * Example usage:
     * <code>
     * $query->filterByIdentifier('fooValue');   // WHERE identifier = 'fooValue'
     * $query->filterByIdentifier('%fooValue%', Criteria::LIKE); // WHERE identifier LIKE '%fooValue%'
     * </code>
     *
     * @param     string $identifier The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSdohFormQuery The current query, for fluid interface
     */
    public function filterByIdentifier($identifier = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($identifier)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SdohFormTableMap::COL_IDENTIFIER, $identifier, $comparison);
    }

    /**
     * Filter the query on the form_version column
     *
     * Example usage:
     * <code>
     * $query->filterByFormVersion(1234); // WHERE form_version = 1234
     * $query->filterByFormVersion(array(12, 34)); // WHERE form_version IN (12, 34)
     * $query->filterByFormVersion(array('min' => 12)); // WHERE form_version > 12
     * </code>
     *
     * @param     mixed $formVersion The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSdohFormQuery The current query, for fluid interface
     */
    public function filterByFormVersion($formVersion = null, $comparison = null)
    {
        if (is_array($formVersion)) {
            $useMinMax = false;
            if (isset($formVersion['min'])) {
                $this->addUsingAlias(SdohFormTableMap::COL_FORM_VERSION, $formVersion['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($formVersion['max'])) {
                $this->addUsingAlias(SdohFormTableMap::COL_FORM_VERSION, $formVersion['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SdohFormTableMap::COL_FORM_VERSION, $formVersion, $comparison);
    }

    /**
     * Filter the query on the screening_data column
     *
     * Example usage:
     * <code>
     * $query->filterByScreeningData('fooValue');   // WHERE screening_data = 'fooValue'
     * $query->filterByScreeningData('%fooValue%', Criteria::LIKE); // WHERE screening_data LIKE '%fooValue%'
     * </code>
     *
     * @param     string $screeningData The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSdohFormQuery The current query, for fluid interface
     */
    public function filterByScreeningData($screeningData = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($screeningData)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SdohFormTableMap::COL_SCREENING_DATA, $screeningData, $comparison);
    }

    /**
     * Filter the query on the diagnoses_data column
     *
     * Example usage:
     * <code>
     * $query->filterByDiagnosesData('fooValue');   // WHERE diagnoses_data = 'fooValue'
     * $query->filterByDiagnosesData('%fooValue%', Criteria::LIKE); // WHERE diagnoses_data LIKE '%fooValue%'
     * </code>
     *
     * @param     string $diagnosesData The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSdohFormQuery The current query, for fluid interface
     */
    public function filterByDiagnosesData($diagnosesData = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($diagnosesData)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SdohFormTableMap::COL_DIAGNOSES_DATA, $diagnosesData, $comparison);
    }

    /**
     * Filter the query on the goals_data column
     *
     * Example usage:
     * <code>
     * $query->filterByGoalsData('fooValue');   // WHERE goals_data = 'fooValue'
     * $query->filterByGoalsData('%fooValue%', Criteria::LIKE); // WHERE goals_data LIKE '%fooValue%'
     * </code>
     *
     * @param     string $goalsData The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSdohFormQuery The current query, for fluid interface
     */
    public function filterByGoalsData($goalsData = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($goalsData)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SdohFormTableMap::COL_GOALS_DATA, $goalsData, $comparison);
    }

    /**
     * Filter the query on the intervention_data column
     *
     * Example usage:
     * <code>
     * $query->filterByInterventionData('fooValue');   // WHERE intervention_data = 'fooValue'
     * $query->filterByInterventionData('%fooValue%', Criteria::LIKE); // WHERE intervention_data LIKE '%fooValue%'
     * </code>
     *
     * @param     string $interventionData The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSdohFormQuery The current query, for fluid interface
     */
    public function filterByInterventionData($interventionData = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($interventionData)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SdohFormTableMap::COL_INTERVENTION_DATA, $interventionData, $comparison);
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
     * @return $this|ChildSdohFormQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($status)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SdohFormTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the last_admin_download_ts column
     *
     * Example usage:
     * <code>
     * $query->filterByLastAdminDownloadTs('2011-03-14'); // WHERE last_admin_download_ts = '2011-03-14'
     * $query->filterByLastAdminDownloadTs('now'); // WHERE last_admin_download_ts = '2011-03-14'
     * $query->filterByLastAdminDownloadTs(array('max' => 'yesterday')); // WHERE last_admin_download_ts > '2011-03-13'
     * </code>
     *
     * @param     mixed $lastAdminDownloadTs The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSdohFormQuery The current query, for fluid interface
     */
    public function filterByLastAdminDownloadTs($lastAdminDownloadTs = null, $comparison = null)
    {
        if (is_array($lastAdminDownloadTs)) {
            $useMinMax = false;
            if (isset($lastAdminDownloadTs['min'])) {
                $this->addUsingAlias(SdohFormTableMap::COL_LAST_ADMIN_DOWNLOAD_TS, $lastAdminDownloadTs['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastAdminDownloadTs['max'])) {
                $this->addUsingAlias(SdohFormTableMap::COL_LAST_ADMIN_DOWNLOAD_TS, $lastAdminDownloadTs['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SdohFormTableMap::COL_LAST_ADMIN_DOWNLOAD_TS, $lastAdminDownloadTs, $comparison);
    }

    /**
     * Filter the query on the log column
     *
     * Example usage:
     * <code>
     * $query->filterByLog('fooValue');   // WHERE log = 'fooValue'
     * $query->filterByLog('%fooValue%', Criteria::LIKE); // WHERE log LIKE '%fooValue%'
     * </code>
     *
     * @param     string $log The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSdohFormQuery The current query, for fluid interface
     */
    public function filterByLog($log = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($log)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SdohFormTableMap::COL_LOG, $log, $comparison);
    }

    /**
     * Filter the query on the created_ts column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedTs('2011-03-14'); // WHERE created_ts = '2011-03-14'
     * $query->filterByCreatedTs('now'); // WHERE created_ts = '2011-03-14'
     * $query->filterByCreatedTs(array('max' => 'yesterday')); // WHERE created_ts > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdTs The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSdohFormQuery The current query, for fluid interface
     */
    public function filterByCreatedTs($createdTs = null, $comparison = null)
    {
        if (is_array($createdTs)) {
            $useMinMax = false;
            if (isset($createdTs['min'])) {
                $this->addUsingAlias(SdohFormTableMap::COL_CREATED_TS, $createdTs['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdTs['max'])) {
                $this->addUsingAlias(SdohFormTableMap::COL_CREATED_TS, $createdTs['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SdohFormTableMap::COL_CREATED_TS, $createdTs, $comparison);
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
     * @return $this|ChildSdohFormQuery The current query, for fluid interface
     */
    public function filterByUpdatedTs($updatedTs = null, $comparison = null)
    {
        if (is_array($updatedTs)) {
            $useMinMax = false;
            if (isset($updatedTs['min'])) {
                $this->addUsingAlias(SdohFormTableMap::COL_UPDATED_TS, $updatedTs['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedTs['max'])) {
                $this->addUsingAlias(SdohFormTableMap::COL_UPDATED_TS, $updatedTs['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SdohFormTableMap::COL_UPDATED_TS, $updatedTs, $comparison);
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
     * @return $this|ChildSdohFormQuery The current query, for fluid interface
     */
    public function filterByValid($valid = null, $comparison = null)
    {
        if (is_string($valid)) {
            $valid = in_array(strtolower($valid), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SdohFormTableMap::COL_VALID, $valid, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSdohForm $sdohForm Object to remove from the list of results
     *
     * @return $this|ChildSdohFormQuery The current query, for fluid interface
     */
    public function prune($sdohForm = null)
    {
        if ($sdohForm) {
            $this->addUsingAlias(SdohFormTableMap::COL_ID, $sdohForm->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the sdoh_form table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SdohFormTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SdohFormTableMap::clearInstancePool();
            SdohFormTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SdohFormTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SdohFormTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SdohFormTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SdohFormTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SdohFormQuery
