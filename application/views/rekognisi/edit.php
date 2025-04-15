<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg">
            <form action="" method="post">
                <input type="hidden" name="id" value="<?= $rekognisi['id']; ?>">

                <div class="form-group">
                    <label for="nama_rekognisi">Nama Rekognisi</label>
                    <input type="text" class="form-control" id="nama_rekognisi" name="nama_rekognisi" value="<?= $rekognisi['nama_rekognisi']; ?>">
                    <?= form_error('nama_rekognisi', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="bidang_rekognisi">Bidang Rekognisi</label>
                    <input type="text" class="form-control" id="bidang_rekognisi" name="bidang_rekognisi" value="<?= $rekognisi['bidang_rekognisi']; ?>">
                    <?= form_error('bidang_rekognisi', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="nama_kegiatan">Nama Kegiatan</label>
                    <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" value="<?= $rekognisi['nama_kegiatan']; ?>">
                </div>

                <div class="form-group">
                    <label for="tanggal_kegiatan">Tanggal Kegiatan</label>
                    <input type="date" class="form-control" id="tanggal_kegiatan" name="tanggal_kegiatan" value="<?= $rekognisi['tanggal_kegiatan']; ?>">
                </div>

                <div class="form-group">
                    <label for="komponen_rekognisi">Komponen Rekognisi</label>
                    <select class="form-control" id="komponen_rekognisi" name="komponen_rekognisi" required>
                        <option value="">-- Pilih Komponen Rekognisi --</option>
                        <option value="pemakalah/speaker seminar">Pemakalah/Speaker Seminar</option>
                        <option value="narasumber seminar">Narasumber Seminar</option>
                        <option value="peserta seminar">Peserta Seminar</option>
                        <option value="msib (studi independent)">MSIB (Studi Independent)</option>
                        <option value="msib (magang)">MSIB (Magang)</option>
                        <option value="pmm (pertukaran mahasiswa merdeka)">PMM (Pertukaran Mahasiswa Merdeka)</option>
                        <option value="membangun desa / kkn-t">Membangun Desa / KKN-T</option>
                        <option value="hki">HKI</option>
                        <option value="publikasi jurnal sinta">Publikasi Jurnal Sinta</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="penyelenggara">Penyelenggara</label>
                    <input type="text" class="form-control" id="penyelenggara" name="penyelenggara" value="<?= $rekognisi['penyelenggara']; ?>">
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="<?= base_url('rekognisi'); ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->