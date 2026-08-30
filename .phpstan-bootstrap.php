<?php

/**
 * Copyright (c) 2025 Mohamed EL Mrabet
 * CleatSquad - https://cleatsquad.dev
 *
 * This file is part of the CleatSquad_ParallelTestsPlus module.
 * Licensed under the MIT License. See the LICENSE file in the module root.
 */
declare(strict_types=1);

/**
 * BP is defined at runtime by Magento's app/bootstrap.php; declare it here
 * so PHPStan can resolve it statically without a real Magento installation.
 */
if (!defined('BP')) {
    define('BP', __DIR__);
}
