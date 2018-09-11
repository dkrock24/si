(function() {
    'use strict';

    angular
        .module("app")
        .config(routeConfig);

    function routeConfig($stateProvider, $urlRouterProvider) {
        $urlRouterProvider.otherwise("/dashboard/multiplebox")

        $stateProvider.state('dashboard', {
                abstract: true,
                template: "<ui-view/>",
                ncyBreadcrumb: {
                    label: 'Dashboard'
                },
                data: {
                    icon: 'pe-7s-monitor',
                },
            })
            .state('dashboard.multiplebox', {
                url: "/dashboard/multiplebox",
                templateUrl: 'views/DashboardMultipleBox.html',
                ncyBreadcrumb: {
                    label: 'Multiple Box'
                },
                data: {
                    icon: 'pe-7s-box2',
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    'assets/js/lib/flot/jquery.flot.min.js',
                                    'assets/js/lib/flot/jquery.flot.tooltip.min.js',
                                    'assets/js/lib/flot/jquery.flot.resize.min.js',
                                    'assets/js/lib/flot/jquery.flot.crosshair.min.js',
                                    'assets/js/lib/flot/jquery.flot.stack.min.js',
                                    'assets/js/lib/flot/curvedLines.min.js',
                                    'assets/js/lib/datatables/jquery.dataTables.min.js',
                                    'assets/js/lib/datatables/dataTables.responsive.min.js',
                                    'assets/js/lib/datatables/dataTables.bootstrap.min.js',
                                    'assets/js/lib/datatables/dataTables.fixedHeader.min.js',
                                    'assets/js/lib/datatables/dataTables.fixedColumns.min.js',
                                    'assets/js/pages/dashboard-multiplebox.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('dashboard.minimal', {
                url: "/dashboard/minimal",
                templateUrl: 'views/DashboardMinimal.html',
                ncyBreadcrumb: {
                    label: 'Minimalistic'
                },
                data: {
                    icon: 'pe-7s-graph1',
                    hasFullContainer: true,
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    'assets/js/lib/easypiechart/jquery.easypiechart.min.js',
                                    'assets/js/lib/easypiechart/easypiechart-init.js',
                                    'assets/js/lib/sparkline/jquery.sparkline.min.js',
                                    'assets/js/lib/sparkline/sparkline-init.js',
                                    'assets/js/lib/flot/jquery.flot.min.js',
                                    'assets/js/lib/flot/jquery.flot.orderBars.min.js',
                                    'assets/js/lib/flot/jquery.flot.tooltip.min.js',
                                    'assets/js/lib/flot/jquery.flot.resize.min.js',
                                    'assets/js/lib/flot/jquery.flot.selection.min.js',
                                    'assets/js/lib/flot/jquery.flot.crosshair.min.js',
                                    'assets/js/lib/flot/jquery.flot.stack.min.js',
                                    'assets/js/lib/flot/jquery.flot.time.min.js',
                                    'assets/js/lib/flot/jquery.flot.pie.min.js',
                                    'assets/js/lib/flot/curvedLines.min.js',
                                    'assets/js/lib/echarts/echarts-all.js',
                                    'assets/js/lib/echarts/theme.js',
                                    'assets/js/pages/dashboard-minimal.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('dashboard.realtime', {
                url: "/dashboard/realtime",
                templateUrl: 'views/DashboardRealtime.html',
                ncyBreadcrumb: {
                    label: 'Real-time'
                },
                data: {
                    icon: 'pe-7s-refresh-2',
                    hasFullContainer: true,
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    'assets/js/lib/flot/jquery.flot.min.js',
                                    'assets/js/lib/flot/jquery.flot.tooltip.min.js',
                                    'assets/js/lib/flot/jquery.flot.resize.min.js',
                                    'assets/js/pages/dashboard-realtime.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('dashboard.multipleBoxContrast', {
                url: "/dashboard/multipleBoxContrast",
                templateUrl: 'views/DashboardMultipleBoxContrast.html',
                ncyBreadcrumb: {
                    label: 'Multiple Box Contrast'
                },
                data: {
                    icon: 'pe-7s-sun',
                    hasFullContainer: true,
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    'assets/js/lib/easypiechart/jquery.easypiechart.min.js',
                                    'assets/js/lib/easypiechart/easypiechart-init.js',
                                    'assets/js/lib/sparkline/jquery.sparkline.min.js',
                                    'assets/js/lib/sparkline/sparkline-init.js',
                                    'assets/js/lib/flot/jquery.flot.min.js',
                                    'assets/js/lib/flot/jquery.flot.tooltip.min.js',
                                    'assets/js/lib/flot/jquery.flot.resize.min.js',
                                    'assets/js/lib/flot/jquery.flot.crosshair.min.js',
                                    'assets/js/lib/flot/jquery.flot.stack.min.js',
                                    'assets/js/lib/flot/curvedLines.min.js',
                                    'assets/js/lib/jqvmap/jquery.vmap.min.js',
                                    'assets/js/lib/jqvmap/maps/jquery.vmap.usa.js',
                                    'assets/js/pages/dashboard-multiplebox-contrast.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('widgets', {
                abstract: true,
                template: '<ui-view/>',
                ncyBreadcrumb: {
                    label: 'Widgets'
                },
                data: {
                    icon: 'pe-7s-box2',
                },
            })
            .state('widgets.boxes', {
                url: "/widgets/boxes",
                templateUrl: 'views/WidgetBox.html',
                ncyBreadcrumb: {
                    label: 'Boxes'
                },
                data: {
                    icon: 'fa fa-bar-chart',
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    'assets/js/lib/easypiechart/jquery.easypiechart.min.js',
                                    'assets/js/lib/easypiechart/easypiechart-init.js',
                                    'assets/js/lib/sparkline/jquery.sparkline.min.js',
                                    'assets/js/lib/sparkline/sparkline-init.js',
                                    'assets/js/lib/flot/jquery.flot.min.js',
                                    'assets/js/lib/flot/jquery.flot.orderBars.min.js',
                                    'assets/js/lib/flot/jquery.flot.tooltip.min.js',
                                    'assets/js/lib/flot/jquery.flot.resize.min.js',
                                    'assets/js/lib/flot/jquery.flot.selection.min.js',
                                    'assets/js/lib/flot/jquery.flot.crosshair.min.js',
                                    'assets/js/lib/flot/jquery.flot.stack.min.js',
                                    'assets/js/lib/flot/jquery.flot.time.min.js',
                                    'assets/js/lib/flot/jquery.flot.pie.min.js',
                                    'assets/js/pages/widget-box.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('widgets.panel', {
                url: "/widgets/panel",
                templateUrl: 'views/WidgetPanel.html',
                controller: "WidgetsPanelController",
                ncyBreadcrumb: {
                    label: 'Panels'
                },
                data: {
                    icon: 'pe-7s-box2',
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    {
                                        type: 'js',
                                        path: '//maps.google.com/maps/api/js?sensor=true&callback=initialize'
                                    },
                                    'assets/js/lib/gmaps/gmaps.min.js',
                                    'assets/js/pages/widget-panel.js',
                                    'assets/js/app/controllers/widgets.panel.controller.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('widgets.complex', {
                url: "/widgets/complex",
                templateUrl: 'views/WidgetComplex.html',
                ncyBreadcrumb: {
                    label: 'Complex Widgets'
                },
                data: {
                    icon: 'fa fa-line-chart',
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    'assets/js/lib/easypiechart/jquery.easypiechart.min.js',
                                    'assets/js/lib/easypiechart/easypiechart-init.js',
                                    'assets/js/lib/sparkline/jquery.sparkline.min.js',
                                    'assets/js/lib/sparkline/sparkline-init.js',
                                    'assets/js/lib/flot/jquery.flot.min.js',
                                    'assets/js/lib/flot/jquery.flot.orderBars.min.js',
                                    'assets/js/lib/flot/jquery.flot.tooltip.min.js',
                                    'assets/js/lib/flot/jquery.flot.resize.min.js',
                                    'assets/js/lib/flot/jquery.flot.selection.min.js',
                                    'assets/js/lib/flot/jquery.flot.crosshair.min.js',
                                    'assets/js/lib/flot/jquery.flot.stack.min.js',
                                    'assets/js/lib/flot/jquery.flot.time.min.js',
                                    'assets/js/lib/flot/jquery.flot.pie.min.js',
                                    'assets/js/lib/flot/curvedLines.min.js',
                                    'assets/js/pages/widget-complex.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('inbox', {
                url: "/inbox",
                templateUrl: 'views/Inbox.html',
                ncyBreadcrumb: {
                    label: 'Mail'
                },
                data: {
                    icon: 'pe-7s-mail"',
                    hasFullContainer: true,
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    'assets/js/lib/summernote/summernote.min.js',
                                    'assets/js/pages/inbox.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('calendar', {
                url: "/calendar",
                templateUrl: 'views/Calendar.html',
                ncyBreadcrumb: {
                    label: 'Calendar'
                },
                data: {
                    icon: 'pe-7s-date',
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    'assets/js/lib/fullcalendar/moment.min.js',
                                    'assets/js/lib/fullcalendar/jquery-ui.custom.min.js',
                                    'assets/js/lib/fullcalendar/fullcalendar.min.js',
                                    'assets/js/lib/mini-calendar/mini-calendar.min.js',
                                    'assets/js/pages/calendar.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('profile', {
                url: "/profile",
                templateUrl: 'views/Profile.html',
                controller: "ProfileController",
                ncyBreadcrumb: {
                    label: 'Profile'
                },
                data: {
                    icon: 'pe-7s-id',
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    {
                                        type: 'js',
                                        path: '//maps.google.com/maps/api/js?sensor=true&callback=initialize'
                                    },
                                    'assets/js/lib/gmaps/gmaps.min.js',
                                    'assets/js/pages/profile.js',
                                    'assets/js/app/controllers/profile.controller.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('charts', {
                abstract: true,
                template: '<ui-view/>',
                ncyBreadcrumb: {
                    label: 'Charts'
                },
                data: {
                    icon: 'pe-7s-graph1',
                },
            })
            .state('charts.flotChart', {
                url: "/charts/flotChart",
                templateUrl: 'views/FlotChart.html',
                ncyBreadcrumb: {
                    label: 'Flot Charts'
                },
                data: {
                    icon: 'fa fa-bar-chart',
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    'assets/js/lib/flot/jquery.flot.min.js',
                                    'assets/js/lib/flot/jquery.flot.orderBars.min.js',
                                    'assets/js/lib/flot/jquery.flot.tooltip.min.js',
                                    'assets/js/lib/flot/jquery.flot.resize.min.js',
                                    'assets/js/lib/flot/jquery.flot.selection.min.js',
                                    'assets/js/lib/flot/jquery.flot.crosshair.min.js',
                                    'assets/js/lib/flot/jquery.flot.stack.min.js',
                                    'assets/js/lib/flot/jquery.flot.time.min.js',
                                    'assets/js/lib/flot/jquery.flot.pie.min.js',
                                    'assets/js/pages/flotchart.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('charts.chartist', {
                url: "/charts/chartist",
                templateUrl: 'views/Chartist.html',
                ncyBreadcrumb: {
                    label: 'Chartist'
                },
                data: {
                    icon: 'pe-7s-graph2',
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    'assets/js/lib/chartist/chartist.min.js',
                                    'assets/js/lib/chartist/chartist-plugin-tooltip.min.js',
                                    'assets/js/pages/chartist.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('charts.chartJs', {
                url: "/charts/chartJs",
                templateUrl: 'views/ChartJs.html',
                ncyBreadcrumb: {
                    label: 'Chart.js'
                },
                data: {
                    icon: 'fa fa-line-chart',
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    'assets/js/lib/chartjs/Chart.min.js',
                                    'assets/js/pages/chartjs.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('charts.sparkline', {
                url: "/charts/sparkline",
                templateUrl: 'views/Sparkline.html',
                ncyBreadcrumb: {
                    label: 'Sparkline Charts'
                },
                data: {
                    icon: 'fa fa-area-chart',
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    'assets/js/lib/sparkline/jquery.sparkline.min.js',
                                    'assets/js/lib/sparkline/sparkline-init.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('charts.easyPieChart', {
                url: "/charts/easyPieChart",
                templateUrl: 'views/EasyPieChart.html',
                ncyBreadcrumb: {
                    label: 'Easy Pie Chart'
                },
                data: {
                    icon: 'pe-7s-graph',
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    'assets/js/lib/easypiechart/jquery.easypiechart.min.js',
                                    'assets/js/lib/easypiechart/easypiechart-init.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('charts.eCharts', {
                url: "/charts/eCharts",
                templateUrl: 'views/ECharts.html',
                ncyBreadcrumb: {
                    label: 'E-Charts'
                },
                data: {
                    icon: 'pe-7s-graph3',
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    'assets/js/lib/echarts/echarts-all.js',
                                    'assets/js/lib/echarts/theme.js',
                                    'assets/js/pages/e-charts.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('uiElements', {
                abstract: true,
                template: '<ui-view/>',
                ncyBreadcrumb: {
                    label: 'UI Elements'
                },
                data: {
                    icon: 'pe-7s-paint-bucket',
                },
            })
            .state('uiElements.elements', {
                url: "/uiElements/elements",
                templateUrl: 'views/Elements.html',
                ncyBreadcrumb: {
                    label: 'Basic Elements'
                },
                data: {
                    icon: 'pe-7s-ticket',
                },
            })
            .state('uiElements.buttons', {
                url: "/uiElements/buttons",
                templateUrl: 'views/Buttons.html',
                ncyBreadcrumb: {
                    label: 'Buttons'
                },
                data: {
                    icon: 'pe-7s-plus',
                },
            })
            .state('uiElements.notifications', {
                url: "/uiElements/notifications",
                templateUrl: 'views/Notifications.html',
                ncyBreadcrumb: {
                    label: 'Notifications'
                },
                data: {
                    icon: 'pe-7s-bell',
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    'assets/js/lib/notifications/snap.svg-min.js',
                                    'assets/js/lib/notifications/notificationFx.js',
                                    'assets/js/pages/notifications.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('uiElements.strokeIcons', {
                url: "/uiElements/strokeIcons",
                templateUrl: 'views/StrokeIcons.html',
                ncyBreadcrumb: {
                    label: '7 Stroke Icons'
                },
                data: {
                    icon: 'pe-7s-arc',
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    'assets/js/pages/icons.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('uiElements.fontAwesome', {
                url: "/uiElements/fontAwesome",
                templateUrl: 'views/FontAwesome.html',
                ncyBreadcrumb: {
                    label: 'FontAwesome Icons'
                },
                data: {
                    icon: 'fa fa-rocket',
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    'assets/js/pages/icons.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('uiElements.glyphicons', {
                url: "/uiElements/glyphicons",
                templateUrl: 'views/Glyphicons.html',
                ncyBreadcrumb: {
                    label: 'Glyphicons'
                },
                data: {
                    icon: 'glyphicon glyphicon-apple',
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    'assets/js/pages/icons.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('uiElements.panels', {
                url: "/uiElements/panels",
                templateUrl: 'views/Panels.html',
                ncyBreadcrumb: {
                    label: 'Panels & Accordions'
                },
                data: {
                    icon: 'pe-7s-browser',
                },
            })
            .state('uiElements.tabs', {
                url: "/uiElements/tabs",
                templateUrl: 'views/Tabs.html',
                ncyBreadcrumb: {
                    label: 'Tabs'
                },
                data: {
                    icon: 'pe-7s-folder',
                },
            })
            .state('uiElements.modals', {
                url: "/uiElements/modals",
                templateUrl: 'views/Modals.html',
                ncyBreadcrumb: {
                    label: 'Modals'
                },
                data: {
                    icon: 'pe-7s-chat',
                },
            })
            .state('uiElements.nestableList', {
                url: "/uiElements/nestableList",
                templateUrl: 'views/NestableList.html',
                ncyBreadcrumb: {
                    label: 'Nestable Lists'
                },
                data: {
                    icon: 'pe-7s-menu',
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    'assets/js/lib/nestable/jquery.nestable.min.js',
                                    'assets/js/pages/nestablelist.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('uiElements.tree', {
                url: "/uiElements/tree",
                templateUrl: 'views/Tree.html',
                ncyBreadcrumb: {
                    label: 'Tree'
                },
                data: {
                    icon: 'pe-7s-plus',
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    'assets/js/lib/tree/tree.min.js',
                                    'assets/js/pages/tree.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('forms', {
                abstract: true,
                template: '<ui-view/>',
                ncyBreadcrumb: {
                    label: 'Forms'
                },
                data: {
                    icon: 'pe-7s-note',
                },
            })
            .state('forms.formInputs', {
                url: "/forms/formInputs",
                templateUrl: 'views/FormInputs.html',
                ncyBreadcrumb: {
                    label: 'Form Inputs'
                },
                data: {
                    icon: 'pe-7s-ticket',
                },
            })
            .state('forms.formAdvancedInputs', {
                url: "/forms/formAdvancedInputs",
                templateUrl: 'views/FormAdvancedInputs.html',
                ncyBreadcrumb: {
                    label: 'Advanced Inputs'
                },
                data: {
                    icon: 'pe-7s-plus',
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    'assets/js/lib/select2/select2.full.min.js',
                                    'assets/js/lib/tagsinput/bootstrap-tagsinput.min.js',
                                    'assets/js/lib/datepicker/bootstrap-datepicker.min.js',
                                    'assets/js/lib/timepicker/bootstrap-timepicker.min.js',
                                    'assets/js/lib/moment/moment.min.js',
                                    'assets/js/lib/daterangepicker/daterangepicker.min.js',
                                    'assets/js/lib/autosize/jquery.autosize.min.js',
                                    'assets/js/lib/spinbox/spinbox.min.js',
                                    'assets/js/lib/knob/jquery.knob.min.js',
                                    'assets/js/lib/colorpicker/jquery.minicolors.min.js',
                                    'assets/js/lib/slider/ion.rangeSlider.min.js',
                                    'assets/js/lib/dropzone/dropzone.min.js',
                                    'assets/js/lib/rating/jquery.rateit.min.js',
                                    'assets/js/lib/mockjax/jquery.mockjax.min.js',
                                    'assets/js/lib/xeditable/bootstrap-editable.min.js',
                                    'assets/js/pages/formadvancedinputs.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('forms.formInputMask', {
                url: "/forms/formInputMask",
                templateUrl: 'views/FormInputMask.html',
                ncyBreadcrumb: {
                    label: 'Input Masks'
                },
                data: {
                    icon: 'pe-7s-bell',
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    'assets/js/lib/inputmask/jasny-bootstrap.min.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('forms.formEditors', {
                url: "/forms/formEditors",
                templateUrl: 'views/FormEditors.html',
                ncyBreadcrumb: {
                    label: 'Editors'
                },
                data: {
                    icon: 'pe-7s-edit',
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    'assets/js/lib/summernote/summernote.min.js',
                                    'assets/js/lib/ckeditor/ckeditor.js',
                                    'assets/js/pages/formeditors.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('forms.formLayouts', {
                url: "/forms/formLayouts",
                templateUrl: 'views/FormLayouts.html',
                ncyBreadcrumb: {
                    label: 'Form Layouts'
                },
                data: {
                    icon: 'pe-7s-photo-gallery',
                },
            })
            .state('forms.formValidation', {
                url: "/forms/formValidation",
                templateUrl: 'views/FormValidation.html',
                ncyBreadcrumb: {
                    label: 'Form Validation'
                },
                data: {
                    icon: 'pe-7s-shield',
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    'assets/js/lib/validation/jquery.validate.min.js',
                                    'assets/js/lib/validation/jquery.validate.defaults.js',
                                    'assets/js/pages/formvalidation.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('forms.formWizard', {
                url: "/forms/formWizard",
                templateUrl: 'views/FormWizard.html',
                ncyBreadcrumb: {
                    label: 'Form Wizard'
                },
                data: {
                    icon: 'pe-7s-play',
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    'assets/js/lib/wizard/wizard.min.js',
                                    'assets/js/pages/formwizard.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('tables', {
                abstract: true,
                template: '<ui-view/>',
                ncyBreadcrumb: {
                    label: 'Tables'
                },
                data: {
                    icon: 'pe-7s-keypad',
                },
            })
            .state('tables.tables', {
                url: "/tables/tables",
                templateUrl: 'views/Tables.html',
                ncyBreadcrumb: {
                    label: 'Tables Styles'
                },
                data: {
                    icon: 'pe-7s-paint-bucket',
                },
            })
            .state('tables.responsiveTables', {
                url: "/tables/responsiveTables",
                templateUrl: 'views/ResponsiveTables.html',
                ncyBreadcrumb: {
                    label: 'Responsive Tables'
                },
                data: {
                    icon: 'pe-7s-exapnd2',
                },
            })
            .state('tables.datatablesInit', {
                url: "/tables/datatablesInit",
                templateUrl: 'views/DatatablesInit.html',
                ncyBreadcrumb: {
                    label: 'Layouts'
                },
                data: {
                    icon: 'pe-7s-display2',
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    'assets/js/lib/datatables/jquery.dataTables.min.js',
                                    'assets/js/lib/datatables/dataTables.responsive.min.js',
                                    'assets/js/lib/datatables/dataTables.bootstrap.min.js',
                                    'assets/js/lib/datatables/dataTables.fixedHeader.min.js',
                                    'assets/js/lib/datatables/dataTables.fixedColumns.min.js',
                                    'assets/js/pages/datatables-init.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('tables.datatablesSearch', {
                url: "/tables/datatablesSearch",
                templateUrl: 'views/DatatablesSearch.html',
                ncyBreadcrumb: {
                    label: 'Search'
                },
                data: {
                    icon: 'pe-7s-search',
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    'assets/js/lib/datatables/jquery.dataTables.min.js',
                                    'assets/js/lib/datatables/dataTables.bootstrap.min.js',
                                    'assets/js/pages/datatables-search.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('tables.datatablesExport', {
                url: "/tables/datatablesExport",
                templateUrl: 'views/DatatablesExport.html',
                ncyBreadcrumb: {
                    label: 'Export and Print'
                },
                data: {
                    icon: 'pe-7s-print',
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    'assets/js/lib/datatables/jquery.dataTables.min.js',
                                    'assets/js/lib/datatables/dataTables.tableTools.min.js',
                                    'assets/js/lib/datatables/dataTables.bootstrap.min.js',
                                    'assets/js/pages/datatables-export.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('tables.datatablesCrud', {
                url: "/tables/datatablesCrud",
                templateUrl: 'views/DatatablesCrud.html',
                ncyBreadcrumb: {
                    label: 'Data Manipulation'
                },
                data: {
                    icon: 'pe-7s-pen',
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    'assets/js/lib/datatables/jquery.dataTables.min.js',
                                    'assets/js/lib/datatables/dataTables.tableTools.min.js',
                                    'assets/js/lib/datatables/dataTables.bootstrap.min.js',
                                    'assets/js/pages/datatables-crud.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('maps', {
                abstract: true,
                template: '<ui-view/>',
                ncyBreadcrumb: {
                    label: 'Maps'
                },
                data: {
                    icon: 'pe-7s-map-marker',
                },
            })
            .state('maps.gMaps', {
                url: "/maps/gMaps",
                templateUrl: 'views/GMaps.html',
                controller: "GMapsController",
                ncyBreadcrumb: {
                    label: 'GMaps'
                },
                data: {
                    icon: 'pe-7s-map-2',
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    {
                                        type: 'js',
                                        path: '//maps.google.com/maps/api/js?sensor=true&callback=initialize'
                                    },
                                    'assets/js/lib/gmaps/gmaps.min.js',
                                    'assets/js/pages/gmaps.js',
                                    'assets/js/app/controllers/gmaps.controller.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('maps.jqvMap', {
                url: "/maps/jqvMap",
                templateUrl: 'views/JqvMap.html',
                ncyBreadcrumb: {
                    label: 'JQV Map'
                },
                data: {
                    icon: 'pe-7s-world',
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    'assets/js/lib/jqvmap/jquery.vmap.min.js',
                                    'assets/js/lib/jqvmap/maps/jquery.vmap.germany.js',
                                    'assets/js/lib/jqvmap/maps/jquery.vmap.europe.js',
                                    'assets/js/lib/jqvmap/maps/jquery.vmap.usa.js',
                                    'assets/js/lib/jqvmap/maps/jquery.vmap.russia.js',
                                    'assets/js/lib/jqvmap/maps/jquery.vmap.world.js',
                                    'assets/js/lib/jqvmap/maps/continents/jquery.vmap.africa.js',
                                    'assets/js/lib/jqvmap/maps/data/jquery.vmap.sampledata.js',
                                    'assets/js/pages/jqvmaps.js',
                                ]
                            });
                        }
                    ]
                }
            })
            .state('pages', {
                abstract: true,
                template: '<ui-view/>',
                ncyBreadcrumb: {
                    label: 'Pages'
                },
                data: {
                    icon: 'pe-7s-display1',
                },
            })
            .state('pages.timeline', {
                url: "/pages/timeline",
                templateUrl: 'views/Timeline.html',
                ncyBreadcrumb: {
                    label: 'Timeline'
                },
                data: {
                    icon: 'pe-7s-clock',
                },
            })
            .state('pages.error500', {
                url: "/pages/error500",
                templateUrl: 'views/Error500.html',
                ncyBreadcrumb: {
                    label: '500'
                },
                data: {
                    icon: 'pe-7s-server',
                },
            })
            .state('pages.error404', {
                url: "/pages/error404",
                templateUrl: 'views/Error404.html',
                ncyBreadcrumb: {
                    label: '404'
                },
                data: {
                    icon: 'pe-7s-attention',
                },
            })
            .state('pages.error401', {
                url: "/pages/error401",
                templateUrl: 'views/Error401.html',
                ncyBreadcrumb: {
                    label: '401'
                },
                data: {
                    icon: 'pe-7s-user',
                },
            })
            .state('pages.blank', {
                url: "/pages/blank",
                templateUrl: 'views/Blank.html',
                ncyBreadcrumb: {
                    label: 'Blank Page'
                },
                data: {
                    icon: 'pe-7s-browser',
                },
                resolve: {
                    deps: [
                        '$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load({
                                serie: true,
                                files: [
                                    'assets/js/pages/blank.js',
                                ]
                            });
                        }
                    ]
                }
            })
    }
}());