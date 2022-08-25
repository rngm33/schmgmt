<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark">Assets-Liabilities Report</h5>
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
                      <span>Balance-Sheets</span><br>
                      <span>({{to_date}} / {{from_date}})</span>
                    </div>
                    <div class="table-responsive col-sm-6 overflow-hidden pr-0">
                      <table class="table table-bordered table-hover table-sm m-0">
                        <thead class="thead-dark">                  
                          <tr>
                            <th>Assets</th>
                            <th>Amount</th>
                          </tr>
                        </thead>
                        <tbody v-for="(data,index) in getAssetsReports" :key="data.id">
                          <tr v-if="data.get_assets_liabitities_type_many.length && data.type!='Current'">
                            <td colspan="2" class="bg-success-light">
                              {{data.type}}
                            </td>                       
                          </tr>
                          <tr v-if="data.type=='Current'">
                            <td colspan="2" class="bg-success-light">
                              {{data.type}}
                            </td>                       
                          </tr>

                          <tr v-if="data.type=='Current'"  v-for="(stocks,key) in data.get_assets_stock_type_many" :key="stocks.id">
                            <td>{{ stocks.sub_type }}</td>
                            <td v-if="stocks.sub_type=='Stock/Inventory'">1</td>
                            <td v-if="stocks.sub_type=='Bank/Cheque'">2</td>
                            <td v-if="stocks.sub_type=='Wallet'">3</td>
                            <td v-if="stocks.sub_type=='Cash'">4</td>
                          </tr>
                          
                          <tr v-for="(listing,index) in data.get_assets_liabitities_type_many" :key="listing.id">
                            <td>{{ listing.topic }}</td>
                            <td>{{ listing.amount }}</td>
                          </tr>
                          <tr v-if="data.get_assets_liabitities_type_many.length">
                            <th>Total {{ data.type }} {{ data.category }}</th>
                            <th>{{ dataSubAssets(data.get_assets_liabitities_type_many) }}</th>
                          </tr>
                        </tbody>
                        <tfoot>
                          <tr>
                            <th>Assets Total</th>
                            <th>{{ totalAsset }}</th>
                          </tr>
                        </tfoot>
                        
                      </table>
                    </div>
                    <div class="table-responsive col-sm-6 overflow-hidden pl-0">
                      <table class="table table-bordered table-hover table-sm m-0">
                        <thead class="thead-dark">                  
                          <tr>
                            <th>Liabilities</th>
                            <th>Amount</th>
                          </tr>
                        </thead>
                        <tbody v-for="(data1,index) in getLiabilitiesReports" :key="data1.id">
                          <tr v-if="data1.get_assets_liabitities_type_many.length">
                            <td colspan="2" class="bg-warning-light">
                              {{data1.type}}
                            </td>                       
                          </tr>

                          <tr v-if="data1.type=='Current'">
                            <td></td>
                          </tr>

                          
                          <tr v-for="(listing1,index) in data1.get_assets_liabitities_type_many" :key="listing1.id">
                            <td>{{ listing1.topic }}</td>
                            <td>{{ listing1.amount }}</td>
                          </tr>
                          <tr v-if="data1.get_assets_liabitities_type_many.length">
                            <th>Total {{data1.type}} {{ data1.category }}</th>
                            <th>{{ dataSubLiabilities(data1.get_assets_liabitities_type_many) }}</th>
                          </tr>
                        </tbody>
                        <tfoot>
                          <tr>
                            <th>Liabilities Total</th>
                            <th>{{ totalLiabilities }}</th>
                          </tr>
                        </tfoot>
                        
                      </table>
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
          date:{
            start: moment().subtract(1,'months')._d, // Jan 16th, 2018
            end: new Date()    // Jan 19th, 2018
          },
          
          assetsList:'',
          assetsListing:'',
          bank_balance:'',
          liabilitiesListing:'',
          total_assets:'',
          total_liabilities:'',
          totalAsset:0,
          totalLiabilities:0,
          to_date:'',
          from_date:'',
        }
    },
    mounted(){
      this.$Progress.start();
      this.pagechange();
      axios.get(`/currentuser`)
        .then((response)=>{
          // this.auth_name = response.data.currentuser.name;
          // this.auth_address = response.data.currentuser.address;
      });
      this.$Progress.finish();
    },
    computed:{
      getAssetsReports: function(){
        var avar = this.$store.getters.getAssetsLiabilitiesReport;
        this.total_assets = avar[0];
        if(this.total_assets) {
          this.dataSubAssets(this.total_assets);
          this.dataAssets(this.total_assets);
         
        }
        return avar[0];
      },
      getLiabilitiesReports: function(){
        var avar = this.$store.getters.getAssetsLiabilitiesReport;
        this.total_liabilities = avar[1];
        if(this.total_liabilities) {
          this.dataLiabilities(this.total_liabilities);
        }
        return avar[1];
      },

    },
    methods:{
      pagechange(){
        this.$Progress.start()
        this.$store.dispatch("allAssetsLiablitiesReport", [this.pagination.current_page,moment(this.date.start).format('YYYY-MM-DD'),moment(this.date.end).format('YYYY-MM-DD')]);
        this.selecttoDate(moment(this.date.start).format('YYYY-MM-DD'));
        this.selectfromDate(moment(this.date.end).format('YYYY-MM-DD'));
        this.$Progress.finish()
      },
   
      dateChange(){
        this.pagechange();
      },
      print () {
        this.$htmlToPaper('printMe');
      },
      dataAssets: function(assetsList) {
        for(this.i = 0; this.i < assetsList.length; this.i++) {
          this.assetsListing = assetsList[this.i];
          for(var j = 0; j < this.assetsListing.get_assets_liabitities_type_many.length; j++) {
            this.totalAsset += parseFloat(this.assetsListing.get_assets_liabitities_type_many[j].amount);
          }
        }
        return this.totalAsset;
      },
      dataSubAssets: function(assetsSubList) {
        console.log(assetsSubList[0]);
        return assetsSubList.reduce((acc, val) => {
           return acc + parseInt(val.amount);
        }, 0); 
        
      },
      dataLiabilities: function(liabilitiesList) {
        for(this.k = 0; this.k < liabilitiesList.length; this.k++) {
          this.liabilitiesListing = liabilitiesList[this.k];
          for(var m = 0; m < this.liabilitiesListing.get_assets_liabitities_type_many.length; m++) {
            this.totalLiabilities += parseFloat(this.liabilitiesListing.get_assets_liabitities_type_many[m].amount);
          }
        }
        return this.totalLiabilities;
      },
      dataSubLiabilities: function(liabilitiesSubList) {
        console.log(liabilitiesSubList[0]);
        return liabilitiesSubList.reduce((acc, val) => {
           return acc + parseInt(val.amount);
        }, 0); 
        
      },
      selecttoDate: function(toDate) {
        return this.to_date = toDate;
      },
      selectfromDate: function(fromDate) {
        return this.from_date = fromDate;
      }
    },
    watch: {
    }
  }
</script>

<style scoped>
</style>