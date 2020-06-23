<?php

namespace EmiAdvisors\Base;

use \DateTime;
use \Exception;
use \PDO;
use EmiAdvisors\SdohFormQuery as ChildSdohFormQuery;
use EmiAdvisors\Map\SdohFormTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'sdoh_form' table.
 *
 *
 *
 * @package    propel.generator.EmiAdvisors.Base
 */
abstract class SdohForm implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\EmiAdvisors\\Map\\SdohFormTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        string
     */
    protected $id;

    /**
     * The value for the user_id field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $user_id;

    /**
     * The value for the domain field.
     *
     * @var        string
     */
    protected $domain;

    /**
     * The value for the identifier field.
     *
     * @var        string
     */
    protected $identifier;

    /**
     * The value for the form_version field.
     *
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $form_version;

    /**
     * The value for the screening_data field.
     *
     * @var        string
     */
    protected $screening_data;

    /**
     * The value for the diagnoses_data field.
     *
     * @var        string
     */
    protected $diagnoses_data;

    /**
     * The value for the goals_data field.
     *
     * @var        string
     */
    protected $goals_data;

    /**
     * The value for the intervention_data field.
     *
     * @var        string
     */
    protected $intervention_data;

    /**
     * The value for the status field.
     *
     * @var        string
     */
    protected $status;

    /**
     * The value for the last_admin_download_ts field.
     *
     * @var        DateTime
     */
    protected $last_admin_download_ts;

    /**
     * The value for the log field.
     *
     * @var        string
     */
    protected $log;

    /**
     * The value for the created_ts field.
     *
     * @var        DateTime
     */
    protected $created_ts;

    /**
     * The value for the updated_ts field.
     *
     * Note: this column has a database default value of: (expression) CURRENT_TIMESTAMP
     * @var        DateTime
     */
    protected $updated_ts;

    /**
     * The value for the valid field.
     *
     * Note: this column has a database default value of: true
     * @var        boolean
     */
    protected $valid;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->user_id = '0';
        $this->form_version = 1;
        $this->valid = true;
    }

    /**
     * Initializes internal state of EmiAdvisors\Base\SdohForm object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>SdohForm</code> instance.  If
     * <code>obj</code> is an instance of <code>SdohForm</code>, delegates to
     * <code>equals(SdohForm)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|SdohForm The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [user_id] column value.
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Get the [domain] column value.
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Get the [identifier] column value.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Get the [form_version] column value.
     *
     * @return int
     */
    public function getFormVersion()
    {
        return $this->form_version;
    }

    /**
     * Get the [screening_data] column value.
     *
     * @return string
     */
    public function getScreeningData()
    {
        return $this->screening_data;
    }

    /**
     * Get the [diagnoses_data] column value.
     *
     * @return string
     */
    public function getDiagnosesData()
    {
        return $this->diagnoses_data;
    }

    /**
     * Get the [goals_data] column value.
     *
     * @return string
     */
    public function getGoalsData()
    {
        return $this->goals_data;
    }

    /**
     * Get the [intervention_data] column value.
     *
     * @return string
     */
    public function getInterventionData()
    {
        return $this->intervention_data;
    }

    /**
     * Get the [status] column value.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get the [optionally formatted] temporal [last_admin_download_ts] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getLastAdminDownloadTs($format = NULL)
    {
        if ($format === null) {
            return $this->last_admin_download_ts;
        } else {
            return $this->last_admin_download_ts instanceof \DateTimeInterface ? $this->last_admin_download_ts->format($format) : null;
        }
    }

    /**
     * Get the [log] column value.
     *
     * @return string
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * Get the [optionally formatted] temporal [created_ts] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedTs($format = NULL)
    {
        if ($format === null) {
            return $this->created_ts;
        } else {
            return $this->created_ts instanceof \DateTimeInterface ? $this->created_ts->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [updated_ts] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpdatedTs($format = NULL)
    {
        if ($format === null) {
            return $this->updated_ts;
        } else {
            return $this->updated_ts instanceof \DateTimeInterface ? $this->updated_ts->format($format) : null;
        }
    }

    /**
     * Get the [valid] column value.
     *
     * @return boolean
     */
    public function getValid()
    {
        return $this->valid;
    }

    /**
     * Get the [valid] column value.
     *
     * @return boolean
     */
    public function isValid()
    {
        return $this->getValid();
    }

    /**
     * Set the value of [id] column.
     *
     * @param string $v new value
     * @return $this|\EmiAdvisors\SdohForm The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[SdohFormTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [user_id] column.
     *
     * @param string $v new value
     * @return $this|\EmiAdvisors\SdohForm The current object (for fluent API support)
     */
    public function setUserId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->user_id !== $v) {
            $this->user_id = $v;
            $this->modifiedColumns[SdohFormTableMap::COL_USER_ID] = true;
        }

        return $this;
    } // setUserId()

    /**
     * Set the value of [domain] column.
     *
     * @param string $v new value
     * @return $this|\EmiAdvisors\SdohForm The current object (for fluent API support)
     */
    public function setDomain($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->domain !== $v) {
            $this->domain = $v;
            $this->modifiedColumns[SdohFormTableMap::COL_DOMAIN] = true;
        }

        return $this;
    } // setDomain()

    /**
     * Set the value of [identifier] column.
     *
     * @param string $v new value
     * @return $this|\EmiAdvisors\SdohForm The current object (for fluent API support)
     */
    public function setIdentifier($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->identifier !== $v) {
            $this->identifier = $v;
            $this->modifiedColumns[SdohFormTableMap::COL_IDENTIFIER] = true;
        }

        return $this;
    } // setIdentifier()

    /**
     * Set the value of [form_version] column.
     *
     * @param int $v new value
     * @return $this|\EmiAdvisors\SdohForm The current object (for fluent API support)
     */
    public function setFormVersion($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->form_version !== $v) {
            $this->form_version = $v;
            $this->modifiedColumns[SdohFormTableMap::COL_FORM_VERSION] = true;
        }

        return $this;
    } // setFormVersion()

    /**
     * Set the value of [screening_data] column.
     *
     * @param string $v new value
     * @return $this|\EmiAdvisors\SdohForm The current object (for fluent API support)
     */
    public function setScreeningData($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->screening_data !== $v) {
            $this->screening_data = $v;
            $this->modifiedColumns[SdohFormTableMap::COL_SCREENING_DATA] = true;
        }

        return $this;
    } // setScreeningData()

    /**
     * Set the value of [diagnoses_data] column.
     *
     * @param string $v new value
     * @return $this|\EmiAdvisors\SdohForm The current object (for fluent API support)
     */
    public function setDiagnosesData($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->diagnoses_data !== $v) {
            $this->diagnoses_data = $v;
            $this->modifiedColumns[SdohFormTableMap::COL_DIAGNOSES_DATA] = true;
        }

        return $this;
    } // setDiagnosesData()

    /**
     * Set the value of [goals_data] column.
     *
     * @param string $v new value
     * @return $this|\EmiAdvisors\SdohForm The current object (for fluent API support)
     */
    public function setGoalsData($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->goals_data !== $v) {
            $this->goals_data = $v;
            $this->modifiedColumns[SdohFormTableMap::COL_GOALS_DATA] = true;
        }

        return $this;
    } // setGoalsData()

    /**
     * Set the value of [intervention_data] column.
     *
     * @param string $v new value
     * @return $this|\EmiAdvisors\SdohForm The current object (for fluent API support)
     */
    public function setInterventionData($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->intervention_data !== $v) {
            $this->intervention_data = $v;
            $this->modifiedColumns[SdohFormTableMap::COL_INTERVENTION_DATA] = true;
        }

        return $this;
    } // setInterventionData()

    /**
     * Set the value of [status] column.
     *
     * @param string $v new value
     * @return $this|\EmiAdvisors\SdohForm The current object (for fluent API support)
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[SdohFormTableMap::COL_STATUS] = true;
        }

        return $this;
    } // setStatus()

    /**
     * Sets the value of [last_admin_download_ts] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\EmiAdvisors\SdohForm The current object (for fluent API support)
     */
    public function setLastAdminDownloadTs($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->last_admin_download_ts !== null || $dt !== null) {
            if ($this->last_admin_download_ts === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->last_admin_download_ts->format("Y-m-d H:i:s.u")) {
                $this->last_admin_download_ts = $dt === null ? null : clone $dt;
                $this->modifiedColumns[SdohFormTableMap::COL_LAST_ADMIN_DOWNLOAD_TS] = true;
            }
        } // if either are not null

        return $this;
    } // setLastAdminDownloadTs()

    /**
     * Set the value of [log] column.
     *
     * @param string $v new value
     * @return $this|\EmiAdvisors\SdohForm The current object (for fluent API support)
     */
    public function setLog($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->log !== $v) {
            $this->log = $v;
            $this->modifiedColumns[SdohFormTableMap::COL_LOG] = true;
        }

        return $this;
    } // setLog()

    /**
     * Sets the value of [created_ts] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\EmiAdvisors\SdohForm The current object (for fluent API support)
     */
    public function setCreatedTs($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_ts !== null || $dt !== null) {
            if ($this->created_ts === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->created_ts->format("Y-m-d H:i:s.u")) {
                $this->created_ts = $dt === null ? null : clone $dt;
                $this->modifiedColumns[SdohFormTableMap::COL_CREATED_TS] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedTs()

    /**
     * Sets the value of [updated_ts] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\EmiAdvisors\SdohForm The current object (for fluent API support)
     */
    public function setUpdatedTs($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_ts !== null || $dt !== null) {
            if ($this->updated_ts === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->updated_ts->format("Y-m-d H:i:s.u")) {
                $this->updated_ts = $dt === null ? null : clone $dt;
                $this->modifiedColumns[SdohFormTableMap::COL_UPDATED_TS] = true;
            }
        } // if either are not null

        return $this;
    } // setUpdatedTs()

    /**
     * Sets the value of the [valid] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\EmiAdvisors\SdohForm The current object (for fluent API support)
     */
    public function setValid($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->valid !== $v) {
            $this->valid = $v;
            $this->modifiedColumns[SdohFormTableMap::COL_VALID] = true;
        }

        return $this;
    } // setValid()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->user_id !== '0') {
                return false;
            }

            if ($this->form_version !== 1) {
                return false;
            }

            if ($this->valid !== true) {
                return false;
            }

        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SdohFormTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SdohFormTableMap::translateFieldName('UserId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : SdohFormTableMap::translateFieldName('Domain', TableMap::TYPE_PHPNAME, $indexType)];
            $this->domain = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : SdohFormTableMap::translateFieldName('Identifier', TableMap::TYPE_PHPNAME, $indexType)];
            $this->identifier = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : SdohFormTableMap::translateFieldName('FormVersion', TableMap::TYPE_PHPNAME, $indexType)];
            $this->form_version = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : SdohFormTableMap::translateFieldName('ScreeningData', TableMap::TYPE_PHPNAME, $indexType)];
            $this->screening_data = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : SdohFormTableMap::translateFieldName('DiagnosesData', TableMap::TYPE_PHPNAME, $indexType)];
            $this->diagnoses_data = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : SdohFormTableMap::translateFieldName('GoalsData', TableMap::TYPE_PHPNAME, $indexType)];
            $this->goals_data = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : SdohFormTableMap::translateFieldName('InterventionData', TableMap::TYPE_PHPNAME, $indexType)];
            $this->intervention_data = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : SdohFormTableMap::translateFieldName('Status', TableMap::TYPE_PHPNAME, $indexType)];
            $this->status = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : SdohFormTableMap::translateFieldName('LastAdminDownloadTs', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->last_admin_download_ts = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : SdohFormTableMap::translateFieldName('Log', TableMap::TYPE_PHPNAME, $indexType)];
            $this->log = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : SdohFormTableMap::translateFieldName('CreatedTs', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_ts = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : SdohFormTableMap::translateFieldName('UpdatedTs', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_ts = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : SdohFormTableMap::translateFieldName('Valid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->valid = (null !== $col) ? (boolean) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 15; // 15 = SdohFormTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\EmiAdvisors\\SdohForm'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SdohFormTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSdohFormQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see SdohForm::setDeleted()
     * @see SdohForm::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SdohFormTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSdohFormQuery::create()
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
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SdohFormTableMap::DATABASE_NAME);
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
                SdohFormTableMap::addInstanceToPool($this);
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
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
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

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[SdohFormTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SdohFormTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SdohFormTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(SdohFormTableMap::COL_USER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'user_id';
        }
        if ($this->isColumnModified(SdohFormTableMap::COL_DOMAIN)) {
            $modifiedColumns[':p' . $index++]  = 'domain';
        }
        if ($this->isColumnModified(SdohFormTableMap::COL_IDENTIFIER)) {
            $modifiedColumns[':p' . $index++]  = 'identifier';
        }
        if ($this->isColumnModified(SdohFormTableMap::COL_FORM_VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'form_version';
        }
        if ($this->isColumnModified(SdohFormTableMap::COL_SCREENING_DATA)) {
            $modifiedColumns[':p' . $index++]  = 'screening_data';
        }
        if ($this->isColumnModified(SdohFormTableMap::COL_DIAGNOSES_DATA)) {
            $modifiedColumns[':p' . $index++]  = 'diagnoses_data';
        }
        if ($this->isColumnModified(SdohFormTableMap::COL_GOALS_DATA)) {
            $modifiedColumns[':p' . $index++]  = 'goals_data';
        }
        if ($this->isColumnModified(SdohFormTableMap::COL_INTERVENTION_DATA)) {
            $modifiedColumns[':p' . $index++]  = 'intervention_data';
        }
        if ($this->isColumnModified(SdohFormTableMap::COL_STATUS)) {
            $modifiedColumns[':p' . $index++]  = 'status';
        }
        if ($this->isColumnModified(SdohFormTableMap::COL_LAST_ADMIN_DOWNLOAD_TS)) {
            $modifiedColumns[':p' . $index++]  = 'last_admin_download_ts';
        }
        if ($this->isColumnModified(SdohFormTableMap::COL_LOG)) {
            $modifiedColumns[':p' . $index++]  = 'log';
        }
        if ($this->isColumnModified(SdohFormTableMap::COL_CREATED_TS)) {
            $modifiedColumns[':p' . $index++]  = 'created_ts';
        }
        if ($this->isColumnModified(SdohFormTableMap::COL_UPDATED_TS)) {
            $modifiedColumns[':p' . $index++]  = 'updated_ts';
        }
        if ($this->isColumnModified(SdohFormTableMap::COL_VALID)) {
            $modifiedColumns[':p' . $index++]  = 'valid';
        }

        $sql = sprintf(
            'INSERT INTO sdoh_form (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'user_id':
                        $stmt->bindValue($identifier, $this->user_id, PDO::PARAM_INT);
                        break;
                    case 'domain':
                        $stmt->bindValue($identifier, $this->domain, PDO::PARAM_STR);
                        break;
                    case 'identifier':
                        $stmt->bindValue($identifier, $this->identifier, PDO::PARAM_STR);
                        break;
                    case 'form_version':
                        $stmt->bindValue($identifier, $this->form_version, PDO::PARAM_INT);
                        break;
                    case 'screening_data':
                        $stmt->bindValue($identifier, $this->screening_data, PDO::PARAM_STR);
                        break;
                    case 'diagnoses_data':
                        $stmt->bindValue($identifier, $this->diagnoses_data, PDO::PARAM_STR);
                        break;
                    case 'goals_data':
                        $stmt->bindValue($identifier, $this->goals_data, PDO::PARAM_STR);
                        break;
                    case 'intervention_data':
                        $stmt->bindValue($identifier, $this->intervention_data, PDO::PARAM_STR);
                        break;
                    case 'status':
                        $stmt->bindValue($identifier, $this->status, PDO::PARAM_STR);
                        break;
                    case 'last_admin_download_ts':
                        $stmt->bindValue($identifier, $this->last_admin_download_ts ? $this->last_admin_download_ts->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'log':
                        $stmt->bindValue($identifier, $this->log, PDO::PARAM_STR);
                        break;
                    case 'created_ts':
                        $stmt->bindValue($identifier, $this->created_ts ? $this->created_ts->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'updated_ts':
                        $stmt->bindValue($identifier, $this->updated_ts ? $this->updated_ts->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'valid':
                        $stmt->bindValue($identifier, (int) $this->valid, PDO::PARAM_INT);
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
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SdohFormTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getUserId();
                break;
            case 2:
                return $this->getDomain();
                break;
            case 3:
                return $this->getIdentifier();
                break;
            case 4:
                return $this->getFormVersion();
                break;
            case 5:
                return $this->getScreeningData();
                break;
            case 6:
                return $this->getDiagnosesData();
                break;
            case 7:
                return $this->getGoalsData();
                break;
            case 8:
                return $this->getInterventionData();
                break;
            case 9:
                return $this->getStatus();
                break;
            case 10:
                return $this->getLastAdminDownloadTs();
                break;
            case 11:
                return $this->getLog();
                break;
            case 12:
                return $this->getCreatedTs();
                break;
            case 13:
                return $this->getUpdatedTs();
                break;
            case 14:
                return $this->getValid();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array())
    {

        if (isset($alreadyDumpedObjects['SdohForm'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['SdohForm'][$this->hashCode()] = true;
        $keys = SdohFormTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getUserId(),
            $keys[2] => $this->getDomain(),
            $keys[3] => $this->getIdentifier(),
            $keys[4] => $this->getFormVersion(),
            $keys[5] => $this->getScreeningData(),
            $keys[6] => $this->getDiagnosesData(),
            $keys[7] => $this->getGoalsData(),
            $keys[8] => $this->getInterventionData(),
            $keys[9] => $this->getStatus(),
            $keys[10] => $this->getLastAdminDownloadTs(),
            $keys[11] => $this->getLog(),
            $keys[12] => $this->getCreatedTs(),
            $keys[13] => $this->getUpdatedTs(),
            $keys[14] => $this->getValid(),
        );
        if ($result[$keys[10]] instanceof \DateTimeInterface) {
            $result[$keys[10]] = $result[$keys[10]]->format('c');
        }

        if ($result[$keys[12]] instanceof \DateTimeInterface) {
            $result[$keys[12]] = $result[$keys[12]]->format('c');
        }

        if ($result[$keys[13]] instanceof \DateTimeInterface) {
            $result[$keys[13]] = $result[$keys[13]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }


        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\EmiAdvisors\SdohForm
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SdohFormTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\EmiAdvisors\SdohForm
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setUserId($value);
                break;
            case 2:
                $this->setDomain($value);
                break;
            case 3:
                $this->setIdentifier($value);
                break;
            case 4:
                $this->setFormVersion($value);
                break;
            case 5:
                $this->setScreeningData($value);
                break;
            case 6:
                $this->setDiagnosesData($value);
                break;
            case 7:
                $this->setGoalsData($value);
                break;
            case 8:
                $this->setInterventionData($value);
                break;
            case 9:
                $this->setStatus($value);
                break;
            case 10:
                $this->setLastAdminDownloadTs($value);
                break;
            case 11:
                $this->setLog($value);
                break;
            case 12:
                $this->setCreatedTs($value);
                break;
            case 13:
                $this->setUpdatedTs($value);
                break;
            case 14:
                $this->setValid($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = SdohFormTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setUserId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setDomain($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setIdentifier($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setFormVersion($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setScreeningData($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setDiagnosesData($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setGoalsData($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setInterventionData($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setStatus($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setLastAdminDownloadTs($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setLog($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setCreatedTs($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setUpdatedTs($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setValid($arr[$keys[14]]);
        }
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
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\EmiAdvisors\SdohForm The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
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
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(SdohFormTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SdohFormTableMap::COL_ID)) {
            $criteria->add(SdohFormTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(SdohFormTableMap::COL_USER_ID)) {
            $criteria->add(SdohFormTableMap::COL_USER_ID, $this->user_id);
        }
        if ($this->isColumnModified(SdohFormTableMap::COL_DOMAIN)) {
            $criteria->add(SdohFormTableMap::COL_DOMAIN, $this->domain);
        }
        if ($this->isColumnModified(SdohFormTableMap::COL_IDENTIFIER)) {
            $criteria->add(SdohFormTableMap::COL_IDENTIFIER, $this->identifier);
        }
        if ($this->isColumnModified(SdohFormTableMap::COL_FORM_VERSION)) {
            $criteria->add(SdohFormTableMap::COL_FORM_VERSION, $this->form_version);
        }
        if ($this->isColumnModified(SdohFormTableMap::COL_SCREENING_DATA)) {
            $criteria->add(SdohFormTableMap::COL_SCREENING_DATA, $this->screening_data);
        }
        if ($this->isColumnModified(SdohFormTableMap::COL_DIAGNOSES_DATA)) {
            $criteria->add(SdohFormTableMap::COL_DIAGNOSES_DATA, $this->diagnoses_data);
        }
        if ($this->isColumnModified(SdohFormTableMap::COL_GOALS_DATA)) {
            $criteria->add(SdohFormTableMap::COL_GOALS_DATA, $this->goals_data);
        }
        if ($this->isColumnModified(SdohFormTableMap::COL_INTERVENTION_DATA)) {
            $criteria->add(SdohFormTableMap::COL_INTERVENTION_DATA, $this->intervention_data);
        }
        if ($this->isColumnModified(SdohFormTableMap::COL_STATUS)) {
            $criteria->add(SdohFormTableMap::COL_STATUS, $this->status);
        }
        if ($this->isColumnModified(SdohFormTableMap::COL_LAST_ADMIN_DOWNLOAD_TS)) {
            $criteria->add(SdohFormTableMap::COL_LAST_ADMIN_DOWNLOAD_TS, $this->last_admin_download_ts);
        }
        if ($this->isColumnModified(SdohFormTableMap::COL_LOG)) {
            $criteria->add(SdohFormTableMap::COL_LOG, $this->log);
        }
        if ($this->isColumnModified(SdohFormTableMap::COL_CREATED_TS)) {
            $criteria->add(SdohFormTableMap::COL_CREATED_TS, $this->created_ts);
        }
        if ($this->isColumnModified(SdohFormTableMap::COL_UPDATED_TS)) {
            $criteria->add(SdohFormTableMap::COL_UPDATED_TS, $this->updated_ts);
        }
        if ($this->isColumnModified(SdohFormTableMap::COL_VALID)) {
            $criteria->add(SdohFormTableMap::COL_VALID, $this->valid);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildSdohFormQuery::create();
        $criteria->add(SdohFormTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       string $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \EmiAdvisors\SdohForm (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setUserId($this->getUserId());
        $copyObj->setDomain($this->getDomain());
        $copyObj->setIdentifier($this->getIdentifier());
        $copyObj->setFormVersion($this->getFormVersion());
        $copyObj->setScreeningData($this->getScreeningData());
        $copyObj->setDiagnosesData($this->getDiagnosesData());
        $copyObj->setGoalsData($this->getGoalsData());
        $copyObj->setInterventionData($this->getInterventionData());
        $copyObj->setStatus($this->getStatus());
        $copyObj->setLastAdminDownloadTs($this->getLastAdminDownloadTs());
        $copyObj->setLog($this->getLog());
        $copyObj->setCreatedTs($this->getCreatedTs());
        $copyObj->setUpdatedTs($this->getUpdatedTs());
        $copyObj->setValid($this->getValid());
        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
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
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \EmiAdvisors\SdohForm Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->user_id = null;
        $this->domain = null;
        $this->identifier = null;
        $this->form_version = null;
        $this->screening_data = null;
        $this->diagnoses_data = null;
        $this->goals_data = null;
        $this->intervention_data = null;
        $this->status = null;
        $this->last_admin_download_ts = null;
        $this->log = null;
        $this->created_ts = null;
        $this->updated_ts = null;
        $this->valid = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
        } // if ($deep)

    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SdohFormTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
