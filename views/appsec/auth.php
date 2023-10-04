<h1>Authentication</h1>
<hr/>

<table class="table table-hover">
    <thead>
        <th>Username</th>
        <th>Email</th>
        <th>Date Creation</th>
        <th>Options</th>
    </thead>
    <tbody>
        <tr id="no-contents-yet">
            <td colspan="4" align="center">
                No users yet.
            </td>
        </tr>
    </tbody>
</table>

<button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#add-user-modal">
    Add User
</button>

<div class="modal fade" id="add-user-modal" tabindex="-1" role="dialog" aria-labelledby="add-user-modalLabel" aria-hidden="true">
    <div class="modal-dialog shadow" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-user-modalLabel">Add User</h5>
                <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Username"></input>
                <p class="text-danger d-none" id="username-error"></p>

                <label for="username" class="form-label mt-2">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email"></input>
                <p class="text-danger d-none" id="email-error"></p>

                <label for="password" class="form-label mt-2">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password"></input>
                <p class="text-danger d-none" id="password-error"></p>

                <label for="confirm-password" class="form-label mt-2">Confirm Password</label>
                <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="Confirm Password"></input>
                <p class="text-danger d-none" id="confirm-password-error"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="mb-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Cancel
                </button>

                <button type="button" class="btn btn-primary" id="add-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="mb-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Add
                </button>
            </div>
        </div>
    </div>
</div>

<script src="scripts/vendors/jquery.min.js"></script>
<script src="scripts/appsec/auth.js"></script>