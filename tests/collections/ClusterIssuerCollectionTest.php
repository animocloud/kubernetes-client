<?php

use Maclof\Kubernetes\Collections\ClusterIssuerCollection;

class ClusterIssuerCollectionTest extends TestCase
{
    protected $items = [
        [],
        [],
        [],
        []
    ];

    protected function getClusterIssuerCollection()
    {
        return new ClusterIssuerCollection($this->items);
    }

    public function test_get_items()
    {
        $issuerCollection = $this->getClusterIssuerCollection();
        $items = $issuerCollection->toArray();

        $this->assertTrue(is_array($items));
        $this->assertEquals(4, count($items));
    }
}
