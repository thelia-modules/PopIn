<?php

namespace PopIn\Model\Base;

use \Exception;
use \PDO;
use PopIn\Model\PopInCampaign as ChildPopInCampaign;
use PopIn\Model\PopInCampaignQuery as ChildPopInCampaignQuery;
use PopIn\Model\Map\PopInCampaignTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'pop_in_campaign' table.
 *
 *
 *
 * @method     ChildPopInCampaignQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPopInCampaignQuery orderByStart($order = Criteria::ASC) Order by the start column
 * @method     ChildPopInCampaignQuery orderByEnd($order = Criteria::ASC) Order by the end column
 * @method     ChildPopInCampaignQuery orderByContentSourceType($order = Criteria::ASC) Order by the content_source_type column
 * @method     ChildPopInCampaignQuery orderByContentSourceId($order = Criteria::ASC) Order by the content_source_id column
 *
 * @method     ChildPopInCampaignQuery groupById() Group by the id column
 * @method     ChildPopInCampaignQuery groupByStart() Group by the start column
 * @method     ChildPopInCampaignQuery groupByEnd() Group by the end column
 * @method     ChildPopInCampaignQuery groupByContentSourceType() Group by the content_source_type column
 * @method     ChildPopInCampaignQuery groupByContentSourceId() Group by the content_source_id column
 *
 * @method     ChildPopInCampaignQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPopInCampaignQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPopInCampaignQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPopInCampaignQuery leftJoinPopInFreeContent($relationAlias = null) Adds a LEFT JOIN clause to the query using the PopInFreeContent relation
 * @method     ChildPopInCampaignQuery rightJoinPopInFreeContent($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PopInFreeContent relation
 * @method     ChildPopInCampaignQuery innerJoinPopInFreeContent($relationAlias = null) Adds a INNER JOIN clause to the query using the PopInFreeContent relation
 *
 * @method     ChildPopInCampaign findOne(ConnectionInterface $con = null) Return the first ChildPopInCampaign matching the query
 * @method     ChildPopInCampaign findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPopInCampaign matching the query, or a new ChildPopInCampaign object populated from the query conditions when no match is found
 *
 * @method     ChildPopInCampaign findOneById(int $id) Return the first ChildPopInCampaign filtered by the id column
 * @method     ChildPopInCampaign findOneByStart(string $start) Return the first ChildPopInCampaign filtered by the start column
 * @method     ChildPopInCampaign findOneByEnd(string $end) Return the first ChildPopInCampaign filtered by the end column
 * @method     ChildPopInCampaign findOneByContentSourceType(string $content_source_type) Return the first ChildPopInCampaign filtered by the content_source_type column
 * @method     ChildPopInCampaign findOneByContentSourceId(string $content_source_id) Return the first ChildPopInCampaign filtered by the content_source_id column
 *
 * @method     array findById(int $id) Return ChildPopInCampaign objects filtered by the id column
 * @method     array findByStart(string $start) Return ChildPopInCampaign objects filtered by the start column
 * @method     array findByEnd(string $end) Return ChildPopInCampaign objects filtered by the end column
 * @method     array findByContentSourceType(string $content_source_type) Return ChildPopInCampaign objects filtered by the content_source_type column
 * @method     array findByContentSourceId(string $content_source_id) Return ChildPopInCampaign objects filtered by the content_source_id column
 *
 */
abstract class PopInCampaignQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \PopIn\Model\Base\PopInCampaignQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\PopIn\\Model\\PopInCampaign', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPopInCampaignQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPopInCampaignQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \PopIn\Model\PopInCampaignQuery) {
            return $criteria;
        }
        $query = new \PopIn\Model\PopInCampaignQuery();
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
     * @return ChildPopInCampaign|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PopInCampaignTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PopInCampaignTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildPopInCampaign A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, START, END, CONTENT_SOURCE_TYPE, CONTENT_SOURCE_ID FROM pop_in_campaign WHERE ID = :p0';
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
            $obj = new ChildPopInCampaign();
            $obj->hydrate($row);
            PopInCampaignTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPopInCampaign|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
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
    public function findPks($keys, $con = null)
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
     * @return ChildPopInCampaignQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PopInCampaignTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildPopInCampaignQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PopInCampaignTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildPopInCampaignQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PopInCampaignTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PopInCampaignTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PopInCampaignTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the start column
     *
     * Example usage:
     * <code>
     * $query->filterByStart('2011-03-14'); // WHERE start = '2011-03-14'
     * $query->filterByStart('now'); // WHERE start = '2011-03-14'
     * $query->filterByStart(array('max' => 'yesterday')); // WHERE start > '2011-03-13'
     * </code>
     *
     * @param     mixed $start The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPopInCampaignQuery The current query, for fluid interface
     */
    public function filterByStart($start = null, $comparison = null)
    {
        if (is_array($start)) {
            $useMinMax = false;
            if (isset($start['min'])) {
                $this->addUsingAlias(PopInCampaignTableMap::START, $start['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($start['max'])) {
                $this->addUsingAlias(PopInCampaignTableMap::START, $start['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PopInCampaignTableMap::START, $start, $comparison);
    }

    /**
     * Filter the query on the end column
     *
     * Example usage:
     * <code>
     * $query->filterByEnd('2011-03-14'); // WHERE end = '2011-03-14'
     * $query->filterByEnd('now'); // WHERE end = '2011-03-14'
     * $query->filterByEnd(array('max' => 'yesterday')); // WHERE end > '2011-03-13'
     * </code>
     *
     * @param     mixed $end The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPopInCampaignQuery The current query, for fluid interface
     */
    public function filterByEnd($end = null, $comparison = null)
    {
        if (is_array($end)) {
            $useMinMax = false;
            if (isset($end['min'])) {
                $this->addUsingAlias(PopInCampaignTableMap::END, $end['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($end['max'])) {
                $this->addUsingAlias(PopInCampaignTableMap::END, $end['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PopInCampaignTableMap::END, $end, $comparison);
    }

    /**
     * Filter the query on the content_source_type column
     *
     * Example usage:
     * <code>
     * $query->filterByContentSourceType('fooValue');   // WHERE content_source_type = 'fooValue'
     * $query->filterByContentSourceType('%fooValue%'); // WHERE content_source_type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $contentSourceType The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPopInCampaignQuery The current query, for fluid interface
     */
    public function filterByContentSourceType($contentSourceType = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($contentSourceType)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $contentSourceType)) {
                $contentSourceType = str_replace('*', '%', $contentSourceType);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PopInCampaignTableMap::CONTENT_SOURCE_TYPE, $contentSourceType, $comparison);
    }

    /**
     * Filter the query on the content_source_id column
     *
     * Example usage:
     * <code>
     * $query->filterByContentSourceId('fooValue');   // WHERE content_source_id = 'fooValue'
     * $query->filterByContentSourceId('%fooValue%'); // WHERE content_source_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $contentSourceId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPopInCampaignQuery The current query, for fluid interface
     */
    public function filterByContentSourceId($contentSourceId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($contentSourceId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $contentSourceId)) {
                $contentSourceId = str_replace('*', '%', $contentSourceId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PopInCampaignTableMap::CONTENT_SOURCE_ID, $contentSourceId, $comparison);
    }

    /**
     * Filter the query by a related \PopIn\Model\PopInFreeContent object
     *
     * @param \PopIn\Model\PopInFreeContent|ObjectCollection $popInFreeContent  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPopInCampaignQuery The current query, for fluid interface
     */
    public function filterByPopInFreeContent($popInFreeContent, $comparison = null)
    {
        if ($popInFreeContent instanceof \PopIn\Model\PopInFreeContent) {
            return $this
                ->addUsingAlias(PopInCampaignTableMap::ID, $popInFreeContent->getIdPopInCampaign(), $comparison);
        } elseif ($popInFreeContent instanceof ObjectCollection) {
            return $this
                ->usePopInFreeContentQuery()
                ->filterByPrimaryKeys($popInFreeContent->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPopInFreeContent() only accepts arguments of type \PopIn\Model\PopInFreeContent or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PopInFreeContent relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildPopInCampaignQuery The current query, for fluid interface
     */
    public function joinPopInFreeContent($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PopInFreeContent');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'PopInFreeContent');
        }

        return $this;
    }

    /**
     * Use the PopInFreeContent relation PopInFreeContent object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PopIn\Model\PopInFreeContentQuery A secondary query class using the current class as primary query
     */
    public function usePopInFreeContentQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPopInFreeContent($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PopInFreeContent', '\PopIn\Model\PopInFreeContentQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPopInCampaign $popInCampaign Object to remove from the list of results
     *
     * @return ChildPopInCampaignQuery The current query, for fluid interface
     */
    public function prune($popInCampaign = null)
    {
        if ($popInCampaign) {
            $this->addUsingAlias(PopInCampaignTableMap::ID, $popInCampaign->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the pop_in_campaign table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PopInCampaignTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PopInCampaignTableMap::clearInstancePool();
            PopInCampaignTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildPopInCampaign or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildPopInCampaign object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PopInCampaignTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PopInCampaignTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        PopInCampaignTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PopInCampaignTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // PopInCampaignQuery
