<?php

namespace CategoriesBundle\Test\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractFunctionalTestCase extends WebTestCase
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @SetUp
     */
    protected function setUp()
    {
        $this->client = static::createClient([
            'environment' => 'test',
            'debug'       => true,
        ]);
    }

    /**
     * @TearDown
     */
    protected function tearDown()
    {
        $this->client = null;
    }

    /**
     * @return object
     */
    protected function getJsonObject(string $content): object
    {
        return json_decode($content);
    }
}
