<?php
/**
 * Configuration utility for WP-ZAPP modules and libraries.
 *
 * @package WPZAPP\Config
 * @license GPL-3.0
 * @link    https://wpzapp.org
 */

namespace WPZAPP\Config;

use WPZAPP\Contracts\Validatable;
use IteratorAggregate;
use ArrayAccess;
use Serializable;
use Countable;
use WPZAPP\Config\Exception\ConfigKeyNotFoundException;
use WPZAPP\Config\Exception\PathValidationException;

/**
 * Interface for a configuration object.
 *
 * @since 1.0.0
 */
interface Config extends Validatable, IteratorAggregate, ArrayAccess, Serializable, Countable
{

    /**
     * Check whether the config has a specific key.
     *
     * @since 1.0.0
     *
     * @param string $path,... Key, or path segments if key is nested.
     *
     * @return bool True if the key exists, false otherwise.
     *
     * @throws PathValidationException
     */
    public function hasKey(...$path): bool;

    /**
     * Get the value for a specific key.
     *
     * @since 1.0.0
     *
     * @param string $path,... Key, or path segments if key is nested.
     *
     * @return mixed Value for the key.
     *
     * @throws ConfigKeyNotFoundException
     * @throws PathValidationException
     */
    public function getKey(...$path);

    /**
     * Get all keys and values.
     *
     * @since 1.0.0
     *
     * @return array Array (possibly multi-dimensional) with the config data.
     */
    public function getAll(): array;

    /**
     * Get a new config from a specific key.
     *
     * @since 1.0.0
     *
     * @param string $path,... Key, or path segments if key is nested.
     *
     * @return Config The new config.
     *
     * @throws ConfigKeyNotFoundException
     * @throws PathValidationException
     */
    public function getSubConfig(...$path): Config;

    /**
     * Get the configuration schema object.
     *
     * @since 1.0.0
     *
     * @return ConfigSchema The configuration schema object.
     */
    public function getSchema(): ConfigSchema;
}
