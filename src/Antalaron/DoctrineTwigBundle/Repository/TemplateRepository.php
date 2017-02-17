<?php

/*
 * (c) Antal Áron <antalaron@antalaron.hu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Antalaron\DoctrineTwigBundle\Repository;

use Antalaron\DoctrineTwigBundle\Model\TemplateRepositoryInterface;
use Doctrine\ORM\EntityRepository;

/**
 * TemplateRepository.
 *
 * @author Antal Áron <antalaron@antalaron.hu>
 */
class TemplateRepository extends EntityRepository implements TemplateRepositoryInterface
{
    /**
     * Find on by name.
     *
     * @param string $name
     *
     * @return Template|null
     */
    public function findOneByName($name)
    {
        return $this->findOneBy([
            'name' => $name,
        ]);
    }
}
