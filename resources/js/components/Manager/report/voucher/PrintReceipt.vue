<template>
  <div>

    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12 connectedSortable">
            <!-- main page load here-->
            <div>
              <router-link to="/report/voucher">
                <i class="fas fa-arrow-left" title="Click to go back"></i>
              </router-link>
              <button @click="print" class="btn btn-primary rounded-0"><i class="fas fa-print">Print</i></button>
            </div>
            <!-- <a @click="$router.go(-1)"><i class="fas fa-arrow-left" title="Click to go back"></i></a> -->
            <div v-if="this.type == 'agent'">
              <div id="printMe" class="card">
                <div class="card-body">
                  <div class="container-fluid mb-5">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="text-capitalize text-center">
                          <h3 style="color:#234790">{{auth_name}}</h3>
                          <span style="color:#193367">{{auth_address}}</span>
                        </div>
                      </div>
                      <div class="col-md">
                        <div class="main-box-parent">
                          <div class="diagonal-box position-absolute w-50 h-25">
                          </div>
                          <div class="text-main-box position-absolute">
                            <h2 style="color:white;">RECEIPT</h2>
                          </div>
                        </div>
                      </div>
                      <div class="col-md">
                        <div class="text-right">
                          <div class="mb-2">
                            <span> Receipt No. </span>
                            <span>{{ this.$route.params.data.recp_no }}</span>
                          </div>
                          <div class="mr-2">
                            <span>Date : </span>
                            <span>{{ this.$route.params.data.date_np }}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="container-fluid">
                    <div class="row text-main-label">
                      <div class="col-12">
                        <div class="d-flex">
                          <label class="align-self-end">Received with thanks from M/s</label>
                          <div class="flex-fill">
                            <!-- <div v-if="this.type=='agent'"> -->
                            <input autocomplete="off" type="text"
                              v-model="this.$route.params.data.get_agent_detail.name"
                              class="form-control form-control-border " name="agentname">
                            <!-- </div> -->
                            <!-- <div v-if="this.type=='default'">
                          <input autocomplete="off" type="text" v-model="clientname" class="form-control form-control-border "
                            name="clientname">
                          </div> -->
                          </div>
                        </div>
                        <div class="d-flex">
                          <label class="align-self-end">the sum of Rupees</label>
                          <div class="flex-fill">
                            <input autocomplete="off" v-if="this.printtype == 'amtac'"
                              v-model="this.$route.params.data.amtac_word" type="text"
                              class="form-control form-control-border" name="price">

                            <input autocomplete="off" v-if="this.printtype == 'amtbc'"
                              v-model="this.$route.params.data.amtpaid_word" type="text"
                              class="form-control form-control-border" name="price">
                          </div>
                          <label class="align-self-end">only,</label>
                        </div>
                        <div class="d-flex">
                          <label class="align-self-end">against</label>
                          <div class="flex-fill">
                            <input autocomplete="off" type="text" class="form-control form-control-border" name=""
                              v-model="kistaname">
                          </div>
                          <label class="align-self-end">dated</label>
                          <div class="flex-fill">
                            <input autocomplete="off" type="text" v-model="this.$route.params.data.date_np"
                              class="form-control form-control-border" name="">
                          </div>
                        </div>
                        <br>
                        <div class="d-flex">
                          <label class="align-self-end">by cash/cheque/Draft No.</label>
                          <div class="flex-fill">
                            <div v-if="this.payment_type == '1'"><input autocomplete="off" type="text" value="Wallet"
                                class="form-control form-control-border"></div>

                            <div v-if="this.payment_type == '2'">
                              <input autocomplete="off" type="text" value="Bank Deposit"
                                class="form-control form-control-border">
                            </div>
                            <div v-if="this.payment_type == '3'">
                              <input autocomplete="off" type="text" value="Cash"
                                class="form-control form-control-border">
                            </div>
                          </div>

                          <label class="align-self-end">payment.</label>
                        </div>
                      </div>
                    </div>
                    <div class="row my-4 justify-content-between">
                      <div class="col-3">
                        <div class="input-group shadow-total">
                          <div class="input-group-prepend">
                            <span
                              class="input-total-box input-group-text rounded-0 border-right-0"><strong>Rs.</strong></span>
                          </div>
                          <input autocomplete="off" type="text" v-if="this.printtype == 'amtac'"
                            class="form-control border-left-0 rounded-0" v-model="this.$route.params.data.amt_ac">

                          <input autocomplete="off" type="text" v-if="this.printtype == 'amtbc'"
                            class="form-control border-left-0 rounded-0" v-model="this.$route.params.data.amount_paid">
                        </div>
                      </div>
                      <div class="col-4 mt-auto">
                        <div class="text-right">
                          <span class="border-top" style="color:#234790">Authorised Signature</span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-10">
                        <div class="foot-blue">
                        </div>
                      </div>
                      <div class="col-2">
                        <div class="foot-red">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>


            <div v-if="this.type == 'default'">
              <div class="card">
                <div class="card-body">
                  <div class="container-fluid mb-5">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="text-capitalize text-center">
                          <h3 style="color:#234790">Deltron Suppliers Pvt. Ltd</h3>
                          <span style="color:#193367">Biratnagar, Nepal</span>
                        </div>
                      </div>
                      <div class="col-md">
                        <div class="main-box-parent">
                          <div class="diagonal-box position-absolute w-50 h-25">
                          </div>
                          <div class="text-main-box position-absolute">
                            <h2 style="color:white;">RECEIPT</h2>
                          </div>
                        </div>
                      </div>
                      <div class="col-md">
                        <div class="text-right">
                          <div class="mb-2">
                            <span>Receipt No.</span>
                            <span>{{ this.$route.params.data.recp_no }}</span>

                          </div>
                          <div class="mr-2">
                            <span>Date : </span>
                            <span>{{ this.$route.params.data.date_np }}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="container-fluid">
                    <div class="row text-main-label">
                      <div class="col-12">
                        <div class="d-flex">
                          <label class="align-self-end">Received with thanks from M/s</label>
                          <div class="flex-fill">
                            <input autocomplete="off" type="text"
                              v-model="this.$route.params.data.get_client_detail.name"
                              class="form-control form-control-border " name="clientname">
                          </div>
                        </div>
                        <div class="d-flex">
                          <label class="align-self-end">the sum of Rupees</label>
                          <div class="flex-fill">
                            <input autocomplete="off" v-model="this.$route.params.data.amtpaid_word" type="text"
                              class="form-control form-control-border" name="price">
                            <!-- <input autocomplete="off" type="text" class="form-control form-control-border" name="price"> -->
                          </div>
                          <label class="align-self-end">only,</label>
                        </div>
                        <div class="d-flex">
                          <label class="align-self-end">against</label>
                          <div class="flex-fill">
                            <input autocomplete="off" type="text" class="form-control form-control-border" name=""
                              v-model="kistaname">
                          </div>
                          <label class="align-self-end">dated</label>
                          <div class="flex-fill">
                            <input autocomplete="off" type="text" v-model="this.$route.params.data.date_np"
                              class="form-control form-control-border" name="">
                          </div>
                        </div>
                        <br>
                        <div class="d-flex">
                          <label class="align-self-end">by cash/cheque/Draft No.</label>
                          <div class="flex-fill">
                            <div v-if="this.payment_type == '1'"><input autocomplete="off" type="text" value="Wallet"
                                class="form-control form-control-border"></div>

                            <div v-if="this.payment_type == '2'">
                              <input autocomplete="off" type="text" value="Bank"
                                class="form-control form-control-border">
                            </div>
                            <div v-if="this.payment_type == '3'">
                              <input autocomplete="off" type="text" value="Cash"
                                class="form-control form-control-border">
                            </div>
                          </div>

                          <label class="align-self-end">payment.</label>
                        </div>
                      </div>
                    </div>
                    <div class="row my-4 justify-content-between">
                      <div class="col-3">
                        <div class="input-group shadow-total">
                          <div class="input-group-prepend">
                            <span
                              class="input-total-box input-group-text rounded-0 border-right-0"><strong>Rs.</strong></span>
                          </div>
                          <input autocomplete="off" type="text" class="form-control border-left-0 rounded-0"
                            v-model="this.$route.params.data.amount_paid">
                        </div>
                      </div>
                      <div class="col-4 mt-auto">
                        <div class="text-right">
                          <span class="border-top" style="color:#234790">Authorised Signature</span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-10">
                        <div class="foot-blue">
                        </div>
                      </div>
                      <div class="col-2">
                        <div class="foot-red">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- <keep-alive>
 <component :is="component" />
</keep-alive> -->
  </div>
</template>
  <style scoped>
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
      component: "VoucherPrint",
      kista_id: '',
      agent_id: '',
      client_id: '',
      status: '',
      agent_name: '',
      type: '',
      auth_name:'',
      auth_address:'',
      payment_type: '',
      kistaname: '',
      data: {
        amt2bepaid: '',
        amtpaid: '',
        name: ''
      },
      printtype: ''
    }
  },
  mounted() {
    console.log("printreceipt")
 axios.get(`/currentuser`)
        .then((response)=>{
          this.auth_name = response.data.currentuser.name;
          this.auth_address = response.data.currentuser.address;
      })

    this.type = this.$route.params.type
    this.printtype = this.$route.params.printtype
    this.payment_type = this.$route.params.data.payment_type
    this.kistaname = this.$route.params.data.get_kista_detail.name + " Kista"
    this.data.amtpaid = this.$route.params.data.amount_paid

    //  this.agentname = this.$route.params.data.get_agent_detail.name
    // this.clientname = this.$route.params.data.get_client_detail.name
  },
  methods: {
    print() {
      console.log("print clicked");
      this.$htmlToPaper('printMe');
    },
  }

}
</script>
