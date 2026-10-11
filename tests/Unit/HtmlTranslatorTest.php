<?php

namespace Tests\Unit;

use App\Services\HtmlTranslator;
use PHPUnit\Framework\TestCase;

class HtmlTranslatorTest extends TestCase
{
    protected function translator(): HtmlTranslator
    {
        return new HtmlTranslator([
            'Dashboard'              => 'لوحة التحكم',
            'Save'                   => 'حفظ',
            'Assalamu Alaikum, {1}'  => 'السلام عليكم، {1}',
            '{#1} lessons'           => '{1} دروس',
            'Are you sure?'          => 'هل أنت متأكد؟',
        ], 'ar', 'rtl', 'http://localhost');
    }

    public function test_translates_text_attributes_and_sets_rtl(): void
    {
        $out = $this->translator()->translate(
            '<html lang="en" dir="ltr"><head></head><body><h1> Dashboard </h1>'
            . '<input type="submit" value="Save"><p>Assalamu Alaikum, Ali</p><span>5 lessons</span></body></html>'
        );

        $this->assertStringContainsString('lang="ar" dir="rtl"', $out);
        $this->assertStringContainsString('لوحة التحكم', $out);
        $this->assertStringContainsString('value="حفظ"', $out);
        $this->assertStringContainsString('السلام عليكم، Ali', $out);
        $this->assertStringContainsString('5 دروس', $out);
        $this->assertStringContainsString('language-rtl.css', $out);
        $this->assertStringContainsString('</html>', $out);
        $this->assertStringNotContainsString('</html dir', $out);
    }

    public function test_leaves_textareas_styles_and_unknown_text_alone(): void
    {
        $html = '<head><style>.a{content:"Dashboard"}</style></head><textarea>Dashboard</textarea><p>Unknown text</p>';
        $out  = $this->translator()->translate($html);

        $this->assertStringContainsString('<textarea>Dashboard</textarea>', $out);
        $this->assertStringContainsString('content:"Dashboard"', $out);
        $this->assertStringContainsString('Unknown text', $out);
    }

    public function test_translates_sweetalert_strings_in_scripts(): void
    {
        $out = $this->translator()->translate(
            "<script>Swal.fire({title:'Are you sure?', icon:'warning'}); var x = 'Dashboard';</script>"
        );

        $this->assertStringContainsString("title:'هل أنت متأكد؟'", $out);
        $this->assertStringContainsString("var x = 'Dashboard'", $out); // plain variables untouched
    }
}
