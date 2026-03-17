<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Map\PersonTableMap;
use ChurchCRM\model\ChurchCRM\Person as ChildPerson;
use ChurchCRM\model\ChurchCRM\PersonQuery as ChildPersonQuery;
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
 * Base class that represents a query for the `person_per` table.
 *
 * This contains the main person data, including person names, person addresses, person phone numbers, and foreign keys to the family table
 *
 * @method static orderById($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_ID column
 * @method static orderByTitle($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_Title column
 * @method static orderByFirstName($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_FirstName column
 * @method static orderByMiddleName($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_MiddleName column
 * @method static orderByLastName($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_LastName column
 * @method static orderBySuffix($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_Suffix column
 * @method static orderByAddress1($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_Address1 column
 * @method static orderByAddress2($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_Address2 column
 * @method static orderByCity($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_City column
 * @method static orderByState($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_State column
 * @method static orderByZip($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_Zip column
 * @method static orderByCountry($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_Country column
 * @method static orderByHomePhone($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_HomePhone column
 * @method static orderByWorkPhone($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_WorkPhone column
 * @method static orderByCellPhone($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_CellPhone column
 * @method static orderByEmail($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_Email column
 * @method static orderByWorkEmail($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_WorkEmail column
 * @method static orderByBirthMonth($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_BirthMonth column
 * @method static orderByBirthDay($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_BirthDay column
 * @method static orderByBirthYear($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_BirthYear column
 * @method static orderByMembershipDate($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_MembershipDate column
 * @method static orderByGender($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_Gender column
 * @method static orderByFmrId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_fmr_ID column
 * @method static orderByClsId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_cls_ID column
 * @method static orderByFamId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_fam_ID column
 * @method static orderByEnvelope($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_Envelope column
 * @method static orderByDateLastEdited($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_DateLastEdited column
 * @method static orderByDateEntered($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_DateEntered column
 * @method static orderByEnteredBy($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_EnteredBy column
 * @method static orderByEditedBy($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_EditedBy column
 * @method static orderByFriendDate($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_FriendDate column
 * @method static orderByFlags($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_Flags column
 * @method static orderByFacebook($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_Facebook column
 * @method static orderByTwitter($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_Twitter column
 * @method static orderByLinkedIn($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the per_LinkedIn column
 *
 * @method static groupById() Group by the per_ID column
 * @method static groupByTitle() Group by the per_Title column
 * @method static groupByFirstName() Group by the per_FirstName column
 * @method static groupByMiddleName() Group by the per_MiddleName column
 * @method static groupByLastName() Group by the per_LastName column
 * @method static groupBySuffix() Group by the per_Suffix column
 * @method static groupByAddress1() Group by the per_Address1 column
 * @method static groupByAddress2() Group by the per_Address2 column
 * @method static groupByCity() Group by the per_City column
 * @method static groupByState() Group by the per_State column
 * @method static groupByZip() Group by the per_Zip column
 * @method static groupByCountry() Group by the per_Country column
 * @method static groupByHomePhone() Group by the per_HomePhone column
 * @method static groupByWorkPhone() Group by the per_WorkPhone column
 * @method static groupByCellPhone() Group by the per_CellPhone column
 * @method static groupByEmail() Group by the per_Email column
 * @method static groupByWorkEmail() Group by the per_WorkEmail column
 * @method static groupByBirthMonth() Group by the per_BirthMonth column
 * @method static groupByBirthDay() Group by the per_BirthDay column
 * @method static groupByBirthYear() Group by the per_BirthYear column
 * @method static groupByMembershipDate() Group by the per_MembershipDate column
 * @method static groupByGender() Group by the per_Gender column
 * @method static groupByFmrId() Group by the per_fmr_ID column
 * @method static groupByClsId() Group by the per_cls_ID column
 * @method static groupByFamId() Group by the per_fam_ID column
 * @method static groupByEnvelope() Group by the per_Envelope column
 * @method static groupByDateLastEdited() Group by the per_DateLastEdited column
 * @method static groupByDateEntered() Group by the per_DateEntered column
 * @method static groupByEnteredBy() Group by the per_EnteredBy column
 * @method static groupByEditedBy() Group by the per_EditedBy column
 * @method static groupByFriendDate() Group by the per_FriendDate column
 * @method static groupByFlags() Group by the per_Flags column
 * @method static groupByFacebook() Group by the per_Facebook column
 * @method static groupByTwitter() Group by the per_Twitter column
 * @method static groupByLinkedIn() Group by the per_LinkedIn column
 *
 * @method static leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method static rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method static innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method static leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method static rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method static innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
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
 * @method static leftJoinWhyCame($relationAlias = null) Adds a LEFT JOIN clause to the query using the WhyCame relation
 * @method static rightJoinWhyCame($relationAlias = null) Adds a RIGHT JOIN clause to the query using the WhyCame relation
 * @method static innerJoinWhyCame($relationAlias = null) Adds a INNER JOIN clause to the query using the WhyCame relation
 *
 * @method static joinWithWhyCame($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the WhyCame relation
 *
 * @method static leftJoinWithWhyCame() Adds a LEFT JOIN clause and with to the query using the WhyCame relation
 * @method static rightJoinWithWhyCame() Adds a RIGHT JOIN clause and with to the query using the WhyCame relation
 * @method static innerJoinWithWhyCame() Adds a INNER JOIN clause and with to the query using the WhyCame relation
 *
 * @method static leftJoinPersonCustom($relationAlias = null) Adds a LEFT JOIN clause to the query using the PersonCustom relation
 * @method static rightJoinPersonCustom($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PersonCustom relation
 * @method static innerJoinPersonCustom($relationAlias = null) Adds a INNER JOIN clause to the query using the PersonCustom relation
 *
 * @method static joinWithPersonCustom($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the PersonCustom relation
 *
 * @method static leftJoinWithPersonCustom() Adds a LEFT JOIN clause and with to the query using the PersonCustom relation
 * @method static rightJoinWithPersonCustom() Adds a RIGHT JOIN clause and with to the query using the PersonCustom relation
 * @method static innerJoinWithPersonCustom() Adds a INNER JOIN clause and with to the query using the PersonCustom relation
 *
 * @method static leftJoinNote($relationAlias = null) Adds a LEFT JOIN clause to the query using the Note relation
 * @method static rightJoinNote($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Note relation
 * @method static innerJoinNote($relationAlias = null) Adds a INNER JOIN clause to the query using the Note relation
 *
 * @method static joinWithNote($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the Note relation
 *
 * @method static leftJoinWithNote() Adds a LEFT JOIN clause and with to the query using the Note relation
 * @method static rightJoinWithNote() Adds a RIGHT JOIN clause and with to the query using the Note relation
 * @method static innerJoinWithNote() Adds a INNER JOIN clause and with to the query using the Note relation
 *
 * @method static leftJoinPerson2group2roleP2g2r($relationAlias = null) Adds a LEFT JOIN clause to the query using the Person2group2roleP2g2r relation
 * @method static rightJoinPerson2group2roleP2g2r($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Person2group2roleP2g2r relation
 * @method static innerJoinPerson2group2roleP2g2r($relationAlias = null) Adds a INNER JOIN clause to the query using the Person2group2roleP2g2r relation
 *
 * @method static joinWithPerson2group2roleP2g2r($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the Person2group2roleP2g2r relation
 *
 * @method static leftJoinWithPerson2group2roleP2g2r() Adds a LEFT JOIN clause and with to the query using the Person2group2roleP2g2r relation
 * @method static rightJoinWithPerson2group2roleP2g2r() Adds a RIGHT JOIN clause and with to the query using the Person2group2roleP2g2r relation
 * @method static innerJoinWithPerson2group2roleP2g2r() Adds a INNER JOIN clause and with to the query using the Person2group2roleP2g2r relation
 *
 * @method static leftJoinEventAttend($relationAlias = null) Adds a LEFT JOIN clause to the query using the EventAttend relation
 * @method static rightJoinEventAttend($relationAlias = null) Adds a RIGHT JOIN clause to the query using the EventAttend relation
 * @method static innerJoinEventAttend($relationAlias = null) Adds a INNER JOIN clause to the query using the EventAttend relation
 *
 * @method static joinWithEventAttend($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the EventAttend relation
 *
 * @method static leftJoinWithEventAttend() Adds a LEFT JOIN clause and with to the query using the EventAttend relation
 * @method static rightJoinWithEventAttend() Adds a RIGHT JOIN clause and with to the query using the EventAttend relation
 * @method static innerJoinWithEventAttend() Adds a INNER JOIN clause and with to the query using the EventAttend relation
 *
 * @method static leftJoinPrimaryContactPerson($relationAlias = null) Adds a LEFT JOIN clause to the query using the PrimaryContactPerson relation
 * @method static rightJoinPrimaryContactPerson($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PrimaryContactPerson relation
 * @method static innerJoinPrimaryContactPerson($relationAlias = null) Adds a INNER JOIN clause to the query using the PrimaryContactPerson relation
 *
 * @method static joinWithPrimaryContactPerson($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the PrimaryContactPerson relation
 *
 * @method static leftJoinWithPrimaryContactPerson() Adds a LEFT JOIN clause and with to the query using the PrimaryContactPerson relation
 * @method static rightJoinWithPrimaryContactPerson() Adds a RIGHT JOIN clause and with to the query using the PrimaryContactPerson relation
 * @method static innerJoinWithPrimaryContactPerson() Adds a INNER JOIN clause and with to the query using the PrimaryContactPerson relation
 *
 * @method static leftJoinSecondaryContactPerson($relationAlias = null) Adds a LEFT JOIN clause to the query using the SecondaryContactPerson relation
 * @method static rightJoinSecondaryContactPerson($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SecondaryContactPerson relation
 * @method static innerJoinSecondaryContactPerson($relationAlias = null) Adds a INNER JOIN clause to the query using the SecondaryContactPerson relation
 *
 * @method static joinWithSecondaryContactPerson($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the SecondaryContactPerson relation
 *
 * @method static leftJoinWithSecondaryContactPerson() Adds a LEFT JOIN clause and with to the query using the SecondaryContactPerson relation
 * @method static rightJoinWithSecondaryContactPerson() Adds a RIGHT JOIN clause and with to the query using the SecondaryContactPerson relation
 * @method static innerJoinWithSecondaryContactPerson() Adds a INNER JOIN clause and with to the query using the SecondaryContactPerson relation
 *
 * @method static leftJoinPledge($relationAlias = null) Adds a LEFT JOIN clause to the query using the Pledge relation
 * @method static rightJoinPledge($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Pledge relation
 * @method static innerJoinPledge($relationAlias = null) Adds a INNER JOIN clause to the query using the Pledge relation
 *
 * @method static joinWithPledge($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the Pledge relation
 *
 * @method static leftJoinWithPledge() Adds a LEFT JOIN clause and with to the query using the Pledge relation
 * @method static rightJoinWithPledge() Adds a RIGHT JOIN clause and with to the query using the Pledge relation
 * @method static innerJoinWithPledge() Adds a INNER JOIN clause and with to the query using the Pledge relation
 *
 * @method static leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method static rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method static innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method static joinWithUser($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the User relation
 *
 * @method static leftJoinWithUser() Adds a LEFT JOIN clause and with to the query using the User relation
 * @method static rightJoinWithUser() Adds a RIGHT JOIN clause and with to the query using the User relation
 * @method static innerJoinWithUser() Adds a INNER JOIN clause and with to the query using the User relation
 *
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Person matching the query
 * @method \ChurchCRM\model\ChurchCRM\Person findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Person matching the query, or a new \ChurchCRM\model\ChurchCRM\Person object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneById(int $per_ID) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_ID column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByTitle(string $per_Title) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_Title column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByFirstName(string $per_FirstName) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_FirstName column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByMiddleName(string $per_MiddleName) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_MiddleName column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByLastName(string $per_LastName) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_LastName column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneBySuffix(string $per_Suffix) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_Suffix column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByAddress1(string $per_Address1) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_Address1 column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByAddress2(string $per_Address2) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_Address2 column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByCity(string $per_City) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_City column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByState(string $per_State) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_State column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByZip(string $per_Zip) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_Zip column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByCountry(string $per_Country) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_Country column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByHomePhone(string $per_HomePhone) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_HomePhone column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByWorkPhone(string $per_WorkPhone) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_WorkPhone column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByCellPhone(string $per_CellPhone) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_CellPhone column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByEmail(string $per_Email) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_Email column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByWorkEmail(string $per_WorkEmail) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_WorkEmail column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByBirthMonth(int $per_BirthMonth) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_BirthMonth column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByBirthDay(int $per_BirthDay) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_BirthDay column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByBirthYear(int $per_BirthYear) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_BirthYear column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByMembershipDate(string $per_MembershipDate) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_MembershipDate column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByGender(int $per_Gender) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_Gender column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByFmrId(int $per_fmr_ID) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_fmr_ID column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByClsId(int $per_cls_ID) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_cls_ID column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByFamId(int $per_fam_ID) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_fam_ID column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByEnvelope(int $per_Envelope) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_Envelope column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByDateLastEdited(string $per_DateLastEdited) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_DateLastEdited column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByDateEntered(string $per_DateEntered) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_DateEntered column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByEnteredBy(int $per_EnteredBy) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_EnteredBy column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByEditedBy(int $per_EditedBy) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_EditedBy column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByFriendDate(string $per_FriendDate) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_FriendDate column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByFlags(int $per_Flags) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_Flags column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByFacebook(string $per_Facebook) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_Facebook column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByTwitter(string $per_Twitter) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_Twitter column
 * @method \ChurchCRM\model\ChurchCRM\Person|null findOneByLinkedIn(string $per_LinkedIn) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_LinkedIn column
 *
 * @method \ChurchCRM\model\ChurchCRM\Person requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\Person by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Person matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneById(int $per_ID) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByTitle(string $per_Title) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_Title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByFirstName(string $per_FirstName) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_FirstName column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByMiddleName(string $per_MiddleName) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_MiddleName column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByLastName(string $per_LastName) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_LastName column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneBySuffix(string $per_Suffix) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_Suffix column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByAddress1(string $per_Address1) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_Address1 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByAddress2(string $per_Address2) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_Address2 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByCity(string $per_City) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_City column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByState(string $per_State) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_State column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByZip(string $per_Zip) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_Zip column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByCountry(string $per_Country) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_Country column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByHomePhone(string $per_HomePhone) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_HomePhone column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByWorkPhone(string $per_WorkPhone) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_WorkPhone column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByCellPhone(string $per_CellPhone) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_CellPhone column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByEmail(string $per_Email) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_Email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByWorkEmail(string $per_WorkEmail) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_WorkEmail column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByBirthMonth(int $per_BirthMonth) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_BirthMonth column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByBirthDay(int $per_BirthDay) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_BirthDay column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByBirthYear(int $per_BirthYear) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_BirthYear column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByMembershipDate(string $per_MembershipDate) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_MembershipDate column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByGender(int $per_Gender) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_Gender column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByFmrId(int $per_fmr_ID) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_fmr_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByClsId(int $per_cls_ID) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_cls_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByFamId(int $per_fam_ID) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_fam_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByEnvelope(int $per_Envelope) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_Envelope column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByDateLastEdited(string $per_DateLastEdited) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_DateLastEdited column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByDateEntered(string $per_DateEntered) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_DateEntered column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByEnteredBy(int $per_EnteredBy) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_EnteredBy column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByEditedBy(int $per_EditedBy) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_EditedBy column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByFriendDate(string $per_FriendDate) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_FriendDate column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByFlags(int $per_Flags) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_Flags column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByFacebook(string $per_Facebook) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_Facebook column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByTwitter(string $per_Twitter) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_Twitter column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Person requireOneByLinkedIn(string $per_LinkedIn) Return the first \ChurchCRM\model\ChurchCRM\Person filtered by the per_LinkedIn column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\PersonCollection|array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\Person objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\PersonCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\Person objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findById(int|array<int> $per_ID) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByTitle(string|array<string> $per_Title) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_Title column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByFirstName(string|array<string> $per_FirstName) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_FirstName column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByMiddleName(string|array<string> $per_MiddleName) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_MiddleName column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByLastName(string|array<string> $per_LastName) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_LastName column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findBySuffix(string|array<string> $per_Suffix) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_Suffix column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByAddress1(string|array<string> $per_Address1) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_Address1 column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByAddress2(string|array<string> $per_Address2) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_Address2 column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByCity(string|array<string> $per_City) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_City column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByState(string|array<string> $per_State) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_State column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByZip(string|array<string> $per_Zip) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_Zip column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByCountry(string|array<string> $per_Country) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_Country column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByHomePhone(string|array<string> $per_HomePhone) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_HomePhone column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByWorkPhone(string|array<string> $per_WorkPhone) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_WorkPhone column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByCellPhone(string|array<string> $per_CellPhone) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_CellPhone column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByEmail(string|array<string> $per_Email) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_Email column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByWorkEmail(string|array<string> $per_WorkEmail) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_WorkEmail column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByBirthMonth(int|array<int> $per_BirthMonth) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_BirthMonth column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByBirthDay(int|array<int> $per_BirthDay) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_BirthDay column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByBirthYear(int|array<int> $per_BirthYear) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_BirthYear column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByMembershipDate(string|array<string> $per_MembershipDate) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_MembershipDate column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByGender(int|array<int> $per_Gender) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_Gender column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByFmrId(int|array<int> $per_fmr_ID) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_fmr_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByClsId(int|array<int> $per_cls_ID) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_cls_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByFamId(int|array<int> $per_fam_ID) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_fam_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByEnvelope(int|array<int> $per_Envelope) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_Envelope column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByDateLastEdited(string|array<string> $per_DateLastEdited) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_DateLastEdited column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByDateEntered(string|array<string> $per_DateEntered) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_DateEntered column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByEnteredBy(int|array<int> $per_EnteredBy) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_EnteredBy column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByEditedBy(int|array<int> $per_EditedBy) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_EditedBy column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByFriendDate(string|array<string> $per_FriendDate) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_FriendDate column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByFlags(int|array<int> $per_Flags) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_Flags column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByFacebook(string|array<string> $per_Facebook) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_Facebook column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByTwitter(string|array<string> $per_Twitter) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_Twitter column
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Person> findByLinkedIn(string|array<string> $per_LinkedIn) Return \ChurchCRM\model\ChurchCRM\Person objects filtered by the per_LinkedIn column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\Person>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class PersonQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of PersonQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\Person',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPersonQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\PersonQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildPersonQuery) {
            return $criteria;
        }
        $query = new ChildPersonQuery();
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
     * @return \ChurchCRM\model\ChurchCRM\Base\Person|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PersonTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = (string)$key;
        $obj = PersonTableMap::getInstanceFromPool($poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Person|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildPerson
    {
        $sql = 'SELECT per_ID, per_Title, per_FirstName, per_MiddleName, per_LastName, per_Suffix, per_Address1, per_Address2, per_City, per_State, per_Zip, per_Country, per_HomePhone, per_WorkPhone, per_CellPhone, per_Email, per_WorkEmail, per_BirthMonth, per_BirthDay, per_BirthYear, per_MembershipDate, per_Gender, per_fmr_ID, per_cls_ID, per_fam_ID, per_Envelope, per_DateLastEdited, per_DateEntered, per_EnteredBy, per_EditedBy, per_FriendDate, per_Flags, per_Facebook, per_Twitter, per_LinkedIn FROM person_per WHERE per_ID = :p0';
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
            $obj = new ChildPerson();
            $obj->hydrate($row);
            $poolKey = (string)$key;
            PersonTableMap::addInstanceToPool($obj, $poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Base\Person|mixed|array|null the result, formatted by the current formatter
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
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\Person>|mixed|array the list of results, formatted by the current formatter
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
        $resolvedColumn = $this->resolveLocalColumnByName('per_ID');
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
        $resolvedColumn = $this->resolveLocalColumnByName('per_ID');
        $this->addUsingOperator($resolvedColumn, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the per_ID column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE per_ID = 1234
     * $query->filterById(array(12, 34)); // WHERE per_ID IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE per_ID > 12
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
        $resolvedColumn = $this->resolveLocalColumnByName('per_ID');
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
     * Filter the query on the per_Title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue'); // WHERE per_Title = 'fooValue'
     * $query->filterByTitle('%fooValue%', Criteria::LIKE); // WHERE per_Title LIKE '%fooValue%'
     * $query->filterByTitle(['foo', 'bar']); // WHERE per_Title IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $title The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByTitle($title = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('per_Title');
        if ($comparison === null && is_array($title)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $title, $comparison);

        return $this;
    }

    /**
     * Filter the query on the per_FirstName column
     *
     * Example usage:
     * <code>
     * $query->filterByFirstName('fooValue'); // WHERE per_FirstName = 'fooValue'
     * $query->filterByFirstName('%fooValue%', Criteria::LIKE); // WHERE per_FirstName LIKE '%fooValue%'
     * $query->filterByFirstName(['foo', 'bar']); // WHERE per_FirstName IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $firstName The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByFirstName($firstName = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('per_FirstName');
        if ($comparison === null && is_array($firstName)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $firstName, $comparison);

        return $this;
    }

    /**
     * Filter the query on the per_MiddleName column
     *
     * Example usage:
     * <code>
     * $query->filterByMiddleName('fooValue'); // WHERE per_MiddleName = 'fooValue'
     * $query->filterByMiddleName('%fooValue%', Criteria::LIKE); // WHERE per_MiddleName LIKE '%fooValue%'
     * $query->filterByMiddleName(['foo', 'bar']); // WHERE per_MiddleName IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $middleName The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByMiddleName($middleName = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('per_MiddleName');
        if ($comparison === null && is_array($middleName)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $middleName, $comparison);

        return $this;
    }

    /**
     * Filter the query on the per_LastName column
     *
     * Example usage:
     * <code>
     * $query->filterByLastName('fooValue'); // WHERE per_LastName = 'fooValue'
     * $query->filterByLastName('%fooValue%', Criteria::LIKE); // WHERE per_LastName LIKE '%fooValue%'
     * $query->filterByLastName(['foo', 'bar']); // WHERE per_LastName IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $lastName The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByLastName($lastName = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('per_LastName');
        if ($comparison === null && is_array($lastName)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $lastName, $comparison);

        return $this;
    }

    /**
     * Filter the query on the per_Suffix column
     *
     * Example usage:
     * <code>
     * $query->filterBySuffix('fooValue'); // WHERE per_Suffix = 'fooValue'
     * $query->filterBySuffix('%fooValue%', Criteria::LIKE); // WHERE per_Suffix LIKE '%fooValue%'
     * $query->filterBySuffix(['foo', 'bar']); // WHERE per_Suffix IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $suffix The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterBySuffix($suffix = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('per_Suffix');
        if ($comparison === null && is_array($suffix)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $suffix, $comparison);

        return $this;
    }

    /**
     * Filter the query on the per_Address1 column
     *
     * Example usage:
     * <code>
     * $query->filterByAddress1('fooValue'); // WHERE per_Address1 = 'fooValue'
     * $query->filterByAddress1('%fooValue%', Criteria::LIKE); // WHERE per_Address1 LIKE '%fooValue%'
     * $query->filterByAddress1(['foo', 'bar']); // WHERE per_Address1 IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $address1 The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByAddress1($address1 = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('per_Address1');
        if ($comparison === null && is_array($address1)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $address1, $comparison);

        return $this;
    }

    /**
     * Filter the query on the per_Address2 column
     *
     * Example usage:
     * <code>
     * $query->filterByAddress2('fooValue'); // WHERE per_Address2 = 'fooValue'
     * $query->filterByAddress2('%fooValue%', Criteria::LIKE); // WHERE per_Address2 LIKE '%fooValue%'
     * $query->filterByAddress2(['foo', 'bar']); // WHERE per_Address2 IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $address2 The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByAddress2($address2 = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('per_Address2');
        if ($comparison === null && is_array($address2)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $address2, $comparison);

        return $this;
    }

    /**
     * Filter the query on the per_City column
     *
     * Example usage:
     * <code>
     * $query->filterByCity('fooValue'); // WHERE per_City = 'fooValue'
     * $query->filterByCity('%fooValue%', Criteria::LIKE); // WHERE per_City LIKE '%fooValue%'
     * $query->filterByCity(['foo', 'bar']); // WHERE per_City IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $city The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByCity($city = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('per_City');
        if ($comparison === null && is_array($city)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $city, $comparison);

        return $this;
    }

    /**
     * Filter the query on the per_State column
     *
     * Example usage:
     * <code>
     * $query->filterByState('fooValue'); // WHERE per_State = 'fooValue'
     * $query->filterByState('%fooValue%', Criteria::LIKE); // WHERE per_State LIKE '%fooValue%'
     * $query->filterByState(['foo', 'bar']); // WHERE per_State IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $state The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByState($state = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('per_State');
        if ($comparison === null && is_array($state)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $state, $comparison);

        return $this;
    }

    /**
     * Filter the query on the per_Zip column
     *
     * Example usage:
     * <code>
     * $query->filterByZip('fooValue'); // WHERE per_Zip = 'fooValue'
     * $query->filterByZip('%fooValue%', Criteria::LIKE); // WHERE per_Zip LIKE '%fooValue%'
     * $query->filterByZip(['foo', 'bar']); // WHERE per_Zip IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $zip The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByZip($zip = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('per_Zip');
        if ($comparison === null && is_array($zip)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $zip, $comparison);

        return $this;
    }

    /**
     * Filter the query on the per_Country column
     *
     * Example usage:
     * <code>
     * $query->filterByCountry('fooValue'); // WHERE per_Country = 'fooValue'
     * $query->filterByCountry('%fooValue%', Criteria::LIKE); // WHERE per_Country LIKE '%fooValue%'
     * $query->filterByCountry(['foo', 'bar']); // WHERE per_Country IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $country The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByCountry($country = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('per_Country');
        if ($comparison === null && is_array($country)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $country, $comparison);

        return $this;
    }

    /**
     * Filter the query on the per_HomePhone column
     *
     * Example usage:
     * <code>
     * $query->filterByHomePhone('fooValue'); // WHERE per_HomePhone = 'fooValue'
     * $query->filterByHomePhone('%fooValue%', Criteria::LIKE); // WHERE per_HomePhone LIKE '%fooValue%'
     * $query->filterByHomePhone(['foo', 'bar']); // WHERE per_HomePhone IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $homePhone The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByHomePhone($homePhone = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('per_HomePhone');
        if ($comparison === null && is_array($homePhone)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $homePhone, $comparison);

        return $this;
    }

    /**
     * Filter the query on the per_WorkPhone column
     *
     * Example usage:
     * <code>
     * $query->filterByWorkPhone('fooValue'); // WHERE per_WorkPhone = 'fooValue'
     * $query->filterByWorkPhone('%fooValue%', Criteria::LIKE); // WHERE per_WorkPhone LIKE '%fooValue%'
     * $query->filterByWorkPhone(['foo', 'bar']); // WHERE per_WorkPhone IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $workPhone The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByWorkPhone($workPhone = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('per_WorkPhone');
        if ($comparison === null && is_array($workPhone)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $workPhone, $comparison);

        return $this;
    }

    /**
     * Filter the query on the per_CellPhone column
     *
     * Example usage:
     * <code>
     * $query->filterByCellPhone('fooValue'); // WHERE per_CellPhone = 'fooValue'
     * $query->filterByCellPhone('%fooValue%', Criteria::LIKE); // WHERE per_CellPhone LIKE '%fooValue%'
     * $query->filterByCellPhone(['foo', 'bar']); // WHERE per_CellPhone IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $cellPhone The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByCellPhone($cellPhone = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('per_CellPhone');
        if ($comparison === null && is_array($cellPhone)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $cellPhone, $comparison);

        return $this;
    }

    /**
     * Filter the query on the per_Email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue'); // WHERE per_Email = 'fooValue'
     * $query->filterByEmail('%fooValue%', Criteria::LIKE); // WHERE per_Email LIKE '%fooValue%'
     * $query->filterByEmail(['foo', 'bar']); // WHERE per_Email IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $email The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByEmail($email = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('per_Email');
        if ($comparison === null && is_array($email)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $email, $comparison);

        return $this;
    }

    /**
     * Filter the query on the per_WorkEmail column
     *
     * Example usage:
     * <code>
     * $query->filterByWorkEmail('fooValue'); // WHERE per_WorkEmail = 'fooValue'
     * $query->filterByWorkEmail('%fooValue%', Criteria::LIKE); // WHERE per_WorkEmail LIKE '%fooValue%'
     * $query->filterByWorkEmail(['foo', 'bar']); // WHERE per_WorkEmail IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $workEmail The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByWorkEmail($workEmail = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('per_WorkEmail');
        if ($comparison === null && is_array($workEmail)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $workEmail, $comparison);

        return $this;
    }

    /**
     * Filter the query on the per_BirthMonth column
     *
     * Example usage:
     * <code>
     * $query->filterByBirthMonth(1234); // WHERE per_BirthMonth = 1234
     * $query->filterByBirthMonth(array(12, 34)); // WHERE per_BirthMonth IN (12, 34)
     * $query->filterByBirthMonth(array('min' => 12)); // WHERE per_BirthMonth > 12
     * </code>
     *
     * @param mixed $birthMonth The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByBirthMonth($birthMonth = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('per_BirthMonth');
        if (is_array($birthMonth)) {
            $useMinMax = false;
            if (isset($birthMonth['min'])) {
                $this->addUsingOperator($resolvedColumn, $birthMonth['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($birthMonth['max'])) {
                $this->addUsingOperator($resolvedColumn, $birthMonth['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $birthMonth, $comparison);

        return $this;
    }

    /**
     * Filter the query on the per_BirthDay column
     *
     * Example usage:
     * <code>
     * $query->filterByBirthDay(1234); // WHERE per_BirthDay = 1234
     * $query->filterByBirthDay(array(12, 34)); // WHERE per_BirthDay IN (12, 34)
     * $query->filterByBirthDay(array('min' => 12)); // WHERE per_BirthDay > 12
     * </code>
     *
     * @param mixed $birthDay The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByBirthDay($birthDay = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('per_BirthDay');
        if (is_array($birthDay)) {
            $useMinMax = false;
            if (isset($birthDay['min'])) {
                $this->addUsingOperator($resolvedColumn, $birthDay['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($birthDay['max'])) {
                $this->addUsingOperator($resolvedColumn, $birthDay['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $birthDay, $comparison);

        return $this;
    }

    /**
     * Filter the query on the per_BirthYear column
     *
     * Example usage:
     * <code>
     * $query->filterByBirthYear(1234); // WHERE per_BirthYear = 1234
     * $query->filterByBirthYear(array(12, 34)); // WHERE per_BirthYear IN (12, 34)
     * $query->filterByBirthYear(array('min' => 12)); // WHERE per_BirthYear > 12
     * </code>
     *
     * @param mixed $birthYear The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByBirthYear($birthYear = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('per_BirthYear');
        if (is_array($birthYear)) {
            $useMinMax = false;
            if (isset($birthYear['min'])) {
                $this->addUsingOperator($resolvedColumn, $birthYear['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($birthYear['max'])) {
                $this->addUsingOperator($resolvedColumn, $birthYear['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $birthYear, $comparison);

        return $this;
    }

    /**
     * Filter the query on the per_MembershipDate column
     *
     * Example usage:
     * <code>
     * $query->filterByMembershipDate('2011-03-14'); // WHERE per_MembershipDate = '2011-03-14'
     * $query->filterByMembershipDate('now'); // WHERE per_MembershipDate = '2011-03-14'
     * $query->filterByMembershipDate(array('max' => 'yesterday')); // WHERE per_MembershipDate > '2011-03-13'
     * </code>
     *
     * @param mixed $membershipDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByMembershipDate($membershipDate = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('per_MembershipDate');
        if (is_array($membershipDate)) {
            $useMinMax = false;
            if (isset($membershipDate['min'])) {
                $this->addUsingOperator($resolvedColumn, $membershipDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($membershipDate['max'])) {
                $this->addUsingOperator($resolvedColumn, $membershipDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $membershipDate, $comparison);

        return $this;
    }

    /**
     * Filter the query on the per_Gender column
     *
     * Example usage:
     * <code>
     * $query->filterByGender(1234); // WHERE per_Gender = 1234
     * $query->filterByGender(array(12, 34)); // WHERE per_Gender IN (12, 34)
     * $query->filterByGender(array('min' => 12)); // WHERE per_Gender > 12
     * </code>
     *
     * @param mixed $gender The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByGender($gender = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('per_Gender');
        if (is_array($gender)) {
            $useMinMax = false;
            if (isset($gender['min'])) {
                $this->addUsingOperator($resolvedColumn, $gender['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($gender['max'])) {
                $this->addUsingOperator($resolvedColumn, $gender['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $gender, $comparison);

        return $this;
    }

    /**
     * Filter the query on the per_fmr_ID column
     *
     * Example usage:
     * <code>
     * $query->filterByFmrId(1234); // WHERE per_fmr_ID = 1234
     * $query->filterByFmrId(array(12, 34)); // WHERE per_fmr_ID IN (12, 34)
     * $query->filterByFmrId(array('min' => 12)); // WHERE per_fmr_ID > 12
     * </code>
     *
     * @param mixed $fmrId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByFmrId($fmrId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('per_fmr_ID');
        if (is_array($fmrId)) {
            $useMinMax = false;
            if (isset($fmrId['min'])) {
                $this->addUsingOperator($resolvedColumn, $fmrId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fmrId['max'])) {
                $this->addUsingOperator($resolvedColumn, $fmrId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $fmrId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the per_cls_ID column
     *
     * Example usage:
     * <code>
     * $query->filterByClsId(1234); // WHERE per_cls_ID = 1234
     * $query->filterByClsId(array(12, 34)); // WHERE per_cls_ID IN (12, 34)
     * $query->filterByClsId(array('min' => 12)); // WHERE per_cls_ID > 12
     * </code>
     *
     * @param mixed $clsId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByClsId($clsId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('per_cls_ID');
        if (is_array($clsId)) {
            $useMinMax = false;
            if (isset($clsId['min'])) {
                $this->addUsingOperator($resolvedColumn, $clsId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($clsId['max'])) {
                $this->addUsingOperator($resolvedColumn, $clsId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $clsId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the per_fam_ID column
     *
     * Example usage:
     * <code>
     * $query->filterByFamId(1234); // WHERE per_fam_ID = 1234
     * $query->filterByFamId(array(12, 34)); // WHERE per_fam_ID IN (12, 34)
     * $query->filterByFamId(array('min' => 12)); // WHERE per_fam_ID > 12
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
        $resolvedColumn = $this->resolveLocalColumnByName('per_fam_ID');
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
     * Filter the query on the per_Envelope column
     *
     * Example usage:
     * <code>
     * $query->filterByEnvelope(1234); // WHERE per_Envelope = 1234
     * $query->filterByEnvelope(array(12, 34)); // WHERE per_Envelope IN (12, 34)
     * $query->filterByEnvelope(array('min' => 12)); // WHERE per_Envelope > 12
     * </code>
     *
     * @param mixed $envelope The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByEnvelope($envelope = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('per_Envelope');
        if (is_array($envelope)) {
            $useMinMax = false;
            if (isset($envelope['min'])) {
                $this->addUsingOperator($resolvedColumn, $envelope['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($envelope['max'])) {
                $this->addUsingOperator($resolvedColumn, $envelope['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $envelope, $comparison);

        return $this;
    }

    /**
     * Filter the query on the per_DateLastEdited column
     *
     * Example usage:
     * <code>
     * $query->filterByDateLastEdited('2011-03-14'); // WHERE per_DateLastEdited = '2011-03-14'
     * $query->filterByDateLastEdited('now'); // WHERE per_DateLastEdited = '2011-03-14'
     * $query->filterByDateLastEdited(array('max' => 'yesterday')); // WHERE per_DateLastEdited > '2011-03-13'
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
        $resolvedColumn = $this->resolveLocalColumnByName('per_DateLastEdited');
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
     * Filter the query on the per_DateEntered column
     *
     * Example usage:
     * <code>
     * $query->filterByDateEntered('2011-03-14'); // WHERE per_DateEntered = '2011-03-14'
     * $query->filterByDateEntered('now'); // WHERE per_DateEntered = '2011-03-14'
     * $query->filterByDateEntered(array('max' => 'yesterday')); // WHERE per_DateEntered > '2011-03-13'
     * </code>
     *
     * @param mixed $dateEntered The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByDateEntered($dateEntered = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('per_DateEntered');
        if (is_array($dateEntered)) {
            $useMinMax = false;
            if (isset($dateEntered['min'])) {
                $this->addUsingOperator($resolvedColumn, $dateEntered['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateEntered['max'])) {
                $this->addUsingOperator($resolvedColumn, $dateEntered['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $dateEntered, $comparison);

        return $this;
    }

    /**
     * Filter the query on the per_EnteredBy column
     *
     * Example usage:
     * <code>
     * $query->filterByEnteredBy(1234); // WHERE per_EnteredBy = 1234
     * $query->filterByEnteredBy(array(12, 34)); // WHERE per_EnteredBy IN (12, 34)
     * $query->filterByEnteredBy(array('min' => 12)); // WHERE per_EnteredBy > 12
     * </code>
     *
     * @param mixed $enteredBy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByEnteredBy($enteredBy = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('per_EnteredBy');
        if (is_array($enteredBy)) {
            $useMinMax = false;
            if (isset($enteredBy['min'])) {
                $this->addUsingOperator($resolvedColumn, $enteredBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($enteredBy['max'])) {
                $this->addUsingOperator($resolvedColumn, $enteredBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $enteredBy, $comparison);

        return $this;
    }

    /**
     * Filter the query on the per_EditedBy column
     *
     * Example usage:
     * <code>
     * $query->filterByEditedBy(1234); // WHERE per_EditedBy = 1234
     * $query->filterByEditedBy(array(12, 34)); // WHERE per_EditedBy IN (12, 34)
     * $query->filterByEditedBy(array('min' => 12)); // WHERE per_EditedBy > 12
     * </code>
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
        $resolvedColumn = $this->resolveLocalColumnByName('per_EditedBy');
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
     * Filter the query on the per_FriendDate column
     *
     * Example usage:
     * <code>
     * $query->filterByFriendDate('2011-03-14'); // WHERE per_FriendDate = '2011-03-14'
     * $query->filterByFriendDate('now'); // WHERE per_FriendDate = '2011-03-14'
     * $query->filterByFriendDate(array('max' => 'yesterday')); // WHERE per_FriendDate > '2011-03-13'
     * </code>
     *
     * @param mixed $friendDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByFriendDate($friendDate = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('per_FriendDate');
        if (is_array($friendDate)) {
            $useMinMax = false;
            if (isset($friendDate['min'])) {
                $this->addUsingOperator($resolvedColumn, $friendDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($friendDate['max'])) {
                $this->addUsingOperator($resolvedColumn, $friendDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $friendDate, $comparison);

        return $this;
    }

    /**
     * Filter the query on the per_Flags column
     *
     * Example usage:
     * <code>
     * $query->filterByFlags(1234); // WHERE per_Flags = 1234
     * $query->filterByFlags(array(12, 34)); // WHERE per_Flags IN (12, 34)
     * $query->filterByFlags(array('min' => 12)); // WHERE per_Flags > 12
     * </code>
     *
     * @param mixed $flags The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByFlags($flags = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('per_Flags');
        if (is_array($flags)) {
            $useMinMax = false;
            if (isset($flags['min'])) {
                $this->addUsingOperator($resolvedColumn, $flags['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($flags['max'])) {
                $this->addUsingOperator($resolvedColumn, $flags['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $flags, $comparison);

        return $this;
    }

    /**
     * Filter the query on the per_Facebook column
     *
     * Example usage:
     * <code>
     * $query->filterByFacebook('fooValue'); // WHERE per_Facebook = 'fooValue'
     * $query->filterByFacebook('%fooValue%', Criteria::LIKE); // WHERE per_Facebook LIKE '%fooValue%'
     * $query->filterByFacebook(['foo', 'bar']); // WHERE per_Facebook IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $facebook The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByFacebook($facebook = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('per_Facebook');
        if ($comparison === null && is_array($facebook)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $facebook, $comparison);

        return $this;
    }

    /**
     * Filter the query on the per_Twitter column
     *
     * Example usage:
     * <code>
     * $query->filterByTwitter('fooValue'); // WHERE per_Twitter = 'fooValue'
     * $query->filterByTwitter('%fooValue%', Criteria::LIKE); // WHERE per_Twitter LIKE '%fooValue%'
     * $query->filterByTwitter(['foo', 'bar']); // WHERE per_Twitter IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $twitter The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByTwitter($twitter = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('per_Twitter');
        if ($comparison === null && is_array($twitter)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $twitter, $comparison);

        return $this;
    }

    /**
     * Filter the query on the per_LinkedIn column
     *
     * Example usage:
     * <code>
     * $query->filterByLinkedIn('fooValue'); // WHERE per_LinkedIn = 'fooValue'
     * $query->filterByLinkedIn('%fooValue%', Criteria::LIKE); // WHERE per_LinkedIn LIKE '%fooValue%'
     * $query->filterByLinkedIn(['foo', 'bar']); // WHERE per_LinkedIn IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $linkedIn The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByLinkedIn($linkedIn = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('per_LinkedIn');
        if ($comparison === null && is_array($linkedIn)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $linkedIn, $comparison);

        return $this;
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
                ->addUsingOperator($this->resolveLocalColumnByName('per_fam_ID'), $family->getId(), $comparison);
        } elseif ($family instanceof ObjectCollection) {
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingOperator($this->resolveLocalColumnByName('per_fam_ID'), $family->toKeyValue('PrimaryKey', 'Id'), $comparison);

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
    public function joinFamily(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
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
    public function useFamilyQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
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
        ?string $joinType = Criteria::INNER_JOIN
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
     * Filter the query by a related WhyCame object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\WhyCame|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\WhyCame> $whyCame the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this
     */
    public function filterByWhyCame(WhyCame|ObjectCollection $whyCame, ?string $comparison = null)
    {
        if ($whyCame instanceof WhyCame) {
            $this
                ->addUsingOperator($this->resolveLocalColumnByName('per_ID'), $whyCame->getPerId(), $comparison);
        } elseif ($whyCame instanceof ObjectCollection) {
            $this
                ->useWhyCameQuery()
                ->filterByPrimaryKeys($whyCame->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByWhyCame() only accepts arguments of type \ChurchCRM\model\ChurchCRM\Base\WhyCame or Collection');
        }

        return $this;
    }

    /**
     * Adds a JOIN clause to the query using the WhyCame relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinWhyCame(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('WhyCame');

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
            $this->addJoinObject($join, 'WhyCame');
        }

        return $this;
    }

    /**
     * Use the WhyCame relation WhyCame object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\WhyCameQuery<static> A secondary query class using the current class as primary query
     */
    public function useWhyCameQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\WhyCameQuery<static> $query */
        $query = $this->joinWhyCame($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'WhyCame', '\ChurchCRM\model\ChurchCRM\WhyCameQuery');

        return $query;
    }

    /**
     * Use the WhyCame relation WhyCame object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\WhyCameQuery<mixed>):\ChurchCRM\model\ChurchCRM\WhyCameQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withWhyCameQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useWhyCameQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to WhyCame table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\WhyCameQuery<static> The inner query object of the EXISTS statement
     */
    public function useWhyCameExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\WhyCameQuery<static> $q */
        $q = $this->useExistsQuery('WhyCame', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to WhyCame table for a NOT EXISTS query.
     *
     * @see useWhyCameExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\WhyCameQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function useWhyCameNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\WhyCameQuery<static> $q*/
        $q = $this->useExistsQuery('WhyCame', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to WhyCame table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\WhyCameQuery<static> The inner query object of the IN statement
     */
    public function useInWhyCameQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\WhyCameQuery<static> $q */
        $q = $this->useInQuery('WhyCame', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to WhyCame table for a NOT IN query.
     *
     * @see useWhyCameInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\WhyCameQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInWhyCameQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\WhyCameQuery<static> $q */
        $q = $this->useInQuery('WhyCame', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
    }

    /**
     * Filter the query by a related PersonCustom object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\PersonCustom|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\PersonCustom> $personCustom the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this
     */
    public function filterByPersonCustom(PersonCustom|ObjectCollection $personCustom, ?string $comparison = null)
    {
        if ($personCustom instanceof PersonCustom) {
            $this
                ->addUsingOperator($this->resolveLocalColumnByName('per_ID'), $personCustom->getPerId(), $comparison);
        } elseif ($personCustom instanceof ObjectCollection) {
            $this
                ->usePersonCustomQuery()
                ->filterByPrimaryKeys($personCustom->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPersonCustom() only accepts arguments of type \ChurchCRM\model\ChurchCRM\Base\PersonCustom or Collection');
        }

        return $this;
    }

    /**
     * Adds a JOIN clause to the query using the PersonCustom relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinPersonCustom(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PersonCustom');

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
            $this->addJoinObject($join, 'PersonCustom');
        }

        return $this;
    }

    /**
     * Use the PersonCustom relation PersonCustom object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\PersonCustomQuery<static> A secondary query class using the current class as primary query
     */
    public function usePersonCustomQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PersonCustomQuery<static> $query */
        $query = $this->joinPersonCustom($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'PersonCustom', '\ChurchCRM\model\ChurchCRM\PersonCustomQuery');

        return $query;
    }

    /**
     * Use the PersonCustom relation PersonCustom object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\PersonCustomQuery<mixed>):\ChurchCRM\model\ChurchCRM\PersonCustomQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withPersonCustomQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->usePersonCustomQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to PersonCustom table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\PersonCustomQuery<static> The inner query object of the EXISTS statement
     */
    public function usePersonCustomExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\PersonCustomQuery<static> $q */
        $q = $this->useExistsQuery('PersonCustom', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to PersonCustom table for a NOT EXISTS query.
     *
     * @see usePersonCustomExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\PersonCustomQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function usePersonCustomNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PersonCustomQuery<static> $q*/
        $q = $this->useExistsQuery('PersonCustom', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to PersonCustom table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\PersonCustomQuery<static> The inner query object of the IN statement
     */
    public function useInPersonCustomQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PersonCustomQuery<static> $q */
        $q = $this->useInQuery('PersonCustom', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to PersonCustom table for a NOT IN query.
     *
     * @see usePersonCustomInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\PersonCustomQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInPersonCustomQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PersonCustomQuery<static> $q */
        $q = $this->useInQuery('PersonCustom', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
    }

    /**
     * Filter the query by a related Note object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Note|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Note> $note the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this
     */
    public function filterByNote(Note|ObjectCollection $note, ?string $comparison = null)
    {
        if ($note instanceof Note) {
            $this
                ->addUsingOperator($this->resolveLocalColumnByName('per_ID'), $note->getPerId(), $comparison);
        } elseif ($note instanceof ObjectCollection) {
            $this
                ->useNoteQuery()
                ->filterByPrimaryKeys($note->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByNote() only accepts arguments of type \ChurchCRM\model\ChurchCRM\Base\Note or Collection');
        }

        return $this;
    }

    /**
     * Adds a JOIN clause to the query using the Note relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinNote(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Note');

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
            $this->addJoinObject($join, 'Note');
        }

        return $this;
    }

    /**
     * Use the Note relation Note object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\NoteQuery<static> A secondary query class using the current class as primary query
     */
    public function useNoteQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\NoteQuery<static> $query */
        $query = $this->joinNote($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'Note', '\ChurchCRM\model\ChurchCRM\NoteQuery');

        return $query;
    }

    /**
     * Use the Note relation Note object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\NoteQuery<mixed>):\ChurchCRM\model\ChurchCRM\NoteQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withNoteQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useNoteQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Note table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\NoteQuery<static> The inner query object of the EXISTS statement
     */
    public function useNoteExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\NoteQuery<static> $q */
        $q = $this->useExistsQuery('Note', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to Note table for a NOT EXISTS query.
     *
     * @see useNoteExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\NoteQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function useNoteNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\NoteQuery<static> $q*/
        $q = $this->useExistsQuery('Note', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to Note table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\NoteQuery<static> The inner query object of the IN statement
     */
    public function useInNoteQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\NoteQuery<static> $q */
        $q = $this->useInQuery('Note', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to Note table for a NOT IN query.
     *
     * @see useNoteInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\NoteQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInNoteQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\NoteQuery<static> $q */
        $q = $this->useInQuery('Note', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
    }

    /**
     * Filter the query by a related Person2group2roleP2g2r object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Person2group2roleP2g2r|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Person2group2roleP2g2r> $person2group2roleP2g2r the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this
     */
    public function filterByPerson2group2roleP2g2r(Person2group2roleP2g2r|ObjectCollection $person2group2roleP2g2r, ?string $comparison = null)
    {
        if ($person2group2roleP2g2r instanceof Person2group2roleP2g2r) {
            $this
                ->addUsingOperator($this->resolveLocalColumnByName('per_ID'), $person2group2roleP2g2r->getPersonId(), $comparison);
        } elseif ($person2group2roleP2g2r instanceof ObjectCollection) {
            $this
                ->usePerson2group2roleP2g2rQuery()
                ->filterByPrimaryKeys($person2group2roleP2g2r->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPerson2group2roleP2g2r() only accepts arguments of type \ChurchCRM\model\ChurchCRM\Base\Person2group2roleP2g2r or Collection');
        }

        return $this;
    }

    /**
     * Adds a JOIN clause to the query using the Person2group2roleP2g2r relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinPerson2group2roleP2g2r(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Person2group2roleP2g2r');

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
            $this->addJoinObject($join, 'Person2group2roleP2g2r');
        }

        return $this;
    }

    /**
     * Use the Person2group2roleP2g2r relation Person2group2roleP2g2r object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\Person2group2roleP2g2rQuery<static> A secondary query class using the current class as primary query
     */
    public function usePerson2group2roleP2g2rQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\Person2group2roleP2g2rQuery<static> $query */
        $query = $this->joinPerson2group2roleP2g2r($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'Person2group2roleP2g2r', '\ChurchCRM\model\ChurchCRM\Person2group2roleP2g2rQuery');

        return $query;
    }

    /**
     * Use the Person2group2roleP2g2r relation Person2group2roleP2g2r object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\Person2group2roleP2g2rQuery<mixed>):\ChurchCRM\model\ChurchCRM\Person2group2roleP2g2rQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withPerson2group2roleP2g2rQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->usePerson2group2roleP2g2rQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Person2group2roleP2g2r table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\Person2group2roleP2g2rQuery<static> The inner query object of the EXISTS statement
     */
    public function usePerson2group2roleP2g2rExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\Person2group2roleP2g2rQuery<static> $q */
        $q = $this->useExistsQuery('Person2group2roleP2g2r', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to Person2group2roleP2g2r table for a NOT EXISTS query.
     *
     * @see usePerson2group2roleP2g2rExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\Person2group2roleP2g2rQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function usePerson2group2roleP2g2rNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\Person2group2roleP2g2rQuery<static> $q*/
        $q = $this->useExistsQuery('Person2group2roleP2g2r', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to Person2group2roleP2g2r table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\Person2group2roleP2g2rQuery<static> The inner query object of the IN statement
     */
    public function useInPerson2group2roleP2g2rQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\Person2group2roleP2g2rQuery<static> $q */
        $q = $this->useInQuery('Person2group2roleP2g2r', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to Person2group2roleP2g2r table for a NOT IN query.
     *
     * @see usePerson2group2roleP2g2rInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\Person2group2roleP2g2rQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInPerson2group2roleP2g2rQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\Person2group2roleP2g2rQuery<static> $q */
        $q = $this->useInQuery('Person2group2roleP2g2r', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
    }

    /**
     * Filter the query by a related EventAttend object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\EventAttend|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\EventAttend> $eventAttend the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this
     */
    public function filterByEventAttend(EventAttend|ObjectCollection $eventAttend, ?string $comparison = null)
    {
        if ($eventAttend instanceof EventAttend) {
            $this
                ->addUsingOperator($this->resolveLocalColumnByName('per_ID'), $eventAttend->getPersonId(), $comparison);
        } elseif ($eventAttend instanceof ObjectCollection) {
            $this
                ->useEventAttendQuery()
                ->filterByPrimaryKeys($eventAttend->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByEventAttend() only accepts arguments of type \ChurchCRM\model\ChurchCRM\Base\EventAttend or Collection');
        }

        return $this;
    }

    /**
     * Adds a JOIN clause to the query using the EventAttend relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinEventAttend(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('EventAttend');

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
            $this->addJoinObject($join, 'EventAttend');
        }

        return $this;
    }

    /**
     * Use the EventAttend relation EventAttend object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\EventAttendQuery<static> A secondary query class using the current class as primary query
     */
    public function useEventAttendQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventAttendQuery<static> $query */
        $query = $this->joinEventAttend($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'EventAttend', '\ChurchCRM\model\ChurchCRM\EventAttendQuery');

        return $query;
    }

    /**
     * Use the EventAttend relation EventAttend object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\EventAttendQuery<mixed>):\ChurchCRM\model\ChurchCRM\EventAttendQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withEventAttendQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useEventAttendQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to EventAttend table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\EventAttendQuery<static> The inner query object of the EXISTS statement
     */
    public function useEventAttendExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventAttendQuery<static> $q */
        $q = $this->useExistsQuery('EventAttend', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to EventAttend table for a NOT EXISTS query.
     *
     * @see useEventAttendExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\EventAttendQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function useEventAttendNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventAttendQuery<static> $q*/
        $q = $this->useExistsQuery('EventAttend', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to EventAttend table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\EventAttendQuery<static> The inner query object of the IN statement
     */
    public function useInEventAttendQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventAttendQuery<static> $q */
        $q = $this->useInQuery('EventAttend', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to EventAttend table for a NOT IN query.
     *
     * @see useEventAttendInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\EventAttendQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInEventAttendQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventAttendQuery<static> $q */
        $q = $this->useInQuery('EventAttend', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
    }

    /**
     * Filter the query by a related PrimaryContactPerson object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Event|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Event> $event the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this
     */
    public function filterByPrimaryContactPerson(Event|ObjectCollection $event, ?string $comparison = null)
    {
        if ($event instanceof Event) {
            $this
                ->addUsingOperator($this->resolveLocalColumnByName('per_ID'), $event->getType(), $comparison);
        } elseif ($event instanceof ObjectCollection) {
            $this
                ->usePrimaryContactPersonQuery()
                ->filterByPrimaryKeys($event->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPrimaryContactPerson() only accepts arguments of type \ChurchCRM\model\ChurchCRM\Base\Event or Collection');
        }

        return $this;
    }

    /**
     * Adds a JOIN clause to the query using the PrimaryContactPerson relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinPrimaryContactPerson(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PrimaryContactPerson');

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
            $this->addJoinObject($join, 'PrimaryContactPerson');
        }

        return $this;
    }

    /**
     * Use the PrimaryContactPerson relation Event object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\EventQuery<static> A secondary query class using the current class as primary query
     */
    public function usePrimaryContactPersonQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventQuery<static> $query */
        $query = $this->joinPrimaryContactPerson($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'PrimaryContactPerson', '\ChurchCRM\model\ChurchCRM\EventQuery');

        return $query;
    }

    /**
     * Use the PrimaryContactPerson relation Event object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\EventQuery<mixed>):\ChurchCRM\model\ChurchCRM\EventQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withPrimaryContactPersonQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->usePrimaryContactPersonQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the PrimaryContactPerson relation to the Event table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\EventQuery<static> The inner query object of the EXISTS statement
     */
    public function usePrimaryContactPersonExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventQuery<static> $q */
        $q = $this->useExistsQuery('PrimaryContactPerson', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the PrimaryContactPerson relation to the Event table for a NOT EXISTS query.
     *
     * @see usePrimaryContactPersonExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\EventQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function usePrimaryContactPersonNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventQuery<static> $q*/
        $q = $this->useExistsQuery('PrimaryContactPerson', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the PrimaryContactPerson relation to the Event table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\EventQuery<static> The inner query object of the IN statement
     */
    public function useInPrimaryContactPersonQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventQuery<static> $q */
        $q = $this->useInQuery('PrimaryContactPerson', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the PrimaryContactPerson relation to the Event table for a NOT IN query.
     *
     * @see usePrimaryContactPersonInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\EventQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInPrimaryContactPersonQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventQuery<static> $q */
        $q = $this->useInQuery('PrimaryContactPerson', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
    }

    /**
     * Filter the query by a related SecondaryContactPerson object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Event|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Event> $event the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this
     */
    public function filterBySecondaryContactPerson(Event|ObjectCollection $event, ?string $comparison = null)
    {
        if ($event instanceof Event) {
            $this
                ->addUsingOperator($this->resolveLocalColumnByName('per_ID'), $event->getSecondaryContactPersonId(), $comparison);
        } elseif ($event instanceof ObjectCollection) {
            $this
                ->useSecondaryContactPersonQuery()
                ->filterByPrimaryKeys($event->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySecondaryContactPerson() only accepts arguments of type \ChurchCRM\model\ChurchCRM\Base\Event or Collection');
        }

        return $this;
    }

    /**
     * Adds a JOIN clause to the query using the SecondaryContactPerson relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinSecondaryContactPerson(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SecondaryContactPerson');

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
            $this->addJoinObject($join, 'SecondaryContactPerson');
        }

        return $this;
    }

    /**
     * Use the SecondaryContactPerson relation Event object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\EventQuery<static> A secondary query class using the current class as primary query
     */
    public function useSecondaryContactPersonQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventQuery<static> $query */
        $query = $this->joinSecondaryContactPerson($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'SecondaryContactPerson', '\ChurchCRM\model\ChurchCRM\EventQuery');

        return $query;
    }

    /**
     * Use the SecondaryContactPerson relation Event object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\EventQuery<mixed>):\ChurchCRM\model\ChurchCRM\EventQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withSecondaryContactPersonQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useSecondaryContactPersonQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the SecondaryContactPerson relation to the Event table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\EventQuery<static> The inner query object of the EXISTS statement
     */
    public function useSecondaryContactPersonExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventQuery<static> $q */
        $q = $this->useExistsQuery('SecondaryContactPerson', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the SecondaryContactPerson relation to the Event table for a NOT EXISTS query.
     *
     * @see useSecondaryContactPersonExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\EventQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function useSecondaryContactPersonNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventQuery<static> $q*/
        $q = $this->useExistsQuery('SecondaryContactPerson', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the SecondaryContactPerson relation to the Event table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\EventQuery<static> The inner query object of the IN statement
     */
    public function useInSecondaryContactPersonQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventQuery<static> $q */
        $q = $this->useInQuery('SecondaryContactPerson', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the SecondaryContactPerson relation to the Event table for a NOT IN query.
     *
     * @see useSecondaryContactPersonInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\EventQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInSecondaryContactPersonQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventQuery<static> $q */
        $q = $this->useInQuery('SecondaryContactPerson', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
    }

    /**
     * Filter the query by a related Pledge object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Pledge|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Pledge> $pledge the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this
     */
    public function filterByPledge(Pledge|ObjectCollection $pledge, ?string $comparison = null)
    {
        if ($pledge instanceof Pledge) {
            $this
                ->addUsingOperator($this->resolveLocalColumnByName('per_ID'), $pledge->getEditedBy(), $comparison);
        } elseif ($pledge instanceof ObjectCollection) {
            $this
                ->usePledgeQuery()
                ->filterByPrimaryKeys($pledge->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPledge() only accepts arguments of type \ChurchCRM\model\ChurchCRM\Base\Pledge or Collection');
        }

        return $this;
    }

    /**
     * Adds a JOIN clause to the query using the Pledge relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinPledge(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Pledge');

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
            $this->addJoinObject($join, 'Pledge');
        }

        return $this;
    }

    /**
     * Use the Pledge relation Pledge object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\PledgeQuery<static> A secondary query class using the current class as primary query
     */
    public function usePledgeQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PledgeQuery<static> $query */
        $query = $this->joinPledge($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'Pledge', '\ChurchCRM\model\ChurchCRM\PledgeQuery');

        return $query;
    }

    /**
     * Use the Pledge relation Pledge object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\PledgeQuery<mixed>):\ChurchCRM\model\ChurchCRM\PledgeQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withPledgeQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->usePledgeQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Pledge table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\PledgeQuery<static> The inner query object of the EXISTS statement
     */
    public function usePledgeExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\PledgeQuery<static> $q */
        $q = $this->useExistsQuery('Pledge', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to Pledge table for a NOT EXISTS query.
     *
     * @see usePledgeExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\PledgeQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function usePledgeNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PledgeQuery<static> $q*/
        $q = $this->useExistsQuery('Pledge', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to Pledge table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\PledgeQuery<static> The inner query object of the IN statement
     */
    public function useInPledgeQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PledgeQuery<static> $q */
        $q = $this->useInQuery('Pledge', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to Pledge table for a NOT IN query.
     *
     * @see usePledgeInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\PledgeQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInPledgeQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PledgeQuery<static> $q */
        $q = $this->useInQuery('Pledge', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
    }

    /**
     * Filter the query by a related User object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\User|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\User> $user the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this
     */
    public function filterByUser(User|ObjectCollection $user, ?string $comparison = null)
    {
        if ($user instanceof User) {
            $this
                ->addUsingOperator($this->resolveLocalColumnByName('per_ID'), $user->getPersonId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            $this
                ->useUserQuery()
                ->filterByPrimaryKeys($user->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type \ChurchCRM\model\ChurchCRM\Base\User or Collection');
        }

        return $this;
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinUser(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

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
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\UserQuery<static> A secondary query class using the current class as primary query
     */
    public function useUserQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\UserQuery<static> $query */
        $query = $this->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'User', '\ChurchCRM\model\ChurchCRM\UserQuery');

        return $query;
    }

    /**
     * Use the User relation User object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\UserQuery<mixed>):\ChurchCRM\model\ChurchCRM\UserQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withUserQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useUserQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to User table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\UserQuery<static> The inner query object of the EXISTS statement
     */
    public function useUserExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\UserQuery<static> $q */
        $q = $this->useExistsQuery('User', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to User table for a NOT EXISTS query.
     *
     * @see useUserExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\UserQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function useUserNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\UserQuery<static> $q*/
        $q = $this->useExistsQuery('User', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to User table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\UserQuery<static> The inner query object of the IN statement
     */
    public function useInUserQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\UserQuery<static> $q */
        $q = $this->useInQuery('User', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to User table for a NOT IN query.
     *
     * @see useUserInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\UserQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInUserQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\UserQuery<static> $q */
        $q = $this->useInQuery('User', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param \ChurchCRM\model\ChurchCRM\Person|null $person Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildPerson $person = null)
    {
        if ($person) {
            $resolvedColumn = $this->resolveLocalColumnByName('per_ID');
            $this->addUsingOperator($resolvedColumn, $person->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the person_per table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PersonTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PersonTableMap::clearInstancePool();
            PersonTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PersonTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PersonTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PersonTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            PersonTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
