<?php
session_start();
include('includes/header.php');
include('authentication.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('config/dbcon.php');
?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add Agency</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Agency</li>
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
                <h3 class="card-title">Settings
                </h3>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                    <form action="code-add-agency.php" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
            <div class="form-group">
                <label for="">Agency Name</label>
                    <input type="text" name="name" value="" class="form-control" placeholder="Agency Name">
              </div>
              <div class="form-group">
                <label for="">Agency BIO</label>
                    <input type="text" name="bio" value="" class="form-control" placeholder="Agency BIO">
              </div>
              <div class="form-group">
    <label for="">Founder ID ( IN APP )</label>
    <input type="text" name="owner_displayid" value="" class="form-control" placeholder="Founder ID">
</div>
<div class="form-group">
    <label for="">Founder Name</label>
    <input type="text" name="owner_name" value="" class="form-control" placeholder="Founder Name" readonly>
</div>
<div class="form-group">
    <label for="">Founder BIO</label>
    <textarea name="owner_description" class="form-control" placeholder="Founder Description" readonly></textarea>
</div>
<div class="form-group">
    <label for="">Founder UID</label>
    <input type="text" name="owner_uid" value="" class="form-control" placeholder="Founder UID" readonly>
</div>
                <div class="form-group">
                <label for="">Agency Image</label>
                <input type="file" name="image" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="">Agency Flag</label>
                <input type="file" name="flag" class="form-control" required>
              </div>






                
                 
                
            </div>
            <div class="modal-footer">
              <button type="submit" name="addagency" class="btn btn-info">Create Agency</button>
      </div>
    </form>

                    </div>
                </div>
              </div>
         </div>
    </div>
    </div>
        </div>
        </div>
        </section>

</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    // عند تغيير قيمة حقل الـ UID
    $('input[name="owner_displayid"]').on('change', function(){
        var short_digital_id = $(this).val(); // الـ UID المدخل
        if(short_digital_id !== ''){
            // إرسال طلب AJAX لجلب معلومات المستخدم
            $.ajax({
                url: 'get_user_info.php', // مسار السكربت المعالج للطلب
                method: 'POST',
                data: { short_digital_id: short_digital_id },
                success: function(response){
                    // عرض معلومات المستخدم في الحقول المخصصة
                    var userData = JSON.parse(response);
                    $('input[name="owner_name"]').val(userData.full_name);
                    $('input[name="owner_uid"]').val(userData.uid);
                    $('textarea[name="owner_description"]').val(userData.bio);
                },
                error: function(){
                    // إدراج رسالة خطأ في حالة عدم القدرة على جلب المعلومات
                    alert('Failed to retrieve user information.');
                }
            });
        }
    });
});
</script>



</body>
</html>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


<?php include('includes/script.php'); ?>
<?php include('includes/footer.php'); ?>