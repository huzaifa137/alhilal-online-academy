@extends('layouts.master')

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
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
            height: 45vh;
            border: 1px solid #ccc;
        }

        #output {
            background: #f5f5f5;
            padding: 10px;
            overflow-y: auto;
        }
    </style>
@endsection

@section('page-header')
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title">Code Editor</h4>
        </div>

        <div class="page-rightheader ml-auto d-lg-flex d-none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" class="d-flex"><svg class="svg-icon"
                            xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z" />
                            <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3" />
                        </svg><span class="breadcrumb-icon"> Home</span></a></li>
                <li class="breadcrumb-item active" aria-current="page">Code Editor</li>
            </ol>
        </div>
        
    </div>
@endsection

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-column flex-md-row w-100">
                        <!-- Title Section -->
                        <div class="w-100 w-md-50 d-flex justify-content-center align-items-center mb-2 mb-md-0">
                            <h3 class="card-title m-0"><span style="color: #8e98db">Interactive Code Editor</span></h3>
                        </div>


                        <div class="w-100 w-md-50 d-flex justify-content-center align-items-center">
                            <select id="language-select" class="form-control w-75"
                                style="background-color: #e0f7fa; transition: background-color 0.3s ease; border-color: #8e98db;"
                                onfocus="this.style.backgroundColor='#e0f7fa'; this.style.borderColor='#00acc1';"
                                onmouseover="this.style.backgroundColor='#e0f7fa';" onchange="changeLanguage(this.value)">
                                <option value="javascript">JavaScript</option>
                                <option value="html">HTML</option>
                                <option value="css">CSS</option>
                                {{-- <option value="python">Python</option>
                                <option value="php">PHP</option> --}}
                            </select>
                        </div>


                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Editor Column -->
                        <div class="col-12 col-md-6 mb-4 mb-md-0">
                            <div id="editor" class="editor-container"></div>
                            <div class="run-code-container">
                                <button class="btn btn-primary mt-3" onclick="runCode()">
                                    <i class="fas fa-play"></i> Run Code
                                </button>
                            </div>
                        </div>

                        <!-- Output Column -->
                        <div class="col-12 col-md-6">
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
    <!-- Monaco Editor -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.45.0/min/vs/loader.min.js"></script>

    <!-- Pyodide (Python) -->
    <script src="https://cdn.jsdelivr.net/pyodide/v0.23.4/full/pyodide.js"></script>

    <!-- PHP-WASM -->
    <script src="https://cdn.jsdelivr.net/npm/php-wasm/wasm_exec.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/php-wasm/php.js"></script>

    <script>
        let editor;
        let currentLang = 'javascript';

        let pyodideReady = false;
        let pyodide = null;

        let phpReady = false;
        let phpRunner = null;

        const starterCode = {
            javascript: `function greet(name) {
    return "Hello, " + name + "!";
}
console.log(greet("Huzaifa"));`,
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
}`,
            python: `print("Hello from Python!")`,
            php: `<?php
            echo 'Hello from PHP!';
            ?>`
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

            window.addEventListener('resize', () => {
                editor.layout();
            });
        });

        window.addEventListener('load', async () => {
            document.getElementById('loading').style.display = 'block';

            try {
                pyodide = await loadPyodide();
                pyodideReady = true;
                console.log("✅ Pyodide loaded.");
            } catch (err) {
                console.error("❌ Failed to load Pyodide:", err);
            }

            try {
                phpRunner = await createPHP();
                phpReady = true;
                console.log("✅ PHP-WASM loaded.");
            } catch (err) {
                console.error("❌ Failed to load PHP-WASM:", err);
            }

            document.getElementById('loading').style.display = 'none';
        });

        function changeLanguage(lang) {
            currentLang = lang;
            monaco.editor.setModelLanguage(editor.getModel(), (lang === 'php' || lang === 'html') ? 'html' : lang);
            editor.setValue(starterCode[lang] || '');
            document.getElementById('output').style.display = 'none';
            document.getElementById('preview-frame').style.display = (lang === 'html' || lang === 'css') ? 'block' : 'none';
        }

        async function runCode() {
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
                    const result = eval(code);
                    console.log = originalLog;
                    outputEl.textContent = logs.length ? logs.join('\n') : (result ?? '✅ Code executed.');
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
            } else if (currentLang === 'python') {
                if (!pyodideReady) {
                    outputEl.textContent = "⚠️ Pyodide is still loading...";
                    return;
                }
                try {
                    const result = await pyodide.runPythonAsync(code);
                    outputEl.textContent = result ?? "✅ Executed.";
                } catch (e) {
                    outputEl.textContent = '❌ Python Error: ' + e.message;
                }
            } else if (currentLang === 'php') {
                if (!phpReady || !phpRunner) {
                    outputEl.textContent = "⚠️ PHP engine still loading...";
                    return;
                }
                try {
                    const result = await phpRunner.run(code);
                    outputEl.textContent = result;
                } catch (e) {
                    outputEl.textContent = '❌ PHP Error: ' + e.message;
                }
            }
        }
    </script>
@endsection
