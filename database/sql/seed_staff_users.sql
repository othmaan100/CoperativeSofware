-- =============================================================================
-- COOP Software — Initial Setup Seed Script
--   (roles, permissions, savings products and staff/admin accounts)
-- =============================================================================
--
-- PURPOSE
--   Prepares a freshly migrated database (e.g. on a new remote/production
--   server) so the system is usable immediately:
--     1. All permissions and roles, with each role granted the permissions
--        it needs for its duties and modules (mirrors
--        database/seeders/RolesAndPermissionsSeeder.php exactly).
--     2. The savings products (Regular Savings + Target/Special Savings) and
--        the default Regular Savings minimum-balance withdrawal rule, so
--        contribution batches can be posted and savings managed
--        (mirrors database/seeders/SavingsSeeder.php).
--     3. The core staff/admin accounts (Super Admin, Treasurer, Chairman,
--        Secretary, Store Officer, Auditor, Exco, Loan Officer), so only
--        ordinary MEMBER registration needs to go through the app itself.
--     4. Clears the cached permission list so the app picks up the roles and
--        permissions above straight away.
--
-- BEFORE YOU RUN THIS
--   1. Run the normal Laravel migrations on the target database first:
--        php artisan migrate --force
--      Nothing else needs to be seeded first — this script creates the roles
--      and permissions itself.
--   2. Replace every `name` and `email` placeholder in section 3 with the
--      real person's name and real email address for that position.
--   3. TESTING SETUP: every account is created with the password
--      12345678 and `must_change_password = 0`, so you can log in
--      straight away without being asked to change it.
--   4. This script is idempotent (safe to run more than once) — re-running it
--      never creates duplicate permissions, roles, role assignments, savings
--      products, withdrawal rules or users. It only ADDS what is missing; it
--      never removes or overwrites anything that already exists.
--
-- HOW TO RUN
--   mysql -u <user> -p <database> < database/sql/seed_staff_users.sql
--   -- or import it via phpMyAdmin / your hosting control panel's SQL tab.
--
-- AFTER RUNNING
--   Section 4 clears the permission cache, which works when the app uses
--   CACHE_STORE=database (the current setting). If the server uses a
--   different cache store (file, redis, ...), run this once instead:
--     php artisan permission:cache-reset
--
-- NOT INCLUDED (still seeded with artisan if you need them)
--   Loan products, share price, system settings and the commodity catalogue:
--     php artisan db:seed --class=SettingsSeeder --force
--     php artisan db:seed --class=ShareSeeder --force
--     php artisan db:seed --class=LoanSeeder --force
--     php artisan db:seed --class=CommodityCatalogueSeeder --force
--
-- SECURITY NOTE
--   All accounts share the bcrypt (cost 12) hash of the temporary password
--   12345678. Because that password is now written in this file, do NOT
--   commit this file to a public repository, and make sure every person
--   logs in and changes their password before the system goes live.
-- =============================================================================

START TRANSACTION;

-- =============================================================================
-- SECTION 1 — PERMISSIONS, ROLES AND ROLE ASSIGNMENTS
-- =============================================================================
--   Each role below gets exactly the permissions RolesAndPermissionsSeeder
--   grants it. Super Admin receives every permission.
--   Summary of duties:
--     member        — own profile, savings, loans, shares, dividends, complaints
--     treasurer     — membership approvals, contributions, withdrawals, loans,
--                     shares, dividends, budgets, welfare, reports
--     chairman      — second-signature authorisations, rates/settings,
--                     announcements, budget approval, reports
--     secretary     — member change requests, commodity catalogue/cycles,
--                     announcements, complaints
--     store_officer — commodity cycle approval and goods release
--     auditor       — read-only: activity log, financial statements, reports
--     exco          — read-only: reports, complaints
--     loan_officer  — view members
--     applicant     — view own application (before approval)
-- -----------------------------------------------------------------------------

