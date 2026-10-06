-- =============================================================================
-- COOP Software: database updates for October 2026
-- =============================================================================
-- For the remote server, where `php artisan migrate` cannot be run.
-- Upload the new code first, then run this file in phpMyAdmin (SQL tab).
--
-- BEFORE YOU START
--   1. Back up the remote database (phpMyAdmin > Export).
--   2. See which of these updates the server already has:
--
--        SELECT migration FROM migrations WHERE migration LIKE '2026_10_%';
--
--      Each part below is named after its migration. SKIP any part whose
--      migration name is already in that list, or it will fail with
--      "Duplicate column" / "Table already exists".
--   3. Part 8 needs MySQL 8.0+ or MariaDB 10.2+ (SELECT VERSION(); to check).
--
-- Parts 1-7 change the table structure only. Part 8 updates savings dates.
-- =============================================================================


-- -----------------------------------------------------------------------------
-- PART 1: 2026_10_02_000001_a_make_member_import_fields_nullable
-- Lets member import leave phone, gender, marital status, date of birth,
-- address, department and next-of-kin details blank.
-- -----------------------------------------------------------------------------
ALTER TABLE `members` MODIFY `phone_1` varchar(255) NULL;
ALTER TABLE `members` MODIFY `gender` enum('male', 'female') NULL;
ALTER TABLE `members` MODIFY `marital_status` enum('single', 'married', 'divorced', 'widowed') NULL;
ALTER TABLE `members` MODIFY `date_of_birth` date NULL;
ALTER TABLE `members` MODIFY `home_address` text NULL;
ALTER TABLE `members` MODIFY `department` varchar(255) NULL;
ALTER TABLE `next_of_kin` MODIFY `name` varchar(255) NULL;
ALTER TABLE `next_of_kin` MODIFY `relationship` varchar(255) NULL;
ALTER TABLE `next_of_kin` MODIFY `phone` varchar(255) NULL;

INSERT INTO `migrations` (`migration`, `batch`)
SELECT '2026_10_02_000001_a_make_member_import_fields_nullable', IFNULL(MAX(`batch`), 0) + 1 FROM `migrations`;


-- -----------------------------------------------------------------------------
-- PART 2: 2026_10_03_000001_a_add_membership_date_to_members_table
-- The date each member joined the society ("Date Joined").
-- -----------------------------------------------------------------------------
ALTER TABLE `members` ADD `membership_date` date NULL AFTER `membership_no`;

INSERT INTO `migrations` (`migration`, `batch`)
SELECT '2026_10_03_000001_a_add_membership_date_to_members_table', IFNULL(MAX(`batch`), 0) + 1 FROM `migrations`;


