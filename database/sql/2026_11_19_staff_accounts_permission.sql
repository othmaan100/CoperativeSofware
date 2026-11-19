-- ---------------------------------------------------------------------------
-- Staff Accounts page (Secretary / Treasurer edit Staff IDs, reset passwords)
-- Same as migration 2026_11_19_000002_a_add_manage_staff_accounts_permission
--
-- HOW TO RUN: phpMyAdmin -> select the site's database -> SQL tab ->
-- paste everything below -> Go.  Safe to run more than once.
-- ---------------------------------------------------------------------------

-- 1. New permission, given to the Secretary, Treasurer and Super Admin roles.
INSERT IGNORE INTO `permissions` (`name`, `guard_name`, `created_at`, `updated_at`)
VALUES ('manage_staff_accounts', 'web', NOW(), NOW());

INSERT IGNORE INTO `role_has_permissions` (`permission_id`, `role_id`)
SELECT p.`id`, r.`id`
FROM `permissions` p
JOIN `roles` r ON r.`name` IN ('secretary', 'treasurer', 'super_admin') AND r.`guard_name` = 'web'
WHERE p.`name` = 'manage_staff_accounts' AND p.`guard_name` = 'web';

-- 2. Record the migration as done, so a later `php artisan migrate` skips it.
INSERT INTO `migrations` (`migration`, `batch`)
SELECT '2026_11_19_000002_a_add_manage_staff_accounts_permission', COALESCE(MAX(`batch`), 0) + 1
FROM `migrations`
WHERE NOT EXISTS (
    SELECT 1 FROM `migrations` WHERE `migration` = '2026_11_19_000002_a_add_manage_staff_accounts_permission'
);

-- 3. Clear the cached permissions so the new menu item shows immediately.
DELETE FROM `cache` WHERE `key` LIKE '%spatie.permission.cache%';

-- Check: should list secretary, super_admin and treasurer.
SELECT r.`name` AS `role`
FROM `role_has_permissions` rp
JOIN `roles` r ON r.`id` = rp.`role_id`
JOIN `permissions` p ON p.`id` = rp.`permission_id`
WHERE p.`name` = 'manage_staff_accounts'
ORDER BY r.`name`;
