@props(['variant' => 'card', 'url' => null])
@php
    $link = $url ?: config('academy.play_store_url');
    $inputId = 'aha-app-link-' . \Illuminate\Support\Str::random(6);
    $shareText = 'Assalamu Alaikum! Download the Al-Hilaal Online Academy app: ' . $link;
    $waShare = 'https://wa.me/?text=' . rawurlencode($shareText);
@endphp

@once
<style>
    .aha-app { font-family: inherit; box-sizing: border-box; }
    .aha-app *, .aha-app *::before, .aha-app *::after { box-sizing: border-box; }
    .aha-app--card { background: #f6f3ff; border: 1px solid #d9d0f5; border-radius: 12px; padding: 14px 16px; margin: 12px 0; }
    .aha-app__title { margin: 0 0 4px; font-size: 15px; font-weight: 700; color: #2b1a66; }
    .aha-app__hint { margin: 0 0 10px; font-size: 13px; color: #5b5675; }
    .aha-app__row { display: flex; flex-wrap: wrap; gap: 8px; align-items: stretch; }
    .aha-app__input { flex: 1 1 220px; min-width: 0; padding: 9px 10px; border: 1px solid #c9c0ea; border-radius: 8px; background: #fff; font-size: 13px; color: #333; }
    .aha-app__btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 9px 14px; border: 0; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; text-decoration: none; line-height: 1.2; }
    .aha-app__btn--copy { background: #3a1f8f; color: #fff; }
    .aha-app__btn--copy.is-copied { background: #1f8f4a; }
    .aha-app__btn--wa { background: #25d366; color: #073b1d; }
    .aha-app__btn--play { background: #fff; color: #3a1f8f; border: 1px solid #c9c0ea; }
    .aha-app--compact { display: inline-flex; gap: 6px; align-items: center; }
    .aha-app--compact .aha-app__btn { padding: 7px 12px; font-size: 12px; white-space: nowrap; }
    @@media (max-width: 700px) { .aha-app__label--hide-sm { display: none; } }
</style>
<script>
    (function () {
        function fallbackCopy(text) {
            var ta = document.createElement('textarea');
            ta.value = text;
            ta.setAttribute('readonly', '');
            ta.style.position = 'fixed';
            ta.style.opacity = '0';
            document.body.appendChild(ta);
            ta.select();
            try { document.execCommand('copy'); } catch (err) {}
            document.body.removeChild(ta);
        }
        function flash(btn) {
            var label = btn.querySelector('.aha-app__label');
            var original = btn.getAttribute('data-original') || (label ? label.textContent : '');
            btn.setAttribute('data-original', original);
            btn.classList.add('is-copied');
            if (label) { label.textContent = 'Copied!'; }
            setTimeout(function () {
                btn.classList.remove('is-copied');
                if (label) { label.textContent = original; }
            }, 1800);
        }
        document.addEventListener('click', function (e) {
            var btn = e.target.closest('[data-aha-copy]');
            if (!btn) { return; }
            e.preventDefault();
            var text = btn.getAttribute('data-aha-copy');
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(function () { flash(btn); }, function () { fallbackCopy(text); flash(btn); });
            } else {
                fallbackCopy(text);
                flash(btn);
            }
        });
    })();
</script>
@endonce

@if ($variant === 'compact')
    <span class="aha-app aha-app--compact">
        <button type="button" class="aha-app__btn aha-app__btn--copy" data-aha-copy="{{ $link }}" title="Copy the Google Play link of our app">
            <i class="fab fa-google-play"></i>
            <span class="aha-app__label aha-app__label--hide-sm">Copy app link</span>
        </button>
    </span>
@else
    <div class="aha-app aha-app--card">
        <p class="aha-app__title">Get the Al-Hilaal Online Academy app</p>
        <p class="aha-app__hint">Copy the Google Play link and share it with students, parents or teachers.</p>
        <div class="aha-app__row">
            <input id="{{ $inputId }}" class="aha-app__input" type="text" readonly value="{{ $link }}" onfocus="this.select()">
            <button type="button" class="aha-app__btn aha-app__btn--copy" data-aha-copy="{{ $link }}">
                <i class="fas fa-copy"></i> <span class="aha-app__label">Copy link</span>
            </button>
            <a class="aha-app__btn aha-app__btn--wa" href="{{ $waShare }}" target="_blank" rel="noopener"><i class="fab fa-whatsapp"></i> Share on WhatsApp</a>
            <a class="aha-app__btn aha-app__btn--play" href="{{ $link }}" target="_blank" rel="noopener"><i class="fab fa-google-play"></i> Open Play Store</a>
        </div>
    </div>
@endif
