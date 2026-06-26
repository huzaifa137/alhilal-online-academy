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
            --border: #E3E0F0; --surface: #fff; --bg: #F5F3FD;
            --radius: 16px; --shadow: 0 4px 20px rgba(107,70,193,.10);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        .ac-wrap { font-family: 'DM Sans', sans-serif; color: var(--ink); padding: 32px 36px 60px; }
        /* Header */
        .ac-header { display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 16px; margin-bottom: 28px; }
        .ac-eyebrow { font-size: .7rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: var(--purple); margin-bottom: 5px; }
        .ac-title { font-family: 'Playfair Display', serif; font-size: 1.9rem; font-weight: 800; color: var(--ink); }
        .ac-title em { font-style: italic; color: var(--purple); }
        /* Stats */
        .ac-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; margin-bottom: 28px; }
        .ac-stat { background: var(--surface); border: 1.5px solid var(--border); border-radius: var(--radius); padding: 20px 22px; }
        .ac-stat-num { font-family: 'Playfair Display', serif; font-size: 2rem; color: var(--purple); }
        .ac-stat-num.gold { color: var(--gold); }
        .ac-stat-num.red  { color: var(--red); }
        .ac-stat-label { font-size: .72rem; font-weight: 600; color: var(--muted); text-transform: uppercase; letter-spacing: .06em; margin-top: 4px; }
        /* Filters */
        .ac-filters { background: var(--surface); border: 1.5px solid var(--border); border-radius: var(--radius); padding: 20px 22px; margin-bottom: 24px; display: flex; gap: 12px; flex-wrap: wrap; align-items: flex-end; }
        .ac-filter-group { display: flex; flex-direction: column; gap: 5px; min-width: 0; }
        .ac-filter-group label { font-size: .7rem; font-weight: 600; color: var(--muted); text-transform: uppercase; letter-spacing: .06em; }
        .ac-filter-group input, .ac-filter-group select {
            border: 1.5px solid var(--border); border-radius: 10px; padding: 8px 12px; font-size: .82rem;
            color: var(--ink); background: var(--bg); min-width: 160px;
        }
        .ac-filter-group input:focus, .ac-filter-group select:focus { outline: none; border-color: var(--purple); }
        .ac-btn { display: inline-flex; align-items: center; gap: 7px; padding: 9px 18px; border-radius: 999px; font-size: .77rem; font-weight: 600; border: none; cursor: pointer; transition: all .2s; text-decoration: none; }
        .ac-btn-primary { background: var(--purple); color: #fff; }
        .ac-btn-primary:hover { background: var(--purple-dark); color: #fff; transform: translateY(-1px); }
        .ac-btn-outline { background: #fff; color: var(--purple); border: 1.5px solid var(--purple); }
        .ac-btn-outline:hover { background: var(--purple-light); }
        .ac-btn-danger { background: #fff; color: var(--red); border: 1.5px solid var(--red); }
        .ac-btn-danger:hover { background: var(--red-light); }
        .ac-btn-success { background: #fff; color: var(--green); border: 1.5px solid var(--green); }
        .ac-btn-success:hover { background: var(--green-light); }
        /* Table */
        .ac-table-wrap { background: var(--surface); border: 1.5px solid var(--border); border-radius: var(--radius); overflow: hidden; box-shadow: var(--shadow); }
        .ac-table { width: 100%; border-collapse: collapse; }
        .ac-table th { background: var(--purple); color: #fff; padding: 13px 16px; font-size: .72rem; font-weight: 600; text-transform: uppercase; letter-spacing: .06em; text-align: left; }
        .ac-table td { padding: 13px 16px; border-bottom: 1px solid var(--border); font-size: .83rem; vertical-align: middle; }
        .ac-table tr:last-child td { border-bottom: none; }
        .ac-table tr:hover td { background: #FAF8FF; }
        .ac-badge { padding: 4px 12px; border-radius: 999px; font-size: .68rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; }
        .ac-badge-green { background: var(--green-light); color: var(--green); }
        .ac-badge-red   { background: var(--red-light);   color: var(--red); }
        .ac-badge-gold  { background: var(--gold-light);  color: var(--gold); }
        .ac-name { font-weight: 600; color: var(--ink); }
        .ac-sub  { font-size: .72rem; color: var(--muted); margin-top: 2px; }
        .ac-cert-no { font-family: monospace; font-size: .76rem; color: var(--purple-dark); }
        /* Paginator */
        .ac-paginator { padding: 16px 20px; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border); flex-wrap: wrap; gap: 10px; }
        /* Flash */
        .ac-flash { border-radius: 12px; padding: 13px 18px; margin-bottom: 20px; font-size: .84rem; }
        .ac-flash-success { background: var(--green-light); border: 1px solid var(--green); color: #065F46; }
        .ac-flash-fail    { background: var(--red-light);   border: 1px solid var(--red);   color: #9B1C1C; }
        /* Revoke modal */
        .ac-modal-bg { display:none; position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:9999; align-items:center; justify-content:center; }
        .ac-modal-bg.open { display:flex; }
        .ac-modal { background:#fff; border-radius:20px; padding:28px 32px; max-width:420px; width:100%; box-shadow:0 20px 60px rgba(0,0,0,.2); }
        .ac-modal h3 { font-family:'Playfair Display',serif; font-size:1.2rem; margin-bottom:12px; color:var(--ink); }
        .ac-modal textarea { width:100%; border:1.5px solid var(--border); border-radius:10px; padding:10px 12px; font-size:.83rem; resize:vertical; min-height:80px; }
        .ac-modal textarea:focus { outline:none; border-color:var(--red); }
        .ac-modal-actions { display:flex; justify-content:flex-end; gap:10px; margin-top:16px; }
        @media(max-width:768px){.ac-stats{grid-template-columns:1fr 1fr;}.ac-wrap{padding:20px 16px 40px;}}
    </style>

    <div class="ac-wrap">

        {{-- Header --}}
        <div class="ac-header">
            <div>
                <div class="ac-eyebrow"><i class="fas fa-certificate"></i> Management</div>
                <h1 class="ac-title">Student <em>Certificates</em></h1>
            </div>
        </div>

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="ac-flash ac-flash-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('fail'))
            <div class="ac-flash ac-flash-fail"><i class="fas fa-exclamation-triangle"></i> {{ session('fail') }}</div>
        @endif

        {{-- Stats --}}
        <div class="ac-stats">
            <div class="ac-stat">
                <div class="ac-stat-num">{{ $stats['total'] }}</div>
                <div class="ac-stat-label">Total Certificates</div>
            </div>
            <div class="ac-stat">
                <div class="ac-stat-num gold">{{ $stats['issued'] }}</div>
                <div class="ac-stat-label">Issued (Active)</div>
            </div>
            <div class="ac-stat">
                <div class="ac-stat-num red">{{ $stats['revoked'] }}</div>
                <div class="ac-stat-label">Revoked</div>
            </div>
        </div>

        {{-- Filters --}}
        <form method="GET" action="{{ route('admin.certificates.index') }}">
            <div class="ac-filters">
                <div class="ac-filter-group" style="flex:1; min-width:180px;">
                    <label>Search</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Name, cert no, code…">
                </div>
                <div class="ac-filter-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="">All Statuses</option>
                        <option value="issued"  @selected(request('status')=='issued')>Issued</option>
                        <option value="revoked" @selected(request('status')=='revoked')>Revoked</option>
                    </select>
                </div>
                <div class="ac-filter-group">
                    <label>Class</label>
                    <select name="class_id">
                        <option value="">All Classes</option>
                        @foreach($classes as $cls)
                            <option value="{{ $cls->id }}" @selected(request('class_id')==$cls->id)>{{ $cls->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="ac-btn ac-btn-primary" style="align-self:flex-end">
                    <i class="fas fa-search"></i> Filter
                </button>
                @if(request()->hasAny(['search','status','class_id']))
                    <a href="{{ route('admin.certificates.index') }}" class="ac-btn ac-btn-outline" style="align-self:flex-end">
                        <i class="fas fa-times"></i> Clear
                    </a>
                @endif
            </div>
        </form>

        {{-- Table --}}
        <div class="ac-table-wrap">
            <table class="ac-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Class</th>
                        <th>Certificate No.</th>
                        <th>Grade</th>
                        <th>Score</th>
                        <th>Issued</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($certificates as $i => $cert)
                        @php
                            $student     = $cert->student;
                            $studentName = $student->fullname
                                ?? trim(($student->firstname ?? '') . ' ' . ($student->lastname ?? ''))
                                ?: 'Student';
                        @endphp
                        <tr>
                            <td style="color:var(--muted);font-size:.75rem;">{{ $certificates->firstItem() + $i }}</td>
                            <td>
                                <div class="ac-name">{{ $studentName }}</div>
                                <div class="ac-sub">{{ $student->email ?? '' }}</div>
                            </td>
                            <td>
                                <div class="ac-name" style="font-size:.83rem;">{{ $cert->class->name ?? '—' }}</div>
                                @if($cert->class->level)
                                    <div class="ac-sub">{{ $cert->class->level->name }}</div>
                                @endif
                            </td>
                            <td><span class="ac-cert-no">{{ $cert->certificate_no }}</span></td>
                            <td>
                                @if($cert->grade)
                                    <span class="ac-badge ac-badge-gold"><i class="fas fa-star"></i> {{ $cert->grade }}</span>
                                @else
                                    <span style="color:var(--muted);font-size:.75rem;">—</span>
                                @endif
                            </td>
                            <td>
                                @if($cert->percentage !== null)
                                    <span style="font-weight:600;color:var(--purple);">{{ number_format((float)$cert->percentage, 1) }}%</span>
                                @else
                                    <span style="color:var(--muted);font-size:.75rem;">—</span>
                                @endif
                            </td>
                            <td style="font-size:.78rem;color:var(--muted);">
                                {{ $cert->issued_date ? \Carbon\Carbon::parse($cert->issued_date)->format('d M Y') : '—' }}
                            </td>
                            <td>
                                @if($cert->status === 'issued')
                                    <span class="ac-badge ac-badge-green"><i class="fas fa-check-circle"></i> Issued</span>
                                @else
                                    <span class="ac-badge ac-badge-red"><i class="fas fa-ban"></i> Revoked</span>
                                @endif
                            </td>
                            <td>
                                <div style="display:flex;gap:7px;flex-wrap:wrap;">
                                    <a href="{{ route('admin.certificates.show', $cert->id) }}"
                                       class="ac-btn ac-btn-outline" style="padding:6px 12px;font-size:.7rem;">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a href="{{ route('admin.certificates.download', $cert->id) }}"
                                       class="ac-btn ac-btn-primary" style="padding:6px 12px;font-size:.7rem;">
                                        <i class="fas fa-download"></i> PDF
                                    </a>
                                    @if($cert->status === 'issued')
                                        <button onclick="openRevoke({{ $cert->id }}, '{{ $cert->certificate_no }}')"
                                                class="ac-btn ac-btn-danger" style="padding:6px 12px;font-size:.7rem;">
                                            <i class="fas fa-ban"></i> Revoke
                                        </button>
                                    @else
                                        <form method="POST" action="{{ route('admin.certificates.reissue', $cert->id) }}" style="display:inline">
                                            @csrf
                                            <button type="submit" class="ac-btn ac-btn-success" style="padding:6px 12px;font-size:.7rem;">
                                                <i class="fas fa-redo"></i> Re-issue
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align:center;padding:60px;color:var(--muted);">
                                <i class="fas fa-certificate" style="font-size:2rem;opacity:.3;display:block;margin-bottom:12px;"></i>
                                No certificates found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="ac-paginator">
                <div style="font-size:.78rem;color:var(--muted);">
                    Showing {{ $certificates->firstItem() }}–{{ $certificates->lastItem() }} of {{ $certificates->total() }} certificates
                </div>
                {{ $certificates->links() }}
            </div>
        </div>
    </div>

    {{-- Revoke Modal --}}
    <div class="ac-modal-bg" id="revokeModal">
        <div class="ac-modal">
            <h3><i class="fas fa-ban" style="color:var(--red);margin-right:8px;"></i> Revoke Certificate</h3>
            <p style="font-size:.83rem;color:var(--muted);margin-bottom:12px;">
                You are about to revoke <strong id="revokeCertNo"></strong>.<br>This action can be undone by re-issuing.
            </p>
            <form method="POST" id="revokeForm">
                @csrf
                <textarea name="reason" placeholder="Reason for revocation (optional)…"></textarea>
                <div class="ac-modal-actions">
                    <button type="button" onclick="closeRevoke()" class="ac-btn ac-btn-outline">Cancel</button>
                    <button type="submit" class="ac-btn" style="background:var(--red);color:#fff;">
                        <i class="fas fa-ban"></i> Confirm Revoke
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRevoke(id, certNo) {
            document.getElementById('revokeCertNo').textContent = certNo;
            document.getElementById('revokeForm').action = `/admin/certificates/${id}/revoke`;
            document.getElementById('revokeModal').classList.add('open');
        }
        function closeRevoke() {
            document.getElementById('revokeModal').classList.remove('open');
        }
        document.getElementById('revokeModal').addEventListener('click', function (e) {
            if (e.target === this) closeRevoke();
        });
    </script>
@endsection
