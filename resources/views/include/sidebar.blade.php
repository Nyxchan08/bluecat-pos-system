<div id="sidebar-container">
    <ul id="sidebar">
        @if(auth()->user()->isAdmin())
        <li><a href="/dashboard"><img src="{{ asset('img/dashboard.png') }}" alt="dashboard">Dashboard</a></li>
        <li><a href="/user/list"><img src="{{ asset('img/users.png') }}" alt="users">Users</a></li>
        <li><a href="/store/list"><img src="{{ asset('img/store.png') }}" alt="store">Store</a></li>
        <li><a href="/supplier/list"><img src="{{ asset('img/supplier.png') }}" alt="suppliers">Suppliers</a></li>
        <li><a href="/category/list"><img src="{{ asset('img/category.png') }}" alt="category">Category</a></li>
        <li><a href="/product/list"><img src="{{ asset('img/product.png') }}" alt="product">Product</a></li>
        <li><a href="/transactions/list"><img src="{{ asset('img/transactions.png') }}" alt="transactions">Transactions</a></li>
        <li><a href="#" data-bs-toggle="modal" data-bs-target="#composeEmailModal"><img src="{{ asset('img/email.png')}}" alt="email">Compose Email</a></li>
        @endif

        @if(auth()->user()->isUser())
        <li><a href="/store/list"><img src="{{ asset('img/store.png') }}" alt="store">Store</a></li>
        <li><a href="/transactions/list"><img src="{{ asset('img/transactions.png') }}" alt="transactions">Transactions</a></li>
        @endif

        <li><a href="#" data-bs-toggle="modal" data-bs-target="#logoutModal"><img src="{{ asset('img/logout.png')}}" alt="log out"> Logout</a></li>
    </ul>
</div>


<div class="modal fade" id="composeEmailModal" tabindex="-1" aria-labelledby="composeEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="composeEmailModalLabel">Compose Email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="composeEmailForm">
                    <div class="mb-3">
                        <label for="receiverEmail" class="form-label">Receiver Email</label>
                        <input type="email" class="form-control" id="receiverEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="emailSubject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="emailSubject" required>
                    </div>
                    <div class="mb-3">
                        <label for="emailMessage" class="form-label">Message</label>
                        <textarea class="form-control" id="emailMessage" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Logout Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to logout?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancel</button>
                <a href="/process/logout" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
<script type="text/javascript">
    (function() {
        emailjs.init('MuhjCapNGGATGj3GF');
    })();

    document.getElementById('composeEmailForm').addEventListener('submit', function(event) {
        event.preventDefault();

        var receiverEmail = document.getElementById('receiverEmail').value;
        var emailSubject = document.getElementById('emailSubject').value;
        var emailMessage = document.getElementById('emailMessage').value;

        var templateParams = {
            receiver_email: receiverEmail,
            email_subject: emailSubject,
            message: emailMessage
        };

        emailjs.send('service_ljnncce', 'template_f4lh6p9', templateParams)
            .then(function(response) {
                console.log('SUCCESS!', response.status, response.text);
                Swal.fire({
                    title: 'Email Sent!',
                    text: 'Your email was sent successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                        
                    }
                });
            }, function(error) {
                console.log('FAILED...', error);
                Swal.fire({
                    title: 'Email Failed',
                    text: 'There was an error sending your email. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
    });
</script>
