@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('vendor-style')
    @vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
    @vite('resources/assets/vendor/libs/datatables/datatables.min.css')
    @vite('resources/assets/vendor/libs/bootstrap/css/bootstrap.min.css') <!-- Ensure Bootstrap CSS is included -->
@endsection

@section('vendor-script')
    @vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
    @vite('resources/assets/vendor/libs/datatables/datatables.min.js')
    @vite('resources/assets/vendor/libs/bootstrap/js/bootstrap.bundle.min.js') <!-- Ensure Bootstrap JS is included -->
@endsection

@section('page-script')
    @vite('resources/assets/js/dashboards-analytics.js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var table = $('#DataTables_Table_0').DataTable({
                responsive: true
            });
        });
    </script>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Filter</h5>
        </div>
        <div class="card-datatable table-responsive">
            <div class="d-flex justify-content-start justify-content-md-end align-items-baseline">
                <div
                    class="dt-action-buttons d-flex align-items-start align-items-md-center justify-content-sm-center gap-4 pt-0">

                    <div id="DataTables_Table_0_filter" class="dataTables_filter">
                        <label><input type="search" class="form-control form-control-sm" placeholder="Search"
                                aria-controls="DataTables_Table_0"></label>
                    </div>
                    <button class="btn btn-primary" tabindex="0" aria-controls="DataTables_Table_0" type="button"
                        onclick="window.location.href='/user-create'">
                        <i class="ri-add-line ri-16px me-1"></i> Add Product
                    </button>

                </div>
            </div>

            <table class="datatables-products table dataTable no-footer dtr-column collapsed" id="DataTables_Table_0"
                aria-describedby="DataTables_Table_0_info">
                <thead>
                    <tr>
                        <th class="control sorting_disabled" rowspan="1" colspan="1" style="width: 1px;"
                            aria-label=""></th>

                        <th class="sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                            colspan="1" style="width: 406px;" aria-label="product: activate to sort column descending"
                            aria-sort="ascending">Product</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                            style="width: 125px;" aria-label="category: activate to sort column ascending">Category</th>
                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 48px;" aria-label="stock">
                            Stock</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                            style="width: 39px;" aria-label="sku: activate to sort column ascending">SKU
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                            style="width: 66px;" aria-label="price: activate to sort column ascending">
                            Price</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                            style="width: 29px;" aria-label="qty: activate to sort column ascending">Qty
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                            style="width: 88px;" aria-label="status: activate to sort column ascending">
                            Status</th>
                        <th class="sorting_disabled dtr-hidden" rowspan="1" colspan="1"
                            style="width: 0px; display: none;" aria-label="Actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="odd">
                        <td class="control" tabindex="0" style=""></td>

                        <td class="sorting_1">
                            <div class="d-flex justify-content-start align-items-center product-name">
                                <div class="avatar-wrapper me-4">
                                    <div class="avatar rounded-2 bg-label-secondary"><img
                                            src="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template/demo/assets/img/ecommerce-images/product-9.png"
                                            alt="Product-9" class="rounded-2"></div>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="text-nowrap text-heading fw-medium">Air Jordan</span>
                                    <small class="text-truncate d-none d-sm-block">Air Jordan is a line of basketball
                                        shoes produced by Nike</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <h6 class="text-truncate d-flex align-items-center mb-0 fw-normal">
                                <span
                                    class="avatar-sm rounded-circle d-flex justify-content-center align-items-center bg-label-info me-4"><i
                                        class="ri-home-6-line"></i></span>
                                Shoes
                            </h6>
                        </td>
                        <td><span class="text-truncate"><label class="switch switch-primary switch-sm"><input
                                        type="checkbox" class="switch-input" id="switch"><span
                                        class="switch-toggle-slider"><span class="switch-off"></span></span></label><span
                                    class="d-none">Out_of_Stock</span></span></td>
                        <td><span>31063</span></td>
                        <td><span>$125</span></td>
                        <td><span>942</span></td>
                        <td><span class="badge rounded-pill bg-label-danger" text-capitalized="">Inactive</span></td>
                        <td class="dtr-hidden" style="display: none;">
                            <div class="d-inline-block text-nowrap">
                                <button
                                    class="btn btn-sm btn-icon btn-text-secondary waves-effect rounded-pill text-body me-1"><i
                                        class="ri-edit-box-line ri-22px"></i></button>
                                <button
                                    class="btn btn-sm btn-icon btn-text-secondary waves-effect rounded-pill text-body dropdown-toggle hide-arrow"
                                    data-bs-toggle="dropdown"><i class="ri-more-2-line ri-22px"></i></button>
                                <div class="dropdown-menu dropdown-menu-end m-0">
                                    <a href="javascript:0;" class="dropdown-item">View</a>
                                    <a href="javascript:0;" class="dropdown-item">Suspend</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="row mx-1">
                <div class="col-sm-12 col-md-6">
                    <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">
                        Displaying 1 to 7 of 100 entries</div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                        <ul class="pagination">
                            <li class="paginate_button page-item previous disabled" id="DataTables_Table_0_previous">
                                <a aria-controls="DataTables_Table_0" aria-disabled="true" role="link"
                                    data-dt-idx="previous" tabindex="-1" class="page-link">Previous</a>
                            </li>
                            <li class="paginate_button page-item active"><a href="#"
                                    aria-controls="DataTables_Table_0" role="link" aria-current="page"
                                    data-dt-idx="0" tabindex="0" class="page-link">1</a></li>
                            <li class="paginate_button page-item "><a href="#" aria-controls="DataTables_Table_0"
                                    role="link" data-dt-idx="1" tabindex="0" class="page-link">2</a></li>
                            <li class="paginate_button page-item "><a href="#" aria-controls="DataTables_Table_0"
                                    role="link" data-dt-idx="2" tabindex="0" class="page-link">3</a></li>
                            <li class="paginate_button page-item "><a href="#" aria-controls="DataTables_Table_0"
                                    role="link" data-dt-idx="3" tabindex="0" class="page-link">4</a></li>
                            <li class="paginate_button page-item "><a href="#" aria-controls="DataTables_Table_0"
                                    role="link" data-dt-idx="4" tabindex="0" class="page-link">5</a></li>
                            <li class="paginate_button page-item disabled" id="DataTables_Table_0_ellipsis"><a
                                    aria-controls="DataTables_Table_0" aria-disabled="true" role="link"
                                    data-dt-idx="ellipsis" tabindex="-1" class="page-link">…</a></li>
                            <li class="paginate_button page-item "><a href="#" aria-controls="DataTables_Table_0"
                                    role="link" data-dt-idx="14" tabindex="0" class="page-link">15</a></li>
                            <li class="paginate_button page-item next" id="DataTables_Table_0_next"><a href="#"
                                    aria-controls="DataTables_Table_0" role="link" data-dt-idx="next" tabindex="0"
                                    class="page-link">Next</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <style>
        .justify-content-md-end {

            margin-bottom: 24px;
        }

        .mx-1 {
            margin-right: 10.75rem !important;
            margin-top: 10px
        }
    </style>
@endsection
