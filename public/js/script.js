document.getElementById('sidebar-toggle').addEventListener('click', function () {
    document.getElementById('sidebar-container').classList.toggle('active');
    document.getElementById('main-content').classList.toggle('active');
});






$.ajax({
    url: '/search', // Assuming this is the URL to your search endpoint
    type: 'GET',
    data: { query: 'search_query_here' }, // Replace 'search_query_here' with the actual search query
    success: function(response) {
        // Handle the response data
        displaySearchResults(response);
    },
    error: function(xhr, status, error) {
        // Handle errors
        console.error(error);
    }
});

function displaySearchResults(data) {
    // Display users
    var usersHtml = '';
    data.users.forEach(function(user) {
        usersHtml += '<div>' + user.first_name + ' ' + user.last_name + '</div>';
        // Add more user details as needed
    });
    $('#users-container').html(usersHtml);

    // Repeat the above process for other entities (transactions, products, categories, suppliers)
}
