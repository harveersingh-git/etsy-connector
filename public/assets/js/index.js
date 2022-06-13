$(function() {
    "use strict";

    // progress bars
    $('.progress .progress-bar').progressbar({
            display_text: 'none'
    });

    $('.sparkbar').sparkline('html', { type: 'bar' });

    $('.sparkline-pie').sparkline('html', {
        type: 'pie',
        offset: 90,
        width: '100px',
        height: '100px',
        sliceColors: ['#29bd73', '#182973', '#ffcd55']
    })


    // top products
    var dataStackedBar = {
            labels: ['Q1','Q2','Q3','Q4','Q5'],
            series: [
                [2350,3205,4520,2351,5632],
                [2541,2583,1592,2674,2323],
                [1212,5214,2325,4235,2519],
            ]
    };
    new Chartist.Bar('#chart-top-products', dataStackedBar, {
            height: "255px",
            stackBars: true,
            axisX: {
                showGrid: false
            },
            axisY: {
                labelInterpolationFnc: function(value) {
                    return (value / 1000) + 'k';
                }
            },
            plugins: [
                Chartist.plugins.tooltip({
                    appendToBody: true
                }),
                Chartist.plugins.legend({
                    legendNames: ['Bitcoin', 'NEO', 'ETH']
                })
            ]
    }).on('draw', function(data) {
            if (data.type === 'bar') {
                data.element.attr({
                    style: 'stroke-width: 35px'
                });
            }
    });


    // notification popup
    toastr.options.closeButton = true;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.showDuration = 1000;
    // toastr['info']('Hello, welcome to HexaBit, a unique admin Template.');
    var token = $('input[name="_token"]').attr('value');
    $.ajax({
        type: 'GET',
        url: base_url + '/overview',
        contentType: 'application/json',
        dataType: 'json',
        // data: data,
        headers: {
            'X-CSRF-Token': token
        },
        success: function(data) {
     console.log(data.data.users);
     var chart = c3.generate({    

        bindto: '#yearly', // id of chart wrapper
        data: {
            columns: [
                // each columns data
                data.data.users,
                data.data.shops
                // ['data3', 14.2, 10.3, 11.9, 15.2, 17.0, 16.6, 6.6, 4.8, 3.9, 4.2],
            ],
    
            labels: true,
            type: 'line', // default type of chart
            colors: {
                'data1': hexabit.colors["orange"],
                'data2': hexabit.colors["green"],
                // 'data3': hexabit.colors["gray-light"]
            },
            names: {
                // name of each serie
                'data1': 'Users',
                'data2': 'Shops',
                // 'data3': 'ETH'
            }
        },
        size: {
            height: 290,
            width: 1000
        },
        axis: {
            x: {
                type: 'category',
                // name of each category
                categories: ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December']
            },
        },
    
        legend: {
            show: true, //hide legend
        },
    
        padding: {
            bottom: 10,
            top: 0
        },
    });

    var chart = c3.generate({    

        bindto: '#monthly', // id of chart wrapper
        data: {
            columns: [
                // each columns data
                data.data.days_users,
                data.data.days_shops
                // ['data3', 14.2, 10.3, 11.9, 15.2, 17.0, 16.6, 6.6, 4.8, 3.9, 4.2],
            ],
    
            labels: true,
            type: 'line', // default type of chart
            colors: {
                'data1': hexabit.colors["orange"],
                'data2': hexabit.colors["green"],
                // 'data3': hexabit.colors["gray-light"]
            },
            names: {
                // name of each serie
                'data1': 'Users',
                'data2': 'Shops',
                // 'data3': 'ETH'
            }
        },
        size: {
            height: 290,
            width: 1000
        },
        axis: {
            x: {
                type: 'category',
                // name of each category
                categories: data.data.current_month_days
            },
        },
    
        legend: {
            show: true, //hide legend
        },
    
        padding: {
            bottom: 10,
            top: 0
        },
    });
        }
    });

 
});