<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR PDF Export</title>
    <style>
        body { font-family: Inter, Arial, sans-serif; margin: 0; background: #f5f5f5; color: #1f2937; }
        .container { max-width: 960px; margin: 2rem auto; background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 8px 32px rgba(0,0,0,.08); }
        h1 { margin-top: 0; font-size: 1.5rem; }
        .toolbar { display: flex; gap: .75rem; align-items: center; margin-bottom: 1rem; }
        button { border: 0; border-radius: 8px; padding: .6rem 1rem; cursor: pointer; font-weight: 600; }
        .btn-primary { background: #f59e0b; color: #111827; }
        .btn-muted { background: #e5e7eb; color: #111827; }
        .list { max-height: 60vh; overflow: auto; border: 1px solid #e5e7eb; border-radius: 10px; }
        .row { display: grid; grid-template-columns: auto 1fr auto; gap: .75rem; align-items: start; padding: .75rem 1rem; border-bottom: 1px solid #f1f5f9; }
        .row:last-child { border-bottom: 0; }
        .slug { font-weight: 700; }
        .type { font-size: .75rem; color: #475569; text-transform: uppercase; letter-spacing: .08em; }
        .text { color: #334155; font-size: .9rem; margin-top: .2rem; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Export question QR codes</h1>
        <p>Select the codes you want to export, then print and save as PDF. The print layout is fixed to an A4 page with a 3×4 QR grid.</p>

        <form method="GET" action="{{ route('admin.questions.qr-export.print') }}" target="_blank">
            <div class="toolbar">
                <button class="btn-muted" type="button" id="select-all">Select all</button>
                <button class="btn-muted" type="button" id="clear-all">Clear all</button>
                <button class="btn-primary" type="submit">Generate PDF layout</button>
            </div>

            <div class="list">
                @foreach ($questions as $question)
                    <label class="row">
                        <input type="checkbox" name="question_ids[]" value="{{ $question->id }}" checked>
                        <span>
                            <div class="slug">{{ $question->slug }}</div>
                            <div class="text">{{ $question->text ?? '—' }}</div>
                        </span>
                        <span class="type">{{ $question->type }}</span>
                    </label>
                @endforeach
            </div>
        </form>
    </div>

    <script>
        const all = [...document.querySelectorAll('input[name="question_ids[]"]')];
        document.getElementById('select-all').addEventListener('click', () => all.forEach(input => input.checked = true));
        document.getElementById('clear-all').addEventListener('click', () => all.forEach(input => input.checked = false));
    </script>
</body>
</html>
