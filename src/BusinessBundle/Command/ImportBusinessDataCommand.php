<?php

namespace BusinessBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;


class ImportBusinessDataCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('api:import:business_data')
            ->setDescription('Import industries and counterparts csv file.')
            ->addArgument('file_path', InputArgument::OPTIONAL, 'business data file path');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filePath = $input->getArgument('file_path');

        if ($filePath !== null && !is_file($filePath)) {
            throw new \Exception("File not found : '" . $filePath . "'!");
        }
        if (null == $filePath) {
            throw new \Exception("File path is required");
        }
        if ($this->getContainer()->get('api.import_business_data')->import($filePath)) {
            $output->writeln('File imported');
        }
    }
}
