{{-- Small pill showing the teaching language. Usage: @include('partials.content-language-badge', ['code' => $lesson->language]) --}}
<span class="content-lang-badge" title="{{ \App\Support\ContentLanguage::native($code ?? null) }}"
    style="display:inline-block;padding:1px 7px;margin-left:6px;border-radius:10px;font-size:10px;font-weight:700;letter-spacing:.4px;background:#e0f2fe;color:#075985;vertical-align:middle;">{{ \App\Support\ContentLanguage::short($code ?? null) }}</span>
