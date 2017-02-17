<?php

namespace Antalaron\DoctrineTwigBundle\Tests\Model;

use Antalaron\DoctrineTwigBundle\Entity\Template;

class TemplateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Template
     */
    private $template;

    protected function setUp()
    {
        $this->template = new Template();
    }

    public function testGetSetName()
    {
        $name = 'foo';
        $this->template->setName($name);

        $this->assertEquals($name, $this->template->getName());
    }

    public function testGetSetSource()
    {
        $source = 'foo';
        $this->template->setSource($source);

        $this->assertEquals($source, $this->template->getSource());
    }

    public function testOnModify()
    {
        $before = time();
        $this->template->onModify();
        $after = time();
        $lastModifiedTime = $this->template->getModifiedAt()->getTimestamp();

        $this->assertTrue($before <= $lastModifiedTime && $lastModifiedTime <= $after);
    }
}
