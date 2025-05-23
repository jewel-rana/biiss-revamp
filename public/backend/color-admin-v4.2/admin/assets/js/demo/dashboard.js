/*
Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
Version: 4.2.0
Author: Sean Ngu
Website: http://www.seantheme.com/color-admin-v4.2/admin/
*/
var handleVectorMap = function() {
        "use strict";
        0 !== $("#world-map").length && $("#world-map").vectorMap({
            map: "world_mill_en",
            scaleColors: [COLOR_GREY_DARKER, COLOR_GREY_LIGHTER],
            normalizeFunction: "polynomial",
            hoverOpacity: .5,
            hoverColor: !1,
            zoomOnScroll: !1,
            markerStyle: {
                initial: {
                    fill: COLOR_GREEN,
                    stroke: "transparent",
                    r: 3
                }
            },
            regionStyle: {
                initial: {
                    fill: COLOR_BLACK_LIGHTER,
                    "fill-opacity": 1,
                    stroke: "none",
                    "stroke-width": .4,
                    "stroke-opacity": 1
                },
                hover: {
                    "fill-opacity": .8
                },
                selected: {
                    fill: "yellow"
                },
                selectedHover: {}
            },
            focusOn: {
                x: .5,
                y: .5,
                scale: 0
            },
            backgroundColor: COLOR_BLACK,
            markers: [{
                latLng: [41.9, 12.45],
                name: "Vatican City"
            }, {
                latLng: [43.73, 7.41],
                name: "Monaco"
            }, {
                latLng: [-.52, 166.93],
                name: "Nauru"
            }, {
                latLng: [-8.51, 179.21],
                name: "Tuvalu"
            }, {
                latLng: [43.93, 12.46],
                name: "San Marino"
            }, {
                latLng: [47.14, 9.52],
                name: "Liechtenstein"
            }, {
                latLng: [7.11, 171.06],
                name: "Marshall Islands"
            }, {
                latLng: [17.3, -62.73],
                name: "Saint Kitts and Nevis"
            }, {
                latLng: [3.2, 73.22],
                name: "Maldives"
            }, {
                latLng: [35.88, 14.5],
                name: "Malta"
            }, {
                latLng: [12.05, -61.75],
                name: "Grenada"
            }, {
                latLng: [13.16, -61.23],
                name: "Saint Vincent and the Grenadines"
            }, {
                latLng: [13.16, -59.55],
                name: "Barbados"
            }, {
                latLng: [17.11, -61.85],
                name: "Antigua and Barbuda"
            }, {
                latLng: [-4.61, 55.45],
                name: "Seychelles"
            }, {
                latLng: [7.35, 134.46],
                name: "Palau"
            }, {
                latLng: [42.5, 1.51],
                name: "Andorra"
            }, {
                latLng: [14.01, -60.98],
                name: "Saint Lucia"
            }, {
                latLng: [6.91, 158.18],
                name: "Federated States of Micronesia"
            }, {
                latLng: [1.3, 103.8],
                name: "Singapore"
            }, {
                latLng: [1.46, 173.03],
                name: "Kiribati"
            }, {
                latLng: [-21.13, -175.2],
                name: "Tonga"
            }, {
                latLng: [15.3, -61.38],
                name: "Dominica"
            }, {
                latLng: [-20.2, 57.5],
                name: "Mauritius"
            }, {
                latLng: [26.02, 50.55],
                name: "Bahrain"
            }, {
                latLng: [.33, 6.73],
                name: "São Tomé and Príncipe"
            }]
        })
    },
    handleInteractiveChart = function() {
        "use strict";

        function a(a, e, i) {
            $('<div id="tooltip" class="flot-tooltip">' + i + "</div>").css({
                top: e - 45,
                left: a - 55
            }).appendTo("body").fadeIn(200)
        }
        if (0 !== $("#interactive-chart").length) {
            var e = [
                    [1, 40],
                    [2, 50],
                    [3, 60],
                    [4, 60],
                    [5, 60],
                    [6, 65],
                    [7, 75],
                    [8, 90],
                    [9, 100],
                    [10, 105],
                    [11, 110],
                    [12, 110],
                    [13, 120],
                    [14, 130],
                    [15, 135],
                    [16, 145],
                    [17, 132],
                    [18, 123],
                    [19, 135],
                    [20, 150]
                ],
                i = [
                    [1, 10],
                    [2, 6],
                    [3, 10],
                    [4, 12],
                    [5, 18],
                    [6, 20],
                    [7, 25],
                    [8, 23],
                    [9, 24],
                    [10, 25],
                    [11, 18],
                    [12, 30],
                    [13, 25],
                    [14, 25],
                    [15, 30],
                    [16, 27],
                    [17, 20],
                    [18, 18],
                    [19, 31],
                    [20, 23]
                ],
                t = [
                    [1, ""],
                    [2, ""],
                    [3, "May&nbsp;15"],
                    [4, ""],
                    [5, ""],
                    [6, "May&nbsp;19"],
                    [7, ""],
                    [8, ""],
                    [9, "May&nbsp;22"],
                    [10, ""],
                    [11, ""],
                    [12, "May&nbsp;25"],
                    [13, ""],
                    [14, ""],
                    [15, "May&nbsp;28"],
                    [16, ""],
                    [17, ""],
                    [18, "May&nbsp;31"],
                    [19, ""],
                    [20, ""]
                ];
            $.plot($("#interactive-chart"), [{
                data: e,
                label: "Page Views",
                color: COLOR_BLUE,
                lines: {
                    show: !0,
                    fill: !1,
                    lineWidth: 2
                },
                points: {
                    show: !0,
                    radius: 3,
                    fillColor: COLOR_WHITE
                },
                shadowSize: 0
            }, {
                data: i,
                label: "Visitors",
                color: COLOR_GREEN,
                lines: {
                    show: !0,
                    fill: !1,
                    lineWidth: 2
                },
                points: {
                    show: !0,
                    radius: 3,
                    fillColor: COLOR_WHITE
                },
                shadowSize: 0
            }], {
                xaxis: {
                    ticks: t,
                    tickDecimals: 0,
                    tickColor: COLOR_BLACK_TRANSPARENT_2
                },
                yaxis: {
                    ticks: 10,
                    tickColor: COLOR_BLACK_TRANSPARENT_2,
                    min: 0,
                    max: 200
                },
                grid: {
                    hoverable: !0,
                    clickable: !0,
                    tickColor: COLOR_BLACK_TRANSPARENT_2,
                    borderWidth: 1,
                    backgroundColor: 'transparent',
                    borderColor: COLOR_BLACK_TRANSPARENT_2
                },
                legend: {
                    labelBoxBorderColor: COLOR_BLACK_TRANSPARENT_2,
                    margin: 10,
                    noColumns: 1,
                    show: !0
                }
            });
            var l = null;
            $("#interactive-chart").bind("plothover", function(e, i, t) {
                if ($("#x").text(i.x.toFixed(2)), $("#y").text(i.y.toFixed(2)), t) {
                    if (l !== t.dataIndex) {
                        l = t.dataIndex, $("#tooltip").remove();
                        var n = t.datapoint[1].toFixed(2),
                            o = t.series.label + " " + n;
                        a(t.pageX, t.pageY, o)
                    }
                } else $("#tooltip").remove(), l = null;
                e.preventDefault()
            })
        }
    },
    handleDonutChart = function() {
        "use strict";
        if (0 !== $("#donut-chart").length) {
            var a = [{
                label: "Chrome",
                data: 35,
                color: COLOR_PURPLE_DARKER
            }, {
                label: "Firefox",
                data: 30,
                color: COLOR_PURPLE
            }, {
                label: "Safari",
                data: 15,
                color: COLOR_PURPLE_LIGHTER
            }, {
                label: "Opera",
                data: 10,
                color: COLOR_BLUE
            }, {
                label: "IE",
                data: 5,
                color: COLOR_BLUE_DARKER
            }];
            $.plot("#donut-chart", a, {
                series: {
                    pie: {
                        innerRadius: .5,
                        show: !0,
                        label: {
                            show: !0
                        }
                    }
                },
                legend: {
                    show: !0
                }
            })
        }
    },
    handleDashboardSparkline = function() {
        "use strict";

        function a() {
            var a = [50, 30, 45, 40, 50, 20, 35, 40, 50, 70, 90, 40];
            e.type = "line", e.height = "23px", e.lineColor = COLOR_RED, e.highlightLineColor = COLOR_RED, e.highlightSpotColor = COLOR_RED;
            var i = $("#sparkline-unique-visitor").width();
            e.width = i >= 200 ? "200px" : "100%", $("#sparkline-unique-visitor").sparkline(a, e), e.lineColor = COLOR_ORANGE, e.highlightLineColor = COLOR_ORANGE, e.highlightSpotColor = COLOR_ORANGE, $("#sparkline-bounce-rate").sparkline(a, e), e.lineColor = COLOR_GREEN, e.highlightLineColor = COLOR_GREEN, e.highlightSpotColor = COLOR_GREEN, $("#sparkline-total-page-views").sparkline(a, e), e.lineColor = COLOR_BLUE, e.highlightLineColor = COLOR_BLUE, e.highlightSpotColor = COLOR_BLUE, $("#sparkline-avg-time-on-site").sparkline(a, e), e.lineColor = COLOR_GREY, e.highlightLineColor = COLOR_GREY, e.highlightSpotColor = COLOR_GREY, $("#sparkline-new-visits").sparkline(a, e), e.lineColor = COLOR_BLACK, e.highlightLineColor = COLOR_BLACK, e.highlightSpotColor = COLOR_GREY, $("#sparkline-return-visitors").sparkline(a, e)
        }
        var e = {
            height: "50px",
            width: "100%",
            fillColor: "transparent",
            lineWidth: 2,
            spotRadius: "4",
            highlightLineColor: COLOR_BLUE,
            highlightSpotColor: COLOR_BLUE,
            spotColor: !1,
            minSpotColor: !1,
            maxSpotColor: !1
        };
        a(), $(window).on("resize", function() {
            $("#sparkline-unique-visitor").empty(), $("#sparkline-bounce-rate").empty(), $("#sparkline-total-page-views").empty(), $("#sparkline-avg-time-on-site").empty(), $("#sparkline-new-visits").empty(), $("#sparkline-return-visitors").empty(), a()
        })
    },
    handleDashboardDatepicker = function() {
        "use strict";
        $("#datepicker-inline").datepicker({
            todayHighlight: !0
        })
    },
    handleDashboardTodolist = function() {
        "use strict";
        $("[data-click=todolist]").click(function() {
            var a = $(this).closest("li");
            $(a).hasClass("active") ? $(a).removeClass("active") : $(a).addClass("active")
        })
    },
    handleDashboardGritterNotification = function() {
        $(window).on("load", function() {
            setTimeout(function() {
                $.gritter.add({
                    title: "Welcome back, Admin!",
                    text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tempus lacus ut lectus rutrum placerat.",
                    image: "../assets/img/user/user-2.jpg",
                    sticky: !0,
                    time: "",
                    class_name: "my-sticky-class"
                })
            }, 1e3)
        })
    },
    Dashboard = function() {
        "use strict";
        return {
            init: function() {
                handleDashboardGritterNotification(), handleInteractiveChart(), handleDashboardSparkline(), handleDonutChart(), handleDashboardTodolist(), handleVectorMap(), handleDashboardDatepicker()
            }
        }
    }();