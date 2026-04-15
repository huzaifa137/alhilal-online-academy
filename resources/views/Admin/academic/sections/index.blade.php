@extends('Admin.layouts.admin-master')

@section('title', 'Sections Management')
@section('page-title', 'Academic Sections')
@section('breadcrumb', 'Sections')

@section('content')
<div class="card">
    <div class="card-head">
        <div class="card-head-left">
            <div class="card-head-title">Academic Sections</div>
            <div class="card-head-sub">Manage Primary, Idaad, and Thanawi sections</div>
        </div>
        <div class="card-head-right">
            <a href="{{ url('admin.sections.create') }}" class="btn-action bta-primary">
                <i class="fas fa-plus"></i> Add Section
            </a>
        </div>
    </div>
    
    <div class="card-body">
        @if(session('success'))
            <div style="padding: 12px 16px; background: var(--green-light); color: var(--green); border-radius: 12px; margin-bottom: 20px;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div style="padding: 12px 16px; background: var(--red-light); color: var(--red); border-radius: 12px; margin-bottom: 20px;">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif
        
        <div class="grid-3">
            @forelse($sections as $section)
                <div class="kpi-card" style="cursor: default;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                        <div style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;
                            @if($section->code === 'PRIM') 
                                background: var(--purple-light); color: var(--purple);
                            @elseif($section->code === 'IDAD')
                                background: var(--gold-light); color: var(--gold);
                            @else
                                background: var(--red-light); color: var(--red);
                            @endif
                        ">
                            @if($section->code === 'PRIM')
                                <i class="fas fa-child"></i>
                            @elseif($section->code === 'IDAD')
                                <i class="fas fa-user-graduate"></i>
                            @else
                                <i class="fas fa-user-tie"></i>
                            @endif
                        </div>
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <h3 style="font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 700; color: var(--ink);">{{ $section->name }}</h3>
                                <span style="padding: 3px 8px; border-radius: 20px; font-size: 0.65rem; font-weight: 600; text-transform: uppercase;
                                    @if($section->status === 'active')
                                        background: var(--green-light); color: var(--green);
                                    @else
                                        background: var(--red-light); color: var(--red);
                                    @endif
                                ">
                                    <i class="fas fa-circle" style="font-size: 5px;"></i> {{ ucfirst($section->status) }}
                                </span>
                            </div>
                            <div style="font-family: 'DM Mono', monospace; font-size: 0.75rem; color: var(--muted);">{{ $section->code }}</div>
                        </div>
                    </div>
                    
                    @if($section->description)
                        <p style="font-size: 0.8rem; color: var(--muted); margin-bottom: 16px; line-height: 1.5;">
                            {{ Str::limit($section->description, 100) }}
                        </p>
                    @endif
                    
                    <div style="display: flex; gap: 16px; padding: 12px 0; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); margin-bottom: 16px;">
                        <div style="text-align: center; flex: 1;">
                            <div style="font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 700; color: var(--ink);">{{ $section->levels_count ?? 0 }}</div>
                            <div style="font-size: 0.65rem; color: var(--muted); text-transform: uppercase;">Levels</div>
                        </div>
                        <div style="text-align: center; flex: 1;">
                            <div style="font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 700; color: var(--ink);">{{ $section->classes_count ?? 0 }}</div>
                            <div style="font-size: 0.65rem; color: var(--muted); text-transform: uppercase;">Classes</div>
                        </div>
                        <div style="text-align: center; flex: 1;">
                            <div style="font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 700; color: var(--ink);">{{ $section->students_count ?? 0 }}</div>
                            <div style="font-size: 0.65rem; color: var(--muted); text-transform: uppercase;">Students</div>
                        </div>
                    </div>
                    
                    <div class="cmd-strip" style="gap: 6px;">
                        <a href="{{ url('admin.levels.index', ['section' => $section->id]) }}" class="cmd-btn" style="flex: 1; justify-content: center; padding: 8px 12px;">
                            <i class="fas fa-layer-group"></i> Levels
                        </a>
                        <a href="{{ url('admin.sections.edit', $section) }}" class="cmd-btn" style="flex: 1; justify-content: center; padding: 8px 12px;">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <button onclick="toggleSectionStatus({{ $section->id }})" class="cmd-btn" style="padding: 8px 12px;" title="Toggle Status">
                            <i class="fas fa-power-off"></i>
                        </button>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 40px; background: white; border-radius: var(--radius-lg); border: 1px dashed var(--border2);">
                    <i class="fas fa-layer-group" style="font-size: 3rem; color: var(--muted2); margin-bottom: 16px; opacity: 0.4;"></i>
                    <h3 style="font-family: 'Playfair Display', serif; font-size: 1.2rem; color: var(--ink); margin-bottom: 8px;">No Sections Found</h3>
                    <p style="color: var(--muted); margin-bottom: 20px;">Get started by creating your first academic section</p>
                    <a href="{{ url('admin.sections.create') }}" class="btn-action bta-primary">
                        <i class="fas fa-plus"></i> Create First Section
                    </a>
                </div>
            @endforelse
        </div>
        
        @if($sections->hasPages())
            <div style="margin-top: 24px;">
                {{ $sections->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@section('js')
<script>
    function toggleSectionStatus(sectionId) {
        fetch(`/admin/sections/${sectionId}/toggle-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            alert('Failed to update status. Please try again.');
        });
    }
</script>
@endsection