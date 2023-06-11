///////////////////////////////
// いいね！用のJavaScript
///////////////////////////////

$(function () {
  // いいね！がクリックされた時
  $('.js-like').click(function () {
    const this_obj = $(this);
    // tweet_idを取得
    const tweet_id = $(this).data('tweet-id');
    const like_id = $(this).data('like-id');
    const like_count_obj = $(this).parent().find('.js-like-count');
    let like_count = Number(like_count_obj.html());

    if (like_id) {
      // いいね！取り消し
      // 非同期通信
      $.ajax({
        url: 'like.php',
        type: 'POST', //メソッドのこと
        data: {
          'like_id': like_id
        },
        timeout: 10000  //サーバーとの通信のtimeout
      })
      // 取り消しが成功
      .done(() => {
        //非同期通信でエラーがなければdoneメソッドに登録の以下の処理が実行される
        // メソッドは一度しか使用しない場合、無名関数・arro関数で記述できる
        // いいね！カウントを減らす
        like_count--;
        like_count_obj.html(like_count);
        this_obj.data('like-id', null);

        // いいね！ボタンの色をグレーに変更
        $(this).find('img').attr('src', '../Views/img/icon-heart.svg');
      })
      .fail((data) => { //通信に失敗した場合
        alert('処理中にエラーが発生しました。');
        console.log(data); //データを受け取ってlogを出力する->アラートでエラーメッセージを表示する
      });
      //.でメソッドが連結している:メソッドチェーン
      //ajaxメソッドの戻り値にあるdoneメソッドが実行->doneメソッドの戻り値にあるfailメソッドが実行されている。responseを待たずに裏で即座に実行される
    } else {
      // いいね！付与
      // 非同期通信
      $.ajax({
        url: 'like.php',
        type: 'POST',
        data: {
          'tweet_id': tweet_id
        },
        timeout: 10000
      })
      // いいね！が成功
      .done((data) => {
        // いいね！カウントを増やす
        like_count++;
        like_count_obj.html(like_count);
        this_obj.data('like-id', data['like_id']);

        // いいね！ボタンの色を青に変更
        $(this).find('img').attr('src', '../Views/img/icon-heart-twitterblue.svg');
      })
      .fail((data) => { //通信に失敗した場合
        alert('処理中にエラーが発生しました。');
        console.log(data); //データを受け取ってlogを出力する->アラートでエラーメッセージを表示する
      });
    }
  });
})