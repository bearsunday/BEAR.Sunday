<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Database;

use Ray\Di\AbstractModule;
use BEAR\Sunday\Interceptor\TimeStamper;
use BEAR\Sunday\Interceptor\Transactional;


/**
 * DBAL module
 *
 * @package    BEAR.Sunday
 * @subpackage Module
 */
class DoctrineDbalModule extends AbstractModule
{
    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        // @Db
        $this->installDbInjector();
        // @Transactional
        $this->installTransaction();
        // @Time
        $this->installTimeStamper();
    }

    /**
     * @Transactional - db transaction
     */
    private function installDbInjector()
    {
        $dbInjector = $this->requestInjection('\BEAR\Sunday\Interceptor\DbInjector');
        $this->bindInterceptor(
            $this->matcher->annotatedWith('BEAR\Sunday\Annotation\Db'),
            $this->matcher->startWith('on'),
            [$dbInjector]
        );
    }

    /**
     * @Transactional - db transaction
     */
    private function installTransaction()
    {
        $this->bindInterceptor(
            $this->matcher->any(),
            $this->matcher->annotatedWith('BEAR\Sunday\Annotation\Transactional'),
            [new Transactional]
        );
    }

    /**
     * @Time - put time to 'time' property
     */
    private function installTimeStamper()
    {
        $this->bindInterceptor(
            $this->matcher->any(),
            $this->matcher->annotatedWith('BEAR\Sunday\Annotation\Time'),
            [new TimeStamper]
        );
    }
}
