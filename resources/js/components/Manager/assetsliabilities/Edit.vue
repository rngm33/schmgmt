<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark">Edit: <span class="text-primary">{{form.topic}}</span></h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Assets-Liabilities</li>
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
                    <router-link to="/assetsliabilitieslist">
                      <i class="fas fa-arrow-left" title="Click to go back"></i>
                    </router-link>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form role="form" enctype="multipart/form-data" @submit.prevent="updateAssetsLiabilities()">
                    <div class="card-body">
                      <div class="row">

                        <div class="form-group col-md">
                          <label for="type">Type</label>
                          <select class="form-control" id="type" v-model="form.type"> 
                            <option disabled value="">Select one</option>
                            <option value="Assets">Assets</option>
                            <option value="Liabilities">Liabilities</option>
                          </select>
                        </div>

                        <!-- for liabilities selection-->
                        <div class="form-group col-md-12" v-if="this.form.type == 'Assets'">
                           <input type="radio" id="current" value="1" v-model="form.assets_type" >
                          <label for="current">Current</label>

                          <input type="radio" id="fixed" value="2" v-model="form.assets_type">
                          <label for="fixed">Fixed</label>
                                                    
                          <input type="radio" id="long-term" value="3" v-model="form.assets_type">
                          <label for="long-term">Long-Term Investment</label>

                          <input type="radio" id="intangible" value="4" v-model="form.assets_type">
                          <label for="intangible">Intangible</label>
                        </div>

                        <!-- for liabilities selection-->
                        <div class="form-group col-md-12" v-if="this.form.type == 'Liabilities'">
                           <input type="radio" id="shareholders" value="5" v-model="form.assets_type" >
                          <label for="shareholders">Shareholder's Equity</label>

                          <input type="radio" id="long-term-liabilities" value="6" v-model="form.assets_type">
                          <label for="long-term-liabilities">Long-Term</label>

                          <input type="radio" id="current-liabilities" value="7" v-model="form.assets_type">
                          <label for="current-liabilities">Current</label>
                        </div>

                        <div class="form-group col-md-12">
                          <label for="topic">Topic<code>*</code></label>
                          <input type="text" class="form-control" id="topic" placeholder="Add topic" v-model="form.topic" name="topic" :class="{ 'is-invalid': form.errors.has('topic') }" autocomplete="off">
                          <has-error :form="form" field="topic"></has-error>
                        </div>
                        <div class="form-group col-md-12">
                          <label for="description">Description<code>*</code></label>
                          <input type="text" class="form-control" id="description" placeholder="Add description" v-model="form.description" name="description" :class="{ 'is-invalid': form.errors.has('description') }" autocomplete="off">
                          <has-error :form="form" field="description"></has-error>
                        </div>
                        <div class="form-group col-md-12">
                          <label for="amount">Amount<code>*</code></label>
                          <input type="text" class="form-control" id="amount" placeholder="Add amount" v-model="form.amount" name="amount" :class="{ 'is-invalid': form.errors.has('amount') }" autocomplete="off" @keypress="isNumber($event)">
                          <has-error :form="form" field="amount"></has-error>
                        </div>
                        <div class="form-group col-md-12">
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
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Update Assets/Liabilities"}}</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-4">
                <div class="box box-default position-relative">
                  <div class="box-body">
                    <div class="callout callout-success">
                      <h5>Title : {{form.topic}}</h5>
                      <h5>Amount : {{form.amount}}</h5>
                      <h5>Date : {{form.date}}</h5>
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
          type:'',
          topic:'',
          description:'',
          assets_type:'',
          amount:'',
          date:moment(new Date()).format('YYYY-MM-DD'),
          keywords: '',
          }),
          state: {
            isSending: false,
            isDisplay: true
          }
        }
    },
    mounted(){
      this.$Progress.start()
      axios.get(`/manager/assetsliabilities/${this.$route.params.assetsliabilitiesid}/edit`)
      .then((response)=>{
        this.form.fill(response.data.assetsliabilities)
      })


      this.$Progress.finish()
    },
    computed:{

    },
    methods:{
      updateAssetsLiabilities(){
        this.state.isSending = true;
        this.form.date = moment(this.form.date).format('YYYY-MM-DD');
        this.form.put(`/manager/assetsliabilities/${this.$route.params.assetsliabilitiesid}`)
        .then((response)=>{
          this.$router.push('/assetsliabilitieslist')
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