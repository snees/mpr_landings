<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>다이어트 체험가 이벤트 - 미담한의원</title>

  <!-- 메타태그 -->
  <meta name="type" content="website">
  <meta name="title" content="미담한의원"/>
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <meta name="url" content="http://landing.midam-foru.com/">
  <meta property="og:type" content="website">
  <meta property="og:title" content="미담한의원">
  <meta property="og:site_name" content="미담한의원" />
  <meta property="og:description" content="">
  <meta property="og:keywords" content="">
  <meta property="og:image" content="./img/og_img.png">
  <meta property="og:url" content="http://landing.midam-foru.com/">
  <link rel="canonical" href="http://landing.midam-foru.com/">
  <link rel="apple-touch-icon" sizes="180x180" href="./img/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="./img/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="./img/favicon/favicon-16x16.png">
  <link rel="manifest" href="./img/favicon/site.webmanifest">
  <meta name="robots" content="index, follow">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.3.2/swiper-bundle.css" integrity="sha512-ipO1yoQyZS3BeIuv2A8C5AwQChWt2Pi4KU3nUvXxc4TKr8QgG8dPexPAj2JGsJD6yelwKa4c7Y2he9TTkPM4Dg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.3.2/swiper-bundle.min.js" integrity="sha512-V1mUBtsuFY9SNr+ptlCQAlPkhsH0RGLcazvOCFt415od2Bf9/YkdjXxZCdhrP/TVYsPeAWuHa+KYLbjNbeEnWg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://unpkg.com/micromodal/dist/micromodal.min.js"></script>
  <link rel="stylesheet" href="./css/font.css?v=220823">
  <link rel="stylesheet" href="./css/common.css?v=220823">
  <link rel="stylesheet" href="./css/style.css?v=220823">

  <meta name="facebook-domain-verification" content="afsb8abqrg5g2cbxk05then9gba5sx" />
</head>

