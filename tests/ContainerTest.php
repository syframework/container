<?php

use PHPUnit\Framework\TestCase;
use Sy\Container;
use Sy\Container\NotFoundException;

class ContainerTest extends TestCase {

	protected $container;

	protected function setUp(): void {
		$this->container = new Container();
	}

	public function testContainerCanCheckForDefinition() {
		$this->assertFalse($this->container->has('definition'));
		$this->assertFalse(isset($this->container->definition));
		$this->container->definition = function() {
			return 'value';
		};
		$this->assertTrue($this->container->has('definition'));
		$this->assertTrue(isset($this->container->definition));
	}

	public function testContainerCanAddAndGetDefinition() {
		$this->container->definition = function() {
			return 'value';
		};
		$this->assertEquals('value', $this->container->get('definition'));
		$this->assertEquals('value', $this->container->definition);
	}

	public function testContainerThrowsWhenDefinitionIsNotFound() {
		$this->expectException(NotFoundException::class);
		$this->container->get('non-existent-definition');
	}

	public function testContainerThrowsWhenDefinitionIsNotFound2() {
		$this->expectException(NotFoundException::class);
		$this->container->nothing;
	}

}