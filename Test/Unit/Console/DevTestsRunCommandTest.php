<?php
/**
 * Copyright (c) 2025 Mohamed EL Mrabet
 * CleatSquad - https://cleatsquad.dev
 *
 * This file is part of the CleatSquad_ParallelTestsPlus module.
 * Licensed under the MIT License. See the LICENSE file in the module root.
 */
declare(strict_types=1);

namespace CleatSquad\ParallelTestsPlus\Test\Unit\Console;

use CleatSquad\ParallelTestsPlus\Console\DevTestsRunCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;


require_once __DIR__ . '/../_files/mock_passthru.php';

/**
 * Tests for the ParallelTestsPlus DevTestsRunCommand override.
 */
class DevTestsRunCommandTest extends TestCase
{
    /**
     * @var DevTestsRunCommand
     */
    private DevTestsRunCommand $command;

    protected function setUp(): void
    {
        $this->command = new DevTestsRunCommand();
    }

    public function testInvalidTestType()
    {
        $commandTester = new CommandTester($this->command);
        $commandTester->execute([DevTestsRunCommand::INPUT_ARG_TYPE => 'bad']);
        $this->assertStringContainsString('Invalid type: "bad"', $commandTester->getDisplay());
    }

    public function testParaTestCommandIsGenerated()
    {
        // Fake global passthru override
        global $devTestsRunCommandTestResult;
        $devTestsRunCommandTestResult = 0;

        $commandTester = new CommandTester($this->command);
        $commandTester->execute(
            [
                DevTestsRunCommand::INPUT_ARG_TYPE => 'unit',
                '-' . DevTestsRunCommand::INPUT_OPT_COMMAND_ARGUMENTS_SHORT => '--list-suites'
            ]
        );
        $this->assertStringContainsString(
            '--list-suites',
            $commandTester->getDisplay(),
            'Parameters should be passed to PHPUnit'
        );
        $this->assertStringContainsString(
            'PASSED (',
            $commandTester->getDisplay(),
            'PHPUnit runs should have passed'
        );
    }

    public function testProcessesOption()
    {
        global $devTestsRunCommandTestResult;
        $devTestsRunCommandTestResult = 0;

        $commandTester = new CommandTester($this->command);

        $commandTester->execute([
            DevTestsRunCommand::INPUT_ARG_TYPE => 'unit',
            '--' . DevTestsRunCommand::INPUT_ARG_PROCESSES => '8',
        ]);

        $this->assertStringContainsString(
            '--processes 8',
            $commandTester->getDisplay(),
            'Parallel process count must be injected'
        );
    }

    public function testRunnerOption()
    {
        global $devTestsRunCommandTestResult;
        $devTestsRunCommandTestResult = 0;

        $commandTester = new CommandTester($this->command);

        $commandTester->execute([
            DevTestsRunCommand::INPUT_ARG_TYPE => 'unit',
            '--' .  DevTestsRunCommand::INPUT_ARG_RUNNER  => 'WrapperRunner'
        ]);

        $this->assertStringContainsString(
            '--runner \'WrapperRunner\'',
            $commandTester->getDisplay(),
            'Runner option must be passed to ParaTest'
        );
    }

    public function testPassArgumentsToPHPUnitNegative()
    {
        global $devTestsRunCommandTestResult;
        $devTestsRunCommandTestResult = 255;

        $commandTester = new CommandTester($this->command);
        $commandTester->execute(
            [
                DevTestsRunCommand::INPUT_ARG_TYPE => 'unit',
                '-' . DevTestsRunCommand::INPUT_OPT_COMMAND_ARGUMENTS_SHORT => '--list-suites',
            ]
        );
        $this->assertStringContainsString(
            '--list-suites',
            $commandTester->getDisplay(),
            'Parameters should be passed to PHPUnit'
        );
        $this->assertStringContainsString(
            'FAILED - ',
            $commandTester->getDisplay(),
            'PHPUnit runs should have passed'
        );
    }

    public function testCommandDirectoryLogging()
    {
        global $devTestsRunCommandTestResult;
        $devTestsRunCommandTestResult = 0;

        $tester = new CommandTester($this->command);
        $tester->execute([DevTestsRunCommand::INPUT_ARG_TYPE => 'unit']);

        $output = $tester->getDisplay();

        $this->assertMatchesRegularExpression(
            '#/dev/tests/.+?>#',
            $output,
            "The command should log the directory it is running in."
        );
    }

    public function testDefaultRunnerIsWrapperRunner()
    {
        global $devTestsRunCommandTestResult;
        $devTestsRunCommandTestResult = 0;
        $tester = new CommandTester($this->command);
        $tester->execute([
            DevTestsRunCommand::INPUT_ARG_TYPE => 'unit',
        ]);
        $this->assertStringContainsString(
            "--runner 'WrapperRunner'",
            $tester->getDisplay()
        );
    }

    public function testProcessesCannotBeBelowOne()
    {
        global $devTestsRunCommandTestResult;
        $devTestsRunCommandTestResult = 0;

        $tester = new CommandTester($this->command);

        $tester->execute([
            DevTestsRunCommand::INPUT_ARG_TYPE => 'unit',
            '--' . DevTestsRunCommand::INPUT_ARG_PROCESSES => '0',
        ]);

        $this->assertStringContainsString(
            '--processes 1',
            $tester->getDisplay()
        );
    }
}
