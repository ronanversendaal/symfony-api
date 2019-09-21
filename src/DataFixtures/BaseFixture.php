<?php


namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Faker\Factory;

abstract class BaseFixture extends Fixture
{
    /** @var ObjectManager */
    private $manager;

    /** @var \Faker\Generator */
    protected $faker;

    private $referenceIndex = [];

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->faker = Factory::create();
        $this->loadData($manager);
    }

    abstract protected function loadData(ObjectManager $manager);

    protected function getRandomReference(string $className) {
        if(!isset($this->referenceIndex[$className])) {
            $this->referenceIndex[$className] = [];

            foreach ($this->referenceRepository->getReferences() as $key => $reference) {
                if(strpos($key, $className.'_') === 0) {
                    $this->referenceIndex[$className][] = $key;
                }
            }
        }

        if(empty($this->referenceIndex[$className])) {
            throw new \Exception(sprintf('Cannot find any references for class %s', $className));
        }

        $randomReferenceKey = $this->faker->randomElement($this->referenceIndex[$className]);

        return $this->getReference($randomReferenceKey);
    }

    protected function createMany(string $className, int $count, callable $factory)
    {
        for ($i = 0; $i < $count; $i++) {
            $entity = new $className();
            $factory($entity, $i);

            $this->manager->persist($entity);

            $this->addReference($className.'_'.$i, $entity);
        }
    }
}