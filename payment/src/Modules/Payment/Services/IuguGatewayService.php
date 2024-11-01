<?php

namespace App\Modules\Payment\Services;

use App\Modules\Payment\Interfaces\PaymentGatewayInterface;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\MissingExtensionException;
use Monolog\Handler\SyslogUdpHandler;
use Monolog\Logger;

class IuguGatewayService implements PaymentGatewayInterface
{
    private Logger $log;

    /**
     * @throws MissingExtensionException
     */
    public function __construct()
    {
        $output = "%channel%.%level_name%: %message%";
        $formatter = new LineFormatter($output);

        $this->log = new Logger('payment');
        $syslogHandler = new SyslogUdpHandler(env('PAPERTRAIL_HOST'), env('PAPERTRAIL_PORT'));
        $syslogHandler->setFormatter($formatter);
        $this->log->pushHandler($syslogHandler);
    }

    public function make(string $message): void
    {
        sleep(1);

        echo "PAGO - IUGU" . PHP_EOL;

        $this->log->info($message);
    }
}
