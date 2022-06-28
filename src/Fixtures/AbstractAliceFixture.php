<?php

namespace Aligent\FixturesBundle\Fixtures;

use Aligent\FixturesBundle\Initializer\ReferenceInitializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use Fidry\AliceDataFixtures\Loader\PurgerLoader;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\VarDumper\VarDumper;

abstract class AbstractAliceFixture extends AbstractFixture implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function load(ObjectManager $manager): void
    {
        /** @var PurgerLoader  $loader */
        $loader = $this->container->get('fidry_alice_data_fixtures.loader.doctrine');
        $fixturesPath = $this->getFixtures();

        $files = [];
        if (is_dir($fixturesPath)) {
            $finder = new Finder();
            $finder->in($fixturesPath)
                ->name('*.yml')
                ->files();

            if (!$finder->hasResults()) {
                return;
            }

            foreach ($finder as $file) {
                $files[] = $file->getRealPath();
            }
        } else {
            $file = new File($fixturesPath, true);

            if ($file->getExtension() !== 'yml' && $file->getExtension() !== 'yaml') {
                throw new FileException('Expected either a .yaml or .yml file.');
            }

            $files[] = $file->getRealPath();
        }

        /** @var ReferenceInitializer $initializer */
        $initializer = $this->container->get(ReferenceInitializer::class);
        $references = new ArrayCollection();
        $initializer->init($manager, $references);
        $loader->load($files, [], $references->toArray());
    }

    /**
     * The path to an alice fixture, or directory of alice fixtures
     * @return string
     */
    abstract protected function getFixtures(): string;
}
