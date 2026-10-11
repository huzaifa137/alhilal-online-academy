{{--
    Language switcher (English / Arabic / Swahili)

    Inline (inside a header):   @include('partials.language-switcher')
    Floating (top corner):      @include('partials.language-switcher', ['floating' => true])

    Keep one switcher per page. Pages without one get a floating switcher
    automatically (see App\Http\Middleware\TranslateResponse).
--}}
@php
    $lswLanguages = config('languages.supported', []);
    $lswCurrent   = app()->getLocale();
    $lswActive    = $lswLanguages[$lswCurrent] ?? reset($lswLanguages);
    $lswFloating  = $floating ?? false;
@endphp

@once
    <style>
        .lsw { position: relative; display: inline-block; font-family: 'DM Sans', 'Segoe UI', Tahoma, Arial, sans-serif; line-height: 1; z-index: 1190; }
        .lsw--floating { position: fixed; top: 14px; inset-inline-end: 16px; }
        .lsw-btn {
            display: inline-flex; align-items: center; gap: 8px;
            height: 38px; padding: 0 12px;
            background: #fff; color: #4C2E8A;
            border: 1px solid rgba(107, 70, 193, .28); border-radius: 999px;
            font-size: 13px; font-weight: 600; cursor: pointer;
            box-shadow: 0 2px 10px rgba(107, 70, 193, .12);
            transition: background .2s, box-shadow .2s, border-color .2s;
        }
        .lsw-btn:hover, .lsw.is-open .lsw-btn { background: #EDE9FA; border-color: #6B46C1; box-shadow: 0 4px 16px rgba(107, 70, 193, .2); }
        .lsw-btn:focus-visible { outline: 2px solid #6B46C1; outline-offset: 2px; }
        .lsw-btn svg { width: 18px; height: 18px; flex: none; }
        .lsw-caret { width: 12px !important; height: 12px !important; transition: transform .2s; opacity: .7; }
        .lsw.is-open .lsw-caret { transform: rotate(180deg); }
        .lsw-menu {
            position: absolute; top: calc(100% + 8px); inset-inline-end: 0;
            min-width: 190px; padding: 6px; margin: 0; list-style: none;
            background: #fff; border: 1px solid rgba(107, 70, 193, .18); border-radius: 14px;
            box-shadow: 0 16px 40px rgba(26, 10, 46, .18);
            opacity: 0; visibility: hidden; transform: translateY(-6px);
            transition: opacity .18s, transform .18s, visibility .18s;
        }
        .lsw.is-open .lsw-menu { opacity: 1; visibility: visible; transform: translateY(0); }
        .lsw-item {
            display: flex; align-items: center; gap: 10px; padding: 9px 10px;
            border-radius: 10px; color: #1A0A2E !important; text-decoration: none !important;
            font-size: 14px; font-weight: 500; white-space: nowrap;
        }
        .lsw-item:hover { background: #EDE9FA; }
        .lsw-item.is-active { background: linear-gradient(135deg, #EDE9FA, #FEE2E2); font-weight: 700; }
        .lsw-badge {
            display: inline-flex; align-items: center; justify-content: center;
            width: 30px; height: 30px; flex: none; border-radius: 50%;
            background: linear-gradient(135deg, #6B46C1, #DC2626); color: #fff;
            font-size: 11px; font-weight: 700; letter-spacing: .3px;
        }
        .lsw-item .lsw-check { margin-inline-start: auto; width: 16px; height: 16px; color: #6B46C1; }
        @media (max-width: 575px) {
            .lsw-label { display: none; }
            .lsw-btn { padding: 0 10px; }
            .lsw--floating { top: 10px; inset-inline-end: 10px; }
        }
        @media print { .lsw { display: none !important; } }
    </style>
    <script>
        (function () {
            if (window.__lswReady) return;
            window.__lswReady = true;
            document.addEventListener('click', function (e) {
                var btn = e.target.closest ? e.target.closest('.lsw-btn') : null;
                document.querySelectorAll('.lsw.is-open').forEach(function (el) {
                    if (!btn || el !== btn.parentNode) {
                        el.classList.remove('is-open');
                        el.querySelector('.lsw-btn').setAttribute('aria-expanded', 'false');
                    }
                });
                if (btn) {
                    var box = btn.parentNode, open = !box.classList.contains('is-open');
                    box.classList.toggle('is-open', open);
                    btn.setAttribute('aria-expanded', open ? 'true' : 'false');
                }
            });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    document.querySelectorAll('.lsw.is-open').forEach(function (el) {
                        el.classList.remove('is-open');
                        el.querySelector('.lsw-btn').setAttribute('aria-expanded', 'false');
                    });
                }
            });
        })();
    </script>
@endonce

<div class="lsw {{ $lswFloating ? 'lsw--floating' : '' }}" data-lang-switcher>
    <button type="button" class="lsw-btn" aria-haspopup="true" aria-expanded="false" aria-label="Language" title="Language">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
        <span class="lsw-label" lang="{{ $lswCurrent }}">{{ $lswActive['native'] }}</span>
        <svg class="lsw-caret" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
    </button>
    <ul class="lsw-menu" role="menu">
        @foreach ($lswLanguages as $code => $lang)
            <li role="none">
                <a role="menuitem" class="lsw-item {{ $code === $lswCurrent ? 'is-active' : '' }}"
                   href="{{ route('language.switch', $code) }}" hreflang="{{ $code }}" lang="{{ $code }}"
                   @if ($code === $lswCurrent) aria-current="true" @endif>
                    <span class="lsw-badge">{{ $lang['short'] }}</span>
                    <span>{{ $lang['native'] }}</span>
                    @if ($code === $lswCurrent)
                        <svg class="lsw-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                    @endif
                </a>
            </li>
        @endforeach
    </ul>
</div>
