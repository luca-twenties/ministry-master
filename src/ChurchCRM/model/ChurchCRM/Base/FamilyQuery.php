<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Family as ChildFamily;
use ChurchCRM\model\ChurchCRM\FamilyQuery as ChildFamilyQuery;
use ChurchCRM\model\ChurchCRM\Map\FamilyTableMap;
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
 * Base class that represents a query for the `family_fam` table.
 *
 * This contains the main family data, including family name, family addresses, and family phone numbers
 *
 * @method static orderById($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fam_ID column
 * @method static orderByName($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fam_Name column
 * @method static orderByAddress1($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fam_Address1 column
 * @method static orderByAddress2($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fam_Address2 column
 * @method static orderByCity($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fam_City column
 * @method static orderByState($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fam_State column
 * @method static orderByZip($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fam_Zip column
 * @method static orderByCountry($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fam_Country column
 * @method static orderByHomePhone($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fam_HomePhone column
 * @method static orderByEmail($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fam_Email column
 * @method static orderByWeddingdate($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fam_WeddingDate column
 * @method static orderByDateEntered($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fam_DateEntered column
 * @method static orderByDateLastEdited($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fam_DateLastEdited column
 * @method static orderByEnteredBy($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fam_EnteredBy column
 * @method static orderByEditedBy($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fam_EditedBy column
 * @method static orderByScanCheck($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fam_scanCheck column
 * @method static orderByScanCredit($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fam_scanCredit column
 * @method static orderBySendNewsletter($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fam_SendNewsLetter column
 * @method static orderByDateDeactivated($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fam_DateDeactivated column
 * @method static orderByLatitude($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fam_Latitude column
 * @method static orderByLongitude($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fam_Longitude column
 * @method static orderByEnvelope($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fam_Envelope column
 *
 * @method static groupById() Group by the fam_ID column
 * @method static groupByName() Group by the fam_Name column
 * @method static groupByAddress1() Group by the fam_Address1 column
 * @method static groupByAddress2() Group by the fam_Address2 column
 * @method static groupByCity() Group by the fam_City column
 * @method static groupByState() Group by the fam_State column
 * @method static groupByZip() Group by the fam_Zip column
 * @method static groupByCountry() Group by the fam_Country column
 * @method static groupByHomePhone() Group by the fam_HomePhone column
 * @method static groupByEmail() Group by the fam_Email column
 * @method static groupByWeddingdate() Group by the fam_WeddingDate column
 * @method static groupByDateEntered() Group by the fam_DateEntered column
 * @method static groupByDateLastEdited() Group by the fam_DateLastEdited column
 * @method static groupByEnteredBy() Group by the fam_EnteredBy column
 * @method static groupByEditedBy() Group by the fam_EditedBy column
 * @method static groupByScanCheck() Group by the fam_scanCheck column
 * @method static groupByScanCredit() Group by the fam_scanCredit column
 * @method static groupBySendNewsletter() Group by the fam_SendNewsLetter column
 * @method static groupByDateDeactivated() Group by the fam_DateDeactivated column
 * @method static groupByLatitude() Group by the fam_Latitude column
 * @method static groupByLongitude() Group by the fam_Longitude column
 * @method static groupByEnvelope() Group by the fam_Envelope column
 *
 * @method static leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method static rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method static innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method static leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method static rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method static innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
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
 * @method static leftJoinFamilyCustom($relationAlias = null) Adds a LEFT JOIN clause to the query using the FamilyCustom relation
 * @method static rightJoinFamilyCustom($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FamilyCustom relation
 * @method static innerJoinFamilyCustom($relationAlias = null) Adds a INNER JOIN clause to the query using the FamilyCustom relation
 *
 * @method static joinWithFamilyCustom($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the FamilyCustom relation
 *
 * @method static leftJoinWithFamilyCustom() Adds a LEFT JOIN clause and with to the query using the FamilyCustom relation
 * @method static rightJoinWithFamilyCustom() Adds a RIGHT JOIN clause and with to the query using the FamilyCustom relation
 * @method static innerJoinWithFamilyCustom() Adds a INNER JOIN clause and with to the query using the FamilyCustom relation
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
 * @method \ChurchCRM\model\ChurchCRM\Family|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Family matching the query
 * @method \ChurchCRM\model\ChurchCRM\Family findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Family matching the query, or a new \ChurchCRM\model\ChurchCRM\Family object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\Family|null findOneById(int $fam_ID) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_ID column
 * @method \ChurchCRM\model\ChurchCRM\Family|null findOneByName(string $fam_Name) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_Name column
 * @method \ChurchCRM\model\ChurchCRM\Family|null findOneByAddress1(string $fam_Address1) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_Address1 column
 * @method \ChurchCRM\model\ChurchCRM\Family|null findOneByAddress2(string $fam_Address2) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_Address2 column
 * @method \ChurchCRM\model\ChurchCRM\Family|null findOneByCity(string $fam_City) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_City column
 * @method \ChurchCRM\model\ChurchCRM\Family|null findOneByState(string $fam_State) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_State column
 * @method \ChurchCRM\model\ChurchCRM\Family|null findOneByZip(string $fam_Zip) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_Zip column
 * @method \ChurchCRM\model\ChurchCRM\Family|null findOneByCountry(string $fam_Country) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_Country column
 * @method \ChurchCRM\model\ChurchCRM\Family|null findOneByHomePhone(string $fam_HomePhone) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_HomePhone column
 * @method \ChurchCRM\model\ChurchCRM\Family|null findOneByEmail(string $fam_Email) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_Email column
 * @method \ChurchCRM\model\ChurchCRM\Family|null findOneByWeddingdate(string $fam_WeddingDate) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_WeddingDate column
 * @method \ChurchCRM\model\ChurchCRM\Family|null findOneByDateEntered(string $fam_DateEntered) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_DateEntered column
 * @method \ChurchCRM\model\ChurchCRM\Family|null findOneByDateLastEdited(string $fam_DateLastEdited) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_DateLastEdited column
 * @method \ChurchCRM\model\ChurchCRM\Family|null findOneByEnteredBy(int $fam_EnteredBy) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_EnteredBy column
 * @method \ChurchCRM\model\ChurchCRM\Family|null findOneByEditedBy(int $fam_EditedBy) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_EditedBy column
 * @method \ChurchCRM\model\ChurchCRM\Family|null findOneByScanCheck(string $fam_scanCheck) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_scanCheck column
 * @method \ChurchCRM\model\ChurchCRM\Family|null findOneByScanCredit(string $fam_scanCredit) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_scanCredit column
 * @method \ChurchCRM\model\ChurchCRM\Family|null findOneBySendNewsletter(string $fam_SendNewsLetter) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_SendNewsLetter column
 * @method \ChurchCRM\model\ChurchCRM\Family|null findOneByDateDeactivated(string $fam_DateDeactivated) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_DateDeactivated column
 * @method \ChurchCRM\model\ChurchCRM\Family|null findOneByLatitude(float $fam_Latitude) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_Latitude column
 * @method \ChurchCRM\model\ChurchCRM\Family|null findOneByLongitude(float $fam_Longitude) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_Longitude column
 * @method \ChurchCRM\model\ChurchCRM\Family|null findOneByEnvelope(int $fam_Envelope) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_Envelope column
 *
 * @method \ChurchCRM\model\ChurchCRM\Family requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\Family by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Family requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Family matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Family requireOneById(int $fam_ID) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Family requireOneByName(string $fam_Name) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_Name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Family requireOneByAddress1(string $fam_Address1) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_Address1 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Family requireOneByAddress2(string $fam_Address2) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_Address2 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Family requireOneByCity(string $fam_City) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_City column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Family requireOneByState(string $fam_State) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_State column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Family requireOneByZip(string $fam_Zip) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_Zip column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Family requireOneByCountry(string $fam_Country) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_Country column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Family requireOneByHomePhone(string $fam_HomePhone) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_HomePhone column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Family requireOneByEmail(string $fam_Email) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_Email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Family requireOneByWeddingdate(string $fam_WeddingDate) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_WeddingDate column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Family requireOneByDateEntered(string $fam_DateEntered) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_DateEntered column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Family requireOneByDateLastEdited(string $fam_DateLastEdited) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_DateLastEdited column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Family requireOneByEnteredBy(int $fam_EnteredBy) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_EnteredBy column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Family requireOneByEditedBy(int $fam_EditedBy) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_EditedBy column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Family requireOneByScanCheck(string $fam_scanCheck) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_scanCheck column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Family requireOneByScanCredit(string $fam_scanCredit) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_scanCredit column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Family requireOneBySendNewsletter(string $fam_SendNewsLetter) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_SendNewsLetter column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Family requireOneByDateDeactivated(string $fam_DateDeactivated) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_DateDeactivated column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Family requireOneByLatitude(float $fam_Latitude) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_Latitude column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Family requireOneByLongitude(float $fam_Longitude) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_Longitude column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Family requireOneByEnvelope(int $fam_Envelope) Return the first \ChurchCRM\model\ChurchCRM\Family filtered by the fam_Envelope column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\FamilyCollection|array<\ChurchCRM\model\ChurchCRM\Family>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Family> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\Family objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\FamilyCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\Family objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\Family>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Family> findById(int|array<int> $fam_ID) Return \ChurchCRM\model\ChurchCRM\Family objects filtered by the fam_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\Family>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Family> findByName(string|array<string> $fam_Name) Return \ChurchCRM\model\ChurchCRM\Family objects filtered by the fam_Name column
 * @method array<\ChurchCRM\model\ChurchCRM\Family>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Family> findByAddress1(string|array<string> $fam_Address1) Return \ChurchCRM\model\ChurchCRM\Family objects filtered by the fam_Address1 column
 * @method array<\ChurchCRM\model\ChurchCRM\Family>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Family> findByAddress2(string|array<string> $fam_Address2) Return \ChurchCRM\model\ChurchCRM\Family objects filtered by the fam_Address2 column
 * @method array<\ChurchCRM\model\ChurchCRM\Family>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Family> findByCity(string|array<string> $fam_City) Return \ChurchCRM\model\ChurchCRM\Family objects filtered by the fam_City column
 * @method array<\ChurchCRM\model\ChurchCRM\Family>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Family> findByState(string|array<string> $fam_State) Return \ChurchCRM\model\ChurchCRM\Family objects filtered by the fam_State column
 * @method array<\ChurchCRM\model\ChurchCRM\Family>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Family> findByZip(string|array<string> $fam_Zip) Return \ChurchCRM\model\ChurchCRM\Family objects filtered by the fam_Zip column
 * @method array<\ChurchCRM\model\ChurchCRM\Family>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Family> findByCountry(string|array<string> $fam_Country) Return \ChurchCRM\model\ChurchCRM\Family objects filtered by the fam_Country column
 * @method array<\ChurchCRM\model\ChurchCRM\Family>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Family> findByHomePhone(string|array<string> $fam_HomePhone) Return \ChurchCRM\model\ChurchCRM\Family objects filtered by the fam_HomePhone column
 * @method array<\ChurchCRM\model\ChurchCRM\Family>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Family> findByEmail(string|array<string> $fam_Email) Return \ChurchCRM\model\ChurchCRM\Family objects filtered by the fam_Email column
 * @method array<\ChurchCRM\model\ChurchCRM\Family>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Family> findByWeddingdate(string|array<string> $fam_WeddingDate) Return \ChurchCRM\model\ChurchCRM\Family objects filtered by the fam_WeddingDate column
 * @method array<\ChurchCRM\model\ChurchCRM\Family>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Family> findByDateEntered(string|array<string> $fam_DateEntered) Return \ChurchCRM\model\ChurchCRM\Family objects filtered by the fam_DateEntered column
 * @method array<\ChurchCRM\model\ChurchCRM\Family>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Family> findByDateLastEdited(string|array<string> $fam_DateLastEdited) Return \ChurchCRM\model\ChurchCRM\Family objects filtered by the fam_DateLastEdited column
 * @method array<\ChurchCRM\model\ChurchCRM\Family>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Family> findByEnteredBy(int|array<int> $fam_EnteredBy) Return \ChurchCRM\model\ChurchCRM\Family objects filtered by the fam_EnteredBy column
 * @method array<\ChurchCRM\model\ChurchCRM\Family>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Family> findByEditedBy(int|array<int> $fam_EditedBy) Return \ChurchCRM\model\ChurchCRM\Family objects filtered by the fam_EditedBy column
 * @method array<\ChurchCRM\model\ChurchCRM\Family>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Family> findByScanCheck(string|array<string> $fam_scanCheck) Return \ChurchCRM\model\ChurchCRM\Family objects filtered by the fam_scanCheck column
 * @method array<\ChurchCRM\model\ChurchCRM\Family>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Family> findByScanCredit(string|array<string> $fam_scanCredit) Return \ChurchCRM\model\ChurchCRM\Family objects filtered by the fam_scanCredit column
 * @method array<\ChurchCRM\model\ChurchCRM\Family>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Family> findBySendNewsletter(string|array<string> $fam_SendNewsLetter) Return \ChurchCRM\model\ChurchCRM\Family objects filtered by the fam_SendNewsLetter column
 * @method array<\ChurchCRM\model\ChurchCRM\Family>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Family> findByDateDeactivated(string|array<string> $fam_DateDeactivated) Return \ChurchCRM\model\ChurchCRM\Family objects filtered by the fam_DateDeactivated column
 * @method array<\ChurchCRM\model\ChurchCRM\Family>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Family> findByLatitude(float|array<float> $fam_Latitude) Return \ChurchCRM\model\ChurchCRM\Family objects filtered by the fam_Latitude column
 * @method array<\ChurchCRM\model\ChurchCRM\Family>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Family> findByLongitude(float|array<float> $fam_Longitude) Return \ChurchCRM\model\ChurchCRM\Family objects filtered by the fam_Longitude column
 * @method array<\ChurchCRM\model\ChurchCRM\Family>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Family> findByEnvelope(int|array<int> $fam_Envelope) Return \ChurchCRM\model\ChurchCRM\Family objects filtered by the fam_Envelope column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\Family>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class FamilyQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of FamilyQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\Family',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildFamilyQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\FamilyQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildFamilyQuery) {
            return $criteria;
        }
        $query = new ChildFamilyQuery();
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
     * @return \ChurchCRM\model\ChurchCRM\Base\Family|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(FamilyTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = (string)$key;
        $obj = FamilyTableMap::getInstanceFromPool($poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Family|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildFamily
    {
        $sql = 'SELECT fam_ID, fam_Name, fam_Address1, fam_Address2, fam_City, fam_State, fam_Zip, fam_Country, fam_HomePhone, fam_Email, fam_WeddingDate, fam_DateEntered, fam_DateLastEdited, fam_EnteredBy, fam_EditedBy, fam_scanCheck, fam_scanCredit, fam_SendNewsLetter, fam_DateDeactivated, fam_Latitude, fam_Longitude, fam_Envelope FROM family_fam WHERE fam_ID = :p0';
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
            $obj = new ChildFamily();
            $obj->hydrate($row);
            $poolKey = (string)$key;
            FamilyTableMap::addInstanceToPool($obj, $poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Base\Family|mixed|array|null the result, formatted by the current formatter
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
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\Family>|mixed|array the list of results, formatted by the current formatter
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
        $resolvedColumn = $this->resolveLocalColumnByName('fam_ID');
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
        $resolvedColumn = $this->resolveLocalColumnByName('fam_ID');
        $this->addUsingOperator($resolvedColumn, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the fam_ID column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE fam_ID = 1234
     * $query->filterById(array(12, 34)); // WHERE fam_ID IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE fam_ID > 12
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
        $resolvedColumn = $this->resolveLocalColumnByName('fam_ID');
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
     * Filter the query on the fam_Name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue'); // WHERE fam_Name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE fam_Name LIKE '%fooValue%'
     * $query->filterByName(['foo', 'bar']); // WHERE fam_Name IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $name The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByName($name = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('fam_Name');
        if ($comparison === null && is_array($name)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $name, $comparison);

        return $this;
    }

    /**
     * Filter the query on the fam_Address1 column
     *
     * Example usage:
     * <code>
     * $query->filterByAddress1('fooValue'); // WHERE fam_Address1 = 'fooValue'
     * $query->filterByAddress1('%fooValue%', Criteria::LIKE); // WHERE fam_Address1 LIKE '%fooValue%'
     * $query->filterByAddress1(['foo', 'bar']); // WHERE fam_Address1 IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $address1 The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByAddress1($address1 = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('fam_Address1');
        if ($comparison === null && is_array($address1)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $address1, $comparison);

        return $this;
    }

    /**
     * Filter the query on the fam_Address2 column
     *
     * Example usage:
     * <code>
     * $query->filterByAddress2('fooValue'); // WHERE fam_Address2 = 'fooValue'
     * $query->filterByAddress2('%fooValue%', Criteria::LIKE); // WHERE fam_Address2 LIKE '%fooValue%'
     * $query->filterByAddress2(['foo', 'bar']); // WHERE fam_Address2 IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $address2 The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByAddress2($address2 = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('fam_Address2');
        if ($comparison === null && is_array($address2)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $address2, $comparison);

        return $this;
    }

    /**
     * Filter the query on the fam_City column
     *
     * Example usage:
     * <code>
     * $query->filterByCity('fooValue'); // WHERE fam_City = 'fooValue'
     * $query->filterByCity('%fooValue%', Criteria::LIKE); // WHERE fam_City LIKE '%fooValue%'
     * $query->filterByCity(['foo', 'bar']); // WHERE fam_City IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $city The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByCity($city = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('fam_City');
        if ($comparison === null && is_array($city)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $city, $comparison);

        return $this;
    }

    /**
     * Filter the query on the fam_State column
     *
     * Example usage:
     * <code>
     * $query->filterByState('fooValue'); // WHERE fam_State = 'fooValue'
     * $query->filterByState('%fooValue%', Criteria::LIKE); // WHERE fam_State LIKE '%fooValue%'
     * $query->filterByState(['foo', 'bar']); // WHERE fam_State IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $state The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByState($state = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('fam_State');
        if ($comparison === null && is_array($state)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $state, $comparison);

        return $this;
    }

    /**
     * Filter the query on the fam_Zip column
     *
     * Example usage:
     * <code>
     * $query->filterByZip('fooValue'); // WHERE fam_Zip = 'fooValue'
     * $query->filterByZip('%fooValue%', Criteria::LIKE); // WHERE fam_Zip LIKE '%fooValue%'
     * $query->filterByZip(['foo', 'bar']); // WHERE fam_Zip IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $zip The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByZip($zip = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('fam_Zip');
        if ($comparison === null && is_array($zip)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $zip, $comparison);

        return $this;
    }

    /**
     * Filter the query on the fam_Country column
     *
     * Example usage:
     * <code>
     * $query->filterByCountry('fooValue'); // WHERE fam_Country = 'fooValue'
     * $query->filterByCountry('%fooValue%', Criteria::LIKE); // WHERE fam_Country LIKE '%fooValue%'
     * $query->filterByCountry(['foo', 'bar']); // WHERE fam_Country IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $country The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByCountry($country = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('fam_Country');
        if ($comparison === null && is_array($country)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $country, $comparison);

        return $this;
    }

    /**
     * Filter the query on the fam_HomePhone column
     *
     * Example usage:
     * <code>
     * $query->filterByHomePhone('fooValue'); // WHERE fam_HomePhone = 'fooValue'
     * $query->filterByHomePhone('%fooValue%', Criteria::LIKE); // WHERE fam_HomePhone LIKE '%fooValue%'
     * $query->filterByHomePhone(['foo', 'bar']); // WHERE fam_HomePhone IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $homePhone The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByHomePhone($homePhone = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('fam_HomePhone');
        if ($comparison === null && is_array($homePhone)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $homePhone, $comparison);

        return $this;
    }

    /**
     * Filter the query on the fam_Email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue'); // WHERE fam_Email = 'fooValue'
     * $query->filterByEmail('%fooValue%', Criteria::LIKE); // WHERE fam_Email LIKE '%fooValue%'
     * $query->filterByEmail(['foo', 'bar']); // WHERE fam_Email IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $email The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByEmail($email = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('fam_Email');
        if ($comparison === null && is_array($email)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $email, $comparison);

        return $this;
    }

    /**
     * Filter the query on the fam_WeddingDate column
     *
     * Example usage:
     * <code>
     * $query->filterByWeddingdate('2011-03-14'); // WHERE fam_WeddingDate = '2011-03-14'
     * $query->filterByWeddingdate('now'); // WHERE fam_WeddingDate = '2011-03-14'
     * $query->filterByWeddingdate(array('max' => 'yesterday')); // WHERE fam_WeddingDate > '2011-03-13'
     * </code>
     *
     * @param mixed $weddingdate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByWeddingdate($weddingdate = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('fam_WeddingDate');
        if (is_array($weddingdate)) {
            $useMinMax = false;
            if (isset($weddingdate['min'])) {
                $this->addUsingOperator($resolvedColumn, $weddingdate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($weddingdate['max'])) {
                $this->addUsingOperator($resolvedColumn, $weddingdate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $weddingdate, $comparison);

        return $this;
    }

    /**
     * Filter the query on the fam_DateEntered column
     *
     * Example usage:
     * <code>
     * $query->filterByDateEntered('2011-03-14'); // WHERE fam_DateEntered = '2011-03-14'
     * $query->filterByDateEntered('now'); // WHERE fam_DateEntered = '2011-03-14'
     * $query->filterByDateEntered(array('max' => 'yesterday')); // WHERE fam_DateEntered > '2011-03-13'
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
        $resolvedColumn = $this->resolveLocalColumnByName('fam_DateEntered');
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
     * Filter the query on the fam_DateLastEdited column
     *
     * Example usage:
     * <code>
     * $query->filterByDateLastEdited('2011-03-14'); // WHERE fam_DateLastEdited = '2011-03-14'
     * $query->filterByDateLastEdited('now'); // WHERE fam_DateLastEdited = '2011-03-14'
     * $query->filterByDateLastEdited(array('max' => 'yesterday')); // WHERE fam_DateLastEdited > '2011-03-13'
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
        $resolvedColumn = $this->resolveLocalColumnByName('fam_DateLastEdited');
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
     * Filter the query on the fam_EnteredBy column
     *
     * Example usage:
     * <code>
     * $query->filterByEnteredBy(1234); // WHERE fam_EnteredBy = 1234
     * $query->filterByEnteredBy(array(12, 34)); // WHERE fam_EnteredBy IN (12, 34)
     * $query->filterByEnteredBy(array('min' => 12)); // WHERE fam_EnteredBy > 12
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
        $resolvedColumn = $this->resolveLocalColumnByName('fam_EnteredBy');
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
     * Filter the query on the fam_EditedBy column
     *
     * Example usage:
     * <code>
     * $query->filterByEditedBy(1234); // WHERE fam_EditedBy = 1234
     * $query->filterByEditedBy(array(12, 34)); // WHERE fam_EditedBy IN (12, 34)
     * $query->filterByEditedBy(array('min' => 12)); // WHERE fam_EditedBy > 12
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
        $resolvedColumn = $this->resolveLocalColumnByName('fam_EditedBy');
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
     * Filter the query on the fam_scanCheck column
     *
     * Example usage:
     * <code>
     * $query->filterByScanCheck('fooValue'); // WHERE fam_scanCheck = 'fooValue'
     * $query->filterByScanCheck('%fooValue%', Criteria::LIKE); // WHERE fam_scanCheck LIKE '%fooValue%'
     * $query->filterByScanCheck(['foo', 'bar']); // WHERE fam_scanCheck IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $scanCheck The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByScanCheck($scanCheck = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('fam_scanCheck');
        if ($comparison === null && is_array($scanCheck)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $scanCheck, $comparison);

        return $this;
    }

    /**
     * Filter the query on the fam_scanCredit column
     *
     * Example usage:
     * <code>
     * $query->filterByScanCredit('fooValue'); // WHERE fam_scanCredit = 'fooValue'
     * $query->filterByScanCredit('%fooValue%', Criteria::LIKE); // WHERE fam_scanCredit LIKE '%fooValue%'
     * $query->filterByScanCredit(['foo', 'bar']); // WHERE fam_scanCredit IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $scanCredit The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByScanCredit($scanCredit = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('fam_scanCredit');
        if ($comparison === null && is_array($scanCredit)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $scanCredit, $comparison);

        return $this;
    }

    /**
     * Filter the query on the fam_SendNewsLetter column
     *
     * Example usage:
     * <code>
     * $query->filterBySendNewsletter('fooValue'); // WHERE fam_SendNewsLetter = 'fooValue'
     * $query->filterBySendNewsletter('%fooValue%', Criteria::LIKE); // WHERE fam_SendNewsLetter LIKE '%fooValue%'
     * $query->filterBySendNewsletter(['foo', 'bar']); // WHERE fam_SendNewsLetter IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $sendNewsletter The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterBySendNewsletter($sendNewsletter = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('fam_SendNewsLetter');
        if ($comparison === null && is_array($sendNewsletter)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $sendNewsletter, $comparison);

        return $this;
    }

    /**
     * Filter the query on the fam_DateDeactivated column
     *
     * Example usage:
     * <code>
     * $query->filterByDateDeactivated('2011-03-14'); // WHERE fam_DateDeactivated = '2011-03-14'
     * $query->filterByDateDeactivated('now'); // WHERE fam_DateDeactivated = '2011-03-14'
     * $query->filterByDateDeactivated(array('max' => 'yesterday')); // WHERE fam_DateDeactivated > '2011-03-13'
     * </code>
     *
     * @param mixed $dateDeactivated The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByDateDeactivated($dateDeactivated = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('fam_DateDeactivated');
        if (is_array($dateDeactivated)) {
            $useMinMax = false;
            if (isset($dateDeactivated['min'])) {
                $this->addUsingOperator($resolvedColumn, $dateDeactivated['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateDeactivated['max'])) {
                $this->addUsingOperator($resolvedColumn, $dateDeactivated['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $dateDeactivated, $comparison);

        return $this;
    }

    /**
     * Filter the query on the fam_Latitude column
     *
     * Example usage:
     * <code>
     * $query->filterByLatitude(1234); // WHERE fam_Latitude = 1234
     * $query->filterByLatitude(array(12, 34)); // WHERE fam_Latitude IN (12, 34)
     * $query->filterByLatitude(array('min' => 12)); // WHERE fam_Latitude > 12
     * </code>
     *
     * @param mixed $latitude The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByLatitude($latitude = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('fam_Latitude');
        if (is_array($latitude)) {
            $useMinMax = false;
            if (isset($latitude['min'])) {
                $this->addUsingOperator($resolvedColumn, $latitude['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($latitude['max'])) {
                $this->addUsingOperator($resolvedColumn, $latitude['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $latitude, $comparison);

        return $this;
    }

    /**
     * Filter the query on the fam_Longitude column
     *
     * Example usage:
     * <code>
     * $query->filterByLongitude(1234); // WHERE fam_Longitude = 1234
     * $query->filterByLongitude(array(12, 34)); // WHERE fam_Longitude IN (12, 34)
     * $query->filterByLongitude(array('min' => 12)); // WHERE fam_Longitude > 12
     * </code>
     *
     * @param mixed $longitude The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByLongitude($longitude = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('fam_Longitude');
        if (is_array($longitude)) {
            $useMinMax = false;
            if (isset($longitude['min'])) {
                $this->addUsingOperator($resolvedColumn, $longitude['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($longitude['max'])) {
                $this->addUsingOperator($resolvedColumn, $longitude['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $longitude, $comparison);

        return $this;
    }

    /**
     * Filter the query on the fam_Envelope column
     *
     * Example usage:
     * <code>
     * $query->filterByEnvelope(1234); // WHERE fam_Envelope = 1234
     * $query->filterByEnvelope(array(12, 34)); // WHERE fam_Envelope IN (12, 34)
     * $query->filterByEnvelope(array('min' => 12)); // WHERE fam_Envelope > 12
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
        $resolvedColumn = $this->resolveLocalColumnByName('fam_Envelope');
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
     * Filter the query by a related Person object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Person|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Person> $person the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this
     */
    public function filterByPerson(Person|ObjectCollection $person, ?string $comparison = null)
    {
        if ($person instanceof Person) {
            $this
                ->addUsingOperator($this->resolveLocalColumnByName('fam_ID'), $person->getFamId(), $comparison);
        } elseif ($person instanceof ObjectCollection) {
            $this
                ->usePersonQuery()
                ->filterByPrimaryKeys($person->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPerson() only accepts arguments of type \ChurchCRM\model\ChurchCRM\Base\Person or Collection');
        }

        return $this;
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
     * Filter the query by a related FamilyCustom object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\FamilyCustom|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\FamilyCustom> $familyCustom the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this
     */
    public function filterByFamilyCustom(FamilyCustom|ObjectCollection $familyCustom, ?string $comparison = null)
    {
        if ($familyCustom instanceof FamilyCustom) {
            $this
                ->addUsingOperator($this->resolveLocalColumnByName('fam_ID'), $familyCustom->getFamId(), $comparison);
        } elseif ($familyCustom instanceof ObjectCollection) {
            $this
                ->useFamilyCustomQuery()
                ->filterByPrimaryKeys($familyCustom->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFamilyCustom() only accepts arguments of type \ChurchCRM\model\ChurchCRM\Base\FamilyCustom or Collection');
        }

        return $this;
    }

    /**
     * Adds a JOIN clause to the query using the FamilyCustom relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinFamilyCustom(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FamilyCustom');

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
            $this->addJoinObject($join, 'FamilyCustom');
        }

        return $this;
    }

    /**
     * Use the FamilyCustom relation FamilyCustom object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\FamilyCustomQuery<static> A secondary query class using the current class as primary query
     */
    public function useFamilyCustomQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\FamilyCustomQuery<static> $query */
        $query = $this->joinFamilyCustom($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'FamilyCustom', '\ChurchCRM\model\ChurchCRM\FamilyCustomQuery');

        return $query;
    }

    /**
     * Use the FamilyCustom relation FamilyCustom object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\FamilyCustomQuery<mixed>):\ChurchCRM\model\ChurchCRM\FamilyCustomQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withFamilyCustomQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useFamilyCustomQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to FamilyCustom table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\FamilyCustomQuery<static> The inner query object of the EXISTS statement
     */
    public function useFamilyCustomExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\FamilyCustomQuery<static> $q */
        $q = $this->useExistsQuery('FamilyCustom', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to FamilyCustom table for a NOT EXISTS query.
     *
     * @see useFamilyCustomExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\FamilyCustomQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function useFamilyCustomNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\FamilyCustomQuery<static> $q*/
        $q = $this->useExistsQuery('FamilyCustom', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to FamilyCustom table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\FamilyCustomQuery<static> The inner query object of the IN statement
     */
    public function useInFamilyCustomQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\FamilyCustomQuery<static> $q */
        $q = $this->useInQuery('FamilyCustom', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to FamilyCustom table for a NOT IN query.
     *
     * @see useFamilyCustomInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\FamilyCustomQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInFamilyCustomQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\FamilyCustomQuery<static> $q */
        $q = $this->useInQuery('FamilyCustom', $modelAlias, $queryClass, Criteria::NOT_IN);

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
                ->addUsingOperator($this->resolveLocalColumnByName('fam_ID'), $note->getFamId(), $comparison);
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
                ->addUsingOperator($this->resolveLocalColumnByName('fam_ID'), $pledge->getFamId(), $comparison);
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
    public function joinPledge(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
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
    public function usePledgeQuery(?string $relationAlias = null, string $joinType = Criteria::LEFT_JOIN)
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
        ?string $joinType = Criteria::LEFT_JOIN
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
     * Exclude object from result
     *
     * @param \ChurchCRM\model\ChurchCRM\Family|null $family Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildFamily $family = null)
    {
        if ($family) {
            $resolvedColumn = $this->resolveLocalColumnByName('fam_ID');
            $this->addUsingOperator($resolvedColumn, $family->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the family_fam table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FamilyTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            FamilyTableMap::clearInstancePool();
            FamilyTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(FamilyTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(FamilyTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            FamilyTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            FamilyTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
