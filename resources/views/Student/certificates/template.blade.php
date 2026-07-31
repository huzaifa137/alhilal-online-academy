<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Certificate - {{ $certificateNo }}</title>
    <style>
        @font-face {
            font-family: 'Amiri';
            font-style: normal;
            font-weight: normal;
            src: url('{{ public_path('assets/fonts/Amiri-Regular.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: 'Amiri';
            font-style: normal;
            font-weight: bold;
            src: url('{{ public_path('assets/fonts/Amiri-Bold.ttf') }}') format('truetype');
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            width: 297mm;
            height: 210mm;
            overflow: hidden;
            font-family: Georgia, serif;
            background: white;
        }

        .ar {
            direction: rtl;
            unicode-bidi: embed;
            text-align: right;
            font-family: 'Amiri', serif !important;
        }

        .ar-center {
            direction: rtl;
            unicode-bidi: embed;
            text-align: center;
            font-family: 'Amiri', serif !important;
        }

        .page {
            position: relative;
            width: 297mm;
            height: 210mm;
            background: #FCFBF7;
            overflow: hidden;
        }

        /* BORDERS & CORNERS */
        .outer { position: absolute; top: 5mm; left: 5mm; right: 5mm; bottom: 5mm; border: 3px solid #2D1765; }
        .middle { position: absolute; top: 7mm; left: 7mm; right: 7mm; bottom: 7mm; border: 1.5px solid #C6922E; }
        .inner { position: absolute; top: 9mm; left: 9mm; right: 9mm; bottom: 9mm; border: 1px solid #E5DDF5; }

        .corner { position: absolute; width: 10mm; height: 10mm; }
        .tl { top: 5mm; left: 5mm; border-top: 3px solid #C6922E; border-left: 3px solid #C6922E; }
        .tr { top: 5mm; right: 5mm; border-top: 3px solid #C6922E; border-right: 3px solid #C6922E; }
        .bl { bottom: 5mm; left: 5mm; border-bottom: 3px solid #C6922E; border-left: 3px solid #C6922E; }
        .br { bottom: 5mm; right: 5mm; border-bottom: 3px solid #C6922E; border-right: 3px solid #C6922E; }

        /* SIDEBAR */
        .sidebar { position: absolute; left: 0; top: 0; bottom: 0; width: 30mm; background: #2D1765; }
        .gold-strip { position: absolute; left: 30mm; top: 0; bottom: 0; width: 3mm; background: #C6922E; }
        .sidebar-icon { position: absolute; top: 55mm; left: 7mm; text-align: center; color: white; }
        .sidebar-icon p { font-size: 8pt; letter-spacing: 2px; margin-top: 5mm; }
        .sidebar-text {
            position: absolute; top: 120mm; left: -32mm; width: 90mm;
            text-align: center; font-size: 9pt; font-family: Arial;
            font-weight: bold; letter-spacing: 4px; color: white;
            transform: rotate(-90deg);
        }

        /* WATERMARK */
        .watermark {
            position: absolute; left: 50%; top: 50%;
            margin-left: -55mm; margin-top: -55mm;
            width: 110mm; height: 110mm; opacity: .06; z-index: 0;
        }
        .watermark img { width: 100%; height: 100%; object-fit: contain; }

        /* CONTENT CONTAINER */
        .content {
            position: absolute; left: 40mm; right: 15mm; top: 10mm; bottom: 10mm; z-index: 1;
        }

        /* HEADER */
        .header { width: 100%; padding-bottom: 2mm; margin-bottom: 2mm; border-bottom: 1px solid #DDD; }
        .header td { vertical-align: top; }
        .school { font-size: 15pt; font-weight: bold; color: #16103A; }
        .school-sub { font-family: Arial; font-size: 6.5pt; letter-spacing: 2.5px; color: #777; margin-top: 1mm; }

        .cert-block { text-align: right; }
        .cert-label { font-family: Arial; font-size: 6.5pt; letter-spacing: 1px; color: #777; text-transform: uppercase; }
        .cert-value { font-size: 8.5pt; font-weight: bold; color: #2D1765; margin-top: 0.5mm; }
        .issue-date { font-size: 8.5pt; margin-top: 1mm; color: #2D1765; }

        /* TITLE SECTION */
        .title-section { margin-top: 2mm; text-align: center; }
        .main-title { font-size: 26pt; font-weight: bold; line-height: 1.1; color: #16103A; text-align: left; }
        .main-title-ar { font-size: 26pt; font-weight: bold; line-height: 1.1; color: #16103A; text-align: right; }

        .divider { margin-top: 3mm; margin-bottom: 3mm; text-align: center; }
        .divider-line { display: inline-block; width: 45mm; height: 1px; background: #C6922E; vertical-align: middle; }
        .divider-dot { display: inline-block; width: 3mm; height: 3mm; background: #C6922E; border-radius: 50%; margin: 0 3mm; vertical-align: middle; }

        .presented-container {
            text-align: center; margin-top: 2mm; font-size: 8pt;
            font-family: Arial, sans-serif; letter-spacing: 1.5px;
            text-transform: uppercase; color: #555; font-weight: bold;
        }

        .student {
            display: block; text-align: center; margin: 3mm auto 0;
            padding-bottom: 1.5mm; width: 80%; border-bottom: 2px solid #C6922E;
            font-size: 28pt; font-style: italic; font-weight: bold; color: #4B2AA9;
        }

        /* DESCRIPTION & COURSE */
        .description-table { width: 100%; margin-top: 4mm; }
        .description { font-size: 9.5pt; line-height: 1.4; color: #222; font-family: Arial, sans-serif; }
        .description-ar { font-size: 10.5pt; line-height: 1.4; color: #222; text-align: right; }

        .course-table { width: 100%; margin-top: 3mm; }
        .course { font-family: Georgia, serif; font-size: 15pt; font-weight: bold; color: #16103A; }
        .meta { margin-top: 1.5mm; font-size: 8.5pt; color: #666; font-family: Arial, sans-serif; }
        .meta-ar { margin-top: 1.5mm; font-size: 9pt; color: #666; }

        /* CARDS / STATS */
        .stats { margin-top: 4mm; width: 100%; border-collapse: separate; border-spacing: 6mm 0; }
        .card { padding: 2.5mm; text-align: center; height: 22mm; border-radius: 4px; }
        .score { border: 1.5px solid #CFC3FF; background: #F8F5FF; }
        .grade { border: 1.5px solid #D8A033; background: #FFF9EE; }
        .status { border: 1.5px solid #2C9A6A; background: #F4FFF8; }

        .icon-img { width: 6mm; height: 6mm; display: block; margin: 0 auto 1.5mm; object-fit: contain; }
        .value { font-size: 16pt; font-weight: bold; font-family: Georgia, serif; }
        .label { margin-top: 1.5mm; font-size: 6.5pt; letter-spacing: 1px; text-transform: uppercase; font-family: Arial, sans-serif; color: #555; font-weight: bold; }

        .score .value { color: #4B2AA9; }
        .grade .value { color: #A76500; }
        .status .value { color: #14774C; }

        /* FOOTER SIGNATURES */
        .signature-area { margin-top: 6mm; width: 100%; }
        .sig-table { width: 100%; }
        .sig-table td { vertical-align: top; text-align: center; }
        .sig-line { width: 45mm; margin: 0 auto 2mm; border-top: 1.5px solid #2D1765; }
        .sig-title-en { font-size: 8pt; font-weight: bold; font-family: Arial, sans-serif; color: #16103A; }
        .sig-title-ar { font-size: 9pt; font-weight: bold; color: #16103A; margin-top: 0.5mm; }
        .sig-sub { font-size: 6.5pt; font-family: Arial, sans-serif; color: #777; margin-top: 0.5mm; }
    </style>
</head>

<body>
    <div class="page">
        <div class="outer"></div>
        <div class="middle"></div>
        <div class="inner"></div>
        <div class="corner tl"></div>
        <div class="corner tr"></div>
        <div class="corner bl"></div>
        <div class="corner br"></div>
        <div class="sidebar"></div>
        <div class="gold-strip"></div>
        
        <div class="sidebar-icon">
            <img src="{{ public_path('assets/images/al-hilaal_update.png') }}" style="width: 16mm; height: auto; display: block; margin: 0 auto;" alt="Logo">
            <p>AL-HILAL</p>
        </div>
        
        <div class="sidebar-text">Al-Hilaal Online Academy</div>
        
        <div class="watermark">
            <img src="{{ public_path('assets/images/al-hilaal_update.png') }}" alt="Watermark">
        </div>

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
                                <div class="cert-label ar" style="margin-top:2mm;">تاريخ التاريخ :</div>
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

                <div class="divider">
                    <span class="divider-line"></span>
                    <span class="divider-dot"></span>
                    <span class="divider-line"></span>
                </div>

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

                <table class="stats">
                    <tr>
                        @if($percentage !== null)
                            <td width="33%">
                                <div class="card score">
                                    <img class="icon-img" src="{{ public_path('assets/images/brand/medal.png') }}">
                                    <div class="value">{{ number_format((float) $percentage, 1) }}%</div>
                                    <div class="label">AVERAGE SCORE / <span class="ar">{{ ar(trans('certificate.average_score', [], 'ar')) }}</span></div>
                                </div>
                            </td>
                        @endif

                        @if($grade)
                            <td width="33%">
                                <div class="card grade">
                                    <img class="icon-img" src="{{ public_path('assets/images/brand/check.png') }}">
                                    <div class="value">{{ $grade }}</div>
                                    <div class="label">GRADE / <span class="ar">{{ ar(trans('certificate.grade', [], 'ar')) }}</span></div>
                                </div>
                            </td>
                        @endif

                        <td width="33%">
                            <div class="card status">
                                <img class="icon-img" src="{{ public_path('assets/images/brand/star.png') }}">
                                <div class="value">PASSED</div>
                                <div class="label">STATUS / <span class="ar">{{ ar(trans('certificate.status', [], 'ar')) }}</span></div>
                            </div>
                        </td>
                    </tr>
                </table>

                <div class="signature-area">
                    <table class="sig-table" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="33%">
                                <div class="sig-line"></div>
                                <div class="sig-title-en">Academy Director</div>
                                <div class="sig-sub">Al-Hilaal Online Academy</div>
                            </td>
                            <td width="34%">
                                <div class="sig-line"></div>
                                <div class="sig-title-ar ar-center">{{ ar(trans('certificate.director', [], 'ar')) }}</div>
                                <div class="sig-sub">Al-Hilaal Online Academy</div>
                            </td>
                            <td width="33%">
                                <div class="sig-line"></div>
                                <div class="sig-title-ar ar-center">{{ ar(trans('certificate.registrar', [], 'ar')) }}</div>
                                <div class="sig-title-ar ar-center" style="font-size:7.5pt; font-weight:normal;">{{ ar(trans('certificate.registrar', [], 'ar')) }}</div>
                            </td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
</body>
</html>