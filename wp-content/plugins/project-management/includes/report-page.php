<?php

$projectCounts = count(get_posts([
    'numberposts' => -1,
    'post_type' => 'project',
     'post_status' => 'publish',
]));

$allProject = get_posts([
    'numberposts' => -1,
    'post_type' => 'project',
    'post_status' => 'publish',
]);

$projectPending = 0;
$projectInProgress = 0;
$projectCompleted = 0;

foreach ($allProject as $project) {
    $projectStatus = get_post_meta($project->ID, '_status', true);
    if ($projectStatus == 'pending') {
        $projectPending++;
    } elseif ($projectStatus == 'in_progress') {
        $projectInProgress++;
    } elseif ($projectStatus == 'completed') {
        $projectCompleted++;
    }
}
?>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>

<!-- Popper JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<div class="row" style="margin-bottom: 40px;">
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Projects</h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <a href="/admin/product/list"><i class="align-middle" data-feather="monitor"></i></a>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3"> <?= $projectCounts ?></h1>
                <div class="mb-0" style="padding-bottom: 22px;">
                    <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Pending</h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <a href="/admin/users"><i class="align-middle" data-feather="users"></i></a>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3"><?= $projectPending ?></h1>
                <div class="mb-0" style="padding-bottom: 22px;">
                    <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">In Progress</h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle" data-feather="dollar-sign"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3"><?= $projectInProgress ?></h1>
                <div class="mb-0" style="padding-bottom: 22px;">
                    <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Completed</h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <a href="/admin/order/lists"> <i class="align-middle" data-feather="shopping-cart"></i></a>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3"><?= $projectCompleted   ?></h1>
                <div class="mb-0">
                    <div class="mb-0" style="padding-bottom: 22px;">
                        <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>