<?php include 'header.php' ?>

<div class="container">
    <div class="clearfix"></div>
    <div class="lines"></div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
        </div>
    </div>
    <div class="title-bg">
        <div class="title">Alışveriş Sepetim</div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered chart">
            <thead>
                <tr>
                    <th>Remove</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Model</th>
                    <th>Item No.</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <form><input type="checkbox"></form>
                    </td>
                    <td><img src="images\demo-img.jpg" width="100" alt=""></td>
                    <td>Some Camera</td>
                    <td>PR - 2</td>
                    <td>225883</td>
                    <td>
                        <form><input type="text" class="form-control quantity"></form>
                    </td>
                    <td>$94.00</td>
                    <td>$94.00</td>
                </tr>
             
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-md-6">
           
           
        </div>
        <div class="col-md-3 col-md-offset-3">
            <div class="subtotal-wrap">
                <div class="subtotal">
                    <p>Sub Total : $26.00</p>
                    <p>Vat 17% : $54.00</p>
                </div>
                <div class="total">Total : <span class="bigprice">$255.00</span></div>
                <div class="clearfix"></div>
                <a href="" class="btn btn-default btn-yellow">Ödeme Sayfası</a>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="spacer"></div>
</div>


<?php include 'footer.php' ?>