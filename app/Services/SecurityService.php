<?php

namespace App\Services;

use Illuminate\Support\Str;

class SecurityService
{
    /**
     * Sanitize user input to prevent XSS attacks
     *
     * @param string|null $input
     * @return string|null
     */
    public static function sanitizeInput(?string $input): ?string
    {
        if (is_null($input)) {
            return null;
        }

        // Remove any null bytes
        $input = str_replace(chr(0), '', $input);

        // Strip tags based on configuration
        $allowedTags = config('security.sanitization.allowed_tags', '');
        $input = strip_tags($input, $allowedTags);

        // Encode special characters
        $input = htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Trim whitespace
        $input = trim($input);

        return $input;
    }

    /**
     * Validate uploaded file security
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $type
     * @return array
     */
    public static function validateUploadedFile($file, string $type = 'images'): array
    {
        $config = config("security.uploads.{$type}", []);
        $errors = [];

        // Check file size
        if (isset($config['max_size'])) {
            $maxSizeKb = $config['max_size'];
            $fileSizeKb = $file->getSize() / 1024;
            
            if ($fileSizeKb > $maxSizeKb) {
                $errors[] = "File size exceeds maximum allowed size of {$maxSizeKb}KB";
            }
        }

        // Check MIME type
        if (isset($config['allowed_mimes'])) {
            $mimeType = $file->getMimeType();
            
            if (!in_array($mimeType, $config['allowed_mimes'])) {
                $errors[] = "File type {$mimeType} is not allowed";
            }
        }

        // Check file extension
        if (isset($config['allowed_extensions'])) {
            $extension = strtolower($file->getClientOriginalExtension());
            
            if (!in_array($extension, $config['allowed_extensions'])) {
                $errors[] = "File extension .{$extension} is not allowed";
            }
        }

        // Additional security checks
        // Check if file is actually an image
        if ($type === 'images') {
            $imageInfo = @getimagesize($file->getPathname());
            if ($imageInfo === false) {
                $errors[] = "File is not a valid image";
            }
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors,
        ];
    }

    /**
     * Generate secure random reference number
     *
     * @param int $length
     * @return string
     */
    public static function generateReference(int $length = 10): string
    {
        return strtoupper(Str::random($length));
    }

    /**
     * Sanitize filename for storage
     *
     * @param string $filename
     * @return string
     */
    public static function sanitizeFilename(string $filename): string
    {
        // Remove path information
        $filename = basename($filename);

        // Remove special characters
        $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);

        // Remove multiple dots
        $filename = preg_replace('/\.+/', '.', $filename);

        // Ensure filename is not empty
        if (empty($filename) || $filename === '.') {
            $filename = 'file_' . time();
        }

        return $filename;
    }

    /**
     * Check if IP is rate limited
     *
     * @param string $key
     * @param int $maxAttempts
     * @param int $decayMinutes
     * @return bool
     */
    public static function isRateLimited(string $key, int $maxAttempts, int $decayMinutes): bool
    {
        $attempts = cache()->get($key, 0);
        
        if ($attempts >= $maxAttempts) {
            return true;
        }

        cache()->put($key, $attempts + 1, now()->addMinutes($decayMinutes));
        
        return false;
    }

    /**
     * Log security event
     *
     * @param string $event
     * @param array $context
     * @return void
     */
    public static function logSecurityEvent(string $event, array $context = []): void
    {
        \Log::channel('security')->warning($event, array_merge($context, [
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url' => request()->fullUrl(),
            'timestamp' => now()->toDateTimeString(),
        ]));
    }
}
