{{--
    Teaching-language dropdown for lessons, study materials and class quizzes.
    Usage: @include('partials.content-language-select', ['name' => 'language', 'id' => 'language', 'selected' => null])
--}}
@php
    $clName = $name ?? 'language';
    $clId = $id ?? $clName;
    $clSelected = $selected ?? null;
@endphp
<select name="{{ $clName }}" id="{{ $clId }}" required>
    <option value="">-- Select teaching language --</option>
    @foreach(config('languages.supported', []) as $clCode => $clMeta)
        <option value="{{ $clCode }}" {{ $clSelected === $clCode ? 'selected' : '' }}>
            {{ $clMeta['name'] }}{{ $clMeta['native'] !== $clMeta['name'] ? ' (' . $clMeta['native'] . ')' : '' }}
        </option>
    @endforeach
</select>