-- 1. Permissions (83)
INSERT INTO permissions (name, guard_name, created_at, updated_at) VALUES
  ('view_own_application', 'web', NOW(), NOW()),
  ('view_own_profile', 'web', NOW(), NOW()),
  ('edit_own_profile', 'web', NOW(), NOW()),
  ('request_exit', 'web', NOW(), NOW()),
  ('view_all_members', 'web', NOW(), NOW()),
  ('approve_applications', 'web', NOW(), NOW()),
  ('reject_applications', 'web', NOW(), NOW()),
  ('adjust_contribution', 'web', NOW(), NOW()),
  ('mark_application_fee_paid', 'web', NOW(), NOW()),
  ('review_change_requests', 'web', NOW(), NOW()),
  ('edit_locked_fields', 'web', NOW(), NOW()),
  ('manage_member_status', 'web', NOW(), NOW()),
  ('export_reports', 'web', NOW(), NOW()),
  ('view_registration_fee_reports', 'web', NOW(), NOW()),
  ('manage_registration_fee_settings', 'web', NOW(), NOW()),
  ('view_own_savings', 'web', NOW(), NOW()),
  ('request_withdrawal', 'web', NOW(), NOW()),
  ('make_voluntary_deposit', 'web', NOW(), NOW()),
  ('post_contribution_batch', 'web', NOW(), NOW()),
  ('confirm_voluntary_deposit', 'web', NOW(), NOW()),
  ('treasurer_review_withdrawal', 'web', NOW(), NOW()),
  ('chairman_authorize_withdrawal', 'web', NOW(), NOW()),
  ('disburse_withdrawal', 'web', NOW(), NOW()),
  ('initiate_reversal', 'web', NOW(), NOW()),
  ('authorize_reversal', 'web', NOW(), NOW()),
  ('manage_withdrawal_conditions', 'web', NOW(), NOW()),
  ('manage_savings_products', 'web', NOW(), NOW()),
  ('view_savings_reports', 'web', NOW(), NOW()),
  ('import_members', 'web', NOW(), NOW()),
  ('view_own_loans', 'web', NOW(), NOW()),
  ('apply_for_loan', 'web', NOW(), NOW()),
  ('treasurer_review_loan', 'web', NOW(), NOW()),
  ('chairman_authorize_loan', 'web', NOW(), NOW()),
  ('disburse_loan', 'web', NOW(), NOW()),
  ('post_loan_repayment_batch', 'web', NOW(), NOW()),
  ('confirm_loan_repayment', 'web', NOW(), NOW()),
  ('manage_loan_products', 'web', NOW(), NOW()),
  ('set_loan_interest_rates', 'web', NOW(), NOW()),
  ('manage_loan_limit_multiplier', 'web', NOW(), NOW()),
  ('import_loans', 'web', NOW(), NOW()),
  ('view_loan_reports', 'web', NOW(), NOW()),
  ('view_own_shares', 'web', NOW(), NOW()),
  ('purchase_shares', 'web', NOW(), NOW()),
  ('request_share_withdrawal', 'web', NOW(), NOW()),
  ('confirm_share_purchase', 'web', NOW(), NOW()),
  ('treasurer_review_share_withdrawal', 'web', NOW(), NOW()),
  ('chairman_authorize_share_withdrawal', 'web', NOW(), NOW()),
  ('disburse_share_withdrawal', 'web', NOW(), NOW()),
  ('manage_share_price', 'web', NOW(), NOW()),
  ('view_share_reports', 'web', NOW(), NOW()),
  ('view_own_dividends', 'web', NOW(), NOW()),
  ('manage_dividend_periods', 'web', NOW(), NOW()),
  ('declare_dividend_rates', 'web', NOW(), NOW()),
  ('calculate_dividends', 'web', NOW(), NOW()),
  ('post_dividends', 'web', NOW(), NOW()),
  ('view_dividend_reports', 'web', NOW(), NOW()),
  ('request_commodity_loan', 'web', NOW(), NOW()),
  ('manage_commodity_catalogue', 'web', NOW(), NOW()),
  ('manage_commodity_cycles', 'web', NOW(), NOW()),
  ('price_commodity_cycle', 'web', NOW(), NOW()),
  ('verify_commodity_cycle', 'web', NOW(), NOW()),
  ('approve_commodity_cycle', 'web', NOW(), NOW()),
  ('authorize_commodity_cycle', 'web', NOW(), NOW()),
  ('release_commodity_goods', 'web', NOW(), NOW()),
  ('view_activity_log', 'web', NOW(), NOW()),
  ('manage_member_documents', 'web', NOW(), NOW()),
  ('manage_loan_documents', 'web', NOW(), NOW()),
  ('manage_announcements', 'web', NOW(), NOW()),
  ('view_financial_statements', 'web', NOW(), NOW()),
  ('raise_complaint', 'web', NOW(), NOW()),
  ('raise_complaint_on_behalf', 'web', NOW(), NOW()),
  ('handle_complaints', 'web', NOW(), NOW()),
  ('handle_confidential_complaints', 'web', NOW(), NOW()),
  ('manage_budgets', 'web', NOW(), NOW()),
  ('approve_budgets', 'web', NOW(), NOW()),
  ('view_budget_reports', 'web', NOW(), NOW()),
  ('initiate_welfare_claim', 'web', NOW(), NOW()),
  ('authorize_welfare_claim', 'web', NOW(), NOW()),
  ('disburse_welfare_claim', 'web', NOW(), NOW()),
  ('post_welfare_levy', 'web', NOW(), NOW()),
  ('manage_welfare_settings', 'web', NOW(), NOW()),
  ('view_welfare_reports', 'web', NOW(), NOW()),
  ('manage_users', 'web', NOW(), NOW())
