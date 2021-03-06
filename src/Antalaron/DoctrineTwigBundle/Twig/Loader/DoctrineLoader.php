<?php

/*
 * (c) Antal Áron <antalaron@antalaron.hu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Antalaron\DoctrineTwigBundle\Twig\Loader;

use Antalaron\DoctrineTwigBundle\Model\TemplateInterface;
use Antalaron\DoctrineTwigBundle\Model\TemplateRepositoryInterface;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * DoctrineLoader.
 *
 * @author Antal Áron <antalaron@antalaron.hu>
 */
class DoctrineLoader implements \Twig_LoaderInterface, \Twig_SourceContextLoaderInterface, \Twig_ExistsLoaderInterface
{
    const CACHE_KEY_PREFIX = 'doctrine_';

    /**
     * @var ManagerRegistry
     */
    protected $managerRegistry;

    /**
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * {@inheritdoc}
     */
    public function getSource($name)
    {
        $template = $this->getRepository()->findOneByName($name);

        if (null === $template) {
            throw new \Twig_Error_Loader(sprintf('Unable to find template "%s".', $name));
        }

        if (!$template->isEnabled()) {
            throw new \Twig_Error_Loader(sprintf('Template "%s" is not enabled.', $name));
        }

        return $template->getSource();
    }

    /**
     * {@inheritdoc}
     */
    public function getSourceContext($name)
    {
        $template = $this->getRepository()->findOneByName($name);

        if (null === $template) {
            throw new \Twig_Error_Loader(sprintf('Unable to find template "%s".', $name));
        }

        if (!$template->isEnabled()) {
            throw new \Twig_Error_Loader(sprintf('Template "%s" is not enabled.', $name));
        }

        return new \Twig_Source($template->getSource(), $name);
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheKey($name)
    {
        $template = $this->getRepository()->findOneByName($name);

        if (null === $template) {
            throw new \Twig_Error_Loader(sprintf('Unable to find template "%s".', $name));
        }

        if (!$template->isEnabled()) {
            throw new \Twig_Error_Loader(sprintf('Template "%s" is not enabled.', $name));
        }

        return static::CACHE_KEY_PREFIX.$name;
    }

    /**
     * {@inheritdoc}
     */
    public function isFresh($name, $time)
    {
        $template = $this->getRepository()->findOneByName($name);

        if (null === $template) {
            throw new \Twig_Error_Loader(sprintf('Unable to find template "%s".', $name));
        }

        if (!$template->isEnabled()) {
            throw new \Twig_Error_Loader(sprintf('Template "%s" is not enabled.', $name));
        }

        return $template->getModifiedAt()->getTimestamp() <= $time;
    }

    /**
     * {@inheritdoc}
     */
    public function exists($name)
    {
        $template = $this->getRepository()->findOneByName($name);

        return null !== $template && $template->isEnabled();
    }

    /**
     * Get repository.
     *
     * @return TemplateRepositoryInterface
     */
    protected function getRepository()
    {
        return $this->managerRegistry->getRepository(TemplateInterface::class);
    }
}
