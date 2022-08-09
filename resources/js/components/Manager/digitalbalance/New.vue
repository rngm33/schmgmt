<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark">Add Digital Balance Detail</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Digital-Balance</li>
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
                    <router-link to="/digitalbalance">
                      <i class="fas fa-arrow-left" title="Click to go back"></i>
                    </router-link>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form role="form" enctype="multipart/form-data" @submit.prevent="addDigitalBalance()">
                    <div class="card-body">
                      <div class="row">
                        <div class="form-group col-md-12">
                          <label for="type">Type<code>*</code></label>
                          <select class="form-control" id="type" v-model="form.type"> 
                            <option disabled value="">Select</option>
                            <option value="Default">Default</option>
                            <!-- <option value="Random">Random</option> -->
                          </select>
                          <has-error :form="form" field="luckydraw_id"></has-error>
                        </div>

                        <div class="form-group col-md-12">
                          <div class="form-group col-md-12">
                              <label for="wallet_name">Wallet name<code>*</code></label>
                              <input type="text" class="form-control" id="wallet_name" placeholder="Add wallet_name" v-model="form.wallet_name" name="wallet_name" :class="{ 'is-invalid': form.errors.has('wallet_name') }" autocomplete="off">
                              <has-error :form="form" field="wallet_name"></has-error>
                          </div>
                          <div class="form-group col-md-12">
                              <label for="wallet_id">Wallet Id:<code>*</code></label>
                              <input type="text" class="form-control" id="wallet_id" placeholder="Add wallet_id" v-model="form.wallet_id" name="wallet_id" :class="{ 'is-invalid': form.errors.has('wallet_id') }" autocomplete="off">
                              <has-error :form="form" field="wallet_id"></has-error>
                          </div>
                          <div class="form-group col-md-12">
                              <label for="amount">Amount<code>*</code></label>
                              <input type="text" class="form-control" id="amount" placeholder="Add amount" v-model="form.amount" name="amount" :class="{ 'is-invalid': form.errors.has('amount') }" autocomplete="off" @keypress="isNumber($event)">
                              <has-error :form="form" field="amount"></has-error>
                          </div>
                          <div class="form-group col-md-6">
                              <label>Date</label>
                              <date-picker v-model="form.date" format="YYYY-MM-dd" name="date" >
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


                        <!-- <div v-if="form.type=='Default'" class="form-group col-md-12">
                          <div class="form-group col-md-12">
                              <label for="wallet_name">Wallet name<code>*</code></label>
                              <input type="text" class="form-control" id="wallet_name" placeholder="Add wallet_name" v-model="form.wallet_name" name="wallet_name" :class="{ 'is-invalid': form.errors.has('wallet_name') }" autocomplete="off">
                              <has-error :form="form" field="wallet_name"></has-error>
                          </div>
                          <div class="form-group col-md-12">
                              <label for="wallet_id">Wallet Id:<code>*</code></label>
                              <input type="text" class="form-control" id="wallet_id" placeholder="Add wallet_id" v-model="form.wallet_id" name="wallet_id" :class="{ 'is-invalid': form.errors.has('wallet_id') }" autocomplete="off">
                              <has-error :form="form" field="wallet_id"></has-error>
                          </div>
                          <div class="form-group col-md-6">
                              <label>Date</label>
                              <date-picker v-model="form.date" format="YYYY-MM-dd" name="date" >
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
                        </div> -->

                        <!-- <div v-if="form.type=='Random'" class="form-group col-md-12">
                          <div class="form-group col-md-12">
                              <label for="wallet_name">Wallet name<code>*</code></label>
                              <input type="text" class="form-control" id="wallet_name" placeholder="Add wallet_name" v-model="form.wallet_name" name="wallet_name" :class="{ 'is-invalid': form.errors.has('wallet_name') }" autocomplete="off">
                              <has-error :form="form" field="wallet_name"></has-error>
                          </div>
                          <div class="form-group col-md-12">
                              <label for="wallet_id">Wallet Id:<code>*</code></label>
                              <input type="text" class="form-control" id="wallet_id" placeholder="Add wallet_id" v-model="form.wallet_id" name="wallet_id" :class="{ 'is-invalid': form.errors.has('wallet_id') }" autocomplete="off">
                              <has-error :form="form" field="wallet_id"></has-error>
                          </div>
                          <div class="form-group col-md-12">
                              <label for="amount">Amount<code>*</code></label>
                              <input type="text" class="form-control" id="amount" placeholder="Add amount" v-model="form.amount" name="amount" :class="{ 'is-invalid': form.errors.has('amount') }" autocomplete="off" @keypress="isNumber($event)">
                              <has-error :form="form" field="amount"></has-error>
                          </div>
                          <div class="form-group col-md-6">
                              <label>Date</label>
                              <date-picker v-model="form.date" format="YYYY-MM-dd" name="date" >
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
                        </div> -->
                      </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Add Detail"}}</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-4">
                <div class="box box-default position-relative">
                  <div class="box-body">
                    <div class="callout callout-success">
                      <h5>Wallet Name : {{form.wallet_name}}</h5>
                      <h5>Wallet Id : {{form.wallet_id}}</h5>
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
    name: "New",
    components: {
      DatePicker
    },
    data(){
      return {
        form: new Form({
          type: '',
          wallet_name:'',
          wallet_id:'',
          amount:'',
          date:moment(new Date()).format('YYYY-MM-DD'),
        }),
        state: {
          isSending: false
        }
      }
    },
    mounted(){
      // this.$Progress.start()
      // this.$store.dispatch("allSelectLuckyDraw")
      // this.$Progress.finish()
    },
    computed:{
      // allSelectLuckyDraws(){
      //   var a = this.$store.getters.getSelectLuckyDraw[0]
      //   return a;
      // },
      // getAllKista(){
      //   var b = this.$store.getters.getSelectKista
      //   return b[0];
      // },
    },
    methods:{
     addDigitalBalance(){
      this.state.isSending = true;
      this.form.date = moment(this.form.date).format('YYYY-MM-DD');
      this.form.post('/manager/digitalbalance')
      .then((response)=>{
        this.$router.push('/digitalbalance')
        Toast.fire({
          icon: 'success',
          title: 'Detail Added successfully'
        })
      })
      .catch(()=>{
        this.state.isSending = false;
      })
      // this.resetForm();
    },
    resetForm() {
      this.form.reset();
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
    // kistaChange(){
    //   this.$store.dispatch("allSelectKista", [this.form.luckydraw_id]);
    // },
    // luckydrawChange(){
    //   this.kistaChange();
    // },
  }
}
</script>
<style scoped>
</style>
