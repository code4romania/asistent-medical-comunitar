<?php

declare(strict_types=1);

use App\Services\Sanitize;

it('sanitizes urls', function () {
    $this->assertSame('http://www.example.com', Sanitize::url('www.example.com'));
    $this->assertSame('https://example.com', Sanitize::url('https://example.com'));
    $this->assertSame('https://example.com/path/to/resource', Sanitize::url('https://example.com/path/to/resource'));
    $this->assertSame('https://example.com/path/to/resource', Sanitize::url('  https://example.com/path/to/resource  '));
    $this->assertSame('https://example.com/path/to/resourcealert("xss")', Sanitize::url('https://example.com/path/to/resource<script>alert("xss")</script>'));
    $this->assertSame('https://example.com/path/to/resource?param=alert("xss")', Sanitize::url('https://example.com/path/to/resource?param=<script>alert("xss")</script>'));
});
