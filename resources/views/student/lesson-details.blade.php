@extends('layouts-side-bar.master')

@section('css')
    <!-- Existing styles -->
    <link href="{{ URL::asset('assets/plugins/jvectormap/jqvmap.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        .swal2-container {
            z-index: 2000 !important;
        }

        .video-container {
            width: 100%;
            max-width: 100%;
            margin: 0 auto;
        }

        .video-container iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .ratio-16x9 {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            max-width: 100%;
        }

        .ratio-16x9 iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .editor-container {
            position: relative;
            width: 100%;
            height: 50vh;
            border: 1px solid #ccc;
            overflow: hidden;
        }

        @media (max-width: 768px) {
            .editor-container {
                height: 40vh;
            }
        }

        #preview-frame,
        #output {
            width: 100%;
            height: calc(50vh - 3rem);
            border: 1px solid #ccc;
        }

        #output {
            background: #f5f5f5;
            padding: 10px;
            overflow-y: auto;
        }

        .run-code-container {
            margin-top: 1rem;
            display: flex;
            justify-content: center;
        }

        .editor-container {
            position: relative;
            width: 100%;
            height: 50vh;
            border: 1px solid #ccc;
            overflow: hidden;
        }

        @media (max-width: 768px) {
            .editor-container {
                height: 40vh;
            }
        }

        #preview-frame,
        #output {
            width: 100%;
            height: calc(50vh - 3rem);
            /* Adjust height to account for the button */
            border: 1px solid #ccc;
        }

        #output {
            background: #f5f5f5;
            padding: 10px;
            overflow-y: auto;
        }

        .run-code-container {
            margin-top: 1rem;
            display: flex;
            justify-content: center;
        }
    </style>
@endsection

@section('content')
    <br> <br>
    <div class="row">
        <!-- Video Lesson Section -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>{{ $lesson->title }}</h4>
                    <a href="{{ url('student/ongoing-lesson/' . $lesson->module->course->id) }}"
                        class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back to Lessons
                    </a>
                </div>
                <div class="card-body">
                    <p><strong>Module:</strong> {{ $lesson->module->title }}</p>
                    <p><strong>Course:</strong> {{ $lesson->module->course->title }}</p>

                    @if ($lesson->video_url)
                        @php
                            $embedUrl = str_replace('watch?v=', 'embed/', $lesson->video_url);
                        @endphp
                        <div class="video-container mt-4">
                            <div class="ratio ratio-16x9">
                                <iframe src="{{ $embedUrl }}" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Code Editor Section -->
        <div class="col-xl-12 mt-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">Interactive Code Editor</h4>
                    <select id="language-select" class="form-control w-25"
                        style="background-color: #e0f7fa; transition: background-color 0.3s ease; border-color: #8e98db;"
                        onfocus="this.style.backgroundColor='#e0f7fa'; this.style.borderColor='#00acc1';"
                        onmouseover="this.style.backgroundColor='#e0f7fa';" onchange="changeLanguage(this.value)">
                        <option value="javascript">JavaScript</option>
                        <option value="html">HTML</option>
                        <option value="css">CSS</option>
                        {{-- <option value="python">Python</option> --}}
                        {{-- <option value="php">PHP</option> --}}
                    </select>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div id="editor" class="editor-container"></div>
                            <div class="run-code-container">
                                <button class="btn btn-primary mt-3" onclick="runCode()">
                                    <i class="fas fa-play"></i> Run Code
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5>Output:</h5>
                            <div id="loading" style="display:none; color: orange;">⏳ Loading runtime, please wait...</div>
                            <iframe id="preview-frame" style="display:none;"></iframe>
                            <pre id="output" style="display:none;"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
@endsection

@section('js')
    <!-- Your existing JS libraries -->
    <script src="{{ URL::asset('assets/plugins/echarts/echarts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/peitychart/jquery.peity.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/apexcharts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/moment/moment.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/js/daterange.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jvectormap/jquery.vmap.js') }}"></script>
    <script src="{{ URL::asset('assets/js/index1.js') }}"></script>

    <!-- Monaco Editor -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.45.0/min/vs/loader.min.js"></script>

    <script>
        let editor;
        let currentLang = 'javascript';

        const starterCode = {
            javascript: `function greet(name) {
    return "Hello, " + name + "!";
}
console.log(greet("World"));`,
            html: `<!DOCTYPE html>
<html>
<head><title>My Page</title></head>
<body>
    <h1>Hello, world!</h1>
</body>
</html>`,
            css: `body {
    background-color: lightblue;
    font-family: Arial;
}`
        };

        require.config({
            paths: {
                'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.45.0/min/vs'
            }
        });

        require(['vs/editor/editor.main'], function() {
            editor = monaco.editor.create(document.getElementById('editor'), {
                value: starterCode[currentLang],
                language: currentLang,
                theme: 'vs-dark',
                automaticLayout: true
            });

            window.addEventListener('resize', () => editor.layout());
        });

        function changeLanguage(lang) {
            currentLang = lang;
            monaco.editor.setModelLanguage(editor.getModel(), (lang === 'html') ? 'html' : lang);
            editor.setValue(starterCode[lang] || '');
            document.getElementById('output').style.display = 'none';
            document.getElementById('preview-frame').style.display = (lang === 'html' || lang === 'css') ? 'block' : 'none';
        }

        function runCode() {
            const code = editor.getValue();
            const outputEl = document.getElementById('output');
            const iframe = document.getElementById('preview-frame');

            outputEl.style.display = 'block';
            outputEl.textContent = '';
            iframe.style.display = 'none';

            if (currentLang === 'javascript') {
                try {
                    const logs = [];
                    const originalLog = console.log;
                    console.log = function(...args) {
                        logs.push(args.join(' '));
                    };
                    eval(code);
                    console.log = originalLog;
                    outputEl.textContent = logs.join('\n') || '✅ Code executed.';
                } catch (e) {
                    outputEl.textContent = '❌ Error: ' + e.message;
                }
            } else if (currentLang === 'html') {
                iframe.srcdoc = code;
                outputEl.style.display = 'none';
                iframe.style.display = 'block';
            } else if (currentLang === 'css') {
                iframe.srcdoc = `<html><head><style>${code}</style></head><body><h1>Styled Output</h1></body></html>`;
                outputEl.style.display = 'none';
                iframe.style.display = 'block';
            }
        }
    </script>
@endsection
