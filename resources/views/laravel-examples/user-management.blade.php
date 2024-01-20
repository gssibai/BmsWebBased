@extends('layouts.user_type.auth')

@section('content')

<div>
   

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <form id="deleteForm" action="{{ route('delete.all.selected') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <!-- Hidden input to store selected user IDs -->
                                <input type="hidden" name="selectedUsers" id="selectedUsers">
                            </form>
                            <div class="align-items-center d-flex usersHeader">
                            <h5 class="mb-0 me-3">All Users</h5>
                            <div class="input-group">
                                <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                                <input type="text" id="searchInput" class="form-control" placeholder="Type here...">
                            </div>
                            <button onclick="clearInputs()" id="clearButton" class="btn btn-secondary m-0 ms-1">Clear</button>
                        </div>
                    </div>
                        
                        <div class="d-flex flex-grow-0 align-items-center">
                           
                                <select class="select me-2" style="    border-radius: 10px;
                                text-align: center;
                                text-transform: uppercase;" name="sortOption" id="sortOptions" onchange="sortUsers()">
                                    <option value="id">ID</option>
                                    <option value="name">Name</option>
                                    <option value="email">Email</option>
                                </select>
                            
                           
                           
                                <a onclick="updateSelectedUsersData()" class="btn btn-primary me-2 mb-0 p-3">Update Users Data</a>

                            <a onclick="deleteSelectedUsers()" class="btn bg-gradient-primary me-2 mb-0 p-3">
                                <i class="cursor-pointer fas fa-trash"></i> &nbsp;Drop selected users
                            </a>
                        <a href="/add-user" class="btn bg-gradient-primary btn-sm mb-0 p-3" type="button">+&nbsp; New User</a>
                        <form class="m-2" action="{{ route('delete.all.except.loggedin') }}" method="POST">
                            @csrf
                            @method('DELETE')
                    
                        <button type="submit" href="/add-user" class="btn bg-gradient-primary mb-0 p-3" type="button"> <i class="cursor-pointer fas fa-trash"></i> &nbsp;Drop users</button>  
                    </form>     
                    </div>
                    </div>
                    
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        SELECT
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Enable Search
                                    </th>
                               
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        ID
                                    </th>
                                    {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Photo
                                    </th> --}}
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Name
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Email
                                    </th>
                                    
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Creation Date
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="userTableBody">
                                @foreach($users as $user)
                            
                                <tr>
                                    <td class="ps-4">
                                        <input type="checkbox" value="{{ $user->id }}" class="text-xs font-weight-bold mb-0"/>
                                    </td>
                                    <td class="ps-4">
                                        <input type="radio" value="{{ $user->id }}" class="text-xs font-weight-bold mb-0"/>
                                    </td>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">
                                         
                                            {{ $user->id }}
                                       </p>
                                    </td>
                                    {{-- <td>
                                        <div>
                                            <img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3">
                                        </div>
                                    </td> --}}
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $user->name }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $user->email }}</p>
                                    </td>
                                    
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $user->created_at }}</span>
                                    </td>
                                    <td class="text-center">
                                        {{-- <a href="#" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit user">
                                            <i class="fas fa-user-edit text-secondary"></i>
                                        </a> --}}
                                        <span>
                                        <form action="{{ route('delete.user', ['id' => $user->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                    
                                            <button type="submit" class="btn btn-link">
                                                <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                            </button>
                                        </form>
                                    </span>
                                    </td>
                                </tr>
                                @endforeach
                                
                            </div>
                          
                        </div>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 <script>
    function deleteSelectedUsers() {
  var selectedUsers = [];
  var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');

  checkboxes.forEach(function(checkbox) {
      selectedUsers.push(checkbox.value);
  });

  if (selectedUsers.length > 0) {
      // Set the selected user IDs in the hidden input field
      document.getElementById('selectedUsers').value = selectedUsers.join(',');
      // Submit the form
      document.getElementById('deleteForm').submit();
  } else {
      alert('Please select at least one user to delete.');
  }
}
let currentSortOption = 'id'; // Default sorting option
    let ascending = true; // Default sorting order

    function sortUsers() {
        const selectedOption = document.getElementById('sortOptions').value;

        if (selectedOption === currentSortOption) {
            ascending = !ascending; // Toggle sorting order if the same option is selected again
        } else {
            ascending = true; // Reset to default ascending order if a new option is selected
        }

        currentSortOption = selectedOption;

        const usersTableBody = document.querySelector('#userTableBody');
        const rows = Array.from(usersTableBody.getElementsByTagName('tr'));

        rows.sort(function(a, b) {
            const valueA = a.querySelector(`td:nth-child(${getIndexOfSortOption(currentSortOption)})`).textContent.trim();
            const valueB = b.querySelector(`td:nth-child(${getIndexOfSortOption(currentSortOption)})`).textContent.trim();

            if (currentSortOption === 'id') {
                return ascending ? parseInt(valueA) - parseInt(valueB) : parseInt(valueB) - parseInt(valueA);
            } else {
                return ascending ? valueA.localeCompare(valueB) : valueB.localeCompare(valueA);
            }
        });

        rows.forEach(function(row) {
            usersTableBody.appendChild(row); // Re-add rows without removing them
        });
    }

    function getIndexOfSortOption(option) {
        switch (option) {
            case 'id':
                return 3; // Assuming ID is in the second column (adjust if different)
            case 'name':
                return 4; // Assuming Name is in the third column (adjust if different)
            case 'email':
                return 5; // Assuming Email is in the fourth column (adjust if different)
            default:
                return 2; // Default to ID column
        }
    }
    document.getElementById('searchInput').addEventListener('keyup', function(event) {
    if (event.key === 'Enter') {
        performSearch();
    }
});


function performSearch() {
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const selectedRadio = document.querySelector('input[type="radio"]:checked');

    if (selectedRadio) {
        const userId = selectedRadio.value;
        const row = document.querySelector(`#userTableBody tr input[type="radio"][value="${userId}"]`).closest('tr');
        const rowData = row.querySelectorAll('td:nth-child(n+4)');

        let rowContainsSearch = false;

        rowData.forEach(function(column) {
            const columnData = column.textContent.toLowerCase();
            if (columnData.includes(searchInput)) {
                rowContainsSearch = true;
            }
        });

        if (rowContainsSearch) {
            row.style.display = ''; // Show the row if a match is found in user data
        } else {
            row.style.display = 'none'; // Hide the row if no match is found
        }
    } else {
        alert('Please check a radio button to perform the search.');
    }
}


function clearInputs() {
    document.getElementById('searchInput').value = ''; // Clear the search input
    const selectedRadios = document.querySelectorAll('input[type="radio"]:checked');
    const selectChecks = document.querySelectorAll('input[type="checkbox"]:checked');
    selectedRadios.forEach(radio => {
        radio.checked = false; // Uncheck all selected radio buttons
    });
    selectChecks.forEach(checkbox => {
        checkbox.checked = false;
    });
}
function updateSelectedUsersData() {
        var selectedUsers = [];
        var radioButtons = document.querySelectorAll('input[type="radio"]:checked');

        radioButtons.forEach(function(radio) {
            selectedUsers.push(radio.value);
        });

        if (selectedUsers.length > 0) {
            // Redirect to update page with selected user IDs
            window.location.href = "/update-users?userIds=" + selectedUsers.join(',');
        } else {
            alert('Please select at least one user to update.');
        }
    }
 </script>

@endsection