@extends('Student.layouts.sidebar')

@section('main-content')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
:root{--c-bg:#F0EEF8;--c-surface:#FFFFFF;--c-surface2:#F7F6FB;--c-border:#E3E0F0;--c-ink:#1A1628;--c-muted:#7C748E;--c-accent:#6B46C1;--c-accent-lt:#EDE9FA;--c-emerald:#059669;--c-green-lt:#D1FAE5;--c-red:#DC2626;--c-red-lt:#FEE2E2;--c-gold:#D97706;--c-gold-lt:#FEF3C7;--radius-lg:18px;--radius-xl:24px;--radius-pill:999px;--shadow-sm:0 1px 3px rgba(107,70,193,.07);--shadow-md:0 4px 16px rgba(107,70,193,.10);--shadow-lg:0 12px 40px rgba(107,70,193,.14);--gradient:linear-gradient(135deg,#6B46C1 0%,#8B5CF6 100%)}
*{margin:0;padding:0;box-sizing:border-box}
body{background:var(--c-bg);font-family:'DM Sans',sans-serif}
.en-wrap{width:100%;font-family:'DM Sans',sans-serif;color:var(--c-ink)}
.en-header{display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:32px;flex-wrap:wrap;gap:16px}
.en-eyebrow{font-size:.72rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--c-accent);margin-bottom:6px}
.en-title{font-family:'DM Serif Display',Georgia,serif;font-size:2rem;font-weight:400;color:var(--c-ink);line-height:1.15;margin:0}
.en-title em{font-style:italic;color:var(--c-accent)}
.en-subtitle{margin-top:6px;font-size:.83rem;color:var(--c-muted)}
.en-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-bottom:32px}
.en-stat{background:var(--c-surface);border:1.5px solid var(--c-border);border-radius:var(--radius-lg);padding:20px;transition:all .22s}
.en-stat:hover{transform:translateY(-2px);border-color:var(--c-accent);box-shadow:var(--shadow-md)}
.en-stat-icon{width:44px;height:44px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;margin-bottom:14px}
.en-stat-num{font-family:'DM Serif Display',serif;font-size:1.8rem;color:var(--c-ink);line-height:1.1}
.en-stat-label{font-size:.73rem;font-weight:600;color:var(--c-muted);margin-top:5px;text-transform:uppercase;letter-spacing:.06em}
.en-search{position:relative;margin-bottom:28px;max-width:480px}
.en-search input{width:100%;padding:12px 20px 12px 48px;border:1.5px solid var(--c-border);border-radius:var(--radius-pill);font-size:.84rem;font-family:'DM Sans',sans-serif;background:var(--c-surface);transition:all .2s}
.en-search input:focus{outline:none;border-color:var(--c-accent);box-shadow:0 0 0 3px rgba(107,70,193,.13)}
.en-search i{position:absolute;left:18px;top:50%;transform:translateY(-50%);color:var(--c-muted)}
.en-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
.en-card{background:var(--c-surface);border:1.5px solid var(--c-border);border-radius:var(--radius-xl);overflow:hidden;transition:all .25s;box-shadow:var(--shadow-sm)}
.en-card:hover{transform:translateY(-3px);box-shadow:var(--shadow-md)}
.en-card-header{background:var(--gradient);padding:20px;position:relative}
.en-card-badge{position:absolute;top:12px;right:12px;background:rgba(255,255,255,.2);padding:4px 10px;border-radius:var(--radius-pill);font-size:.65rem;font-weight:600;color:white}
.en-card-badge.enrolled{background:rgba(5,150,105,.9);color:white}
.en-card-icon{width:44px;height:44px;background:rgba(255,255,255,.15);border-radius:12px;display:flex;align-items:center;justify-content:center;color:white;font-size:1.1rem;margin-bottom:12px}
.en-card-name{font-size:1.05rem;font-weight:700;color:white;margin:0 0 4px}
.en-card-level{font-size:.7rem;color:rgba(255,255,255,.8);display:flex;align-items:center;gap:5px}
.en-card-body{padding:18px}
.en-card-subjects{display:flex;flex-wrap:wrap;gap:6px;margin-bottom:16px}
.en-subject-chip{background:var(--c-accent-lt);color:var(--c-accent);padding:3px 10px;border-radius:var(--radius-pill);font-size:.65rem;font-weight:600}
.en-card-meta{display:flex;gap:12px;font-size:.7rem;color:var(--c-muted);margin-bottom:16px;flex-wrap:wrap}
.en-card-meta-item{display:flex;align-items:center;gap:4px}
.en-card-footer{padding:0 18px 18px}
.en-btn-enroll{width:100%;padding:11px;background:var(--gradient);color:white;border:none;border-radius:var(--radius-pill);font-family:'DM Sans',sans-serif;font-size:.82rem;font-weight:600;cursor:pointer;transition:all .2s;display:flex;align-items:center;justify-content:center;gap:8px}
.en-btn-enroll:hover{opacity:.9;transform:translateY(-1px);box-shadow:0 6px 20px rgba(107,70,193,.32)}
.en-btn-enroll:disabled,.en-btn-enrolled{width:100%;padding:11px;background:var(--c-green-lt);color:var(--c-emerald);border:1.5px solid var(--c-emerald);border-radius:var(--radius-pill);font-size:.82rem;font-weight:600;cursor:default;display:flex;align-items:center;justify-content:center;gap:8px}
.en-empty{text-align:center;padding:72px 40px;background:var(--c-surface);border-radius:var(--radius-xl);border:1.5px solid var(--c-border)}
@media(max-width:1100px){.en-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:700px){.en-grid{grid-template-columns:1fr}.en-stats{grid-template-columns:repeat(2,1fr)}}
</style>

