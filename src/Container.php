<?php
namespace Sy;

use Sy\Container\NotFoundException;

class Container implements \Psr\Container\ContainerInterface {

	private static $instance;

	private $functions;
	private $values;

	public function __construct() {
		$this->functions = array();
		$this->values = array();
	}

	/**
	 * Finds an entry of the container by its identifier and returns it.
	 *
	 * @param string $id Identifier of the entry to look for.
	 *
	 * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
	 * @throws ContainerExceptionInterface Error while retrieving the entry.
	 *
	 * @return mixed Entry.
	 */
	public function get($id) {
		if (!isset($this->functions[$id])) {
			throw new NotFoundException(sprintf('Identifier "%s" is not defined.', $id));
		}
		if (!isset($this->values[$id])) {
			$this->values[$id] = $this->functions[$id]();
		}
		return $this->values[$id];
	}

	/**
	 * Returns true if the container can return an entry for the given identifier.
	 * Returns false otherwise.
	 *
	 * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
	 * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
	 *
	 * @param string $id Identifier of the entry to look for.
	 *
	 * @return bool
	 */
	public function has($id) {
		return isset($this->functions[$id]);
	}

	/**
	 * Shortcut of has method.
	 *
	 * @param string $id Identifier of the entry to look for.
	 * @return bool
	 */
	public function __isset($id) {
		return $this->has($id);
	}

	/**
	 * Shortcut of get method.
	 *
	 * @param string $id Identifier of the entry to look for.
	 * @return mixed Entry.
	 */
	public function __get($id) {
		return $this->get($id);
	}

	/**
	 * Sets an object.
	 * Objects must be defined as Closures.
	 *
	 * @param string  $id    The unique identifier for the object
	 * @param Closure $value The closure to defined an object
	 */
	public function __set($id, $value) {
		$this->functions[$id] = $value;
	}

	/**
	 * Unsets an object.
	 *
	 * @param string $id The unique identifier for the object
	 */
	public function __unset($id) {
		unset($this->values[$id]);
	}

	/**
	 * @return Container
	 */
	public static function getInstance() {
		$c = get_called_class();
		if (!isset(self::$instance[$c])) {
			self::$instance[$c] = new $c;
		}
		return self::$instance[$c];
	}

	private function __clone() {}

}

namespace Sy\Container;

class NotFoundException extends \Exception implements \Psr\Container\NotFoundExceptionInterface {}