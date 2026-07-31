<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Report Card - {{ $reportNo }}</title>
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

        @page {
            margin: 0;
            size: A4 portrait;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            width: 210mm;
            font-family: Arial, sans-serif;
            background: white;
            color: #1A0A2E;
        }

        .ar {
            direction: rtl;
            unicode-bidi: embed;
            text-align: right;
            font-family: 'Amiri', serif !important;
        }

        .page {
            position: relative;
            width: 190mm;
            min-height: 279mm;
            background: #FCFBF7;
            padding: 8mm 10mm 10mm;
            overflow: hidden;
        }

        .outer-border {
            position: absolute;
            top: 5mm; left: 5mm; right: 5mm; bottom: 5mm;
            border: 2px solid #2D1765;
            pointer-events: none;
        }
        .inner-border {
            position: absolute;
            top: 6.5mm; left: 6.5mm; right: 6.5mm; bottom: 6.5mm;
            border: 1px solid #D8CDF2;
            pointer-events: none;
        }

        .watermark {
            position: absolute; left: 50%; top: 50%;
            margin-left: -45mm; margin-top: -45mm;
            width: 90mm; height: 90mm; opacity: .05; z-index: 0;
        }
        .watermark img { width: 100%; height: 100%; object-fit: contain; }

        .content { position: relative; z-index: 1; }

        /* HEADER */
        .header-table { width: 100%; table-layout: fixed; border-bottom: 2px solid #C6922E; padding-bottom: 3mm; margin-bottom: 4mm; }
        .header-table td { vertical-align: middle; overflow: hidden; }
        .school-name { font-size: 16pt; font-weight: bold; color: #16103A; }
        .school-name-ar { font-size: 13pt; color: #16103A; }
        .school-tagline { font-family: Arial; font-size: 6.5pt; letter-spacing: 2px; color: #777; margin-top: 1mm; text-transform: uppercase; }

        .doc-title-block { text-align: right; }
        .doc-title { font-size: 11.5pt; font-weight: bold; color: #4B2AA9; letter-spacing: .3px; text-transform: uppercase; word-wrap: break-word; }
        .doc-title-ar { font-size: 10pt; color: #4B2AA9; margin-top: 0.5mm; }
        .doc-ref { font-family: monospace; font-size: 7pt; color: #777; margin-top: 1.5mm; word-wrap: break-word; }

        /* STUDENT INFO */
        .info-box {
            background: #F8F5FF;
            border: 1px solid #E3DBFA;
            border-radius: 6px;
            padding: 4mm 5mm;
            margin-bottom: 5mm;
        }
        .info-table { width: 100%; table-layout: fixed; }
        .info-table td { padding: 1.3mm 2mm; font-size: 8.7pt; vertical-align: top; overflow: hidden; word-wrap: break-word; }
        .info-label { color: #6B6584; font-size: 7pt; text-transform: uppercase; letter-spacing: .5px; font-weight: bold; }
        .info-value { color: #16103A; font-weight: bold; font-size: 9.5pt; margin-top: 0.5mm; }

        /* SECTION LABEL */
        .section-label {
            font-size: 9.5pt;
            font-weight: bold;
            color: #fff;
            background: #2D1765;
            padding: 2.2mm 4mm;
            border-radius: 4px 4px 0 0;
            letter-spacing: .5px;
        }

        /* SUBJECT TABLE */
        table.subjects {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            margin-bottom: 5mm;
            font-size: 8.3pt;
        }
        table.subjects thead th {
            background: #EDE9FA;
            color: #2D1765;
            text-align: left;
            padding: 2.5mm 2.5mm;
            font-size: 7.3pt;
            text-transform: uppercase;
            letter-spacing: .4px;
            border-bottom: 1.5px solid #C6922E;
            overflow: hidden;
        }
        table.subjects tbody td {
            padding: 2.6mm 2.5mm;
            border-bottom: 1px solid #EEE9FA;
            vertical-align: middle;
            overflow: hidden;
            word-wrap: break-word;
        }
        table.subjects tbody tr:nth-child(even) { background: #FBFAFF; }

        .subj-name { font-weight: bold; color: #16103A; }
        .subj-teacher { color: #8A84A0; font-size: 7.5pt; }

        .pct-cell { white-space: nowrap; }
        .pct-bar-wrap { display: block; width: 100%; height: 3px; background: #EDE9FA; border-radius: 3px; margin-top: 1mm; }
        .pct-bar { display: block; height: 3px; background: #6B46C1; border-radius: 3px; }

        .grade-pill {
            display: inline-block;
            padding: 1mm 2.5mm;
            border-radius: 999px;
            font-weight: bold;
            font-size: 7.6pt;
            color: #fff;
        }
        .g-Ap, .g-A { background: #059669; }
        .g-B { background: #2563EB; }
        .g-C { background: #D97706; }
        .g-D { background: #DC2626; }
        .g-E { background: #7F1D1D; }
        .g-none { background: #9CA3AF; }

        .center { text-align: center; }
        .right { text-align: right; }

        /* SUMMARY CARDS */
        table.summary { width: 100%; table-layout: fixed; border-collapse: separate; border-spacing: 2mm 0; margin-bottom: 5mm; }
        .sum-card { border-radius: 6px; padding: 3mm 1.5mm; text-align: center; border: 1.3px solid; overflow: hidden; }
        .sum-value { font-size: 13pt; font-weight: bold; }
        .sum-label { font-size: 6.3pt; text-transform: uppercase; letter-spacing: .4px; color: #666; margin-top: 1mm; font-weight: bold; }
        .c-purple { border-color: #CFC3FF; background: #F8F5FF; } .c-purple .sum-value { color: #4B2AA9; }
        .c-gold   { border-color: #E8C27D; background: #FFF9EE; } .c-gold .sum-value { color: #A76500; }
        .c-green  { border-color: #A7E0C6; background: #F1FBF6; } .c-green .sum-value { color: #14774C; }
        .c-blue   { border-color: #A9C6F5; background: #F0F5FF; } .c-blue .sum-value { color: #1D4ED8; }

        /* REMARK BOX */
        .remark-box {
            border: 1px solid #E3DBFA;
            border-left: 4px solid #C6922E;
            background: #FFFDF8;
            border-radius: 0 6px 6px 0;
            padding: 3.5mm 5mm;
            margin-bottom: 5mm;
            font-size: 8.7pt;
            color: #3B2459;
        }
        .remark-box strong { color: #16103A; }

        /* GRADING SCALE */
        table.scale { width: 100%; table-layout: fixed; border-collapse: collapse; margin-bottom: 6mm; font-size: 7pt; }
        table.scale td { border: 1px solid #E3DBFA; padding: 1.6mm; text-align: center; color: #555; overflow: hidden; }
        table.scale td.scale-head { background: #F5F3FD; font-weight: bold; color: #2D1765; }

        /* SIGNATURES */
        .sig-table { width: 100%; table-layout: fixed; margin-top: 8mm; }
        .sig-table td { text-align: center; vertical-align: top; padding-top: 8mm; overflow: hidden; }
        .sig-line { width: 42mm; margin: 0 auto 2mm; border-top: 1.3px solid #2D1765; }
        .sig-title { font-size: 8pt; font-weight: bold; color: #16103A; }
        .sig-sub { font-size: 6.5pt; color: #888; margin-top: 0.5mm; }

        .footer-note {
            margin-top: 7mm;
            text-align: center;
            font-size: 6.6pt;
            color: #9892B0;
            border-top: 1px dashed #E3DBFA;
            padding-top: 3mm;
        }
    </style>
</head>

<body>
    <div class="page">
        <div class="outer-border"></div>
        <div class="inner-border"></div>

        <div class="watermark">
            <img src="{{ public_path('assets/images/al-hilaal_update.png') }}" alt="Watermark">
        </div>

        <div class="content">
            {{-- HEADER --}}
            <table class="header-table" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="16mm">
                        <img src="{{ public_path('assets/images/al-hilaal_update.png') }}" style="width:14mm;height:14mm;object-fit:contain;display:block;">
                    </td>
                    <td width="54%">
                        <div class="school-name">Al-Hilaal Online Academy</div>
                        <div class="school-name-ar ar">{{ ar(trans('certificate.academy_name', [], 'ar')) }}</div>
                        <div class="school-tagline">Excellence in Islamic Online Education</div>
                    </td>
                    <td width="30%">
                        <div class="doc-title-block">
                            <div class="doc-title">Student Report Card</div>
                            <div class="doc-title-ar ar">{{ ar(trans('report_card.title', [], 'ar')) }}</div>
                            <div class="doc-ref">Ref: {{ $reportNo }}</div>
                            <div class="doc-ref">Issued: {{ $generatedAt->format('d F Y') }}</div>
                        </div>
                    </td>
                </tr>
            </table>

            {{-- STUDENT INFO --}}
            <div class="info-box">
                <table class="info-table" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="25%">
                            <div class="info-label">Student Name</div>
                            <div class="info-value">{{ $studentName }}</div>
                        </td>
                        <td width="20%">
                            <div class="info-label">Class</div>
                            <div class="info-value">{{ $class->name }}</div>
                        </td>
                        <td width="20%">
                            <div class="info-label">Level</div>
                            <div class="info-value">{{ $levelName ?? '—' }}</div>
                        </td>
                        <td width="17%">
                            <div class="info-label">Roll No.</div>
                            <div class="info-value">{{ $rollNumber ?? '—' }}</div>
                        </td>
                        <td width="18%">
                            <div class="info-label">Academic Year</div>
                            <div class="info-value">{{ $academicYearName ?? '—' }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="info-label">Section</div>
                            <div class="info-value">{{ $sectionName ?? '—' }}</div>
                        </td>
                        <td colspan="2">
                            <div class="info-label">Class Teacher</div>
                            <div class="info-value">{{ $classTeacherName ?: '—' }}</div>
                        </td>
                        <td colspan="2">
                            <div class="info-label">Class Position</div>
                            <div class="info-value">
                                @if($rankPosition)
                                    {{ $rankPosition }} of {{ $rankOutOf }}
                                @else
                                    Not yet ranked
                                @endif
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            {{-- SUBJECT PERFORMANCE --}}
            <div class="section-label">Subject-Wise Performance</div>
            <table class="subjects">
                <thead>
                    <tr>
                        <th style="width:26%;">Subject</th>
                        <th style="width:10%;" class="center">Full Marks</th>
                        <th style="width:12%;" class="center">Obtained</th>
                        <th style="width:16%;">Percentage</th>
                        <th style="width:9%;" class="center">Grade</th>
                        <th style="width:9%;" class="center">Lessons</th>
                        <th style="width:18%;">Remark</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subjects as $subject)
                        <tr>
                            <td>
                                <div class="subj-name">{{ $subject['name'] }}</div>
                                @if($subject['teacher'])
                                    <div class="subj-teacher">{{ $subject['teacher'] }}</div>
                                @endif
                            </td>
                            <td class="center">{{ $subject['full_marks'] }}</td>
                            <td class="center">
                                {{ $subject['marks_obtained'] !== null ? $subject['marks_obtained'] : '—' }}
                            </td>
                            <td class="pct-cell">
                                @if($subject['percentage'] !== null)
                                    {{ number_format($subject['percentage'], 1) }}%
                                    <span class="pct-bar-wrap"><span class="pct-bar" style="width:{{ min(100, $subject['percentage']) }}%;"></span></span>
                                @else
                                    <span style="color:#AAA;">—</span>
                                @endif
                            </td>
                            <td class="center">
                                @if($subject['grade'])
                                    <span class="grade-pill g-{{ str_replace('+', 'p', $subject['grade']) }}">{{ $subject['grade'] }}</span>
                                @else
                                    <span class="grade-pill g-none">—</span>
                                @endif
                            </td>
                            <td class="center">{{ $subject['lessons_completed'] }}/{{ $subject['lessons_total'] }}</td>
                            <td style="font-size:7.6pt;color:#555;">{{ $subject['remark'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="center" style="padding:6mm;color:#999;">No subjects assigned to this class yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- SUMMARY CARDS --}}
            <table class="summary">
                <tr>
                    <td width="25%">
                        <div class="sum-card c-purple">
                            <div class="sum-value">{{ $totalMarksObtained }}/{{ $totalFullMarks }}</div>
                            <div class="sum-label">Total Marks</div>
                        </div>
                    </td>
                    <td width="25%">
                        <div class="sum-card c-gold">
                            <div class="sum-value">{{ $overallPercentage !== null ? number_format($overallPercentage, 1) . '%' : '—' }}</div>
                            <div class="sum-label">Overall Score</div>
                        </div>
                    </td>
                    <td width="25%">
                        <div class="sum-card c-green">
                            <div class="sum-value">{{ $overallGrade ?? '—' }}</div>
                            <div class="sum-label">Overall Grade</div>
                        </div>
                    </td>
                    <td width="25%">
                        <div class="sum-card c-blue">
                            <div class="sum-value">{{ $lessonProgressPercentage }}%</div>
                            <div class="sum-label">Lesson Progress</div>
                        </div>
                    </td>
                </tr>
            </table>

            {{-- REMARK --}}
            <div class="remark-box">
                <strong>Class Teacher's Remark:</strong> {{ $overallRemark }}.
                Completed {{ $totalLessonsCompleted }} of {{ $totalLessons }} lessons
                and attempted {{ $totalQuizzesTaken }} of {{ $totalQuizzes }} quizzes.
            </div>

            {{-- GRADING SCALE --}}
            <table class="scale">
                <tr>
                    <td class="scale-head">Grade</td>
                    <td>A+</td><td>A</td><td>B</td><td>C</td><td>D</td><td>E</td>
                </tr>
                <tr>
                    <td class="scale-head">Range</td>
                    <td>90-100%</td><td>80-89%</td><td>70-79%</td><td>60-69%</td><td>50-59%</td><td>Below 50%</td>
                </tr>
            </table>

            {{-- SIGNATURES --}}
            <table class="sig-table" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="33%">
                        <div class="sig-line"></div>
                        <div class="sig-title">Class Teacher</div>
                        <div class="sig-sub">{{ $classTeacherName ?: 'Al-Hilaal Online Academy' }}</div>
                    </td>
                    <td width="34%">
                        <div class="sig-line"></div>
                        <div class="sig-title">Academy Director</div>
                        <div class="sig-sub">Al-Hilaal Online Academy</div>
                    </td>
                    <td width="33%">
                        <div class="sig-line"></div>
                        <div class="sig-title">Parent / Guardian</div>
                        <div class="sig-sub">Acknowledgement</div>
                    </td>
                </tr>
            </table>

            <div class="footer-note">
                This is a system-generated report card produced from live lesson &amp; quiz records as of {{ $generatedAt->format('d F Y, H:i') }}.
                &nbsp;•&nbsp; Al-Hilaal Online Academy &nbsp;•&nbsp; Report Ref: {{ $reportNo }}
            </div>
        </div>
    </div>
</body>
</html>