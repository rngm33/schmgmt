<template>
<div>
    <div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h5 class="m-0 text-dark">Purchase Report</h5>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><router-link to="/#">Home</router-link></li>
          <li class="breadcrumb-item active">Dashboard v1</li>
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
         <!-- main page load here -->
        <div class="row">
          <div>
            <button @click="print" class="btn btn-primary rounded-0"><i class="fas fa-print">Print</i></button>
            <button @click.prevent="purchaseReportExport()" class="btn btn-success rounded-0"><i class="fas fa-print" title="Export To Excel"></i> Excel</button>
          </div>
          <div class="ml-1">
            <form role="form" enctype="multipart/form-data" @submit.prevent="addPurchase()">
              <div class="form-group">
                <button type="submit" class="btn btn-primary rounded-0" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Import"}}</button>
                <input type="file" class=""  id="file" name="file" @change="changePhoto($event)" :class="{ 'is-invalid': form.errors.has('file') }">
                <has-error :form="form" field="file"></has-error>
              </div>
            </form>
          </div>
        </div>
        <div class="card card-info card-outline">
          <div class="card-header">
            <div class="row">
              <div class="form-group col-md-5">
                <date-picker mode='range' v-model="date" lang="en" type="date" format="YYYY-MM-dd" v-on:input="dateChange" is-range>
                  <template v-slot="{ inputValue, inputEvents }">
                    <div class="flex justify-center items-center">
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
                  </template>
                </date-picker>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div id="printMe" class="row">
              <div class="col-md-12 text-center mb-2">
                <span>{{auth_name}},{{auth_address}}</span><br>
                <span>Purchase Report</span><br>
                <span>{{to_date}} / {{from_date}}</span>
              </div>
              <div class="table-responsive col-sm">
                <table class="table table-bordered table-hover table-sm m-0">
                  <thead class="table-primary">                  
                    <tr>
                      <th width="10">SN</th>
                      <th class="text-left">Supplier Name</th>
                      <th>Item Name</th>
                      <th>Description</th>
                      <th>Purchase Date</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(data,index) in getAllPurchase" :key="data.id">
                      <td>{{index+1}}</td>
                      <td class="text-left">{{data.supplier_name}}</td>
                      <td>{{data.item_name}}</td>
                      <td>{{data.description}}</td>
                      <td>
                        <span class="badge badge-warning">{{data.date_np}}</span>
                      </td>
                      <td>{{data.amount}}</td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="5">Total:</td>
                      <td>{{total}}</td>
                    </tr>
                  </tfoot>
                </table>
                <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="fetchPosts"></pagination>
              </div>
            </div>

          </div>
        </div>
        <!-- /.card -->
      </section>
    <!-- /.Left col -->
    <!-- right col (We are only adding the ID to make the widgets sortable)-->
    </div>
<!-- /.row (main row) -->
</div><!-- /.container-fluid -->
</section>
</div>
</template>
<script>
  import pagination from '../../../../components/PaginationComponent.vue';
  import DatePicker from 'v-calendar/lib/components/date-picker.umd';
  import moment from 'moment'
  export default{
    name: "List",
    components: {
      pagination,
      DatePicker
    },
    data(){
      return{
        pagination: {
            'current_page': 1
          },
          form: new Form({
            title:'',
            file: null,
          }),
          luckydraw_id:'',
          cost_price:'',
          total:'',
          kista_id:'',
          lottery_status:'',
          date:{
            start: moment().subtract(1,'months')._d, // Jan 16th, 2018
            end: new Date()    // Jan 19th, 2018
          },
          state: {
            isSending: false
          },
          search:'',
          auth_name:'',
          auth_address:'',
          to_date:'',
          from_date:'',
        }
    },
    mounted(){
      this.$Progress.start()
      this.fetchPosts();
      axios.get(`/currentuser`)
        .then((response)=>{
          this.auth_name = response.data.currentuser.name;
          this.auth_address = response.data.currentuser.address;
      })
      this.$Progress.finish()
    },
    computed:{
      getAllPurchase(){
        var b = this.$store.getters.getPurchaseReport;
        this.total = b[2];
        this.to_date = b[3];
        this.from_date = b[4];
        if(b.length==3)
          this.pagination = b[1];
        return b[0];
      },

    },
    methods:{
      fetchPosts() {
        this.pagechange();
        // this.$store.dispatch("allPurchaseReport")

      },
      pagechange(){
        this.$Progress.start()
        this.$store.dispatch("allPurchaseReport", [this.pagination.current_page,moment(this.date.start).format('YYYY-MM-DD'),moment(this.date.end).format('YYYY-MM-DD')]);
        this.$Progress.finish()
      },
      dateChange(){
        this.pagechange();
      },
      print () {
        this.$htmlToPaper('printMe');
      },
      purchaseReportExport(){
        location.href = '/manager/report/purchase/export?start_date='+moment(this.date.start).format('YYYY-MM-DD')+'&end_date='+moment(this.date.end).format('YYYY-MM-DD');
      },
      addPurchase(){
        this.state.isSending = true;
        this.form.post('/manager/report/purchase/import',{
          headers: {
            'Content-Type': 'multipart/form-data',
          },
          transformRequest: [function (data,headers){
            return objectToFormData(data)
          }]
        })
        .then((response)=>{
          this.state.isSending = false;
          Toast.fire({
            icon: 'success',
            title: 'Detail Added successfully'
          })
        })
        .catch(()=>{
          this.state.isSending = false;
        })
      },
      changePhoto(event){
        let file = event.target.files[0];
        this.form.file = file;
      },
   
    }
  }
</script>

<style scoped>
</style>