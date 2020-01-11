$(document).ready(function () {

    //chart





   /* $('select').on('change', function(e) {
        e.preventDefault();
        $('#line-chart').empty();
          var year=this.value;
    });*/

     // click fun
    $('.add-product-btn').on('click',function (e) {
         e.preventDefault();//هنا بمنع الصفحه من انها تعمل اعاده تحميل من البدايه
                           // alert('btn clicked');
        var name= $(this).data('name');
                    //احنا قايلين ف لينك الزرار اللي بضغط عليه ان ف حاجه اسمها data name
        var id= $(this).data('id');
        var price= $.number($(this).data('price'),2);//عملناها ببلاجن نيمبر هنعمل علامه بعد رقمين//for x.00
        $(this).removeClass('btn-success').addClass('btn-default disabled');//هنا بقوله لما اضغط ع الزرار خليه deactive**


        //end collect data

       var html=
           `<tr>
                <td>${name}</td>
                <td><input type="number" name="products[${id}][quantity]" data-price="${price}"   min="1"  value="1" class="form-control input-sm product-quantity"></td>
                <td class="product-price" >${price}</td>
                <td><button class="btn btn-danger btn-sm order-Delete" data-id="${id}"><span class="fa fa-trash"></span></button></td>
            </tr>`;
        $('.order-list').append(html);
        //cal_total
        calTotal();
    });//end click fun
                   //  alert(name + ' ' + id + ' '+ price);
        //disabled btn
    //  disabled btn
        $('body').on('click','.disabled',function (e) {
            e.preventDefault();
                  // لو ضغط كليلك ع اي مكان ف الbody والمكان دا واخد كلاس disabled امنع الشئ اللي المفروض يجصل اللي هو ال click
                  //ودا يعتبر تاكيد بس  ل**
        });// end disabled btn

        //  delete orderحطتهم هنا لان الفورم دي بتتخلق من الداله دي اصلا مينفعش تكون براها
        $('body').on('click','.order-Delete',function (e) {
            e.preventDefault();
            var  id= $(this).data('id');
            //دورلي ع اللي واخد الid دا
            $('#product-' +id).addClass('btn-success').removeClass('btn-default disabled');
            $(this).closest('tr').remove();
            calTotal();
        });
        // end delete order

        //collective price
 $('.order-products').on('click',function (e) {
      e.preventDefault();

     $('.loading').css('display','flex');//flex عشان تخلي علامه اللتحميل ف النص
      var  url=$(this).data('url');
      var  method=$(this).data('method');
      $.ajax({
          url:url,
          method:method,
          success:function (data) {

              $('.loading').css('display','none');
              $('#order-product-list').empty();
              $('#order-product-list').append(data);
          }
      })


  });//end of order-products click


});//end ready fun
//print order
//  print order
$('#print-order-form-btn').on('click',function () {
    $('.print-area').printThis();
})// end print order


//cal_priceلازم افكر هوصل للمجموع ازاي ؟؟
//هو جوه لسيت وبعد الليست داخل ان بوت  وهعمل each fun عشان تلف عليهم
//html المقصود بيه الشي اللي هوصله عن طريق ال.order-list .product-price
    function  calTotal() {
           var price=0;

         $('.order-list .product-price').each(function (index) {
            price += parseFloat($(this).html().replace(/,/g,''));//for 1,234,30
            ///,/g mean global
            //alert(price);مينفعش اعمل ال هنا
         });
         $('.total-price').html($.number(price,2));//for x.00

        if(price >0){
            $('#add-order-form-btn').removeClass('disabled');
        }else {
            $('#add-order-form-btn').addClass('disabled');
        }

    }// end calTotal

   //if add more 1 product for the same product(change quantity)
$('body').on('keyup change','.product-quantity',function () {
     //price for unit
           /*مينفعش اقول كدا ع طول لانه هيدخل كل الprice ف بعضه
            لما اغير اكتر من كميه لمنتجات مختلفه انما كدا كل منتج هيتيغير هيطلعلي سهره
           * var unitPrice=parseFloat( $('.product-price').data('price'));11
           ////////////
            var unitPrice=parseFloat( $(this).closest('tr').find('.product-price').data('price'));22
          هي صح ولكن الاسهل اني اخحط الداتا برايس مع الانبوت
         بدل مااكتب كل دا ف الhtml هحط داخل الinput  data-price عشان اوصله بسهوله بدل ماكنت حطاه مع عمود السعر
           * */
      var unitPrice=parseFloat($(this).data('price'));
      var quantity= Number( $(this).val());//not $(this).html() bcs it in input //number of unit
      $(this).closest('tr').find('.product-price').html($.number(unitPrice * quantity,2));
            //  لازم تتكتب بالطريقه دي عشان اتاكد ان الكميه المحدده انضربت ف سعر الوحده بتاعها فعلا
            //وكمان حطناها ف مكانها بالظبط بناء ع تغير الكميه مش اي مكان تاني
      calTotal();

});
    //end product quantity
