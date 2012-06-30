<?php

namespace Backlog\BacklogBundle\Entity;

class BacklogRowManager
{
    private $providers = array();

    public function __construct(array $providers)
    {
        foreach ($providers as $provider) {
            if (!$provider instanceof RowProviderInterface) {
                throw new \InvalidArgumentException('Provider must implement RowProviderInterface');
            }

            $this->providers[$provider->getName()] = $provider;
        }
    }

    public function getProviders()
    {
        return $this->providers;
    }

    public function getProviderByName($name)
    {
        if (!isset($this->providers[$name])) {
            throw new \InvalidArgumentException(sprintf('No provider named "%s"', $name));
        }

        return $this->providers[$name];
    }

    public function getProvider(BacklogRow $row)
    {
        foreach ($this->providers as $provider) {
            if ($provider->supports($row)) {
                return $provider;
            }
        }

        throw new \InvalidArgumentException('Unsupported row received');
    }
}
