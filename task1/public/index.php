<?php require __DIR__ . '/../bootstrap.php';
?><!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Calculator</title>
    <script src="js/loader.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <style>
        #calc-container {
            color: white;
        }

        #calculator p {
            display: inline;
        }

        #calculator input {
            margin: auto auto;
            width: 100%;
        }
    </style>
</head>
<body>



<div class="container h-90 ">

    <div id="calc-container" class="mx-auto my-auto w-50 h-100">
        <div class="card bg-dark py-5 mt-5">
            <div class="mt-5">
                <h1 class="text-center">Calcing</h1>

                <form id="calculator">
                    <div class="w-50 mx-auto text-center">

                        <div class="price-container">
                            <div class="d-flex justify-content-between">
                                <label>Car price</label>
                                <p id="price-indicator">100</p>
                            </div>
                            <div>
                                <input name="asset_price" type="range" value="100" min="100" max="100000" onchange="updateTextInput(this.value, 'price-indicator')">
                            </div>
                        </div>

                        <div class="tax-container">
                            <div class="d-flex justify-content-between">
                                <label>Tax</label>
                                <p id="tax-indicator">0</p>
                            </div>
                            <div>
                                <input type="range" name="tax" value="0" min="0" max="100" onchange="updateTextInput(this.value, 'tax-indicator')">
                            </div>
                        </div>

                        <div class="period-container">
                            <div class="d-flex justify-content-between">
                                <label>Period (months)</label><p id="period-indicator">1</p>
                            </div>
                            <div>
                                <input type="range" name="installment_count" value="1" min="1" max="12" onchange="updateTextInput(this.value, 'period-indicator')">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" role="button" id="calc-btn">Calculate</button>
                    </div>
                </form>
            </div>
        </div>

    </div>


    <h1>Total</h1>
    <div id="showData2" class="mt-5"></div>

    <h1>Installments</h1>
    <div id="showData" class="mt-5"></div>




</div>

<script src="js/main.js"></script>
</body>
</html>