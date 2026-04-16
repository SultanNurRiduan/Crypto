<?php
function fpb(int $m, int $n): array
{
    $steps = [];
    while ($n !== 0) {
        $q    = intdiv($m, $n);
        $sisa = $m % $n;
        $steps[] = ['a' => $m, 'b' => $n, 'q' => $q, 'r' => $sisa];
        $temp = $n;
        $n    = $m % $n;
        $m    = $temp;
    }
    return ['hasil' => $m, 'steps' => $steps];
}

$mVal = 224;
$nVal = 324;
$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mVal = (int)($_POST['m'] ?? 224);
    $nVal = (int)($_POST['n'] ?? 324);
    if ($mVal > 0 && $nVal > 0) {
        $result = fpb($mVal, $nVal);
    }
} else {
    $result = fpb($mVal, $nVal);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator FPB Euclidean</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 2rem 1rem;
            background: #0f0c29;
            position: relative;
            overflow-x: hidden;
        }

        /* ── Background ── */
        .bg-gradient {
            position: fixed;
            inset: 0;
            z-index: 0;
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
        }

        .blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.55;
            z-index: 0;
            pointer-events: none;
        }

        .blob-1 {
            width: 420px;
            height: 420px;
            background: #7f5af0;
            top: -100px;
            left: -80px;
        }

        .blob-2 {
            width: 380px;
            height: 380px;
            background: #2cb67d;
            bottom: -100px;
            right: -60px;
        }

        .blob-3 {
            width: 300px;
            height: 300px;
            background: #e879f9;
            top: 40%;
            left: 50%;
            transform: translateX(-50%);
        }

        /* ── Card Glass ── */
        .card {
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 20px;
            padding: 2rem;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.35);
        }

        h1 {
            font-size: 20px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 1.5rem;
            letter-spacing: -0.01em;
        }

        /* ── Form ── */
        .field {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.65);
            margin-bottom: 5px;
        }

        input[type=number] {
            width: 100%;
            padding: 9px 12px;
            font-size: 14px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.10);
            color: #fff;
            font-family: inherit;
            outline: none;
            transition: border-color .2s, background .2s;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            filter: invert(1) opacity(0.5);
        }

        input[type=number]:focus {
            border-color: rgba(127, 90, 240, 0.85);
            background: rgba(255, 255, 255, 0.16);
        }

        .btn {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            background: rgba(127, 90, 240, 0.45);
            color: #fff;
            font-family: inherit;
            margin-top: .5rem;
            letter-spacing: .01em;
            transition: background .2s, transform .1s;
        }

        .btn:hover {
            background: rgba(127, 90, 240, 0.68);
        }

        .btn:active {
            transform: scale(0.98);
        }

        /* ── Result Box ── */
        .result-box {
            margin-top: 1.5rem;
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 14px;
            padding: 1.25rem 1.4rem;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .result-main {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.88);
            line-height: 1.75;
        }

        .result-main strong {
            color: #fff;
        }

        .result-note {
            display: inline-block;
            font-size: 13px;
            font-weight: 600;
            margin-top: 10px;
            padding: 5px 11px;
            border-radius: 8px;
        }

        .result-note {
            background: rgba(44, 182, 125, 0.18);
            color: #5de0a0;
            border: 1px solid rgba(44, 182, 125, 0.3);
        }

        .result-note.not-coprime {
            background: rgba(232, 121, 249, 0.15);
            color: #e879f9;
            border: 1px solid rgba(232, 121, 249, 0.3);
        }

        /* ── Steps ── */
        .steps {
            margin-top: 14px;
        }

        .steps-title {
            font-size: 11px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.38);
            text-transform: uppercase;
            letter-spacing: .07em;
            margin-bottom: 8px;
        }

        .step-row {
            font-size: 13px;
            font-family: 'Courier New', monospace;
            color: rgba(255, 255, 255, 0.72);
            padding: 5px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.07);
        }

        .step-row:last-child {
            border-bottom: none;
        }

        .step-highlight {
            color: #a78bfa;
            font-weight: 700;
        }
    </style>
</head>
<body>

    <!-- Background layers -->
    <div class="bg-gradient"></div>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>

    <!-- Glass card -->
    <div class="card">
        <h1>Kalkulator FPB Euclidean</h1>

        <form method="POST">
            <div class="field">
                <label>Angka 1 (Nilai A)</label>
                <input type="number" name="m" value="<?= htmlspecialchars($mVal) ?>" min="1" required>
            </div>
            <div class="field">
                <label>Angka 2 (Nilai B)</label>
                <input type="number" name="n" value="<?= htmlspecialchars($nVal) ?>" min="1" required>
            </div>
            <button type="submit" class="btn">Hitung FPB</button>
        </form>

        <?php if ($result): ?>
            <?php
                $hasil        = $result['hasil'];
                $steps        = $result['steps'];
                $relatifPrima = ($hasil === 1);
            ?>
            <div class="result-box">
                <p class="result-main">
                    FPB dari <strong><?= $mVal ?></strong> dan <strong><?= $nVal ?></strong> adalah:
                    <strong><?= $hasil ?></strong>
                </p>
                <span class="result-note <?= $relatifPrima ? '' : 'not-coprime' ?>">
                    <?= $relatifPrima
                        ? 'Kedua angka RELATIF PRIMA'
                        : 'TIDAK relatif prima (FPB = ' . $hasil . ')' ?>
                </span>
                <div class="steps">
                    <div class="steps-title">Langkah-langkah Euclidean</div>
                    <?php foreach ($steps as $s): ?>
                        <div class="step-row">
                            <?= $s['a'] ?> = <?= $s['q'] ?> &times; <?= $s['b'] ?> +
                            <span class="step-highlight"><?= $s['r'] ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>