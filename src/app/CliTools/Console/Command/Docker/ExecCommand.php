<?php

namespace CliTools\Console\Command\Docker;

/*
 * CliTools Command
 * Copyright (C) 2015 Markus Blaschke <markus@familie-blaschke.net>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExecCommand extends AbstractCommand implements \CliTools\Console\Filter\AnyParameterFilterInterface {

    /**
     * Configure command
     */
    protected function configure() {
        $this->setName('docker:exec')
            ->setDescription('Run defined command in docker container');
    }

    /**
     * Execute command
     *
     * @param  InputInterface  $input  Input instance
     * @param  OutputInterface $output Output instance
     *
     * @return int|null|void
     */
    public function execute(InputInterface $input, OutputInterface $output) {
        $paramList = $this->getFullParameterList();
        $container = $this->getApplication()->getConfigValue('docker', 'container');

        if (!empty($paramList)) {
            $comamnd = array_splice($paramList, 0, 1);
            $comamnd = reset($comamnd);

            $ret = $this->executeDockerExec($container, $comamnd, $paramList);
        } else {
            $output->writeln('<error>No command/parameter specified</error>');
            $ret = 1;
        }

        return $ret;
    }
}
