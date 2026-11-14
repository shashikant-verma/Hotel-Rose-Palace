<?php

namespace Tests\Unit;

use App\Services\SecurityService;
use Tests\TestCase;

class SecurityServiceTest extends TestCase
{
    /**
     * Test input sanitization removes XSS attempts
     */
    public function test_sanitize_input_removes_xss(): void
    {
        $malicious = '<script>alert("XSS")</script>Hello';
        $sanitized = SecurityService::sanitizeInput($malicious);

        $this->assertStringNotContainsString('<script>', $sanitized);
        $this->assertStringNotContainsString('</script>', $sanitized);
    }

    /**
     * Test sanitize input handles null bytes
     */
    public function test_sanitize_input_removes_null_bytes(): void
    {
        $input = "Hello\x00World";
        $sanitized = SecurityService::sanitizeInput($input);

        $this->assertStringNotContainsString(chr(0), $sanitized);
    }

    /**
     * Test sanitize input encodes special characters
     */
    public function test_sanitize_input_encodes_special_characters(): void
    {
        $input = '<p>Hello & "World"</p>';
        $sanitized = SecurityService::sanitizeInput($input);

        $this->assertStringContainsString('&amp;', $sanitized);
        $this->assertStringContainsString('&quot;', $sanitized);
    }

    /**
     * Test sanitize input trims whitespace
     */
    public function test_sanitize_input_trims_whitespace(): void
    {
        $input = '   Hello World   ';
        $sanitized = SecurityService::sanitizeInput($input);

        $this->assertEquals('Hello World', $sanitized);
    }

    /**
     * Test sanitize input handles null
     */
    public function test_sanitize_input_handles_null(): void
    {
        $sanitized = SecurityService::sanitizeInput(null);

        $this->assertNull($sanitized);
    }

    /**
     * Test generate reference creates unique reference
     */
    public function test_generate_reference_creates_unique(): void
    {
        $ref1 = SecurityService::generateReference();
        $ref2 = SecurityService::generateReference();

        $this->assertNotEquals($ref1, $ref2);
        $this->assertEquals(10, strlen($ref1));
        $this->assertEquals(10, strlen($ref2));
    }

    /**
     * Test generate reference is uppercase
     */
    public function test_generate_reference_is_uppercase(): void
    {
        $reference = SecurityService::generateReference();

        $this->assertEquals($reference, strtoupper($reference));
    }

    /**
     * Test sanitize filename removes special characters
     */
    public function test_sanitize_filename_removes_special_chars(): void
    {
        $filename = 'test<>|*?.jpg';
        $sanitized = SecurityService::sanitizeFilename($filename);

        $this->assertStringNotContainsString('<', $sanitized);
        $this->assertStringNotContainsString('>', $sanitized);
        $this->assertStringNotContainsString('|', $sanitized);
        $this->assertStringNotContainsString('*', $sanitized);
    }

    /**
     * Test sanitize filename removes path traversal attempts
     */
    public function test_sanitize_filename_prevents_path_traversal(): void
    {
        $filename = '../../../etc/passwd.jpg';
        $sanitized = SecurityService::sanitizeFilename($filename);

        $this->assertStringNotContainsString('..', $sanitized);
        $this->assertStringNotContainsString('/', $sanitized);
    }

    /**
     * Test sanitize filename handles empty input
     */
    public function test_sanitize_filename_handles_empty(): void
    {
        $filename = SecurityService::sanitizeFilename('');

        $this->assertNotEmpty($filename);
        $this->assertStringContainsString('file_', $filename);
    }

    /**
     * Test rate limiting tracks attempts
     */
    public function test_is_rate_limited_tracks_attempts(): void
    {
        $key = 'test_ip_' . now()->timestamp;
        $maxAttempts = 3;

        $limited = false;
        for ($i = 0; $i < 4; $i++) {
            $limited = SecurityService::isRateLimited($key, $maxAttempts, 1);
        }

        // 4th attempt should be limited
        $this->assertTrue($limited);
    }

    /**
     * Test log security event
     */
    public function test_log_security_event(): void
    {
        // This test verifies the method doesn't throw an exception
        SecurityService::logSecurityEvent('test_event', [
            'test' => 'data',
        ]);

        $this->assertTrue(true);
    }
}
