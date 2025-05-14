<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= esc($tutorial['judul']) ?> - Presentation</title>
    <meta http-equiv="refresh" content="5"> <!-- Auto refresh tiap 5 detik -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        pre {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            overflow-x: auto;
        }
        img.responsive-img {
            max-width: 100%;
            height: auto;
            max-height: 300px;
            display: block;
            margin: 10px 0;
        }
    </style>
</head>
<body class="p-4">
    <div class="container">
        <h1><?= esc($tutorial['judul']) ?></h1>
        <p><strong>Kode Matkul:</strong> <?= esc($tutorial['kode_matkul']) ?></p>
        <hr>

        <?php if (!empty($details)): ?>
            <?php $i = 1; ?>
            <?php foreach ($details as $d): ?>
                <?php if ($d['status'] === 'show'): ?>
                    <div class="mb-4 border-bottom pb-3">
                        <h4>Langkah <?= $i++ ?>.</h4>

                        <?php if (!empty($d['text'])): ?>
                            <p><?= esc($d['text']) ?></p>
                        <?php endif; ?>

                        <?php if (!empty($d['url'])): ?>
                            <p><a href="<?= esc($d['url']) ?>" target="_blank"><?= esc($d['url']) ?></a></p>
                        <?php endif; ?>

                        <?php if (!empty($d['image'])): ?>
                            <p>
                                <img src="<?= base_url('uploads/images/' . esc($d['image'])) ?>" alt="Gambar" class="responsive-img">
                            </p>
                        <?php endif; ?>

                        <?php if (!empty($d['code'])): ?>
                            <pre><code><?= esc($d['code']) ?></code></pre>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Tidak ada detail tutorial untuk ditampilkan.</p>
        <?php endif; ?>
    </div>
</body>
</html>
