<?php declare(strict_types=1);
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\GroupedProduct\Test\Unit\Model\Product\Cart\Configuration\Plugin;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\CartConfiguration;
use Magento\GroupedProduct\Model\Product\Cart\Configuration\Plugin\Grouped;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GroupedTest extends TestCase
{
    /**
     * @var Grouped
     */
    protected $groupedPlugin;

    /**
     * @var MockObject
     */
    protected $productMock;

    /**
     * @var MockObject
     */
    protected $subjectMock;

    /**
     * @var \Closure
     */
    protected $closureMock;

    protected function setUp(): void
    {
        $this->productMock = $this->createMock(Product::class);
        $this->subjectMock = $this->createMock(CartConfiguration::class);
        $this->closureMock = function () {
            return 'Expected';
        };
        $this->groupedPlugin = new Grouped();
    }

    public function testAroundIsProductConfiguredWhenProductGrouped()
    {
        $config = ['super_group' => 'product'];
        $this->productMock->expects(
            $this->once()
        )->method(
            'getTypeId'
        )->will(
            $this->returnValue(\Magento\GroupedProduct\Model\Product\Type\Grouped::TYPE_CODE)
        );
        $this->assertEquals(
            true,
            $this->groupedPlugin->aroundIsProductConfigured(
                $this->subjectMock,
                $this->closureMock,
                $this->productMock,
                $config
            )
        );
    }

    public function testAroundIsProductConfiguredWhenProductIsNotGrouped()
    {
        $config = ['super_group' => 'product'];
        $this->productMock->expects($this->once())->method('getTypeId')->will($this->returnValue('product'));
        $this->assertEquals(
            'Expected',
            $this->groupedPlugin->aroundIsProductConfigured(
                $this->subjectMock,
                $this->closureMock,
                $this->productMock,
                $config
            )
        );
    }
}
