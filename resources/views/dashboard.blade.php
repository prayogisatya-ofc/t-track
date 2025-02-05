@extends('app')

@section('content')
<div class="page-inner" id="app">
    <div class="row">
        <div class="col-sm-6 col-md-6">
            <div class="card card-stats card-round shadow-none">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-5 mb-3 mb-sm-0">
                            <div class="form-group p-0">
                                <label class="form-label">Dari</label>
                                <input type="date" class="form-control" v-model="filter.startDate" @change="getAllData">
                            </div>
                        </div>
                        <div class="col-sm-5 mb-3 mb-sm-0">
                            <div class="form-group p-0">
                                <label class="form-label">Sampai</label>
                                <input type="date" class="form-control" v-model="filter.endDate" @change="getAllData">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group p-0">
                                <label class="form-label">Sync Data</label><br>
                                <button class="btn btn-icon btn-round text-white" :class="{'btn-warning': syncData.button, 'btn-danger': !syncData.button}" @click="buttonSyncData">
                                    <i v-if="syncData.button" class="fas fa-sync fa-spin"></i>
                                    <i v-else="syncData.button" class="fas fa-sync"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round shadow-none">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-warning bubble-shadow-small">
                                <i class="fas fa-cog"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Total Produksi</p>
                                <h4 class="card-title">[[ totalProduksi ]] <small>Tempe</small></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round shadow-none">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-warning bubble-shadow-small">
                                <i class="fas fa-cogs"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Seluruh Produksi</p>
                                <h4 class="card-title">[[ seluruhProduksi ]] <small>Tempe</small></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card card-round shadow-none">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Grafik Produksi</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="min-height: 375px">
                        <canvas id="grafikProduksi"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-warning card-round shadow-none">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Produksi Bulan ini</div>
                    </div>
                    <div class="card-category">{{ date('F Y') }}</div>
                </div>
                <div class="card-body pb-0">
                    <div class="mb-4 mt-2">
                        <h1>[[ mingguanData.total ]] <small>Tempe</small></h1>
                    </div>
                    <div class="pull-in">
                        <canvas id="grafikMingguan" style="height: 290px"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-round shadow-none">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">Riwayat Produksi</div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">ID Penghitungan</th>
                                    <th scope="col" class="text-end">Tanggal & Waktu</th>
                                    <th scope="col" class="text-end">Jumlah</th>
                                    <th scope="col" class="text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in riwayatProduksi" :key="item.id">
                                    <th scope="row">
                                        <button class="btn btn-icon btn-round btn-success btn-sm me-2">
                                            <i class="fa fa-check"></i>
                                        </button>
                                        [[ item.id ]]
                                    </th>
                                    <td class="text-end">[[ item.tanggal ]]</td>
                                    <td class="text-end">[[ item.jumlah ]]</td>
                                    <td class="text-end">
                                        <span class="badge badge-success">Completed</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Profil Saya</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div v-if="errors" class="alert alert-warning d-flex align-items-center" role="alert">
                        <i class="fa fa-exclamation-circle me-2"></i>
                        <ul class="mb-0">
                            <li v-for="error in errors">
                                <span v-for="item in error">[[ item ]]</span>
                            </li>
                        </ul>
                    </div>
                    <form @submit.prevent="updateProfile" method="post" id="profileForm">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" v-model="user.name">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" v-model="user.email">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Password Baru</label>
                            <input type="password" class="form-control" v-model="user.password">
                            <small class="form-helper">Kosongkan jika tidak ingin diganti.</small>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" v-model="user.password_confirmation">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" form="profileForm" class="btn btn-warning text-white">Update</button>
                </div>
            </div>
        </div>
    </div>      
</div>
@endsection

