<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      <?php if (str_replace('_', '-', app()->getLocale()) == 'ar' || @$_COOKIE['is_rtl'] == 'true') { ?> dir="rtl" <?php } ?>>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
<!-- <title>{{ config('app.name', 'Laravel') }}</title> -->
    <title id="app_name"><?php echo @$_COOKIE['meta_title']; ?></title>
    <link rel="icon" id="favicon" type="image/x-icon"
          href="<?php echo str_replace('images/', 'images%2F', @$_COOKIE['favicon']); ?>">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <?php if (str_replace('_', '-', app()->getLocale()) == 'ar' || @$_COOKIE['is_rtl'] == 'true') { ?>
    <link href="{{asset('assets/plugins/bootstrap/css/bootstrap-rtl.min.css')}}" rel="stylesheet">
    <?php } ?>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <?php if (str_replace('_', '-', app()->getLocale()) == 'ar' || @$_COOKIE['is_rtl'] == 'true') { ?>
    <link href="{{asset('css/style_rtl.css')}}" rel="stylesheet">
    <?php } ?>
    <link href="{{ asset('css/icons/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/toast-master/css/jquery.toast.css')}}" rel="stylesheet">
    <link href="{{ asset('css/colors/blue.css') }}" rel="stylesheet">
    <link href="{{ asset('css/chosen.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-tagsinput.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/toastr.min.css')}}" rel="stylesheet">
    
    <link href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw/dist/leaflet.draw.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>

    <?php if (isset($_COOKIE['admin_panel_color'])) { ?>

    <style type="text/css">
        /* Dark theme variables */
        :root {
            --primary-color: #6366f1;
            --primary-hover: #4f46e5;
            --secondary-color: #8b5cf6;
            --accent-color: #ec4899;
            --bg-primary: #0f172a;
            --bg-secondary: #1e293b;
            --bg-card: #334155;
            --text-primary: #f1f5f9;
            --text-secondary: #cbd5e1;
            --text-muted: #94a3b8;
            --border-color: #475569;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --gradient-primary: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            --gradient-secondary: linear-gradient(135deg, var(--accent-color), var(--primary-color));
        }

        /* Global dark theme */
        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
        }

        /* Card styling */
        .card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            background-color: var(--bg-secondary);
            border-bottom: 1px solid var(--border-color);
            border-radius: 12px 12px 0 0;
        }

        .card-body {
            background-color: var(--bg-card);
        }

        /* Sidebar styling */
        .sidebar-nav {
            background-color: var(--bg-secondary);
            border-right: 1px solid var(--border-color);
        }

        .sidebar-nav ul li a {
            color: var(--text-secondary);
            background-color: var(--bg-secondary);
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .sidebar-nav ul li a:hover {
            color: var(--primary-color);
            background-color: var(--bg-card);
            border-right: 3px solid var(--primary-color);
        }

        .sidebar-nav ul li a:hover i {
            color: var(--primary-color);
        }

        .sidebar-nav > ul > li.active > a,
        .sidebar-nav ul li ul li.active a,
        .sidebar-nav ul li ul li a:hover {
            color: var(--primary-color);
            background-color: var(--bg-card);
            border-right: 3px solid var(--primary-color);
        }

        .sidebar-nav > ul > li.active > a i {
            color: var(--primary-color);
        }

        /* Buttons */
        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            color: white;
            border-radius: 8px;
            padding: 8px 16px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(99, 102, 241, 0.3);
        }

        .btn-primary:hover, .btn-primary.disabled:hover {
            background: var(--gradient-secondary);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(99, 102, 241, 0.4);
        }

        .btn-primary.active, .btn-primary:active, .btn-primary:focus {
            background: var(--primary-hover);
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.5);
        }

        /* Form elements */
        .form-control {
            background-color: var(--bg-secondary);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background-color: var(--bg-card);
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.3);
            color: var(--text-primary);
        }

        /* Tables */
        .table {
            color: var(--text-primary);
        }

        .table tr {
            border-bottom: 1px solid var(--border-color);
        }

        .table tr:hover {
            background-color: var(--bg-secondary);
        }

        .table td, .table th {
            border-top: 1px solid var(--border-color);
        }

        /* Headers and titles */
        h1, h2, h3, h4, h5, h6 {
            color: var(--text-primary);
        }

        /* Badges and alerts */
        .badge-success {
            background-color: var(--success-color);
        }

        .badge-warning {
            background-color: var(--warning-color);
        }

        .badge-danger {
            background-color: var(--danger-color);
        }

        /* Navigation */
        .nav-tabs .nav-link {
            color: var(--text-secondary);
            background-color: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-bottom: none;
            border-radius: 8px 8px 0 0;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link.active, .nav-tabs .nav-link:hover {
            color: var(--text-primary);
            background-color: var(--bg-card);
            border-color: var(--primary-color);
            border-bottom: 1px solid var(--bg-card);
        }

        /* Sidebar toggler */
        .sidebartoggler {
            color: var(--text-secondary);
        }

        /* Topbar */
        .topbar {
            background-color: var(--bg-secondary);
            border-bottom: 1px solid var(--border-color);
        }

        /* Pagination */
        .pagination > li > a.page-link {
            background-color: var(--bg-secondary);
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            margin: 0 4px;
            transition: all 0.3s ease;
        }

        .pagination > li > a.page-link:hover {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            animation: fadeIn 0.5s ease-out;
        }

        /* Responsive design */
        @media screen and (max-width: 767px) {
            .mini-sidebar .sidebar-nav ul li a:hover, 
            .sidebar-nav > ul > li.active > a {
                color: var(--primary-color) !important;
            }

            .mini-sidebar .sidebar-nav #sidebarnav > li:hover a i, 
            .mini-sidebar .sidebar-nav ul li a, 
            .sidebar-nav ul li a.active i, 
            .sidebar-nav ul li a.active:hover i, 
            .sidebar-nav ul li.active a:hover i {
                color: var(--text-secondary);
            }

            .sidebar-nav > ul > li.active > a, 
            .sidebar-nav > ul > li.active > a i, 
            .sidebar-nav > ul > li > a:hover i {
                color: var(--primary-color) !important;
            }
        }
    </style>
    <?php } ?>

