<?php
namespace Helloworld\Resource\App;

use BEAR\Resource\AbstractObject as Page;

/**
 * Hello resource
 *
 * @return self
 */class Hello extends Page
 {
     /**
      * Get
      *
      * @param string $name
      *
      * @return \Helloworld\Resource\App\Hello
      */
     public function onGet($name)
     {
         $this['greeting'] = 'Hello ' . $name;
         $this['time'] = date('r');

         return $this;
     }
 }
