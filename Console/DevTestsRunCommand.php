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

use Magento\Developer\Console\Command\DevTestsRunCommand as OriginalCommand;
use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Override of Magento's dev:tests:run command to enable ParaTest.
 */
class DevTestsRunCommand extends OriginalCommand
{
    /**
     * Maps phpunit test names to directory and target name
     *
     * @var array
     */
    protected array $commands = [];

    /**
     * Maps types (from user input) to phpunit test names
     *
     * @var array
     */
    protected array $types = [];

    /**
     * input processes parameter
     */
    public const INPUT_ARG_PROCESSES = 'processes';

    /**
     * input runner parameter
     */
    public const INPUT_ARG_RUNNER = 'runner';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setupTestInfo();
        parent::configure();

        $this->addOption(
            self::INPUT_ARG_PROCESSES,
            'p',
            InputOption::VALUE_OPTIONAL,
            'Number of ParaTest worker processes.',
            1
        );

        $this->addOption(
            self::INPUT_ARG_RUNNER,
            'r',
            InputOption::VALUE_OPTIONAL,
            'ParaTest runner (WrapperRunner recommended).',
            'WrapperRunner'
        );
    }

    /**
     * Execute Paratest instead of PHPUnit.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int Non-zero if invalid type, 0 otherwise
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /* Validate type argument is valid */
        $processes = max(1, (int)$input->getOption(self::INPUT_ARG_PROCESSES));
        $runner = (string)($input->getOption(self::INPUT_ARG_RUNNER) ?: 'WrapperRunner');
        $type = (string)$input->getArgument(self::INPUT_ARG_TYPE);
        if (!isset($this->types[$type])) {
            $output->writeln(
                'Invalid type: "' . $type . '". Available types: ' . implode(', ', array_keys($this->types))
            );
            return Cli::RETURN_FAILURE;
        }

        $vendorDir = require BP . '/app/etc/vendor_path.php';

        $failures = [];
        $runCommands = $this->types[$type];
        foreach ($runCommands as $key) {
            [$dir, $options] = $this->commands[$key];
            $dirName = realpath(BP . '/dev/tests/' . $dir);
            chdir($dirName);
            // Build ParaTest command
            $command = sprintf(
                '%s %s/%s/bin/paratest --runner %s --processes %d',
                PHP_BINARY,
                BP,
                $vendorDir,
                escapeshellarg($runner),
                $processes
            );
            if ($options) {
                $command .= ' ' . $options;
            }
            $commandArguments = $input->getOption(self::INPUT_OPT_COMMAND_ARGUMENTS);
            if (!empty($commandArguments)) {
                $command .= ' ' . $commandArguments;
            }
            $this->logCommand($output, $dirName, $command);
            // passthru() call have to be here.
            // phpcs:ignore Magento2.Security.InsecureFunction
            passthru($command, $returnVal);
            if ($returnVal !== 0) {
                $failures[] = $command;
            }
        }
        return $this->renderResult($output, $failures, count($runCommands));
    }

    /**
     * Display formatted command block.
     */
    private function logCommand(OutputInterface $output, string $dirName, string $command): void
    {
        $message = $dirName . '> ' . $command;
        $output->writeln(['', str_pad("---- {$message} ", 70, '-'), '']);
    }

    /**
     * Print command execution summary.
     */
    private function renderResult(OutputInterface $output, array $failures, int $total): int
    {
        $output->writeln(str_repeat('-', 70));
        if ($failures !== []) {
            $output->writeln(sprintf("FAILED - %d of %d failed:", count($failures), $total));
            foreach ($failures as $message) {
                $output->writeln(" - $message");
            }
            return Cli::RETURN_FAILURE;
        }

        $output->writeln("PASSED ($total)");
        return Cli::RETURN_SUCCESS;
    }

    /**
     * Initialize test mapping arrays.
     * Mirrors Magento’s native logic.
     */
    private function setupTestInfo(): void
    {
        $this->commands = [
            'unit'                  => ['../tests/unit', ''],
            'unit-static'           => ['../tests/static/framework/tests/unit', ''],
            'unit-integration'      => ['../tests/integration/framework/tests/unit', ''],
            'integration'           => ['../tests/integration', ''],
            'integration-integrity' => ['../tests/integration', ' testsuite/Magento/Test/Integrity'],
            'static-default'        => ['../tests/static', ''],
            'static-legacy'         => ['../tests/static', ' testsuite/Magento/Test/Legacy'],
            'static-integration-js' => ['../tests/static', ' testsuite/Magento/Test/Js/Exemplar'],
        ];

        $this->types = [
            'all'             => array_keys($this->commands),
            'unit'            => ['unit', 'unit-static', 'unit-integration'],
            'integration'     => ['integration'],
            'integration-all' => ['integration', 'integration-integrity'],
            'static'          => ['static-default'],
            'static-all'      => ['static-default', 'static-legacy', 'static-integration-js'],
            'integrity'       => ['static-default', 'static-legacy', 'integration-integrity'],
            'legacy'          => ['static-legacy'],
            'default'         => [
                'unit',
                'unit-static',
                'unit-integration',
                'integration',
                'static-default',
            ],
        ];
    }
}
