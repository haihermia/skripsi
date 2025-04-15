<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <!-- Notifikasi (jika ada) -->
    <?= $this->session->flashdata('message'); ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <!-- Tombol Tambah Data -->
            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#tambahRekognisiModal">
                Tambah Data Rekognisi
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama Rekognisi</th>
                            <th>Bidang Rekognisi</th>
                            <th>Nama Kegiatan</th>
                            <th>Tanggal Kegiatan</th>
                            <th>Komponen Rekognisi</th>
                            <th>Penyelenggara</th>
                            <th>Bukti</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($rekognisi as $p) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $p['nim']; ?></td>
                                <td><?= $p['nama_rekognisi']; ?></td>
                                <td><?= $p['bidang_rekognisi']; ?></td>
                                <td><?= $p['nama_kegiatan']; ?></td>
                                <td><?= date('d-m-Y', strtotime($p['tanggal_kegiatan'])); ?></td>
                                <td><?= $p['komponen_rekognisi']; ?></td>
                                <td><?= $p['penyelenggara']; ?></td>
                                <td><a href="<?= base_url() . 'uploads/bukti/' . $p['bukti']; ?>">Lihat</a></td>

                                <td style="white-space: nowrap; text-align: center;">
                                    <div class="btn-group">
                                        <a href="<?= base_url('rekognisi/editRekognisi/') . $p['id']; ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="<?= base_url('rekognisi/hapusRekognisi/') . $p['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?');">
                                            <i class="fas fa-trash"></i> Hapus
                                        </a>
                                    </div>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->

<!-- Modal Tambah Data -->
<div class="modal fade" id="tambahRekognisiModal" tabindex="-1" aria-labelledby="tambahRekognisiLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahRekognisiLabel">Tambah Data Rekognisi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('rekognisi/tambah'); ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nim">NIM</label>
                        <input type="number" class="form-control" id="nim" name="nim" required disabled value="<?= $mahasiswa['nim']?>">
                    </div>
                    <div class="form-group">
                        <label for="nama_rekognisi">Nama Rekognisi</label>
                        <input type="text" class="form-control" id="nama_rekognisi" name="nama_rekognisi" required>
                    </div>
                    <div class="form-group">
                        <label for="bidang_rekognisi">Bidang Rekognisi</label>
                        <input type="text" class="form-control" id="bidang_rekognisi" name="bidang_rekognisi" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_kegiatan">Nama Kegiatan</label>
                        <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_kegiatan">Tanggal Kegiatan</label>
                        <input type="date" class="form-control" id="tanggal_kegiatan" name="tanggal_kegiatan" required>
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
                        <input type="text" class="form-control" id="penyelenggara" name="penyelenggara" required>
                    </div>
                    <div class="form-group">
                        <label for="bukti">Bukti (URL/File)</label>
                        <input type="file" class="form-control" id="bukti" name="bukti" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>