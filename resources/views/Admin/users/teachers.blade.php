@extends('Admin.layouts.admin-master')
@section('title', 'Teachers Management')
@section('page-title', 'Teachers')
@section('breadcrumb', 'Teachers')

@section('content')
    <style>
        .tm-modal-bg { display:none; position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:9999; align-items:center; justify-content:center; padding:20px; }
        .tm-modal-bg.open { display:flex; }
        .tm-modal { background:#fff; border-radius:20px; padding:28px 32px; max-width:480px; width:100%; box-shadow:0 20px 60px rgba(0,0,0,.2); max-height:90vh; overflow-y:auto; }
        .tm-modal h3 { font-family:'Playfair Display',serif; font-size:1.2rem; margin-bottom:18px; color:var(--ink); }
        .tm-form-row { display:flex; gap:12px; margin-bottom:14px; }
        .tm-form-group { flex:1; display:flex; flex-direction:column; gap:5px; }
        .tm-form-group label { font-size:.72rem; font-weight:600; color:var(--muted); text-transform:uppercase; letter-spacing:.05em; }
        .tm-form-group input, .tm-form-group select {
            border:1.5px solid var(--border2); border-radius:10px; padding:9px 12px; font-size:.85rem;
            font-family:'DM Sans',sans-serif; color:var(--ink); outline:none;
        }
        .tm-form-group input:focus, .tm-form-group select:focus { border-color:var(--purple); }
        .tm-form-error { font-size:.7rem; color:var(--red); min-height:14px; }
        .tm-modal-actions { display:flex; justify-content:flex-end; gap:10px; margin-top:18px; }
        .tm-btn { padding:9px 18px; border-radius:999px; font-size:.8rem; font-weight:600; border:none; cursor:pointer; font-family:'DM Sans',sans-serif; }
        .tm-btn-primary { background:var(--gradient); color:#fff; }
        .tm-btn-ghost { background:#F5F3FD; color:var(--muted); }
        .tm-add-btn {
            padding:8px 16px; background:var(--gradient); color:#fff; border:none; border-radius:var(--radius-md);
            cursor:pointer; font-family:'DM Sans',sans-serif; font-size:0.82rem; font-weight:600; display:inline-flex; align-items:center; gap:6px;
        }
        .tm-action-btn { padding:5px 10px; border-radius:var(--radius-sm); font-size:.72rem; font-weight:600; border:none; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; }
        .tm-password-wrap { position:relative; display:flex; align-items:center; }
        .tm-password-wrap input { width:100%; padding-right:36px !important; }
        .tm-password-toggle {
            position:absolute; right:10px; top:50%; transform:translateY(-50%);
            cursor:pointer; color:var(--muted); font-size:.85rem; background:none; border:none; padding:0;
            display:flex; align-items:center; justify-content:center;
        }
        .tm-password-toggle:hover { color:var(--purple); }

        /* Ensure SweetAlert2 always renders above the teacher modal (which uses z-index:9999) */
        .swal2-container { z-index: 10050 !important; }
    </style>

    <div class="card">
        <div class="card-head">
            <div class="card-head-left">
                <div class="card-head-title">All Teachers</div>
                <div class="card-head-sub">{{ $teachers->total() }} educators on the platform</div>
            </div>
            <div class="card-head-right" style="display:flex;gap:10px;align-items:center;">
                <form method="GET" style="display:flex;gap:8px;">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or email…"
                        style="padding:8px 14px;border:1.5px solid var(--border2);border-radius:var(--radius-md);font-family:'DM Sans',sans-serif;font-size:0.82rem;outline:none;width:220px;">
                    <button type="submit"
                        style="padding:8px 16px;background:var(--gradient);color:white;border:none;border-radius:var(--radius-md);cursor:pointer;font-family:'DM Sans',sans-serif;font-size:0.82rem;font-weight:600;">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <button type="button" class="tm-add-btn" onclick="openTeacherModal()">
                    <i class="fas fa-plus"></i> Add Teacher
                </button>
            </div>
        </div>
        <div class="card-body-0">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Teacher</th>
                        <th>Email</th>
                        <th class="text-center">Lessons</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teachers as $i => $teacher)
                        @php
                            $initials = strtoupper(substr($teacher->firstname ?? 'T', 0, 1) . substr($teacher->lastname ?? '', 0, 1));
                            $colors = ['ua-1', 'ua-2', 'ua-3', 'ua-4', 'ua-5', 'ua-6', 'ua-7', 'ua-8'];
                            $ava = $colors[$i % 8];
                            $active = $teacher->account_status == 10;
                            $teacherJson = [
                                'id' => $teacher->id,
                                'firstname' => $teacher->firstname,
                                'lastname' => $teacher->lastname,
                                'username' => $teacher->username,
                                'email' => $teacher->email,
                                'phonenumber' => $teacher->phonenumber,
                                'gender' => $teacher->gender,
                            ];
                        @endphp
                        <tr>
                            <td style="color:var(--muted2);font-size:0.75rem;">{{ $teachers->firstItem() + $i }}</td>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <div style="width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:0.78rem;flex-shrink:0;"
                                        class="{{ $ava }}">{{ $initials }}</div>
                                    <div>
                                        <div style="font-weight:600;font-size:0.84rem;color:var(--ink);">
                                            {{ $teacher->firstname }} {{ $teacher->lastname }}</div>
                                        <div style="font-size:0.7rem;color:var(--muted);">ID: {{ $teacher->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-size:0.82rem;color:var(--muted);">{{ $teacher->email }}</td>
                            <td class="text-center">
                                <span style="font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700;color:var(--purple);">{{ $teacher->lesson_count }}</span>
                            </td>
                            <td><span class="badge {{ $active ? 'badge-active' : 'badge-inactive' }}"><i
                                        class="fas fa-circle"></i> {{ $active ? 'Active' : 'Inactive' }}</span></td>
                            <td style="font-size:0.78rem;color:var(--muted);">{{ $teacher->created_at?->format('d M Y') }}</td>
                            <td class="text-right">
                                <div style="display:flex;gap:6px;justify-content:flex-end;">
                                    <a href="{{ route('admin.teachers.show', $teacher->id) }}"
                                        class="tm-action-btn"
                                        style="background:var(--purple-light);color:var(--purple);"><i
                                            class="fas fa-eye"></i></a>
                                    <button type="button" class="tm-action-btn"
                                        style="background:#DBEAFE;color:#1D4ED8;"
                                        onclick='openTeacherModal(@json($teacherJson))'>
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <form method="POST" action="{{ route('admin.teachers.toggle', $teacher->id) }}"
                                        style="display:inline;">
                                        @csrf
                                        <button type="submit"
                                            style="padding:5px 10px;border-radius:var(--radius-sm);background:{{ $active ? '#fee2e2' : '#d1fae5' }};color:{{ $active ? '#991b1b' : '#065f46' }};font-size:0.72rem;font-weight:600;border:none;cursor:pointer;">
                                            <i class="fas fa-{{ $active ? 'ban' : 'check' }}"></i>
                                        </button>
                                    </form>
                                    <button type="button" class="tm-action-btn"
                                        style="background:#FEE2E2;color:#991B1B;"
                                        onclick="deleteTeacher({{ $teacher->id }}, '{{ addslashes($teacher->firstname . ' ' . $teacher->lastname) }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center;padding:32px;color:var(--muted);">No teachers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if($teachers->hasPages())
                <div style="padding:16px 24px;border-top:1px solid var(--border);">
                    {{ $teachers->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Add / Edit Teacher Modal --}}
    <div class="tm-modal-bg" id="teacherModal">
        <div class="tm-modal">
            <h3 id="teacherModalTitle"><i class="fas fa-chalkboard-teacher"></i> Add Teacher</h3>
            <form id="teacherForm" onsubmit="return submitTeacherForm(event)">
                <input type="hidden" id="tm_id" value="">
                <div class="tm-form-row">
                    <div class="tm-form-group">
                        <label>First Name</label>
                        <input type="text" id="tm_firstname" required>
                        <div class="tm-form-error" id="err_firstname"></div>
                    </div>
                    <div class="tm-form-group">
                        <label>Last Name</label>
                        <input type="text" id="tm_lastname" required>
                        <div class="tm-form-error" id="err_lastname"></div>
                    </div>
                </div>
                <div class="tm-form-row">
                    <div class="tm-form-group">
                        <label>Username</label>
                        <input type="text" id="tm_username" required>
                        <div class="tm-form-error" id="err_username"></div>
                    </div>
                    <div class="tm-form-group">
                        <label>Gender</label>
                        <select id="tm_gender">
                            <option value="">—</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <div class="tm-form-error" id="err_gender"></div>
                    </div>
                </div>
                <div class="tm-form-row">
                    <div class="tm-form-group">
                        <label>Email</label>
                        <input type="email" id="tm_email">
                        <div class="tm-form-error" id="err_email"></div>
                    </div>
                    <div class="tm-form-group">
                        <label>Phone Number</label>
                        <input type="text" id="tm_phonenumber" required>
                        <div class="tm-form-error" id="err_phonenumber"></div>
                    </div>
                </div>
                <div class="tm-form-row">
                    <div class="tm-form-group">
                        <label>Password <span id="tm_pw_hint" style="text-transform:none;font-weight:400;"></span></label>
                        <div class="tm-password-wrap">
                            <input type="password" id="tm_password" autocomplete="new-password">
                            <button type="button" class="tm-password-toggle" onclick="togglePasswordVisibility('tm_password', this)" tabindex="-1">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="tm-form-error" id="err_password"></div>
                    </div>
                    <div class="tm-form-group">
                        <label>Confirm Password</label>
                        <div class="tm-password-wrap">
                            <input type="password" id="tm_password_confirmation" autocomplete="new-password">
                            <button type="button" class="tm-password-toggle" onclick="togglePasswordVisibility('tm_password_confirmation', this)" tabindex="-1">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="tm-modal-actions">
                    <button type="button" class="tm-btn tm-btn-ghost" onclick="closeTeacherModal()">Cancel</button>
                    <button type="submit" class="tm-btn tm-btn-primary" id="tm_submit_btn">Save Teacher</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            icon.classList.toggle('fa-eye', !isHidden);
            icon.classList.toggle('fa-eye-slash', isHidden);
        }

        function openTeacherModal(teacher) {
            document.getElementById('teacherForm').reset();
            document.querySelectorAll('#teacherForm .tm-form-error').forEach(e => e.textContent = '');

            // Always reset password fields back to masked when (re)opening the modal
            document.querySelectorAll('#teacherForm .tm-password-wrap input').forEach(input => input.type = 'password');
            document.querySelectorAll('#teacherForm .tm-password-toggle i').forEach(icon => {
                icon.classList.add('fa-eye');
                icon.classList.remove('fa-eye-slash');
            });

            if (teacher) {
                document.getElementById('teacherModalTitle').innerHTML = '<i class="fas fa-pen"></i> Edit Teacher';
                document.getElementById('tm_id').value = teacher.id;
                document.getElementById('tm_firstname').value = teacher.firstname || '';
                document.getElementById('tm_lastname').value = teacher.lastname || '';
                document.getElementById('tm_username').value = teacher.username || '';
                document.getElementById('tm_email').value = teacher.email || '';
                document.getElementById('tm_phonenumber').value = teacher.phonenumber || '';
                document.getElementById('tm_gender').value = teacher.gender || '';
                document.getElementById('tm_pw_hint').textContent = '(leave blank to keep current password)';
            } else {
                document.getElementById('teacherModalTitle').innerHTML = '<i class="fas fa-chalkboard-teacher"></i> Add Teacher';
                document.getElementById('tm_id').value = '';
                document.getElementById('tm_pw_hint').textContent = '';
            }

            document.getElementById('teacherModal').classList.add('open');
        }

        function closeTeacherModal() {
            document.getElementById('teacherModal').classList.remove('open');
        }

        async function submitTeacherForm(event) {
            event.preventDefault();

            document.querySelectorAll('#teacherForm .tm-form-error').forEach(e => e.textContent = '');

            const id = document.getElementById('tm_id').value;
            const isEdit = !!id;

            const payload = {
                firstname: document.getElementById('tm_firstname').value,
                lastname: document.getElementById('tm_lastname').value,
                username: document.getElementById('tm_username').value,
                email: document.getElementById('tm_email').value,
                phonenumber: document.getElementById('tm_phonenumber').value,
                gender: document.getElementById('tm_gender').value,
                password: document.getElementById('tm_password').value,
                password_confirmation: document.getElementById('tm_password_confirmation').value,
            };

            const url = isEdit
                ? `{{ url('admin/teachers') }}/${id}`
                : `{{ route('admin.teachers.store') }}`;

            const btn = document.getElementById('tm_submit_btn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

            try {
                const response = await fetch(url, {
                    method: isEdit ? 'PUT' : 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(payload)
                });

                const data = await response.json();

                if (response.status === 422 && data.errors) {
                    Object.keys(data.errors).forEach(field => {
                        const el = document.getElementById('err_' + field);
                        if (el) el.textContent = data.errors[field][0];
                    });
                    btn.disabled = false;
                    btn.innerHTML = 'Save Teacher';
                    return false;
                }

                if (data.success) {
                    closeTeacherModal();
                    await Swal.fire({
                        icon: 'success',
                        title: isEdit ? 'Teacher Updated!' : 'Teacher Added!',
                        text: data.message,
                        confirmButtonColor: '#6B46C1',
                        timer: 2200,
                        showConfirmButton: false
                    });
                    location.reload();
                } else {
                    Swal.fire({ icon: 'error', title: 'Something went wrong', text: data.message || 'Please try again.', confirmButtonColor: '#DC2626' });
                    btn.disabled = false;
                    btn.innerHTML = 'Save Teacher';
                }
            } catch (e) {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong. Please try again.', confirmButtonColor: '#DC2626' });
                btn.disabled = false;
                btn.innerHTML = 'Save Teacher';
            }

            return false;
        }

        async function deleteTeacher(id, name) {
            const result = await Swal.fire({
                title: 'Delete Teacher?',
                html: `<div style="text-align:left;">You are about to permanently delete <strong>${name}</strong>. This cannot be undone.</div>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DC2626',
                cancelButtonColor: '#6B46C1',
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel'
            });

            if (!result.isConfirmed) return;

            try {
                const response = await fetch(`{{ url('admin/teachers') }}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                const data = await response.json();

                if (data.success) {
                    await Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: data.message,
                        confirmButtonColor: '#6B46C1',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    location.reload();
                } else {
                    Swal.fire({ icon: 'error', title: 'Delete Failed', text: data.message || 'Please try again.', confirmButtonColor: '#DC2626' });
                }
            } catch (e) {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong. Please try again.', confirmButtonColor: '#DC2626' });
            }
        }
    </script>
@endsection