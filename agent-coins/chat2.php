<?php
session_start();
include('includes/header.php');
include('authentication.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('config/dbcon.php');

if(isset($_SESSION['auth_agentcoins']))
{
  echo $_SESSION['auth_useragent']['agent_name']; 
}

$auth_agentcoins = $_SESSION['auth_agentcoins'];

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
            <!-- DIRECT CHAT -->
            <div class="card direct-chat direct-chat-primary">
              <div class="card-header">
                <h3 class="card-title">Online Chat</h3>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <!-- Conversations are loaded here -->
                <div id="chat-box"></div>
                <div class="direct-chat-messages">
                  <!-- Message. Default to the left -->
                  <div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                        <!-- /.contacts-list-info -->
                      </a>
                    </li>
                    <!-- End Contact Item -->
                  </ul>
                  <!-- /.contacts-list -->
                </div>
                <!-- /.direct-chat-pane -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <div class="input-group">
                    <input type="text" name="message" id="message" placeholder="Type Message ..." class="form-control">
                    <span class="input-group-append">
                      <button onclick="sendMessage()" type="button" class="btn btn-primary">Send</button>
                    </span>
                  </div>
                </form>
              </div>
              <!-- /.card-footer-->
            </div>
            <!--/.direct-chat -->

            </div>
            <!-- /.card -->
          </section>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function sendMessage() {
            var message = $("#message").val();
            
            $.post("send_message.php", { message: message }, function(data) {
                // عملية إرسال الرسالة
                $("#message").val(""); // إفراغ حقل الرسالة بعد الإرسال
            });
        }

        function getMessages() {
            $.get("get_messages.php", function(data) {
                $("#chat-box").html(data);
                var chatBox = document.getElementById("chat-box");
                chatBox.scrollTop = chatBox.scrollHeight; // تمرير إلى أسفل لرؤية آخر الرسائل
            });
        }

        // استرجاع الرسائل كل فترة زمنية
        setInterval(getMessages, 1000); // كل 2 ثانية، يمكنك تغيير هذا حسب الحاجة
    </script>

<?php include('includes/script.php'); ?>
