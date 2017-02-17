<?php

/*
 * (c) Antal Áron <antalaron@antalaron.hu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Antalaron\DoctrineTwigBundle\Model;

/**
 * TemplateRepositoryInterface.
 *
 * @author Antal Áron <antalaron@antalaron.hu>
 */
interface TemplateRepositoryInterface
{
    /**
     * Find on by name.
     *
     * @param string $name
     *
     * @return TemplateInterface|null
     */
    public function findOneByName($name);
}
