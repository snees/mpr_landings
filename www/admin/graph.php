<?php
    include_once trim($_SERVER['DOCUMENT_ROOT'])."/include/inc.common.php";
    session_start();
    $time = $_POST['time'];
    $date = $_POST['date'];
    $type = $_POST['g_type'];
    $code = $_POST['code'];
    $key= $_POST['key'];
    $_SESSION['code']=$code;
    
    if(!$code)
    {
      if($type=="curve")
      {
        $sql="select a.*,ifnull(b.cnt,0)as cnt from
        (select @curDate := date_sub(@curDate, interval 1 day) as dates from mpr_event_db inner join (select @curDate := $time) A where @curDate > date_add($time, interval -1 week)ORDER by dates asc) a 
            left join (select *, DATE_FORMAT(regdate,'%Y-%m-%d')as now,count(regdate)as cnt from mpr_event_db b GROUP by now)b
              on a.dates = b.now";
                            
        $result=$DB->query($sql);
        // print_r($column);
        // echo "<script>console.log('컬럼명:".$column[0]['year']."');</script>";
        // echo "<script>console.log('컬럼명:".$column[0]['br_code']."');</script>";
        // echo "<script>console.log('길이:".count($column)."');</script>";
        // $label_1 = array();
        // $label_2 = array();
        // $data_1 = array();
        echo json_encode($result);
      }
      if($type=="column")
      {
        $sql="select b.ev_subject,a.dates,a.cnt,a.br_key from
        (select br_key,date_format(regdate,'%Y-%m-%d')as dates,count(br_key) as cnt from mpr_event_db where date_format(regdate,'%Y-%m-%d')='$date' group by br_key)a 
          left outer join (select ev_subject, ev_key from mpr_event group by ev_key)b on a.br_key = b.ev_key limit 3";
        $result=$DB->query($sql);
        echo json_encode($result);
      }

      if($type=="pie")
      {
        if(!$key)
        {
          $sql="select if(ev_sex='','기타',if(ev_sex='F','여자','남자'))as ev_sex, count(ev_sex) as cnt from mpr_event_db where br_code ='TwTwiN' group by ev_sex";
          $result=$DB->query($sql);
          echo json_encode($result);
        }
        else
        {
          $sql="select if(ev_sex='','기타',if(ev_sex='F','여자','남자'))as ev_sex, count(ev_sex) as cnt, date_format(regdate,'%Y-%m-%d')as dates from mpr_event_db where br_key='$key' and date_format(regdate,'%Y-%m-%d')='$date' group by ev_sex";
          $result=$DB->query($sql);
          echo json_encode($result);
        }
        
      }

      if($type=="rev_bar")
      {
        if(!$key)
        {
          $sql="select a.age_range,a.cnt FROM
          (select
                (
                    CASE
                        when ev_age BETWEEN 10 and 19 then '10대'
                        when ev_age BETWEEN 20 and 29 then '20대'
                        when ev_age BETWEEN 30 and 39 then '30대'
                        when ev_age BETWEEN 40 and 49 then '40대'
                        when ev_age BETWEEN 50 and 59 then '50대'
                        when ev_age BETWEEN 60 and 69 then '60대'
                        when ev_age BETWEEN 70 and 79 then '70대'
                        when ev_age BETWEEN 80 and 89 then '80대'
                        when ev_age BETWEEN 90 and 99 then '90대'
                        else '범위밖'
                    END) as age_range, count(ev_age) as cnt,br_key
                from mpr_event_db where br_key='2WL8ZRZDS5DM' group by age_range)a
                left outer JOIN
          (select * from mpr_event)b on a.br_key = b.ev_key";
          $result=$DB->query($sql);
          echo json_encode($result);
        }
        else
        {
          $sql="select a.age_range,a.cnt FROM
          (select
                (
                    CASE
                        when ev_age BETWEEN 10 and 19 then '10대'
                        when ev_age BETWEEN 20 and 29 then '20대'
                        when ev_age BETWEEN 30 and 39 then '30대'
                        when ev_age BETWEEN 40 and 49 then '40대'
                        when ev_age BETWEEN 50 and 59 then '50대'
                        when ev_age BETWEEN 60 and 69 then '60대'
                        when ev_age BETWEEN 70 and 79 then '70대'
                        when ev_age BETWEEN 80 and 89 then '80대'
                        when ev_age BETWEEN 90 and 99 then '90대'
                        else '범위밖'
                    END) as age_range, count(ev_age) as cnt,br_key,date_format(regdate,'%Y-%m-%d') as dates
                from mpr_event_db where br_key='$key' and date_format(regdate,'%Y-%m-%d')='$date' group by age_range)a
                left outer JOIN
          (select * from mpr_event group by ev_key)b on a.br_key = b.ev_key";
          $result=$DB->query($sql);
          echo json_encode($result);
        }
      }
    }
    if($_SESSION['code'])
    {
      $sql="select a.br_name, b.ev_stat,b.ev_code,b.ev_subject,b.ev_start, b.ev_end from
      (select br_code,br_name from mpr_branch)a
      left outer join
      (select * from mpr_event  where ev_stat='W' or ev_stat='Y')b on a.br_code=b.br_code where a.br_code='$code'";
      $result=$DB->query($sql);
      echo json_encode($result);
    }
    // else
    // {
    //   $_SESSION['code']=$code;
    //   echo $_SESSION['code'];
    // }



    

    // select a.age_range,a.cnt FROM
    // (select
    //       (
    //           CASE
    //               when ev_age BETWEEN 10 and 19 then '10대'
    //               when ev_age BETWEEN 20 and 29 then '20대'
    //               when ev_age BETWEEN 30 and 39 then '30대'
    //               when ev_age BETWEEN 40 and 49 then '40대'
    //               when ev_age BETWEEN 50 and 59 then '50대'
    //               when ev_age BETWEEN 60 and 69 then '60대'
    //               when ev_age BETWEEN 70 and 79 then '70대'
    //               when ev_age BETWEEN 80 and 89 then '80대'
    //               when ev_age BETWEEN 90 and 99 then '90대'
    //               else '범위밖'
    //           END) as age_range, count(ev_age) as cnt,br_key,date_format(regdate,'%Y-%m-%d') as dates
    //       from mpr_event_db where br_key='2WL8ZRZDS5DM' and date_format(regdate,'%Y-%m-%d')='2022-10-18 group by age_range)a
    //       left outer JOIN
    // (select * from mpr_event)b on a.br_key = b.ev_key


























    // if($type=="stackbar")
    // {
    //   $sql="select tmp.dates, tmp.ev_subject,tmp.cnt,if(tmp.ev_subject is null,tmp.rank=0,tmp.rank)as rank from
    //   (select a.dates, b.ev_subject,ifnull(b.cnt,0) as cnt,dense_rank() over(PARTITION by a.dates order by b.cnt desc)as rank from
    //   (select @curDate := date_sub(@curDate, interval 1 day) as dates from mpr_event_db inner join (select @curDate := $time) A where @curDate > date_add($time, interval -1 week)ORDER by dates asc)a
    //   left outer join
    //   (select b.ev_subject,a.dates, a.cnt from
    //         (select br_key,date_format(regdate,'%Y-%m-%d')as dates, count(br_key) as cnt from mpr_event_db group by br_key,dates)a 
    //           left outer join (select ev_subject, ev_key from mpr_event group by ev_key)b on a.br_key = b.ev_key)b on a.dates=b.dates)tmp where tmp.rank<=3";
    //   $result=$DB->query($sql);
    //   echo json_encode($result);
    // }
    // 2022-10-13  lfsd2 1
    // 2022-10-14  lfsd2 2
    // 2022-10-15  2dc22 1
    // 2022-10-16  2dc22 2
    // 2022-10-17  2dc22 3
    // 2022-10-18  lfsd2 1
    // 2022-10-19  lfsd2 1 

    
    // 2022-10-13  lfsd2 1       
    // 2022-10-14  lfsd2 2
    // 2022-10-15  lfsd2 0 
    // 2022-10-16  lfsd2 0
    // 2022-10-17  lfsd2 0
    // 2022-10-18  lfsd2 1
    // 2022-10-19  lfsd2 1

    // 2022-10-13  2dc22 0
    // 2022-10-14  2dc22 0
    // 2022-10-15  2dc22 1
    // 2022-10-16  2dc22 2
    // 2022-10-17  2dc22 3
    // 2022-10-18  2dc22 0
    // 2022-10-19  2dc22 0
?>