@push('js')
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    const { createApp } = Vue

    createApp({
        delimiters: ['[[', ']]'],
        data() {
            return {
                filter: {
                    startDate: '',
                    endDate: ''
                },
                grafikProduksi: null,
                grafikData: {
                    labels: [],
                    data: []
                },
                grafikMingguan: null,
                mingguanData: {
                    labels: [],
                    data: [],
                    total: 0
                },
                totalProduksi: 0,
                seluruhProduksi: 0,
                syncData: {
                    interval: null,
                    button: true
                },
                riwayatProduksi: [],
                user: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                },
                errors: null
            }
        },
        mounted() {
            this.getAllData()
            this.startSyncData()
            this.getProfil()
        },
        methods: {
            async getProfil() {
                try {
                    const response = await axios.get(`/profil-saya`);
                    this.user.name = response.data.name;
                    this.user.email = response.data.email;
                } catch (error) {
                    console.error('Gagal mengambil data:', error);
                }
            },
            updateProfile() {
                const profileModal = bootstrap.Modal.getInstance(document.getElementById('profileModal'));

                axios.post(`/profil-saya/update`, this.user, {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => {
                        alert('Profil berhasil diperbarui')
                        if (profileModal) profileModal.hide()
                        this.getProfil()
                        this.errors = null
                        this.user.password = ''
                        this.user.password_confirmation = ''
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors
                    });
            },
            getAllData() {
                this.getGrafikProduksi()
                this.getTotalProduksi() 
                this.getSeluruhProduksi()
                this.getGrafikMingguan()
                this.getRiwayatProduksi()
            },
            async getTotalProduksi() {
                try {
                    const response = await axios.get(`/get-total-produksi?start=${this.filter.startDate}&end=${this.filter.endDate}`);
                    this.totalProduksi = response.data.totalProduksi;
                } catch (error) {
                    console.error('Gagal mengambil data:', error);
                }
            },
            async getSeluruhProduksi() {
                try {
                    const response = await axios.get(`/get-seluruh-produksi`);
                    this.seluruhProduksi = response.data.seluruhProduksi;
                } catch (error) {
                    console.error('Gagal mengambil data:', error);
                }
            },
            async getGrafikProduksi() {
                try {
                    const response = await axios.get(`/get-grafik-produksi?start=${this.filter.startDate}&end=${this.filter.endDate}`);
                    this.grafikData.labels = response.data.labels.reverse();
                    this.grafikData.data = response.data.data.reverse();
                    
                    if (!this.grafikProduksi) {
                        this.makeGrafikProduksi();
                    } else {
                        this.updateGrafikProduksi();
                    }

                } catch (error) {
                    console.error('Gagal mengambil data:', error);
                }
            },
            makeGrafikProduksi() {
                var ctx = document.getElementById('grafikProduksi').getContext('2d');
                this.grafikProduksi = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: this.grafikData.labels,
                        datasets: [{
                            label: "Jumlah Tempe",
                            borderColor: '#FFAD46',
                            pointBackgroundColor: 'rgba(255, 173, 70, 0.6)',
                            pointRadius: 0,
                            backgroundColor: 'rgba(255, 173, 70, 0.4)',
                            legendColor: '#FFAD46',
                            fill: true,
                            borderWidth: 2,
                            data: this.grafikData.data
                        }]
                    },
                    options : {
                        responsive: true, 
                        maintainAspectRatio: false,
                        legend: {
                            display: false
                        },
                        tooltips: {
                            bodySpacing: 4,
                            mode:"nearest",
                            intersect: 0,
                            position:"nearest",
                            xPadding:10,
                            yPadding:10,
                            caretPadding:10
                        },
                        layout:{
                            padding:{left:5,right:5,top:15,bottom:15}
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    fontStyle: "500",
                                    beginAtZero: false,
                                    maxTicksLimit: 5,
                                    padding: 10
                                },
                                gridLines: {
                                    drawTicks: false,
                                    display: false
                                }
                            }],
                            xAxes: [{
                                gridLines: {
                                    zeroLineColor: "transparent"
                                },
                                ticks: {
                                    padding: 10,
                                    fontStyle: "500"
                                }
                            }]
                        }
                    }
                });
            },
            updateGrafikProduksi() {
                this.grafikProduksi.data.labels = this.grafikData.labels;
                this.grafikProduksi.data.datasets[0].data = this.grafikData.data;
                this.grafikProduksi.update();
            },
            startSyncData() {
                this.syncData.interval = setInterval(() => {
                    this.getAllData();
                }, 3000);
            },
            stopSyncData() {
                clearInterval(this.syncData.interval);
            },
            buttonSyncData() {
                if (!this.syncData.button) {
                    this.startSyncData();
                    this.syncData.button = true;
                } else {
                    this.stopSyncData();
                    this.syncData.button = false;
                }
            },
            async getGrafikMingguan() {
                try {
                    const response = await axios.get(`/get-grafik-mingguan`);
                    this.mingguanData.labels = response.data.labels;
                    this.mingguanData.data = response.data.data;
                    this.mingguanData.total = response.data.total;
                    
                    if (!this.grafikMingguan) {
                        this.makeGrafikMingguan();
                    } else {
                        this.updateGrafikMingguan();
                    }

                } catch (error) {
                    console.error('Gagal mengambil data:', error);
                }
            },
            makeGrafikMingguan() {
                var ctx = document.getElementById('grafikMingguan').getContext('2d');
                this.grafikMingguan = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: this.mingguanData.labels,
                        datasets:[ {
                            label: "Jumlah Produksi", 
                            fill: !0, 
                            backgroundColor: "rgba(255,255,255,0.2)", 
                            borderColor: "#fff", 
                            borderCapStyle: "butt", 
                            borderDash: [], 
                            borderDashOffset: 0, 
                            pointBorderColor: "#fff", 
                            pointBackgroundColor: "#fff", 
                            pointBorderWidth: 1, 
                            pointHoverRadius: 5, 
                            pointHoverBackgroundColor: "#fff", 
                            pointHoverBorderColor: "#fff", 
                            pointHoverBorderWidth: 1, 
                            pointRadius: 1, 
                            pointHitRadius: 5, 
                            data: this.mingguanData.data
                        }]
                    },
                    options : {
                        maintainAspectRatio:!1, legend: {
                            display: !1
                        }
                        , animation: {
                            easing: "easeInOutBack"
                        }
                        , scales: {
                            yAxes:[ {
                                display:!1, ticks: {
                                    fontColor: "rgba(0,0,0,0.5)", fontStyle: "bold", beginAtZero: !0, maxTicksLimit: 10, padding: 0
                                }
                                , gridLines: {
                                    drawTicks: !1, display: !1
                                }
                            }
                            ], xAxes:[ {
                                display:!1, gridLines: {
                                    zeroLineColor: "transparent"
                                }
                                , ticks: {
                                    padding: -20, fontColor: "rgba(255,255,255,0.2)", fontStyle: "bold"
                                }
                            }
                            ]
                        }
                    }
                });
            },
            updateGrafikMingguan() {
                this.grafikMingguan.data.labels = this.mingguanData.labels;
                this.grafikMingguan.data.datasets[0].data = this.mingguanData.data;
                this.grafikMingguan.update();
            },
            async getRiwayatProduksi() {
                try {
                    const response = await axios.get(`/get-riwayat-produksi?start=${this.filter.startDate}&end=${this.filter.endDate}`);
                    this.riwayatProduksi = response.data.riwayatProduksi;
                } catch (error) {
                    console.error('Gagal mengambil data:', error);
                }
            },
        }
    }).mount('#app')
</script>
@endpush