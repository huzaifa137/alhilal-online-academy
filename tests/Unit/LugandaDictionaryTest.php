<?php

namespace Tests\Unit;

use App\Services\HtmlTranslator;
use PHPUnit\Framework\TestCase;

class LugandaDictionaryTest extends TestCase
{
    private function load(string $file): array
    {
        $path = dirname(__DIR__, 2) . '/resources/lang/' . $file;
        $data = json_decode(file_get_contents($path), true);
        $this->assertIsArray($data, "$file is not valid JSON");

        return $data;
    }

    public function test_luganda_covers_every_swahili_key(): void
    {
        $missing = array_diff_key($this->load('sw.json'), $this->load('lg.json'));

        $this->assertSame([], array_keys($missing), 'lg.json is missing keys that sw.json has');
    }

    public function test_no_empty_values_and_placeholders_are_consistent(): void
    {
        foreach ($this->load('lg.json') as $key => $value) {
            $this->assertNotSame('', trim($value), "Empty translation for: $key");

            preg_match_all('/\{#?(\d+)\}/', $key, $k);
            preg_match_all('/\{(\d+)\}/', $value, $v);
            $this->assertEmpty(array_diff($v[1], $k[1]), "Value uses a placeholder the key does not have: $key");

            // :language style Laravel replacements must survive translation
            preg_match_all('/:[a-z_]+/i', $key, $kn);
            foreach ($kn[0] as $named) {
                $this->assertStringContainsString($named, $value, "Lost $named in: $key");
            }
        }
    }

    public function test_translator_handles_luganda_patterns(): void
    {
        $t = new HtmlTranslator($this->load('lg.json'), 'lg', 'ltr', 'http://localhost');

        $out = $t->translate('<html lang="en"><body><h1>Dashboard</h1><span>5 lessons</span>'
            . '<p>Assalamu Alaikum, Ali</p></body></html>');

        $this->assertStringContainsString('lang="lg"', $out);
        $this->assertStringContainsString('Ekipande', $out);
        $this->assertStringContainsString('Amasomo 5', $out);
        $this->assertStringContainsString('Assalaamu alaikum, Ali', $out);
    }

    public function test_lang_files_exist_for_luganda(): void
    {
        foreach (['auth', 'pagination', 'passwords', 'validation'] as $file) {
            $path = dirname(__DIR__, 2) . "/resources/lang/lg/$file.php";
            $this->assertFileExists($path);
            $this->assertIsArray(require $path);
        }
    }
}