ON DUPLICATE KEY UPDATE name = name;

-- 2. Roles (10)
INSERT INTO roles (name, guard_name, created_at, updated_at) VALUES
  ('applicant', 'web', NOW(), NOW()),
  ('member', 'web', NOW(), NOW()),
  ('treasurer', 'web', NOW(), NOW()),
  ('chairman', 'web', NOW(), NOW()),
  ('secretary', 'web', NOW(), NOW()),
  ('exco', 'web', NOW(), NOW()),
  ('loan_officer', 'web', NOW(), NOW()),
  ('auditor', 'web', NOW(), NOW()),
  ('store_officer', 'web', NOW(), NOW()),
  ('super_admin', 'web', NOW(), NOW())
ON DUPLICATE KEY UPDATE name = name;

-- 3. Role -> permission assignments

-- applicant (1 permissions)
INSERT INTO role_has_permissions (permission_id, role_id)
SELECT p.id, r.id FROM permissions p
JOIN roles r ON r.name = 'applicant' AND r.guard_name = 'web'
WHERE p.guard_name = 'web' AND p.name IN (
      'view_own_application'
  )
  AND NOT EXISTS (SELECT 1 FROM role_has_permissions x WHERE x.permission_id = p.id AND x.role_id = r.id);

-- member (15 permissions)
INSERT INTO role_has_permissions (permission_id, role_id)
SELECT p.id, r.id FROM permissions p
JOIN roles r ON r.name = 'member' AND r.guard_name = 'web'
WHERE p.guard_name = 'web' AND p.name IN (
      'view_own_application', 'view_own_profile', 'edit_own_profile', 'request_exit',
      'view_own_savings', 'request_withdrawal', 'make_voluntary_deposit', 'view_own_loans',
      'apply_for_loan', 'view_own_shares', 'purchase_shares', 'request_share_withdrawal',
      'view_own_dividends', 'request_commodity_loan', 'raise_complaint'
  )
  AND NOT EXISTS (SELECT 1 FROM role_has_permissions x WHERE x.permission_id = p.id AND x.role_id = r.id);

-- treasurer (43 permissions)
INSERT INTO role_has_permissions (permission_id, role_id)
SELECT p.id, r.id FROM permissions p
JOIN roles r ON r.name = 'treasurer' AND r.guard_name = 'web'
WHERE p.guard_name = 'web' AND p.name IN (
      'view_all_members', 'approve_applications', 'reject_applications', 'adjust_contribution',
      'mark_application_fee_paid', 'manage_member_status', 'export_reports', 'view_registration_fee_reports',
      'post_contribution_batch', 'confirm_voluntary_deposit', 'treasurer_review_withdrawal', 'disburse_withdrawal',
      'initiate_reversal', 'manage_withdrawal_conditions', 'view_savings_reports', 'import_members',
      'treasurer_review_loan', 'disburse_loan', 'post_loan_repayment_batch', 'confirm_loan_repayment',
      'manage_loan_limit_multiplier', 'import_loans', 'view_loan_reports', 'confirm_share_purchase',
      'treasurer_review_share_withdrawal', 'disburse_share_withdrawal', 'manage_share_price', 'view_share_reports',
      'manage_dividend_periods', 'calculate_dividends', 'post_dividends', 'view_dividend_reports',
      'manage_member_documents', 'manage_loan_documents', 'view_financial_statements', 'raise_complaint_on_behalf',
      'handle_complaints', 'manage_budgets', 'view_budget_reports', 'initiate_welfare_claim',
      'disburse_welfare_claim', 'post_welfare_levy', 'view_welfare_reports'
  )
  AND NOT EXISTS (SELECT 1 FROM role_has_permissions x WHERE x.permission_id = p.id AND x.role_id = r.id);