-- -----------------------------------------------------------------------------
-- PART 3: 2026_10_04_000001_a_create_loan_repayment_reversals_table
-- Excess loan repayments, held until applied to another loan or refunded.
-- -----------------------------------------------------------------------------
CREATE TABLE `loan_repayment_reversals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `member_id` bigint unsigned NOT NULL,
  `loan_id` bigint unsigned NOT NULL,
  `repayment_transaction_id` bigint unsigned NOT NULL,
  `reversal_transaction_id` bigint unsigned NOT NULL,
  `amount` decimal(14, 2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'awaiting_choice',
  `resolution` varchar(255) NULL,
  `target_loan_id` bigint unsigned NULL,
  `applied_transaction_id` bigint unsigned NULL,
  `bank_name` varchar(255) NULL,
  `account_number` varchar(255) NULL,
  `account_name` varchar(255) NULL,
  `refund_reference` varchar(255) NULL,
  `chosen_at` timestamp NULL,
  `processed_by` bigint unsigned NULL,
  `processed_at` timestamp NULL,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL
) DEFAULT CHARACTER SET utf8mb4 COLLATE 'utf8mb4_unicode_ci';
ALTER TABLE `loan_repayment_reversals` ADD CONSTRAINT `loan_repayment_reversals_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`);
ALTER TABLE `loan_repayment_reversals` ADD CONSTRAINT `loan_repayment_reversals_loan_id_foreign` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`);
ALTER TABLE `loan_repayment_reversals` ADD CONSTRAINT `loan_repayment_reversals_processed_by_foreign` FOREIGN KEY (`processed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
ALTER TABLE `loan_repayment_reversals` ADD INDEX `loan_repayment_reversals_status_index` (`status`);
ALTER TABLE `loan_repayment_reversals` ADD CONSTRAINT `lrr_repayment_txn_fk` FOREIGN KEY (`repayment_transaction_id`) REFERENCES `loan_repayment_transactions` (`id`);
ALTER TABLE `loan_repayment_reversals` ADD CONSTRAINT `lrr_reversal_txn_fk` FOREIGN KEY (`reversal_transaction_id`) REFERENCES `loan_repayment_transactions` (`id`);
ALTER TABLE `loan_repayment_reversals` ADD CONSTRAINT `lrr_target_loan_fk` FOREIGN KEY (`target_loan_id`) REFERENCES `loans` (`id`);
ALTER TABLE `loan_repayment_reversals` ADD CONSTRAINT `lrr_applied_txn_fk` FOREIGN KEY (`applied_transaction_id`) REFERENCES `loan_repayment_transactions` (`id`);

INSERT INTO `migrations` (`migration`, `batch`)
SELECT '2026_10_04_000001_a_create_loan_repayment_reversals_table', IFNULL(MAX(`batch`), 0) + 1 FROM `migrations`;


-- -----------------------------------------------------------------------------
-- PART 4: 2026_10_04_000002_a_add_released_quantities_to_commodity_request_lines
-- What the Store Officer actually released per commodity line. Requests
-- already released are treated as fully supplied.
-- -----------------------------------------------------------------------------
ALTER TABLE `commodity_request_lines` ADD `quantity_released` decimal(8, 2) NULL AFTER `line_total`;
ALTER TABLE `commodity_request_lines` ADD `released_line_total` decimal(14, 2) NULL AFTER `quantity_released`;
UPDATE `commodity_request_lines`
SET `quantity_released` = `quantity`, `released_line_total` = `line_total`
WHERE `commodity_request_id` IN (SELECT `id` FROM `commodity_requests` WHERE `status` = 'active');

INSERT INTO `migrations` (`migration`, `batch`)
SELECT '2026_10_04_000002_a_add_released_quantities_to_commodity_request_lines', IFNULL(MAX(`batch`), 0) + 1 FROM `migrations`;


-- -----------------------------------------------------------------------------
-- PART 5: 2026_10_05_000001_a_add_audit_and_stock_to_commodity_cycle_prices
-- Auditor price corrections, Store Officer stock counts, and the reason an
-- item was not (fully) released.
-- -----------------------------------------------------------------------------
ALTER TABLE `commodity_cycle_prices` ADD `original_unit_price` decimal(14, 2) NULL AFTER `unit_price`;
ALTER TABLE `commodity_cycle_prices` ADD `revised_by` bigint unsigned NULL AFTER `set_at`;
ALTER TABLE `commodity_cycle_prices` ADD `revised_at` timestamp NULL AFTER `revised_by`;
ALTER TABLE `commodity_cycle_prices` ADD `quantity_in_store` decimal(10, 2) NULL AFTER `revised_at`;
ALTER TABLE `commodity_cycle_prices` ADD `quantity_damaged` decimal(10, 2) NULL AFTER `quantity_in_store`;
ALTER TABLE `commodity_cycle_prices` ADD CONSTRAINT `ccp_revised_by_fk` FOREIGN KEY (`revised_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
ALTER TABLE `commodity_request_lines` ADD `shortfall_reason` varchar(255) NULL AFTER `released_line_total`;

INSERT INTO `migrations` (`migration`, `batch`)
SELECT '2026_10_05_000001_a_add_audit_and_stock_to_commodity_cycle_prices', IFNULL(MAX(`batch`), 0) + 1 FROM `migrations`;


-- -----------------------------------------------------------------------------
-- PART 6: 2026_10_05_000002_a_create_loan_tenure_change_requests_table
-- Treasurer requests to extend a loan's tenure, approved by the Chairman.
-- -----------------------------------------------------------------------------
CREATE TABLE `loan_tenure_change_requests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `loan_id` bigint unsigned NOT NULL,
  `member_id` bigint unsigned NOT NULL,
  `current_tenure_months` smallint unsigned NOT NULL,
  `requested_tenure_months` smallint unsigned NOT NULL,
  `current_installment` decimal(14, 2) NOT NULL,
  `proposed_installment` decimal(14, 2) NOT NULL,
  `applied_installment` decimal(14, 2) NULL,
  `reason` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `requested_by` bigint unsigned NOT NULL,
  `requested_at` timestamp NOT NULL,
  `chairman_reviewed_by` bigint unsigned NULL,
  `chairman_reviewed_at` timestamp NULL,
  `chairman_note` text NULL,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL
) DEFAULT CHARACTER SET utf8mb4 COLLATE 'utf8mb4_unicode_ci';
ALTER TABLE `loan_tenure_change_requests` ADD CONSTRAINT `loan_tenure_change_requests_loan_id_foreign` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`);
ALTER TABLE `loan_tenure_change_requests` ADD CONSTRAINT `loan_tenure_change_requests_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`);
ALTER TABLE `loan_tenure_change_requests` ADD CONSTRAINT `loan_tenure_change_requests_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`);
ALTER TABLE `loan_tenure_change_requests` ADD INDEX `loan_tenure_change_requests_status_index` (`status`);
ALTER TABLE `loan_tenure_change_requests` ADD CONSTRAINT `ltcr_chairman_fk` FOREIGN KEY (`chairman_reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

INSERT INTO `migrations` (`migration`, `batch`)
SELECT '2026_10_05_000002_a_create_loan_tenure_change_requests_table', IFNULL(MAX(`batch`), 0) + 1 FROM `migrations`;


-- -----------------------------------------------------------------------------
-- PART 7: 2026_10_06_000001_a_create_withdrawal_import_batches_table
-- Import of past withdrawals from the manual books.
-- -----------------------------------------------------------------------------
CREATE TABLE `withdrawal_import_batches` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `uploaded_by` bigint unsigned NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `total_amount` decimal(14, 2) NOT NULL DEFAULT '0',
  `total_records` int unsigned NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL DEFAULT 'validated',
  `rows` json NULL,
  `posted_at` timestamp NULL,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL
) DEFAULT CHARACTER SET utf8mb4 COLLATE 'utf8mb4_unicode_ci';
ALTER TABLE `withdrawal_import_batches` ADD CONSTRAINT `withdrawal_import_batches_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`);
ALTER TABLE `withdrawal_requests` ADD `is_legacy_import` tinyint(1) NOT NULL DEFAULT '0' AFTER `status`;
ALTER TABLE `withdrawal_requests` ADD `withdrawal_import_batch_id` bigint unsigned NULL AFTER `is_legacy_import`;
ALTER TABLE `withdrawal_requests` ADD CONSTRAINT `wr_import_batch_fk` FOREIGN KEY (`withdrawal_import_batch_id`) REFERENCES `withdrawal_import_batches` (`id`) ON DELETE SET NULL;

INSERT INTO `migrations` (`migration`, `batch`)
SELECT '2026_10_06_000001_a_create_withdrawal_import_batches_table', IFNULL(MAX(`batch`), 0) + 1 FROM `migrations`;


-- -----------------------------------------------------------------------------
-- PART 8: Date imported savings records to when they really happened
-- Same as `php artisan savings:date-legacy-records --apply`.
-- Contributions move to the last day of their batch's month; imported opening
-- balances move to the member's join date; running balances are then
-- recalculated in date order. Amounts and current balances do not change.
-- Safe to run more than once: records already dated correctly are skipped.
-- Needs MySQL 8.0+ or MariaDB 10.2+.
-- -----------------------------------------------------------------------------

-- 8a. Contributions: last day of the batch's month (months not yet ended are left alone).
UPDATE `savings_transactions` t
JOIN `contribution_batches` b ON b.`id` = t.`source_batch_id`
SET t.`posted_at` = TIMESTAMP(LAST_DAY(CONCAT(b.`period`, '-01')))
WHERE t.`type` = 'contribution_deduction'
  AND LAST_DAY(CONCAT(b.`period`, '-01')) < CURDATE()
  AND t.`posted_at` > TIMESTAMP(LAST_DAY(CONCAT(b.`period`, '-01')));

-- 8b. Imported opening balances: the member's join date.
UPDATE `savings_transactions` t
JOIN `savings_accounts` a ON a.`id` = t.`savings_account_id`
JOIN `members` m ON m.`id` = a.`member_id`
SET t.`posted_at` = TIMESTAMP(m.`membership_date`)
WHERE t.`type` = 'opening_balance'
  AND t.`reference` LIKE 'IMPORT-%'
  AND m.`membership_date` IS NOT NULL
  AND m.`membership_date` < CURDATE()
  AND t.`posted_at` > TIMESTAMP(m.`membership_date`);

-- 8c. Recalculate each entry's running balance in date order.
UPDATE `savings_transactions` t
JOIN (
  SELECT `id`,
         SUM(CASE WHEN `type` IN ('contribution_deduction', 'voluntary_deposit', 'reversal_credit', 'opening_balance', 'dividend_credit', 'interest_credit')
                  THEN `amount` ELSE -`amount` END)
           OVER (PARTITION BY `savings_account_id` ORDER BY `posted_at`, `id`) AS `running`
  FROM `savings_transactions`
) r ON r.`id` = t.`id`
SET t.`balance_after` = r.`running`;

-- 8d. Check: both numbers must be 0. If "mismatches" is not 0, restore the
--     backup and contact support. Nothing in 8a-8c changes account balances.
SELECT COUNT(*) AS mismatches
FROM `savings_accounts` a
WHERE a.`balance` <> COALESCE((
  SELECT t.`balance_after` FROM `savings_transactions` t
  WHERE t.`savings_account_id` = a.`id`
  ORDER BY t.`posted_at` DESC, t.`id` DESC LIMIT 1
), 0);

SELECT COUNT(*) AS negative_balances FROM `savings_transactions` WHERE `balance_after` < 0;
