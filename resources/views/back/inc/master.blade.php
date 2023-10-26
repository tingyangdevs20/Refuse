<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>REIFuze</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Pet Store Dashboard" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('back/assets/images/favicon.ico') }}">


    <!-- Bootstrap Css -->
    <link href="{{ asset('back/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('back/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('back/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('chat-box/css/style.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    <!-- @yield('styles') -->
    @yield('styles')
    <style>
        .collapsedlogo {
            float: right;
            margin-right: -17px;
            margin-top: 12px;
        }
    </style>

    <script src="{{ asset('back/assets/libs/jquery/jquery.min.js') }}"></script>

</head>

<body data-sidebar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">


        <!-- ========== Header ========== -->
        @include('back.inc.header')
        <!-- Header -->
        <!-- ========== Left Sidebar Start ========== -->
        @include('back.inc.nav')
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            @yield('content')
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © REIFuze.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-right d-none d-sm-block">

                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>

    @component('components.soft-phone-ui')
    @endcomponent

    <!-- END layout-wrapper -->

    <!-- twilio-call-controls form. This will be hidden -->
    <main id="controls" class="d-none">
        <section class="left-column" id="info">
            <h2>Your Device Info</h2>
            <div id="client-name"></div>
            <div id="output-selection" class="hide">
                <label>Ringtone Devices</label>
                <select id="ringtone-devices" multiple></select>
                <label>Speaker Devices</label>
                <select id="speaker-devices" multiple></select><br />
                <button id="get-devices">Seeing "Unknown" devices?</button>
            </div>
        </section>
        <section class="center-column">
            <h2 class="instructions">Make a Call</h2>
            <div id="call-controls" class="hide">
                <label for="phone-number">Enter a phone number or client name</label>
                <input id="phone-number" type="text" placeholder="+15552221234" />


                <div id="volume-indicators" class="hide">
                    <label>Mic Volume</label>
                    <div id="input-volume"></div>
                    <br /><br />
                    <label>Speaker Volume</label>
                    <div id="output-volume"></div>
                </div>
            </div>
        </section>
        <section class="right-column">
            <h2>Event Log</h2>
            <div class="hide" id="log"></div>
        </section>
    </main>

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script>
        var publicPath = "{!! URL::to('/') !!}/admin/";
    </script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script src="{{ asset('back/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('back/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('back/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('back/assets/libs/node-waves/waves.min.js') }}"></script>

    <!-- apexcharts -->
    {{-- <script src="{{ asset('back/assets/libs/apexcharts/apexcharts.min.js') }}"></script> --}}

    <!-- Saas dashboard init -->
    {{-- <script src="{{ asset('back/assets/js/pages/saas-dashboard.init.js') }}"></script> --}}

    <script src="{{ asset('back/assets/js/app.js') }}"></script>
    <script src="{{ asset('back/assets/js/pages/twilio.min.js') }}"></script>
    <script src="{{ asset('back/assets/js/pages/twilio-main.js') }}"></script>

    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <!-- Soft-phone-modal-js -->
    <script>
        var currentPage = 1; // Start with page 1
        var isLoading = false;

        $('#end-call').on('click', function() {
            $('#end-call').hide();
            $('#answer-call').show();
            // Do business stuff here
            $('input[type=tel]').val('');
            $('input[type=tel]').focus();
        });




        $('#show-history').on('click', function() {
            var historyPanel = document.getElementById("call-history");
            var historyPanel2 = document.getElementById("dial_pad");
            if (historyPanel.style.display === "none") {
                historyPanel.style.display = "block";
                historyPanel2.style.display = "none";
                const showHistoryButton = document.getElementById("show-history");
                showHistoryButton.style.color = "blue";
                const showdial = document.getElementById("show-dialpad");
                showdial.style.color = "#d3d3d3";
                fetchCallRecords(currentPage);
            }
        });
        $('#show-dial-pad').on('click', function() {
            var historyPanel = document.getElementById("call-history");
            var historyPanel2 = document.getElementById("dial_pad");
            if (historyPanel2.style.display === "none") {
                historyPanel2.style.display = "block";
                historyPanel.style.display = "none";

                const showdial = document.getElementById("show-dialpad");
                showdial.style.color = "blue";
                const showHistoryButton = document.getElementById("show-history");
                showHistoryButton.style.color = "#d3d3d3";

                fetchCallRecords(currentPage);
            }
        });
        // Flag to prevent multiple simultaneous requests
        function formatDate(date) {
            const options = {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
            };
            return date.toLocaleString('en-US', options);
        }

        function fetchCallRecords(page) {
            if (isLoading || page < 1) {
                return;
            }
            var selectElement = document.getElementById("call_from");
            var number = selectElement.value;
            isLoading = true;
            var lastValu = null;
            var counter = 1;

            $.ajax({
                method: "get",
                url: '<?php echo url('admin/phones/records'); ?>',
                data: {
                    page: page,
                    number: number
                },
                success: function(res) {
                    var callHistoryList = $('#call-history ul');
                    res.data.forEach(function(call) {
                        var listItem = $('<li class="call-record"></li>');
                        var startTime = new Date(call.startTime.date);
                        var formattedStartTime = formatDate(startTime);

                        if (
                            lastValu &&
                            lastValu.from === call.from &&
                            lastValu.to === call.to &&
                            lastValu.direction === call.direction
                        ) {
                            // Same call characteristics, increment counter
                            counter++;
                        } else {

                            // Different call characteristics, reset counter

                            if (number === call.to && call.status === "completed") {
                                listItem.addClass('incoming-call');
                                listItem.append(
                                    '<i class="fas fa-arrow-down call-icon" style="color: green;"></i>'
                                );
                                listItem.append('<div class="call-from">' + call.from + '(<small>' +
                                    counter + '</small>)<br> <small>' + formattedStartTime +
                                    '</small> </div>');
                            } else if (number === call.from) {
                                listItem.addClass('outgoing-call');
                                listItem.append(
                                    '<i class="fas fa-arrow-up call-icon" style="color: blue;"></i>'
                                );
                                listItem.append('<div class="call-from">' + call.to + '(<small>' +
                                    counter + '</small>)<br> <small>' + formattedStartTime +
                                    '</small> </div>');
                            } else {
                                listItem.addClass('missed-call');
                                listItem.append(
                                    '<i class="fas fa-phone-slash call-icon" style="color: red;"></i>'
                                );
                                listItem.append('<div class="call-from">' + call.from + '(<small>' +
                                    counter + '</small>)<br> <small>' + formattedStartTime +
                                    '</small> </div>');
                            }

                            lastValu = call; // Update the lastValu for the next iteration

                            counter = 1;
                            var answerCallButton = $(
                                '<button style="margin-top: 10px;" id="answer-call" class="ans-call"><i class="fa fa-phone" aria-hidden="true"></i></button>'
                            );
                            listItem.append(answerCallButton);

                            callHistoryList.append(listItem);
                        }

                    });

                    currentPage++;
                    isLoading = false;
                },
                error: function(err) {
                    isLoading = false;
                    console.log('Error occurred while saving.', err);
                }
            });
        }




        // Detect when the user has scrolled to the bottom of the "call-history" div
        $('#call-history').scroll(function() {
            if ($('#call-history').scrollTop() + $('#call-history').innerHeight() >= $('#call-history ul')
                .innerHeight()) {
                // Load the next page when scrolled to the bottom
                fetchCallRecords(currentPage);
            }
        });

        // Initial request


        $('.focus-effects').on('click', function() {
            var text = $('input[type=tel]');
            text.val(text.val() + this.value);

            $(".soft-phone").find(".ans-call").attr('phone-number', text.val())

            text.focus();
        });



        $('input[type=reset]').on('click', function() {
            $('input[type=tel]').focus();
        });

        let modal = document.getElementById('soft-phone-modal');

        let btn = document.getElementById('open-modal-btn');

        btn.onclick = function() {
            modal.style.display = 'block';
        };

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        };

        // Close the modal when the "Escape" key is pressed
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                modal.style.display = 'none';
            }
        });

        $(document).on('click', ".close-dialer", function(e) {
            modal.style.display = 'none';
        });
    </script>
    <script>
        $(document).ready(function() {
            myInstance = new SimpleBar(document.getElementById('demo'), {
                autoHide: true,
                forceVisible: false,
                classNames: {
                    resizeWrapper: 'simplebar-resize-wrapper',
                    content: 'simplebar-content',
                    offset: 'simplebar-offset',
                    mask: 'simplebar-mask',
                    wrapper: 'simplebar-wrapper',
                    placeholder: 'simplebar-placeholder',
                    scrollbar: 'simplebar-scrollbar',
                    track: 'simplebar-track',
                    heightAutoObserverWrapperEl: 'simplebar-height-auto-observer-wrapper',
                    heightAutoObserverEl: 'simplebar-height-auto-observer',
                    visible: 'simplebar-visible',
                    horizontal: 'simplebar-horizontal',
                    vertical: 'simplebar-vertical',
                    hover: 'simplebar-hover',
                    dragging: 'simplebar-dragging'
                },
                scrollbarMinSize: 25,
                scrollbarMaxSize: 0,
                direction: 'ltr',
                timeout: 1000
            })

            // Find the active link within the .vertical-menu
            var activeLink = $('.vertical-menu #sidebar-menu ul li a.active');

            // Check if there is an active link
            if (activeLink.length > 0) {
                // Get the Simplebar instance of the .vertical-menu
                var verticalMenu = myInstance.getScrollElement();

                // Calculate the scroll position to the active link
                var scrollPosition = activeLink.position().top;

                // Set the scrollTop of the scrollable container
                if (verticalMenu) {
                    verticalMenu.scrollTop = scrollPosition;
                }
            }
        });
    </script>
    <script src="{{ asset('chat-box/js/script.js') }}"></script>
    @include('sweetalert::alert')

    @yield('scripts')
    @stack('js')
</body>

</html>
