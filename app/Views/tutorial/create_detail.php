<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2>Tambah Detail Tutorial : <?= esc($tutorial['judul']) ?></h2>
    <form id="form-detail" action="<?= isset($detail) ? '/tutorial/detail/update/' . $tutorial['id'] . '/' . $detail['id'] : '/tutorial/detail/store/' . $tutorial['id'] ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label for="text" class="form-label">Text</label>
            <textarea class="form-control" id="text" name="text" rows="5" placeholder="Isi teks tutorial..."><?= esc($detail['text'] ?? '') ?></textarea>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="order" class="form-label">Urutan (Order)</label>
                <input type="number" class="form-control" id="order" name="tutor_order" value="<?= esc($detail['tutor_order'] ?? 1) ?>" min="1">
            </div>
            <div class="col-md-6">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="show" <?= isset($detail['status']) && $detail['status'] === 'show' ? 'selected' : '' ?>>Show</option>
                    <option value="hide" <?= isset($detail['status']) && $detail['status'] === 'hide' ? 'selected' : '' ?>>Hide</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label for="url_optional" class="form-label">URL (Opsional)</label>
            <input type="url" class="form-control" id="url" name="url" value="<?= esc($detail['url'] ?? '') ?>" placeholder="https://...">
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Gambar (Opsional)</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
            <?php if (!empty($detail['image'])): ?>
                <small class="d-block mt-1">Gambar saat ini: <a href="<?= base_url('uploads/' . $detail['image']) ?>" target="_blank"><?= esc($detail['image']) ?></a></small>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="code" class="form-label">Code Program (Opsional)</label>
            <textarea class="form-control" id="code" name="code" rows="5" placeholder="Contoh code..."><?= esc($detail['code'] ?? '') ?></textarea>
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Update Tutorial</button>
            <a href="/tutorial/<?= $tutorial['id'] ?>/detail" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<script>
document.getElementById('form-detail').addEventListener('submit', function(e) {
    const text  = document.getElementById('text').value.trim();
    const code  = document.getElementById('code').value.trim();
    const url   = document.getElementById('url').value.trim();
    const image = document.getElementById('image').value;

    if (!text && !code && !url && !image) {
        e.preventDefault();
        alert('Minimal isi salah satu field!');
    }
});
</script>

<?= $this->endSection() ?>
