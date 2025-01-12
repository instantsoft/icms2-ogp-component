<?php

namespace SimonHamp\TheOg\Layout\Layouts;

use SimonHamp\TheOg\BorderPosition;
use SimonHamp\TheOg\Layout\AbstractLayout;
use SimonHamp\TheOg\Layout\PictureBox;
use SimonHamp\TheOg\Layout\Position;
use SimonHamp\TheOg\Layout\TextBox;

class icms extends AbstractLayout {

    protected BorderPosition $borderPosition = BorderPosition::All;
    protected int $borderWidth               = 25;
    protected int $height                    = 630;
    protected int $padding                   = 30;
    protected int $width                     = 1200;

    public function features(): void {

        $callToAction = $this->callToAction();

        $description = $this->description();

        $url = $this->url();

        $watermark = $this->watermark();

        $title_box = (new TextBox())
            ->name('title')
            ->text($this->title())
            ->color($this->config->theme->getTitleColor())
            ->font($this->config->theme->getTitleFont())
            ->size(60)
            ->box($this->mountArea()->box->width(), 400);

        if (!$description) {

            $title_box->position(
                x: 0,
                y: 0,
                relativeTo: fn() => $this->mountArea()->anchor(Position::Center),
                anchor: Position::Center
            );

        } else {

            $title_y = 0;

            if (isset($this->config->url_position) && $this->config->url_position->value === 'top-left') {
                $title_y = 60;
            }

            $title_box->position(
                x: 0,
                y: $title_y,
                relativeTo: function () {
                    return $this->mountArea()->anchor();
                }
            );

        }

        $this->addFeature($title_box);

        if ($description) {

            $this->addFeature((new TextBox())
                ->name('description')
                ->text($description)
                ->color($this->config->theme->getDescriptionColor())
                ->font($this->config->theme->getDescriptionFont())
                ->size(40)
                ->box($this->mountArea()->box->width(), 240)
                ->position(
                    x: 0,
                    y: 60,
                    relativeTo: fn() => $this->getFeature('title')->anchor(Position::BottomLeft)
                )
            );
        }

        if ($callToAction) {
            $this->addFeature((new TextBox())
                ->text($callToAction)
                ->color($this->config->theme->getCallToActionColor())
                ->font($this->config->theme->getCallToActionFont())
                ->size(28)
                ->box($this->mountArea()->box->width(), 240)
                ->position(
                    x: 0,
                    y: 0,
                    relativeTo: fn() => $this->mountArea()->anchor($this->config->call_toaction_position),
                    anchor: $this->config->call_toaction_position
                )
            );
        }

        if ($url) {
            $this->addFeature((new TextBox())
                ->name('url')
                ->text($url)
                ->color($this->config->theme->getUrlColor())
                ->font($this->config->theme->getUrlFont())
                ->size(28)
                ->box($this->mountArea()->box->width(), 100)
                ->position(
                        x: 0,
                        y: 0,
                        relativeTo: fn() => $this->mountArea()->anchor($this->config->url_position),
                        anchor: $this->config->url_position
                )
            );
        }

        if ($watermark) {
            $this->addFeature((new PictureBox())
                ->path($watermark->path())
                ->box($this->mountArea()->box->width(), 100)
                ->position(
                        x: 0,
                        y: 0,
                        relativeTo: fn() => $this->mountArea()->anchor($this->config->watermark_position),
                        anchor: $this->config->watermark_position
                )
            );
        }

    }

    public function url(): string {
        if ($url = parent::url()) {
            return strtoupper($url);
        }
        return '';
    }

}
