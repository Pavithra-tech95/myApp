<!DOCTYPE html>
<html lang="en">
<head>
  <title>View Order</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/vue@2.6.0"></script>
<script src="https://cdn.jsdelivr.net/npm/vee-validate@2.0.0/dist/vee-validate.js"></script>
<script src="https://unpkg.com/vee-validate@2.0.0"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
</head>
<body>
<?php $url =  'http://'.$_SERVER['HTTP_HOST'] . substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], "/"));
?>
 <input type="hidden" id="url" value="<?php echo $url?>">
<div class="container" id="app">
  <h2>View Order Details</h2>
    <table class="table table-striped">
    <thead>
      <tr>
        <th>Customer Name</th>
        <th> No. of Items ordered</th>
        <th>Total Amount</th>
        <th> Status</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="data in viewlist">
        <td>@{{data.cust_name}}</td>
        <td>@{{data.no_items}}</td>
        <td>@{{data.amount}}</td>
        <td>
        <button v-show="data.status == 1"   class="btn btn-primary" @click="changeStatus(data.id,2)">Recieved</button>
        <button v-show="data.status == 2"   class="btn btn-warning"  @click="changeStatus(data.id,3)">Preparing</button>
        <button v-show="data.status == 3"   class="btn btn-success"  >Ready to serve</button>
        </td>
      </tr>
    </tbody>
  </table>
</div>
<script>
var app = new Vue({
	el:'#app',
  data:{viewlist:'',appurl:'' },
  methods:{
    changeStatus(id,status){
      var vm = this;
      axios.get(this.appurl+'/changestatus', {
        params: {
          status: status,
          id: id,
           }
      })
      .then(function (response) {
         vm.loadtable();
      });
    },
    loadtable(){
      var self = this;
      //alert(self.appurl)
       axios.get(this.appurl+'/vieworder', {
        params: {
          type: 'order',
          }
      })
      .then(response => {
            console.log(response);
            self.viewlist = response.data;
        })
        .catch(function (error) {
            console.log(error);
        })
    },
    
   },
  mounted(){ //works like onload() 
    	
      this.appurl = $("#url").val();
      this.loadtable();
     //alert(this.appurl)

  }
    
});
</script>
</body>
</html>



