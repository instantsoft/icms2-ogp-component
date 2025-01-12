<?php

declare(strict_types=1);

namespace Intervention\Image\Typography;

use Intervention\Image\Interfaces\FontInterface;

class Font implements FontInterface
{
    protected float $size = 12;
    protected float $angle = 0;
    protected mixed $color = '000000';
    protected ?string $filename = null;
    protected string $alignment = 'left';
    protected string $valignment = 'bottom';
    protected float $lineHeight = 1.25;

    public function __construct(?string $filename = null)
    {
        $this->filename = $filename;
    }

    /**
     * {@inheritdoc}
     *
     * @see FontInterface::setSize()
     */
    public function setSize(float $size): FontInterface
    {
        $this->size = $size;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see FontInterface::size()
     */
    public function size(): float
    {
        return $this->size;
    }

    /**
     * {@inheritdoc}
     *
     * @see FontInterface::setAngle()
     */
    public function setAngle(float $angle): FontInterface
    {
        $this->angle = $angle;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see FontInterface::angle()
     */
    public function angle(): float
    {
        return $this->angle;
    }

    /**
     * {@inheritdoc}
     *
     * @see FontInterface::setFilename()
     */
    public function setFilename(string $filename): FontInterface
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see FontInterface::filename()
     */
    public function filename(): ?string
    {
        return $this->filename;
    }

    /**
     * {@inheritdoc}
     *
     * @see FontInterface::hasFilename()
     */
    public function hasFilename(): bool
    {
        return !is_null($this->filename) && is_file($this->filename);
    }

    /**
     * {@inheritdoc}
     *
     * @see FontInterface::setColor()
     */
    public function setColor(mixed $color): FontInterface
    {
        $this->color = $color;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see FontInterface::color()
     */
    public function color(): mixed
    {
        return $this->color;
    }

    /**
     * {@inheritdoc}
     *
     * @see FontInterface::alignment()
     */
    public function alignment(): string
    {
        return $this->alignment;
    }

    /**
     * {@inheritdoc}
     *
     * @see FontInterface::setAlignment()
     */
    public function setAlignment(string $value): FontInterface
    {
        $this->alignment = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see FontInterface::valignment()
     */
    public function valignment(): string
    {
        return $this->valignment;
    }

    /**
     * {@inheritdoc}
     *
     * @see FontInterface::setValignment()
     */
    public function setValignment(string $value): FontInterface
    {
        $this->valignment = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see FontInterface::setLineHeight()
     */
    public function setLineHeight(float $height): FontInterface
    {
        $this->lineHeight = $height;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see FontInterface::lineHeight()
     */
    public function lineHeight(): float
    {
        return $this->lineHeight;
    }
}
