<div class="card shadow-sm border-bottom-primary">
    <div class="card-header bg-white py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                    Detail Barang - <?= $barang['nama_barang']; ?>
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('barang') ?>" class="btn btn-sm btn-secondary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-arrow-left"></i>
                    </span>
                    <span class="text">
                        Kembali
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>ID Barang</th>
                <td><?= $barang['id_barang']; ?></td>
            </tr>
            <tr>
                <th>Nama Barang</th>
                <td><?= $barang['nama_barang']; ?></td>
            </tr>
            <tr>
                <th>Stok</th>
                <td><?= $barang['stok']; ?></td>
            </tr>
        </table>
        <hr>
        <h5>Detail Stok Barang</h5>
        <div class="table-responsive">
            <table class="table table-striped w-100 dt-responsive nowrap" id="dataTable">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Serial Number</th>
                        <th>Merk</th>
                        <th>Tipe</th>
                        <th>Kondisi</th>
                        <th>Lokasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    if ($detail_barang) :
                        foreach ($detail_barang as $d) :
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $d['serial_number']; ?></td>
                                <td><?= $d['merk']; ?></td>
                                <td><?= $d['tipe']; ?></td>
                                <td><?= $d['kondisi']; ?></td>
                                <td><?= $d['location']; ?></td>
                                <td>
                                    <a href="<?= base_url('barang/edit_detail/') . $d['id_detail'] ?>" class="btn btn-warning btn-circle btn-sm"><i class="fa fa-edit"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center">
                                Data Kosong
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>