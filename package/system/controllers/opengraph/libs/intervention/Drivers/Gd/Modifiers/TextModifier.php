<?php

declare(strict_types=1);

namespace Intervention\Image\Drivers\Gd\Modifiers;

use Intervention\Image\Drivers\AbstractTextModifier;
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Geometry\Point;
use Intervention\Image\Geometry\Polygon;
use Intervention\Image\Geometry\Rectangle;
use Intervention\Image\Interfaces\FontInterface;

/**
 * @property Point $position
 * @property string $text
 * @property FontInterface $font
 */
class TextModifier extends AbstractTextModifier
{
    public function apply(ImageInterface $image): ImageInterface
    {
        $lines = $this->alignedTextBlock($this->position, $this->text);

        $color = $this->driver()->colorProcessor($image->colorspace())->colorToNative(
            $this->driver()->handleInput($this->font->color())
        );

        foreach ($image as $frame) {
            if ($this->font->hasFilename()) {
                foreach ($lines as $line) {
                    imagealphablending($frame->native(), true);
                    imagettftext(
                        $frame->native(),
                        $this->adjustedFontSize(),
                        $this->font->angle() * -1,
                        $line->position()->x(),
                        $line->position()->y(),
                        $color,
                        $this->font->filename(),
                        (string) $line
                    );
                }
            } else {
                foreach ($lines as $line) {
                    imagestring(
                        $frame->native(),
                        $this->getGdFont(),
                        $line->position()->x(),
                        $line->position()->y(),
                        (string) $line,
                        $color
                    );
                }
            }
        }

        return $image;
    }

    /**
     * {@inheritdoc}
     *
     * @see AbstractTextModifier::boxSize()
     */
    protected function boxSize(string $text): Polygon
    {
        if (!$this->font->hasFilename()) {
            // calculate box size from gd font
            $box = new Rectangle(0, 0);
            $chars = mb_strlen($text);
            if ($chars > 0) {
                $box->setWidth($chars * $this->getGdFontWidth());
                $box->setHeight($this->getGdFontHeight());
            }
            return $box;
        }

        // calculate box size from font file with angle 0
        $box = imageftbbox(
            $this->adjustedFontSize(),
            0,
            $this->font->filename(),
            $text
        );

        // build polygon from points
        $polygon = new Polygon();
        $polygon->addPoint(new Point($box[6], $box[7]));
        $polygon->addPoint(new Point($box[4], $box[5]));
        $polygon->addPoint(new Point($box[2], $box[3]));
        $polygon->addPoint(new Point($box[0], $box[1]));

        return $polygon;
    }

    /**
     * Calculate font size for `imagettftext` from given font size
     *
     * @return float
     */
    private function adjustedFontSize(): float
    {
        return floatval(ceil($this->font->size() * .75));
    }

    /**
     * Return GD's internal font size (if no ttf file is set)
     *
     * @return int
     */
    private function getGdFont(): int
    {
        if (is_numeric($this->font->filename())) {
            return intval($this->font->filename());
        }

        return 1;
    }

    /**
     * Font width to calculate box size, only applicable when no ttf file is set
     *
     * @return int
     */
    private function getGdFontWidth(): int
    {
        return $this->getGdFont() + 4;
    }

    /**
     * Font height to calculate box size, only applicable when no ttf file is set
     *
     * @return int
     */
    private function getGdFontHeight(): int
    {
        switch ($this->getGdFont()) {
            case 2:
                return 14;

            case 3:
                return 14;

            case 4:
                return 16;

            case 5:
                return 16;

            default:
            case 1:
                return 8;
        }
    }
}
