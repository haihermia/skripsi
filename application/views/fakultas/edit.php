<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg">
        <form action="<?= base_url('fakultas/updateFakultas/' . $fakultas['id']); ?>" method="POST">
                <input type="hidden" name="id" value="<?= $fakultas['id']; ?>">

                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= $fakultas['name']; ?>">
                    <?= form_error('name', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= $fakultas['email']; ?>" readonly>
                    <small class="text-muted">Email tidak bisa diubah.</small>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="<?= base_url('fakultas'); ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->