<body>

  <article>
    <div class="bg_sec">
      <img src="./img/title.png" alt="체지방 타이틀" class="event_title img-responsive py-30">
      <img src="./img/price.jpg" alt="가격" class="price img-responsive">
      <div class="swiper">
        <div class="swiper-wrapper">
          <div class="swiper-slide"><img src="./img/inbody01.png" alt="다이어트 4개월차" class="img-responsive mt-0"></div>
          <div class="swiper-slide"><img src="./img/inbody02.png" alt="다이어트 3개월차" class="img-responsive mt-0"></div>
          <div class="swiper-slide"><img src="./img/inbody03.png" alt="다이어트 1개월" class="img-responsive mt-0"></div>
          <div class="swiper-slide"><img src="./img/inbody04.png" alt="다이어트 3개월" class="img-responsive mt-0"></div>
          <div class="swiper-slide"><img src="./img/inbody05.png" alt="다이어트 3개월차" class="img-responsive mt-0"></div>
        </div>
      </div>
      <script>
        const inbodySwiper = new Swiper('.swiper', {
          speed: 1000,
          autoplay: {
            delay: 1500,
            disableOnInteraction: false,
          },
          effect: 'fade',
          fadeEffect: {
            crossFade: true
          },
        })
      </script>

      <div class="video_wrapper">
        <video autoplay loop muted playsinline>
          <source src="./img/video.mp4" ype="video/mp4">
          해당 브라우저는 video 태그를 지원하지 않습니다.
        </video>
      </div>
      <img src="./img/video_bottom.png" alt="지방분해 테스트" class="img-responsive mt-0">
      <img src="./img/txt01.png" alt="지방분해 1:1 체형관리" class="img-responsive py-30">
    </div>

    <form name="fastAjax" id="fastAjax" onsubmit="return fastAjaxLanding(this);">
      <div class="question">
        <div class="question_box">
          <div class="ques ques01 point-font font-40"><span class="qnum font-20">Q.01</span> 현재 나의 고민은?</div>
          <div class="q_select font-30 bold500">
            <div class="q_list">
              <input type="checkbox" name="a" value="체지방 분해" id="ql_a01">
              <label for="ql_a01">
                <span></span>체지방 분해</label>
            </div>
            <div class="q_list">
              <input type="checkbox" name="a" value="식욕억제" id="ql_a02">
              <label for="ql_a02">
                <span></span>식욕억제</label>
            </div>
            <div class="q_list">
              <input type="checkbox" name="a" value="식습관 개선" id="ql_a03">
              <label for="ql_a03">
                <span></span>식습관 개선</label>
            </div>
          </div>
          <div class="ques ques02 point-font font-40 mt-50"><span class="qnum font-20">Q.02</span> 목표감량 kg은?</div>
          <div class="q_select font-30 bold500">
            <div class="q_list">
              <input type="radio" name="b" value="3~5kg" id="ql_b01">
              <label for="ql_b01">
                <span></span>3~5kg</label>
            </div>
            <div class="q_list">
              <input type="radio" name="b" value="5~10kg" id="ql_b02">
              <label for="ql_b02">
                <span></span>5~10kg</label>
            </div>
            <div class="q_list">
              <input type="radio" name="b" value="10~15kg" id="ql_b03">
              <label for="ql_b03">
                <span></span>10~15kg</label>
            </div>
            <div class="q_list">
              <input type="radio" name="b" value="15kg 이상" id="ql_b04">
              <label for="ql_b04">
                <span></span>15kg 이상</label>
            </div>
          </div>
          <div class="ques ques03 point-font font-40 mt-50"><span class="qnum font-20">Q.03</span> 목표 개월은?</div>
          <div class="q_select font-30 bold500">
            <div class="q_list">
              <input type="radio" name="c" value="10일" id="ql_c01">
              <label for="ql_c01">
                <span></span>10일</label>
            </div>
            <div class="q_list">
              <input type="radio" name="c" value="한달" id="ql_c02">
              <label for="ql_c02">
                <span></span>한달</label>
            </div>
            <div class="q_list">
              <input type="radio" name="c" value="세달" id="ql_c03">
              <label for="ql_c03">
                <span></span>세달</label>
            </div>
          </div>
        </div>
      </div>

      <div class="form bg-gray">
        <!-- <div class="tit font-24 point-font mb-20">이벤트 기간 : 2022.08.01~2022.08.31</div> -->
        <p class="font-18">안심하세요! 미담한의원에서는 고객님의 소중한 개인정보를 <br class="hidden-xs"> 상담 외 어떠한 목적으로도 사용하지 않습니다.</p>
        <div class="formGroup">
          <div class="table_box">
            <div class="table font-22">
              <tbody>
                <div class="table_row">
                  <div class="table_head bold500">이름</div>
                  <div class="table_data">
                    <input type="text" name="wr_name" class="inp" autocomplete="off">
                  </div>
                </div>
                <div class="table_row">
                  <div class="table_head font-22 bold500">전화번호</div>
                  <div class="table_data">
                    <input type="tel" name="phone" class="inp font-22" autocomplete="off" maxlength="11">
                  </div>
                </div>
                <div class="table_row">
                  <div class="table_data select_data bold500">
                    <select name="time" id="">
                      <option value="" selected disabled>상담가능시간</option>
                      <option value="09-11">오전 9시~오전 11시</option>
                      <option value="11-1">오전 11시~오후 1시</option>
                      <option value="3-5">오후 3시~오후 5시</option>
                      <option value="6-7">오후 6시~오후 7시</option>
                    </select>
                  </div>
                </div>
              </tbody>
            </div>
          </div>
        </div>
        <div class="agree font-18 mb-20">
          <input type="checkbox" name="agg" value="개인정보수집동의" id="agree" class="font-18">
          <label for="agree">
            <span></span>
            <p>개인정보 수집 및 이용에 관한 내용을 확인하고 <br class="visible-xs" /> 동의함 <a href="javascript:openModal();" class="btn-agreement">[자세히보기]</a></p>
            </label>
        </div>


        <div class="modal micromodal-slide" id="modal-1" aria-hidden="true">
          <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
              <header class="modal__header">
                <h2 class="modal__title" id="modal-1-title">
                  개인정보수집안내
                </h2>
                <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
              </header>
              <main class="modal__content" id="modal-1-content">
                <div class="agreement">
                  <h3>개인정보처리방침</h3>
                  <ul>
                    <li>개인 정보 수집 주체 : 미담한의원</li>
                    <li>개인 정보 수집 항목 : 이름, 전화번호</li>
                    <li>개인 정보 수집 및 이용 목적 : 미담한의원 다이어트 이벤트 상담용 (전화, 문자)</li>
                    <li>개인 정보 보유 및 이용 기간 : 수집일로부터 6개월 (고객 동의 철회 시 지체없이 파기)</li>
                  </ul>
                  <br>
                  <h3>개인 정보 취급 위탁</h3>
                  <ul>
                    <li>개인 정보 취급 위탁을 받는 자 : 엠피알</li>
                    <li>개인 정보 취급 위탁을 하는 업무의 내용: 이벤트 참여 고객 정보 저장 및 서버, 전산 관리</li>
                  </ul>
                  <br>
                  <p>* 상기 동의를 거부할 권리가 있으나, 수집 및 이용에 동의하지 않을 경우 미담한의원 다이어트 상담 및 이벤트 참여가 불가능합니다.
                  </p>
                </div>
              </main>
              <footer class="modal__footer">
                <button class="modal__btn" data-micromodal-close aria-label="Close this dialog window">닫기</button>
              </footer>
            </div>
          </div>
        </div>
        <script>
          function openModal() {
            MicroModal.show('modal-1');
          }
        </script>

        <a href="javascript:;">
          <div class="application">
            <p class="font-40 point-font color-white"><strong class="secondary-color">상담</strong> 예약하기</p>
          </div>
        </a>
        <input type="submit" value="상담 신청하기" id="submitt" style="display:none">
      </div>
    </form>

    <img src="./img/qna.png" alt="미담한 효소 qna" class="qna_sec img-responsive">

    <div class="apply_list mt-50 pb-100">
      <img src="./img/txt02.png" alt="실시간 신청자 현황" class="img-responsive mb-20 py-30">
      <div class="apply_member font-18">
      </div>
      <button type="button" class="btn_moreSubscribe font-18 bg-gray">신청자 현황 더보기 »</button>
    </div>
    <script type="text/javascript">
      let from = 0;
      let maxFrom = 30;

      $(document).ready(function() {
        getData();
      });

      $('.apply_list button').on('click', function() {
        getData();

        // 스크롤 아래로 내리기
        $('html, body').animate({
          scrollTop: document.body.scrollHeight
        }, 500)
      })


      /* 정상적인 휴대폰 번호 확인 */
      function phoneFomatter(num) {
        let formatNum = '';

        if (num.length == 11) {
          formatNum = num.replace(/(\d{3})(\d{4})(\d{4})/, '$1-****-$3');
        } else if (num.length == 10) {
          formatNum = num.replace(/(\d{3})(\d{3})(\d{4})/, '$1-***-$3');
        } else if (num.length == 8) {
          formatNum = num.replace(/(\d{4})(\d{4})/, '****-$2');
        } else if (num.length == 7) {
          formatNum = num.replace(/(\d{3})(\d{4})/, '***-$2');
        }

        return formatNum;
      }

      /* 데이터 불러오기 */
      function getData() {
        let eventName = "다이어트 지방분해";

        $.ajax({
            url: './event_diet_comment.php',
            type: 'POST',
            dataType: 'JSON',
            data: {
              eventName: eventName,
              from: from
            }
          })
          .done(function(r) {
            if (r.result) {
              let obj = r.result;

              for (let i in obj) {
                let name = obj[i].cname;
                name = name.substring(0, 1);
                let tel = obj[i].chp;
                tel = phoneFomatter(tel);
                let subject = obj[i].call_stat;
                let datetime = obj[i].rcdate;
                let time = datetime.substring(11, 16);
                let date = datetime.substring(5, 10);

                let tags = '<div class="content">';
                tags += '<div class="name">' + name + '**  |  ' + tel + '</div>';
                tags += '<div class="msg">접수되었습니다.</div>';
                tags += '<div class="date">' + date + ' ' + time + '</div>';
                tags += '</div>';
                $('.apply_member').append(tags);
              }
              from += 5;
            } else {
              alert('더 이상 불러올 수 없습니다');
              $('.btn_moreSubscribe').fadeOut(150);
            }
          })
          .fail(function(r) {
            console.log(r);
            console.log('ERROR');
          });
        return false;
      }
    </script>

    <script>
      $(".application").on('click', function() {
        $("#submitt").trigger('click');
      });

      function fastAjaxLanding(f) {
        let cate = "다이어트 지방분해";
        var qArray = [];
        if (f.a.length > 1) {
          $(f.a).each(function(i, v) {
            if (v.checked) qArray.push(v.value);
          });
          var qlistA = qArray.join();
        } else {
          var qlistA = f.a;
        }
        var qlistB = f.b.value;
        var qlistC = f.c.value;
        var name = f.wr_name.value;
        var phone = f.phone.value;
        var time = f.time.value;
        var chkP = f.agg.checked;

        if (!qlistA || !qlistB || !qlistC) {
          alert('설문에 참여 부탁드립니다.');
          goToSurvey();
          return false;
        }
        if (!name) {
          alert('이름을 입력하세요.');
          f.wr_name.focus();
          return false;
        }
        if (!phone) {
          alert('연락처를 입력하세요.');
          f.phone.focus();
          return false;
        }
        let reg_num = /^[0-9]{8,13}$/;
        if (reg_num.test(phone) === false) {
          alert('양식에 맞게(-없이 입력)를 올바르게 입력하세요.');
          f.phone.focus();
          return false;
        }
        if (!chkP) {
          alert('개인정보 취급방침에 동의는 필수입니다.');
          return false;
        }

        // ConnectM 데이터 입력
        $.ajax({
            url: './event_diet.php',
            type: 'post',
            dataType: 'json',
            data: {
              qlistA: qlistA,
              qlistB: qlistB,
              qlistC: qlistC,
              name: name,
              phone: phone,
              time: time,
              key: "7DEA0B398C9526DE79F561308BE7955D"
            },
          })
          .done(function(r) {
            if (r.result) {
              alert('상담이 접수되었습니다.🙂');
              $('#fastAjax')[0].reset();
            } else {
              alert('오류가 발생했습니다.');
              location.reload();
            }
          })
          .fail(function(r) {
            console.log(r);
          });

        return false;
      }

      function goToSurvey() {
        $('html, body').animate({
          scrollTop: $("#fastAjax").offset().top
        }, 500);
      };
    </script>
  </article>

</body>

</html>