<?= $this->extend('layouts/dashboard/app'); ?>

<?= $this->section('page_title'); ?>
<?= $pageTitle ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-lg-8">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-md-flex align-items-center">
                    <div>
                        <h4 class="card-title">Sales Overview</h4>
                        <p class="card-subtitle">
                            Ample admin Vs Pixel admin
                        </p>
                    </div>
                    <div class="ms-auto">
                        <ul class="list-unstyled mb-0">
                            <li class="list-inline-item text-primary">
                                <span class="round-8 text-bg-primary rounded-circle me-1 d-inline-block"></span>
                                Ample
                            </li>
                            <li class="list-inline-item text-info">
                                <span class="round-8 text-bg-info rounded-circle me-1 d-inline-block"></span>
                                Pixel Admin
                            </li>
                        </ul>
                    </div>
                </div>
                <div id="sales-overview" class="mt-4 mx-n6"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card overflow-hidden">
            <div class="card-body pb-0">
                <div class="d-flex align-items-start">
                    <div>
                        <h4 class="card-title">Weekly Stats</h4>
                        <p class="card-subtitle">Average sales</p>
                    </div>
                    <div class="ms-auto">
                        <div class="dropdown">
                            <a href="javascript:void(0)" class="text-muted" id="year1-dropdown" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="ti ti-dots fs-7"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="year1-dropdown">
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)">Action</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)">Another action</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)">Something else here</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="mt-4 pb-3 d-flex align-items-center">
                    <span class="btn btn-primary rounded-circle round-48 hstack justify-content-center">
                        <i class="ti ti-shopping-cart fs-6"></i>
                    </span>
                    <div class="ms-3">
                        <h5 class="mb-0 fw-bolder fs-4">Top Sales</h5>
                        <span class="text-muted fs-3">Johnathan Doe</span>
                    </div>
                    <div class="ms-auto">
                        <span class="badge bg-secondary-subtle text-muted">+68%</span>
                    </div>
                </div>
                <div class="py-3 d-flex align-items-center">
                    <span class="btn btn-warning rounded-circle round-48 hstack justify-content-center">
                        <i class="ti ti-star fs-6"></i>
                    </span>
                    <div class="ms-3">
                        <h5 class="mb-0 fw-bolder fs-4">Best Seller</h5>
                        <span class="text-muted fs-3">MaterialPro Admin</span>
                    </div>
                    <div class="ms-auto">
                        <span class="badge bg-secondary-subtle text-muted">+68%</span>
                    </div>
                </div>
                <div class="py-3 d-flex align-items-center">
                    <span class="btn btn-success rounded-circle round-48 hstack justify-content-center">
                        <i class="ti ti-message-dots fs-6"></i>
                    </span>
                    <div class="ms-3">
                        <h5 class="mb-0 fw-bolder fs-4">Most Commented</h5>
                        <span class="text-muted fs-3">Ample Admin</span>
                    </div>
                    <div class="ms-auto">
                        <span class="badge bg-secondary-subtle text-muted">+68%</span>
                    </div>
                </div>
                <div class="pt-3 mb-7 d-flex align-items-center">
                    <span class="btn btn-secondary rounded-circle round-48 hstack justify-content-center">
                        <i class="ti ti-diamond fs-6"></i>
                    </span>
                    <div class="ms-3">
                        <h5 class="mb-0 fw-bolder fs-4">Top Budgets</h5>
                        <span class="text-muted fs-3">Sunil Joshi</span>
                    </div>
                    <div class="ms-auto">
                        <span class="badge bg-secondary-subtle text-muted">+15%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-md-flex align-items-center">
                    <div>
                        <h4 class="card-title">Products Performance</h4>
                        <p class="card-subtitle">
                            Ample Admin Vs Pixel Admin
                        </p>
                    </div>
                    <div class="ms-auto mt-3 mt-md-0">
                        <select class="form-select theme-select border-0" aria-label="Default select example">
                            <option value="1">March 2025</option>
                            <option value="2">March 2025</option>
                            <option value="3">March 2025</option>
                        </select>
                    </div>
                </div>
                <div class="table-responsive mt-4">
                    <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
                        <thead>
                            <tr>
                                <th scope="col" class="px-0 text-muted">
                                    Assigned
                                </th>
                                <th scope="col" class="px-0 text-muted">Name</th>
                                <th scope="col" class="px-0 text-muted">
                                    Priority
                                </th>
                                <th scope="col" class="px-0 text-muted text-end">
                                    Budget
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-0">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= base_url() ?>img/profile/user-3.jpg" class="rounded-circle" width="40"
                                            alt="flexy" />
                                        <div class="ms-3">
                                            <h6 class="mb-0 fw-bolder">Sunil Joshi</h6>
                                            <span class="text-muted">Web Designer</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-0">Elite Admin</td>
                                <td class="px-0">
                                    <span class="badge bg-info">Low</span>
                                </td>
                                <td class="px-0 text-dark fw-medium text-end">
                                    $3.9K
                                </td>
                            </tr>
                            <tr>
                                <td class="px-0">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= base_url() ?>img/profile/user-5.jpg" class="rounded-circle" width="40"
                                            alt="flexy" />
                                        <div class="ms-3">
                                            <h6 class="mb-0 fw-bolder">
                                                Andrew McDownland
                                            </h6>
                                            <span class="text-muted">Project Manager</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-0">Real Homes WP Theme</td>
                                <td class="px-0">
                                    <span class="badge text-bg-primary">Medium</span>
                                </td>
                                <td class="px-0 text-dark fw-medium text-end">
                                    $24.5K
                                </td>
                            </tr>
                            <tr>
                                <td class="px-0">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= base_url() ?>img/profile/user-6.jpg" class="rounded-circle" width="40"
                                            alt="flexy" />
                                        <div class="ms-3">
                                            <h6 class="mb-0 fw-bolder">
                                                Christopher Jamil
                                            </h6>
                                            <span class="text-muted">SEO Manager</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-0">MedicalPro WP Theme</td>
                                <td class="px-0">
                                    <span class="badge bg-warning">Hight</span>
                                </td>
                                <td class="px-0 text-dark fw-medium text-end">
                                    $12.8K
                                </td>
                            </tr>
                            <tr>
                                <td class="px-0">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= base_url() ?>img/profile/user-7.jpg" class="rounded-circle" width="40"
                                            alt="flexy" />
                                        <div class="ms-3">
                                            <h6 class="mb-0 fw-bolder">Nirav Joshi</h6>
                                            <span class="text-muted">Frontend Engineer</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-0">Hosting Press HTML</td>
                                <td class="px-0">
                                    <span class="badge bg-danger">Low</span>
                                </td>
                                <td class="px-0 text-dark fw-medium text-end">
                                    $2.4K
                                </td>
                            </tr>
                            <tr>
                                <td class="px-0">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= base_url() ?>img/profile/user-8.jpg" class="rounded-circle" width="40"
                                            alt="flexy" />
                                        <div class="ms-3">
                                            <h6 class="mb-0 fw-bolder">Micheal Doe</h6>
                                            <span class="text-muted">Content Writer</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-0">Helping Hands WP Theme</td>
                                <td class="px-0">
                                    <span class="badge bg-success">Low</span>
                                </td>
                                <td class="px-0 text-dark fw-medium text-end">
                                    $9.3K
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <!-- Card -->
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-0">Recent Comments</h4>
            </div>
            <div class="comment-widgets scrollable mb-2 common-widget" style="height: 465px" data-simplebar="">
                <!-- Comment Row -->
                <div class="d-flex flex-row comment-row border-bottom p-3 gap-3">
                    <div>
                        <span><img src="<?= base_url() ?>img/profile/user-3.jpg" class="rounded-circle" alt="user"
                                width="50" /></span>
                    </div>
                    <div class="comment-text w-100">
                        <h6 class="fw-medium">James Anderson</h6>
                        <p class="mb-1 fs-2 text-muted">
                            Lorem Ipsum is simply dummy text of the printing and
                            type etting industry
                        </p>
                        <div class="comment-footer mt-2">
                            <div class="d-flex align-items-center">
                                <span class="
                              badge
                              bg-info-subtle
                              text-info
                              
                            ">Pending</span>
                                <span class="action-icons">
                                    <a href="javascript:void(0)" class="ps-3"><i class="ti ti-edit fs-5"></i></a>
                                    <a href="javascript:void(0)" class="ps-3"><i class="ti ti-check fs-5"></i></a>
                                    <a href="javascript:void(0)" class="ps-3"><i class="ti ti-heart fs-5"></i></a>
                                </span>
                            </div>
                            <span class="
                            text-muted
                            ms-auto
                            fw-normal
                            fs-2
                            d-block
                            mt-2
                            text-end
                          ">April 14, 2025</span>
                        </div>
                    </div>
                </div>
                <!-- Comment Row -->
                <div class="d-flex flex-row comment-row border-bottom active p-3 gap-3">
                    <div>
                        <span><img src="<?= base_url() ?>img/profile/user-5.jpg" class="rounded-circle" alt="user"
                                width="50" /></span>
                    </div>
                    <div class="comment-text active w-100">
                        <h6 class="fw-medium">Michael Jorden</h6>
                        <p class="mb-1 fs-2 text-muted">
                            Lorem Ipsum is simply dummy text of the printing and
                            type setting industry.
                        </p>
                        <div class="comment-footer mt-2">
                            <div class="d-flex align-items-center">
                                <span class="
                              badge
                              bg-success-subtle
                              text-success
                              
                            ">Approved</span>
                                <span class="action-icons active">
                                    <a href="javascript:void(0)" class="ps-3"><i class="ti ti-edit fs-5"></i></a>
                                    <a href="javascript:void(0)" class="ps-3"><i class="ti ti-circle-x fs-5"></i></a>
                                    <a href="javascript:void(0)" class="ps-3"><i class="ti ti-heart text-danger fs-5"></i></a>
                                </span>
                            </div>
                            <span class="
                            text-muted
                            ms-auto
                            fw-normal
                            fs-2
                            text-end
                            mt-2
                            d-block
                          ">April 14, 2025</span>
                        </div>
                    </div>
                </div>
                <!-- Comment Row -->
                <div class="d-flex flex-row comment-row border-bottom p-3 gap-3">
                    <div>
                        <span><img src="<?= base_url() ?>img/profile/user-6.jpg" class="rounded-circle" alt="user"
                                width="50" /></span>
                    </div>
                    <div class="comment-text w-100">
                        <h6 class="fw-medium">Johnathan Doeting</h6>
                        <p class="mb-1 fs-2 text-muted">
                            Lorem Ipsum is simply dummy text of the printing and
                            type setting industry.
                        </p>
                        <div class="comment-footer mt-2">
                            <div class="d-flex align-items-center">
                                <span class="
                              badge
                              bg-danger-subtle
                              text-danger
                              
                            ">Rejected</span>
                                <span class="action-icons">
                                    <a href="javascript:void(0)" class="ps-3"><i class="ti ti-edit fs-5"></i></a>
                                    <a href="javascript:void(0)" class="ps-3"><i class="ti ti-check fs-5"></i></a>
                                    <a href="javascript:void(0)" class="ps-3"><i class="ti ti-heart fs-5"></i></a>
                                </span>
                            </div>
                            <span class="
                            text-muted
                            ms-auto
                            fw-normal
                            fs-2
                            d-block
                            mt-2
                            text-end
                          ">April 14, 2025</span>
                        </div>
                    </div>
                </div>
                <!-- Comment Row -->
                <div class="d-flex flex-row comment-row p-3 gap-3">
                    <div>
                        <span><img src="<?= base_url() ?>img/profile/user-4.jpg" class="rounded-circle" alt="user"
                                width="50" /></span>
                    </div>
                    <div class="comment-text w-100">
                        <h6 class="fw-medium">James Anderson</h6>
                        <p class="mb-1 fs-2 text-muted">
                            Lorem Ipsum is simply dummy text of the printing and
                            type setting industry.
                        </p>
                        <div class="comment-footer mt-2">
                            <div class="d-flex align-items-center">
                                <span class="
                              badge
                              bg-info-subtle
                              text-info
                              
                            ">Pending</span>
                                <span class="action-icons">
                                    <a href="javascript:void(0)" class="ps-3"><i class="ti ti-edit fs-5"></i></a>
                                    <a href="javascript:void(0)" class="ps-3"><i class="ti ti-check fs-5"></i></a>
                                    <a href="javascript:void(0)" class="ps-3"><i class="ti ti-heart fs-5"></i></a>
                                </span>
                            </div>
                            <span class="
                            text-muted
                            ms-auto
                            fw-normal
                            fs-2
                            d-block
                            text-end
                            mt-2
                          ">April 14, 2025</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <h4 class="card-title mb-0">Weather Report</h4>
                    <select class="form-select w-auto ms-auto">
                        <option selected="">Today</option>
                        <option value="1">Weekly</option>
                    </select>
                </div>
                <div class="d-flex align-items-center flex-row mt-4">
                    <div class="p-2 display-5 text-primary">
                        <i class="ti ti-cloud-snow"></i>
                        <span>73<sup>°</sup></span>
                    </div>
                    <div class="p-2">
                        <h3 class="mb-0">Saturday</h3>
                        <small>Ahmedabad, India</small>
                    </div>
                </div>
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td>Wind</td>
                            <td class="fw-medium">ESE 17 mph</td>
                        </tr>
                        <tr>
                            <td>Humidity</td>
                            <td class="fw-medium">83%</td>
                        </tr>
                        <tr>
                            <td>Pressure</td>
                            <td class="fw-medium">28.56 in</td>
                        </tr>
                        <tr>
                            <td>Cloud Cover</td>
                            <td class="fw-medium">78%</td>
                        </tr>
                        <tr>
                            <td>Ceiling</td>
                            <td class="fw-medium">25760 ft</td>
                        </tr>
                    </tbody>
                </table>
                <hr />
                <ul class="list-unstyled row text-center city-weather-days mb-0">
                    <li class="col">
                        <i class="ti ti-sun-high fs-4"></i><span>09:30</span>
                        <h3 class="mb-0 fs-6 lh-base">70<sup>°</sup></h3>
                    </li>
                    <li class="col">
                        <i class="ti ti-cloud fs-4"></i><span>11:30</span>
                        <h3 class="mb-0 fs-6 lh-base">72<sup>°</sup></h3>
                    </li>
                    <li class="col">
                        <i class="ti ti-cloud-rain fs-4"></i><span>13:30</span>
                        <h3 class="mb-0 fs-6 lh-base">75<sup>°</sup></h3>
                    </li>
                    <li class="col">
                        <i class="ti ti-cloud-snow fs-4"></i><span>15:30</span>
                        <h3 class="mb-0 fs-6 lh-base">76<sup>°</sup></h3>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
