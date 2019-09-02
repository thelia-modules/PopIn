<?php

namespace PopIn\Model\Base;

use \Exception;
use \PDO;
use PopIn\Model\PopInFreeContent as ChildPopInFreeContent;
use PopIn\Model\PopInFreeContentQuery as ChildPopInFreeContentQuery;
use PopIn\Model\Map\PopInFreeContentTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'pop_in_free_content' table.
 *
 *
 *
 * @method     ChildPopInFreeContentQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPopInFreeContentQuery orderByIdPopInCampaign($order = Criteria::ASC) Order by the id_pop_in_campaign column
 * @method     ChildPopInFreeContentQuery orderByTextFree($order = Criteria::ASC) Order by the text_free column
 * @method     ChildPopInFreeContentQuery orderByLink($order = Criteria::ASC) Order by the link column
 *
 * @method     ChildPopInFreeContentQuery groupById() Group by the id column
 * @method     ChildPopInFreeContentQuery groupByIdPopInCampaign() Group by the id_pop_in_campaign column
 * @method     ChildPopInFreeContentQuery groupByTextFree() Group by the text_free column
 * @method     ChildPopInFreeContentQuery groupByLink() Group by the link column
 *
 * @method     ChildPopInFreeContentQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPopInFreeContentQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPopInFreeContentQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPopInFreeContentQuery leftJoinPopInCampaign($relationAlias = null) Adds a LEFT JOIN clause to the query using the PopInCampaign relation
 * @method     ChildPopInFreeContentQuery rightJoinPopInCampaign($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PopInCampaign relation
 * @method     ChildPopInFreeContentQuery innerJoinPopInCampaign($relationAlias = null) Adds a INNER JOIN clause to the query using the PopInCampaign relation
 *
 * @method     ChildPopInFreeContent findOne(ConnectionInterface $con = null) Return the first ChildPopInFreeContent matching the query
 * @method     ChildPopInFreeContent findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPopInFreeContent matching the query, or a new ChildPopInFreeContent object populated from the query conditions when no match is found
 *
 * @method     ChildPopInFreeContent findOneById(int $id) Return the first ChildPopInFreeContent filtered by the id column
 * @method     ChildPopInFreeContent findOneByIdPopInCampaign(int $id_pop_in_campaign) Return the first ChildPopInFreeContent filtered by the id_pop_in_campaign column
 * @method     ChildPopInFreeContent findOneByTextFree(string $text_free) Return the first ChildPopInFreeContent filtered by the text_free column
 * @method     ChildPopInFreeContent findOneByLink(string $link) Return the first ChildPopInFreeContent filtered by the link column
 *
 * @method     array findById(int $id) Return ChildPopInFreeContent objects filtered by the id column
 * @method     array findByIdPopInCampaign(int $id_pop_in_campaign) Return ChildPopInFreeContent objects filtered by the id_pop_in_campaign column
 * @method     array findByTextFree(string $text_free) Return ChildPopInFreeContent objects filtered by the text_free column
 * @method     array findByLink(string $link) Return ChildPopInFreeContent objects filtered by the link column
 *
 */
abstract class PopInFreeContentQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \PopIn\Model\Base\PopInFreeContentQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\PopIn\\Model\\PopInFreeContent', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPopInFreeContentQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPopInFreeContentQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \PopIn\Model\PopInFreeContentQuery) {
            return $criteria;
        }
        $query = new \PopIn\Model\PopInFreeContentQuery();
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
     * @return ChildPopInFreeContent|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PopInFreeContentTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PopInFreeContentTableMap::DATABASE_NAME);
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
     * @return   ChildPopInFreeContent A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, ID_POP_IN_CAMPAIGN, TEXT_FREE, LINK FROM pop_in_free_content WHERE ID = :p0';
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
            $obj = new ChildPopInFreeContent();
            $obj->hydrate($row);
            PopInFreeContentTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPopInFreeContent|array|mixed the result, formatted by the current formatter
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
     * @return ChildPopInFreeContentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PopInFreeContentTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildPopInFreeContentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PopInFreeContentTableMap::ID, $keys, Criteria::IN);
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
     * @return ChildPopInFreeContentQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PopInFreeContentTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PopInFreeContentTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PopInFreeContentTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the id_pop_in_campaign column
     *
     * Example usage:
     * <code>
     * $query->filterByIdPopInCampaign(1234); // WHERE id_pop_in_campaign = 1234
     * $query->filterByIdPopInCampaign(array(12, 34)); // WHERE id_pop_in_campaign IN (12, 34)
     * $query->filterByIdPopInCampaign(array('min' => 12)); // WHERE id_pop_in_campaign > 12
     * </code>
     *
     * @see       filterByPopInCampaign()
     *
     * @param     mixed $idPopInCampaign The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPopInFreeContentQuery The current query, for fluid interface
     */
    public function filterByIdPopInCampaign($idPopInCampaign = null, $comparison = null)
    {
        if (is_array($idPopInCampaign)) {
            $useMinMax = false;
            if (isset($idPopInCampaign['min'])) {
                $this->addUsingAlias(PopInFreeContentTableMap::ID_POP_IN_CAMPAIGN, $idPopInCampaign['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idPopInCampaign['max'])) {
                $this->addUsingAlias(PopInFreeContentTableMap::ID_POP_IN_CAMPAIGN, $idPopInCampaign['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PopInFreeContentTableMap::ID_POP_IN_CAMPAIGN, $idPopInCampaign, $comparison);
    }

    /**
     * Filter the query on the text_free column
     *
     * Example usage:
     * <code>
     * $query->filterByTextFree('fooValue');   // WHERE text_free = 'fooValue'
     * $query->filterByTextFree('%fooValue%'); // WHERE text_free LIKE '%fooValue%'
     * </code>
     *
     * @param     string $textFree The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPopInFreeContentQuery The current query, for fluid interface
     */
    public function filterByTextFree($textFree = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($textFree)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $textFree)) {
                $textFree = str_replace('*', '%', $textFree);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PopInFreeContentTableMap::TEXT_FREE, $textFree, $comparison);
    }

    /**
     * Filter the query on the link column
     *
     * Example usage:
     * <code>
     * $query->filterByLink('fooValue');   // WHERE link = 'fooValue'
     * $query->filterByLink('%fooValue%'); // WHERE link LIKE '%fooValue%'
     * </code>
     *
     * @param     string $link The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPopInFreeContentQuery The current query, for fluid interface
     */
    public function filterByLink($link = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($link)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $link)) {
                $link = str_replace('*', '%', $link);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PopInFreeContentTableMap::LINK, $link, $comparison);
    }

    /**
     * Filter the query by a related \PopIn\Model\PopInCampaign object
     *
     * @param \PopIn\Model\PopInCampaign|ObjectCollection $popInCampaign The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPopInFreeContentQuery The current query, for fluid interface
     */
    public function filterByPopInCampaign($popInCampaign, $comparison = null)
    {
        if ($popInCampaign instanceof \PopIn\Model\PopInCampaign) {
            return $this
                ->addUsingAlias(PopInFreeContentTableMap::ID_POP_IN_CAMPAIGN, $popInCampaign->getId(), $comparison);
        } elseif ($popInCampaign instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PopInFreeContentTableMap::ID_POP_IN_CAMPAIGN, $popInCampaign->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPopInCampaign() only accepts arguments of type \PopIn\Model\PopInCampaign or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PopInCampaign relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildPopInFreeContentQuery The current query, for fluid interface
     */
    public function joinPopInCampaign($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PopInCampaign');

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
            $this->addJoinObject($join, 'PopInCampaign');
        }

        return $this;
    }

    /**
     * Use the PopInCampaign relation PopInCampaign object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PopIn\Model\PopInCampaignQuery A secondary query class using the current class as primary query
     */
    public function usePopInCampaignQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPopInCampaign($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PopInCampaign', '\PopIn\Model\PopInCampaignQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPopInFreeContent $popInFreeContent Object to remove from the list of results
     *
     * @return ChildPopInFreeContentQuery The current query, for fluid interface
     */
    public function prune($popInFreeContent = null)
    {
        if ($popInFreeContent) {
            $this->addUsingAlias(PopInFreeContentTableMap::ID, $popInFreeContent->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the pop_in_free_content table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PopInFreeContentTableMap::DATABASE_NAME);
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
            PopInFreeContentTableMap::clearInstancePool();
            PopInFreeContentTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildPopInFreeContent or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildPopInFreeContent object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PopInFreeContentTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PopInFreeContentTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        PopInFreeContentTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PopInFreeContentTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // PopInFreeContentQuery
