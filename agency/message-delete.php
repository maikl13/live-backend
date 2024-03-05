<?php
if(isset($_SESSION['status']))
{
    ?>
    <div class="alert alert-danger" role="alert"> 
    <strong>Sorry .. </strong> <?php echo $_SESSION['status']; ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php
unset($_SESSION['status']);
}
?>