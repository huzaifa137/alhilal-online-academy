<?php

namespace App\Services;

/**
 * Translates a rendered HTML page using a flat "English => Translation"
 * dictionary (resources/lang/<locale>.json).
 *
 * What it translates:
 *   - visible text nodes (exact match, whitespace-insensitive)
 *   - placeholder / title / alt / aria-label / data-title attributes
 *   - value of submit/button/reset inputs
 *   - display strings inside inline <script> (Swal.fire, toastr, alert, confirm,
 *     and title/text/html/... properties) and inline on*="" handlers
 *   - <html lang dir>, plus RTL assets when the language is right-to-left
 *
 * Dictionary keys may contain {1}, {2}... placeholders (any text) or {#1}
 * (numbers only) to match text that contains dynamic values, e.g.
 *   "Welcome back, {1}!"  =>  "مرحباً بعودتك، {1}!"
 *   "{#1} lessons"        =>  "{1} دروس"
 *
 * Anything that is not found in the dictionary is left exactly as it is.
 */
class HtmlTranslator
{
    /** @var array<string,string> */
    protected array $exact = [];

    /** @var array<int,array{0:string,1:string}> regex => template */
    protected array $patterns = [];

    protected string $locale;
    protected string $dir;

    protected string $assetBase;

    /** @var array<string,self> */
    protected static array $instances = [];

    protected const ATTRS = [
        'placeholder', 'title', 'alt', 'aria-label',
        'data-title', 'data-original-title', 'data-placeholder', 'data-bs-original-title',
    ];

    protected const JS_PROPS = [
        'title', 'text', 'html', 'label', 'placeholder', 'message',
        'confirmButtonText', 'cancelButtonText', 'denyButtonText',
        'emptyTable', 'zeroRecords', 'infoEmpty', 'loadingRecords',
        'processing', 'search', 'searchPlaceholder', 'lengthMenu', 'info',
    ];

    public function __construct(array $dictionary, string $locale, string $dir = 'ltr', string $assetBase = '')
    {
        $this->locale    = $locale;
        $this->dir       = $dir;
        $this->assetBase = rtrim($assetBase, '/');

        foreach ($dictionary as $key => $value) {
            if (!is_string($key) || !is_string($value) || $value === '') {
                continue;
            }

            $key = self::normalize($key);
            if ($key === '') {
                continue;
            }

            if (preg_match('/\{#?\d+\}/', $key)) {
                $this->patterns[] = $this->compilePattern($key, $value);
            } else {
                $this->exact[$key] = $value;
            }
        }

        // Most specific (longest literal) patterns first
        usort($this->patterns, fn ($a, $b) => strlen($b[2]) <=> strlen($a[2]));
    }

    /**
     * Build (and cache) a translator for a locale from resources/lang/<locale>.json
     */
    public static function forLocale(string $locale): self
    {
        if (isset(self::$instances[$locale])) {
            return self::$instances[$locale];
        }

        // Works whether the app keeps translations in lang/ or resources/lang/
        $file = null;
        foreach ([
            function_exists('lang_path') ? lang_path($locale . '.json') : null,
            resource_path('lang/' . $locale . '.json'),
            base_path('lang/' . $locale . '.json'),
        ] as $candidate) {
            if ($candidate && is_file($candidate)) {
                $file = $candidate;
                break;
            }
        }

        $dictionary = [];
        if ($file) {
            $decoded = json_decode((string) file_get_contents($file), true);
            if (is_array($decoded)) {
                $dictionary = $decoded;
            }
        }

        $dir = config('languages.supported.' . $locale . '.dir', 'ltr');

        return self::$instances[$locale] = new self(
            $dictionary,
            $locale,
            $dir,
            function_exists('asset') ? rtrim(asset(''), '/') : ''
        );
    }

    /* ------------------------------------------------------------------ */
    /*  Public API                                                         */
    /* ------------------------------------------------------------------ */

