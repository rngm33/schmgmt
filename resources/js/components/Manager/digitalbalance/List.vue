<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark xyz">Digital Balance List</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/#">Home</router-link></li>
              <li class="breadcrumb-item active">Digital Balance</li>
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
                  <div class="col-md-2">
                    <router-link :to="'/digitalbalance/create'" class="btn btn-primary btn-block" style="color:#fff"> Add <i class="fas fa-user-plus fa-fw"></i></router-link>
                  </div>
                  <div class="col-md-10">
  
                  </div>
                </div>
              </div><!-- /.card-header -->

              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover table-sm m-0">
                    <thead class="table-primary text-center">                  
                      <tr>
                        <th width="10">SN</th>
                        <th>Type</th>
                        <th>Wallet Name</th>
                        <th>Wallet Id</th>
                        <th>Amount</th>
                        <th>Created At</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      <tr v-for="(data,index) in getAllDigitalBalance" :key="data.id" :class="colorchange(data.is_active)">
                        <td>{{index+1}}</td>
                        <!-- <td >{{data.get_client_info.name}}</td> -->
                        <td v-if="data.type == 'Default'">{{data.type}}</td>
                        <td v-if="data.type == 'Random'">{{data.type}}</td>
                        <!-- <td>
                          <span class="text-success" v-if="data.payment_type == '1'"> Digital</span>
                        </td> -->
                        <td>{{data.wallet_name}}</td>
                        <td>{{data.wallet_id}}</td>
                        <td>{{data.amount}}</td>
                        <td>
                          {{data.date_np}} 
                          <span class="badge badge-warning text-danger">{{data.created_at  | formatDate}}</span>
                        </td>                        
                        <td>
                          <!-- <a href="" class="btn btn-xs btn-outline-success"> <i class="nav-icon fas fa-landmark" title="Transfer to Bank"></i></a>
                          <a href="" class="btn btn-xs btn-outline-secondary"> <i class="nav-icon fas fa-rupee-sign" title="Transfer to Cash"></i></a> -->
                          <router-link :to="`/digitalbalance/${data.id}/banktransfer`" class="btn btn-xs btn-outline-success"><i class="nav-icon fas fa-landmark" title="Transfer to Bank"></i></router-link> 
                          <router-link :to="`/digitalbalance/${data.id}/cashtransfer`" class="btn btn-xs btn-outline-secondary"><i class="nav-icon fas fa-rupee-sign" title="Transfer to Cash"></i></router-link> 
                          <router-link :to="`/digitalbalance/${data.id}/edit`" class="btn btn-xs btn-outline-info"><i class="fas fa-pencil-alt" title="Click to edit"></i></router-link> 
                          <a href="" @click.prevent="deleteDigitalBalance(data.id)" class="btn btn-xs btn-outline-danger"><i class="fas fa-trash-alt" title="Click to delete"></i></a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="fetchPosts"></pagination>
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
<script type="text/javascript">
  import pagination from '../../../components/PaginationComponent.vue';
  export default{
    name: "List",
    components: {
      pagination,
    },
    data(){
      return{
          pagination: {
            'current_page': 1
          },
          search: ''
        }
    },
    mounted(){
    this.fetchPosts();
    },
    computed:{
      getAllDigitalBalance(){
        var avar = this.$store.getters.getDigitalBalance;
        if(avar.length==2)
          this.pagination = avar[1];
        return avar[0];
      },
     
    },
    methods:{
      fetchPosts(){
        this.$Progress.start()
        this.$store.dispatch("allDigitalBalance", [this.pagination.current_page]);
        this.$Progress.finish()
      },
      DigitalBalanceStatus(clkid, show){
          axios.get('/manager/digitalbalance/status/'+clkid+'/'+show)
          .then(()=>{
              this.$store.dispatch("allDigitalBalance", [0,0]);
              Toast.fire({
                  icon: 'success',
                  title: 'Status changed successfully'
              })
          })
          .catch(()=>{
        })
      },
      colorchange(id){
        return {
          'table-danger':!id,
          'table-default': id
        }
      },
      deleteDigitalBalance(id){
        var that = this;
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'No, cancel!',
          buttonsStyling: true
        }).then(function (isConfirm) {
          if(isConfirm.value === true) {
            axios.delete('/manager/digitalbalance/'+id)
            .then((response)=>{
              Toast.fire({
                icon: 'success',
                title: 'Data Deleted successfully'
              })
              that.$store.dispatch("allDigitalBalance", [0,0]);
            })
            .catch((response)=>{
              Toast.fire({
                icon: 'error',
                title: 'Something went wrong'
              })
            })
          }
          else{
            Toast.fire({
              icon: 'error',
              title: 'Setting not Deleted'
            })
          }
        })
      },
      searchSetting(){
        this.fetchPosts();
      }

    }
}
</script>