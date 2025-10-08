<?php $__env->startSection('title', 'Data Periode'); ?>
<?php $__env->startSection('page-title', 'Data Periode'); ?>
<?php $__env->startSection('menu-periode', 'active'); ?>

<?php $__env->startSection('content'); ?>
<section class="section">
  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Data Periode</h4>
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambah" style="border-radius: 0;">
                <i class="fas fa-plus"></i> Tambah Periode
            </button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped" id="table-1">
                <thead>
                  <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Periode</th>
                    <th class="text-center">Deskripsi</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $__empty_1 = true; $__currentLoopData = $periodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $periode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                  <tr>
                    <td class="text-center"><?php echo e($index + 1); ?></td>
                    <td class="text-center"><?php echo e($periode->nama_periode); ?></td>
                    <td class="text-center"><?php echo e($periode->deskripsi ?? '-'); ?></td>
                    <td class="text-center">
                      <button class="btn btn-warning btn-sm btn-edit" 
                        data-id="<?php echo e($periode->id_periode); ?>" 
                        data-nama="<?php echo e($periode->nama_periode); ?>" 
                        data-deskripsi="<?php echo e($periode->deskripsi ?? ''); ?>">
                        <i class="fas fa-edit"></i> Edit
                      </button>
                      <form action="<?php echo e(route('periode.destroy', $periode->id_periode)); ?>" method="POST" class="d-inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="button" class="btn btn-danger btn-sm btn-hapus">
                          <i class="fas fa-trash"></i> Hapus
                        </button>
                      </form>
                    </td>
                  </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                  <tr>
                    <td colspan="4" class="text-center">Data tabel masih kosong</td>
                  </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

      <!-- Modal Tambah -->
      <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <form action="<?php echo e(route('periode.store')); ?>" method="POST">
              <?php echo csrf_field(); ?>
              <div class="modal-header">
                <h5 class="modal-title">Tambah Periode</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label>Nama Periode</label>
                  <input type="text" name="nama_periode" class="form-control" required>
                </div>
                <div class="form-group">
                  <label>Deskripsi</label>
                  <textarea name="deskripsi" class="form-control"></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Periode</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Modal Edit Tunggal -->
      <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <form id="formEdit" method="POST">
              <?php echo csrf_field(); ?>
              <?php echo method_field('PUT'); ?>
              <div class="modal-header">
                <h5 class="modal-title">Edit Periode</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label>Nama Periode</label>
                  <input type="text" name="nama_periode" id="editNama" class="form-control" required>
                </div>
                <div class="form-group">
                  <label>Deskripsi</label>
                  <textarea name="deskripsi" id="editDeskripsi" class="form-control"></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
              </div>
            </form>
          </div>
        </div>
      </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
<script>
$(document).ready(function() {
    $("#table-1").DataTable({ "columnDefs": [{ "orderable": false, "targets": 3 }] });

    // Hapus
    $(document).on('click', '.btn-hapus', function(e) {
        e.preventDefault();
        const form = $(this).closest('form');
        Swal.fire({
            title: 'Hapus Data?',
            text: "Data periode ini akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // Edit modal
    $(document).on('click', '.btn-edit', function() {
        const id = $(this).data('id');
        const nama = $(this).data('nama');
        const deskripsi = $(this).data('deskripsi');
        $('#editNama').val(nama);
        $('#editDeskripsi').val(deskripsi);
        $('#formEdit').attr('action', '/periode/' + id);
        $('#modalEdit').modal('show');
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Management_Gereja\resources\views/dashboard.blade.php ENDPATH**/ ?>