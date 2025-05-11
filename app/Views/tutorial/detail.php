<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<h2 class="mt-3 mb-2">Detail Tutorial: <?= esc($tutorial['judul']) ?></h2>


<div class="mb-4">
    <a href="/tutorial/<?= $tutorial['id'] ?>/detail/create_detail" class="btn btn-success me-2">+ Tambah Detail Tutorial</a>
</div>


<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success mb-4"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>


<table class="table table-bordered table-striped" style="table-layout: fixed; width: 100%;">
    <thead class="table-dark">
        <tr>
            <th style="width: 8%;" class="text-center">Urutan</th>
            <th style="width: 20%;" class="text-center">Text</th>
            <th style="width: 14%;" class="text-center">Code</th>
            <th style="width: 22%;" class="text-center">URL</th>
            <th style="width: 12%;" class="text-center">Image</th>
            <th style="width: 10%;" class="text-center">Status</th>
            <th style="width: 14%;" class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($details as $detail): ?>
            <tr>
                <td class="text-center"><?= esc($detail['tutor_order']) ?></td>
                <td class="text-wrap text-break"><?= esc($detail['text']) ?></td>
                <td class="text-center">
                    <?php if (!empty(trim($detail['code']))): ?>
                        <button class="btn btn-outline-dark btn-sm" data-bs-toggle="modal" data-bs-target="#codeModal<?= $detail['id'] ?>">
                            Lihat Code
                        </button>

                        <div class="modal fade" id="codeModal<?= $detail['id'] ?>" tabindex="-1" aria-labelledby="codeModalLabel<?= $detail['id'] ?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="codeModalLabel<?= $detail['id'] ?>">Code (Urutan <?= esc($detail['tutor_order']) ?>)</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <pre class="text-start" style="white-space: pre-wrap; font-size: 13px; font-family: monospace; background:#f8f9fa; border:1px solid #ccc; padding:10px; border-radius:5px;"><?= esc($detail['code']) ?></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <em class="text-muted">Tidak ada</em>
                    <?php endif; ?>
                </td>
                <td class="text-wrap text-break">
                    <?php if (!empty($detail['url'])): ?>
                        <a href="<?= esc($detail['url']) ?>" target="_blank"><?= esc($detail['url']) ?></a>
                    <?php else: ?>
                        <em class="text-muted">Tidak ada</em>
                    <?php endif; ?>
                </td>
                <td class="text-center">
                    <?php if (!empty($detail['image'])): ?>
                        <img src="/uploads/images/<?= esc($detail['image']) ?>" alt="Image" style="max-height: 50px; max-width: 100%; object-fit: contain;">
                    <?php else: ?>
                        <em class="text-muted">Tidak ada</em>
                    <?php endif; ?>
                </td>
                <td class="text-center">
                    <form action="/tutorial/<?= $tutorial['id'] ?>/detail/<?= $detail['id'] ?>/toggle" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="status" value="<?= $detail['status'] === 'show' ? 'hide' : 'show' ?>">
                        <button class="btn btn-sm <?= $detail['status'] === 'show' ? 'btn-success' : 'btn-secondary' ?>">
                            <?= ucfirst($detail['status']) ?>
                        </button>
                    </form>
                </td>
                <td class="text-center">
                    <a href="/tutorial/<?= $tutorial['id'] ?>/detail/create_detail/<?= $detail['id'] ?>" class="btn btn-sm btn-warning me-2">Edit</a>
                    <form action="/tutorial/<?= $tutorial['id'] ?>/detail/<?= $detail['id'] ?>/delete" method="post" style="display:inline;" onsubmit="return confirm('Yakin hapus?')">
                        <?= csrf_field() ?>
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?php if (empty($details)): ?>
    <p class="text-muted">Belum ada detail tutorial.</p>
<?php endif; ?>


<div class="d-flex justify-content-end mt-4">
    <a href="/tutorial" class="btn btn-secondary">← Kembali ke Daftar</a>
</div>

<style>
    td, th {
        word-wrap: break-word;
        white-space: normal;
        vertical-align: middle;
    }
    table img {
        display: block;
        margin: 0 auto;
    }
</style>

<?= $this->endSection() ?>