    public function translate(string $html): string
    {
        $tokenRegex = '~(<!--.*?-->'
            . '|<script\b[^>]*>.*?</script\s*>'
            . '|<style\b[^>]*>.*?</style\s*>'
            . '|<\/?[a-zA-Z][^\s/>]*(?>[^>"\']+|"[^"]*"|\'[^\']*\')*+>)~is';

        $parts = @preg_split($tokenRegex, $html, -1, PREG_SPLIT_DELIM_CAPTURE);

        if ($parts === false) {
            return $html; // regex engine gave up: serve the page untouched
        }

        $out        = '';
        $inTitle    = false;
        $inTextarea = false;
        $inHead     = true;

        foreach ($parts as $i => $part) {
            if ($part === '') {
                continue;
            }

            // Odd indexes are the delimiters (tags, scripts, styles, comments)
            if ($i % 2 === 1) {
                if (strncmp($part, '<!--', 4) === 0) {
                    $out .= $part;
                } elseif (stripos($part, '<script') === 0) {
                    $out .= $this->translateScript($part);
                } elseif (stripos($part, '<style') === 0) {
                    $out .= $part;
                } else {
                    $name = $this->tagName($part);
                    if ($name === 'title') {
                        $inTitle = $part[1] !== '/';
                    } elseif ($name === 'textarea') {
                        $inTextarea = $part[1] !== '/';
                    }
                    $out .= $this->translateTag($part, $name);
                }
                continue;
            }

            // Text node
            if ($inTextarea) {
                $out .= $part;
            } elseif ($inTitle) {
                $out .= $this->translateTitle($part);
            } else {
                $out .= $this->translateText($part);
            }
        }

        return $this->injectHeadAssets($out);
    }

    public function lookup(string $text): ?string
    {
        $key = self::normalize($text);
        if ($key === '') {
            return null;
        }

        if (isset($this->exact[$key])) {
            return $this->exact[$key];
        }

        // "Name:" / "Name *" / "Loading..." -> translate the base, keep the suffix
        if (preg_match('/^(.*?)(\s*[:*]+|\s*…|\s*\.{3})$/su', $key, $m) && $m[1] !== '') {
            if (isset($this->exact[$m[1]])) {
                return $this->exact[$m[1]] . $m[2];
            }
        }

        foreach ($this->patterns as [$regex, $template]) {
            if (preg_match($regex, $key, $m)) {
                $result = $template;
                foreach ($m as $name => $val) {
                    if (is_string($name) && $name !== '' && $name[0] === 'p') {
                        $result = str_replace('{' . substr($name, 1) . '}', $val, $result);
                    }
                }
                return $result;
            }
        }

        return null;
    }

    /* ------------------------------------------------------------------ */
    /*  Internals                                                          */
    /* ------------------------------------------------------------------ */

    public static function normalize(string $text): string
    {
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/[\s\x{00A0}]+/u', ' ', $text) ?? $text;

        return trim($text);
    }

    protected function compilePattern(string $key, string $value): array
    {
        $pieces  = preg_split('/(\{#?\d+\})/', $key, -1, PREG_SPLIT_DELIM_CAPTURE);
        $regex   = '';
        $literal = '';

        foreach ($pieces as $piece) {
            if (preg_match('/^\{(#?)(\d+)\}$/', $piece, $m)) {
                // {1} = any text, {#1} = a number only (e.g. 12, 1,500, 85.5)
                $regex .= '(?P<p' . $m[2] . '>' . ($m[1] === '#' ? '[\d.,]+' : '.*?') . ')';
            } else {
                $regex   .= preg_quote($piece, '~');
                $literal .= $piece;
            }
        }

        return ['~^' . $regex . '$~us', $value, $literal];
    }

