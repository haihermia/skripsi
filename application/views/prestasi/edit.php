<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg">
            <form action="" method="post">
                <input type="hidden" name="id" value="<?= $prestasi['id']; ?>">

                <div class="form-group">
                    <label for="nama_prestasi">Nama Prestasi</label>
                    <input type="text" class="form-control" id="nama_prestasi" name="nama_prestasi" value="<?= $prestasi['nama_prestasi']; ?>">
                    <?= form_error('nama_prestasi', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="bidang_prestasi">Bidang Prestasi</label>
                    <input type="text" class="form-control" id="bidang_prestasi" name="bidang_prestasi" value="<?= $prestasi['bidang_prestasi']; ?>">
                    <?= form_error('bidang_prestasi', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="nama_kegiatan">Nama Kegiatan</label>
                    <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" value="<?= $prestasi['nama_kegiatan']; ?>">
                </div>

                <div class="form-group">
                    <label for="tanggal_kegiatan">Tanggal Kegiatan</label>
                    <input type="date" class="form-control" id="tanggal_kegiatan" name="tanggal_kegiatan" value="<?= $prestasi['tanggal_kegiatan']; ?>">
                </div>

                <div class="form-group">
                <label for="komponen_prestasi">Komponen Prestasi</label>
                        <select class="form-control" id="komponen_prestasi" name="komponen_prestasi" required>
                            <option value="">-- Pilih Komponen Prestasi --</option>
                            <option value="Juara Umum">Juara Umum</option>
                            <option value="Juara 1 (Nasional)">Juara 1 (Nasional)</option>
                            <option value="Juara 2 (Nasional)">Juara 2 (Nasional)</option>
                            <option value="Juara 3 (Nasional)">Juara 3 (Nasional)</option>
                            <option value="Juara Harapan 1 (Nasional)">Juara Harapan 1 (Nasional)</option>
                            <option value="Juara Harapan 2 (Nasional)">Juara Harapan 2 (Nasional)</option>
                            <option value="Juara Harapan 3 (Nasional)">Juara Harapan 3 (Nasional)</option>
                        </select>
                </div>

                <div class="form-group">
                    <label for="penyelenggara">Penyelenggara</label>
                    <input type="text" class="form-control" id="penyelenggara" name="penyelenggara" value="<?= $prestasi['penyelenggara']; ?>">
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="<?= base_url('prestasi'); ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->