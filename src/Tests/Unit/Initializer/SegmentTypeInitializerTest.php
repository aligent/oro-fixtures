<?php
namespace Aligent\FixturesBundle\Tests\Unit\Initializer;

use Aligent\FixturesBundle\Initializer\SegmentTypeInitializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectManager;
use Oro\Bundle\SegmentBundle\Entity\SegmentType;
use PHPUnit\Framework\TestCase;

class SegmentTypeInitializerTest extends TestCase
{
    public function testInit(): void
    {
        $initializer = new SegmentTypeInitializer();
        $collection = new ArrayCollection();

        $manager = $this->createMock(ObjectManager::class);
        $repo = $this->createMock(EntityRepository::class);

        $entities = [
            'default_segment_type' => (new SegmentType('default')),
            'secondary_segment_type' => (new SegmentType('secondary')),
        ];

        $manager->expects($this->once())
            ->method('getRepository')
            ->willReturn($repo);

        $repo->expects($this->once())
            ->method('findAll')
            ->willReturn(array_values($entities));


        $initializer->init($manager, $collection);

        $this->assertEquals(
            $entities,
            $collection->toArray()
        );
    }
}
