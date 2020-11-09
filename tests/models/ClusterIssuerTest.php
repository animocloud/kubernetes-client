<?php

use Maclof\Kubernetes\Models\ClusterIssuer;

class ClusterIssuerTest extends TestCase
{
    public function test_get_schema()
    {
        $issuer = new ClusterIssuer;

        $schema = trim($issuer->getSchema());
        $fixture = trim($this->getFixture('clusterissuers/empty.json'));

        $this->assertEquals($fixture, $schema);
    }

    public function test_get_metadata()
    {
        $issuer = new ClusterIssuer([
            'metadata' => [
                'name' => 'test2',
            ],
        ]);

        $metadata = $issuer->getMetadata('name');

        $this->assertEquals($metadata, 'test2');
    }
}
