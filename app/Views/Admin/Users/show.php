<?= $this->extend('Admin/layout/main'); ?>

<!-- Aqui enviamos para o template principal o título -->
<?= $this->section('title'); ?>

  <?= $title; ?>

<?= $this->endSection(); ?>


<!-- Aqui enviamos para o template principal os estilos -->
<?= $this->section('styles'); ?>



<?= $this->endSection(); ?>



<!-- Aqui enviamos para o template principal o conteúdo -->
<?= $this->section('content'); ?>
<input type="file" id="myFileInput" hidden="true"/>

<div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
  <!-- User Card -->
  <div class="card mb-4">
    <div class="card-body">
      <div class="user-avatar-section">
        <div class=" d-flex align-items-center flex-column">
          <a href="<?php echo site_url("admin/users/editPhoto"); ?>" onclick="document.getElementById('myFileInput').click()">
            <img class="img-fluid rounded my-4" src="<?= site_url('assets/img/avatars/monkito.jpeg'); ?>" height="110" width="110" alt="User avatar" />
          </a>
          <div class="user-info text-center">
            <h4 class="mb-2"><?= $user->name; ?></h4>
            <span class="badge bg-label-secondary"><?= $user->is_admin ? 'Admin' : 'Client' ?></span>
          </div>
        </div>
      </div>
      <h5 class="pb-2 border-bottom mb-4">Details</h5>
      <div class="info-container">
        <ul class="list-unstyled">
          <li class="mb-3">
            <span class="fw-medium me-2">Name:</span>
            <span><?= esc($user->name); ?></span>
          </li>
          <li class="mb-3">
            <span class="fw-medium me-2">Email:</span>
            <span><?= esc($user->email); ?></span>
          </li>
          <li class="mb-3">
            <span class="fw-medium me-2">Status:</span>
            <span class="badge <?= $user->active ? 'bg-label-primary' : 'bg-label-danger' ?>"><?= ($user->active ? 'Active' : 'Inactive'); ?></span>
          </li>
          <li class="mb-3">
            <span class="fw-medium me-2">Contact:</span>
            <span><?= esc($user->phone); ?></span>
          </li>
          <li class="mb-3">
            <span class="fw-medium me-2">Created:</span>
            <span><?= $user->created_at->humanize(); ?></span>
          </li>
          <li class="mb-3">
            <span class="fw-medium me-2">Updated:</span>
            <span><?= $user->updated_at->humanize(); ?></span>
          </li>
        </ul>
        <div class="justify-content-center">
          <?php if ($user->deleted_at == null): ?>
            <a href="<?= site_url("admin/users/edit/$user->id"); ?>" class="btn btn-sm btn-dark mr-2">
              <i class="bx bx-edit-alt tf-icons"></i>
              Edit
            </a>

            <a href="<?= site_url("admin/users/delete/$user->id"); ?>" class="btn btn-sm btn-danger mr-2">
              <i class="bx bx-trash-alt tf-icons"></i>
              Delete
            </a>
        
            <a href="<?= site_url("admin/users"); ?>" class="btn btn-sm btn-light">
              <i class="bx bx-left-arrow-alt tf-icons"></i>  
              Back
            </a>
          <?php else: ?>
            <a title="Undo deletion" href="<?= site_url("admin/users/undoDelete/$user->id"); ?>" class="btn btn-sm btn-dark mr-2">
              <i class="bx bx-undo tf-icons"></i>
              Undo
            </a>

            <a href="<?= site_url("admin/users"); ?>" class="btn btn-sm btn-light">
              <i class="bx bx-left-arrow-alt tf-icons"></i>  
              Back
            </a>

          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <!-- /User Card -->
</div>

<?= $this->endSection(); ?>


<!-- Aqui enviamos para o template principal os scripts -->
<?= $this->section('scripts'); ?>



<?= $this->endSection(); ?>