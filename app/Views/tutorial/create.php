<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2>Tambah Tutorial</h2>
    <form action="/tutorial/save" method="post">
        <div class="mb-3">
            <label for="judul" class="form-label">Judul Tutorial</label>
            <input type="text" name="judul" id="judul" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="kode_matkul" class="form-label">Mata Kuliah</label>
            <select name="kode_matkul" id="kode_matkul" class="form-control" required>
                <option value="">-- Pilih Mata Kuliah --</option>
                <?php if (!empty($matkuls)): ?>
                    <?php foreach ($matkuls as $matkul): ?>
                        <option value="<?= esc($matkul['kdmk']) ?>">
                            <?= esc($matkul['kdmk']) ?> - <?= esc($matkul['nama']) ?>
                        </option>
                    <?php endforeach ?>
                <?php else: ?>
                    <option value="">Data mata kuliah tidak tersedia</option>
                <?php endif ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<?= $this->endSection() ?>
