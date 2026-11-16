<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TestEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {recipient : The recipient email address}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a safe test email using the currently configured Laravel mailer to verify connectivity';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $recipient = $this->argument('recipient');

        if (!filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
            $this->error("Invalid recipient email address: '{$recipient}'.");
            return self::FAILURE;
        }

        $mailer = config('mail.default');
        $fromAddress = config('mail.from.address');
        $fromName = config('mail.from.name');
        $host = config("mail.mailers.{$mailer}.host", 'N/A');
        $port = config("mail.mailers.{$mailer}.port", 'N/A');

        $this->info("Hotel Rose Palace — Email System Operational Verification");
        $this->info("Preparing test email using '{$mailer}' driver...");
        $this->line("  From:      {$fromName} <{$fromAddress}>");
        $this->line("  Recipient: {$recipient}");
        if ($mailer === 'smtp') {
            $this->line("  Server:  {$host}:{$port}");
        }

        try {
            Mail::raw(
                "Hello from Hotel Rose Palace!\n\nThis is a verified test email sent via Laravel Mail to confirm SMTP delivery.\nTimestamp: " . now()->toIso8601String() . "\nMailer: {$mailer}\nServer: {$host}:{$port}\n\nHotel Rose Palace Concierge System",
                function ($message) use ($recipient, $fromAddress, $fromName) {
                    $message->to($recipient)
                        ->from($fromAddress, $fromName)
                        ->subject('Hotel Rose Palace - SMTP Verification Test');
                }
            );

            $this->info("✓ Test email dispatched successfully via '{$mailer}' mailer to {$recipient}.");
            return self::SUCCESS;
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $this->error("✗ Failed to dispatch email via '{$mailer}': {$errorMessage}");

            Log::error('Test email dispatch failed', [
                'recipient' => $recipient,
                'mailer' => $mailer,
                'error' => $errorMessage,
            ]);

            return self::FAILURE;
        }
    }
}
