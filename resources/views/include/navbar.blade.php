<div id="navbar" class="navbar navbar-expand-lg navbar-light bg-light">
    <a href="/dashboard">
        <img src="https://s3.amazonaws.com/access-resources/evantaconnect/production/sponsor_logos/20763.png?6352" alt="Logo" class="d-inline-block align-text-top img-fluid" style="max-height: 31px;">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar-drawer" aria-controls="sidebar-drawer">
        <span class="navbar-toggler-icon"></span>
    </button>
    <form class="d-flex collapse navbar-collapse" role="search" id="navsearch" >
        <input class="form-control me-2" type="search" placeholder="Search your meow meow..." aria-label="Search" name="searchTerm" value="{{ $searchTerm ?? '' }}">
        <button class="btn btn-outline-success" type="submit" style="height: 33px">Search</button>
    </form>
</div>

<div id="sidebar-drawer" class="offcanvas offcanvas-end">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Menu</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul id="sidebar" class="list-group">
            <li class="list-group-item"><a href="/dashboard">Dashboard</a></li>
            <li class="list-group-item"><a href="/user/list">Users</a></li>
            <li class="list-group-item"><a href="/store/list">Store</a></li>
            <li class="list-group-item"><a href="/supplier/list">Suppliers</a></li>
            <li class="list-group-item"><a href="/category/list">Category</a></li>
            <li class="list-group-item"><a href="/product/list">Product</a></li>
            <li class="list-group-item"><a href="/transactions/list">Transactions</a></li>
        </ul>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
