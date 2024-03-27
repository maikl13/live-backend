<?php
session_start();
include('includes/header.php');
include('authentication.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('config/dbcon.php');
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">New Transaction</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">New Transaction</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                        </div>
                        </div>
                        </div>
    <div class="card">
              <div class="card-header">
                <h3 class="card-title">New Transaction
                </h3>
                <input type="text" id="live_search" autocomplete="off" placeholder="Search ID Account Here ..." class="form-control float-right">
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="agentcoinsresult" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                  <th>#</th>
        <th>Profile Image</th>
        <th>Account ID</th>
        <th>Account Name</th>
        <th>Account BIO</th>
        <th>Send Golds</th>
                  </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table> 
            </div>
         </div>

    </div>

    </div>
        </div>
        </div>

        </section>


     </div>

<?php include('includes/script.php'); ?>

<script type="text/javascript">

    $(document).ready(function(){
        $("#live_search").keyup(function(){
            var input = $(this).val();
           // alert(input);

           if(input != ""){
            $.ajax({
                url:"livesearch.php",
                method:"POST",
                data:{input:input},
                
                success:function(data){
                    $("#agentcoinsresult").html(data);
                }

            });
           }else{
                 $("#agentcoinsresult").css("display","none");
           }
        });
    });

</script>



<script>
        $(document).ready(function () {

            $('.sendGold').on('click', function () {

                $('#AddTransactionModal').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#update_id').val(data[0]);
                $('#fname').val(data[1]);
                $('#lname').val(data[2]);
                $('#course').val(data[3]);
                $('#contact').val(data[4]);
            });
        });
    </script>

<?php include('includes/footer.php'); ?>