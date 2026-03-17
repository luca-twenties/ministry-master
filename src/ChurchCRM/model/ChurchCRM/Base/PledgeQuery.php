<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Map\PledgeTableMap;
use ChurchCRM\model\ChurchCRM\Pledge as ChildPledge;
use ChurchCRM\model\ChurchCRM\PledgeQuery as ChildPledgeQuery;
use Exception;
use PDO;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\ActiveQuery\TypedModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Propel;

/**
 * Base class that represents a query for the `pledge_plg` table.
 *
 * This contains all payment/pledge information
 *
 * @method static orderById($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the plg_plgID column
 * @method static orderByFamId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the plg_FamID column
 * @method static orderByFyId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the plg_FYID column
 * @method static orderByDate($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the plg_date column
 * @method static orderByAmount($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the plg_amount column
 * @method static orderBySchedule($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the plg_schedule column
 * @method static orderByMethod($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the plg_method column
 * @method static orderByComment($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the plg_comment column
 * @method static orderByDateLastEdited($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the plg_DateLastEdited column
 * @method static orderByEditedBy($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the plg_EditedBy column
 * @method static orderByPledgeOrPayment($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the plg_PledgeOrPayment column
 * @method static orderByFundId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the plg_fundID column
 * @method static orderByDepId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the plg_depID column
 * @method static orderByCheckNo($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the plg_CheckNo column
 * @method static orderByProblem($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the plg_Problem column
 * @method static orderByScanString($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the plg_scanString column
 * @method static orderByAutId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the plg_aut_ID column
 * @method static orderByAutCleared($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the plg_aut_Cleared column
 * @method static orderByAutResultId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the plg_aut_ResultID column
 * @method static orderByNondeductible($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the plg_NonDeductible column
 * @method static orderByGroupKey($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the plg_GroupKey column
 *
 * @method static groupById() Group by the plg_plgID column
 * @method static groupByFamId() Group by the plg_FamID column
 * @method static groupByFyId() Group by the plg_FYID column
 * @method static groupByDate() Group by the plg_date column
 * @method static groupByAmount() Group by the plg_amount column
 * @method static groupBySchedule() Group by the plg_schedule column
 * @method static groupByMethod() Group by the plg_method column
 * @method static groupByComment() Group by the plg_comment column
 * @method static groupByDateLastEdited() Group by the plg_DateLastEdited column
 * @method static groupByEditedBy() Group by the plg_EditedBy column
 * @method static groupByPledgeOrPayment() Group by the plg_PledgeOrPayment column
 * @method static groupByFundId() Group by the plg_fundID column
 * @method static groupByDepId() Group by the plg_depID column
 * @method static groupByCheckNo() Group by the plg_CheckNo column
 * @method static groupByProblem() Group by the plg_Problem column
 * @method static groupByScanString() Group by the plg_scanString column
 * @method static groupByAutId() Group by the plg_aut_ID column
 * @method static groupByAutCleared() Group by the plg_aut_Cleared column
 * @method static groupByAutResultId() Group by the plg_aut_ResultID column
 * @method static groupByNondeductible() Group by the plg_NonDeductible column
 * @method static groupByGroupKey() Group by the plg_GroupKey column
 *
 * @method static leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method static rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method static innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method static leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method static rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method static innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method static leftJoinDeposit($relationAlias = null) Adds a LEFT JOIN clause to the query using the Deposit relation
 * @method static rightJoinDeposit($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Deposit relation
 * @method static innerJoinDeposit($relationAlias = null) Adds a INNER JOIN clause to the query using the Deposit relation
 *
 * @method static joinWithDeposit($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the Deposit relation
 *
 * @method static leftJoinWithDeposit() Adds a LEFT JOIN clause and with to the query using the Deposit relation
 * @method static rightJoinWithDeposit() Adds a RIGHT JOIN clause and with to the query using the Deposit relation
 * @method static innerJoinWithDeposit() Adds a INNER JOIN clause and with to the query using the Deposit relation
 *
 * @method static leftJoinDonationFund($relationAlias = null) Adds a LEFT JOIN clause to the query using the DonationFund relation
 * @method static rightJoinDonationFund($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DonationFund relation
 * @method static innerJoinDonationFund($relationAlias = null) Adds a INNER JOIN clause to the query using the DonationFund relation
 *
 * @method static joinWithDonationFund($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the DonationFund relation
 *
 * @method static leftJoinWithDonationFund() Adds a LEFT JOIN clause and with to the query using the DonationFund relation
 * @method static rightJoinWithDonationFund() Adds a RIGHT JOIN clause and with to the query using the DonationFund relation
 * @method static innerJoinWithDonationFund() Adds a INNER JOIN clause and with to the query using the DonationFund relation
 *
 * @method static leftJoinFamily($relationAlias = null) Adds a LEFT JOIN clause to the query using the Family relation
 * @method static rightJoinFamily($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Family relation
 * @method static innerJoinFamily($relationAlias = null) Adds a INNER JOIN clause to the query using the Family relation
 *
 * @method static joinWithFamily($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the Family relation
 *
 * @method static leftJoinWithFamily() Adds a LEFT JOIN clause and with to the query using the Family relation
 * @method static rightJoinWithFamily() Adds a RIGHT JOIN clause and with to the query using the Family relation
 * @method static innerJoinWithFamily() Adds a INNER JOIN clause and with to the query using the Family relation
 *
 * @method static leftJoinPerson($relationAlias = null) Adds a LEFT JOIN clause to the query using the Person relation
 * @method static rightJoinPerson($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Person relation
 * @method static innerJoinPerson($relationAlias = null) Adds a INNER JOIN clause to the query using the Person relation
 *
 * @method static joinWithPerson($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the Person relation
 *
 * @method static leftJoinWithPerson() Adds a LEFT JOIN clause and with to the query using the Person relation
 * @method static rightJoinWithPerson() Adds a RIGHT JOIN clause and with to the query using the Person relation
 * @method static innerJoinWithPerson() Adds a INNER JOIN clause and with to the query using the Person relation
 *
 * @method \ChurchCRM\model\ChurchCRM\Pledge|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Pledge matching the query
 * @method \ChurchCRM\model\ChurchCRM\Pledge findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Pledge matching the query, or a new \ChurchCRM\model\ChurchCRM\Pledge object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\Pledge|null findOneById(int $plg_plgID) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_plgID column
 * @method \ChurchCRM\model\ChurchCRM\Pledge|null findOneByFamId(int $plg_FamID) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_FamID column
 * @method \ChurchCRM\model\ChurchCRM\Pledge|null findOneByFyId(int $plg_FYID) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_FYID column
 * @method \ChurchCRM\model\ChurchCRM\Pledge|null findOneByDate(string $plg_date) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_date column
 * @method \ChurchCRM\model\ChurchCRM\Pledge|null findOneByAmount(string $plg_amount) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_amount column
 * @method \ChurchCRM\model\ChurchCRM\Pledge|null findOneBySchedule(string $plg_schedule) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_schedule column
 * @method \ChurchCRM\model\ChurchCRM\Pledge|null findOneByMethod(string $plg_method) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_method column
 * @method \ChurchCRM\model\ChurchCRM\Pledge|null findOneByComment(string $plg_comment) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_comment column
 * @method \ChurchCRM\model\ChurchCRM\Pledge|null findOneByDateLastEdited(string $plg_DateLastEdited) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_DateLastEdited column
 * @method \ChurchCRM\model\ChurchCRM\Pledge|null findOneByEditedBy(int $plg_EditedBy) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_EditedBy column
 * @method \ChurchCRM\model\ChurchCRM\Pledge|null findOneByPledgeOrPayment(string $plg_PledgeOrPayment) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_PledgeOrPayment column
 * @method \ChurchCRM\model\ChurchCRM\Pledge|null findOneByFundId(int $plg_fundID) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_fundID column
 * @method \ChurchCRM\model\ChurchCRM\Pledge|null findOneByDepId(int $plg_depID) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_depID column
 * @method \ChurchCRM\model\ChurchCRM\Pledge|null findOneByCheckNo(string $plg_CheckNo) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_CheckNo column
 * @method \ChurchCRM\model\ChurchCRM\Pledge|null findOneByProblem(bool $plg_Problem) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_Problem column
 * @method \ChurchCRM\model\ChurchCRM\Pledge|null findOneByScanString(string $plg_scanString) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_scanString column
 * @method \ChurchCRM\model\ChurchCRM\Pledge|null findOneByAutId(int $plg_aut_ID) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_aut_ID column
 * @method \ChurchCRM\model\ChurchCRM\Pledge|null findOneByAutCleared(bool $plg_aut_Cleared) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_aut_Cleared column
 * @method \ChurchCRM\model\ChurchCRM\Pledge|null findOneByAutResultId(int $plg_aut_ResultID) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_aut_ResultID column
 * @method \ChurchCRM\model\ChurchCRM\Pledge|null findOneByNondeductible(string $plg_NonDeductible) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_NonDeductible column
 * @method \ChurchCRM\model\ChurchCRM\Pledge|null findOneByGroupKey(string $plg_GroupKey) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_GroupKey column
 *
 * @method \ChurchCRM\model\ChurchCRM\Pledge requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\Pledge by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Pledge requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Pledge matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Pledge requireOneById(int $plg_plgID) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_plgID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Pledge requireOneByFamId(int $plg_FamID) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_FamID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Pledge requireOneByFyId(int $plg_FYID) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_FYID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Pledge requireOneByDate(string $plg_date) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Pledge requireOneByAmount(string $plg_amount) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_amount column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Pledge requireOneBySchedule(string $plg_schedule) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_schedule column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Pledge requireOneByMethod(string $plg_method) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_method column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Pledge requireOneByComment(string $plg_comment) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_comment column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Pledge requireOneByDateLastEdited(string $plg_DateLastEdited) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_DateLastEdited column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Pledge requireOneByEditedBy(int $plg_EditedBy) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_EditedBy column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Pledge requireOneByPledgeOrPayment(string $plg_PledgeOrPayment) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_PledgeOrPayment column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Pledge requireOneByFundId(int $plg_fundID) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_fundID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Pledge requireOneByDepId(int $plg_depID) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_depID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Pledge requireOneByCheckNo(string $plg_CheckNo) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_CheckNo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Pledge requireOneByProblem(bool $plg_Problem) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_Problem column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Pledge requireOneByScanString(string $plg_scanString) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_scanString column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Pledge requireOneByAutId(int $plg_aut_ID) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_aut_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Pledge requireOneByAutCleared(bool $plg_aut_Cleared) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_aut_Cleared column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Pledge requireOneByAutResultId(int $plg_aut_ResultID) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_aut_ResultID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Pledge requireOneByNondeductible(string $plg_NonDeductible) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_NonDeductible column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Pledge requireOneByGroupKey(string $plg_GroupKey) Return the first \ChurchCRM\model\ChurchCRM\Pledge filtered by the plg_GroupKey column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\PledgeCollection|array<\ChurchCRM\model\ChurchCRM\Pledge>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Pledge> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\Pledge objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\PledgeCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\Pledge objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\Pledge>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Pledge> findById(int|array<int> $plg_plgID) Return \ChurchCRM\model\ChurchCRM\Pledge objects filtered by the plg_plgID column
 * @method array<\ChurchCRM\model\ChurchCRM\Pledge>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Pledge> findByFamId(int|array<int> $plg_FamID) Return \ChurchCRM\model\ChurchCRM\Pledge objects filtered by the plg_FamID column
 * @method array<\ChurchCRM\model\ChurchCRM\Pledge>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Pledge> findByFyId(int|array<int> $plg_FYID) Return \ChurchCRM\model\ChurchCRM\Pledge objects filtered by the plg_FYID column
 * @method array<\ChurchCRM\model\ChurchCRM\Pledge>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Pledge> findByDate(string|array<string> $plg_date) Return \ChurchCRM\model\ChurchCRM\Pledge objects filtered by the plg_date column
 * @method array<\ChurchCRM\model\ChurchCRM\Pledge>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Pledge> findByAmount(string|array<string> $plg_amount) Return \ChurchCRM\model\ChurchCRM\Pledge objects filtered by the plg_amount column
 * @method array<\ChurchCRM\model\ChurchCRM\Pledge>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Pledge> findBySchedule(string|array<string> $plg_schedule) Return \ChurchCRM\model\ChurchCRM\Pledge objects filtered by the plg_schedule column
 * @method array<\ChurchCRM\model\ChurchCRM\Pledge>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Pledge> findByMethod(string|array<string> $plg_method) Return \ChurchCRM\model\ChurchCRM\Pledge objects filtered by the plg_method column
 * @method array<\ChurchCRM\model\ChurchCRM\Pledge>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Pledge> findByComment(string|array<string> $plg_comment) Return \ChurchCRM\model\ChurchCRM\Pledge objects filtered by the plg_comment column
 * @method array<\ChurchCRM\model\ChurchCRM\Pledge>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Pledge> findByDateLastEdited(string|array<string> $plg_DateLastEdited) Return \ChurchCRM\model\ChurchCRM\Pledge objects filtered by the plg_DateLastEdited column
 * @method array<\ChurchCRM\model\ChurchCRM\Pledge>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Pledge> findByEditedBy(int|array<int> $plg_EditedBy) Return \ChurchCRM\model\ChurchCRM\Pledge objects filtered by the plg_EditedBy column
 * @method array<\ChurchCRM\model\ChurchCRM\Pledge>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Pledge> findByPledgeOrPayment(string|array<string> $plg_PledgeOrPayment) Return \ChurchCRM\model\ChurchCRM\Pledge objects filtered by the plg_PledgeOrPayment column
 * @method array<\ChurchCRM\model\ChurchCRM\Pledge>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Pledge> findByFundId(int|array<int> $plg_fundID) Return \ChurchCRM\model\ChurchCRM\Pledge objects filtered by the plg_fundID column
 * @method array<\ChurchCRM\model\ChurchCRM\Pledge>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Pledge> findByDepId(int|array<int> $plg_depID) Return \ChurchCRM\model\ChurchCRM\Pledge objects filtered by the plg_depID column
 * @method array<\ChurchCRM\model\ChurchCRM\Pledge>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Pledge> findByCheckNo(string|array<string> $plg_CheckNo) Return \ChurchCRM\model\ChurchCRM\Pledge objects filtered by the plg_CheckNo column
 * @method array<\ChurchCRM\model\ChurchCRM\Pledge>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Pledge> findByProblem(bool|array<bool> $plg_Problem) Return \ChurchCRM\model\ChurchCRM\Pledge objects filtered by the plg_Problem column
 * @method array<\ChurchCRM\model\ChurchCRM\Pledge>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Pledge> findByScanString(string|array<string> $plg_scanString) Return \ChurchCRM\model\ChurchCRM\Pledge objects filtered by the plg_scanString column
 * @method array<\ChurchCRM\model\ChurchCRM\Pledge>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Pledge> findByAutId(int|array<int> $plg_aut_ID) Return \ChurchCRM\model\ChurchCRM\Pledge objects filtered by the plg_aut_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\Pledge>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Pledge> findByAutCleared(bool|array<bool> $plg_aut_Cleared) Return \ChurchCRM\model\ChurchCRM\Pledge objects filtered by the plg_aut_Cleared column
 * @method array<\ChurchCRM\model\ChurchCRM\Pledge>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Pledge> findByAutResultId(int|array<int> $plg_aut_ResultID) Return \ChurchCRM\model\ChurchCRM\Pledge objects filtered by the plg_aut_ResultID column
 * @method array<\ChurchCRM\model\ChurchCRM\Pledge>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Pledge> findByNondeductible(string|array<string> $plg_NonDeductible) Return \ChurchCRM\model\ChurchCRM\Pledge objects filtered by the plg_NonDeductible column
 * @method array<\ChurchCRM\model\ChurchCRM\Pledge>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Pledge> findByGroupKey(string|array<string> $plg_GroupKey) Return \ChurchCRM\model\ChurchCRM\Pledge objects filtered by the plg_GroupKey column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\Pledge>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class PledgeQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of PledgeQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\Pledge',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPledgeQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\PledgeQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildPledgeQuery) {
            return $criteria;
        }
        $query = new ChildPledgeQuery();
        if ($modelAlias !== null) {
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
     * $obj = $c->findPk(12, $con);
     * </code>
     *
     * @param int $key Primary key to use for the query
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con an optional connection object
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Pledge|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PledgeTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = (string)$key;
        $obj = PledgeTableMap::getInstanceFromPool($poolKey);
        if ($obj !== null) {
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param mixed $key Primary key to use for the query
     * @param \Propel\Runtime\Connection\ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return \ChurchCRM\model\ChurchCRM\Pledge|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildPledge
    {
        $sql = 'SELECT plg_plgID, plg_FamID, plg_FYID, plg_date, plg_amount, plg_schedule, plg_method, plg_comment, plg_DateLastEdited, plg_EditedBy, plg_PledgeOrPayment, plg_fundID, plg_depID, plg_CheckNo, plg_Problem, plg_scanString, plg_aut_ID, plg_aut_Cleared, plg_aut_ResultID, plg_NonDeductible, plg_GroupKey FROM pledge_plg WHERE plg_plgID = :p0';
        $stmt = $con->prepare($sql);
        if (is_bool($stmt)) {
            throw new PropelException('Failed to initialize statement');
        }
        $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
        try {
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);

            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;

        $row = $stmt->fetch(PDO::FETCH_NUM);
        if ($row) {
            $obj = new ChildPledge();
            $obj->hydrate($row);
            $poolKey = (string)$key;
            PledgeTableMap::addInstanceToPool($obj, $poolKey);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param mixed $key Primary key to use for the query
     * @param \Propel\Runtime\Connection\ConnectionInterface $con A connection object
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Pledge|mixed|array|null the result, formatted by the current formatter
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
     *
     * @param array $keys Primary keys to use for the query
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con an optional connection object
     *
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\Pledge>|mixed|array the list of results, formatted by the current formatter
     */
    public function findPks($keys, ?ConnectionInterface $con = null)
    {
        if (!$con) {
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
     * @param mixed $key Primary key to use for the query
     *
     * @return $this
     */
    public function filterByPrimaryKey($key)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('plg_plgID');
        $this->addUsingOperator($resolvedColumn, $key, Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param array $keys The list of primary key values to use for the query
     *
     * @return static
     */
    public function filterByPrimaryKeys(array $keys)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('plg_plgID');
        $this->addUsingOperator($resolvedColumn, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the plg_plgID column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE plg_plgID = 1234
     * $query->filterById(array(12, 34)); // WHERE plg_plgID IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE plg_plgID > 12
     * </code>
     *
     * @param mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterById($id = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('plg_plgID');
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingOperator($resolvedColumn, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingOperator($resolvedColumn, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $id, $comparison);

        return $this;
    }

    /**
     * Filter the query on the plg_FamID column
     *
     * Example usage:
     * <code>
     * $query->filterByFamId(1234); // WHERE plg_FamID = 1234
     * $query->filterByFamId(array(12, 34)); // WHERE plg_FamID IN (12, 34)
     * $query->filterByFamId(array('min' => 12)); // WHERE plg_FamID > 12
     * </code>
     *
     * @see static::filterByFamily()
     *
     * @param mixed $famId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByFamId($famId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('plg_FamID');
        if (is_array($famId)) {
            $useMinMax = false;
            if (isset($famId['min'])) {
                $this->addUsingOperator($resolvedColumn, $famId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($famId['max'])) {
                $this->addUsingOperator($resolvedColumn, $famId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $famId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the plg_FYID column
     *
     * Example usage:
     * <code>
     * $query->filterByFyId(1234); // WHERE plg_FYID = 1234
     * $query->filterByFyId(array(12, 34)); // WHERE plg_FYID IN (12, 34)
     * $query->filterByFyId(array('min' => 12)); // WHERE plg_FYID > 12
     * </code>
     *
     * @param mixed $fyId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByFyId($fyId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('plg_FYID');
        if (is_array($fyId)) {
            $useMinMax = false;
            if (isset($fyId['min'])) {
                $this->addUsingOperator($resolvedColumn, $fyId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fyId['max'])) {
                $this->addUsingOperator($resolvedColumn, $fyId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $fyId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the plg_date column
     *
     * Example usage:
     * <code>
     * $query->filterByDate('2011-03-14'); // WHERE plg_date = '2011-03-14'
     * $query->filterByDate('now'); // WHERE plg_date = '2011-03-14'
     * $query->filterByDate(array('max' => 'yesterday')); // WHERE plg_date > '2011-03-13'
     * </code>
     *
     * @param mixed $date The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByDate($date = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('plg_date');
        if (is_array($date)) {
            $useMinMax = false;
            if (isset($date['min'])) {
                $this->addUsingOperator($resolvedColumn, $date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($date['max'])) {
                $this->addUsingOperator($resolvedColumn, $date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $date, $comparison);

        return $this;
    }

    /**
     * Filter the query on the plg_amount column
     *
     * Example usage:
     * <code>
     * $query->filterByAmount(1234); // WHERE plg_amount = 1234
     * $query->filterByAmount(array(12, 34)); // WHERE plg_amount IN (12, 34)
     * $query->filterByAmount(array('min' => 12)); // WHERE plg_amount > 12
     * </code>
     *
     * @param mixed $amount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByAmount($amount = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('plg_amount');
        if (is_array($amount)) {
            $useMinMax = false;
            if (isset($amount['min'])) {
                $this->addUsingOperator($resolvedColumn, $amount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($amount['max'])) {
                $this->addUsingOperator($resolvedColumn, $amount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $amount, $comparison);

        return $this;
    }

    /**
     * Filter the query on the plg_schedule column
     *
     * Example usage:
     * <code>
     * $query->filterBySchedule('fooValue'); // WHERE plg_schedule = 'fooValue'
     * $query->filterBySchedule('%fooValue%', Criteria::LIKE); // WHERE plg_schedule LIKE '%fooValue%'
     * $query->filterBySchedule(['foo', 'bar']); // WHERE plg_schedule IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $schedule The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterBySchedule($schedule = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('plg_schedule');
        if ($comparison === null && is_array($schedule)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $schedule, $comparison);

        return $this;
    }

    /**
     * Filter the query on the plg_method column
     *
     * Example usage:
     * <code>
     * $query->filterByMethod('fooValue'); // WHERE plg_method = 'fooValue'
     * $query->filterByMethod('%fooValue%', Criteria::LIKE); // WHERE plg_method LIKE '%fooValue%'
     * $query->filterByMethod(['foo', 'bar']); // WHERE plg_method IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $method The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByMethod($method = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('plg_method');
        if ($comparison === null && is_array($method)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $method, $comparison);

        return $this;
    }

    /**
     * Filter the query on the plg_comment column
     *
     * Example usage:
     * <code>
     * $query->filterByComment('fooValue'); // WHERE plg_comment = 'fooValue'
     * $query->filterByComment('%fooValue%', Criteria::LIKE); // WHERE plg_comment LIKE '%fooValue%'
     * $query->filterByComment(['foo', 'bar']); // WHERE plg_comment IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $comment The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByComment($comment = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('plg_comment');
        if ($comparison === null && is_array($comment)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $comment, $comparison);

        return $this;
    }

    /**
     * Filter the query on the plg_DateLastEdited column
     *
     * Example usage:
     * <code>
     * $query->filterByDateLastEdited('2011-03-14'); // WHERE plg_DateLastEdited = '2011-03-14'
     * $query->filterByDateLastEdited('now'); // WHERE plg_DateLastEdited = '2011-03-14'
     * $query->filterByDateLastEdited(array('max' => 'yesterday')); // WHERE plg_DateLastEdited > '2011-03-13'
     * </code>
     *
     * @param mixed $dateLastEdited The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByDateLastEdited($dateLastEdited = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('plg_DateLastEdited');
        if (is_array($dateLastEdited)) {
            $useMinMax = false;
            if (isset($dateLastEdited['min'])) {
                $this->addUsingOperator($resolvedColumn, $dateLastEdited['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateLastEdited['max'])) {
                $this->addUsingOperator($resolvedColumn, $dateLastEdited['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $dateLastEdited, $comparison);

        return $this;
    }

    /**
     * Filter the query on the plg_EditedBy column
     *
     * Example usage:
     * <code>
     * $query->filterByEditedBy(1234); // WHERE plg_EditedBy = 1234
     * $query->filterByEditedBy(array(12, 34)); // WHERE plg_EditedBy IN (12, 34)
     * $query->filterByEditedBy(array('min' => 12)); // WHERE plg_EditedBy > 12
     * </code>
     *
     * @see static::filterByPerson()
     *
     * @param mixed $editedBy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByEditedBy($editedBy = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('plg_EditedBy');
        if (is_array($editedBy)) {
            $useMinMax = false;
            if (isset($editedBy['min'])) {
                $this->addUsingOperator($resolvedColumn, $editedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($editedBy['max'])) {
                $this->addUsingOperator($resolvedColumn, $editedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $editedBy, $comparison);

        return $this;
    }

    /**
     * Filter the query on the plg_PledgeOrPayment column
     *
     * Example usage:
     * <code>
     * $query->filterByPledgeOrPayment('fooValue'); // WHERE plg_PledgeOrPayment = 'fooValue'
     * $query->filterByPledgeOrPayment('%fooValue%', Criteria::LIKE); // WHERE plg_PledgeOrPayment LIKE '%fooValue%'
     * $query->filterByPledgeOrPayment(['foo', 'bar']); // WHERE plg_PledgeOrPayment IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $pledgeOrPayment The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByPledgeOrPayment($pledgeOrPayment = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('plg_PledgeOrPayment');
        if ($comparison === null && is_array($pledgeOrPayment)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $pledgeOrPayment, $comparison);

        return $this;
    }

    /**
     * Filter the query on the plg_fundID column
     *
     * Example usage:
     * <code>
     * $query->filterByFundId(1234); // WHERE plg_fundID = 1234
     * $query->filterByFundId(array(12, 34)); // WHERE plg_fundID IN (12, 34)
     * $query->filterByFundId(array('min' => 12)); // WHERE plg_fundID > 12
     * </code>
     *
     * @see static::filterByDonationFund()
     *
     * @param mixed $fundId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByFundId($fundId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('plg_fundID');
        if (is_array($fundId)) {
            $useMinMax = false;
            if (isset($fundId['min'])) {
                $this->addUsingOperator($resolvedColumn, $fundId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fundId['max'])) {
                $this->addUsingOperator($resolvedColumn, $fundId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $fundId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the plg_depID column
     *
     * Example usage:
     * <code>
     * $query->filterByDepId(1234); // WHERE plg_depID = 1234
     * $query->filterByDepId(array(12, 34)); // WHERE plg_depID IN (12, 34)
     * $query->filterByDepId(array('min' => 12)); // WHERE plg_depID > 12
     * </code>
     *
     * @see static::filterByDeposit()
     *
     * @param mixed $depId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByDepId($depId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('plg_depID');
        if (is_array($depId)) {
            $useMinMax = false;
            if (isset($depId['min'])) {
                $this->addUsingOperator($resolvedColumn, $depId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($depId['max'])) {
                $this->addUsingOperator($resolvedColumn, $depId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $depId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the plg_CheckNo column
     *
     * Example usage:
     * <code>
     * $query->filterByCheckNo(1234); // WHERE plg_CheckNo = 1234
     * $query->filterByCheckNo(array(12, 34)); // WHERE plg_CheckNo IN (12, 34)
     * $query->filterByCheckNo(array('min' => 12)); // WHERE plg_CheckNo > 12
     * </code>
     *
     * @param mixed $checkNo The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByCheckNo($checkNo = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('plg_CheckNo');
        if (is_array($checkNo)) {
            $useMinMax = false;
            if (isset($checkNo['min'])) {
                $this->addUsingOperator($resolvedColumn, $checkNo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($checkNo['max'])) {
                $this->addUsingOperator($resolvedColumn, $checkNo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $checkNo, $comparison);

        return $this;
    }

    /**
     * Filter the query on the plg_Problem column
     *
     * Example usage:
     * <code>
     * $query->filterByProblem(true); // WHERE plg_Problem = true
     * $query->filterByProblem('yes'); // WHERE plg_Problem = true
     * </code>
     *
     * @param string|bool|null $problem The value to use as filter.
     *      Non-boolean arguments are converted using the following rules:
     *          - 1, '1', 'true', 'on', and 'yes' are converted to boolean true
     *          - 0, '0', 'false', 'off', and 'no' are converted to boolean false
     *      Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByProblem($problem = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('plg_Problem');
        if (is_string($problem)) {
            $problem = in_array(strtolower($problem), ['false', 'off', '-', 'no', 'n', '0', ''], true) ? false : true;
        }
        $this->addUsingOperator($resolvedColumn, $problem, $comparison);

        return $this;
    }

    /**
     * Filter the query on the plg_scanString column
     *
     * Example usage:
     * <code>
     * $query->filterByScanString('fooValue'); // WHERE plg_scanString = 'fooValue'
     * $query->filterByScanString('%fooValue%', Criteria::LIKE); // WHERE plg_scanString LIKE '%fooValue%'
     * $query->filterByScanString(['foo', 'bar']); // WHERE plg_scanString IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $scanString The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByScanString($scanString = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('plg_scanString');
        if ($comparison === null && is_array($scanString)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $scanString, $comparison);

        return $this;
    }

    /**
     * Filter the query on the plg_aut_ID column
     *
     * Example usage:
     * <code>
     * $query->filterByAutId(1234); // WHERE plg_aut_ID = 1234
     * $query->filterByAutId(array(12, 34)); // WHERE plg_aut_ID IN (12, 34)
     * $query->filterByAutId(array('min' => 12)); // WHERE plg_aut_ID > 12
     * </code>
     *
     * @param mixed $autId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByAutId($autId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('plg_aut_ID');
        if (is_array($autId)) {
            $useMinMax = false;
            if (isset($autId['min'])) {
                $this->addUsingOperator($resolvedColumn, $autId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($autId['max'])) {
                $this->addUsingOperator($resolvedColumn, $autId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $autId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the plg_aut_Cleared column
     *
     * Example usage:
     * <code>
     * $query->filterByAutCleared(true); // WHERE plg_aut_Cleared = true
     * $query->filterByAutCleared('yes'); // WHERE plg_aut_Cleared = true
     * </code>
     *
     * @param string|bool|null $autCleared The value to use as filter.
     *      Non-boolean arguments are converted using the following rules:
     *          - 1, '1', 'true', 'on', and 'yes' are converted to boolean true
     *          - 0, '0', 'false', 'off', and 'no' are converted to boolean false
     *      Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByAutCleared($autCleared = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('plg_aut_Cleared');
        if (is_string($autCleared)) {
            $autCleared = in_array(strtolower($autCleared), ['false', 'off', '-', 'no', 'n', '0', ''], true) ? false : true;
        }
        $this->addUsingOperator($resolvedColumn, $autCleared, $comparison);

        return $this;
    }

    /**
     * Filter the query on the plg_aut_ResultID column
     *
     * Example usage:
     * <code>
     * $query->filterByAutResultId(1234); // WHERE plg_aut_ResultID = 1234
     * $query->filterByAutResultId(array(12, 34)); // WHERE plg_aut_ResultID IN (12, 34)
     * $query->filterByAutResultId(array('min' => 12)); // WHERE plg_aut_ResultID > 12
     * </code>
     *
     * @param mixed $autResultId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByAutResultId($autResultId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('plg_aut_ResultID');
        if (is_array($autResultId)) {
            $useMinMax = false;
            if (isset($autResultId['min'])) {
                $this->addUsingOperator($resolvedColumn, $autResultId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($autResultId['max'])) {
                $this->addUsingOperator($resolvedColumn, $autResultId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $autResultId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the plg_NonDeductible column
     *
     * Example usage:
     * <code>
     * $query->filterByNondeductible(1234); // WHERE plg_NonDeductible = 1234
     * $query->filterByNondeductible(array(12, 34)); // WHERE plg_NonDeductible IN (12, 34)
     * $query->filterByNondeductible(array('min' => 12)); // WHERE plg_NonDeductible > 12
     * </code>
     *
     * @param mixed $nondeductible The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByNondeductible($nondeductible = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('plg_NonDeductible');
        if (is_array($nondeductible)) {
            $useMinMax = false;
            if (isset($nondeductible['min'])) {
                $this->addUsingOperator($resolvedColumn, $nondeductible['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($nondeductible['max'])) {
                $this->addUsingOperator($resolvedColumn, $nondeductible['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $nondeductible, $comparison);

        return $this;
    }

    /**
     * Filter the query on the plg_GroupKey column
     *
     * Example usage:
     * <code>
     * $query->filterByGroupKey('fooValue'); // WHERE plg_GroupKey = 'fooValue'
     * $query->filterByGroupKey('%fooValue%', Criteria::LIKE); // WHERE plg_GroupKey LIKE '%fooValue%'
     * $query->filterByGroupKey(['foo', 'bar']); // WHERE plg_GroupKey IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $groupKey The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByGroupKey($groupKey = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('plg_GroupKey');
        if ($comparison === null && is_array($groupKey)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $groupKey, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related Deposit object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Deposit|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Deposit> $deposit The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return static
     */
    public function filterByDeposit($deposit, ?string $comparison = null)
    {
        if ($deposit instanceof Deposit) {
            return $this
                ->addUsingOperator($this->resolveLocalColumnByName('plg_depID'), $deposit->getId(), $comparison);
        } elseif ($deposit instanceof ObjectCollection) {
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingOperator($this->resolveLocalColumnByName('plg_depID'), $deposit->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByDeposit() only accepts arguments of type Deposit or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Deposit relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinDeposit(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Deposit');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $leftAlias = $this->useAliasInSQL ? $this->getModelAlias() : null;
        $join->setupJoinCondition($this, $relationMap, $leftAlias, $relationAlias);
        $previousJoin = $this->getPreviousJoin();
        if ($previousJoin instanceof ModelJoin) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Deposit');
        }

        return $this;
    }

    /**
     * Use the Deposit relation Deposit object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\DepositQuery<static> A secondary query class using the current class as primary query
     */
    public function useDepositQuery(?string $relationAlias = null, string $joinType = Criteria::LEFT_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\DepositQuery<static> $query */
        $query = $this->joinDeposit($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'Deposit', '\ChurchCRM\model\ChurchCRM\DepositQuery');

        return $query;
    }

    /**
     * Use the Deposit relation Deposit object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\DepositQuery<mixed>):\ChurchCRM\model\ChurchCRM\DepositQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withDepositQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useDepositQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Deposit table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\DepositQuery<static> The inner query object of the EXISTS statement
     */
    public function useDepositExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\DepositQuery<static> $q */
        $q = $this->useExistsQuery('Deposit', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to Deposit table for a NOT EXISTS query.
     *
     * @see useDepositExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\DepositQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function useDepositNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\DepositQuery<static> $q*/
        $q = $this->useExistsQuery('Deposit', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to Deposit table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\DepositQuery<static> The inner query object of the IN statement
     */
    public function useInDepositQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\DepositQuery<static> $q */
        $q = $this->useInQuery('Deposit', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to Deposit table for a NOT IN query.
     *
     * @see useDepositInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\DepositQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInDepositQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\DepositQuery<static> $q */
        $q = $this->useInQuery('Deposit', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
    }

    /**
     * Filter the query by a related DonationFund object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\DonationFund|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\DonationFund> $donationFund The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return static
     */
    public function filterByDonationFund($donationFund, ?string $comparison = null)
    {
        if ($donationFund instanceof DonationFund) {
            return $this
                ->addUsingOperator($this->resolveLocalColumnByName('plg_fundID'), $donationFund->getId(), $comparison);
        } elseif ($donationFund instanceof ObjectCollection) {
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingOperator($this->resolveLocalColumnByName('plg_fundID'), $donationFund->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByDonationFund() only accepts arguments of type DonationFund or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DonationFund relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinDonationFund(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DonationFund');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $leftAlias = $this->useAliasInSQL ? $this->getModelAlias() : null;
        $join->setupJoinCondition($this, $relationMap, $leftAlias, $relationAlias);
        $previousJoin = $this->getPreviousJoin();
        if ($previousJoin instanceof ModelJoin) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'DonationFund');
        }

        return $this;
    }

    /**
     * Use the DonationFund relation DonationFund object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\DonationFundQuery<static> A secondary query class using the current class as primary query
     */
    public function useDonationFundQuery(?string $relationAlias = null, string $joinType = Criteria::LEFT_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\DonationFundQuery<static> $query */
        $query = $this->joinDonationFund($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'DonationFund', '\ChurchCRM\model\ChurchCRM\DonationFundQuery');

        return $query;
    }

    /**
     * Use the DonationFund relation DonationFund object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\DonationFundQuery<mixed>):\ChurchCRM\model\ChurchCRM\DonationFundQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withDonationFundQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useDonationFundQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to DonationFund table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\DonationFundQuery<static> The inner query object of the EXISTS statement
     */
    public function useDonationFundExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\DonationFundQuery<static> $q */
        $q = $this->useExistsQuery('DonationFund', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to DonationFund table for a NOT EXISTS query.
     *
     * @see useDonationFundExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\DonationFundQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function useDonationFundNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\DonationFundQuery<static> $q*/
        $q = $this->useExistsQuery('DonationFund', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to DonationFund table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\DonationFundQuery<static> The inner query object of the IN statement
     */
    public function useInDonationFundQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\DonationFundQuery<static> $q */
        $q = $this->useInQuery('DonationFund', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to DonationFund table for a NOT IN query.
     *
     * @see useDonationFundInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\DonationFundQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInDonationFundQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\DonationFundQuery<static> $q */
        $q = $this->useInQuery('DonationFund', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
    }

    /**
     * Filter the query by a related Family object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Family|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Family> $family The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return static
     */
    public function filterByFamily($family, ?string $comparison = null)
    {
        if ($family instanceof Family) {
            return $this
                ->addUsingOperator($this->resolveLocalColumnByName('plg_FamID'), $family->getId(), $comparison);
        } elseif ($family instanceof ObjectCollection) {
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingOperator($this->resolveLocalColumnByName('plg_FamID'), $family->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByFamily() only accepts arguments of type Family or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Family relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinFamily(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Family');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $leftAlias = $this->useAliasInSQL ? $this->getModelAlias() : null;
        $join->setupJoinCondition($this, $relationMap, $leftAlias, $relationAlias);
        $previousJoin = $this->getPreviousJoin();
        if ($previousJoin instanceof ModelJoin) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Family');
        }

        return $this;
    }

    /**
     * Use the Family relation Family object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\FamilyQuery<static> A secondary query class using the current class as primary query
     */
    public function useFamilyQuery(?string $relationAlias = null, string $joinType = Criteria::LEFT_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\FamilyQuery<static> $query */
        $query = $this->joinFamily($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'Family', '\ChurchCRM\model\ChurchCRM\FamilyQuery');

        return $query;
    }

    /**
     * Use the Family relation Family object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\FamilyQuery<mixed>):\ChurchCRM\model\ChurchCRM\FamilyQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withFamilyQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useFamilyQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Family table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\FamilyQuery<static> The inner query object of the EXISTS statement
     */
    public function useFamilyExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\FamilyQuery<static> $q */
        $q = $this->useExistsQuery('Family', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to Family table for a NOT EXISTS query.
     *
     * @see useFamilyExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\FamilyQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function useFamilyNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\FamilyQuery<static> $q*/
        $q = $this->useExistsQuery('Family', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to Family table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\FamilyQuery<static> The inner query object of the IN statement
     */
    public function useInFamilyQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\FamilyQuery<static> $q */
        $q = $this->useInQuery('Family', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to Family table for a NOT IN query.
     *
     * @see useFamilyInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\FamilyQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInFamilyQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\FamilyQuery<static> $q */
        $q = $this->useInQuery('Family', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
    }

    /**
     * Filter the query by a related Person object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Person|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Person> $person The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return static
     */
    public function filterByPerson($person, ?string $comparison = null)
    {
        if ($person instanceof Person) {
            return $this
                ->addUsingOperator($this->resolveLocalColumnByName('plg_EditedBy'), $person->getId(), $comparison);
        } elseif ($person instanceof ObjectCollection) {
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingOperator($this->resolveLocalColumnByName('plg_EditedBy'), $person->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByPerson() only accepts arguments of type Person or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Person relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinPerson(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Person');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $leftAlias = $this->useAliasInSQL ? $this->getModelAlias() : null;
        $join->setupJoinCondition($this, $relationMap, $leftAlias, $relationAlias);
        $previousJoin = $this->getPreviousJoin();
        if ($previousJoin instanceof ModelJoin) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Person');
        }

        return $this;
    }

    /**
     * Use the Person relation Person object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\PersonQuery<static> A secondary query class using the current class as primary query
     */
    public function usePersonQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PersonQuery<static> $query */
        $query = $this->joinPerson($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'Person', '\ChurchCRM\model\ChurchCRM\PersonQuery');

        return $query;
    }

    /**
     * Use the Person relation Person object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\PersonQuery<mixed>):\ChurchCRM\model\ChurchCRM\PersonQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withPersonQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->usePersonQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Person table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\PersonQuery<static> The inner query object of the EXISTS statement
     */
    public function usePersonExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\PersonQuery<static> $q */
        $q = $this->useExistsQuery('Person', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to Person table for a NOT EXISTS query.
     *
     * @see usePersonExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\PersonQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function usePersonNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PersonQuery<static> $q*/
        $q = $this->useExistsQuery('Person', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to Person table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\PersonQuery<static> The inner query object of the IN statement
     */
    public function useInPersonQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PersonQuery<static> $q */
        $q = $this->useInQuery('Person', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to Person table for a NOT IN query.
     *
     * @see usePersonInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\PersonQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInPersonQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PersonQuery<static> $q */
        $q = $this->useInQuery('Person', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param \ChurchCRM\model\ChurchCRM\Pledge|null $pledge Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildPledge $pledge = null)
    {
        if ($pledge) {
            $resolvedColumn = $this->resolveLocalColumnByName('plg_plgID');
            $this->addUsingOperator($resolvedColumn, $pledge->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the pledge_plg table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PledgeTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PledgeTableMap::clearInstancePool();
            PledgeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver). This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     */
    public function delete(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PledgeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PledgeTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PledgeTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            PledgeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
