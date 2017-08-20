<?php
/**
 * Configuration utility for WP-ZAPP modules and libraries.
 *
 * @package WPZAPP\Config
 * @license GPL-3.0
 * @link    https://wpzapp.org
 */

namespace WPZAPP\Config;

use ArrayObject;
use WPZAPP\Config\Path\Path;
use WPZAPP\Config\Path\PathWalker;
use WPZAPP\Config\Exception\ConfigValidationException;
use WPZAPP\Config\Exception\ConfigKeyNotFoundException;
use WPZAPP\Config\Exception\PathSegmentNotFoundException;

/**
 * Base config class.
 *
 * @since 1.0.0
 */
abstract class AbstractConfig extends ArrayObject implements Config
{

    /** @var ConfigSchema Configuration schema object. */
    protected $schema;

    /** @var bool|null Validation result, or null if validation has not run yet. */
    protected $validationResult;

    /**
     * Constructor.
     *
     * @since 1.0.0
     *
     * @param array $config Configuration data array.
     */
    public function __construct(array $config)
    {
        parent::__construct($config, ArrayObject::ARRAY_AS_PROPS);

        $this->setSchema();
    }

    /**
     * @inheritDoc
     */
    public function hasKey(...$path): bool
    {
        $path = new Path($path);
        $path->validate();

        return PathWalker::canWalk($this->getArrayCopy(), $path);
    }

    /**
     * @inheritDoc
     */
    public function getKey(...$path)
    {
        $path = new Path($path);
        $path->validate();

        try {
            $result = PathWalker::walk($this->getArrayCopy(), $path);
        } catch(PathSegmentNotFoundException $e) {
            throw new ConfigKeyNotFoundException('Config key not found: '.$e->getMessage());
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        return $this->getArrayCopy();
    }

    /**
     * @inheritDoc
     */
    public function getSubConfig(...$path): Config
    {
        $subConfig = clone $this;
        $subConfig->exchangeArray(call_user_func_array(array($subConfig, 'getKey'), $path));

        // TODO: Handle the config schema.
        return $subConfig;
    }

    /**
     * Validate the config.
     *
     * @since 1.0.0
     *
     * @throws ConfigValidation
     */
    public function validate()
    {
        try {
            // TODO: Validate.

            $this->validationResult = true;
        } catch(ConfigValidationException $e) {
            $this->validationResult = false;

            throw $e;
        }
    }

    /**
     * Check whether the config is valid.
     *
     * @since 1.0.0
     *
     * @return bool Whether the config is valid.
     */
    public function isValid(): bool
    {
        if (is_bool($this->validationResult)) {
            return $this->validationResult;
        }

        try {
            $this->validate();
        } catch(ConfigValidationException $e) {
            // Empty catch block.
        }

        return $this->validationResult;
    }

    /**
     * @inheritDoc
     */
    public function getSchema(): ConfigSchema
    {
        return $this->schema;
    }

    /**
     * Set the configuration schema object.
     *
     * @since 1.0.0
     */
    abstract protected function setSchema();
}