-- chairman (26 permissions)
INSERT INTO role_has_permissions (permission_id, role_id)
SELECT p.id, r.id FROM permissions p
JOIN roles r ON r.name = 'chairman' AND r.guard_name = 'web'
WHERE p.guard_name = 'web' AND p.name IN (
      'view_all_members', 'view_registration_fee_reports', 'manage_registration_fee_settings', 'chairman_authorize_withdrawal',
      'authorize_reversal', 'manage_withdrawal_conditions', 'view_savings_reports', 'chairman_authorize_loan',
      'set_loan_interest_rates', 'view_loan_reports', 'chairman_authorize_share_withdrawal', 'manage_share_price',
      'view_share_reports', 'declare_dividend_rates', 'view_dividend_reports', 'authorize_commodity_cycle',
      'manage_loan_documents', 'manage_announcements', 'view_financial_statements', 'handle_complaints',
      'handle_confidential_complaints', 'approve_budgets', 'view_budget_reports', 'authorize_welfare_claim',
      'manage_welfare_settings', 'view_welfare_reports'
  )
  AND NOT EXISTS (SELECT 1 FROM role_has_permissions x WHERE x.permission_id = p.id AND x.role_id = r.id);

-- secretary (11 permissions)
INSERT INTO role_has_permissions (permission_id, role_id)
SELECT p.id, r.id FROM permissions p
JOIN roles r ON r.name = 'secretary' AND r.guard_name = 'web'
WHERE p.guard_name = 'web' AND p.name IN (
      'view_all_members', 'review_change_requests', 'export_reports', 'manage_commodity_catalogue',
      'manage_commodity_cycles', 'price_commodity_cycle', 'manage_member_documents', 'manage_announcements',
      'raise_complaint_on_behalf', 'handle_complaints', 'initiate_welfare_claim'
  )
  AND NOT EXISTS (SELECT 1 FROM role_has_permissions x WHERE x.permission_id = p.id AND x.role_id = r.id);

-- exco (10 permissions)
INSERT INTO role_has_permissions (permission_id, role_id)
SELECT p.id, r.id FROM permissions p
JOIN roles r ON r.name = 'exco' AND r.guard_name = 'web'
WHERE p.guard_name = 'web' AND p.name IN (
      'view_all_members', 'export_reports', 'view_registration_fee_reports', 'view_savings_reports',
      'view_loan_reports', 'view_share_reports', 'view_dividend_reports', 'handle_complaints',
      'view_budget_reports', 'view_welfare_reports'
  )
  AND NOT EXISTS (SELECT 1 FROM role_has_permissions x WHERE x.permission_id = p.id AND x.role_id = r.id);

-- loan_officer (1 permissions)
INSERT INTO role_has_permissions (permission_id, role_id)
SELECT p.id, r.id FROM permissions p
JOIN roles r ON r.name = 'loan_officer' AND r.guard_name = 'web'
WHERE p.guard_name = 'web' AND p.name IN (
      'view_all_members'
  )
  AND NOT EXISTS (SELECT 1 FROM role_has_permissions x WHERE x.permission_id = p.id AND x.role_id = r.id);

-- auditor (6 permissions)
INSERT INTO role_has_permissions (permission_id, role_id)
SELECT p.id, r.id FROM permissions p
JOIN roles r ON r.name = 'auditor' AND r.guard_name = 'web'
WHERE p.guard_name = 'web' AND p.name IN (
      'view_all_members', 'verify_commodity_cycle', 'view_activity_log', 'view_financial_statements',
      'view_budget_reports', 'view_welfare_reports'
  )
  AND NOT EXISTS (SELECT 1 FROM role_has_permissions x WHERE x.permission_id = p.id AND x.role_id = r.id);

