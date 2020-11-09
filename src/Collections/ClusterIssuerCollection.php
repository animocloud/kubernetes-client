<?php namespace Maclof\Kubernetes\Collections;

use Maclof\Kubernetes\Models\ClusterIssuer;

class ClusterIssuerCollection extends Collection
{
    /**
     * The constructor.
     *
     * @param array $items
     */
    public function __construct(array $items)
    {
        parent::__construct($this->getClusterIssuers($items));
    }

    /**
     * Get an array of certificate cluster issuers.
     *
     * @param  array $items
     * @return array
     */
    protected function getClusterIssuers(array $items)
    {
        foreach ($items as &$item) {
            if ($item instanceof ClusterIssuer) {
                continue;
            }

            $item = new ClusterIssuer($item);
        }

        return $items;
    }
}
