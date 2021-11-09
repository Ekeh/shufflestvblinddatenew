<?php
if(!isset($_COOKIE['userid'])){
    ?>
    <script type="text/javascript">
        alert("You Must Login to view this page");
        setTimeout(function(){
            window.location.href = 'signin.php';
        }, 1000);
    </script>
    <?php
    exit;
}
$user_id=$_COOKIE['userid'];
if(!isset($_GET['token']))
{
    ?>
    <script type="text/javascript">
        alert("Invalid parameters.");
        setTimeout(function(){
            window.location.href = 'index.php?p=taspp';
        }, 1000);
    </script>
    <?php
    exit;
}
$category_id = mysqli_escape_string($db, $_GET['token']);
$category_sql = mysqli_query($db,"SELECT * FROM `tbl_category` WHERE id = '$category_id' AND is_available='1'");
$category = mysqli_fetch_assoc($category_sql);
?>

<section class="section section--first section--bg section-mobile-view" data-bg="img/section/section.jpg" style="background: url(&quot;img/section/section.jpg&quot;) center center / cover no-repeat;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section__wrap">
                    <!-- section title -->
                    <h2 class="section__title"><?=$category['name']?> Results</h2>
                    <!-- end section title -->

                    <!-- breadcrumb -->
                    <ul class="breadcrumb">
                        <li class="breadcrumb__item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb__item breadcrumb__item--active"><?=$category['name']?> Results</li>
                    </ul>
                    <!-- end breadcrumb -->
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="dashbox">
            <div class="dashbox__title">
                <h3><i class="icon ion-ios-trophy"></i><?=$category['name']?>  - VOTES</h3>

                <div class="dashbox__wrap">
                    <a class="dashbox__refresh" href=""><i class="icon ion-ios-refresh"></i></a>
                </div>
            </div>

            <div class="dashbox__table-wrap mCustomScrollbar _mCS_2" style="overflow: visible;">
                <div id="mCSB_2" class="mCustomScrollBox mCS-custom-bar2 mCSB_horizontal mCSB_outside" tabindex="0" style="max-height: none;"><div id="mCSB_2_container" class="mCSB_container" style="position: relative; top: 0px; left: 0px; width: 501px; min-width: 100%; overflow-x: inherit;" dir="ltr">
                      <div class="table-response">
                          <table class="main__table main__table--dash">
                              <thead>
                              <tr>
                                  <th>MATCH</th>
                                  <th>TOTAL VOTES</th>
                              </tr>
                              </thead>
                              <tbody>
                              <?php

                              $sql = mysqli_query($db,
                                  "SELECT tu.userid AS user_id, CONCAT(tu.fname, ' ', tu.lname) AS username, tu.photo AS photo, bd.id AS vote_id, vr.id AS category_id, bd.amount
                                        FROM tbl_taspp_subscription sub
                                        LEFT JOIN tbl_category vr ON vr.id = sub.category_id
                                        LEFT JOIN tbl_taspp_vote_record bd ON bd.to_user_id = sub.user_id
                                        LEFT JOIN tbl_users tu ON sub.user_id = tu.userid
                                        WHERE vr.id = '$category_id' AND tu.photo != ''
                                        ORDER BY bd.amount DESC");
                              $request_total_votes = [];
                              $total_votes_in_system = 0;
                              $match_user_info = [];
                              while ($row = mysqli_fetch_array($sql)) {
                                  if(isset($request_total_votes[$row['user_id']])) {
                                      $request_total_votes[$row['user_id']] += intval($row['amount']);
                                      $total_votes_in_system += intval($row['amount']);
                                  }else {
                                      $request_total_votes[$row['user_id']] = intval($row['amount']);
                                      $total_votes_in_system += intval($row['amount']);
                                  }
                                  if(!isset($match_user_info[$row['user_id']])) {
                                      $match_user_info[$row['user_id']] =
                                          [
                                              'username' => $row['username'],
                                              'user_id' => $row['user_id'],
                                              'photo' => $row['photo'],
                                          ];
                                  }
                              }

                              uasort($request_total_votes, function ($item1, $item2) {
                                  if ($item1 == $item2) return 0;
                                  return $item1 < $item2 ? 1 : -1;
                              });
                              foreach ($request_total_votes as $key => $value) {
                                  $matched_users = $match_user_info[$key];
                                  if (!is_file("uploads/profile/{$matched_users['photo']}") || !file_exists("uploads/profile/{$matched_users['photo']}")) {
                                      continue;
                                  }
                                  $percent_vote= 0;
                                  if($total_votes_in_system > 0)
                                  $percent_vote = number_format((float)(($value / $total_votes_in_system) * 100), 1, '.', '');
                                  ?>
                                  <tr style="border-bottom: 1px dotted #fff;">
                                      <td style="padding-bottom: 10px;">
                                          <div class="main__table-text">
                                              <a href="index.php?p=tasppvote&token=<?=$matched_users['user_id']?>" title="<?=$matched_users['username']?>">
                                                  <img src="uploads/profile/<?=$matched_users['photo']?>" alt="<?=$matched_users['username']?>" title="<?=$matched_users['username']?>"  width="150" />
                                              </a>
                                          </div>
                                      </td>
                                      <td>
                                          <div class="main__table-text main__table-text--rate"><i class="icon ion-ios-trophy"></i> <?=$percent_vote?>%</div>
                                      </td>
                                  </tr>
                                  <?php
                              }
                              ?>

                              <tr>
                                  <td colspan="3"><br /><br /></td>
                              </tr>
                              </tbody>
                          </table>
                      </div>

                    </div>
                </div>
                <div id="mCSB_2_scrollbar_horizontal" class="mCSB_scrollTools mCSB_2_scrollbar mCS-custom-bar2 mCSB_scrollTools_horizontal" style="display: block;"><div class="mCSB_draggerContainer"><div id="mCSB_2_dragger_horizontal" class="mCSB_dragger" style="position: absolute; min-width: 30px; display: block; width: 499px; max-width: 490px; left: 0px;">
                            <div class="mCSB_dragger_bar"></div>
                            <div class="mCSB_draggerRail"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<br />
<br />
    </div>
</section>