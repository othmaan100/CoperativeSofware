-- ---------------------------------------------------------------------------
-- Legacy profit for dividends (Treasurer enters profit from the old records)
-- Same as migration 2026_11_19_000001_a_create_dividend_legacy_profits_table
--
-- HOW TO RUN: phpMyAdmin -> select the site's database -> SQL tab ->
-- paste everything below -> Go.  Run it ONCE only.
-- ---------------------------------------------------------------------------

CREATE TABLE `dividend_legacy_profits` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `dividend_period_id` BIGINT UNSIGNED NOT NULL,
    `category` VARCHAR(255) NOT NULL,
    `amount` DECIMAL(14,2) NOT NULL,
    `description` VARCHAR(255) NULL DEFAULT NULL,
    `entered_by` BIGINT UNSIGNED NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `dividend_legacy_profits_dividend_period_id_foreign` (`dividend_period_id`),
    KEY `dividend_legacy_profits_entered_by_foreign` (`entered_by`),
    CONSTRAINT `dividend_legacy_profits_dividend_period_id_foreign`
        FOREIGN KEY (`dividend_period_id`) REFERENCES `dividend_periods` (`id`) ON DELETE CASCADE,
    CONSTRAINT `dividend_legacy_profits_entered_by_foreign`
        FOREIGN KEY (`entered_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Record the migration as done, so a later `php artisan migrate` skips it.
INSERT INTO `migrations` (`migration`, `batch`)
SELECT '2026_11_19_000001_a_create_dividend_legacy_profits_table', COALESCE(MAX(`batch`), 0) + 1
FROM `migrations`
WHERE NOT EXISTS (
    SELECT 1 FROM `migrations` WHERE `migration` = '2026_11_19_000001_a_create_dividend_legacy_profits_table'
);

-- Check: should show the new, empty table's columns.
SHOW COLUMNS FROM `dividend_legacy_profits`;
