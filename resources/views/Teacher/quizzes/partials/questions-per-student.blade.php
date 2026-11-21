{{--
    Optional "questions per student" setting.

    Expects: $exam, $poolCount (questions currently in the quiz),
             $marksVary (bool, true when questions carry different marks)
    Posts `questions_per_student` only while the switch is on, so leaving it off
    (or switching it off) clears the limit and every student answers everything.
--}}
@php
    $qpsEnabled = !is_null($exam->questions_per_student);
    $qpsValue = $exam->questions_per_student ?? '';
@endphp

<style>
    .qps-card { background: #fff; border: 1.5px solid #E3E0F0; border-radius: 18px; padding: 20px 24px; margin-bottom: 24px; font-family: 'DM Sans', sans-serif; color: #1A1628; }
    .qps-head { display: flex; align-items: center; gap: 14px; cursor: pointer; margin: 0; }
    .qps-head input { position: absolute; opacity: 0; pointer-events: none; }
    .qps-switch { flex: 0 0 auto; width: 46px; height: 26px; border-radius: 999px; background: #CFCADF; position: relative; transition: background .2s; }
    .qps-switch::after { content: ''; position: absolute; top: 3px; left: 3px; width: 20px; height: 20px; border-radius: 50%; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,.25); transition: transform .2s; }
    .qps-head input:checked + .qps-switch { background: #5B3FD9; }
    .qps-head input:checked + .qps-switch::after { transform: translateX(20px); }
    .qps-head input:focus-visible + .qps-switch { outline: 3px solid #EAE6FF; }
    .qps-title { font-weight: 700; font-size: .95rem; display: block; }
    .qps-sub { font-size: .8rem; color: #7C748E; display: block; margin-top: 2px; }
    .qps-body { margin-top: 16px; padding-top: 16px; border-top: 1px dashed #E3E0F0; }
    .qps-row { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; font-size: .9rem; }
    .qps-row input[type=number] { width: 90px; padding: 9px 12px; border: 1.5px solid #E3E0F0; border-radius: 10px; font: inherit; font-weight: 600; text-align: center; }
    .qps-row input[type=number]:focus { outline: none; border-color: #5B3FD9; box-shadow: 0 0 0 3px #EAE6FF; }
    .qps-hint { margin-top: 10px; font-size: .82rem; color: #7C748E; line-height: 1.5; }
    .qps-hint.qps-error { color: #DC2626; font-weight: 600; }
    .qps-hint.qps-warn { color: #D97706; }
</style>

<div class="qps-card" id="qpsCard" data-marks-vary="{{ !empty($marksVary) ? '1' : '0' }}">
    <label class="qps-head">
        <input type="checkbox" id="qpsToggle" {{ $qpsEnabled ? 'checked' : '' }}>
        <span class="qps-switch"></span>
        <span>
            <span class="qps-title"><i class="fas fa-random"></i> Give each student a random selection of questions</span>
            <span class="qps-sub">Optional. When off, every student answers all the questions in this quiz.</span>
        </span>
    </label>

    <div class="qps-body" id="qpsBody" style="display: none;">
        <div class="qps-row">
            <label for="qpsInput">Each student answers</label>
            <input type="number" id="qpsInput" name="questions_per_student" min="1" step="1"
                value="{{ $qpsValue }}" disabled>
            <span>of <strong id="qpsPool">{{ $poolCount }}</strong> questions</span>
        </div>
        <div class="qps-hint" id="qpsHint"></div>
    </div>
</div>

<script>
    (function () {
        const toggle = document.getElementById('qpsToggle');
        const body = document.getElementById('qpsBody');
        const input = document.getElementById('qpsInput');
        const poolEl = document.getElementById('qpsPool');
        const hint = document.getElementById('qpsHint');
        const card = document.getElementById('qpsCard');
        let pool = {{ (int) $poolCount }};

        function marksVary() {
            const marks = Array.from(document.querySelectorAll('input[name$="[marks]"]'))
                .map(i => i.value.trim()).filter(Boolean);
            // On pages without live question inputs fall back to the server value
            return marks.length ? new Set(marks).size > 1 : card.dataset.marksVary === '1';
        }

        function render() {
            const on = toggle.checked;
            body.style.display = on ? 'block' : 'none';
            input.disabled = !on;       // disabled inputs are not posted => limit cleared
            poolEl.textContent = pool;
            input.max = pool;
            hint.className = 'qps-hint';
            if (!on) { hint.textContent = ''; return; }

            if (input.value === '') input.value = Math.max(1, Math.min(pool, Math.ceil(pool / 2)));
            const n = parseInt(input.value, 10);

            if (!pool) {
                hint.classList.add('qps-error');
                hint.textContent = 'Add questions to the quiz first.';
            } else if (!n || n < 1) {
                hint.classList.add('qps-error');
                hint.textContent = 'Enter a number of 1 or more.';
            } else if (n > pool) {
                hint.classList.add('qps-error');
                hint.textContent = `This cannot be more than the ${pool} question${pool === 1 ? '' : 's'} in the quiz.`;
            } else if (n === pool) {
                hint.classList.add('qps-warn');
                hint.textContent = 'This equals the total number of questions, so every student still answers all of them.';
            } else {
                hint.textContent = `Every attempt gets ${n} randomly chosen question${n === 1 ? '' : 's'} out of ${pool}. ` +
                    'Students see different questions, and a retake draws a new set.';
                if (marksVary()) {
                    hint.classList.add('qps-warn');
                    hint.textContent += ' Note: your questions carry different marks, so the paper total will differ between students. Scores are calculated as a percentage of the questions given. Use equal marks if you want papers to be worth the same.';
                }
            }
        }

        // Called by the question builder whenever questions are added or removed
        window.qpsSync = function (count) { pool = count; render(); };

        // Returns an error message, or null when the setting is fine
        window.qpsValidate = function () {
            if (!toggle.checked) return null;
            const n = parseInt(input.value, 10);
            if (!n || n < 1) return 'Please enter how many questions each student should answer (1 or more).';
            if (n > pool) return `Questions per student (${n}) cannot be more than the number of questions in the quiz (${pool}).`;
            return null;
        };

        // Different marks per question affect the hint, so re-check when they change
        document.addEventListener('input', function (e) {
            if (e.target && e.target.name && /\[marks\]$/.test(e.target.name)) render();
        });

        toggle.addEventListener('change', render);
        input.addEventListener('input', render);
        render();
    })();
</script>
