<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0 text-dark xyz">Payment Collection Report</h5>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <router-link to="/#">Home</router-link>
                            </li>
                            <li class="breadcrumb-item active">Payment Collection</li>
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
                                            @change="onChangeAgent($event)" v-model="agent_id">
                                            <option value="">Select Type</option>
                                            <option value="1">Agent</option>
                                            <option value="2">Default</option>
                                        </select>
                                    </div>
                                    <div class="col-md">
                                        <select class="form-control" id="payment_id" name="payment_id"
                                            @change="onChangePayment($event)" v-model="payment_id">
                                            <option value="">Select Payment Type</option>
                                            <option value="1">Digital Wallet</option>
                                            <option value="2">BankCheque</option>
                                            <option value="3">Cash</option>
                                        </select>
                                    </div>
                                    <button class="btn btn-primary btn-block col" @click="savedata">
                                        Click to continue
                                    </button>
                                </div>
                            </div><!-- /.card-header -->

                            <div class="row">

                                <div class="col-8">
                                    <div class="card-body">
                                        <!-- <div class="card-header"> -->

                                        <button @click="print" class="btn btn-primary rounded-0"><i
                                                class="fas fa-print">Print</i></button>

                                        <!-- </div> -->
                                        <div id="print" class="row">
                                            <div v-for="detail in getAllData" :key="detail.id">
                                            </div>
                                            <div class="col-md-12 text-center mb-2">
                                                <h2><span>{{ auth_name }}</span></h2>
                                                <span>{{ auth_address }}</span><br>
                                                <span>Payment Collection Report</span><br>
                                                <span>{{ luckydraw_name }}<span v-if="kista_id && clicked">,</span>
                                                    {{ kista_name }}<span v-if="agent_id && clicked">, {{ atype }}</span>
                                                    </span>
                                            </div>
                                            <!-- </div> -->
                                            
                                            <div class="table-responsive col-md-12" >
                                             <!-- <span class="badge badge-warning p-2" v-if="this.agsts==true">Agent</span> -->

                                                <table class="table table-bordered table-hover table m-0">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th class="text-center">Payment Type</th>
                                                            <th class="text-center">Total Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-center" v-if="this.status == true">
                                                        <tr v-for="(detail, index) in getAllData" :key="detail.id">
                                                            <td class="table-primary">
                                                                {{ ty[index] }}
                                                            </td>
                                                            <td class="table-secondary">Rs.{{ detail }}</td>
                                                        </tr>
                                                    </tbody>
                                                    <tbody class="text-center" v-if="this.status == false">
                                                        <tr>
                                                            <td>
                                                                <span v-if="this.payment_type == '1'">Digital
                                                                    wallet</span>
                                                                <span v-if="this.payment_type == '2'">Bank</span>
                                                                <span v-if="this.payment_type == '3'">Cash</span>

                                                            </td>

                                                            <td>
                                                                Rs.{{ amt }}
                                                            </td>

                                                        </tr>
                                                    </tbody>
                                                    <tfoot class="text-center bg-warning" v-if="this.status == true">
                                                        <tr>
                                                            <td >Grand Total </td>
                                                            <td class="font-weight-bold" colspan="2">
                                                                <span>Rs.{{gtotal}}</span>
                                                                <!-- <span v-if="this.agsts==true">Rs.{{gtotalag}} </span> -->

                                                            </td>
                                                            </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
<!--               
                                                <div class="table-responsive col-md-6" v-if="this.agsts==true">
                                                 <span class="badge badge-success p-2">Default</span>

                                                <table class="table table-bordered table-hover table m-0">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th class="text-center">Payment Type</th>
                                                            <th class="text-center">Total Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-center" v-if="this.status == true ">
                                                        <tr v-for="(detail, index) in getAllDataDef" :key="detail.id">
                                                            <td class="table-primary">
                                                                {{ ty[index] }}
                                                            </td>
                                                            <td class="table-secondary">Rs.{{ detail }}</td>
                                                        </tr>
                                                    </tbody>
                                                    <tbody class="text-center" v-if="this.status == false && this.agsts==true">
                                                        <tr>
                                                            <td>
                                                                <span v-if="this.payment_type == '1'">Digital
                                                                    wallet</span>
                                                                <span v-if="this.payment_type == '2'">Bank</span>
                                                                <span v-if="this.payment_type == '3'">Cash</span>

                                                            </td>

                                                            <td v-if="this.status == false && this.agsts==true">
                                                                Rs.{{ amtdef }}
                                                            </td>

                                                        </tr>
                                                    </tbody>
                                                    <tfoot class="text-center bg-success" v-if="this.status == true">
                                                        <tr>
                                                            <td >Grand Total </td>
                                                            <td class="font-weight-bold" colspan="2">Rs.{{gtotaldef}} </td>

                                                            </tr>
                                                    </tfoot>
                                                </table>
                                            </div> -->

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
            luckydraw_id: '',
            kista_id: '',
            agent_id: '',
            payment_id: '',
            name: '',
        
            ty: ['Digital Wallet','Bank Depo./Cheque','Cash'],
            status: '',
            amt: '',
            amtdef: '',
            gtotal:'',
            gtotalag:'',
            gtotaldef:'',
            state: true,
            click: '',
            agsts:'',
            agentstats: '',
            agent_name: '',
            payment_type: '',
            atype:'',
            luckydraw_name: '',
            kista_name: '',
            lid: '',
            kid: '',
          
            show: false,
            auth_name: '',
            auth_address: '',
            clicked: '',
        }
    },
    mounted() {
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
     
        getAllData() {
            this.$Progress.start()
            var data = this.$store.getters.getPaymentReport;
            if (data.length == 0) return [];
            this.luckydraw_name = data[0].luckydraw_name;
            this.kista_name = data[0].kista_name;
            this.$Progress.finish()
            this.show = data[0].status
            this.status = data[0].status
            // this.gtotalag= data[0].gtotalag
            this.gtotal= data[0].gtotal
            this.payment_type = data[0].ptype
            this.amt = data[1];
            // this.amtdef = data[2];
            this.atype=data[0].atype
            this.agsts=data[0].agsts
            return data[1];
        },

        //  getAllDataDef() {
        //     this.$Progress.start()
        //     var data = this.$store.getters.getPaymentReport;
        //     // console.log(data[0]);
        //     if (data.length == 0) return [];
     
        //     this.gtotalag= data[0].gtotalag
        //     this.gtotaldef= data[0].gtotaldef
        
        //     return data[2];
        // },

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
            this.$store.dispatch("allPaymentCollection", [this.kista_id, this.luckydraw_id, this.agent_name, this.payment_id]);
            this.clicked = true
           
        },
   
        print() {
            this.$htmlToPaper('print');
        },

    }
}
</script>