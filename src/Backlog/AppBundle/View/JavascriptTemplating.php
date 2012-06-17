<?php

namespace Backlog\AppBundle\View;

use Symfony\Bundle\FrameworkBundle\CacheWarmer\TemplateFinderInterface;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\Templating\TemplateReference;

class JavascriptTemplating
{
    protected $finder;
    protected $locator;

    public function __construct(TemplateFinderInterface $finder, FileLocatorInterface $locator)
    {
        $this->finder = $finder;
        $this->locator = $locator;
    }

    public function getTemplates()
    {
        $getName = function ($tpl) {
            return $tpl->getLogicalName();
        };

        return array_values(array_filter(
            array_map(
                $getName,
                $this->finder->findAllTemplates()
            ),
            function ($name) {
                return 0 === strpos($name, 'BacklogAppBundle');
            }
        ));
    }

    public function getTemplateSource($name)
    {
        foreach ($this->finder->findAllTemplates() as $tpl) {
            if (0 !== strpos($name, 'BacklogAppBundle')) {
                continue;
            }
            if ($tpl->getLogicalName() == $name) {
                $file = $this->locator->locate($tpl);

                return file_get_contents($file);
            }
        }

        throw new \InvalidArgumentException(sprintf('Template "%s" not found', $name));
    }
}
