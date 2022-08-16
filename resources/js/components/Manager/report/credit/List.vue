<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark">Credit Report</h5>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/#">Home</router-link></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <section class="col-lg-12 connectedSortable">
            <button @click="print" class="btn btn-primary rounded-0"><i class="fas fa-print">Print</i></button>
            <div class="card card-info card-outline">
              <div class="card-header">
                <div class="row">
                  <div class="form-group col-md-12">
                    <date-picker mode='range' v-model="date" lang="en" type="date" format="YYYY-MM-dd" v-on:input="dateChange" is-range>
                      <template v-slot="{ inputValue, inputEvents }">
                        <div class="d-flex justify-content-between">
                          <v-nepalidatepicker classValue="form-control" v-model="englishDate" placeholder="to"/>
                          <v-nepalidatepicker classValue="form-control" v-model="englishDate" placeholder="from"/>
                          <div>
                            <input
                            :value="inputValue.start"
                            v-on="inputEvents.start"
                            class="border px-2 py-1 w-32 rounded focus:outline-none focus:border-indigo-300"
                            /><i class="fas fa-arrow-right fa-fw"></i>
                            <input
                            :value="inputValue.end"
                            v-on="inputEvents.end"
                            class="border px-2 py-1 w-32 rounded focus:outline-none focus:border-indigo-300"
                            />
                          </div>
                        </div>
                      </template>
                    </date-picker>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div id="printMe">
                  <div class="row">
                    <div class="col-md-12 text-center mb-2">
                      <span>Deltron Suppliers Pvt.Ltd.</span><br>
                      <span>Credit Report</span><br>
                      <span>({{to_date}} / {{from_date}})</span>
                    </div>
                    <div class="card-body">
                            <div class="table-responsive">
                              <table class="table table-bordered table-hover table-sm m-0">
                                <thead class="table-primary text-center">                  
                                  <tr>
                                    <th width="10">SN</th>
                                    <th class="text-center">Creditor</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="(data, index) in getAllPurchase" :key="data.id">
                                    <td>{{ index + 1 }}</td>
                                    <td class="text-left">{{ data.supplier_name }}</td>
                                    <td>{{ data.amount }}</td>
                                    <td>
                                      <input type="button" value="Pay">
                                    </td>
                                    <td>
                                      <span class="badge badge-warning">{{ data.date_np }}</span>
                                    </td>

                                  </tr>
                                </tbody>

                              </table>
                              <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="fetchPosts"></pagination>
                            </div>
                  </div>

                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import pagination from '../../../../components/PaginationComponent.vue';
import DatePicker from 'v-calendar/lib/components/date-picker.umd';
import moment from 'moment'
export default {
  name: "List",
  components: {
    pagination,
    DatePicker
  },
  data() {
    return {
      pagination: {
        'current_page': 1
      },
      form: new Form({
        title: '',
        file: null,
      }),
      cost_price: '',
      total: '',
      lottery_status: '',
      date: {
        start: moment().subtract(1, 'months')._d, // Jan 16th, 2018
        end: new Date()    // Jan 19th, 2018
      },
      state: {
        isSending: false
      },
      search: '',
      auth_name: '',
      auth_address: '',
      to_date: '',
      from_date: '',
    }
  },
  mounted() {
    this.$Progress.start()
    this.fetchPosts();
    axios.get(`/currentuser`)
      .then((response) => {
        this.auth_name = response.data.currentuser.name;
        this.auth_address = response.data.currentuser.address;
      })
    this.$Progress.finish()
  },
  computed: {
    getAllPurchase() {
      var b = this.$store.getters.getPurchaseReport;
      this.total = b[2];
      this.to_date = b[3];
      this.from_date = b[4];
      if (b.length == 3)
        this.pagination = b[1];
      return b[0];
    },

  },
  methods: {
    fetchPosts() {
      this.pagechange();
      // this.$store.dispatch("allPurchaseReport")

    },
    pagechange() {
      this.$Progress.start()
      this.$store.dispatch("allPurchaseReport", [this.pagination.current_page, moment(this.date.start).format('YYYY-MM-DD'), moment(this.date.end).format('YYYY-MM-DD')]);
      this.$Progress.finish()
    },
    dateChange() {
      this.pagechange();
    },
    print() {
      this.$htmlToPaper('printMe');
    },
    purchaseReportExport() {
      location.href = '/manager/report/purchase/export?start_date=' + moment(this.date.start).format('YYYY-MM-DD') + '&end_date=' + moment(this.date.end).format('YYYY-MM-DD');
    },
    addPurchase() {
      this.state.isSending = true;
      this.form.post('/manager/report/purchase/import', {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
        transformRequest: [function (data, headers) {
          return objectToFormData(data)
        }]
      })
        .then((response) => {
          this.state.isSending = false;
          Toast.fire({
            icon: 'success',
            title: 'Detail Added successfully'
          })
        })
        .catch(() => {
          this.state.isSending = false;
        })
    },
    changePhoto(event) {
      let file = event.target.files[0];
      this.form.file = file;
    },

  }
}
</script>

<style scoped>
</style>