<div class="en-wrap">
    <div class="en-header">
        <div>
            <div class="en-eyebrow"><i class="fas fa-school"></i> Class Enrollment</div>
            <h1 class="en-title">Browse <em>Available Classes</em></h1>
            <div class="en-subtitle">Enroll yourself in a class to start learning</div>
        </div>
        <a href="{{ route('student.lessons.lists') }}" style="display:inline-flex;align-items:center;gap:8px;background:var(--c-surface);color:var(--c-accent);border:1.5px solid var(--c-accent);padding:9px 20px;border-radius:var(--radius-pill);font-size:.82rem;font-weight:600;text-decoration:none;transition:all .2s;">
            <i class="fas fa-book-open"></i> My Lessons
        </a>
    </div>

    <div class="en-stats">
        <div class="en-stat">
            <div class="en-stat-icon" style="background:var(--c-accent-lt);color:var(--c-accent)"><i class="fas fa-chalkboard"></i></div>
            <div class="en-stat-num">{{ $classes->count() }}</div>
            <div class="en-stat-label">Available Classes</div>
        </div>
        <div class="en-stat">
            <div class="en-stat-icon" style="background:var(--c-green-lt);color:var(--c-emerald)"><i class="fas fa-check-circle"></i></div>
            <div class="en-stat-num">{{ count($enrolledClassIds) }}</div>
            <div class="en-stat-label">Enrolled In</div>
        </div>
        <div class="en-stat">
            <div class="en-stat-icon" style="background:var(--c-gold-lt);color:var(--c-gold)"><i class="fas fa-book"></i></div>
            <div class="en-stat-num">{{ $classes->count() - count($enrolledClassIds) }}</div>
            <div class="en-stat-label">Available to Join</div>
        </div>
    </div>

    <div class="en-search">
        <i class="fas fa-search"></i>
        <input type="text" id="classSearch" placeholder="Search classes by name or level...">
    </div>

    @if($classes->count() > 0)
    <div class="en-grid" id="classGrid">
        @foreach($classes as $class)
        @php $isEnrolled = in_array($class->id, $enrolledClassIds); @endphp
        <div class="en-card" data-classname="{{ strtolower($class->name . ' ' . ($class->level->name ?? '')) }}">
            <div class="en-card-header">
                @if($isEnrolled)
                    <span class="en-card-badge enrolled"><i class="fas fa-check"></i> Enrolled</span>
                @else
                    <span class="en-card-badge"><i class="fas fa-lock-open"></i> Open</span>
                @endif
                <div class="en-card-icon"><i class="fas fa-chalkboard"></i></div>
                <div class="en-card-name">{{ $class->name }}</div>
                <div class="en-card-level">
                    <i class="fas fa-graduation-cap"></i>
                    {{ $class->level->name ?? 'General' }}
                    @if($class->level->section)
                        · {{ $class->level->section->name }}
                    @endif
                </div>
            </div>
            <div class="en-card-body">
                @if($class->subjects && $class->subjects->count() > 0)
                <div class="en-card-subjects">
                    @foreach($class->subjects->take(4) as $subject)
                        <span class="en-subject-chip">{{ $subject->name }}</span>
                    @endforeach
                    @if($class->subjects->count() > 4)
                        <span class="en-subject-chip">+{{ $class->subjects->count() - 4 }} more</span>
                    @endif
                </div>
                @endif
                <div class="en-card-meta">
                    <span class="en-card-meta-item"><i class="fas fa-book"></i> {{ $class->subjects->count() }} Subjects</span>
                    @if($class->capacity)
                    <span class="en-card-meta-item"><i class="fas fa-users"></i> Cap: {{ $class->capacity }}</span>
                    @endif
                    @if($class->room_number)
                    <span class="en-card-meta-item"><i class="fas fa-door-open"></i> Room {{ $class->room_number }}</span>
                    @endif
                </div>
            </div>
            <div class="en-card-footer">
                @if($isEnrolled)
                    <div class="en-btn-enrolled">
                        <i class="fas fa-check-circle"></i> Already Enrolled
                    </div>
                @else
                    <button class="en-btn-enroll" onclick="enrollInClass({{ $class->id }}, '{{ addslashes($class->name) }}', this)">
                        <i class="fas fa-plus-circle"></i> Enroll Now
                    </button>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="en-empty">
        <div style="width:72px;height:72px;margin:0 auto 20px;border-radius:50%;background:var(--c-surface2);border:2px dashed var(--c-border);display:flex;align-items:center;justify-content:center;font-size:1.6rem;color:var(--c-muted)"><i class="fas fa-school"></i></div>
        <h3 style="font-size:1.1rem;color:var(--c-ink);margin-bottom:8px">No Classes Available</h3>
        <p style="color:var(--c-muted)">No active classes are available for enrollment at this time. Please check back later.</p>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
