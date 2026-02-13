@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor restaurantTitle">{{ trans('lang.driver_plural') }}</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">{{ trans('lang.dashboard') }}</a></li>
                    <li class="breadcrumb-item"><a href="{!! route('drivers') !!}">{{ trans('lang.driver_plural') }}</a></li>
                    <li class="breadcrumb-item active">{{ trans('lang.restaurant_details') }}</li>
                </ol>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="resttab-sec">
                        <div class="menu-tab">
                            <ul>
                                <li class="active">
                                    <a href="{{ route('drivers.view', $id) }}">{{ trans('lang.tab_basic') }}</a>
                                </li>
                                <li>
                                    <a href="{{ route('orders') }}?driverId={{ $id }}">{{ trans('lang.tab_orders') }}</a>
                                </li>
                                <li>
                                    <a href="{{ route('driver.payout', $id) }}">{{ trans('lang.tab_payouts') }}</a>
                                </li>
                                <li>
                                    <a href="{{ route('payoutRequests.drivers.view', $id) }}">{{ trans('lang.tab_payout_request') }}</a>
                                </li>
                                <li>
                                    <a href="{{ route('users.walletstransaction', $id) }}">{{ trans('lang.wallet_transaction') }}</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="driver-ratings-tab">{{ trans('lang.driver_ratings') }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card card-box-with-icon bg-gradient-primary shadow-sm">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div class="card-box-with-content">
                                            <h4 class="text-white mb-1 h4 rest_active_count" id="total_earnings">$0.00</h4>
                                            <p class="mb-0 small text-white-50">{{ trans('lang.dashboard_total_earnings') }}</p>
                                        </div>
                                        <span class="box-icon ab"><img src="{{ asset('images/total_earning.png') }}" style="filter: brightness(0) invert(1);"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card card-box-with-icon bg-gradient-success shadow-sm">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div class="card-box-with-content">
                                            <h4 class="text-white mb-1 h4 rest_count" id="cod_earning">$0.00</h4>
                                            <p class="mb-0 small text-white-50">{{ trans('lang.cash_in_hand') }}</p>
                                        </div>
                                        <span class="box-icon ab"><img src="{{ asset('images/total_earning.png') }}" style="filter: brightness(0) invert(1);"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card card-box-with-icon bg-gradient-warning shadow-sm">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div class="card-box-with-content">
                                            <h4 class="text-white mb-1 h4 total_transaction" id="total_withdrawal">$0.00</h4>
                                            <p class="mb-0 small text-white-50">{{ trans('lang.total_withdrawal') }}</p>
                                        </div>
                                        <span class="box-icon ab"><img src="{{ asset('images/total_payment.png') }}" style="filter: brightness(0) invert(1);"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card card-box-with-icon bg-gradient-danger shadow-sm">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div class="card-box-with-content">
                                            <h4 class="text-white mb-1 h4 commission_earned" id="pending_withdrawal">$0.00</h4>
                                            <p class="mb-0 small text-white-50">{{ trans('lang.pending_withdrawal') }}</p>
                                        </div>
                                        <span class="box-icon ab"><img src="{{ asset('images/remaining_payment.png') }}" style="filter: brightness(0) invert(1);"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row restaurant_payout_create driver_details">
                            <div class="restaurant_payout_create-inner">
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#addWalletModal" class="add-wallate btn btn-success"><i class="fa fa-plus"></i> Add Wallet Amount</a>
                                <fieldset>
                                    <legend>{{ trans('lang.driver_details') }}</legend>
                                    <div class="form-group row width-50">
                                        <label class="col-3 control-label">{{ trans('lang.first_name') }}</label>
                                        <div class="col-7" class="driver_name">
                                            <span class="driver_name" id="driver_name"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row width-50">
                                        <label class="col-3 control-label">{{ trans('lang.email') }}</label>
                                        <div class="col-7">
                                            <span class="email"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row width-50">
                                        <label class="col-3 control-label">{{ trans('lang.user_phone') }}</label>
                                        <div class="col-7">
                                            <span class="phone"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row width-50">
                                        <label class="col-3 control-label">{{ trans('lang.wallet_Balance') }}</label>
                                        <div class="col-7">
                                            <span class="wallet"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row width-50">
                                        <label class="col-3 control-label">{{ trans('lang.profile_image') }}</label>
                                        <div class="col-7 profile_image">
                                        </div>
                                    </div>
                                    <div class="form-group row width-50">
                                        <label class="col-3 control-label">{{ trans('lang.zone') }}</label>
                                        <div class="col-7">
                                            <span id="zone_name"></span>
                                        </div>
                                    </div>
                            </div>
                            </fieldset>
                        </div>
                    </div>
                        <div class="row restaurant_payout_create restaurant_details">
                        <div class="restaurant_payout_create-inner">
                            <fieldset>
                                <legend>{{ trans('lang.bankdetails') }}</legend>
                                <div class="form-group row width-50">
                                    <label class="col-4 control-label">{{ trans('lang.bank_name') }}</label>
                                    <div class="col-7">
                                        <span class="bank_name"></span>
                                    </div>
                                </div>
                                <div class="form-group row width-50">
                                    <label class="col-4 control-label">{{ trans('lang.branch_name') }}</label>
                                    <div class="col-7">
                                        <span class="branch_name"></span>
                                    </div>
                                </div>
                                <div class="form-group row width-50">
                                    <label class="col-4 control-label">{{ trans('lang.holer_name') }}</label>
                                    <div class="col-7">
                                        <span class="holer_name"></span>
                                    </div>
                                </div>
                                <div class="form-group row width-50">
                                    <label class="col-4 control-label">{{ trans('lang.account_number') }}</label>
                                    <div class="col-7">
                                        <span class="account_number"></span>
                                    </div>
                                </div>
                                <div class="form-group row width-50">
                                    <label class="col-4 control-label">{{ trans('lang.other_information') }}</label>
                                    <div class="col-7">
                                        <span class="other_information"></span>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <!-- Driver Ratings Section -->
                    <div class="row restaurant_payout_create driver_ratings_section" style="display: none;">
                        <div class="restaurant_payout_create-inner">
                            <fieldset>
                                <legend>{{ trans('lang.driver_ratings') }}</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card card-box-with-icon bg-gradient-primary">
                                            <div class="card-body d-flex justify-content-between align-items-center">
                                                <div class="card-box-with-content">
                                                    <h4 class="text-white mb-1 h4" id="average_rating">0.0</h4>
                                                    <p class="mb-0 small text-white-50">{{ trans('lang.average_rating') }}</p>
                                                </div>
                                                <span class="box-icon ab"><img src="{{ asset('images/star.png') }}" style="filter: brightness(0) invert(1);"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card card-box-with-icon bg-gradient-info">
                                            <div class="card-body d-flex justify-content-between align-items-center">
                                                <div class="card-box-with-content">
                                                    <h4 class="text-white mb-1 h4" id="total_reviews">0</h4>
                                                    <p class="mb-0 small text-white-50">{{ trans('lang.total_reviews') }}</p>
                                                </div>
                                                <span class="box-icon ab"><img src="{{ asset('images/review.png') }}" style="filter: brightness(0) invert(1);"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <h5>{{ trans('lang.rating_breakdown') }}</h5>
                                    <div class="rating-breakdown">
                                        <div class="rating-item">
                                            <div class="d-flex justify-content-between">
                                                <span>5 {{ trans('lang.stars') }}</span>
                                                <span id="rating_5">0%</span>
                                            </div>
                                            <div class="progress mt-1">
                                                <div class="progress-bar bg-success" id="rating_5_bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="rating-item mt-2">
                                            <div class="d-flex justify-content-between">
                                                <span>4 {{ trans('lang.stars') }}</span>
                                                <span id="rating_4">0%</span>
                                            </div>
                                            <div class="progress mt-1">
                                                <div class="progress-bar bg-info" id="rating_4_bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="rating-item mt-2">
                                            <div class="d-flex justify-content-between">
                                                <span>3 {{ trans('lang.stars') }}</span>
                                                <span id="rating_3">0%</span>
                                            </div>
                                            <div class="progress mt-1">
                                                <div class="progress-bar bg-warning" id="rating_3_bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="rating-item mt-2">
                                            <div class="d-flex justify-content-between">
                                                <span>2 {{ trans('lang.stars') }}</span>
                                                <span id="rating_2">0%</span>
                                            </div>
                                            <div class="progress mt-1">
                                                <div class="progress-bar bg-danger" id="rating_2_bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="rating-item mt-2">
                                            <div class="d-flex justify-content-between">
                                                <span>1 {{ trans('lang.star') }}</span>
                                                <span id="rating_1">0%</span>
                                            </div>
                                            <div class="progress mt-1">
                                                <div class="progress-bar bg-dark" id="rating_1_bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5>{{ trans('lang.recent_reviews') }}</h5>
                                        <div class="filter-controls">
                                            <select id="rating-filter" class="form-control form-control-sm">
                                                <option value="">{{ trans('lang.all_ratings') }}</option>
                                                <option value="5">5 {{ trans('lang.stars') }}</option>
                                                <option value="4">4 {{ trans('lang.stars') }}</option>
                                                <option value="3">3 {{ trans('lang.stars') }}</option>
                                                <option value="2">2 {{ trans('lang.stars') }}</option>
                                                <option value="1">1 {{ trans('lang.star') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="recent-reviews" id="recent_reviews">
                                        <div class="text-center text-muted">{{ trans('lang.no_reviews_yet') }}</div>
                                    </div>
                                    <div class="mt-3" id="reviews-pagination">
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group col-12 text-center btm-btn">
                <a href="{!! route('drivers') !!}" class="btn btn-default"><i class="fa fa-undo"></i>{{ trans('lang.cancel') }}</a>
            </div>
        </div>
    </div>
    </div>
    <!-- Add Wallet Modal -->
    <div class="modal fade" id="addWalletModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered location_modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title locationModalTitle">{{ trans('lang.add_wallet_amount') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="">
                        <div class="form-row">
                            <div class="form-group row">
                                <div class="form-group row width-100">
                                    <label class="col-12 control-label">{{ trans('lang.amount') }}</label>
                                    <div class="col-12">
                                        <input type="number" name="amount" class="form-control" id="amount">
                                        <div id="wallet_error" style="color:red"></div>
                                    </div>
                                </div>
                                <div class="form-group row width-100">
                                    <label class="col-12 control-label">{{ trans('lang.note') }}</label>
                                    <div class="col-12">
                                        <input type="text" name="note" class="form-control" id="note">
                                    </div>
                                </div>
                                <div class="form-group row width-100">
                                    <div id="user_account_not_found_error" class="align-items-center" style="color:red"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary save-form-btn">{{ trans('submit') }}</a>
                        </button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">
                            {{ trans('close') }}</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reply to Review Modal -->
    <div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ trans('lang.reply_to_review') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="replyForm">
                        <input type="hidden" id="replyReviewId">
                        <div class="form-group">
                            <label for="replyText">{{ trans('lang.reply') }}</label>
                            <textarea class="form-control" id="replyText" rows="3" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('lang.close') }}</button>
                    <button type="button" class="btn btn-primary" id="saveReplyBtn">{{ trans('lang.submit') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var id = "<?php echo $id; ?>";
        var database = firebase.firestore();
        var ref = database.collection('users').where("id", "==", id);
        var photo = "";
        var placeholderImage = '';
        var placeholder = database.collection('settings').doc('placeHolderImage');
        placeholder.get().then(async function(snapshotsimage) {
            var placeholderImageData = snapshotsimage.data();
            placeholderImage = placeholderImageData.image;
        })
        var currentCurrency = '';
        var currencyAtRight = false;
        var decimal_degits = 0;
        var refCurrency = database.collection('currencies').where('isActive', '==', true);
        refCurrency.get().then(async function(snapshots) {
            var currencyData = snapshots.docs[0].data();
            currentCurrency = currencyData.symbol;
            currencyAtRight = currencyData.symbolAtRight;
            if (currencyData.decimal_degits) {
                decimal_degits = currencyData.decimal_degits;
            }
        });
        var email_templates = database.collection('email_templates').where('type', '==', 'wallet_topup');
        var emailTemplatesData = null;
        $(document).ready(async function() {
            jQuery("#data-table_processing").show();
            await email_templates.get().then(async function(snapshots) {
                emailTemplatesData = snapshots.docs[0].data();
            });
            getOverviewBlocksData();
            ref.get().then(async function(snapshots) {
                var driver = snapshots.docs[0].data();
                $(".driver_name").text(driver.firstName);
                if (driver.hasOwnProperty('email') && driver.email) {
                    $(".email").text(shortEmail(driver.email));
                } else {
                    $('.email').html("{{ trans('lang.not_mentioned') }}");
                }
                if (driver.hasOwnProperty('phoneNumber') && driver.phoneNumber) {
                    $(".phone").text(shortEditNumber(driver.phoneNumber));
                } else {
                    $('.phone').html("{{ trans('lang.not_mentioned') }}");
                }
                var wallet_balance = 0;
                if (driver.hasOwnProperty('wallet_amount') && driver.wallet_amount != null && !isNaN(driver.wallet_amount)) {
                    wallet_balance = driver.wallet_amount;
                }
                if (currencyAtRight) {
                    wallet_balance = parseFloat(wallet_balance).toFixed(decimal_degits) + "" + currentCurrency;
                } else {
                    wallet_balance = currentCurrency + "" + parseFloat(wallet_balance).toFixed(decimal_degits);
                }
                $(".wallet").text(wallet_balance);
                var image = "";
                if (driver.profilePictureURL != "" && driver.profilePictureURL != null) {
                    image = '<img onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" width="200px" id="" height="auto" src="' + driver.profilePictureURL + '">';
                } else {
                    image = '<img width="200px" id="" height="auto" src="' + placeholderImage + '">';
                }
                $(".profile_image").html(image);
                if (driver.hasOwnProperty('zoneId') && driver.zoneId != '') {
                    database.collection('zone').doc(driver.zoneId).get().then(async function(snapshots) {
                        let zone = snapshots.data();
                        $("#zone_name").text(zone.name);
                    });
                }
                if (driver.userBankDetails) {
                    if (driver.userBankDetails.bankName != undefined) {
                        $(".bank_name").text(driver.userBankDetails.bankName);
                    }
                    if (driver.userBankDetails.branchName != undefined) {
                        $(".branch_name").text(driver.userBankDetails.branchName);
                    }
                    if (driver.userBankDetails.holderName != undefined) {
                        $(".holer_name").text(driver.userBankDetails.holderName);
                    }
                    if (driver.userBankDetails.accountNumber != undefined) {
                        $(".account_number").text(driver.userBankDetails.accountNumber);
                    }
                    if (driver.userBankDetails.otherDetails != undefined) {
                        $(".other_information").text(driver.userBankDetails.otherDetails);
                    }
                }
                jQuery("#data-table_processing").hide();
            });
        })
         $(".driver-ratings-tab").click(function() {
            $(".menu-tab ul li").removeClass("active");
            $(this).parent().addClass("active");
            $(".driver_details, .restaurant_details").hide();
            $(".driver_ratings_section").show();
            fetchDriverRatings();
        });

        $(".save-form-btn").click(function() {
            var date = firebase.firestore.FieldValue.serverTimestamp();
            var amount = $('#amount').val();
            if (amount == '') {
                $('#wallet_error').text('{{ trans('lang.add_wallet_amount_error') }}');
                return false;
            }
            var note = $('#note').val();
            database.collection('users').where('id', '==', id).get().then(async function(snapshot) {
                if (snapshot.docs.length > 0) {
                    var data = snapshot.docs[0].data();
                    var walletAmount = 0;
                    if (data.hasOwnProperty('wallet_amount') && !isNaN(data.wallet_amount) && data.wallet_amount != null) {
                        walletAmount = data.wallet_amount;
                    }
                    var user_id = data.id;
                    var newWalletAmount = parseFloat(walletAmount) + parseFloat(amount);
                    database.collection('users').doc(id).update({
                        'wallet_amount': newWalletAmount
                    }).then(function(result) {
                        var tempId = database.collection("tmp").doc().id;
                        database.collection('wallet').doc(tempId).set({
                            'amount': parseFloat(amount),
                            'date': date,
                            'isTopUp': true,
                            'id': tempId,
                            'order_id': '',
                            'payment_method': 'Wallet',
                            'payment_status': 'success',
                            'user_id': user_id,
                            'note': note,
                            'transactionUser': "driver",
                        }).then(async function(result) {
                            if (currencyAtRight) {
                                amount = parseInt(amount).toFixed(decimal_degits) + "" + currentCurrency;
                                newWalletAmount = newWalletAmount.toFixed(decimal_degits) + "" + currentCurrency;
                            } else {
                                amount = currentCurrency + "" + parseInt(amount).toFixed(decimal_degits);
                                newWalletAmount = currentCurrency + "" + newWalletAmount.toFixed(decimal_degits);
                            }
                            var formattedDate = new Date();
                            var month = formattedDate.getMonth() + 1;
                            var day = formattedDate.getDate();
                            var year = formattedDate.getFullYear();
                            month = month < 10 ? '0' + month : month;
                            day = day < 10 ? '0' + day : day;
                            formattedDate = day + '-' + month + '-' + year;
                            var message = emailTemplatesData.message;
                            message = message.replace(/{username}/g, data.firstName + ' ' + data.lastName);
                            message = message.replace(/{date}/g, formattedDate);
                            message = message.replace(/{amount}/g, amount);
                            message = message.replace(/{paymentmethod}/g, 'Wallet');
                            message = message.replace(/{transactionid}/g, tempId);
                            message = message.replace(/{newwalletbalance}/g, newWalletAmount);
                            emailTemplatesData.message = message;
                            var url = "{{ url('send-email') }}";
                            var sendEmailStatus = await sendEmail(url, emailTemplatesData.subject, emailTemplatesData.message, [data.email]);
                            if (sendEmailStatus) {
                                window.location.reload();
                            }
                        })
                    })
                } else {
                    $('#user_account_not_found_error').text('{{ trans('lang.user_detail_not_found') }}');
                }
            });
        });

        var currentPage = 1;
        var reviewsPerPage = 5;
        var currentFilter = '';

        async function fetchDriverRatings(page = 1, filter = '') {
            var totalReviews = 0;
            var totalRating = 0;
            var ratingCounts = {1: 0, 2: 0, 3: 0, 4: 0, 5: 0};
            
            var query = database.collection('driver_reviews').where('driverID', '==', id);
            
            if (filter) {
                query = query.where('rating', '==', parseInt(filter));
            }
            
            await query.get().then(async function(snapshots) {
                totalReviews = snapshots.docs.length;
                if (totalReviews > 0) {
                    snapshots.docs.forEach((doc) => {
                        var review = doc.data();
                        var rating = parseInt(review.rating);
                        if (rating >= 1 && rating <= 5) {
                            ratingCounts[rating]++;
                            totalRating += rating;
                        }
                    });

                    var averageRating = totalRating / totalReviews;
                    $('#average_rating').text(averageRating.toFixed(1));
                    $('#total_reviews').text(totalReviews);

                    for (var i = 1; i <= 5; i++) {
                        var percentage = (ratingCounts[i] / totalReviews) * 100;
                        $('#rating_' + i).text(percentage.toFixed(1) + '%');
                        $('#rating_' + i + '_bar').css('width', percentage.toFixed(1) + '%');
                    }

                    // Pagination
                    var startIndex = (page - 1) * reviewsPerPage;
                    var endIndex = startIndex + reviewsPerPage;
                    var paginatedReviews = snapshots.docs.slice(startIndex, endIndex);

                    var reviewsHtml = '';
                    paginatedReviews.forEach((doc) => {
                        var review = doc.data();
                        var formattedDate = review.createdAt.toDate().toLocaleDateString();
                        var starsHtml = '';
                        for (var i = 1; i <= 5; i++) {
                            starsHtml += i <= review.rating ? '<i class="fa fa-star text-warning"></i>' : '<i class="fa fa-star-o text-muted"></i>';
                        }
                        reviewsHtml += `
                            <div class="review-item mb-3 card card-box">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <strong>${review.customerName || 'Customer'}</strong>
                                            <div class="mt-1">${starsHtml}</div>
                                        </div>
                                        <span class="text-muted">${formattedDate}</span>
                                    </div>
                                    ${review.reviewText ? '<p class="mt-2 text-muted">' + review.reviewText + '</p>' : ''}
                                    ${review.reply ? `
                                        <div class="mt-3 p-3 bg-light rounded">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <strong>{{ trans('lang.admin_reply') }}</strong>
                                                <small class="text-muted">${review.repliedAt ? review.repliedAt.toDate().toLocaleDateString() : ''}</small>
                                            </div>
                                            <p class="mt-1">${review.reply}</p>
                                        </div>
                                    ` : ''}
                                    <div class="mt-3">
                                        <button class="btn btn-sm btn-primary reply-btn" data-review-id="${doc.id}">
                                            {{ trans('lang.reply') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    $('#recent_reviews').html(reviewsHtml);

                    // Show pagination
                    if (totalReviews > reviewsPerPage) {
                        showPagination(totalReviews, page);
                    } else {
                        $('#reviews-pagination').html('');
                    }
                } else {
                    $('#recent_reviews').html('<div class="text-center text-muted">{{ trans('lang.no_reviews_yet') }}</div>');
                    $('#reviews-pagination').html('');
                }
            });
        }

        function showPagination(totalReviews, currentPage) {
            var totalPages = Math.ceil(totalReviews / reviewsPerPage);
            var paginationHtml = `
                <nav aria-label="Reviews pagination">
                    <ul class="pagination justify-content-center">
            `;

            if (currentPage > 1) {
                paginationHtml += `
                    <li class="page-item">
                        <a class="page-link" href="#" onclick="fetchDriverRatings(${currentPage - 1}, '${currentFilter}')">
                            {{ trans('lang.previous') }}
                        </a>
                    </li>
                `;
            }

            var startPage = Math.max(1, currentPage - 2);
            var endPage = Math.min(totalPages, currentPage + 2);

            if (startPage > 1) {
                paginationHtml += `
                    <li class="page-item">
                        <a class="page-link" href="#" onclick="fetchDriverRatings(1, '${currentFilter}')">1</a>
                    </li>
                    ${startPage > 2 ? '<li class="page-item disabled"><span class="page-link">...</span></li>' : ''}
                `;
            }

            for (var i = startPage; i <= endPage; i++) {
                paginationHtml += `
                    <li class="page-item ${i === currentPage ? 'active' : ''}">
                        <a class="page-link" href="#" onclick="fetchDriverRatings(${i}, '${currentFilter}')">${i}</a>
                    </li>
                `;
            }

            if (endPage < totalPages) {
                paginationHtml += `
                    ${endPage < totalPages - 1 ? '<li class="page-item disabled"><span class="page-link">...</span></li>' : ''}
                    <li class="page-item">
                        <a class="page-link" href="#" onclick="fetchDriverRatings(${totalPages}, '${currentFilter}')">${totalPages}</a>
                    </li>
                `;
            }

            if (currentPage < totalPages) {
                paginationHtml += `
                    <li class="page-item">
                        <a class="page-link" href="#" onclick="fetchDriverRatings(${currentPage + 1}, '${currentFilter}')">
                            {{ trans('lang.next') }}
                        </a>
                    </li>
                `;
            }

            paginationHtml += `
                    </ul>
                </nav>
            `;

            $('#reviews-pagination').html(paginationHtml);
        }

        $('#rating-filter').change(function() {
            currentFilter = $(this).val();
            currentPage = 1;
            fetchDriverRatings(currentPage, currentFilter);
        });

        // Handle reply button click
        $(document).on('click', '.reply-btn', function() {
            var reviewId = $(this).data('review-id');
            $('#replyReviewId').val(reviewId);
            $('#replyText').val('');
            $('#replyModal').modal('show');
        });

        // Handle reply submission
        $('#saveReplyBtn').click(function() {
            var reviewId = $('#replyReviewId').val();
            var reply = $('#replyText').val().trim();

            if (!reply) {
                alert('{{ trans('lang.reply_required') }}');
                return;
            }

            $.ajax({
                url: '{{ route('driver.review.reply') }}',
                method: 'POST',
                data: {
                    review_id: reviewId,
                    reply: reply,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        $('#replyModal').modal('hide');
                        fetchDriverRatings(currentPage, currentFilter);
                        toastr.success('{{ trans('lang.reply_added_successfully') }}');
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('{{ trans('lang.failed_to_send_reply') }}');
                }
            });
        });

        async function getOverviewBlocksData() {
            var totalCodEarning = 0;
            var driverWithrawal = 0;
            var pendingWithdrawal = 0;
            await database.collection('restaurant_orders').where('driverID', '==', id).where('payment_method', '==', 'cod').where('status', '==', 'Order Completed').get().then(async function(snapshot) {
                if (snapshot.docs.length > 0) {
                    console.log(snapshot.docs.length)
                    snapshot.docs.forEach((listval) => {
                        var data = listval.data();
                        if (data.hasOwnProperty('tip_amount') && data.tip_amount != null && data.tip_amount != '') {
                            totalCodEarning += parseFloat(data.tip_amount);
                        }
                        if (data.hasOwnProperty('deliveryCharge') && data.deliveryCharge != null && data.deliveryCharge != '') {
                            totalCodEarning += parseFloat(data.deliveryCharge);
                        }
                    })
                }
            })
           await database.collection('driver_payouts').where('driverID', '==', id).where('paymentStatus', '==', 'Success').get().then(async function(snapshot) {
                if (snapshot.docs.length > 0) {

                    snapshot.docs.forEach((listval) => {
                        var data = listval.data();
                        if (data.hasOwnProperty('amount') && data.amount != null && data.amount != '') {
                            driverWithrawal += parseFloat(data.amount);
                        }

                    })
                }
            })

           await database.collection('users').where('id', '==', id).get().then(async function(snapshot) {
                if (snapshot.docs.length > 0) {
                    var data = snapshot.docs[0].data();
                    if (data.hasOwnProperty('wallet_amount') && data.wallet_amount != null && !isNaN(data.wallet_amount)) {
                        pendingWithdrawal = data.wallet_amount;
                    }

                }
            })
            var totalEarning=parseFloat(pendingWithdrawal)+parseFloat(driverWithrawal)+parseFloat(totalCodEarning);
            if (currencyAtRight) {
                totalCodEarningAmount=parseFloat(totalCodEarning).toFixed(decimal_degits) + "" + currentCurrency;
                totalWithdrawalAmount = parseFloat(driverWithrawal).toFixed(decimal_degits) + "" + currentCurrency;
                pendingWithdrawalAmount = parseFloat(pendingWithdrawal).toFixed(decimal_degits) + "" + currentCurrency;
                totalEarningAmount=parseFloat(totalEarning).toFixed(decimal_degits) + "" + currentCurrency;
            } else {
                totalCodEarningAmount=currentCurrency + "" + parseFloat(totalCodEarning).toFixed(decimal_degits);
                totalWithdrawalAmount = currentCurrency + "" + parseFloat(driverWithrawal).toFixed(decimal_degits);
                pendingWithdrawalAmount = currentCurrency + "" + parseFloat(pendingWithdrawal).toFixed(decimal_degits);
                totalEarningAmount=currentCurrency + "" + parseFloat(totalEarning).toFixed(decimal_degits);
            }
            $('#cod_earning').html(totalCodEarningAmount);
            $('#total_withdrawal').html(totalWithdrawalAmount);
            $('#pending_withdrawal').html(pendingWithdrawalAmount)
            $('#total_earnings').html(totalEarningAmount);
        }
    </script>
@endsection