-- store_officer (3 permissions)
INSERT INTO role_has_permissions (permission_id, role_id)
SELECT p.id, r.id FROM permissions p
JOIN roles r ON r.name = 'store_officer' AND r.guard_name = 'web'
WHERE p.guard_name = 'web' AND p.name IN (
      'view_all_members', 'approve_commodity_cycle', 'release_commodity_goods'
  )
  AND NOT EXISTS (SELECT 1 FROM role_has_permissions x WHERE x.permission_id = p.id AND x.role_id = r.id);

-- super_admin (83 permissions)
INSERT INTO role_has_permissions (permission_id, role_id)
SELECT p.id, r.id FROM permissions p
JOIN roles r ON r.name = 'super_admin' AND r.guard_name = 'web'
WHERE p.guard_name = 'web'
  AND NOT EXISTS (SELECT 1 FROM role_has_permissions x WHERE x.permission_id = p.id AND x.role_id = r.id);

-- =============================================================================
-- SECTION 2 — SAVINGS PRODUCTS AND DEFAULT WITHDRAWAL RULE
-- =============================================================================
--   The Regular Savings product is required for posting contribution
--   batches, voluntary deposits, withdrawals and opening member savings
--   accounts. The 5,000 minimum balance is a starting default; the
--   Chairman/Treasurer can change it on the Withdrawal Rules screen.
-- -----------------------------------------------------------------------------
INSERT INTO savings_products (code, name, is_interest_bearing, description, is_active, created_at, updated_at)
SELECT 'regular', 'Regular Savings', 0, 'Funded by approved monthly salary deduction plus voluntary top-ups.', 1, NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM savings_products WHERE code = 'regular');

INSERT INTO savings_products (code, name, is_interest_bearing, description, is_active, created_at, updated_at)
SELECT 'target', 'Target/Special Savings', 0, 'Member-defined goal savings with an optional target amount and date.', 1, NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM savings_products WHERE code = 'target');

-- Default minimum balance rule for Regular Savings
INSERT INTO withdrawal_conditions (savings_product_id, rule_type, value, description, is_active, created_at, updated_at)
SELECT sp.id, 'minimum_balance', '5000', 'Minimum balance that must remain in Regular Savings after any withdrawal.', 1, NOW(), NOW()
FROM savings_products sp WHERE sp.code = 'regular'
  AND NOT EXISTS (SELECT 1 FROM withdrawal_conditions w WHERE w.savings_product_id = sp.id AND w.rule_type = 'minimum_balance');

-- =============================================================================
-- SECTION 3 — STAFF / ADMIN ACCOUNTS
-- =============================================================================
--   Each user is only inserted if no user with that email already exists,
--   and each role is only assigned if that assignment does not already
--   exist. Existing users are left untouched (their password is NOT reset).
-- -----------------------------------------------------------------------------
-- Super Admin
-- -----------------------------------------------------------------------------
INSERT INTO users (name, email, password, must_change_password, email_verified_at, created_at, updated_at)
SELECT 'System Administrator', 'admin@fcetpotiskum.com.ng',
       '$2y$12$LLPiznagz6bVMT1brl2BBOcQxTyail66DHMwUM0gzCAWMn7ZJNexW',
       0, NOW(), NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM users WHERE email = 'admin@fcetpotiskum.com.ng');

INSERT INTO model_has_roles (role_id, model_id, model_type)
SELECT r.id, u.id, 'App\\Models\\User'
FROM roles r, users u
WHERE r.name = 'super_admin' AND r.guard_name = 'web' AND u.email = 'admin@fcetpotiskum.com.ng'
  AND NOT EXISTS (
      SELECT 1 FROM model_has_roles mhr
      WHERE mhr.role_id = r.id AND mhr.model_id = u.id AND mhr.model_type = 'App\\Models\\User'
  );

