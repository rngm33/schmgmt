<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark xyz">Voucher</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <router-link to="/#">Home</router-link>
              </li>
              <li class="breadcrumb-item active">Voucher</li>
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
                    <select class="form-control" id="luckydraw_id" v-model="luckydraw_id" name="luckydraw_id"
                      @change="luckydrawChange">
                      <option disabled value="">Select one scheme</option>
                      <option :value="luckydraw.id" v-for="luckydraw in allSelectLuckyDraws">
                        {{ luckydraw.name }}
                      </option>
                    </select>
                  </div>
                  <div class="col-md">
                    <select class="form-control" id="kista_id" name="kista_id" v-model="kista_id" @change="kistaChange">
                      <option value="">Select Kista</option>
                      <option :value="kista.id" v-for="kista in getAllKista">{{ kista.name }}</option>
                    </select>
                  </div>
                  <div class="col-md">
                    <select class="form-control" id="agent_id" name="agent_id" v-on:change="onChangeAgent($event)"
                      v-model="agent_id">
                      <option disabled value="">Select Type</option>
                      <option>Agent</option>
                      <option>Default</option>

                    </select>
                  </div>
                  <button class="btn btn-primary btn-block col" @click="savedata">{{ "Click to continue" }}
                  </button>
                </div>
              </div><!-- /.card-header -->

              <div class="row">
                <div class="col-7">

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
                            <td>{{ index + 1 }}</td>

                            <td>
                              <input type="hidden" class="form-control" name="id" v-model="detail.id">
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
                              <button class="btn btn-xs btn-outline-info" title="View"><i class="fas fa-eye"
                                  @click="fetchAgentData(detail.id)">

                                </i></button>
                            </td>
                          </tr>
                        </tbody>
                        <tbody class="text-center" v-if="this.status == false">
                          <tr v-for="(detail, index) in getAllDetail" :key="detail.id">
                            <td>{{ index + 1 }}</td>

                            <td>
                              <!-- <input type="hidden" class="form-control" name="id" v-model="detail.id"> -->
                              <span class="text-primary">{{ detail.get_client_info.name }}</span>
                            </td>
                            <td>
                              <span class="text-primary">{{ detail.get_client_info.address }}</span>
                            </td>
                            <td>
                              <span class="text-primary">{{ detail.get_client_info.phone }}</span>
                            </td>
                            <td class="text-left">
                              <!-- <router-link :to="{ name: 'voucheragent', params: { agentid: detail.id,
                           lid: lid,kid: kid }}" class="btn btn-xs btn-outline-info" title="View">
                            <i class="fas fa-eye">
                          
                            </i>
                          </router-link>  -->
                              <button class="btn btn-xs btn-outline-info" title="View"><i class="fas fa-eye"
                                  @click="fetchDefaultData(detail.get_client_info.id,detail.agent_id)">

                                </i></button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <!-- </form> -->

                </div>

                <div class="col-5" v-show="show" id="lol">
                  <!-- <div class="box box-default position-relative"> -->
                  <form role="form" enctype="multipart/form-data" @submit.prevent="saveVoucherData()">
                    <div class="card">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-12">
                            <h4><span class="badge badge-warning p-2 ">{{ this.data.name }}</span>
                            </h4>
                          </div>
                          
                          <div class="col-md-12">
                            <label class="form-control no-border">Amount To Be paid : <span
                                class="badge badge-primary p-2">RS. {{
                                    this.data.amt2bepaid
                                }}</span> </label>
                          </div>

                          <div class="col-md-12">
                            <label class="form-control no-border">Paid Amount :
                              <span class="badge badge-success p-2">RS. {{ this.data.amtpaid }}</span></label>
                          </div>

                          <div class="col-md-12">
                            <label class="form-control no-border">Due Amount :
                              <span class="badge badge-danger p-2">
                                RS. {{ this.data.amt2bepaid - this.data.amtpaid }}</span>
                            </label>
                          </div>

                          <div class="col-md-12">
                            <label class="form-control no-border">Date</label>
                            <date-picker v-model="form.date" format="YYYY-MM-dd" name="date" :max-date='new Date()'>
                              <template v-slot="{ inputValue, inputEvents }">
                                <input class="bg-white border px-2 py-1 rounded form-control" :value="inputValue"
                                  v-on="inputEvents" />
                              </template>
                            </date-picker>

                            <has-error :form="form" field="date"></has-error>
                          </div>

                          <div class="col-md-12">
                            <label class="form-control no-border">Payment Type</label>
                            <input type="radio" id="wallet" value="1" v-model="payment_type">
                            <label for="wallet">Digital Wallet</label>

                            <input type="radio" id="bank" value="2" v-model="payment_type">
                            <label for="bank">Bank Deposit/Cheque</label>

                            <input type="radio" id="cash" value="3" v-model="payment_type">
                            <label for="cash">Cash</label>
                          </div>

                          <div class="col-md-12">
                          <button type="submit" class="btn btn-primary mx-auto d-block" :disabled="state.isSending">{{
                              state.isSending ?
                                "Loading..." : "Save"
                          }}</button>
                          </div>
                        </div>
                      </div>
                    </div>

                  </form>
                  <!-- </div> -->
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
      client_id: '',
      lottery_status: [],
      status: '',
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
      valueTrue: 'true',
      valueFalse: 'false',
      lid: '',
      kid: '',
      data: {
        amt2bepaid: '',
        amtpaid: '',
        name: ''
      }, show: false
    }
  },
  mounted() {
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
      var data = this.$store.getters.getDetailVoucher;
      if (data.length == 0) return [];
      this.$Progress.finish()

      this.status = data[0].status;
      return data[0].respo;
    },
  },
  methods: {
    editClientDetail(id, lotteryStatus) {
      var that = this;
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, change it!',
        cancelButtonText: 'No, cancel!',
        buttonsStyling: true
      }).then(function (isConfirm) {
        if (isConfirm.value === true) {
          axios.get('/manager/detail/revise/' + id + '/' + lotteryStatus)
            .then((response) => {
              Toast.fire({
                icon: 'success',
                title: 'Data Changed successfully'
              })
              window.location.reload();
              this.$store.dispatch("allDetail", [0, 0, 0]);

            })
            .catch((response) => {
              // Toast.fire({
              //   icon: 'error',
              //   title: 'Something went wrong'
              // })
            })
        }
        else {
          Toast.fire({
            icon: 'error',
            title: ' not Changed'
          })
        }
      })
    },
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
      this.$store.dispatch("allDetailvoucher", [this.luckydraw_id, this.kista_id, this.agent_name]);

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
    fetchAgentData(id) {
      axios.get("/manager/mdetailvoucheragent/" + "?agentid=" + id +
        "&kistaid=" + this.kid + "&luckydrawid=" + this.lid)
        .then((response) => {
          this.data.amt2bepaid = response.data.amt2bepaid
          this.data.amtpaid = response.data.amtpaid
          this.agent_id = id
          this.data.name = response.data.agent.name
          this.payment_type = 3
          this.show = true

        })
    },
    fetchDefaultData(clientid,agentid) {
      axios.get("/manager/mdetailvoucherdef/" + "?clientid=" + clientid +
        "&kistaid=" + this.kid + "&luckydrawid=" + this.lid)
        .then((response) => {
          console.log(response.data.respo)
          this.data.amt2bepaid = response.data.kistaamt
          this.data.amtpaid = response.data.respo.amount
          this.agent_id = agentid
          this.client_id= clientid
          this.data.name = response.data.respo.get_client_info.name
          this.payment_type = 3
          this.show = true
        })
    },
    saveVoucherData: function saveVoucherData() {
      var that = this;
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Save it!',
        cancelButtonText: 'No, cancel!',
        buttonsStyling: true
      }).then(function (isConfirm) {
        if (isConfirm.value === true) {
          console.log("isConfirm.value === true");

          axios.post('/manager/voucher/add', {
            amt2bepaid: that.data.amt2bepaid,
            amtpaid: that.data.amtpaid,
            agent_id: that.agent_id,
            client_id: that.client_id,
            luckydraw_id: that.lid,
            kista_id: that.kid,
            date: moment(that.form.date).format('YYYY-MM-DD'),
            payment_type: that.payment_type,
            type: that.agent_name

          }).then(function (response) {
            // window.location.reload();
            if(response.data.status==="success") {
              Toast.fire({
                icon: 'success',
                title: 'voucher added successfully'
              });
              that.show=false;
              that.state.isSending = true;
              
            }
          })["catch"](function () { });
        } else {
          Toast.fire({
            icon: 'error',
            title: 'Data could not save'
          });
        }
      });
    },

  }
}
</script>