@extends('Teacher.layouts.teacher-master')

@section('title', 'Upload Study Material')
@section('page-title', 'Upload Study Material')
@section('breadcrumb', 'Study Materials')

@section('content')

    <style>
        .m-wrap { max-width: 1200px; }

        .m-card {
            background: #fff;
            border: 1px solid var(--border, #E3E0F0);
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 4px 16px rgba(91,63,217,.08);
        }

        .m-card-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--purple-dark, #4C2E8A);
            margin-bottom: 4px;
        }

        .m-card-sub { font-size: .82rem; color: var(--muted, #6B6584); margin-bottom: 24px; }

        .fg { margin-bottom: 20px; }
        .fg label { display:block; font-size:.8rem; font-weight:600; color:#1A0A2E; margin-bottom:6px; }
        .fg label span { color:#DC2626; }
        .fg select, .fg input[type=text], .fg textarea {
            width:100%; padding:10px 14px; border:1px solid #E3E0F0; border-radius:10px;
            font-family:'DM Sans',sans-serif; font-size:.85rem; color:#1A0A2E; background:#F7F6FB;
        }
        .fg select:disabled { opacity:.6; }
        .fg-row { display:flex; gap:16px; flex-wrap:wrap; }
        .fg-row .fg { flex:1; min-width:220px; }

        .m-drop {
            border: 2px dashed #C9C2E8;
            border-radius: 14px;
            padding: 28px;
            text-align: center;
            background: #F7F6FB;
            cursor: pointer;
            transition: all .2s;
        }
        .m-drop:hover { border-color:#6B46C1; background:#F0EEFA; }
        .m-drop i { font-size: 2rem; color:#6B46C1; margin-bottom: 8px; display:block; }
        .m-drop .fname { font-size:.8rem; font-weight:600; color:#1A0A2E; margin-top:8px; }

        .m-submit {
            display:inline-flex; align-items:center; gap:8px;
            padding: 12px 28px; border:none; border-radius:40px;
            background: linear-gradient(135deg,#6B46C1,#DC2626); color:#fff;
            font-weight:600; font-size:.9rem; cursor:pointer; font-family:'DM Sans',sans-serif;
        }
        .m-submit:disabled { opacity:.6; cursor:not-allowed; }

        .m-back {
            display:inline-flex; align-items:center; gap:6px; margin-bottom:18px;
            font-size:.8rem; font-weight:600; color:#6B46C1; text-decoration:none;
        }
    </style>

    <div class="m-wrap">
        <a href="{{ route('teacher.materials.index') }}" class="m-back"><i class="fas fa-arrow-left"></i> Back to Study Materials</a>

        <div class="m-card">
            <div class="m-card-title"><i class="fas fa-file-pdf" style="color:#DC2626"></i> Upload a PDF</div>
            <div class="m-card-sub">This PDF will appear under the chosen subject, for every student enrolled and paid up in that class.</div>

            <form id="materialForm">
                @csrf
                <div class="fg-row">
                    <div class="fg">
                        <label><i class="fas fa-chalkboard"></i> Class <span>*</span></label>
                        <select id="classSelect" required>
                            <option value="">-- Select a class --</option>
                        </select>
                    </div>
                    <div class="fg">
                        <label><i class="fas fa-book"></i> Subject <span>*</span></label>
                        <select id="subjectSelect" required disabled>
                            <option value="">-- First select a class --</option>
                        </select>
                    </div>
                </div>

                <div class="fg">
                    <label>Title <span>*</span></label>
                    <input type="text" id="titleInput" placeholder="e.g. Tajweed Revision Pack" required>
                </div>

                <div class="fg">
                    <label>Description (optional)</label>
                    <textarea id="descInput" rows="3" placeholder="Short note about what this PDF covers..."></textarea>
                </div>

                <div class="fg">
                    <label><i class="fas fa-coins"></i> Price (UGX, optional)</label>
                    <input type="text" id="amountInput" placeholder="Leave blank if free" inputmode="numeric">
                    <div style="font-size:.72rem;color:var(--muted,#6B6584);margin-top:6px;">
                        If set, students must pay this amount before they can open the PDF — same as lesson payments.
                        Leave blank for a free material.
                    </div>
                </div>

                <div class="fg">
                    <label>PDF File <span>*</span></label>
                    <div class="m-drop" onclick="document.getElementById('fileInput').click()">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <div>Click to choose a PDF (max 50MB)</div>
                        <div class="fname" id="fileName"></div>
                    </div>
                    <input type="file" id="fileInput" accept="application/pdf" style="display:none" required>
                </div>

                <button type="submit" class="m-submit" id="submitBtn">
                    <i class="fas fa-upload"></i> Upload PDF
                </button>
            </form>
        </div>
    </div>

@endsection


@section('js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let currentClassId = null;

        function loadClasses() {
            $.get('{{ route("teacher.lessons.classes.list") }}')
                .done(function (data) {
                    const $classSelect = $('#classSelect');
                    $classSelect.html('<option value="">-- Select a class --</option>');
                    (data.classes || []).forEach(cls => {
                        const levelName = cls.level?.name || 'N/A';
                        $classSelect.append(`<option value="${cls.id}">${cls.name} (${levelName})</option>`);
                    });
                })
                .fail(function () {
                    Swal.fire('Error', 'Failed to load classes.', 'error');
                });
        }

        $('#classSelect').on('change', function () {
            const classId = $(this).val();
            currentClassId = classId;
            const $subjectSelect = $('#subjectSelect');

            if (!classId) {
                $subjectSelect.html('<option value="">-- First select a class --</option>').prop('disabled', true);
                return;
            }

            $subjectSelect.html('<option value="">Loading subjects...</option>').prop('disabled', true);

            $.get(`/teacher/lessons/classes/${classId}/subjects`)
                .done(function (data) {
                    $subjectSelect.html('<option value="">-- Select a subject --</option>');
                    (data.subjects || []).forEach(subject => {
                        $subjectSelect.append(`<option value="${subject.id}">${subject.name}${subject.code ? ' (' + subject.code + ')' : ''}</option>`);
                    });
                    $subjectSelect.prop('disabled', false);
                })
                .fail(function () {
                    $subjectSelect.html('<option value="">Error loading subjects</option>');
                    Swal.fire('Error', 'Failed to load subjects for this class.', 'error');
                });
        });

        $('#fileInput').on('change', function () {
            $('#fileName').text(this.files[0] ? this.files[0].name : '');
        });

        $('#materialForm').on('submit', function (e) {
            e.preventDefault();

            const classId = $('#classSelect').val();
            const subjectId = $('#subjectSelect').val();
            const title = $('#titleInput').val().trim();
            const file = $('#fileInput')[0].files[0];

            if (!classId || !subjectId || !title || !file) {
                Swal.fire('Missing info', 'Please fill in the class, subject, title, and choose a PDF file.', 'warning');
                return;
            }

            const $btn = $('#submitBtn');
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Uploading...');

            const formData = new FormData();
            formData.append('class_id', classId);
            formData.append('subject_id', subjectId);
            formData.append('title', title);
            formData.append('description', $('#descInput').val());
            formData.append('amount', $('#amountInput').val().replace(/[^0-9.]/g, ''));
            formData.append('file', file);

            $.ajax({
                url: '{{ route("teacher.materials.store") }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: { 'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content') },
                success: function (data) {
                    Swal.fire('Uploaded!', data.message, 'success').then(() => {
                        window.location.href = '{{ route("teacher.materials.index") }}';
                    });
                },
                error: function (xhr) {
                    console.error('Upload failed:', xhr.status, xhr.responseText);

                    let errorMsg = `Status ${xhr.status}`;

                    if (xhr.responseJSON) {
                        // Laravel validation errors (422) or JSON error responses
                        const data = xhr.responseJSON;
                        if (data.message) {
                            errorMsg = data.message;
                        }
                        if (data.errors) {
                            errorMsg = Object.values(data.errors).flat().join('\n');
                        }
                    } else if (xhr.responseText) {
                        // Raw HTML/text error (e.g. Laravel debug page on 500)
                        // Try to pull just the exception message out of the debug HTML
                        const match = xhr.responseText.match(/<title>(.*?)<\/title>/is);
                        errorMsg = match ? match[1] : xhr.responseText.substring(0, 500);
                    }

                    Swal.fire({
                        title: `Upload Error (${xhr.status})`,
                        html: `<pre style="text-align:left;white-space:pre-wrap;font-size:.75rem;max-height:300px;overflow:auto;">${$('<div>').text(errorMsg).html()}</pre>`,
                        icon: 'error',
                        width: 600
                    });
                },
                complete: function () {
                    $btn.prop('disabled', false).html('<i class="fas fa-upload"></i> Upload PDF');
                }
            });
        });

        loadClasses();
    </script>
@endsection