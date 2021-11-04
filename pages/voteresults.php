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
$userid=$_COOKIE['userid'];


?>

<section class="section section--first section--bg section-mobile-view" data-bg="img/section/section.jpg" style="background: url(&quot;img/section/section.jpg&quot;) center center / cover no-repeat;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section__wrap">
                    <!-- section title -->
                    <h2 class="section__title">Results</h2>
                    <!-- end section title -->

                    <!-- breadcrumb -->
                    <ul class="breadcrumb">
                        <li class="breadcrumb__item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb__item breadcrumb__item--active">Results</li>
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
                <h3><i class="icon ion-ios-trophy"></i> VOTES</h3>

                <div class="dashbox__wrap">
                    <a class="dashbox__refresh" href=""><i class="icon ion-ios-refresh"></i></a>
                </div>
            </div>

            <div class="dashbox__table-wrap mCustomScrollbar _mCS_2" style="overflow: visible;">
                <div id="mCSB_2" class="mCustomScrollBox mCS-custom-bar2 mCSB_horizontal mCSB_outside" tabindex="0" style="max-height: none;"><div id="mCSB_2_container" class="mCSB_container" style="position: relative; top: 0px; left: 0px; width: 501px; min-width: 100%; overflow-x: inherit;" dir="ltr">
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
                                "SELECT bd.user_id AS from_user_id, bd.to_user_id, fu.username AS from_username, 
                                        fu.photo AS from_photo, tu.username AS to_username, tu.photo AS to_photo,
                                         bd.id AS request_id, vr.voteid AS vote_id, vr.post_id, bd.user_id, vr.amount
                                        FROM tbl_blind_date_request bd
                                        LEFT JOIN tbl_vote_record vr ON bd.id = vr.post_id
                                        LEFT JOIN tbl_users fu ON bd.user_id = fu.userid
                                        LEFT JOIN tbl_users tu ON bd.to_user_id = tu.userid
                                        WHERE bd.status='" . BLIND_DATE_STATUS_ACCEPTED . "'
                                        ORDER BY vr.amount DESC");
                            $request_total_votes = [];
                            $total_votes_in_system = 0;
                            $match_user_info = [];
                            while ($row = mysqli_fetch_array($sql)) {
                                if(isset($request_total_votes[$row['request_id']])) {
                                    if($row['amount'] != null) {
                                        $request_total_votes[$row['request_id']] += intval($row['amount']);
                                        $total_votes_in_system += intval($row['amount']);
                                    }

                                }else {
                                    if($row['amount'] != null) {
                                        $request_total_votes[$row['request_id']] = intval($row['amount']);
                                        $total_votes_in_system += intval($row['amount']);
                                    }else {
                                        $request_total_votes[$row['request_id']] = 0;
                                    }

                                }
                                if(!isset($match_user_info[$row['request_id']])) {
                                    $match_user_info[$row['request_id']] =
                                        [
                                            'from_username' => $row['from_username'],
                                            'from_photo' => $row['from_photo'],
                                            'to_username' => $row['to_username'],
                                            'to_photo' => $row['to_photo'],
                                        ];
                                }
                            }

                         uasort($request_total_votes, function ($item1, $item2) {
                                if ($item1 == $item2) return 0;
                                return $item1 < $item2 ? 1 : -1;
                            });
                          //  dump($request_total_votes);
                           foreach ($request_total_votes as $key => $value) {
                                $matched_users = $match_user_info[$key];
                                $percent_vote = number_format((float)(($value / $total_votes_in_system) * 100), 1, '.', '');
                              ?>
                               <tr style="border-bottom: 1px dotted #fff;">
                                   <td style="padding-bottom: 10px;">
                                       <div class="main__table-text">
                                           <a href="#" title="<?=$matched_users['from_username']?>" class="margin-right-10">
                                               <img src="uploads/profile/<?=$matched_users['from_photo']?>" alt="<?=$matched_users['from_username']?>" title="<?=$matched_users['from_username']?>"  width="150" />
                                           </a>
                                           <a href="#" title="<?=$matched_users['from_username']?>">
                                               <img src="uploads/profile/<?=$matched_users['to_photo']?>" alt="<?=$matched_users['to_username']?>" title="<?=$matched_users['to_username']?>"  width="150" />
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