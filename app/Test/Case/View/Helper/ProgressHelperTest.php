<?php
App::uses('Controller', 'Controller');
App::uses('View', 'View');
App::uses('ProgressHelper', 'View/Helper');

class ProgressHelperTest extends CakeTestCase{
  public function setUp(){
      parent::setUp();
      $Controller = new Controller();
      $View = new View($Controller);
      $this->Progress = new ProgressHelper($View);

  }

  public function testBar(){
      $result = $this->Progress->bar(90);
      $this->assertContains('width:90%', $result);
      $this->assertContains('progress-bar', $result);
      $result = $this->Progress->bar(33.3333333);
      $this->assertContains('width:33%', $result);

  }
}
?>