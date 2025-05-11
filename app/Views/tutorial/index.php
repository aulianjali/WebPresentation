<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container mt-3">
    <h2>Daftar Master Tutorial</h2>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <a href="/tutorial/create" class="btn btn-primary mb-3">+ Tambah Tutorial</a>
    
    <table class="table table-bordered" id="tutorialTable">
        <thead class="table-dark">
            <tr>
                <th class="text-center" style="width: 15%;">Judul</th>
                <th class="text-center" style="width: 15%;">Kode Matkul</th>
                <th class="text-center" style="width: 20%;">URL Presentation</th>
                <th class="text-center" style="width: 20%;">URL Finished</th>
                <th class="text-center" style="width: 15%;">Email</th>
                <th class="text-center" style="width: 15%;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tutorials as $t): ?>
            <tr>
                <td><?= esc($t['judul']) ?></td>
                <td><?= esc($t['kode_matkul']) ?></td>
                <td>
                    <a href="<?= base_url('/presentation/' . $t['url_presentation']) ?>" target="_blank">
                        <?= esc($t['url_presentation']) ?>
                    </a>
                </td>
                <td>
                    <a href="<?= base_url('/finished/' . $t['url_finished']) ?>" target="_blank">
                        <?= esc($t['url_finished']) ?>
                    </a>
                </td>
                <td><?= esc($t['creator_email']) ?></td>
                <td class="text-center">
                    <a href="/tutorial/<?= $t['id'] ?>/detail" class="btn btn-sm btn-warning">Detail</a>
                    <a href="/tutorial/delete/<?= $t['id'] ?>" onclick="return confirm('Yakin mau hapus?')" class="btn btn-sm btn-danger">Hapus</a>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
