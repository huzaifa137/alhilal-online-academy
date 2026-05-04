@extends('Admin.layouts.admin-master')

@section('title', 'Levels Management')
@section('page-title', 'Academic Levels')
@section('breadcrumb', 'Levels')

@section('content')
<div class="card">
    <div class="card-head">
        <div class="card-head-left">
            <div class="card-head-title">{{ $section->name }} - Levels</div>
            <div class="card-head-sub">Manage levels for this section</div>
        </div>
        <div class="card-head-right">
            <a href="{{ route('admin.levels.create', ['section' => $section->id]) }}" class="btn-action bta-primary">
                <i class="fas fa-plus"></i> Add Level
            </a>
        </div>
    </div>
    
    <div class="card-body">
        <div class="data-table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Level</th>
                        <th>Code</th>
                        <th>Classes</th>
                        <th>Students</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($levels as $level)
                    <tr>
                        <td>
                            <div class="user-cell">
                                <div class="user-ava ua-1" style="background: var(--purple);">{{ substr($level->code, 0, 2) }}</div>
                                <div>
                                    <div class="user-name">{{ $level->name }}</div>
                                    <div class="user-meta">{{ $level->description ? Str::limit($level->description, 30) : '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="mono">{{ $level->code }}</span></td>
                        <td>{{ $level->classes_count ?? 0 }}</td>
                        <td>{{ $level->students_count ?? 0 }}</td>
                        <td>
                            <span class="badge {{ $level->status === 'active' ? 'badge-active' : 'badge-inactive' }}">
                                <i class="fas fa-circle"></i> {{ ucfirst($level->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="cmd-strip" style="gap: 4px;">
                                <a href="{{ route('admin.classes.index', ['level' => $level->id]) }}" class="cmd-btn" style="padding: 6px 10px;">
                                    <i class="fas fa-chalkboard"></i>
                                </a>
                                <a href="{{ route('admin.levels.edit', $level) }}" class="cmd-btn" style="padding: 6px 10px;">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection