<?php

/*
 * This file is part of the Imagine package.
 *
 * (c) Bulat Shakirzyanov <mallluhuct@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace yii\imagine\Imagine\Filter\Basic;

use yii\imagine\Imagine\Image\ImageInterface;
use yii\imagine\Imagine\Image\Color;
use yii\imagine\Imagine\Filter\FilterInterface;

/**
 * A rotate filter
 */
class Rotate implements FilterInterface
{
    /**
     * @var integer
     */
    private $angle;

    /**
     * @var Color
     */
    private $background;

    /**
     * Constructs Rotate filter with given angle and background color
     *
     * @param integer $angle
     * @param Color   $background
     */
    public function __construct($angle, Color $background = null)
    {
        $this->angle      = $angle;
        $this->background = $background;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(ImageInterface $image)
    {
        return $image->rotate($this->angle, $this->background);
    }
}
