<?php

/*
 * (c) Antal Áron <antalaron@antalaron.hu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Antalaron\DoctrineTwigBundle\Tests\Twig\Loader;

use Antalaron\DoctrineTwigBundle\Entity\Template;
use Antalaron\DoctrineTwigBundle\Model\TemplateInterface;
use Antalaron\DoctrineTwigBundle\Repository\TemplateRepository;
use Antalaron\DoctrineTwigBundle\Twig\Loader\DoctrineLoader;
use Doctrine\Common\Persistence\ManagerRegistry;

class DoctrineLoaderTest extends \PHPUnit_Framework_TestCase
{
    public function testExists()
    {
        $template = new Template();
        $template->setEnabled(true);
        $name = 'foo_bar';

        $repository = $this->getMockBuilder(TemplateRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findOneBy'])
            ->getMock();
        $repository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['name' => $name])
            ->will($this->returnValue($template));

        $registry = $this->getMockBuilder(ManagerRegistry::class)
            ->disableOriginalConstructor()
            ->getMock();
        $registry
            ->expects($this->once())
            ->method('getRepository')
            ->with(TemplateInterface::class)
            ->will($this->returnValue($repository));
        $loader = new DoctrineLoader($registry);

        $this->assertTrue($loader->exists($name));
    }

    public function testExistsNotEnabled()
    {
        $template = new Template();
        $template->setEnabled(false);
        $name = 'foo_bar';

        $repository = $this->getMockBuilder(TemplateRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findOneBy'])
            ->getMock();
        $repository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['name' => $name])
            ->will($this->returnValue($template));

        $registry = $this->getMockBuilder(ManagerRegistry::class)
            ->disableOriginalConstructor()
            ->getMock();
        $registry
            ->expects($this->once())
            ->method('getRepository')
            ->with(TemplateInterface::class)
            ->will($this->returnValue($repository));
        $loader = new DoctrineLoader($registry);

        $this->assertFalse($loader->exists($name));
    }

    public function testExistsNotExists()
    {
        $name = 'foo_bar';

        $repository = $this->getMockBuilder(TemplateRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findOneBy'])
            ->getMock();
        $repository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['name' => $name])
            ->will($this->returnValue(null));

        $registry = $this->getMockBuilder(ManagerRegistry::class)
            ->disableOriginalConstructor()
            ->getMock();
        $registry
            ->expects($this->once())
            ->method('getRepository')
            ->with(TemplateInterface::class)
            ->will($this->returnValue($repository));
        $loader = new DoctrineLoader($registry);

        $this->assertFalse($loader->exists($name));
    }

    public function testGetSourceContext()
    {
        $template = new Template();
        $template->setEnabled(true);
        $name = 'foo_bar';
        $source = 'foo_bar_baz';
        $template->setSource($source);

        $repository = $this->getMockBuilder(TemplateRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findOneBy'])
            ->getMock();
        $repository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['name' => $name])
            ->will($this->returnValue($template));

        $registry = $this->getMockBuilder(ManagerRegistry::class)
            ->disableOriginalConstructor()
            ->getMock();
        $registry
            ->expects($this->once())
            ->method('getRepository')
            ->with(TemplateInterface::class)
            ->will($this->returnValue($repository));
        $loader = new DoctrineLoader($registry);

        $this->assertEquals($source, $loader->getSourceContext($name)->getCode());
    }

    /**
     * @expectedException \Twig_Error_Loader
     * @expectedExceptionMessage Unable to find template "foo_bar".
     */
    public function testGetSourceContextNotExists()
    {
        $name = 'foo_bar';

        $repository = $this->getMockBuilder(TemplateRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findOneBy'])
            ->getMock();
        $repository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['name' => $name])
            ->will($this->returnValue(null));

        $registry = $this->getMockBuilder(ManagerRegistry::class)
            ->disableOriginalConstructor()
            ->getMock();
        $registry
            ->expects($this->once())
            ->method('getRepository')
            ->with(TemplateInterface::class)
            ->will($this->returnValue($repository));
        $loader = new DoctrineLoader($registry);

        $loader->getSourceContext($name);
    }

    /**
     * @expectedException \Twig_Error_Loader
     * @expectedExceptionMessage Template "foo_bar" is not enabled.
     */
    public function testGetSourceContextNotEnabled()
    {
        $template = new Template();
        $template->setEnabled(false);
        $name = 'foo_bar';
        $source = 'foo_bar_baz';
        $template->setSource($source);

        $repository = $this->getMockBuilder(TemplateRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findOneBy'])
            ->getMock();
        $repository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['name' => $name])
            ->will($this->returnValue($template));

        $registry = $this->getMockBuilder(ManagerRegistry::class)
            ->disableOriginalConstructor()
            ->getMock();
        $registry
            ->expects($this->once())
            ->method('getRepository')
            ->with(TemplateInterface::class)
            ->will($this->returnValue($repository));
        $loader = new DoctrineLoader($registry);

        $loader->getSourceContext($name);
    }

    public function testGetCacheKey()
    {
        $template = new Template();
        $template->setEnabled(true);
        $name = 'foo_bar';

        $repository = $this->getMockBuilder(TemplateRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findOneBy'])
            ->getMock();
        $repository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['name' => $name])
            ->will($this->returnValue($template));

        $registry = $this->getMockBuilder(ManagerRegistry::class)
            ->disableOriginalConstructor()
            ->getMock();
        $registry
            ->expects($this->once())
            ->method('getRepository')
            ->with(TemplateInterface::class)
            ->will($this->returnValue($repository));
        $loader = new DoctrineLoader($registry);

        $this->assertEquals(DoctrineLoader::CACHE_KEY_PREFIX.$name, $loader->getCacheKey($name));
    }

    /**
     * @expectedException \Twig_Error_Loader
     * @expectedExceptionMessage Unable to find template "foo_bar".
     */
    public function testGetCacheKeyNotExists()
    {
        $name = 'foo_bar';

        $repository = $this->getMockBuilder(TemplateRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findOneBy'])
            ->getMock();
        $repository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['name' => $name])
            ->will($this->returnValue(null));

        $registry = $this->getMockBuilder(ManagerRegistry::class)
            ->disableOriginalConstructor()
            ->getMock();
        $registry
            ->expects($this->once())
            ->method('getRepository')
            ->with(TemplateInterface::class)
            ->will($this->returnValue($repository));
        $loader = new DoctrineLoader($registry);

        $loader->getCacheKey($name);
    }

    /**
     * @expectedException \Twig_Error_Loader
     * @expectedExceptionMessage Template "foo_bar" is not enabled.
     */
    public function testGetCacheKeyNotEnabled()
    {
        $template = new Template();
        $template->setEnabled(false);
        $name = 'foo_bar';

        $repository = $this->getMockBuilder(TemplateRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findOneBy'])
            ->getMock();
        $repository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['name' => $name])
            ->will($this->returnValue($template));

        $registry = $this->getMockBuilder(ManagerRegistry::class)
            ->disableOriginalConstructor()
            ->getMock();
        $registry
            ->expects($this->once())
            ->method('getRepository')
            ->with(TemplateInterface::class)
            ->will($this->returnValue($repository));
        $loader = new DoctrineLoader($registry);

        $loader->getCacheKey($name);
    }

    public function testIsFresh()
    {
        $template = new Template();
        $template->setEnabled(true);
        $template->onModify();
        $name = 'foo_bar';

        $repository = $this->getMockBuilder(TemplateRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findOneBy'])
            ->getMock();
        $repository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['name' => $name])
            ->will($this->returnValue($template));

        $registry = $this->getMockBuilder(ManagerRegistry::class)
            ->disableOriginalConstructor()
            ->getMock();
        $registry
            ->expects($this->once())
            ->method('getRepository')
            ->with(TemplateInterface::class)
            ->will($this->returnValue($repository));
        $loader = new DoctrineLoader($registry);

        $this->assertTrue($loader->isFresh($name, time()));
    }

    public function testIsFreshFalse()
    {
        $template = new Template();
        $template->setEnabled(true);
        $template->onModify();
        $name = 'foo_bar';

        $repository = $this->getMockBuilder(TemplateRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findOneBy'])
            ->getMock();
        $repository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['name' => $name])
            ->will($this->returnValue($template));

        $registry = $this->getMockBuilder(ManagerRegistry::class)
            ->disableOriginalConstructor()
            ->getMock();
        $registry
            ->expects($this->once())
            ->method('getRepository')
            ->with(TemplateInterface::class)
            ->will($this->returnValue($repository));
        $loader = new DoctrineLoader($registry);

        $this->assertFalse($loader->isFresh($name, time() - 10));
    }

    /**
     * @expectedException \Twig_Error_Loader
     * @expectedExceptionMessage Unable to find template "foo_bar".
     */
    public function testIsFreshNotExists()
    {
        $name = 'foo_bar';

        $repository = $this->getMockBuilder(TemplateRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findOneBy'])
            ->getMock();
        $repository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['name' => $name])
            ->will($this->returnValue(null));

        $registry = $this->getMockBuilder(ManagerRegistry::class)
            ->disableOriginalConstructor()
            ->getMock();
        $registry
            ->expects($this->once())
            ->method('getRepository')
            ->with(TemplateInterface::class)
            ->will($this->returnValue($repository));
        $loader = new DoctrineLoader($registry);

        $loader->isFresh($name, time());
    }

    /**
     * @expectedException \Twig_Error_Loader
     * @expectedExceptionMessage Template "foo_bar" is not enabled.
     */
    public function testIsFreshNotEnabled()
    {
        $template = new Template();
        $template->setEnabled(false);
        $template->onModify();
        $name = 'foo_bar';

        $repository = $this->getMockBuilder(TemplateRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findOneBy'])
            ->getMock();
        $repository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['name' => $name])
            ->will($this->returnValue($template));

        $registry = $this->getMockBuilder(ManagerRegistry::class)
            ->disableOriginalConstructor()
            ->getMock();
        $registry
            ->expects($this->once())
            ->method('getRepository')
            ->with(TemplateInterface::class)
            ->will($this->returnValue($repository));
        $loader = new DoctrineLoader($registry);

        $loader->isFresh($name, time());
    }
}
