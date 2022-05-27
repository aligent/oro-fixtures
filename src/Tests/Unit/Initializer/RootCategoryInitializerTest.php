<?php
namespace Aligent\FixturesBundle\Tests\Unit\Initializer;

use Aligent\FixturesBundle\Initializer\RootCategoryInitializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Oro\Bundle\CatalogBundle\Entity\Category;
use Oro\Bundle\CatalogBundle\Provider\MasterCatalogRootProviderInterface;
use PHPUnit\Framework\TestCase;

class RootCategoryInitializerTest extends TestCase
{
    public function testInit(): void
    {
        $catalogRootProvider = $this->createMock(MasterCatalogRootProviderInterface::class);
        $initializer = new RootCategoryInitializer($catalogRootProvider);
        $collection = new ArrayCollection();
        $manager = $this->createMock(ObjectManager::class);
        $category = new Category();

        $catalogRootProvider->expects($this->once())
            ->method('getMasterCatalogRoot')
            ->willReturn($category);


        $initializer->init($manager, $collection);

        $this->assertArrayHasKey('root_category', $collection);
        $this->assertContains($category, $collection);
    }
}