</head>
<body>

<div id="app" class="fix-header fix-sidebar card-no-border">
    <div id="main-wrapper">
        <div id="data-table_processing" class="page-overlay" style="display:none;">
            <div class="overlay-text">
                <img src="{{asset('images/spinner.gif')}}">
            </div>
        </div>
        <header class="topbar">

            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                @include('layouts.header')
            </nav>

        </header>
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                @include('layouts.menu')
            </div>
            <!-- End Sidebar scroll-->
        </aside>
    </div>
    <main class="py-4">
        @yield('content')
    </main>
</div>

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-draw/dist/leaflet.draw.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-editable/0.7.3/leaflet.editable.min.js"></script>
<script src="https://unpkg.com/leaflet-draw@0.4.14/dist/leaflet.draw-src.js"></script>
<script src="https://unpkg.com/leaflet-geojson-layer/src/leaflet.geojson.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  
<script src="{{ asset('assets/plugins/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('js/waves.js') }}"></script>
<script src="{{ asset('js/sidebarmenu.js') }}"></script>
<script src="{{ asset('assets/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
<script src="{{ asset('js/custom.min.js') }}"></script>
<script src="{{ asset('assets/plugins/summernote/summernote-bs4.js')}}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>

<script src="{{ asset('js/jquery.resizeImg.js') }}"></script>
<script src="{{ asset('js/mobileBUGFix.mini.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>

<script type="text/javascript">
    jQuery(window).scroll(function () {
        var scroll = jQuery(window).scrollTop();
        if (scroll <= 60) {
            jQuery("body").removeClass("sticky");
        } else {
            jQuery("body").addClass("sticky");
        }
    });
</script>

<script src="{{ asset('assets/plugins/select2/dist/js/select2.min.js') }}"></script>
<script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-firestore.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-storage.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-database.js"></script>
<script src="{{ asset('js/geofirestore.js') }}"></script>
<script src="https://cdn.firebase.com/libs/geofire/5.0.1/geofire.min.js"></script>
<script type="text/javascript">
    // Firebase Configuration
    var firebaseConfig = {
        apiKey: "<?php echo env('FIREBASE_APIKEY'); ?>",
        authDomain: "<?php echo env('FIREBASE_AUTH_DOMAIN'); ?>",
        databaseURL: "<?php echo env('FIREBASE_DATABASE_URL'); ?>",
        projectId: "<?php echo env('FIREBASE_PROJECT_ID'); ?>",
        storageBucket: "<?php echo env('FIREBASE_STORAGE_BUCKET'); ?>",
        messagingSenderId: "<?php echo env('FIREBASE_MESSAAGING_SENDER_ID'); ?>",
        appId: "<?php echo env('FIREBASE_APP_ID'); ?>",
        measurementId: "<?php echo env('FIREBASE_MEASUREMENT_ID'); ?>"
    };
    // Initialize Firebase
    if (!firebase.apps.length) {
        firebase.initializeApp(firebaseConfig);
    }
