<?php

namespace IRMessage\Concerns;

trait TranslatableMessage
{
    public function translate(string $index): string
    {
        $driver = $this->config->get('lang');

        return trans("irmessage::messages.{$driver}.{$index}");
    }
}
