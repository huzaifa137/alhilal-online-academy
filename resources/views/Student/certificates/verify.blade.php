<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Certificate — Al-Hilal Online Academy</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,800;1,700&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --purple: #6B46C1; --purple-dark: #4C2E8A; --purple-light: #EDE9FA;
            --gold: #D97706; --gold-light: #FEF3C7;
            --green: #059669; --green-light: #D1FAE5;
            --red: #DC2626; --red-light: #FEE2E2;
            --ink: #1A0A2E; --muted: #6B6584;
            --border: #E3E0F0; --surface: #fff; --bg: #F5F3FD;
            --radius: 18px; --shadow: 0 8px 32px rgba(107,70,193,.14);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--ink); min-height: 100vh; display: flex; flex-direction: column; align-items: center; padding: 40px 20px 80px; }

        /* Header */
        .vr-header { text-align: center; margin-bottom: 36px; }
        .vr-logo { width: 62px; height: 62px; background: linear-gradient(135deg, var(--purple), var(--purple-dark)); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.7rem; color: #fff; margin: 0 auto 14px; box-shadow: 0 4px 16px rgba(107,70,193,.3); }
        .vr-academy { font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 800; color: var(--ink); }
        .vr-sub { font-size: .78rem; color: var(--muted); margin-top: 3px; letter-spacing: .05em; }

        /* Search box */
        .vr-search-card { background: var(--surface); border: 1.5px solid var(--border); border-radius: var(--radius); padding: 32px 36px; max-width: 520px; width: 100%; box-shadow: var(--shadow); margin-bottom: 28px; }
        .vr-search-title { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 800; margin-bottom: 6px; }
        .vr-search-title em { font-style: italic; color: var(--purple); }
        .vr-search-desc { font-size: .82rem; color: var(--muted); margin-bottom: 22px; }
        .vr-input-row { display: flex; gap: 10px; }
        .vr-input { flex: 1; border: 1.5px solid var(--border); border-radius: 12px; padding: 11px 14px; font-size: .88rem; color: var(--ink); background: var(--bg); font-family: monospace; letter-spacing: .06em; }
        .vr-input:focus { outline: none; border-color: var(--purple); background: #fff; }
        .vr-btn { display: inline-flex; align-items: center; gap: 7px; padding: 11px 20px; border-radius: 12px; font-size: .82rem; font-weight: 600; border: none; cursor: pointer; background: var(--purple); color: #fff; transition: all .2s; }
        .vr-btn:hover { background: var(--purple-dark); transform: translateY(-1px); }

        /* Result card — valid */
        .vr-result-valid { background: var(--surface); border: 2px solid var(--green); border-radius: var(--radius); max-width: 520px; width: 100%; box-shadow: 0 8px 28px rgba(5,150,105,.14); overflow: hidden; }
        .vr-result-valid-header { background: linear-gradient(135deg, #059669 0%, #16A34A 100%); padding: 20px 24px; display: flex; align-items: center; gap: 14px; }
        .vr-result-valid-icon { font-size: 2rem; color: #fff; }
        .vr-result-valid-title { font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 700; color: #fff; }
        .vr-result-valid-sub { font-size: .75rem; color: rgba(255,255,255,.8); margin-top: 2px; }
        .vr-result-body { padding: 22px 24px; }
        .vr-field-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px; margin-bottom: 18px; }
        .vr-field label { font-size: .67rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--muted); display: block; margin-bottom: 3px; }
        .vr-field-val { font-size: .88rem; font-weight: 500; color: var(--ink); }
        .vr-field-val.mono { font-family: monospace; color: var(--purple-dark); font-size: .8rem; }
        .vr-cert-seal { display: flex; align-items: center; gap: 12px; background: var(--green-light); border: 1px solid var(--green); border-radius: 12px; padding: 14px 18px; }
        .vr-cert-seal-icon { font-size: 1.6rem; }
        .vr-cert-seal-text { font-size: .82rem; font-weight: 600; color: #065F46; }
        .vr-cert-seal-sub { font-size: .73rem; color: #047857; margin-top: 2px; }
        /* Pill badges */
        .vr-pill { padding: 4px 12px; border-radius: 999px; font-size: .7rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; margin-top: 6px; }
        .vr-pill-gold { background: var(--gold-light); color: var(--gold); }
        .vr-pill-purple { background: var(--purple-light); color: var(--purple); }

        /* Result card — invalid */
        .vr-result-invalid { background: var(--surface); border: 2px solid var(--red); border-radius: var(--radius); max-width: 520px; width: 100%; padding: 28px 28px; text-align: center; }
        .vr-invalid-icon { font-size: 2.5rem; margin-bottom: 12px; color: var(--red); }
        .vr-invalid-title { font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 800; color: var(--red); margin-bottom: 8px; }
        .vr-invalid-text { font-size: .83rem; color: var(--muted); }
    </style>
</head>
<body>

    <div class="vr-header">
        <div class="vr-logo">🕌</div>
        <div class="vr-academy">Al-Hilal Online Academy</div>
        <div class="vr-sub">Excellence in Islamic Online Education</div>
    </div>

    {{-- Search box --}}
    <div class="vr-search-card">
        <div class="vr-search-title">Verify a <em>Certificate</em></div>
        <p class="vr-search-desc">Enter the verification code printed on the certificate to confirm its authenticity.</p>
        <form method="GET" action="{{ route('certificates.verify') }}">
            <div class="vr-input-row">
                <input class="vr-input" type="text" name="code"
                       value="{{ $code ?? '' }}"
                       placeholder="e.g. AH3K-7F2D-9P1X-KM2R"
                       autocomplete="off" spellcheck="false">
                <button type="submit" class="vr-btn">
                    <i class="fas fa-search"></i> Verify
                </button>
            </div>
        </form>
    </div>

    {{-- Result --}}
    @if($code)
        @if($certificate)
            @php
                $student     = $certificate->student;
                $studentName = $student->fullname
                    ?? trim(($student->firstname ?? '') . ' ' . ($student->lastname ?? ''))
                    ?: 'Student';
            @endphp

            @if($certificate->status === 'issued')
                <div class="vr-result-valid">
                    <div class="vr-result-valid-header">
                        <div class="vr-result-valid-icon">✅</div>
                        <div>
                            <div class="vr-result-valid-title">Certificate Verified</div>
                            <div class="vr-result-valid-sub">This is an authentic Al-Hilal Online Academy certificate.</div>
                        </div>
                    </div>
                    <div class="vr-result-body">
                        <div class="vr-cert-seal" style="margin-bottom:18px;">
                            <div class="vr-cert-seal-icon">🎓</div>
                            <div>
                                <div class="vr-cert-seal-text">Certificate of Completion</div>
                                <div class="vr-cert-seal-sub">Al-Hilal Online Academy — Officially Issued</div>
                            </div>
                        </div>
                        <div class="vr-field-grid">
                            <div class="vr-field">
                                <label>Student Name</label>
                                <div class="vr-field-val">{{ $studentName }}</div>
                            </div>
                            <div class="vr-field">
                                <label>Class Completed</label>
                                <div class="vr-field-val">{{ $certificate->class->name ?? '—' }}</div>
                            </div>
                            @if($certificate->class->level)
                            <div class="vr-field">
                                <label>Level</label>
                                <div class="vr-field-val">{{ $certificate->class->level->name }}</div>
                            </div>
                            @endif
                            <div class="vr-field">
                                <label>Issued On</label>
                                <div class="vr-field-val">
                                    {{ $certificate->issued_date ? \Carbon\Carbon::parse($certificate->issued_date)->format('d F Y') : '—' }}
                                </div>
                            </div>
                            <div class="vr-field">
                                <label>Certificate No.</label>
                                <div class="vr-field-val mono">{{ $certificate->certificate_no }}</div>
                            </div>
                            <div class="vr-field">
                                <label>Verification Code</label>
                                <div class="vr-field-val mono">{{ $certificate->verification_code }}</div>
                            </div>
                        </div>
                        @if($certificate->grade || $certificate->percentage !== null)
                            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                                @if($certificate->grade)
                                    <span class="vr-pill vr-pill-gold"><i class="fas fa-star"></i> Grade {{ $certificate->grade }}</span>
                                @endif
                                @if($certificate->percentage !== null)
                                    <span class="vr-pill vr-pill-purple"><i class="fas fa-chart-line"></i> {{ number_format((float)$certificate->percentage, 1) }}% Score</span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @else
                {{-- Revoked --}}
                <div class="vr-result-invalid">
                    <div class="vr-invalid-icon"><i class="fas fa-ban"></i></div>
                    <div class="vr-invalid-title">Certificate Revoked</div>
                    <p class="vr-invalid-text">This certificate ({{ $certificate->certificate_no }}) has been revoked by the institution and is no longer valid.</p>
                </div>
            @endif
        @else
            {{-- Not found --}}
            <div class="vr-result-invalid">
                <div class="vr-invalid-icon"><i class="fas fa-times-circle"></i></div>
                <div class="vr-invalid-title">Certificate Not Found</div>
                <p class="vr-invalid-text">No certificate matches the code <strong>{{ $code }}</strong>. Please check the code and try again.</p>
            </div>
        @endif
    @endif

</body>
</html>