async function enrollInClass(classId, className, btn) {
    const result = await Swal.fire({
        title: 'Enroll in Class?',
        html: `<div style="text-align:left;"><p>You are about to enroll in:</p><p style="font-weight:700;font-size:1.05rem;margin-top:8px;color:#6B46C1">${className}</p><p style="margin-top:8px;font-size:.85rem;color:#7C748E">You can pay for the class once enrolled.</p></div>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#6B46C1',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Yes, Enroll Me!',
        cancelButtonText: 'Cancel'
    });

    if (!result.isConfirmed) return;

    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enrolling...';

    try {
        const response = await fetch('{{ route("student.enroll") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ class_id: classId })
        });
        const data = await response.json();

        if (data.success) {
            await Swal.fire({
                icon: 'success',
                title: 'Enrolled Successfully!',
                text: data.message,
                confirmButtonColor: '#6B46C1',
                timer: 2500,
                showConfirmButton: false
            });
            location.reload();
        } else {
            Swal.fire({ icon: 'error', title: 'Enrollment Failed', text: data.message, confirmButtonColor: '#DC2626' });
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-plus-circle"></i> Enroll Now';
        }
    } catch (e) {
        Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong. Please try again.', confirmButtonColor: '#DC2626' });
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-plus-circle"></i> Enroll Now';
    }
}

document.getElementById('classSearch').addEventListener('keyup', function() {
    const term = this.value.toLowerCase();
    document.querySelectorAll('.en-card').forEach(card => {
        const name = card.getAttribute('data-classname') || '';
        card.style.display = (!term || name.includes(term)) ? '' : 'none';
    });
});
</script>
@endsection