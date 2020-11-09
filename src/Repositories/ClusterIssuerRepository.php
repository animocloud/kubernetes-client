<?php namespace Maclof\Kubernetes\Repositories;

use Maclof\Kubernetes\Collections\ClusterIssuerCollection;
use Maclof\Kubernetes\Repositories\Strategy\PatchMergeTrait;

class ClusterIssuerRepository extends Repository
{
    use PatchMergeTrait;

    protected $uri = 'clusterissuers';

    protected $namespace = false;

    protected function createCollection($response)
    {
        return new ClusterIssuerCollection($response['items']);
    }

}
