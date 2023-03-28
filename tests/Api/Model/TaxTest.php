<?php declare(strict_types=1);

namespace ShopwareSdk\Tests\Api\Model;

use PHPUnit\Framework\TestCase;
use ShopwareSdk\Model\Tax;
use ShopwareSdk\Tests\ApiHelper;

class TaxTest extends TestCase
{
    public function testGetAll()
    {
        $taxCollection = ApiHelper::createAdminApi()->tax->getAll();

        self::assertCount(3, $taxCollection->entities);

        $taxEntity = $this->getTaxByName('Standard rate', $taxCollection->entities);
        self::assertSame(19.0, $taxEntity->taxRate);
        self::assertSame(1, $taxEntity->position);

        $taxEntity = $this->getTaxByName('Reduced rate', $taxCollection->entities);
        self::assertSame(7.0, $taxEntity->taxRate);
        self::assertSame(2, $taxEntity->position);

        $taxEntity = $this->getTaxByName('Reduced rate 2', $taxCollection->entities);
        self::assertSame(0.0, $taxEntity->taxRate);
        self::assertSame(3, $taxEntity->position);
    }

    /**
     * @param string $name
     * @param \ShopwareSdk\Model\Tax[] $entities
     *
     * @throws \Exception
     * @return \ShopwareSdk\Model\Tax
     */
    private function getTaxByName(string $name, array $entities) : Tax
    {
        foreach ($entities as $tax) {
            if ($tax->name === $name) {
                return $tax;
            }
        }
        throw new \Exception('Tax not found');
    }
}
