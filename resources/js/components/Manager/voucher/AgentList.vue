<template>
	<div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark"> <span class="text-primary">{{form.name}}</span></h5>
            <!-- <h5 class="m-0 text-dark">Kista: <span><small>{{form.name}}</small></span></h5> -->
            <!-- <h5 class="m-0 text-dark">Edit Detail</h5> -->
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">voucher</li>
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
            <div class="row">
              <div class="col-8">
                <div class="card card-primary">
                  <div class="card-header">
                    <router-link to="/voucher">
                      <i class="fas fa-arrow-left" title="Click to go back"></i>
                    </router-link>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form role="form" enctype="multipart/form-data" @submit.prevent="updateLuckyDraw()">
                    <div class="card-body">
                      <div class="row">
                        <div class="form-group col-md-12">
                          <label for="category_id">Agent Name : {{form.name}}</label>
                          
                        </div>
                        <div class="form-group col-md-12">
                          <label for="name">Amount To Be paid : RS. {{ amt2bepaid }}</label>
                        
                        </div>
                        <div class="form-group col-md-12">
                          <label for="amount">Payed Amount :  RS. {{ amtpaid }}</label>
                          
                        </div>
                          <div class="form-group col-md-12">
                          <label for="amount">Due Amount :  RS. {{ amt2bepaid - amtpaid }}</label>
                          
                        </div>
                        <div class="form-group col-md-6">
                          <label>Date</label>
                          <date-picker v-model="form.date" format="YYYY-MM-dd" name="date" :max-date='new Date()'>
                            <template v-slot="{ inputValue, inputEvents }">
                              <input
                              class="bg-white border px-2 py-1 rounded form-control"
                              :value="inputValue"
                              v-on="inputEvents"
                              />
                            </template>
                          </date-picker>
                          <has-error :form="form" field="date"></has-error>
                        </div>
                      </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Save"}}</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-4">
                <div class="box box-default position-relative">
                  <div class="box-body">
                    <div class="callout callout-success">
                      <h5>Name : {{form.name}}</h5>
                      <h5>Amount : {{form.amount}}</h5>
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
  import DatePicker from 'v-calendar/lib/components/date-picker.umd';
  import moment from 'moment'
  export default {
    name: "Edit",
    components: {
      DatePicker
    },
    data(){
        return {
          form: new Form({
            name: '',
            amount: '',
            date:moment(new Date()).format('YYYY-MM-DD'),
            // date: '',
            luckydraw_id: '',
           
          }),
           amt2bepaid:'',
           amtpaid:'',
          state: {
            isSending: false,
            isDisplay: true
          }
        }
    },
    mounted(){
      console.log(this.$route.params.kid)
      // this.getData()
            this.$store.dispatch("agentDetailVoucher",[this.$route.params.agentid,
            this.$route.params.kid,this.$route.params.lid])
            axios.get("/manager/mdetailvoucheragent/"+"?agentid="+this.$route.params.agentid
            +"&kistaid="+this.$route.params.kid+"&luckydrawid="+this.$route.params.lid)
			.then((response)=>{
				console.log("rabin",response.data.amt2bepaid);
        this.amt2bepaid=response.data.amt2bepaid
        this.amtpaid=response.data.amtpaid

        this.form.name=response.data.agent.name
    		// this.form.fill(response.data.kistas)
			})

    },
    computed:{
     
    },
 
    methods:{
      getData(){
        // console.log(a);
        // return a;
    },
      updateLuckyDraw(){
        this.state.isSending = true;
        this.form.date = moment(this.form.date).format('YYYY-MM-DD');
        this.form.put(`/manager/kista/${this.$route.params.kistaid}`)
        .then((response)=>{
          this.$router.push('/kista')
          Toast.fire({
            icon: 'success',
            title: 'Data  Updated successfully'
          })
        })
        .catch(()=>{
          this.state.isSending = false
        })
      },
      isNumber: function(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if ((charCode > 31 && (charCode < 48 || charCode > 57) ) && charCode !== 46
          ) {
          evt.preventDefault();;
        } else {
          return true;
        }
      },
    }
  }
</script>

