<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0 text-dark xyz">Payment Method Report</h5>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <router-link to="/#">Home</router-link>
                            </li>
                            <li class="breadcrumb-item active">Payment Method</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-12 connectedSortable">
                        <!-- main page load here-->


                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md">
                                        <select class="form-control" id="luckydraw_id" v-model="luckydraw_id"
                                            name="luckydraw_id" @change="luckydrawChange">
                                            <option disabled value="">Select one scheme</option>
                                            <option :value="luckydraw.id" v-for="luckydraw in allSelectLuckyDraws">
                                                {{ luckydraw.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md">
                                        <select class="form-control" id="kista_id" name="kista_id" v-model="kista_id"
                                            @change="kistaChange">
                                            <option value="">Select Kista</option>
                                            <option :value="kista.id" v-for="kista in getAllKista">{{ kista.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md">
                                        <select class="form-control" id="agent_id" name="agent_id"
                                            v-on:change="onChangeAgent($event)" v-model="agent_id">
                                            <option disabled value="">Select Type</option>
                                            <option>Agent</option>
                                            <option>Default</option>
                                        </select>
                                    </div>
                                    <button class="btn btn-primary btn-block col" @click="savedata">
                                    Click to continue
                                    </button>
                                </div>
                            </div><!-- /.card-header -->

                            <div class="row">
                                <div class="col-4">

                                    <!-- <form role="form" @submit.prevent="addDetail()"> -->
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-sm m-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th width="10">SN</th>
                                                        <th class="text-center">Name</th>
                                                        <th class="text-center">Address</th>
                                                        <th class="text-center">Phone</th>
                                                        <th class="text-center">Action</th>

                                                    </tr>
                                                </thead>

                                                <tbody class="text-center" v-if="this.status == true">
                                                    <tr v-for="(detail, index) in getAllDetail" :key="detail.id">
                                                        <td>{{ index + 1 }}
                                                        </td>
                                                        <td>
                                                            <input type="hidden" class="form-control" name="id"
                                                                v-model="detail.id">
                                                            <span class="text-primary">{{ detail.name }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="text-primary">{{ detail.address }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="text-primary">{{ detail.phone }}</span>
                                                        </td>
                                                        <td class="text-left">
                                                            <!-- <router-link :to="{ name: 'voucheragent', params: { agentid: detail.id,
                           lid: lid,kid: kid }}" class="btn btn-xs btn-outline-info" title="View">
                            <i class="fas fa-eye">
                          
                            </i>
                          </router-link>  -->
                                                            <button class="btn btn-xs btn-outline-info" title="View"><i
                                                                    class="fas fa-eye"
                                                                    @click="fetchAgentVoucherReport(detail.name, detail.id)">

                                                                </i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tbody class="text-center" v-if="this.status == false">
                                                    <tr v-for="(detail, index) in getAllDetail" :key="detail.id">
                                                        <td>{{ index + 1 }}</td>

                                                        <td>
                                                            <!-- <input type="hidden" class="form-control" name="id" v-model="detail.id"> -->
                                                            <span class="text-primary">{{ detail.name }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="text-primary">{{ detail.address }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="text-primary">{{ detail.phone }}</span>
                                                        </td>
                                                        <td class="text-left">

                                                            <button class="btn btn-xs btn-outline-info" title="View"><i
                                                                    class="fas fa-eye"
                                                                    @click="fetchDefaultVoucherReport(detail.name, detail.id, detail.agent_id)">

                                                                </i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- </form> -->

                                </div>

                                <div class="col-8" v-show="show" id="lol">
                                    <div class="card-body">
                                        <!-- <div class="card-header"> -->
                                        <span class="badge badge-success text-uppercase p-2">
                                            {{ name }}
                                        </span>
                                        <button @click="print" class="btn btn-primary rounded-0"><i
                                                class="fas fa-print">Print</i></button>

                                        <!-- </div> -->
                                        <div id="print" class="row">
                                            <!-- <div v-for="(detail, index) in getAllData" :key="detail.id"> -->

                                            <div class="col-md-12 text-center mb-2">
                                                <span> {{ auth_name }} , {{auth_address}} </span><br>
                                                <span>Payment Method Report</span><br>
                      <span>{{luckydraw_name}}<span v-if="kista_id && clicked">,</span> {{kista_name}}<span v-if="agent_id && clicked">,</span> {{name}}</span>
                                            </div>
                                            <!-- </div> -->
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-sm m-0">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th width="10">SN</th>
                                                            <th class="text-center">Payment Type</th>
                                                            <th class="text-center">Amount to be paid</th>
                                                            <th class="text-center">Amount Paid</th>
                                                            <th class="text-center">Due</th>
                                                            <th class="text-center">Paid At</th>

                                                        </tr>
                                                    </thead>
                                                    <!-- <div v-for="(detail) in getAllData" :key="detail.id">
                      <div v-if="!detail.length">no data</div>
                      <div v-else>  -->

                                                    <!-- //default -->
                                                    <tbody class="text-center" v-if="this.reportsts == false">
                                                        <tr v-for="(detail, index) in getAllData" :key="detail.id">
                                                            <td>{{ index + 1 }}
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-info text-white p-2"
                                                                    v-if="detail.payment_type == '1'">Wallet</span>
                                                                <span class="badge badge-info text-white p-2"
                                                                    v-if="detail.payment_type == '2'">Bank</span>
                                                                <span class="badge badge-info text-white p-2"
                                                                    v-if="detail.payment_type == '3'">Cash</span>

                                                            </td>

                                                            <td>
                                                                <span class="text-primary">{{ detail.amt_to_be_paid
                                                                }}</span>
                                                            </td>
                                                            <td>
                                                                <span class="text-primary">{{ detail.amount_paid
                                                                }}</span>
                                                            </td>
                                                            <td>
                                                                <span class="text-primary">{{ (detail.amt_to_be_paid -
                                                                        detail.amount_paid)
                                                                }}</span>
                                                            </td>
                                                            <td>
                                                                {{ detail.date_np }}
                                                                <span class="badge badge-warning text-danger">{{
                                                                        detail.created_at | formatDate
                                                                }}</span>
                                                            </td>

                                                        </tr>
                                                    </tbody>

                                                    <!-- //agent -->
                                                    <tbody class="text-center" v-if="this.reportsts == true">
                                                        <tr v-for="(detail, index) in getAllData" :key="detail.id">
                                                            <td>{{ index + 1 }}
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-success text-warning p-2"
                                                                    v-if="detail.payment_type == '1'">Wallet</span>
                                                                <span class="badge badge-success text-warning p-2"
                                                                    v-if="detail.payment_type == '2'">Bank</span>
                                                                <span class="badge badge-success text-warning p-2"
                                                                    v-if="detail.payment_type == '3'">Cash</span>

                                                            </td>

                                                            <td>
                                                                <span class="text-primary">{{ detail.amt_to_be_paid
                                                                }}</span>
                                                            </td>
                                                            <td>
                                                                <span class="text-primary">{{ detail.amount_paid
                                                                }}</span>
                                                            </td>
                                                            <td>
                                                                <span class="text-primary">{{ (detail.amt_to_be_paid -
                                                                        detail.amount_paid)
                                                                }}</span>
                                                            </td>
                                                            <td>
                                                                {{ detail.date_np }}
                                                                <span class="badge badge-warning text-danger">{{
                                                                        detail.created_at | formatDate
                                                                }}</span>
                                                            </td>

                                                        </tr>
                                                    </tbody>
                                                    <!-- </div> 
                        </div> -->

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- </form> -->
                                </div>
                            </div>
                        </div>

                    </section>
                </div>
            </div><!-- /.container-fluid -->
        </section>

    </div>

</template>
<style>
.no-border {
    border: 0;
    box-shadow: none;
}
</style>
<script>
import DatePicker from 'v-calendar/lib/components/date-picker.umd';
import moment from 'moment'

export default {
    name: "List",
    components: {
        DatePicker
    },
    data() {
        return {
            form: new Form({
                name: '',
                amount: '',
                date: moment(new Date()).format('YYYY-MM-DD'),
                // date: '',
                luckydraw_id: '',

            }),
            luckydraw_id: '',
            kista_id: '',
            agent_id: '',
            name: '',
            lottery_status: [],
            status: '',
            reportsts: '',
            amount: [],
            state: {
                isSending: true,
                isOrdering: true
            },
            gender: "female",
            isOnline: "2",
            items:
                [
                    { txt: 'pay', val: 1 },
                    { txt: 'unpay', val: 2 }
                ],
            comparisonvalue: '2',
            state: true,
            count: '',
            click: '',
            agentstats: '',
            agent_name: '',
            payment_type: '',
            luckydraw_name:'',
            lid: '',
            kid: '',
            data: {
                amt2bepaid: '',
                amtpaid: '',
                name: ''
            },
            show: false,
            auth_name: '',
            auth_address: '',
        }
    },
    mounted() {
        console.log("report voucher")
        axios.get(`/currentuser`)
            .then((response) => {
                this.auth_name = response.data.currentuser.name;
                this.auth_address = response.data.currentuser.address;
            })
        this.$store.dispatch("allSelectLuckyDraw")

    },
    computed: {
        allSelectLuckyDraws() {
            var a = this.$store.getters.getSelectLuckyDraw[0]
            return a;
        },
        getAllKista() {
            var b = this.$store.getters.getSelectKista
            return b[0];
        },
        getAllAgent() {
            var b = this.$store.getters.getSelectAgent
            return b[0];
        },
        getAllDetail() {
            this.$Progress.start()
            var data = this.$store.getters.getDetailVoucherReport;
            console.log(data)
            if (data.length == 0) return [];
            this.$Progress.finish()

            this.status = data[0].status;
            return data[0].respo;
        },

        getAllData() {
            this.$Progress.start()
            var data = this.$store.getters.getVoucherReport;
            if (data.length == 0) return [];
            this.luckydraw_name=data[0].luckydraw_name;
            this.$Progress.finish()
            this.show = true
            this.reportsts = data[0].status;
            return data[0].respo;
        },

    },
    methods: {
        agentChange() {
            this.$store.dispatch("allSelectAgent", [this.kista_id]);
        },
        onChangeAgent: function (e) {
            var id = e.target.value;
            var name = e.target.options[e.target.options.selectedIndex].text;
            this.agent_name = name;
        },
        kistaChange() {
            this.$store.dispatch("allSelectKista", [this.luckydraw_id]);
            this.agentChange();
        },
        luckydrawChange() {
            this.kistaChange();
        },
        savedata() {
            if (this.agent_name == "default") {
                this.agentstats = true;
            }
            else {
                this.agentstats = false;
            }
            this.$store.dispatch("allReportVoucher", [this.luckydraw_id, this.kista_id, this.agent_name]);

            this.clearData()
            this.kid = this.kista_id;
            this.lid = this.luckydraw_id;
            this.click = true;
        },
        clearData() {
            this.data.name = "";
            this.data.amtpaid = "";
            this.data.amt2bepaid = "";
            this.show = false
        },
        fetchAgentVoucherReport(name, agentid) {
            this.name = name
            this.$store.dispatch("allDefaultVoucherReport", [null, this.kid, this.lid, agentid]);

        },
        fetchDefaultVoucherReport(name, clientid, agentid) {
            this.agent_id = agentid
            this.name = name
            this.$store.dispatch("allDefaultVoucherReport", [clientid, this.kid, this.lid, null]);

        },
        print() {
            this.$htmlToPaper('print');
        },

    }
}
</script>