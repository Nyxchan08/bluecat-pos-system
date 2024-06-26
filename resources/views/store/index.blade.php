@extends('layout.main')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8" id="product-list-container">
            <div class="product-list">
                <div class="row row-cols-2 row-cols-sm-4" id="productContainer">
                    @foreach($products as $product)
                        <div class="col-md-3 mb-4">
                            <div class="card product-price-card" onclick="addToOrder('{{ $product->product_name }}', {{ $product->price }})">
                                <img class="product-image" src="{{ $product->product_image ? asset('storage/img/product/' . $product->product_image) : 'https://i.vimeocdn.com/portrait/17883671_640x640' }}" alt="Product Image">
                                <div class="card-body">
                                    <h5 class="card-title">{{ Str::limit($product->product_name, 15, '...') }}</h5>
                                    <p class="card-text">PHP {{ number_format($product->price, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-4" id="right-sidebar-order-container">
            <div>
                <div class="card" id="body-card">
                    <div class="card-header" id="card-id-order">
                        <h4>Checkout</h4>
                    </div>
                    <div class="card-body">
                        <div class="order-summary">
                            <div class="order-header">
                                <div class="order-header-item">Name</div>
                                <div class="order-header-item">QTY</div>
                                <div class="order-header-item">Price</div>
                                <div class="order-header-item"></div>
                            </div>
                            <div class="order-items" id="orderItems">
                                
                            </div>
                        </div>
                        <div class="form-group mb-3" style="margin-top: 1rem">
                            <label for="discount">Discount (%)</label>
                            <input type="number" class="form-control" id="discount" min="0" value="0" oninput="updateTotal()">
                        </div>
                        <h4>Total: PHP <span id="total_amount">0.00</span></h4>
                        <button class="btn btn-success" onclick="showPaymentModal()">Pay</button>
                        <button class="btn btn-secondary" onclick="cancelOrder()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="quantityModal" tabindex="-1" role="dialog" aria-labelledby="quantityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quantityModalLabel">Enter Quantity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="numeric-keypad" class="text-center">
                    <input type="text" id="quantityInput" class="form-control mb-3" oninput="validateQuantityInput()" autofocus>
                    <div class="keypad-buttons d-grid gap-2">
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-primary" onclick="appendNumber(1, 'quantityInput')">1</button>
                            <button type="button" class="btn btn-primary" onclick="appendNumber(2, 'quantityInput')">2</button>
                            <button type="button" class="btn btn-primary" onclick="appendNumber(3, 'quantityInput')">3</button>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-primary" onclick="appendNumber(4, 'quantityInput')">4</button>
                            <button type="button" class="btn btn-primary" onclick="appendNumber(5, 'quantityInput')">5</button>
                            <button type="button" class="btn btn-primary" onclick="appendNumber(6, 'quantityInput')">6</button>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-primary" onclick="appendNumber(7, 'quantityInput')">7</button>
                            <button type="button" class="btn btn-primary" onclick="appendNumber(8, 'quantityInput')">8</button>
                            <button type="button" class="btn btn-primary" onclick="appendNumber(9, 'quantityInput')">9</button>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-primary" onclick="appendNumber(0, 'quantityInput')">0</button>
                            <button type="button" class="btn btn-danger" onclick="clearInput('quantityInput')">C</button>
                            <button type="button" class="btn btn-success" onclick="setQuantity()">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Enter Payment Amount</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="paymentForms">
                    
                    <div id="creditCardForm" style="display: none;">
                        <div class="form-group mb-3">
                            <label for="cardNumber">Card Number</label>
                            <input type="text" class="form-control" id="cardNumber" placeholder="Enter card number" maxlength="19" onfocus="setActiveInput('cardNumber')">
                        </div>
                        <div class="form-group mb-3">
                            <label for="expiryDate">Expiry Date</label>
                            <input type="text" class="form-control" id="expiryDate" placeholder="MM/YY" maxlength="5" onfocus="setActiveInput('expiryDate')">
                        </div>
                        <div class="form-group mb-3">
                            <label for="cvv">CVV</label>
                            <input type="password" class="form-control" id="cvv" placeholder="CVV" maxlength="3" onfocus="setActiveInput('cvv')">
                        </div>
                    </div>

                    
                    <div id="debitCardForm" style="display: none;">
                        <div class="form-group mb-3">
                            <label for="debitCardNumber">Debit Card Number</label>
                            <input type="text" class="form-control" id="debitCardNumber" placeholder="Enter debit card number" maxlength="19" onfocus="setActiveInput('debitCardNumber')">
                        </div>
                        <div class="form-group mb-3">
                            <label for="debitExpiryDate">Expiry Date</label>
                            <input type="text" class="form-control" id="debitExpiryDate" placeholder="MM/YY" maxlength="5" onfocus="setActiveInput('debitExpiryDate')">
                        </div>
                        <div class="form-group mb-3">
                            <label for="debitCvv">CVV</label>
                            <input type="password" class="form-control" id="debitCvv" placeholder="CVV" maxlength="3" onfocus="setActiveInput('debitCvv')">
                        </div>
                    </div>

                    
                    <div id="paymentInputContainer">
                        <input type="text" id="paymentInput" class="form-control mb-3" placeholder="Enter payment amount" oninput="validatePaymentInput()" onfocus="setActiveInput('paymentInput')" autofocus>
                    </div>
                </div>

                
                <div class="form-group mb-3">
                    <label for="paymentMethod">Payment Method</label>
                    <select class="form-control" id="paymentMethod" onchange="togglePaymentForm()">
                        <option value="cash">Cash</option>
                        <option value="credit_card">Credit Card</option>
                        <option value="debit_card">Debit Card</option>
                    </select>
                </div>

                
                <div id="numeric-keypad" class="text-center">
                    <div class="keypad-buttons d-grid gap-2">
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-primary" onclick="appendNumber(1, activeInput)">1</button>
                            <button type="button" class="btn btn-primary" onclick="appendNumber(2, activeInput)">2</button>
                            <button type="button" class="btn btn-primary" onclick="appendNumber(3, activeInput)">3</button>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-primary" onclick="appendNumber(4, activeInput)">4</button>
                            <button type="button" class="btn btn-primary" onclick="appendNumber(5, activeInput)">5</button>
                            <button type="button" class="btn btn-primary" onclick="appendNumber(6, activeInput)">6</button>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-primary" onclick="appendNumber(7, activeInput)">7</button>
                            <button type="button" class="btn btn-primary" onclick="appendNumber(8, activeInput)">8</button>
                            <button type="button" class="btn btn-primary" onclick="appendNumber(9, activeInput)">9</button>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-primary" onclick="appendNumber(0, activeInput)">0</button>
                            <button type="button" class="btn btn-danger" onclick="clearInput(activeInput)">C</button>
                            <button type="button" class="btn btn-success" onclick="processPayment()">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script>
    var currentQuantityElement;
    var activeInput;

    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        window.addToOrder = function (productName, productPrice) {
            var existingItem = document.querySelector('.order-item[data-product-name="' + productName + '"]');

            if (existingItem) {
                var quantityElement = existingItem.querySelector('.quantity');
                var currentQuantity = parseInt(quantityElement.innerText);
                quantityElement.innerText = currentQuantity + 1;
            } else {
                var div = document.createElement('div');
                div.classList.add('order-item');
                div.setAttribute('data-product-name', productName);
                div.setAttribute('data-product-price', productPrice);
                div.innerHTML =
                    '<div class="order-item-name">' + productName + '</div>' +
                    '<div class="order-item-quantity quantity" onclick="editQuantity(this)">1</div>' +
                    '<div class="order-item-price price">PHP ' + productPrice.toFixed(2) + '</div>' +
                    '<div class="order-item-action action"><button onclick="removeItem(this)" id="order-delete-btn"><img src="{{ asset("img/delete.png") }}" alt="delete btn" id="order-delete-btn"></button></div>';

                document.getElementById('orderItems').appendChild(div);
            }

            updateTotal();
        };

        window.editQuantity = function (element) {
            currentQuantityElement = element;
            $('#quantityInput').val(element.innerText);
            $('#quantityModal').modal('show');
        };

        window.appendNumber = function (num, inputId) {
            var currentInput = $('#' + inputId).val();
            if ((inputId === 'cardNumber' || inputId === 'debitCardNumber') && currentInput.replace(/\s/g, '').length >= 16) return;
            if ((inputId === 'expiryDate' || inputId === 'debitExpiryDate') && currentInput.length >= 5) return;
            if ((inputId === 'debitCvv' || inputId === 'debitCvv') && currentInput.length >= 3) return;
            if (inputId === 'cvv' && currentInput.length >= 3) return;
            $('#' + inputId).val(currentInput + num);
            formatInput(inputId); 
        };

        window.clearInput = function (inputId) {
            $('#' + inputId).val('');
        };

        window.setQuantity = function () {
            var newQuantity = parseInt($('#quantityInput').val());
            if (!isNaN(newQuantity) && newQuantity > 0) {
                currentQuantityElement.innerText = newQuantity;
                $('#quantityModal').modal('hide');
                updateTotal();
            } else {
                Swal.fire({
                    title: 'Invalid Quantity',
                    text: 'Please enter a valid quantity. It should be a positive number.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        };

        window.updateTotal = function () {
            var discount = parseFloat(document.getElementById('discount').value);
            var total = 0;
            var orderItems = document.querySelectorAll('.order-item');

            orderItems.forEach(function (item) {
                var quantity = parseInt(item.querySelector('.quantity').innerText);
                var price = parseFloat(item.getAttribute('data-product-price'));
                total += quantity * price;
            });

            var discountAmount = (discount / 100) * total;
            total -= discountAmount;
            document.getElementById('total_amount').innerText = total.toFixed(2);
        };

        window.removeItem = function (button) {
            var item = button.closest('.order-item');
            item.remove();
            updateTotal();
        };

        window.cancelOrder = function () {
            document.getElementById('orderItems').innerHTML = '';
            document.getElementById('total_amount').innerText = '0.00';
            document.getElementById('discount').value = 0;
        };

        window.showPaymentModal = function () {
            var totalAmount = parseFloat(document.getElementById('total_amount').innerText);
            $('#paymentInput').val('');
            $('#paymentMethod').val('cash');
            togglePaymentForm();
            $('#paymentModal').modal('show');
        };

        window.setActiveInput = function(inputId) {
            activeInput = inputId;
        };

        window.appendNumberToPayment = function (num) {
            appendNumber(num, activeInput);
            formatInput(activeInput); 
        };

        window.clearPaymentInput = function () {
            clearInput(activeInput);
        };

        window.togglePaymentForm = function () {
            var paymentMethod = $('#paymentMethod').val();
            $('#creditCardForm').hide();
            $('#debitCardForm').hide();
            $('#paymentInputContainer').hide(); 

            if (paymentMethod === 'credit_card') {
                $('#creditCardForm').show();
                setActiveInput('cardNumber');
            } else if (paymentMethod === 'debit_card') {
                $('#debitCardForm').show();
                setActiveInput('debitCardNumber');
            } else if (paymentMethod === 'cash') {
                $('#paymentInputContainer').show();
                setActiveInput('paymentInput');
            }
        };

        window.processPayment = function () {
            var totalAmount = parseFloat(document.getElementById('total_amount').innerText);
            var paymentMethod = $('#paymentMethod').val();

            if (paymentMethod === 'cash') {
                var paymentAmount = parseFloat($('#paymentInput').val());

                if (isNaN(paymentAmount) || paymentAmount < 0) {
                    Swal.fire({
                        title: 'Invalid Amount',
                        text: 'Please enter a valid amount. It should be a positive number.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                if (paymentAmount < totalAmount) {
                    Swal.fire({
                        title: 'Payment Error',
                        text: 'The payment amount is less than the total amount. Please enter a higher amount.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                var items = [];
                var orderItems = document.querySelectorAll('.order-item');
                orderItems.forEach(function (item) {
                    var productName = item.getAttribute('data-product-name');
                    var quantity = parseInt(item.querySelector('.quantity').innerText);
                    var price = parseFloat(item.getAttribute('data-product-price'));
                    items.push({ name: productName, quantity: quantity, price: price });
                });

                var discount = parseFloat(document.getElementById('discount').value);

                var requestData = {
                    _token: '{{ csrf_token() }}',
                    items: items,
                    discount: discount,
                    payment_amount: paymentAmount,
                    payment_method: 'cash'
                };

                $.ajax({
                    url: '{{ route('transactions.store') }}',
                    method: 'POST',
                    data: requestData,
                    success: function (response) {
                        document.getElementById('orderItems').innerHTML = '';
                        document.getElementById('total_amount').innerText = '0.00';
                        document.getElementById('discount').value = 0;

                        Swal.fire({
                            title: 'Success!',
                            text: 'Payment successful.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function (xhr, status, error) {
                        var errorMessage = 'An error occurred while processing the payment. Please try again later.';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMessage = xhr.responseJSON.error;
                        }
                        Swal.fire({
                            title: 'Payment Error',
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });

            } else if (paymentMethod === 'debit_card' || paymentMethod === 'credit_card') {
                if (!validateCardDetails()) {
                    return;
                }

                var cardNumber, expiryDate, cvv;

                if (paymentMethod === 'credit_card') {
                    cardNumber = $('#cardNumber').val().replace(/\s/g, '');
                    expiryDate = $('#expiryDate').val();
                    cvv = $('#cvv').val();
                } else if (paymentMethod === 'debit_card') {
                    cardNumber = $('#debitCardNumber').val().replace(/\s/g, '');
                    expiryDate = $('#debitExpiryDate').val();
                    cvv = $('#debitCvv').val();
                }

                var items = [];
                var orderItems = document.querySelectorAll('.order-item');
                orderItems.forEach(function (item) {
                    var productName = item.getAttribute('data-product-name');
                    var quantity = parseInt(item.querySelector('.quantity').innerText);
                    var price = parseFloat(item.getAttribute('data-product-price'));
                    items.push({ name: productName, quantity: quantity, price: price });
                });

                var discount = parseFloat(document.getElementById('discount').value);

                var requestData = {
                    _token: '{{ csrf_token() }}',
                    items: items,
                    discount: discount,
                    payment_method: paymentMethod,
                    card_number: cardNumber,
                    expiry_date: expiryDate,
                    cvv: cvv,
                    total_amount: totalAmount
                };

                $.ajax({
                    url: '{{ route('transactions.store') }}',
                    method: 'POST',
                    data: requestData,
                    success: function (response) {
                        document.getElementById('orderItems').innerHTML = '';
                        document.getElementById('total_amount').innerText = '0.00';
                        document.getElementById('discount').value = 0;

                        Swal.fire({
                            title: 'Success!',
                            text: 'Payment successful.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function (xhr, status, error) {
                        var errorMessage = 'An error occurred while processing the payment. Please try again later.';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMessage = xhr.responseJSON.error;
                        }
                        Swal.fire({
                            title: 'Payment Error',
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        };

        function validateCardDetails() {
            if (!validateCardNumber() || !validateExpiryDate() || !validateCVV()) {
                return false;
            }
            return true;
        }

        function validateCardNumber() {
            var paymentMethod = $('#paymentMethod').val();
            var cardNumber;

            if (paymentMethod === 'credit_card') {
                cardNumber = $('#cardNumber').val().replace(/\s/g, '');
            } else if (paymentMethod === 'debit_card') {
                cardNumber = $('#debitCardNumber').val().replace(/\s/g, '');
            }

            if (!/^\d{16}$/.test(cardNumber)) {
                Swal.fire({
                    title: paymentMethod === 'credit_card' ? 'Invalid Card Number' : 'Invalid Debit Card Number',
                    text: paymentMethod === 'credit_card' ? 'Please enter a valid 16-digit card number.' : 'Please enter a valid 16-digit debit card number.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return false;
            }

            return true;
        }

        function validateExpiryDate() {
            var expiryDate = $('#expiryDate').val();

            if ($('#paymentMethod').val() === 'debit_card') {
                expiryDate = $('#debitExpiryDate').val();
            }

            if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(expiryDate)) {
                Swal.fire({
                    title: 'Invalid Expiry Date',
                    text: 'Please enter a valid expiry date in MM/YY format.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return false;
            }

            var today = new Date();
            var currentYear = today.getFullYear() % 100;
            var currentMonth = today.getMonth() + 1;

            var parts = expiryDate.split('/');
            var inputMonth = parseInt(parts[0], 10);
            var inputYear = parseInt(parts[1], 10);

            if (inputYear < currentYear || (inputYear === currentYear && inputMonth < currentMonth)) {
                Swal.fire({
                    title: 'Invalid Expiry Date',
                    text: 'Expiry date cannot be in the past.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return false;
            }

            return true;
        }

        function validateCVV() {
            var cvv = $('#cvv').val();

            if ($('#paymentMethod').val() === 'debit_card') {
                cvv = $('#debitCvv').val();
            }

            if (!/^\d{3}$/.test(cvv)) {
                Swal.fire({
                    title: 'Invalid CVV',
                    text: 'Please enter a valid 3-digit CVV.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return false;
            }
            return true;
        }

        function formatCardNumber(cardNumberFieldId) {
            var cardNumberField = $('#' + cardNumberFieldId);
            var cardNumber = cardNumberField.val().replace(/\s/g, '');
            var formattedCardNumber = '';

            for (var i = 0; i < cardNumber.length; i++) {
                if (i > 0 && i % 4 === 0) {
                    formattedCardNumber += ' ';
                }
                formattedCardNumber += cardNumber[i];
            }

            cardNumberField.val(formattedCardNumber.trim());
        }

        function formatExpiryDate(expiryDateFieldId) {
            var expiryDateField = $('#' + expiryDateFieldId);
            var expiryDate = expiryDateField.val();

            if (expiryDate.length === 2 && expiryDate.indexOf('/') === -1) {
                expiryDate = expiryDate.substring(0, 2) + '/' + expiryDate.substring(2);
            }

            expiryDateField.val(expiryDate);
        }

        function formatInput(inputId) {
            if (inputId === 'cardNumber' || inputId === 'debitCardNumber') {
                formatCardNumber(inputId);
            } else if (inputId === 'expiryDate' || inputId === 'debitExpiryDate') {
                formatExpiryDate(inputId);
            }
        }

        $(document).ready(function () {
            $('#cardNumber, #debitCardNumber').on('input', function () {
                var fieldId = $(this).attr('id');
                formatCardNumber(fieldId);
            });

            $('#expiryDate, #debitExpiryDate').on('input', function () {
                var fieldId = $(this).attr('id');
                formatExpiryDate(fieldId);
            });
        });
    });
</script>
@endsection
