<?php
namespace Aligent\FixturesBundle\Tests\Unit\Initializer;

use Aligent\FixturesBundle\Initializer\DefaultPriceListInitializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Oro\Bundle\PricingBundle\Entity\PriceList;
use Oro\Bundle\PricingBundle\Entity\Repository\PriceListRepository;
use PHPUnit\Framework\TestCase;

class DefaultPriceListInitializerTest extends TestCase
{
    public function testInit(): void
    {
        $initializer = new DefaultPriceListInitializer();
        $collection = new ArrayCollection();

        $manager = $this->createMock(ObjectManager::class);
        $repo = $this->createMock(PriceListRepository::class);
        $priceList = new PriceList();

        $manager->expects($this->once())
            ->method('getRepository')
            ->willReturn($repo);

        $repo->expects($this->once())
            ->method('getDefault')
            ->willReturn($priceList);


        $initializer->init($manager, $collection);

        $this->assertContains($priceList, $collection);
    }
}
