<?php
/**
 * config-audit/audit.php
 *
 * Compares effective Laravel configuration against config-audit/baseline.example.
 * Prints PASS / FAIL / UNVERIFIED for each control. Never prints secret values.
 *
 * Usage:
 *   php config-audit/audit.php                          (checks .env of this project)
 *   php config-audit/audit.php path/to/target/.env      (checks another .env)
 *
 * Exit code: 0 if all required checks pass, 1 if any required check fails.
 */

$baselinePath = __DIR__ . '/baseline.example';
if (!file_exists($baselinePath)) {
    fwrite(STDERR, "FAIL: baseline file not found at {$baselinePath}\n");
    exit(1);
}
$baseline = parse_ini_file($baselinePath, false, INI_SCANNER_RAW);
if ($baseline === false) {
    fwrite(STDERR, "FAIL: baseline file could not be parsed\n");
    exit(1);
}

// Optional first arg overrides the .env path
$envPath = $argv[1] ?? (__DIR__ . '/../.env');
if (!file_exists($envPath)) {
    fwrite(STDERR, "FAIL: .env not found at {$envPath}\n");
    exit(1);
}
$env = parse_ini_file($envPath, false, INI_SCANNER_RAW);

$failures = 0;

// ---- 1. debug_off ----
$debugOk = isset($env['APP_DEBUG']) && strtolower((string)$env['APP_DEBUG']) === 'false';
echo $debugOk ? "debug_off PASS\n" : "debug_off FAIL\n";
if (!$debugOk) $failures++;

// ---- 2. app_key_present (presence only — never print the value) ----
$keyPresent = !empty($env['APP_KEY']);
echo $keyPresent ? "app_key_present PASS\n" : "app_key_present FAIL\n";
if (!$keyPresent) $failures++;

// ---- 3. document_root ----
$docRootOk = file_exists(__DIR__ . '/../public/index.php');
echo $docRootOk ? "document_root PASS\n" : "document_root FAIL\n";
if (!$docRootOk) $failures++;

// ---- 4. writable_paths ----
$storageOk = is_writable(__DIR__ . '/../storage');
$cacheOk   = is_writable(__DIR__ . '/../bootstrap/cache');
$writableOk = $storageOk && $cacheOk;
echo $writableOk ? "writable_paths PASS\n" : "writable_paths FAIL\n";
if (!$writableOk) $failures++;

// ---- 5. environment_label ----
$expectedLabel = $baseline['environment_label'] ?? null;
$actualLabel = $env['APP_ENV'] ?? null;
$labelOk = $expectedLabel !== null && $actualLabel === $expectedLabel;
echo $labelOk ? "environment_label PASS\n" : "environment_label FAIL\n";
if (!$labelOk) $failures++;

// ---- 6. database_access_scope (cannot introspect from PHP in this context) ----
echo "database_access_scope UNVERIFIED\n";

// Exit non-zero if any required check failed
exit($failures > 0 ? 1 : 0);