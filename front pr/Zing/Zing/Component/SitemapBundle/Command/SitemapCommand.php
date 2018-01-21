<?php
namespace Zing\Component\SitemapBundle\Command;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SitemapCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this   ->setName('sitemap:build')
                ->setDescription('Running sitemap build');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->getContainer()->get('zing.component.sitemap.build_sitemap')->sitemap());
    }
}