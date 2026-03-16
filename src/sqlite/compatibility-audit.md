# SQLite Compatibility Audit (Phase 3 Step 7)

Status: In progress

## Scope
- SQL migration scripts (install + upgrades)
- Runtime SQL and ORM usage
- Legacy mysqli usage in PHP pages

## Findings Summary
### 1) MySQL-specific DDL in migration scripts
Patterns found in `src/mysql/install/Install.sql` and `src/mysql/upgrade/*`:
- `ENGINE=...`, `CHARACTER SET`, `COLLATE`, `PACK_KEYS`, `AUTO_INCREMENT`
- MySQL-specific column types: `mediumint`, `tinyint(1) unsigned`, `enum(...)`
- `ALTER TABLE ... DROP INDEX`, `RENAME TABLE`
- `DROP COLUMN IF EXISTS` (SQLite supports only from 3.35+ with limited syntax)
- MySQL comments and options on columns/tables

SQLite target changes:
- Remove engine/charset/collation clauses
- Convert `AUTO_INCREMENT` to `INTEGER PRIMARY KEY AUTOINCREMENT` (or `INTEGER PRIMARY KEY`)
- Convert `enum(...)` to `TEXT` with CHECK constraint or lookup table
- Convert `mediumint`/`tinyint` to `INTEGER`
- Replace `DROP INDEX` and `RENAME TABLE` with SQLite-supported syntax

### 2) MySQL-specific functions in stored query strings
Inserts in `query_qry` contain:
- `CONCAT()`, `COALESCE()`, `NOW()`, `DATE_SUB()`, `DAYOFMONTH()`, `MONTH()`
- These need SQLite equivalents (e.g., `strftime`, `datetime('now')`, `||` concatenation)

### 3) MySQLi usage in PHP code (blocking for SQLite)
Legacy PHP files still rely on `mysqli_*` APIs.
This is a major compatibility blocker for SQLite.

Examples (non-exhaustive):
- `src/PersonEditor.php`
- `src/FamilyEditor.php`
- `src/CSVImport.php`
- `src/QuerySQL.php`
- `src/ChurchCRM/Service/FinancialService.php`
- `src/ChurchCRM/Service/GroupService.php`

### 4) Runtime MySQL-specific SQL (non-migration)
These will break under SQLite unless refactored:
- `ON DUPLICATE KEY UPDATE`: `src/EventNames.php`, `src/EventEditor.php` (handled with SQLite-specific branches)
- `ENGINE=InnoDB` in runtime table creation: `src/GroupPropsEditor.php`, `src/ChurchCRM/Service/GroupService.php` (SQLite-safe DDL added)
- `GROUP_CONCAT(... SEPARATOR ...)`: `src/ChurchCRM/Service/DepositService.php` (SQLite-safe branch exists)
- `DATE_FORMAT`/`DAYOFYEAR`: `src/CSVCreateFile.php` (SQLite-safe branch added)
- `CONCAT()` in search providers: `src/ChurchCRM/Search/FinanceDepositSearchResultProvider.php`, `src/ChurchCRM/Search/FinancePaymentSearchResultProvider.php` (SQLite-safe branch added)

## Immediate Next Actions
1. Create SQLite-specific DDL by transforming `src/sqlite/install/Install.sql`:
   - Remove ENGINE/CHARSET/COLLATE/AUTO_INCREMENT
   - Convert data types + enums
   - Normalize PRIMARY KEY declarations
2. Create SQLite-specific upgrade scripts in `src/sqlite/upgrade/*`:
   - Convert MySQL-only `ALTER TABLE` and `DROP INDEX`
   - Replace unsupported syntax with SQLite alternatives
3. Introduce a compatibility shim plan for mysqli usage:
   - Short term: isolate non-SQLite-safe pages in standalone (disable or restrict)
   - Medium term: migrate to Propel or PDO for SQLite compatibility
4. Inventory and refactor MySQL-only runtime SQL (above list) to SQLite-safe equivalents.

## Notes
This audit is a prerequisite to making SQLite the default standalone DB. Until completed,
SQLite remains gated by `CHURCHCRM_SQLITE_EXPERIMENTAL=1`.

## Decision Log
- 2026-03-12: SQLite baseline set to current (`7.0.3`). Legacy MySQL upgrade chains are not applied to fresh SQLite installs. Future SQLite upgrades will be appended from this baseline forward.