-- -----------------------------------------------------------------------------
-- Treasurer
-- -----------------------------------------------------------------------------
INSERT INTO users (name, email, password, must_change_password, email_verified_at, created_at, updated_at)
SELECT 'Treasurer', 'treasurer@fcetpotiskum.com.ng',
       '$2y$12$LLPiznagz6bVMT1brl2BBOcQxTyail66DHMwUM0gzCAWMn7ZJNexW',
       0, NOW(), NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM users WHERE email = 'treasurer@fcetpotiskum.com.ng');

INSERT INTO model_has_roles (role_id, model_id, model_type)
SELECT r.id, u.id, 'App\\Models\\User'
FROM roles r, users u
WHERE r.name = 'treasurer' AND r.guard_name = 'web' AND u.email = 'treasurer@fcetpotiskum.com.ng'
  AND NOT EXISTS (
      SELECT 1 FROM model_has_roles mhr
      WHERE mhr.role_id = r.id AND mhr.model_id = u.id AND mhr.model_type = 'App\\Models\\User'
  );

-- -----------------------------------------------------------------------------
-- Chairman
-- -----------------------------------------------------------------------------
INSERT INTO users (name, email, password, must_change_password, email_verified_at, created_at, updated_at)
SELECT 'Chairman', 'chairman@fcetpotiskum.com.ng',
       '$2y$12$LLPiznagz6bVMT1brl2BBOcQxTyail66DHMwUM0gzCAWMn7ZJNexW',
       0, NOW(), NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM users WHERE email = 'chairman@fcetpotiskum.com.ng');

INSERT INTO model_has_roles (role_id, model_id, model_type)
SELECT r.id, u.id, 'App\\Models\\User'
FROM roles r, users u
WHERE r.name = 'chairman' AND r.guard_name = 'web' AND u.email = 'chairman@fcetpotiskum.com.ng'
  AND NOT EXISTS (
      SELECT 1 FROM model_has_roles mhr
      WHERE mhr.role_id = r.id AND mhr.model_id = u.id AND mhr.model_type = 'App\\Models\\User'
  );

-- -----------------------------------------------------------------------------
-- Secretary
-- -----------------------------------------------------------------------------
INSERT INTO users (name, email, password, must_change_password, email_verified_at, created_at, updated_at)
SELECT 'Secretary', 'secretary@fcetpotiskum.com.ng',
       '$2y$12$LLPiznagz6bVMT1brl2BBOcQxTyail66DHMwUM0gzCAWMn7ZJNexW',
       0, NOW(), NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM users WHERE email = 'secretary@fcetpotiskum.com.ng');

INSERT INTO model_has_roles (role_id, model_id, model_type)
SELECT r.id, u.id, 'App\\Models\\User'
FROM roles r, users u
WHERE r.name = 'secretary' AND r.guard_name = 'web' AND u.email = 'secretary@fcetpotiskum.com.ng'
  AND NOT EXISTS (
      SELECT 1 FROM model_has_roles mhr
      WHERE mhr.role_id = r.id AND mhr.model_id = u.id AND mhr.model_type = 'App\\Models\\User'
  );

-- -----------------------------------------------------------------------------
-- Store Officer
-- -----------------------------------------------------------------------------
INSERT INTO users (name, email, password, must_change_password, email_verified_at, created_at, updated_at)
SELECT 'Store Officer', 'store.officer@fcetpotiskum.com.ng',
       '$2y$12$LLPiznagz6bVMT1brl2BBOcQxTyail66DHMwUM0gzCAWMn7ZJNexW',
       0, NOW(), NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM users WHERE email = 'store.officer@fcetpotiskum.com.ng');

INSERT INTO model_has_roles (role_id, model_id, model_type)
SELECT r.id, u.id, 'App\\Models\\User'
FROM roles r, users u
WHERE r.name = 'store_officer' AND r.guard_name = 'web' AND u.email = 'store.officer@fcetpotiskum.com.ng'
  AND NOT EXISTS (
      SELECT 1 FROM model_has_roles mhr
      WHERE mhr.role_id = r.id AND mhr.model_id = u.id AND mhr.model_type = 'App\\Models\\User'
  );

-- -----------------------------------------------------------------------------
-- Auditor
-- -----------------------------------------------------------------------------
INSERT INTO users (name, email, password, must_change_password, email_verified_at, created_at, updated_at)
SELECT 'Auditor', 'auditor@fcetpotiskum.com.ng',
       '$2y$12$LLPiznagz6bVMT1brl2BBOcQxTyail66DHMwUM0gzCAWMn7ZJNexW',
       0, NOW(), NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM users WHERE email = 'auditor@fcetpotiskum.com.ng');

