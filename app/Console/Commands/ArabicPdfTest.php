<?php

namespace App\Console\Commands;

use App\Services\ArabicPdf;
use Illuminate\Console\Command;

class ArabicPdfTest extends Command
{
    protected $signature = 'pdf:arabic-test';

    protected $description = 'Write storage/app/arabic-test.pdf to confirm Arabic renders correctly with mPDF';

    public function handle(): int
    {
        $html = <<<'HTML'
<html>
<head>
<meta charset="utf-8">
<style>
    body { font-family: dejavusans; font-size: 14pt; padding: 20px; }
    .ar  { font-family: xbriyaz; direction: rtl; }
    td   { padding: 8px; border: 1px solid #999; }
</style>
</head>
<body>
    <h2>Al-Hilaal Online Academy <span class="ar">أكاديمية الهلال</span></h2>
    <p class="ar" style="text-align:right;">شهادة إنجاز</p>
    <p class="ar" style="text-align:right;">بطاقة تقرير الطالب</p>
    <p class="ar" style="text-align:right;">يشهد بأن الطالب قد أتم جميع الدروس والتقييمات بنجاح</p>
    <table width="100%">
        <tr><td>Average score</td><td class="ar" style="text-align:right;">متوسط الدرجات</td></tr>
        <tr><td>Grade</td><td class="ar" style="text-align:right;">التقدير</td></tr>
        <tr><td>Status</td><td class="ar" style="text-align:right;">الحالة</td></tr>
    </table>
    <p>Mixed line: P1 - <span class="ar">المستوى الابتدائي الأول</span> - 2024-2025</p>
</body>
</html>
HTML;

        $path = ArabicPdf::make(['margin_left' => 10, 'margin_right' => 10, 'margin_top' => 10])
            ->html($html)
            ->save(storage_path('app/arabic-test.pdf'));

        $this->info("Written: {$path}");

        return self::SUCCESS;
    }
}
