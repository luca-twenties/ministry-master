<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Map\UserTableMap;
use ChurchCRM\model\ChurchCRM\User as ChildUser;
use ChurchCRM\model\ChurchCRM\UserQuery as ChildUserQuery;
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
 * Base class that represents a query for the `user_usr` table.
 *
 * This contains the login information and specific settings for each ChurchCRM user
 *
 * @method static orderByPersonId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_per_ID column
 * @method static orderByPassword($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_Password column
 * @method static orderByNeedPasswordChange($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_NeedPasswordChange column
 * @method static orderByLastLogin($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_LastLogin column
 * @method static orderByLoginCount($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_LoginCount column
 * @method static orderByFailedLogins($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_FailedLogins column
 * @method static orderByAddRecords($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_AddRecords column
 * @method static orderByEditRecords($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_EditRecords column
 * @method static orderByDeleteRecords($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_DeleteRecords column
 * @method static orderByMenuOptions($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_MenuOptions column
 * @method static orderByManageGroups($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_ManageGroups column
 * @method static orderByFinance($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_Finance column
 * @method static orderByNotes($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_Notes column
 * @method static orderByAdmin($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_Admin column
 * @method static orderByDefaultFY($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_defaultFY column
 * @method static orderByCurrentDeposit($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_currentDeposit column
 * @method static orderByUserName($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_UserName column
 * @method static orderByUserStyle($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_Style column
 * @method static orderByApiKey($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_ApiKey column
 * @method static orderByTwoFactorAuthSecret($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_TwoFactorAuthSecret column
 * @method static orderByTwoFactorAuthLastKeyTimestamp($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_TwoFactorAuthLastKeyTimestamp column
 * @method static orderByTwoFactorAuthRecoveryCodes($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_TwoFactorAuthRecoveryCodes column
 * @method static orderByEditSelf($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_EditSelf column
 * @method static orderByCalStart($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_CalStart column
 * @method static orderByCalEnd($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_CalEnd column
 * @method static orderByCalNoSchool1($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_CalNoSchool1 column
 * @method static orderByCalNoSchool2($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_CalNoSchool2 column
 * @method static orderByCalNoSchool3($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_CalNoSchool3 column
 * @method static orderByCalNoSchool4($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_CalNoSchool4 column
 * @method static orderByCalNoSchool5($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_CalNoSchool5 column
 * @method static orderByCalNoSchool6($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_CalNoSchool6 column
 * @method static orderByCalNoSchool7($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_CalNoSchool7 column
 * @method static orderByCalNoSchool8($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_CalNoSchool8 column
 * @method static orderBySearchfamily($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the usr_SearchFamily column
 *
 * @method static groupByPersonId() Group by the usr_per_ID column
 * @method static groupByPassword() Group by the usr_Password column
 * @method static groupByNeedPasswordChange() Group by the usr_NeedPasswordChange column
 * @method static groupByLastLogin() Group by the usr_LastLogin column
 * @method static groupByLoginCount() Group by the usr_LoginCount column
 * @method static groupByFailedLogins() Group by the usr_FailedLogins column
 * @method static groupByAddRecords() Group by the usr_AddRecords column
 * @method static groupByEditRecords() Group by the usr_EditRecords column
 * @method static groupByDeleteRecords() Group by the usr_DeleteRecords column
 * @method static groupByMenuOptions() Group by the usr_MenuOptions column
 * @method static groupByManageGroups() Group by the usr_ManageGroups column
 * @method static groupByFinance() Group by the usr_Finance column
 * @method static groupByNotes() Group by the usr_Notes column
 * @method static groupByAdmin() Group by the usr_Admin column
 * @method static groupByDefaultFY() Group by the usr_defaultFY column
 * @method static groupByCurrentDeposit() Group by the usr_currentDeposit column
 * @method static groupByUserName() Group by the usr_UserName column
 * @method static groupByUserStyle() Group by the usr_Style column
 * @method static groupByApiKey() Group by the usr_ApiKey column
 * @method static groupByTwoFactorAuthSecret() Group by the usr_TwoFactorAuthSecret column
 * @method static groupByTwoFactorAuthLastKeyTimestamp() Group by the usr_TwoFactorAuthLastKeyTimestamp column
 * @method static groupByTwoFactorAuthRecoveryCodes() Group by the usr_TwoFactorAuthRecoveryCodes column
 * @method static groupByEditSelf() Group by the usr_EditSelf column
 * @method static groupByCalStart() Group by the usr_CalStart column
 * @method static groupByCalEnd() Group by the usr_CalEnd column
 * @method static groupByCalNoSchool1() Group by the usr_CalNoSchool1 column
 * @method static groupByCalNoSchool2() Group by the usr_CalNoSchool2 column
 * @method static groupByCalNoSchool3() Group by the usr_CalNoSchool3 column
 * @method static groupByCalNoSchool4() Group by the usr_CalNoSchool4 column
 * @method static groupByCalNoSchool5() Group by the usr_CalNoSchool5 column
 * @method static groupByCalNoSchool6() Group by the usr_CalNoSchool6 column
 * @method static groupByCalNoSchool7() Group by the usr_CalNoSchool7 column
 * @method static groupByCalNoSchool8() Group by the usr_CalNoSchool8 column
 * @method static groupBySearchfamily() Group by the usr_SearchFamily column
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
 * @method static leftJoinUserConfig($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserConfig relation
 * @method static rightJoinUserConfig($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserConfig relation
 * @method static innerJoinUserConfig($relationAlias = null) Adds a INNER JOIN clause to the query using the UserConfig relation
 *
 * @method static joinWithUserConfig($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserConfig relation
 *
 * @method static leftJoinWithUserConfig() Adds a LEFT JOIN clause and with to the query using the UserConfig relation
 * @method static rightJoinWithUserConfig() Adds a RIGHT JOIN clause and with to the query using the UserConfig relation
 * @method static innerJoinWithUserConfig() Adds a INNER JOIN clause and with to the query using the UserConfig relation
 *
 * @method static leftJoinUserSetting($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserSetting relation
 * @method static rightJoinUserSetting($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserSetting relation
 * @method static innerJoinUserSetting($relationAlias = null) Adds a INNER JOIN clause to the query using the UserSetting relation
 *
 * @method static joinWithUserSetting($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserSetting relation
 *
 * @method static leftJoinWithUserSetting() Adds a LEFT JOIN clause and with to the query using the UserSetting relation
 * @method static rightJoinWithUserSetting() Adds a RIGHT JOIN clause and with to the query using the UserSetting relation
 * @method static innerJoinWithUserSetting() Adds a INNER JOIN clause and with to the query using the UserSetting relation
 *
 * @method \ChurchCRM\model\ChurchCRM\User|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\User matching the query
 * @method \ChurchCRM\model\ChurchCRM\User findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\User matching the query, or a new \ChurchCRM\model\ChurchCRM\User object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByPersonId(int $usr_per_ID) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_per_ID column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByPassword(string $usr_Password) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_Password column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByNeedPasswordChange(bool $usr_NeedPasswordChange) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_NeedPasswordChange column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByLastLogin(string $usr_LastLogin) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_LastLogin column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByLoginCount(int $usr_LoginCount) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_LoginCount column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByFailedLogins(int $usr_FailedLogins) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_FailedLogins column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByAddRecords(bool $usr_AddRecords) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_AddRecords column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByEditRecords(bool $usr_EditRecords) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_EditRecords column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByDeleteRecords(bool $usr_DeleteRecords) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_DeleteRecords column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByMenuOptions(bool $usr_MenuOptions) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_MenuOptions column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByManageGroups(bool $usr_ManageGroups) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_ManageGroups column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByFinance(bool $usr_Finance) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_Finance column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByNotes(bool $usr_Notes) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_Notes column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByAdmin(bool $usr_Admin) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_Admin column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByDefaultFY(int $usr_defaultFY) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_defaultFY column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByCurrentDeposit(int $usr_currentDeposit) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_currentDeposit column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByUserName(string $usr_UserName) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_UserName column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByUserStyle(string $usr_Style) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_Style column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByApiKey(string $usr_ApiKey) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_ApiKey column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByTwoFactorAuthSecret(string $usr_TwoFactorAuthSecret) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_TwoFactorAuthSecret column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByTwoFactorAuthLastKeyTimestamp(int $usr_TwoFactorAuthLastKeyTimestamp) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_TwoFactorAuthLastKeyTimestamp column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByTwoFactorAuthRecoveryCodes(string $usr_TwoFactorAuthRecoveryCodes) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_TwoFactorAuthRecoveryCodes column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByEditSelf(bool $usr_EditSelf) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_EditSelf column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByCalStart(string $usr_CalStart) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_CalStart column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByCalEnd(string $usr_CalEnd) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_CalEnd column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByCalNoSchool1(string $usr_CalNoSchool1) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_CalNoSchool1 column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByCalNoSchool2(string $usr_CalNoSchool2) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_CalNoSchool2 column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByCalNoSchool3(string $usr_CalNoSchool3) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_CalNoSchool3 column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByCalNoSchool4(string $usr_CalNoSchool4) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_CalNoSchool4 column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByCalNoSchool5(string $usr_CalNoSchool5) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_CalNoSchool5 column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByCalNoSchool6(string $usr_CalNoSchool6) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_CalNoSchool6 column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByCalNoSchool7(string $usr_CalNoSchool7) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_CalNoSchool7 column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneByCalNoSchool8(string $usr_CalNoSchool8) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_CalNoSchool8 column
 * @method \ChurchCRM\model\ChurchCRM\User|null findOneBySearchfamily(int $usr_SearchFamily) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_SearchFamily column
 *
 * @method \ChurchCRM\model\ChurchCRM\User requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\User by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\User matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByPersonId(int $usr_per_ID) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_per_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByPassword(string $usr_Password) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_Password column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByNeedPasswordChange(bool $usr_NeedPasswordChange) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_NeedPasswordChange column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByLastLogin(string $usr_LastLogin) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_LastLogin column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByLoginCount(int $usr_LoginCount) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_LoginCount column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByFailedLogins(int $usr_FailedLogins) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_FailedLogins column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByAddRecords(bool $usr_AddRecords) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_AddRecords column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByEditRecords(bool $usr_EditRecords) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_EditRecords column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByDeleteRecords(bool $usr_DeleteRecords) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_DeleteRecords column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByMenuOptions(bool $usr_MenuOptions) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_MenuOptions column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByManageGroups(bool $usr_ManageGroups) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_ManageGroups column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByFinance(bool $usr_Finance) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_Finance column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByNotes(bool $usr_Notes) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_Notes column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByAdmin(bool $usr_Admin) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_Admin column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByDefaultFY(int $usr_defaultFY) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_defaultFY column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByCurrentDeposit(int $usr_currentDeposit) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_currentDeposit column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByUserName(string $usr_UserName) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_UserName column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByUserStyle(string $usr_Style) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_Style column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByApiKey(string $usr_ApiKey) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_ApiKey column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByTwoFactorAuthSecret(string $usr_TwoFactorAuthSecret) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_TwoFactorAuthSecret column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByTwoFactorAuthLastKeyTimestamp(int $usr_TwoFactorAuthLastKeyTimestamp) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_TwoFactorAuthLastKeyTimestamp column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByTwoFactorAuthRecoveryCodes(string $usr_TwoFactorAuthRecoveryCodes) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_TwoFactorAuthRecoveryCodes column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByEditSelf(bool $usr_EditSelf) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_EditSelf column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByCalStart(string $usr_CalStart) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_CalStart column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByCalEnd(string $usr_CalEnd) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_CalEnd column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByCalNoSchool1(string $usr_CalNoSchool1) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_CalNoSchool1 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByCalNoSchool2(string $usr_CalNoSchool2) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_CalNoSchool2 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByCalNoSchool3(string $usr_CalNoSchool3) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_CalNoSchool3 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByCalNoSchool4(string $usr_CalNoSchool4) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_CalNoSchool4 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByCalNoSchool5(string $usr_CalNoSchool5) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_CalNoSchool5 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByCalNoSchool6(string $usr_CalNoSchool6) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_CalNoSchool6 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByCalNoSchool7(string $usr_CalNoSchool7) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_CalNoSchool7 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneByCalNoSchool8(string $usr_CalNoSchool8) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_CalNoSchool8 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\User requireOneBySearchfamily(int $usr_SearchFamily) Return the first \ChurchCRM\model\ChurchCRM\User filtered by the usr_SearchFamily column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\UserCollection|array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\User objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\UserCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\User objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByPersonId(int|array<int> $usr_per_ID) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_per_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByPassword(string|array<string> $usr_Password) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_Password column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByNeedPasswordChange(bool|array<bool> $usr_NeedPasswordChange) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_NeedPasswordChange column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByLastLogin(string|array<string> $usr_LastLogin) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_LastLogin column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByLoginCount(int|array<int> $usr_LoginCount) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_LoginCount column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByFailedLogins(int|array<int> $usr_FailedLogins) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_FailedLogins column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByAddRecords(bool|array<bool> $usr_AddRecords) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_AddRecords column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByEditRecords(bool|array<bool> $usr_EditRecords) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_EditRecords column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByDeleteRecords(bool|array<bool> $usr_DeleteRecords) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_DeleteRecords column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByMenuOptions(bool|array<bool> $usr_MenuOptions) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_MenuOptions column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByManageGroups(bool|array<bool> $usr_ManageGroups) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_ManageGroups column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByFinance(bool|array<bool> $usr_Finance) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_Finance column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByNotes(bool|array<bool> $usr_Notes) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_Notes column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByAdmin(bool|array<bool> $usr_Admin) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_Admin column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByDefaultFY(int|array<int> $usr_defaultFY) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_defaultFY column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByCurrentDeposit(int|array<int> $usr_currentDeposit) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_currentDeposit column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByUserName(string|array<string> $usr_UserName) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_UserName column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByUserStyle(string|array<string> $usr_Style) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_Style column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByApiKey(string|array<string> $usr_ApiKey) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_ApiKey column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByTwoFactorAuthSecret(string|array<string> $usr_TwoFactorAuthSecret) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_TwoFactorAuthSecret column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByTwoFactorAuthLastKeyTimestamp(int|array<int> $usr_TwoFactorAuthLastKeyTimestamp) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_TwoFactorAuthLastKeyTimestamp column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByTwoFactorAuthRecoveryCodes(string|array<string> $usr_TwoFactorAuthRecoveryCodes) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_TwoFactorAuthRecoveryCodes column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByEditSelf(bool|array<bool> $usr_EditSelf) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_EditSelf column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByCalStart(string|array<string> $usr_CalStart) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_CalStart column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByCalEnd(string|array<string> $usr_CalEnd) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_CalEnd column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByCalNoSchool1(string|array<string> $usr_CalNoSchool1) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_CalNoSchool1 column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByCalNoSchool2(string|array<string> $usr_CalNoSchool2) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_CalNoSchool2 column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByCalNoSchool3(string|array<string> $usr_CalNoSchool3) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_CalNoSchool3 column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByCalNoSchool4(string|array<string> $usr_CalNoSchool4) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_CalNoSchool4 column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByCalNoSchool5(string|array<string> $usr_CalNoSchool5) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_CalNoSchool5 column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByCalNoSchool6(string|array<string> $usr_CalNoSchool6) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_CalNoSchool6 column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByCalNoSchool7(string|array<string> $usr_CalNoSchool7) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_CalNoSchool7 column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findByCalNoSchool8(string|array<string> $usr_CalNoSchool8) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_CalNoSchool8 column
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\User> findBySearchfamily(int|array<int> $usr_SearchFamily) Return \ChurchCRM\model\ChurchCRM\User objects filtered by the usr_SearchFamily column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\User>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class UserQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of UserQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\User',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUserQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\UserQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildUserQuery) {
            return $criteria;
        }
        $query = new ChildUserQuery();
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
     * @return \ChurchCRM\model\ChurchCRM\Base\User|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UserTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = (string)$key;
        $obj = UserTableMap::getInstanceFromPool($poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\User|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildUser
    {
        $sql = 'SELECT usr_per_ID, usr_Password, usr_NeedPasswordChange, usr_LastLogin, usr_LoginCount, usr_FailedLogins, usr_AddRecords, usr_EditRecords, usr_DeleteRecords, usr_MenuOptions, usr_ManageGroups, usr_Finance, usr_Notes, usr_Admin, usr_defaultFY, usr_currentDeposit, usr_UserName, usr_Style, usr_ApiKey, usr_TwoFactorAuthSecret, usr_TwoFactorAuthLastKeyTimestamp, usr_TwoFactorAuthRecoveryCodes, usr_EditSelf, usr_CalStart, usr_CalEnd, usr_CalNoSchool1, usr_CalNoSchool2, usr_CalNoSchool3, usr_CalNoSchool4, usr_CalNoSchool5, usr_CalNoSchool6, usr_CalNoSchool7, usr_CalNoSchool8, usr_SearchFamily FROM user_usr WHERE usr_per_ID = :p0';
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
            $obj = new ChildUser();
            $obj->hydrate($row);
            $poolKey = (string)$key;
            UserTableMap::addInstanceToPool($obj, $poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Base\User|mixed|array|null the result, formatted by the current formatter
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
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\User>|mixed|array the list of results, formatted by the current formatter
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
        $resolvedColumn = $this->resolveLocalColumnByName('usr_per_ID');
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
        $resolvedColumn = $this->resolveLocalColumnByName('usr_per_ID');
        $this->addUsingOperator($resolvedColumn, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the usr_per_ID column
     *
     * Example usage:
     * <code>
     * $query->filterByPersonId(1234); // WHERE usr_per_ID = 1234
     * $query->filterByPersonId(array(12, 34)); // WHERE usr_per_ID IN (12, 34)
     * $query->filterByPersonId(array('min' => 12)); // WHERE usr_per_ID > 12
     * </code>
     *
     * @see static::filterByPerson()
     *
     * @param mixed $personId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByPersonId($personId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_per_ID');
        if (is_array($personId)) {
            $useMinMax = false;
            if (isset($personId['min'])) {
                $this->addUsingOperator($resolvedColumn, $personId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($personId['max'])) {
                $this->addUsingOperator($resolvedColumn, $personId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $personId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_Password column
     *
     * Example usage:
     * <code>
     * $query->filterByPassword('fooValue'); // WHERE usr_Password = 'fooValue'
     * $query->filterByPassword('%fooValue%', Criteria::LIKE); // WHERE usr_Password LIKE '%fooValue%'
     * $query->filterByPassword(['foo', 'bar']); // WHERE usr_Password IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $password The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByPassword($password = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_Password');
        if ($comparison === null && is_array($password)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $password, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_NeedPasswordChange column
     *
     * Example usage:
     * <code>
     * $query->filterByNeedPasswordChange(true); // WHERE usr_NeedPasswordChange = true
     * $query->filterByNeedPasswordChange('yes'); // WHERE usr_NeedPasswordChange = true
     * </code>
     *
     * @param string|bool|null $needPasswordChange The value to use as filter.
     *      Non-boolean arguments are converted using the following rules:
     *          - 1, '1', 'true', 'on', and 'yes' are converted to boolean true
     *          - 0, '0', 'false', 'off', and 'no' are converted to boolean false
     *      Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByNeedPasswordChange($needPasswordChange = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_NeedPasswordChange');
        if (is_string($needPasswordChange)) {
            $needPasswordChange = in_array(strtolower($needPasswordChange), ['false', 'off', '-', 'no', 'n', '0', ''], true) ? false : true;
        }
        $this->addUsingOperator($resolvedColumn, $needPasswordChange, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_LastLogin column
     *
     * Example usage:
     * <code>
     * $query->filterByLastLogin('2011-03-14'); // WHERE usr_LastLogin = '2011-03-14'
     * $query->filterByLastLogin('now'); // WHERE usr_LastLogin = '2011-03-14'
     * $query->filterByLastLogin(array('max' => 'yesterday')); // WHERE usr_LastLogin > '2011-03-13'
     * </code>
     *
     * @param mixed $lastLogin The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByLastLogin($lastLogin = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_LastLogin');
        if (is_array($lastLogin)) {
            $useMinMax = false;
            if (isset($lastLogin['min'])) {
                $this->addUsingOperator($resolvedColumn, $lastLogin['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastLogin['max'])) {
                $this->addUsingOperator($resolvedColumn, $lastLogin['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $lastLogin, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_LoginCount column
     *
     * Example usage:
     * <code>
     * $query->filterByLoginCount(1234); // WHERE usr_LoginCount = 1234
     * $query->filterByLoginCount(array(12, 34)); // WHERE usr_LoginCount IN (12, 34)
     * $query->filterByLoginCount(array('min' => 12)); // WHERE usr_LoginCount > 12
     * </code>
     *
     * @param mixed $loginCount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByLoginCount($loginCount = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_LoginCount');
        if (is_array($loginCount)) {
            $useMinMax = false;
            if (isset($loginCount['min'])) {
                $this->addUsingOperator($resolvedColumn, $loginCount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($loginCount['max'])) {
                $this->addUsingOperator($resolvedColumn, $loginCount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $loginCount, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_FailedLogins column
     *
     * Example usage:
     * <code>
     * $query->filterByFailedLogins(1234); // WHERE usr_FailedLogins = 1234
     * $query->filterByFailedLogins(array(12, 34)); // WHERE usr_FailedLogins IN (12, 34)
     * $query->filterByFailedLogins(array('min' => 12)); // WHERE usr_FailedLogins > 12
     * </code>
     *
     * @param mixed $failedLogins The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByFailedLogins($failedLogins = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_FailedLogins');
        if (is_array($failedLogins)) {
            $useMinMax = false;
            if (isset($failedLogins['min'])) {
                $this->addUsingOperator($resolvedColumn, $failedLogins['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($failedLogins['max'])) {
                $this->addUsingOperator($resolvedColumn, $failedLogins['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $failedLogins, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_AddRecords column
     *
     * Example usage:
     * <code>
     * $query->filterByAddRecords(true); // WHERE usr_AddRecords = true
     * $query->filterByAddRecords('yes'); // WHERE usr_AddRecords = true
     * </code>
     *
     * @param string|bool|null $addRecords The value to use as filter.
     *      Non-boolean arguments are converted using the following rules:
     *          - 1, '1', 'true', 'on', and 'yes' are converted to boolean true
     *          - 0, '0', 'false', 'off', and 'no' are converted to boolean false
     *      Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByAddRecords($addRecords = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_AddRecords');
        if (is_string($addRecords)) {
            $addRecords = in_array(strtolower($addRecords), ['false', 'off', '-', 'no', 'n', '0', ''], true) ? false : true;
        }
        $this->addUsingOperator($resolvedColumn, $addRecords, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_EditRecords column
     *
     * Example usage:
     * <code>
     * $query->filterByEditRecords(true); // WHERE usr_EditRecords = true
     * $query->filterByEditRecords('yes'); // WHERE usr_EditRecords = true
     * </code>
     *
     * @param string|bool|null $editRecords The value to use as filter.
     *      Non-boolean arguments are converted using the following rules:
     *          - 1, '1', 'true', 'on', and 'yes' are converted to boolean true
     *          - 0, '0', 'false', 'off', and 'no' are converted to boolean false
     *      Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByEditRecords($editRecords = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_EditRecords');
        if (is_string($editRecords)) {
            $editRecords = in_array(strtolower($editRecords), ['false', 'off', '-', 'no', 'n', '0', ''], true) ? false : true;
        }
        $this->addUsingOperator($resolvedColumn, $editRecords, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_DeleteRecords column
     *
     * Example usage:
     * <code>
     * $query->filterByDeleteRecords(true); // WHERE usr_DeleteRecords = true
     * $query->filterByDeleteRecords('yes'); // WHERE usr_DeleteRecords = true
     * </code>
     *
     * @param string|bool|null $deleteRecords The value to use as filter.
     *      Non-boolean arguments are converted using the following rules:
     *          - 1, '1', 'true', 'on', and 'yes' are converted to boolean true
     *          - 0, '0', 'false', 'off', and 'no' are converted to boolean false
     *      Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByDeleteRecords($deleteRecords = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_DeleteRecords');
        if (is_string($deleteRecords)) {
            $deleteRecords = in_array(strtolower($deleteRecords), ['false', 'off', '-', 'no', 'n', '0', ''], true) ? false : true;
        }
        $this->addUsingOperator($resolvedColumn, $deleteRecords, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_MenuOptions column
     *
     * Example usage:
     * <code>
     * $query->filterByMenuOptions(true); // WHERE usr_MenuOptions = true
     * $query->filterByMenuOptions('yes'); // WHERE usr_MenuOptions = true
     * </code>
     *
     * @param string|bool|null $menuOptions The value to use as filter.
     *      Non-boolean arguments are converted using the following rules:
     *          - 1, '1', 'true', 'on', and 'yes' are converted to boolean true
     *          - 0, '0', 'false', 'off', and 'no' are converted to boolean false
     *      Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByMenuOptions($menuOptions = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_MenuOptions');
        if (is_string($menuOptions)) {
            $menuOptions = in_array(strtolower($menuOptions), ['false', 'off', '-', 'no', 'n', '0', ''], true) ? false : true;
        }
        $this->addUsingOperator($resolvedColumn, $menuOptions, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_ManageGroups column
     *
     * Example usage:
     * <code>
     * $query->filterByManageGroups(true); // WHERE usr_ManageGroups = true
     * $query->filterByManageGroups('yes'); // WHERE usr_ManageGroups = true
     * </code>
     *
     * @param string|bool|null $manageGroups The value to use as filter.
     *      Non-boolean arguments are converted using the following rules:
     *          - 1, '1', 'true', 'on', and 'yes' are converted to boolean true
     *          - 0, '0', 'false', 'off', and 'no' are converted to boolean false
     *      Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByManageGroups($manageGroups = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_ManageGroups');
        if (is_string($manageGroups)) {
            $manageGroups = in_array(strtolower($manageGroups), ['false', 'off', '-', 'no', 'n', '0', ''], true) ? false : true;
        }
        $this->addUsingOperator($resolvedColumn, $manageGroups, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_Finance column
     *
     * Example usage:
     * <code>
     * $query->filterByFinance(true); // WHERE usr_Finance = true
     * $query->filterByFinance('yes'); // WHERE usr_Finance = true
     * </code>
     *
     * @param string|bool|null $finance The value to use as filter.
     *      Non-boolean arguments are converted using the following rules:
     *          - 1, '1', 'true', 'on', and 'yes' are converted to boolean true
     *          - 0, '0', 'false', 'off', and 'no' are converted to boolean false
     *      Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByFinance($finance = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_Finance');
        if (is_string($finance)) {
            $finance = in_array(strtolower($finance), ['false', 'off', '-', 'no', 'n', '0', ''], true) ? false : true;
        }
        $this->addUsingOperator($resolvedColumn, $finance, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_Notes column
     *
     * Example usage:
     * <code>
     * $query->filterByNotes(true); // WHERE usr_Notes = true
     * $query->filterByNotes('yes'); // WHERE usr_Notes = true
     * </code>
     *
     * @param string|bool|null $notes The value to use as filter.
     *      Non-boolean arguments are converted using the following rules:
     *          - 1, '1', 'true', 'on', and 'yes' are converted to boolean true
     *          - 0, '0', 'false', 'off', and 'no' are converted to boolean false
     *      Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByNotes($notes = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_Notes');
        if (is_string($notes)) {
            $notes = in_array(strtolower($notes), ['false', 'off', '-', 'no', 'n', '0', ''], true) ? false : true;
        }
        $this->addUsingOperator($resolvedColumn, $notes, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_Admin column
     *
     * Example usage:
     * <code>
     * $query->filterByAdmin(true); // WHERE usr_Admin = true
     * $query->filterByAdmin('yes'); // WHERE usr_Admin = true
     * </code>
     *
     * @param string|bool|null $admin The value to use as filter.
     *      Non-boolean arguments are converted using the following rules:
     *          - 1, '1', 'true', 'on', and 'yes' are converted to boolean true
     *          - 0, '0', 'false', 'off', and 'no' are converted to boolean false
     *      Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByAdmin($admin = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_Admin');
        if (is_string($admin)) {
            $admin = in_array(strtolower($admin), ['false', 'off', '-', 'no', 'n', '0', ''], true) ? false : true;
        }
        $this->addUsingOperator($resolvedColumn, $admin, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_defaultFY column
     *
     * Example usage:
     * <code>
     * $query->filterByDefaultFY(1234); // WHERE usr_defaultFY = 1234
     * $query->filterByDefaultFY(array(12, 34)); // WHERE usr_defaultFY IN (12, 34)
     * $query->filterByDefaultFY(array('min' => 12)); // WHERE usr_defaultFY > 12
     * </code>
     *
     * @param mixed $defaultFY The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByDefaultFY($defaultFY = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_defaultFY');
        if (is_array($defaultFY)) {
            $useMinMax = false;
            if (isset($defaultFY['min'])) {
                $this->addUsingOperator($resolvedColumn, $defaultFY['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($defaultFY['max'])) {
                $this->addUsingOperator($resolvedColumn, $defaultFY['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $defaultFY, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_currentDeposit column
     *
     * Example usage:
     * <code>
     * $query->filterByCurrentDeposit(1234); // WHERE usr_currentDeposit = 1234
     * $query->filterByCurrentDeposit(array(12, 34)); // WHERE usr_currentDeposit IN (12, 34)
     * $query->filterByCurrentDeposit(array('min' => 12)); // WHERE usr_currentDeposit > 12
     * </code>
     *
     * @param mixed $currentDeposit The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByCurrentDeposit($currentDeposit = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_currentDeposit');
        if (is_array($currentDeposit)) {
            $useMinMax = false;
            if (isset($currentDeposit['min'])) {
                $this->addUsingOperator($resolvedColumn, $currentDeposit['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($currentDeposit['max'])) {
                $this->addUsingOperator($resolvedColumn, $currentDeposit['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $currentDeposit, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_UserName column
     *
     * Example usage:
     * <code>
     * $query->filterByUserName('fooValue'); // WHERE usr_UserName = 'fooValue'
     * $query->filterByUserName('%fooValue%', Criteria::LIKE); // WHERE usr_UserName LIKE '%fooValue%'
     * $query->filterByUserName(['foo', 'bar']); // WHERE usr_UserName IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $userName The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByUserName($userName = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_UserName');
        if ($comparison === null && is_array($userName)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $userName, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_Style column
     *
     * Example usage:
     * <code>
     * $query->filterByUserStyle('fooValue'); // WHERE usr_Style = 'fooValue'
     * $query->filterByUserStyle('%fooValue%', Criteria::LIKE); // WHERE usr_Style LIKE '%fooValue%'
     * $query->filterByUserStyle(['foo', 'bar']); // WHERE usr_Style IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $userStyle The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByUserStyle($userStyle = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_Style');
        if ($comparison === null && is_array($userStyle)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $userStyle, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_ApiKey column
     *
     * Example usage:
     * <code>
     * $query->filterByApiKey('fooValue'); // WHERE usr_ApiKey = 'fooValue'
     * $query->filterByApiKey('%fooValue%', Criteria::LIKE); // WHERE usr_ApiKey LIKE '%fooValue%'
     * $query->filterByApiKey(['foo', 'bar']); // WHERE usr_ApiKey IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $apiKey The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByApiKey($apiKey = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_ApiKey');
        if ($comparison === null && is_array($apiKey)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $apiKey, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_TwoFactorAuthSecret column
     *
     * Example usage:
     * <code>
     * $query->filterByTwoFactorAuthSecret('fooValue'); // WHERE usr_TwoFactorAuthSecret = 'fooValue'
     * $query->filterByTwoFactorAuthSecret('%fooValue%', Criteria::LIKE); // WHERE usr_TwoFactorAuthSecret LIKE '%fooValue%'
     * $query->filterByTwoFactorAuthSecret(['foo', 'bar']); // WHERE usr_TwoFactorAuthSecret IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $twoFactorAuthSecret The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByTwoFactorAuthSecret($twoFactorAuthSecret = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_TwoFactorAuthSecret');
        if ($comparison === null && is_array($twoFactorAuthSecret)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $twoFactorAuthSecret, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_TwoFactorAuthLastKeyTimestamp column
     *
     * Example usage:
     * <code>
     * $query->filterByTwoFactorAuthLastKeyTimestamp(1234); // WHERE usr_TwoFactorAuthLastKeyTimestamp = 1234
     * $query->filterByTwoFactorAuthLastKeyTimestamp(array(12, 34)); // WHERE usr_TwoFactorAuthLastKeyTimestamp IN (12, 34)
     * $query->filterByTwoFactorAuthLastKeyTimestamp(array('min' => 12)); // WHERE usr_TwoFactorAuthLastKeyTimestamp > 12
     * </code>
     *
     * @param mixed $twoFactorAuthLastKeyTimestamp The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByTwoFactorAuthLastKeyTimestamp($twoFactorAuthLastKeyTimestamp = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_TwoFactorAuthLastKeyTimestamp');
        if (is_array($twoFactorAuthLastKeyTimestamp)) {
            $useMinMax = false;
            if (isset($twoFactorAuthLastKeyTimestamp['min'])) {
                $this->addUsingOperator($resolvedColumn, $twoFactorAuthLastKeyTimestamp['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($twoFactorAuthLastKeyTimestamp['max'])) {
                $this->addUsingOperator($resolvedColumn, $twoFactorAuthLastKeyTimestamp['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $twoFactorAuthLastKeyTimestamp, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_TwoFactorAuthRecoveryCodes column
     *
     * Example usage:
     * <code>
     * $query->filterByTwoFactorAuthRecoveryCodes('fooValue'); // WHERE usr_TwoFactorAuthRecoveryCodes = 'fooValue'
     * $query->filterByTwoFactorAuthRecoveryCodes('%fooValue%', Criteria::LIKE); // WHERE usr_TwoFactorAuthRecoveryCodes LIKE '%fooValue%'
     * $query->filterByTwoFactorAuthRecoveryCodes(['foo', 'bar']); // WHERE usr_TwoFactorAuthRecoveryCodes IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $twoFactorAuthRecoveryCodes The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByTwoFactorAuthRecoveryCodes($twoFactorAuthRecoveryCodes = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_TwoFactorAuthRecoveryCodes');
        if ($comparison === null && is_array($twoFactorAuthRecoveryCodes)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $twoFactorAuthRecoveryCodes, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_EditSelf column
     *
     * Example usage:
     * <code>
     * $query->filterByEditSelf(true); // WHERE usr_EditSelf = true
     * $query->filterByEditSelf('yes'); // WHERE usr_EditSelf = true
     * </code>
     *
     * @param string|bool|null $editSelf The value to use as filter.
     *      Non-boolean arguments are converted using the following rules:
     *          - 1, '1', 'true', 'on', and 'yes' are converted to boolean true
     *          - 0, '0', 'false', 'off', and 'no' are converted to boolean false
     *      Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByEditSelf($editSelf = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_EditSelf');
        if (is_string($editSelf)) {
            $editSelf = in_array(strtolower($editSelf), ['false', 'off', '-', 'no', 'n', '0', ''], true) ? false : true;
        }
        $this->addUsingOperator($resolvedColumn, $editSelf, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_CalStart column
     *
     * Example usage:
     * <code>
     * $query->filterByCalStart('2011-03-14'); // WHERE usr_CalStart = '2011-03-14'
     * $query->filterByCalStart('now'); // WHERE usr_CalStart = '2011-03-14'
     * $query->filterByCalStart(array('max' => 'yesterday')); // WHERE usr_CalStart > '2011-03-13'
     * </code>
     *
     * @param mixed $calStart The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByCalStart($calStart = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_CalStart');
        if (is_array($calStart)) {
            $useMinMax = false;
            if (isset($calStart['min'])) {
                $this->addUsingOperator($resolvedColumn, $calStart['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($calStart['max'])) {
                $this->addUsingOperator($resolvedColumn, $calStart['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $calStart, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_CalEnd column
     *
     * Example usage:
     * <code>
     * $query->filterByCalEnd('2011-03-14'); // WHERE usr_CalEnd = '2011-03-14'
     * $query->filterByCalEnd('now'); // WHERE usr_CalEnd = '2011-03-14'
     * $query->filterByCalEnd(array('max' => 'yesterday')); // WHERE usr_CalEnd > '2011-03-13'
     * </code>
     *
     * @param mixed $calEnd The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByCalEnd($calEnd = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_CalEnd');
        if (is_array($calEnd)) {
            $useMinMax = false;
            if (isset($calEnd['min'])) {
                $this->addUsingOperator($resolvedColumn, $calEnd['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($calEnd['max'])) {
                $this->addUsingOperator($resolvedColumn, $calEnd['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $calEnd, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_CalNoSchool1 column
     *
     * Example usage:
     * <code>
     * $query->filterByCalNoSchool1('2011-03-14'); // WHERE usr_CalNoSchool1 = '2011-03-14'
     * $query->filterByCalNoSchool1('now'); // WHERE usr_CalNoSchool1 = '2011-03-14'
     * $query->filterByCalNoSchool1(array('max' => 'yesterday')); // WHERE usr_CalNoSchool1 > '2011-03-13'
     * </code>
     *
     * @param mixed $calNoSchool1 The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByCalNoSchool1($calNoSchool1 = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_CalNoSchool1');
        if (is_array($calNoSchool1)) {
            $useMinMax = false;
            if (isset($calNoSchool1['min'])) {
                $this->addUsingOperator($resolvedColumn, $calNoSchool1['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($calNoSchool1['max'])) {
                $this->addUsingOperator($resolvedColumn, $calNoSchool1['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $calNoSchool1, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_CalNoSchool2 column
     *
     * Example usage:
     * <code>
     * $query->filterByCalNoSchool2('2011-03-14'); // WHERE usr_CalNoSchool2 = '2011-03-14'
     * $query->filterByCalNoSchool2('now'); // WHERE usr_CalNoSchool2 = '2011-03-14'
     * $query->filterByCalNoSchool2(array('max' => 'yesterday')); // WHERE usr_CalNoSchool2 > '2011-03-13'
     * </code>
     *
     * @param mixed $calNoSchool2 The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByCalNoSchool2($calNoSchool2 = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_CalNoSchool2');
        if (is_array($calNoSchool2)) {
            $useMinMax = false;
            if (isset($calNoSchool2['min'])) {
                $this->addUsingOperator($resolvedColumn, $calNoSchool2['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($calNoSchool2['max'])) {
                $this->addUsingOperator($resolvedColumn, $calNoSchool2['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $calNoSchool2, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_CalNoSchool3 column
     *
     * Example usage:
     * <code>
     * $query->filterByCalNoSchool3('2011-03-14'); // WHERE usr_CalNoSchool3 = '2011-03-14'
     * $query->filterByCalNoSchool3('now'); // WHERE usr_CalNoSchool3 = '2011-03-14'
     * $query->filterByCalNoSchool3(array('max' => 'yesterday')); // WHERE usr_CalNoSchool3 > '2011-03-13'
     * </code>
     *
     * @param mixed $calNoSchool3 The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByCalNoSchool3($calNoSchool3 = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_CalNoSchool3');
        if (is_array($calNoSchool3)) {
            $useMinMax = false;
            if (isset($calNoSchool3['min'])) {
                $this->addUsingOperator($resolvedColumn, $calNoSchool3['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($calNoSchool3['max'])) {
                $this->addUsingOperator($resolvedColumn, $calNoSchool3['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $calNoSchool3, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_CalNoSchool4 column
     *
     * Example usage:
     * <code>
     * $query->filterByCalNoSchool4('2011-03-14'); // WHERE usr_CalNoSchool4 = '2011-03-14'
     * $query->filterByCalNoSchool4('now'); // WHERE usr_CalNoSchool4 = '2011-03-14'
     * $query->filterByCalNoSchool4(array('max' => 'yesterday')); // WHERE usr_CalNoSchool4 > '2011-03-13'
     * </code>
     *
     * @param mixed $calNoSchool4 The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByCalNoSchool4($calNoSchool4 = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_CalNoSchool4');
        if (is_array($calNoSchool4)) {
            $useMinMax = false;
            if (isset($calNoSchool4['min'])) {
                $this->addUsingOperator($resolvedColumn, $calNoSchool4['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($calNoSchool4['max'])) {
                $this->addUsingOperator($resolvedColumn, $calNoSchool4['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $calNoSchool4, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_CalNoSchool5 column
     *
     * Example usage:
     * <code>
     * $query->filterByCalNoSchool5('2011-03-14'); // WHERE usr_CalNoSchool5 = '2011-03-14'
     * $query->filterByCalNoSchool5('now'); // WHERE usr_CalNoSchool5 = '2011-03-14'
     * $query->filterByCalNoSchool5(array('max' => 'yesterday')); // WHERE usr_CalNoSchool5 > '2011-03-13'
     * </code>
     *
     * @param mixed $calNoSchool5 The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByCalNoSchool5($calNoSchool5 = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_CalNoSchool5');
        if (is_array($calNoSchool5)) {
            $useMinMax = false;
            if (isset($calNoSchool5['min'])) {
                $this->addUsingOperator($resolvedColumn, $calNoSchool5['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($calNoSchool5['max'])) {
                $this->addUsingOperator($resolvedColumn, $calNoSchool5['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $calNoSchool5, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_CalNoSchool6 column
     *
     * Example usage:
     * <code>
     * $query->filterByCalNoSchool6('2011-03-14'); // WHERE usr_CalNoSchool6 = '2011-03-14'
     * $query->filterByCalNoSchool6('now'); // WHERE usr_CalNoSchool6 = '2011-03-14'
     * $query->filterByCalNoSchool6(array('max' => 'yesterday')); // WHERE usr_CalNoSchool6 > '2011-03-13'
     * </code>
     *
     * @param mixed $calNoSchool6 The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByCalNoSchool6($calNoSchool6 = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_CalNoSchool6');
        if (is_array($calNoSchool6)) {
            $useMinMax = false;
            if (isset($calNoSchool6['min'])) {
                $this->addUsingOperator($resolvedColumn, $calNoSchool6['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($calNoSchool6['max'])) {
                $this->addUsingOperator($resolvedColumn, $calNoSchool6['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $calNoSchool6, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_CalNoSchool7 column
     *
     * Example usage:
     * <code>
     * $query->filterByCalNoSchool7('2011-03-14'); // WHERE usr_CalNoSchool7 = '2011-03-14'
     * $query->filterByCalNoSchool7('now'); // WHERE usr_CalNoSchool7 = '2011-03-14'
     * $query->filterByCalNoSchool7(array('max' => 'yesterday')); // WHERE usr_CalNoSchool7 > '2011-03-13'
     * </code>
     *
     * @param mixed $calNoSchool7 The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByCalNoSchool7($calNoSchool7 = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_CalNoSchool7');
        if (is_array($calNoSchool7)) {
            $useMinMax = false;
            if (isset($calNoSchool7['min'])) {
                $this->addUsingOperator($resolvedColumn, $calNoSchool7['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($calNoSchool7['max'])) {
                $this->addUsingOperator($resolvedColumn, $calNoSchool7['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $calNoSchool7, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_CalNoSchool8 column
     *
     * Example usage:
     * <code>
     * $query->filterByCalNoSchool8('2011-03-14'); // WHERE usr_CalNoSchool8 = '2011-03-14'
     * $query->filterByCalNoSchool8('now'); // WHERE usr_CalNoSchool8 = '2011-03-14'
     * $query->filterByCalNoSchool8(array('max' => 'yesterday')); // WHERE usr_CalNoSchool8 > '2011-03-13'
     * </code>
     *
     * @param mixed $calNoSchool8 The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByCalNoSchool8($calNoSchool8 = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_CalNoSchool8');
        if (is_array($calNoSchool8)) {
            $useMinMax = false;
            if (isset($calNoSchool8['min'])) {
                $this->addUsingOperator($resolvedColumn, $calNoSchool8['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($calNoSchool8['max'])) {
                $this->addUsingOperator($resolvedColumn, $calNoSchool8['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $calNoSchool8, $comparison);

        return $this;
    }

    /**
     * Filter the query on the usr_SearchFamily column
     *
     * Example usage:
     * <code>
     * $query->filterBySearchfamily(1234); // WHERE usr_SearchFamily = 1234
     * $query->filterBySearchfamily(array(12, 34)); // WHERE usr_SearchFamily IN (12, 34)
     * $query->filterBySearchfamily(array('min' => 12)); // WHERE usr_SearchFamily > 12
     * </code>
     *
     * @param mixed $searchfamily The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterBySearchfamily($searchfamily = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('usr_SearchFamily');
        if (is_array($searchfamily)) {
            $useMinMax = false;
            if (isset($searchfamily['min'])) {
                $this->addUsingOperator($resolvedColumn, $searchfamily['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($searchfamily['max'])) {
                $this->addUsingOperator($resolvedColumn, $searchfamily['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $searchfamily, $comparison);

        return $this;
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
                ->addUsingOperator($this->resolveLocalColumnByName('usr_per_ID'), $person->getId(), $comparison);
        } elseif ($person instanceof ObjectCollection) {
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingOperator($this->resolveLocalColumnByName('usr_per_ID'), $person->toKeyValue('PrimaryKey', 'Id'), $comparison);

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
     * Filter the query by a related UserConfig object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\UserConfig|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\UserConfig> $userConfig the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this
     */
    public function filterByUserConfig(UserConfig|ObjectCollection $userConfig, ?string $comparison = null)
    {
        if ($userConfig instanceof UserConfig) {
            $this
                ->addUsingOperator($this->resolveLocalColumnByName('usr_per_ID'), $userConfig->getPeronId(), $comparison);
        } elseif ($userConfig instanceof ObjectCollection) {
            $this
                ->useUserConfigQuery()
                ->filterByPrimaryKeys($userConfig->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserConfig() only accepts arguments of type \ChurchCRM\model\ChurchCRM\Base\UserConfig or Collection');
        }

        return $this;
    }

    /**
     * Adds a JOIN clause to the query using the UserConfig relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinUserConfig(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserConfig');

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
            $this->addJoinObject($join, 'UserConfig');
        }

        return $this;
    }

    /**
     * Use the UserConfig relation UserConfig object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\UserConfigQuery<static> A secondary query class using the current class as primary query
     */
    public function useUserConfigQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\UserConfigQuery<static> $query */
        $query = $this->joinUserConfig($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'UserConfig', '\ChurchCRM\model\ChurchCRM\UserConfigQuery');

        return $query;
    }

    /**
     * Use the UserConfig relation UserConfig object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\UserConfigQuery<mixed>):\ChurchCRM\model\ChurchCRM\UserConfigQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withUserConfigQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useUserConfigQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to UserConfig table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\UserConfigQuery<static> The inner query object of the EXISTS statement
     */
    public function useUserConfigExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\UserConfigQuery<static> $q */
        $q = $this->useExistsQuery('UserConfig', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to UserConfig table for a NOT EXISTS query.
     *
     * @see useUserConfigExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\UserConfigQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function useUserConfigNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\UserConfigQuery<static> $q*/
        $q = $this->useExistsQuery('UserConfig', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to UserConfig table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\UserConfigQuery<static> The inner query object of the IN statement
     */
    public function useInUserConfigQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\UserConfigQuery<static> $q */
        $q = $this->useInQuery('UserConfig', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to UserConfig table for a NOT IN query.
     *
     * @see useUserConfigInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\UserConfigQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInUserConfigQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\UserConfigQuery<static> $q */
        $q = $this->useInQuery('UserConfig', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
    }

    /**
     * Filter the query by a related UserSetting object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\UserSetting|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\UserSetting> $userSetting the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this
     */
    public function filterByUserSetting(UserSetting|ObjectCollection $userSetting, ?string $comparison = null)
    {
        if ($userSetting instanceof UserSetting) {
            $this
                ->addUsingOperator($this->resolveLocalColumnByName('usr_per_ID'), $userSetting->getUserId(), $comparison);
        } elseif ($userSetting instanceof ObjectCollection) {
            $this
                ->useUserSettingQuery()
                ->filterByPrimaryKeys($userSetting->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserSetting() only accepts arguments of type \ChurchCRM\model\ChurchCRM\Base\UserSetting or Collection');
        }

        return $this;
    }

    /**
     * Adds a JOIN clause to the query using the UserSetting relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinUserSetting(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserSetting');

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
            $this->addJoinObject($join, 'UserSetting');
        }

        return $this;
    }

    /**
     * Use the UserSetting relation UserSetting object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\UserSettingQuery<static> A secondary query class using the current class as primary query
     */
    public function useUserSettingQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\UserSettingQuery<static> $query */
        $query = $this->joinUserSetting($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'UserSetting', '\ChurchCRM\model\ChurchCRM\UserSettingQuery');

        return $query;
    }

    /**
     * Use the UserSetting relation UserSetting object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\UserSettingQuery<mixed>):\ChurchCRM\model\ChurchCRM\UserSettingQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withUserSettingQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useUserSettingQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to UserSetting table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\UserSettingQuery<static> The inner query object of the EXISTS statement
     */
    public function useUserSettingExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\UserSettingQuery<static> $q */
        $q = $this->useExistsQuery('UserSetting', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to UserSetting table for a NOT EXISTS query.
     *
     * @see useUserSettingExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\UserSettingQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function useUserSettingNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\UserSettingQuery<static> $q*/
        $q = $this->useExistsQuery('UserSetting', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to UserSetting table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\UserSettingQuery<static> The inner query object of the IN statement
     */
    public function useInUserSettingQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\UserSettingQuery<static> $q */
        $q = $this->useInQuery('UserSetting', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to UserSetting table for a NOT IN query.
     *
     * @see useUserSettingInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\UserSettingQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInUserSettingQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\UserSettingQuery<static> $q */
        $q = $this->useInQuery('UserSetting', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param \ChurchCRM\model\ChurchCRM\User|null $user Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildUser $user = null)
    {
        if ($user) {
            $resolvedColumn = $this->resolveLocalColumnByName('usr_per_ID');
            $this->addUsingOperator($resolvedColumn, $user->getPersonId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the user_usr table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UserTableMap::clearInstancePool();
            UserTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UserTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            UserTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            UserTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
