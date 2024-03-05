  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>
    <?php
                    $query = "SELECT * FROM websetting";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                        }
                      }
                          ?>
                            
                         
            <?php echo $row['copyright'];?>

    </strong>
    
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b>
      
      <?php
                    $query = "SELECT * FROM websetting";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                        }
                      }
                          ?>
                            
                         
            <?php echo $row['version'];?>

      
    </div>
  </footer>

</div>


</body>
</html>