    protected function esc(string $s): string
    {
        return htmlspecialchars($s, ENT_NOQUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    protected function escAttr(string $s): string
    {
        return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    protected function tagName(string $tag): string
    {
        return preg_match('~^<\s*/?\s*([a-zA-Z][a-zA-Z0-9:-]*)~', $tag, $m) ? strtolower($m[1]) : '';
    }

    protected function translateText(string $raw): string
    {
        if (!preg_match('/^(\s*)(.*?)(\s*)$/su', $raw, $m) || $m[2] === '') {
            return $raw;
        }

        $translated = $this->lookup($m[2]);

        return $translated === null ? $raw : $m[1] . $this->esc($translated) . $m[3];
    }

    protected function translateTitle(string $raw): string
    {
        $translated = $this->translateText($raw);
        if ($translated !== $raw) {
            return $translated;
        }

        // "Dashboard - AlHilal Academy": translate each part separately
        $segments = preg_split('/(\s+[-|–—]\s+)/u', $raw, -1, PREG_SPLIT_DELIM_CAPTURE);
        if (count($segments) < 3) {
            return $raw;
        }

        foreach ($segments as $k => $seg) {
            if ($k % 2 === 0) {
                $segments[$k] = $this->translateText($seg);
            }
        }

        return implode('', $segments);
    }

    protected function translateTag(string $tag, string $name): string
    {
        if ($name === 'html') {
            return strncmp($tag, '</', 2) === 0 ? $tag : $this->rewriteHtmlTag($tag);
        }

        // title="", placeholder="", alt="" ...
        $attrs = implode('|', array_map('preg_quote', self::ATTRS));
        $tag = preg_replace_callback(
            '~(\s(?:' . $attrs . ')\s*=\s*)(?:"([^"]*)"|\'([^\']*)\')~i',
            function ($m) {
                $value = $m[2] !== '' ? $m[2] : ($m[3] ?? '');
                $t = $this->lookup($value);

                return $t === null ? $m[0] : $m[1] . '"' . $this->escAttr($t) . '"';
            },
            $tag
        ) ?? $tag;

        // <input type="submit" value="Save">
        if ($name === 'input' && preg_match('~\stype\s*=\s*["\']?(submit|button|reset)\b~i', $tag)) {
            $tag = preg_replace_callback(
                '~(\svalue\s*=\s*)(?:"([^"]*)"|\'([^\']*)\')~i',
                function ($m) {
                    $value = $m[2] !== '' ? $m[2] : ($m[3] ?? '');
                    $t = $this->lookup($value);

                    return $t === null ? $m[0] : $m[1] . '"' . $this->escAttr($t) . '"';
                },
                $tag
            ) ?? $tag;
        }

        // onclick="return confirm('Are you sure?')"
        if (stripos($tag, ' on') !== false) {
            $tag = preg_replace_callback(
                '~(\son[a-z]+\s*=\s*)"([^"]*)"~i',
                function ($m) {
                    $js  = html_entity_decode($m[2], ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    $new = $this->translateJsCalls($js);

                    return $new === $js ? $m[0] : $m[1] . '"' . $this->escAttr($new) . '"';
                },
                $tag
            ) ?? $tag;
        }

        return $tag;
    }

    protected function rewriteHtmlTag(string $tag): string
    {
        if (preg_match('~\slang\s*=\s*(["\']).*?\1~i', $tag)) {
            $tag = preg_replace('~(\slang\s*=\s*)(["\']).*?\2~i', '$1"' . $this->locale . '"', $tag, 1);
        } else {
            $tag = preg_replace('~^<html~i', '<html lang="' . $this->locale . '"', $tag, 1);
        }

        if (preg_match('~\sdir\s*=\s*(["\']).*?\1~i', $tag)) {
            $tag = preg_replace('~(\sdir\s*=\s*)(["\']).*?\2~i', '$1"' . $this->dir . '"', $tag, 1);
        } else {
            $tag = preg_replace('~>$~', ' dir="' . $this->dir . '">', $tag, 1);
        }

        return $tag;
    }

    /* ----------------------------- scripts ----------------------------- */

    protected function translateScript(string $script): string
    {
        // Leave JSON / templates / import maps alone; only plain JavaScript is touched
        if (preg_match('~^<script\b[^>]*\stype\s*=\s*["\']?+(?!text/javascript|module|application/javascript)~i', $script)) {
            return $script;
        }

        if (!preg_match('~^(<script\b[^>]*>)(.*)(</script\s*>)$~is', $script, $m)) {
            return $script;
        }

        $body = $m[2];
        if (trim($body) === '') {
            return $script;
        }

        $quoted = '"(?:[^"\\\\\n]|\\\\.)*"|\'(?:[^\'\\\\\n]|\\\\.)*\'';

        // title: 'Name', "text": "Saved", html: '...'
        $props = implode('|', self::JS_PROPS);
        $body = preg_replace_callback(
            '~(?<![\w$.])(["\']?)(' . $props . ')\1(\s*:\s*)(' . $quoted . ')~',
            fn ($mm) => $mm[1] . $mm[2] . $mm[1] . $mm[3] . $this->translateJsLiteral($mm[4]),
            $body
        ) ?? $body;

        $body = $this->translateJsCalls($body);

        return $m[1] . $body . $m[3];
    }

    protected function translateJsCalls(string $js): string
    {
        $quoted = '"(?:[^"\\\\\n]|\\\\.)*"|\'(?:[^\'\\\\\n]|\\\\.)*\'';

        // Swal.fire('Title', 'Text', 'icon') / swal(...) / toastr.x('Msg', 'Title')
        $js = preg_replace_callback(
            '~(?<![\w$.])(Swal\.fire|swal|toastr\.(?:success|error|warning|info))\s*\(\s*(' . $quoted . ')(?:(\s*,\s*)(' . $quoted . '))?~',
            function ($m) {
                $out = $m[1] . '(' . $this->translateJsLiteral($m[2]);
                if (isset($m[4]) && $m[4] !== '') {
                    $out .= $m[3] . $this->translateJsLiteral($m[4]);
                }

                return $out;
            },
            $js
        ) ?? $js;

        // alert('..') / confirm('..')
        $js = preg_replace_callback(
            '~(?<![\w$.])(alert|confirm)\s*\(\s*(' . $quoted . ')~',
            fn ($m) => $m[1] . '(' . $this->translateJsLiteral($m[2]),
            $js
        ) ?? $js;

        return $js;
    }

    /** Translate one quoted JS string literal (including its quotes). */
    protected function translateJsLiteral(string $literal): string
    {
        $quote = $literal[0];
        $inner = substr($literal, 1, -1);

        if ($quote === '"') {
            $decoded = json_decode($literal, true);
            if (!is_string($decoded)) {
                return $literal;
            }
        } else {
            $decoded = preg_replace_callback(
                '~\\\\(.)~s',
                fn ($m) => $m[1] === 'n' ? "\n" : $m[1],
                $inner
            );
        }

        if (strpos($decoded, '${') !== false) {
            return $literal; // template-ish, leave alone
        }

        $t = $this->lookup($decoded);
        if ($t === null) {
            return $literal;
        }

        if ($quote === '"') {
            return json_encode($t, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        return "'" . addcslashes($t, "\\'\n\r") . "'";
    }

    /* ----------------------------- head assets ------------------------- */

    protected function injectHeadAssets(string $html): string
    {
        if ($this->dir !== 'rtl' || stripos($html, '</head>') === false) {
            return $html;
        }

        // Use the template's own RTL stylesheets where they exist
        $html = preg_replace(
            '~(href\s*=\s*["\'][^"\']*?)/assets/css/((?:animated|dark|skins|style|sidemenu(?:-color|-dark)?)\.css)~i',
            '$1/assets/css-rtl/$2',
            $html
        ) ?? $html;

        $tags = "\n" . '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap">'
            . "\n" . '<link rel="stylesheet" href="' . $this->assetBase . '/assets/css/language-rtl.css?v=1">' . "\n";

        $pos = stripos($html, '</head>');

        return substr($html, 0, $pos) . $tags . substr($html, $pos);
    }
}
