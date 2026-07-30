@extends('Teacher.layouts.teacher-master')

@section('title', 'Study Materials')
@section('page-title', 'Study Materials')
@section('breadcrumb', 'Study Materials')

@section('content')

    <style>
        .m-head { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
        .m-add-btn {
            display:inline-flex; align-items:center; gap:8px;
            padding: 11px 22px; border:none; border-radius:40px;
            background: linear-gradient(135deg,#6B46C1,#DC2626); color:#fff;
            font-weight:600; font-size:.85rem; text-decoration:none;
        }
        .m-table-wrap {
            background:#fff; border:1px solid #E3E0F0; border-radius:18px; overflow:hidden;
        }
        table.m-table { width:100%; border-collapse:collapse; font-size:.85rem; }
        table.m-table th {
            text-align:left; padding:14px 18px; background:#F7F6FB; color:#6B6584;
            font-size:.72rem; text-transform:uppercase; letter-spacing:.05em; font-weight:700;
        }
        table.m-table td { padding:14px 18px; border-top:1px solid #EFEDF7; vertical-align:middle; }
        .m-badge { display:inline-flex; align-items:center; gap:5px; padding:4px 10px; border-radius:20px; font-size:.7rem; font-weight:600; }
        .m-badge.active { background:#D1FAE5; color:#059669; }
        .m-badge.inactive { background:#FEE2E2; color:#DC2626; }
        .m-action-btn {
            border:none; background:none; cursor:pointer; color:#6B6584; font-size:.85rem; padding:6px 8px;
        }
        .m-action-btn:hover { color:#6B46C1; }
        .m-empty { text-align:center; padding:60px 20px; color:#6B6584; }
        .m-empty i { font-size:2.5rem; color:#C9C2E8; margin-bottom:12px; display:block; }

        @media (max-width: 768px) {
            .m-table-wrap { overflow-x:auto; }
            table.m-table { min-width:680px; }
        }
    </style>

    <div class="m-head">
        <div style="font-size:.85rem;color:#6B6584;">Manage the PDF materials you've uploaded for your classes and subjects.</div>
        <a href="{{ route('teacher.materials.create') }}" class="m-add-btn"><i class="fas fa-plus"></i> Upload PDF</a>
    </div>

    <div class="m-table-wrap">
        @if($materials->count() > 0)
            <table class="m-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Class</th>
                        <th>Subject</th>
                        <th>Price</th>
                        <th>Size</th>
                        <th>Status</th>
                        <th>Uploaded</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($materials as $material)
                        <tr id="row-{{ $material->id }}">
                            <td><i class="fas fa-file-pdf" style="color:#DC2626;margin-right:6px"></i>{{ $material->title }}</td>
                            <td>{{ $material->class->name ?? '—' }}</td>
                            <td>{{ $material->subject->name ?? '—' }}</td>
                            <td>{{ $material->amount ? 'UGX ' . number_format($material->amount) : 'Free' }}</td>
                            <td>{{ $material->file_size_formatted }}</td>
                            <td>
                                <span class="m-badge {{ $material->status }}" id="badge-{{ $material->id }}">
                                    <i class="fas fa-{{ $material->status === 'active' ? 'check-circle' : 'eye-slash' }}"></i>
                                    {{ ucfirst($material->status) }}
                                </span>
                            </td>
                            <td>{{ $material->created_at->format('d M Y') }}</td>
                            <td style="text-align:right;white-space:nowrap;">
                                <button class="m-action-btn" title="Toggle visibility" onclick="toggleMaterial({{ $material->id }})">
                                    <i class="fas fa-toggle-on"></i>
                                </button>
                                <button class="m-action-btn" title="Delete" onclick="deleteMaterial({{ $material->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="m-empty">
                <i class="fas fa-file-pdf"></i>
                <div style="font-weight:600;color:#1A0A2E;margin-bottom:6px;">No study materials yet</div>
                <div style="margin-bottom:18px;">Upload a PDF and it will show up under the subject for enrolled students.</div>
                <a href="{{ route('teacher.materials.create') }}" class="m-add-btn"><i class="fas fa-plus"></i> Upload your first PDF</a>
            </div>
        @endif
    </div>

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const CSRF = document.querySelector('meta[name=csrf-token]').content;

        async function toggleMaterial(id) {
            try {
                const res = await fetch(`/teacher/materials/${id}/toggle`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': CSRF }
                });
                const data = await res.json();
                if (data.success) {
                    const badge = document.getElementById(`badge-${id}`);
                    badge.className = `m-badge ${data.status}`;
                    badge.innerHTML = `<i class="fas fa-${data.status === 'active' ? 'check-circle' : 'eye-slash'}"></i> ${data.status.charAt(0).toUpperCase() + data.status.slice(1)}`;
                }
            } catch (e) {
                Swal.fire('Error', 'Could not update this material.', 'error');
            }
        }

        async function deleteMaterial(id) {
            const confirm = await Swal.fire({
                title: 'Delete this PDF?',
                text: 'Students will no longer be able to see or download it.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it',
                confirmButtonColor: '#DC2626',
            });
            if (!confirm.isConfirmed) return;

            try {
                const res = await fetch(`/teacher/materials/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': CSRF }
                });
                const data = await res.json();
                if (data.success) {
                    document.getElementById(`row-${id}`).remove();
                } else {
                    Swal.fire('Error', data.message || 'Could not delete.', 'error');
                }
            } catch (e) {
                Swal.fire('Error', 'Could not delete this material.', 'error');
            }
        }
    </script>
@endsection