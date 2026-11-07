<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Certificate - {{ $certificateNo }}</title>
    <style>
        /* mPDF layout: the frame, sidebar, corners and watermark are ONE static
           background image (public/assets/images/certificate-frame.png) that
           ArabicPdf paints behind the page; everything below just flows inside the
           page margins set by the controller (see CertificatePdf options). */
        body { margin: 0; padding: 0; font-family: freesans, dejavusans, sans-serif; }

        .ar {
            direction: rtl;
            text-align: right;
            font-family: amiri, xbriyaz, dejavusans;
        }

        .ar-center {
            direction: rtl;
            text-align: center;
            font-family: amiri, xbriyaz, dejavusans;
        }

        .content { width: 100%; }

        /* HEADER */
        .header { width: 100%; padding-bottom: 2mm; margin-bottom: 2mm; border-bottom: 1px solid #DDD; }
        .header td { vertical-align: top; }
        .school { font-size: 15pt; font-weight: bold; color: #16103A; }
        .school-sub { font-family: freesans; font-size: 6.5pt; letter-spacing: 2.5px; color: #777; margin-top: 1mm; }

        .cert-block { text-align: right; }
        .cert-label { font-family: freesans; font-size: 6.5pt; letter-spacing: 1px; color: #777; text-transform: uppercase; }
        .cert-value { font-size: 8.5pt; font-weight: bold; color: #2D1765; margin-top: 0.5mm; }
        .issue-date { font-size: 8.5pt; margin-top: 1mm; color: #2D1765; }

        /* TITLE SECTION */
        .title-section { margin-top: 2mm; text-align: center; }
        .main-title { font-size: 26pt; font-weight: bold; line-height: 1.1; color: #16103A; text-align: left; }
        .main-title-ar { font-size: 26pt; font-weight: bold; line-height: 1.1; color: #16103A; text-align: right; }

        .divider { margin-top: 3mm; margin-bottom: 3mm; }

        .presented-container {
            text-align: center; margin-top: 2mm; font-size: 8pt;
            font-family: freesans; letter-spacing: 1.5px;
            text-transform: uppercase; color: #555; font-weight: bold;
        }

        .student {
            display: block; text-align: center; margin: 3mm auto 0;
            padding-bottom: 1.5mm; width: 80%; border-bottom: 2px solid #C6922E;
            font-size: 28pt; font-style: italic; font-weight: bold; color: #4B2AA9;
        }

        /* DESCRIPTION & COURSE */
        .description-table { width: 100%; margin-top: 4mm; }
        .description { font-size: 9.5pt; line-height: 1.4; color: #222; font-family: freesans; }
        .description-ar { font-size: 10.5pt; line-height: 1.4; color: #222; text-align: right; }

        .course-table { width: 100%; margin-top: 3mm; }
        .course { font-family: freeserif; font-size: 15pt; font-weight: bold; color: #16103A; }
        .meta { margin-top: 1.5mm; font-size: 8.5pt; color: #666; font-family: freesans; }
        .meta-ar { margin-top: 1.5mm; font-size: 9pt; color: #666; }

        /* CARDS / STATS */
        .stats { margin-top: 6mm; width: 100%; }
        .card { padding: 2.5mm; text-align: center; height: 22mm; vertical-align: middle; }
        .score { border: 0.4mm solid #CFC3FF; background: #F8F5FF; }
        .grade { border: 0.4mm solid #D8A033; background: #FFF9EE; }
        .status { border: 0.4mm solid #2C9A6A; background: #F4FFF8; }

        .icon-img { width: 6mm; height: 6mm; }
        .value { font-size: 16pt; font-weight: bold; font-family: freeserif; }
        .label { margin-top: 1.5mm; font-size: 6.5pt; letter-spacing: 1px; text-transform: uppercase; font-family: freesans; color: #555; font-weight: bold; }

        .score .value { color: #4B2AA9; }
        .grade .value { color: #A76500; }
        .status .value { color: #14774C; }

        /* FOOTER SIGNATURES */
        .signature-area { margin-top: 18mm; width: 100%; }
        .sig-table { width: 100%; }
        .sig-table td { vertical-align: top; text-align: center; }
        .sig-box { width: 45mm; margin: 0 auto; }
        .sig-box td { border-top: 0.5mm solid #2D1765; padding-top: 2mm; text-align: center; }
        .sig-title-en { font-size: 8pt; font-weight: bold; font-family: freesans; color: #16103A; }
        .sig-title-ar { font-size: 9pt; font-weight: bold; color: #16103A; margin-top: 0.5mm; }
        .sig-sub { font-size: 6.5pt; font-family: freesans; color: #777; margin-top: 0.5mm; }
    </style>
</head>

<body>
    <div class="page">
        <div class="content">
            <table class="header" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="16mm">
                        <img src="{{ public_path('assets/images/al-hilaal_update.png') }}" style="width:14mm; height:14mm; object-fit:contain; display:block;">
                    </td>
                    <td>
                        <table style="width:100%;" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="vertical-align:baseline;">
                                    <span class="school">Al-Hilaal Online Academy</span>
                                    <span class="school ar" style="font-size:15pt; margin-left: 2mm;">{{ ar(trans('certificate.academy_name', [], 'ar')) }}</span>
                                </td>
                            </tr>
                        </table>
                        <div class="school-sub">EXCELLENCE IN ISLAMIC ONLINE EDUCATION</div>
                        <div class="school-sub ar" style="text-align:left; margin-top:0.5mm;">
                            {{ ar(trans('certificate.academy_tagline', [], 'ar')) }}
                        </div>
                    </td>
                    <td>
                        <div class="cert-block">
                            <div class="cert-label">
                                <span style="color:#282349;">CERTIFICATE NO : </span> 
                                <span style="color:#e32a27;">{{ $verificationCode }}</span>
                            </div>
                            <div class="cert-value">{{ $certificateNo }}</div>
                            @if($issuedDate)
                                <div class="cert-label ar" style="margin-top:2mm;">تاريخ الإصدار :</div>
                                <div class="issue-date">{{ \Carbon\Carbon::parse($issuedDate)->format('d F Y') }}</div>
                            @endif
                        </div>
                    </td>
                </tr>
            </table>

            <div class="title-section">
                <table style="width:100%;" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="width:50%; text-align:left; vertical-align:middle;">
                            <div class="main-title">Certificate of<br>Completion</div>
                        </td>
                        <td style="width:50%; text-align:right; vertical-align:middle;">
                            <div class="main-title-ar ar">
                                {{ ar(trans('certificate.title', [], 'ar')) }}
                            </div>
                        </td>
                    </tr>
                </table>

                <table class="divider" cellpadding="0" cellspacing="0" style="width:100%;">
                    <tr>
                        <td style="width:38%;"><div style="border-top:0.3mm solid #C6922E; height:0;"></div></td>
                        <td style="width:24%; text-align:center;"><div style="width:3mm; height:3mm; background:#C6922E; border-radius:1.5mm; margin:0 auto;"></div></td>
                        <td style="width:38%;"><div style="border-top:0.3mm solid #C6922E; height:0;"></div></td>
                    </tr>
                </table>

                <div class="presented-container">
                    PROUDLY PRESENTED TO &nbsp;&nbsp;<span class="ar" style="font-size: 10pt;">{{ ar(trans('certificate.presented_to', [], 'ar')) }}</span>
                </div>

                <div class="student">{{ $studentName }}</div>

                <table class="description-table" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="width:48%; text-align:left; vertical-align:top;" class="description">
                            Has successfully completed all lessons, assessments and course requirements in
                        </td>
                        <td style="width:48%; text-align:right; vertical-align:top;" class="description-ar ar">
                            {{ ar(trans('certificate.description', [], 'ar')) }}
                        </td>
                    </tr>
                </table>

                <table class="course-table" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="width:33%; text-align:left; vertical-align:top;">
                            <div class="course">{{ $className }}</div>
                            @if($levelName)
                                <div class="meta">Level: {{ $levelName }}</div>
                            @endif
                        </td>

                        <td style="width:34%; text-align:center; vertical-align:top;">
                            <div class="course">{{ $className }}</div>
                            @if($levelName || $academicYearName)
                                <div class="meta">
                                    @if($levelName) Level {{ $levelName }} @endif
                                    @if($levelName && $academicYearName) • @endif
                                    @if($academicYearName) {{ $academicYearName }} @endif
                                </div>
                            @endif
                        </td>

                        <td style="width:33%; text-align:right; vertical-align:top;">
                            <div class="course ar">
                                {{ ar_level_label($levelCode ?? '', $levelName ?? $className) }}
                            </div>
                            <div class="meta-ar ar">
                                {{ ar(trans('certificate.level_label', [], 'ar')) }} {{ ar_section_label($sectionName ?? $levelName ?? 'ابتدائي') }}
                            </div>
                        </td>
                    </tr>
                </table>

                <table class="stats" cellpadding="0" cellspacing="0">
                    <tr>
                        @if($percentage !== null)
                            <td class="card score" width="31%">
                                <img class="icon-img" src="{{ public_path('assets/images/brand/medal.png') }}"><br>
                                <span class="value">{{ number_format((float) $percentage, 1) }}%</span>
                                <div class="label">AVERAGE SCORE / <span class="ar">{{ ar(trans('certificate.average_score', [], 'ar')) }}</span></div>
                            </td>
                            <td width="3.5%"></td>
                        @endif

                        @if($grade)
                            <td class="card grade" width="31%">
                                <img class="icon-img" src="{{ public_path('assets/images/brand/check.png') }}"><br>
                                <span class="value">{{ $grade }}</span>
                                <div class="label">GRADE / <span class="ar">{{ ar(trans('certificate.grade', [], 'ar')) }}</span></div>
                            </td>
                            <td width="3.5%"></td>
                        @endif

                        <td class="card status" width="31%">
                            <img class="icon-img" src="{{ public_path('assets/images/brand/star.png') }}"><br>
                            <span class="value">PASSED</span>
                            <div class="label">STATUS / <span class="ar">{{ ar(trans('certificate.status', [], 'ar')) }}</span></div>
                        </td>
                    </tr>
                </table>

                <div class="signature-area">
                    <table class="sig-table" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="33%">
                                <table class="sig-box" cellpadding="0" cellspacing="0"><tr><td>
                                    <div class="sig-title-en">Academy Director</div>
                                    <div class="sig-sub">Al-Hilaal Online Academy</div>
                                </td></tr></table>
                            </td>
                            <td width="34%">
                                <table class="sig-box" cellpadding="0" cellspacing="0"><tr><td>
                                    <div class="sig-title-ar ar-center">{{ ar(trans('certificate.director', [], 'ar')) }}</div>
                                    <div class="sig-sub">Al-Hilaal Online Academy</div>
                                </td></tr></table>
                            </td>
                            <td width="33%">
                                <table class="sig-box" cellpadding="0" cellspacing="0"><tr><td>
                                    <div class="sig-title-ar ar-center">{{ ar(trans('certificate.registrar', [], 'ar')) }}</div>
                                    <div class="sig-sub">&nbsp;</div>
                                </td></tr></table>
                            </td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
</body>
</html>