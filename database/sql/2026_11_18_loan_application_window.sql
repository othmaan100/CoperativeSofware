-- ---------------------------------------------------------------------------
-- Loan application window (Treasurer opens/closes loan applications)
-- Same as migration 2026_11_18_000001_a_add_application_window_to_loan_products
--
-- HOW TO RUN: phpMyAdmin -> select the site's database -> SQL tab ->
-- paste everything below -> Go.  Run it ONCE only.
-- ---------------------------------------------------------------------------

-- 1. New columns. Every product starts with applications CLOSED.
ALTER TABLE `loan_products`
    ADD COLUMN `applications_open` TINYINT(1) NOT NULL DEFAULT 0 AFTER `is_active`,
    ADD COLUMN `applications_close_on` DATE NULL DEFAULT NULL AFTER `applications_open`;

-- 2. New permission, given to the Treasurer and Super Admin roles.
INSERT IGNORE INTO `permissions` (`name`, `guard_name`, `created_at`, `updated_at`)
VALUES ('open_loan_applications', 'web', NOW(), NOW());

INSERT IGNORE INTO `role_has_permissions` (`permission_id`, `role_id`)
SELECT p.`id`, r.`id`
FROM `permissions` p
JOIN `roles` r ON r.`name` IN ('treasurer', 'super_admin') AND r.`guard_name` = 'web'
WHERE p.`name` = 'open_loan_applications' AND p.`guard_name` = 'web';

-- 3. Record the migration as done, so a later `php artisan migrate` skips it.
INSERT INTO `migrations` (`migration`, `batch`)
SELECT '2026_11_18_000001_a_add_application_window_to_loan_products', COALESCE(MAX(`batch`), 0) + 1
FROM `migrations`
WHERE NOT EXISTS (
    SELECT 1 FROM `migrations` WHERE `migration` = '2026_11_18_000001_a_add_application_window_to_loan_products'
);

-- 4. Clear the cached permissions so the Treasurer gets the new one immediately.
DELETE FROM `cache` WHERE `key` LIKE '%spatie.permission.cache%';

-- Check: should list regular / emergency / commodity with applications_open = 0.
SELECT `code`, `is_active`, `applications_open`, `applications_close_on` FROM `loan_products`;
