<?php
$isIndex = true;
require_once('../template/header.php'); 

?>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>
                    <?php
                    $sql = "SELECT COUNT(*) AS AMOUNT FROM tb_loves WHERE MONTH(love_on) = MONTH(CURDATE());";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $amountLoves = $stmt->fetch(PDO::FETCH_OBJ)->AMOUNT;

                    $sql = "SELECT COUNT(*) AS AMOUNT FROM tb_comment WHERE MONTH(comment_at) = MONTH(CURDATE());";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $amountComments = $stmt->fetch(PDO::FETCH_OBJ)->AMOUNT;

                    $amountLovesAndCm = $amountLoves + $amountComments;

                    echo $amountLovesAndCm;
                    ?>
                  </h3>
                  <p>Loves and Comments In <?php echo getdate()['month']; ?></p>
                </div>
                <div class="icon">
                  <i class="fab fa-react"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <!-- <h3>53<sup style="font-size: 20px">%</sup></h3> -->

                  <!-- <p>Bounce Rate</p> -->
                  <h3>
                    <?php
                    $sql = "SELECT COUNT(*) AS AMOUNT FROM tb_tweets WHERE MONTH(tweet_postedOn) = MONTH(CURDATE());";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $amountNewTweet = $stmt->fetch(PDO::FETCH_OBJ)->AMOUNT;
                    echo $amountNewTweet;
                    ?>
                  </h3>
                  <p>Tweets In <?php echo getdate()['month']; ?></p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>
                    <?php
                    $sql = "SELECT COUNT(*) AS AMOUNT FROM tb_users WHERE MONTH(user_signUpDate) = MONTH(CURDATE());";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $amountNewSign = $stmt->fetch(PDO::FETCH_OBJ)->AMOUNT;
                    echo $amountNewSign;
                    ?>
                  </h3>
                  <p>User Registrations In <?php echo getdate()['month']; ?></p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3>
                    <?php
                    $sql = "SELECT COUNT(*) AS AMOUNT FROM tb_uploadedimages WHERE MONTH(uploadedImage_on) = MONTH(CURDATE());";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $amountUpLoadInMonth = $stmt->fetch(PDO::FETCH_OBJ)->AMOUNT;
                    echo $amountUpLoadInMonth;
                    ?>
                  </h3>
                  <p>Uploads In <?php echo getdate()['month']; ?></p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
          </div>
          <!-- /.row -->
          <!-- Main content -->
          <section class="content">
            <div class="container-fluid">
              <h3 class="mt-4 mb-4">Social Widgets</h3>
              <h4 class="mt-4 mb-4">Top users of <?php echo getdate()['month'] ?></h4>
              <div class="row">
                <?php
                $sql = "SELECT * FROM UOTM";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($data as $row) {
                  // LẤY SỐ LƯỢNG BÀI ĐĂNG CỦA NGƯỜI DÙNG TRONG THÁNG
                  $sql = "SELECT COUNT(*) AS AMOUNT FROM tb_tweets WHERE MONTH(tweet_postedOn) = MONTH(CURDATE()) AND tweet_by = {$row['user_id']}";
                  $stmt = $conn->prepare($sql);
                  $stmt->execute();
                  $amountOfTweets = $stmt->fetch(PDO::FETCH_OBJ)->AMOUNT;

                  // LẤY SỐ LƯỢNG NGƯỜI THEO DÕI CỦA NGƯỜI DÙNG TRONG THÁNG
                  $sql = "SELECT COUNT(*) AS AMOUNT FROM tb_follows WHERE MONTH(follow_at) = MONTH(CURDATE()) AND follow_following = {$row['user_id']}";
                  $stmt = $conn->prepare($sql);
                  $stmt->execute();
                  $amountOfFollowers = $stmt->fetch(PDO::FETCH_OBJ)->AMOUNT;

                ?>
                  <!-- /.col -->
                  <div class="col-md-4">
                    <!-- Widget: user widget style 1 -->
                    <div class="card card-widget widget-user">
                      <!-- Add the bg color to the header using any of the bg-* classes -->
                      <div class="widget-user-header bg-secondary">
                        <h3 class="widget-user-username"><?php echo $row['user_userName']; ?></h3>
                        <h5 class="widget-user-desc"><?php echo $row['user_email']; ?></h5>
                      </div>
                      <div class="widget-user-image">
                        <img class="img-circle elevation-2" src="image/avatar.jpg" alt="User Avatar">
                      </div>
                      <div class="card-footer">
                        <div class="row">
                          <div class="col-sm-4 border-right">
                            <div class="description-block">
                              <h5 class="description-header"><?php echo $row['AMOUNT_ALL']; ?></h5>
                              <span class="description-text">TOTAL</span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <!-- /.col -->
                          <div class="col-sm-4 border-right">
                            <div class="description-block">
                              <h5 class="description-header"><?php echo $amountOfTweets; ?></h5>
                              <span class="description-text">TWEETS</span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <!-- /.col -->
                          <div class="col-sm-4">
                            <div class="description-block">
                              <h5 class="description-header"><?php echo $amountOfFollowers; ?></h5>
                              <span class="description-text">FOLLOWERS</span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <!-- /.col -->
                        </div>
                        <!-- /.row -->
                      </div>
                    </div>
                    <!-- /.widget-user -->
                  </div>
                  <!-- /.col -->
                <?php
                }

                ?>
              </div>
            </div><!-- /.container-fluid -->
            <h4 class="mt-4 mb-4">Top tweets of <?php echo getdate()['month'] ?></h4>
            <div class="container-fluid">
              <div class="row">
                <?php 
                  $sql = "SELECT comments_in_month.*,tb_users.user_userName,tb_users.user_id, tb_uploadedimages.uploadedImage_link, (TOTAL_COMMENTS + TOTAL_LOVES) AS TOTAL_ALL 
                          FROM comments_in_month, loves_in_month, tb_users, tb_uploadedimages
                          WHERE comments_in_month.tweet_id = loves_in_month.tweet_id
                          AND tb_users.user_id = comments_in_month.tweet_by
                          AND tb_uploadedimages.uploadedImage_forTweet = comments_in_month.tweet_id
                          LIMIT 5";
                  $stmt = $conn->prepare($sql);
                  $stmt->execute();
                  $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                  foreach($data as $row) {
                ?>
                <div class="col-md-6">
                  <!-- Box Comment -->
                  <div class="card card-widget">
                    <div class="card-header">
                      <div class="user-block">
                        <img class="img-circle" src="image/avatar.jpg" alt="User Image">
                        <span class="username"><a href="#"><?php echo $row['user_userName'] ?></a></span>
                        <span class="description"><?php echo $row['tweet_postedOn'] ?></span>
                      </div>
                      <!-- /.user-block -->
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" title="Mark as read">
                          <i class="far fa-circle"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                      <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      <?php 
                          if(isset($row['uploadedImage_link']) && $row['uploadedImage_link'] != NULL) {
                            echo "<img class='img-fluid pad' src='../../backend/uploads/{$row['user_id']}/tweet-{$row['tweet_id']}-{$row['uploadedImage_link']}' alt='Photo'>";
                          }?>

                      <p><?php echo $row['tweet_status'] ?></p>
                      <button type="button" class="btn btn-default btn-sm"><i class="fas fa-share"></i> <?php echo $row['TOTAL_ALL'] ?> Reacts</button>
                    </div>
                  </div>
                  <!-- /.card -->
                </div>
                <?php } ?>
              </div>
            </div>
          </section>
          <!-- /.content -->
          <!-- Main row -->
          <div class="row">
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-12 connectedSortable">

              <!-- Map card -->
              <div class="card bg-gradient-primary">
                <div class="card-header border-0">
                  <h3 class="card-title">
                    <i class="fas fa-map-marker-alt mr-1"></i>
                    Visitors
                  </h3>
                  <!-- card tools -->
                  <div class="card-tools">
                    <button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
                      <i class="far fa-calendar-alt"></i>
                    </button>
                    <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                  <!-- /.card-tools -->
                </div>
                <div class="card-body">
                  <div id="world-map" style="height: 250px; width: 100%;"></div>
                </div>
                <!-- /.card-body-->
                <div class="card-footer bg-transparent">
                  <div class="row">
                    <div class="col-4 text-center">
                      <div id="sparkline-1"></div>
                      <div class="text-white">Visitors</div>
                    </div>
                    <!-- ./col -->
                    <div class="col-4 text-center">
                      <div id="sparkline-2"></div>
                      <div class="text-white">Online</div>
                    </div>
                    <!-- ./col -->
                    <div class="col-4 text-center">
                      <div id="sparkline-3"></div>
                      <div class="text-white"></div>
                    </div>
                    <!-- ./col -->
                  </div>
                  <!-- /.row -->
                </div>
              </div>
              <!-- /.card -->

              <!-- Calendar -->
              <div class="card bg-gradient-success">
                <div class="card-header border-0">

                  <h3 class="card-title">
                    <i class="far fa-calendar-alt"></i>
                    Calendar
                  </h3>
                  <!-- tools card -->
                  <div class="card-tools">
                    <!-- button with a dropdown -->
                    <div class="btn-group">
                      <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
                        <i class="fas fa-bars"></i>
                      </button>
                      <div class="dropdown-menu" role="menu">
                        <a href="#" class="dropdown-item">Add new event</a>
                        <a href="#" class="dropdown-item">Clear events</a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">View calendar</a>
                      </div>
                    </div>
                    <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                  <!-- /. tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body pt-0">
                  <!--The calendar -->
                  <div id="calendar" style="width: 100%"></div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </section>
            <!-- right col -->
          </div>
          <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
<?php require_once '../template/footer.php'; ?>