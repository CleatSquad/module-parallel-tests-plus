<?php
/**
 * Copyright (c) 2025 Mohamed EL Mrabet
 * CleatSquad - https://cleatsquad.dev
 *
 * This file is part of the CleatSquad_ParallelTestsPlus module.
 * Licensed under the MIT License. See the LICENSE file in the module root.
 */
declare(strict_types=1);

namespace CleatSquad\ParallelTestsPlus\Console;

/**
 * Test-only override of passthru()
 */
function passthru($command, &$return_var = null)
{
    global $devTestsRunCommandTestResult;
    $return_var = $devTestsRunCommandTestResult ?? 0;
}
