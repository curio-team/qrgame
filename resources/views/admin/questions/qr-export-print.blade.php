<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question QR export</title>
    <style>
        @page { size: A4 portrait; margin: 10mm; }
        body { margin: 0; font-family: Arial, sans-serif; color: #111827; }
        .page {
            width: 190mm;
            min-height: 277mm;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: repeat(4, 1fr);
            gap: 5mm;
            page-break-after: always;
        }
        .page:last-child { page-break-after: auto; }
        .cell {
            border: 1px solid #e5e7eb;
            border-radius: 4mm;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3mm;
            text-align: center;
            overflow: hidden;
        }
        .qr svg { width: 42mm; height: 42mm; display: block; }
        .slug { margin-top: 2mm; font-weight: 700; font-size: 11pt; word-break: break-word; }
        .url { margin-top: 1mm; font-size: 8pt; color: #4b5563; word-break: break-all; }
        .hint {
            max-width: 190mm;
            margin: 6mm auto;
            font-size: 9pt;
            color: #374151;
            text-align: center;
        }
        @media print {
            .hint { display: none; }
        }
    </style>
</head>
<body>
    <div class="hint">Use your browser print dialog and choose “Save as PDF”.</div>

    @foreach ($questions->chunk(12) as $chunk)
        <section class="page">
            @foreach ($chunk as $question)
                <article class="cell">
                    <div class="qr">{!! $question->qr_svg !!}</div>
                    <div class="slug">{{ $question->slug }}</div>
                    <div class="url">{{ $question->qr_url }}</div>
                </article>
            @endforeach
        </section>
    @endforeach

    <script>
        window.addEventListener('load', () => window.print());
    </script>
</body>
</html>
