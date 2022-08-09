<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                <div class="col-sm-6">
                    <h5 class="m-0 text-dark">Transfer To Cash</h5>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Transfer</li>
                    </ol>
                </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

 <div class="container-fluid">
             <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-12 connectedSortable">
                        <div class="row">
                            <div class="col-8">
                                    <!-- main page load here-->
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <router-link to="/digitalbalance">
                                            <i class="fas fa-arrow-left" title="Click to go back"></i>
                                            </router-link>
                                        </div>
                                         <form role="form" enctype="multipart/form-data">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="form-group col-md-3">
                                                            <label for="amount">Amount<code>*</code></label>
                                                            <input type="text" class="form-control" id="amount" placeholder="Add amount"/>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-3">
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
                                                    <!-- /.card-body -->
                                                    <div class="">
                                                        <button type="submit" class="btn btn-primary" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Transfer To Cash"}}</button>
                                                    </div>
                                                </div>
                                         </form>
                                    </div>
                            </div>
                        </div>
                    </section>
             </div>
        </div>
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


    </div>
</template>