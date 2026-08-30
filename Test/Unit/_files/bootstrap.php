<?php

/**
 * Copyright (c) 2025 Mohamed EL Mrabet
 * CleatSquad - https://cleatsquad.dev
 *
 * This file is part of the CleatSquad_ParallelTestsPlus module.
 * Licensed under the MIT License. See the LICENSE file in the module root.
 */
declare(strict_types=1);

require __DIR__ . '/../../../vendor/autoload.php';

/**
 * DevTestsRunCommand reads Magento's BP constant and app/etc/vendor_path.php.
 * Outside a real Magento installation (e.g. running this module's own unit
 * tests standalone), fake a minimal Magento directory layout so the command
 * can resolve its test directories.
 */
$fixtureRoot = sys_get_temp_dir() . '/parallel-tests-plus-fixture';

$testDirs = [
    'dev/tests/unit',
    'dev/tests/static/framework/tests/unit',
    'dev/tests/integration/framework/tests/unit',
    'dev/tests/integration',
    'dev/tests/static',
    'app/etc',
];

foreach ($testDirs as $relativeDir) {
    $path = $fixtureRoot . '/' . $relativeDir;
    if (!is_dir($path)) {
        mkdir($path, 0777, true);
    }
}

file_put_contents($fixtureRoot . '/app/etc/vendor_path.php', "<?php\nreturn 'vendor';\n");

if (!defined('BP')) {
    define('BP', $fixtureRoot);
}
