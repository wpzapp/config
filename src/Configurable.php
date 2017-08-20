<?php
/**
 * Configuration utility for WP-ZAPP modules and libraries.
 *
 * @package WPZAPP\Config
 * @license GPL-3.0
 * @link    https://wpzapp.org
 */

namespace WPZAPP\Config;

/**
 * Interface for a configurable object.
 *
 * @since 1.0.0
 */
interface Configurable
{

    /**
     * Check whether the config has a specific key.
     *
     * @since 1.0.0
     *
     * @param string $key Key, or path to the key if nested.
     * @return bool True if the key exists, false otherwise.
     */
    public function hasConfigKey(string $key): bool;

    /**
     * Get the value for a specific key.
     *
     * @since 1.0.0
     *
     * @param string $key Key, or path to the key if nested.
     * @return mixed Value for the key.
     */
    public function getConfigKey(string $key);

    /**
     * Get the config object.
     *
     * @since 1.0.0
     *
     * @return Config The config object.
     */
    public function config(): Config;
}
