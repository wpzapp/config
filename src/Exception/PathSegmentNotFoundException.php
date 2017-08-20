<?php
/**
 * Configuration utility for WP-ZAPP modules and libraries.
 *
 * @package WPZAPP\Config
 * @license GPL-3.0
 * @link    https://wpzapp.org
 */

namespace WPZAPP\Config\Exception;

use WPZAPP\Exceptions\BaseException;

/**
 * Exception thrown when a path segment does not exist on the input array.
 *
 * @since 1.0.0
 */
class PathSegmentNotFoundException extends BaseException
{

}
