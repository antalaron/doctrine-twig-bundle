<?php

/*
 * (c) Antal Áron <antalaron@antalaron.hu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Antalaron\DoctrineTwigBundle\Model;

/**
 * TemplateInterface.
 *
 * @author Antal Áron <antalaron@antalaron.hu>
 */
interface TemplateInterface
{
    /**
     * Get id.
     *
     * @return int
     */
    public function getId();

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return TemplateInterface
     */
    public function setName($name);

    /**
     * Get name.
     *
     * @return string
     */
    public function getName();

    /**
     * Set source.
     *
     * @param string $source
     *
     * @return TemplateInterface
     */
    public function setSource($source);

    /**
     * Get source.
     *
     * @return string
     */
    public function getSource();

    /**
     * Set modifiedAt.
     *
     * @param \DateTime $modifiedAt
     *
     * @return TemplateInterface
     */
    public function setModifiedAt(\DateTime $modifiedAt);

    /**
     * Get modifiedAt.
     *
     * @return \DateTime
     */
    public function getModifiedAt();

    /**
     * Set enabled.
     *
     * @param bool $enabled
     *
     * @return TemplateInterface
     */
    public function isEnabled($enabled);

    /**
     * Get enabled.
     *
     * @return bool
     */
    public function getEnabled();
}
