<?php

namespace IRMessage\Drivers;

use IRMessage\Contracts\Driver;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use IRMessage\Concerns\TranslatableMessage;

class IPPanelDriver implements Driver
{
    use TranslatableMessage;

    const url = 'https://edge.ippanel.com/v1/api/send';

    protected Collection $config;

    public function __construct(Collection|array $config)
    {
        $this->config = (is_array($config)) ? collect($config) : $config;
    }

    public function send(array|string $recipients, string $message, array $args = [], ?string $from = null)
    {
        $pattern = $this->translate($message);
        $from = $from ?? $this->config->get('from');
        $token = $this->config->get('token');

        $response = Http::acceptJson()
            ->withHeader('Authorization', $token)
            ->post(self::url, [
                "sending_type" => "pattern",
                "from_number" => $from,
                "code" => $pattern,
                "recipients" => $recipients,
                "params" => $args
            ]);

        return $response->json();
    }
}
