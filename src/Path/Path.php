<?php
/**
 * Configuration utility for WP-ZAPP modules and libraries.
 *
 * @package WPZAPP\Config
 * @license GPL-3.0
 * @link    https://wpzapp.org
 */

namespace WPZAPP\Config\Path;

use WPZAPP\Contracts\Validatable;
use WPZAPP\Config\Exception\PathValidationException;

/**
 * Class representing a path to a key.
 *
 * @since 1.0.0
 */
final class Path implements Validatable
{

    /** @var array The path. */
    private $path = array();

    /**
     * Constructor.
     *
     * @since 1.0.0
     *
     * @param array $path The path.
     */
    public function __construct(array $path)
    {
        $this->path = $path;
    }

    /**
     * Get the path segments.
     *
     * @since 1.0.0
     *
     * @return array Path segments.
     */
    public function getSegments(): array
    {
        return $this->path;
    }

    /**
     * @inheritDoc
     */
    public function validate()
    {
        if (empty($this->path)) {
            throw new PathValidationException('Paths must not be empty.');
        }

        foreach ($this->path as $segment) {
            if (empty($segment)) {
                throw new PathValidationException(sprintf('Empty segment in path %s.', $this->__toString()));
            }

            if (!preg_match('/^[a-z]+[a-zA-Z0-9-_]*[^-_]$/', $segment)) {
                throw new PathValidationException(sprintf( 'Invalid segment %1$s of path %2$s.', $segment, $this->__toString()));
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function isValid(): bool
    {
        try {
            $this->validate();
        } catch (PathValidationException $e) {
            return false;
        }

        return true;
    }

    /**
     * Get a string representation of the path.
     *
     * It is the path segments connected with '->' separators.
     *
     * @since 1.0.0
     *
     * @return string String representation of the path.
     */
    public function __toString(): string
    {
        return implode('->', $this->path);
    }
}
