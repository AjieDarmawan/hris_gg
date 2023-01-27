<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<style>
.highcharts-figure,
.highcharts-data-table table {
    min-width: 360px;
    max-width: 800px;
    margin: 1em auto;
}

.highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #ebebeb;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
}

.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}

.highcharts-data-table th {
    font-weight: 600;
    padding: 0.5em;
}

.highcharts-data-table td,
.highcharts-data-table th,
.highcharts-data-table caption {
    padding: 0.5em;
}

.highcharts-data-table thead tr,
.highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}

.highcharts-data-table tr:hover {
    background: #f1f7ff;
}
</style>

<div class="row container">
    <div class="col-md-6">
        <div id="kar_masuk_risen"></div>

        <b>Total Karyawan : <?php echo $jumlah_karyawan_aktif->total; ?> Karyawan</b>
    </div>

    <div class="col-md-6">
        <div id="penggajian"></div>
        <b>Total Penggajian : </b>
    </div>
</div>

<br><br>


<div class="row container">
    <div class="col-md-6">
        <div id="fasilitas"></div>
    </div>


    <div class="col-md-6">
        <div id="status_karyawan"></div>
    </div>


</div>




<script>
Highcharts.chart('kar_masuk_risen', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Data Karyawan Masuk & Keluar Tahun <?php echo date("Y")?>'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    yAxis: {
        title: {
            text: 'Penggajian'
        }
    },
    plotOptions: {
        series: {
            dataLabels: {
                enabled: true
            }
        }
    },

    credits: {
    enabled: false
  },
    series: [{
        name: 'Masuk',
        color: {
            radialGradient: {
                cx: 0.5,
                cy: 0.5,
                r: 0.5
            },
            stops: [
                [0, '#003399'],
                [1, '#3366AA']
            ]
        },
        data: [<?php 
            foreach($kar_masuk as $k){
			echo $k->TOTAL.',';
		}
        ?>]
    }, {
        name: 'Keluar',
        color: '#FF0000',
        data: [<?php 
            foreach($kar_keluar as $k){
			echo $k->TOTAL.',';
		}
        ?>]
    }]
});
</script>

<script>
Highcharts.chart('penggajian', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Penggajian Tahun <?php echo date("Y")?>'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    yAxis: {
        title: {
            text: 'Penggajian'
        }
    },
    plotOptions: {
        column: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: true
        }
    },

    credits: {
    enabled: false
  },
    series: [{
        color: {
            linearGradient: {
                x1: 0,
                x2: 0,
                y1: 0,
                y2: 1
            },
            stops: [
                [0, '#003399'],
                [1, '#3366AA']
            ]
        },
        name: 'Penggajian',
        data: [1100000000, 1200000000, 1300000000, 1400000000, 1500000000, 1500000000, 1550000000,
            1610000000, 0, 0,
            0, 0
        ]
    }]
});
</script>


<script>
Highcharts.chart('fasilitas', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Data Fasilitas <?php echo date("M-Y")?>'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: ['Bpjs K', 'Bpjs PK', 'JP K', 'JP PK', 'JHT K', 'JHT PK', 'JKK', 'JKM', 'Sembako Beras',
            'Sembako Uang', 'Sembako Tidak Ada', 'Iuran Paguyuban'
        ]
    },
    yAxis: {
        title: {
            text: 'Penggajian'
        }
    },
    plotOptions: {
        series: {
            dataLabels: {
                enabled: true
            }
        }
    },

    credits: {
    enabled: false
  },
    series: [{
        name: 'Aktif',
        color: {
            radialGradient: {
                cx: 0.5,
                cy: 0.5,
                r: 0.5
            },
            stops: [
                [0, '#00996B'],
                [1, '#69AA33']
            ]
        },
        data: [<?php echo $fasilitas_dapat->bpjs_k?>,
        <?php echo $fasilitas_dapat->bpjs_pk?>,
        <?php echo $fasilitas_dapat->jp_k?>,
        <?php echo $fasilitas_dapat->jp_pk?>,
        <?php echo $fasilitas_dapat->jht_k?>,
        <?php echo $fasilitas_dapat->jht_pk?>,
        <?php echo $fasilitas_dapat->jkk_pk?>,
        <?php echo $fasilitas_dapat->jkm_pk?>,
        <?php echo $fasilitas_dapat->sembako_beras?>,
        <?php echo $fasilitas_dapat->sembako_tidak_ada?>,
        <?php echo $fasilitas_dapat->sembako_uang?>
    
    
    ]
    }, {
        name: 'Tidak Dapat',
        color: '#FF0000',
        data: [<?php echo $fasilitas_tidak_dapat->bpjs_k?>,
        <?php echo $fasilitas_tidak_dapat->bpjs_pk?>,
        <?php echo $fasilitas_tidak_dapat->jp_k?>,
        <?php echo $fasilitas_tidak_dapat->jp_pk?>,
        <?php echo $fasilitas_tidak_dapat->jht_k?>,
        <?php echo $fasilitas_tidak_dapat->jht_pk?>,
        <?php echo $fasilitas_tidak_dapat->jkk_pk?>,
        <?php echo $fasilitas_tidak_dapat->jkm_pk?>,
        0,
        0,
        0
    
    
    ]
    }]
});
</script>


<script>
Highcharts.chart('status_karyawan', {
    chart: {
        type: 'pie'
    },
    title: {
        text: 'Data Status Karyawan <?php echo date("M-Y")?>'
    },
    subtitle: {
        text: ''
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
            }
        }
    },

    credits: {
    enabled: false
  },


    series: [{
        name: 'Karyawan',
        colorByPoint: true,
        data: [{
            color: {
                radialGradient: {
                    cx: 0.5,
                    cy: 0.5,
                    r: 0.5
                },
                stops: [
                    [0, '#003399'],
                    [1, '#3366AA']
                ]
            },
            name: 'Nikah',
            y:  <?php echo $status_kar->Kawin?>,
            sliced: true,
            selected: true
        }, {
            name: 'Janda',
            y:  <?php echo $status_kar->Janda?>,
        }, {
            name: 'Duda',
            y:  <?php echo $status_kar->Duda?>,
        }, {
            name: 'Belum Nikah',
            y:  <?php echo $status_kar->belum_kawin?>,
        }, {
            name: 'Tidak Diketahui',
            y:  <?php echo $status_kar->tidak_diketahui?>,
            color: {
                radialGradient: {
                    cx: 0.5,
                    cy: 0.5,
                    r: 0.5
                },
                stops: [
                    [0, '#990000'],
                    [1, '#AA3333']
                ]
            }
        }]
    }]
});
</script>