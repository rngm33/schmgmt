<template>
<div>
    <div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h5 class="m-0 text-dark">Tpnpl Report</h5>
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
        <!-- main page load here-->
        <button @click="print" class="btn btn-primary rounded-0"><i class="fas fa-print">Print</i></button>
        <!-- <button @click.prevent="salesReportExport()" class="btn btn-success rounded-0"><i class="fas fa-print" title="Export To Excel"></i> Excel</button> -->
        <div class="card card-info card-outline">

          <div class="card-header">
            <div class="row">
              <div class="col-md">
                <select class="form-control" id="luckydraw_id" v-model="luckydraw_id" @change="luckydraw_change"> 
                  <option value="">Select one Scheme</option>
                  <option :value="luckydraw.id" v-for="luckydraw in getAllLuckydraw">{{luckydraw.name}}</option>
                </select>
              </div>
              <div class="form-group col-md">
                <select class="form-control" id="kista_id" name="kista_id" v-model="kista_id"  @change="kistaChange"> 
                  <option value="">Select one kista</option>
                  <option :value="kista.id" v-for="kista in getAllKista">{{kista.name}}</option>
                </select>
              </div>
              <div class="form-group col-md">
                <!-- <label for="lottery_status">Type </label> -->
                <select class="form-control" id="lottery_status" v-model="lottery_status" @change="lotterystatuschange"> 
                  <option disabled value="">Select one</option>
                  <option value="1">Unpaid</option>
                  <option value="2">Paid</option>
                  <option value="3">Leave</option>
                </select>
              </div>
              <div class="form-group col-md">
               
                <button class="btn btn-primary btn-block col" @click="searchdata">{{"Click to continue"}}
                </button>
              </div>
              
            </div>
          </div>
          <div class="card-body">
            <div id="printMe">
              <div class="row">
                <div class="col-md-12 text-center mb-2">
                   <h2><span>{{auth_name}}</span></h2>
                    <span>{{auth_address}}</span><br>
                  <span>TPNPL Report</span><br>
                  <span>{{luckydraw_name}}<span v-if="kista_id && clicked">,</span> {{kista_name}}</span>
                </div>
                <div class="table-responsive col-sm-10">
                  <table class="table table-bordered table-hover table-sm m-0">
                    <thead class="table-primary">                  
                      <tr>
                        <th>SN</th>
                        <th>Member</th>
                        <th>Amount</th>
                        <th>Remaining</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(tpnpl,index) in getAllTpnpreport" :key="tpnpl.id">
                        <td>{{index+1}}</td>
                        <td>{{tpnpl.get_client_info.name}} ({{tpnpl.get_client_info.address}}, {{tpnpl.get_client_info.phone}}) ({{tpnpl.get_client_info.serial_no}})</td>
                        <td>{{tpnpl.amount}}</td>
                        <td>{{tpnpl.remaining}}</td>
                      </tr>
                    </tbody>
                  </table>
                  <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="searchdata"></pagination>
                </div>
                <div class="table-responsive col-sm-2">
                  <table class="table table-bordered table-hover table-sm m-0">
                    <thead class="table-primary"> 
                      <tr>
                        <th>Total Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Rs.{{total}}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
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
          luckydraw_id:'',
          cost_price:'',
          total:'',
          kista_id:'',
          lottery_status:'',
          date:{
            start: moment().subtract(1,'months')._d, // Jan 16th, 2018
            end: new Date()    // Jan 19th, 2018
          },
          auth_name:'',
          auth_address:'',
          luckydraw_name:'',
          kista_name:'',
          clicked:'',
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
      getAllLuckydraw(){
          return this.$store.getters.getSelectLuckyDraw[0]
      },
      getAllKista(){
        var b = this.$store.getters.getSelectKista
        return b[0];
      },
      getAllTpnpreport(){
        var avar = this.$store.getters.getTpnplReport;
        this.total = avar[2];
        this.luckydraw_name = avar[3];
        this.kista_name = avar[4];
        if(avar.length==3)
          this.pagination = avar[1];
        return avar[0];
      },
    },
    methods:{
      fetchPosts() {
        this.pagechange();
        this.$store.dispatch("allSelectLuckyDraw")
        this.$store.dispatch("allSelectKista", [this.luckydraw_id]);
      },
      pagechange(){
        this.$Progress.start()
        // console.log(this.lottery_status);
        this.$Progress.finish()
      },
   
      kistaChange(){
        this.$store.dispatch("allSelectKista", [this.luckydraw_id]);
         this.pagechange();
      },
      lotterystatuschange(){
         this.pagechange();
      },
      luckydraw_change(){
        this.kistaChange();
        this.pagechange();
      },
      dateChange(){
        this.pagechange();
      },
      categoryChange(){
        this.pagechange();
        this.subCatchange();
      },
      subCatchange(){
        this.pagechange();
      },
      print () {
        this.$htmlToPaper('printMe');
      },
      salesReportExport(){
        location.href = '/home/report/purchase/export?name='+this.name+'&supplier_id='+this.supplier_id+'&category_id='+this.category_id+'&subcategory_id='+this.sub_category_id+'&start_date='+moment(this.date.start).format('YYYY-MM-DD')+'&end_date='+moment(this.date.end).format('YYYY-MM-DD');
      },
      searchdata()
      {
        this.$store.dispatch("allTpnplReport", [this.luckydraw_id,this.kista_id,this.lottery_status,this.pagination.current_page]);
        this.clicked = true;

      },
    }
  }
</script>

<style scoped>
</style>