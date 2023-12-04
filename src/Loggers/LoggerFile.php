<?php

namespace App\Loggers;

use Monolog\Logger;

class LoggerFile 
{
    // implements LoggerInterface
    // protected \Psr\Log\LoggerInterface $logger;
    
    // public function __construct(\Psr\Log\LoggerInterface $logger)
    // {
    //     $this->logger = $logger;
    // }

    // public function log(string $level, $message, ?array $context = null): void
    // {
    //     $this->logger->log($level, $message, is_array($context) ? $context : []);
    // }

    // public function debug(string $message, ?array $context = null): void
    // {
    //     $this->log('DEBUG', $message, is_array($context) ? $context : []);
    // }

    // public function info(string $message, ?array $context = null): void
    // {
    //     $this->log('INFO', $message, is_array($context) ? $context : []);
    // }

    // public function warning(string $message, ?array $context = null): void
    // {
    //     $this->log('WARNING', $message, is_array($context) ? $context : []);
    // }

    // public function error(string $message, ?array $context = null): void
    // {
    //     $this->log('ERROR', $message, is_array($context) ? $context : []);
    // }

    protected Logger $logger;
    // public $message="ehe";

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
        // $logger->info('Test Message');
    }
    public function log(string $level, string $message, ?array $context = null): void
    {
        $this->logger->log($level, $message, $context);
    }

    public function debug(string $message, ?array $context = null): void
    {
        $this->log('DEBUG', 'fdfdfd', $context);
    }

    // public function info(string $message, ?array $context = null): void
    // {
    //     $this->log('INFO', 'fdfdfd', $context);
    // }

    // public function warning(string $message, ?array $context = null): void
    // {
    //     $this->log('WARNING', $message, $context);
    // }

    // public function error(string $message, ?array $context = null): void
    // {
    //     $this->log('ERROR', $message, $context);
    // }
}