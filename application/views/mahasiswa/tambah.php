<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <!-- Notifikasi (jika ada) -->
    <?= $this->session->flashdata('message'); ?>

    <div class="card shadow">
        <div class="card-body">
            <form action="<?= base_url('mahasiswa/tambah'); ?>" method="POST">
                <div class="form-group">
                    <label for="nim">NIM</label>
                    <input type="text" class="form-control" id="nim" name="nim" value="<?= set_value('nim'); ?>" required>
                    <?= form_error('nim', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="nama_mahasiswa">Nama Mahasiswa</label>
                    <input type="text" class="form-control" id="nama_mahasiswa" name="nama_mahasiswa" value="<?= set_value('nama_mahasiswa'); ?>" required>
                    <?= form_error('nama_mahasiswa', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= set_value('email'); ?>" required>
                    <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="program_studi">Program Studi</label>
                    <input type="text" class="form-control" id="program_studi" name="program_studi" value="<?= set_value('program_studi'); ?>" required>
                    <?= form_error('program_studi', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="fakultas">Fakultas</label>
                    <input type="text" class="form-control" id="fakultas" name="fakultas" value="<?= set_value('fakultas'); ?>" required>
                    <?= form_error('fakultas', '<small class="text-danger">', '</small>'); ?>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('mahasiswa'); ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->