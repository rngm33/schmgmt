<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark xyz">Members Detail List</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <router-link to="/#">Home</router-link>
              </li>
              <li class="breadcrumb-item active">Detail</li>
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
                      v-model="agent_id" @change="agentChange">
                      <option value="">Select Agent</option>
                      <option :value="agent.id" v-for="agent in getAllAgent">{{ agent.name }}</option>
                    </select>
                  </div>
                  <button class="btn btn-primary btn-block col" @click="savedata">{{ "Click to continue" }}
                  </button>
                </div>
              </div><!-- /.card-header -->
              <form role="form" @submit.prevent="addDetail()">
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm m-0">
                      <thead class="thead-light">
                        <tr>
                          <th width="10">SN</th>
                          <th class="text-left">Name</th>
                          <th class="text-center">Status</th>
                          <th class="text-center">Payment Method</th>
                        </tr>
                      </thead>
                      <tbody class="text-center" v-if="this.status == false && click && this.agentstats == false">
                        <tr v-for="(detail, index) in getAllDetail" :key="detail.id">
                          <td>{{ index + 1 }}</td>
                          <td class="text-left">
                            <input type="hidden" class="form-control" name="id" v-model="detail.id">
                            <!-- <span class="text-primary">{{detail.name}} ({{detail.serial_no}})</span> -->
                            <span class="text-primary">{{ detail.name }}</span>
                          </td>

                          <td v-if="detail.is_leave == '1'">
                            <input type="radio" id="unpaid[index]" value="1" v-model="lottery_status[index]">
                            <label for="unpaid[index]">Unpay</label>

                            <input type="radio" id="already_pay[index]" value="2" v-model="lottery_status[index]">
                            <label for="already_pay[index]">Pay</label>

                            <input type="radio" id="leave[index]" value="3" class="d-none"
                              v-model="lottery_status[index]">
                            <input type="text" name="amount[]" v-model="amount[index]"
                              :disabled="lottery_status[index] == 1">
                          </td>

                          <td v-if="detail.is_leave == '0'">
                            <input type="radio" id="leave" value="3" v-model="lottery_status[index]"><label
                              for="leave">Leave</label>
                          </td>

                        </tr>
                      </tbody>

                      <tbody class="text-center" v-if="this.status == true && click && this.agentstats == false">
                        <tr v-for="(play, ind) in getAllDetail" :key="play.id">
                          <td>{{ ind + 1 }}</td>
                          <td class="text-left">

                            <!-- <span class="text-primary">{{play.get_client_info.name}} ({{play.get_client_info.serial_no}})</span> -->
                            <span class="text-primary">{{ play.get_client_info.name }}</span>
                          </td>
                          <td>
                            <span class="text-danger" v-if="play.lottery_status == '1'">UnPaid {{ play.amount }}</span>
                            <span class="text-primary" v-if="play.lottery_status == '2'">Paid {{ play.amount }}
                              <!--  <router-link :to="`/client/prize/${play.id}`" class="btn btn-xs btn-outline-info" title="Add Lottery Prize"><i class="fas fa-plus fa-sm"></i>
                          </router-link>
                          <span class="badge badge-warning text-info float-sm-right" v-if="play.lottery_prize != null ">{{play.lottery_prize}} is allocated</span>  -->
                            </span>
                            <span class="text-warning" v-if="play.lottery_status == '3'">Leave</span>
                            <span class="float-right">
                              <a href="" @click.prevent="editClientDetail(play.id, play.lottery_status)"
                                class="btn btn-xs btn-outline-success" title="Click to Revise"><i
                                  class="fas fa-undo"></i></a>
                            </span>
                          </td>
                        </tr>
                      </tbody>

                      <tbody class="text-center" v-if="this.status == false && this.agentstats == true">
                        <tr v-for="(detail, index) in getAllDetail" :key="detail.id">
                          <td>{{ index + 1 }}</td>

                          <td class="text-left">
                            <input type="hidden" class="form-control" name="id" v-model="detail.id">
                            <span class="text-primary">{{ detail.name }}</span>
                          </td>
                          <td v-if="detail.is_leave == '1'">
                            <input type="radio" v-on:click="checkPayType(index, $event)" id="unpaid[index]" value="1"
                              v-model="lottery_status[index]">
                            <label for="unpaid[index]">Unpay</label>

                            <input type="radio" id="already_pay[index]" value="2" v-model="lottery_status[index]">
                            <label for="already_pay[index]">Pay</label>

                            <input type="radio" id="leave[index]" value="3" class="d-none"
                              v-model="lottery_status[index]">
                            <input type="text" name="amount[]" v-model="amount[index]"
                              :disabled="lottery_status[index] == 1">
                          </td>
                          <td v-if="detail.is_leave == '0'">
                            <input type="radio" id="leave" value="3" v-model="lottery_status[index]"><label
                              for="leave">Leave</label>
                          </td>
                          <td>

                            <input type="radio" id="wallet[index]" value=" 1" :disabled="disableRd(index)"
                              v-model="payment_type[index]">
                            <label for="wallet[index]">Digital Wallet</label>

                            <input type="radio" id="bank[index]" value="2" :disabled="disableRd(index)"
                              v-model="payment_type[index]">
                            <label for="bank[index]">Bank Deposit/Cheque</label>

                            <input type="radio" id="cash[index]" value="3" :disabled="disableRd(index)"
                              v-model="payment_type[index]">
                            <label for="cash[index]">Cash</label>
                          </td>

                        </tr>
                      </tbody>

                      <tbody class="text-center" v-if="this.status == true && this.agentstats == true">
                        <input type="hidden" class="form-control" v-model="updateMode">

                        <tr v-for="(detail, index) in getAllDetail" :key="detail.id"
                          :class="{ voucherbg: stscolor == detail.client_id }">
                          <td>{{ index + 1 }}</td>

                          <td class="text-left">
                            <span class="text-primary">{{ detail.get_client_info.name }}</span>
                          </td>

                          <td>
                            <span class="text-danger" v-if="detail.lottery_status == '1'">UnPaid
                              {{ detail.amount }}</span>
                            <span class="text-primary" v-if="detail.lottery_status == '2'">Paid Rs. {{ detail.amount }}
                            </span>

                            <span class="text-success" v-if="detail.payment_type == '1'">( Digital Wallet )</span>
                            <span class="text-success" v-if="detail.payment_type == '2'">( Bank Deposit/Cheque )</span>
                            <span class="text-success" v-if="detail.payment_type == '3'">( Cash )</span>
                          </td>

                          <td v-if="detail.lottery_status == 1 && detail.get_client_info.is_leave == 1">
                            <input type="radio" v-on:click="checkPayType(index, $event)" id="unpaid[index]" value="1"
                              v-on:change="onChangePay($event, index, detail.client_id)"
                              v-model="lottery_status[index]">
                            <label for="unpaid[index]">Unpay</label>

                            <input type="radio" id="already_pay[index]" value="2"
                              v-on:change="onChangePay($event, index, detail.client_id)"
                              v-model="lottery_status[index]">
                            <label for="already_pay[index]">Pay</label>

                            <input type="radio" id="leave[index]" value="3" class="d-none"
                              v-model="lottery_status[index]">
                            <input type="text" name="amount[]" v-model="amount[index]"
                              :disabled="lottery_status[index] == 1">

                            <input type="radio" id="wallet[index]" value=" 1" :disabled="disableRd(index)"
                              v-model="payment_type[index]">
                            <label for="wallet[index]">Digital Wallet</label>

                            <input type="radio" id="bank[index]" value="2" :disabled="disableRd(index)"
                              v-model="payment_type[index]">
                            <label for="bank[index]">Bank Deposit/Cheque</label>

                            <input type="radio" id="cash[index]" value="3" :disabled="disableRd(index)"
                              v-model="payment_type[index]">
                            <label for="cash[index]">Cash</label>

                            <a v-on:click="updateclientPayment(detail.client_id, index)" class="btn btn-success">
                              {{ state.isSending ? "saving..." : "Save" }} </a>
                          </td>

                          <!-- <td>                            
