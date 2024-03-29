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

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Hoverable Table rows -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?= $title ?></h5>

            <div class="ui-widget">
                <input id="query" name="query" placeholder="Search.." class="form-control bg-light mb-4">
            </div>

        <a href="<?= site_url("admin/users/create"); ?>" class="btn btn-success btn-sm float-right">
            <i class="bx bx-plus tf-icons"></i>
          Create
        </a>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                    <th>Client</th>
                    <th>Users</th>
                    <th>Status</th>
                    <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <?php
                        foreach ($users as $user): ?>
                    <tr>
                        <td>
                            <a href="<?= site_url("admin/users/show/$user->id"); ?>">
                                <?= $user->name; ?>
                            </a>    
                        </td>
                        <td>
                            <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                            <li
                                data-bs-toggle="tooltip"
                                data-popup="tooltip-custom"
                                data-bs-placement="top"
                                class="avatar avatar-xs pull-up"
                                title="Lilian Fuller"
                            >
                                <img src="../assets/img/avatars/5.png" alt="Avatar" class="rounded-circle" />
                            </li>
                            <li
                                data-bs-toggle="tooltip"
                                data-popup="tooltip-custom"
                                data-bs-placement="top"
                                class="avatar avatar-xs pull-up"
                                title="Sophia Wilkerson"
                            >
                                <img src="../assets/img/avatars/6.png" alt="Avatar" class="rounded-circle" />
                            </li>
                            <li
                                data-bs-toggle="tooltip"
                                data-popup="tooltip-custom"
                                data-bs-placement="top"
                                class="avatar avatar-xs pull-up"
                                title="Christina Parker"
                            >
                                <img src="../assets/img/avatars/7.png" alt="Avatar" class="rounded-circle" />
                            </li>
                            </ul>
                        </td>
                        <td>
                            <?= $user->active ?
                                '<span class="badge bg-label-primary me-1">Active</span>' :
                                '<span class="badge bg-label-danger me-1">Inactive</span>'
                            ?>
                        </td>
                        <td>
                            <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="<?= site_url("admin/users/edit/$user->id"); ?>">
                                    <i class="bx bx-edit-alt me-1"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item" href="<?= site_url("admin/users/delete/$user->id"); ?>">
                                    <i class="bx bx-trash me-1"></i>
                                    Delete
                                </a>
                            </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="mt-3">
                <?= $pager->links(); ?>
            </div>
        </div>
    </div>
</div>
<!--/ Hoverable Table rows -->

<?= $this->endSection(); ?>


<!-- Aqui enviamos para o template principal os scripts -->
<?= $this->section('scripts'); ?>

<?= $this->endSection(); ?>