</script>
<script src="{{ asset('js/chosen.jquery.js') }}"></script>
<script src="{{ asset('js/bootstrap-tagsinput.js') }}"></script>
<script src="{{ asset('js/crypto-js.js') }}"></script>
<script src="{{ asset('js/jquery.cookie.js') }}"></script>
<script src="{{ asset('js/jquery.validate.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.24/jspdf.plugin.autotable.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script src="{{ asset('js/jquery.masking.js') }}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script type="text/javascript">

    var database = firebase.firestore();
    var geoFirestore = new GeoFirestore(database);
    var createdAtman = firebase.firestore.Timestamp.fromDate(new Date());
    var createdAt = {_nanoseconds: createdAtman.nanoseconds, _seconds: createdAtman.seconds};

    var ref = database.collection('settings').doc("globalSettings");
    ref.get().then(async function (snapshots) {
        try {
            var globalSettings = snapshots.data();
            $("#logo_web").attr('src', globalSettings.appLogo);

            if (getCookie('meta_title') == undefined || getCookie('meta_title') == null || getCookie('meta_title') == "") {
                document.title = globalSettings.meta_title;

                setCookie('meta_title', globalSettings.meta_title, 365);
            }

        } catch (error) {

        }
    });

    var refDistance = database.collection('settings').doc("RestaurantNearBy");
    refDistance.get().then(async function (snapshots) {
        try {
            var data = snapshots.data();
            var distanceType=data.distanceType.charAt(0).toUpperCase() + data.distanceType.slice(1);
            $('#distanceType').val(distanceType);
            $('.global_distance_type').html(distanceType);

        } catch (error) {

        }
    });

    var langcount = 0;
    var languages_list = database.collection('settings').doc('languages');
    languages_list.get().then(async function (snapshotslang) {
        snapshotslang = snapshotslang.data();
        if (snapshotslang != undefined) {
            snapshotslang = snapshotslang.list;
            languages_list_main = snapshotslang;
            snapshotslang.forEach((data) => {
                if (data.isActive == true) {
                    langcount++;
                    $('#language_dropdown').append($("<option></option>").attr("value", data.slug).text(data.title));
                }
            });
            if (langcount > 1) {
                $("#language_dropdown_box").css('visibility', 'visible');
            }
            <?php if (session()->get('locale')) { ?>
            $("#language_dropdown").val("<?php    echo session()->get('locale'); ?>");
            <?php } ?>

        }
    });

    var url = "{{ route('changeLang') }}";

    $(".changeLang").change(function () {
        var slug = $(this).val();
        languages_list_main.forEach((data) => {
            if (slug == data.slug) {
                if (data.is_rtl == undefined) {
                    setCookie('is_rtl', 'false', 365);
                } else {
                    setCookie('is_rtl', data.is_rtl.toString(), 365);
                }
                window.location.href = url + "?lang=" + slug;
            }
        });
    });

    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        let expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    var version = database.collection('settings').doc("Version");
    version.get().then(async function (snapshots) {
        var version_data = snapshots.data();
        if (version_data == undefined) {
            database.collection('settings').doc('Version').set({});
        }
        try {
            $('.web_version').html("V:" + version_data.web_version);
        } catch (error) {
        }
    });

    async function sendEmail(url, subject, message, recipients) {

        var checkFlag = false;

        await $.ajax({

            type: 'POST',
            data: {
                subject: subject,
                message: message,
                recipients: recipients
            },
            url: url,
            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                checkFlag = true;
            },
            error: function (xhr, status, error) {
                checkFlag = true;
            }
        });

        return checkFlag;

    }
    function exportData(dt, format, config) {
        const {
            columns,              
            fileName = 'Export',    
        } = config;

        const filteredRecords = dt.ajax.json().filteredData;

        const fieldTypes = {};
        const dataMapper = (record) => {
            return columns.map((col) => {
                const value = record[col.key];
                if (!fieldTypes[col.key]) {
                    if (value === true || value === false) {
                        fieldTypes[col.key] = 'boolean';
                    } else if (value && typeof value === 'object' && value.seconds) {
                        fieldTypes[col.key] = 'date'; 
                    } else if (typeof value === 'number') {
                        fieldTypes[col.key] = 'number';
                    } else if (typeof value === 'string') {
                        fieldTypes[col.key] = 'string';
                    } else {
                        fieldTypes[col.key] = 'string'; 
                    }
                }

                switch (fieldTypes[col.key]) {
                    case 'boolean':
                        return value ? 'Yes' : 'No'; 
                    case 'date':
                        return value ? new Date(value.seconds * 1000).toLocaleString() : '-';
                    case 'number':
                        return typeof value === 'number' ? value : 0;
                    case 'string':
                    default:
                        return value || '-';
                }
            });
        };

        const tableData = filteredRecords.map(dataMapper);
        const data = [columns.map(col => col.header), ...tableData];
        const columnWidths = columns.map((_, colIndex) =>
            Math.max(...data.map(row => row[colIndex]?.toString().length || 0))
        );

        if (format === 'csv') {
            const csv = data.map(row => row.map(cell => {
                if (typeof cell === 'string' && (cell.includes(',') || cell.includes('\n') || cell.includes('"'))) {
                    return `"${cell.replace(/"/g, '""')}"`;
                }
                return cell;
            }).join(',')).join('\n');

            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            saveAs(blob, `${fileName}.csv`);
        } else if (format === 'excel') {
            const ws = XLSX.utils.aoa_to_sheet(data, { cellDates: true });

            ws['!cols'] = columnWidths.map(width => ({ wch: Math.min(width + 5, 30) })); 

            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Data');
            XLSX.writeFile(wb, `${fileName}.xlsx`);
        } else if (format === 'pdf') {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            const totalLength = columnWidths.reduce((sum, length) => sum + length, 0);
            const columnStyles = {};
            columnWidths.forEach((length, index) => {
                columnStyles[index] = {
                    cellWidth: (length / totalLength) * 180, 
                };
            });

            doc.setFontSize(16);
            doc.text(fileName, 14, 16);

            doc.autoTable({
                head: [columns.map(col => col.header)],
                body: tableData,
                startY: 20,
                theme: 'striped',
                styles: {
                    cellPadding: 2,
                    fontSize: 10,
                },
                columnStyles,
                margin: { top: 30, bottom: 30 },
                didDrawPage: function (data) {
                    doc.setFontSize(10);
                    doc.text(fileName, data.settings.margin.left, 10);
                }
            });
            doc.save(`${fileName}.pdf`);
        } else {
            console.error('Unsupported format');
        }
    }


    var mapType = 'ONLINE';
    database.collection('settings').doc('DriverNearBy').get().then(async function (snapshots) {
        var data = snapshots.data();
        if (data && data.selectedMapType && data.selectedMapType == "osm") {
            mapType = "OFFLINE"
        }
    });

    async function loadGoogleMapsScript() {
        var googleMapKeySnapshotsHeader = await database.collection('settings').doc("googleMapKey").get();
        var placeholderImageHeaderData = googleMapKeySnapshotsHeader.data();
        googleMapKey = placeholderImageHeaderData.key;
        const script = document.createElement('script');

        if (mapType == "OFFLINE" ){
            script.src = "https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"; 
            script.src = "https://unpkg.com/leaflet-draw/dist/leaflet.draw.js"; 
            script.src = "https://cdnjs.cloudflare.com/ajax/libs/leaflet-editable/0.7.3/leaflet.editable.min.js";
            script.src = "https://unpkg.com/leaflet-draw@0.4.14/dist/leaflet.draw-src.js";
            script.src = "https://unpkg.com/leaflet-ajax/dist/leaflet.ajax.min.js";
            script.src = "https://unpkg.com/leaflet-geojson-layer/src/leaflet.geojson.js";
            script.src = "https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"; 

        }else{
            script.src = "https://maps.googleapis.com/maps/api/js?key=" + googleMapKey + "&libraries=places,drawing";
        }
        script.onload = function () {
            navigator.geolocation.getCurrentPosition(GeolocationSuccessCallback,GeolocationErrorCallback);
            if(typeof window['InitializeGodsEyeMap'] === 'function') { 
                InitializeGodsEyeMap();
            }
        };
        document.head.appendChild(script);
    }

    const GeolocationSuccessCallback = (position) => {
        if(position.coords != undefined){
            default_latitude = position.coords.latitude
            default_longitude = position.coords.longitude
            setCookie('default_latitude', default_latitude, 365);
            setCookie('default_longitude', default_longitude, 365);
        }
    };

    const GeolocationErrorCallback = (error) => {
        console.log('Error: You denied for your default Geolocation',error.message);
        setCookie('default_latitude', '23.022505', 365);
        setCookie('default_longitude','72.571365', 365);
    };

    loadGoogleMapsScript();

    async function sendNotification(fcmToken = '', title, body, payload = null) {
        var checkFlag = false;
        var sendNotificationUrl = "{{ route('send-notification') }}";
        console.log(JSON.stringify(payload));
        if (fcmToken !== '') {
            await $.ajax({
                type: 'POST',
                url: sendNotificationUrl,
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    'fcm': fcmToken,
                    'title': title,
                    'message': body,
                    'payload': JSON.stringify(payload)
                },
                success: function (data) {
                    checkFlag = true;
                },
                error: function (error) {
                    checkFlag = true;
                }
            });
        } else {
            checkFlag = true;
        }

        return checkFlag;
    }

    database.collection('settings').doc("notification_setting").get().then(async function (snapshots) {
        var data = snapshots.data();
        if(data != undefined){
            serviceJson = data.serviceJson;
            if(serviceJson != '' && serviceJson != null){
                $.ajax({
                    type: 'POST',
                    data: {
                        serviceJson: btoa(serviceJson),
                    },
                    url: "{{ route('store-firebase-service') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                    }
                });
            }
        }
    });

    //On delete item delete image also from bucket general code
    const deleteDocumentWithImage = async (collection, id, singleImageField, arrayImageField) => {
        // Reference to the Firestore document
        const docRef = database.collection(collection).doc(id);
        try {
            const doc = await docRef.get();
            if (!doc.exists) {
                console.log("No document found for deletion");
                return;
            }

            const data = doc.data();

            // Deleting single image field
            if (singleImageField) {
                if (Array.isArray(singleImageField)) {
                    for (const field of singleImageField) {
                        const imageUrl = data[field];
                        if (imageUrl) await deleteImageFromBucket(imageUrl);
                    }
                } else {
                    const imageUrl = data[singleImageField];
                    if (imageUrl) await deleteImageFromBucket(imageUrl);
                }
            }
            // Deleting array image field
            if (arrayImageField) {
                if (Array.isArray(arrayImageField)) {
                    for (const field of arrayImageField) {
                        const arrayImages = data[field];
                        if (arrayImages && Array.isArray(arrayImages)) {
                            for (const imageUrl of arrayImages) {
                                if (imageUrl) await deleteImageFromBucket(imageUrl);
                            }
                        }
                    }
                } else {
                    const arrayImages = data[arrayImageField];
                    if (arrayImages && Array.isArray(arrayImages)) {
                        for (const imageUrl of arrayImages) {
                            if (imageUrl) await deleteImageFromBucket(imageUrl);
                        }
                    }
                }
            }

                // Deleting images in variants array within item_attribute
            const item_attribute = data.item_attribute || {};  // Access item_attribute
            const variants = item_attribute.variants || [];    // Access variants array inside item_attribute
            if (variants.length > 0) {
                for (const variant of variants) {
                    const variantImageUrl = variant.variant_image;
                    if (variantImageUrl) {
                        await deleteImageFromBucket(variantImageUrl);
                    }
                }
            }

            // Optionally delete the Firestore document after image deletion
            await docRef.delete();
            console.log("Document and images deleted successfully.");
        } catch (error) {
            console.error("Error deleting document and images:", error);
        }
    };

    const deleteImageFromBucket = async (imageUrl) => {
        try {
            const storageRef = firebase.storage().ref();

            // Check if the imageUrl is a full URL or just a child path
            let oldImageUrlRef;
            if (imageUrl.includes('https://')) {
                // Full URL
                oldImageUrlRef = storageRef.storage.refFromURL(imageUrl);
            } else {
                // Child path, use ref instead of refFromURL
                oldImageUrlRef = storageRef.storage.ref(imageUrl);
            }
            var envBucket = "<?php echo env('FIREBASE_STORAGE_BUCKET'); ?>";
            var imageBucket = oldImageUrlRef.bucket;
            // Check if the bucket name matches
            if (imageBucket === envBucket) {
                // Delete the image
                await oldImageUrlRef.delete();
                console.log("Image deleted successfully.");
            }
        } catch (error) {

        }
    };

</script>

@yield('scripts')

</body>
</html>