</td> -->

                        </tr>
                      </tbody>
                      <!-- <tfoot v-if="this.status == true && this.agentstats == true && this.lotsts != 0">
                        <tr>
                          <td colspan="4" class="text-center">
                            <button type="submit" class="btn btn-success">Save</button>{{ count }}
                          </td>
                        </tr>
                      </tfoot> -->

                      <tfoot v-if="this.status == false">
                        <tr>
                          <td colspan="4" class="text-center">
                            <button type="submit" class="btn btn-success">Save</button>{{ count }}
                          </td>
                        </tr>
                      </tfoot>

                    </table>
                  </div>
                </div>
              </form>
            </div>
          </section>
        </div>
      </div><!-- /.container-fluid -->

    </section>
  </div>
</template>
 <style>
 .voucherbg {
   background-color: rgb(139, 138, 212);
   font-weight: normal;
 }
 </style>
<script>
export default {
  name: "List",
  components: {
  },
  data() {
    return {
      luckydraw_id: '',
      kista_id: '',
      agent_id: '',
      lottery_status: [],
      status: '',
      amount: [],
      state: {
        isSending: false,
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
      payment_type: [],
      valueTrue: 'true',
      valueFalse: 'false',
      lotsts: '',
      stscolor: 0

    }
  },
  mounted() {
    console.log('mounted')
    this.$store.dispatch("allSelectLuckyDraw")

  },
  computed: {
    updateMode: {
      get() {
        if (this.status == true && this.agentstats == true) {
          return this.valueTrue
        } else {
          return this.valueFalse
        }
      },
      set(val) {
        if (this.status == true && this.agentstats == true) {
          this.valueTrue = val
        } else {
          this.valueFalse = val
        }
      }
    },
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
      var data = this.$store.getters.getDetail;
      if (data.length == 0) return [];
      // if(data[0].kistadetails.get_client_info == 0) return [];
      this.status = data[0].status;
      // this.amount = data[0].kistaAmount;
      console.log(data[0].status, this.agentstats);

      this.amount = data[0].kistadetails.map(function (kd, i) {
        return data[0].kistaAmount;
      });
      this.lottery_status = data[0].kistadetails.map(function (kd, i) {
        return 2;
      });
      this.payment_type = data[0].kistadetails.map(function (kd, i) {
        return 3;
      });

      this.lotsts = data[0].lotsts;


      this.$Progress.finish()
      return data[0].kistadetails;
    },
  },
  methods: {
    colorchange(id) {
      return {
        'table-danger': !id,
        'table-default': id
      }
    },
    onChangePay(event, index, cid) {
      // console.log(cid)
      var lottery_status = event.target.value;
      if (lottery_status == 2) {
        this.payment_type[index] = 3;

      }
      if (lottery_status == 1) {
        this.payment_type[index] == null;
        this.amount[index] == null;
      }

    },
    checkPayType(index, event) {
      if (event.target.checked) {
        // console.log("unpay"+ index)
        return this.payment_type[index] = null

      }

    },
    disableRd(index) {
      return true ? this.lottery_status[index] == '1' : false;
    },
    addDetail: function addDetail() {
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
          axios.post('/manager/detail', {
            data: that.getAllDetail,
            lottery_status: that.lottery_status,
            amount: that.amount,
            agent_id: that.agent_id,
            luckydraw_id: that.luckydraw_id,
            kista_id: that.kista_id,
            payment_type: that.payment_type,
            updateMode: that.updateMode
          }).then(function (response) {

            if (response.data.message === "kistaempty") {
              Toast.fire({
                icon: 'error',
                title: 'Previous Kista Is Not Paid'
              });
            }

            // that.$store.dispatch("allDetail");
            if (response.data.message === "success") {
              window.location.reload();
              that.state.isSending = true;
              Toast.fire({
                icon: 'success',
                title: 'Detail Updated successfully'
              });
            }
          })["catch"](function () { });
        } else {
          Toast.fire({
            icon: 'error',
            title: 'Data couldnot save'
          });
        }
      });
    },
    updateclientPayment(cid, index) {
      var that = this;
      var ls = that.lottery_status[index];
      var pt = that.payment_type[index];
      var amt = that.amount[index];
      var kid = that.kista_id;
      var lid = that.luckydraw_id;

      axios.post('/manager/detail', {
        cid: cid, ls: ls, pt: pt, amt: amt, kid: kid, lid: lid,
        updateMode: that.updateMode
      }).then(function (response) {
        // console.log(response.data.id);

        if (response.data.status === "success") {
          Toast.fire({
            icon: 'success',
            title: 'Data updated successfully'
          })
          window.location.reload();

          that.stscolor = response.data.id;
          that.state.isSending = true;
        }

      })["catch"](function () { });

    },
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
              // this.$router.push('/home/revise');
              // this.$router.go()
              // this.$store.dispatch("allDetail",[0,0]);
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
      if (this.agent_name.toLowerCase() == "default") {
        console.log("default selected");
        this.agentstats = true;

      }
      else {
        console.log("not ok");
        this.agentstats = false;

      }
      this.$store.dispatch("allDetail", [this.agent_id, this.kista_id]);
      this.click = true;
    },
  }
}
</script>
