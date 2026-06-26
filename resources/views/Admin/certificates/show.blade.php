@extends('Admin.layouts.admin-master')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,800;1,700&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --purple: #6B46C1; --purple-dark: #4C2E8A; --purple-light: #EDE9FA;
            --gold: #D97706; --gold-light: #FEF3C7;
            --green: #059669; --green-light: #D1FAE5;
            --red: #DC2626; --red-light: #FEE2E2;
            --ink: #1A0A2E; --muted: #6B6584;
            --border: #E3E0F0; --surface: #fff;
            --radius: 16px; --shadow: 0 4px 20px rgba(107,70,193,.10);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        .as-wrap { font-family: 'DM Sans', sans-serif; color: var(--ink); padding: 32px 36px 60px; max-width: 860px; }
        .as-back { display: inline-flex; align-items: center; gap: 7px; color: var(--purple); font-size: .82rem; font-weight: 600; text-decoration: none; margin-bottom: 20px; }
        .as-back:hover { color: var(--purple-dark); }
        .as-title { font-family: 'Playfair Display', serif; font-size: 1.7rem; font-weight: 800; margin-bottom: 24px; color: var(--ink); }
        .as-title em { font-style: italic; color: var(--purple); }
        /* Card */
        .as-card { background: var(--surface); border: 1.5px solid var(--border); border-radius: var(--radius); overflow: hidden; box-shadow: var(--shadow); margin-bottom: 20px; }
        .as-card-header { background: linear-gradient(135deg, var(--purple) 0%, var(--purple-dark) 60%, var(--gold) 100%); padding: 22px 26px; display: flex; align-items: center; gap: 16px; }
        .as-icon-wrap { width: 52px; height: 52px; border-radius: 50%; background: rgba(255,255,255,.15); border: 2px solid rgba(255,255,255,.4); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: #fff; flex-shrink: 0; }
        .as-card-title { font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 700; color: #fff; }
        .as-card-sub { font-size: .75rem; color: rgba(255,255,255,.75); margin-top: 3px; }
        .as-badge { padding: 4px 12px; border-radius: 999px; font-size: .68rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; margin-left: auto; }
        .as-badge-green { background: rgba(5,150,105,.2); color: #6EE7B7; border: 1px solid rgba(5,150,105,.4); }
        .as-badge-red   { background: rgba(220,38,38,.2); color: #FCA5A5; border: 1px solid rgba(220,38,38,.4); }
        /* Fields */
        .as-body { padding: 24px 26px; }
        .as-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 18px; }
        .as-field label { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--muted); display: block; margin-bottom: 4px; }
        .as-field-val { font-size: .88rem; font-weight: 500; color: var(--ink); }
        .as-field-val.mono { font-family: monospace; color: var(--purple-dark); }
        .as-divider { height: 1px; background: var(--border); margin: 20px 0; }
        /* Revoke reason */
        .as-revoke-box { background: var(--red-light); border: 1.5px solid var(--red); border-radius: 12px; padding: 14px 18px; margin-top: 16px; font-size: .83rem; color: #9B1C1C; }
        /* Actions */
        .as-actions { display: flex; gap: 10px; flex-wrap: wrap; padding: 18px 26px; border-top: 1px solid var(--border); background: #FAFAFA; }
        .as-btn { display: inline-flex; align-items: center; gap: 7px; padding: 9px 18px; border-radius: 999px; font-size: .77rem; font-weight: 600; border: none; cursor: pointer; transition: all .2s; text-decoration: none; }
        .as-btn-primary { background: var(--purple); color: #fff; }
        .as-btn-primary:hover { background: var(--purple-dark); color: #fff; }
        .as-btn-outline { background: #fff; color: var(--purple); border: 1.5px solid var(--purple); }
        .as-btn-outline:hover { background: var(--purple-light); }
        .as-btn-danger { background: #fff; color: var(--red); border: 1.5px solid var(--red); }
        .as-btn-danger:hover { background: var(--red-light); }
        .as-btn-success { background: #fff; color: var(--green); border: 1.5px solid var(--green); }
        .as-btn-success:hover { background: var(--green-light); }
        /* Revoke modal */
        .as-modal-bg { display:none; position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:9999; align-items:center; justify-content:center; }
        .as-modal-bg.open { display:flex; }
        .as-modal { background:#fff; border-radius:20px; padding:28px 32px; max-width:400px; width:100%; box-shadow:0 20px 60px rgba(0,0,0,.2); }
        .as-modal h3 { font-family:'Playfair Display',serif; font-size:1.1rem; margin-bottom:10px; }
        .as-modal textarea { width:100%; border:1.5px solid var(--border); border-radius:10px; padding:10px 12px; font-size:.83rem; resize:vertical; min-height:80px; }
        .as-modal-actions { display:flex; justify-content:flex-end; gap:10px; margin-top:14px; }
    </style>

    <div class="as-wrap">
        <a href="{{ route('admin.certificates.index') }}" class="as-back">
            <i class="fas fa-arrow-left"></i> Back to All Certificates
        </a>

        <h1 class="as-title">Certificate <em>Detail</em></h1>

        @if(session('success'))
            <div style="background:var(--green-light);border:1px solid var(--green);border-radius:12px;padding:13px 18px;margin-bottom:20px;font-size:.84rem;color:#065F46;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @php
            $student     = $certificate->student;
            $studentName = $student->fullname
                ?? trim(($student->firstname ?? '') . ' ' . ($student->lastname ?? ''))
                ?: 'Student';
        @endphp

        {{-- Main info card --}}
        <div class="as-card">
            <div class="as-card-header">
                <div class="as-icon-wrap">🎓</div>
                <div>
                    <div class="as-card-title">{{ $certificate->title ?? 'Certificate of Completion' }}</div>
                    <div class="as-card-sub">{{ $certificate->certificate_no }}</div>
                </div>
                <div class="as-badge {{ $certificate->status === 'issued' ? 'as-badge-green' : 'as-badge-red' }}">
                    <i class="fas fa-{{ $certificate->status === 'issued' ? 'check-circle' : 'ban' }}"></i>
                    {{ ucfirst($certificate->status) }}
                </div>
            </div>

            <div class="as-body">
                <div class="as-grid">
                    <div class="as-field">
                        <label>Student Name</label>
                        <div class="as-field-val">{{ $studentName }}</div>
                    </div>
                    <div class="as-field">
                        <label>Email</label>
                        <div class="as-field-val">{{ $student->email ?? '—' }}</div>
                    </div>
                    <div class="as-field">
                        <label>Class</label>
                        <div class="as-field-val">{{ $certificate->class->name ?? '—' }}</div>
                    </div>
                    <div class="as-field">
                        <label>Level</label>
                        <div class="as-field-val">{{ $certificate->class->level->name ?? '—' }}</div>
                    </div>
                    <div class="as-field">
                        <label>Academic Year</label>
                        <div class="as-field-val">{{ $certificate->class->academicYear->name ?? '—' }}</div>
                    </div>
                    <div class="as-field">
                        <label>Section</label>
                        <div class="as-field-val">{{ $certificate->class->level->section->name ?? '—' }}</div>
                    </div>
                </div>

                <div class="as-divider"></div>

                <div class="as-grid">
                    <div class="as-field">
                        <label>Certificate No.</label>
                        <div class="as-field-val mono">{{ $certificate->certificate_no }}</div>
                    </div>
                    <div class="as-field">
                        <label>Verification Code</label>
                        <div class="as-field-val mono">{{ $certificate->verification_code ?? '—' }}</div>
                    </div>
                    <div class="as-field">
                        <label>Grade</label>
                        <div class="as-field-val">{{ $certificate->grade ?? '—' }}</div>
                    </div>
                    <div class="as-field">
                        <label>Average Score</label>
                        <div class="as-field-val">{{ $certificate->percentage !== null ? number_format((float)$certificate->percentage, 1).'%' : '—' }}</div>
                    </div>
                    <div class="as-field">
                        <label>Issued Date</label>
                        <div class="as-field-val">{{ $certificate->issued_date ? \Carbon\Carbon::parse($certificate->issued_date)->format('d F Y') : '—' }}</div>
                    </div>
                    <div class="as-field">
                        <label>Type</label>
                        <div class="as-field-val" style="text-transform:capitalize;">{{ str_replace('_',' ', $certificate->type ?? 'class_completion') }}</div>
                    </div>
                </div>

                @if($certificate->status === 'revoked' && $certificate->revoked_reason)
                    <div class="as-revoke-box">
                        <i class="fas fa-ban"></i> <strong>Revocation Reason:</strong> {{ $certificate->revoked_reason }}
                    </div>
                @endif

                @if($certificate->verification_code)
                    <div style="margin-top:18px;padding:14px 16px;background:#F5F3FD;border:1px solid var(--purple-light);border-radius:12px;font-size:.8rem;color:var(--muted);">
                        <i class="fas fa-qrcode" style="color:var(--purple);"></i>&nbsp;
                        Verify at:
                        <a href="{{ route('certificates.verify', ['code' => $certificate->verification_code]) }}" target="_blank"
                           style="color:var(--purple);font-weight:600;">
                            {{ route('certificates.verify', ['code' => $certificate->verification_code]) }}
                        </a>
                    </div>
                @endif
            </div>

            <div class="as-actions">
                <a href="{{ route('admin.certificates.download', $certificate->id) }}" class="as-btn as-btn-primary">
                    <i class="fas fa-download"></i> Download PDF
                </a>
                <a href="{{ route('student.certificates.preview', $certificate->class_id) }}" class="as-btn as-btn-outline" target="_blank">
                    <i class="fas fa-eye"></i> Preview Certificate
                </a>
                @if($certificate->status === 'issued')
                    <button onclick="document.getElementById('revokeModal').classList.add('open')" class="as-btn as-btn-danger">
                        <i class="fas fa-ban"></i> Revoke
                    </button>
                @else
                    <form method="POST" action="{{ route('admin.certificates.reissue', $certificate->id) }}" style="display:inline">
                        @csrf
                        <button type="submit" class="as-btn as-btn-success">
                            <i class="fas fa-redo"></i> Re-issue Certificate
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    {{-- Revoke Modal --}}
    <div class="as-modal-bg" id="revokeModal">
        <div class="as-modal">
            <h3><i class="fas fa-ban" style="color:var(--red);margin-right:8px;"></i> Revoke Certificate</h3>
            <p style="font-size:.83rem;color:var(--muted);margin-bottom:12px;">
                This will mark <strong>{{ $certificate->certificate_no }}</strong> as revoked.<br>
                You can re-issue it later if needed.
            </p>
            <form method="POST" action="{{ route('admin.certificates.revoke', $certificate->id) }}">
                @csrf
                <textarea name="reason" placeholder="Reason for revocation (optional)…"></textarea>
                <div class="as-modal-actions">
                    <button type="button" onclick="document.getElementById('revokeModal').classList.remove('open')"
                            class="as-btn as-btn-outline">Cancel</button>
                    <button type="submit" class="as-btn" style="background:var(--red);color:#fff;">
                        <i class="fas fa-ban"></i> Confirm Revoke
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('revokeModal').addEventListener('click', function (e) {
            if (e.target === this) this.classList.remove('open');
        });
    </script>
@endsection
