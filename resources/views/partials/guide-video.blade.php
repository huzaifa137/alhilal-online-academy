{{--
    "Watch the Guide" section (homepage).

    A walkthrough video that shows a new student the whole journey: choosing a
    language, registering, paying, studying, and collecting report cards and
    certificates.

    Include on the homepage with:   @include('partials.guide-video')

    - Video + poster live in public/assets/videos/.
    - Chapters below are plain data: `start` is the second the chapter begins.
      If the video is ever re-recorded, only this array needs to change.
    - Needs the homepage CSS variables (--purple, --gradient, ...) and Font Awesome,
      both of which home-page.blade.php already loads.
    - All visible text sits in its own element so the HtmlTranslator
      (resources/lang/*.json) can translate it.
--}}
@php
    $guideChapters = [
        ['start' => 0,   'icon' => 'fa-circle-play',    'title' => 'Getting Started',        'desc' => 'Meet your guide and open Al-Hilaal Online Academy from Google Play.'],
        ['start' => 46,  'icon' => 'fa-book-open',      'title' => 'What You Get',           'desc' => 'PDF notes, a quiz after each lesson, and certificates when you finish.'],
        ['start' => 62,  'icon' => 'fa-language',       'title' => 'Choose Your Language',   'desc' => 'Tap the globe icon to switch between English, Arabic, Kiswahili and Luganda.'],
        ['start' => 79,  'icon' => 'fa-user-plus',      'title' => 'Register for Free',      'desc' => 'Tap Get Started Free, fill in your details and confirm your password.'],
        ['start' => 130, 'icon' => 'fa-table-columns',  'title' => 'Your Dashboard',         'desc' => 'Your account is ready. See your classes, lessons and study materials.'],
        ['start' => 140, 'icon' => 'fa-wallet',         'title' => 'Make a Payment',         'desc' => 'Pay with mobile money, and chat with the admin on WhatsApp if you need help.'],
        ['start' => 201, 'icon' => 'fa-award',          'title' => 'Reports & Certificates', 'desc' => 'Open your report cards and certificates and download them.'],
        ['start' => 228, 'icon' => 'fa-right-from-bracket', 'title' => 'Sign Out',           'desc' => 'Finish up and sign out safely.'],
    ];
    $guideDuration = 233; // seconds
    $guideVideo    = asset('assets/videos/hilal-online-academy-guide.mp4') . '?v=2'; // ?v bumps the browser cache when the file is re-encoded
    $guidePoster   = asset('assets/videos/hilal-online-academy-guide-poster.jpg');
@endphp

<style>
/* ── GUIDE VIDEO SECTION ── */
.gd-section {
    position: relative;
    overflow: hidden;
    padding: 88px 0;
    color: #fff;
    background: linear-gradient(135deg, #1A0A2E 0%, #3B2459 55%, #4C2E8A 100%);
    scroll-margin-top: 70px;
}
.gd-section::before,
.gd-section::after {
    content: '';
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
}
.gd-section::before {
    width: 520px; height: 520px;
    right: -160px; top: -180px;
    background: radial-gradient(circle, rgba(220,38,38,0.28), transparent 65%);
}
.gd-section::after {
    width: 460px; height: 460px;
    left: -160px; bottom: -200px;
    background: radial-gradient(circle, rgba(107,70,193,0.55), transparent 65%);
}
.gd-grid {
    position: relative;
    z-index: 1;
    display: grid;
    grid-template-columns: minmax(0, 340px) minmax(0, 1fr);
    gap: 64px;
    align-items: center;
}

/* Video stage (the video is a 9:16 portrait recording) */
.gd-stage-wrap { position: relative; justify-self: center; width: 100%; max-width: 340px; }
.gd-stage {
    position: relative;
    aspect-ratio: 9 / 16;
    border-radius: 30px;
    overflow: hidden;
    background: #0b0f1e;
    border: 1px solid rgba(255,255,255,0.18);
    box-shadow: 0 32px 80px rgba(0,0,0,0.45), 0 0 0 8px rgba(255,255,255,0.05);
}
.gd-video { display: block; width: 100%; height: 100%; object-fit: cover; background: #0b0f1e; }
.gd-play {
    position: absolute; inset: 0;
    display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 16px;
    width: 100%;
    border: 0; padding: 0; cursor: pointer;
    color: #fff;
    font-family: 'DM Sans', sans-serif;
    background: linear-gradient(180deg, rgba(26,10,46,0.10) 0%, rgba(26,10,46,0.62) 100%);
    transition: opacity 0.3s ease;
}
.gd-play-btn {
    width: 78px; height: 78px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.7rem;
    padding-left: 5px;
    background: var(--gradient);
    box-shadow: 0 0 0 10px rgba(255,255,255,0.16), 0 12px 32px rgba(0,0,0,0.4);
    animation: gdPulse 2.2s ease-in-out infinite;
    transition: transform 0.2s ease;
}
.gd-play:hover .gd-play-btn { transform: scale(1.08); }
.gd-play:focus-visible { outline: 3px solid #FCD34D; outline-offset: -3px; }
.gd-play-label {
    font-size: 0.82rem; font-weight: 600; letter-spacing: 0.4px;
    background: rgba(0,0,0,0.45);
    backdrop-filter: blur(6px);
    padding: 7px 16px;
    border-radius: 30px;
}
.gd-stage.is-started .gd-play { opacity: 0; pointer-events: none; }
@keyframes gdPulse {
    0%, 100% { box-shadow: 0 0 0 10px rgba(255,255,255,0.16), 0 12px 32px rgba(0,0,0,0.4); }
    50%      { box-shadow: 0 0 0 18px rgba(255,255,255,0.06), 0 12px 32px rgba(0,0,0,0.4); }
}

.gd-chip {
    position: absolute;
    display: flex; align-items: center; gap: 10px;
    padding: 10px 14px;
    border-radius: 14px;
    background: #fff;
    color: var(--ink);
    box-shadow: var(--shadow-lg);
    font-size: 0.8rem; font-weight: 600;
    z-index: 2;
    pointer-events: none;
}
.gd-chip i {
    width: 30px; height: 30px;
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.8rem;
}
.gd-chip-1 { top: 28px; left: -34px; }
.gd-chip-1 i { background: var(--purple-light); color: var(--purple); }
.gd-chip-2 { bottom: 40px; right: -34px; }
.gd-chip-2 i { background: #DCFCE7; color: #16A34A; }

/* Seek bar under the video */
.gd-seek { display: flex; align-items: center; gap: 10px; margin-top: 18px; direction: ltr; }
.gd-seek-time { flex: none; font-size: 0.72rem; font-weight: 600; color: rgba(255,255,255,0.7); font-variant-numeric: tabular-nums; min-width: 32px; text-align: center; }
.gd-seek-bar {
    --gd-fill: 0%;
    flex: 1; min-width: 0; height: 22px;
    margin: 0; background: transparent;
    -webkit-appearance: none; appearance: none;
    cursor: pointer; touch-action: pan-y;
}
.gd-seek-bar::-webkit-slider-runnable-track {
    height: 6px; border-radius: 6px;
    background: linear-gradient(90deg, #A78BFA 0%, #F87171 var(--gd-fill), rgba(255,255,255,0.2) var(--gd-fill));
}
.gd-seek-bar::-moz-range-track { height: 6px; border-radius: 6px; background: rgba(255,255,255,0.2); }
.gd-seek-bar::-moz-range-progress { height: 6px; border-radius: 6px; background: linear-gradient(90deg, #A78BFA, #F87171); }
.gd-seek-bar::-webkit-slider-thumb {
    -webkit-appearance: none; appearance: none;
    width: 18px; height: 18px; margin-top: -6px;
    border-radius: 50%; background: #fff; border: 0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.4);
}
.gd-seek-bar::-moz-range-thumb { width: 18px; height: 18px; border-radius: 50%; background: #fff; border: 0; box-shadow: 0 2px 8px rgba(0,0,0,0.4); }
.gd-seek-bar:focus-visible { outline: 2px solid #FCD34D; outline-offset: 4px; border-radius: 6px; }

/* Copy + chapters */
.gd-content .eyebrow { color: #FCA5A5; }
.gd-content .eyebrow::before { background: #FCA5A5; }
.gd-content .section-heading { color: #fff; }
.gd-lead { color: rgba(255,255,255,0.72); font-size: 1rem; line-height: 1.75; max-width: 560px; }
.gd-chaps-title {
    margin: 30px 0 12px;
    font-size: 0.72rem; font-weight: 600;
    letter-spacing: 2px; text-transform: uppercase;
    color: rgba(255,255,255,0.55);
}
.gd-chaps {
    list-style: none;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}
.gd-chap {
    position: relative;
    overflow: hidden;
    display: flex; align-items: flex-start; gap: 12px;
    width: 100%; height: 100%;
    padding: 14px 14px 16px;
    text-align: start;
    color: #fff;
    font-family: 'DM Sans', sans-serif;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 16px;
    cursor: pointer;
    transition: background 0.2s, border-color 0.2s, transform 0.2s;
}
.gd-chap:hover { background: rgba(255,255,255,0.12); transform: translateY(-2px); }
.gd-chap:focus-visible { outline: 2px solid #FCD34D; outline-offset: 2px; }
.gd-chap.is-active { background: rgba(255,255,255,0.16); border-color: rgba(255,255,255,0.4); }
.gd-chap-ico {
    flex: none;
    width: 38px; height: 38px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.9rem;
    background: rgba(255,255,255,0.1);
    color: #E9D5FF;
    transition: background 0.2s, color 0.2s;
}
.gd-chap.is-active .gd-chap-ico { background: var(--gradient); color: #fff; }
.gd-chap-body { flex: 1; min-width: 0; }
.gd-chap-top { display: flex; align-items: baseline; justify-content: space-between; gap: 8px; }
.gd-chap-title { font-size: 0.88rem; font-weight: 600; line-height: 1.3; }
.gd-chap-time { flex: none; font-size: 0.7rem; font-weight: 600; color: #FCD34D; font-variant-numeric: tabular-nums; }
.gd-chap-desc { margin-top: 4px; font-size: 0.76rem; line-height: 1.5; color: rgba(255,255,255,0.62); }
.gd-chap-bar { position: absolute; left: 0; right: 0; bottom: 0; height: 3px; background: transparent; }
.gd-chap-bar i { display: block; width: 0; height: 100%; background: var(--gradient); }

.gd-actions { display: flex; flex-wrap: wrap; gap: 14px; margin-top: 32px; }
.gd-section .btn-ghost { font-size: 0.9rem; }

/* Link shown in the hero */
.hero-watch {
    display: inline-flex; align-items: center; gap: 10px;
    color: rgba(255,255,255,0.85);
    font-size: 0.88rem; font-weight: 500;
    text-decoration: none;
    transition: color 0.2s;
}
.hero-watch:hover { color: #fff; }
.hero-watch-icon {
    width: 38px; height: 38px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.8rem;
    padding-left: 2px;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.3);
    transition: background 0.2s;
}
.hero-watch:hover .hero-watch-icon { background: var(--red); border-color: var(--red); }

@media (max-width: 900px) {
    .gd-section { padding: 64px 0; }
    .gd-grid { grid-template-columns: 1fr; gap: 40px; }
    .gd-stage-wrap { max-width: 320px; }
    .gd-chip-1 { top: -14px; left: 8px; }
    .gd-chip-2 { bottom: -14px; right: 8px; }
}
@media (max-width: 600px) {
    .gd-chaps { grid-template-columns: 1fr; }
    .gd-chap:not(.is-active) .gd-chap-desc { display: none; }
    .gd-actions .btn { width: 100%; justify-content: center; }
}
@media (prefers-reduced-motion: reduce) {
    .gd-play-btn { animation: none; }
    .gd-chap, .gd-chap:hover { transition: none; transform: none; }
}
</style>

<!-- ════════════════════ WATCH THE GUIDE ════════════════════ -->
<section class="gd-section" id="guide">
    <div class="container">
        <div class="gd-grid">

            <!-- Video -->
            <div class="gd-stage-wrap">
                <div class="gd-chip gd-chip-1"><i class="fas fa-clock"></i><span>About 4 minutes</span></div>
                <div class="gd-chip gd-chip-2"><i class="fas fa-list-check"></i><span>8 simple steps</span></div>

                <div class="gd-stage" id="gdStage">
                    <video id="gdVideo" class="gd-video" preload="metadata" playsinline
                           poster="{{ $guidePoster }}">
                        <source src="{{ $guideVideo }}" type="video/mp4">
                        Your browser does not support video playback.
                    </video>
                    <button type="button" class="gd-play" id="gdPlay" aria-label="Play guide video">
                        <span class="gd-play-btn"><i class="fas fa-play"></i></span>
                        <span class="gd-play-label">Watch the Guide</span>
                    </button>
                </div>

                <div class="gd-seek">
                    <span class="gd-seek-time" id="gdCur">0:00</span>
                    <input type="range" class="gd-seek-bar" id="gdSeek" min="0" max="{{ $guideDuration }}" step="0.1" value="0" aria-label="Seek video">
                    <span class="gd-seek-time">{{ floor($guideDuration / 60) }}:{{ str_pad($guideDuration % 60, 2, '0', STR_PAD_LEFT) }}</span>
                </div>
            </div>

            <!-- Copy + chapters -->
            <div class="gd-content">
                <span class="eyebrow">Watch the Guide</span>
                <h2 class="section-heading">See How It Works,<br>Step by Step</h2>
                <p class="gd-lead">A short walkthrough of the whole journey, from registering and paying to studying and collecting your report cards and certificates, exactly as the system works.</p>

                <div class="gd-chaps-title">In this video</div>
                <ol class="gd-chaps" id="gdChaps">
                    @foreach ($guideChapters as $chapter)
                        <li>
                            <button type="button" class="gd-chap" data-start="{{ $chapter['start'] }}">
                                <span class="gd-chap-ico"><i class="fas {{ $chapter['icon'] }}"></i></span>
                                <span class="gd-chap-body">
                                    <span class="gd-chap-top">
                                        <span class="gd-chap-title">{{ $chapter['title'] }}</span>
                                        <span class="gd-chap-time">{{ floor($chapter['start'] / 60) }}:{{ str_pad($chapter['start'] % 60, 2, '0', STR_PAD_LEFT) }}</span>
                                    </span>
                                    <span class="gd-chap-desc">{{ $chapter['desc'] }}</span>
                                </span>
                                <span class="gd-chap-bar"><i></i></span>
                            </button>
                        </li>
                    @endforeach
                </ol>

                <div class="gd-actions">
                    <a href="{{ url('/users/register') }}" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Create Free Account
                    </a>
                    <button type="button" class="btn btn-ghost" id="gdWhatsapp">
                        <i class="fab fa-whatsapp"></i> Need help? Chat with us
                    </button>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
(function () {
    var video = document.getElementById('gdVideo');
    if (!video) return;

    var stage    = document.getElementById('gdStage');
    var playBtn  = document.getElementById('gdPlay');
    var chapBtns = [].slice.call(document.querySelectorAll('#gdChaps .gd-chap'));
    var starts   = chapBtns.map(function (b) { return Number(b.getAttribute('data-start')); });
    var total    = {{ $guideDuration }};
    var seekBar  = document.getElementById('gdSeek');
    var curLabel = document.getElementById('gdCur');
    var current  = -1;
    var pending  = null;     // a jump requested before the video had loaded its metadata
    var scrubbing = false;   // seek bar is being dragged
    var scrubTo  = 0;        // latest second the thumb points at

    function fmt(t) {
        t = Math.max(0, Math.floor(t));
        return Math.floor(t / 60) + ':' + ('0' + (t % 60)).slice(-2);
    }

    function duration() { return video.duration || total; }

    // ── Servers that cannot "jump" (no HTTP Range support, e.g. `php artisan serve`) ──
    // A browser can only jump to a part of the video it has already downloaded.
    // If the server cannot send partial content, we download the file once and
    // play it from memory, where jumping always works.
    var videoUrl  = (video.querySelector('source') || {}).src || video.currentSrc;
    var inMemory  = false;       // already playing from a downloaded copy
    var loadingMem = false;
    var wantPlay  = false;       // the visitor asked for playback
    var expected  = null;        // second a jump should land on (to verify it did)

    function useDownloadedCopy(resumeAt) {
        if (inMemory || loadingMem || !window.fetch || !window.URL) return;
        loadingMem = true;
        if (!video.paused) video.pause();            // do not play from the wrong spot meanwhile
        stage.style.cursor = 'progress';
        fetch(videoUrl).then(function (r) { return r.blob(); }).then(function (blob) {
            inMemory = true;
            loadingMem = false;
            stage.style.cursor = '';
            if (pending == null) pending = resumeAt != null ? resumeAt : 0;   // a jump asked for meanwhile wins
            video.src = URL.createObjectURL(blob);
            video.load();
            video.addEventListener('loadedmetadata', function once() {
                video.removeEventListener('loadedmetadata', once);
                if (wantPlay && !scrubbing) play();
            });
        }).catch(function () { loadingMem = false; stage.style.cursor = ''; });
    }

    // Ask for 2 bytes: a server that supports jumping answers 206 Partial Content.
    (function probeRange() {
        if (!window.fetch || !window.AbortController) return;
        var ac = new AbortController();
        fetch(videoUrl, { headers: { Range: 'bytes=0-1' }, signal: ac.signal }).then(function (r) {
            ac.abort();   // we only wanted the headers
            if (r.status !== 206) useDownloadedCopy(0);
        }).catch(function () {});
    })();

    function start() {
        stage.classList.add('is-started');
        video.controls = true;
    }

    function updateSeek(t) {
        if (!seekBar) return;
        seekBar.value = t;
        seekBar.style.setProperty('--gd-fill', Math.min(100, (t / duration()) * 100) + '%');
        if (curLabel) curLabel.textContent = fmt(t);
    }

    function render(t) {
        var idx = 0;
        for (var i = 0; i < starts.length; i++) { if (t >= starts[i]) idx = i; }

        if (idx !== current) {
            current = idx;
            chapBtns.forEach(function (b, i) {
                var on = i === idx;
                b.classList.toggle('is-active', on);
                if (on) b.setAttribute('aria-current', 'true'); else b.removeAttribute('aria-current');
                if (!on) b.querySelector('.gd-chap-bar i').style.width = '0';
            });
        }

        var end = idx + 1 < starts.length ? starts[idx + 1] : duration();
        var pct = Math.max(0, Math.min(100, ((t - starts[idx]) / (end - starts[idx])) * 100));
        chapBtns[idx].querySelector('.gd-chap-bar i').style.width = pct + '%';
    }

    // Move the playhead once. If the video has not loaded its metadata yet the
    // jump is remembered and applied a single time when it arrives.
    function setTime(t) {
        t = Math.max(0, Math.min(t, duration() - 0.2));
        expected = t;
        if (loadingMem) { pending = t; return; }   // applied once the downloaded copy is ready
        if (video.readyState >= 1) {
            pending = null;
            try { video.currentTime = t; } catch (e) { pending = t; }
        } else {
            pending = t;
        }
    }

    function applyPending() {
        if (pending == null) return;
        var t = pending;
        pending = null;
        try { video.currentTime = t; } catch (e) {}
    }
    video.addEventListener('loadedmetadata', applyPending);

    function play() {
        wantPlay = true;
        start();
        var p = video.play();
        if (p && p.catch) p.catch(function () {});
    }

    // Jump to a second (chapter click) and keep playing from there.
    function jumpAndPlay(t) {
        setTime(t);
        render(t);
        updateSeek(t);
        play();
    }

    playBtn.addEventListener('click', play);
    video.addEventListener('play', start);

    video.addEventListener('timeupdate', function () {
        if (scrubbing || video.seeking || (loadingMem && !inMemory)) return;   // the bar and chapters follow the thumb instead
        render(video.currentTime);
        updateSeek(video.currentTime);
    });

    // Chapters
    chapBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            jumpAndPlay(Number(btn.getAttribute('data-start')));
            // On phones the chapter list sits below the video: bring the video back into view.
            if (window.matchMedia('(max-width: 900px)').matches) {
                stage.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    });

    // Seek bar. While dragging, the video is paused and shows the frame under the
    // thumb. Only one seek is ever in flight (a new one starts when the last
    // finishes), so the decoder is never flooded. On release it plays from there.
    var lastScrub = 0, scrubTimer = null;
    function scrubStep() {
        if (!scrubbing || video.seeking || video.readyState < 1) return;
        if (Math.abs(video.currentTime - scrubTo) < 0.05) return;
        var wait = 90 - (Date.now() - lastScrub);      // at most ~10 frames a second
        if (wait > 0) {
            if (!scrubTimer) scrubTimer = setTimeout(function () { scrubTimer = null; scrubStep(); }, wait);
            return;
        }
        lastScrub = Date.now();
        try { video.currentTime = scrubTo; } catch (e) {}
    }
    video.addEventListener('seeked', scrubStep);

    // Safety net: if a jump did not land (server/proxy quirk), switch to the downloaded copy.
    video.addEventListener('seeked', function () {
        if (scrubbing || expected == null) return;
        var want = expected;
        expected = null;
        if (Math.abs(video.currentTime - want) > 3) useDownloadedCopy(want);
    });

    function beginScrub() {
        if (scrubbing) return;
        scrubbing = true;
        scrubTo = Number(seekBar.value);   // a plain click on the handle must not jump anywhere
        start();
        if (!video.paused) video.pause();
    }

    function endScrub() {
        if (!scrubbing) return;           // pointerup, touchend and change all land here: run once
        scrubbing = false;
        clearTimeout(scrubTimer); scrubTimer = null;
        setTime(scrubTo);
        render(scrubTo);
        updateSeek(scrubTo);
        play();
    }

    if (seekBar) {
        seekBar.addEventListener('pointerdown', beginScrub);
        seekBar.addEventListener('input', function () {
            beginScrub();                  // also covers keyboard arrows
            scrubTo = Number(seekBar.value);
            render(scrubTo);
            updateSeek(scrubTo);
            scrubStep();
        });
        seekBar.addEventListener('change', endScrub);
        ['pointerup', 'pointercancel', 'touchend'].forEach(function (ev) {
            seekBar.addEventListener(ev, endScrub);
        });
        seekBar.addEventListener('blur', endScrub);
    }

    // Reuse the existing WhatsApp button (bottom nav) so the message and Play Store link stay in one place.
    var wa = document.getElementById('gdWhatsapp');
    if (wa) wa.addEventListener('click', function () {
        var main = document.getElementById('whatsappChat');
        if (main) main.click();
    });

    render(0);
    updateSeek(0);
})();
</script>