INSERT INTO model_has_roles (role_id, model_id, model_type)
SELECT r.id, u.id, 'App\\Models\\User'
FROM roles r, users u
WHERE r.name = 'auditor' AND r.guard_name = 'web' AND u.email = 'auditor@fcetpotiskum.com.ng'
  AND NOT EXISTS (
      SELECT 1 FROM model_has_roles mhr
      WHERE mhr.role_id = r.id AND mhr.model_id = u.id AND mhr.model_type = 'App\\Models\\User'
  );

-- -----------------------------------------------------------------------------
-- Exco Member
--   (Add more blocks like this one, copy/pasted, if the Exco has several
--   members — just give each a distinct email.)
-- -----------------------------------------------------------------------------
INSERT INTO users (name, email, password, must_change_password, email_verified_at, created_at, updated_at)
SELECT 'Exco Member', 'exco@fcetpotiskum.com.ng',
       '$2y$12$LLPiznagz6bVMT1brl2BBOcQxTyail66DHMwUM0gzCAWMn7ZJNexW',
       0, NOW(), NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM users WHERE email = 'exco@fcetpotiskum.com.ng');

INSERT INTO model_has_roles (role_id, model_id, model_type)
SELECT r.id, u.id, 'App\\Models\\User'
FROM roles r, users u
WHERE r.name = 'exco' AND r.guard_name = 'web' AND u.email = 'exco@fcetpotiskum.com.ng'
  AND NOT EXISTS (
      SELECT 1 FROM model_has_roles mhr
      WHERE mhr.role_id = r.id AND mhr.model_id = u.id AND mhr.model_type = 'App\\Models\\User'
  );

-- -----------------------------------------------------------------------------
-- Loan Officer
-- -----------------------------------------------------------------------------
INSERT INTO users (name, email, password, must_change_password, email_verified_at, created_at, updated_at)
SELECT 'Loan Officer', 'loan.officer@fcetpotiskum.com.ng',
       '$2y$12$LLPiznagz6bVMT1brl2BBOcQxTyail66DHMwUM0gzCAWMn7ZJNexW',
       0, NOW(), NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM users WHERE email = 'loan.officer@fcetpotiskum.com.ng');

INSERT INTO model_has_roles (role_id, model_id, model_type)
SELECT r.id, u.id, 'App\\Models\\User'
FROM roles r, users u
WHERE r.name = 'loan_officer' AND r.guard_name = 'web' AND u.email = 'loan.officer@fcetpotiskum.com.ng'
  AND NOT EXISTS (
      SELECT 1 FROM model_has_roles mhr
      WHERE mhr.role_id = r.id AND mhr.model_id = u.id AND mhr.model_type = 'App\\Models\\User'
  );

-- =============================================================================
-- SECTION 4 — CLEAR THE CACHED PERMISSION LIST
-- =============================================================================
--   The app caches roles/permissions for 24 hours. Removing the cached copy
--   makes it reload the roles and permissions created above immediately.
-- -----------------------------------------------------------------------------
DELETE FROM cache WHERE `key` LIKE '%spatie.permission.cache';

COMMIT;

-- =============================================================================
-- After running: verify with
--   -- staff accounts and their roles
--   SELECT u.id, u.name, u.email, r.name AS role
--   FROM users u
--   JOIN model_has_roles mhr ON mhr.model_id = u.id AND mhr.model_type = 'App\\Models\\User'
--   JOIN roles r ON r.id = mhr.role_id
--   ORDER BY r.name;
--
--   -- permissions per role (expect: super_admin 83, treasurer 43, chairman 26,
--   --  member 15, secretary 11, exco 10, auditor 6, store_officer 3,
--   --  applicant 1, loan_officer 1)
--   SELECT r.name, COUNT(*) AS permissions
--   FROM roles r JOIN role_has_permissions rhp ON rhp.role_id = r.id
--   GROUP BY r.name ORDER BY permissions DESC;
--
--   -- savings products (expect: regular, target)
--   SELECT code, name, is_active FROM savings_products;
-- =============================================================================
